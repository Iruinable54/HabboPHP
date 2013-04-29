<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
ini_set('display_errors', 0); 
ini_set('log_errors', 0); 
error_reporting(0);
 define('SETTINGS','true');
	require('includes/init.php');
	
	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');
	
	require('includes/language.php');
	require('includes/view-functions.php');

	
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	$form_id = (int) trim($_REQUEST['id']);
	$is_new_form = false;
	
	//check the form_id
	//if blank or zero, create a new form first, otherwise load the form
	if(empty($form_id)){
		$is_new_form = true;
		//insert into ap_forms table and set the status to draft
		//set the status within 'form_active' field
		//form_active: 0 - Inactive / Disabled temporarily
		//form_active: 1 - Active
		//form_active: 2 - Draft
		//form_active: 9 - Deleted
		
		$query = "INSERT INTO `".MF_TABLE_PREFIX."forms` (
							form_name,
							form_description,
							form_redirect,
							form_redirect_enable,
							form_active,
							form_success_message,
							form_password,
							form_frame_height,
							form_unique_ip,
							form_captcha,
							form_captcha_type,
							form_review,
							form_label_alignment,
							form_resume_enable,
							form_limit_enable,
							form_limit,
							form_language,
							form_schedule_enable,
							form_schedule_start_date,
							form_schedule_end_date,
							form_schedule_start_hour,
							form_schedule_end_hour,
							form_lastpage_title,
							form_submit_primary_text,
							form_submit_secondary_text,
							form_submit_primary_img,
							form_submit_secondary_img,
							form_submit_use_image,
							form_page_total,
							form_pagination_type,
							form_review_primary_text,
							form_review_secondary_text,
							form_review_primary_img,
							form_review_secondary_img,
							form_review_use_image,
							form_review_title,
							form_review_description
							)
					VALUES ('".$lang['UntitledForm']."',
							'".$lang['NoFormDescription']."',
							'',
							0,
							2,
							'".$lang['SuccessFormSubmit']."',
							'',
							0,
							0,
							0,
							'r',
							0,
							'top_label',
							0,
							0,
							0,
							'english',
							0,
							'',
							'',
							'',
							'',
							'".$lang['UntitledPage']."',
							'".$lang['Submit']."',
							'".$lang['Previous']."',
							'',
							'',
							0,
							1,
							'steps',
							'".$lang['Submit']."',
							'".$lang['Previous']."',
							'',
							'',
							0,
							'".$lang['ReviewYourEntry']."',
							'".$lang['PleaseVerifyBeforeSend']."'
						   );";
		mf_do_query($query,array(),$dbh);
		$form_id = (int) $dbh->lastInsertId();
	}else{
		//if this is an existing form, delete the previous unsaved form fields
		//IMPORTANT: for multi users version, the query condition need to be adjusted
		$query = "DELETE FROM `".MF_TABLE_PREFIX."form_elements` where form_id = ? AND element_status='2'";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
		
		//the ap_element_options table has "live" column, which has 3 possible values:
		// 0 - the option is being deleted
		// 1 - the option is active
		// 2 - the option is currently being drafted, not being saved yet and will be deleted by edit_form.php if the form is being edited the next time
		$query = "DELETE FROM `".MF_TABLE_PREFIX."element_options` where form_id = ? AND live='2'";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
	}
	//get the HTML markup of the form
	$markup = mf_display_raw_form($dbh,$form_id);
	
	//get the properties for each form field
	//get form data
	$query 	= "select 
					 form_name,
					 form_active,
					 form_description,
					 form_redirect,
					 form_redirect_enable,
					 form_success_message,
					 form_password,
					 form_unique_ip,
					 form_captcha,
					 form_captcha_type,
					 form_review,
					 form_resume_enable,
					 form_limit_enable,
					 form_limit,
					 form_language,
					 form_frame_height,
					 form_label_alignment,
					 form_lastpage_title,
					 form_schedule_enable,
					 form_schedule_start_date,
					 form_schedule_end_date,
					 form_schedule_start_hour,
					 form_schedule_end_hour,
					 form_submit_primary_text,
					 form_submit_secondary_text,
					 form_submit_primary_img,
					 form_submit_secondary_img,
					 form_submit_use_image,
					 form_page_total,
					 form_pagination_type,
					 form_review_primary_text,
					 form_review_secondary_text,
					 form_review_primary_img,
					 form_review_secondary_img,
					 form_review_use_image,
					 form_review_title,
					 form_review_description
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	$form = new stdClass();
	if(!empty($row)){
		$form->id 				= $form_id;
		$form->name 			= $row['form_name'];
		$form->active 			= (int) $row['form_active'];
		$form->description 		= $row['form_description'];
		$form->redirect 		= $row['form_redirect'];
		$form->redirect_enable 	= (int) $row['form_redirect_enable'];
		$form->success_message  = $row['form_success_message'];
		$form->password 		= $row['form_password'];
		$form->frame_height 	= $row['form_frame_height'];
		$form->unique_ip 		= (int) $row['form_unique_ip'];
		$form->captcha 			= (int) $row['form_captcha'];
		$form->captcha_type 	= $row['form_captcha_type'];
		$form->review 			= (int) $row['form_review'];
		$form->resume_enable 	= (int) $row['form_resume_enable'];
		$form->limit_enable 	= (int) $row['form_limit_enable'];
		$form->limit 			= (int) $row['form_limit'];
		$form->label_alignment	= $row['form_label_alignment'];
		$form->schedule_enable 	= (int) $row['form_schedule_enable'];
		
		if(empty($row['form_language'])){
			$form->language		= 'english';
		}else{
			$form->language		= $row['form_language'];
		}
		
		$form->schedule_start_date  = $row['form_schedule_start_date'];
		if(!empty($row['form_schedule_start_hour'])){
			$form->schedule_start_hour  = date('h:i:a',strtotime($row['form_schedule_start_hour']));
		}else{
			$form->schedule_start_hour  = '';
		}
		$form->schedule_end_date  	= $row['form_schedule_end_date'];
		if(!empty($row['form_schedule_end_hour'])){
			$form->schedule_end_hour  	= date('h:i:a',strtotime($row['form_schedule_end_hour']));
		}else{
			$form->schedule_end_hour	= '';
		}
		$form_lastpage_title		= $row['form_lastpage_title'];
		$form_submit_primary_text 	= $row['form_submit_primary_text'];
		$form_submit_secondary_text = $row['form_submit_secondary_text'];
		$form_submit_primary_img 	= $row['form_submit_primary_img'];
		$form_submit_secondary_img  = $row['form_submit_secondary_img'];
		$form_submit_use_image  	= (int) $row['form_submit_use_image'];
		$form->page_total			= (int) $row['form_page_total'];
		$form->pagination_type		= $row['form_pagination_type'];
		
		$form->review_primary_text 	 = $row['form_review_primary_text'];
		$form->review_secondary_text = $row['form_review_secondary_text'];
		$form->review_primary_img 	 = $row['form_review_primary_img'];
		$form->review_secondary_img  = $row['form_review_secondary_img'];
		$form->review_use_image  	 = (int) $row['form_review_use_image'];
		$form->review_title			 = $row['form_review_title'];
		$form->review_description	 = $row['form_review_description'];
	} 
	
	//get element options first and store it into array
	$query = "select 
					element_id,
					option_id,
					`position`,
					`option`,
					option_is_default 
			    from 
			    	".MF_TABLE_PREFIX."element_options 
			   where 
			   		form_id = ? and live=1 
			order by 
					element_id asc,`position` asc";
	$params = array($form_id);
	$sth 	= mf_do_query($query,$params,$dbh);
	
	while($row = mf_do_fetch_result($sth)){
		$element_id = $row['element_id'];
		$option_id  = $row['option_id'];
		$options_lookup[$element_id][$option_id]['position'] 		  = $row['position'];
		$options_lookup[$element_id][$option_id]['option'] 			  = $row['option'];
		$options_lookup[$element_id][$option_id]['option_is_default'] = $row['option_is_default'];
	}
	
	//get the last option id for each options and store it into array
	//we need it when the user adding a new option, so that we could assign the last option id + 1
	$query = "select 
					element_id,
					max(option_id) as last_option_id 
			    from 
			    	".MF_TABLE_PREFIX."element_options 
			   where 
			   		form_id = ? 
			group by 
					element_id";
	$params = array($form_id);
	$sth 	= mf_do_query($query,$params,$dbh);
	
	while($row = mf_do_fetch_result($sth)){
		$element_id = $row['element_id'];
		$last_option_id_lookup[$element_id] = $row['last_option_id'];
	}

	
	//get elements data
	$element = array();
	$query = "select 
					element_id,
					element_title,
					element_guidelines,
					element_size,
					element_is_required,
					element_is_unique,
					element_is_private,
					element_type,
					element_position,
					element_default_value,
					element_constraint,
					element_css_class,
					element_range_min,
					element_range_max,
					element_range_limit_by,
					element_choice_columns,
					element_choice_has_other,
					element_choice_other_label,
					element_time_showsecond, 
					element_time_24hour,
					element_address_hideline2,
					element_address_us_only,
					element_date_enable_range,
					element_date_range_min,
					element_date_range_max,
					element_date_enable_selection_limit,
					element_date_selection_max,
					element_date_disable_past_future,
					element_date_past_future,
					element_date_disable_weekend,
					element_date_disable_specific,
					element_date_disabled_list,
					element_file_enable_type_limit,
					element_file_block_or_allow,
					element_file_type_list,
					element_file_as_attachment,
					element_file_enable_advance,
					element_file_auto_upload,
					element_file_enable_multi_upload,
					element_file_max_selection,
					element_file_enable_size_limit,
					element_file_size_max,
					element_submit_use_image,
					element_submit_primary_text,
					element_submit_secondary_text,
					element_submit_primary_img,
					element_submit_secondary_img,
					element_page_title,
					element_matrix_allow_multiselect,
					element_matrix_parent_id 
				from 
					".MF_TABLE_PREFIX."form_elements 
			   where 
			   		form_id = ? and element_status='1'
			order by 
					element_position asc";
	$params = array($form_id);
	$sth 	= mf_do_query($query,$params,$dbh);
	
	$j=0;
	while($row = mf_do_fetch_result($sth)){
		$element_id = $row['element_id'];
		
		//lookup element options first
		$option_id_array = array();
		$element_options = array();
		
		if(!empty($options_lookup[$element_id])){
			
			$i=1;
			foreach ($options_lookup[$element_id] as $option_id=>$data){
				$element_options[$option_id] = new stdClass();
				$element_options[$option_id]->position 	 = $i;
				$element_options[$option_id]->option 	 = $data['option'];
				$element_options[$option_id]->is_default = $data['option_is_default'];
				$element_options[$option_id]->is_db_live = 1;
				
				$option_id_array[$element_id][$i] = $option_id;
				
				$i++;
			}
		}
		
	
		//populate elements
		$element[$j] = new stdClass();
		$element[$j]->title 		= $row['element_title'];
		$element[$j]->guidelines 	= $row['element_guidelines'];
		$element[$j]->size 			= $row['element_size'];
		$element[$j]->is_required 	= $row['element_is_required'];
		$element[$j]->is_unique 	= $row['element_is_unique'];
		$element[$j]->is_private 	= $row['element_is_private'];
		$element[$j]->type 			= $row['element_type'];
		$element[$j]->position 		= $row['element_position'];
		$element[$j]->id 			= $row['element_id'];
		$element[$j]->is_db_live 	= 1;
		$element[$j]->default_value = $row['element_default_value'];
		$element[$j]->constraint 	= $row['element_constraint'];
		$element[$j]->css_class 	= $row['element_css_class'];
		$element[$j]->range_min 	= (int) $row['element_range_min'];
		$element[$j]->range_max 	= (int) $row['element_range_max'];
		$element[$j]->range_limit_by	 = $row['element_range_limit_by'];
		$element[$j]->choice_columns	 = (int) $row['element_choice_columns'];
		$element[$j]->choice_has_other	 = (int) $row['element_choice_has_other'];
		$element[$j]->choice_other_label = $row['element_choice_other_label'];
		$element[$j]->time_showsecond	 = (int) $row['element_time_showsecond'];
		$element[$j]->time_24hour	 	 = (int) $row['element_time_24hour'];
		$element[$j]->address_hideline2	 = (int) $row['element_address_hideline2'];
		$element[$j]->address_us_only	 = (int) $row['element_address_us_only'];
		$element[$j]->date_enable_range	 = (int) $row['element_date_enable_range'];
		$element[$j]->date_range_min	 = $row['element_date_range_min'];
		$element[$j]->date_range_max	 = $row['element_date_range_max'];
		$element[$j]->date_enable_selection_limit	= (int) $row['element_date_enable_selection_limit'];
		$element[$j]->date_selection_max	 		= (int) $row['element_date_selection_max'];
		$element[$j]->date_disable_past_future	 	= (int) $row['element_date_disable_past_future'];
		$element[$j]->date_past_future	 			= $row['element_date_past_future'];
		$element[$j]->date_disable_weekend	 		= (int) $row['element_date_disable_weekend'];
		$element[$j]->date_disable_specific	 		= (int) $row['element_date_disable_specific'];
		$element[$j]->date_disabled_list	 		= $row['element_date_disabled_list'];					
		$element[$j]->file_enable_type_limit	 	= (int) $row['element_file_enable_type_limit'];						
		$element[$j]->file_block_or_allow	 		= $row['element_file_block_or_allow'];
		$element[$j]->file_type_list	 			= $row['element_file_type_list'];
		$element[$j]->file_as_attachment	 		= (int) $row['element_file_as_attachment'];	
		$element[$j]->file_enable_advance	 		= (int) $row['element_file_enable_advance'];	
		$element[$j]->file_auto_upload	 			= (int) $row['element_file_auto_upload'];
		$element[$j]->file_enable_multi_upload	 	= (int) $row['element_file_enable_multi_upload'];
		$element[$j]->file_max_selection	 		= (int) $row['element_file_max_selection'];
		$element[$j]->file_enable_size_limit	 	= (int) $row['element_file_enable_size_limit'];
		$element[$j]->file_size_max	 				= (int) $row['element_file_size_max'];
		$element[$j]->submit_use_image	 			= (int) $row['element_submit_use_image'];
		$element[$j]->submit_primary_text	 		= $row['element_submit_primary_text'];
		$element[$j]->submit_secondary_text	 		= $row['element_submit_secondary_text'];
		$element[$j]->submit_primary_img	 		= $row['element_submit_primary_img'];
		$element[$j]->submit_secondary_img	 		= $row['element_submit_secondary_img'];
		$element[$j]->page_title	 				= $row['element_page_title'];
		$element[$j]->matrix_allow_multiselect	 	= (int) $row['element_matrix_allow_multiselect'];
		$element[$j]->matrix_parent_id	 			= (int) $row['element_matrix_parent_id'];

						 
		
		if(!empty($element_options)){
			$element[$j]->options 	= $element_options;
			$element[$j]->last_option_id = $last_option_id_lookup[$element_id];
		}else{
			$element[$j]->options 	= '';
		}
		
		//if the element is a matrix field and not the parent, store the data into a lookup array for later use when rendering the markup
		if($row['element_type'] == 'matrix' && !empty($row['element_matrix_parent_id'])){
				
				$parent_id 	  = $row['element_matrix_parent_id'];
				$row_position = count($matrix_elements[$parent_id]) + 2;
				$element_id   = $row['element_id'];
				
				$matrix_elements[$parent_id][$element_id] = new stdClass();
				$matrix_elements[$parent_id][$element_id]->is_db_live = 1;
				$matrix_elements[$parent_id][$element_id]->position   = $row_position;
				$matrix_elements[$parent_id][$element_id]->row_title  = $row['element_title'];
				
				$column_data = array();
				$col_position = 1;
				foreach ($element_options as $option_id=>$value){
					$column_data[$option_id] = new stdClass();
					$column_data[$option_id]->is_db_live = 1;
					$column_data[$option_id]->position 	 = $col_position;
					$column_data[$option_id]->column_title 	= $value->option;
					$col_position++;
				}
				
				$matrix_elements[$parent_id][$element_id]->column_data = $column_data;
				
				//remove it from the main element array
				$element[$j] = array();
				unset($element[$j]);
				$j--;
		}
		
		$j++;
	}
	
	//if this is multipage form, add the lastpage submit property into the element list
	if($form->page_total > 1){
		$element[$j]->id 		 = 'lastpage';
		$element[$j]->type 		 = 'page_break';
		$element[$j]->page_title = $form_lastpage_title;
		$element[$j]->submit_primary_text	 		= $form_submit_primary_text;
		$element[$j]->submit_secondary_text	 		= $form_submit_secondary_text;
		$element[$j]->submit_primary_img	 		= $form_submit_primary_img;
		$element[$j]->submit_secondary_img	 		= $form_submit_secondary_img;
		$element[$j]->submit_use_image	 			= $form_submit_use_image;
	}

		
	$jquery_data_code = '';
	
	//build the json code for form fields
	$all_element = array('elements' => $element);
	foreach ($element as $data){
		//if this is matrix element, attach the children data into options property and merge with current (matrix parent) options
		if($data->type == 'matrix'){
			$matrix_elements[$data->id][$data->id] = new stdClass();
			$matrix_elements[$data->id][$data->id]->is_db_live = 1;
			$matrix_elements[$data->id][$data->id]->position   = 1;
			$matrix_elements[$data->id][$data->id]->row_title  = $data->title;
				
			$column_data = array();
			$col_position = 1;
			foreach ($data->options as $option_id=>$value){
				$column_data[$option_id] = new stdClass();
				$column_data[$option_id]->is_db_live = 1;
				$column_data[$option_id]->position 	 = $col_position;
				$column_data[$option_id]->column_title 	= $value->option;
				$col_position++;
			}
				
			$matrix_elements[$data->id][$data->id]->column_data = $column_data;

			$temp_array = array();
			$temp_array = $matrix_elements[$data->id];
			
			asort($temp_array);
			
			$matrix_elements[$data->id] = array();
			$matrix_elements[$data->id] = $temp_array;
			
			$data->options = array();
			$data->options = $matrix_elements[$data->id];
			
		}
		$field_settings = json_encode($data);
		$jquery_data_code .= "\$('#li_{$data->id}').data('field_properties',{$field_settings});\n";
	}

	
	//build the json code for form settings
	$json_form = json_encode($form);
	$jquery_data_code .= "\$('#form_header').data('form_properties',{$json_form});\n";
	
	
	
	$header_data =<<<EOT
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link type="text/css" href="css/edit_form.css" rel="stylesheet" />
<link type="text/css" href="js/datepick/smoothness.datepick.css" rel="stylesheet" />
EOT;
	
	$current_nav_tab = 'manage_forms';
	
	require('includes/header.php'); 
