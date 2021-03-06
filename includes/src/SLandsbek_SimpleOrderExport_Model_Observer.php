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
 * Observer to append option to export to csv to mass action select box in the orders grid.
 */
class SLandsbek_SimpleOrderExport_Model_Observer 
{
    /**
     * Extends the mass action select box to append the option to export to csv.
     * Event: core_block_abstract_prepare_layout_before
     */
    public function addMassaction($observer) 
    {
        $block = $observer->getEvent()->getBlock();
        $user = Mage::getModel('admin/session');
        if($user->isLoggedIn()){
        	//var_dump($user->getUser()->getRole()->getData('role_name'));
        $role = $user->getUser()->getRole()->getData('role_name');
        }
        if(get_class($block) =='Mage_Adminhtml_Block_Widget_Grid_Massaction'
            && $block->getRequest()->getControllerName() == 'sales_order') 
        {
            $block->addItem('simpleorderexport', array(
                'label' => 'Export Finance Report',
                'url' => Mage::app()->getStore()->getUrl('simpleorderexport/export_order/csvexport'),
            ));
            $block->addItem('simpleorderexportJDE', array(
            		'label' => 'Export JDE Report',
            		'url' => Mage::app()->getStore()->getUrl('simpleorderexport/export_order/csvexportjde'),
            ));
            $block->addItem('simpleorderexportAramex', array(
            		'label' => 'Export Aramex Report',
            		'url' => Mage::app()->getStore()->getUrl('simpleorderexport/export_order/csvexportaramex'),
            ));
            if($role=="Administrators"){
            $block->addItem('deleteorders', array(
            		'label' => 'Delete Orders',
            		'url' => Mage::app()->getStore()->getUrl('emadmin/adminhtml_sales_order/deleteorder'),
            ));
            }
        }
    }
}