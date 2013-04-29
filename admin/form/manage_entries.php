<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/	
 define('SETTINGS','true');
	require('includes/init.php');
	
	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');

	require('includes/entry-functions.php');
	
	$form_id = (int) trim($_GET['id']);
	$sort_by = trim($_GET['sortby']);

	//get page number for pagination
	if (isset($_REQUEST['pageno'])) {
	   $pageno = $_REQUEST['pageno'];
	}else{
	   $pageno = 1;
	}

	
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	$query 	= "select 
					 form_name,
					 entries_sort_by,
					 entries_filter_type,
					 entries_enable_filter
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if(!empty($row)){
		$form_name = htmlspecialchars($row['form_name']);
		$entries_filter_type   = $row['entries_filter_type'];
		$entries_enable_filter = $row['entries_enable_filter'];
	}

	if(empty($sort_by)){
		//get the default sort element from the table
		$sort_by = $row['entries_sort_by'];
	}else{
		//if sort by parameter exist, save it into the database
		$query = "update ".MF_TABLE_PREFIX."forms set entries_sort_by = ? where form_id = ?";
		$params = array($sort_by,$form_id);
		mf_do_query($query,$params,$dbh);
	}

	$jquery_data_code = '';

	//get all available columns label
	$columns_meta  = mf_get_columns_meta($dbh,$form_id);
	$columns_label = $columns_meta['name_lookup'];
	$columns_type  = $columns_meta['type_lookup'];
	
	//get current column preference
	$query = "select element_name from ".MF_TABLE_PREFIX."column_preferences where form_id=?";
	$params = array($form_id);

	$sth = mf_do_query($query,$params,$dbh);
	while($row = mf_do_fetch_result($sth)){
		$current_column_preference[] = $row['element_name'];
	}


	//check if the table has entries or not
	$query = "select count(*) total_row from `".MF_TABLE_PREFIX."form_{$form_id}` where `status`=1";
	$params = array();
			
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
		
	if(!empty($row['total_row'])){
		$form_has_entries = true;
	}else{
		$form_has_entries = false;
	}

	//prepare the jquery data for column type lookup
	foreach ($columns_type as $element_name => $element_type) {
		if($element_type == 'checkbox'){
			if(substr($element_name, -5) == 'other'){
				$element_type = 'checkbox_other';
			}
		}

		$jquery_data_code .= "\$('#filter_pane').data('$element_name','$element_type');\n";
	}


	//get filter keywords from ap_form_filters table
	$query = "select
					element_name,
					filter_condition,
					filter_keyword
				from 
					".MF_TABLE_PREFIX."form_filters
			   where
			   		form_id = ?
			order by 
			   		aff_id asc";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);
	$i = 0;
	while($row = mf_do_fetch_result($sth)){
		$filter_data[$i]['element_name'] 	 = $row['element_name'];
		$filter_data[$i]['filter_condition'] = $row['filter_condition'];
		$filter_data[$i]['filter_keyword'] 	 = $row['filter_keyword'];
		$i++;
	}

			$header_data =<<<EOT
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link type="text/css" href="css/pagination_classic.css" rel="stylesheet" />
<link type="text/css" href="css/dropui.css" rel="stylesheet" />
<link type="text/css" href="js/datepick/smoothness.datepick.css" rel="stylesheet" />
EOT;
	
	$current_nav_tab = 'manage_forms';
	require('includes/header.php'); 
	
?>


		<div id="content" class="full">
			<div class="post manage_entries">
				
<ul class="breadcrumb" style="margin-top:14px;">
  <li>
    <a href="manage_forms.php"><?php echo $lang['Forms']; ?></a> <span class="divider">></span>
  </li>
  <li>
    <a href="#"><?php echo $lang['Entries']; ?></a> <span class="divider">></span>
  </li>
  <li class="active"><?php echo $form_name; ?></li>
