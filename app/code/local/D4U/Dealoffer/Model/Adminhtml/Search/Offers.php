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
 * Admin search model
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Model_Adminhtml_Search_Offers extends Varien_Object{
	/**
	 * Load search results
	 * @access public
	 * @return D4U_Dealoffer_Model_Adminhtml_Search_Offers
	 * @author Ultimate Module Creator
	 */
	public function load(){
		$arr = array();
		if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
			$this->setResults($arr);
			return $this;
		}
		$collection = Mage::getResourceModel('dealoffer/offers_collection')
			->addFieldToFilter('name', array('like' => $this->getQuery().'%'))
			->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
			->load();
		foreach ($collection->getItems() as $offers) {
			$arr[] = array(
				'id'=> 'offers/1/'.$offers->getId(),
				'type'  => Mage::helper('dealoffer')->__('Offers'),
				'name'  => $offers->getName(),
				'description'   => $offers->getName(),
				'url' => Mage::helper('adminhtml')->getUrl('*/dealoffer_offers/edit', array('id'=>$offers->getId())),
			);
		}
		$this->setResults($arr);
		return $this;
	}
}