?>

 		<div id="editor_loading">
 			<?php echo $lang['Loading']; ?>
 		</div>
		
		<div id="content">
		<div class="post form_editor">
		<img id="selected_field_image" src="images/icons/arrow.gif">			
		<img id="selected_field_image2" src="images/icons/arrow.gif">
		

<?php 
	echo $markup;
	
?>

		<div id="bottom_bar" style="display: none">
				<div class="bottom_bar_side">
				</div>
				<div id="bottom_bar_content" class="form-actions">
						 
						<a id="bottom_bar_save_form" href="#" class="btn btn-large btn-primary" style="" alt="Save Form" title="Save Form">
					        <?php echo $lang['SaveForm']; ?>
					    </a>
					    
					    <div id="bottom_bar_field_action">
						  	<img src="images/icons/arrow.gif" style="float: left" alt=""/> 
						    <a id="bottom_bar_duplicate_field" href="#" class="positive" alt="Duplicate Selected Field" title="Duplicate Selected Field">
						        <img src="images/icons/page_copy.png" />
						        <?php echo $lang['Duplicate']; ?>
						    </a>
						    
						    <a id="bottom_bar_delete_field" href="#" class="negative" alt="Delete Selected Field" title="Delete Selected Field">
						        <img src="images/icons/delete.png" alt=""/> 
						        <?php echo $lang['Delete']; ?>
						    </a>
					   </div> 
				</div>
				<div id="bottom_bar_loader">
					<span>
						<img src="images/loader.gif" width="32" height="32"/>
						<span id="bottom_bar_msg"><?php echo $lang['Loading']; ?></span>
					</span>
				</div>
				<div class="bottom_bar_side">
				</div>
		</div>	
		<div id="bottom_bar_limit"></div>