</ul>

				<?php mf_show_message(); ?>

				<div class="content_body">
					
					<?php if($form_has_entries){ ?>
					
						<div id="entries_actions">
							<ul>
								<li>
									<a class="btn btn-danger" id="entry_delete" href="#"><?php echo $lang['Delete']; ?></a>
								</li>
								<li>&nbsp;</li>
								<li>
									<a class="btn btn-inverse" id="entry_export" href="#"><?php echo $lang['Export']; ?></a>
								</li>
							</ul>
						</div>
						<div id="entries_options" data-formid="<?php echo $form_id; ?>">
							<ul>
								<li>
									<a id="entry_select_field" class="btn btn-primary" href="#"><?php echo $lang['SelectFields']; ?></a>
								</li>
								<li>&nbsp;</li>
								<li>
									<a id="entry_filter" class="btn" href="#"><?php echo $lang['FilterEntries']; ?></a>
								</li>
							</ul>
						</div>

						<?php if(!empty($entries_enable_filter)){ ?>
							<div id="filter_info">
								Displaying filtered entries.  <a style="margin-left: 60px" id="me_edit_filter" href="#">Edit</a> or <a href="#" id="me_clear_filter">Clear Filter</a>
							</div>
						<?php } ?>
						
						<div style="clear: both"></div>
						<div id="field_selection" style="display: none" class="">
							<h6>Select fields to be displayed:</h6>
							<ul>
								<?php 
									foreach($columns_label as $element_name=>$element_label){
										if($element_name == 'id'){
											continue;
										}
										if(!empty($current_column_preference)){
											if(in_array($element_name,$current_column_preference)){
												$checked_tag = 'checked="checked"';
											}else{
												$checked_tag = '';
											}
										}
								?>
									<li>
										<input type="checkbox" value="1" <?php echo $checked_tag; ?> class="element checkbox" name="<?php echo $element_name; ?>" id="<?php echo $element_name; ?>">
										<?php echo $element_label; ?>
									</li>
								<? } ?>
							</ul>
							<div id="field_selection_apply">
									<input type="button" id="me_field_select_submit" value="<?php echo $lang['Apply']; ?>" class="btn"> <span id="cancel_field_select_span">or <a href="#" id="field_selection_cancel"><?php echo $lang['Cancel']; ?></a></span>
							</div>
							
						</div>

						<div id="filter_pane" style="display: none" class="">
							
							<h6>Display entries that match 
									<select style="margin-left: 5px;margin-right: 5px" name="filter_all_any" id="filter_all_any" class="element select"> 
										<option value="all" <?php if($entries_filter_type == 'all'){ echo 'selected="selected"'; } ?>>all</option>
										<option value="any" <?php if($entries_filter_type == 'any'){ echo 'selected="selected"'; } ?>>any</option>
									</select> 
								of the following conditions:
							</h6>
							
							<ul>

								<?php
									if(empty($filter_data)){
										$field_labels = array_slice($columns_label, 4);
										$entry_info_labels = array_slice($columns_label, 0,4);

										$temp_keys = array_keys($field_labels);
										$first_field_element_name = $temp_keys[0];
										$first_field_element_type = $columns_type[$first_field_element_name];
										
										if($first_field_element_type == 'checkbox'){
											if(substr($first_field_element_name, -5) == 'other'){
												$first_field_element_type = 'checkbox_other';
											}
										}

										if(in_array($first_field_element_type, array('money','number'))){
											$condition_text_display = 'display:none';
											$condition_number_display = '';
											$condition_date_display = 'display:none';
											$condition_file_display = 'display:none';
											$condition_checkbox_display = 'display:none';
											$filter_keyword_display = '';
										}else if(in_array($first_field_element_type, array('date','europe_date'))){
											$condition_text_display = 'display:none';
											$condition_number_display = 'display:none';
											$condition_date_display = '';
											$condition_file_display = 'display:none';
											$condition_checkbox_display = 'display:none';
											$filter_keyword_display = '';
											$filter_date_class = 'filter_date';
										}else if($first_field_element_type == 'file'){
											$condition_text_display = 'display:none';
											$condition_number_display = 'display:none';
											$condition_date_display = 'display:none';
											$condition_file_display = '';
											$condition_checkbox_display = 'display:none';
											$filter_keyword_display = '';
										}else if($first_field_element_type == 'checkbox'){
											$condition_text_display = 'display:none';
											$condition_number_display = 'display:none';
											$condition_date_display = 'display:none';
											$condition_file_display = 'display:none';
											$condition_checkbox_display = '';
											$filter_keyword_display = 'display:none';
										}else{
											$condition_text_display = '';
											$condition_number_display = 'display:none';
											$condition_date_display = 'display:none';
											$condition_file_display = 'display:none';
											$condition_checkbox_display = 'display:none';
											$filter_keyword_display = '';
										}

										//prepare the jquery data for the filter list
										$filter_properties = new stdClass();
										$filter_properties->element_name = $first_field_element_name;
										
										if($first_field_element_type == 'file'){
											$filter_properties->condition    = 'contains';
										}else{
											$filter_properties->condition    = 'is';
										}
										
										$filter_properties->keyword 	 = '';

										$json_filter_properties = json_encode($filter_properties);
										$jquery_data_code .= "\$('#li_1').data('filter_properties',{$json_filter_properties});\n";
								?>

								<li id="li_1" class="filter_settings <?php echo $filter_date_class; ?>">
									<select name="filterfield_1" id="filterfield_1" class="element select condition_fieldname" style="width: 260px"> 
										<optgroup label="Form Fields">
											<?php
												foreach ($field_labels as $element_name => $element_label) {
													echo "<option value=\"{$element_name}\">{$element_label}</option>\n";
												}
											?>
										</optgroup>
										<optgroup label="Entry Information">
											<?php
												foreach ($entry_info_labels as $element_name => $element_label) {
													echo "<option value=\"{$element_name}\">{$element_label}</option>\n";
												}
											?>
										</optgroup>
									</select> 
									<select name="conditiontext_1" id="conditiontext_1" class="element select condition_text" style="width: 120px;<?php echo $condition_text_display; ?>">
										<option value="is">Is</option>
										<option value="is_not">Is Not</option>
										<option value="begins_with">Begins with</option>
										<option value="ends_with">Ends with</option>
										<option value="contains">Contains</option>
										<option value="not_contain">Does not contain</option>
									</select>
									<select name="conditionnumber_1" id="conditionnumber_1" class="element select condition_number" style="width: 120px;<?php echo $condition_number_display; ?>">
										<option value="is">Is</option>
										<option value="less_than">Less than</option>
										<option value="greater_than">Greater than</option>
									</select>
									<select name="conditiondate_1" id="conditiondate_1" class="element select condition_date" style="width: 120px;<?php echo $condition_date_display; ?>">
										<option value="is">Is</option>
										<option value="is_before">Is Before</option>
										<option value="is_after">Is After</option>
									</select>
									<select name="conditionfile_1" id="conditionfile_1" class="element select condition_file" style="width: 120px;<?php echo $condition_file_display; ?>">
										<option value="contains">Contains</option>
										<option value="not_contain">Does not contain</option>
									</select>
									<select name="conditioncheckbox_1" id="conditioncheckbox_1" class="element select condition_checkbox" style="width: 120px;<?php echo $condition_checkbox_display; ?>">
										<option value="is_one">Is Checked</option>
										<option value="is_zero">Is Empty</option>
									</select>
									<input type="text" class="element text filter_keyword" value="" id="filterkeyword_1" style="<?php echo $filter_keyword_display; ?>">
									<input type="hidden" value="" name="datepicker_1" id="datepicker_1">
									<span style="display:none"><img id="datepickimg_1" alt="Pick date." src="images/icons/calendar.png" class="trigger filter_date_trigger" style="vertical-align: top; cursor: pointer" /></span>
									<a href="#" id="deletefilter_1" class="filter_delete_a"><img src="images/icons/51_blue_16.png" /></a>

								</li>

								<?php 
									} else { 
										
										$field_labels = array_slice($columns_label, 4);
										$entry_info_labels = array_slice($columns_label, 0,4);

										$i=1;
										$filter_properties = new stdClass();

										foreach ($filter_data as $value) {
											$field_element_type = $columns_type[$value['element_name']];
											
											if($field_element_type == 'checkbox'){
												if(substr($value['element_name'], -5) == 'other'){
													$field_element_type = 'checkbox_other';
												}
											}

											$filter_date_class = '';
											
											if(in_array($field_element_type, array('money','number'))){
												$condition_text_display = 'display:none';
												$condition_number_display = '';
												$condition_date_display = 'display:none';
												$condition_file_display = 'display:none';
												$condition_checkbox_display = 'display:none';
												$filter_keyword_display = '';
											}else if(in_array($field_element_type, array('date','europe_date'))){
												$condition_text_display = 'display:none';
												$condition_number_display = 'display:none';
												$condition_date_display = '';
												$condition_file_display = 'display:none';
												$condition_checkbox_display = 'display:none';
												$filter_keyword_display = '';
												$filter_date_class = 'filter_date';
											}else if($field_element_type == 'file'){
												$condition_text_display = 'display:none';
												$condition_number_display = 'display:none';
												$condition_date_display = 'display:none';
												$condition_file_display = '';
												$condition_checkbox_display = 'display:none';
												$filter_keyword_display = '';
											}else if($field_element_type == 'checkbox'){
												$condition_text_display = 'display:none';
												$condition_number_display = 'display:none';
												$condition_date_display = 'display:none';
												$condition_file_display = 'display:none';
												$condition_checkbox_display = '';
												$filter_keyword_display = 'display:none';
											}else{
												$condition_text_display = '';
												$condition_number_display = 'display:none';
												$condition_date_display = 'display:none';
												$condition_file_display = 'display:none';
												$condition_checkbox_display = 'display:none';
												$filter_keyword_display = '';
											}

											//prepare the jquery data for the filter list
											$filter_properties->element_name = $value['element_name'];
											$filter_properties->condition    = $value['filter_condition'];
											$filter_properties->keyword 	 = $value['filter_keyword'];

											$json_filter_properties = json_encode($filter_properties);
											$jquery_data_code .= "\$('#li_{$i}').data('filter_properties',{$json_filter_properties});\n";
								?>			

								<li id="li_<?php echo $i; ?>" class="filter_settings <?php echo $filter_date_class; ?>">
									<select name="filterfield_<?php echo $i; ?>" id="filterfield_<?php echo $i; ?>" class="element select condition_fieldname" style="width: 260px"> 
										<optgroup label="Form Fields">
											<?php
												foreach ($field_labels as $element_name => $element_label) {
													if($element_name == $value['element_name']){
														$selected_tag = 'selected="selected"';
													}else{
														$selected_tag = '';
													}
													echo "<option {$selected_tag} value=\"{$element_name}\">{$element_label}</option>\n";
												}
											?>
										</optgroup>
										<optgroup label="Entry Information">
											<?php
												foreach ($entry_info_labels as $element_name => $element_label) {
													if($element_name == $value['element_name']){
														$selected_tag = 'selected="selected"';
													}else{
														$selected_tag = '';
													}

													echo "<option {$selected_tag} value=\"{$element_name}\">{$element_label}</option>\n";
												}
											?>
										</optgroup>
									</select> 
									<select name="conditiontext_<?php echo $i; ?>" id="conditiontext_<?php echo $i; ?>" class="element select condition_text" style="width: 120px;<?php echo $condition_text_display; ?>">
										<option <?php if($value['filter_condition'] == 'is'){ echo 'selected="selected"'; } ?> value="is">Is</option>
										<option <?php if($value['filter_condition'] == 'is_not'){ echo 'selected="selected"'; } ?> value="is_not">Is Not</option>
										<option <?php if($value['filter_condition'] == 'begins_with'){ echo 'selected="selected"'; } ?> value="begins_with">Begins with</option>
										<option <?php if($value['filter_condition'] == 'ends_with'){ echo 'selected="selected"'; } ?> value="ends_with">Ends with</option>
										<option <?php if($value['filter_condition'] == 'contains'){ echo 'selected="selected"'; } ?> value="contains">Contains</option>
										<option <?php if($value['filter_condition'] == 'not_contain'){ echo 'selected="selected"'; } ?> value="not_contain">Does not contain</option>
									</select>
									<select name="conditionnumber_<?php echo $i; ?>" id="conditionnumber_<?php echo $i; ?>" class="element select condition_number" style="width: 120px;<?php echo $condition_number_display; ?>">
										<option <?php if($value['filter_condition'] == 'is'){ echo 'selected="selected"'; } ?> value="is">Is</option>
										<option <?php if($value['filter_condition'] == 'less_than'){ echo 'selected="selected"'; } ?> value="less_than">Less than</option>
										<option <?php if($value['filter_condition'] == 'greater_than'){ echo 'selected="selected"'; } ?> value="greater_than">Greater than</option>
									</select>
									<select name="conditiondate_<?php echo $i; ?>" id="conditiondate_<?php echo $i; ?>" class="element select condition_date" style="width: 120px;<?php echo $condition_date_display; ?>">
										<option <?php if($value['filter_condition'] == 'is'){ echo 'selected="selected"'; } ?> value="is">Is</option>
										<option <?php if($value['filter_condition'] == 'is_before'){ echo 'selected="selected"'; } ?> value="is_before">Is Before</option>
										<option <?php if($value['filter_condition'] == 'is_after'){ echo 'selected="selected"'; } ?> value="is_after">Is After</option>
									</select>
									<select name="conditionfile_<?php echo $i; ?>" id="conditionfile_<?php echo $i; ?>" class="element select condition_file" style="width: 120px;<?php echo $condition_file_display; ?>">
										<option <?php if($value['filter_condition'] == 'contains'){ echo 'selected="selected"'; } ?> value="contains">Contains</option>
										<option <?php if($value['filter_condition'] == 'not_contain'){ echo 'selected="selected"'; } ?> value="not_contain">Does not contain</option>
									</select>
									<select name="conditioncheckbox_<?php echo $i; ?>" id="conditioncheckbox_<?php echo $i; ?>" class="element select condition_checkbox" style="width: 120px;<?php echo $condition_checkbox_display; ?>">
										<option <?php if($value['filter_condition'] == 'is_one'){ echo 'selected="selected"'; } ?> value="is_one">Is Checked</option>
										<option <?php if($value['filter_condition'] == 'is_zero'){ echo 'selected="selected"'; } ?> value="is_zero">Is Empty</option>
									</select>
									<input type="text" class="element text filter_keyword" value="<?php echo htmlspecialchars($value['filter_keyword'],ENT_QUOTES); ?>" id="filterkeyword_<?php echo $i; ?>" style="<?php echo $filter_keyword_display; ?>">
									<input type="hidden" value="" name="datepicker_<?php echo $i; ?>" id="datepicker_<?php echo $i; ?>">
									<span style="display:none"><img id="datepickimg_<?php echo $i; ?>" alt="Pick date." src="images/icons/calendar.png" class="trigger filter_date_trigger" style="vertical-align: top; cursor: pointer" /></span>
									<a href="#" id="deletefilter_<?php echo $i; ?>" class="filter_delete_a"><img src="images/icons/51_blue_16.png" /></a>
								</li>
											
								
									
								<?php 	
										$i++;
										}//end foreach filter_data
									} //end else
								?>

								<li id="li_filter_add" class="filter_add">
									<a href="#" id="filter_add_a"><img src="images/icons/49_blue_16.png" /></a>
								</li>
							</ul>
							<div id="filter_pane_apply">
									<input type="button" id="me_filter_pane_submit" value="<?php echo $lang['ApplyFilter']; ?>" class="btn"> <span id="cancel_filter_pane_span">or <a href="#" id="filter_pane_cancel"><?php echo $lang['Cancel']; ?></a></span>
							</div>
						</div>

						<?php 
							$entries_options['page_number']   = $pageno; //set the page number to be displayed
							$entries_options['rows_per_page'] = 15; //set the maximum rows to be displayed each page

							//set the sorting options
							$exploded = explode('-', $sort_by);
							$entries_options['sort_element'] = $exploded[0]; //the element name, e.g. element_2
							$entries_options['sort_order']	 = $exploded[1]; //asc or desc

							//set filter options
							$entries_options['filter_data'] = $filter_data;
							$entries_options['filter_type'] = $entries_filter_type;
							

							echo mf_display_entries_table($dbh,$form_id,$entries_options); 
						?>
							
						
						<div id="me_sort_option">
							<label class="description" for="me_sort_by"><?php echo $lang['SortBy']; ?> &#8674; </label>
							<select class="element select" id="me_sort_by" name="me_sort_by"> 
								<optgroup label="Ascending">
									<?php 
										foreach ($columns_label as $element_name => $element_label) {

											//id is basically the same as date_created, but lot faster for sorting
											if($element_name == 'date_created'){
												$element_name = 'id'; 
											}

											if(strlen($element_label) > 40){
												$element_label = substr($element_label, 0, 40).'...';
											}

											if($sort_by == $element_name.'-asc'){
												$selected_tag = 'selected="selected"';
											}else{
												$selected_tag = '';
											}

											echo "<option {$selected_tag} value=\"{$element_name}-asc\">{$element_label}</option>\n";
										}
									?>
								</optgroup>
								<optgroup label="Descending">
									<?php 
										foreach ($columns_label as $element_name => $element_label) {

											//id is basically the same as date_created, but lot faster for sorting
											if($element_name == 'date_created'){
												$element_name = 'id';
												$element_label .= ' (Default)';
											}

											if(strlen($element_label) > 40){
												$element_label = substr($element_label, 0, 40).'...';
											}

											if($sort_by == $element_name.'-desc'){
												$selected_tag = 'selected="selected"';
											}else{
												$selected_tag = '';
											}

											echo "<option {$selected_tag} value=\"{$element_name}-desc\">{$element_label}</option>\n";
										}
									?>
								</optgroup>
							</select>
						</div>
					
					<?php } else { ?>
						
						<div id="entries_manager_empty">
								<h2><?php echo $lang['No Entries']; ?>.</h2>
								<h3><?php echo $lang['This form doesnt have any entries yet']; ?>.</h3>
						</div>	

					<?php } ?>

				</div> <!-- /end of content_body -->	
			
			</div><!-- /.post -->
		</div><!-- /#content -->

