<?php
/**
 * Class Utiks_GpgCheckout_Block_Form_GpgCheckout
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 */
class Utiks_GpgCheckout_Block_Form_GpgCheckout extends Mage_Payment_Block_Form
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('gpgcheckout/form/paymentmethod.phtml');
    }
}