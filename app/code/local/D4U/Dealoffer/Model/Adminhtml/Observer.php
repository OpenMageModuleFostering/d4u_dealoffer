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
 * Adminhtml observer
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Model_Adminhtml_Observer{
	/**
	 * check if tab can be added
	 * @access protected
	 * @param Mage_Catalog_Model_Product $product
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	protected function _canAddTab($product){
		if ($product->getId()){
			return true;
		}
		if (!$product->getAttributeSetId()){
			return false;
		}
		$request = Mage::app()->getRequest();
		if ($request->getParam('type') == 'configurable'){
			if ($request->getParam('attribtues')){
				return true;
			}
		}
		return false;
	}
	/**
	 * add the offers tab to products
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return D4U_Dealoffer_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function addOffersBlock($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
			$block->addTab('offerss', array(
				'label' => Mage::helper('dealoffer')->__('Offerss'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/dealoffer_offers_catalog_product/offerss', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}
	/**
	 * save offers - product relation
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return D4U_Dealoffer_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function saveOffersData($observer){
		$post = Mage::app()->getRequest()->getPost('offerss', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			$offersProduct = Mage::getResourceSingleton('dealoffer/offers_product')->saveProductRelation($product, $post);
		}
		return $this;
	}}