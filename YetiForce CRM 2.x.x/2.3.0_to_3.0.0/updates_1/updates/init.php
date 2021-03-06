<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * *********************************************************************************************************************************** */
require_once 'modules/com_vtiger_workflow/include.inc';
require_once 'modules/com_vtiger_workflow/tasks/VTEntityMethodTask.inc';
require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
require_once('include/events/include.inc');
include_once('vtlib/Vtiger/Module.php');
include_once('cache/updates/RemoveModule.php');
include_once('cache/updates/Migration.php');

class YetiForceUpdate
{

	var $package;
	var $modulenode;
	var $return = true;
	var $filesToDelete = [
		'modules/PaymentsIn/schema.xml',
		'modules/PaymentsOut/schema.xml',
		'config.csrf-secret.php',
		'api/firefoxtoolbar.php',
		'api/thunderbirdplugin.php',
		'api/wordplugin.php',
		'libraries/adodb',
		'libraries/chartjs/Chartmin.js',
		'libraries/guidersjs',
		'libraries/jquery/datatables/bower.json',
		'libraries/jquery/datatables/composer.json',
		'libraries/jquery/datatables/dataTables.jquery.json',
		'libraries/jquery/datatables/extensions/ColReorder/Readme.txt',
		'libraries/jquery/datatables/extensions/ColVis/Readme.txt',
		'libraries/jquery/datatables/extensions/FixedColumns/Readme.txt',
		'libraries/jquery/datatables/media/images/back_disabled.png',
		'libraries/jquery/datatables/media/images/back_enabled.png',
		'libraries/jquery/datatables/media/images/back_enabled_hover.png',
		'libraries/jquery/datatables/media/images/forward_disabled.png',
		'libraries/jquery/datatables/media/images/forward_enabled.png',
		'libraries/jquery/datatables/media/images/forward_enabled_hover.png',
		'libraries/jquery/datatables/package.json',
		'libraries/jquery/jqplot/excanvas.js',
		'libraries/jquery/jqplot/jquery.jqplot.css',
		'libraries/jquery/jqplot/jquery.jqplot.js',
		'libraries/jquery/jquery-ui/css',
		'libraries/jquery/jquery-ui/js',
		'libraries/jquery/jquery-ui/README.md',
		'libraries/jquery/jquery-ui/third-party',
		'libraries/jquery/pnotify/jquery.pnotify.default.css',
		'libraries/jquery/pnotify/jquery.pnotify.js',
		'libraries/jquery/pnotify/jquery.pnotify.min.js',
		'libraries/jquery/pnotify/use for pines style icons/jquery.pnotify.default.icons.css',
		'libraries/jquery/select2/component.json',
		'libraries/jquery/select2/LICENSE',
		'libraries/jquery/select2/release.sh',
		'libraries/jquery/select2/select2.png',
		'libraries/jquery/select2/select2x2.png',
		'libraries/jquery/select2/spinner.gif',
		'modules/Accounts/actions',
		'modules/Contacts/actions/TransferOwnership.php',
		'modules/ModComments/actions/Delete.php',
		'modules/OSSMailTemplates/actions/GetListModule.php',
		'modules/OSSMailTemplates/actions/GetListTpl.php',
		'modules/RequirementCards/models/Module.php',
		'modules/Settings/BackUp/actions/CreateBackUp.php',
		'modules/Settings/BackUp/actions/CreateFileBackUp.php',
		'modules/Settings/BackUp/actions/SaveFTPConfig.php',
		'modules/Vtiger/resources/validator/EmailValidator.js',
		'languages/de_de/Install.php',
		'languages/en_us/Install.php',
		'languages/pl_pl/Install.php',
		'languages/pt_br/Install.php',
		'languages/ru_ru/Install.php',
		'modules/Settings/Vtiger/views/ListUI5.php',
		'config/config.template.php',
		'modules/Settings/PDF/actions/DeleteWatermark.php',
		'modules/Settings/PDF/actions/GetSpecialFunctions.php',
		'modules/Settings/PDF/actions/ValidateRecords.php',
		'modules/Settings/PDF/helpers/upload_watermark.php',
		'modules/Settings/PDF/models/Field.php',
		'modules/Settings/PDF/models/FilterRecordStructure.php',
		'modules/Settings/PDF/models/RecordStructure.php',
		'modules/Settings/PDF/special_functions/example.php',
		'modules/Settings/PDF/views/ExportPDF.php',
		'modules/Settings/SupportProcesses/actions/SaveGeneral.php',
		'modules/Settings/Vtiger/views/UI5Embed.php',
		'modules/Vtiger/views/UI5Embed.php',
		'modules/QuotesEnquires/models/DetailView.php',
		'modules/RequirementCards/models/DetailView.php',
		'modules/RequirementCards/models/Record.php',
		'modules/SCalculations/schema.xml',
		'modules/SQuoteEnquiries/schema.xml',
		'modules/SQuotes/schema.xml',
		'modules/SRecurringOrders/schema.xml',
		'modules/SRequirementsCards/schema.xml',
		'modules/SSalesProcesses/schema.xml',
		'modules/SSingleOrders/schema.xml',
		'modules/Users/views/Detail.php',
		'modules/Users/views/Edit.php',
		'modules/Vtiger/handlers/SharedOwnerUpdater.php',
		'modules/QuotesEnquires',
		'modules/RequirementCards',
		'layouts/vlayout',
		'libraries/mPDF/examples',
		'modules/Accounts/views/AccountsListTree.php',
		'layouts/basic/modules/Accounts/resources/AccountsListTree.min.js',
		'layouts/basic/modules/Accounts/resources/AccountsListTree.js',
		'layouts/basic/modules/Accounts/AccountsListTree.tpl',
		'layouts/basic/modules/Accounts/AccountsList.tpl',
		'languages/ru_ru/Settings/Home.php',
		'languages/pt_br/Settings/Home.php',
		'languages/pl_pl/Settings/Home.php',
		'languages/en_us/Settings/Home.php',
		'languages/de_de/Settings/Home.php',
		'modules/Vtiger/widgets/Calculations.php',
		'layouts/basic/modules/Vtiger/widgets/CalculationsConfig.tpl',
		'layouts/basic/modules/Vtiger/widgets/CalculationsBasic.tpl',
		'layouts/basic/modules/Vtiger/widgets/Calculations.tpl',
		'cron/modules/SalesOrder/RecurringInvoice.service',
		'modules/Settings/OSSPdf',
		'layouts/basic/modules/Settings/OSSPdf',
		'modules/Settings/OSSCosts/',
		'modules/Vendors/models/DetailView.php',
		'modules/Products/models/DetailView.php',
		'modules/PaymentsIn/workflow/UpdateBalance.php',
		'modules/Accounts/summary_blocks/TotalSale.php',
		'modules/Accounts/handlers/AccountsHandler.php',
		'modules/Vtiger/widgets/PotentialsList.php',
		'modules/Project/views/InPotentialsRelation.php',
		'modules/OutsourcedProducts/models/ListView.php',
		'modules/OSSSoldServices/models/ListView.php',
		'modules/OSSOutsourcedServices/models/ListView.php',
		'modules/OSSMailScanner/email_actions/6_bind_Potentials.php',
		'modules/Mobile/api/ws/models/alerts/PotentialsDueIn5Days.php',
		'modules/Contacts/models/RelationListView.php',
		'modules/Campaigns/dashboards/CampaignsWidget.php',
		'modules/Assets/models/ListView.php',
		'layouts/basic/modules/Vtiger/widgets/PotentialsListBasic.tpl',
		'layouts/basic/modules/Vtiger/widgets/PotentialsList.tpl',
		'modules/Accounts/views/Detail.php',
		'modules/Leads/views/QuickCreateAjax.php',
		'config/calendar.php',
		'layouts/basic/modules/Vtiger/resources/TreeCategory.js',
		'layouts/basic/modules/Vtiger/resources/TreeCategory.min.js',
		'layouts/basic/modules/Vtiger/TreeCategory.tpl',
		'modules/Accounts/summary_blocks/OrdersAccepted.php',
		'modules/Accounts/summary_blocks/OrdersAll.php',
		'modules/Competition/schema.xml',
		'modules/Partners/schema.xml',
		'modules/Project/views/InPotentialsRelation.php',
		'modules/Vtiger/views/TreeCategory.php',
		'storage/Logo/serwis_logo_yetiforce.png',
		'modules/Inventory',
		'layouts/basic/modules/Inventory',
		'libraries/tcpdf',
		'vtlib/Vtiger/PDF',
		'libraries/mPDF/ttfonts/UnBatang_0613.ttf',
		'libraries/mPDF/ttfonts/Sun-ExtB.ttf',
		'libraries/mPDF/ttfonts/Sun-ExtA.ttf',
		'libraries/mPDF/ttfonts/Jomolhari.ttf',
		'libraries/mPDF/ttfonts/Aegyptus.otf',
		'layouts/basic/modules/OSSTimeControl/UsersList.tpl',
		'layouts/basic/modules/Reservations/UsersList.tpl',
		'modules/OSSTimeControl/views/UsersList.php',
		'modules/Reservations/views/UsersList.php',
		'layouts/basic/modules/Reservations/uitypes/DateTime.tpl',
		'layouts/basic/modules/OSSTimeControl/uitypes/DateTime.tpl',
		'modules/OSSMail/roundcube/plugins/yetiforce/yetiforce.min.js',
		'modules/OSSMail/RoundCube.js',
		'modules/OSSMail/actions/GetPermissions.php',
		'modules/OSSMail/actions/getCrmId.php',
		'modules/OSSMail/actions/getConfig.php',
		'modules/OSSMail/actions/findCrmDetail.php',
		'layouts/basic/modules/OSSMail/resources/Global.min.js',
		'layouts/basic/modules/OSSMail/resources/Global.js',
		'layouts/basic/modules/OSSMail/inframe.css',
		'modules/Emails/actions/TrackAccess.php',
		'modules/Services/models/DetailView.php',
		'modules/OSSMail/roundcube/plugins/yetiforce/yetiforce.js',
		'modules/OSSMailScanner/email_actions',
		'modules/OSSMailScanner/template_actions',
		'modules/OSSMailScanner/actions/saveFolderList.php',
		'layouts/basic/modules/OSSMail/selectEmail.tpl',
		'modules/OSSMail/actions/GetEmail.php',
		'modules/OSSMail/actions/GetTranslate.php',
		'modules/OSSMail/views/selectEmail.php',
		'layouts/basic/modules/Settings/Vtiger/Github.tpl',
		'layouts/basic/modules/OSSMailView/DetailViewHeader.tpl',
		'modules/ServiceContracts/models/Module.php',
		'modules/Vendors/models/Module.php',
		'modules/Accounts/models/Relation.php',
		'modules/Competition/models/Relation.php',
		'modules/Contacts/models/Relation.php',
		'modules/HelpDesk/models/Relation.php',
		'modules/Leads/models/Relation.php',
		'modules/Partners/models/Relation.php',
		'modules/Project/models/Relation.php',
		'modules/SCalculations/models/Relation.php',
		'modules/ServiceContracts/models/Relation.php',
		'modules/SQuoteEnquiries/models/Relation.php',
		'modules/SQuotes/models/Relation.php',
		'modules/SRecurringOrders/models/Relation.php',
		'modules/SRequirementsCards/models/Relation.php',
		'modules/SSalesProcesses/models/Relation.php',
		'modules/SSingleOrders/models/Relation.php',
		'modules/Vendors/models/Relation.php',
		'modules/OSSMail/roundcube/Dockerfile',
		'modules/OSSMail/roundcube/vendor/patchwork/utf8/class/Patchwork/PHP/Shim/Xml.php',
		'modules/OSSMail/roundcube/vendor/patchwork/utf8/class/Patchwork/TurkishUtf8.php',
		'modules/OSSMail/roundcube/vendor/patchwork/utf8/class/Patchwork/Utf8.php',
		'modules/OSSMail/roundcube/vendor/patchwork/utf8/class/Patchwork/Utf8/BestFit.php',
		'modules/OSSMail/roundcube/vendor/patchwork/utf8/class/Patchwork/Utf8/WindowsStreamWrapper.php',
		'modules/OSSMail/roundcube/vendor/pear',
		'modules/OSSMail/roundcube/vendor/patchwork/utf8/class',
		'layouts/basic/modules/Project/charts/ShowTimeProject.tpl',
		'layouts/basic/modules/Project/charts/ShowTimeProjectEmployees.tpl',
		'config/modules/calendar.php',
	];

	function YetiForceUpdate($modulenode)
	{
		$this->modulenode = $modulenode;
	}

	function preupdate()
	{
		//$this->package->_errorText = 'Errot';
		return true;
	}

	function update()
	{
		$this->changeActivity();
		$this->deleteCustomView();
		$this->databaseSchema();
		$this->removeHandler(['Vtiger_SharedOwnerUpdater_Handler']);
		$this->enableTracking();
		$this->addCurrencies();
		$this->addTimeZone();
		$this->updateMailTemplate();
		$this->deleteWorkflow();
		$this->addWorkflows();
		$this->worflowEnityMethod();
		$this->addSalesProcessField();
		$this->databaseOtherData();
		$this->addActionMap();
		$this->setCustomize();
		$this->updateSettingsMenu();
		$this->updateSettingFieldsMenu();
		$this->addModules();
		$this->sharedOwner();
		$this->relations();
		$this->deleteLang();
		$this->addFieldsToScheme();
		$this->addFields();
		$this->addTree();
		$this->dataAccess($this->accessData(2));
		$this->dataAccess($this->accessData(3));
		$this->dataAccess($this->accessData(4));

		$this->updateMenu();
		$this->roundcubeConfig();
		$this->databaseNextChange();
		$this->dataAccess($this->accessData(0), true);
		$this->dataAccess($this->accessData(1), true);
		$this->linkProccess();

		$migration = new Migration();
		$migration->init();

		if ((int) $this->modulenode->remove_modules == 1) {
			$this->removeModules();
		} else {
			$this->reconfiguration();
		}
		$this->remove('OSSTimeControl', $this->removeFiedsData('OSSTimeControl'), 'deleteOtherFields');
		$this->databaseStepTwo();
	}

	function databaseStepTwo()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query("SELECT ossmailviewid FROM `vtiger_ossmailview_relation`;");
		$num = $result->rowCount();
		$result = $adb->query("SELECT DISTINCT `ossmailviewid`,`crmid` FROM `vtiger_ossmailview_relation`;");
		$num2 = $result->rowCount();
		if ($num == $num2) {
			$result = $adb->query("SHOW KEYS FROM `vtiger_ossmailview_relation` WHERE Key_name='ossmailviewid_2';");
			if ($result->rowCount() == 0) {
				$adb->query('ALTER TABLE `vtiger_ossmailview_relation` ADD UNIQUE KEY `ossmailviewid_2`(`ossmailviewid`,`crmid`) ; ');
			}
		}
		$adb->update('vtiger_relatedlists', ['actions' => 'SEND'], '`name` = ?', ['get_emails']);
		$relName = ['get_accounts_mail', 'get_contacts_mail', 'get_leads_mail', 'get_helpdesk_mail', 'get_project_mail', 'get_servicecontracts_mail', 'get_campaigns_mail', 'get_vendor_mail'];
		$adb->update('vtiger_relatedlists', ['name' => 'get_record2mails', 'actions' => 'ADD,SELECT'], '`name` IN (' . $adb->generateQuestionMarks($relName) . ')', $relName);
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_modtracker_basic` LIKE 'whodidsu';");
		if ($result->rowCount()) {
			$adb->query('ALTER TABLE `vtiger_modtracker_basic` DROP COLUMN `whodidsu` ;');
		}
		$adb->delete('vtiger_links', 'linklabel IN (?,?,?,?,?,?)', ['View History', 'LBL_CHECK_STATUS', 'Send SMS', 'LBL_ADD_NOTE', 'LBL_SHOW_ACCOUNT_HIERARCHY', 'OSSMailJS']);
		$adb->delete('vtiger_fieldmodulerel', 'module = ? AND relmodule <> ?', ['Calendar', 'Calendar']);
		$result = $adb->query('SELECT fieldtypeid FROM `vtiger_ws_fieldtype` WHERE `uitype` IN (66,67,68);');
		while ($typeId = $adb->getSingleValue($result)) {
			$adb->delete('vtiger_ws_referencetype', 'fieldtypeid = ?', [$typeId]);
		}
		$result = $adb->pquery('SELECT 1 FROM `com_vtiger_workflow_tasktypes` WHERE `classname` = ?;', ['VTUpdateWorkTime']);
		if (!$result->rowCount()) {
			$taskType = ['modules' => ["include" => ["OSSTimeControl"], "exclude" => []], 'name' => 'VTUpdateWorkTime', 'label' => 'LBL_UPDATE_WORK_TIME_AUTOMATICALLY', 'classname' => 'VTUpdateWorkTime', 'classpath' => 'modules/com_vtiger_workflow/tasks/VTUpdateWorkTime.inc', 'templatepath' => 'com_vtiger_workflow/taskforms/VTUpdateWorkTime.tpl', 'sourcemodule' => NULL];
			VTTaskType::registerTaskType($taskType);
		}
		$this->addHandler([['vtiger.entity.afterrestore', 'modules/OSSTimeControl/handlers/TimeControl.php', 'TimeControlHandler', '', 1, '[]']]);

		$result = $adb->pquery("SELECT templateid FROM vtiger_trees_templates WHERE module = ?;", [getTabid('Documents')]);
		if ($tempateId = $adb->getSingleValue($result)) {
			$result = $adb->pquery("SELECT 1 FROM vtiger_trees_templates_data WHERE templateid = ? AND `name` = ?;", [$tempateId, 'Mails']);
			if (!$result->rowCount()) {
				$sql = 'INSERT INTO vtiger_trees_templates_data(templateid, name, tree, parenttrre, depth, label, state) VALUES (?,?,?,?,?,?,?)';
				$params = [$tempateId, 'Mails', 'T2', 'T2', '0', 'Mails', ''];
				$adb->pquery($sql, $params);
			}
		}
		$adb->update('roundcube_system', ['value' => '2016011900'], '`name` = ?', ['roundcube-version']);
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_field` LIKE 'header_field';");
		if (!$result->rowCount()) {
			$adb->query('ALTER TABLE `vtiger_field` ADD COLUMN `header_field` varchar(15) NULL after `fieldparams` ;');
		}
		$dirName = 'modules/com_vtiger_workflow/tasks';
		if (file_exists('cache/updates/files/' . $dirName . '/VTUpdateWorkTime.inc')) {
			Vtiger_Functions::recurseCopy('cache/updates/files/' . $dirName, $dirName, true);
		}
		$this->addWorkflows(false);
		$adb->update('vtiger_relatedlists', ['presence' => '1'], '`tabid` = ? AND `label` IN (?,?,?,?,?,?)', [getTabid('SSalesProcesses'), 'Assets', 'OSSOutsourcedServices', 'OSSSoldServices', 'OutsourcedProducts', 'Products', 'Services']);
		$adb->update('vtiger_relatedlists', ['actions' => 'ADD,SELECT'], '`name` = ? ', ['get_record2mails']);
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_settings_blocks` LIKE 'type';");
		if (!$result->rowCount()) {
			$adb->query('ALTER TABLE `vtiger_settings_blocks` ADD COLUMN `type` tinyint(1)   NULL after `icon` , ADD COLUMN `linkto` text NULL after `type` ;');
			$blockid = $adb->getUniqueID('vtiger_settings_blocks');
			$adb->insert('vtiger_settings_blocks', ['blockid' => $blockid, 'label' => 'LBL_MENU_SUMMARRY', 'sequence' => '0', 'icon' => 'userIcon-Home2', 'type' => '1', 'linkto' => 'index.php?module=Vtiger&parent=Settings&view=Index']);
		}

		$this->rebuildCampaignRel();
		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_entity_stats` (
				`crmid` int(19) NOT NULL,
				`crmactivity` smallint(6) DEFAULT NULL,
				PRIMARY KEY (`crmid`),
				CONSTRAINT `fk_1_vtiger_entity_stats` FOREIGN KEY (`crmid`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->addCron([['LBL_CRMACTIVITY_DAYS', 'modules/Calendar/cron/SetCrmActivity.php', '86400', NULL, NULL, '1', 'Calendar', '16', '']]);
		$addHandler = [
			['vtiger.entity.unlink.after', 'modules/Calendar/handlers/CalendarHandler.php', 'CalendarHandler', '', 1, '[]'],
			['vtiger.entity.aftersave.final', 'modules/Calendar/handlers/CalendarHandler.php', 'CalendarHandler', '', 1, '[]'],
			['vtiger.entity.afterrestore', 'modules/Calendar/handlers/CalendarHandler.php', 'CalendarHandler', '', 1, '[]']
		];
		$this->addHandler($addHandler);
		$this->addFields($this->getFieldsTab());
		$this->fillColumn();
	}

	function fillColumn()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query('SELECT 1 FROM `vtiger_entity_stats`;');
		if (!$result->rowCount()) {
			$modules = ['Accounts', 'Contacts', 'Leads', 'Vendors', 'Partners', 'Competition', 'OSSEmployees', 'SSalesProcesses', 'Project', 'ServiceContracts', 'Campaigns', 'SQuoteEnquiries', 'SRequirementsCards', 'SCalculations', 'SQuotes', 'SSingleOrders', 'SRecurringOrders', 'HelpDesk'];
			$query = 'INSERT INTO `vtiger_entity_stats` (crmid) SELECT crmid FROM `vtiger_crmentity` WHERE setype IN (' . $adb->generateQuestionMarks($modules) . ');';
			$adb->pquery($query, $modules);
		}
	}

	function getFieldsTab()
	{
		global $log, $adb;
		$modules = ['Accounts', 'Contacts', 'Leads', 'Vendors', 'Partners', 'Competition', 'OSSEmployees', 'SSalesProcesses', 'Project', 'ServiceContracts', 'Campaigns', 'SQuoteEnquiries', 'SRequirementsCards', 'SCalculations', 'SQuotes', 'SSingleOrders', 'SRecurringOrders', 'HelpDesk'];
		$tabIds = [];
		foreach ($modules as $module) {
			$tabId = getTabid($module);
			if ($tabId) {
				$tabIds[] = $tabId;
			}
		}
		$result = $adb->pquery('SELECT * FROM vtiger_field WHERE columnname = ? AND tabid IN (' . $adb->generateQuestionMarks($tabIds) . ');', array_unshift($tabIds, 'modifiedtime') ? $tabIds : []);
		foreach ($adb->getArray($result) as $field) {
			$field['columnname'] = 'crmactivity';
			$field['uitype'] = '307';
			$field['tablename'] = 'vtiger_entity_stats';
			$field['fieldname'] = 'crmactivity';
			$field['fieldlabel'] = 'LBL_CRMACTIVITY';
			$field['presence'] = '0';
			$field['quickcreate'] = '1';
			$field['quickcreatesequence'] = null;
			$field['displaytype'] = '10';
			$field['typeofdata'] = 'NN~O';
			$field['columntype'] = 'smallint(6)';
			$field['blocklabel'] = $field['block'];
			unset($field['header_field']);
			$field = array_values($field);
			$field[] = [];
			$field[] = [];
			$setToCRM[$field[0]] = [$field];
		}
		$log->debug("Exiting YetiForceUpdate::getSmowneridTab() method ...");
		return $setToCRM;
	}

