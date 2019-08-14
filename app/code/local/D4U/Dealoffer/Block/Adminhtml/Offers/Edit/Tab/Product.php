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
 * Offers - product relation edit block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('product_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getOffers()->getId()) {
			$this->setDefaultFilter(array('in_products'=>1));
		}
	}
	/**
	 * prepare the product collection
	 * @access protected 
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tab_Product
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('catalog/product_collection')->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'right');
		$collection->addAttributeToFilter('status',1);
		$collection->addAttributeToFilter('visibility',array("neq"=>1)); 
		$collection->addAttributeToSelect('price');
		$adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
		$collection->joinAttribute('product_name', 'catalog_product/name', 'entity_id', null, 'left', $adminStore);
		if ($this->getOffers()->getId()){
			$constraint = '{{table}}.offers_id='.$this->getOffers()->getId();
		}
		else{
			$constraint = '{{table}}.offers_id=0';
		}
		$collection->joinField('position',
			'dealoffer/offers_product',
			'position',
			'product_id=entity_id',
			$constraint,
			'left');
			
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tab_Product
	 * @author Ultimate Module Creator
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tab_Product
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		
		$collection = Mage::getModel('catalog/category')->getCollection()->setLoadProductCount(true)->addAttributeToSelect('name');
		$options = array();
		foreach ($collection as $item){
			if($item->getId() != '' ){
				$options[$item->getId()] = $item->getName();
			}
		}
		
		$this->addColumn('in_products', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_products',
			'field_name' =>'items[]',
			'values'=> $this->_getSelectedProducts(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('product_name', array(
			'header'=> Mage::helper('catalog')->__('Name'),
			'align' => 'left',
			'index' => 'product_name',
		));
		$this->addColumn('category_id', array(
			'header'=> Mage::helper('catalog')->__('Category Name'),
			'align' => 'left',
			'index' => 'category_id',
			'type' => 'options',
            'options'  =>$options
			
		));
		$this->addColumn('sku', array(
			'header'=> Mage::helper('catalog')->__('SKU'),
			'align' => 'left',
			'index' => 'sku',
		));
		$this->addColumn('price', array(
			'header'=> Mage::helper('catalog')->__('Price'),
			'type'  => 'currency',
			'width' => '1',
			'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
			'index' => 'price'
		));
		$this->addColumn('position', array(
			'header'=> Mage::helper('catalog')->__('Position'),
			'name'  => 'position',
			'width' => 60,
			'type'  => 'number',
			'validate_class'=> 'validate-number',
			'index' => 'position',
			'editable'  => true,
		));
	}
	/**
	 * Retrieve selected products
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _getSelectedProducts(){
		$products = $this->getOffersProducts();
		if (!is_array($products)) {
			$products = array_keys($this->getSelectedProducts());
		}
		return $products;
	}
	
 	/**
	 * Retrieve selected products
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProducts() {
		$products = array();
		$selected = Mage::registry('current_offers')->getSelectedProducts();
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $product) {
			$products[$product->getId()] = array('position' => $product->getPosition());
		}
		return $products;
	}
	/**
	 * get row url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($item){
		return '#';
	}
	/**
	 * get grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/productsGrid', array(
			'id'=>$this->getOffers()->getId()
		));
	}
	/**
	 * get the current offers
	 * @access public
	 * @return D4U_Dealoffer_Model_Offers
	 * @author Ultimate Module Creator
	 */
	public function getOffers(){
		return Mage::registry('current_offers');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tab_Product
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
		// Set custom filter for in product flag
		if ($column->getId() == 'in_products') {
			$productIds = $this->_getSelectedProducts();
			if (empty($productIds)) {
				$productIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
			} 
			else {
				if($productIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}