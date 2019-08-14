<?php

/**
 * Gpg Checkout ReccuNumber source model
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
 * Class Utiks_GpgCheckout_Model_System_Config_Source_ReccuNumber
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @author    Anis Hidouri <anis@utiks.com>
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.utiks.com
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
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('2 fois')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('3 fois')),
            array('value' => 6, 'label' => Mage::helper('adminhtml')->__('6 fois')),
        );
    }
}