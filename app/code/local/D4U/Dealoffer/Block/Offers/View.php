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
 * Offers view block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Offers_View extends Mage_Core_Block_Template{
	/**
	 * get the current offers
	 * @access public
	 * @return mixed (D4U_Dealoffer_Model_Offers|null)
	 * @author Ultimate Module Creator
	 */
	public function getCurrentOffers(){
		return Mage::registry('current_dealoffer_offers');
	}
} 