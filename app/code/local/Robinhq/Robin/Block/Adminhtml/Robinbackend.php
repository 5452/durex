<?php  

class Robinhq_Robin_Block_Adminhtml_Robinbackend extends Mage_Adminhtml_Block_Template {
   
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addCss('robin/robin.css');

        return parent::_prepareLayout();
    }

}