<?php
	require '../../../../init.php';
	
	if(!isset($_GET['groupId']) or !is_numeric($_GET['groupId'])) exit ;
	
	$Groups = new Groups(array('groupid' => intval($_GET['groupId'])));
	if(!$Groups->Exist()) exit ;
	
	$data = $Groups->getInfo();
	
?>


<div id="badge-editor-flash" align="center">
<strong>Flash is required to use this tool</strong>
</div>

<script type="text/javascript" language="JavaScript">
var swfobj = new SWFObject("<?php echo $config->url_site; ?>/web-gallery/flash/BadgeEditor.swf", "badgeEditor", "280", "366", "8");
swfobj.addParam("base", "<?php echo $config->url_site; ?>/web-gallery/flash/");
swfobj.addParam("bgcolor", "#FFFFFF");
swfobj.addVariable("post_url", "<?php echo $config->url_site; ?>/modules/groups/actions/update_group_badge/index.php");
swfobj.addVariable("__app_key", "HabboPHP");
swfobj.addVariable("groupId", "<?php echo $data['id']; ?>");
swfobj.addVariable("badge_data", "<?php echo $data['badge']; ?>");
swfobj.addVariable("localization_url", "<?php echo $config->url_site; ?>/xml/badge_editor.xml");
swfobj.addVariable("xml_url", "<?php echo $config->url_site; ?>/figure/badge_data_xml.xml");
swfobj.addParam("allowScriptAccess", "none");
swfobj.write("badge-editor-flash");
</script>