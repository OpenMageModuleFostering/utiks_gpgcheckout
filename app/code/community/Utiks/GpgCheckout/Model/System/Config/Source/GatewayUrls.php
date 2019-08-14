<?php

/**
 * Gpg Checkout Payment Gateway urls source model
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
 * Class Utiks_GpgCheckout_Model_System_Config_Source_GatewayUrls
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
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
          array('value' => 'https://preprod.gpgcheckout.com/Paiement_test/Validation_paiement.php', 'label' => Mage::helper('adminhtml')->__('Mode développement/préproduction')),
          array('value' => 'https://www.gpgcheckout.com/Paiement/Validation_paiement.php', 'label' => Mage::helper('adminhtml')->__('Production site en ligne')),
        );
    }
}