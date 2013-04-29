<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
 
 	require('includes/header.php'); 
 
	require('includes/init.php');

	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');
	

	$dbh 		 = mf_connect_db();

	$mf_settings = mf_get_settings($dbh);
	$selected_form_id = (int) $_GET['id'];
	
	if(!empty($_GET['hl'])){
		$highlight_selected_form_id = true;
	}else{
		$highlight_selected_form_id = false;
	}
	
	//determine the sorting order
	$form_sort_by = 'date_created'; //the default sort order
	
	if(!empty($_GET['sortby'])){
		$form_sort_by = strtolower(trim($_GET['sortby'])); //the user select a new sort order
		
		//save the sort order into ap_settings table
		$query = "update ".MF_TABLE_PREFIX."settings set form_manager_sort_by=?";
		$params = array($form_sort_by);
		mf_do_query($query,$params,$dbh);
		
	}elseif(!empty($mf_settings['form_manager_sort_by'])){ //load the previous saved sort order
		$form_sort_by = $mf_settings['form_manager_sort_by'];
	} 
	
	$query_order_by_clause = '';
	
	if($form_sort_by == 'form_title'){
		$query_order_by_clause = " ORDER BY form_name ASC";
		$sortby_title = 'Form Title';
	}else if($form_sort_by == 'form_tags'){
		$query_order_by_clause = " ORDER BY form_tags ASC";
		$sortby_title = 'Form Tags';
	}else if($form_sort_by == 'today_entries'){
		$sortby_title = "Today's Entries";
		
		
	}else if($form_sort_by == 'total_entries'){
		$sortby_title = "Total Entries";
		
		
	}else{ //the default date created sort
		$query_order_by_clause = " ORDER BY form_id ASC";
		$sortby_title = "Date Created";
	}
	
	//the number of forms being displayed on each page
	$rows_per_page = $mf_settings['form_manager_max_rows'];  
	
	//get the list of the form, put them into array
	$query = "SELECT 
					form_name,
					form_id,
					form_tags,
					form_active,
					form_theme_id
				FROM
					".MF_TABLE_PREFIX."forms
				WHERE
					form_active=0 or form_active=1
					{$query_order_by_clause}";
	$params = array();
	$sth = mf_do_query($query,$params,$dbh);
	
	$form_list_array = array();
	$i=0;
	while($row = mf_do_fetch_result($sth)){
		$form_list_array[$i]['form_id']   	  = $row['form_id'];
		$form_list_array[$i]['form_name'] 	  = $row['form_name'];	
		$form_list_array[$i]['form_active']   = $row['form_active'];
		$form_list_array[$i]['form_theme_id'] = $row['form_theme_id'];
		
		//get todays entries count
		$sub_query = "select count(*) today_entry from `".MF_TABLE_PREFIX."form_{$row['form_id']}` where `status`=1 and date_created >= date_format(curdate(),'%Y-%m-%d 00:00:00') ";
		$sub_sth = mf_do_query($sub_query,array(),$dbh);
		$sub_row = mf_do_fetch_result($sub_sth);
		
		$form_list_array[$i]['today_entry'] = $sub_row['today_entry'];
		
		//get latest entry timing
		if(!empty($sub_row['today_entry'])){
			$sub_query = "select date_created from `".MF_TABLE_PREFIX."form_{$row['form_id']}` order by id desc limit 1";
			$sub_sth = mf_do_query($sub_query,array(),$dbh);
			$sub_row = mf_do_fetch_result($sub_sth);
			
			$form_list_array[$i]['latest_entry'] = mf_relative_date($sub_row['date_created']);
		}
		
		//get total entries count
		if($form_sort_by == 'total_entries'){
			$sub_query = "select count(*) total_entry from `".MF_TABLE_PREFIX."form_{$row['form_id']}` where `status`=1";
			$sub_sth = mf_do_query($sub_query,array(),$dbh);
			$sub_row = mf_do_fetch_result($sub_sth);
			
			$form_list_array[$i]['total_entry'] = $sub_row['total_entry'];
		}
		
		
		//get form tags and split them into array
		if(!empty($row['form_tags'])){
			$form_tags_array = explode(',',$row['form_tags']);
			array_walk($form_tags_array, 'mf_trim_value');
			$form_list_array[$i]['form_tags'] = $form_tags_array;
		}
		
		$i++;
	}
	
	
	if($form_sort_by == 'today_entries'){
		usort($form_list_array, 'sort_by_today_entry');
	}
	
	if($form_sort_by == 'total_entries'){
		usort($form_list_array, 'sort_by_total_entry');
	}

	
	if(empty($selected_form_id)){ //if there is no preference for which form being displayed, display the first form
		$selected_form_id = $form_list_array[0]['form_id'];
	}

	$selected_page_number = 1;
	
	//build pagination markup
	$total_rows = count($form_list_array);
	$total_page = ceil($total_rows / $rows_per_page);
	
	if($total_page > 1){
		
		$start_form_index = 0;
		$pagination_markup = '<ul id="mf_pagination" class="pages green small">'."\n";
		
		for($i=1;$i<=$total_page;$i++){
			
			//attach the data code into each pagination button
			$end_form_index = $start_form_index + $rows_per_page;
			$liform_ids_array = array();
			
			for ($j=$start_form_index;$j<$end_form_index;$j++) {
				if(!empty($form_list_array[$j]['form_id'])){
					$liform_ids_array[] = '#liform_'.$form_list_array[$j]['form_id'];
					
					//put the page number into the array
					$form_list_array[$j]['page_number'] = $i;
					
					//we need to determine on which page the selected_form_id being displayed
					if($selected_form_id == $form_list_array[$j]['form_id']){
						$selected_page_number = $i;
					}
				}
			}
			
			$liform_ids_joined = implode(',',$liform_ids_array);
			$start_form_index = $end_form_index;
			
			$jquery_data_code .= "\$('#pagebtn_{$i}').data('liform_list','{$liform_ids_joined}');\n";
			
			
			if($i == $selected_page_number){
				if($selected_page_number > 1){
					$pagination_markup = str_replace('current_page','',$pagination_markup);
				}
				
				$pagination_markup .= '<li id="pagebtn_'.$i.'" class="page current_page">'.$i.'</li>'."\n";
			}else{
				$pagination_markup .= '<li id="pagebtn_'.$i.'" class="page">'.$i.'</li>'."\n";
			}
			
		}
		
		$pagination_markup .= '</ul>';
	}else{
		//if there is only 1 page, set the page_number property for each form to 1
		foreach ($form_list_array as $key=>$value){
			$form_list_array[$key]['page_number'] = 1;
		}
	}

	//get the available tags
	$query = "select form_tags from ".MF_TABLE_PREFIX."forms where form_tags is not null and form_tags <> ''";
	$params = array();
	
	$sth = mf_do_query($query,$params,$dbh);
	$raw_tags = array();
	while($row = mf_do_fetch_result($sth)){
		$raw_tags = array_merge(explode(',',$row['form_tags']),$raw_tags);
	}

	$all_tagnames = array_unique($raw_tags);
	sort($all_tagnames);
	
	$jquery_data_code .= "\$('#dialog-enter-tagname-input').data('available_tags',".json_encode($all_tagnames).");\n";
	
	//get the available custom themes
	$query = "SELECT theme_id,theme_name FROM ".MF_TABLE_PREFIX."form_themes WHERE theme_built_in=0 and status=1 ORDER BY theme_name ASC";
		
	$params = array();
	$sth = mf_do_query($query,$params,$dbh);

	$theme_list_array = array();
	while($row = mf_do_fetch_result($sth)){
		$theme_list_array[$row['theme_id']] = htmlspecialchars($row['theme_name']);
	}

	//get built-in themes
	$query = "SELECT theme_id,theme_name FROM ".MF_TABLE_PREFIX."form_themes WHERE theme_built_in=1 and status=1 ORDER BY theme_name ASC";
		
	$params = array();
	$sth = mf_do_query($query,$params,$dbh);

	$theme_builtin_list_array = array();
	while($row = mf_do_fetch_result($sth)){
		$theme_builtin_list_array[$row['theme_id']] = htmlspecialchars($row['theme_name']);
	}
	
		$header_data =<<<EOT
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link type="text/css" href="css/pagination_classic.css" rel="stylesheet" />
<link type="text/css" href="css/dropui.css" rel="stylesheet" />
EOT;

		
		
		
	
	$current_nav_tab = 'manage_forms';
	
	
	
