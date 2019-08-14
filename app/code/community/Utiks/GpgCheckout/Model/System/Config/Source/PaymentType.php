<?php

/**
 * Gpg Checkout Payment types source model
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
 * Class Utiks_GpgCheckout_Model_System_Config_Source_PaymentType
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
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
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Paiement direct')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Paiement récurent')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('Paiement différer')),
            array('value' => 4, 'label' => Mage::helper('adminhtml')->__('Paiement Pré-autorisation')),
            array('value' => 5, 'label' => Mage::helper('adminhtml')->__('Paiement Pré-autorisation Confirmation')),
            array('value' => 6, 'label' => Mage::helper('adminhtml')->__('Paiement Abonnement annuel')),
        );
    }
}