<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/	
	require('includes/init.php');
	
	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');

	require('includes/entry-functions.php');
	
	$form_id  = (int) trim($_GET['form_id']);
	$entry_id = (int) trim($_GET['entry_id']);
	$nav = trim($_GET['nav']);

	if(empty($form_id) || empty($entry_id)){
		die("Invalid Request");
	}

	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	//get form name
	$query 	= "select 
					 form_name
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if(!empty($row)){
		$form_name = htmlspecialchars($row['form_name']);
	}

	//if there is "nav" parameter, we need to determine the correct entry id and override the existing entry_id
	if(!empty($nav)){
		$all_entry_id_array = mf_get_filtered_entries_ids($dbh,$form_id);
		$entry_key = array_keys($all_entry_id_array,$entry_id);
		$entry_key = $entry_key[0];

		if($nav == 'prev'){
			$entry_key--;
		}else{
			$entry_key++;
		}

		$entry_id = $all_entry_id_array[$entry_key];

		//if there is no entry_id, fetch the first/last member of the array
		if(empty($entry_id)){
			if($nav == 'prev'){
				$entry_id = array_pop($all_entry_id_array);
			}else{
				$entry_id = $all_entry_id_array[0];
			}
		}
	}

		
	//get entry details for particular entry_id
	$param['checkbox_image'] = 'images/icons/59_blue_16.png';
	$entry_details = mf_get_entry_details($dbh,$form_id,$entry_id,$param);

	//get entry information (date created/updated/ip address)
	$query = "select 
					date_format(date_created,'%e %b %Y - %r') date_created,
					date_format(date_updated,'%e %b %Y - %r') date_updated,
					ip_address 
				from 
					`".MF_TABLE_PREFIX."form_{$form_id}` 
			where id=?";
	$params = array($entry_id);

	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);

	$date_created = $row['date_created'];
	if(!empty($row['date_updated'])){
		$date_updated = $row['date_updated'];
	}else{
		$date_updated = '&nbsp;';
	}
	$ip_address   = $row['ip_address'];


	$header_data =<<<EOT
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/entry_print.css" media="print">
EOT;

	$current_nav_tab = 'manage_forms';
	require('includes/header.php'); 
	
