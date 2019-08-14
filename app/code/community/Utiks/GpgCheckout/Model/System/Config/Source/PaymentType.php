<?php
/**
 * Class Utiks_GpgCheckout_Model_System_Config_Source_PaymentType
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 */
class Utiks_GpgCheckout_Model_System_Config_Source_PaymentType
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('utiks_gpgcheckout')->__('Direct Payment')),
            array('value' => 2, 'label' => Mage::helper('utiks_gpgcheckout')->__('Recurring Payment')),
            array('value' => 3, 'label' => Mage::helper('utiks_gpgcheckout')->__('Deferred Payment')),
            array('value' => 4, 'label' => Mage::helper('utiks_gpgcheckout')->__('Pre-Authorization Payment')),
            array('value' => 5, 'label' => Mage::helper('utiks_gpgcheckout')->__('Pre-Authorization Confirmation Payment')),
            array('value' => 6, 'label' => Mage::helper('utiks_gpgcheckout')->__('Annual Subscription Payment')),
        );
    }
}