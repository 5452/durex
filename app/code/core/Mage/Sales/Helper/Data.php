<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Sales module base helper
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Maximum available number
     */
    const MAXIMUM_AVAILABLE_NUMBER = 99999999;

    /**
     * Check quote amount
     *
     * @param Mage_Sales_Model_Quote $quote
     * @param decimal $amount
     * @return Mage_Sales_Helper_Data
     */
    public function checkQuoteAmount(Mage_Sales_Model_Quote $quote, $amount)
    {
        if (!$quote->getHasError() && ($amount>=self::MAXIMUM_AVAILABLE_NUMBER)) {
            $quote->setHasError(true);
            $quote->addMessage(
                $this->__('Items maximum quantity or price do not allow checkout.')
            );
        }
        return $this;
    }

    /**
     * Check allow to send new order confirmation email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendNewOrderConfirmationEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order::XML_PATH_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send new order email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendNewOrderEmail($store = null)
    {
        return $this->canSendNewOrderConfirmationEmail($store);
    }

    /**
     * Check allow to send order comment email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendOrderCommentEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order::XML_PATH_UPDATE_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send new shipment email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendNewShipmentEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order_Shipment::XML_PATH_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send shipment comment email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendShipmentCommentEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order_Shipment::XML_PATH_UPDATE_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send new invoice email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendNewInvoiceEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order_Invoice::XML_PATH_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send invoice comment email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendInvoiceCommentEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order_Invoice::XML_PATH_UPDATE_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send new creditmemo email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendNewCreditmemoEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order_Creditmemo::XML_PATH_EMAIL_ENABLED, $store);
    }

    /**
     * Check allow to send creditmemo comment email
     *
     * @param mixed $store
     * @return bool
     */
    public function canSendCreditmemoCommentEmail($store = null)
    {
        return Mage::getStoreConfigFlag(Mage_Sales_Model_Order_Creditmemo::XML_PATH_UPDATE_EMAIL_ENABLED, $store);
    }

    /**
     * Get old field map
     *
     * @param string $entityId
     * @return array
     */
    public function getOldFieldMap($entityId)
    {
        $node = Mage::getConfig()->getNode('global/sales/old_fields_map/' . $entityId);
        if ($node === false) {
            return array();
        }
        return (array) $node;
    }

    public function getItemName($itemId)
    {
         $quote = Mage::getModel('sales/bv');
        //$item = Mage::getModel("category/product")->load($itemId);
        return $quote;
    }

    public function getItemImgPath()
    {
        return "v1/images/OC_goods.png";
    }

    public function getItem($orderId)
    {
    	$productList = array();
    	$PM = new OrderProductMode();
    	
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
    	$select = $connection->select()
    	->from('sales_flat_order_item', array('product_id'))->where('order_id=?',$orderId);

    	$rowsArray = $connection->fetchAll($select);
    	
    	$select1 = $connection->select()
    	->from('sales_flat_quote', array('items_qty'))->where('entity_id=?',$orderId);
    	$rowsArray1 = $connection->fetchAll($select1);
    	
    	foreach($rowsArray as $p)
    	{
    		$PM = new OrderProductMode();
    		$product = Mage::getModel('catalog/product')->load($p['product_id']);
    		Mage::getModel('catalog/product')->load($p['product_id']);
    		$PM->name=(string) $product['name'];
    		
    		$PM->product_id=(string) $product['$product_id'];
    		$PM->img=(string) $product['image'];
    		$PM->sku = (string) $product['sku'];
    		$PM->Qty = (string) $rowsArray1[0]['items_qty'];
    		array_push($productList,$PM);
    	}
        return $productList;
    }

}

class OrderProductMode
{
	function __construct(){ }
	public $name,$img,$order_id,$product_id,$sku,$Qty;
	
}
