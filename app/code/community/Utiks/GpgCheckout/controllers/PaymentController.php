<?php

/**
 * Gpg Checkout Payment controller
 *
 * * PHP version 5.5
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
 */

/**
 * Class Utiks_GpgCheckout_PaymentController
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
 */
class Utiks_GpgCheckout_PaymentController extends Mage_Core_Controller_Front_Action
{

    //GPG Checkout transactions status   

    const TRANSACTION_FAILED = '05';
    const TRANSACTION_CANCELLED = '06';
    const TRANSACTION_REFUND = '07';
    const TRANSACTION_SUCCEEDED = '00';
    const TRANSACTION_CHARGEBACK = '08';
    const FRAUD_DETECTION = '02';

    protected $_helper;
    protected $_logs;


    /**
     * Constructor
     */
    public function _construct()
    {
        $this->_helper = Mage::helper('utiks_gpgcheckout');
        $this->_logs   = $this->_helper->getStoreConfigByName('logs');
    }

    /**
     * Render redirect page 
     * 
     * @return template
     */
    public function redirectAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template', 'gpgcheckout', array('template' => 'gpgcheckout/redirect.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }


    /**
     * Response triggered when GPGCheckout sends back a response after processing the customer's payment
     * 
     * @throws Exception
     */
    public function responseAction()
    {
        $order = null;
        
        if ($this->getRequest()->isPost()) {
            try{
                $gpgCheckoutResponse = $this->getRequest()->getParams();
                $gpgCheckoutTransactionId = key($gpgCheckoutResponse);
                $gpgCheckoutResponse = array_shift(array_values($gpgCheckoutResponse));
                $transactionStatus = $gpgCheckoutResponse['TransStatus'];
                $orderId = $gpgCheckoutResponse['PAYID'];
                $paymentType = $this->getHelper()->getPaymentType($gpgCheckoutResponse['PayementType']);
                $authorizationCode = $gpgCheckoutResponse['AuthorisationCode'];
                $signature = $gpgCheckoutResponse['Signature'];
                $totalAmount = $gpgCheckoutResponse['TotalAmount'];
                $numSite = $this->getHelper()->getStoreConfigByName('num_site');
                $password = $this->getHelper()->getStoreConfigByName('gpg_password');
                $device = $gpgCheckoutResponse['Currency'];
                $signatureCheck = sha1($numSite . $password . $orderId . $totalAmount . $device);

                $order = Mage::getModel('sales/order');
                $order->load($orderId);
                $payment = $order->getPayment();
                // in case fraud detection cancel order and redirect to failure page   
                if ($signature != $signatureCheck) {
                    $paymentAdditionalData = array(
                        'gpg_transaction' => $gpgCheckoutTransactionId,
                        'transactionStatus' => self::FRAUD_DETECTION,
                        'paymentType' => $paymentType,
                        'authorizationCode' => $authorizationCode
                    );
                    $order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'GPG Checkout fraud detection ')->save();
                    $payment->setAdditionalData(serialize($paymentAdditionalData));
                    $payment->save();
                    $message = 'GPG Checkout fraud detection, transaction id n° '.$gpgCheckoutTransactionId;
                    $this->setLogMessage($message, $order);
                    Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array('_secure' => true));
                }
                $paymentAdditionalData = array(
                    'gpg_transaction' => $gpgCheckoutTransactionId,
                    'transactionStatus' => $transactionStatus,
                    'paymentType' => $paymentType,
                    'authorizationCode' => $authorizationCode
                );
                $paymentAdditionalData = serialize($paymentAdditionalData);
                if ($transactionStatus == self::TRANSACTION_SUCCEEDED) {
                    // Payment was successful,update the order state            
                    $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'GPG Checkout has authorized the payment.');
                    $order->sendNewOrderEmail();
                    $order->setEmailSent(true);
                    $message = 'GPG Checkout has authorized the payment, transaction id n° '.$gpgCheckoutTransactionId;
                    $this->setLogMessage($message, $order);

                } elseif ($transactionStatus == self::TRANSACTION_FAILED || transactionStatus == self::TRANSACTION_CANCELLED) {
                    //you can change failed status with your custom status
                    $order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'GPG Checkout payment failed or cancelled.');
                    $message = 'GPG Checkout payment failed or cancelled, transaction id n° '.$gpgCheckoutTransactionId;
                    $this->setLogMessage($message, $order);
                }
                $order->save();
                //update order payment information
                $payment->setAdditionalData($paymentAdditionalData);
                $payment->save();
                Mage::getSingleton('checkout/session')->unsQuoteId();
            } catch (Exception $e) {
                $message = 'an error has occurred with order'.$order->getIncrementId().'__More details! '.$e->getMessage();
                Mage::log($message, null, 'GPGCheckoutException.log', true);
            }

            
        }
    }

     /**
     * Get module helper
     * 
     * @return mixed
     */
    public function getHelper()
    {
        return $this->_helper;
    }

    /**
     * Get gpgcheckout payment log
     * 
     * @param string $message
     * 
     * @param object $order
     */
    public function setLogMessage($message,$order)
    {
        if ($this->_logs == 1) {
            $orderIncrementId = $order->getIncrementId();
            $datetime = Zend_Date::now();
            $logText = sprintf("%s payment log informations for order n° %s : %s", $datetime, $orderIncrementId, $message);
            Mage::log($logText, null, 'GPGCheckout.log', true);
        }        
    }
}