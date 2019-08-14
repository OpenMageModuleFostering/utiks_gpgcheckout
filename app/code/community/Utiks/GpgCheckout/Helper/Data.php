<?php

/**
 * Gpg Checkout Payment helper
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
 * Class Utiks_GpgCheckout_Helper_Data
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
 */
class Utiks_GpgCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{


    //GPG Payment Types
    
    const DIRECT_PAYMENT = 'Paiement Direct';
    const RECURRENT_PAYMENT = 'Paiement récurent ';
    const DEFERRED_PAYMENT = 'Paiement différer';
    const PRE_AUTHORIZATION_PAYMENT = 'Paiement Pré-autorisation';
    const PRE_AUTHORIZATION_CONFIRMATION_PAYMENT = 'Paiement Pré-autorisation Confirmation';
    const SUBSCRIPTION_PAYMENT = 'Paiement Abonnement';

    /**
     * Get order payment type
     * 
     * @param string $type
     * 
     * @return null|string
     */
    public function getPaymentType($type)
    {
        $paymentType = null;
        switch ($type) {
            case "1":
                $paymentType = self::DIRECT_PAYMENT;
                break;
            case "2":
                $paymentType = self::RECURRENT_PAYMENT;
                break;
            case "3":
                $paymentType = self::DEFERRED_PAYMENT;
                break;
            case "4":
                $paymentType = self::PRE_AUTHORIZATION_PAYMENT;
                break;
            case "5":
                $paymentType = self::PRE_AUTHORIZATION_CONFIRMATION_PAYMENT;
                break;
            case "6":
                $paymentType = self::SUBSCRIPTION_PAYMENT;
                break;
        }

        return $paymentType;
    }


    /**
     * Return logo image
     * 
     * @return string
     */
    public function getGpgCheckoutLogo()
    {
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/gpgcheckout/gpgcheckout.png';
        return $url;
    }

    /**
     * Return payment image state
     * 
     * @return string $url
     */
    public function getGpgState()
    {
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'gpgcheckout/';
        return $url;
    }

    /**
     * @param string $string
     * 
     * @return mixed
     */
    public function getStoreConfigByName($string)
    {
        $configValue = Mage::getStoreConfig('payment/mycheckout');

        return $configValue['' . $string];

    }

    /**
     * Get current Order Id
     * 
     * @return mixed
     */
    public function getOrderId()
    {
        return Mage::getSingleton('checkout/session')->getLastOrderId();
    }

    /**
     * Get Order Data
     * 
     * @param $orderId
     * @return array|null
     */
    public function getOrderData($orderId)
    {
        $data = null;
        $order = Mage::getModel('sales/order');
        $order->load($orderId);
        if ($order) {
            $data = array(
                'orderAmount' => $order->getGrandTotal(),
                'OrderDevice' => $order->getOrderCurrencyCode(),
                'OrderItems' => $this->getOrderItemsNames($order)
            );
        }

        return $data;
    }

    /**
     * Get all order items names
     * 
     * @param $order
     * @return string
     */
    public function getOrderItemsNames($order)
    {
        $orderItems = array();
        foreach ($order->getAllVisibleItems() as $item) {
            $orderItems[] = round($item->getQtyOrdered()) . '*' . $item->getName();
        }

        return implode(',', $orderItems);
    }

    /**
     * Get customer information
     * 
     * @param string $orderId
     * 
     * @return array
     */
    public function getOrderCustomerData($orderId)
    {
        $order = Mage::getModel('sales/order');
        $order->load($orderId);
        $customer_id = $order->getCustomerId();
        $customerData = Mage::getModel('customer/customer')->load($customer_id)->getData();
        $customerShippingData = $order->getShippingAddress()->getData();
        return array_merge($customerData, $customerShippingData);
    }
}