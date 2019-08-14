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
 * Offers product model
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Model_Offers_Product extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->_init('dealoffer/offers_product');
	}
	/**
	 * Save data for offers-product relation
	 * @access public
	 * @param  D4U_Dealoffer_Model_Offers $offers
	 * @return D4U_Dealoffer_Model_Offers_Product
	 * @author Ultimate Module Creator
	 */
	public function saveOffersRelation($offers){
		$data = $offers->getProductsData();
		if (!is_null($data)) {
			$this->_getResource()->saveOffersRelation($offers, $data);
		}
		return $this;
	}
	/**
	 * get products for offers
	 * @access public
	 * @param D4U_Dealoffer_Model_Offers $offers
	 * @return D4U_Dealoffer_Model_Resource_Offers_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getProductCollection($offers){
		$collection = Mage::getResourceModel('dealoffer/offers_product_collection')
			->addOffersFilter($offers);
		return $collection;
	}
}