<?php
/**
 * Class Utiks_GpgCheckout_Model_PaymentMethod
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
 * Class Utiks_GpgCheckout_Model_PaymentMethod
 * 
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
 */
class Utiks_GpgCheckout_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'gpgcheckout';
    protected $_formBlockType = 'utiks_gpgcheckout/form_gpgCheckout';
    protected $_infoBlockType = 'utiks_gpgcheckout/info_gpgCheckout';
    protected $_isGateway = true;
    protected $_canAuthorize = true;
    protected $_canUseCheckout = true;

    /**
     * Return redirect url
     * 
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('gpgcheckout/payment/redirect', array('_secure' => true));
    }

    /**
     * Check whether payment method can be used
     * 
     * @param null $quote
     * 
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        $helper = Mage::helper('utiks_gpgcheckout');
        $availability = $helper->getStoreConfigByName('active');
        if ($availability == 1) {
            return parent::isAvailable($quote = null);
        }
        
        return false;        
    }
}