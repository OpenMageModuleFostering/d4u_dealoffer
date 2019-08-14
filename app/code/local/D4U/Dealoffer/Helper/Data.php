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
 * Dealoffer default helper
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
	 * get the url to the offers list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getOfferssUrl(){
		return Mage::getUrl('dealoffer/offers/index');
	}
}