<?php if($is_new_form){ ?>		
		<div id="no_fields_notice">
			<img src="images/icons/arrow_border_right.png" style="padding-bottom: 20px"/>
			<h3><?php echo $lang['FormNoFieldsYet']; ?></h3>
			<p><?php echo $lang['NoFieldsYetInfo']; ?></p>
		</div>			
<?php } ?>        
        </div>   	
			 
		</div><!-- /#content -->
		
		<div id="sidebar">
			<div id="builder_tabs">
								<ul id="builder_tabs_btn" style="display: none">
									<li id="btn_add_field"><a onclick="$('#builder_tabs_btn > li').css({background:'#fff'});$('#btn_add_field').css({background:'#f9f9f9'});" href="#tab_add_field"><?php echo $lang['AddAField']; ?></a></li>
									<li id="btn_field_properties"><a onclick="$('#builder_tabs_btn > li').css({background:'#fff'});$('#btn_field_properties').css({background:'#f9f9f9'});" href="#tab_field_properties"><?php echo $lang['FieldProperties']; ?></a></li>
									<li id="btn_form_properties"><a onclick="$('#builder_tabs_btn > li').css({background:'#fff'});$('#btn_form_properties').css({background:'#f9f9f9'});" href="#tab_form_properties"><?php echo $lang['FormProperties']; ?></a></li>
								</ul>
								<div id="tab_add_field">
									<div id="social" class="box">
										<ul>   		
											<li id="btn_single_line_text" class="box">
												<a id="a_single_line_text" href="#" title="Single Line Text">
													<img src="images/icons/single_line_text.png" alt="Single Line Text" />
													<span class="blabel"><?php echo $lang['Text']; ?></span>
												</a>
											</li>     
											  
											<li id="btn_number" class="box">
												<a id="a_number" href="#" title="Number">
													<img src="images/icons/number.png" alt="Number" />
													<span class="blabel"><?php echo $lang['Number']; ?></span>
												</a>
											</li>     
								          	
								          	<li id="btn_paragraph_text" class="box">
												<a id="a_paragraph_text" href="#" title="Paragraph Text">
													<img src="images/icons/paragraph.png" alt="Paragraph Text" />
													<span class="blabel"><?php echo $lang['Paragraph']; ?></span>
												</a>
											</li>     
											<li id="btn_checkboxes" class="box">
												<a id="a_checkboxes" href="#" title="Checkboxes">
													<img src="images/icons/checkbox.png" alt="Checkboxes" />
													<span class="blabel"><?php echo $lang['Checkboxes']; ?></span>
												</a>
											</li>   	
											
											<li id="btn_multiple_choice" class="box">
												<a id="a_multiple_choice" href="#" title="Multiple Choice">
													<img src="images/icons/multiple_choice.png" alt="Multiple Choice" />
													<span class="blabel"><?php echo $lang['Multiple_Choice']; ?></span>
												</a>
											</li>     
											  
											<li id="btn_drop_down" class="box">
												<a id="a_drop_down" href="#" title="Drop Down">
													<img src="images/icons/dropdown.png" alt="Drop Down" />
													<span class="blabel"><?php echo $lang['Drop_Down']; ?></span>
												</a>
											</li>     
								          	
								          	<li id="btn_name" class="box">
												<a id="a_name" href="#" title="Name">
													<img src="images/icons/name.png" alt="Name" />
													<span class="blabel"><?php echo $lang['NameInput']; ?></span>
												</a>
											</li>     
											<li id="btn_date" class="box">
												<a id="a_date" href="#" title="Date">
													<img src="images/icons/date.png" alt="Date" />
													<span class="blabel"><?php echo $lang['Date']; ?></span>
												</a>
											</li>   	
											
											<li id="btn_time" class="box">
												<a id="a_time" href="#" title="Time">
													<img src="images/icons/time.png" alt="Time" />
													<span class="blabel"><?php echo $lang['Time']; ?></span>
												</a>
											</li>     
											  
											<li id="btn_phone" class="box">
												<a id="a_phone" href="#" title="Phone">
													<img src="images/icons/phone.png" alt="Phone" />
													<span class="blabel"><?php echo $lang['Phone']; ?></span>
												</a>
											</li>     
								          	
								          	<li id="btn_address" class="box">
												<a id="a_address" href="#" title="Address">
													<img src="images/icons/address.png" alt="Address" />
													<span class="blabel"><?php echo $lang['Adress']; ?></span>
												</a>
											</li>     
											<li id="btn_website" class="box">
												<a id="a_website" href="#" title="Web Site">
													<img src="images/icons/website.png" alt="Web Site" />
													<span class="blabel"><?php echo $lang['WebSite']; ?></span>
												</a>
											</li>   	
											
											<li id="btn_price" class="box">
												<a id="a_price" href="#" title="Price">
													<img src="images/icons/price.png" alt="Price" />
													<span class="blabel"><?php echo $lang['Price']; ?></span>
												</a>
											</li>     
											  
											<li id="btn_email" class="box">
												<a  id="a_email" href="#" title="Email">
													<img src="images/icons/email.png" alt="Email" />
													<span class="blabel"><?php echo $lang['Email']; ?></span>
												</a>
											</li>     
								          	
								          	<li id="btn_matrix" class="box">
												<a id="a_matrix" href="#" title="Matrix Choice">
													<img src="images/icons/matrix.png" alt="Matrix" />
													<span class="blabel"><?php echo $lang['MatrixChoice']; ?></span>
												</a>
											</li>     
											<li id="btn_file_upload" class="box">
												<a id="a_file_upload" href="#" title="File Upload">
													<img src="images/icons/file_upload.png" alt="File Upload" />
													<span class="blabel"><?php echo $lang['FileUpload']; ?></span>
												</a>
											</li>  
											<li id="btn_section_break" class="box">
												<a id="a_section_break" href="#" title="Section Break">
													<img src="images/icons/section_break.png" alt="Section Break" />
													<span class="blabel"><?php echo $lang['SectionBreak']; ?></span>
												</a>
											</li>     
											<li id="btn_page_break" class="box">
												<a id="a_page_break" href="#" title="Page Break">
													<img src="images/icons/page_break.png" alt="Page Break" />
													<span class="blabel"><?php echo $lang['PageBreak']; ?></span>
												</a>
											</li>   	
								
											 
								
								       			
					</ul>
										
					<div class="clear"></div>
									
			</div><!-- /#social -->
		</div>
				
		<div id="tab_field_properties" style="display: none">
			<div id="field_properties_pane" class="box"> <!-- Start field properties pane -->
				<form style="display: block;" id="element_properties" action="" onsubmit="return false;">
					
					<div id="element_inactive_msg">
						<div class="bullet_bar_top">
						</div>
						
						<img src="images/icons/arrow_border_left.png" style="margin-top: 80px" />
						<h3><?php echo $lang['SelectAField']; ?></h3>
						<p id="eim_p"><?php echo $lang['ChooseOnLeftToConfigure']; ?></p>
						 
						<div class="bullet_bar_bottom">
						</div>
					</div>
					
					<div id="element_properties_form">
						<div class="bullet_bar_top">
						</div>
						<div class="num" id="element_position">12</div>
						<ul id="all_properties">
						<li id="prop_element_label">
								<label class="desc" for="element_label"><?php echo $lang['FieldLabel']; ?> <img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="<?php echo $lang['FieldLabel']; ?> is one or two words placed directly above the field."/>
								</label>
								<textarea id="element_label" name="element_label" class="textarea" /></textarea>
						</li>
						
						<li class="leftCol" id="prop_element_type">
							<label class="desc" for="element_type">
							Field Type 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Field Type detemines what kind of data can be collected by your field. After you save the form, the field type cannot be changed."/>
							</label>
							<select class="select full" id="element_type" name="element_type" autocomplete="off" tabindex="12">
							<option value="text">Single Line Text</option>
							<option value="textarea">Paragraph Text</option>
							<option value="radio">Multiple Choice</option>
							<option value="checkbox">Checkboxes</option>
							<option value="select">Drop Down</option>
							<option value="number">Number</option>
							<option value="simple_name">Name</option>
							<option value="date">Date</option>
							<option value="time">Time</option>
							<option value="phone">Phone</option>
							<option value="money">Price</option>
							<option value="url">Web Site</option>
							<option value="email">Email</option>
							<option value="address">Address</option>
							<option value="file">File Upload</option>
							<option value="section">Section Break</option>
							<option value="matrix">Matrix Choice</option>
							</select>
						</li>
						
						<li class="rightCol" id="prop_element_size">
							<label class="desc" for="element_size">
							Field Size 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This property set the visual appearance of the field in your form. It does not limit nor increase the amount of data that can be collected by the field."/>
							</label>
							<select class="select full" id="element_size" autocomplete="off" tabindex="13">
							<option value="small">Small</option>
							<option value="medium">Medium</option>
							<option value="large">Large</option>
							</select>
						</li>
						
						<li class="rightCol" id="prop_choice_columns">
							<label class="desc" for="element_choice_columns">
							Choice Columns 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Set the number of columns being used to display the choices. Inline columns means the choices are sitting next to each other."/>
							</label>
							<select class="select full" id="element_choice_columns" autocomplete="off">
							<option value="1">One Column</option>
							<option value="2">Two Columns</option>
							<option value="3">Three Columns</option>
							<option value="9">Inline</option>
							</select>
						</li>
						
						<li class="rightCol" id="prop_date_format">
							<label class="desc" for="field_size">
							Date Format 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can choose between American and European Date Formats"/>
							</label>
							<select class="select full" id="date_type" autocomplete="off">
							<option id="element_date" value="date">MM / DD / YYYY</option>
							<option id="element_europe_date" value="europe_date">DD / MM / YYYY</option>
							</select>
						</li>
						
						<li class="rightCol" id="prop_name_format">
							<label class="desc" for="name_format">
							Name Format 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Two format available. A normal name field, or an extended name field with title and suffix."/>
							</label>
							<select class="select full" id="name_format" autocomplete="off">
							<option id="element_simple_name" value="simple_name" selected="selected">Normal</option>
							<option id="element_name" value="name" selected="selected">Normal + Title</option>
							<option id="element_simple_name_wmiddle" value="simple_name_wmiddle" selected="selected">Full</option>
							<option id="element_name_wmiddle" value="name_wmiddle">Full + Title</option>
							</select>
						</li>
						
						<li class="rightCol" id="prop_phone_format">
							<label class="desc" for="field_size">
							Phone Format 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can choose between American and International Phone Formats"/>
							</label>
							<select class="select full" id="phone_format" name="phone_format" autocomplete="off">
							<option id="element_phone" value="phone">### - ### - ####</option>
							<option id="element_simple_phone" value="simple_phone">International</option>
							</select>
						</li>
						
						<li class="rightCol" id="prop_currency_format">
							<label class="desc" for="field_size">
							Currency Format
							</label>
							<select class="select full" id="money_format" name="money_format" autocomplete="off">
							<option id="element_money_usd" value="dollar">&#36; - Dollars</option>
							<option id="element_money_euro" value="euro">&#8364; - Euros</option>
							<option id="element_money_pound" value="pound">&#163; - Pounds Sterling</option>
							<option id="element_money_yen" value="yen">&#165; - Yen</option>
							<option id="element_money_baht" value="baht">&#3647; - Baht</option>
							<option id="element_money_forint" value="forint">&#70;&#116; - Forint</option>
							<option id="element_money_franc" value="franc">CHF - Francs</option>
							<option id="element_money_koruna" value="koruna">&#75;&#269; - Koruna</option>
							<option id="element_money_krona" value="krona">kr - Krona</option>
							<option id="element_money_pesos" value="pesos">&#36; - Pesos</option>
							<option id="element_money_rand" value="rand">R - Rand</option>
							<option id="element_money_ringgit" value="ringgit">RM - Ringgit</option>
							<option id="element_money_rupees" value="rupees">Rs - Rupees</option>
							<option id="element_money_zloty" value="zloty">&#122;&#322; - Złoty</option>
							<option id="element_money_riyals" value="riyals">&#65020; - Riyals</option>
							</select>
						</li>
						
						<li class="clear" id="prop_choices">
							<fieldset class="choices">
							
							Choices 
							<img class="helpmsg" src="images/icons/help3.png" style="vertical-align: top; " title="Use the plus and minus buttons to add and delete choices. Click on the choice to make it the default selection."/>
							
							<ul id="element_choices">
							<li>
								<input type="radio" title="Select this choice as the default." class="choices_default" name="choices_default" />
								<input type="text" value="First option" autocomplete="off" class="text" id="choice_1" /> 
								<img title="Add" alt="Add" src="images/icons/add.png" style="vertical-align: middle" > 
								<img title="Delete" alt="Delete" src="images/icons/delete.png" style="vertical-align: middle" > 
							</li>	
							</ul>
							
							<div style="text-align: center;padding-top: 5px;padding-bottom: 10px">
								<img src="images/icons/page_go.png" style="vertical-align: top"/> <a href="#" id="bulk_import_choices">bulk insert choices</a>
							</div> 
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_choices_other">
							<fieldset class="choices">
							
							Choices Options 
							
							
							<span>	
									<input id="prop_choices_other_checkbox" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_choices_other_checkbox">Allow Client to Add Other Choice</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Enable this option if you would like to allow your client to write his own answer if none of the other choices are applicable. A text field will be added to the last choice. Enter the label below this checkbox."/>
									<div style="margin-bottom: 5px;margin-top: 3px;padding-left: 20px">
										<img src="images/icons/tag_green.png" style="vertical-align: middle"> <input id="prop_other_choices_label" style="width: 220px" class="text" value="" size="25" type="text">
									</div>
									<span id="prop_choices_randomize_span" style="display: none">
									<input id="prop_choices_randomize" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_choices_randomize">Randomize Choices</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Enable this option if you would like the choices to be shuffled around each time the form being displayed."/>
									</span>
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_matrix_row">
							<fieldset class="choices">
							
							Rows 
							<img class="helpmsg" src="images/icons/help3.png" style="vertical-align: top; " title="Enter rows labels here. Use the plus and minus buttons to add and delete matrix row. "/>
							
							<ul id="element_matrix_row">
							<li>
								<input type="text" value="First Question" autocomplete="off" class="text" id="matrixrow_1" /> 
								<img title="Add" alt="Add" src="images/icons/add.png" style="vertical-align: middle" > 
								<img title="Delete" alt="Delete" src="images/icons/delete.png" style="vertical-align: middle" > 
							</li>	
							</ul>
							
							<div style="text-align: center;padding-top: 5px;padding-bottom: 10px">
								<img src="images/icons/page_go.png" style="vertical-align: top"/> <a href="#" id="bulk_import_matrix_row">bulk insert rows</a>
							</div> 
							
							</fieldset>
							
						</li>
						<li class="clear" id="prop_matrix_column">
							<fieldset class="choices">
							
							Columns 
							<img class="helpmsg" src="images/icons/help3.png" style="vertical-align: top; " title="Enter column labels here. Use the plus and minus buttons to add and delete matrix column. "/>
							
							<ul id="element_matrix_column">
							<li>
								<input type="text" value="First Question" autocomplete="off" class="text" id="matrixcolumn_1" /> 
								<img title="Add" alt="Add" src="images/icons/add.png" style="vertical-align: middle" > 
								<img title="Delete" alt="Delete" src="images/icons/delete.png" style="vertical-align: middle" > 
							</li>	
							</ul>
							
							<div style="text-align: center;padding-top: 5px;padding-bottom: 10px">
								<img src="images/icons/page_go.png" style="vertical-align: top"/> <a href="#" id="bulk_import_matrix_column">bulk insert columns</a>
							</div> 
							
							</fieldset>
							
						</li>
						<li id="prop_breaker"></li> 
						<li class="clear" id="prop_options">
							<fieldset class="fieldset">
							<b>Règles</b><br />
							<input id="element_required" class="checkbox" value="" type="checkbox">
							<span style="font-weight:normal;"><?php echo $lang['Required']; ?></span>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this rule will make sure that a user fills out a particular field. A message will be displayed to the user if they have not filled out the field."/>
							<br>
							<span id="element_unique_span">
							<input id="element_unique" class="checkbox" value="" type="checkbox">
							<span style="font-weight:normal;"><?php echo $lang['NoDuplicates']; ?></span>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this rule will verify that the data entered into this field is unique and has not been submitted previously."/>  </span><br>
							</fieldset>
						</li>
					
						
						<li class="clear" id="prop_time_options">
							<fieldset class="choices">
							<b><?php echo $lang['TimeOptions']; ?></b><br />
							
							<span>	
									<input id="prop_time_showsecond" class="checkbox" value="" type="checkbox">
									<span style="font-weight:normal;"><?php echo $lang['ShowSecondsField']; ?></span>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this will enable Seconds field on your time field."/>
									<br/>
									<input id="prop_time_24hour" class="checkbox" value="" type="checkbox">
									<span style="font-weight:normal;"><?php echo $lang['Use24H']; ?></span>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This will enable 24-hour notation in the form hh:mm (for example 14:23) or hh:mm:ss (for example, 14:23:45)"/>
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_text_options">
							<fieldset class="choices">
							<b><?php echo $lang['TextOptions']; ?></b><br />
							
							<span>	
									<input id="prop_text_as_password" class="checkbox" value="" type="checkbox">
									<?php echo $lang['ShowAsAPasswordField']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this will display the field as a password field and masked all the characters (shown as asterisks or circles). <br/><br/>Please be aware that there is <u>no encryption</u> being made for the password field. You will be able to see it from the admin panel/email as a plain text."/>
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_matrix_options">
							<fieldset class="choices">
							<b>
							<?php echo $lang['MatrixOptions']; ?> 
							</b><br />
							
							<span>	
									<input id="prop_matrix_allow_multiselect" class="checkbox" value="" type="checkbox">
									<span style="font-weight:normal;"><?php echo $lang['AllowMultipleAnswersPerRow']; ?></span>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this option will allow your client to select multiple answers for each row. This option can only being set once, when you initially added the matrix field. Once you have saved the form, this option can't be changed."/>
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_address_options">
							<fieldset class="choices">
							<b>
							<?php echo $lang['AddressOptions']; ?> 
							</b><br />
							
							<span>	
									<input id="prop_address_hideline2" class="checkbox" value="" type="checkbox">
									<?php echo $lang['HideAddressLine2']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Hide the 'Address Line 2' field from the address field."/>
									<br/>
									<input id="prop_address_us_only" class="checkbox" value="" type="checkbox">
									<?php echo $lang['RestricttoUSStateSelection']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this will limit the country selection to United States only and the state field will be populated with U.S. state list"/>
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_date_options">
							<fieldset class="choices">
							<b>
							<?php echo $lang['DateOptions']; ?>
							</b><br />
							
							<span>	
									<input id="prop_date_range" class="checkbox" value="" type="checkbox">
									<?php echo $lang['EnableMinimumandorMaximumDates']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can set minimum and/or maximum dates within which a date may be chosen."/>
									
									<div id="prop_date_range_details" style="display: none;">
										
										<div id="form_date_range_minimum">
											<?php echo $lang['MinimumDate']; ?> <br />
											
											<span>
											<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="date_range_min_mm" id="date_range_min_mm">
											<label for="date_range_min_mm"><?php echo $lang['MM']; ?></label>
											</span>
											
											<span>
											<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="date_range_min_dd" id="date_range_min_dd">
											<label for="date_range_min_dd"><?php echo $lang['DD']; ?></label>
											</span>
											
											<span>
											 <input type="text" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="date_range_min_yyyy" id="date_range_min_yyyy">
											 <label for="date_range_min_yyyy"><?php echo $lang['YYYY']; ?></label>
											</span>
											
											<span style="height: 30px;padding-right: 10px;">
											<input type="hidden" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="linked_picker_range_min" id="linked_picker_range_min">
											<div style="display: none"><img id="date_range_min_pick_img" alt="Pick date." src="images/icons/calendar.png" class="trigger" style="margin-top: 3px; cursor: pointer" /></div>
											</span>
											
											</div>
											
											<div id="form_date_range_maximum">
											<?php echo $lang['MaximumDate']; ?><br />
											
											<span>
											<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="date_range_max_mm" id="date_range_max_mm">
											<label for="date_range_max_mm"><?php echo $lang['MM']; ?></label>
											</span>
											
											<span>
											<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="date_range_max_dd" id="date_range_max_dd">
											<label for="date_range_max_dd"><?php echo $lang['DD']; ?></label>
											</span>
											
											<span>
											 <input type="text" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="date_range_max_yyyy" id="date_range_max_yyyy">
											<label for="date_range_max_yyyy"><?php echo $lang['YYYY']; ?></label>
											</span>
											
											<span>
											<input type="hidden" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="linked_picker_range_max" id="linked_picker_range_max">
											<div style="display: none"><img id="date_range_max_pick_img" alt="Pick date." src="images/icons/calendar.png" class="trigger" style="margin-top: 3px; cursor: pointer" /></div>
											</span>
											
		 									</div>
											
											<div style="clear: both"></div>
										
									</div>
									
									<div style="clear: both"></div>
									
									<input id="prop_date_selection_limit" class="checkbox" value="" type="checkbox">
									<?php echo $lang['EnableDateSelectionLimit']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This is useful for reservation or booking form, so that you could allocate each day for a maximum number of customers. For example, setting the value to 5 will ensure that the same date can't be booked/selected by more than 5 customers."/>
									<div id="form_date_selection_limit" style="display: none">
											<?php echo $lang['OnlyAllowEachDateToBeSelected']; ?>
											<input id="date_selection_max" style="width: 20px" class="text" value="" maxlength="255" type="text"> times
									</div>
									<div style="clear: both"></div>
									
									<input id="prop_date_past_future_selection" class="checkbox" value="" type="checkbox">
									<?php echo $lang['Disable']; ?>
										<select class="select medium" id="prop_date_past_future" name="prop_date_past_future" autocomplete="off" disabled="disabled">
											<option id="element_date_past" value="p"><?php echo $lang['AllPastDates']; ?></option>
											<option id="element_date_future" value="f"><?php echo $lang['AllFutureDates']; ?></option>
										</select>
									
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this option will disable either past or future dates selection."/>
									<div style="clear: both"></div>
									
									<input id="prop_date_disable_weekend" class="checkbox" value="" type="checkbox">
									<?php echo $lang['DisableWeekEnd']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this option will disable all weekend dates."/>
									<div style="clear: both"></div>
									
									<input id="prop_date_disable_specific" class="checkbox" value="" type="checkbox">
									<?php echo $lang['DisableSpecificDates']; ?>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can disable any specific dates to prevent them from being selected by your clients. Use the datepicker to disable multiple dates."/>
									<div id="form_date_disable_specific" style="display: none">
											<textarea class="textarea" rows="10" cols="100" style="width: 175px;height: 45px" id="date_disabled_list"></textarea>
											<div style="display: none"><img id="date_disable_specific_pick_img" alt="Pick date." src="images/icons/calendar.png" class="trigger" style="vertical-align: top; cursor: pointer" /></div>
									</div>
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_file_options">
							<fieldset class="choices">
							<b>
							<?php echo $lang['UploadOptions']; ?> 
							</b><br />
							
							<span>
							
									<input id="prop_file_enable_type_limit" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_file_enable_type_limit">Limit File Upload Type</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can block or only allow certain file types to be uploaded. Enter the file types extension into the textbox, separate them with commas. (example: jpg,gif,png,bmp)"/>
									<div id="form_file_limit_type" style="display: none">
											<select class="select" id="prop_file_block_or_allow" name="prop_file_block_allow" autocomplete="off" style="width: 90px">
											<option id="element_file_allow" value="a">Only Allow</option>
											<option id="element_file_block" value="b">Block</option>
											</select> <label class="choice" for="file_type_list">file types listed below:</label>
											<textarea class="textarea" rows="10" cols="100" style="width: 230px; height: 30px;margin-top: 5px" id="file_type_list"></textarea>
									</div>
									<div style="clear: both"></div>									
									<input id="prop_file_as_attachment" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_file_as_attachment">Send File as Email Attachment</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By default, all file uploads will be sent to your email as a download link. Checking this option will send the file as email attachment instead. WARNING: Don't enable this option if you expect to receive large files from your clients. If the files attached are larger than the allowed memory limit on your server, the email won't be sent."/>
									
									<div style="clear: both"></div>
									
									<input id="prop_file_enable_advance" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_file_enable_advance">Enable Advance Uploader</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this option will enable advance functionality, such as Upload Progress Bar, Multiple File Uploads, AJAX uploads, File Size Limit, etc. This option is recommended to be enabled."/>
										
							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_file_advance_options">
							<fieldset class="choices">
							
							Advance Uploader Options 
							
							
							<span>
									<input id="prop_file_auto_upload" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_file_auto_upload">Automatically Upload Files</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By default, the upload button or the form submit button need to be clicked to start uploading the file. By checking this option, the file will be automatically being uploaded as soon as the file being selected."/>
									<div style="clear: both"></div>	
									
									<input id="prop_file_multi_upload" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_file_multi_upload">Allow Multiple File Upload</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this option will allow multiple files to be uploaded. You can also limit the maximum number of files to be uploaded."/>
									<div id="form_file_max_selection">
											Limit selection to a maximum 
											<input id="file_max_selection" style="width: 20px" class="text" value="" maxlength="255" type="text"> files
									</div>
									<div style="clear: both"></div>
									
									<input id="prop_file_limit_size" class="checkbox" value="" type="checkbox">
									<label class="choice" for="prop_file_limit_size">Limit File Size</label>
									<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can set the maximum size of a file allowed to be uploaded here."/>
									<div id="form_file_limit_size">
											Limit each file to a maximum 
											<input id="file_size_max" style="width: 20px" class="text" value="" maxlength="255" type="text"> MB
									</div>
									

							</span>
							
							</fieldset>
							
						</li>
						
						<li class="clear" id="prop_range">
							<fieldset class="range">
							
								<?php echo $lang['Range']; ?>
							
							
							<div style="padding-left: 2px">
								<span>
								<label for="element_range_min" class="desc">Min</label>
								<input type="text" value="" class="text" name="element_range_min" id="element_range_min">
								</span>
								<span>
								<label for="element_range_max" class="desc">Max</label>
								<input type="text" value="" class="text" name="element_range_max" id="element_range_max">
								</span>
								<span>
								<label for="element_range_limit_by" class="desc"><?php echo $lang['LimitBy']; ?>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can limit the amount of characters typed to be between certain characters or words, or between certain values in the case of number field. Leave the value blank or 0 if you don't want to set any limit."/></label>
								<select class="select" name="element_range_limit_by" id="element_range_limit_by">
									<option value="c"><?php echo $lang['Characters']; ?></option>
									<option value="w"><?php echo $lang['Words']; ?></option>
								</select>
								<select class="select" name="element_range_number_limit_by" id="element_range_number_limit_by">
									<option value="v"><?php echo $lang['Value']; ?></option>
									<option value="d"><?php echo $lang['Digits']; ?></option>
								</select>
								</span>
								
							</div>
							</fieldset>
						</li>
						
						<li class="clear" id="prop_default_value">
							<label class="desc" for="element_default">
							<?php echo $lang['DefaultValue']; ?>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By setting this value, the field will be prepopulated with the text you enter."/>
							</label>
							
							<input id="element_default_value" class="text large" name="element_default_value" value="" type="text">
						</li>
						
						<li class="clear" id="prop_default_phone">
							<label class="desc" for="element_default_phone">
							<?php echo $lang['DefaultValue']; ?>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By setting this value, the field will be prepopulated with the text you enter."/>
							</label>
							
							<input id="element_default_phone1" class="text" size="3" maxlength="3" name="element_default_phone1" value="" type="text"> - 
 							<input id="element_default_phone2" class="text" size="3" maxlength="3" name="element_default_phone2" value="" type="text"> - 
							<input id="element_default_phone3" class="text" size="4" maxlength="4" name="element_default_phone3" value="" type="text">
						</li>
						
						<li class="clear" id="prop_default_date">
							<label class="desc" for="element_default_date">
							<?php echo $lang['DefaultDate']; ?>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By setting this value, the date will be prepopulated with the date you enter. Use the format ##/##/#### or any English date words, such as 'today', 'tomorrow', 'last friday', '+1 week', 'last day of next month', '3 days ago', 'monday next week'"/>
							</label>
							
							<input id="element_default_date" class="text large" name="element_default_date" value="" type="text">
						</li>
						
						<li class="clear" id="prop_default_value_textarea">
							<label class="desc" for="element_default_textarea">
							<?php echo $lang['DefaultValue']; ?>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By setting this value, the field will be prepopulated with the text you enter."/>
							</label>
							
							<textarea class="textarea" rows="10" cols="50" id="element_default_value_textarea" name="element_default_value_textarea"></textarea>
						</li>
						
						<li class="clear" id="prop_default_country">
							<label class="desc" for="fieldaddress_default">
							<?php echo $lang['DefaultCountry']; ?>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By setting this value, the country field will be prepopulated with the selection you make."/>
							</label>
							<select class="select" id="element_countries" name="element_countries">
							<option value=""></option>
							
							<optgroup label="North America">
							<option value="Antigua and Barbuda">Antigua and Barbuda</option>
							<option value="Bahamas">Bahamas</option>
							<option value="Barbados">Barbados</option> 
							<option value="Belize">Belize</option> 
							<option value="Canada">Canada</option> 
							<option value="Costa Rica">Costa Rica</option> 
							<option value="Cuba">Cuba</option> 
							<option value="Dominica">Dominica</option> 
							<option value="Dominican Republic">Dominican Republic</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Grenada">Grenada</option> 
							<option value="Guatemala">Guatemala</option> 
							<option value="Haiti">Haiti</option> 
							<option value="Honduras">Honduras</option> 
							<option value="Jamaica">Jamaica</option> 
							<option value="Mexico">Mexico</option> 
							<option value="Nicaragua">Nicaragua</option> 
							<option value="Panama">Panama</option> 
							<option value="Puerto Rico">Puerto Rico</option> 
							<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
							<option value="Saint Lucia">Saint Lucia</option>
							<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option> 
							<option value="Trinidad and Tobago">Trinidad and Tobago</option>
							<option value="United States">United States</option>
							</optgroup>
							
							<optgroup label="South America">
							<option value="Argentina">Argentina</option>
							<option value="Bolivia">Bolivia</option> 
							<option value="Brazil">Brazil</option> 
							<option value="Chile">Chile</option> 
							<option value="Columbia">Columbia</option>
							<option value="Ecuador">Ecuador</option> 
							<option value="Guyana">Guyana</option> 
							<option value="Paraguay">Paraguay</option> 
							<option value="Peru">Peru</option> 
							<option value="Suriname">Suriname</option> 
							<option value="Uruguay">Uruguay</option> 
							<option value="Venezuela">Venezuela</option>
							</optgroup>
							
							<optgroup label="Europe">
							<option value="Albania">Albania</option>
							<option value="Andorra">Andorra</option>
							<option value="Armenia">Armenia</option>
							<option value="Austria">Austria</option>
							<option value="Azerbaijan">Azerbaijan</option>
							<option value="Belarus">Belarus</option>
							<option value="Belgium">Belgium</option> 
							<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
							<option value="Bulgaria">Bulgaria</option> 
							<option value="Croatia">Croatia</option> 
							<option value="Cyprus">Cyprus</option> 
							<option value="Czech Republic">Czech Republic</option>
							<option value="Denmark">Denmark</option> 
							<option value="Estonia">Estonia</option> 
							<option value="Finland">Finland</option> 
							<option value="France">France</option> 
							<option value="Georgia">Georgia</option>
							<option value="Germany">Germany</option>
							<option value="Greece">Greece</option> 
							<option value="Hungary">Hungary</option> 
							<option value="Iceland">Iceland</option> 
							<option value="Ireland">Ireland</option> 
							<option value="Italy">Italy</option> 
							<option value="Latvia">Latvia</option> 
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Lithuania">Lithuania</option> 
							<option value="Luxembourg">Luxembourg</option> 
							<option value="Macedonia">Macedonia</option> 
							<option value="Malta">Malta</option> 
							<option value="Moldova">Moldova</option> 
							<option value="Monaco">Monaco</option> 
							<option value="Montenegro">Montenegro</option> 
							<option value="Netherlands">Netherlands</option> 
							<option value="Norway">Norway</option> 
							<option value="Poland">Poland</option> 
							<option value="Portugal">Portugal</option>
							<option value="Romania">Romania</option> 
							<option value="San Marino">San Marino</option>
							<option value="Serbia">Serbia</option>
							<option value="Slovakia">Slovakia</option>
							<option value="Slovenia">Slovenia</option> 
							<option value="Spain">Spain</option> 
							<option value="Sweden">Sweden</option> 
							<option value="Switzerland">Switzerland</option> 
							<option value="Ukraine">Ukraine</option> 
							<option value="United Kingdom">United Kingdom</option>
							<option value="Vatican City">Vatican City</option>
							</optgroup>
							
							<optgroup label="Asia">
							<option value="Afghanistan">Afghanistan</option>
							<option value="Bahrain">Bahrain</option>
							<option value="Bangladesh">Bangladesh</option>
							<option value="Bhutan">Bhutan</option>
							<option value="Brunei Darussalam">Brunei Darussalam</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Cambodia">Cambodia</option>
							<option value="China">China</option>
							<option value="East Timor">East Timor</option>
							<option value="Hong Kong">Hong Kong</option> 
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran">Iran</option>
							<option value="Iraq">Iraq</option>
							<option value="Israel">Israel</option>
							<option value="Japan">Japan</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="North Korea">North Korea</option>
							<option value="South Korea">South Korea</option>
							<option value="Kuwait">Kuwait</option> 
							<option value="Kyrgyzstan">Kyrgyzstan</option> 
							<option value="Laos">Laos</option> 
							<option value="Lebanon">Lebanon</option> 
							<option value="Malaysia">Malaysia</option> 
							<option value="Maldives">Maldives</option> 
							<option value="Mongolia">Mongolia</option> 
							<option value="Nepal">Nepal</option> 
							<option value="Oman">Oman</option> 
							<option value="Pakistan">Pakistan</option> 
							<option value="Philippines">Philippines</option> 
							<option value="Qatar">Qatar</option> 
							<option value="Russia">Russia</option> 
							<option value="Saudi Arabia">Saudi Arabia</option> 
							<option value="Singapore">Singapore</option> 
							<option value="Sri Lanka">Sri Lanka</option>
							<option value="Syria">Syria</option>
							<option value="Taiwan">Taiwan</option> 
							<option value="Tajikistan">Tajikistan</option> 
							<option value="Thailand">Thailand</option> 
							<option value="Turkey">Turkey</option> 
							<option value="Turkmenistan">Turkmenistan</option> 
							<option value="United Arab Emirates">United Arab Emirates</option>
							<option value="Uzbekistan">Uzbekistan</option> 
							<option value="Vietnam">Vietnam</option> 
							<option value="Yemen">Yemen</option>
							</optgroup>
							
							<optgroup label="Oceania">
							<option value="Australia">Australia</option>
							<option value="Fiji">Fiji</option> 
							<option value="Kiribati">Kiribati</option>
							<option value="Marshall Islands">Marshall Islands</option> 
							<option value="Micronesia">Micronesia</option> 
							<option value="Nauru">Nauru</option> 
							<option value="New Zealand">New Zealand</option>
							<option value="Palau">Palau</option>
							<option value="Papua New Guinea">Papua New Guinea</option>
							<option value="Samoa">Samoa</option> 
							<option value="Solomon Islands">Solomon Islands</option>
							<option value="Tonga">Tonga</option> 
							<option value="Tuvalu">Tuvalu</option>  
							<option value="Vanuatu">Vanuatu</option>
							</optgroup>
							
							<optgroup label="Africa">
							<option value="Algeria">Algeria</option> 
							<option value="Angola">Angola</option> 
							<option value="Benin">Benin</option> 
							<option value="Botswana">Botswana</option> 
							<option value="Burkina Faso">Burkina Faso</option> 
							<option value="Burundi">Burundi</option> 
							<option value="Cameroon">Cameroon</option> 
							<option value="Cape Verde">Cape Verde</option>
							<option value="Central African Republic">Central African Republic</option>
							<option value="Chad">Chad</option>  
							<option value="Comoros">Comoros</option>  
							<option value="Congo">Congo</option>
							<option value="Djibouti">Djibouti</option> 
							<option value="Egypt">Egypt</option> 
							<option value="Equatorial Guinea">Equatorial Guinea</option> 
							<option value="Eritrea">Eritrea</option> 
							<option value="Ethiopia">Ethiopia</option> 
							<option value="Gabon">Gabon</option> 
							<option value="Gambia">Gambia</option> 
							<option value="Ghana">Ghana</option> 
							<option value="Guinea">Guinea</option> 
							<option value="Guinea-Bissau">Guinea-Bissau</option>
							<option value="Côte d'Ivoire">Côte d'Ivoire</option> 
							<option value="Kenya">Kenya</option> 
							<option value="Lesotho">Lesotho</option> 
							<option value="Liberia">Liberia</option> 
							<option value="Libya">Libya</option> 
							<option value="Madagascar">Madagascar</option> 
							<option value="Malawi">Malawi</option> 
							<option value="Mali">Mali</option>
							<option value="Mauritania">Mauritania</option> 
							<option value="Mauritius">Mauritius</option> 
							<option value="Morocco">Morocco</option> 
							<option value="Mozambique">Mozambique</option> 
							<option value="Namibia">Namibia</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option> 
							<option value="Rwanda">Rwanda</option> 
							<option value="Sao Tome and Principe">Sao Tome and Principe</option>
							<option value="Senegal">Senegal</option> 
							<option value="Seychelles">Seychelles</option> 
							<option value="Sierra Leone">Sierra Leone</option>
							<option value="Somalia">Somalia</option> 
							<option value="South Africa">South Africa</option>
							<option value="Sudan">Sudan</option> 
							<option value="Swaziland">Swaziland</option> 
							<option value="United Republic of Tanzania">Tanzania</option>
							<option value="Togo">Togo</option> 
							<option value="Tunisia">Tunisia</option> 
							<option value="Uganda">Uganda</option> 
							<option value="Zambia">Zambia</option> 
							<option value="Zimbabwe">Zimbabwe</option>
							</optgroup>
							</select>
						</li>
						
						<li class="clear" id="prop_phone_default">
							<label class="desc" for="element_phone_default1">
							<?php echo $lang['DefaultValue']; ?>
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="By setting this value, the field will be prepopulated with the text you enter."/>
							</label>
							
							( <input id="element_phone_default1" class="text" size="3" name="text" value="" tabindex="11" maxlength="3" onkeyup="set_properties(JJ('#element_phone_default1').val().toString()+JJ('#element_phone_default2').val().toString()+JJ('#element_phone_default3').val().toString(), 'default_value')" onblur="set_properties(JJ('#element_phone_default1').val().toString()+JJ('#element_phone_default2').val().toString()+JJ('#element_phone_default3').val().toString(), 'default_value')" type="text"> ) 
							
							<input id="element_phone_default2" class="text" size="3" name="text" value="" tabindex="11" maxlength="3" onkeyup="set_properties(JJ('#element_phone_default1').val().toString()+JJ('#element_phone_default2').val().toString()+JJ('#element_phone_default3').val().toString(), 'default_value')" onblur="set_properties(JJ('#element_phone_default1').val().toString()+JJ('#element_phone_default2').val().toString()+JJ('#element_phone_default3').val().toString(), 'default_value')" type="text"> -
							<input id="element_phone_default3" class="text" size="4" name="text" value="" tabindex="11" maxlength="4" onkeyup="set_properties(JJ('#element_phone_default1').val().toString()+JJ('#element_phone_default2').val().toString()+JJ('#element_phone_default3').val().toString(), 'default_value')" onblur="set_properties(JJ('#element_phone_default1').val().toString()+JJ('#element_phone_default2').val().toString()+JJ('#element_phone_default3').val().toString(), 'default_value')" type="text">
						</li>
						
						
						<li class="clear" id="prop_instructions">
							<label class="desc" for="element_instructions">
							<?php echo $lang['GuidelinesForUser']; ?> 
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This text will be displayed to your users while they're filling out particular field."/>
							</label>
							
							<textarea class="textarea" rows="10" cols="50" id="element_instructions"></textarea>
						</li>
						
						<li class="clear" id="prop_custom_css">
							<label class="desc" for="element_custom_css">
							Custom CSS Class
							<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This is advanced option. You can add custom CSS classnames to the parent element of the field. This is useful if you would like to customize the styling for each of your field using your own CSS code. These custom class names will not appear live in the form builder, only on the live form."/>
							</label>
							
							<input id="element_custom_css" class="text large" name="element_custom_css" value="" maxlength="255" type="text">
						</li>
						
						<li class="clear" id="prop_page_break_button" style="margin-top: 50px;margin-bottom: 50px">
								<fieldset style="padding-top: 15px">
								Page Submit Buttons
								
								<div class="left" style="padding-bottom: 5px">
								<input id="prop_submit_use_text" name="submit_use_image" class="radio" value="0" type="radio">
								<label class="choice" for="prop_submit_use_text">Use Text Button</label>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This is the default and recommended option. All buttons will use simple text. You can change the text being used on each page submit/back button."/>
								</div>
								
								<div class="left" style="padding-left: 5px;padding-bottom: 5px">
								<input id="prop_submit_use_image" name="submit_use_image" class="radio" value="1" type="radio">
								<label class="choice" for="prop_submit_use_image">Use Image Button</label>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Select this option if you prefer to use your own submit/back image buttons. Make sure to enter the full URL address to your images."/>
								</div>
								
								<div id="div_submit_use_text" class="left" style="padding-left: 8px;padding-bottom: 10px;width: 92%">
								<label class="desc" for="submit_primary_text">Submit Button</label>
								<input id="submit_primary_text" class="text large" name="submit_primary_text" value="" type="text">
								<label id="lbl_submit_secondary_text" class="desc" for="submit_secondary_text" style="margin-top: 10px">Back Button</label>
								<input id="submit_secondary_text" class="text large" name="submit_secondary_text" value="" type="text">
								</div>
								
								<div id="div_submit_use_image" class="left" style="padding-left: 8px;padding-bottom: 10px;width: 92%; display: none">
								<label class="desc" for="submit_primary_img">Submit Button. Image URL:</label>
								<input id="submit_primary_img" class="text large" name="submit_primary_img" value="http://" type="text">
								<label id="lbl_submit_secondary_img" class="desc" for="submit_secondary_img" style="margin-top: 10px">Back Button. Image URL:</label>
								<input id="submit_secondary_img" class="text large" name="submit_secondary_img" value="http://" type="text">
								</div>
								</fieldset>
						</li>
						
						</ul>
						<div class="bullet_bar_bottom">
						</div>
					</div>
					
				</form>
			</div> <!-- end field properties pane -->
		</div>
		
		<div id="tab_form_properties" style="display: none">
			<div id="form_properties_pane" class="box">
				<div id="form_properties_holder">
						<div class="bullet_bar_top">
						</div>

						<!--  start form properties pane -->
						<form id="form_properties" action="" onsubmit="return false;">
							<ul id="all_form_properties">
							<li class="form_prop">
								<label class="desc" for="form_title">Form Title 
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="The title of your form displayed to the user when they see your form."/>
								</label>
								<input id="form_title" name="form_title" class="text large" value="" tabindex="1"  type="text">
							</li>
							<li class="form_prop">
								<label class="desc" for="form_description">Description 
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This will appear directly below the form name. Useful for displaying a short description or any instructions, notes, guidelines."/>
								</label>
								<textarea class="textarea small" rows="10" cols="50" id="form_description" tabindex="2"></textarea>
							</li>
							
							<li id="form_prop_confirmation" class="form_prop">
								<fieldset>
								Submission Confirmation
								
								<div class="left" style="padding-bottom: 5px">
								<input id="form_success_message_option" name="confirmation" class="radio" value="" checked="checked" type="radio">
								<span style="font-size:11px;font-weight:normal;">Show Text</span>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This message will be displayed after your users have successfully submitted an entry."/>
								</div>
								
								<div class="left" style="padding-left: 15px;padding-bottom: 5px">
								<input id="form_redirect_option" name="confirmation" class="radio" value="" type="radio">
								<span style="font-size:11px;font-weight:normal;">Redirect to Web Site</span>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="After your users have successfully submitted an entry, you can redirect them to another 
								website/URL of your choice."/>
								</div>
								
								<textarea class="textarea" rows="10" cols="50" id="form_success_message" tabindex="9"></textarea>
								
								<input id="form_redirect_url" class="text hide" name="form_redirect_url" value="http://" type="text">
								</fieldset>
							</li>
							
							
							
							<li id="form_prop_language" class="leftCol form_prop">
								<label class="desc">
								Language 
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can choose the language being used to display your form messages."/>
								</label>
								<div>
								<select autocomplete="off" id="form_language" class="select large">
								<option value="dutch">Dutch</option>
								<option value="english">English</option>
								<option value="french">Français</option>
								<option value="german">German</option>
								<option value="italian">Italian</option>
								<option value="japanese">Japanese</option>
								<option value="portuguese">Portuguese</option>
								<option value="spanish">Spanish</option>
								<option value="swedish">Swedish</option>
								</select>
								</div>
							</li>
							
							<li id="form_prop_label_alignment" class="rightCol form_prop">
								<label for="form_label_alignment" class="desc">Label Alignment 
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Set the <?php echo $lang['FieldLabel']; ?> placement"/>
								</label>
								<div>
								<select autocomplete="off" id="form_label_alignment" class="select large">
								<option value="top_label">Top Aligned</option>
								<option value="left_label">Left Aligned</option>
								<option value="right_label">Right Aligned</option>
								</select>
								</div>
								
							</li>
							<li class="form_prop">
								<span style="clear: both;display: block">
										<input id="form_captcha" class="checkbox" value="" checked="checked" type="checkbox">
										Turn On Spam Protection (CAPTCHA)
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="If enabled, an image with random words will be generated and users will be required to enter the correct words to be able submitting your form. This is useful to prevent abuse from bots or automated programs usually written to generate spam."/>
										<div id="form_captcha_type_option" style="display: block">
											
											<label class="choice" for="form_captcha_type">Type: </label>
											<select class="select" 
											
											
											id="form_captcha_type" name="form_captcha_type" autocomplete="off">
												<option value="r">reCAPTCHA (Hardest)</option>
												<option value="i">Simple Image (Medium)</option>
												<option value="t">Simple Text (Easiest)</option>
											</select>
											<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="You can select the difficulty level of the spam protection.
											 <br/>
											 <br/>
											reCAPTCHA : Display an image with distorted words. An audio also included. This is the most secure but also the hardest to read. Some people might find this annoying.
											 <br/>
											 <br/> 
											Simple Image : Display an image with a clear and sharp words. Most people will find this easy to read.
											 <br/>
											 <br/>
											Simple Text : Display a text (not an image) which contain simple question to solve."/>
										</div>
									</span>
							</li>
							
							<li id="form_prop_toggle" class="form_prop">
							<div style="text-align: right">
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="All settings below this point are optional. You can leave it as it is if you don't need it."/> <a href=""  id="form_prop_toggle_a">show more options</a> <img style="vertical-align: top;cursor: pointer" src="images/icons/resultset_next.gif" id="form_prop_toggle_img"/>
							</div> 
							</li>
						
							
							<li id="form_prop_processing" class="clear advanced_prop form_prop">
								<fieldset>
								Processing Options
									<span>
										<input id="form_resume" class="checkbox" value="" type="checkbox"> 
										<label class="choice" for="form_resume">Allow Clients to Save and Resume Later</label>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Checking this will display additional link at the bottom of your form which would allow your clients to save their progress and resume later. This option only available if your form has at least two pages (has one or more Page Break field)."/>
									</span><br>
									<span>	
										<input id="form_review" class="checkbox" value="" type="checkbox">
										<label class="choice" for="form_review">Show Review Page Before Submitting</label>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="If enabled, your clients will be prompted to a preview page that lets them double check their entries before submitting the form."/>
									</span><br>
								</fieldset>
							</li>
							
							<li class="clear advanced_prop form_prop" id="form_prop_review" style="display: none;zoom: 1">
								<fieldset style="padding-top: 15px">
								Review Page Options
								
								<label class="desc" for="form_review_title">
								Review Page Title
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Enter the title to be displayed on the review page."/>
								</label>
								
								<input id="form_review_title" class="text large" name="form_review_title" value="" maxlength="255" type="text">
								
								<label class="desc" for="form_review_description">
								Review Page Description 
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Enter some brief description to be displayed on the review page."/>
								</label>
								
								<textarea class="textarea" rows="10" cols="50" id="form_review_description" style="height: 2.5em"></textarea>
								<div style="border-bottom: 1px dashed green; height: 15px;margin-right: 10px"></div>
								<div class="left" style="padding-bottom: 5px;margin-top: 12px">
								<input id="form_review_use_text" name="form_review_option" class="radio" value="0" type="radio">
								<label class="choice" for="form_review_use_text">Use Text Button</label>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="This is the default and recommended option. All buttons on review page will use simple text."/>
								</div>
								
								<div class="left" style="padding-left: 5px;padding-bottom: 5px;margin-top: 12px">
								<input id="form_review_use_image" name="form_review_option" class="radio" value="1" type="radio">
								<label class="choice" for="form_review_use_image">Use Image Button</label>
								<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Select this option if you prefer to use your own submit/back image buttons. Make sure to enter the full URL address to your images."/>
								</div>
								
								<div id="div_review_use_text" class="left" style="padding-left: 8px;padding-bottom: 10px;width: 92%">
								<label class="desc" for="review_primary_text">Submit Button</label>
								<input id="review_primary_text" class="text large" name="review_primary_text" value="" type="text">
								<label id="lbl_review_secondary_text" class="desc" for="review_secondary_text" style="margin-top: 3px">Back Button</label>
								<input id="review_secondary_text" class="text large" name="review_secondary_text" value="" type="text">
								</div>
								
								<div id="div_review_use_image" class="left" style="padding-left: 8px;padding-bottom: 10px;width: 92%;display: none">
								<label class="desc" for="review_primary_img">Submit Button. Image URL:</label>
								<input id="review_primary_img" class="text large" name="review_primary_img" value="http://" type="text">
								<label id="lbl_review_secondary_img" class="desc" for="review_secondary_img" style="margin-top: 3px">Back Button. Image URL:</label>
								<input id="review_secondary_img" class="text large" name="review_secondary_img" value="http://" type="text">
								</div>
								</fieldset>
							</li>
							 
							<li id="form_prop_protection" class="advanced_prop form_prop">
								<fieldset>
								Protection &amp; Limit
									<span>	
										<input id="form_password_option" class="checkbox" value=""  type="checkbox">
										<label class="choice" for="form_password_option">Turn On Password Protection</label>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="If enabled, all users accessing the public form will then be required to type in the password to access the form. Your form is password protected."/>
										<div id="form_password" style="display: none">
											<img src="images/icons/key.png" alt="Password : " style="vertical-align: middle">
											<input id="form_password_data" style="width: 50%" class="text" value="" size="25"  type="password">
										</div>
									</span>
									
	
									<span style="clear: both;display: block">
										<input id="form_unique_ip" class="checkbox" value="" type="checkbox">
										<label class="choice" for="form_unique_ip">Limit One Entry Per IP</label>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Use this to prevent clients from filling out your form more than once. This is done by comparing client's IP Address."/>
									</span>
									<span style="clear: both;display: block">	
										<input id="form_limit_option" class="checkbox" value="" type="checkbox">
										<label class="choice" for="form_limit_option">Limit Submission</label>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="The form will be turned off after reaching the number of entries defined here."/>
										<div id="form_limit_div" style="display: none">
											<img src="images/icons/flag_red.png" alt="Maximum accepted entries : " style="vertical-align: middle"> Maximum accepted entries:
											<input id="form_limit" style="width: 20%" class="text" value="" maxlength="255" type="text">
										</div>
									</span>
								</fieldset>
							</li>
							
							
							<li id="form_prop_scheduling" class="clear advanced_prop form_prop">
								
								<fieldset>
								  Automatic Scheduling 
								 <div style="padding-bottom: 10px">
								 <input id="form_schedule_enable" class="checkbox" value="" style="float: left"  type="checkbox">
								 <label class="choice" style="float: left;margin-left: 5px;margin-right:3px;line-height: 1.7" for="form_schedule_enable">Enable Automatic Scheduling</label>
								  <img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="If you would like to schedule your form to become active at certain period of time only, enable this option."/>
								 </div>
								<div id="form_prop_scheduling_start" style="display: none">
								
									<label class="desc">Only Accept Submission From Date: </label> 
									
									<span>
									<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="scheduling_start_mm" id="scheduling_start_mm">
									<label for="scheduling_start_mm">MM</label>
									</span>
									
									<span>
									<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="scheduling_start_dd" id="scheduling_start_dd">
									<label for="scheduling_start_dd">DD</label>
									</span>
									
									<span>
									 <input type="text" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="scheduling_start_yyyy" id="scheduling_start_yyyy">
									<label for="scheduling_start_yyyy">YYYY</label>
									</span>
									
									<span id="scheduling_cal_start">
											<input type="hidden" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="linked_picker_scheduling_start" id="linked_picker_scheduling_start">
											<div style="display: none"><img id="scheduling_start_pick_img" alt="Pick date." src="images/icons/calendar.png" class="trigger" style="margin-top: 3px; cursor: pointer" /></div>
									</span>
									<span>
									<select name="scheduling_start_hour" id="scheduling_start_hour" class="select"> 
									<option value="01">1</option>
									<option value="02">2</option>
									<option value="03">3</option>
									<option value="04">4</option>
									<option value="05">5</option>
									<option value="06">6</option>
									<option value="07">7</option>
									<option value="08">8</option>
									<option value="09">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									</select>
									<label for="scheduling_start_hour">HH</label>
									</span>
									<span>
									<select name="scheduling_start_minute" id="scheduling_start_minute" class="select"> 
									<option value="00">00</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
									</select>
									<label for="scheduling_start_minute">MM</label>
									</span>
									<span>
									<select name="scheduling_start_ampm" id="scheduling_start_ampm" class="select"> 
									<option value="am">AM</option>
									<option value="pm">PM</option>
									</select>
									<label for="scheduling_start_ampm">AM/PM</label>
									</span>

								</div>
									
								<div id="form_prop_scheduling_end" style="display: none">
								
									<label class="desc">Until Date:</label>
									<span>
									<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="scheduling_end_mm" id="scheduling_end_mm">
									<label for="scheduling_end_mm">MM</label>
									</span>
									
									<span>
									<input type="text" value="" maxlength="2" size="2" style="width: 2em;" class="text" name="scheduling_end_dd" id="scheduling_end_dd">
									<label for="scheduling_end_dd">DD</label>
									</span>
									
									<span>
									 <input type="text" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="scheduling_end_yyyy" id="scheduling_end_yyyy">
									<label for="scheduling_end_yyyy">YYYY</label>
									</span>
									
									<span id="scheduling_cal_end">
											<input type="hidden" value="" maxlength="4" size="4" style="width: 3em;" class="text" name="linked_picker_scheduling_end" id="linked_picker_scheduling_end">
											<div style="display: none"><img id="scheduling_end_pick_img" alt="Pick date." src="images/icons/calendar.png" class="trigger" style="margin-top: 3px; cursor: pointer" /></div>
									</span>
									<span>
									<select name="scheduling_end_hour" id="scheduling_end_hour" class="select"> 
									<option value="01">1</option>
									<option value="02">2</option>
									<option value="03">3</option>
									<option value="04">4</option>
									<option value="05">5</option>
									<option value="06">6</option>
									<option value="07">7</option>
									<option value="08">8</option>
									<option value="09">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									</select>
									<label for="scheduling_end_hour">HH</label>
									</span>
									<span>
									<select name="scheduling_end_minute" id="scheduling_end_minute" class="select"> 
									<option value="00">00</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
									</select>
									<label for="scheduling_end_minute">MM</label>
									</span>
									<span>
									<select name="scheduling_end_ampm" id="scheduling_end_ampm" class="select"> 
									<option value="am">AM</option>
									<option value="pm">PM</option>
									</select>
									<label for="scheduling_end_ampm">AM/PM</label>
									</span>

								</div>
								
								</fieldset>
							</li>
							
							<li id="form_prop_breaker" class="clear advanced_prop form_prop"></li>
							
							<li id="prop_pagination_style" class="clear">
								<fieldset class="choices">
								
									Pagination Header Style 
									<img class="helpmsg" src="images/icons/help3.png" style="vertical-align: top; " title="When a form has multiple pages, the pagination header will be displayed on top of your form to let your clients know their progress. This is useful to help your clients understand how much of the form has been completed and how much left to be filled out."/>
								
								<ul>
									<li>
										<input type="radio" id="pagination_style_steps" name="pagination_style" class="choices_default" title="Complete Steps">
										<span style="font-weight:normal;font-size:11px;">Complete Steps</span>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="A complete series of all page titles will be displayed, along with the page numbers. The respective page title will be highlighted as the client continue to the next pages. Use this style if your form only has small number of pages."/>
									</li>
									<li>
										<input type="radio" id="pagination_style_percentage" name="pagination_style" class="choices_default" title="Progress Bar">
										<span style="font-weight:normal;font-size:11px;">Progress Bar</span>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="A progress bar with a percentage number and the current active page title will be displayed. Use this style if your form has many pages or you need to put longer page title for each page."/>
									</li>
									<li>
										<input type="radio" id="pagination_style_disabled" name="pagination_style" class="choices_default" title="Disable Pagination Header">
										<span style="font-weight:normal;font-size:11px;">Disable</span>
										<img class="helpmsg" src="images/icons/help2.png" style="vertical-align: top" title="Select this option if you prefer to disable the pagination header completely."/>
									</li>
								</ul>	
							</fieldset>
							</li>
							
							<li id="prop_pagination_titles" class="clear">
								<fieldset class="choices">
								
									Page Titles
									<img class="helpmsg" src="images/icons/help3.png" style="vertical-align: top; " title="Each page on your form will have its own title which you can specify here. This is useful to organize the form into meaningful content groups. Ensure that the titles of your form pages match your clients' expectations and succintly explain what each page is for. "/>
								
								<ul id="pagination_title_list">
									<li>
										<label for="pagetitleinput_1">1.</label> 
										<input type="text" value="" autocomplete="off" class="text" id="pagetitle_1" /> 
									</li>	
								</ul>	
							</fieldset>
								
							</li>
							
							</ul>
						</form>
						<!--  end form properties pane -->

						<div class="bullet_bar_bottom">
						</div>
				</div>
			</div>
		</div>
	</div>			
