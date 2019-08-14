<?php
/**
 * Class Utiks_GpgCheckout_Model_System_Config_Source_ReccuNumber
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 */
class Utiks_GpgCheckout_Model_System_Config_Source_ReccuNumber
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 2, 'label' => Mage::helper('utiks_gpgcheckout')->__('%s times', '2')),
            array('value' => 3, 'label' => Mage::helper('utiks_gpgcheckout')->__('%s times', '3')),
            array('value' => 6, 'label' => Mage::helper('utiks_gpgcheckout')->__('%s times', '6')),
        );
    }
}