<?php

/**
 * Gpg Checkout Payment method Info block
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
 * Class Utiks_GpgCheckout_Block_Info_GpgCheckout
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
 */
class Utiks_GpgCheckout_Block_Info_GpgCheckout extends Mage_Payment_Block_Info
{
    
    protected $_helper;

    /**
     * Constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('gpgcheckout/info/gpg-checkout.phtml');
        $this->_helper = Mage::helper('utiks_gpgcheckout');
    }

    /**
     * Return information to be showed in order admin page
     * 
     * @return array|Varien_Object
     */
    protected function renderAdditionalPaymentData()
    {

        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }
        $info = $this->getInfo();
        $data = unserialize($info->getData('additional_data'));
        if ($data['transactionStatus'] == '00') {
            $data['transactionStatus'] = array('value' => $data['transactionStatus'], 'state' => true);
        } elseif ($data['transactionStatus'] == '05' || $data['transactionStatus'] == '06' || $data['transactionStatus'] == '02') {
            $data['transactionStatus'] = array('value' => $data['transactionStatus'], 'state' => false); 
        }
        $paymentHelper = Mage::helper('payment');
        $transport = array(
            $paymentHelper->__('Transaction number') => $data['gpg_transaction'],
            $paymentHelper->__('Transaction Status') => $data['transactionStatus'],
            $paymentHelper->__('Payment Type') => $data['paymentType'],
            $paymentHelper->__('Authorization code') => $data['authorizationCode'],
        );
        
        return $transport;
    }
}

