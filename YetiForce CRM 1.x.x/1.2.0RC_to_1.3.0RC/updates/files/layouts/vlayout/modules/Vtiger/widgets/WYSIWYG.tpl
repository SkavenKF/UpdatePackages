<div class="summaryWidgetContainer">
	<div class="widget_header row-fluid">
		<span class="span5 margin0px"><h4>{vtranslate($WIDGET['label'],$MODULE_NAME)}</h4></span>
	</div>
	<div class="defaultMarginP">{Vtiger_Functions::removeHtmlTags(array('link', 'style', 'a', 'img', 'script'),decode_html($RECORD->get($WIDGET['data']['field_name'])))}</div>
</div>