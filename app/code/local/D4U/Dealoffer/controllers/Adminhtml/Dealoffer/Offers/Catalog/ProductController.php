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
 * Offers product admin controller
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class D4U_Dealoffer_Adminhtml_Dealoffer_Offers_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	/**
	 * construct
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		// Define module dependent translate
		$this->setUsedModuleName('D4U_Dealoffer');
	}
	/**
	 * offerss in the catalog page
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function offerssAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.offers')
			->setProductOfferss($this->getRequest()->getPost('product_offerss', null));
		$this->renderLayout();
	}
	/**
	 * offerss grid in the catalog page
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function offerssGridAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.offers')
			->setProductOfferss($this->getRequest()->getPost('product_offerss', null));
		$this->renderLayout();
	}
}