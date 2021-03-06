{*<!--
/*********************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 ********************************************************************************/
-->*}
{strip}
{if count($DATA) gt 0 }
	<div style="padding:5px;">
		<div class="row-fluid">
			<div class="span3"><strong>{vtranslate('Title', $RELATED_MODULE)}</strong></div>
			<div class="span3"><strong>{vtranslate('CalculationStatus', $RELATED_MODULE)}</strong></div>
			<div class="span3"><strong>{vtranslate('Related to', $RELATED_MODULE)}</strong></div>
			<div class="span3"><strong>{vtranslate('Assigned To', $RELATED_MODULE)}</strong></div>
		</div>
		{foreach item=ROW from=$DATA}
			<div class="row-fluid">
				<div class="span3"><a class="moduleColor_{$RELATED_MODULE}" href="index.php?module={$RELATED_MODULE}&view=Detail&record={$ROW.calculationsid}">{$ROW.name}</a></div>
				<div class="span3">{vtranslate($ROW.calculationsstatus, $RELATED_MODULE)}</div>
				<div class="span3">
					{if $ROW.relatedid gt 0 }
						{assign var="CRMTYPE" value=Vtiger_Functions::getCRMRecordType($ROW.relatedid)}
						<a class="moduleColor_{$CRMTYPE}" href="index.php?module={$CRMTYPE}&view=Detail&record={$ROW.relatedid}" title="{vtranslate($CRMTYPE, $CRMTYPE)}">{Vtiger_Functions::getCRMRecordLabel($ROW.relatedid)}</a>
					{/if}
				</div>
				<div class="span3">{Vtiger_Functions::getOwnerRecordLabel($ROW.smownerid)}</div>
			</div>
		{/foreach}
	</div>
{else}
	<span class="noDataMsg">
		{vtranslate('LBL_NO_DATA', $MODULE_NAME)}
	</span>
{/if}
{/strip}
