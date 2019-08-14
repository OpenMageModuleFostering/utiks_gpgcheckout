<?php

/**
 * Gpg Checkout Payment method form block
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
 * Class Utiks_GpgCheckout_Block_Form_GpgCheckout
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
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