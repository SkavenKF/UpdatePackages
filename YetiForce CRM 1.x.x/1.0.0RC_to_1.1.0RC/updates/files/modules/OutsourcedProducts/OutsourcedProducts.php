<?php
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
include_once 'modules/Vtiger/CRMEntity.php';

class OutsourcedProducts extends Vtiger_CRMEntity {
	var $table_name = 'vtiger_outsourcedproducts';
	var $table_index= 'outsourcedproductsid';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;
	var $related_tables = Array('vtiger_outsourcedproductscf' => Array ('outsourcedproductsid', 'vtiger_outsourcedproducts', 'outsourcedproductsid'));
	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_outsourcedproductscf', 'outsourcedproductsid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity','vtiger_outsourcedproducts','vtiger_outsourcedproductscf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity'=>'crmid',
		'vtiger_outsourcedproducts'=>'outsourcedproductsid',
		'vtiger_outsourcedproductscf'=>'outsourcedproductsid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array(
   		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
        'Product Name'=>Array('outsourcedproducts'=>'productname'),
		'Category'=>Array('outsourcedproducts'=>'pscategory'),
		'Sub Category'=>Array('outsourcedproducts'=>'pssubcategory'),
		'Assigned To' => Array('crmentity','smownerid'),
		'Date Sold'=>Array('outsourcedproducts'=>'datesold'),
		'Status'=>Array('outsourcedproducts'=>'oproductstatus'),
	);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
        'Product Name'=>'productname',
		'Category'=>'pscategory',
		'Sub Category'=>'pssubcategory',
		'Assigned To' => 'assigned_user_id',
		'Date Sold'=>'datesold',
		'Status'=>'oproductstatus',
	);

	// Make the field link to detail view
	var $list_link_field = 'productname';

	// For Popup listview and UI type support
	var $search_fields = array (
        'Product Name'=>Array('outsourcedproducts'=>'productname'),
		'Category'=>Array('outsourcedproducts'=>'pscategory'),
		'Sub Category'=>Array('outsourcedproducts'=>'pssubcategory'),
		'Assigned To' => Array('crmentity','smownerid'),
		'Date Sold'=>Array('outsourcedproducts'=>'datesold'),
		'Status'=>Array('outsourcedproducts'=>'oproductstatus'),
	);
	var $search_fields_name = array (
        'Product Name'=>'productname',
		'Category'=>'pscategory',
		'Sub Category'=>'pssubcategory',
		'Assigned To' => 'assigned_user_id',
		'Date Sold'=>'datesold',
		'Status'=>'oproductstatus',
	);

	// For Popup window record selection
	var $popup_fields = array('productname');

	// Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
	var $sortby_fields = Array();

	// For Alphabetical search
	var $def_basicsearch_col = 'productname';

	// Required Information for enabling Import feature
	var $required_fields = array('productname'=>1);

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = array('createdtime', 'modifiedtime', 'productname');

	// Callback function list during Importing
	var $special_functions = Array('set_import_assigned_user');

	var $default_order_by = 'productname';
	var $default_sort_order='ASC';

	var $unit_price;
 	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
	function vtlib_handler($moduleName, $eventType) {
		require_once('include/utils/utils.php');
		global $adb;

 		if($eventType == 'module.postinstall') {
			//Add Assets Module to Customer Portal
			global $adb;
			include_once('vtlib/Vtiger/Module.php');
			// Mark the module as Standard module
			$adb->pquery('UPDATE vtiger_tab SET customized=0 WHERE name=?', array($moduleName));

			//adds sharing accsess
			$AssetsModule  = Vtiger_Module::getInstance($moduleName);
			Vtiger_Access::setDefaultSharing($AssetsModule);

			//Showing Assets module in the related modules in the More Information Tab
			$assetInstance = Vtiger_Module::getInstance($moduleName);

			$accountInstance = Vtiger_Module::getInstance('Accounts');
			$accountInstance->setRelatedlist($assetInstance,$moduleName,array('ADD'),'get_dependents_list');

			$productInstance = Vtiger_Module::getInstance('Products');
			$productInstance->setRelatedlist($assetInstance,$moduleName,array('ADD'),'get_dependents_list');

			$InvoiceInstance = Vtiger_Module::getInstance('Invoice');
			$InvoiceInstance->setRelatedlist($assetInstance,$moduleName,array('ADD'),'get_dependents_list');$InvoiceInstance = Vtiger_Module::getInstance('Leads');
			$InvoiceInstance->setRelatedlist($assetInstance,$moduleName,array('ADD'),'get_dependents_list');

			$result = $adb->pquery("SELECT 1 FROM vtiger_modentity_num WHERE semodule = ? AND active = 1", array($moduleName));
			if (!($adb->num_rows($result))) {
				//Initialize module sequence for the module
				$adb->pquery("INSERT INTO vtiger_modentity_num values(?,?,?,?,?,?)", array($adb->getUniqueId("vtiger_modentity_num"), $moduleName, 'UP', 1, 1, 1));
			}

		} else if($eventType == 'module.disabled') {
		// TODO Handle actions when this module is disabled.
		} else if($eventType == 'module.enabled') {
		// TODO Handle actions when this module is enabled.
		} else if($eventType == 'module.preuninstall') {
		// TODO Handle actions when this module is about to be deleted.
		} else if($eventType == 'module.preupdate') {
		// TODO Handle actions before this module is updated.
		} else if($eventType == 'module.postupdate') {
		}
 	} 
    /**
	 * Move the related records of the specified list of id's to the given record.
	 * @param String This module name
	 * @param Array List of Entity Id's from which related records need to be transfered
	 * @param Integer Id of the the Record to which the related records are to be moved
	 */
	function transferRelatedRecords($module, $transferEntityIds, $entityId) {
		global $adb,$log;
		$log->debug("Entering function transferRelatedRecords ($module, $transferEntityIds, $entityId)");

		$rel_table_arr = Array("Documents"=>"vtiger_senotesrel","Attachments"=>"vtiger_seattachmentsrel");

		$tbl_field_arr = Array("vtiger_senotesrel"=>"notesid","vtiger_seattachmentsrel"=>"attachmentsid");

		$entity_tbl_field_arr = Array("vtiger_senotesrel"=>"crmid","vtiger_seattachmentsrel"=>"crmid");

		foreach($transferEntityIds as $transferId) {
			foreach($rel_table_arr as $rel_module=>$rel_table) {
				$id_field = $tbl_field_arr[$rel_table];
				$entity_id_field = $entity_tbl_field_arr[$rel_table];
				// IN clause to avoid duplicate entries
				$sel_result =  $adb->pquery("select $id_field from $rel_table where $entity_id_field=? " .
						" and $id_field not in (select $id_field from $rel_table where $entity_id_field=?)",
						array($transferId,$entityId));
				$res_cnt = $adb->num_rows($sel_result);
				if($res_cnt > 0) {
					for($i=0;$i<$res_cnt;$i++) {
						$id_field_value = $adb->query_result($sel_result,$i,$id_field);
						$adb->pquery("update $rel_table set $entity_id_field=? where $entity_id_field=? and $id_field=?",
							array($entityId,$transferId,$id_field_value));
					}
				}
			}
		}
		parent::transferRelatedRecords($module, $transferEntityIds, $entityId);
		$log->debug("Exiting transferRelatedRecords...");
	}
}
?>
