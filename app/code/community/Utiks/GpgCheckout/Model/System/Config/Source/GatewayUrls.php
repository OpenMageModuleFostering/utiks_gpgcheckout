<?php
/**
 * Class Utiks_GpgCheckout_Model_System_Config_Source_GatewayUrls
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 */
class Utiks_GpgCheckout_Model_System_Config_Source_GatewayUrls
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'test',
                'label' => Mage::helper('utiks_gpgcheckout')->__('Test mode')
            ),
            array(
                'value' => 'production',
                'label' => Mage::helper('utiks_gpgcheckout')->__('Production mode')
            ),
        );
    }
}