	public function addCron($addCrons = [])
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::addCron() method ...");
		if ($addCrons) {
			foreach ($addCrons as $cron) {
				$result = $adb->pquery("SELECT * FROM `vtiger_cron_task` WHERE name = ? AND handler_file = ?;", [$cron[0], $cron[1]]);
				if ($adb->getRowCount($result) == 0) {
					Vtiger_Cron::register($cron[0], $cron[1], $cron[2], $cron[6], $cron[5], 0, $cron[8]);
					$key = $this->getMax('vtiger_cron_task', 'sequence');
					$adb->pquery('UPDATE `vtiger_cron_task` SET `sequence` = ? WHERE name = ? AND handler_file = ?;', [$key, $cron[0], $cron[1]]);
				}
			}
		}
		$log->debug("Exiting YetiForceUpdate::addCron() method ...");
	}

	function rebuildCampaignRel()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query("SHOW TABLES LIKE 'vtiger_campaign_records';");
		if (!$adb->getRowCount($result)) {
			$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_campaign_records`(
				`campaignid` int(19) NOT NULL  DEFAULT 0 , 
				`crmid` int(19) NOT NULL  DEFAULT 0 , 
				`campaignrelstatusid` int(19) NOT NULL  DEFAULT 0 , 
				PRIMARY KEY (`campaignid`,`crmid`,`campaignrelstatusid`) , 
				KEY `campaigncontrel_contractid_idx`(`crmid`) , 
				CONSTRAINT `fk_vtiger_crmentity` 
				FOREIGN KEY (`crmid`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
			) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
			$copys = [
				'vtiger_campaigncontrel' => 'contactid',
				'vtiger_campaignleadrel' => 'leadid',
				'vtiger_campaignaccountrel' => 'accountid'
			];

			foreach ($copys as $table => $column) {
				$query = "INSERT INTO `vtiger_campaign_records` (campaignid, crmid, campaignrelstatusid) SELECT campaignid, $column, campaignrelstatusid FROM `$table` ;";
				$adb->query($query);
				$adb->query('DROP TABLE IF EXISTS ' . $table);
			}
		}
	}

	function addFieldsToScheme()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query("SHOW COLUMNS FROM `u_yf_competition` LIKE 'email';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `u_yf_competition` ADD COLUMN `email` varchar(50) NULL DEFAULT '';");
		}
		$result = $adb->query("SHOW COLUMNS FROM `u_yf_partners` LIKE 'email';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `u_yf_partners` ADD COLUMN `email` varchar(50) NULL DEFAULT '';");
		}
	}

	function linkProccess()
	{
		$adb = PearDatabase::getInstance();
		$adb->update('vtiger_ws_fieldtype', ['fieldtype' => 'referenceProcess'], 'uitype = ?', ['66']);
		$adb->update('vtiger_ws_fieldtype', ['fieldtype' => 'referenceLink'], 'uitype = ?', ['67']);
		$adb->update('vtiger_ws_fieldtype', ['fieldtype' => 'referenceSubProcess'], 'uitype = ?', ['68']);

		$result = $adb->query("SHOW KEYS FROM `vtiger_activity` WHERE Key_name='subprocess';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_activity` ADD KEY `subprocess`(`subprocess`);");
		}
		$result = $adb->query("SHOW KEYS FROM `vtiger_osstimecontrol` WHERE Key_name='subprocess';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_osstimecontrol` ADD KEY `subprocess`(`subprocess`), ADD KEY `link`(`link`), ADD KEY `process`(`process`);");
		}
		$adb->pquery("UPDATE vtiger_field SET `fieldlabel` = CASE "
			. " WHEN fieldlabel = 'Process' THEN 'FL_PROCESS' "
			. " WHEN fieldlabel = 'Relation' THEN 'FL_RELATION' "
			. " ELSE fieldlabel END WHERE columnname IN (?,?) AND tablename = ?", ['process', 'link', 'vtiger_activity']);
		$this->addRelations();
		$this->relatedSeq();
		$this->ChangedFieldOrder();
	}

	function ChangedFieldOrder()
	{
		$adb = PearDatabase::getInstance();
		$adb->update('vtiger_blocks', ['tabid' => getTabid('Calendar'), 'blocklabel' => 'LBL_RELATED_TO', 'sequence' => '3'], 'tabid = ? AND `blocklabel` = ?', [getTabid('Events'), 'LBL_CUSTOM_INFORMATION']);
		$adb->update('vtiger_blocks', ['sequence' => '4'], 'tabid = ? AND `blocklabel` = ?', [getTabid('Calendar'), 'LBL_CUSTOM_INFORMATION']);

		//'name','columnname','blocklabel','sequence','quickcreate','quickcreatesequence'
		$data = [
			['Calendar', 'smownerid', 'LBL_TASK_INFORMATION', '2', '0', '4'],
			['Calendar', 'date_start', 'LBL_TASK_INFORMATION', '3', '0', '2'],
			['Calendar', 'due_date', 'LBL_TASK_INFORMATION', '5', '1', '3'],
			['Calendar', 'process', 'LBL_RELATED_TO', '2', '2', '8'],
			['Calendar', 'link', 'LBL_RELATED_TO', '1', '2', '7'],
			['Calendar', 'status', 'LBL_TASK_INFORMATION', '9', '1', '2'],
			['Events', 'process', 'LBL_RELATED_TO', '2', '2', '10'],
			['Events', 'link', 'LBL_RELATED_TO', '1', '2', '9'],
			['Calendar', 'shownerid', 'LBL_TASK_INFORMATION', '5', '2', '6'],
			['Calendar', 'allday', 'LBL_TASK_INFORMATION', '26', '0', '5'],
			['Events', 'followup', 'LBL_RELATED_TO', '4', '1', NULL],
			['Calendar', 'followup', 'LBL_RELATED_TO', '4', '1', NULL],
			['Calendar', 'subprocess', 'LBL_RELATED_TO', '3', '1', NULL],
			['Events', 'subprocess', 'LBL_RELATED_TO', '3', '1', NULL]
		];
		$tabIds = [];
		$blockIds = ['Calendar' => [], 'Events' => []];
		foreach ($data as $row) {
			if (empty($tabIds[$row[0]])) {
				$tabIds[$row[0]] = getTabid($row[0]);
			}
			if (empty($blockIds[$row[0]][$row[2]])) {
				$result = $adb->pquery('SELECT blockid FROM `vtiger_blocks` WHERE `blocklabel` = ? AND `tabid` = ?;', [$row[2], $tabIds[$row[0]]]);
				$blockIds[$row[0]][$row[2]] = $adb->getSingleValue($result);
			}
			if ($blockIds[$row[0]][$row[2]] && $tabIds[$row[0]]) {
				$adb->update('vtiger_field', ['block' => $blockIds[$row[0]][$row[2]], 'sequence' => $row[3], 'quickcreate' => $row[4], 'quickcreatesequence' => $row[5]], '`tabid` = ? AND columnname = ?', [$tabIds[$row[0]], $row[1]]);
			}
		}
	}

	function addRelations()
	{
		$adb = PearDatabase::getInstance();
		//tabid(name),'name','label','presence','actions','sequence'
		$data['Calendar'] = [
			['Vendors', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['OSSEmployees', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['SSalesProcesses', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['SQuoteEnquiries', 'get_activities', 'Activities', '0', 'ADD', '3'],
			['SRequirementsCards', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['SCalculations', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['SQuotes', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['SSingleOrders', 'get_activities', 'Activities', '0', 'ADD', '1'],
			['SRecurringOrders', 'get_activities', 'Activities', '0', 'ADD', '1']
		];
		$dataInversely = [
			['Partners', 'OSSMailView', 'get_record2mails', 'Partners', '0', 'ADD,SELECT', '11'],
			['Competition', 'OSSMailView', 'get_record2mails', 'Competition', '0', 'ADD,SELECT', '12'],
			['OSSEmployees', 'OSSMailView', 'get_record2mails', 'OSSEmployees', '0', 'ADD,SELECT', '13'],
			['OSSMailView', 'OSSEmployees', 'get_emails', 'OSSMailView', '0', 'SEND', '8'],
			['SSalesProcesses', 'OSSMailView', 'get_record2mails', 'SSalesProcesses', '0', 'ADD,SELECT', '14'],
			['ProjectTask', 'OSSMailView', 'get_record2mails', 'ProjectTask', '0', 'ADD,SELECT', '15'],
			['OSSMailView', 'ProjectTask', 'get_emails', 'OSSMailView', '0', 'SEND', '3'],
			['ProjectMilestone', 'OSSMailView', 'get_record2mails', 'ProjectMilestone', '0', 'ADD,SELECT', '16'],
			['OSSMailView', 'ProjectMilestone', 'get_emails', 'OSSMailView', '0', 'SEND', '2'],
			['SQuoteEnquiries', 'OSSMailView', 'get_record2mails', 'SQuoteEnquiries', '0', 'ADD,SELECT', '17'],
			['SRequirementsCards', 'OSSMailView', 'get_record2mails', 'SRequirementsCards', '0', 'ADD,SELECT', '18'],
			['SCalculations', 'OSSMailView', 'get_record2mails', 'SCalculations', '0', 'ADD,SELECT', '19'],
			['SQuotes', 'OSSMailView', 'get_record2mails', 'SQuotes', '0', 'ADD,SELECT', '20'],
			['SSingleOrders', 'OSSMailView', 'get_record2mails', 'SSingleOrders', '0', 'ADD,SELECT', '21'],
			['SRecurringOrders', 'OSSMailView', 'get_record2mails', 'SRecurringOrders', '0', 'ADD,SELECT', '22']
		];
		foreach ($data as $relModule => $modulesRel) {
			$relInstance = Vtiger_Module::getInstance($relModule);
			foreach ($modulesRel as $values) {
				$targetModule = Vtiger_Module::getInstance($values[0]);
				$targetModule->setRelatedList($relInstance, $values[2], [$values[4]], $values[1]);
			}
		}
		foreach ($dataInversely as $values) {
			$relInstance = Vtiger_Module::getInstance($values[0]);
			$targetModule = Vtiger_Module::getInstance($values[1]);
			$targetModule->setRelatedList($relInstance, $values[3], [$values[4]], $values[2]);
		}
	}

	function relatedSeq()
	{
		$adb = PearDatabase::getInstance();
		$dataSeq = [];
		$dataSeq['Accounts'] = [
			['Contacts', '1'],
			['Calendar', '2'],
			['OSSMailView', '3'],
			['Documents', '4'],
			['HelpDesk', '5'],
			['Products', '12'],
			['Campaigns', '6'],
			['PBXManager', '7'],
			['ServiceContracts', '8'],
			['Services', '15'],
			['Assets', '13'],
			['Project', '9'],
			['OSSTimeControl', '10'],
			['OSSOutsourcedServices', '16'],
			['OSSSoldServices', '17'],
			['OutsourcedProducts', '14'],
			['OSSPasswords', '11'],
			['CallHistory', '18'],
			['PaymentsIn', '19'],
			['PaymentsOut', '20'],
			['LettersIn', '21'],
			['LettersOut', '22'],
			['Reservations', '23']
		];
		$dataSeq['Vendors'] = [
			['Products', '2'],
			['Contacts', '3'],
			['OSSMailView', '4'],
			['OSSPasswords', '6'],
			['CallHistory', '7'],
			['LettersOut', '9'],
			['LettersIn', '10'],
			['Reservations', '8'],
			['HelpDesk', '11'],
			['Project', '12'],
			['PaymentsIn', '13'],
			['PaymentsOut', '14'],
			['Documents', '5'],
			['Calendar', '1']
		];
		$dataSeq['Campaigns'] = [
			['Leads', '2'],
			['Calendar', '1'],
			['Accounts', '3'],
			['OSSMailView', '4']
		];
		$dataSeq['OSSEmployees'] = [
			['Documents', '2'],
			['OSSTimeControl', '3'],
			['CallHistory', '4'],
			['LettersOut', '6'],
			['LettersIn', '7'],
			['HolidaysEntitlement', '5'],
			['Calendar', '1']
		];
		$dataSeq['Project'] = [
			['ProjectTask', '2'],
			['ProjectMilestone', '3'],
			['Documents', '4'],
			['HelpDesk', '5'],
			[0, '1'],
			['OSSTimeControl', '6'],
			['OSSMailView', '7'],
			['Calendar', '1'],
			['Reservations', '8'],
			['Contacts', '9']
		];
		$dataSeq['SSalesProcesses'] = [
			['Documents', '2'],
			['OSSMailView', '3'],
			['SRequirementsCards', '5'],
			['SQuoteEnquiries', '4'],
			['SCalculations', '6'],
			['SQuotes', '7'],
			['SSingleOrders', '8'],
			['SRecurringOrders', '9'],
			['Products', '10'],
			['OutsourcedProducts', '11'],
			['Assets', '12'],
			['Services', '13'],
			['OSSOutsourcedServices', '14'],
			['OSSSoldServices', '15'],
			['Calendar', '1']
		];

		foreach ($dataSeq as $module => $relSeq) {
			$query = 'UPDATE vtiger_relatedlists SET sequence = CASE ';
			$tabId = getTabid($module);
			foreach ($relSeq as $relModuleSeq) {
				$relTabId = is_string($relModuleSeq[0]) ? getTabid($relModuleSeq[0]) : $relModuleSeq[0];
				$query .= ' WHEN tabid="' . $tabId . '" AND related_tabid = ' . $relTabId . ' THEN ' . $relModuleSeq[1];
			}
			$query .=' ELSE sequence END ';
			$query .= ' WHERE tabid = ?';
			$adb->pquery($query, [$tabId]);
		}
	}

	function remove($moduleName, $data, $action)
	{
		$log = vglobal('log');
		$log->debug(__CLASS__ . '::' . __METHOD__ . ' (' . $moduleName . ',' . print_r($data, true) . ',' . $action . ')| Start');
		$instance = new RemoveModule($moduleName);
		$instance->init($data);
		$instance->$action();
		$log->debug(__CLASS__ . '::' . __METHOD__ . ' | END');
	}

	function removeFiedsData($index)
	{
		$modules = [
			'OSSTimeControl' => [
				'removeFields' => ['vtiger_osstimecontrol' => ['accountid', 'ticketid', 'projectid', 'projecttaskid', 'servicecontractsid', 'assetsid', 'leadid', 'quoteid', 'salesorderid', 'potentialid', 'calculationsid', 'quotesenquiresid', 'requirementcardsid']]
			]
		];
		return $modules[$index];
	}

	function accessData($index)
	{
		$data = [];
		$data[0] = [
			'base' => ['Accounts', 'Check for duplicates', 'a:1:{i:0;a:2:{s:2:"cf";b:0;s:2:"an";s:24:"Accounts!!unique_account";}}'],
			'cnd' => [
				['11', 'accountname', 'is not empty', '', '1', 'string']
			]
		];
		$data[1] = [
			'base' => ['Leads', 'Check for duplicates', 'a:1:{i:0;a:8:{s:2:"an";s:20:"Vtiger!!unique_value";s:5:"what1";s:6:"vat_id";s:6:"where1";a:2:{i:0;s:23:"vtiger_account=vat_id=6";i:1;s:27:"vtiger_leaddetails=vat_id=7";}s:5:"info0";s:0:"";s:5:"info1";s:0:"";s:5:"info2";s:0:"";s:8:"locksave";s:1:"3";s:2:"cf";b:1;}}'],
			'cnd' => [
				['12', 'vat_id', 'is not empty', '', '1', 'string']
			]
		];
		$data[2] = [
			'base' => ['Calendar', 'Adding time period to status change']
		];
		$data[3] = [
			'base' => ['Events', 'Adding time period to status change']
		];
		$data[4] = [
			'base' => ['Accounts', 'Check for duplicate names']
		];
		return $data[$index];
	}

	function reconfiguration()
	{
		$adb = PearDatabase::getInstance();
		$modules = ['Calculations', 'RequirementCards', 'QuotesEnquires', 'SalesOrder', 'Quotes', 'OSSPdf', 'OSSCosts', 'PurchaseOrder', 'Invoice', 'Potentials'];
		foreach ($modules as $moduleName) {
			$result = $adb->pquery('SELECT presence FROM vtiger_tab WHERE `name` = ?', [$moduleName]);
			if ($adb->getRowCount($result) && !($presence = $adb->getSingleValue($result))) {
				vtlib_toggleModuleAccess($moduleName, false);
				//$this->deleteIcons($moduleName);
				//$this->deleteLanguagesForModule($moduleName);
				//$this->deleteDir($moduleName);
			}
		}
	}

	/**
	 * Function to remove files related to a module
	 */
	public function deleteDir($moduleName)
	{
		$log = vglobal('log');
		$log->debug(__CLASS__ . '::' . __METHOD__ . ' ()| Start');
		$modulePath = 'modules/' . $moduleName;
		Vtiger_Functions::recurseDelete($modulePath);
		foreach (self::getAllLayouts() as $name => $label) {
			$layoutPath = 'layouts/' . $name . '/modules/' . $moduleName;
			Vtiger_Functions::recurseDelete($layoutPath);
		}
		$log->debug(__CLASS__ . '::' . __METHOD__ . ' | END');
	}

	public static function getAllLayouts()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery('SELECT name,label FROM vtiger_layout');
		$folders = [
			'basic' => vtranslate('LBL_DEFAULT')
		];
		while ($row = $adb->fetch_array($result)) {
			$folders[$row['name']] = vtranslate($row['label']);
		}
		return $folders;
	}

	/**
	 * Function to remove language files related to a module
	 */
	function deleteLanguagesForModule($moduleName)
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query('SELECT prefix FROM vtiger_language');
		while ($lang = $adb->getSingleValue($result)) {
			$langFilePath = "languages/$lang/" . $moduleName . ".php";
			if (file_exists($langFilePath))
				@unlink($langFilePath);
		}
	}

	/**
	 * Function to remove icons related to a module
	 */
	public function deleteIcons($moduleName)
	{
		$log = vglobal('log');
		$log->debug(__CLASS__ . '::' . __METHOD__ . ' ()| Start');
		$iconSize = ['', 48, 64, 128];
		foreach ($iconSize as $value) {
			foreach (self::getAllLayouts() as $name => $label) {
				$fileName = "layouts/$name/skins/images/" . $moduleName . $value . ".png";
				if (file_exists($fileName)) {
					@unlink($fileName);
				}
			}
		}
		$log->debug(__CLASS__ . '::' . __METHOD__ . ' | END');
	}

	function removeModules()
	{
		$modules = [
			'Calculations' => [
				'removeFields' => ['vtiger_inventoryproductrel' => ['calculationsid'], 'vtiger_potential' => ['sum_time_k', 'sum_calculations']],
				'tableList' => ['vtiger_calculationsproductrel'],
				'links' => ['index.php?module=Calculations&view=ShowWidget&name=Calculations']
			],
			'RequirementCards' => [
				'removeFields' => ['vtiger_osstimecontrol' => ['requirementcardsid']],
			],
			'QuotesEnquires' => [
			],
			'SalesOrder' => [
				'removeFields' => ['vtiger_potential' => ['sum_time_so', 'sum_salesorders', 'average_profit_so'], 'vtiger_account' => ['average_profit_so', 'sum_salesorders']],
				'tableList' => ['vtiger_invoice_recurring_info', 'vtiger_salesorderaddress', 'vtiger_sostatushistory'],
				'handlers' => ['RecurringInvoiceHandler']
			],
			'Quotes' => [
				'removeFields' => ['vtiger_potential' => ['sum_time_q', 'sum_quotes'], 'vtiger_purchaseorder' => ['quoteid']],
				'tableList' => ['vtiger_quotesaddress', 'vtiger_quotestagehistory']
			],
			'OSSPdf' => [
				'tableList' => ['vtiger_osspd', 'vtiger_osspdf_constraints', 'vtiger_osspdf_config'],
				'links' => ['layouts/_layoutName_/modules/OSSPdf/resources/PDFUtils.js', 'layouts/vlayout/modules/OSSPdf/resources/PDFUtils.js', 'like' => 'module=OSSPdf']
			],
			'OSSCosts' => [
				'tableList' => ['vtiger_osscosts_config'],
				'links' => []
			],
			'PurchaseOrder' => [
				'removeFields' => ['vtiger_invoice' => ['purchaseorder']],
				'tableList' => ['vtiger_purchaseorderaddress', 'vtiger_postatushistory'],
				'links' => []
			],
			'Invoice' => [
				'removeFields' => ['vtiger_potential' => ['sum_invoices'], 'vtiger_account' => ['sum_invoices'], 'vtiger_osssoldservices' => ['invoiceid']],
				'tableList' => ['vtiger_invoiceaddress', 'vtiger_invoicestatushistory', 'vtiger_invoicestatushistory_seq'],
				'links' => ['index.php?module=Potentials&view=ShowWidget&name=PipelinedAmountPerSalesPerson', 'index.php?module=Potentials&view=ShowWidget&name=FunnelAmount'],
				'workflows' => ['PaymentsIn' => 'PaymentsIn - UpdateBalance', 'PaymentsOut' => 'PaymentsOut - UpdateBalance'],
				'workflowsMethod' => ['UpdateBalance'],
				'handlers' => ['PotentialsHandler', 'AccountsHandler']
			],
			'Potentials' => [
				'removeFields' => ['vtiger_assets' => ['pot_renewal', 'potential'], 'vtiger_osssoldservices' => ['pot_renewal', 'potential'], 'vtiger_convertleadmapping' => ['potentialfid'], 'vtiger_ossoutsourcedservices' => ['potential'], 'vtiger_outsourcedproducts' => ['potential']],
				'tableList' => ['vtiger_contpotentialrel', 'vtiger_potstagehistory', 'vtiger_potentialscf'],
				'links' => ['like' => 'index.php?module=Potentials'],
				'widgets' => ['PotentialsList']
			]
		];
		foreach ($modules as $module => $valueMap) {
			$instance = new RemoveModule($module);
			$instance->init($valueMap);
			$instance->delete();
		}
	}

	function postupdate()
	{
		global $log, $adb;
		$menuRecordModel = new Settings_Menu_Record_Model();
		$menuRecordModel->refreshMenuFiles();
		$this->updateFiles();
		$dirName = 'cache/updates';
		$result = true;
		Vtiger_Deprecated::createModuleMetaFile();
		Vtiger_Access::syncSharingAccess();
		$adb->query('SET FOREIGN_KEY_CHECKS = 1;');
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$adb->query("INSERT INTO `yetiforce_updates` (`user`, `name`, `from_version`, `to_version`, `result`) VALUES ('" . $currentUser->get('user_name') . "', '" . $this->modulenode->label . "', '" . $this->modulenode->from_version . "', '" . $this->modulenode->to_version . "','" . $result . "');", true);
		$adb->query("UPDATE vtiger_version SET `current_version` = '" . $this->modulenode->to_version . "';");
		Vtiger_Functions::recurseDelete($dirName . '/files');
		Vtiger_Functions::recurseDelete($dirName . '/init.php');
		Vtiger_Functions::recurseDelete('cache/templates_c');
		$this->removeFolder(['layouts/vlayout', 'libraries/mPDF/examples']);
		header('Location: ' . vglobal('site_URL'));
		exit;
		return true;
	}

	function dataAccess($data, $add = false)
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery("SELECT dataaccessid FROM vtiger_dataaccess WHERE module_name = ? AND `summary` = ?;", [$data['base'][0], $data['base'][1]]);
		$id = $adb->getSingleValue($result);
		if ($id && !$add) {
			$adb->delete('vtiger_dataaccess_cnd', 'dataaccessid = ?', [$id]);
			$adb->delete('vtiger_dataaccess', 'dataaccessid = ?', [$id]);
		} elseif (!$id && $add) {
			$adb->pquery('INSERT INTO vtiger_dataaccess (module_name,summary,data) VALUES(?, ?, ?)', $data['base']);
			$id = $adb->getLastInsertID();
			foreach ($data['cnd'] as $values) {
				$values[0] = $id;
				$adb->pquery('INSERT INTO vtiger_dataaccess_cnd (dataaccessid,fieldname,comparator,val,required,field_type) VALUES(?, ?, ?, ?, ?, ?)', $values);
			}
		}
	}

	function databaseNextChange()
	{
		$adb = PearDatabase::getInstance();
		$adb->update('vtiger_relatedlists', ['creator_detail' => 0, 'relation_comment' => 1], '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?)', [getTabid('SSalesProcesses'), getTabid('OSSSoldServices'),
			getTabid('SSalesProcesses'), getTabid('OSSOutsourcedServices'),
			getTabid('SSalesProcesses'), getTabid('Assets'),
			getTabid('SSalesProcesses'), getTabid('OutsourcedProducts'),
			getTabid('Accounts'), getTabid('OSSOutsourcedServices'),
			getTabid('Accounts'), getTabid('OSSSoldServices'),
			getTabid('Accounts'), getTabid('OutsourcedProducts'),
			getTabid('Leads'), getTabid('OSSOutsourcedServices'),
			getTabid('Leads'), getTabid('OutsourcedProducts'),
			getTabid('Accounts'), getTabid('Assets')
		]);
		$adb->update('vtiger_relatedlists', ['creator_detail' => 1, 'relation_comment' => 1], '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?) OR '
			. '(`tabid` = ? AND related_tabid = ?)', [getTabid('Accounts'), getTabid('Services'),
			getTabid('Accounts'), getTabid('Products'),
			getTabid('Leads'), getTabid('Products'),
			getTabid('SSalesProcesses'), getTabid('Products')]);

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_modentity_num` LIKE 'postfix';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_modentity_num` ADD COLUMN `postfix` varchar(50) NOT NULL after `prefix` ;");
		}
		$adb->update('vtiger_modentity_num', ['prefix' => 'PR'], 'semodule = ? AND `prefix` = ?', ['Partners', 'P']);
		$adb->update('vtiger_modentity_num', ['prefix' => 'CMP'], 'semodule = ? AND `prefix` = ?', ['Competition', 'P']);
		$adb->update('vtiger_modentity_num', ['prefix' => 'S-RO'], 'semodule = ? AND `prefix` = ?', ['SRecurringOrders', 'S-SO']);

		$result = $adb->pquery("SELECT 1 FROM vtiger_widgets WHERE tabid = ?;", [getTabid('SSalesProcesses')]);
		if (!$adb->getRowCount($result)) {
			$this->addWidget('SSalesProcesses');
		}

		$result = $adb->query("SHOW KEYS FROM `vtiger_osstimecontrol` WHERE Key_name='osstimecontrol_status_8';");
		if ($result->rowCount()) {
			$adb->query("ALTER TABLE `vtiger_osstimecontrol` DROP KEY `osstimecontrol_status_8`;");
		}
		$result = $adb->query("SHOW KEYS FROM `vtiger_osstimecontrol` WHERE Key_name='osstimecontrol_status_7';");
		if ($result->rowCount()) {
			$adb->query("ALTER TABLE `vtiger_osstimecontrol` DROP KEY `osstimecontrol_status_7`;");
		}
		$result = $adb->query("SHOW KEYS FROM `vtiger_osstimecontrol` WHERE Key_name='osstimecontrol_status_5';");
		if ($result->rowCount()) {
			$adb->query("ALTER TABLE `vtiger_osstimecontrol` DROP KEY `osstimecontrol_status_5`,DROP KEY `osstimecontrol_status_4`,DROP KEY `osstimecontrol_status_3`,DROP KEY `osstimecontrol_status_2`,DROP KEY `osstimecontrol_status`;");
		}

		$adb->pquery("UPDATE vtiger_field SET `fieldlabel` = ? WHERE columnname = ? AND tablename IN (?,?,?,?) AND `fieldlabel` = ?;", ['FL_TOTAL_TIME_H', 'sum_time', 'vtiger_account', 'vtiger_assets', 'vtiger_projecttask', 'vtiger_troubletickets', 'Total time [h]']);

		$moduleInstance = Vtiger_Module::getInstance('OSSTimeControl');
		$targetModule = Vtiger_Module::getInstance('Vendors');
		$targetModule->setRelatedList($moduleInstance, 'OSSTimeControl', ['ADD'], 'get_dependents_list');
		$moduleInstance = Vtiger_Module::getInstance('OSSTimeControl');
		$targetModule = Vtiger_Module::getInstance('Partners');
		$targetModule->setRelatedList($moduleInstance, 'OSSTimeControl', ['ADD'], 'get_dependents_list');
		$moduleInstance = Vtiger_Module::getInstance('OSSTimeControl');
		$targetModule = Vtiger_Module::getInstance('Competition');
		$targetModule->setRelatedList($moduleInstance, 'OSSTimeControl', ['ADD'], 'get_dependents_list');

		$modcommentsModuleInstance = Vtiger_Module::getInstance('ModComments');
		if ($modcommentsModuleInstance && file_exists('modules/ModComments/ModComments.php')) {
			include_once 'modules/ModComments/ModComments.php';
			if (class_exists('ModComments'))
				ModComments::addWidgetTo(array('Vendors'));
		}

		ModTracker::enableTrackingForModule(Vtiger_Functions::getModuleId('Vendors'));
		$result = $adb->pquery("SELECT 1 FROM vtiger_widgets WHERE tabid = ?;", [getTabid('Vendors')]);
		if (!$adb->getRowCount($result)) {
			$this->addWidget('Vendors');
		}

		$moduleInstance = Vtiger_Module::getInstance('Contacts');
		$targetModule = Vtiger_Module::getInstance('Partners');
		$targetModule->setRelatedList($moduleInstance, 'Contacts', ['ADD'], 'get_dependents_list');
		$targetModule = Vtiger_Module::getInstance('Competition');
		$targetModule->setRelatedList($moduleInstance, 'Contacts', ['ADD'], 'get_dependents_list');
		$targetModule = Vtiger_Module::getInstance('SSalesProcesses');
		$targetModule->setRelatedList($moduleInstance, 'Contacts', ['ADD,SELECT'], 'get_related_list');

		$result1 = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ?", ['parentid', 'vtiger_contactdetails']);
		$result2 = $adb->pquery("SELECT * FROM `vtiger_fieldmodulerel` WHERE fieldid = ? AND relmodule = ?", [$adb->query_result($result1, 0, 'fieldid'), 'Partners']);
		if ($adb->getRowCount($result2) == 0) {
			$adb->query("insert  into `vtiger_fieldmodulerel`(`fieldid`,`module`,`relmodule`) values (" . $adb->query_result($result1, 0, 'fieldid') . ",'Contacts','Partners');");
		}
		$result2 = $adb->pquery("SELECT * FROM `vtiger_fieldmodulerel` WHERE fieldid = ? AND relmodule = ?", [$adb->query_result($result1, 0, 'fieldid'), 'Competition']);
		if ($adb->getRowCount($result2) == 0) {
			$adb->query("insert  into `vtiger_fieldmodulerel`(`fieldid`,`module`,`relmodule`) values (" . $adb->query_result($result1, 0, 'fieldid') . ",'Contacts','Competition');");
		}
		$widgets = [];
		$widgets['SSalesProcesses'] = [['100', 'SSalesProcesses', 'RelatedModule', 'Contacts', '1', '5', NULL, '{"limit":"5","relatedmodule":"' . getTabid('Contacts') . '","columns":"1","action":"1","actionSelect":"1","filter":"-","checkbox_selected":"","checkbox":"-"}']];
		$widgets['Partners'] = [['101', 'Partners', 'RelatedModule', 'Contacts', '1', '5', NULL, '{"limit":"5","relatedmodule":"' . getTabid('Contacts') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}']];
		$widgets['Competition'] = [['101', 'Competition', 'RelatedModule', 'Contacts', '1', '5', NULL, '{"limit":"5","relatedmodule":"' . getTabid('Contacts') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}']];
		foreach ($widgets as $widgetMod) {
			foreach ($widgetMod as $widget) {
				$result = $adb->pquery("SELECT 1 FROM vtiger_widgets WHERE tabid = ? AND `type` = ? AND `label` = ?;", [getTabid($widget[1]), $widget[2], $widget[3]]);
				if (!$adb->getRowCount($result)) {
					$sql = "INSERT INTO vtiger_widgets (tabid, type, label, wcol, sequence, nomargin, data) VALUES (?, ?, ?, ?, ?, ?, ?);";
					$adb->pquery($sql, [ getTabid($widget[1]), $widget[2], $widget[3], $widget[4], $widget[5], $widget[6], $widget[7]]);
				}
			}
		}
		$fields = ['osstimecontrol_no', 'osssoldservices_no', 'ossemployees_no', 'ideas_no', 'holidaysentitlement_no', 'neworders_no', 'squoteenquiries_no', 'ssalesprocesses_no', 'srequirementscards_no', 'scalculations_no', 'squotes_no', 'ssingleorders_no', 'srecurringorders_no', 'partners_no', 'competition_no'];
		$adb->pquery('UPDATE vtiger_field SET `displaytype` = 2 WHERE fieldname IN (' . $adb->generateQuestionMarks($fields) . ') AND `displaytype` = 3', $fields);
		$adb->pquery('UPDATE vtiger_field SET `displaytype` = 1 WHERE fieldname = ? AND `displaytype` = 3', ['reservations_no']);
		$adb->delete('vtiger_cvcolumnlist', '`columnname` IN (?,?,?) ', ['vtiger_osstimecontrol:osstimecontrol_no:osstimecontrol_no:OSSTimeControl_No.:V', 'vtiger_ideas:ideas_no:ideas_no:Ideas_LBL_NO:V', 'u_yf_squoteenquiries:salesprocessid:salesprocessid:SQuoteEnquiries_SINGLE_SSalesProcesses:V']);
		$adb->query('DROP TABLE IF EXISTS vtiger_email_access');
		$adb->query('DROP TABLE IF EXISTS vtiger_email_track');
		$columns = ['vtiger_outsourcedproducts:potential:potential:OutsourcedProducts_Potentials:V',
			'vtiger_assets:potential:potential:Assets_Potential:V',
			'vtiger_assets:potential renewal:Potential renewal:Assets_Potential_renewal:V',
			'vtiger_ossoutsourcedservices:potential:potential:OSSOutsourcedServices_Potentials:V',
			'vtiger_osssoldservices:potential:potential:OSSSoldServices_Potential:V'];
		$adb->delete('vtiger_cvcolumnlist', '`columnname` IN (' . $adb->generateQuestionMarks($columns) . ') ', $columns);
	}

	function addTree()
	{
		$adb = PearDatabase::getInstance();
		$tabId = getTabid('Assets');
		$result = $adb->pquery("SELECT templateid FROM vtiger_trees_templates WHERE module IN (?);", [$tabId]);
		if (!$adb->getRowCount($result)) {
			$templateid = (int) $adb->getSingleValue($result);
			$sql = 'INSERT INTO vtiger_trees_templates(`name`, `module`, `access`) VALUES (?,?,?)';
			$adb->pquery($sql, ['Category', $tabId, 1]);
			$newtempateId = $adb->getLastInsertID();
			$sql = 'INSERT INTO vtiger_trees_templates_data(templateid, name, tree, parenttrre, depth, label, state) VALUES (?,?,?,?,?,?,?)';
			$params = [$newtempateId, 'None', 'T1', 'T1', '0', 'None', ''];
			$adb->pquery($sql, $params);
			$adb->pquery('UPDATE `vtiger_field` SET `fieldparams` = ? WHERE `tabid` = ? AND columnname = ?;', [$newtempateId, $tabId, 'pscategory']);
		}
	}

	function removeFolder($srcs)
	{
		$rootDir = vglobal('root_directory');
		foreach ($srcs as $src) {
			$dir = $rootDir . $src;
			if (file_exists($dir)) {
				$folder = scandir($dir);
				$folder = is_array($folder) ? $folder : [];
				$key = array_search('.', $folder);
				$key2 = array_search('..', $folder);
				unset($folder[$key]);
				unset($folder[$key2]);
				if (empty($folder)) {
					rmdir($dir);
				}
			}
		}
	}

	function deleteLang()
	{
		Settings_LangManagement_Module_Model::delete(['prefix' => 'nl_nl']);
	}

	function relations()
	{
		$adb = PearDatabase::getInstance();
		$moduleInstance = Vtiger_Module::getInstance('PaymentsOut');
		$targetModule = Vtiger_Module::getInstance('Vendors');
		$targetModule->setRelatedList($moduleInstance, 'PaymentsOut', ['add'], 'get_dependents_list');
		$result1 = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ?", ['relatedid', 'vtiger_paymentsout']);
		$result2 = $adb->pquery("SELECT * FROM `vtiger_fieldmodulerel` WHERE fieldid = ? AND relmodule = ?", [$adb->query_result($result1, 0, 'fieldid'), 'Vendors']);
		if ($adb->getRowCount($result2) == 0) {
			$adb->query("insert  into `vtiger_fieldmodulerel`(`fieldid`,`module`,`relmodule`) values (" . $adb->query_result($result1, 0, 'fieldid') . ",'PaymentsOut','Vendors');");
		}

		$moduleInstance = Vtiger_Module::getInstance('PaymentsIn');
		$targetModule = Vtiger_Module::getInstance('Vendors');
		$targetModule->setRelatedList($moduleInstance, 'PaymentsIn', ['add'], 'get_dependents_list');
		$result1 = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ?", ['relatedid', 'vtiger_paymentsin']);
		$result2 = $adb->pquery("SELECT * FROM `vtiger_fieldmodulerel` WHERE fieldid = ? AND relmodule = ?", [$adb->query_result($result1, 0, 'fieldid'), 'Vendors']);
		if ($adb->getRowCount($result2) == 0) {
			$adb->query("insert  into `vtiger_fieldmodulerel`(`fieldid`,`module`,`relmodule`) values (" . $adb->query_result($result1, 0, 'fieldid') . ",'PaymentsIn','Vendors');");
		}

		$moduleInstance = Vtiger_Module::getInstance('Documents');
		$targetModule = Vtiger_Module::getInstance('Vendors');
		$targetModule->setRelatedList($moduleInstance, 'Documents', ['add', 'select'], 'get_attachments');
	}

	public function sharedOwner()
	{
		global $log;
		$log->debug("Entering YetiForceUpdate::sharedOwner() method ...");
		$adb = PearDatabase::getInstance();
		$currentUser = Users_Record_Model::getCurrentUserModel();

		$result = $adb->query("SHOW TABLES LIKE 'u_yf_crmentity_showners';");
		if (!$adb->getRowCount($result)) {
			$adb->query("CREATE TABLE IF NOT EXISTS `u_yf_crmentity_showners`(
				`crmid` int(19) NULL  , 
				`userid` int(19) NULL  , 
				UNIQUE KEY `mix`(`crmid`,`userid`) , 
				KEY `crmid`(`crmid`) , 
				KEY `userid`(`userid`) , 
				CONSTRAINT `fk_u_yf_crmentity_showners` 
				FOREIGN KEY (`crmid`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
			) ENGINE=InnoDB DEFAULT CHARSET='utf8' ;");

			$assignedToValues = [];
			$assignedToValues[] = $currentUser->getAccessibleUsers();
			$assignedToValues[] = $currentUser->getAccessibleGroups();

			$result = $adb->query("SHOW TABLES LIKE '%_showners';");
			if ($adb->getRowCount($result) > 1) {
				while ($row = $adb->fetch_array($result)) {
					if ('u_yf_crmentity_showners' != current($row)) {
						$query = "INSERT INTO u_yf_crmentity_showners (crmid, userid) SELECT crmid, userid FROM " . current($row) . ";";
						$adb->query($query);
						$adb->query('DROP TABLE IF EXISTS ' . current($row) . ';');
					}
				}
			} else {
				$result = $adb->pquery("SELECT `setype`, `crmid`, `shownerid` FROM vtiger_crmentity WHERE `setype` IN (SELECT DISTINCT `name` FROM vtiger_tab INNER JOIN vtiger_field ON vtiger_tab.tabid = vtiger_field.tabid WHERE uitype = 120) AND `shownerid` NOT IN ('', '0')");
				while ($row = $adb->fetch_array($result)) {
					$userIds = explode(',', $row['shownerid']);
					foreach ($userIds as $userId) {
						foreach ($assignedToValues as $accessibleIds) {
							if (array_key_exists($userId, $accessibleIds)) {
								$adb->insert('u_yf_crmentity_showners', [
									'crmid' => $row['crmid'],
									'userid' => $userId,
								]);
								break;
							}
						}
					}
				}
			}
			$adb->query("UPDATE `vtiger_crmentity` SET `shownerid` = '0';");
		}
		$adb->query('ALTER TABLE `vtiger_crmentity` CHANGE `shownerid` `shownerid` tinyint(1)   NULL after `smownerid` ;');
		$log->debug("Exiting YetiForceUpdate::sharedOwner() method ...");
	}

	public function addModules()
	{
		global $log;
		$log->debug("Entering YetiForceUpdate::addModules() method ...");
		$adb = PearDatabase::getInstance();
		$rootDir = vglobal('root_directory');
		$dirName = 'cache/updates/files/';
		$modules = ['SSalesProcesses', 'SQuoteEnquiries', 'SRequirementsCards', 'SCalculations', 'SQuotes', 'SSingleOrders', 'SRecurringOrders', 'Partners', 'Competition'];
		foreach ($modules as $module) {
			try {
				if (file_exists('cache/updates/' . $module . '.xml') && !Vtiger_Module::getInstance($module)) {
					$locations = ['modules/' . $module];
					foreach ($locations as $loc) {
						if (is_dir($dirName . $loc) && !file_exists($rootDir . $loc)) {
							mkdir($rootDir . $loc);
						}
						Vtiger_Functions::recurseCopy($dirName . $loc, $loc, true);
						Vtiger_Functions::recurseDelete($dirName . $loc);
					}

					$importInstance = new Vtiger_PackageImport();
					$importInstance->_modulexml = simplexml_load_file('cache/updates/' . $module . '.xml');
					$importInstance->import_Module();
					unlink('cache/updates/' . $module . '.xml');
					if (!in_array($module, ['SSalesProcesses', 'Partners', 'Competition'])) {
						$adb->update('vtiger_tab', ['type' => 1], '`name` = ?', [$module]);
						$this->setPicklistValues($module);
						$this->addWorkflowToNewModule($module);
						$this->addInventoryData($module);
					}
					$this->addWidget($module);
				}
			} catch (Exception $e) {
				$log->fatal("ERROR YetiForceUpdate::addModules(" . $e->getMessage() . ") method ...");
			}
		}
		$this->addTimeFieldsToScheme();
		$adb->update('vtiger_tab', ['customized' => 0], '`name` IN (' . $adb->generateQuestionMarks($modules) . ')', $modules);
		$log->debug("Exiting YetiForceUpdate::addModules() method ...");
	}

	public function addTimeFieldsToScheme()
	{
		$adb = PearDatabase::getInstance();
		$tables = ['u_yf_competition', 'u_yf_partners', 'u_yf_scalculations', 'u_yf_squoteenquiries', 'u_yf_squotes', 'u_yf_srecurringorders', 'u_yf_srequirementscards', 'u_yf_ssalesprocesses', 'u_yf_ssingleorders', 'vtiger_campaign', 'vtiger_contactdetails', 'vtiger_leaddetails', 'vtiger_ossemployees', 'vtiger_projectmilestone', 'vtiger_vendor'];
		foreach ($tables as $table) {
			$result = $adb->query("SHOW COLUMNS FROM `$table` LIKE 'sum_time';");
			if (!$result->rowCount()) {
				$adb->query("ALTER TABLE `$table` ADD COLUMN `sum_time` decimal(10,2) NULL DEFAULT 0.00;");
			}
		}
	}

	public function addInventoryData($module)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' (' . $module . ') method ...');
		$data = [];
		$data['SCalculations'] = [['1', 'name', 'LBL_ITEM_NAME', 'Name', '0', '', '1', '1', '0', '{"modules":["Products","Services"],"limit":" "}', '1'],
			['2', 'qty', 'LBL_QUANTITY', 'Quantity', '0', '1', '2', '1', '0', '{}', '1'],
			['4', 'comment1', 'LBL_COMMENT', 'Comment', '0', '', '3', '2', '0', '{}', '0']];
		$data['SQuoteEnquiries'] = [['1', 'name', 'LBL_ITEM_NAME', 'Name', '0', '', '1', '1', '0', '{"modules":["Products","Services"],"limit":" "}', '1'],
			['2', 'qty', 'LBL_QUANTITY', 'Quantity', '0', '1', '2', '1', '0', '{}', '1'],
			['4', 'comment1', 'LBL_COMMENT', 'Comment', '0', '', '3', '2', '0', '{}', '0']];
		$data['SRequirementsCards'] = [['1', 'name', 'LBL_ITEM_NAME', 'Name', '0', '', '1', '1', '0', '{"modules":["Products","Services"],"limit":" "}', '1'],
			['2', 'qty', 'LBL_QUANTITY', 'Quantity', '0', '1', '2', '1', '0', '{}', '1'],
			['4', 'comment1', 'LBL_COMMENT', 'Comment', '0', '', '3', '2', '0', '{}', '0']];
		$data['SQuotes'] = [['1', 'name', 'LBL_ITEM_NAME', 'Name', '0', '', '1', '1', '0', '{"modules":["Products","Services"],"limit":" "}', '1'],
			['2', 'qty', 'LBL_QUANTITY', 'Quantity', '0', '1', '2', '1', '0', '{}', '1'],
			['3', 'discount', 'LBL_DISCOUNT', 'Discount', '0', '0', '3', '1', '0', '{}', '1'],
			['4', 'marginp', 'LBL_MARGIN_PERCENT', 'MarginP', '0', '0', '4', '1', '0', '{}', '1'],
			['5', 'margin', 'LBL_MARGIN', 'Margin', '0', '0', '5', '1', '0', '{}', '1'],
			['6', 'comment1', 'LBL_COMMENT', 'Comment', '0', '', '6', '2', '0', '{}', '0']];
		$data['SRecurringOrders'] = [['1', 'name', 'LBL_ITEM_NAME', 'Name', '0', '', '1', '1', '0', '{"modules":["Products","Services"],"limit":" "}', '1'],
			['2', 'qty', 'LBL_QUANTITY', 'Quantity', '0', '1', '2', '1', '0', '{}', '1'],
			['3', 'discount', 'LBL_DISCOUNT', 'Discount', '0', '0', '3', '1', '0', '{}', '1'],
			['4', 'marginp', 'LBL_MARGIN_PERCENT', 'MarginP', '0', '0', '4', '1', '0', '{}', '1'],
			['5', 'margin', 'LBL_MARGIN', 'Margin', '0', '0', '5', '1', '0', '{}', '1'],
			['6', 'tax', 'LBL_TAX', 'Tax', '0', '0', '6', '1', '0', '{}', '1'],
			['7', 'comment1', 'LBL_COMMENT', 'Comment', '0', '', '7', '2', '0', '{}', '0']];
		$data['SSingleOrders'] = [['1', 'name', 'LBL_ITEM_NAME', 'Name', '0', '', '1', '1', '0', '{"modules":["Products","Services"],"limit":" "}', '1'],
			['2', 'qty', 'LBL_QUANTITY', 'Quantity', '0', '1', '2', '1', '0', '{}', '1'],
			['3', 'discount', 'LBL_DISCOUNT', 'Discount', '0', '0', '3', '1', '0', '{}', '1'],
			['4', 'marginp', 'LBL_MARGIN_PERCENT', 'MarginP', '0', '0', '4', '1', '0', '{}', '1'],
			['5', 'margin', 'LBL_MARGIN', 'Margin', '0', '0', '5', '1', '0', '{}', '1'],
			['6', 'tax', 'LBL_TAX', 'Tax', '0', '0', '6', '1', '0', '{}', '1'],
			['7', 'comment1', 'LBL_COMMENT', 'Comment', '0', '', '7', '2', '0', '{}', '0']];

		$colums = ['id', 'columnname', 'label', 'invtype', 'presence', 'defaultValue', 'sequence', 'block', 'displayType', 'params', 'colSpan'];
		$inventoryField = Vtiger_InventoryField_Model::getInstance($module);
		if ($inventoryField && $data[$module]) {
			foreach ($data[$module] as $param) {
				$inventoryField->addField($param[3], array_combine($colums, $param));
			}
		}

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addWidget($module)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' (' . $module . ') method ...');
		$adb = PearDatabase::getInstance();
		$widgets = [];
		$widgets['SQuoteEnquiries'] = [['55', 'SQuoteEnquiries', 'Summary', NULL, '1', '0', NULL, '[]'],
			['56', 'SQuoteEnquiries', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}'],
			['57', 'SQuoteEnquiries', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['58', 'SQuoteEnquiries', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['59', 'SQuoteEnquiries', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]']];
		$widgets['SRequirementsCards'] = [['60', 'SRequirementsCards', 'Summary', NULL, '1', '0', NULL, '[]'],
			['61', 'SRequirementsCards', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}'],
			['62', 'SRequirementsCards', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['63', 'SRequirementsCards', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['64', 'SRequirementsCards', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]']];
		$widgets['SCalculations'] = [['65', 'SCalculations', 'Summary', NULL, '1', '0', NULL, '[]'],
			['66', 'SCalculations', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['67', 'SCalculations', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['68', 'SCalculations', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['69', 'SCalculations', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];
		$widgets['SQuotes'] = [['70', 'SQuotes', 'Summary', NULL, '1', '0', NULL, '[]'],
			['71', 'SQuotes', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['72', 'SQuotes', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['73', 'SQuotes', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['74', 'SQuotes', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];
		$widgets['SSingleOrders'] = [['75', 'SSingleOrders', 'Summary', NULL, '1', '0', NULL, '[]'],
			['76', 'SSingleOrders', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['77', 'SSingleOrders', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['78', 'SSingleOrders', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['79', 'SSingleOrders', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];
		$widgets['SSalesProcesses'] = [['75', 'SSalesProcesses', 'Summary', NULL, '1', '0', NULL, '[]'],
			['76', 'SSalesProcesses', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['77', 'SSalesProcesses', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['78', 'SSalesProcesses', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['79', 'SSalesProcesses', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];
		$widgets['Partners'] = [['75', 'Partners', 'Summary', NULL, '1', '0', NULL, '[]'],
			['76', 'Partners', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['77', 'Partners', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['78', 'Partners', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['79', 'Partners', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];
		$widgets['Competition'] = [['75', 'Competition', 'Summary', NULL, '1', '0', NULL, '[]'],
			['76', 'Competition', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['77', 'Competition', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['78', 'Competition', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['79', 'Competition', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];
		$widgets['Vendors'] = [['75', 'Vendors', 'Summary', NULL, '1', '0', NULL, '[]'],
			['76', 'Vendors', 'Updates', 'LBL_UPDATES', '1', '1', NULL, '[]'],
			['77', 'Vendors', 'Comments', 'ModComments', '2', '2', NULL, '{"relatedmodule":"ModComments","limit":"5"}'],
			['78', 'Vendors', 'RelatedModule', 'Documents', '2', '3', NULL, '{"limit":"","relatedmodule":"' . getTabid('Documents') . '","columns":"3","action":"1","filter":"-","checkbox_selected":"","checkbox":"-"}'], ['79', 'Vendors', 'EmailList', 'Emails', '2', '4', NULL, '{"relatedmodule":"Emails","limit":"5"}']];

		if ($widgets[$module]) {
			foreach ($widgets[$module] as $widget) {
				$sql = "INSERT INTO vtiger_widgets (tabid, type, label, wcol, sequence, nomargin, data) VALUES (?, ?, ?, ?, ?, ?, ?);";
				$adb->pquery($sql, [ getTabid($widget[1]), $widget[2], $widget[3], $widget[4], $widget[5], $widget[6], $widget[7]]);
			}
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addWorkflowToNewModule($module)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' (' . $module . ') method ...');
		$workflow = [];
		$workflow['SQuoteEnquiries'] = ['63', 'SQuoteEnquiries', 'Block edition', '[{"fieldname":"squoteenquiries_status","operation":"is","value":"PLL_DISCARDED","valuetype":"rawtext","joincondition":"or","groupjoin":null,"groupid":"1"},{"fieldname":"squoteenquiries_status","operation":"is","value":"PLL_ACCEPTED","valuetype":"rawtext","joincondition":"","groupjoin":null,"groupid":"1"}]', '9', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];
		$workflow['SRequirementsCards'] = ['64', 'SRequirementsCards', 'Block edition', '[{"fieldname":"srequirementscards_status","operation":"is","value":"PLL_DISCARDED","valuetype":"rawtext","joincondition":"or","groupjoin":null,"groupid":"1"},{"fieldname":"srequirementscards_status","operation":"is","value":"PLL_ACCEPTED","valuetype":"rawtext","joincondition":"","groupjoin":null,"groupid":"1"}]', '9', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];
		$workflow['SCalculations'] = ['65', 'SCalculations', 'Block edition', '[{"fieldname":"scalculations_status","operation":"is","value":"PLL_DISCARDED","valuetype":"rawtext","joincondition":"or","groupjoin":null,"groupid":"1"},{"fieldname":"scalculations_status","operation":"is","value":"PLL_ACCEPTED","valuetype":"rawtext","joincondition":"","groupjoin":null,"groupid":"1"}]', '9', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];
		$workflow['SQuotes'] = ['66', 'SQuotes', 'Block edition', '[{"fieldname":"squotes_status","operation":"is","value":"PLL_DISCARDED","valuetype":"rawtext","joincondition":"or","groupjoin":null,"groupid":"1"},{"fieldname":"squotes_status","operation":"is","value":"PLL_ACCEPTED","valuetype":"rawtext","joincondition":"","groupjoin":null,"groupid":"1"}]', '9', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];
		$workflow['SSingleOrders'] = ['67', 'SSingleOrders', 'Block edition', '[{"fieldname":"ssingleorders_status","operation":"is","value":"PLL_UNREALIZED","valuetype":"rawtext","joincondition":"or","groupjoin":null,"groupid":"1"},{"fieldname":"ssingleorders_status","operation":"is","value":"PLL_REALIZED","valuetype":"rawtext","joincondition":"","groupjoin":null,"groupid":"1"}]', '9', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];
		$workflow['SRecurringOrders'] = ['68', 'SRecurringOrders', 'Block edition', '[{"fieldname":"srecurringorders_status","operation":"is","value":"PLL_UNREALIZED","valuetype":"rawtext","joincondition":"or","groupjoin":null,"groupid":"1"},{"fieldname":"srecurringorders_status","operation":"is","value":"PLL_REALIZED","valuetype":"rawtext","joincondition":"","groupjoin":null,"groupid":"1"}]', '9', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];

		$this->saveWorflows([$workflow[$module]]);
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function setPicklistValues($module)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . '(' . $module . ') method ...');
		$adb = PearDatabase::getInstance();
		$values = ['ssingleorders_status' => ['PLL_DRAFT', 'PLL_REQUIRES_TO_BE_COMPLEMENTED', 'PLL_REQUIRES_CONSULTATION', 'PLL_WAITING_FOR_SHIPPING', 'PLL_WAITING_FOR_SIGNATURE', 'PLL_WAITING_FOR_REALIZATION', 'PLL_IN_REALIZATION', 'PLL_UNREALIZED', 'PLL_REALIZED'],
			'squoteenquiries_status' => ['PLL_DRAFT', 'PLL_REQUIRES_TO_BE_COMPLEMENTED', 'PLL_REQUIRES_CONSULTATION', 'PLL_WAITING_FOR_APPROVAL', 'PLL_DISCARDED', 'PLL_ACCEPTED'],
			'scalculations_status' => ['PLL_DRAFT', 'PLL_REQUIRES_TO_BE_COMPLEMENTED', 'PLL_REQUIRES_CONSULTATION', 'PLL_WAITING_FOR_APPROVAL', 'PLL_DISCARDED', 'PLL_ACCEPTED'],
			'squotes_status' => ['PLL_DRAFT', 'PLL_REQUIRES_TO_BE_COMPLEMENTED', 'PLL_REQUIRES_CONSULTATION', 'PLL_WAITING_FOR_SHIPPING', 'PLL_WAITING_FOR_SIGNATURE', 'PLL_DISCARDED', 'PLL_ACCEPTED'],
			'srecurringorders_status' => ['PLL_DRAFT', 'PLL_REQUIRES_TO_BE_COMPLEMENTED', 'PLL_REQUIRES_CONSULTATION', 'PLL_WAITING_FOR_SHIPPING', 'PLL_WAITING_FOR_SIGNATURE', 'PLL_WAITING_FOR_REALIZATION', 'PLL_AUTOMATIC_GENERATION', 'PLL_UNREALIZED', 'PLL_REALIZED'],
			'srequirementscards_status' => ['PLL_DRAFT', 'PLL_REQUIRES_TO_BE_COMPLEMENTED', 'PLL_REQUIRES_CONSULTATION', 'PLL_WAITING_FOR_APPROVAL', 'PLL_DISCARDED', 'PLL_ACCEPTED']
		];
		$name = strtolower($module) . '_status';
		$moduleModel = Vtiger_Module_Model::getInstance($module);
		if ($moduleModel && $values[$name]) {
			$fieldModel = Vtiger_Field_Model::getInstance($name, $moduleModel);
			if ($fieldModel) {
				$fieldModel->setPicklistValues($values[$name]);
				$adb->update('vtiger_' . $name, ['presence' => 0], '`' . $name . '` IN (?,?,?,?,?)', ['PLL_ACCEPTED', 'PLL_DISCARDED', 'PLL_AUTOMATIC_GENERATION', 'PLL_UNREALIZED', 'PLL_REALIZED']);
			}
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addActionMap()
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::addActionMap() method ...");
		$adb = PearDatabase::getInstance();
		$actions = ['ExportPdf', 'PrintMail', 'RecordMapping', 'RecordMappingList', 'OpenRecord', 'CloseRecord', 'DuplicatesHandling', 'FavoriteRecords'];
		foreach ($actions as $action) {
			$result = $adb->pquery('SELECT actionid FROM vtiger_actionmapping WHERE actionname=?;', [$action]);
			if ($adb->getRowCount($result) && 'DuplicatesHandling' != $action) {
				continue;
			}
			if ('DuplicatesHandling' != $action) {
				$securitycheck = 0;
				$key = $this->getMax('vtiger_actionmapping', 'actionid');
				$adb->pquery("INSERT INTO `vtiger_actionmapping` (`actionid`, `actionname`, `securitycheck`) VALUES (?, ?, ?);", [$key, $action, $securitycheck]);
			} else {
				$key = $adb->getSingleValue($result);
			}
			if (in_array($action, ['OpenRecord', 'CloseRecord'])) {
				continue;
			}
			$permission = 0;
			if (in_array($action, ['RecordMapping', 'RecordMappingList'])) {
				$modules = Settings_Vtiger_CustomRecordNumberingModule_Model::getSupportedModules();
				unset($modules[getTabid('OSSMailView')]);
				$sql = "SELECT tabid, `name`  FROM `vtiger_tab` WHERE tabid IN (" . implode(',', array_keys($modules)) . ");";
			} elseif ($action == 'PrintMail') {
				$sql = "SELECT tabid, `name`  FROM `vtiger_tab` WHERE `isentitytype` = '1' AND `name` = 'OSSMailView';";
			} elseif ($action == 'DuplicatesHandling') {
				$permission = 1;
				$sql = "SELECT tabid, `name`  FROM `vtiger_tab` WHERE `isentitytype` = '1' AND `name` = 'OSSTimeControl';";
			} else {
				$sql = "SELECT tabid, `name`  FROM `vtiger_tab` WHERE `isentitytype` = '1' AND `name` NOT IN ('SMSNotifier','ModComments','PBXManager','Events','Emails','CallHistory','OSSMailView','');";
			}
			$result = $adb->query($sql);
			$rowCount = $adb->getRowCount($result);

			$resultP = $adb->query("SELECT profileid FROM vtiger_profile;");
			$rowCountP = $adb->getRowCount($resultP);
			for ($i = 0; $i < $rowCountP; $i++) {
				$profileId = $adb->query_result_raw($resultP, $i, 'profileid');
				for ($k = 0; $k < $rowCount; $k++) {
					$row = $adb->query_result_rowdata($result, $k);
					$tabid = $row['tabid'];
					$resultC = $adb->pquery("SELECT activityid FROM vtiger_profile2utility WHERE profileid=? AND tabid=? AND activityid=? ;", [$profileId, $tabid, $key]);
					if ($adb->num_rows($resultC) == 0) {
						$adb->pquery("INSERT INTO vtiger_profile2utility (profileid, tabid, activityid, permission) VALUES  (?, ?, ?, ?)", [$profileId, $tabid, $key, $permission]);
					}
				}
			}
		}
		$log->debug("Exiting YetiForceUpdate::addActionMap() method ...");
	}

	public function databaseOtherData()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery("SELECT * FROM `vtiger_settings_field` WHERE `name` = ? ", ['LBL_PDF']);
		if (!$adb->num_rows($result)) {
			$blockid = $adb->query_result($adb->pquery("SELECT blockid FROM vtiger_settings_blocks WHERE label='LBL_OTHER_SETTINGS'", []), 0, 'blockid');
			$sequence = (int) $adb->query_result($adb->pquery("SELECT max(sequence) as sequence FROM vtiger_settings_field WHERE blockid=?", [$blockid]), 0, 'sequence') + 1;
			$fieldid = $adb->getUniqueId('vtiger_settings_field');
			$adb->pquery("INSERT INTO vtiger_settings_field (fieldid,blockid,sequence,name,iconpath,description,linkto)
			VALUES (?,?,?,?,?,?,?)", [$fieldid, $blockid, $sequence, 'LBL_PDF', '', 'LBL_PDF_DESCRIPTION', 'index.php?module=PDF&parent=Settings&view=List']);
		}
		$adb->pquery("UPDATE vtiger_links SET `linkurl` = CASE "
			. " WHEN linklabel = 'Chat' THEN 'layouts/_layoutName_/modules/AJAXChat/Chat.js' "
			. " WHEN linklabel = 'PDFUtils' THEN 'layouts/_layoutName_/modules/OSSPdf/resources/PDFUtils.js' "
			. " WHEN linklabel = 'OSSMailJScheckmails' THEN 'layouts/_layoutName_/modules/OSSMail/resources/checkmails.js' "
			. " ELSE linkurl END WHERE linklabel IN (?,?,?) ", ['Chat', 'PDFUtils', 'OSSMailJScheckmails']);

		$result = $adb->pquery('SELECT * FROM `vtiger_ws_fieldtype` WHERE fieldtype = ?;', ['streetAddress']);
		if (!$adb->getRowCount($result)) {
			$key = $this->getMax('vtiger_ws_fieldtype', 'fieldtypeid');
			$adb->pquery('insert  into `vtiger_ws_fieldtype`(`fieldtypeid`,`uitype`,`fieldtype`) values (?,?,?);', [$key, '306', 'streetAddress']);
		}

		$result = $adb->query('SELECT panellogoname,organization_id FROM `vtiger_organizationdetails`');
		while ($row = $adb->fetch_array($result)) {
			if (empty($row['panellogoname'])) {
				$adb->update('vtiger_organizationdetails', ['panellogoname' => 'white_logo_yetiforce.png'], '`organization_id` = ?', [$row['organization_id']]);
			}
		}

		$adb->update('vtiger_field', ['fieldlabel' => 'LBL_MENU_EXPANDED_BY_DEFAULT'], '`columnname` = ?', ['leftpanelhide']);

		$adb->update('com_vtiger_workflow_tasktypes', ['modules' => '{"include":["Accounts","Leads","Contacts","HelpDesk","Campaigns","Project","ServiceContracts","Vendors","Partners","Competition","OSSEmployees","SSalesProcesses","SQuoteEnquiries","SRequirementsCards","SCalculations","SQuotes","SSingleOrders","SRecurringOrders"],"exclude":["Calendar","FAQ","Events"]}'], '`tasktypename` IN (?,?)', ['VTCreateEventTask', 'VTCreateTodoTask']);
		$adb->update('com_vtiger_workflow_tasktypes', ['modules' => '{"include":["Accounts","Contacts","Leads","OSSEmployees","Vendors","Campaigns","HelpDesk","Project","ServiceContracts"],"exclude":["Calendar","FAQ","Events"]}'], '`tasktypename` IN (?)', ['VTUpdateCalendarDates']);
		$adb->delete('vtiger_mobile_alerts', '`handler_class` = ? ', ['Mobile_WS_AlertModel_PotentialsDueIn5Days']);
		$adb->delete('vtiger_ossmailscanner_config', '`conf_type` = ? ', ['folders']);

		$adb->update('vtiger_field', ['displaytype' => '1'], '`columnname` IN (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) AND uitype = ? ', ['osstimecontrol_no', 'osssoldservices_no', 'ideas_no', 'ossemployees_no', 'holidaysentitlement_no', 'neworders_no', 'squoteenquiries_no', 'ssalesprocesses_no', 'srequirementscards_no', 'scalculations_no', 'squotes_no', 'ssingleorders_no', 'srecurringorders_no', 'partners_no', 'competition_no', '4']);
		$result = $adb->query('SELECT COUNT(1) AS `count` FROM `u_yf_github`;');
		if (!$adb->getRowCount($result)) {
			$adb->insert('u_yf_github', ['client_id' => '', 'token' => '', 'username' => '']);
		}

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function updateMenu()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$columns = ['id', 'parentid', 'type', 'sequence', 'module', 'label', 'icon'];
		$menu = [
			['44', '0', '2', '0', NULL, 'MEN_VIRTUAL_DESK', 'userIcon-VirtualDesk'],
			['45', '44', '0', '0', 'Home', 'Home page', 'userIcon-Home2'],
			['46', '44', '0', '1', 'Calendar', NULL, ''],
			['47', '0', '2', '1', NULL, 'MEN_COMPANIES_CONTACTS', 'userIcon-CompainesAndContacts'],
			['48', '47', '0', '0', 'Leads', NULL, ''],
			['49', '47', '0', '5', 'Contacts', NULL, ''],
			['50', '47', '0', '3', 'Vendors', NULL, ''],
			['51', '47', '0', '1', 'Accounts', NULL, ''],
			['52', '0', '2', '2', NULL, 'MEN_MARKETING', 'userIcon-Sales'],
			['54', '52', '0', '0', 'Campaigns', NULL, ''],
			['62', '118', '0', '7', 'PriceBooks', NULL, ''],
			['63', '0', '2', '5', NULL, 'MEN_SUPPORT', 'userIcon-Support'],
			['64', '63', '0', '0', 'HelpDesk', NULL, ''],
			['65', '63', '0', '1', 'ServiceContracts', NULL, ''],
			['66', '63', '0', '2', 'Faq', NULL, ''],
			['67', '0', '2', '4', NULL, 'MEN_PROJECTS', 'userIcon-Projects2'],
			['68', '67', '0', '0', 'Project', NULL, ''],
			['69', '67', '0', '1', 'ProjectMilestone', NULL, ''],
			['70', '67', '0', '2', 'ProjectTask', NULL, ''],
			['71', '0', '2', '6', NULL, 'MEN_BOOKKEEPING', 'userIcon-BookKeeping'],
			['72', '71', '0', '1', 'PaymentsIn', NULL, ''],
			['73', '71', '0', '0', 'PaymentsOut', NULL, ''],
			['76', '0', '2', '7', NULL, 'MEN_HUMAN_RESOURCES', 'userIcon-HumanResources'],
			['77', '76', '0', '0', 'OSSEmployees', NULL, ''],
			['78', '76', '0', '1', 'OSSTimeControl', NULL, ''],
			['79', '76', '0', '2', 'HolidaysEntitlement', NULL, ''],
			['80', '0', '2', '8', NULL, 'MEN_SECRETARY', 'userIcon-Secretary'],
			['81', '80', '0', '0', 'LettersIn', NULL, ''],
			['82', '80', '0', '1', 'LettersOut', NULL, ''],
			['83', '80', '0', '2', 'Reservations', NULL, ''],
			['84', '0', '2', '9', NULL, 'MEN_DATABESES', 'userIcon-Database'],
			['85', '84', '2', '0', NULL, 'MEN_PRODUCTBASE', NULL],
			['86', '84', '0', '1', 'Products', NULL, ''],
			['87', '84', '0', '2', 'OutsourcedProducts', NULL, ''],
			['88', '84', '0', '3', 'Assets', NULL, ''],
			['89', '84', '3', '4', NULL, NULL, NULL],
			['90', '84', '2', '5', NULL, 'MEN_SERVICESBASE', NULL],
			['91', '84', '0', '6', 'Services', NULL, ''],
			['92', '84', '0', '7', 'OSSOutsourcedServices', NULL, ''],
			['93', '84', '0', '8', 'OSSSoldServices', NULL, ''],
			['94', '84', '3', '9', NULL, NULL, NULL],
			['95', '84', '2', '10', NULL, 'MEN_LISTS', NULL],
			['96', '84', '0', '11', 'OSSMailView', NULL, ''],
			['97', '84', '0', '12', 'SMSNotifier', NULL, ''],
			['98', '84', '0', '13', 'PBXManager', NULL, ''],
			['99', '84', '0', '14', 'OSSMailTemplates', NULL, ''],
			['100', '84', '0', '15', 'Documents', NULL, ''],
			['106', '84', '0', '17', 'CallHistory', NULL, ''],
			['107', '84', '3', '18', NULL, NULL, NULL],
			['108', '84', '0', '23', 'NewOrders', NULL, ''],
			['109', '84', '0', '16', 'OSSPasswords', NULL, ''],
			['111', '44', '0', '3', 'Ideas', NULL, ''],
			['113', '44', '0', '2', 'OSSMail', NULL, ''],
			['114', '84', '0', '22', 'Reports', NULL, ''],
			['115', '84', '0', '19', 'Rss', NULL, ''],
			['116', '84', '0', '20', 'Portal', NULL, ''],
			['117', '84', '3', '21', NULL, NULL, NULL],
			['118', '0', '2', '3', NULL, 'MEN_SALES', 'userIcon-Potentials'],
			['119', '118', '0', '0', 'SSalesProcesses', NULL, ''],
			['120', '118', '0', '1', 'SQuoteEnquiries', NULL, ''],
			['121', '118', '0', '2', 'SRequirementsCards', NULL, ''],
			['122', '118', '0', '3', 'SCalculations', NULL, ''],
			['123', '118', '0', '4', 'SQuotes', NULL, ''],
			['124', '118', '0', '5', 'SSingleOrders', NULL, ''],
			['125', '118', '0', '6', 'SRecurringOrders', NULL, ''],
			['126', '47', '0', '2', 'Partners', NULL, ''],
			['127', '47', '0', '4', 'Competition', NULL, '']
		];
		$adb->delete('yetiforce_menu', '`role` = ? ', [0]);
		$parents = [];
		foreach ($menu as $row) {
			$parent = $row[1] != 0 ? $parents[$row[1]] : 0;
			$module = $row[2] == 0 ? getTabid($row[4]) : $row[4];
			if ($row[2] == 0 && !vtlib_isModuleActive($row[4])) {
				continue;
			}
			$result = $adb->insert('yetiforce_menu', ['role' => 0, 'parentid' => $parent, 'type' => $row[2], 'sequence' => $row[3], 'module' => $module, 'label' => $row[5], 'icon' => $row[6]]);
			if (is_array($result) && $row[1] == 0) {
				$parents[$row[0]] = $result['id'];
			}
		}

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function updateSettingsMenu()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$settingMenu = [['1', 'LBL_USER_MANAGEMENT', '1', 'adminIcon-permissions'],
			['2', 'LBL_STUDIO', '2', 'adminIcon-standard-modules'],
			['3', 'LBL_COMPANY', '12', 'adminIcon-company-information'],
			['4', 'LBL_SYSTEM_TOOLS', '11', 'adminIcon-system-tools'],
			['5', 'LBL_INTEGRATION', '8', 'adminIcon-integration'],
			['6', 'LBL_PROCESSES', '13', 'adminIcon-processes'],
			['7', 'LBL_SECURITY_MANAGEMENT', '6', 'adminIcon-security'],
			['8', 'LBL_MAIL_TOOLS', '10', 'adminIcon-mail-tools'],
			['9', 'LBL_About_YetiForce', '26', 'adminIcon-about-yetiforce'],
			['11', 'LBL_ADVANCED_MODULES', '3', 'adminIcon-advenced-modules'],
			['12', 'LBL_CALENDAR_LABELS_COLORS', '4', 'adminIcon-calendar-labels-colors'],
			['13', 'LBL_SEARCH_AND_FILTERS', '5', 'adminIcon-search-and-filtres'],
			['14', 'LBL_LOGS', '7', 'adminIcon-logs'],
			['15', 'LBL_AUTOMATION', '9', 'adminIcon-automation']];

		$removeSettingsMenu = ['LBL_OTHER_SETTINGS', 'LBL_MAIL', 'LBL_CUSTOMIZE_TRANSLATIONS', 'LBL_EXTENDED_MODULES'];
		$adb->delete('vtiger_settings_blocks', '`label` IN (?,?,?,?) ', $removeSettingsMenu);

		foreach ($settingMenu as $row) {
			$result = $adb->pquery('SELECT 1 FROM vtiger_settings_blocks WHERE label = ?', [$row[1]]);
			if ($result->rowCount() > 0) {
				$adb->update('vtiger_settings_blocks', ['sequence' => $row[2], 'icon' => $row[3]], '`label` = ?', [$row[1]]);
			} else {
				$blockid = $adb->getUniqueID('vtiger_settings_blocks');
				$adb->insert('vtiger_settings_blocks', ['blockid' => $blockid, 'label' => $row[1], 'sequence' => $row[2], 'icon' => $row[3]]);
			}
		}

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function updateSettingFieldsMenu()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();

		$menu = [
			['LBL_USER_MANAGEMENT', 'LBL_USERS', 'adminIcon-user', 'LBL_USER_DESCRIPTION', 'index.php?module=Users&parent=Settings&view=List', '1', '0', '1'],
			['LBL_USER_MANAGEMENT', 'LBL_ROLES', 'adminIcon-roles', 'LBL_ROLE_DESCRIPTION', 'index.php?module=Roles&parent=Settings&view=Index', '2', '0', '0'],
			['LBL_USER_MANAGEMENT', 'LBL_PROFILES', 'adminIcon-profiles', 'LBL_PROFILE_DESCRIPTION', 'index.php?module=Profiles&parent=Settings&view=List', '3', '0', '0'],
			['LBL_USER_MANAGEMENT', 'USERGROUPLIST', 'adminIcon-groups', 'LBL_GROUP_DESCRIPTION', 'index.php?module=Groups&parent=Settings&view=List', '4', '0', '0'],
			['LBL_USER_MANAGEMENT', 'LBL_SHARING_ACCESS', 'adminIcon-module-access', 'LBL_SHARING_ACCESS_DESCRIPTION', 'index.php?module=SharingAccess&parent=Settings&view=Index', '5', '0', '0'],
			['LBL_USER_MANAGEMENT', 'LBL_FIELDS_ACCESS', 'adminIcon-special-access', 'LBL_SHARING_FIELDS_DESCRIPTION', 'index.php?module=FieldAccess&parent=Settings&view=Index', '6', '0', '0'],
			['LBL_USER_MANAGEMENT', 'GlobalPermission', 'adminIcon-special-access', 'LBL_GLOBALPERMISSION_DESCRIPTION', 'index.php?module=GlobalPermission&parent=Settings&view=Index', '7', '0', '0'],
			['LBL_USER_MANAGEMENT', 'LBL_LOCKS', '', 'LBL_LOCKS_DESCRIPTION', 'index.php?module=Users&view=Locks&parent=Settings', '8', '0', '0'],
			['LBL_STUDIO', 'VTLIB_LBL_MODULE_MANAGER', 'adminIcon-modules-installation', 'VTLIB_LBL_MODULE_MANAGER_DESCRIPTION', 'index.php?module=ModuleManager&parent=Settings&view=List', '1', '0', '1'],
			['LBL_STUDIO', 'LBL_PICKLIST_EDITOR', 'adminIcon-fields-picklists', 'LBL_PICKLIST_DESCRIPTION', 'index.php?parent=Settings&module=Picklist&view=Index', '9', '0', '1'],
			['LBL_STUDIO', 'LBL_PICKLIST_DEPENDENCY_SETUP', 'adminIcon-fields-picklists-relations', 'LBL_PICKLIST_DEPENDENCY_DESCRIPTION', 'index.php?parent=Settings&module=PickListDependency&view=List', '10', '0', '0'],
			['LBL_STUDIO', 'LBL_CUSTOMIZE_RECORD_NUMBERING', 'adminIcon-recording-control', 'LBL_CUSTOMIZE_MODENT_NUMBER_DESCRIPTION', 'index.php?module=Vtiger&parent=Settings&view=CustomRecordNumbering', '6', '0', '0'],
			['LBL_STUDIO', 'LBL_EDIT_FIELDS', 'adminIcon-modules-fields', 'LBL_LAYOUT_EDITOR_DESCRIPTION', 'index.php?module=LayoutEditor&parent=Settings&view=Index', '2', '0', '0'],
			['LBL_STUDIO', 'LBL_MENU_BUILDER', 'adminIcon-menu-configuration', 'LBL_MENU_BUILDER_DESCRIPTION', 'index.php?module=Menu&view=Index&parent=Settings', '14', '0', '1'],
			['LBL_STUDIO', 'LBL_ARRANGE_RELATED_TABS', 'adminIcon-modules-relations', 'LBL_ARRANGE_RELATED_TABS', 'index.php?module=LayoutEditor&parent=Settings&view=Index&mode=showRelatedListLayout', '4', '0', '1'],
			['LBL_STUDIO', 'Widgets', 'adminIcon-modules-widgets', 'LBL_WIDGETS_DESCRIPTION', 'index.php?module=Widgets&parent=Settings&view=Index', '3', '0', '1'],
			['LBL_STUDIO', 'LBL_QUICK_CREATE_EDITOR', 'adminIcon-fields-quick-create', 'LBL_QUICK_CREATE_EDITOR_DESCRIPTION', 'index.php?module=QuickCreateEditor&parent=Settings&view=Index', '8', '0', '0'],
			['LBL_STUDIO', 'LBL_WIDGETS_MANAGEMENT', 'adminIcon-widgets-configuration', 'LBL_WIDGETS_MANAGEMENT_DESCRIPTION', 'index.php?module=WidgetsManagement&parent=Settings&view=Configuration', '15', '0', '0'],
			['LBL_STUDIO', 'LBL_TREES_MANAGER', 'adminIcon-field-folders', 'LBL_TREES_MANAGER_DESCRIPTION', 'index.php?module=TreesManager&parent=Settings&view=List', '11', '0', '0'],
			['LBL_STUDIO', 'LBL_MODTRACKER_SETTINGS', 'adminIcon-modules-track-chanegs', 'LBL_MODTRACKER_SETTINGS_DESCRIPTION', 'index.php?module=ModTracker&parent=Settings&view=List', '5', '0', '0'],
			['LBL_STUDIO', 'LBL_HIDEBLOCKS', 'adminIcon-filed-hide-bloks', 'LBL_HIDEBLOCKS_DESCRIPTION', 'index.php?module=HideBlocks&parent=Settings&view=List', '12', '0', '0'],
			['LBL_STUDIO', 'LBL_CUSTOM_FIELD_MAPPING', 'adminIcon-filed-mapping', 'LBL_CUSTOM_FIELD_MAPPING_DESCRIPTION', 'index.php?parent=Settings&module=Leads&view=MappingDetail', '13', '0', '0'],
			['LBL_STUDIO', 'LBL_MAPPEDFIELDS', 'adminIcon-mapped-fields', 'LBL_MAPPEDFIELDS_DESCRIPTION', 'index.php?module=MappedFields&parent=Settings&view=List', '16', '0', '0'],
			['LBL_COMPANY', 'NOTIFICATIONSCHEDULERS', '', 'LBL_NOTIF_SCHED_DESCRIPTION', 'index.php?module=Settings&view=listnotificationschedulers&parenttab=Settings', '4', '0', '0'],
			['LBL_COMPANY', 'LBL_COMPANY_DETAILS', 'adminIcon-company-detlis', 'LBL_COMPANY_DESCRIPTION', 'index.php?parent=Settings&module=Vtiger&view=CompanyDetails', '2', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'INVENTORYNOTIFICATION', '', 'LBL_INV_NOTIF_DESCRIPTION', 'index.php?module=Settings&view=listinventorynotifications&parenttab=Settings', '1', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_CURRENCY_SETTINGS', 'adminIcon-currencies', 'LBL_CURRENCY_DESCRIPTION', 'index.php?parent=Settings&module=Currency&view=List', '4', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_SWITCH_USERS', 'adminIcon-users', 'LBL_SWITCH_USERS_DESCRIPTION', 'index.php?module=Users&view=SwitchUsers&parent=Settings', '34', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_SYSTEM_INFO', 'adminIcon-server-configuration', 'LBL_SYSTEM_DESCRIPTION', 'index.php?module=Settings&submodule=Server&view=ProxyConfig', '6', '1', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_ANNOUNCEMENT', 'adminIcon-company-information', 'LBL_ANNOUNCEMENT_DESCRIPTION', 'index.php?parent=Settings&module=Vtiger&view=AnnouncementEdit', '2', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_DEFAULT_MODULE_VIEW', 'adminIcon-standard-modules', 'LBL_DEFAULT_MODULE_VIEW_DESC', 'index.php?module=Settings&action=DefModuleView&parenttab=Settings', '2', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_TERMS_AND_CONDITIONS', 'adminIcon-terms-and-conditions', 'LBL_INV_TANDC_DESCRIPTION', 'index.php?parent=Settings&module=Vtiger&view=TermsAndConditionsEdit', '3', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_CONFIG_EDITOR', 'adminIcon-system-tools', 'LBL_CONFIG_EDITOR_DESCRIPTION', 'index.php?module=Vtiger&parent=Settings&view=ConfigEditorDetail', '7', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'ModTracker', 'adminIcon-modules-track-chanegs', 'LBL_MODTRACKER_DESCRIPTION', 'index.php?module=ModTracker&action=BasicSettings&parenttab=Settings&formodule=ModTracker', '9', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LBL_PDF', 'adminIcon-modules-pdf-templates', 'LBL_PDF_DESCRIPTION', 'index.php?module=PDF&parent=Settings&view=List', '27', '0', '0'],
			['LBL_SYSTEM_TOOLS', 'LangManagement', 'adminIcon-languages-and-translations', 'LBL_LANGMANAGEMENT_DESCRIPTION', 'index.php?module=LangManagement&parent=Settings&view=Index', '1', '0', '0'],
			['LBL_INTEGRATION', 'LBL_PBXMANAGER', 'adminIcon-pbx-manager', 'LBL_PBXMANAGER_DESCRIPTION', 'index.php?module=PBXManager&parent=Settings&view=Index', '22', '0', '0'],
			['LBL_INTEGRATION', 'LBL_CUSTOMER_PORTAL', 'adminIcon-customer-portal', 'PORTAL_EXTENSION_DESCRIPTION', 'index.php?module=CustomerPortal&action=index&parenttab=Settings', '3', '0', '0'],
			['LBL_INTEGRATION', 'Webforms', 'adminIcon-online-forms', 'LBL_WEBFORMS_DESCRIPTION', 'index.php?module=Webforms&action=index&parenttab=Settings', '4', '0', '0'],
			['LBL_INTEGRATION', 'LBL_API_ADDRESS', 'adminIcon-address', 'LBL_API_ADDRESS_DESCRIPTION', 'index.php?module=ApiAddress&parent=Settings&view=Configuration', '5', '0', '0'],
			['LBL_INTEGRATION', 'LBL_MOBILE_KEYS', 'adminIcon-mobile-applications', 'LBL_MOBILE_KEYS_DESCRIPTION', 'index.php?parent=Settings&module=MobileApps&view=MobileKeys', '6', '0', '0'],
			['LBL_INTEGRATION', 'LBL_DAV_KEYS', 'adminIcon-dav-applications', 'LBL_DAV_KEYS_DESCRIPTION', 'index.php?parent=Settings&module=Dav&view=Keys', '7', '0', '0'],
			['LBL_INTEGRATION', 'LBL_AUTHORIZATION', 'adminIcon-automation', 'LBL_AUTHORIZATION_DESCRIPTION', 'index.php?module=Users&view=Auth&parent=Settings', '1', '0', '0'],
			['LBL_INTEGRATION', 'LBL_CURRENCY_UPDATE', 'adminIcon-currencies', 'LBL_CURRENCY_UPDATE_DESCRIPTION', 'index.php?module=CurrencyUpdate&view=Index&parent=Settings', '2', '0', '0'],
			['LBL_PROCESSES', 'LBL_SALES_PROCESSES', 'adminIcon-sales', 'LBL_SALES_PROCESSES_DESCRIPTION', 'index.php?module=SalesProcesses&view=Index&parent=Settings', '2', '0', '0'],
			['LBL_PROCESSES', 'LBL_SUPPORT_PROCESSES', 'adminIcon-support ', 'LBL_SUPPORT_PROCESSES_DESCRIPTION', 'index.php?module=SupportProcesses&view=Index&parent=Settings', '6', '0', '0'],
			['LBL_PROCESSES', 'LBL_REALIZATION_PROCESSES', 'adminIcon-realization', 'LBL_REALIZATION_PROCESSES_DESCRIPTION', 'index.php?module=RealizationProcesses&view=Index&parent=Settings', '3', '0', '0'],
			['LBL_PROCESSES', 'LBL_MARKETING_PROCESSES', 'adminIcon-marketing', 'LBL_MARKETING_PROCESSES_DESCRIPTION', 'index.php?module=MarketingProcesses&view=Index&parent=Settings', '1', '0', '0'],
			['LBL_PROCESSES', 'LBL_FINANCIAL_PROCESSES', 'adminIcon-finances', 'LBL_FINANCIAL_PROCESSES_DESCRIPTION', 'index.php?module=FinancialProcesses&view=Index&parent=Settings', '5', '0', '0'],
			['LBL_PROCESSES', 'LBL_TIMECONTROL_PROCESSES', 'adminIcon-logistics', 'LBL_TIMECONTROL_PROCESSES_DESCRIPTION', 'index.php?module=TimeControlProcesses&parent=Settings&view=Index', '7', '0', '0'],
			['LBL_SECURITY_MANAGEMENT', 'LBL_PASSWORD_CONF', 'adminIcon-passwords-configuration', 'LBL_PASSWORD_DESCRIPTION', 'index.php?module=Password&parent=Settings&view=Index', '1', '0', '0'],
			['LBL_SECURITY_MANAGEMENT', 'OSSPassword Configuration', 'adminIcon-passwords-encryption', 'LBL_OSSPASSWORD_CONFIGURATION_DESCRIPTION', 'index.php?module=OSSPasswords&view=ConfigurePass&parent=Settings', '3', '0', '0'],
			['LBL_SECURITY_MANAGEMENT', 'LBL_BRUTEFORCE', 'adminIcon-brute-force', 'LBL_BRUTEFORCE_DESCRIPTION', 'index.php?module=BruteForce&parent=Settings&view=Show', '2', '0', '0'],
			['LBL_SECURITY_MANAGEMENT', 'Backup', 'adminIcon-backup', 'LBL_BACKUP_DESCRIPTION', 'index.php?parent=Settings&module=BackUp&view=Index', '4', '0', '0'],
			['LBL_MAIL_TOOLS', 'LBL_MAIL_SERVER_SETTINGS', 'adminIcon-mail-configuration', 'LBL_MAIL_SERVER_DESCRIPTION', 'index.php?parent=Settings&module=Vtiger&view=OutgoingServerDetail', '5', '0', '0'],
			['LBL_MAIL_TOOLS', 'Mail Scanner', 'adminIcon-mail-scanner', 'LBL_MAIL_SCANNER_DESCRIPTION', 'index.php?module=OSSMailScanner&parent=Settings&view=Index', '3', '0', '0'],
			['LBL_MAIL_TOOLS', 'Mail View', 'adminIcon-oss_mailview', 'LBL_MAIL_VIEW_DESCRIPTION', 'index.php?module=OSSMailView&parent=Settings&view=index', '21', '0', '0'],
			['LBL_MAIL_TOOLS', 'LBL_AUTOLOGIN', 'adminIcon-mail-auto-login', 'LBL_AUTOLOGIN_DESCRIPTION', 'index.php?parent=Settings&module=Mail&view=Autologin', '4', '0', '0'],
			['LBL_MAIL_TOOLS', 'LBL_MAIL_GENERAL_CONFIGURATION', 'adminIcon-mail-smtp-server', 'LBL_MAIL_GENERAL_CONFIGURATION_DESCRIPTION', 'index.php?parent=Settings&module=Mail&view=Config', '1', '0', '0'],
			['LBL_MAIL_TOOLS', 'Mail', 'adminIcon-mail-download-history', 'LBL_OSSMAIL_DESCRIPTION', 'index.php?module=OSSMail&parent=Settings&view=index', '2', '0', '0'],
			['LBL_About_YetiForce', 'License', 'adminIcon-license', 'LBL_LICENSE_DESCRIPTION', 'index.php?module=Vtiger&parent=Settings&view=License', '4', '0', '0'],
			['LBL_About_YetiForce', 'Credits', 'adminIcon-contributors', 'LBL_CREDITS_DESCRIPTION', 'index.php?module=Vtiger&view=Credits&parent=Settings', '3', '0', '0'],
			['LBL_ADVANCED_MODULES', 'LBL_CREDITLIMITS', 'adminIcon-credit-limit-base_2', 'LBL_CREDITLIMITS_DESCRIPTION', 'index.php?module=Inventory&parent=Settings&view=CreditLimits', '5', '0', '0'],
			['LBL_ADVANCED_MODULES', 'LBL_TAXES', 'adminIcon-taxes-rates', 'LBL_TAXES_DESCRIPTION', 'index.php?module=Inventory&parent=Settings&view=Taxes', '1', '0', '0'],
			['LBL_ADVANCED_MODULES', 'LBL_DISCOUNTS', 'adminIcon-discount-base', 'LBL_DISCOUNTS_DESCRIPTION', 'index.php?module=Inventory&parent=Settings&view=Discounts', '3', '0', '0'],
			['LBL_ADVANCED_MODULES', 'LBL_TAXCONFIGURATION', 'adminIcon-taxes-caonfiguration', 'LBL_TAXCONFIGURATION_DESCRIPTION', 'index.php?module=Inventory&parent=Settings&view=TaxConfiguration', '4', '0', '0'],
			['LBL_ADVANCED_MODULES', 'LBL_DISCOUNTCONFIGURATION', 'adminIcon-discount-configuration', 'LBL_DISCOUNTCONFIGURATION_DESCRIPTION', 'index.php?module=Inventory&parent=Settings&view=DiscountConfiguration', '2', '0', '0'],
			['LBL_CALENDAR_LABELS_COLORS', 'LBL_ACTIVITY_TYPES', 'adminIcon-calendar-types', 'LBL_ACTIVITY_TYPES_DESCRIPTION', 'index.php?parent=Settings&module=Calendar&view=ActivityTypes', '1', '0', '0'],
			['LBL_CALENDAR_LABELS_COLORS', 'LBL_PUBLIC_HOLIDAY', 'adminIcon-calendar-holidys', 'LBL_PUBLIC_HOLIDAY_DESCRIPTION', 'index.php?module=PublicHoliday&view=Configuration&parent=Settings', '3', '0', '0'],
			['LBL_CALENDAR_LABELS_COLORS', 'LBL_CALENDAR_CONFIG', 'adminIcon-calendar-configuration', 'LBL_CALENDAR_CONFIG_DESCRIPTION', 'index.php?parent=Settings&module=Calendar&view=UserColors', '2', '0', '0'],
			['LBL_CALENDAR_LABELS_COLORS', 'LBL_COLORS', 'adminIcon-colors', 'LBL_COLORS_DESCRIPTION', 'index.php?module=Users&parent=Settings&view=Colors', '4', '0', '0'],
			['LBL_SEARCH_AND_FILTERS', 'Search Setup', 'adminIcon-search-configuration', 'LBL_SEARCH_SETUP_DESCRIPTION', 'index.php?module=Search&parent=Settings&view=Index', '1', '0', '0'],
			['LBL_SEARCH_AND_FILTERS', 'CustomView', 'adminIcon-filters-configuration', 'LBL_CUSTOMVIEW_DESCRIPTION', 'index.php?module=CustomView&parent=Settings&view=Index', '2', '0', '0'],
			['LBL_LOGS', 'LBL_LOGIN_HISTORY_DETAILS', 'adminIcon-users-login', 'LBL_LOGIN_HISTORY_DESCRIPTION', 'index.php?module=LoginHistory&parent=Settings&view=List', '3', '0', '0'],
			['LBL_LOGS', 'Mail Logs', 'adminIcon-mail-download-history', 'LBL_MAIL_LOGS_DESCRIPTION', 'index.php?module=OSSMailScanner&parent=Settings&view=logs', '4', '0', '0'],
			['LBL_LOGS', 'LBL_UPDATES_HISTORY', 'adminIcon-server-updates', 'LBL_UPDATES_HISTORY_DESCRIPTION', 'index.php?parent=Settings&module=Updates&view=Index', '2', '0', '0'],
			['LBL_LOGS', 'LBL_CONFREPORT', 'adminIcon-server-configuration', 'LBL_CONFREPORT_DESCRIPTION', 'index.php?parent=Settings&module=ConfReport&view=Index', '1', '0', '0'],
			['LBL_AUTOMATION', 'LBL_LIST_WORKFLOWS', 'adminIcon-triggers', 'LBL_LIST_WORKFLOWS_DESCRIPTION', 'index.php?module=Workflows&parent=Settings&view=List', '1', '0', '1'],
			['LBL_AUTOMATION', 'Scheduler', 'adminIcon-cron', 'LBL_SCHEDULER_DESCRIPTION', 'index.php?module=CronTasks&parent=Settings&view=List', '3', '0', '0'],
			['LBL_AUTOMATION', 'LBL_WORKFLOW_LIST', 'adminIcon-workflow', 'LBL_AVAILABLE_WORKLIST_LIST', 'index.php?module=com_vtiger_workflow&action=workflowlist', '1', '0', '0'],
			['LBL_AUTOMATION', 'Document Control', 'adminIcon-workflow', 'LBL_DOCUMENT_CONTROL_DESCRIPTION', 'index.php?module=OSSDocumentControl&parent=Settings&view=Index', '4', '0', '0'],
			['LBL_AUTOMATION', 'Project Templates', 'adminIcon-document-templates', 'LBL_PROJECT_TEMPLATES_DESCRIPTION', 'index.php?module=OSSProjectTemplates&parent=Settings&view=Index', '5', '0', '0'],
			['LBL_AUTOMATION', 'LBL_DATAACCESS', 'adminIcon-recording-control', 'LBL_DATAACCESS_DESCRIPTION', 'index.php?module=DataAccess&parent=Settings&view=Index', '2', '0', '0']
		];
		$blocks = [];
		$delete = ['LBL_TAX_SETTINGS', 'PDF'];
		$adb->delete('vtiger_settings_field', '`name` IN (' . $adb->generateQuestionMarks($delete) . ') ', $delete);
		foreach ($menu as $row) {
			if (!array_key_exists($row[0], $blocks)) {
				$blockInstance = Settings_Vtiger_Menu_Model::getInstance($row[0]);
				$blocks[$row[0]] = $blockInstance;
			}
			$result = $adb->pquery('SELECT 1 FROM `vtiger_settings_field` WHERE `name` = ?', [$row[1]]);
			if ($result->rowCount() > 0 && !empty($blocks[$row[0]])) {
				$adb->update('vtiger_settings_field', ['blockid' => $blocks[$row[0]]->get('blockid'), 'name' => $row[1], 'iconpath' => $row[2], 'description' => $row[3], 'linkto' => $row[4], 'sequence' => $row[5], 'active' => $row[6], 'pinned' => $row[7]], '`name` = ?', [$row[1]]);
			} elseif (!empty($blocks[$row[0]])) {
				$fieldId = $adb->getUniqueID('vtiger_settings_field');
				$adb->insert('vtiger_settings_field', ['fieldid' => $fieldId, 'blockid' => $blocks[$row[0]]->get('blockid'), 'name' => $row[1], 'iconpath' => $row[2], 'description' => $row[3], 'linkto' => $row[4], 'sequence' => $row[5], 'active' => $row[6], 'pinned' => $row[7]]);
			}
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function changeActivity()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$adb->query("UPDATE `vtiger_activity_reminder_popup` SET `status` = '1' WHERE recordid IN (SELECT activityid FROM `vtiger_activity` WHERE `status` IN ('PLL_CANCELLED','PLL_COMPLETED','PLL_OVERDUE'))");
		$adb->query("UPDATE `vtiger_activity_reminder_popup` SET `status` = '0' WHERE recordid IN (SELECT activityid FROM `vtiger_activity` WHERE `status` IN ('PLL_IN_REALIZATION','PLL_POSTPONED','PLL_PLANNED'))");
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function setCustomize()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$modulesSetZero = ['PBXManager', 'CallHistory'];
		$adb->update('vtiger_tab', ['customized' => 0], '`name` IN (' . $adb->generateQuestionMarks($modulesSetZero) . ')', $modulesSetZero);
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function deleteCustomView()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');

		$adb = PearDatabase::getInstance();
		$result = $adb->pquery('SELECT cvid FROM vtiger_customview WHERE entitytype = ?', ['Emails']);
		if ($result->rowCount() > 0) {
			$cvid = $adb->query_result($result, 0, 'cvid');
			$adb->delete('vtiger_customview', 'cvid = ?', [$cvid]);
			$adb->delete('vtiger_cvcolumnlist', 'cvid = ?', [$cvid]);
		}

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addSalesProcessField()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');

		$adb = PearDatabase::getInstance();
		$adb->delete('yetiforce_proc_sales', '`param` NOT IN (?)', ['limit_product_service']);

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function databaseSchema()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');

		$adb = PearDatabase::getInstance();
		$adb->query("CREATE TABLE IF NOT EXISTS `s_yf_multireference` (
				`source_module` varchar(50) NOT NULL,
				`dest_module` varchar(50) NOT NULL,
				`lastid` int(19) unsigned NOT NULL DEFAULT '0',
				`type` tinyint(1) NOT NULL DEFAULT '0',
				KEY `source_module` (`source_module`,`dest_module`)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$result = $adb->query("SHOW COLUMNS FROM `s_yf_multireference` LIKE 'type';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `s_yf_multireference` ADD COLUMN `type` TINYINT(1) DEFAULT 0 NOT NULL AFTER `lastid`;");
		}
		$adb->query("CREATE TABLE IF NOT EXISTS `l_yf_sqltime` (
			`id` int(19) DEFAULT NULL,
			`type` varchar(20) DEFAULT NULL,
			`data` text,
			`date` datetime DEFAULT NULL,
			`qtime` decimal(20,3) DEFAULT NULL,
			KEY `id` (`id`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$adb->query('DROP TABLE IF EXISTS `vtiger_sqltimelog`');

		$this->addHandler([['vtiger.entity.aftersave.final', 'modules/Vtiger/handlers/MultiReferenceUpdater.php', 'Vtiger_MultiReferenceUpdater_Handler', '', '1', '[]']]);

		$sql = 'UPDATE vtiger_relatedlists SET `related_tabid` = ?, `label` = ? WHERE `related_tabid` = ?';
		$adb->pquery($sql, [getTabid('OSSMailView'), 'OSSMailView', getTabid('Emails')]);

		$query = 'UPDATE vtiger_currencies_seq SET id = (SELECT currencyid FROM vtiger_currencies ORDER BY currencyid DESC LIMIT 1)';
		$adb->query($query);

		$uniqId = $adb->getUniqueID('vtiger_currencies');
		$result = $adb->pquery('SELECT 1 FROM vtiger_currencies WHERE currency_name = ?', ['CFP Franc']);

		if ($adb->num_rows($result) <= 0) {
			$adb->pquery('INSERT INTO vtiger_currencies VALUES (?,?,?,?)', [$uniqId, 'CFP Franc', 'XPF', 'F']);
		}

		$sortOrderResult = $adb->pquery("SELECT sortorderid FROM vtiger_time_zone WHERE time_zone = ?", ['Asia/Yakutsk']);
		if ($adb->num_rows($sortOrderResult)) {
			$sortOrderId = $adb->query_result($sortOrderResult, 0, 'sortorderid');
			$adb->pquery('UPDATE vtiger_time_zone SET sortorderid = (sortorderid + 1) WHERE sortorderid > ?', [$sortOrderId]);
			$sortOrderResult = $adb->pquery("SELECT 1 FROM vtiger_time_zone WHERE time_zone = ?", ['Etc/GMT-11']);
			if (!$adb->num_rows($sortOrderResult)) {
				$adb->pquery('INSERT INTO vtiger_time_zone (time_zone, sortorderid, presence) VALUES (?, ?, ?)', ['Etc/GMT-11', ($sortOrderId + 1), 1]);
			}
		}

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_layout` (
					`id` int(11) NOT NULL,
					`name` varchar(50) DEFAULT NULL,
					`label` varchar(30) DEFAULT NULL,
					`lastupdated` datetime DEFAULT NULL,
					`isdefault` tinyint(1) DEFAULT NULL,
					`active` tinyint(1) DEFAULT NULL,
					PRIMARY KEY (`id`)
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_ossmailtemplates` LIKE 'sysname';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_ossmailtemplates` ADD COLUMN `sysname` varchar(50) NULL DEFAULT '' after `name`;");
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_timecontrol_type` LIKE 'color';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_timecontrol_type` ADD COLUMN `color` varchar(25) NULL DEFAULT '#E6FAD8';");
			$adb->pquery("UPDATE vtiger_timecontrol_type SET `color` = CASE "
				. " WHEN timecontrol_type = 'PLL_WORKING_TIME' THEN ? "
				. " WHEN timecontrol_type = 'PLL_BREAK_TIME' THEN ? "
				. " WHEN timecontrol_type = 'PLL_HOLIDAY' THEN ? "
				. " ELSE timecontrol_type END WHERE timecontrol_type IN (?,?,?) ", ['#EDC240', '#AFD8F8', '#CB4B4B', 'PLL_WORKING_TIME', 'PLL_BREAK_TIME', 'PLL_HOLIDAY']);
		}
		$adb->query("CREATE TABLE IF NOT EXISTS `a_yf_pdf` (
				`pdfid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of record',
				`module_name` varchar(25) NOT NULL COMMENT 'name of the module',
				`header_content` text NOT NULL,
				`body_content` text NOT NULL,
				`footer_content` text NOT NULL,
				`status` set('active','inactive') NOT NULL,
				`primary_name` varchar(255) NOT NULL,
				`secondary_name` varchar(255) NOT NULL,
				`meta_author` varchar(255) NOT NULL,
				`meta_creator` varchar(255) NOT NULL,
				`meta_keywords` varchar(255) NOT NULL,
				`metatags_status` tinyint(1) NOT NULL,
				`meta_subject` varchar(255) NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`page_format` varchar(255) NOT NULL,
				`margin_chkbox` tinyint(1) DEFAULT NULL,
				`margin_top` smallint(2) unsigned NOT NULL,
				`margin_bottom` smallint(2) unsigned NOT NULL,
				`margin_left` smallint(2) unsigned NOT NULL,
				`margin_right` smallint(2) unsigned NOT NULL,
				`page_orientation` set('PLL_PORTRAIT','PLL_LANDSCAPE') NOT NULL,
				`language` varchar(7) NOT NULL,
				`filename` varchar(255) NOT NULL,
				`visibility` set('PLL_LISTVIEW','PLL_DETAILVIEW') NOT NULL,
				`default` tinyint(1) DEFAULT NULL,
				`conditions` text NOT NULL,
				`watermark_type` set('text','image') NOT NULL,
				`watermark_text` varchar(255) NOT NULL,
				`watermark_size` tinyint(2) unsigned NOT NULL,
				`watermark_angle` smallint(3) unsigned NOT NULL,
				`watermark_image` varchar(255) NOT NULL,
				`template_members` varchar(255) NOT NULL,
				PRIMARY KEY (`pdfid`),
				KEY `module_name` (`module_name`,`status`)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `l_yf_switch_users` (
					`id` int(19) unsigned NOT NULL AUTO_INCREMENT,
					`date` datetime NOT NULL,
					`status` varchar(10) NOT NULL,
					`baseid` int(19) NOT NULL,
					`destid` int(19) NOT NULL,
					`busername` varchar(50) NOT NULL,
					`dusername` varchar(50) NOT NULL,
					`ip` varchar(100) NOT NULL,
					`agent` varchar(255) NOT NULL,
					PRIMARY KEY (`id`),
					KEY `baseid` (`baseid`),
					KEY `destid` (`destid`)
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_organizationdetails` LIKE 'panellogoname';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_organizationdetails` 
					ADD COLUMN `panellogoname` varchar(50)  NULL after `website` , 
					ADD COLUMN `height_panellogo` smallint(3) NULL after `panellogoname` , 
					ADD COLUMN `panellogo` text NULL after `height_panellogo` , 
					CHANGE `logoname` `logoname` varchar(50) NULL after `panellogo` , 
					CHANGE `logo` `logo` text  NULL after `logoname` , 
					CHANGE `vatid` `vatid` varchar(30) NULL after `logo` , 
					ADD COLUMN `id1` varchar(30) NULL after `vatid` , 
					ADD COLUMN `id2` varchar(30) NULL after `id1` , 
					ADD COLUMN `email` varchar(50)  NULL after `id2` ;");
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_settings_blocks` LIKE 'icon';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_settings_blocks` ADD COLUMN `icon` varchar(255) NULL after `sequence` ;");
		}

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_grp2us` (
				`shareid` int(19) NOT NULL,
				`share_groupid` int(19) DEFAULT NULL,
				`to_userid` int(19) DEFAULT NULL,
				`permission` int(19) DEFAULT NULL,
				PRIMARY KEY (`shareid`),
				KEY `datashare_grp2us_share_groupid_idx` (`share_groupid`),
				KEY `datashare_grp2us_to_userid_idx` (`to_userid`)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_role2us` (
				`shareid` int(19) NOT NULL,
				`share_roleid` varchar(255) DEFAULT NULL,
				`to_userid` int(19) DEFAULT NULL,
				`permission` int(19) DEFAULT NULL,
				PRIMARY KEY (`shareid`),
				KEY `datashare_role2us_share_roleid_idx` (`share_roleid`),
				KEY `datashare_role2us_to_userid_idx` (`to_userid`)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_rs2us` (
			`shareid` int(19) NOT NULL,
			`share_roleandsubid` varchar(255) DEFAULT NULL,
			`to_userid` int(19) DEFAULT NULL,
			`permission` int(19) DEFAULT NULL,
			PRIMARY KEY (`shareid`),
			KEY `datashare_rs2us_share_roleandsubid_idx` (`share_roleandsubid`),
			KEY `datashare_rs2us_to_userid_idx` (`to_userid`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_us2grp` (
			`shareid` int(19) NOT NULL,
			`share_userid` int(19) DEFAULT NULL,
			`to_groupid` int(19) DEFAULT NULL,
			`permission` int(19) DEFAULT NULL,
			PRIMARY KEY (`shareid`),
			KEY `datashare_us2grp_share_userid_idx` (`share_userid`),
			KEY `datashare_us2grp_to_groupid_idx` (`to_groupid`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_us2role` (
			`shareid` int(19) NOT NULL,
			`share_userid` int(19) DEFAULT NULL,
			`to_roleid` varchar(255) DEFAULT NULL,
			`permission` int(19) DEFAULT NULL,
			PRIMARY KEY (`shareid`),
			KEY `idx_datashare_us2role_share_userid` (`share_userid`),
			KEY `idx_datashare_us2role_to_roleid` (`to_roleid`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_us2rs` (
			`shareid` int(19) NOT NULL,
			`share_userid` int(19) DEFAULT NULL,
			`to_roleandsubid` varchar(255) DEFAULT NULL,
			`permission` int(19) DEFAULT NULL,
			PRIMARY KEY (`shareid`),
			KEY `datashare_us2rs_share_userid_idx` (`share_userid`),
			KEY `datashare_us2rs_to_roleandsubid_idx` (`to_roleandsubid`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_datashare_us2us` (
			`shareid` int(19) NOT NULL,
			`share_userid` int(19) DEFAULT NULL,
			`to_userid` int(19) DEFAULT NULL,
			`permission` int(19) DEFAULT NULL,
			PRIMARY KEY (`shareid`),
			KEY `datashare_us2us_share_userid_idx` (`share_userid`),
			KEY `datashare_us2us_to_userid_idx` (`to_userid`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$adb->query("CREATE TABLE IF NOT EXISTS `a_yf_mapped_config`(
			`id` int(19) NOT NULL  auto_increment , 
			`tabid` int(19) NULL  , 
			`reltabid` int(19) NULL  , 
			`status` set('active','inactive')  NULL  , 
			`conditions` text  NULL  , 
			`permissions` varchar(255)  NULL  , 
			`params` varchar(255)  NULL  , 
			PRIMARY KEY (`id`) ,
			KEY `tabid`(`tabid`) , 
			KEY `reltabid`(`reltabid`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8' ;");

		$adb->query("CREATE TABLE IF NOT EXISTS `a_yf_mapped_fields`(
		`id` int(19) NOT NULL  auto_increment , 
		`mappedid` int(19) NULL  , 
		`type` varchar(30)  NULL  , 
		`source` varchar(30)  NULL  , 
		`target` varchar(30)  NULL  , 
		`default` varchar(255)  NULL  , 
		PRIMARY KEY (`id`) , 
		KEY `a_yf_mapped_fields_ibfk_1`(`mappedid`) , 
		CONSTRAINT `a_yf_mapped_fields_ibfk_1` 
		FOREIGN KEY (`mappedid`) REFERENCES `a_yf_mapped_config` (`id`) ON DELETE CASCADE 
	) ENGINE=InnoDB DEFAULT CHARSET='utf8' ;");

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_trees_templates_data` LIKE 'icon';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_trees_templates_data` 	ADD COLUMN `icon` varchar(255) NULL after `state` ;");
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_module_dashboard` LIKE 'cache';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_module_dashboard` ADD COLUMN `cache` tinyint(1) NULL DEFAULT 0 after `owners` ;");
		}
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_module_dashboard_widgets` LIKE 'cache';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_module_dashboard_widgets` ADD COLUMN `cache` tinyint(1)   NULL DEFAULT 0 after `module` ;");
		}
		$adb->query("CREATE TABLE IF NOT EXISTS `u_yf_favorites`(
			`crmid` int(19) NULL  , 
			`module` varchar(30)  NULL  , 
			`relcrmid` int(19) NULL  , 
			`relmodule` varchar(30)  NULL  , 
			`userid` int(19) NULL  , 
			`data` timestamp NULL  DEFAULT CURRENT_TIMESTAMP , 
			KEY `crmid`(`crmid`) , 
			KEY `relcrmid`(`relcrmid`) , 
			KEY `mix`(`crmid`,`module`,`relcrmid`,`relmodule`,`userid`) , 
			CONSTRAINT `fk_1_u_yf_favorites` 
			FOREIGN KEY (`relcrmid`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE , 
			CONSTRAINT `fk_u_yf_favorites` 
			FOREIGN KEY (`crmid`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8' ;");
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_relatedlists` LIKE 'favorites';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_relatedlists` ADD COLUMN `favorites` tinyint(1)   NULL DEFAULT 0 after `actions` ;");
		}

		$adb->query("CREATE TABLE IF NOT EXISTS `o_yf_access_for_admin`(
				`id` int(19) unsigned NOT NULL  auto_increment , 
				`username` varchar(50) NOT NULL  , 
				`date` datetime NOT NULL  , 
				`ip` varchar(100) NOT NULL  , 
				`module` varchar(30) NOT NULL  , 
				`url` varchar(300) NOT NULL  , 
				`agent` varchar(255) NOT NULL  , 
				`request` varchar(300) NOT NULL  , 
				PRIMARY KEY (`id`) 
			) ENGINE=InnoDB DEFAULT CHARSET='utf8';");

		$adb->query("CREATE TABLE IF NOT EXISTS `o_yf_access_for_api`(
			`id` int(19) unsigned NOT NULL  auto_increment , 
			`username` varchar(50) NOT NULL  , 
			`date` datetime NOT NULL  , 
			`ip` varchar(100) NOT NULL  , 
			`url` varchar(300) NOT NULL  , 
			`agent` varchar(255) NOT NULL  , 
			`request` varchar(300) NOT NULL  , 
			PRIMARY KEY (`id`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		$adb->query("CREATE TABLE IF NOT EXISTS `o_yf_access_for_user`(
			`id` int(19) unsigned NOT NULL  auto_increment , 
			`username` varchar(50) NOT NULL  , 
			`date` datetime NOT NULL  , 
			`ip` varchar(100) NOT NULL  , 
			`module` varchar(30) NOT NULL  , 
			`url` varchar(300) NOT NULL  , 
			`agent` varchar(255) NOT NULL  , 
			`request` varchar(300) NOT NULL  , 
			PRIMARY KEY (`id`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");

		$result = $adb->query("SHOW TABLES LIKE 'l_yf_access_to_record';");
		if ($adb->getRowCount($result)) {
			$adb->query('RENAME TABLE `l_yf_access_to_record` TO `o_yf_access_to_record`;');
			$result = $adb->query("SHOW COLUMNS FROM `o_yf_access_to_record` LIKE 'request';");
			if ($result->rowCount() == 0) {
				$adb->query("ALTER TABLE `o_yf_access_to_record` ADD COLUMN `request` varchar(300) NOT NULL;");
			}
		} else {
			$adb->query("CREATE TABLE IF NOT EXISTS `o_yf_access_to_record`(
				`id` int(19) unsigned NOT NULL  auto_increment , 
				`username` varchar(50) NOT NULL  , 
				`date` datetime NOT NULL  , 
				`ip` varchar(100) NOT NULL  , 
				`record` int(19) NOT NULL  , 
				`module` varchar(30) NOT NULL  , 
				`url` varchar(300) NOT NULL  , 
				`agent` varchar(255) NOT NULL  , 
				`request` varchar(300) NOT NULL  , 
				PRIMARY KEY (`id`) 
			) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		}

		$adb->query("CREATE TABLE IF NOT EXISTS `o_yf_csrf`(
			`id` int(19) unsigned NOT NULL  auto_increment , 
			`username` varchar(50) NOT NULL  , 
			`date` datetime NOT NULL  , 
			`ip` varchar(100) NOT NULL  , 
			`referer` varchar(300) NOT NULL  , 
			`url` varchar(300) NOT NULL  , 
			`agent` varchar(255) NOT NULL  , 
			PRIMARY KEY (`id`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		$adb->query("CREATE TABLE IF NOT EXISTS `p_yf_servers`(
			`id` int(10) NOT NULL  auto_increment , 
			`name` varchar(200) NULL  , 
			`acceptable_url` varchar(200) NULL  , 
			`status` tinyint(1) NULL  DEFAULT 0 , 
			`api_key` varchar(100) NULL  , 
			PRIMARY KEY (`id`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		$adb->query("CREATE TABLE IF NOT EXISTS `p_yf_sessions`(
			`id` varchar(32) NOT NULL  , 
			`user_id` int(19) NULL  , 
			`language` varchar(10) NULL  , 
			`created` datetime NULL  , 
			`changed` datetime NULL  , 
			`ip` varchar(100) NULL  , 
			PRIMARY KEY (`id`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		$adb->query("CREATE TABLE IF NOT EXISTS `p_yf_users`(
			`id` int(19) NOT NULL  auto_increment , 
			`server_id` int(10) NULL  , 
			`status` tinyint(1) NULL  DEFAULT 0 , 
			`user_name` varchar(50) NOT NULL  , 
			`password_h` varchar(200) NULL  , 
			`password_t` varchar(200) NULL  , 
			`type` varchar(30) NULL  , 
			`parent_id` int(19) NULL  , 
			`login_time` datetime NULL  , 
			`logout_time` datetime NULL  , 
			`first_name` varchar(200) NULL  , 
			`last_name` varchar(200) NULL  , 
			`language` varchar(10) NULL  , 
			PRIMARY KEY (`id`) , 
			UNIQUE KEY `user_name`(`user_name`) , 
			KEY `user_name_2`(`user_name`,`status`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_account` LIKE 'products';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_account` ADD COLUMN `products` text  NULL after `creditlimit`;");
		}
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_account` LIKE 'services';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_account` ADD COLUMN `services` text  NULL after `products` ;");
		}
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_assets` LIKE 'pscategory';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_assets` ADD COLUMN `pscategory` varchar(255)  DEFAULT '' after `ordertime` ;");
		}

		$result = $adb->query("SHOW KEYS FROM `vtiger_account` WHERE Key_name='parentid';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_account` ADD KEY `parentid`(`parentid`);");
		}

		$adb->query('DROP TABLE IF EXISTS vtiger_inventorynotification;');
		$adb->query('DROP TABLE IF EXISTS vtiger_inventorynotification_seq;');

		$adb->query("CREATE TABLE IF NOT EXISTS `u_yf_crmentity_rel_tree`(
				`crmid` int(11) NOT NULL  , 
				`module` int(11) NOT NULL  , 
				`tree` varchar(50) NOT NULL  , 
				`relmodule` int(11) NOT NULL  , 
				`rel_created_user` int(11) NOT NULL  , 
				`rel_created_time` datetime NOT NULL  , 
				`rel_comment` varchar(255) NULL  
			) ENGINE=InnoDB DEFAULT CHARSET='utf8';");

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_relatedlists` LIKE 'creator_detail';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_relatedlists` 	ADD COLUMN `creator_detail` tinyint(1) NULL DEFAULT 0 after `favorites`, ADD COLUMN `relation_comment` tinyint(1) NULL DEFAULT 0 after `creator_detail` ;");
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_seproductsrel` LIKE 'rel_created_user';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_seproductsrel` 
				ADD COLUMN `rel_created_user` int(11)   NOT NULL after `setype` , 
				ADD COLUMN `rel_created_time` datetime   NOT NULL after `rel_created_user` , 
				ADD COLUMN `rel_comment` varchar(255) NULL after `rel_created_time` ; ");
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_crmentityrel` LIKE 'rel_created_user';");
		if ($result->rowCount() == 0) {
			$adb->query("ALTER TABLE `vtiger_crmentityrel` 
				ADD COLUMN `rel_created_user` int(11) NULL after `relmodule` , 
				ADD COLUMN `rel_created_time` datetime NULL after `rel_created_user` , 
				ADD COLUMN `rel_comment` varchar(255) NULL after `rel_created_time` ; ");
		}

		$adb->query("CREATE TABLE IF NOT EXISTS `u_yf_github`(
			`github_id` int(11) NOT NULL  auto_increment , 
			`client_id` varchar(20) COLLATE utf8_general_ci NULL  , 
			`token` varchar(100) COLLATE utf8_general_ci NULL  , 
			`username` varchar(32) COLLATE utf8_general_ci NULL  , 
			KEY `github_id`(`github_id`) 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addHandler($addHandler = [])
	{
		$log = vglobal('log');
		$adb = PearDatabase::getInstance();
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		if ($addHandler) {
			$em = new VTEventsManager($adb);
			foreach ($addHandler as $handler) {
				$result = $adb->pquery('SELECT * FROM `vtiger_eventhandlers` WHERE event_name = ? AND handler_class = ?;', [$handler[0], $handler[2]]);
				if ($result->rowCount() == 0) {
					$em->registerHandler($handler[0], $handler[1], $handler[2], $handler[3], $handler[5]);
				}
			}
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function removeHandler($class = [])
	{
		$log = vglobal('log');
		$adb = PearDatabase::getInstance();
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		if ((bool) $class) {
			$em = new VTEventsManager($adb);
			foreach ($class as $handler) {
				$em->unregisterHandler($handler);
			}
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	function updateFiles()
	{
		$log = vglobal('log');
		$root_directory = vglobal('root_directory');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		if (!$root_directory)
			$root_directory = getcwd();
		$config = $root_directory . '/config/config.inc.php';
		if (file_exists($config)) {
			$configContent = file($config);
			$defaultLayout = true;
			$layoutInLoginView = true;
			$isVisibleLogoInFooter = true;
			foreach ($configContent as $key => $line) {
				if (strpos($line, 'defaultLayout') !== false) {
					$configContent[$key] = str_replace('vlayout', 'basic', $configContent[$key]);
					$defaultLayout = false;
				}
				if (strpos($line, 'layoutInLoginView') !== false) {
					$layoutInLoginView = false;
				}
				if (strpos($line, 'isVisibleLogoInFooter') !== false) {
					$isVisibleLogoInFooter = false;
				}
				if (strpos($line, 'support@vtiger.com') !== false) {
					$configContent[$key] = str_replace('vtiger', 'yetiforce', $configContent[$key]);
				}
				if (strpos($line, 'ini_set') !== false) {
					$configContent[$key] = str_replace('ini_set', 'AppConfig::iniSet', $configContent[$key]);
				}
				if (strpos($line, "include_once('config/version.php')") !== false ||
					strpos($line, 'calculate_response_time') !== false ||
					strpos($line, 'show or hide time to compose each page') !== false ||
					strpos($line, 'in the login form for password') !== false ||
					strpos($line, 'default_password') !== false ||
					strpos($line, 'default username and password') !== false ||
					strpos($line, 'create_default_user') !== false ||
					strpos($line, 'default_user_is_admin') !== false ||
					strpos($line, 'disable_persistent_connections') !== false ||
					strpos($line, 'if your MySQL/PHP configuration does not support') !== false ||
					strpos($line, 'show record count in tabs related modules') !== false ||
					strpos($line, 'showRecordsCount') !== false ||
					strpos($line, 'show names related modules') !== false ||
					strpos($line, 'showNameRelatedModules') !== false ||
					strpos($line, 'default view in Comments (Timeline/List') !== false ||
					strpos($line, 'defaultViewInComments') !== false) {
					unset($configContent[$key]);
				}
			}
			$content = implode("", $configContent);
			if ($defaultLayout) {
				$content .= '
// Set the default layout 
$defaultLayout = \'basic\';

';
			}
			if ($layoutInLoginView) {
				$content .= '
// System\'s lyout selection in the login window (true/false).
$layoutInLoginView = false;

';
			}
			if ($isVisibleLogoInFooter) {
				$content .= '// Logo is visible in footer.
$isVisibleLogoInFooter = true;
';
			}
			$file = fopen($config, "w+");
			fwrite($file, $content);
			fclose($file);
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	function roundcubeConfig()
	{
		$log = vglobal('log');
		$root_directory = vglobal('root_directory');
		$log->debug("Entering YetiForceUpdate::roundcubeConfig() method ...");
		if (!$root_directory)
			$root_directory = getcwd();
		$config = $root_directory . '/modules/OSSMail/roundcube/config/config.inc.php';
		if (file_exists($config)) {
			$configContent = file($config);
			foreach ($configContent as $key => $line) {
				if (strpos($line, 'config[') !== false) {
					break;
				} else {
					unset($configContent[$key]);
				}
			}
			$content = implode("", $configContent);
			$improvedConfig = '<?php
/*
  Disable SSL for IMAP/SMTP
  If your IMAP/SMTP servers are on the same host or are connected via a secure network, not using SSL connections improves performance. So don\'t use "ssl://" or "tls://" urls for \'default_host\' and \'smtp_server\' config options.
 */
if (!$no_include_config) {
	$currentPath = getcwd();
	chdir(dirname(__FILE__) . \'/../../../../\');
	include_once(\'include/ConfigUtils.php\');
	chdir($currentPath);
}
';
			$content = $improvedConfig . $content;
			$file = fopen($config, "w+");
			fwrite($file, $content);
			fclose($file);
		}
		$log->debug("Exiting YetiForceUpdate::roundcubeConfig() method ... ");
	}

	public function enableTracking()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		include_once('modules/ModTracker/ModTracker.php');
		ModTracker::enableTrackingForModule(Vtiger_Functions::getModuleId('OSSTimeControl'));

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addCurrencies()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery('SELECT 1 FROM `vtiger_currencies` WHERE `currency_name` = ?;', ['CFP Franc']);
		if (!$adb->getRowCount($result)) {
			$id = $adb->getUniqueID('vtiger_currencies');
			$adb->insert('vtiger_currencies', [
				'currencyid' => $id,
				'currency_name' => 'CFP Franc',
				'currency_code' => 'XPF',
				'currency_symbol' => 'F',
			]);
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addTimeZone()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery('SELECT 1 FROM `vtiger_time_zone` WHERE `time_zone` = ?;', ['Etc/GMT-11']);
		if (!$adb->getRowCount($result)) {
			$id = $adb->getUniqueID('vtiger_time_zone');
			$seq = $this->getMax('vtiger_time_zone', 'sortorderid');
			$adb->insert('vtiger_time_zone', [
				'time_zoneid' => $id,
				'time_zone' => 'Etc/GMT-11',
				'sortorderid' => $seq,
				'presence' => 1,
			]);
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function getMax($table, $field)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$result = $adb->query("SELECT MAX(" . $field . ") AS max_seq  FROM " . $table . " ;");
		$id = (int) $adb->getSingleValue($result) + 1;
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		return $id;
	}

	public function updateMailTemplate()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$moduleName = 'OSSMailTemplates';
		$data = ['Notify Contact On Ticket Closed' => 'NotifyContactOnTicketClosed', 'Notify Contact On Ticket Create' => 'NotifyContactOnTicketCreate', 'Notify Contact On Ticket Change' => 'NotifyContactOnTicketChange', 'Activity Reminder Notification' => 'ActivityReminderNotificationEvents', 'Test mail about the mail server configuration.' => 'TestMailAboutTheMailServerConfiguration', 'ForgotPassword' => 'UsersForgotPassword', 'Customer Portal - ForgotPassword' => 'YetiPortalForgotPassword', 'New comment added to ticket' => 'NewCommentAddedToTicketContact', 'Security risk has been detected - Brute Force' => 'BruteForceSecurityRiskHasBeenDetected', 'Backup has been made' => 'BackupHasBeenMade', 'New comment added to ticket from portal' => 'NewCommentAddedToTicketOwner'];

		$query = 'UPDATE vtiger_ossmailtemplates SET ';
		$query .=' sysname = CASE ';
		foreach ($data as $name => $sysName) {
			$query .= " WHEN `name` = '" . $name . "' THEN '" . $sysName . "'";
		}
		$query .= ' END WHERE `name` IN (' . $adb->generateQuestionMarks(array_keys($data)) . ')';

		$adb->pquery($query, [array_keys($data)]);

		$adb->update('vtiger_ossmailtemplates', ['sysname' => 'ActivityReminderNotificationTask'], 'name = ? AND oss_module_list = ?', ['Activity Reminder Notification', 'Calendar']);

		$result = $adb->pquery('SELECT ossmailtemplatesid FROM vtiger_ossmailtemplates WHERE `name` = ?;', ['New comment added to ticket from portal']);
		if ($adb->getRowCount($result)) {
			$id = $adb->getSingleValue($result);
			$recordModel = Vtiger_Record_Model::getInstanceById($id, $moduleName);
			$recordModel->set('id', $id);
			$recordModel->set('mode', 'edit');
			$recordModel->set('sysname', 'NewCommentAddedToTicketOwner');
			$recordModel->set('name', 'Notify Owner On new comment added to ticket from portal');
			$recordModel->set('subject', '#t#LBL_ADDED_COMMENT_TO_TICKET#tEnd#');
			$recordModel->set('content', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#LBL_NEW_COMMENT_FOR_TICKET#tEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#691#aEnd#).

<hr /> #b#597#bEnd#: #a#597#aEnd#
</div>');
			$recordModel->save();
		}
		$result = $adb->pquery('SELECT ossmailtemplatesid FROM vtiger_ossmailtemplates WHERE `name` = ?;', ['New comment added to ticket']);
		if ($adb->getRowCount($result)) {
			$id = $adb->getSingleValue($result);
			$recordModel = Vtiger_Record_Model::getInstanceById($id, 'OSSMailTemplates');
			$recordModel->set('id', $id);
			$recordModel->set('mode', 'edit');
			$recordModel->set('sysname', 'NewCommentAddedToTicketContact');
			$recordModel->set('name', 'Notify Contact On New comment added to ticket');
			$recordModel->set('subject', '#t#LBL_ADDED_COMMENT_TO_TICKET#tEnd#');
			$recordModel->set('content', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#LBL_NEW_COMMENT_FOR_TICKET#tEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#745#aEnd#).

<hr /> #b#597#bEnd#: #a#597#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>');
			$recordModel->save();
		}
		$result = $adb->pquery('SELECT ossmailtemplatesid FROM vtiger_ossmailtemplates WHERE `name` = ?;', ['Notify Contact On Ticket Create']);
		if ($adb->getRowCount($result)) {
			$id = $adb->getSingleValue($result);
			$recordModel = Vtiger_Record_Model::getInstanceById($id, 'OSSMailTemplates');
			$recordModel->set('id', $id);
			$recordModel->set('mode', 'edit');
			$recordModel->set('content', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#SINGLE_HelpDesk#tEnd# #a#155#aEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#168#aEnd#).

<hr /><h1><a href="%23s%23LinkToPortalRecord%23sEnd%23">#t#LBL_NOTICE_CREATE#tEnd# #a#155#aEnd#: #a#169#aEnd#</a></h1>

<ul><li>#b#161#bEnd#: #a#161#aEnd#</li>
	<li>#b#158#bEnd#: #a#158#aEnd#</li>
	<li>#b#156#bEnd#: #a#156#aEnd#</li>
	<li>#b#157#bEnd#: #a#157#aEnd#</li>
</ul><hr /> #b#170#bEnd#: #a#170#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>');
			$recordModel->save();
		}

		$mailTemplates = $this->getMailTemplate();
		foreach ($mailTemplates as $mailTemplate) {
			$result = $adb->pquery('SELECT ossmailtemplatesid FROM vtiger_ossmailtemplates WHERE `sysname` = ?;', [$mailTemplate[2]]);
			if (!$adb->getRowCount($result)) {
				$user = Users_Record_Model::getCurrentUserModel();
				$instance = new $moduleName();
				$instance->column_fields['assigned_user_id'] = $user->id;
				$instance->column_fields['name'] = $mailTemplate[1];
				$instance->column_fields['oss_module_list'] = $mailTemplate[3];
				$instance->column_fields['subject'] = $mailTemplate[4];
				$instance->column_fields['content'] = $mailTemplate[5];
				$instance->column_fields['ossmailtemplates_type'] = $mailTemplate[6];
				$save = $instance->save($moduleName);
				$adb->update('vtiger_ossmailtemplates', ['sysname' => $mailTemplate[2]], 'ossmailtemplatesid = ?', [$instance->id]);
			}
		}

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function deleteWorkflow()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$adb = PearDatabase::getInstance();
		$adb->pquery('UPDATE com_vtiger_workflows SET defaultworkflow = "0" WHERE module_name = ?;', ['ModComments']);
		$result = $adb->pquery('SELECT * FROM com_vtiger_workflows WHERE module_name = ?;', ['ModComments']);
		for ($i = 0; $i < $adb->getRowCount($result); $i++) {
			$recordId = $adb->query_result($result, $i, 'workflow_id');
			$recordModel = Settings_Workflows_Record_Model::getInstance($recordId);
			$recordModel->delete();
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addWorkflows($step = true)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');

		$workflow = [];
		$workflowTask = [];
		if ($step) {
			$workflow[] = ['57', 'ModComments', 'New comment added to ticket - Owner', '[{"fieldname":"customer","operation":"is not empty","value":null,"valuetype":"rawtext","joincondition":"","groupjoin":"and","groupid":"0"}]', '1', NULL, 'basic', '6', NULL, NULL, NULL, NULL, NULL, NULL];
			$workflow[] = ['58', 'ModComments', 'New comment added to ticket - account', '[{"fieldname":"customer","operation":"is empty","value":null,"valuetype":"rawtext","joincondition":"","groupjoin":"and","groupid":"0"}]', '1', NULL, 'basic', '6', NULL, NULL, NULL, NULL, NULL, NULL];
			$workflow[] = ['59', 'ModComments', 'New comment added to ticket - contact', '[{"fieldname":"customer","operation":"is empty","value":null,"valuetype":"rawtext","joincondition":"","groupjoin":"and","groupid":"0"}]', '1', NULL, 'basic', '6', NULL, NULL, NULL, NULL, NULL, NULL];

			$workflowTask[] = ['135', '59', 'Notify Contact On New comment added to ticket', 'O:18:"VTEntityMethodTask":7:{s:18:"executeImmediately";b:1;s:10:"workflowId";i:59;s:7:"summary";s:45:"Notify Contact On New comment added to ticket";s:6:"active";b:0;s:7:"trigger";N;s:10:"methodName";s:26:"HeldDeskNewCommentContacts";s:2:"id";i:135;}'];
			$workflowTask[] = ['136', '58', 'Notify Account On New comment added to ticket', 'O:18:"VTEntityMethodTask":7:{s:18:"executeImmediately";b:1;s:10:"workflowId";i:58;s:7:"summary";s:45:"Notify Account On New comment added to ticket";s:6:"active";b:0;s:7:"trigger";N;s:10:"methodName";s:25:"HeldDeskNewCommentAccount";s:2:"id";i:136;}'];
			$workflowTask[] = ['137', '57', 'Notify Owner On new comment added to ticket from portal', 'O:18:"VTEntityMethodTask":7:{s:18:"executeImmediately";b:1;s:10:"workflowId";i:57;s:7:"summary";s:55:"Notify Owner On new comment added to ticket from portal";s:6:"active";b:0;s:7:"trigger";N;s:10:"methodName";s:23:"HeldDeskNewCommentOwner";s:2:"id";i:137;}'];
		} else {
			$workflow[] = ['69', 'OSSTimeControl', 'LBL_UPDATE_WORK_TIME', '[]', '7', NULL, 'basic', '6', '0', '', '', '', '', '0000-00-00 00:00:00'];
			$workflowTask[] = ['138', '69', 'Update working time', 'O:16:"VTUpdateWorkTime":6:{s:18:"executeImmediately";b:0;s:10:"workflowId";i:69;s:7:"summary";s:19:"Update working time";s:6:"active";b:1;s:7:"trigger";N;s:2:"id";i:138;}'];
		}
		$this->saveWorflows($workflow, $workflowTask);
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function saveWorflows($workflow, $workflowTask = [])
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		if (!is_array($workflow)) {
			return false;
		}
		$adb = PearDatabase::getInstance();
		$workflowManager = new VTWorkflowManager($adb);
		$taskManager = new VTTaskManager($adb);
		foreach ($workflow as $record) {
			$result = $adb->pquery('SELECT 1 FROM `com_vtiger_workflows` WHERE `module_name` = ? AND summary = ?;', [$record[1], $record[2]]);
			if ($adb->getRowCount($result)) {
				continue;
			}
			$newWorkflow = $workflowManager->newWorkFlow($record[1]);
			$newWorkflow->description = $record[2];
			$newWorkflow->test = $record[3];
			$newWorkflow->executionCondition = $record[4];
			$newWorkflow->defaultworkflow = $record[5];
			$newWorkflow->type = $record[6];
			$newWorkflow->filtersavedinnew = $record[7];
			$workflowManager->save($newWorkflow);
			foreach ($workflowTask as $indexTask) {
				if ($indexTask[1] == $record[0]) {
					$task = $taskManager->unserializeTask($indexTask[3]);
					$task->id = '';
					$task->workflowId = $newWorkflow->id;
					$taskManager->saveTask($task);
				}
			}
		}
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function worflowEnityMethod()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');

		$adb = PearDatabase::getInstance();
		$task_entity_method = [];
		$task_entity_method[] = ['ModComments', 'HeldDeskNewCommentOwner', 'modules/HelpDesk/workflows/HelpDeskWorkflow.php', 'HeldDeskNewCommentOwner'];

		$emm = new VTEntityMethodManager($adb);
		foreach ($task_entity_method as $method) {
			$result = $adb->pquery('SELECT 1 FROM `com_vtiger_workflowtasks_entitymethod` WHERE `method_name` = ? AND module_name = ?;', [$method[1], $method[0]]);
			if (!$adb->getRowCount($result)) {
				$emm->addEntityMethod($method[0], $method[1], $method[2], $method[3]);
			}
		}
		$adb->update('com_vtiger_workflowtasks_entitymethod', ['method_name' => 'HeldDeskNewCommentAccount', 'function_path' => 'modules/HelpDesk/workflows/HelpDeskWorkflow.php', 'function_name' => 'HeldDeskNewCommentAccount'], 'method_name = ?', ['CustomerCommentFromPortal']);
		$adb->update('com_vtiger_workflowtasks_entitymethod', ['method_name' => 'HeldDeskNewCommentContacts', 'function_path' => 'modules/HelpDesk/workflows/HelpDeskWorkflow.php', 'function_name' => 'HeldDeskNewCommentContacts'], 'method_name = ?', ['TicketOwnerComments']);

		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function getMailTemplate()
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
		$mailTemplate[] = ['94', 'Activity Reminder Notification', 'ActivityReminderNotificationEvents', 'Events', 'Reminder: #a#255#aEnd#', '<span style="line-height:20.7999992370605px;">This is a reminder notification for the Activity:</span><br style="line-height:20.7999992370605px;" /><span style="line-height:20.7999992370605px;">Subject:</span>#a#255#aEnd#<br style="line-height:20.7999992370605px;" /><span style="line-height:20.7999992370605px;">Date & Time: </span>#a#257#aEnd# #a#258#aEnd#<br style="line-height:20.7999992370605px;" /><span style="line-height:20.7999992370605px;color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;">Contact Name: </span>#a#277#aEnd#<br style="line-height:20.7999992370605px;color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;" /><span style="line-height:20.7999992370605px;color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;">Related To: </span>#a#264#aEnd#<br style="line-height:20.7999992370605px;color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;" /><span style="line-height:20.7999992370605px;color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;">Description: </span>#a#275#aEnd#', 'PLL_RECORD'];

		$mailTemplate[] = ['93', 'Activity Reminder Notification', 'ActivityReminderNotificationTask', 'Calendar', 'Reminder:  #a#231#aEnd#', 'This is a reminder notification for the Activity:<br />Subject: #a#231#aEnd#<br />Date & Time: #a#233#aEnd# #a#234#aEnd#<br /><span style="color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;line-height:20.7999992370605px;">Contact Name: </span>#a#238#aEnd#<br style="color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;line-height:20.7999992370605px;" /><span style="color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;line-height:20.7999992370605px;">Related To: </span>#a#237#aEnd#<br style="color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;line-height:20.7999992370605px;" /><span style="color:rgb(43,43,43);font-family:\'Helvetica Neue\', Helvetica, Arial, sans-serif;line-height:20.7999992370605px;">Description: </span>#a#247#aEnd#', 'PLL_RECORD'];

		$mailTemplate[] = ['108', 'Backup has been made', 'BackupHasBeenMade', 'Contacts', 'Backup has been made notification', 'Dear User,<br />
Backup has been made.', 'PLL_MODULE'];
		$mailTemplate[] = ['107', 'Security risk has been detected - Brute Force', 'BruteForceSecurityRiskHasBeenDetected', 'Contacts', 'Security risk has been detected', '<span class="value">Dear user,<br />
Failed login attempts have been detected. </span>', 'PLL_MODULE'];
		$mailTemplate[] = ['109', 'Notify Account On New comment added to ticket', 'NewCommentAddedToTicketAccount', 'ModComments', '#t#LBL_ADDED_COMMENT_TO_TICKET#tEnd#', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#LBL_NEW_COMMENT_FOR_TICKET#tEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#745#aEnd#).

<hr /> #b#597#bEnd#: #a#597#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>', 'PLL_RECORD'];
		$mailTemplate[] = ['106', 'Notify Contact On New comment added to ticket', 'NewCommentAddedToTicketContact', 'ModComments', '#t#LBL_ADDED_COMMENT_TO_TICKET#tEnd#', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#LBL_NEW_COMMENT_FOR_TICKET#tEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#745#aEnd#).

<hr /> #b#597#bEnd#: #a#597#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>', 'PLL_RECORD'];
		$mailTemplate[] = ['105', 'Notify Owner On new comment added to ticket from portal', 'NewCommentAddedToTicketOwner', 'ModComments', '#t#LBL_ADDED_COMMENT_TO_TICKET#tEnd#', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#LBL_NEW_COMMENT_FOR_TICKET#tEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#691#aEnd#).

<hr /> #b#597#bEnd#: #a#597#aEnd#
</div>', 'PLL_RECORD'];
		$mailTemplate[] = ['41', 'Notify Contact On Ticket Change', 'NotifyContactOnTicketChange', 'HelpDesk', '#t#LBL_NOTICE_MODIFICATION#tEnd# #a#155#aEnd#: #a#169#aEnd#', '<div>
<h3><span>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></span></h3>
#t#SINGLE_HelpDesk#tEnd# #a#155#aEnd# #t#LBL_NOTICE_UPDATED#tEnd# #a#168#aEnd#). #s#ChangesList#sEnd#

<hr /><h1><a href="%23s%23LinkToPortalRecord%23sEnd%23">#t#LBL_NOTICE_MODIFICATION#tEnd# #a#155#aEnd#: #a#169#aEnd#</a></h1>

<ul><li>#b#161#bEnd#: #a#161#aEnd#</li>
	<li>#b#158#bEnd#: #a#158#aEnd#</li>
	<li>#b#156#bEnd#: #a#156#aEnd#</li>
	<li>#b#157#bEnd#: #a#157#aEnd#</li>
</ul><hr /> #b#170#bEnd#: #a#170#aEnd#
<hr /> #b#171#bEnd#: #a#171#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>', 'PLL_RECORD'];
		$mailTemplate[] = ['37', 'Notify Contact On Ticket Closed', 'NotifyContactOnTicketClosed', 'HelpDesk', '#t#LBL_NOTICE_CLOSE#tEnd# #a#155#aEnd#: #a#169#aEnd#', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#SINGLE_HelpDesk#tEnd# #a#155#aEnd# #t#LBL_NOTICE_CLOSED#tEnd# #a#168#aEnd#). #s#ChangesList#sEnd#

<hr /><h1><a href="%23s%23LinkToPortalRecord%23sEnd%23">#t#LBL_NOTICE_CLOSE#tEnd# #a#155#aEnd#: #a#169#aEnd#</a></h1>

<ul><li>#b#161#bEnd#: #a#161#aEnd#</li>
	<li>#b#158#bEnd#: #a#158#aEnd#</li>
	<li>#b#156#bEnd#: #a#156#aEnd#</li>
	<li>#b#157#bEnd#: #a#157#aEnd#</li>
</ul><hr /> #b#170#bEnd#: #a#170#aEnd#
<hr /> #b#171#bEnd#: #a#171#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>', 'PLL_RECORD'];
		$mailTemplate[] = ['39', 'Notify Contact On Ticket Create', 'NotifyContactOnTicketCreate', 'HelpDesk', '#t#LBL_NOTICE_CREATE#tEnd# #a#155#aEnd#: #a#169#aEnd#', '<div>
<h3>#t#LBL_NOTICE_WELCOME#tEnd# <strong>YetiForce Sp. z o.o.</strong></h3>
#t#SINGLE_HelpDesk#tEnd# #a#155#aEnd# (#t#LBL_NOTICE_CREATED#tEnd# #a#168#aEnd#).

<hr /><h1><a href="%23s%23LinkToPortalRecord%23sEnd%23">#t#LBL_NOTICE_CREATE#tEnd# #a#155#aEnd#: #a#169#aEnd#</a></h1>

<ul><li>#b#161#bEnd#: #a#161#aEnd#</li>
	<li>#b#158#bEnd#: #a#158#aEnd#</li>
	<li>#b#156#bEnd#: #a#156#aEnd#</li>
	<li>#b#157#bEnd#: #a#157#aEnd#</li>
</ul><hr /> #b#170#bEnd#: #a#170#aEnd#
<hr /><span><em>#t#LBL_NOTICE_FOOTER#tEnd#</em></span></div>', 'PLL_RECORD'];
		$mailTemplate[] = ['95', 'Test mail about the mail server configuration.', 'TestMailAboutTheMailServerConfiguration', 'Users', 'Test mail about the mail server configuration.', '<span style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;">Dear </span>#a#478#aEnd# #a#479#aEnd#<span style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;">, </span><br style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;" /><br style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;" /><b style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;">This is a test mail sent to confirm if a mail is actually being sent through the smtp server that you have configured. </b><br style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;" /><span style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;">Feel free to delete this mail. </span><br style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;" /><br style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;" /><span style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;">Thanks and Regards,</span><br style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;" /><span style="color:rgb(0,0,0);font-family:arial, sans-serif;line-height:normal;">Team YetiForce</span>', 'PLL_RECORD'];
		$mailTemplate[] = ['103', 'ForgotPassword', 'UsersForgotPassword', 'Users', 'Request: ForgotPassword', 'Dear #a#67#aEnd# #a#70#aEnd#,<br /><br />
You recently requested a reminder of your access data for the YetiForce Portal.<br /><br />
You can login by entering the following data:<br /><br />
Your username: #a#80#aEnd#<br />
Your password: #s#ContactsPortalPass#sEnd#<br /><br /><br />
Regards,<br />
YetiForce CRM Support Team.', 'PLL_RECORD'];
		return $mailTemplate;
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}

	public function addFields($setToCRM = false)
	{
		global $log;
		$adb = PearDatabase::getInstance();
		$log->debug("Entering YetiForceUpdate::addFields() method ...");
		include_once('vtlib/Vtiger/Module.php');

		$columnName = ["tabid", "id", "column", "table", "generatedtype", "uitype", "name", "label", "readonly", "presence", "defaultvalue", "maximumlength", "sequence", "block", "displaytype", "typeofdata", "quickcreate", "quicksequence", "info_type", "masseditable", "helpinfo", "summaryfield", "fieldparams", "columntype", "blocklabel", "setpicklistvalues", "setrelatedmodules"];
		if (!$setToCRM) {
			$query = "SELECT `fieldid` FROM `vtiger_field` WHERE `tabid` = '" . getTabid('Services') . "' AND  columnname = 'servicename'";
			$result = $adb->query($query);
			$fieldId1 = $adb->getSingleValue($result);
			$query = "SELECT `fieldid` FROM `vtiger_field` WHERE `tabid` = '" . getTabid('Products') . "' AND  columnname = 'productname'";
			$result = $adb->query($query);
			$fieldId2 = $adb->getSingleValue($result);
			$Accounts = [
				['6', '1945', 'products', 'vtiger_account', '2', '305', 'products', 'Products', '1', '2', '', '100', '10', '196', '5', 'C~O', '1', NULL, 'BAS', '1', '', '0', '{"module":"Products","field":"' . $fieldId2 . '","filterField":"-","filterValue":null}', "text", "LBL_ADVANCED_BLOCK", [], []],
				['6', '1946', 'services', 'vtiger_account', '2', '305', 'services', 'Services', '1', '2', '', '100', '11', '196', '5', 'C~O', '1', NULL, 'BAS', '1', '', '0', '{"module":"Services","field":"' . $fieldId1 . '","filterField":"-","filterValue":null}', "text", "LBL_ADVANCED_BLOCK", [], []]
			];

			$Assets = [
				['37', '1947', 'pscategory', 'vtiger_assets', '2', '302', 'pscategory', 'Category', '1', '2', '', '100', '17', '95', '1', 'V~O', '1', NULL, 'BAS', '1', '', '0', '15', "varchar(255)", "LBL_ASSET_INFORMATION", [], []],
				['37', '1989', 'ssalesprocessesid', 'vtiger_assets', '2', '10', 'ssalesprocessesid', 'SSalesProcesses', '1', '2', '', '100', '18', '95', '1', 'V~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_ASSET_INFORMATION", [], ['SSalesProcesses']]
			];

			$OutsourcedProducts = [
				['59', '1988', 'ssalesprocessesid', 'vtiger_outsourcedproducts', '2', '10', 'ssalesprocessesid', 'SSalesProcesses', '1', '2', '', '100', '31', '144', '1', 'V~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_INFORMATION", [], ['SSalesProcesses']]
			];

			$OSSOutsourcedServices = [
				['57', '1990', 'ssalesprocessesid', 'vtiger_ossoutsourcedservices', '2', '10', 'ssalesprocessesid', 'SSalesProcesses', '1', '2', '', '100', '16', '138', '1', 'V~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_INFORMATION", [], ['SSalesProcesses']]
			];

			$OSSSoldServices = [
				['58', '1991', 'ssalesprocessesid', 'vtiger_osssoldservices', '2', '10', 'ssalesprocessesid', 'SSalesProcesses', '1', '2', '', '100', '10', '141', '1', 'V~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_INFORMATION", [], ['SSalesProcesses']]
			];

			$Calendar = [
				[9, 1992, 'subprocess', 'vtiger_activity', 1, '68', 'subprocess', 'FL_SUB_PROCESS', 1, 0, '', 100, 1, 19, 1, 'I~O', 1, NULL, 'BAS', 1, '', 1, '', "int(19)", "LBL_TASK_INFORMATION", [], []]
			];
			$Events = [
				['16', '1993', 'subprocess', 'vtiger_activity', '1', '68', 'subprocess', 'FL_SUB_PROCESS', '1', '0', '', '100', '3', '119', '1', 'I~O', '1', NULL, 'BAS', '1', '', '1', '', "int(19)", "LBL_RELATED_TO", [], []]
			];
			$OSSTimeControl = [
				['51', '1994', 'process', 'vtiger_osstimecontrol', '1', '66', 'process', 'FL_PROCESS', '1', '2', '', '100', '11', '129', '1', 'I~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_BLOCK", [], []],
				['51', '1995', 'link', 'vtiger_osstimecontrol', '1', '67', 'link', 'FL_RELATION', '1', '2', '', '100', '12', '129', '1', 'I~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_BLOCK", [], []],
				['51', '1996', 'subprocess', 'vtiger_osstimecontrol', '1', '68', 'subprocess', 'FL_SUB_PROCESS', '1', '2', '', '100', '13', '129', '1', 'I~O', '1', NULL, 'BAS', '1', '', '0', '', "int(19)", "LBL_BLOCK", [], []]
			];
			$Competition = [
				['93', '2001', 'sum_time', 'u_yf_competition', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '5', '304', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CUSTOM_INFORMATION", [], []],
				['93', '2013', 'email', 'u_yf_competition', '2', '13', 'email', 'Email', '1', '2', '', '100', '5', '303', '1', 'E~O', '1', NULL, 'BAS', '1', '', '0', '', "varchar(50)", "LBL_COMPETITION_INFORMATION", [], []]
			];
			$Contacts = [
				['4', '1997', 'sum_time', 'vtiger_contactdetails', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '10', '5', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CUSTOM_INFORMATION", [], []]
			];
			$Leads = [
				['7', '1998', 'sum_time', 'vtiger_leaddetails', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '10', '14', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CUSTOM_INFORMATION", [], []]
			];
			$Vendors = [
				['18', '1999', 'sum_time', 'vtiger_vendor', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '19', '42', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_VENDOR_INFORMATION", [], []]
			];
			$Partners = [
				['92', '2000', 'sum_time', 'u_yf_partners', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '5', '300', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CUSTOM_INFORMATION", [], []],
				['92', '2012', 'email', 'u_yf_partners', '2', '13', 'email', 'Email', '1', '2', '', '100', '5', '299', '1', 'E~O', '1', NULL, 'BAS', '1', '', '0', '', "varchar(50)", "LBL_PARTNERS_INFORMATION", [], []]
			];
			$OSSEmployees = [
				['61', '2002', 'sum_time', 'vtiger_ossemployees', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '15', '151', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_INFORMATION", [], []]
			];
			$SSalesProcesses = [
				['86', '2003', 'sum_time', 'u_yf_ssalesprocesses', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '5', '270', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CUSTOM_INFORMATION", [], []]
			];
			$Campaigns = [
				['26', '2004', 'sum_time', 'vtiger_campaign', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '1', '74', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CAMPAIGN_INFORMATION", [], []]
			];
			$ProjectMilestone = [
				['41', '2005', 'sum_time', 'vtiger_projectmilestone', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '5', '102', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_CUSTOM_INFORMATION", [], []]
			];
			$SQuoteEnquiries = [
				['85', '2006', 'sum_time', 'u_yf_squoteenquiries', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '2', '267', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_STATISTICS", [], []]
			];
			$SRequirementsCards = [
				['87', '2007', 'sum_time', 'u_yf_srequirementscards', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '2', '274', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_STATISTICS", [], []]
			];
			$SCalculations = [
				['88', '2008', 'sum_time', 'u_yf_scalculations', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '2', '278', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_STATISTICS", [], []]
			];
			$SQuotes = [
				['89', '2009', 'sum_time', 'u_yf_squotes', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '2', '282', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_STATISTICS", [], []]
			];
			$SSingleOrders = [
				['90', '2010', 'sum_time', 'u_yf_ssingleorders', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '2', '286', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_STATISTICS", [], []]
			];
			$SRecurringOrders = [
				['91', '2011', 'sum_time', 'u_yf_srecurringorders', '1', '7', 'sum_time', 'FL_TOTAL_TIME_H', '1', '2', '', '100', '2', '290', '10', 'NN~O', '1', NULL, 'BAS', '1', '', '0', '', "decimal(10,2)", "LBL_STATISTICS", [], []]
			];

			$setToCRM = ['Accounts' => $Accounts, 'Assets' => $Assets, 'OutsourcedProducts' => $OutsourcedProducts, 'OSSOutsourcedServices' => $OSSOutsourcedServices, 'OSSSoldServices' => $OSSSoldServices, 'Calendar' => $Calendar, 'Events' => $Events, 'OSSTimeControl' => $OSSTimeControl,
				'Contacts' => $Contacts,
				'Leads' => $Leads,
				'Vendors' => $Vendors,
				'Campaigns' => $Campaigns,
				'ProjectMilestone' => $ProjectMilestone,
				'OSSEmployees' => $OSSEmployees,
				'SQuoteEnquiries' => $SQuoteEnquiries,
				'SSalesProcesses' => $SSalesProcesses,
				'SRequirementsCards' => $SRequirementsCards,
				'SCalculations' => $SCalculations,
				'SQuotes' => $SQuotes,
				'SSingleOrders' => $SSingleOrders,
				'SRecurringOrders' => $SRecurringOrders,
				'Partners' => $Partners,
				'Competition' => $Competition
			];
		}

		$setToCRMAfter = [];
		foreach ($setToCRM as $nameModule => $module) {
			if (!$module)
				continue;
			foreach ($module as $key => $fieldValues) {
				for ($i = 0; $i < count($fieldValues); $i++) {
					$setToCRMAfter[$nameModule][$key][$columnName[$i]] = $fieldValues[$i];
				}
			}
		}
		foreach ($setToCRMAfter as $moduleName => $fields) {
			foreach ($fields as $field) {
				if (self::checkFieldExists($field, $moduleName)) {
					continue;
				}
				$moduleInstance = Vtiger_Module::getInstance($moduleName);
				$blockInstance = Vtiger_Block::getInstance($field['blocklabel'], $moduleInstance);
				$fieldInstance = new Vtiger_Field();
				$fieldInstance->column = $field['column'];
				$fieldInstance->name = $field['name'];
				$fieldInstance->label = $field['label'];
				$fieldInstance->table = $field['table'];
				$fieldInstance->uitype = $field['uitype'];
				$fieldInstance->typeofdata = $field['typeofdata'];
				$fieldInstance->readonly = $field['readonly'];
				$fieldInstance->displaytype = $field['displaytype'];
				$fieldInstance->masseditable = $field['masseditable'];
				$fieldInstance->quickcreate = $field['quickcreate'];
				$fieldInstance->columntype = $field['columntype'];
				$fieldInstance->presence = $field['presence'];
				$fieldInstance->maximumlength = $field['maximumlength'];
				$fieldInstance->quicksequence = $field['quicksequence'];
				$fieldInstance->info_type = $field['info_type'];
				$fieldInstance->helpinfo = $field['helpinfo'];
				$fieldInstance->summaryfield = $field['summaryfield'];
				$fieldInstance->generatedtype = $field['generatedtype'];
				$fieldInstance->defaultvalue = $field['defaultvalue'];
				$fieldInstance->fieldparams = $field['fieldparams'];
				$blockInstance->addField($fieldInstance);
				if ($field['setpicklistvalues'] && ($field['uitype'] == 15 || $field['uitype'] == 16 || $field['uitype'] == 33 ))
					$fieldInstance->setPicklistValues($field['setpicklistvalues']);
				if ($field['setrelatedmodules'] && $field['uitype'] == 10) {
					$fieldInstance->setRelatedModules($field['setrelatedmodules']);
				}
			}
		}
		$log->debug("Exiting YetiForceUpdate::addFields() method ...");
	}

	public function checkFieldExists($field, $moduleName)
	{
		global $adb;
		if ($moduleName == 'Settings')
			$result = $adb->pquery("SELECT * FROM vtiger_settings_field WHERE name = ? AND linkto = ? ;", [$field[1], $field[4]]);
		else {
			if (is_numeric($moduleName)) {
				$tabId = $moduleName;
			} else {
				$tabId = getTabid($moduleName);
			}
			$result = $adb->pquery("SELECT * FROM vtiger_field WHERE columnname = ? AND tablename = ? AND tabid = ?;", [$field['column'], $field['table'], $tabId]);
		}
		if (!$adb->getRowCount($result)) {
			return false;
		}
		return true;
	}
}