</div><!-- /#sidebar -->

<div id="dialog-message" title="Uh oh, we're having some difficulties." class="buttons" style="display: none">
	<img src="images/icons/warning.png" title="Warning" /> 
	<p>
		Our apologies, we're unable to reach the server.<br/>
		Please try again within few minutes.<br/><br/>
		If the problem persist, please contact us and we'll get back to you immediately!
	</p>
</div>
<div id="dialog-warning" title="Error Title" class="buttons" style="display: none">
	<img src="images/icons/warning.png" title="Warning" /> 
	<p id="dialog-warning-msg">
		Error
	</p>
</div>
<div id="dialog-confirm-field-delete" title="Are you sure you want to delete this field?" class="buttons" style="display: none">
	<img src="images/icons/hand.png" title="Confirmation" /> 
	<p>
		This action cannot be undone.<br/>
		<strong>All data collected by the field will be deleted as well.</strong><br/><br/>
		If you are sure with this, you can continue deleting this field.<br /><br />
	</p>
	
</div>
<div id="dialog-insert-choices" title="Bulk insert choices" class="buttons" style="display: none"> 
	<form class="dialog-form">				
		<ul>
			<li>
				<label for="bulk_insert_choices" class="description">You can insert a list of choices here. Separate the choices with new line. </label>
				<div>
				<textarea cols="90" rows="8" class="element textarea medium" name="bulk_insert_choices" id="bulk_insert_choices"></textarea> 
				</div> 
			</li>
		</ul>
	</form>