?>


		<div id="content" class="full">
			<div class="post view_entry">
				<div class="content_header">
					<div class="content_header_title">
						<div style="float: left">
							<h2><?php echo "<a class=\"breadcrumb\" href='manage_forms.php?id={$form_id}'>".$form_name.'</a>'; ?> <img src="images/icons/resultset_next.gif" /> <?php echo "<a id=\"ve_a_entries\" class=\"breadcrumb\" href='manage_entries.php?id={$form_id}'>{$lang['Entries']}</a>"; ?> <img id="ve_a_next" src="images/icons/resultset_next.gif" /> #<?php echo $entry_id; ?></h2><br />
						</div>	
						
						<div style="clear: both; height: 1px"></div>
					</div>
					
				</div>

				<?php mf_show_message(); ?>

				<div class="content_body">
					<div id="ve_details" data-formid="<?php echo $form_id; ?>" data-entryid="<?php echo $entry_id; ?>">
						<table id="ve_detail_table" width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tbody>

							<?php 
									$toggle = false;
									
									foreach ($entry_details as $data){ 
										if($data['label'] == 'mf_page_break' && $data['value'] == 'mf_page_break'){
											continue;
										}

										if($toggle){
											$toggle = false;
											$row_style = 'class="alt"';
										}else{
											$toggle = true;
											$row_style = '';
										}	
							?>  
							  	<tr <?php echo $row_style; ?>>
							  	    <td width="40%"><strong><?php echo $data['label']; ?></strong> </td>
							  		<td width="60%"><?php echo nl2br($data['value']); ?></td>
							  	</tr>
							<?php } ?>  	
						  
						  </tbody>
						</table>

						<table width="100%" cellspacing="0" cellpadding="0" border="0" id="ve_table_info">
							<tbody>		
								<tr>
							  	    <td style="font-size: 85%;color: #444; font-weight: bold">
							  	    	<img src="images/icons/70_blue.png" align="absmiddle" style="vertical-align: middle;margin-right: 5px"><?php echo $lang['EntryInfo']; ?></td>
							  		<td>&nbsp; </td>
							  	</tr> 
									
								<tr class="alt">
							  	    <td width="40%"><strong><?php echo $lang['DateCreated']; ?></strong></td>
							  		<td width="60%"><?php echo $date_created; ?></td>
							  	</tr>  	
							  	<tr>
							  	    <td><strong><?php echo $lang['DateUpdated']; ?></strong></td>
							  		<td><?php echo $date_updated; ?></td>
							  	</tr>  	
								<tr class="alt">
							  	    <td><strong><?php echo $lang['IPAddress']; ?></strong></td>
							  		<td><?php echo $ip_address; ?></td>
							  	</tr>
							</tbody>
						</table>

					</div>
					<div id="ve_actions">
						<div id="ve_entry_navigation">
							<a href="<?php echo "view_entry.php?form_id={$form_id}&entry_id={$entry_id}&nav=prev"; ?>" title="Previous Entry"><img src="images/icons/16_left.png" /></a>
							<a href="<?php echo "view_entry.php?form_id={$form_id}&entry_id={$entry_id}&nav=next"; ?>" title="Next Entry" style="margin-left: 5px"><img src="images/icons/16_right.png" /></a>
						</div>
						<div id="ve_entry_actions" class="gradient_blue">
							<ul>
								<li style="border-bottom: 1px dashed #8EACCF"><a id="ve_action_edit" title="Edit Entry" href="<?php echo "edit_entry.php?form_id={$form_id}&entry_id={$entry_id}"; ?>"><?php echo $lang['Edit']; ?></a></li>
								<li style="border-bottom: 1px dashed #8EACCF"><a id="ve_action_email" title="Email Entry" href="#"><?php echo $lang['Email']; ?></a></li>
								<li style="border-bottom: 1px dashed #8EACCF"><a id="ve_action_print" title="Print Entry" href="javascript:window.print()"><?php echo $lang['Print']; ?></a></li>
								<li><a id="ve_action_delete" title="Delete Entry" href="#"><?php echo $lang['Delete']; ?></a></li>
							</ul>
						</div>
					</div>
				</div> <!-- /end of content_body -->	
			
			</div><!-- /.post -->
		</div><!-- /#content -->

<div id="dialog-confirm-entry-delete" title="Are you sure you want to delete this entry?" class="buttons" style="display: none">
	<img src="images/icons/hand.png" title="Confirmation" /> 
	<p id="dialog-confirm-entry-delete-msg">
		This action cannot be undone.<br/>
		<strong id="dialog-confirm-entry-delete-info">Data and files associated with this entry will be deleted.</strong><br/><br/>
		If you are sure with this, you can continue with the deletion.<br /><br />
	</p>				
</div>

<div id="dialog-email-entry" title="Email entry #<?php echo $entry_id; ?> to:" class="buttons" style="display: none"> 
	<form id="dialog-email-entry-form" class="dialog-form" style="padding-left: 10px;padding-bottom: 10px">	
		<ul>
			<li>
				<div>
					<input type="text" value="" class="text" name="dialog-email-entry-input" id="dialog-email-entry-input" />
				</div> 
				<div class="infomessage" style="padding-top: 5px;padding-bottom: 0px">Use commas to separate email addresses.</div>
			</li>
		</ul>
	</form>
</div>

<div id="dialog-entry-sent" title="Success!" class="buttons" style="display: none">
	<img src="images/icons/62_green_48.png" title="Success" /> 
	<p id="dialog-entry-sent-msg">
			The entry has been sent.
	</p>
</div>
 
<?php

	$footer_data =<<<EOT
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.sortable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="js/view_entry.js"></script>
EOT;

	require('includes/footer.php'); 
?>