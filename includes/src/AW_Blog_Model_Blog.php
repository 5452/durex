<?php

/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-L.txt
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-L.txt
 */
class AW_Blog_Model_Blog extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('blog/blog');
    }

    public function getShortContent() {
        $content = $this->getData('short_content');
        if (Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function getPostContent() {
        $content = $this->getData('post_content');
        if (Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }
    
    public function getPostContentForList() {
    	$content = $this->getData('post_content');
    	$content = strip_tags($content);
    	return $content;
    }
    
    public function getPostImg() {
    	$content = $this->getData('post_content');
    	$content1 = Array();
    	$reg = '/<img[^>].+>/i';    	 
    	preg_match_all( $reg , $content , $content1 );
    	$content= $content1[0][0];
    	$content = str_replace(" ","",$content);
    	$start = strpos($content, "mediaurl=")+10;
    	$end = strpos($content, "}}")-1;
    	//var_dump($content);
    	$content = substr($content, $start, $end-$start);
    	//var_dump($content);
    	return $content;
    }

    public function _beforeSave() {
        if (is_array($this->getData('tags'))) {
            $this->setData('tags', implode(",", $this->getData('tags')));
        }
        return parent::_beforeSave();
    }

}