</div>
<div id="dialog-insert-matrix-rows" title="Bulk insert rows" class="buttons" style="display: none"> 
	<form class="dialog-form">				
		<ul>
			<li>
				<label for="bulk_insert_rows" class="description">You can insert a list of rows here. Separate the rows with new line. </label>
				<div>
				<textarea cols="90" rows="8" class="element textarea medium" name="bulk_insert_rows" id="bulk_insert_rows"></textarea> 
				</div> 
			</li>
		</ul>
	</form>
</div>
<div id="dialog-insert-matrix-columns" title="Bulk insert columns" class="buttons" style="display: none"> 
	<form class="dialog-form">				
		<ul>
			<li>
				<label for="bulk_insert_columns" class="description">You can insert a list of columns here. Separate the labels with new line. </label>
				<div>
				<textarea cols="90" rows="8" class="element textarea medium" name="bulk_insert_columns" id="bulk_insert_columns"></textarea> 
				</div> 
			</li>
		</ul>
	</form>
</div>  
<?php
	$footer_data =<<<EOT
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.sortable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/builder.js"></script>
<script type="text/javascript" src="js/datepick/jquery.datepick.js"></script>
<script type="text/javascript">
	$(function(){
		{$jquery_data_code}		
    });
</script>
EOT;
	require('includes/footer.php'); 
?>