<div id="dialog-warning" title="Error Title" class="buttons" style="display: none">
	<img src="images/icons/warning.png" title="Warning" /> 
	<p id="dialog-warning-msg">
		Error
	</p>
</div>
<div id="dialog-export-entries" title="Select File Type" class="buttons" style="display: none">
	<ul>
		<li class="gradient_blue"><a id="export_as_excel" href="#" class="export_link">Excel File (.xls)</a></li>
		<li class="gradient_blue"><a id="export_as_csv" href="#" class="export_link">Comma Separated (.csv)</a></li>
		<li class="gradient_blue"><a id="export_as_txt" href="#" class="export_link">Tab Separated (.txt)</a></li>
	</ul>
</div>
<div id="dialog-confirm-entry-delete" title="Are you sure you want to delete selected entries?" class="buttons" style="display: none">
	<img src="images/icons/hand.png" title="Confirmation" /> 
	<p id="dialog-confirm-entry-delete-msg">
		This action cannot be undone.<br/>
		<strong id="dialog-confirm-entry-delete-info">Data and files associated with your selected entries will be deleted.</strong><br/><br/>
		If you are sure with this, you can continue with the deletion.<br /><br />
	</p>				
</div>
 
<?php
	$footer_data =<<<EOT
<script type="text/javascript">
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
<script type="text/javascript" src="js/datepick/jquery.datepick.js"></script>
<script type="text/javascript" src="js/manage_entries.js"></script>
EOT;

	require('includes/footer.php'); 
?>