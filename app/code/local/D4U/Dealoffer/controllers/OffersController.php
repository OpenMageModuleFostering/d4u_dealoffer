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
 * Offers front contrller
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_OffersController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('dealoffer/offers')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('dealoffer')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('offerss', array(
							'label'	=> Mage::helper('dealoffer')->__('Offers'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('dealoffer/offers/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('dealoffer/offers/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('dealoffer/offers/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view offers action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$offersId 	= $this->getRequest()->getParam('id', 0);
		$offers 	= Mage::getModel('dealoffer/offers')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($offersId);
						
		$category = Mage::getModel('catalog/category')->load($offers->getCategoryId());	
		if (!$offers->getId()){
			$this->_forward('no-route');
		}
		elseif (!$offers->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_dealoffer_offers', $offers);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('dealoffer-offers dealoffer-offers' . $offers->getId());
			}
			if (Mage::helper('dealoffer/offers')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('dealoffer')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('offerss', array(
								'label'	=> Mage::helper('dealoffer')->__('Offers'), 
								'link'	=> Mage::helper('dealoffer')->getOfferssUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('category', array(
								'label'	=> Mage::helper('dealoffer')->__($category->getName()), 
								'link'	=> Mage::getUrl('dealoffer/offers/categoryview/',array('id'=>$offers->getCategoryId())),
						)
					);
					$breadcrumbBlock->addCrumb('offers', array(
								'label'	=> $offers->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($offers->getMetaTitle()){
					$headBlock->setTitle($offers->getMetaTitle());
				}
				else{
					$headBlock->setTitle($offers->getName());
				}
				$headBlock->setKeywords($offers->getMetaKeywords());
				$headBlock->setDescription($offers->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * offers rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('dealoffer/offers')->isRssEnabled()) {
			$this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
			$this->loadLayout(false);
			$this->renderLayout();
		}
		else {
			$this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
			$this->getResponse()->setHeader('Status','404 File not found');
			$this->_forward('nofeed','index','rss');
		}
	} 
	
	public function categoryviewAction()
	{
		/*echo $this->getLayout()
			->createBlock('Mage_Core_Block_Template')
			->setTemplate('d4u_dealoffer/offers/categoryview.phtml')
			->toHtml();*/
			$this->loadLayout();
			$this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
			
			$params = $this->getRequest()->getParams();
			$category = Mage::getModel('catalog/category')->load($params['id']);		

			if (Mage::helper('dealoffer/offers')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('dealoffer')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('offerss', array(
								'label'	=> Mage::helper('dealoffer')->__('Offers'), 
								'link'	=> Mage::getUrl('dealoffer/offers'),
						)
					);
					$breadcrumbBlock->addCrumb('category', array(
								'label'	=> Mage::helper('dealoffer')->__($category->getName()), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				$headBlock->setTitle(Mage::getStoreConfig('dealoffer/offers/meta_title'));
				$headBlock->setKeywords(Mage::getStoreConfig('dealoffer/offers/meta_keywords'));
				$headBlock->setDescription(Mage::getStoreConfig('dealoffer/offers/meta_description'));
			}
			$block = $this->getLayout()->createBlock(
							'Mage_Core_Block_Template',
							'categoryview',
							array('template' => 'd4u_dealoffer/offers/categoryview.phtml')
							);
						$this->getLayout()->getBlock('content')->append($block);
			
			$this->renderLayout();
		
	
	}
	public function getdailydealAction()
	{
				echo $this->getLayout()
				->createBlock('Mage_Core_Block_Template')
				->setTemplate('d4u_dealoffer/getdailydeal.phtml')
				->toHtml();
	}
}