<?php
/**
 * ND MigsVpc payment gateway
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so you can be sent a copy immediately.
 *
 * Original code copyright (c) 2008 Irubin Consulting Inc. DBA Varien
 *
 * @category ND
 * @package    ND_MigsVpc
 * @copyright  Copyright (c) 2010 ND MigsVpc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class ND_MigsVpc_Block_Merchantnew_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        $secure = $this->getOrder()->getPayment()->getMethodInstance();

        $form = new Varien_Data_Form();
        $form->setAction($secure->getMigsVpcMerchantUrl())
            ->setId('migsvpc_merchantnew_checkout')
            ->setName('migsvpc_merchantnew_checkout')
            ->setMethod('POST')
            ->setUseContainer(true);
        foreach ($secure->getFormFields() as $field=>$value) {
            $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));
        }
        $html = '<html><head><style type="text/css">*{margin:0;padding:0;}body{margin:0;padding:0;background:url('.$this->getSkinUrl('images/saletab-bg.jpg').')top center no-repeat;min-height:939px;}.loding{width:130px;margin:0 auto;padding-top:420px;}</style></head><body>';
        $html.= $this->__('Please wait. We are processing your request....');
        //$html .= '<div class="loding"><img src="'.$this->getSkinUrl('images/loading.gif').'" alt="loading" /></div>';
        $html.= $form->toHtml();
        $html.= '<script type="text/javascript">document.getElementById("migsvpc_merchantnew_checkout").submit();</script>';
        $html.= '</body></html>';
        $html = str_replace('<div><input name="form_key" type="hidden" value="'.Mage::getSingleton('core/session')->getFormKey().'" /></div>','',$html);
        return $html;
    }
}
