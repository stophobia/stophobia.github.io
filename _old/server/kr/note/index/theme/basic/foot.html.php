<?php if($m != 'planner') { ?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">//<![CDATA[
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "table,save,advhr,advimage,advlink,insertdatetime,emotions,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
	theme_advanced_buttons1_add_before : "save,newdocument",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "forecolor,backcolor,insertdate,inserttime",
	theme_advanced_buttons2_add_before: "cut,copy,paste,search,replace",
	theme_advanced_buttons3_add_before : "tablecontrols,preview",
	theme_advanced_buttons3_add : "emotions,media,advhr,print,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	content_css : "<?php echo $path; ?>/edit.css",
    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	plugi2n_insertdate_timeFormat : "%H:%M:%S",
	file_browser_callback : "fileBrowserCallBack",
	paste_use_dialog : false,
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : false,
	theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
	paste_auto_cleanup_on_paste : true,
	paste_convert_headers_to_strong : false,
	paste_strip_class_attributes : "all",
	paste_remove_spans : false,
	paste_remove_styles : false	
});
//]]></script>
<?php } if($m == 'planner') { ?>
<script type="text/javascript" src="javascript/datepicker.js"></script>
<script type="text/javascript">//<![CDATA[
var start = new DatePicker({relative	: 'startDate'});
start.setDateFormat([ "yyyy", "mm", "dd" ], "-");
var end = new DatePicker({relative	: 'endDate'});
end.setDateFormat([ "yyyy", "mm", "dd" ], "-");
var memorial = new DatePicker({relative	: 'setDate'});
memorial.setDateFormat([ "yyyy", "mm", "dd" ], "-");
new Draggable('addPlanBox', {revert:false});
new Draggable('viewDetail', {revert:false});
new Draggable('setMemorial', {revert:false});
//]]></script>
<?php } if($m == 'wiki') { ?>
<script type="text/javascript">//<![CDATA[
new Draggable('wikiHistory', {revert:false});
new Draggable('searchBox', {revert:false});
new Draggable('wikiLatestWord', {revert:false});
//]]></script>
<?php } ?>
</body>
</html>