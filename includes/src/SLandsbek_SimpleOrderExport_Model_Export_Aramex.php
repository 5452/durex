<?php
/**
 * NOTICE OF LICENSE
 *
 * The MIT License
 *
 * Copyright (c) 2009 S. Landsbek (slandsbek@gmail.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    SLandsbek_SimpleOrderExport
 * @copyright  Copyright (c) 2009 S. Landsbek (slandsbek@gmail.com)
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

/**
 * Exports orders to csv file. If an order contains multiple ordered items, each item gets
 * added on a separate row.
 */
class SLandsbek_SimpleOrderExport_Model_Export_Aramex extends SLandsbek_SimpleOrderExport_Model_Export_Abstract
{
    const ENCLOSURE = '"';
    const DELIMITER = ',';

    /**
     * Concrete implementation of abstract method to export given orders to csv file in var/export.
     *
     * @param $orders List of orders of type Mage_Sales_Model_Order or order ids to export.
     * @return String The name of the written csv file in var/export
     */
    public function exportOrders($orders) 
    {
    	
    	$parser = new Varien_Convert_Parser_Xml_Excel();
    	$io     = new Varien_Io_File();
    	
    	$path = Mage::getBaseDir('export').'/';
        $file = 'order_export_'.date("Ymd_His").'.xls';
    	
    	$io->setAllowCreateFolders(true);
    	$io->open(array('path' => $path));
    	$io->streamOpen($file, 'w+');
    	$io->streamLock(true);
    	$io->streamWrite($parser->getHeaderXml("Aramex"));
    	$io->streamWrite($parser->getRowXml($this->getHeadRowValues()));
    	foreach ($orders as $order) {
    		$order = Mage::getModel('sales/order')->load($order);
    		$common = $this->getCommonOrderValues($order);
    		$io->streamWrite($parser->getRowXml($common));
    	}
    	
    	$io->streamWrite($parser->getFooterXml());
    	$io->streamUnlock();
    	$io->streamClose();

        return $file;
    }

    /**
	 * Writes the head row with the column names in the csv file.
	 * 
	 * @param $fp The file handle of the csv file
	 */
    protected function writeHeadRow($fp) 
    {
        fputcsv($fp, $this->getHeadRowValues(), self::DELIMITER, self::ENCLOSURE);
    }

    /**
	 * Writes the row(s) for the given order in the csv file.
	 * A row is added to the csv file for each ordered item. 
	 * 
	 * @param Mage_Sales_Model_Order $order The order to write csv of
	 * @param $fp The file handle of the csv file
	 */
    protected function writeOrder($order, $fp) 
    {
        $common = $this->getCommonOrderValues($order);
        fputcsv($fp, $common, self::DELIMITER, self::ENCLOSURE);
    }
    
    protected function totalWeight($order)
    {
    	$orderItems = $order->getItemsCollection();
    	$weight = 0;
    	foreach ($orderItems as $item)
    	{
    		$weight += $item->getWeight()*(int)$item->getQtyOrdered();
    	}
    	return $weight;
    }

    /**
	 * Returns the head column names.
	 * 
	 * @return Array The array containing all column names
	 */
    protected function getHeadRowValues() 
    {
        return array(
            'Shipper reference number',
        	'Cnee CTC',
        		'CNEE ADDRESS',
        		'CNEE TEL',
        		'DEST CITY',
        		'Zip Code',
        		'COUNTRY',
        		'PCS',
        		'Weight',
        		'DESCRIPTION',
        		'Customs Value',
        		'Currency',
        		'Shipper Email'
    	);
    }

    /**
	 * Returns the values which are identical for each row of the given order. These are
	 * all the values which are not item specific: order data, shipping address, billing
	 * address and order totals.
	 * 
	 * @param Mage_Sales_Model_Order $order The order to get values from
	 * @return Array The array containing the non item specific values
	 */
    protected function getCommonOrderValues($order) 
    {
        $shippingAddress = !$order->getIsVirtual() ? $order->getShippingAddress() : null;
        $billingAddress = $order->getBillingAddress();
        
        return array(
            $order->getRealOrderId(),        	
            $shippingAddress ? $shippingAddress->getName() : '',
            $shippingAddress ? $shippingAddress->getData("street") : '',
        		$shippingAddress ? (String)$shippingAddress->getData("telephone") : '',
        		$shippingAddress ? $shippingAddress->getData("city") : '',
        		$shippingAddress ? $shippingAddress->getData("postcode") : '',
        		$shippingAddress ? $shippingAddress->getCountry() : '',
        		$this->getTotalQtyItemsOrdered($order),
        		$this->totalWeight($order),
        		"toys",
        		$order->getData('subtotal'),
        		"GBP",
        		$order->getCustomerEmail(),
        );
    }

    /**
	 * Returns the item specific values.
	 * 
	 * @param Mage_Sales_Model_Order_Item $item The item to get values from
	 * @param Mage_Sales_Model_Order $order The order the item belongs to
	 * @return Array The array containing the item specific values
	 */

}
?>