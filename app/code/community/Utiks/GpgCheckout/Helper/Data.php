<?php
/**
 * Class Utiks_GpgCheckout_Helper_Data
 *
 * @category  Utiks
 * @package   Utiks_GpgCheckout
 * @copyright 2015-2016 Copyright (c) utiks (http://www.utiks.com)
 */
class Utiks_GpgCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get order payment type
     * 
     * @param string $type
     * 
     * @return null|string
     */
    public function getPaymentType($type)
    {
        $paymentType = null;
        switch ($type) {
            case "1":
                $paymentType = Mage::helper('utiks_gpgcheckout')->__('Direct Payment');
                break;
            case "2":
                $paymentType = Mage::helper('utiks_gpgcheckout')->__('Recurring Payment');
                break;
            case "3":
                $paymentType = Mage::helper('utiks_gpgcheckout')->__('Deferred Payment');
                break;
            case "4":
                $paymentType = Mage::helper('utiks_gpgcheckout')->__('Pre-Authorization Payment');
                break;
            case "5":
                $paymentType = Mage::helper('utiks_gpgcheckout')->__('Pre-Authorization Confirmation Payment');
                break;
            case "6":
                $paymentType = Mage::helper('utiks_gpgcheckout')->__('Annual Subscription Payment');
                break;
        }

        return $paymentType;
    }


    /**
     * Return logo image
     * 
     * @return string
     */
    public function getGpgCheckoutLogo()
    {
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/gpgcheckout/gpgcheckout.png';
        return $url;
    }

    /**
     * Return payment image state
     * 
     * @return string $url
     */
    public function getGpgState()
    {
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'gpgcheckout/';
        return $url;
    }

    /**
     * Return payment image state
     *
     * @return string $url
     */
    public function getGpgSubmitUrl()
    {
        $mode = $this->getStoreConfigByName('mode');
        if ($mode == 'production') {
            $submitUrl = $this->getStoreConfigByName('submit_url_production');
        } else {
            $submitUrl = $this->getStoreConfigByName('submit_url_test');
        }
        return $submitUrl;
    }

    /**
     * @param string $string
     * 
     * @return mixed
     */
    public function getStoreConfigByName($string = '')
    {
        $configValue = Mage::getStoreConfig('payment/gpgcheckout');
        if (isset($configValue[$string])){
            return $configValue[$string];
        } else {
            return null;
        }
    }

    /**
     * Get current Order Id
     * 
     * @return mixed
     */
    public function getOrderId()
    {
        return Mage::getSingleton('checkout/session')->getLastOrderId();
    }

    /**
     * Get Order Data
     * 
     * @param $orderId
     * @return array|null
     */
    public function getOrderData($orderId)
    {
        $data = null;
        $order = Mage::getModel('sales/order');
        $order->load($orderId);
        if ($order) {
            $data = array(
                'orderAmount' => $order->getGrandTotal(),
                'OrderDevice' => $order->getOrderCurrencyCode(),
                'OrderItems'  => $this->getOrderItemsNames($order)
            );
        }

        return $data;
    }

    /**
     * Get all order items names
     * 
     * @param $order
     * @return string
     */
    public function getOrderItemsNames($order)
    {
        $orderItems = array();
        foreach ($order->getAllVisibleItems() as $item) {
            $orderItems[] = round($item->getQtyOrdered()) . '*' . $item->getName();
        }

        return implode(',', $orderItems);
    }

    /**
     * Get customer information
     * 
     * @param string $orderId
     * 
     * @return array
     */
    public function getOrderCustomerData($orderId)
    {
        $order = Mage::getModel('sales/order');
        $order->load($orderId);
        $customer_id          = $order->getCustomerId();
        $customerData         = Mage::getModel('customer/customer')->load($customer_id)->getData();
        $customerShippingData = $order->getShippingAddress()->getData();
        return array_merge($customerData, $customerShippingData);
    }
}