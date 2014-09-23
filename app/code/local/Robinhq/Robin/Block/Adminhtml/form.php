<?php
class Robinhq_Robin_Block_Adminhtml_Form_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                  
        $this->_objectId = 'id';
        $this->_blockGroup = 'form';
        $this->_controller = 'adminhtml_form';
         
        $this->_updateButton('save', 'label', Mage::helper('form')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('form')->__('Delete'));
         
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }
 
    public function getHeaderText()
    {
        return Mage::helper('form')->__('My Form Container');
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addCss('skin/adminhtml/default/default/robin/robin.css');

        return parent::_prepareLayout();
    }
}