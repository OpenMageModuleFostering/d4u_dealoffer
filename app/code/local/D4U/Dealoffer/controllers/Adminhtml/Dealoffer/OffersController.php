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
 * Offers admin controller
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Adminhtml_Dealoffer_OffersController extends D4U_Dealoffer_Controller_Adminhtml_Dealoffer{
	/**
	 * init the offers
	 * @access protected
	 * @return D4U_Dealoffer_Model_Offers
	 */
	protected function _initOffers(){
		$offersId  = (int) $this->getRequest()->getParam('id');
		$offers	= Mage::getModel('dealoffer/offers');
		if ($offersId) {
			$offers->load($offersId);
		}
		Mage::register('current_offers', $offers);
		return $offers;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('dealoffer')->__('Dealoffer'))
			 ->_title(Mage::helper('dealoffer')->__('Offers'));
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit offers - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$offersId	= $this->getRequest()->getParam('id');
		$offers  	= $this->_initOffers();
		if ($offersId && !$offers->getId()) {
			$this->_getSession()->addError(Mage::helper('dealoffer')->__('This offers no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$offers->setData($data);
		}
		Mage::register('offers_data', $offers);
		$this->loadLayout();
		$this->_title(Mage::helper('dealoffer')->__('Dealoffer'))
			 ->_title(Mage::helper('dealoffer')->__('Offers'));
		if ($offers->getId()){
			$this->_title($offers->getName());
		}
		else{
			$this->_title(Mage::helper('dealoffer')->__('Add offers'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new offers action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save offers - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('offers')) {
			try {
				$offers = $this->_initOffers();
				$offers->addData($data);
				$deal_imageName = $this->_uploadAndGetName('deal_image', Mage::helper('dealoffer/offers_image')->getImageBaseDir(), $data);
				$offers->setData('deal_image', $deal_imageName);
			//	$offer_imageName = $this->_uploadAndGetName('offer_image', Mage::helper('dealoffer/offers')->getFileBaseDir(), $data);
			//	$offers->setData('offer_image', $offer_imageName);
				$offers->setData('offer_image', 0);
				$products = $this->getRequest()->getPost('products', -1);
				if ($products != -1) {
					$offers->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
				}
				$offers->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dealoffer')->__('Offers was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $offers->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				if (isset($data['deal_image']['value'])){
					$data['deal_image'] = $data['deal_image']['value'];
				}
				if (isset($data['offer_image']['value'])){
					$data['offer_image'] = $data['offer_image']['value'];
				}
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				if (isset($data['deal_image']['value'])){
					$data['deal_image'] = $data['deal_image']['value'];
				}
				if (isset($data['offer_image']['value'])){
					$data['offer_image'] = $data['offer_image']['value'];
				}
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('There was a problem saving the offers.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('Unable to find offers to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete offers - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$offers = Mage::getModel('dealoffer/offers');
				$offers->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dealoffer')->__('Offers was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('There was an error deleteing offers.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('Could not find offers to delete.'));
		$this->_redirect('*/*/');
	}
	public function massTodayDealAction(){
		
		$offersIds = $this->getRequest()->getParam('offers');
		if(!is_array($offersIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('Please select offers.'));
		}
		elseif(count($offersIds) > 1)
		{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('Select Single offers only and  End Date is grater then today date'));
		}
		else{
		
				
					$offerss   = Mage::getResourceModel('dealoffer/offers_collection');
					foreach($offerss as $_offers)
						{	
							if($_offers->getEntityId() == $offersIds[0]){
							$end_date=date("d-m-Y", strtotime($_offers->getEndDate()));
							}
							
							if($_offers->getOfferImage() != 0){
							$offersset="";
							$offersset = Mage::getSingleton('dealoffer/offers')->load($_offers->getEntityId())
										->setOfferImage(0)
										->setIsMassupdate(true)
										->save();
							}
						}
						
				$today = date("d-m-Y"); 
				if(!empty($end_date)  && strtotime($end_date) >= strtotime($today))
				{
						$offers1="";
						$offers1 = Mage::getSingleton('dealoffer/offers')->load($offersIds[0])
									->setOfferImage(1)
									->setIsMassupdate(true)
									->save();
								//	print_r($offers1);exit;
					    $this->_getSession()->addSuccess($this->__('Set today display offer successfully.'));
				}
				else{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('End Date must grater then or equal to today date'));
					
				}
				
							
				
			
		}
		
		$this->_redirect('*/*/index');
	}
	/**
	 * mass delete offers - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$offersIds = $this->getRequest()->getParam('offers');
		if(!is_array($offersIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('Please select offers to delete.'));
		}
		else {
			try {
				foreach ($offersIds as $offersId) {
					$offers = Mage::getModel('dealoffer/offers');
					$offers->setId($offersId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dealoffer')->__('Total of %d offers were successfully deleted.', count($offersIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('There was an error deleteing offers.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massStatusAction(){
		$offersIds = $this->getRequest()->getParam('offers');
		if(!is_array($offersIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('Please select offers.'));
		} 
		else {
			try {
				foreach ($offersIds as $offersId) {
				$offers = Mage::getSingleton('dealoffer/offers')->load($offersId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d offers were successfully updated.', count($offersIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dealoffer')->__('There was an error updating offers.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsAction(){
		$this->_initOffers();
		$this->loadLayout();
		$this->getLayout()->getBlock('offers.edit.tab.product')
			->setOffersProducts($this->getRequest()->getPost('offers_products', null));
		$this->renderLayout();
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsgridAction(){
		$this->_initOffers();
		$this->loadLayout();
		$this->getLayout()->getBlock('offers.edit.tab.product')
			->setOffersProducts($this->getRequest()->getPost('offers_products', null));
		$this->renderLayout();
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'offers.csv';
		$content	= $this->getLayout()->createBlock('dealoffer/adminhtml_offers_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'offers.xls';
		$content	= $this->getLayout()->createBlock('dealoffer/adminhtml_offers_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'offers.xml';
		$content	= $this->getLayout()->createBlock('dealoffer/adminhtml_offers_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}