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
 * Offers admin edit block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'dealoffer';
		$this->_controller = 'adminhtml_offers';
		$this->_updateButton('delete', 'label', Mage::helper('dealoffer')->__('Delete Offers'));
		$this->_removeButton('save');
		$this->_addButton('save', array(
			'label'		=> Mage::helper('dealoffer')->__('Save'),
			'onclick'	=> 'saveEdit()',
			'class'		=> 'save',
		), -50);
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('dealoffer')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		/*$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";*/
		$this->_formScripts[] = "function endAfterStart_offer(start,end){
				return new Date(start.split('/').reverse().join('/')) <=
				new Date(end.split('/').reverse().join('/'));
			}
			function Checkdate_offer(start,end){
			if(start != '' && end != '') {
			var parContainer = document.getElementById('note_end_date');
			var msgContainer1 = document.getElementById('datevalidation');
			if(msgContainer1)
					{
						parContainer.removeChild(msgContainer1);
					}
				if(endAfterStart_offer(start,end) == true)
				{
				}
				else{
					var msgContainer = document.createElement('div');
					msgContainer.setAttribute('id', 'datevalidation');  //set id
					msgContainer.setAttribute('class', 'validation-advice');  //set id
					msgContainer.style.color='#D40707';
					msgContainer.style.fontWeight='bold';
					msgContainer.style.fontSize ='11.4px';
					msgContainer.style.marginLeft ='-5px';
					msgContainer.innerHTML = 'End Date Must be greater than Start Date';
					document.getElementById('offers_end_date').value='';
					parContainer.insertBefore(msgContainer,parContainer.childNodes[0]);
				}
				}
			}
			
			function showproductmsg_offer()
			{
					var parContainer = document.getElementById('offers_tabs_products_content');
					var msgContainer1 = document.getElementById('xyz');
					if(msgContainer1)
					{
						parContainer.removeChild(msgContainer1);
					}
					var msgContainer = document.createElement('div');
					msgContainer.setAttribute('id', 'xyz');  //set id
					msgContainer.style.color='red';
					msgContainer.innerHTML = 'Please Select At least One Product';
					parContainer.insertBefore(msgContainer,parContainer.childNodes[0]);
					
					document.getElementById('offers_tabs_form_offers').className = 'tab-item-link';
					document.getElementById('offers_tabs_form_store_offers').className = 'tab-item-link';
					document.getElementById('offers_tabs_products').className = 'tab-item-link error active';
					
					document.getElementById('offers_tabs_form_offers_content').style.display = 'none';
					document.getElementById('offers_tabs_form_store_offers_content').style.display = 'none';
					document.getElementById('offers_tabs_products_content').style.display = 'block';
					return false;
			}
			
			function showProductsTab_offer(method) { 
			
				var cboxes = document.getElementsByName('items[]');
				var len = cboxes.length;
				for (var i=0; i<len; i++) 
				{ 
					if(cboxes[i].checked)
						{ 
							if(method == 1)
							{
							 editForm.submit($('edit_form').action+'back/edit/');
							 return true;
							}
							else
							{ 
								editForm.submit($('edit_form').action);
								return true;
							
							}
						}
				}
				setTimeout(showproductmsg_offer, 1000);	
				return false;
			}
			function saveAndContinueEdit(){
			if(document.getElementById('offers_deal_image_image')){
			
			}
			else{
			document.getElementById('offers_deal_image').className = '';
			document.getElementById('offers_deal_image').className = 'required-entry';
			}
			showProductsTab_offer(1);
			}
			function saveEdit(){
			if(document.getElementById('offers_deal_image_image')){
			
			}
			else{
			document.getElementById('offers_deal_image').className = '';
			document.getElementById('offers_deal_image').className = 'required-entry';
			}
			showProductsTab_offer(0);
			}
		";
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getHeaderText(){
		if( Mage::registry('offers_data') && Mage::registry('offers_data')->getId() ) {
			return Mage::helper('dealoffer')->__("Edit Offers '%s'", $this->htmlEscape(Mage::registry('offers_data')->getName()));
		} 
		else {
			return Mage::helper('dealoffer')->__('Add Offer');
		}
	}
}