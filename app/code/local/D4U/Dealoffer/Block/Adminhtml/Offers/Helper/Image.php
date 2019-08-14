<?php
/**
 * D4U_Dealoffer extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	D4U
 * @package		D4U_Dealoffer
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Offers image field renderer helper
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Helper_Image extends Varien_Data_Form_Element_Image{
	/**
	 * get the url of the image
	 * @access protected
	 * @return string
	 * @author Ultimate Module Creator
	 */
	protected function _getUrl(){
		$url = false;
		if ($this->getValue()) {
			$url = Mage::helper('dealoffer/offers_image')->getImageBaseUrl().$this->getValue();
		}
		return $url;
	}
}
 