?>
<br />

		<div id="content" class="full">
			<div class="post manage_forms">
				
				<?php mf_show_message(); ?>
				
				<div class="content_body">
				<?php if(!empty($form_list_array)){ ?>	
					<div id="mf_top_pane">
						<div id="mf_search_pane">
							<a href="edit_form.php" id="button_create_form" class="btn btn-large btn-success">
									<?php echo $lang['Create New Form !'] ; ?>
								</a>
						</div>
						<!--<div id="mf_filter_pane">
							<div class="dropui dropuiquick dropui-menu dropui-pink dropui-right">
								<a href="javascript:;" class="dropui-tab">
									<?php echo $lang['Sort By'] ; ?> &#8674; <?php echo $sortby_title; ?>
								</a>
							
								<div class="dropui-content">
									<ul>
										<li <?php if($form_sort_by == 'date_created'){ echo 'class="sort_active"'; } ?>><a id="sort_date_created_link" href="manage_forms.php?sortby=date_created"><?php echo $lang['Date Created']; ?></a></li>
										<li <?php if($form_sort_by == 'form_title'){ echo 'class="sort_active"'; } ?>><a id="sort_form_title_link" href="manage_forms.php?sortby=form_title">Form Title</a></li>
										<li <?php if($form_sort_by == 'form_tags'){ echo 'class="sort_active"'; } ?>><a id="sort_form_tag_link" href="manage_forms.php?sortby=form_tags">Form Tags</a></li>
										<li <?php if($form_sort_by == 'today_entries'){ echo 'class="sort_active"'; } ?>><a id="sort_today_entries_link" href="manage_forms.php?sortby=today_entries">Today's Entries</a></li>
										<li <?php if($form_sort_by == 'total_entries'){ echo 'class="sort_active"'; } ?>><a id="sort_total_entries_link" href="manage_forms.php?sortby=total_entries">Total Entries</a></li>
									</ul>
								</div>
							</div>
						</div>-->
					</div>
					<!--<div id="filtered_result_box">
						<div style="float: left">Filtered Results for &#8674; <span class="highlight"></span></div>
						<div id="filtered_result_box_right">
							<ul>
								<li><a href="#" id="mf_filter_reset" title="Clear filter"><img src="images/icons/56.png" /></a></li>
								<li id="filtered_result_total">Found 22 forms</li>
							</ul>
						</div>
					</div>
					<div id="filtered_result_none">
						Your filter did not match any of your forms.
					</div>-->
					<ul id="mf_form_list">
					
					<?php 
						
						$row_num = 1;
						
						foreach ($form_list_array as $form_data){
							$form_name   	 = htmlspecialchars($form_data['form_name']);
							$form_id   	 	 = $form_data['form_id'];
							$today_entry 	 = $form_data['today_entry'];
							$total_entry 	 = $form_data['total_entry'];
							$latest_entry 	 = $form_data['latest_entry'];
							$theme_id		 = (int) $form_data['form_theme_id'];
							
							if(!empty($form_data['form_tags'])){
								$form_tags_array = array_reverse($form_data['form_tags']);
							}else{
								$form_tags_array = array();
							}
							
							
							$form_class = array();
							$form_class_tag = '';
							
							if($form_id == $selected_form_id){
								$form_class[] = 'form_selected';
							}
							
							if(empty($form_data['form_active'])){
								$form_class[] = 'form_inactive';
							}
							
							if($selected_page_number == $form_data['page_number']){
								$form_class[] = 'form_visible';
							}
							
							$form_class_joined = implode(' ',$form_class);
							$form_class_tag	   = 'class="'.$form_class_joined.'"';
							
							
					?>
							
						<li data-theme_id="<?php echo $theme_id; ?>"  style="margin-bottom:5px;" id="liform_<?php echo $form_id; ?>" <?php echo $form_class_tag; ?>>
							
							<!--<button class="btn btn-primary">Vu</button>
							<table><tr>
								<td><?php echo $form_name; ?></td>
								<td><b style="color:darkred;"><?php echo $today_entry; ?></b></td>
								<td><?php echo $total_entry; ?></td>
								<td><div class="form_option mf_link_delete"><a href="#" class="btn btn-primary">Supprimer</a></div></td>
							</tr></table>-->
							
							<div class="form_option" style="float:left;margin-right:5px;"><a class="mf_link_view" target="_blank" href="<?php echo $config->url_site ;?>/form.php?id=<?php echo $form_id; ?>"><?php echo $form_name; ?></a> 
<?php if($today_entry>0){?><span style="background-color: #B94A48;padding: 1px 9px 2px;
-webkit-border-radius: 9px;
-moz-border-radius: 9px;
border-radius: 9px;font-size: 10.998px;
font-weight: bold;
line-height: 14px;
color: white;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
"><?php if($today_entry>1)echo $today_entry." ".$lang['EntriesToday'];else echo $today_entry." ".$lang['EntrieToday']; ?></span><?php } ?></div>


							<div class="form_option" style="float:right;margin-right:5px;">
								<a class="mf_link_emails btn" href="notification_settings.php?id=<?php echo $form_id; ?>"><?php echo $lang['AlertsEmail']; ?></a>
							</div>
							
							<div class="form_option mf_link_duplicate" style="float:right;margin-right:5px;">
								<a href="#" class="btn btn-info"><?php echo $lang['Duplicate']; ?></a>
							</div>
							<div class="form_option mf_link_delete" style="float:right;margin-right:5px;">
								<a href="#" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
							</div>
							<div class="form_option mf_link_disable" style="float:right;margin-right:5px;">
								<?php 
									if(empty($form_data['form_active'])){
										echo '<a href="#" class="btn btn-inverse">'.$lang['Enable'].'</a>';	
									}else{
										echo '<a href="#" class="btn btn-inverse">'.$lang['Disable'].'</a>';	
									}
								?>
							</div>
							<div class="form_option mf_link_edit" style="float:right;margin-right:5px;">
								<a class="btn btn-warning" href="edit_form.php?id=<?php echo $form_id; ?>"><?php echo $lang['Edit'] ; ?></a>
							</div>
							<div class="form_option mf_link_entries" style="float:right;margin-right:5px;">
								<a href="manage_entries.php?id=<?php echo $form_id; ?>" class="btn btn-primary"><?php echo $lang['Entries'] ; ?></a>
							</div>
							
							<div style="height: 0px; clear: both;"></div>
							<!--<div class="middle_form_bar">
								<h3><?php echo $form_name; ?></h3>
								<div class="form_meta">
									
									<?php if(!empty($total_entry)){ ?>
									<div class="form_stat form_stat_total" title="<?php echo $today_entry." entries today. Latest entry ".$latest_entry."."; ?>">
										<div class="form_stat_count"><?php echo $total_entry; ?></div>
										<div class="form_stat_msg">total</div>
									</div>
									<?php }else if(!empty($today_entry)){ ?>
									<div class="form_stat" title="<?php echo $today_entry." entries today. Latest entry ".$latest_entry."."; ?>">
										<div class="form_stat_count"><?php echo $today_entry; ?></div>
										<div class="form_stat_msg">today</div>
									</div>
									<?php } ?>
									
									<div class="form_tag">
										<ul class="form_tag_list">
											<li class="form_tag_list_icon"><a title="Add a Tag Name" class="addtag" id="addtag_<?php echo $form_id; ?>" href="#"><img src="images/icons/tag_plus.png" /></a></li>
							
											<?php 	
												if(!empty($form_tags_array)){
													foreach ($form_tags_array as $tagname){
														echo "<li>".htmlspecialchars($tagname)." <a class=\"removetag\" href=\"#\" title=\"Remove this tag.\"><img src=\"images/icons/53.png\" /></a></li>";
													}
												}
											?>
											
										</ul>
									</div>
								</div>
								<div style="height: 0px; clear: both;"></div>
							</div>
							-->
							
							
							
							
							<!--<div class="form_option mf_link_group">
								<a class="mf_link_emails" href="notification_settings.php?id=<?php echo $form_id; ?>">Emails</a>
								<a class="mf_link_code" href="embed_code.php?id=<?php echo $form_id; ?>">Code</a>
								<a class="mf_link_view" target="_blank" href="<?php echo $config->url_site ;?>/form.php?id=<?php echo $form_id; ?>">View</a>
							</div>-->
							
							
							
							<div style="height: 0px; clear: both;"></div>
						</li>
						
					<?php 
							$row_num++; 
						}//end foreach $form_list_array 
					?>
						
					</ul>
					<!--
					<div id="result_set_show_more">
						<a href="#">Show More Results...</a>
					</div>
					-->
					<!-- start pagination -->
					
					<?php echo $pagination_markup; ?>
					
					<!-- end pagination -->
					<?php }else{ ?>
					
							<div id="form_manager_empty">
								<h2>Welcome!</h2>
								<h3>You have no forms yet. Go create one by clicking the button above.</h3>
								<br /><br />
								<a href="edit_form.php" id="button_create_form" class="btn btn-large">
									Create New Form!
								</a>
							</div>	
					
					<?php } ?>
					
					
					<!-- start dialog boxes -->
					<div id="dialog-enter-tagname" title="Enter a Tag Name" class="buttons" style="display: none"> 
						<form id="dialog-enter-tagname-form" class="dialog-form" style="padding-left: 10px;padding-bottom: 10px">				
							<ul>
								<li>
									<div>
									<input type="text" value="" class="text" name="dialog-enter-tagname-input" id="dialog-enter-tagname-input" />
									<div class="infomessage"><img src="images/icons/70_green.png" style="vertical-align: middle"/> Tag name is optional. Use it when you have many forms, to group them into categories.</div>
									</div> 
								</li>
							</ul>
						</form>
					</div>
					<div id="dialog-confirm-form-delete" title="Are you sure you want to delete this form?" class="buttons" style="display: none">
						<img src="images/icons/hand.png" title="Confirmation" /> 
						<p>
							This action cannot be undone.<br/>
							<strong>All data and files collected by <span id="confirm_form_delete_name">this form</span> will be deleted as well.</strong><br/><br/>
							If you are sure with this, you can continue deleting this form.<br /><br />
						</p>
						
					</div>
					<div id="dialog-change-theme" title="Select a Theme" class="buttons" style="display: none"> 
						<form id="dialog-change-theme-form" class="dialog-form" style="padding-left: 10px;padding-bottom: 10px">				
							<ul>
								<li>
									<div>
										<select class="select full" id="dialog-change-theme-input" name="dialog-change-theme-input">
											<optgroup label="Your Themes">
												<?php 
													if(!empty($theme_list_array)){
														foreach ($theme_list_array as $theme_id=>$theme_name){
															echo "<option value=\"{$theme_id}\">{$theme_name}</option>";
														}
													}
												?>
												<option value="new">&#8674; Create New Theme!</option>
											</optgroup>
											<optgroup label="Built-in Themes">
												<option value="0">White (Default)</option>
												<?php 
													if(!empty($theme_builtin_list_array)){
														foreach ($theme_builtin_list_array as $theme_id=>$theme_name){
															echo "<option value=\"{$theme_id}\">{$theme_name}</option>";
														}
													}
												?>
											</optgroup>
										</select>
									</div> 
								</li>
							</ul>
						</form>
					</div>
					<!-- end dialog boxes -->
				
				</div> <!-- /end of content_body -->	
			
			</div><!-- /.post -->
		</div><!-- /#content -->


 
<?php

	if($highlight_selected_form_id == true){
		$highlight_selected_form_id = $selected_form_id;
	}else{
		$highlight_selected_form_id = 0;
	}

	$footer_data =<<< EOT
<script type="text/javascript">
	var selected_form_id_highlight = {$highlight_selected_form_id};
	$(function(){
		{$jquery_data_code}		
    });
</script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.sortable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.effects.scale.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.effects.highlight.js"></script>
<script type="text/javascript" src="js/jquery.highlight.js"></script>
EOT;

	require('includes/footer.php');
	
	
	/**** Helper Functions *******/
	
	function sort_by_today_entry($a, $b) {
    	return $b['today_entry'] - $a['today_entry'];
	}
	
	function sort_by_total_entry($a, $b) {
    	return $b['total_entry'] - $a['total_entry'];
	}
	
?>
<script>
jQuery.expr[":"].Contains=function(c,d,b){return jQuery(c).text().toUpperCase().indexOf(b[3].toUpperCase())>=0};jQuery.expr[":"].contains=function(c,d,b){return jQuery(c).text().toUpperCase().indexOf(b[3].toUpperCase())>=0};function reset_form_filter(){$("#mf_form_list > li").hide();$("#mf_pagination").show();if($("#mf_pagination > li.current_page").length>0){$($("#mf_pagination > li.current_page").data("liform_list")).show()}else{$("#mf_form_list > li").show()}$("#mf_form_list h3").unhighlight();$("ul.form_tag_list li").unhighlight();$("#filtered_result_box").fadeOut();$("#filtered_result_none").hide();$("#result_set_show_more").hide()}$(function(){$(".middle_form_bar > h3").click(function(){var a=$(this).parent().parent().attr("id");$("#"+a+" .form_option").slideToggle("medium");$("#"+a+" .form_option").promise().done(function(){$(this).parent().toggleClass("form_selected")})});$(".mf_link_disable a").click(function(){var d=$(this).parent().parent().attr("id");var a=d.split("_");var c=a[1];var b="";if($(this).text()=="Disable" || $(this).text()=="<?php echo $lang['Disable']; ?>"){b="disable"}else{if($(this).text()=="Enable" || $(this).text()=="<?php echo $lang['Enable']; ?>"){b="enable"}}if(b=="disable"||b=="enable"){$(this).text("<?php echo $lang['Loading']; ?>...");$(this).parent().css("position","relative");$(this).after('<img src="images/loader_small_grey.gif" style="position: absolute;margin-left: 12px" />');$.ajax({type:"POST",async:true,url:"toggle_form.php",data:{form_id:c,action:b},cache:false,global:true,dataType:"json",error:function(h,f,g){if(b=="disable"){b="<?php echo $lang['Disable']; ?>"}else{if(b=="Enable"){b="<?php echo $lang['Enable']; ?>"}}$("#"+d+" .mf_link_disable a").text(b);$("#"+d+" .mf_link_disable img").remove()},success:function(e){if(e.status=="ok"){if(e.action=="disable"){$("#liform_"+e.form_id).addClass("form_inactive");$("#liform_"+e.form_id+" .mf_link_disable a").text("<?php echo $lang['Enable']; ?>");$("#liform_"+e.form_id+" .mf_link_disable img").remove()}else{$("#liform_"+e.form_id).removeClass("form_inactive");$("#liform_"+e.form_id+" .mf_link_disable a").text("<?php echo $lang['Disable']; ?>");$("#liform_"+e.form_id+" .mf_link_disable img").remove()}$("#liform_"+e.form_id+" div.middle_form_bar").effect("highlight",{color:"#EDB817"},1500)}else{if(b=="disable"){b="Disable"}else{if(b=="Enable"){b="Enable"}}$("#"+d+" .mf_link_disable a").text(b);$("#"+d+" .mf_link_disable img").remove()}}})}return false});$("#mf_pagination > li").click(function(){var a=$(this).data("liform_list");$("#mf_form_list > li").hide();$(a).show();$("#mf_pagination > li.current_page").removeClass("current_page");$(this).addClass("current_page")});$("#filter_form_input").bind("focusin click",function(){if($("#filter_form_input").val()=="find form..."){$("#filter_form_input").val("");$("#mf_search_box,#filter_form_input").animate({width:"+=165px"},{duration:200,queue:false});$("#mf_search_box,#filter_form_input").promise().done(function(){$("#mf_search_title,#mf_search_tag").slideDown("medium");$("#mf_search_title,#mf_search_tag").promise().done(function(){$("#mf_search_box").addClass("search_focused");$("#mf_search_box,#filter_form_input").removeAttr("style")})})}$(".form_selected .form_option").hide();$(".form_selected").removeClass("form_selected")});$("#mf_search_title").click(function(){$(this).addClass("mf_pane_selected");$("#mf_search_title a").html("&#8674; form title");$("#mf_search_tag a").html("form tags");$("#mf_search_tag").removeClass("mf_pane_selected");$("#filter_form_input").val("");reset_form_filter();$("#filter_form_input").focus();return false});$("#mf_search_tag").click(function(){$(this).addClass("mf_pane_selected");$("#mf_search_tag a").html("&#8674; form tags");$("#mf_search_title a").html("form title");$("#mf_search_title").removeClass("mf_pane_selected");$("#filter_form_input").val("");reset_form_filter();$("#filter_form_input").focus();return false});$("#filter_form_input").keyup(function(){var d=$(this).val();var a=10;if(d!=""){$("#mf_form_list > li").removeClass("result_set").hide();$("#mf_pagination").hide();if($("#mf_search_title").hasClass("mf_pane_selected")){var c=$("#mf_form_list h3:contains('"+d+"')");c.parent().parent().show().addClass("result_set");c.unhighlight();c.highlight(d);$("#filtered_result_box span").text(d);$("#filtered_result_box").fadeIn();$("#filtered_result_total").text("Found "+c.length+" forms");if(c.length==0){$("#filtered_result_none").fadeIn()}else{$("#filtered_result_none").hide()}if(c.length>a){$("#result_set_show_more").show();$(".result_set:gt("+(a-1)+")").hide()}else{$("#result_set_show_more").hide()}}else{var b=$("ul.form_tag_list li:contains('"+d+"')");b.parent().parent().parent().parent().parent().show().addClass("result_set");b.unhighlight();b.highlight(d);$("#filtered_result_box span").text(d);$("#filtered_result_box").fadeIn();$("#filtered_result_total").text("Found "+b.length+" forms");if(b.length==0){$("#filtered_result_none").fadeIn()}else{$("#filtered_result_none").hide()}if(b.length>a){$("#result_set_show_more").show();$(".result_set:gt("+(a-1)+")").hide()}else{$("#result_set_show_more").hide()}}}else{reset_form_filter()}});$("#mf_filter_reset").click(function(){reset_form_filter();$("#mf_search_box").removeClass("search_focused");$("#mf_search_title,#mf_search_tag").hide();$("#filter_form_input").val("find form...");return false});$("#result_set_show_more > a").click(function(){var a=20;var d=$(".result_set:visible").last().index(".result_set");var c=d+1;var b=c+a;$(".result_set").slice(c,b).fadeIn();if(b>=$(".result_set").length){$("#result_set_show_more").hide()}return false});$("#dialog-enter-tagname").dialog({modal:true,autoOpen:false,closeOnEscape:false,width:400,position:["center",150],draggable:false,resizable:false,buttons:[{text:"Save Changes",id:"dialog-enter-tagname-btn-save-changes","class":"bb_button bb_small bb_green",click:function(){var a=parseInt($("#dialog-enter-tagname").data("form_id"));if($("#dialog-enter-tagname-input").val()==""){alert("Please enter a tag name!")}else{$(this).dialog("close");$("#liform_"+a+" ul.form_tag_list").append("<li class=\"processing\"><img src='images/loader_small_grey.gif' /></li>");$.ajax({type:"POST",async:true,url:"save_tags.php",data:{action:"add",form_id:a,tags:$("#dialog-enter-tagname-input").val()},cache:false,global:false,dataType:"json",error:function(d,b,c){$("#liform_"+a+" ul.form_tag_list li.processing").remove();alert("Error! Unable to add tag names. Please try again.")},success:function(b){if(b.status=="ok"){$("#liform_"+b.form_id+" li.form_tag_list_icon").siblings().remove();$("#liform_"+b.form_id+" ul.form_tag_list").append(b.tags_markup)}else{$("#liform_"+b.form_id+" ul.form_tag_list li.processing").remove();alert("Error! Unable to add tag names. Please try again.")}}})}}},{text:"Cancel",id:"dialog-enter-tagname-btn-cancel","class":"btn_secondary_action",click:function(){$(this).dialog("close")}}]});$("#dialog-enter-tagname-form").submit(function(){$("#dialog-enter-tagname-btn-save-changes").click();return false});$("ul.form_tag_list a.addtag").click(function(){var a=$(this).attr("id").split("_");$("#dialog-enter-tagname").data("form_id",a[1]);$("#dialog-enter-tagname-input").val("");$("#dialog-enter-tagname").dialog("open");return false});$("#mf_form_list").delegate("a.removetag","click",function(f){var d=$(this).parent().parent().closest("li").attr("id");var b=d.split("_");var a=parseInt(b[1]);var c=$(this).parent().text();var g=$(this).parent();if($(this).find("img").attr("src")!="images/loader_green_16.png"){$(this).find("img").attr("src","images/loader_green_16.png");$.ajax({type:"POST",async:true,url:"save_tags.php",data:{action:"delete",form_id:a,tags:c},cache:false,global:false,dataType:"json",error:function(j,h,i){g.find("img").attr("src","images/icons/53.png");alert("Error! Unable to delete tag name. Please try again.")},success:function(e){if(e.status=="ok"){g.fadeOut(function(){$(this).remove()})}else{g.find("img").attr("src","images/icons/53.png");alert("Error! Unable to delete tag name. Please try again.")}}})}return false});$("#dialog-enter-tagname-input").autocomplete({source:$("#dialog-enter-tagname-input").data("available_tags")});$(".mf_link_duplicate a").click(function(){var c=$(this).parent().parent().attr("id");var a=c.split("_");var b=a[1];if($(this).text()=="Duplicating..."){return false}$(this).text("Duplicating...");$(this).parent().css("position","relative");$(this).before('<img src="images/loader_small_grey.gif" style="position: absolute;margin-left: -28px" />');$.ajax({type:"POST",async:true,url:"duplicate_form.php",data:{form_id:b},cache:false,global:true,dataType:"json",error:function(g,d,f){$("#"+c+" .mf_link_duplicate a").text("Duplicate");$("#"+c+" .mf_link_duplicate img").remove();alert("Error! Unable to duplicate. Please try again.")},success:function(d){if(d.status=="ok"){window.location.replace("manage_forms.php?id="+d.form_id+"&hl=true")}else{$("#"+c+" .mf_link_duplicate a").text("Duplicate");$("#"+c+" .mf_link_duplicate img").remove();alert("Error! Unable to duplicate. Please try again.")}}});return false});if(selected_form_id_highlight>0){$("#liform_"+selected_form_id_highlight+" div.middle_form_bar").effect("highlight",{color:"#EDB817"},4000)}$("#dialog-confirm-form-delete").dialog({modal:true,autoOpen:false,closeOnEscape:false,width:550,position:["center","center"],draggable:false,resizable:false,open:function(){$("#btn-form-delete-ok").blur()},buttons:[{text:"Yes. Delete this form",id:"btn-form-delete-ok","class":"bb_button bb_small bb_green",click:function(){var a=parseInt($("#dialog-confirm-form-delete").data("form_id"));$("#dropui_theme_options div.dropui-content").attr("style","");$("#btn-form-delete-ok").prop("disabled",true);$("#btn-form-delete-cancel").hide();$("#btn-form-delete-ok").text("Deleting...");$("#btn-form-delete-ok").after("<div class='small_loader_box'><img src='images/loader_small_grey.gif' /></div>");$.ajax({type:"POST",async:true,url:"delete_form.php",data:{form_id:a},cache:false,global:false,dataType:"json",error:function(d,b,c){},success:function(b){if(b.status=="ok"){window.location.replace("manage_forms.php")}}})}},{text:"Cancel",id:"btn-form-delete-cancel","class":"btn_secondary_action",click:function(){$(this).dialog("close")}}]});$(".mf_link_delete a").click(function(){var c=$(this).parent().parent();var b=c.attr("id").split("_");var a=parseInt(b[1]);$("#confirm_form_delete_name").text(c.find("h3").text());$("#dialog-confirm-form-delete").data("form_id",a);$("#dialog-confirm-form-delete").dialog("open");return false});$("#dialog-change-theme").dialog({modal:true,autoOpen:false,closeOnEscape:false,width:400,position:["center","center"],draggable:false,resizable:false,buttons:[{text:"Save Changes",id:"btn-change-theme-ok","class":"bb_button bb_small bb_green",click:function(){var a=parseInt($("#dialog-change-theme").data("form_id"));$("#btn-change-theme-ok").prop("disabled",true);$("#btn-change-theme-cancel").hide();$("#btn-change-theme-ok").text("Applying Theme...");$("#btn-change-theme-ok").after("<div class='small_loader_box'><img src='images/loader_small_grey.gif' /></div>");$.ajax({type:"POST",async:true,url:"change_theme.php",data:{form_id:a,theme_id:$("#dialog-change-theme-input").val()},cache:false,global:false,dataType:"json",error:function(d,b,c){$("#btn-change-theme-cancel").show();$("#btn-change-theme-ok").text("Save Changes");$("#btn-change-theme-ok").next().remove();$("#btn-change-theme-ok").prop("disabled",false);alert("Error! Unable to apply the theme. Please try again.")},success:function(b){$("#btn-change-theme-cancel").show();$("#btn-change-theme-ok").text("Save Changes");$("#btn-change-theme-ok").next().remove();$("#btn-change-theme-ok").prop("disabled",false);if(b.status=="ok"){$("#liform_"+a).data("theme_id",$("#dialog-change-theme-input").val());$("#dialog-change-theme").dialog("close")}else{alert("Error! Unable to apply the theme. Please try again.")}}})}},{text:"Cancel",id:"btn-change-theme-cancel","class":"btn_secondary_action",click:function(){$(this).dialog("close")}}]});$(".mf_link_theme").click(function(){var c=$(this).parent().parent();var b=c.attr("id").split("_");var a=parseInt(b[1]);$("#dialog-change-theme").data("form_id",a);$("#dialog-change-theme-input").val(c.data("theme_id"));$("#dialog-change-theme").dialog("open");return false});$("#dialog-change-theme-input").bind("change",function(){if($(this).val()=="new"){window.location.replace("edit_theme.php")}})});
</script>