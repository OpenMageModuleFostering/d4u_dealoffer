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
 * Product helper
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Helper_Product extends D4U_Dealoffer_Helper_Data{
	/**
	 * get the selected offerss for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return array()
	 * @author Ultimate Module Creator
	 */
	public function getSelectedOfferss(Mage_Catalog_Model_Product $product){
		if (!$product->hasSelectedOfferss()) {
			$offerss = array();
			foreach ($this->getSelectedOfferssCollection($product) as $offers) {
				$offerss[] = $offers;
			}
			$product->setSelectedOfferss($offerss);
		}
		return $product->getData('selected_offerss');
	}
	/**
	 * get offers collection for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return D4U_Dealoffer_Model_Resource_Offers_Collection
	 */
	public function getSelectedOfferssCollection(Mage_Catalog_Model_Product $product){
		$collection = Mage::getResourceSingleton('dealoffer/offers_collection')
			->addProductFilter($product);
		return $collection;
	}
}