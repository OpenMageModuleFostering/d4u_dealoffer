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
 * Offers helper
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Helper_Offers extends Mage_Core_Helper_Abstract{
	/**
	 * check if the rss for offers is enabled
	 * @access public
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function isRssEnabled(){
		return  Mage::getStoreConfigFlag('rss/config/active') && Mage::getStoreConfigFlag('dealoffer/offers/rss');
	}
	/**
	 * get the link to the offers rss list
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRssUrl(){
		return Mage::getUrl('dealoffer/offers/rss');
	}
	/**
	 * get base files dir
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getFileBaseDir(){
		return Mage::getBaseDir('media').DS.'offers'.DS.'file';
	}
	/**
	 * get base file url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getFileBaseUrl(){
		return Mage::getBaseUrl('media').'offers'.'/'.'file';
	}
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('dealoffer/offers/breadcrumbs');
	}
}