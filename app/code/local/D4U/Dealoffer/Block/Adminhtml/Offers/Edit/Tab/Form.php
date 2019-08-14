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
 * Offers edit form tab
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Dealoffer_Offers_Block_Adminhtml_Offers_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('offers_');
		$form->setFieldNameSuffix('offers');
		$this->setForm($form);
		$fieldset = $form->addFieldset('offers_form', array('legend'=>Mage::helper('dealoffer')->__('Deal Offer Informations')));
		$fieldset->addType('image', Mage::getConfig()->getBlockClassName('dealoffer/adminhtml_offers_helper_image'));
		
		
		
		//for all category
		 //$arr =  $this->get_categories();
		 //var_dump($arr);
		
		$categories = Mage::getModel('catalog/category')->getCollection()  
					->addAttributeToSelect('name')
					->addAttributeToSelect('url_key')
					->addAttributeToSelect('my_attribute')
					->setLoadProductCount(true)
					->addAttributeToFilter('is_active',array('eq'=>true))
					->addAttributeToFilter('level',2)
					->setOrder('position', Varien_Db_Select::SQL_ASC)
					->load();
		$main_category_arr = array();
		foreach ($categories as $cat):
			$data_arr =$cat->getData();
			$main_category_arr[] = array('value'=>$data_arr['entity_id'],'label' => $cat->getName());
		endforeach;
		
		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('dealoffer')->__('Name'),
			'name'  => 'name',
			'note'	=> $this->__('Enter Unique Deal Offer Name'),
			'required'  => true,
			'class' => 'required-entry',
			'onchange' => "document.getElementById('offers_url_key').value  = (document.getElementById('offers_name').value).replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '').toLowerCase();",
		));

		$fieldset->addField('category_id', 'select', array(
			'label' => Mage::helper('dealoffer')->__('Category'),
			'name'  => 'category_id',
			'values'=> $main_category_arr,
		));
		
		
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
			Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
		);

		$fieldset->addField('start_date', 'date', array(
			'label' => Mage::helper('dealoffer')->__('Start Date'),
			'name'  => 'start_date',
			'note'	=> $this->__('Deal Offer Start Date'),
			'required'  => true,
			'class' => 'required-entry',
			'image'	 => $this->getSkinUrl('images/grid-cal.gif'),
			'format'	=> $dateFormatIso,
			'onchange' => "Checkdate_offer(document.getElementById('offers_start_date').value,document.getElementById('offers_end_date').value)"
		));
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
			Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
		);

		$fieldset->addField('end_date', 'date', array(
			'label' => Mage::helper('dealoffer')->__('End Date'),
			'name'  => 'end_date',
			'note'	=> $this->__('Deal Offer Expiry Date'),
			'required'  => true,
			'class' => 'required-entry',
			'image'	 => $this->getSkinUrl('images/grid-cal.gif'),
			'format'	=> $dateFormatIso,
			'onchange' => "Checkdate_offer(document.getElementById('offers_start_date').value,document.getElementById('offers_end_date').value)"
		));

		$fieldset->addField('deal_image', 'image', array(
		'name'      => 'deal_image',
		'class'     => 'required-entry required-file',
		'label'     => Mage::helper('dealoffer')->__('Offer Image'),
		'title'     => Mage::helper('dealoffer')->__('Offer Image'),
		'required'  => true,
		
		));

		$fieldset->addField('url_key', 'text', array(
			'label' => Mage::helper('dealoffer')->__('Url key'),
			'name'  => 'url_key',
			'required'  => true,
			'class' => 'required-entry',
			'note'	=> Mage::helper('dealoffer')->__('Relative to Website Base URL')
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('dealoffer')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => '1',
					'label' => Mage::helper('dealoffer')->__('Enabled'),
				),
				array(
					'value' => '0',
					'label' => Mage::helper('dealoffer')->__('Disabled'),
				),
			),
			'value'     => 1 //Default value
		));
		$fieldset->addField('in_rss', 'select', array(
			'label' => Mage::helper('dealoffer')->__('Show in rss'),
			'name'  => 'in_rss',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('dealoffer')->__('Yes'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('dealoffer')->__('No'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_offers')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getOffersData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getOffersData());
			Mage::getSingleton('adminhtml/session')->setOffersData(null);
		}
		elseif (Mage::registry('current_offers')){
			$form->setValues(Mage::registry('current_offers')->getData());
		}
		return parent::_prepareForm();
	}
	
	function get_categories(){

		$category = Mage::getModel('catalog/category'); 
		$tree = $category->getTreeModel(); 
		$tree->load();
		$ids = $tree->getCollection()->getAllIds(); 
		$arr = array();
		if ($ids){ 
		foreach ($ids as $id){ 
		$cat = Mage::getModel('catalog/category'); 
		$cat->load($id);
		$arr[$id] = $cat->getName();
		} 
		}

		return $arr;

}
}