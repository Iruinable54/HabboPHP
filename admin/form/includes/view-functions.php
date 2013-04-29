<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	//Single Line Text
	function mf_display_text($element){
		global $mf_lang;

		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for constraint
		if($element->constraint == 'password'){
			$element_type = 'password';
		}else{
			$element_type = 'text';
		}
		
		//check for populated value, if exist, use it instead default_value
		if(isset($element->populated_value['element_'.$element->id]['default_value'])){
			$element->default_value = $element->populated_value['element_'.$element->id]['default_value'];
		}
	
		if($element->range_limit_by == 'c'){
			$range_limit_by = $mf_lang['range_type_chars'];
		}else if($element->range_limit_by == 'w'){
			$range_limit_by = $mf_lang['range_type_words'];
		}
		
		if(!empty($element->is_design_mode)){
			$range_limit_by = '<var class="range_limit_by">'.$range_limit_by.'</var>';
		}
		
		$input_handler = '';
		$maxlength = '';
		
		if(!empty($element->range_min) || !empty($element->range_max)){
			$currently_entered_length = 0;
			if(!empty($element->default_value)){
				if($element->range_limit_by == 'c'){
					$currently_entered_length = strlen($element->default_value);
				}else if($element->range_limit_by == 'w'){
					$currently_entered_length = count(preg_split("/[\s\.]+/", $element->default_value, NULL, PREG_SPLIT_NO_EMPTY));
				}
			}
		}
		
		if(!empty($element->range_min) && !empty($element->range_max)){
			$range_min_max_tag = sprintf($mf_lang['range_min_max'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var>","<var id=\"range_max_{$element->id}\">{$element->range_max}</var> {$range_limit_by}");
			$currently_entered_tag = sprintf($mf_lang['range_min_max_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

			$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_max_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
			$input_handler = "onkeyup=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\" onchange=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\"";
			
			if($element->range_limit_by == 'c'){
				$maxlength = 'maxlength="'.$element->range_max.'"';
			}
		}elseif(!empty($element->range_max)){
			$range_max_tag = sprintf($mf_lang['range_max'],"<var id=\"range_max_{$element->id}\">{$element->range_max}</var> {$range_limit_by}");
			$currently_entered_tag = sprintf($mf_lang['range_max_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

			$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_max_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
			$input_handler = "onkeyup=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\" onchange=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\"";
			
			if($element->range_limit_by == 'c'){
				$maxlength = 'maxlength="'.$element->range_max.'"';
			}
		}elseif(!empty($element->range_min)){
			$range_min_tag = sprintf($mf_lang['range_min'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var> {$range_limit_by}");
			$currently_entered_tag = sprintf($mf_lang['range_min_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

			$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
			$input_handler = "onkeyup=\"count_input({$element->id},'{$element->range_limit_by}');\" onchange=\"count_input({$element->id},'{$element->range_limit_by}');\"";
		}else{
			$range_limit_markup = '';
		}
		
		if(!empty($element->is_design_mode)){
			$input_handler = '';
		}
		
		//if there is any error message unrelated with range rules, don't display the range markup
		if(!empty($error_message)){
			$range_limit_markup = '';
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
				
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
			<input id="element_{$element->id}" name="element_{$element->id}" {$maxlength} class="element text {$element->size}" type="{$element_type}" value="{$element->default_value}" title="{$element->guidelines}" {$input_handler} />
			{$range_limit_markup} 
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	
	//Paragraph Text
	function mf_display_textarea($element){
		global $mf_lang;

		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for populated value, if exist, use it instead default_value
		if(isset($element->populated_value['element_'.$element->id]['default_value'])){
			$element->default_value = $element->populated_value['element_'.$element->id]['default_value'];
		}
		
		if($element->range_limit_by == 'c'){
			$range_limit_by = $mf_lang['range_type_chars'];
		}else if($element->range_limit_by == 'w'){
			$range_limit_by = $mf_lang['range_type_words'];
		}
		
		if(!empty($element->is_design_mode)){
			$range_limit_by = '<var class="range_limit_by">'.$range_limit_by.'</var>';
		}
		
		$input_handler = '';
		
		if(!empty($element->range_min) || !empty($element->range_max)){
			$currently_entered_length = 0;
			if(!empty($element->default_value)){
				if($element->range_limit_by == 'c'){
					$currently_entered_length = strlen($element->default_value);
				}else if($element->range_limit_by == 'w'){
					$currently_entered_length = count(preg_split("/[\s\.]+/", $element->default_value, NULL, PREG_SPLIT_NO_EMPTY));
				}
			}
		}
		
		if(!empty($element->range_min) && !empty($element->range_max)){
			$range_min_max_tag = sprintf($mf_lang['range_min_max'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var>","<var id=\"range_max_{$element->id}\">{$element->range_max}</var> {$range_limit_by}");
			$currently_entered_tag = sprintf($mf_lang['range_min_max_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

			$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_max_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
			$input_handler = "onkeyup=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\" onchange=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\"";
		}elseif(!empty($element->range_max)){
			$range_max_tag = sprintf($mf_lang['range_max'],"<var id=\"range_max_{$element->id}\">{$element->range_max}</var> {$range_limit_by}");
			$currently_entered_tag = sprintf($mf_lang['range_max_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

			$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_max_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
			$input_handler = "onkeyup=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\" onchange=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\"";
		}elseif(!empty($element->range_min)){
			$range_min_tag = sprintf($mf_lang['range_min'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var> {$range_limit_by}");
			$currently_entered_tag = sprintf($mf_lang['range_min_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

			$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
			$input_handler = "onkeyup=\"count_input({$element->id},'{$element->range_limit_by}');\" onchange=\"count_input({$element->id},'{$element->range_limit_by}');\"";
		}else{
			$range_limit_markup = '';
		}
		
		if(!empty($element->is_design_mode)){
			$input_handler = '';
		}
		
		//if there is any error message unrelated with range rules, don't display the range markup
		if(!empty($error_message)){
			$range_limit_markup = '';
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
			<textarea id="element_{$element->id}" name="element_{$element->id}" class="element textarea {$element->size}" rows="8" cols="90" {$input_handler}>{$element->default_value}</textarea>
			{$range_limit_markup} 
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	//File Upload
	function mf_display_file($element){
		global $mf_lang;

		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}

		if(!empty($element->machform_path)){
			$machform_path = $element->machform_path;
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}

		//check for populated value 
		if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
			foreach ($element->populated_value['element_'.$element->id]['default_value'] as $data){
				$queue_id = "element_{$element->id}".substr(strtoupper(md5(mt_rand())),0,6);
				
				//trim filename if more than 20 characters
				if(strlen($data['filename']) > 20){
					$display_filename = substr($data['filename'],0,20)."...";
				}else{
					$display_filename = $data['filename'];
				}
				
				if($element->is_edit_entry){
					$db_live_status = 2;
				}else{
					$db_live_status = 1;
				}

				$queue_content .= <<<EOT
						<div class="uploadifyQueueItem completed" id="{$queue_id}">
						<div class="cancel">									
							<a href="javascript:remove_attachment('{$data['filename']}',{$element->form_id},{$element->id},'{$queue_id}',{$db_live_status},{$data['entry_id']});"><img border="0" src="{$machform_path}images/icons/delete.png"></a>
						</div>	
						<span class="fileName">
						  <img align="absmiddle" src="{$machform_path}images/icons/attach.gif" class="file_attached">{$display_filename} ({$data['filesize']})
						</span>
						</div>
EOT;
			
			}
			
			
		}
		
		
		
		if(!$element->is_design_mode && !empty($element->file_enable_advance)){
			
			if(!empty($element->populated_value['element_'.$element->id]['file_token'])){
				$file_token = $element->populated_value['element_'.$element->id]['file_token'];
				
				//check for existing listfile
				$listfile_name = $element->machform_data_path.$element->upload_dir."/form_{$element->form_id}/files/listfile_{$file_token}.php";
				if(file_exists($listfile_name)){
					$uploaded_files = file($listfile_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
					array_shift($uploaded_files);
					array_pop($uploaded_files);
					
					foreach($uploaded_files as $tmp_filename_path){
						$file_size = mf_format_bytes(filesize($tmp_filename_path));
						
						$tmp_filename_only =  basename($tmp_filename_path);
						$filename_value    =  substr($tmp_filename_only,strpos($tmp_filename_only,'-')+1);
						$filename_value    =  str_replace('.tmp', '', $filename_value);			
						$filename_value	   =  str_replace('|','',$filename_value);
						
						$queue_id = "element_{$element->id}".substr(strtoupper(md5(mt_rand())),0,6);
						
						//trim filename if more than 20 characters
						if(strlen($filename_value) > 20){
							$display_filename = substr($filename_value,0,20)."...";
						}else{
							$display_filename = $filename_value;
						}
				
						$queue_content .= <<<EOT
							<div class="uploadifyQueueItem completed" id="{$queue_id}">
							<div class="cancel">									
							<a href="javascript:remove_attachment('{$filename_value}',{$element->form_id},{$element->id},'{$queue_id}',0,'{$file_token}');"><img border="0" src="{$machform_path}images/icons/delete.png"></a>
						    </div>		
							<span class="fileName">
							  <img align="absmiddle" src="{$machform_path}images/icons/attach.gif" class="file_attached">{$display_filename} ({$file_size})
							</span>
							</div>
EOT;
					}
				}
				
				
				
			}else{
				$file_token = md5(uniqid(rand(), true)); 
			}
			
			//generate parameters for auto upload
			if(!empty($element->file_auto_upload)){
				$auto_upload = 'true';
			}else{
				$auto_upload = 'false';
				$upload_link_show_tag = "$(\"#element_{$element->id}_upload_link\").show();";
				$upload_link_hide_tag = "$(\"#element_{$element->id}_upload_link\").hide();";
			}
			
			//generate parameters for multi upload
			if(!empty($element->file_enable_multi_upload)){
				$multi_upload = 'true';
				$queue_limit  = $element->file_max_selection;
			}else{
				$multi_upload = 'false';
				$queue_limit  = 1;
			}
			
			//generate parameters for file size limit
			if(!empty($element->file_enable_size_limit)){
				if(!empty($element->file_size_max)){
					$file_size_max_bytes = 1048576 * $element->file_size_max;
					$size_limit = "'sizeLimit' : {$file_size_max_bytes},";
				}else{
					$size_limit = "'sizeLimit' : 10485760,"; //default 10MB
				}
			}
			
			if(!empty($element->file_type_list) && !empty($element->file_enable_type_limit)){
				if($element->file_block_or_allow == 'a'){ //if this is an allow list
					$allowed_file_types = explode(',',$element->file_type_list);
					array_walk($allowed_file_types,create_function('&$val','$val = "*.".strtolower(trim($val));'));
					$allowed_file_types_joined = implode(';',$allowed_file_types);
					
					$file_type_limit_allow = <<<EOT
					 'fileExt'     : '{$allowed_file_types_joined}',
  					 'fileDesc'    : '{$allowed_file_types_joined}',
EOT;
				}else if($element->file_block_or_allow == 'b'){ //if this is a block list
					$blocked_file_types = explode(',',$element->file_type_list);
					array_walk($blocked_file_types,create_function('&$val','$val = strtolower(trim($val));'));
					$blocked_file_types_joined = implode(',',$blocked_file_types);
					
					$file_type_limit_block = "'fileExtBlocked'  : '{$blocked_file_types_joined}',";
				}
			}
			
			$msg_queue_limited = sprintf($mf_lang['file_queue_limited'],$queue_limit);
			$msg_upload_max	   = sprintf($mf_lang['file_upload_max'],$element->file_size_max);
			$uploader_script = <<<EOT
<script type="text/javascript">
	$(function(){
		
		if ($.browser.flash == true){
		      $('#element_{$element->id}').uploadify({
		        'uploader'   	  : '{$machform_path}js/uploadify/uploadify.swf',
		        'script'     	  : '{$machform_path}upload.php',
		        'cancelImg'  	  : '{$machform_path}images/icons/stop.png',
		        'removeCompleted' : false,
		        'displayData' 	  : 'percentage',
		        'scriptData'  : {
		        				 'form_id': {$element->form_id},
		        				 'element_id': {$element->id},
		        				 'file_token': '{$file_token}'
								},
				{$file_type_limit_allow}
				{$file_type_limit_block}
		        'auto'        : {$auto_upload},
		        'multi'       : {$multi_upload},
		        'queueSizeLimit' : {$queue_limit},
		        'onQueueFull'    : function (event,queueSizeLimit) {
				      alert('{$msg_queue_limited}');
				    },
		        'queueID'	  : 'element_{$element->id}_queue',
		        {$size_limit}
		        'buttonImg'   : '{$machform_path}images/upload_button.png',
		        'onError'     : function (event,ID,fileObj,errorObj) {
			      	if(errorObj.type == 'file_size_limited'){
			      		$("#element_{$element->id}" + ID + " span.percentage").text(' - {$msg_upload_max}');
					}else if(errorObj.type == 'file_type_blocked'){
						$("#element_{$element->id}" + ID + " span.percentage").text(' - {$mf_lang['file_type_limited']}');
					}
		        	{$upload_link_hide_tag}
			    },
		        'onSelectOnce' : function(event,data) {
				       {$upload_link_show_tag}
				       check_upload_queue({$element->id},{$multi_upload},{$queue_limit},'{$msg_queue_limited}');
				      
				       if($("html").hasClass("embed")){
				       		$.postMessage({mf_iframe_height: $('body').outerHeight(true)}, '*', parent );
				   	   }
				    },
				'onAllComplete' : function(event,data) {
				       $("#element_{$element->id}_upload_link").hide();
				       
				       if($("#form_{$element->form_id}").data('form_submitting') === true){
				       		upload_all_files();
					   }
				    },
				'onComplete'  : function(event, ID, fileObj, response, data) {
					var is_valid_response = false;
					try{
						var response_json = jQuery.parseJSON(response);
						is_valid_response = true;
					}catch(e){
						is_valid_response = false;
					}
					
					if(is_valid_response == true && response_json.status == "ok"){
						var remove_link = "<a href=\"javascript:remove_attachment('" + response_json.message + "',{$element->form_id},{$element->id},'element_{$element->id}" + ID + "',0,'{$file_token}');\"><img border=\"0\" src=\"{$machform_path}images/icons/delete.png\" /></a>";
						$("#element_{$element->id}" + ID + " > div.cancel > a").replaceWith(remove_link);
				        $("#element_{$element->id}" + ID + " > span.fileName").prepend('<img align="absmiddle" class="file_attached" src="{$machform_path}images/icons/attach.gif">'); 
			        }else{
			        	$("#element_{$element->id}" + ID).addClass('uploadifyError');
			        	$("#element_{$element->id}" + ID + " div.cancel > a ").replaceWith('<img border="0" src="{$machform_path}images/icons/exclamation.png" />');
						$("#element_{$element->id}" + ID + " span.percentage").text(' - {$mf_lang['file_error_upload']}');
					}  
			    }
		      });
	     }else{
	     	$("#element_{$element->id}_token").remove();
		 }
    });
</script>
<input type="hidden" id="element_{$element->id}_token" name="element_{$element->id}_token" value="{$file_token}" />
<a id="element_{$element->id}_upload_link" style="display: none" href="javascript:$('#element_{$element->id}').uploadifyUpload();">{$mf_lang['file_attach']}</a>
EOT;
			$file_queue = "<div id=\"element_{$element->id}_queue\" class=\"file_queue\">{$queue_content}</div>";
		}
		
		if(!empty($queue_content)){
			$file_queue = "<div id=\"element_{$element->id}_queue\" class=\"file_queue uploadifyQueue\">{$queue_content}</div>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
				
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
			<input id="element_{$element->id}" name="element_{$element->id}" class="element file" type="file" />
			{$file_queue} 
			{$uploader_script}
		</div>{$file_option} {$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Website
	function mf_display_url($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for default value
		if(empty($element->default_value)){
			$element->default_value = 'http://';
		}
		
		//check for populated value, if exist, use it instead default_value
		if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
			$element->default_value = $element->populated_value['element_'.$element->id]['default_value'];
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
			
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
			<input id="element_{$element->id}" name="element_{$element->id}" class="element text {$element->size}" type="text"  value="{$element->default_value}" /> 
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Email
	function mf_display_email($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for populated value, if exist, use it instead default_value
		if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
			$element->default_value = $element->populated_value['element_'.$element->id]['default_value'];
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
					
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
			<input id="element_{$element->id}" name="element_{$element->id}" class="element text {$element->size}" type="text" maxlength="255" value="{$element->default_value}" /> 
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	//Phone - Extended
	function mf_display_phone($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check default value
		if(!empty($element->default_value)){
			//split into (xxx) xxx - xxxx
			$default_value_1 = substr($element->default_value,0,3);
			$default_value_2 = substr($element->default_value,3,3);
			$default_value_3 = substr($element->default_value,6,4);
		}
		
		if(!empty($element->populated_value['element_'.$element->id.'_1']['default_value']) || 
		   !empty($element->populated_value['element_'.$element->id.'_2']['default_value']) ||
		   !empty($element->populated_value['element_'.$element->id.'_3']['default_value'])
		){
			$default_value_1 = '';
			$default_value_2 = '';
			$default_value_3 = '';
			$default_value_1 = $element->populated_value['element_'.$element->id.'_1']['default_value'];
			$default_value_2 = $element->populated_value['element_'.$element->id.'_2']['default_value'];
			$default_value_3 = $element->populated_value['element_'.$element->id.'_3']['default_value'];
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" class="element text" size="3" maxlength="3" value="{$default_value_1}" type="text" /> -
			<label for="element_{$element->id}_1">###</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" class="element text" size="3" maxlength="3" value="{$default_value_2}" type="text" /> -
			<label for="element_{$element->id}_2">###</label>
		</span>
		<span>
	 		<input id="element_{$element->id}_3" name="element_{$element->id}_3" class="element text" size="4" maxlength="4" value="{$default_value_3}" type="text" />
			<label for="element_{$element->id}_3">####</label>
		</span>
		{$guidelines} {$error_message}
		</li>
EOT;
		

		return $element_markup;
	}
	
	//Phone - Simple
	function mf_display_simple_phone($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
				
		//check for populated value
		if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
			$element->default_value = $element->populated_value['element_'.$element->id]['default_value'];
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<div>
			<input id="element_{$element->id}" name="element_{$element->id}" class="element text medium" type="text" maxlength="255" value="{$element->default_value}"/> 
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	
	//Date - Normal
	function mf_display_date($element){
		
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for default value
		$cal_default_value = '';
		if(!empty($element->default_value)){
			//the default value can be mm/dd/yyyy or any valid english date words
			//we need to convert the default value into three parts (mm, dd, yyyy)
			$timestamp = strtotime($element->default_value);

			if(($timestamp !== false) && ($timestamp != -1)){
				$valid_default_date = date('m-d-Y', $timestamp);
				$valid_default_date = explode('-',$valid_default_date);
				
				$default_value_1 = $valid_default_date[0];
				$default_value_2 = $valid_default_date[1];
				$default_value_3 = $valid_default_date[2];
			}else{ //it's not a valid date, display blank
				$default_value_1 = '';
				$default_value_2 = '';
				$default_value_3 = '';
			}
		}
		
		//if there's value submitted from the form, overwrite the default value
		if(!empty($element->populated_value['element_'.$element->id.'_1']['default_value']) || 
		   !empty($element->populated_value['element_'.$element->id.'_2']['default_value']) ||
		   !empty($element->populated_value['element_'.$element->id.'_3']['default_value'])
		){
			$default_value_1 = '';
			$default_value_2 = '';
			$default_value_3 = '';
			$default_value_1 = $element->populated_value['element_'.$element->id.'_1']['default_value'];
			$default_value_2 = $element->populated_value['element_'.$element->id.'_2']['default_value'];
			$default_value_3 = $element->populated_value['element_'.$element->id.'_3']['default_value'];
		}
		
		if(!empty($default_value_1) && !empty($default_value_2) && !empty($default_value_3)){
			$cal_default_value = "\$('#element_{$element->id}_datepick').datepick('setDate', \$.datepick.newDate({$default_value_3}, {$default_value_1}, {$default_value_2}));";
		}
		
		$machform_path = '';
		if(!empty($element->machform_path)){
			$machform_path = $element->machform_path;
		}


		$cal_min_date = '';
		$cal_max_date = '';
		if(!empty($element->date_enable_range)){
			if(!empty($element->date_range_min) && ($element->date_range_min != '0000-00-00')){ //value: yyyy-mm-dd
				$date_range_min = explode('-',$element->date_range_min);
				$cal_min_date = ", minDate: '{$date_range_min[1]}/{$date_range_min[2]}/{$date_range_min[0]}'"; //the calendar needs mm/dd/yyyy format
			}
			
			if(!empty($element->date_range_max) && ($element->date_range_max != '0000-00-00')){ //value: yyyy-mm-dd
				$date_range_max = explode('-',$element->date_range_max);
				$cal_max_date = ", maxDate: '{$date_range_max[1]}/{$date_range_max[2]}/{$date_range_max[0]}'"; //the calendar needs mm/dd/yyyy format
			}
		}
		if(!empty($element->date_disable_past_future)){
			$today_date = date('m/d/Y');
			if($element->date_past_future == 'p'){ //disable past dates
				//set minDate to today's date
				$cal_min_date = ", minDate: '{$today_date}'";
			}else if($element->date_past_future == 'f'){ //disable future dates
				//set maxDate to today's date
				$cal_max_date = ", maxDate: '{$today_date}'";
			}
		}
		
		//disable weekend dates
		$cal_disable_weekend = '';
		if(!empty($element->date_disable_weekend)){
			$cal_disable_weekend = ' , onDate: $.datepick.noWeekends';
		}
		
		//disable specific dates
		$cal_disable_specific = '';
		$cal_disable_specific_callback = '';
		if(!empty($element->date_disable_specific) && !empty($element->date_disabled_list)){
			
			$date_disabled_list = explode(',',$element->date_disabled_list);
			$disabled_days = '';
			foreach ($date_disabled_list as $a_day){
				$a_day = trim($a_day);
				$a_day_exploded = explode('/',$a_day);
				$disabled_days .= "[{$a_day_exploded[0]}, {$a_day_exploded[1]}, {$a_day_exploded[2]}],";
			}
			$disabled_days = rtrim($disabled_days,',');
			$disabled_days = "var disabled_days_{$element->id} = [".$disabled_days."];";

$cal_disable_specific = <<<EOT
{$disabled_days}
			function disable_days_{$element->id}(date, inMonth) { 
			    var disable_weekend = {$element->date_disable_weekend};
				if (inMonth) { 
					var is_weekend = 0;
					if((date.getDay() || 7) >= 6){
						is_weekend = 1;
					}
					
			    	if(disable_weekend == 1 && is_weekend == 1){
			    		return {selectable: false};
			    	}else{
				        for (i = 0; i < disabled_days_{$element->id}.length; i++) { 
				            if (date.getMonth() + 1 == disabled_days_{$element->id}[i][0] && 
				                date.getDate() == disabled_days_{$element->id}[i][1] &&
				                date.getFullYear() == disabled_days_{$element->id}[i][2]
				                ) { 
				                return {dateClass: 'day_disabled', selectable: false}; 
				            } 
				        } 
			        }
			        
			    } 
			    return {}; 
			}	
EOT;
			$cal_disable_specific_callback = ", onDate: disable_days_{$element->id}";
		}
		
		

		
$calendar_script = <<<EOT
<script type="text/javascript">
			{$cal_disable_specific}
			$('#element_{$element->id}_datepick').datepick({ 
	    		onSelect: select_date,
	    		showTrigger: '#cal_img_{$element->id}'
	    		{$cal_min_date}
	    		{$cal_max_date}
	    		{$cal_disable_weekend}
	    		{$cal_disable_specific_callback}
			});
			{$cal_default_value}
</script>
EOT;

		//don't call the calendar script if this is on edit_form page
		$cal_img_style = 'display: none';
		if($element->is_design_mode){
			$calendar_script = '';
			$cal_img_style = 'display: block';
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" class="element text" size="2" maxlength="2" value="{$default_value_1}" type="text" /> /
			<label for="element_{$element->id}_1">{$mf_lang['date_mm']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" class="element text" size="2" maxlength="2" value="{$default_value_2}" type="text" /> /
			<label for="element_{$element->id}_2">{$mf_lang['date_dd']}</label>
		</span>
		<span>
	 		<input id="element_{$element->id}_3" name="element_{$element->id}_3" class="element text" size="4" maxlength="4" value="{$default_value_3}" type="text" />
			<label for="element_{$element->id}_3">{$mf_lang['date_yyyy']}</label>
		</span>
	
		<span id="calendar_{$element->id}">
		    <input type="hidden" value="" name="element_{$element->id}_datepick" id="element_{$element->id}_datepick">
			<div style="{$cal_img_style}"><img id="cal_img_{$element->id}" class="datepicker" src="{$machform_path}images/calendar.gif" alt="Pick a date." /></div>	
		</span>
		{$calendar_script}
		{$guidelines} {$error_message}
		</li>
EOT;
	
		return $element_markup;
	}
	
	//Date - Normal
	function mf_display_europe_date($element){
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for default value
		$cal_default_value = '';
		if(!empty($element->default_value)){
			//the default value can be mm/dd/yyyy or any valid english date words
			//we need to convert the default value into three parts (dd, mm, yyyy)
			$timestamp = strtotime($element->default_value);

			if(($timestamp !== false) && ($timestamp != -1)){
				$valid_default_date = date('d-m-Y', $timestamp);
				$valid_default_date = explode('-',$valid_default_date);
				
				$default_value_1 = $valid_default_date[0];
				$default_value_2 = $valid_default_date[1];
				$default_value_3 = $valid_default_date[2];
			}else{ //it's not a valid date, display blank
				$default_value_1 = '';
				$default_value_2 = '';
				$default_value_3 = '';
			}
		}
		
		//if there's value submitted from the form, overwrite the default value
		if(!empty($element->populated_value['element_'.$element->id.'_1']['default_value']) || 
		   !empty($element->populated_value['element_'.$element->id.'_2']['default_value']) ||
		   !empty($element->populated_value['element_'.$element->id.'_3']['default_value'])
		){
			$default_value_1 = '';
			$default_value_2 = '';
			$default_value_3 = '';
			$default_value_1 = $element->populated_value['element_'.$element->id.'_1']['default_value'];
			$default_value_2 = $element->populated_value['element_'.$element->id.'_2']['default_value'];
			$default_value_3 = $element->populated_value['element_'.$element->id.'_3']['default_value'];
		}
		
		if(!empty($default_value_1) && !empty($default_value_2) && !empty($default_value_3)){
			$cal_default_value = "\$('#element_{$element->id}_datepick').datepick('setDate', \$.datepick.newDate({$default_value_3}, {$default_value_2}, {$default_value_1}));";
		}
		
		$machform_path = '';
		if(!empty($element->machform_path)){
			$machform_path = $element->machform_path;
		}
		
		$cal_min_date = '';
		$cal_max_date = '';
		if(!empty($element->date_enable_range)){
			if(!empty($element->date_range_min)){ //value: yyyy-mm-dd
				$date_range_min = explode('-',$element->date_range_min);
				$cal_min_date = ", minDate: '{$date_range_min[1]}/{$date_range_min[2]}/{$date_range_min[0]}'"; //the calendar needs mm/dd/yyyy format
			}
			
			if(!empty($element->date_range_max)){ //value: yyyy-mm-dd
				$date_range_max = explode('-',$element->date_range_max);
				$cal_max_date = ", maxDate: '{$date_range_max[1]}/{$date_range_max[2]}/{$date_range_max[0]}'"; //the calendar needs mm/dd/yyyy format
			}
		}
		if(!empty($element->date_disable_past_future)){
			$today_date = date('m/d/Y');
			if($element->date_past_future == 'p'){ //disable past dates
				//set minDate to today's date
				$cal_min_date = ", minDate: '{$today_date}'";
			}else if($element->date_past_future == 'f'){ //disable future dates
				//set maxDate to today's date
				$cal_max_date = ", maxDate: '{$today_date}'";
			}
		}
		
		//disable weekend dates
		$cal_disable_weekend = '';
		if(!empty($element->date_disable_weekend)){
			$cal_disable_weekend = ' , onDate: $.datepick.noWeekends';
		}
		
		//disable specific dates
		$cal_disable_specific = '';
		$cal_disable_specific_callback = '';
		if(!empty($element->date_disable_specific) && !empty($element->date_disabled_list)){
			
			$date_disabled_list = explode(',',$element->date_disabled_list);
			$disabled_days = '';
			foreach ($date_disabled_list as $a_day){
				$a_day = trim($a_day);
				$a_day_exploded = explode('/',$a_day);
				$disabled_days .= "[{$a_day_exploded[0]}, {$a_day_exploded[1]}, {$a_day_exploded[2]}],";
			}
			$disabled_days = rtrim($disabled_days,',');
			$disabled_days = "var disabled_days_{$element->id} = [".$disabled_days."];";

$cal_disable_specific = <<<EOT
{$disabled_days}
			function disable_days_{$element->id}(date, inMonth) { 
			    var disable_weekend = {$element->date_disable_weekend};
				if (inMonth) { 
					var is_weekend = 0;
					if((date.getDay() || 7) >= 6){
						is_weekend = 1;
					}
					
			    	if(disable_weekend == 1 && is_weekend == 1){
			    		return {selectable: false};
			    	}else{
				        for (i = 0; i < disabled_days_{$element->id}.length; i++) { 
				            if (date.getMonth() + 1 == disabled_days_{$element->id}[i][0] && 
				                date.getDate() == disabled_days_{$element->id}[i][1] &&
				                date.getFullYear() == disabled_days_{$element->id}[i][2]
				                ) { 
				                return {dateClass: 'day_disabled', selectable: false}; 
				            } 
				        } 
			        }
			        
			    } 
			    return {}; 
			}	
EOT;
			$cal_disable_specific_callback = ", onDate: disable_days_{$element->id}";
		}
		
		

		
$calendar_script = <<<EOT
<script type="text/javascript">
			{$cal_disable_specific}
			$('#element_{$element->id}_datepick').datepick({ 
	    		onSelect: select_europe_date,
	    		showTrigger: '#cal_img_{$element->id}'
	    		{$cal_min_date}
	    		{$cal_max_date}
	    		{$cal_disable_weekend}
	    		{$cal_disable_specific_callback}
			});
			{$cal_default_value}
</script>
EOT;

		//don't call the calendar script if this is on edit_form page
		$cal_img_style = 'display: none';
		if($element->is_design_mode){
			$calendar_script = '';
			$cal_img_style = 'display: block';
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" class="element text" size="2" maxlength="2" value="{$default_value_1}" type="text" /> /
			<label for="element_{$element->id}_1">{$mf_lang['date_dd']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" class="element text" size="2" maxlength="2" value="{$default_value_2}" type="text" /> /
			<label for="element_{$element->id}_2">{$mf_lang['date_mm']}</label>
		</span>
		<span>
	 		<input id="element_{$element->id}_3" name="element_{$element->id}_3" class="element text" size="4" maxlength="4" value="{$default_value_3}" type="text" />
			<label for="element_{$element->id}_3">{$mf_lang['date_yyyy']}</label>
		</span>
	
		<span id="calendar_{$element->id}">
			<input type="hidden" value="" name="element_{$element->id}_datepick" id="element_{$element->id}_datepick">
			<div style="{$cal_img_style}"><img id="cal_img_{$element->id}" class="datepicker" src="{$machform_path}images/calendar.gif" alt="Pick a date." /></div>	
		</span>
		{$calendar_script}
		{$guidelines} {$error_message}
		</li>
EOT;
	
		return $element_markup;
	}
	
	
	//Multiple Choice
	function mf_display_radio($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		
		if($element->is_private){
			$el_class[] = 'private';
		}
		
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->choice_columns)){
			$col_number = (int) $element->choice_columns;
			if($col_number == 2){
				$el_class[] = 'two_columns';
			}else if($col_number == 3){
				$el_class[] = 'three_columns';
			}else if($col_number == 9){
				$el_class[] = 'inline_columns';
			}
		}
		
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			$error_message = "<p class=\"error\">{$element->error_message}</p>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		$option_markup = '';
		
		//don't shuffle the choice on edit form page
		if(($element->constraint == 'random') && ($element->is_design_mode != true)){
			$temp = $element->options;
			shuffle($temp);
			$element->options = $temp;
		}
		
		$has_price_definition = false;
		$selected_price_value = 0;
		
		foreach ($element->options as $option){
			
			if($option->is_default){
				$checked = 'checked="checked"';
				$selected_price_value = $option->price_definition;
			}else{
				$checked = '';
			}
			
			//check for populated values
			if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
				$checked = '';

				if($element->populated_value['element_'.$element->id]['default_value'] == $option->id){
					$checked = 'checked="checked"';
					$selected_price_value = $option->price_definition;
				}
			}
			
			if(isset($option->price_definition)){
				$price_definition_data_attr = 'data-pricedef="'.$option->price_definition.'"';
				$has_price_definition = true;
			}else{
				$price_definition_data_attr = '';
			}
			
			$pre_option_markup = '';			
			$pre_option_markup .= "<input id=\"element_{$element->id}_{$option->id}\" {$price_definition_data_attr} name=\"element_{$element->id}\" class=\"element radio\" type=\"radio\" value=\"{$option->id}\" {$checked} />\n";
			$pre_option_markup .= "<label class=\"choice\" for=\"element_{$element->id}_{$option->id}\">{$option->option}</label>\n";
			
			$option_markup .= '<span>'.$pre_option_markup."</span>\n";
		}
		
		//if 'other choice' is enabled, add a new choice at the end and add text field
		if(!empty($element->choice_has_other)){
			if(!empty($element->populated_value['element_'.$element->id.'_other']['default_value'])){
				$other_value = $element->populated_value['element_'.$element->id.'_other']['default_value'];
				$checked = 'checked="checked"';
			}else{
				$checked = '';
				$other_value = '';	
			}
			
			$pre_option_markup = '';
			$pre_option_markup .= "<input id=\"element_{$element->id}_0\" name=\"element_{$element->id}\" class=\"element radio\" type=\"radio\" value=\"\" {$checked} />\n";
			$pre_option_markup .= "<label class=\"choice other\" for=\"element_{$element->id}_0\">{$element->choice_other_label}</label>\n";
			$pre_option_markup .= "<input type=\"text\" value=\"{$other_value}\" class=\"element text other\" name=\"element_{$element->id}_other\" id=\"element_{$element->id}_other\" onclick=\"\$('#element_{$element->id}_0').prop('checked',true);\" />\n";
			
			$option_markup .= '<span>'.$pre_option_markup."</span>\n";
		}

		if($has_price_definition === true){
			$price_data_tag = 'data-pricefield="radio" data-pricevalue="'.$selected_price_value.'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$price_data_tag} {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<div>
			{$option_markup}
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Checkboxes
	function mf_display_checkbox($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		
		if($element->is_private){
			$el_class[] = 'private';
		}
		
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->choice_columns)){
			$col_number = (int) $element->choice_columns;
			if($col_number == 2){
				$el_class[] = 'two_columns';
			}else if($col_number == 3){
				$el_class[] = 'three_columns';
			}else if($col_number == 9){
				$el_class[] = 'inline_columns';
			}
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			$error_message = "<p class=\"error\">{$element->error_message}</p>";
		}
		
		//build the class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//check for populated value first, if any exist, unselect all default value
		$is_populated = false;
		foreach ($element->options as $option){
			
			if(!empty($element->populated_value['element_'.$element->id.'_'.$option->id]['default_value'])){
				$is_populated = true;
				break;
			}
		}
	
		$option_markup = '';
		$has_price_definition = false;
		$selected_price_value = 0;
		
		foreach ($element->options as $option){
			if(!$is_populated){
				if($option->is_default){
					$checked = 'checked="checked"';
					$selected_price_value += (double) $option->price_definition;
				}else{
					$checked = '';
				}
			}else{
				
				if(!empty($element->populated_value['element_'.$element->id.'_'.$option->id]['default_value'])){
					$checked = 'checked="checked"';
					$selected_price_value += (double) $option->price_definition;
				}else{
					$checked = '';	
				}
			}
			
			if(isset($option->price_definition)){
				$price_definition_data_attr = 'data-pricedef="'.$option->price_definition.'"';
				$has_price_definition = true;
			}else{
				$price_definition_data_attr = '';
			}
			
			$pre_option_markup = '';
			$pre_option_markup .= "<input id=\"element_{$element->id}_{$option->id}\" {$price_definition_data_attr} name=\"element_{$element->id}_{$option->id}\" class=\"element checkbox\" type=\"checkbox\" value=\"1\" {$checked} />\n";
			$pre_option_markup .= "<label class=\"choice\" for=\"element_{$element->id}_{$option->id}\">{$option->option}</label>\n";
			
			$option_markup .= '<span>'.$pre_option_markup."</span>\n";
		}
		
		//if 'other checkbox' is enabled, add a new checkbox at the end and add text field
		if(!empty($element->choice_has_other)){
			if(!empty($element->populated_value['element_'.$element->id.'_other']['default_value'])){
				$other_value = $element->populated_value['element_'.$element->id.'_other']['default_value'];
				$checked = 'checked="checked"';
			}else{
				$checked = '';
				$other_value = '';	
			}
			
			$pre_option_markup = '';
			$pre_option_markup .= "<input id=\"element_{$element->id}_0\" name=\"element_{$element->id}\" class=\"element checkbox\" onchange=\"clear_cb_other(this,{$element->id});\"  type=\"checkbox\" value=\"\" {$checked} />\n";
			$pre_option_markup .= "<label class=\"choice other\" for=\"element_{$element->id}_0\">{$element->choice_other_label}</label>\n";
			$pre_option_markup .= "<input type=\"text\" value=\"{$other_value}\" class=\"element text other\" name=\"element_{$element->id}_other\" id=\"element_{$element->id}_other\" onclick=\"\$('#element_{$element->id}_0').prop('checked',true);\" />\n";
			
			$option_markup .= '<span>'.$pre_option_markup."</span>\n";
		}
		
		if($has_price_definition === true){
			$selected_price_value = (double) $selected_price_value;
			$price_data_tag = 'data-pricefield="checkbox" data-pricevalue="'.$selected_price_value.'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$price_data_tag} {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<div>
			{$option_markup}
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}

	
	//Dropdown
	function mf_display_select($element){
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		$option_markup = '';
		$has_price_definition = false;
		$selected_price_value = 0;
		
		$has_default = false;
		foreach ($element->options as $option){
			
			if($option->is_default){
				$selected = 'selected="selected"';
				$has_default = true;
				$selected_price_value = $option->price_definition;
			}else{
				$selected = '';
			}
			
			if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
				$selected = '';
				if($element->populated_value['element_'.$element->id]['default_value'] == $option->id){
					$selected = 'selected="selected"';
					$selected_price_value = $option->price_definition;
				}
			}
			
			if(isset($option->price_definition)){
				$price_definition_data_attr = 'data-pricedef="'.$option->price_definition.'"';
				$has_price_definition = true;
			}else{
				$price_definition_data_attr = '';
			}
			
			$option_markup .= "<option value=\"{$option->id}\" {$price_definition_data_attr} {$selected}>{$option->option}</option>\n";
		}
		
		if(!$has_default){
			if(!empty($element->populated_value['element_'.$element->id]['default_value'])){
				$option_markup = '<option value=""></option>'."\n".$option_markup;
			}else{
				$option_markup = '<option value="" selected="selected"></option>'."\n".$option_markup;
			}
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
		if($has_price_definition === true){
			$price_data_tag = 'data-pricefield="select" data-pricevalue="'.$selected_price_value.'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$price_data_tag} {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
		<select class="element select {$element->size}" id="element_{$element->id}" name="element_{$element->id}"> 
			{$option_markup}
		</select>
		</div>{$guidelines} {$error_message}
		</li>
EOT;

		return $element_markup;
	}
	
	
	//Name - Simple
	function mf_display_simple_name($element){
		
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" type="text" class="element text" maxlength="255" size="8" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" />
			<label>{$mf_lang['name_first']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" type="text" class="element text" maxlength="255" size="14" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" />
			<label>{$mf_lang['name_last']}</label>
		</span>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Name - Simple, with Middle Name
	function mf_display_simple_name_wmiddle($element){
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" type="text" class="element text" maxlength="255" size="8" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" />
			<label>{$mf_lang['name_first']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" type="text" class="element text" maxlength="255" size="8" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" />
			<label>{$mf_lang['name_middle']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_3" name="element_{$element->id}_3" type="text" class="element text" maxlength="255" size="14" value="{$element->populated_value['element_'.$element->id.'_3']['default_value']}" />
			<label>{$mf_lang['name_last']}</label>
		</span>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}

	//Name 
	function mf_display_name($element){
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" type="text" class="element text" maxlength="255" size="2" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" />
			<label>{$mf_lang['name_title']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" type="text" class="element text" maxlength="255" size="8" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" />
			<label>{$mf_lang['name_first']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_3" name="element_{$element->id}_3" type="text" class="element text" maxlength="255" size="14" value="{$element->populated_value['element_'.$element->id.'_3']['default_value']}" />
			<label>{$mf_lang['name_last']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_4" name="element_{$element->id}_4" type="text" class="element text" maxlength="255" size="3" value="{$element->populated_value['element_'.$element->id.'_4']['default_value']}" />
			<label>{$mf_lang['name_suffix']}</label>
		</span>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Name, with Middle
	function mf_display_name_wmiddle($element){
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span class="namewm_ext">
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" type="text" class="element text large" maxlength="255" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" />
			<label>{$mf_lang['name_title']}</label>
		</span>
		<span class="namewm_first">
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" type="text" class="element text large" maxlength="255" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" />
			<label>{$mf_lang['name_first']}</label>
		</span>
		<span class="namewm_middle">
			<input id="element_{$element->id}_3" name="element_{$element->id}_3" type="text" class="element text large" maxlength="255" value="{$element->populated_value['element_'.$element->id.'_3']['default_value']}" />
			<label>{$mf_lang['name_middle']}</label>
		</span>
		<span class="namewm_last">
			<input id="element_{$element->id}_4" name="element_{$element->id}_4" type="text" class="element text large" maxlength="255" value="{$element->populated_value['element_'.$element->id.'_4']['default_value']}" />
			<label>{$mf_lang['name_last']}</label>
		</span>
		<span class="namewm_ext">
			<input id="element_{$element->id}_5" name="element_{$element->id}_5" type="text" class="element text large" maxlength="255" value="{$element->populated_value['element_'.$element->id.'_5']['default_value']}" />
			<label>{$mf_lang['name_suffix']}</label>
		</span>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Time
	function mf_display_time($element){
		
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		if(!empty($element->populated_value['element_'.$element->id.'_4']['default_value'])){
			if($element->populated_value['element_'.$element->id.'_4']['default_value'] == 'AM'){
				$selected_am = 'selected';
			}else{
				$selected_pm = 'selected';
			}
		}
		
		if(!empty($element->time_showsecond)){
			$seconds_markup =<<<EOT
		<span>
			<input id="element_{$element->id}_3" name="element_{$element->id}_3" class="element text " size="2" type="text" maxlength="2" value="{$element->populated_value['element_'.$element->id.'_3']['default_value']}" />
			<label>{$mf_lang['time_ss']}</label>
		</span>
EOT;
			$seconds_separator = ':';
		}else{
			$seconds_markup = '';
			$seconds_separator = '';
		}
		
		if(empty($element->time_24hour)){
			$am_pm_markup =<<<EOT
		<span>
			<select class="element select" style="width:4em" id="element_{$element->id}_4" name="element_{$element->id}_4">
				<option value="AM" {$selected_am}>AM</option>
				<option value="PM" {$selected_pm}>PM</option>
			</select>
			<label>AM/PM</label>
		</span>
EOT;
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" class="element text " size="2" type="text" maxlength="2" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" /> : 
			<label>{$mf_lang['time_hh']}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" class="element text " size="2" type="text" maxlength="2" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" /> {$seconds_separator} 
			<label>{$mf_lang['time_mm']}</label>
		</span>
		{$seconds_markup}
		{$am_pm_markup}{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	//Price
	function mf_display_money($element){
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
			
		}
		
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
		if($element->constraint != 'yen'){ 
			if($element->constraint == 'pound'){
				$main_cur  = $mf_lang['price_pound_main'];
				$child_cur = $mf_lang['price_pound_sub'];
				$cur_symbol = '&#163;';
			}elseif ($element->constraint == 'euro'){
				$main_cur  = $mf_lang['price_euro_main'];
				$child_cur = $mf_lang['price_euro_sub'];
				$cur_symbol = '&#8364;';
			}elseif ($element->constraint == 'baht'){
				$main_cur  = $mf_lang['price_baht_main'];
				$child_cur = $mf_lang['price_baht_sub'];
				$cur_symbol = '&#3647;';
			}elseif ($element->constraint == 'rupees'){
				$main_cur  = $mf_lang['price_rupees_main'];
				$child_cur = $mf_lang['price_rupees_sub'];
				$cur_symbol = 'Rs';
			}elseif ($element->constraint == 'rand'){
				$main_cur  = $mf_lang['price_rand_main'];
				$child_cur = $mf_lang['price_rand_sub'];
				$cur_symbol = 'R';
			}elseif ($element->constraint == 'forint'){
				$main_cur  = $mf_lang['price_forint_main'];
				$child_cur = $mf_lang['price_forint_sub'];
				$cur_symbol = '&#70;&#116;';
			}elseif ($element->constraint == 'franc'){
				$main_cur  = $mf_lang['price_franc_main'];
				$child_cur = $mf_lang['price_franc_sub'];
				$cur_symbol = 'CHF';
			}elseif ($element->constraint == 'koruna'){
				$main_cur  = $mf_lang['price_koruna_main'];
				$child_cur = $mf_lang['price_koruna_sub'];
				$cur_symbol = '&#75;&#269;';
			}elseif ($element->constraint == 'krona'){
				$main_cur  = $mf_lang['price_krona_main'];
				$child_cur = $mf_lang['price_krona_sub'];
				$cur_symbol = 'kr';
			}elseif ($element->constraint == 'pesos'){
				$main_cur  = $mf_lang['price_pesos_main'];
				$child_cur = $mf_lang['price_pesos_sub'];
				$cur_symbol = '&#36;';
			}elseif ($element->constraint == 'ringgit'){
				$main_cur  = $mf_lang['price_ringgit_main'];
				$child_cur = $mf_lang['price_ringgit_sub'];
				$cur_symbol = 'RM';
			}elseif ($element->constraint == 'zloty'){
				$main_cur  = $mf_lang['price_zloty_main'];
				$child_cur = $mf_lang['price_zloty_sub'];
				$cur_symbol = '&#122;&#322;';
			}elseif ($element->constraint == 'riyals'){
				$main_cur  = $mf_lang['price_riyals_main'];
				$child_cur = $mf_lang['price_riyals_sub'];
				$cur_symbol = '&#65020;';
			}else{ //dollar
				$main_cur  = $mf_lang['price_dollar_main'];
				$child_cur = $mf_lang['price_dollar_sub'];
				$cur_symbol = '$';
			}

			if(isset($element->price_definition)){
				$price_value  = $element->populated_value['element_'.$element->id.'_1']['default_value'].'.'.$element->populated_value['element_'.$element->id.'_2']['default_value'];
				$price_value  = (double) $price_value;
				
				$price_data_tag = 'data-pricevalue="'.$price_value.'" data-pricefield="money"';
			}		
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class} {$price_data_tag}>
		<label class="description">{$element->title} {$span_required}</label>
		<span class="symbol">{$cur_symbol}</span>
		<span>
			<input id="element_{$element->id}_1" name="element_{$element->id}_1" class="element text currency" size="10" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" type="text" /> .		
			<label for="element_{$element->id}_1">{$main_cur}</label>
		</span>
		<span>
			<input id="element_{$element->id}_2" name="element_{$element->id}_2" class="element text" size="2" maxlength="2" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" type="text" />
			<label for="element_{$element->id}_2">{$child_cur}</label>
		</span>
		{$guidelines} {$error_message}
		</li>
EOT;

		}else{ //for yen, only display one textfield
			$main_cur  = $mf_lang['price_yen'];
			$cur_symbol = '&#165;';
			
			if(isset($element->price_definition)){
				$price_value  = $element->populated_value['element_'.$element->id]['default_value'];
				$price_value  = (double) $price_value;
				
				$price_data_tag = 'data-pricevalue="'.$price_value.'" data-pricefield="money_simple"';
			}		
			
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class} {$price_data_tag}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<span class="symbol">{$cur_symbol}</span>
		<span>
			<input id="element_{$element->id}" name="element_{$element->id}" class="element text currency" size="10" value="{$element->populated_value['element_'.$element->id]['default_value']}" type="text" />	
			<label for="element_{$element->id}">{$main_cur}</label>
		</span>
		{$guidelines} {$error_message}
		</li>
EOT;
		
		}



		return $element_markup;
	}
	
	//Section Break
	function mf_display_section($element){
		$li_class = '';
		$el_class = array();
		
		$el_class[] = "section_break";
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
		$element->guidelines = nl2br($element->guidelines);			
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
			<h3>{$element->title}</h3>
			<p>{$element->guidelines}</p>
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Page Break
	function mf_display_page_break($element){
		
		$firstpage_class = '';
		
		if($element->page_number == 1){
			$firstpage_class = ' firstpage';
		}
		
		if($element->submit_use_image == 1){
			$btn_class = ' hide';
			$image_class = '';
		}else{
			$btn_class = '';
			$image_class = ' hide';
		}
		
		if(empty($element->submit_primary_img)){
			$element->submit_primary_img = 'images/empty.gif';
		}
		
		if(empty($element->submit_secondary_img)){
			$element->submit_secondary_img = 'images/empty.gif';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" class="page_break{$firstpage_class}" title="Click to edit">
			<div>
				<table class="ap_table_pagination" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" style="vertical-align: bottom">
							<input type="submit" disabled="disabled" value="{$element->submit_primary_text}" id="btn_submit_{$element->id}" name="btn_submit_{$element->id}" class="btn_primary btn_submit{$btn_class}">
							<input type="submit" disabled="disabled" value="{$element->submit_secondary_text}" id="btn_prev_{$element->id}" name="btn_prev_{$element->id}" class="btn_secondary btn_submit{$btn_class}">
							<input type="image" disabled="disabled" src="{$element->submit_primary_img}" alt="Continue" value="Continue" id="img_submit_{$element->id}" name="img_submit_{$element->id}" class="img_primary img_submit{$image_class}">
							<input type="image" disabled="disabled" src="{$element->submit_secondary_img}" alt="Previous" value="Previous" id="img_prev_{$element->id}" name="img_prev_{$element->id}" class="img_secondary img_submit{$image_class}">
						</td> 
						<td align="center" style="vertical-align: top" width="75px">
							<span id="pagenum_{$element->id}" name="pagenum_{$element->id}" class="ap_tp_num">{$element->page_number}</span>
							<span id="pagetotal_{$element->id}" name="pagetotal_{$element->id}" class="ap_tp_text">Page {$element->page_number} of {$element->page_total}</span>
						</td>
					</tr>
				</table>
			</div>
		</li>	
EOT;
		
		return $element_markup;
	}
	
	
	
	//Number
	function mf_display_number($element){
		
		global $mf_lang;

		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		$el_class = array();
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
				
		//check for populated value, if exist, use it instead default_value
		if(isset($element->populated_value['element_'.$element->id]['default_value'])){
			$element->default_value = $element->populated_value['element_'.$element->id]['default_value'];
		}
		
		$input_handler = '';
		$maxlength = '';
		
		if(!empty($element->range_min) || !empty($element->range_max)){
			$currently_entered_length = 0;
			if(!empty($element->default_value) && $element->range_limit_by == 'd'){
					$currently_entered_length = strlen($element->default_value);
			}
		}
		
		if($element->range_limit_by == 'd'){
			$range_limit_by = $mf_lang['range_type_digit'];
			
			if(!empty($element->is_design_mode)){
				$range_limit_by = '<var class="range_limit_by">'.$range_limit_by.'</var>';
			}
			
			if(!empty($element->range_min) && !empty($element->range_max)){
				$range_min_max_tag = sprintf($mf_lang['range_min_max'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var>","<var id=\"range_max_{$element->id}\">{$element->range_max}</var> {$range_limit_by}");
				$currently_entered_tag = sprintf($mf_lang['range_min_max_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

				$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_max_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
				$input_handler = "onkeyup=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\" onchange=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\"";
				$maxlength = 'maxlength="'.$element->range_max.'"';
			}elseif(!empty($element->range_max)){
				$range_max_tag = sprintf($mf_lang['range_max'],"<var id=\"range_max_{$element->id}\">{$element->range_max}</var> {$range_limit_by}");
				$currently_entered_tag = sprintf($mf_lang['range_max_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

				$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_max_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
				$input_handler = "onkeyup=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\" onchange=\"limit_input({$element->id},'{$element->range_limit_by}',{$element->range_max});\"";
				$maxlength = 'maxlength="'.$element->range_max.'"';
			}elseif(!empty($element->range_min)){
				$range_min_tag = sprintf($mf_lang['range_min'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var> {$range_limit_by}");
				$currently_entered_tag = sprintf($mf_lang['range_min_entered'],"<var id=\"currently_entered_{$element->id}\">{$currently_entered_length}</var> {$range_limit_by}");

				$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_tag}&nbsp;&nbsp; <em class=\"currently_entered\">{$currently_entered_tag}</em></label>";
				$input_handler = "onkeyup=\"count_input({$element->id},'{$element->range_limit_by}');\" onchange=\"count_input({$element->id},'{$element->range_limit_by}');\"";
			}else{
				$range_limit_markup = '';
			}

			
		}else if($element->range_limit_by == 'v'){
			if(!empty($element->range_min) && !empty($element->range_max)){
				$range_min_max_tag = sprintf($mf_lang['range_number_min_max'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var>","<var id=\"range_max_{$element->id}\">{$element->range_max}</var>");
				$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_max_tag}</label>";
			}elseif(!empty($element->range_max)){
				$range_max_tag = sprintf($mf_lang['range_number_max'],"<var id=\"range_max_{$element->id}\">{$element->range_max}</var>");
				$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_max_tag}</label>";
			}elseif(!empty($element->range_min)){
				$range_min_tag = sprintf($mf_lang['range_number_min'],"<var id=\"range_min_{$element->id}\">{$element->range_min}</var>");
				$range_limit_markup = "<label for=\"element_{$element->id}\">{$range_min_tag}</label>";
			}else{
				$range_limit_markup = '';
			}
		}
		
		if(!empty($element->is_design_mode)){
			$input_handler = '';
		}
		
		//if there is any error message unrelated with range rules, don't display the range markup
		if(!empty($error_message)){
			$range_limit_markup = '';
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description" for="element_{$element->id}">{$element->title} {$span_required}</label>
		<div>
			<input id="element_{$element->id}" name="element_{$element->id}" class="element text {$element->size}" type="text" {$maxlength} value="{$element->default_value}" {$input_handler} /> 
			{$range_limit_markup}
		</div>{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	
	//Address
	function mf_display_address($element){
		
		$country[0]['label'] = "Afghanistan";
		$country[1]['label'] = "Albania";
		$country[2]['label'] = "Algeria";
		$country[3]['label'] = "Andorra";
		$country[4]['label'] = "Antigua and Barbuda";
		$country[5]['label'] = "Argentina";
		$country[6]['label'] = "Armenia";
		$country[7]['label'] = "Australia";
		$country[8]['label'] = "Austria";
		$country[9]['label'] = "Azerbaijan";
		$country[10]['label'] = "Bahamas";
		$country[11]['label'] = "Bahrain";
		$country[12]['label'] = "Bangladesh";
		$country[13]['label'] = "Barbados";
		$country[14]['label'] = "Belarus";
		$country[15]['label'] = "Belgium";
		$country[16]['label'] = "Belize";
		$country[17]['label'] = "Benin";
		$country[18]['label'] = "Bhutan";
		$country[19]['label'] = "Bolivia";
		$country[20]['label'] = "Bosnia and Herzegovina";
		$country[21]['label'] = "Botswana";
		$country[22]['label'] = "Brazil";
		$country[23]['label'] = "Brunei";
		$country[24]['label'] = "Bulgaria";
		$country[25]['label'] = "Burkina Faso";
		$country[26]['label'] = "Burundi";
		$country[27]['label'] = "Cambodia";
		$country[28]['label'] = "Cameroon";
		$country[29]['label'] = "Canada";
		$country[30]['label'] = "Cape Verde";
		$country[31]['label'] = "Central African Republic";
		$country[32]['label'] = "Chad";
		$country[33]['label'] = "Chile";
		$country[34]['label'] = "China";
		$country[35]['label'] = "Colombia";
		$country[36]['label'] = "Comoros";
		$country[37]['label'] = "Congo";
		$country[38]['label'] = "Costa Rica";
		$country[39]['label'] = "Côte d'Ivoire";
		$country[40]['label'] = "Croatia";
		$country[41]['label'] = "Cuba";
		$country[42]['label'] = "Cyprus";
		$country[43]['label'] = "Czech Republic";
		$country[44]['label'] = "Denmark";
		$country[45]['label'] = "Djibouti";
		$country[46]['label'] = "Dominica";
		$country[47]['label'] = "Dominican Republic";
		$country[48]['label'] = "East Timor";
		$country[49]['label'] = "Ecuador";
		$country[50]['label'] = "Egypt";
		$country[51]['label'] = "El Salvador";
		$country[52]['label'] = "Equatorial Guinea";
		$country[53]['label'] = "Eritrea";
		$country[54]['label'] = "Estonia";
		$country[55]['label'] = "Ethiopia";
		$country[56]['label'] = "Fiji";
		$country[57]['label'] = "Finland";
		$country[58]['label'] = "France";
		$country[59]['label'] = "Gabon";
		$country[60]['label'] = "Gambia";
		$country[61]['label'] = "Georgia";
		$country[62]['label'] = "Germany";
		$country[63]['label'] = "Ghana";
		$country[64]['label'] = "Greece";
		$country[65]['label'] = "Grenada";
		$country[66]['label'] = "Guatemala";
		$country[67]['label'] = "Guinea";
		$country[68]['label'] = "Guinea-Bissau";
		$country[69]['label'] = "Guyana";
		$country[70]['label'] = "Haiti";
		$country[71]['label'] = "Honduras";
		$country[72]['label'] = "Hong Kong";
		$country[73]['label'] = "Hungary";
		$country[74]['label'] = "Iceland";
		$country[75]['label'] = "India";
		$country[76]['label'] = "Indonesia";
		$country[77]['label'] = "Iran";
		$country[78]['label'] = "Iraq";
		$country[79]['label'] = "Ireland";
		$country[80]['label'] = "Israel";
		$country[81]['label'] = "Italy";
		$country[82]['label'] = "Jamaica";
		$country[83]['label'] = "Japan";
		$country[84]['label'] = "Jordan";
		$country[85]['label'] = "Kazakhstan";
		$country[86]['label'] = "Kenya";
		$country[87]['label'] = "Kiribati";
		$country[88]['label'] = "North Korea";
		$country[89]['label'] = "South Korea";
		$country[90]['label'] = "Kuwait";
		$country[91]['label'] = "Kyrgyzstan";
		$country[92]['label'] = "Laos";
		$country[93]['label'] = "Latvia";
		$country[94]['label'] = "Lebanon";
		$country[95]['label'] = "Lesotho";
		$country[96]['label'] = "Liberia";
		$country[97]['label'] = "Libya";
		$country[98]['label'] = "Liechtenstein";
		$country[99]['label'] = "Lithuania";
		$country[100]['label'] = "Luxembourg";
		$country[101]['label'] = "Macedonia";
		$country[102]['label'] = "Madagascar";
		$country[103]['label'] = "Malawi";
		$country[104]['label'] = "Malaysia";
		$country[105]['label'] = "Maldives";
		$country[106]['label'] = "Mali";
		$country[107]['label'] = "Malta";
		$country[108]['label'] = "Marshall Islands";
		$country[109]['label'] = "Mauritania";
		$country[110]['label'] = "Mauritius";
		$country[111]['label'] = "Mexico";
		$country[112]['label'] = "Micronesia";
		$country[113]['label'] = "Moldova";
		$country[114]['label'] = "Monaco";
		$country[115]['label'] = "Mongolia";
		$country[116]['label'] = "Montenegro";
		$country[117]['label'] = "Morocco";
		$country[118]['label'] = "Mozambique";
		$country[119]['label'] = "Myanmar";
		$country[120]['label'] = "Namibia";
		$country[121]['label'] = "Nauru";
		$country[122]['label'] = "Nepal";
		$country[123]['label'] = "Netherlands";
		$country[124]['label'] = "New Zealand";
		$country[125]['label'] = "Nicaragua";
		$country[126]['label'] = "Niger";
		$country[127]['label'] = "Nigeria";
		$country[128]['label'] = "Norway";
		$country[129]['label'] = "Oman";
		$country[130]['label'] = "Pakistan";
		$country[131]['label'] = "Palau";
		$country[132]['label'] = "Panama";
		$country[133]['label'] = "Papua New Guinea";
		$country[134]['label'] = "Paraguay";
		$country[135]['label'] = "Peru";
		$country[136]['label'] = "Philippines";
		$country[137]['label'] = "Poland";
		$country[138]['label'] = "Portugal";
		$country[139]['label'] = "Puerto Rico";
		$country[140]['label'] = "Qatar";
		$country[141]['label'] = "Romania";
		$country[142]['label'] = "Russia";
		$country[143]['label'] = "Rwanda";
		$country[144]['label'] = "Saint Kitts and Nevis";
		$country[145]['label'] = "Saint Lucia";
		$country[146]['label'] = "Saint Vincent and the Grenadines";
		$country[147]['label'] = "Samoa";
		$country[148]['label'] = "San Marino";
		$country[149]['label'] = "Sao Tome and Principe";
		$country[150]['label'] = "Saudi Arabia";
		$country[151]['label'] = "Senegal";
		$country[152]['label'] = "Serbia and Montenegro";
		$country[153]['label'] = "Seychelles";
		$country[154]['label'] = "Sierra Leone";
		$country[155]['label'] = "Singapore";
		$country[156]['label'] = "Slovakia";
		$country[157]['label'] = "Slovenia";
		$country[158]['label'] = "Solomon Islands";
		$country[159]['label'] = "Somalia";
		$country[160]['label'] = "South Africa";
		$country[161]['label'] = "Spain";
		$country[162]['label'] = "Sri Lanka";
		$country[163]['label'] = "Sudan";
		$country[164]['label'] = "Suriname";
		$country[165]['label'] = "Swaziland";
		$country[166]['label'] = "Sweden";
		$country[167]['label'] = "Switzerland";
		$country[168]['label'] = "Syria";
		$country[169]['label'] = "Taiwan";
		$country[170]['label'] = "Tajikistan";
		$country[171]['label'] = "Tanzania";
		$country[172]['label'] = "Thailand";
		$country[173]['label'] = "Togo";
		$country[174]['label'] = "Tonga";
		$country[175]['label'] = "Trinidad and Tobago";
		$country[176]['label'] = "Tunisia";
		$country[177]['label'] = "Turkey";
		$country[178]['label'] = "Turkmenistan";
		$country[179]['label'] = "Tuvalu";
		$country[180]['label'] = "Uganda";
		$country[181]['label'] = "Ukraine";
		$country[182]['label'] = "United Arab Emirates";
		$country[183]['label'] = "United Kingdom";
		$country[184]['label'] = "United States";
		$country[185]['label'] = "Uruguay";
		$country[186]['label'] = "Uzbekistan";
		$country[187]['label'] = "Vanuatu";
		$country[188]['label'] = "Vatican City";
		$country[189]['label'] = "Venezuela";
		$country[190]['label'] = "Vietnam";
		$country[191]['label'] = "Yemen";
		$country[192]['label'] = "Zambia";
		$country[193]['label'] = "Zimbabwe";
		
		
		$country[0]['value'] = "Afghanistan";
		$country[1]['value'] = "Albania";
		$country[2]['value'] = "Algeria";
		$country[3]['value'] = "Andorra";
		$country[4]['value'] = "Antigua and Barbuda";
		$country[5]['value'] = "Argentina";
		$country[6]['value'] = "Armenia";
		$country[7]['value'] = "Australia";
		$country[8]['value'] = "Austria";
		$country[9]['value'] = "Azerbaijan";
		$country[10]['value'] = "Bahamas";
		$country[11]['value'] = "Bahrain";
		$country[12]['value'] = "Bangladesh";
		$country[13]['value'] = "Barbados";
		$country[14]['value'] = "Belarus";
		$country[15]['value'] = "Belgium";
		$country[16]['value'] = "Belize";
		$country[17]['value'] = "Benin";
		$country[18]['value'] = "Bhutan";
		$country[19]['value'] = "Bolivia";
		$country[20]['value'] = "Bosnia and Herzegovina";
		$country[21]['value'] = "Botswana";
		$country[22]['value'] = "Brazil";
		$country[23]['value'] = "Brunei";
		$country[24]['value'] = "Bulgaria";
		$country[25]['value'] = "Burkina Faso";
		$country[26]['value'] = "Burundi";
		$country[27]['value'] = "Cambodia";
		$country[28]['value'] = "Cameroon";
		$country[29]['value'] = "Canada";
		$country[30]['value'] = "Cape Verde";
		$country[31]['value'] = "Central African Republic";
		$country[32]['value'] = "Chad";
		$country[33]['value'] = "Chile";
		$country[34]['value'] = "China";
		$country[35]['value'] = "Colombia";
		$country[36]['value'] = "Comoros";
		$country[37]['value'] = "Congo";
		$country[38]['value'] = "Costa Rica";
		$country[39]['value'] = "Côte d'Ivoire";
		$country[40]['value'] = "Croatia";
		$country[41]['value'] = "Cuba";
		$country[42]['value'] = "Cyprus";
		$country[43]['value'] = "Czech Republic";
		$country[44]['value'] = "Denmark";
		$country[45]['value'] = "Djibouti";
		$country[46]['value'] = "Dominica";
		$country[47]['value'] = "Dominican Republic";
		$country[48]['value'] = "East Timor";
		$country[49]['value'] = "Ecuador";
		$country[50]['value'] = "Egypt";
		$country[51]['value'] = "El Salvador";
		$country[52]['value'] = "Equatorial Guinea";
		$country[53]['value'] = "Eritrea";
		$country[54]['value'] = "Estonia";
		$country[55]['value'] = "Ethiopia";
		$country[56]['value'] = "Fiji";
		$country[57]['value'] = "Finland";
		$country[58]['value'] = "France";
		$country[59]['value'] = "Gabon";
		$country[60]['value'] = "Gambia";
		$country[61]['value'] = "Georgia";
		$country[62]['value'] = "Germany";
		$country[63]['value'] = "Ghana";
		$country[64]['value'] = "Greece";
		$country[65]['value'] = "Grenada";
		$country[66]['value'] = "Guatemala";
		$country[67]['value'] = "Guinea";
		$country[68]['value'] = "Guinea-Bissau";
		$country[69]['value'] = "Guyana";
		$country[70]['value'] = "Haiti";
		$country[71]['value'] = "Honduras";
		$country[72]['value'] = "Hong Kong";
		$country[73]['value'] = "Hungary";
		$country[74]['value'] = "Iceland";
		$country[75]['value'] = "India";
		$country[76]['value'] = "Indonesia";
		$country[77]['value'] = "Iran";
		$country[78]['value'] = "Iraq";
		$country[79]['value'] = "Ireland";
		$country[80]['value'] = "Israel";
		$country[81]['value'] = "Italy";
		$country[82]['value'] = "Jamaica";
		$country[83]['value'] = "Japan";
		$country[84]['value'] = "Jordan";
		$country[85]['value'] = "Kazakhstan";
		$country[86]['value'] = "Kenya";
		$country[87]['value'] = "Kiribati";
		$country[88]['value'] = "North Korea";
		$country[89]['value'] = "South Korea";
		$country[90]['value'] = "Kuwait";
		$country[91]['value'] = "Kyrgyzstan";
		$country[92]['value'] = "Laos";
		$country[93]['value'] = "Latvia";
		$country[94]['value'] = "Lebanon";
		$country[95]['value'] = "Lesotho";
		$country[96]['value'] = "Liberia";
		$country[97]['value'] = "Libya";
		$country[98]['value'] = "Liechtenstein";
		$country[99]['value'] = "Lithuania";
		$country[100]['value'] = "Luxembourg";
		$country[101]['value'] = "Macedonia";
		$country[102]['value'] = "Madagascar";
		$country[103]['value'] = "Malawi";
		$country[104]['value'] = "Malaysia";
		$country[105]['value'] = "Maldives";
		$country[106]['value'] = "Mali";
		$country[107]['value'] = "Malta";
		$country[108]['value'] = "Marshall Islands";
		$country[109]['value'] = "Mauritania";
		$country[110]['value'] = "Mauritius";
		$country[111]['value'] = "Mexico";
		$country[112]['value'] = "Micronesia";
		$country[113]['value'] = "Moldova";
		$country[114]['value'] = "Monaco";
		$country[115]['value'] = "Mongolia";
		$country[116]['value'] = "Montenegro";
		$country[117]['value'] = "Morocco";
		$country[118]['value'] = "Mozambique";
		$country[119]['value'] = "Myanmar";
		$country[120]['value'] = "Namibia";
		$country[121]['value'] = "Nauru";
		$country[122]['value'] = "Nepal";
		$country[123]['value'] = "Netherlands";
		$country[124]['value'] = "New Zealand";
		$country[125]['value'] = "Nicaragua";
		$country[126]['value'] = "Niger";
		$country[127]['value'] = "Nigeria";
		$country[128]['value'] = "Norway";
		$country[129]['value'] = "Oman";
		$country[130]['value'] = "Pakistan";
		$country[131]['value'] = "Palau";
		$country[132]['value'] = "Panama";
		$country[133]['value'] = "Papua New Guinea";
		$country[134]['value'] = "Paraguay";
		$country[135]['value'] = "Peru";
		$country[136]['value'] = "Philippines";
		$country[137]['value'] = "Poland";
		$country[138]['value'] = "Portugal";
		$country[139]['value'] = "Puerto Rico";
		$country[140]['value'] = "Qatar";
		$country[141]['value'] = "Romania";
		$country[142]['value'] = "Russia";
		$country[143]['value'] = "Rwanda";
		$country[144]['value'] = "Saint Kitts and Nevis";
		$country[145]['value'] = "Saint Lucia";
		$country[146]['value'] = "Saint Vincent and the Grenadines";
		$country[147]['value'] = "Samoa";
		$country[148]['value'] = "San Marino";
		$country[149]['value'] = "Sao Tome and Principe";
		$country[150]['value'] = "Saudi Arabia";
		$country[151]['value'] = "Senegal";
		$country[152]['value'] = "Serbia and Montenegro";
		$country[153]['value'] = "Seychelles";
		$country[154]['value'] = "Sierra Leone";
		$country[155]['value'] = "Singapore";
		$country[156]['value'] = "Slovakia";
		$country[157]['value'] = "Slovenia";
		$country[158]['value'] = "Solomon Islands";
		$country[159]['value'] = "Somalia";
		$country[160]['value'] = "South Africa";
		$country[161]['value'] = "Spain";
		$country[162]['value'] = "Sri Lanka";
		$country[163]['value'] = "Sudan";
		$country[164]['value'] = "Suriname";
		$country[165]['value'] = "Swaziland";
		$country[166]['value'] = "Sweden";
		$country[167]['value'] = "Switzerland";
		$country[168]['value'] = "Syria";
		$country[169]['value'] = "Taiwan";
		$country[170]['value'] = "Tajikistan";
		$country[171]['value'] = "Tanzania";
		$country[172]['value'] = "Thailand";
		$country[173]['value'] = "Togo";
		$country[174]['value'] = "Tonga";
		$country[175]['value'] = "Trinidad and Tobago";
		$country[176]['value'] = "Tunisia";
		$country[177]['value'] = "Turkey";
		$country[178]['value'] = "Turkmenistan";
		$country[179]['value'] = "Tuvalu";
		$country[180]['value'] = "Uganda";
		$country[181]['value'] = "Ukraine";
		$country[182]['value'] = "United Arab Emirates";
		$country[183]['value'] = "United Kingdom";
		$country[184]['value'] = "United States";
		$country[185]['value'] = "Uruguay";
		$country[186]['value'] = "Uzbekistan";
		$country[187]['value'] = "Vanuatu";
		$country[188]['value'] = "Vatican City";
		$country[189]['value'] = "Venezuela";
		$country[190]['value'] = "Vietnam";
		$country[191]['value'] = "Yemen";
		$country[192]['value'] = "Zambia";
		$country[193]['value'] = "Zimbabwe";
		
		$state_list[0]['label'] = 'Alabama';
		$state_list[1]['label'] = 'Alaska';
		$state_list[2]['label'] = 'Arizona';
		$state_list[3]['label'] = 'Arkansas';
		$state_list[4]['label'] = 'California';
		$state_list[5]['label'] = 'Colorado';
		$state_list[6]['label'] = 'Connecticut';
		$state_list[7]['label'] = 'Delaware';
		$state_list[8]['label'] = 'Florida';
		$state_list[9]['label'] = 'Georgia';
		$state_list[10]['label'] = 'Hawaii';
		$state_list[11]['label'] = 'Idaho';
		$state_list[12]['label'] = 'Illinois';
		$state_list[13]['label'] = 'Indiana';
		$state_list[14]['label'] = 'Iowa';
		$state_list[15]['label'] = 'Kansas';
		$state_list[16]['label'] = 'Kentucky';
		$state_list[17]['label'] = 'Louisiana';
		$state_list[18]['label'] = 'Maine';
		$state_list[19]['label'] = 'Maryland';
		$state_list[20]['label'] = 'Massachusetts';
		$state_list[21]['label'] = 'Michigan';
		$state_list[22]['label'] = 'Minnesota';
		$state_list[23]['label'] = 'Mississippi';
		$state_list[24]['label'] = 'Missouri';
		$state_list[25]['label'] = 'Montana';
		$state_list[26]['label'] = 'Nebraska';
		$state_list[27]['label'] = 'Nevada';
		$state_list[28]['label'] = 'New Hampshire';
		$state_list[29]['label'] = 'New Jersey';
		$state_list[30]['label'] = 'New Mexico';
		$state_list[31]['label'] = 'New York';
		$state_list[32]['label'] = 'North Carolina';
		$state_list[33]['label'] = 'North Dakota';
		$state_list[34]['label'] = 'Ohio';
		$state_list[35]['label'] = 'Oklahoma';
		$state_list[36]['label'] = 'Oregon';
		$state_list[37]['label'] = 'Pennsylvania';
		$state_list[38]['label'] = 'Rhode Island';
		$state_list[39]['label'] = 'South Carolina';
		$state_list[40]['label'] = 'South Dakota';
		$state_list[41]['label'] = 'Tennessee';
		$state_list[42]['label'] = 'Texas';
		$state_list[43]['label'] = 'Utah';
		$state_list[44]['label'] = 'Vermont';
		$state_list[45]['label'] = 'Virginia';
		$state_list[46]['label'] = 'Washington';
		$state_list[47]['label'] = 'West Virginia';
		$state_list[48]['label'] = 'Wisconsin';
		$state_list[49]['label'] = 'Wyoming';

			
		$state_list[0]['value'] = 'Alabama';
		$state_list[1]['value'] = 'Alaska';
		$state_list[2]['value'] = 'Arizona';
		$state_list[3]['value'] = 'Arkansas';
		$state_list[4]['value'] = 'California';
		$state_list[5]['value'] = 'Colorado';
		$state_list[6]['value'] = 'Connecticut';
		$state_list[7]['value'] = 'Delaware';
		$state_list[8]['value'] = 'Florida';
		$state_list[9]['value'] = 'Georgia';
		$state_list[10]['value'] = 'Hawaii';
		$state_list[11]['value'] = 'Idaho';
		$state_list[12]['value'] = 'Illinois';
		$state_list[13]['value'] = 'Indiana';
		$state_list[14]['value'] = 'Iowa';
		$state_list[15]['value'] = 'Kansas';
		$state_list[16]['value'] = 'Kentucky';
		$state_list[17]['value'] = 'Louisiana';
		$state_list[18]['value'] = 'Maine';
		$state_list[19]['value'] = 'Maryland';
		$state_list[20]['value'] = 'Massachusetts';
		$state_list[21]['value'] = 'Michigan';
		$state_list[22]['value'] = 'Minnesota';
		$state_list[23]['value'] = 'Mississippi';
		$state_list[24]['value'] = 'Missouri';
		$state_list[25]['value'] = 'Montana';
		$state_list[26]['value'] = 'Nebraska';
		$state_list[27]['value'] = 'Nevada';
		$state_list[28]['value'] = 'New Hampshire';
		$state_list[29]['value'] = 'New Jersey';
		$state_list[30]['value'] = 'New Mexico';
		$state_list[31]['value'] = 'New York';
		$state_list[32]['value'] = 'North Carolina';
		$state_list[33]['value'] = 'North Dakota';
		$state_list[34]['value'] = 'Ohio';
		$state_list[35]['value'] = 'Oklahoma';
		$state_list[36]['value'] = 'Oregon';
		$state_list[37]['value'] = 'Pennsylvania';
		$state_list[38]['value'] = 'Rhode Island';
		$state_list[39]['value'] = 'South Carolina';
		$state_list[40]['value'] = 'South Dakota';
		$state_list[41]['value'] = 'Tennessee';
		$state_list[42]['value'] = 'Texas';
		$state_list[43]['value'] = 'Utah';
		$state_list[44]['value'] = 'Vermont';
		$state_list[45]['value'] = 'Virginia';
		$state_list[46]['value'] = 'Washington';
		$state_list[47]['value'] = 'West Virginia';
		$state_list[48]['value'] = 'Wisconsin';
		$state_list[49]['value'] = 'Wyoming';
		
		global $mf_lang;
		
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		
		$el_class = array();
		
		$el_class[] = 'address';
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check for guidelines
		if(!empty($element->guidelines)){
			$guidelines = "<p class=\"guidelines\" id=\"guide_{$element->id}\"><small>{$element->guidelines}</small></p>";
		}
		
		
		//create country markup, if no default value, provide a blank option
		if(!empty($element->address_us_only)){
			$element->default_value = 'United States';
		}
		
		if(empty($element->default_value)){
			$country_markup = '<option value="" selected="selected"></option>'."\n";
		}else{
			$country_markup = '';
		}
		
		foreach ($country as $data){
			if($data['value'] == $element->default_value){
				$selected = 'selected="selected"';
			}else{
				$selected = '';
			}
			
			//check for populated value, use it instead of default value
			if(!empty($element->populated_value['element_'.$element->id.'_6']['default_value'])){
				$selected = '';
				if($element->populated_value['element_'.$element->id.'_6']['default_value'] == $data['value']){
					$selected = 'selected="selected"';
				}
			}
			
			$country_markup .= "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>\n";
		}
		
		//if this address field is restricted to US only
		if(empty($element->is_design_mode) && !empty($element->address_us_only)){
			$country_markup = '<option selected="selected" value="United States">United States</option>';
		}
		
		//decide which state markup being used
		if(empty($element->address_us_only)){
			//display simple input for the state
			$state_markup = "<input id=\"element_{$element->id}_4\" name=\"element_{$element->id}_4\" class=\"element text large\"  value=\"{$element->populated_value['element_'.$element->id.'_4']['default_value']}\" type=\"text\" />";
		}else{
			//display us state dropdown
			$state_markup = "<select class=\"element select large\" id=\"element_{$element->id}_4\" name=\"element_{$element->id}_4\">";
			$state_markup .= '<option value="" selected="selected">Select a State</option>'."\n";
			
			foreach ($state_list as $data){
				if($data['value'] == $element->default_value){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				
				//check for populated value, use it instead of default value
				if(!empty($element->populated_value['element_'.$element->id.'_4']['default_value'])){
					$selected = '';
					if($element->populated_value['element_'.$element->id.'_4']['default_value'] == $data['value']){
						$selected = 'selected="selected"';
					}
				}
				
				$state_markup .= "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>\n";
			}
			
			$state_markup .= "</select>";
			
		}
		
		//set the 'address line 2' visibility, based on selected option
		if(!empty($element->address_hideline2)){
			$address_line2_style = 'style="display: none"';
		}else{
			$address_line2_style = '';
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
		<label class="description">{$element->title} {$span_required}</label>
		
		<div>
			<span id="li_{$element->id}_span_1">
				<input id="element_{$element->id}_1" name="element_{$element->id}_1" class="element text large" value="{$element->populated_value['element_'.$element->id.'_1']['default_value']}" type="text" />
				<label for="element_{$element->id}_1">{$mf_lang['address_street']}</label>
			</span>
		
			<span id="li_{$element->id}_span_2" {$address_line2_style}>
				<input id="element_{$element->id}_2" name="element_{$element->id}_2" class="element text large" value="{$element->populated_value['element_'.$element->id.'_2']['default_value']}" type="text" />
				<label for="element_{$element->id}_2">{$mf_lang['address_street2']}</label>
			</span>
		
			<span id="li_{$element->id}_span_3" class="left state_list">
				<input id="element_{$element->id}_3" name="element_{$element->id}_3" class="element text large" value="{$element->populated_value['element_'.$element->id.'_3']['default_value']}" type="text" />
				<label for="element_{$element->id}_3">{$mf_lang['address_city']}</label>
			</span>
		
			<span id="li_{$element->id}_span_4" class="right state_list">
				{$state_markup}
				<label for="element_{$element->id}_4">{$mf_lang['address_state']}</label>
			</span>
		
			<span id="li_{$element->id}_span_5" class="left">
				<input id="element_{$element->id}_5" name="element_{$element->id}_5" class="element text large" maxlength="15" value="{$element->populated_value['element_'.$element->id.'_5']['default_value']}" type="text" />
				<label for="element_{$element->id}_5">{$mf_lang['address_zip']}</label>
			</span>
			
			<span id="li_{$element->id}_span_6" class="right">
				<select class="element select large" id="element_{$element->id}_6" name="element_{$element->id}_6"> 
				{$country_markup}	
				</select>
			<label for="element_{$element->id}_6">{$mf_lang['address_country']}</label>
		    </span>
	    </div>{$guidelines} {$error_message}
		</li>
EOT;
		
	
		return $element_markup;
	}
	
	
	//Captcha
	function mf_display_captcha($element){
		
		if(!empty($element->error_message)){
			$error_code = $element->error_message;
		}else{
			$error_code = '';
		}
					
		//check for error
		$error_class = '';
		$error_message = '';
		$span_required = '';
		$guidelines = '';
		global $mf_lang;		
		
		if(!empty($element->is_error)){
			if($element->error_message == 'el-required'){
				$element->error_message = $mf_lang['captcha_required'];
				$error_code = '';	
			}else if($element->error_message == 'el-text-required'){
				$element->error_message = $mf_lang['val_required'];
				$error_code = '';	
			}elseif ($element->error_message == 'incorrect-captcha-sol'){
				$element->error_message = $mf_lang['captcha_mismatch'];
			}elseif ($element->error_message == 'incorrect-text-captcha-sol'){
				$element->error_message = $mf_lang['captcha_text_mismatch'];
			}else{
				$element->error_message = "{$mf_lang['captcha_error']} ({$element->error_message})";
			}
			
			$error_class = 'class="error"';
			$error_message = "<p class=\"error\">{$element->error_message}</p>";
		}

		if(!empty($_SERVER['HTTPS'])){
			$use_ssl = true;
		}else{
			$use_ssl = false;
		}
		
		
		if($element->captcha_type == 'i'){ //if this is internal captcha type
		
			$machform_path = '';
			if(!empty($element->machform_path)){
				$machform_path = $element->machform_path;
			}
			
			$timestamp = time(); //use this as paramater for captcha.php, to prevent caching
			
			$element->title = $mf_lang['captcha_simple_image_title'];
$captcha_html = <<<EOT
<img id="captcha_image" src="{$machform_path}captcha.php?t={$timestamp}" width="200" height="60" alt="Please refresh your browser to see this image." /><br />
<input id="captcha_response_field" name="captcha_response_field" class="element text small" type="text" /><div id="dummy_captcha_internal"></div>
EOT;
	 		
		}else if($element->captcha_type == 'r'){ //if this is recaptcha
			$captcha_html = recaptcha_get_html(RECAPTCHA_PUBLIC_KEY, $error_code,$use_ssl);
	
			if($captcha_html === false){
				$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
				$captcha_html = "<b>Error!</b> You have enabled CAPTCHA but no API key available. <br /><br />To use CAPTCHA you must get an API key from <a href='".recaptcha_get_signup_url($domain,'MachForm')."'>http://recaptcha.net/api/getkey</a><br /><br />After getting the API key, save them into your <b>config.php</b> file.";
				$error_class = 'class="error"';
			}

			$recaptcha_theme = RECAPTCHA_THEME;
			$recaptcha_language = RECAPTCHA_LANGUAGE;
			$recaptcha_theme_init = <<<EOT
				<script type="text/javascript">
				 var RecaptchaOptions = {
				    theme : '{$recaptcha_theme}',
				    lang: '{$recaptcha_language}'
				 };
				</script>
EOT;

		}else if($element->captcha_type == 't'){ //if this is simple text captcha
			
			$element->title = $mf_lang['captcha_simple_text_title'];

			$text_captcha = mf_get_text_captcha();
			
			$_SESSION['MF_TEXT_CAPTCHA_ANSWER'] = $text_captcha['answer'];
			$text_captcha_question = htmlspecialchars($text_captcha['question'],ENT_QUOTES);

			$captcha_html = <<<EOT
<span class="text_captcha">{$text_captcha_question}</span>
<input id="captcha_response_field" name="captcha_response_field" class="element text small" type="text" />
EOT;
		}
		
				
$element_markup = <<<EOT
		<li id="li_captcha" {$error_class}> {$recaptcha_theme_init}
		<label class="description" for="captcha_response_field">{$element->title} {$span_required}</label>
		<div>
			{$captcha_html}	
		</div>	 
		{$guidelines} {$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	//Matrix Table
	function mf_display_matrix($element){
		
		//check for error
		$li_class = '';
		$error_message = '';
		$span_required = '';
		$el_class = array();
		
		$el_class[] = "matrix";
		
		if(!empty($element->is_private)){
			$el_class[] = 'private';
		}
		if(!empty($element->css_class)){
			$el_class[] = trim($element->css_class);
		}
		
		if(!empty($element->is_error)){
			$el_class[] = 'error';
			if($element->error_message != 'error_no_display'){
				$error_message = "<p class=\"error\">{$element->error_message}</p>";
			}
		}
		
		//check for required
		if($element->is_required){
			$span_required = "<span id=\"required_{$element->id}\" class=\"required\">*</span>";
		}
		
		//check matrix field type
		if($element->matrix_allow_multiselect){
			$input_type = 'checkbox';
		}else{
			$input_type = 'radio';
		}
		
		
		
		//calculate the table columns width
		$total_answer = count($element->options) + 1;
		$initial_width = 100 / $total_answer;
		$first_col_width = 2 * $initial_width;
		$first_col_width = round($first_col_width);
		$other_col_width = (100 - $first_col_width) / ($total_answer - 1);
		$other_col_width = round($other_col_width);

		//build th markup and first row markup		
		$th_markup = '';
		$first_row_td = '';
		foreach($element->options as $option){
			
			
			if($input_type == 'checkbox'){
				$option_id_var = '_'.$option->id;

				if(!empty($element->populated_value['element_'.$element->id.'_'.$option->id]['default_value']) && ($element->populated_value['element_'.$element->id.'_'.$option->id]['default_value'] == $option->id)){
					$checked_markup = 'checked="checked"';
				}else{
					$checked_markup = '';
				}
			}else{
				$option_id_var = '';
				
				if(!empty($element->populated_value['element_'.$element->id]['default_value']) && ($element->populated_value['element_'.$element->id]['default_value'] == $option->id)){
					$checked_markup = 'checked="checked"';
				}else{
					$checked_markup = '';
				}
			}
			
			$th_markup 	  .= "<th id=\"mc_{$element->id}_{$option->id}\" style=\"width: {$other_col_width}%\" scope=\"col\">{$option->option}</th>\n";
			$first_row_td .= "<td><input id=\"element_{$element->id}_{$option->id}\" name=\"element_{$element->id}{$option_id_var}\" type=\"{$input_type}\" value=\"{$option->id}\" {$checked_markup} /></td>\n";
		}
		
		//build other rows markup
		$tr_markup = '';
		$show_alt = false;
		if(!empty($element->matrix_children)){
			foreach ($element->matrix_children as $matrix_item){
			
				$children_option_id = array();
				$children_option_id = explode(',',$matrix_item['children_option_id']);
				
				$td_markup = "<td class=\"first_col\">{$matrix_item['title']}</td>";
				foreach ($children_option_id as $option_id){
					
					
					if($input_type == 'checkbox'){
						$option_id_var = '_'.$option_id;

						if(!empty($element->populated_value['element_'.$matrix_item['id'].'_'.$option_id]['default_value']) && ($element->populated_value['element_'.$matrix_item['id'].'_'.$option_id]['default_value'] == $option_id)){
							$checked_markup = 'checked="checked"';
						}else{
							$checked_markup = '';
						}
					}else{
						$option_id_var = '';
						
						if(!empty($element->populated_value['element_'.$matrix_item['id']]['default_value']) && ($element->populated_value['element_'.$matrix_item['id']]['default_value'] == $option_id)){
							$checked_markup = 'checked="checked"';
						}else{
							$checked_markup = '';
						}
					}
				
					$td_markup .= "<td><input id=\"element_{$matrix_item['id']}_{$option_id}\" name=\"element_{$matrix_item['id']}{$option_id_var}\" type=\"{$input_type}\" value=\"{$option_id}\" {$checked_markup} /></td>\n";
				}
				
				if($show_alt){
					$row_style = ' class="alt" ';
					$show_alt = false;
				}else{
					$row_style = '';
					$show_alt = true;
				}

				$tr_markup .= "<tr {$row_style} id=\"mr_{$matrix_item['id']}\">".$td_markup."</tr>";
			}
		}
		
		//build the li class
		if(!empty($el_class)){
			foreach ($el_class as $value){
				$li_class .= $value.' ';
			}
			
			$li_class = 'class="'.rtrim($li_class).'"';
		}
		
$element_markup = <<<EOT
		<li id="li_{$element->id}" {$li_class}>
			<table>
				<caption>
					{$element->guidelines} {$span_required}
				</caption>
			    <thead>
			    	<tr>
			        	<th style="width: {$first_col_width}%" scope="col">&nbsp;</th>
			            {$th_markup}
			        </tr>
			    </thead>
			    <tbody>
			    	<tr class="alt" id="mr_{$element->id}">
			        	<td class="first_col">{$element->title}</td>
			            {$first_row_td}
			        </tr>
			        {$tr_markup}
			    </tbody>
			</table>
		{$error_message}
		</li>
EOT;
		
		return $element_markup;
	}
	
	
	//Main function to display a form
	//There are few mode when displaying a form
	//1. New blank form (form populated with default values)
	//2. New form with error (displayed when 1 submitted and having error, form populated with user inputs)
	//3. Edit form (form populated with data from db)
	//4. Edit form with error (displayed when #3 submitted and having error)

	function mf_display_form($dbh,$form_id,$form_params=array()){	
		
		global $mf_lang;

		//parameters mapping
		if(isset($form_params['page_number'])){
			$page_number = $form_params['page_number'];
		}else{
			$page_number = 1;
		}

		if(isset($form_params['populated_values'])){
			$populated_values = $form_params['populated_values'];
		}else{
			$populated_values = array();
		}

		if(isset($form_params['error_elements'])){
			$error_elements = $form_params['error_elements'];
		}else{
			$error_elements = array();
		}
		
		if(isset($form_params['custom_error'])){
			$custom_error = $form_params['custom_error'];
		}else{
			$custom_error = '';
		}
		
		if(isset($form_params['edit_id'])){
			$edit_id = (int) $form_params['edit_id'];
		}else{
			$edit_id = 0;
		}
		
		if(isset($form_params['integration_method'])){ //valid values are empty string, 'iframe' or 'php'
			$integration_method = $form_params['integration_method'];
		}else{
			$integration_method = '';
		}

		if(!empty($form_params['machform_path'])){
			$machform_path = $form_params['machform_path'];
		}else{
			$machform_path = '';
		}

		if(!empty($form_params['machform_data_path'])){
			$machform_data_path = $form_params['machform_data_path'];
		}else{
			$machform_data_path = '';
		}

		
		$mf_settings = mf_get_settings($dbh);
		
		//if there is custom error, don't show other errors
		if(!empty($custom_error)){
			$error_elements = array();
		}
		
		//get form properties data
		$query 	= "SELECT 
						 form_name,
						 form_description,
						 form_redirect,
						 form_success_message,
						 form_password,
						 form_unique_ip,
						 form_frame_height,
						 form_has_css,
						 form_active,
						 form_captcha,
						 form_captcha_type,
						 form_review,
						 form_label_alignment,
						 form_language,
						 form_page_total,
						 form_lastpage_title,
						 form_submit_primary_text,
						 form_submit_secondary_text,
						 form_submit_primary_img,
						 form_submit_secondary_img,
						 form_submit_use_image,
						 form_pagination_type,
						 form_review_primary_text,
						 form_review_secondary_text,
						 form_review_primary_img,
						 form_review_secondary_img,
						 form_review_use_image,
						 form_review_title,
						 form_review_description,
						 form_resume_enable,
						 form_theme_id,
						 payment_show_total,
						 payment_total_location,
						 payment_enable_merchant,
						 payment_currency,
						 payment_price_type,
						 payment_price_amount,
						 form_limit_enable,
						 form_limit,
						 form_schedule_enable,
						 form_schedule_start_date,
						 form_schedule_end_date,
						 form_schedule_start_hour,
						 form_schedule_end_hour
				     FROM 
				     	 ".MF_TABLE_PREFIX."forms 
				    WHERE 
				    	 form_id = ?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);

		//check for non-existent or currently drafted forms
		if(empty($row) || $row['form_active'] != 1){
			die('This is not valid form URL.');
		}

		$form = new stdClass();
		
		$form->id 				= $form_id;
		$form->name 			= $row['form_name'];
		$form->description 		= $row['form_description'];
		$form->redirect 		= $row['form_redirect'];
		$form->success_message  = $row['form_success_message'];
		$form->password 		= $row['form_password'];
		$form->frame_height 	= $row['form_frame_height'];
		$form->unique_ip 		= $row['form_unique_ip'];
		$form->has_css 			= $row['form_has_css'];
		$form->active 			= $row['form_active'];
		$form->captcha 			= $row['form_captcha'];
		$form->captcha_type 	= $row['form_captcha_type'];
		$form->review 			= $row['form_review'];
		$form->label_alignment  = $row['form_label_alignment'];
		$form->page_total 		= $row['form_page_total'];
		$form->lastpage_title 	= $row['form_lastpage_title'];
		$form->submit_primary_text 	 = $row['form_submit_primary_text'];
		$form->submit_secondary_text = $row['form_submit_secondary_text'];
		$form->submit_primary_img 	 = $row['form_submit_primary_img'];
		$form->submit_secondary_img  = $row['form_submit_secondary_img'];
		$form->submit_use_image  	 = (int) $row['form_submit_use_image'];
		$form->pagination_type		 = $row['form_pagination_type'];
		$form->review_primary_text 	 = $row['form_review_primary_text'];
		$form->review_secondary_text = $row['form_review_secondary_text'];
		$form->review_primary_img 	 = $row['form_review_primary_img'];
		$form->review_secondary_img  = $row['form_review_secondary_img'];
		$form->review_use_image  	 = (int) $row['form_review_use_image'];
		$form->review_title			 = $row['form_review_title'];
		$form->review_description	 = $row['form_review_description'];
		$form->resume_enable	 	 = $row['form_resume_enable'];
		$form->theme_id	    	 	 = (int) $row['form_theme_id'];
		$form->payment_show_total	 = (int) $row['payment_show_total'];
		$form->payment_total_location = $row['payment_total_location'];
		$form->payment_enable_merchant = (int) $row['payment_enable_merchant'];
		if($form->payment_enable_merchant < 1){
			$form->payment_enable_merchant = 0;
		}
		$form->payment_currency 	   = $row['payment_currency'];
		$form->payment_price_type 	   = $row['payment_price_type'];
		$form->payment_price_amount    = $row['payment_price_amount'];
		$form->limit_enable  	= (int) $row['form_limit_enable'];
		$form->limit  			= (int) $row['form_limit'];
		$form->schedule_enable  = (int) $row['form_schedule_enable'];
		$form->schedule_start_date  = $row['form_schedule_start_date'];
		$form->schedule_end_date  = $row['form_schedule_end_date'];
		$form->schedule_start_hour  = $row['form_schedule_start_hour'];
		$form->schedule_end_hour  = $row['form_schedule_end_hour'];
		$form->language = trim($row['form_language']);

		if(!empty($form->language)){
			mf_set_language($form->language);
		}

		if(empty($error_elements)){
			$form->is_error 	= 0;
		}else{
			$form->is_error 	= 1;
		}

		if(!empty($edit_id)){
			$form->active = 1;
		}
		
		
		if($form->page_total == 1){
			//if this form has review enabled and user are having $_SESSION['review_id'], then populate the form with that values
			if(!empty($form->review) && !empty($_SESSION['review_id']) && empty($populated_values)){
				$entry_params = array();
				$entry_params['machform_data_path'] = $machform_data_path;

				$populated_values = mf_get_entry_values($dbh,$form_id,$_SESSION['review_id'],true,$entry_params);
			}elseif (!empty($form->review) && !empty($_SESSION['review_id']) && !empty($populated_values)){ //if form review enabled and there is some validation error, the uploaded files needs to be displayed
				$entry_params = array();
				$entry_params['machform_data_path'] = $machform_data_path;

				$populated_file_values = mf_get_entry_values($dbh,$form_id,$_SESSION['review_id'],true,$entry_params);
			}
		}else{
			//if this is multipage form, always populate the fields
			$session_id = session_id();
			
			//if there is form resume key, load the record from ap_form_x table to ap_form_x_review table
			if(!empty($_SESSION['mf_form_resume_key'][$form_id])){
				$resume_key = $_SESSION['mf_form_resume_key'][$form_id];
				
				//first delete existing record within review table
				$query = "DELETE from `".MF_TABLE_PREFIX."form_{$form_id}_review` where session_id=? or resume_key=?";
				$params = array($session_id, $resume_key);
				
				mf_do_query($query,$params,$dbh);
				
				//copy data from ap_form_x table to ap_form_x_review table
				$query  = "SELECT * FROM `".MF_TABLE_PREFIX."form_{$form_id}` WHERE resume_key=?";
				$params = array($resume_key);
				
				$sth = mf_do_query($query,$params,$dbh);
				$row = mf_do_fetch_result($sth);
				
				$columns = array();
				foreach($row as $column_name=>$column_data){
					if($column_name != 'id'){
						$columns[] = $column_name;
					}
				}	
				
				if(empty($columns)){
					//invalid resume_key given, display error message
					$custom_error = 'Invalid Link! <br/>Please open the complete URL to resume your saved progress.';
				}else{	
				
					$columns_joined = implode("`,`",$columns);
					$columns_joined = '`'.$columns_joined.'`';
					
					//copy data from main table
					$query = "INSERT INTO `".MF_TABLE_PREFIX."form_{$form_id}_review`($columns_joined) SELECT {$columns_joined} from `".MF_TABLE_PREFIX."form_{$form_id}` WHERE resume_key=?";
					$params = array($resume_key);
					
					mf_do_query($query,$params,$dbh);
					
					$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}_review` set session_id=? WHERE resume_key=?";
					$params = array($session_id,$resume_key);
					
					mf_do_query($query,$params,$dbh);
					
					for($i=1;$i<=$form->page_total;$i++){
						$_SESSION['mf_form_loaded'][$form_id][$i] = true;
					}
					
					unset($_SESSION['mf_form_resume_key'][$form_id]);
				}
			}
			
			$query = "SELECT `id` from `".MF_TABLE_PREFIX."form_{$form_id}_review` where session_id=?";
			$params = array($session_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);

			//we need to check mf_form_loaded to make sure default values of fields are being loaded on the first view of the form
			if(empty($populated_values) && !empty($_SESSION['mf_form_loaded'][$form_id][$page_number])){
				$entry_params = array();
				$entry_params['machform_data_path'] = $machform_data_path;

				$populated_values = mf_get_entry_values($dbh,$form_id,$row['id'],true,$entry_params);
			}else{ //if there is some validation error, the uploaded files needs to be displayed
				$entry_params = array();
				$entry_params['machform_data_path'] = $machform_data_path;

				$populated_file_values = mf_get_entry_values($dbh,$form_id,$row['id'],true,$entry_params);
			}
		}
		
		//get price definitions for fields, if the merchant feature is enabled
		if(!empty($form->payment_enable_merchant)){
			$query = "select 
							element_id,
							option_id,
							`price` 
					   from 
					   		`".MF_TABLE_PREFIX."element_prices` 
					   where 
					   		form_id=? 
				   order by 
				   			element_id,option_id asc";
			$params = array($form_id);
			$sth = mf_do_query($query,$params,$dbh);
			while($row = mf_do_fetch_result($sth)){
				$element_prices_array[$row['element_id']][$row['option_id']] = $row['price'];
			}	
		}
		
		//get elements data
		//get element options first and store it into array
		$query = "SELECT 
						element_id,
						option_id,
						`position`,
						`option`,
						option_is_default 
				    FROM 
				    	".MF_TABLE_PREFIX."element_options 
				   where 
				   		form_id = ? and live=1 
				order by 
						element_id asc,`position` asc";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			$option_id  = $row['option_id'];
			$options_lookup[$element_id][$option_id]['position'] 		  = $row['position'];
			$options_lookup[$element_id][$option_id]['option'] 			  = $row['option'];
			$options_lookup[$element_id][$option_id]['option_is_default'] = $row['option_is_default'];
			
			if(isset($element_prices_array[$element_id][$option_id])){
				$options_lookup[$element_id][$option_id]['price_definition'] = $element_prices_array[$element_id][$option_id];
			}
		}
	
		$matrix_elements = array();
		
		//get elements data
		$element = array();

		if($page_number === 0){ //if page_number is 0, display all pages (this is being used on edit_entry page)
			$page_number_clause = '';
			$params = array($form_id);
		}else{
			$page_number_clause = 'and element_page_number = ?';
			$params = array($form_id,$page_number);
		}

		$query = "SELECT 
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
						element_choice_has_other,
						element_choice_other_label,
						element_choice_columns,
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
						element_matrix_allow_multiselect,
						element_matrix_parent_id,
						element_range_min,
						element_range_max,
						element_range_limit_by,
						element_css_class
					FROM 
						".MF_TABLE_PREFIX."form_elements 
				   WHERE 
				   		form_id = ? and element_status='1' {$page_number_clause} and element_type <> 'page_break'
				ORDER BY 
						element_position asc";
		
		$sth = mf_do_query($query,$params,$dbh);
		
		$j=0;
		$has_calendar = false; //assume the form doesn't have calendar, so it won't load calendar.js
		$has_advance_uploader = false;
		$has_guidelines = false;
		
		while($row = mf_do_fetch_result($sth)){
			
			$element[$j] = new stdClass();
			
			$element_id = $row['element_id'];
			
			//lookup element options first
			if(!empty($options_lookup[$element_id])){
				$element_options = array();
				$i=0;
				foreach ($options_lookup[$element_id] as $option_id=>$data){
					$element_options[$i] = new stdClass();
					$element_options[$i]->id 		 = $option_id;
					$element_options[$i]->option 	 = $data['option'];
					$element_options[$i]->is_default = $data['option_is_default'];
					$element_options[$i]->is_db_live = 1;
					
					if(isset($data['price_definition'])){
						$element_options[$i]->price_definition = $data['price_definition'];
					}
					
					$i++;
				}
			}
			
		
			//populate elements
			$element[$j]->title 		= nl2br($row['element_title']);
			$element[$j]->guidelines 	= $row['element_guidelines'];
			
			if(!empty($row['element_guidelines']) && ($row['element_type'] != 'section') && ($row['element_type'] != 'matrix')){
				$has_guidelines = true;
			}
			
			$element[$j]->size 			= $row['element_size'];
			$element[$j]->is_required 	= $row['element_is_required'];
			$element[$j]->is_unique 	= $row['element_is_unique'];
			$element[$j]->is_private 	= $row['element_is_private'];
			$element[$j]->type 			= $row['element_type'];
			$element[$j]->position 		= $row['element_position'];
			$element[$j]->id 			= $row['element_id'];
			$element[$j]->is_db_live 	= 1;
			$element[$j]->form_id 		= $form_id;
			$element[$j]->choice_has_other   = (int) $row['element_choice_has_other'];
			$element[$j]->choice_other_label = $row['element_choice_other_label'];
			$element[$j]->choice_columns   	 = (int) $row['element_choice_columns'];
			$element[$j]->time_showsecond    = (int) $row['element_time_showsecond'];
			$element[$j]->time_24hour    	 = (int) $row['element_time_24hour'];
			$element[$j]->address_hideline2	 = (int) $row['element_address_hideline2'];
			$element[$j]->address_us_only	 = (int) $row['element_address_us_only'];
			$element[$j]->date_enable_range	 = (int) $row['element_date_enable_range'];
			$element[$j]->date_range_min	 = $row['element_date_range_min'];
			$element[$j]->date_range_max	 = $row['element_date_range_max'];
			$element[$j]->date_enable_selection_limit	 = (int) $row['element_date_enable_selection_limit'];
			$element[$j]->date_selection_max	 		 = (int) $row['element_date_selection_max'];
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
			
			if(!empty($element[$j]->file_enable_advance)){
				$has_advance_uploader = true;
			}
			
			$element[$j]->file_auto_upload	 			= (int) $row['element_file_auto_upload'];
			$element[$j]->file_enable_multi_upload	 	= (int) $row['element_file_enable_multi_upload'];
			$element[$j]->file_max_selection	 		= (int) $row['element_file_max_selection'];
			$element[$j]->file_enable_size_limit	 	= (int) $row['element_file_enable_size_limit'];
			$element[$j]->file_size_max	 				= (int) $row['element_file_size_max'];
			$element[$j]->matrix_allow_multiselect	 	= (int) $row['element_matrix_allow_multiselect'];
			$element[$j]->matrix_parent_id	 			= (int) $row['element_matrix_parent_id'];
			$element[$j]->upload_dir	 				= $mf_settings['upload_dir'];		
			$element[$j]->range_min	 					= $row['element_range_min'];
			$element[$j]->range_max	 					= $row['element_range_max'];
			$element[$j]->range_limit_by	 			= $row['element_range_limit_by'];
			$element[$j]->css_class	 					= $row['element_css_class'];
			$element[$j]->machform_path	 				= $machform_path;
			$element[$j]->machform_data_path	 		= $machform_data_path;
			
			//this data came from db or form submit
			//being used to display edit form or redisplay form with errors and previous inputs
			//this should be optimized in the future, only pass necessary data, not the whole array			
			$element[$j]->populated_value = $populated_values;
			
			
			//set prices for price-enabled field
			if($row['element_type'] == 'money' && isset($element_prices_array[$row['element_id']][0])){
				$element[$j]->price_definition = 0;
			}
			
			//if there is file upload type, set form enctype to multipart
			if($row['element_type'] == 'file'){
				$form_enc_type = 'enctype="multipart/form-data"';
				
				//if this is single page form with review enabled or multipage form
				if ((!empty($form->review) && !empty($_SESSION['review_id']) && !empty($populated_file_values)) ||
					($form->page_total > 1 && !empty($populated_file_values))	
				) {
					//populate the default value for uploaded files, when validation error occured

					//make sure to keep the file token if exist
					if(!empty($populated_values['element_'.$row['element_id']]['file_token'])){
						$populated_file_values['element_'.$row['element_id']]['file_token'] = $populated_values['element_'.$row['element_id']]['file_token'];
					}
					
					$element[$j]->populated_value = $populated_file_values;
				}

				if(!empty($edit_id) && $_SESSION['mf_logged_in'] === true){
					//if this is edit_entry page
					$element[$j]->is_edit_entry = true;
				}
			}
			
			if(!empty($error_elements[$element[$j]->id])){
				$element[$j]->is_error 	    = 1;
				$element[$j]->error_message = $error_elements[$element[$j]->id];
			}
			
			
			$element[$j]->default_value = htmlspecialchars($row['element_default_value']);
			
			
			$element[$j]->constraint 	= $row['element_constraint'];
			if(!empty($element_options)){
				$element[$j]->options 	= $element_options;
			}else{
				$element[$j]->options 	= '';
			}
			
			
			//check for calendar type
			if($row['element_type'] == 'date' || $row['element_type'] == 'europe_date'){
				$has_calendar = true;
				
				//if the field has date selection limit, we need to do query to existing entries and disable all date which reached the limit
				if(!empty($row['element_date_enable_selection_limit']) && !empty($row['element_date_selection_max'])){
					$sub_query = "select 
										selected_date 
									from (
											select 
												  date_format(element_{$row['element_id']},'%m/%d/%Y') as selected_date,
												  count(element_{$row['element_id']}) as total_selection 
										      from 
										      	  ".MF_TABLE_PREFIX."form_{$form_id} 
										     where 
										     	  status=1 and element_{$row['element_id']} is not null 
										  group by 
										  		  element_{$row['element_id']}
										 ) as A
								   where 
										 A.total_selection >= ?";
					$params = array($row['element_date_selection_max']);
					$sub_sth = mf_do_query($sub_query,$params,$dbh);
					$current_date_disabled_list = array();
					$current_date_disabled_list_joined = '';
					
					while($sub_row = mf_do_fetch_result($sub_sth)){
						$current_date_disabled_list[] = $sub_row['selected_date'];
					}
					
					$current_date_disabled_list_joined = implode(',',$current_date_disabled_list);
					if(!empty($element[$j]->date_disable_specific)){ //add to existing disable date list
						if(empty($element[$j]->date_disabled_list)){
							$element[$j]->date_disabled_list = $current_date_disabled_list_joined;
						}else{
							$element[$j]->date_disabled_list .= ','.$current_date_disabled_list_joined;
						}
					}else{
						//'disable specific date' is not enabled, we need to override and enable it from here
						$element[$j]->date_disable_specific = 1;
						$element[$j]->date_disabled_list = $current_date_disabled_list_joined;
					}
					
				}
			}
			
			//if the element is a matrix field and not the parent, store the data into a lookup array for later use when rendering the markup
			if($row['element_type'] == 'matrix' && !empty($row['element_matrix_parent_id'])){
				
				$parent_id 	 = $row['element_matrix_parent_id'];
				$el_position = $row['element_position'];
				$matrix_elements[$parent_id][$el_position]['title'] = $element[$j]->title; 
				$matrix_elements[$parent_id][$el_position]['id'] 	= $element[$j]->id; 
				
				$matrix_child_option_id = '';
				foreach($element_options as $value){
					$matrix_child_option_id .= $value->id.',';
				}
				$matrix_child_option_id = rtrim($matrix_child_option_id,',');
				$matrix_elements[$parent_id][$el_position]['children_option_id'] = $matrix_child_option_id; 
				
				//remove it from the main element array
				$element[$j] = array();
				unset($element[$j]);
				$j--;
			}
			
			$j++;
		}
		
		
		//add captcha if enabled
		//on multipage form, captcha should be displayed on the last page only
		if(!empty($form->captcha) && (empty($edit_id))){
			if($form->page_total == 1 || ($form->page_total == $page_number)){
				$element[$j] = new stdClass();
				$element[$j]->type 			= 'captcha';
				$element[$j]->captcha_type 	= $form->captcha_type;
				$element[$j]->form_id 		= $form_id;
				$element[$j]->is_private	= 0;

				if(!empty($error_elements['element_captcha'])){
					$element[$j]->is_error 	    = 1;
					$element[$j]->error_message = $error_elements['element_captcha'];
				}
			}
		}
		
		//generate html markup for each element
		$container_class = '';
		$all_element_markup = '';
		foreach ($element as $element_data){
			if($element_data->is_private && empty($edit_id)){ //don't show private element on live forms
				continue;
			}
			
			//if this is matrix field, build the children data from $matrix_elements array
			if($element_data->type == 'matrix'){
				$element_data->matrix_children = $matrix_elements[$element_data->id];
			}
			
			$all_element_markup .= call_user_func('mf_display_'.$element_data->type,$element_data);
		}
		
		if(!empty($custom_error)){
			$form->error_message =<<<EOT
			<li id="error_message">
					<h3 id="error_message_title">{$custom_error}</h3>
			</li>	
EOT;
		}elseif(!empty($error_elements)){
			$form->error_message =<<<EOT
			<li id="error_message">
					<h3 id="error_message_title">{$mf_lang['error_title']}</h3>
					<p id="error_message_desc">{$mf_lang['error_desc']}</p>
			</li>	
EOT;
		}
		
		//if this form is using custom theme and not on edit entry page
		if(!empty($form->theme_id) && empty($edit_id)){
			//get the field highlight color for the particular theme
			$query = "SELECT 
							highlight_bg_type,
							highlight_bg_color,
							form_shadow_style,
							form_shadow_size,
							form_shadow_brightness,
							form_button_type,
							form_button_text,
							form_button_image,
							theme_has_css  
						FROM 
							".MF_TABLE_PREFIX."form_themes 
					   WHERE 
					   		theme_id = ?";
			$params = array($form->theme_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			$form_shadow_style 		= $row['form_shadow_style'];
			$form_shadow_size 		= $row['form_shadow_size'];
			$form_shadow_brightness = $row['form_shadow_brightness'];
			$theme_has_css = (int) $row['theme_has_css'];
			
			//if the theme has css file, make sure to refer to that file
			//otherwise, generate the css dynamically
			if(!empty($theme_has_css)){
				$theme_css_link = '<link rel="stylesheet" type="text/css" href="'.$machform_path.$mf_settings['data_dir'].'/themes/theme_'.$form->theme_id.'.css" media="all" />';
			}else{
				$theme_css_link = '<link rel="stylesheet" type="text/css" href="'.$machform_path.'css_theme.php?theme_id='.$form->theme_id.'" media="all" />';
			}
			
			if($row['highlight_bg_type'] == 'color'){
				$field_highlight_color = $row['highlight_bg_color'];
			}else{ 
				//if the field highlight is using pattern instead of color, set the color to empty string
				$field_highlight_color = ''; 
			}
			
			//get the css link for the fonts
			$font_css_markup = mf_theme_get_fonts_link($dbh,$form->theme_id);
			
			//get the form shadow classes
			if(!empty($form_shadow_style) && ($form_shadow_style != 'disabled')){
				preg_match_all("/[A-Z]/",$form_shadow_style,$prefix_matches);
				//this regex simply get the capital characters of the shadow style name
				//example: RightPerspectiveShadow result to RPS and then being sliced to RP
				$form_shadow_prefix_code = substr(implode("",$prefix_matches[0]),0,-1);
				
				$form_shadow_size_class  = $form_shadow_prefix_code.ucfirst($form_shadow_size);
				$form_shadow_brightness_class = $form_shadow_prefix_code.ucfirst($form_shadow_brightness);

				if(empty($integration_method)){ //only display shadow if the form is not being embedded using any method
					$form_container_class = $form_shadow_style.' '.$form_shadow_size_class.' '.$form_shadow_brightness_class;
				}
			}
			
			//get the button text/image setting
			if(empty($form->review)){
				
				if($row['form_button_type'] == 'text'){
					$submit_button_markup = '<input id="submit_form" class="button_text" type="submit" name="submit_form" value="'.$row['form_button_text'].'" />';
				}else{
					$submit_button_markup = '<input class="submit_img_primary" type="image" alt="Submit" id="submit_form" name="submit_form" src="'.$row['form_button_image'].'" />';
				}
				
				
			}else{
				$submit_button_markup = '<input id="submit_form" class="button_text" type="submit" name="submit_form" value="'.$mf_lang['continue_button'].'" />';
			}
			
		}else{ //if the form doesn't have any theme being applied
			$field_highlight_color = '#FFF7C0';
			
			if(empty($integration_method)){
				$form_container_class = 'WarpShadow WLarge WNormal'; //default shadow
			}else{
				$form_container_class = ''; //dont show any shadow when the form being embedded
			}
			
			
			if(empty($form->review)){
				$submit_button_markup = '<input id="submit_form" class="button_text" type="submit" name="submit_form" value="'.$mf_lang['submit_button'].'" />';
			}else{
				$submit_button_markup = '<input id="submit_form" class="button_text" type="submit" name="submit_form" value="'.$mf_lang['continue_button'].'" />';
			}
		}
		
		//display edit_id if there is any, this is being called on edit_entry.php page
		if(!empty($edit_id)){
			$edit_markup = "<input type=\"hidden\" name=\"edit_id\" value=\"{$edit_id}\" />\n";
			$submit_button_markup = '<input id="submit_form" class="button_text" type="submit" name="submit_form" value="Save Changes" />';
		}else{
			$edit_markup = '';
		}
		

		//check for specific form css, if any, use it instead
		if($form->has_css){
			$css_dir = $mf_settings['data_dir']."/form_{$form_id}/css/";
		}
		
		if(!empty($form->password) && empty($_SESSION['user_authenticated'])){ //if form require password and password hasn't set yet
			$show_password_form = true;
			
		}elseif (!empty($form->password) && !empty($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] != $form_id){ //if user authenticated but not for this form
			$show_password_form = true;
			
		}else{ //user authenticated for this form, or no password required
			$show_password_form = false;
		}

		
		if($show_password_form){
			$submit_button_markup = '<input id="submit_form" class="button_text" type="submit" name="submit_form" value="'.$mf_lang['submit_button'].'" />';
		}

		//default markup for single page form submit button
		$button_markup =<<<EOT
		<li id="li_buttons" class="buttons">
			    <input type="hidden" name="form_id" value="{$form->id}" />
			    {$edit_markup}
			    <input type="hidden" name="submit_form" value="1" />
			    <input type="hidden" name="page_number" value="{$page_number}" />
				{$submit_button_markup}
		</li>
EOT;
		
		//check for form limit rule
		$form_has_maximum_entries = false;
		
		if(!empty($form->limit_enable)){
			$query = "select count(*) total_row from ".MF_TABLE_PREFIX."form_{$form_id} where `status`=1";
			$params = array();
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			$total_entries  = $row['total_row'];

			if($total_entries >= $form->limit){
				$form_has_maximum_entries = true;
			}
		}

		//check for automatic scheduling limit, if enabled
		if(!empty($form->schedule_enable)){
			$schedule_start_time = strtotime($form->schedule_start_date.' '.$form->schedule_start_hour);
			$schedule_end_time = strtotime($form->schedule_end_date.' '.$form->schedule_end_hour);

			$current_time = strtotime(date("Y-m-d H:i:s"));

			if(!empty($schedule_start_time)){
				if($current_time < $schedule_start_time){
					$form->active = 0;
				}
			}

			if(!empty($schedule_end_time)){
				if($current_time > $schedule_end_time){
					$form->active = 0;
				}
			}
		}
				
		if(empty($form->active) || $form_has_maximum_entries){ //if form is not active, don't show the fields
			$form_desc_div ='';	
			$all_element_markup = '';
			$button_markup = '';
			$ul_class = 'class="password"';

			if($form_has_maximum_entries){
				$inactive_message = $mf_lang['form_limited'];
			}else{
				$inactive_message = $mf_lang['form_inactive'];
			}

			$custom_element =<<<EOT
			<li>
				<h2>{$inactive_message}</h2>
			</li>
EOT;
		}elseif($show_password_form){ //don't show form description if this page is password protected and user not authenticated
			$form_desc_div ='';	
			$all_element_markup = '';	
			$custom_element =<<<EOT
			<li>
				<h2>{$mf_lang['form_pass_title']}</h2>
				<div>
				<input type="password" value="" class="text" name="password" id="password" />
				<label for="password" class="desc">{$mf_lang['form_pass_desc']}</label>
				</div>
			</li>
EOT;
			$ul_class = 'class="password"';
		}else{
			if(!empty($form->name) || !empty($form->description)){
				$form->description = nl2br($form->description);
				$form_desc_div =<<<EOT
		<div class="form_description">
			<h2>{$form->name}</h2>
			<p>{$form->description}</p>
		</div>
EOT;
			}
		}
		
		if(!$has_guidelines){
			$container_class .= " no_guidelines";
		}
		
		if($integration_method == 'iframe'){
			$html_class_tag = 'class="embed"';
		}
		
		if($has_calendar){
			$calendar_init = '<script type="text/javascript" src="'.$machform_path.'js/datepick/jquery.datepick.js"></script>'."\n".
							 '<script type="text/javascript" src="'.$machform_path.'js/datepick/jquery.datepick.ext.js"></script>'."\n".
							 '<link type="text/css" href="'.$machform_path.'js/datepick/smoothness.datepick.css" rel="stylesheet" />';
		}else{
			$calendar_init = '';
		}
		
		//if the form has multiple pages
		//display the pagination header
		if($form->page_total > 1 && $show_password_form === false){
			//build pagination header based on the selected type. possible values:
			//steps - display multi steps progress
			//percentage - display progress bar with percentage
			//disabled - disabled
			
			$page_breaks_data = array();
			$page_title_array = array();
			
			//get page titles
			$query = "SELECT 
							element_page_title,
							element_page_number,
							element_submit_use_image,
						    element_submit_primary_text,
							element_submit_secondary_text,
							element_submit_primary_img,
							element_submit_secondary_img 
						FROM 
							".MF_TABLE_PREFIX."form_elements
					   WHERE
							form_id = ? and element_status = 1 and element_type = 'page_break'
					ORDER BY 
					   		element_page_number asc";
			$params = array($form_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			while($row = mf_do_fetch_result($sth)){
				$temp_page_number = $row['element_page_number'];
				$page_breaks_data[$temp_page_number]['use_image'] 		= $row['element_submit_use_image'];
				$page_breaks_data[$temp_page_number]['primary_text'] 	= $row['element_submit_primary_text'];
				$page_breaks_data[$temp_page_number]['secondary_text'] 	= $row['element_submit_secondary_text'];
				$page_breaks_data[$temp_page_number]['primary_img']		= $row['element_submit_primary_img'];
				$page_breaks_data[$temp_page_number]['secondary_img'] 	= $row['element_submit_secondary_img'];
				
				$page_title_array[] = $row['element_page_title'];
			}
			
			//add the last page buttons info into the array for easy lookup
			$page_breaks_data[$form->page_total]['use_image'] 		= $form->submit_use_image;
			$page_breaks_data[$form->page_total]['primary_text'] 	= $form->submit_primary_text;
			$page_breaks_data[$form->page_total]['secondary_text'] 	= $form->submit_secondary_text;
			$page_breaks_data[$form->page_total]['primary_img'] 	= $form->submit_primary_img;
			$page_breaks_data[$form->page_total]['secondary_img'] 	= $form->submit_secondary_img;
			
			
			if($form->pagination_type == 'steps'){
				
				$page_titles_markup = '';
				
				$i=1;
				foreach ($page_title_array as $page_title){
					if($i == $page_number){
						$ap_tp_num_active = ' ap_tp_num_active';
						$ap_tp_text_active = ' ap_tp_text_active';
					}else{
						$ap_tp_num_active = '';
						$ap_tp_text_active = '';
					}
					
					$page_titles_markup .= '<td align="center"><span id="page_num_'.$i.'" class="ap_tp_num'.$ap_tp_num_active.'">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text'.$ap_tp_text_active.'">'.$page_title.'</span></td><td align="center" class="ap_tp_arrow">&gt;</td>'."\n";
					$i++;
				}
				
				//add the last page title into the pagination header markup
				if($i == $page_number){
					$ap_tp_num_active = ' ap_tp_num_active';
					$ap_tp_text_active = ' ap_tp_text_active';
				}else{
					$ap_tp_num_active = '';
					$ap_tp_text_active = '';
				}
				$page_titles_markup .= '<td align="center"><span id="page_num_'.$i.'" class="ap_tp_num'.$ap_tp_num_active.'">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text'.$ap_tp_text_active.'">'.$form->lastpage_title.'</span></td>';
			
				//if form review enabled, we need to add the pagination header
				if(!empty($form->review)){
					$i++;
					$page_titles_markup .= '<td align="center" class="ap_tp_arrow">&gt;</td><td align="center"><span id="page_num_'.$i.'" class="ap_tp_num">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text">'.$form->review_title.'</span></td>';
				}
				
				$pagination_header =<<<EOT
			<li id="pagination_header" class="li_pagination">
			 <table class="ap_table_pagination" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
			  	{$page_titles_markup}
			  </tr>
			</table>
			</li>
EOT;
			}else if($form->pagination_type == 'percentage'){
				
				$page_total = count($page_title_array) + 1;
				
				if(!empty($form->review)){
					$page_total++;
				}
				
				$percent_value = round(($page_number/$page_total) * 100);
				
				if($percent_value == 100){ //it's not make sense to display 100% when the form is not really submitted yet
					$percent_value = 99;
				}
				
				if(!empty($form->review)){
					if(($page_total-1) == $page_number){ //if this is last page of the form
						$current_page_title = $form->lastpage_title;
					}else{
						$current_page_title = $page_title_array[$page_number-1];
					}
				}else{
					if($page_total == $page_number){ //if this is last page of the form
						$current_page_title = $form->lastpage_title;
					}else{
						$current_page_title = $page_title_array[$page_number-1];
					}
				}
				
				$page_number_title = sprintf($mf_lang['page_title'],$page_number,$page_total);
				$pagination_header =<<<EOT
			<li id="pagination_header" class="li_pagination" title="Click to edit">
			    <h3 id="page_title_{$page_number}">{$page_number_title} - {$current_page_title}</h3>
				<div class="mf_progress_container">          
			    	<div id="mf_progress_percentage" class="mf_progress_value" style="width: {$percent_value}%"><span>{$percent_value}%</span></div>
				</div>
			</li>
EOT;
			}else{			
				$pagination_header = '';
			}

			//build the submit buttons markup
			if(empty($edit_id)){
				if(empty($page_breaks_data[$page_number]['use_image'])){ //if using text buttons as submit
				
					if($page_number > 1){
						$button_secondary_markup = '<input class="button_text btn_secondary" type="submit" id="submit_secondary" name="submit_secondary" value="'.$page_breaks_data[$page_number]['secondary_text'].'" />';
					}
					
					$button_markup =<<<EOT
			<li id="li_buttons" class="buttons">
				    <input type="hidden" name="form_id" value="{$form->id}" />
				    {$edit_markup}
				    <input type="hidden" name="submit_form" value="1" />
				    <input type="hidden" name="page_number" value="{$page_number}" />
					<input class="button_text btn_primary" type="submit" id="submit_primary" name="submit_primary" value="{$page_breaks_data[$page_number]['primary_text']}" />
					{$button_secondary_markup}
			</li>
EOT;
				}else{ //if using images as submit
					
					if($page_number > 1){
						$button_secondary_markup = '<input class="submit_img_secondary" type="image" alt="Previous" id="submit_secondary" name="submit_secondary" src="'.$page_breaks_data[$page_number]['secondary_img'].'" />';
					}
					
					$button_markup =<<<EOT
			<li id="li_buttons" class="buttons">
				    <input type="hidden" name="form_id" value="{$form->id}" />
				    {$edit_markup}
				    <input type="hidden" name="submit_form" value="1" />
				    <input type="hidden" name="page_number" value="{$page_number}" />
				 	<input class="submit_img_primary" type="image" alt="Continue" id="submit_primary" name="submit_primary" src="{$page_breaks_data[$page_number]['primary_img']}" />
					{$button_secondary_markup}
			</li>
EOT;
					
				}
			}else{ //if there is edit_id, then this is edit_entry page, display a standard button
				$button_markup =<<<EOT
			<li id="li_buttons" class="buttons">
				    <input type="hidden" name="form_id" value="{$form->id}" />
				    {$edit_markup}
				    <input type="hidden" name="submit_form" value="1" />
				    <input type="hidden" name="page_number" value="{$page_number}" />
					<input class="button_text btn_primary" type="submit" id="submit_primary" name="submit_primary" value="Save Changes" />
			</li>
EOT;
			}
			
		}
		
		if($has_advance_uploader){

			if(!empty($machform_path)){
				$mf_path_script =<<<EOT
<script type="text/javascript">
var __machform_path = '{$machform_path}';
</script>
EOT;
			}

			$advance_uploader_js =<<<EOT
<script type="text/javascript" src="{$machform_path}js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="{$machform_path}js/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript" src="{$machform_path}js/jquery.jqplugin.min.js"></script>
{$mf_path_script}
EOT;
		}

		if($integration_method == 'iframe'){
			$auto_height_js =<<<EOT
<script type="text/javascript" src="{$machform_path}js/jquery.ba-postmessage.min.js"></script>
<script type="text/javascript">
    $(function(){
    	$.postMessage({mf_iframe_height: $('body').outerHeight(true)}, '*', parent );
    });
</script>
EOT;
		}
		
		//if the form has resume enabled and this is multi page form (single page form doesn't have resume option)
		if(!empty($form->resume_enable) && $form->page_total > 1){
			
			if(!empty($error_elements['element_resume_email'])){
				$li_resume_email_style = '';
				$li_resume_error_message = "<p class=\"error\">{$error_elements['element_resume_email']}</p>";
				$li_resume_class = 'class="error"';
				$li_resume_checked = 'checked="checked"';
				$li_resume_button_status = 1;
			}else{
				$li_resume_email_style = 'style="display: none"';
				$li_resume_error_message = '';
				$li_resume_class = '';
				$li_resume_checked = '';
				$li_resume_button_status = 0;
			}
			
			$form_resume_markup = <<<EOT
			<li id="li_resume_checkbox">
			<div>
				<span><input type="checkbox" value="1" class="element checkbox" name="element_resume_checkbox" id="element_resume_checkbox" {$li_resume_checked}>
					<label for="element_resume_checkbox" class="choice">{$mf_lang['resume_checkbox_title']}</label>
				</span>
			</div> 
			</li>
			<li id="li_resume_email" {$li_resume_class} {$li_resume_email_style} data-resumebutton="{$li_resume_button_status}" data-resumelabel="{$mf_lang['resume_submit_button_text']}">
				<label for="element_resume_email" class="description">{$mf_lang['resume_email_input_label']}</label>
				<div>
					<input type="text" value="{$populated_values['element_resume_email']}" class="element text medium" name="element_resume_email" id="element_resume_email"> 
				</div><p id="guide_resume_email" class="guidelines"><small>{$mf_lang['resume_guideline']}</small></p> {$li_resume_error_message}
			</li>
EOT;

		}
		
		//if the form has enabled merchant support and set the total payment to be displayed
		if(!empty($form->payment_enable_merchant) && !empty($form->payment_show_total)){
			
			$currency_symbol = '&#36;';
			
			switch($form->payment_currency){
				case 'USD' : $currency_symbol = '&#36;';break;
				case 'EUR' : $currency_symbol = '&#8364;';break;
				case 'GBP' : $currency_symbol = '&#163;';break;
				case 'AUD' : $currency_symbol = 'A&#36;';break;
				case 'CAD' : $currency_symbol = 'C&#36;';break;
				case 'JPY' : $currency_symbol = '&#165;';break;
				case 'THB' : $currency_symbol = '&#3647;';break;
				case 'HUF' : $currency_symbol = '&#70;&#116;';break;
				case 'CHF' : $currency_symbol = 'CHF';break;
				case 'CZK' : $currency_symbol = '&#75;&#269;';break;
				case 'SEK' : $currency_symbol = 'kr';break;
				case 'DKK' : $currency_symbol = 'kr';break;
				case 'PHP' : $currency_symbol = '&#36;';break;
				case 'MYR' : $currency_symbol = 'RM';break;
				case 'PLN' : $currency_symbol = '&#122;&#322;';break;
				case 'BRL' : $currency_symbol = 'R&#36;';break;
				case 'HKD' : $currency_symbol = 'HK&#36;';break;
				case 'MXN' : $currency_symbol = 'Mex&#36;';break;
				case 'TWD' : $currency_symbol = 'NT&#36;';break;
				case 'TRY' : $currency_symbol = 'TL';break;
			}
		
			if($form->payment_price_type == 'variable'){	
				//if this is multipage form, we need to get the total selected price from other pages
				if($form->page_total > 1){
					$other_page_total_payment = (double) mf_get_payment_total($dbh,$form_id,$session_id,$page_number);
					$other_page_total_data_tag = 'data-basetotal="'.$other_page_total_payment.'"';
				}else{
					$other_page_total_data_tag = 'data-basetotal="0"';
				}
			}elseif ($form->payment_price_type == 'fixed') {
				$other_page_total_data_tag = 'data-basetotal="'.$form->payment_price_amount.'"';
			}
			
			$payment_total_markup = <<<EOT
			<li class="total_payment" {$other_page_total_data_tag}>
				<span>
					<h3>{$currency_symbol}<var>0</var></h3>
					<h5>{$mf_lang['payment_total']}</h5>
				</span>
			</li>
EOT;
			
			if($form->payment_total_location == 'top'){
				$payment_total_markup_top = $payment_total_markup;
			}else if($form->payment_total_location == 'bottom'){
				$payment_total_markup_bottom = $payment_total_markup;
			}else if($form->payment_total_location == 'top-bottom' || $form->payment_total_location == 'all'){
				$payment_total_markup_top 	 = $payment_total_markup;
				$payment_total_markup_bottom = $payment_total_markup;
			}
		}
		
		if(empty($mf_settings['disable_machform_link'])){
			$powered_by_markup = 'Powered by MachForm';
		}else{
			$powered_by_markup = '';
		}

		//if advanced form code being used, display the form without body container
		if($integration_method == 'php'){
			$container_class .= " integrated";

			if(!empty($edit_id)){
				$view_css_markup = '<link rel="stylesheet" type="text/css" href="css/edit_entry.css" media="all" />';
			}else{
				$view_css_markup = "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$machform_path}{$css_dir}view.css\" media=\"all\" />";
			}

			$form_markup = <<<EOT
{$view_css_markup}
{$theme_css_link}
{$font_css_markup}
<style>
html{
	background: none repeat scroll 0 0 transparent;
	background-color: transparent;
}
</style>
<script type="text/javascript" src="{$machform_path}js/jquery.min.js"></script>
<script type="text/javascript" src="{$machform_path}js/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="{$machform_path}view.js"></script>
{$advance_uploader_js}
{$calendar_init}

<div id="main_body" class="{$container_class}">

	<div id="form_container">
	
		<h1><a>{$form->name}</a></h1>
		<form id="form_{$form->id}" class="appnitro {$form->label_alignment}" {$form_enc_type} method="post" data-highlightcolor="{$field_highlight_color}" action="#main_body">
			{$form_desc_div}						
			<ul {$ul_class}>
			{$pagination_header}
			{$payment_total_markup_top}
			{$form->error_message}
			{$all_element_markup}
			{$custom_element}
			{$payment_total_markup_bottom}
			{$form_resume_markup}
			{$button_markup}
			</ul>
		</form>	
		<div id="footer">
			{$powered_by_markup}
		</div>
	</div>	
</div>

EOT;
		}else{

			$form_markup = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html {$html_class_tag} xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$form->name}</title>
<link rel="stylesheet" type="text/css" href="data/form_default/css/view.css" media="all" />
{$theme_css_link}
{$font_css_markup}
<script type="text/javascript" src="{$machform_path}js/jquery.min.js"></script>
<script type="text/javascript" src="{$machform_path}js/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="{$machform_path}view.js"></script>
{$advance_uploader_js}
{$calendar_init}
{$auto_height_js}
</head>
<body id="main_body" class="{$container_class}">
	
	<div id="form_container" class="{$form_container_class}">
	
		<h1><a>{$form->name}</a></h1>
		<form id="form_{$form->id}" class="appnitro {$form->label_alignment}" {$form_enc_type} method="post" data-highlightcolor="{$field_highlight_color}" action="#main_body">
			{$form_desc_div}						
			<ul {$ul_class}>
			{$pagination_header}
			{$payment_total_markup_top}
			{$form->error_message}
			{$all_element_markup}
			{$custom_element}
			{$payment_total_markup_bottom}
			{$form_resume_markup}
			{$button_markup}
			</ul>
		</form>	
		<div id="footer">
			{$powered_by_markup}
		</div>
	</div>
	
	</body>
</html>
EOT;
		}

		return $form_markup;
		
	}
	
	
	//display the form within the form builder page
	function mf_display_raw_form($dbh,$form_id){
		
		global $mf_lang;
		
		
		//get form properties data
		$query 	= "select 
						 form_name,
						 form_description,
						 form_label_alignment,
						 form_page_total,
						 form_lastpage_title,
						 form_submit_primary_text,
						 form_submit_secondary_text,
						 form_submit_primary_img,
						 form_submit_secondary_img,
						 form_submit_use_image,
						 form_pagination_type 
				     from 
				     	 ".MF_TABLE_PREFIX."forms 
				    where 
				    	 form_id = ?";
		$params = array($form_id);
	
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
	
		$form = new stdClass();
		
		$form->id 				= $form_id;
		$form->name 			= $row['form_name'];
		$form->description 		= $row['form_description'];
		$form->label_alignment 	= $row['form_label_alignment'];
		$form->page_total 		= $row['form_page_total'];
		$form->lastpage_title 	= $row['form_lastpage_title'];
		$form->submit_primary_text 	 = $row['form_submit_primary_text'];
		$form->submit_secondary_text = $row['form_submit_secondary_text'];
		$form->submit_primary_img 	 = $row['form_submit_primary_img'];
		$form->submit_secondary_img  = $row['form_submit_secondary_img'];
		$form->submit_use_image  	 = (int) $row['form_submit_use_image'];
		$form->pagination_type		 = $row['form_pagination_type'];
		
		$matrix_elements = array();
		
		//get elements data
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
				   		form_id = ? and live = 1 
				order by 
						element_id asc,`position` asc";
		$params = array($form_id);
		$sth = mf_do_query($query,$params,$dbh);
		
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			$option_id  = $row['option_id'];
			$options_lookup[$element_id][$option_id]['position'] 		  = $row['position'];
			$options_lookup[$element_id][$option_id]['option'] 			  = $row['option'];
			$options_lookup[$element_id][$option_id]['option_is_default'] = $row['option_is_default'];
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
						element_choice_has_other,
						element_choice_other_label,
						element_choice_columns,
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
						element_page_number,
						element_matrix_allow_multiselect,
						element_matrix_parent_id,
						element_range_min,
						element_range_max,
						element_range_limit_by 
					from 
						".MF_TABLE_PREFIX."form_elements 
				   where 
				   		form_id = ? and element_status='1'
				order by 
						element_position asc";
		$params = array($form_id);
	
		$sth = mf_do_query($query,$params,$dbh);
		
		$j=0;
		$has_calendar = false;
		$has_guidelines = false;
		
		$page_title_array = array();
		
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			
			//lookup element options first
			$element_options = array();
			if(!empty($options_lookup[$element_id])){
				
				$i=0;
				foreach ($options_lookup[$element_id] as $option_id=>$data){
					$element_options[$i] = new stdClass();
					$element_options[$i]->id 		 = $option_id;
					$element_options[$i]->option 	 = $data['option'];
					$element_options[$i]->is_default = $data['option_is_default'];
					$element_options[$i]->is_db_live = 1;
					
					$i++;
				}
			}
			
			//populate elements
			$element[$j] = new stdClass();
			$element[$j]->title 		= nl2br($row['element_title']);
			
			
			$element[$j]->guidelines 	= $row['element_guidelines'];
			
			if(!empty($row['element_guidelines']) && ($row['element_type'] != 'section') && ($row['element_type'] != 'matrix')){
				$has_guidelines = true;
			}
			
			$element[$j]->size 			= $row['element_size'];
			$element[$j]->default_value = htmlspecialchars($row['element_default_value']);
			$element[$j]->is_required 	= $row['element_is_required'];
			$element[$j]->is_unique 	= $row['element_is_unique'];
			$element[$j]->is_private 	= $row['element_is_private'];
			$element[$j]->type 			= $row['element_type'];
			$element[$j]->position 		= $row['element_position'];
			$element[$j]->id 			= $row['element_id'];
			$element[$j]->is_db_live 	 = 1;
			$element[$j]->is_design_mode = true;
			$element[$j]->choice_has_other   = (int) $row['element_choice_has_other'];
			$element[$j]->choice_other_label = $row['element_choice_other_label'];
			$element[$j]->choice_columns   	 = (int) $row['element_choice_columns'];
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
			$element[$j]->page_number	 				= (int) $row['element_page_number'];
			$element[$j]->page_total	 				= $form->page_total;
			$element[$j]->matrix_allow_multiselect	 	= (int) $row['element_matrix_allow_multiselect'];
			$element[$j]->matrix_parent_id	 			= (int) $row['element_matrix_parent_id'];
			$element[$j]->range_min	 					= $row['element_range_min'];
			$element[$j]->range_max	 					= $row['element_range_max'];
			$element[$j]->range_limit_by	 			= $row['element_range_limit_by'];
			
			$element[$j]->constraint 	= $row['element_constraint'];
			if(!empty($element_options)){
				$element[$j]->options 	= $element_options;
			}else{
				$element[$j]->options 	= '';
			}
			
			if($row['element_type'] == 'page_break'){
				$page_title_array[] = $row['element_page_title'];
			}
			
			//if the element is a matrix field and not the parent, store the data into a lookup array for later use when rendering the markup
			if($row['element_type'] == 'matrix' && !empty($row['element_matrix_parent_id'])){
				
				$parent_id 	 = $row['element_matrix_parent_id'];
				$el_position = $row['element_position'];
				$matrix_elements[$parent_id][$el_position]['title'] = $element[$j]->title; 
				$matrix_elements[$parent_id][$el_position]['id'] 	= $element[$j]->id; 
				
				$matrix_child_option_id = '';
				foreach($element_options as $value){
					$matrix_child_option_id .= $value->id.',';
				}
				$matrix_child_option_id = rtrim($matrix_child_option_id,',');
				$matrix_elements[$parent_id][$el_position]['children_option_id'] = $matrix_child_option_id; 
				
				//remove it from the main element array
				$element[$j] = array();
				unset($element[$j]);
				$j--;
			}
			
			$j++;
		}

		
		
		
		//generate html markup for each element
		$all_element_markup = '';
		foreach ($element as $element_data){
			//if this is matrix field, build the children data from $matrix_elements array
			if($element_data->type == 'matrix'){
				$element_data->matrix_children = $matrix_elements[$element_data->id];
			}
			$all_element_markup .= call_user_func('mf_display_'.$element_data->type,$element_data);
		}
		
		if(empty($all_element_markup)){
			$all_element_markup = '<li id="li_dummy">&nbsp;</li>';
		}	
				
				

		if(!empty($form->name) || !empty($form->description)){
			$form->description = nl2br($form->description);
			$form_desc_div =<<<EOT
		<div id="form_header" class="form_description">
			<h2 id="form_header_title">{$form->name}</h2>
			<p id="form_header_desc">{$form->description}</p>
		</div>
EOT;
		}else{
			$form_desc_div =<<<EOT
		<div id="form_header" class="form_description">
			<h2 id="form_header_title"><i>This form has no title</i></h2>
			<p id="form_header_desc"></p>
		</div>
EOT;
		}

		if($has_guidelines){
			$container_class = "integrated";
		}else{
			$container_class = "integrated no_guidelines";
		}
		
		
		//if the form has multiple pages
		//display the pagination header
		if($form->page_total > 1){
			
			
			//build pagination header based on the selected type. possible values:
			//steps - display multi steps progress
			//percentage - display progress bar with percentage
			//disabled - disabled
			
			if($form->pagination_type == 'steps'){
				
				$page_titles_markup = '';
				
				$i=1;
				foreach ($page_title_array as $page_title){
					if($i==1){
						$ap_tp_num_active = ' ap_tp_num_active';
						$ap_tp_text_active = ' ap_tp_text_active';
					}else{
						$ap_tp_num_active = '';
						$ap_tp_text_active = '';
					}
					
					$page_titles_markup .= '<td align="center"><span id="page_num_'.$i.'" class="ap_tp_num'.$ap_tp_num_active.'">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text'.$ap_tp_text_active.'">'.$page_title.'</span></td><td align="center" class="ap_tp_arrow">&gt;</td>'."\n";
					$i++;
				}
				
				//add the last page title into the pagination header markup
				$page_titles_markup .= '<td align="center"><span id="page_num_'.$i.'" class="ap_tp_num">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text">'.$form->lastpage_title.'</span></td>';
				
			
				$pagination_header =<<<EOT
			<li id="pagination_header" class="li_pagination" title="Click to edit">
			 <table class="ap_table_pagination" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
			  	{$page_titles_markup}
			  </tr>
			</table>
			</li>
EOT;
			}else if($form->pagination_type == 'percentage'){
				$page_total = count($page_title_array) + 1;
				$percent_value = round((1/$page_total) * 100);
				$pagination_header =<<<EOT
			<li id="pagination_header" class="li_pagination" title="Click to edit">
			    <h3 id="page_title_1">Page 1 of {$page_total} - {$page_title_array[0]}</h3>
				<div class="mf_progress_container">          
			    	<div id="mf_progress_percentage" class="mf_progress_value" style="width: {$percent_value}%"><span>{$percent_value}%</span></div>
				</div>
			</li>
EOT;
			}else{
			
				$pagination_header =<<<EOT
			<li id="pagination_header" class="li_pagination" title="Click to edit">
			    <h3 class="no_header">Pagination Header Disabled</h3>
			</li>
EOT;
			}

			if($form->submit_use_image == 1){
				$btn_class = ' hide';
				$image_class = '';
			}else{
				$btn_class = '';
				$image_class = ' hide';
			}  	
			  	
			$pagination_footer =<<<EOT
		<li title="Click to edit" class="page_break synched" id="li_lastpage">
			<div>
				<table width="100%" cellspacing="0" cellpadding="0" border="0" class="ap_table_pagination">
					<tbody><tr>
						<td align="left" style="vertical-align: bottom;">
							<input type="submit" class="btn_primary btn_submit{$btn_class}" name="btn_submit_lastpage" id="btn_submit_lastpage" value="{$form->submit_primary_text}" disabled="disabled">
							<input type="submit" class="btn_secondary btn_submit{$btn_class}" name="btn_prev_lastpage" id="btn_prev_lastpage" value="{$form->submit_secondary_text}" disabled="disabled">
							<input type="image" src="{$form->submit_primary_img}" class="img_primary img_submit{$image_class}" alt="Submit" name="img_submit_lastpage" id="img_submit_lastpage" value="Submit" disabled="disabled">
							<input type="image" src="{$form->submit_secondary_img}" class="img_secondary img_submit{$image_class}" alt="Previous" name="img_prev_lastpage" id="img_prev_lastpage" value="Previous" disabled="disabled">
						</td> 
						<td width="75px" align="center" style="vertical-align: top;">
							<span class="ap_tp_num" name="pagenum_lastpage" id="pagenum_lastpage">{$form->page_total}</span>
							<span class="ap_tp_text" name="pagetotal_lastpage" id="pagetotal_lastpage">Page {$form->page_total} of {$form->page_total}</span>
						</td>
					</tr>
				</tbody></table>
			</div>
		</li>
EOT;
		}
			
		$form_markup =<<<EOT
<div id="main_body" class="{$container_class}">
		
	<div id="form_container">
	
		<h1><a>{$form->name}</a></h1>
		<form id="form_builder_preview" class="appnitro {$form->label_alignment}" method="post" action="#main_body">
			{$form_desc_div}				
			<ul {$ul_class} id="form_builder_sortable" title="Click field to edit. Drag to reorder.">
			{$pagination_header}	
			{$all_element_markup}
			{$pagination_footer}
			</ul>
		</form>	
	</div>
</div>
EOT;
		return $form_markup;
		
	}
	
	function mf_display_success($dbh,$form_id,$form_params=array()){
		global $mf_lang;
		
		if(!empty($form_params['integration_method'])){
			$integration_method = $form_params['integration_method'];
		}else{
			$integration_method = '';
		}

		if(!empty($form_params['machform_path'])){
			$machform_path = $form_params['machform_path'];
		}else{
			$machform_path = '';
		}



		$mf_settings = mf_get_settings($dbh);
		
		//get form properties data
		$query 	= "select 
						  form_success_message,
						  form_has_css,
						  form_name,
						  form_theme_id
				     from 
				     	 ".MF_TABLE_PREFIX."forms 
				    where 
				    	 form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
	
		$form = new stdClass();
		
		$form->id 				= $form_id;
		$form->success_message  = nl2br($row['form_success_message']);
		$form->has_css 			= $row['form_has_css'];
		$form->name 			= $row['form_name'];
		$form->theme_id 		= $row['form_theme_id'];
	
		
		//check for specific form css, if any, use it instead
		if($form->has_css){
			$css_dir = $mf_settings['data_dir']."/form_{$form_id}/css/";
		}
		
		//if this form is using custom theme
		if(!empty($form->theme_id)){
			//get the field highlight color for the particular theme
			$query = "SELECT 
							highlight_bg_type,
							highlight_bg_color,
							form_shadow_style,
							form_shadow_size,
							form_shadow_brightness,
							form_button_type,
							form_button_text,
							form_button_image,
							theme_has_css  
						FROM 
							".MF_TABLE_PREFIX."form_themes 
					   WHERE 
					   		theme_id = ?";
			$params = array($form->theme_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			$form_shadow_style 		= $row['form_shadow_style'];
			$form_shadow_size 		= $row['form_shadow_size'];
			$form_shadow_brightness = $row['form_shadow_brightness'];
			$theme_has_css = (int) $row['theme_has_css'];
			
			//if the theme has css file, make sure to refer to that file
			//otherwise, generate the css dynamically
			
			if(!empty($theme_has_css)){
				$theme_css_link = '<link rel="stylesheet" type="text/css" href="'.$machform_path.$mf_settings['data_dir'].'/themes/theme_'.$form->theme_id.'.css" media="all" />';
			}else{
				$theme_css_link = '<link rel="stylesheet" type="text/css" href="'.$machform_path.'css_theme.php?theme_id='.$form->theme_id.'" media="all" />';
			}
			
			if($row['highlight_bg_type'] == 'color'){
				$field_highlight_color = $row['highlight_bg_color'];
			}else{ 
				//if the field highlight is using pattern instead of color, set the color to empty string
				$field_highlight_color = ''; 
			}
			
			//get the css link for the fonts
			$font_css_markup = mf_theme_get_fonts_link($dbh,$form->theme_id);
			
			//get the form shadow classes
			if(!empty($form_shadow_style) && ($form_shadow_style != 'disabled')){
				preg_match_all("/[A-Z]/",$form_shadow_style,$prefix_matches);
				//this regex simply get the capital characters of the shadow style name
				//example: RightPerspectiveShadow result to RPS and then being sliced to RP
				$form_shadow_prefix_code = substr(implode("",$prefix_matches[0]),0,-1);
				
				$form_shadow_size_class  = $form_shadow_prefix_code.ucfirst($form_shadow_size);
				$form_shadow_brightness_class = $form_shadow_prefix_code.ucfirst($form_shadow_brightness);

				if(empty($integration_method)){ //only display shadow if the form is not being embedded using any method
					$form_container_class = $form_shadow_style.' '.$form_shadow_size_class.' '.$form_shadow_brightness_class;
				}
			}
			
			
			
		}else{ //if the form doesn't have any theme being applied
			$field_highlight_color = '#FFF7C0';
			
			if(empty($integration_method)){
				$form_container_class = 'WarpShadow WLarge WNormal'; //default shadow
			}else{
				$form_container_class = ''; //dont show any shadow when the form being embedded
			}
		}
		
		
		if(!empty($_SESSION['mf_form_resume_url'][$form_id])){

			$resume_success_title = $mf_lang['resume_success_title'];
			$resume_success_content = sprintf($mf_lang['resume_success_content'],$_SESSION['mf_form_resume_url'][$form_id]);

			$success_markup = <<<EOT
			<h2>{$resume_success_title}</h2>
			<h3>{$resume_success_content}</h3>
EOT;
		}else{
			$success_markup = "<h2>{$form->success_message}</h2>";		
		}

		if(empty($mf_settings['disable_machform_link'])){
			$powered_by_markup = 'Powered by MachForm';
		}else{
			$powered_by_markup = '';
		}
		
		if($integration_method == 'php'){
			$form_markup = <<<EOT
<link rel="stylesheet" type="text/css" href="data/form_default/css/view.css" media="all" />
{$theme_css_link}
{$font_css_markup}
<style>
html{
	background: none repeat scroll 0 0 transparent;
}
</style>

<div id="main_body" class="integrated">
	<div id="form_container">
		<h1><a>Appnitro MachForm</a></h1>
		<div class="form_success">
			{$success_markup}
		</div>
		<div id="footer" class="success">
			{$powered_by_markup}
		</div>		
	</div>
	
</div>
EOT;

		}else{
	
			if($integration_method == 'iframe'){
				$embed_class = 'class="embed"';
				$auto_height_js =<<<EOT
<script type="text/javascript" src="{$machform_path}js/jquery.min.js"></script>
<script type="text/javascript" src="{$machform_path}js/jquery.ba-postmessage.min.js"></script>
<script type="text/javascript">
    $(function(){
    	$.postMessage({mf_iframe_height: $('body').outerHeight(true)}, '*', parent );
    });
</script>
EOT;
			}else{
				$embed_class = '';
			}
			
			$form_markup = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html {$embed_class} xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$form->name}</title>
<link rel="stylesheet" type="text/css" href="data/form_default/css/view.css" media="all" />
{$theme_css_link}
{$font_css_markup}
{$auto_height_js}
</head>
<body id="main_body">
	
	<img id="top" src="{$machform_path}images/top.png" alt="" />
	<div id="form_container" class="{$form_container_class}">
	
		<h1><a>Appnitro MachForm</a></h1>
			
		<div class="form_success">
			{$success_markup}
		</div>
		<div id="footer" class="success">
			{$powered_by_markup}
		</div>		
	</div>
	<img id="bottom" src="{$machform_path}images/bottom.png" alt="" />
</body>
</html>
EOT;
		}

		return $form_markup;
	}
	
	
	
	//display form confirmation page
	function mf_display_form_review($dbh,$form_id,$record_id,$from_page_num,$form_params=array()){
		global $mf_lang;
		
		if(!empty($form_params['integration_method'])){
			$integration_method = $form_params['integration_method'];
		}else{
			$integration_method = '';
		}

		if(!empty($form_params['machform_path'])){
			$machform_path = $form_params['machform_path'];
		}else{
			$machform_path = '';
		}

		if(!empty($form_params['machform_data_path'])){
			$machform_data_path = $form_params['machform_data_path'];
		}else{
			$machform_data_path = '';
		}

		$mf_settings = mf_get_settings($dbh);
		
		//get form properties data
		$query 	= "select 
						  form_name,
						  form_has_css,
						  form_redirect,
						  form_review_primary_text,
						  form_review_secondary_text,
						  form_review_primary_img,
						  form_review_secondary_img,
						  form_review_use_image,
						  form_review_title,
						  form_review_description,
						  form_page_total,
						  form_lastpage_title,
						  form_pagination_type,
						  form_theme_id,
						  payment_show_total,
						  payment_total_location,
						  payment_enable_merchant,
						  payment_currency,
						  payment_price_type,
						  payment_price_amount
				     from 
				     	 ".MF_TABLE_PREFIX."forms 
				    where 
				    	 form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
	
		
		$form_has_css 			= $row['form_has_css'];
		$form_redirect			= $row['form_redirect'];
		$form_review_primary_text 	 = $row['form_review_primary_text'];
		$form_review_secondary_text  = $row['form_review_secondary_text'];
		$form_review_primary_img 	 = $row['form_review_primary_img'];
		$form_review_secondary_img   = $row['form_review_secondary_img'];
		$form_review_use_image  	 = (int) $row['form_review_use_image'];
		$form_review_title			 = $row['form_review_title'];
		$form_review_description	 = $row['form_review_description'];
		$form_page_total 			 = $row['form_page_total'];
		$form_lastpage_title 		 = $row['form_lastpage_title'];
		$form_pagination_type		 = $row['form_pagination_type'];
		$form_name					 = htmlspecialchars($row['form_name'],ENT_QUOTES);
		$form_theme_id				 = $row['form_theme_id'];

		$payment_show_total	 		 = (int) $row['payment_show_total'];
		$payment_total_location 	 = $row['payment_total_location'];
		$payment_enable_merchant 	 = (int) $row['payment_enable_merchant'];
		if($payment_enable_merchant < 1){
			$payment_enable_merchant = 0;
		}
		$payment_currency 	   		 = $row['payment_currency'];
		$payment_price_type 	     = $row['payment_price_type'];
		$payment_price_amount    	 = $row['payment_price_amount'];
		
		//prepare entry data for previewing
		$param['strip_download_link'] = true;
		$param['review_mode']    	  = true;
		$param['show_attach_image']   = true;
		$param['machform_data_path']   = $machform_data_path;
		$entry_details = mf_get_entry_details($dbh,$form_id,$record_id,$param);
		
		$entry_data = '<table id="machform_review_table" width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>'."\n";
		
		$toggle = false;
		foreach ($entry_details as $data){ 
			if($toggle){
				$toggle = false;
				$row_style = 'class="alt"';
			}else{
				$toggle = true;
				$row_style = '';
			}	

			if($data['label'] == 'mf_page_break' && $data['value'] == 'mf_page_break'){
				$data['label'] = '&nbsp;';
				$data['value'] = '&nbsp;';
				$row_style = '';
			}
			
  			$entry_data .= "<tr {$row_style}>\n";
  	    	$entry_data .= "<td class=\"mf_review_label\" width=\"40%\">{$data['label']}</td>\n";
  			$entry_data .= "<td class=\"mf_review_value\" width=\"60%\">".nl2br($data['value'])."</td>\n";
  			$entry_data .= "</tr>\n";
 		}   	
		 	
   	    $entry_data .= '</tbody></table>';

		//check for specific form css, if any, use it instead
		if($form_has_css){
			$css_dir = $mf_settings['data_dir']."/form_{$form_id}/css/";
		}
		
		if($integration_method == 'iframe'){
			$embed_class = 'class="embed"';
		}
		
		
		//if the form has multiple pages
		//display the pagination header
		if($form_page_total > 1){
			
			//build pagination header based on the selected type. possible values:
			//steps - display multi steps progress
			//percentage - display progress bar with percentage
			//disabled - disabled
			
			$page_breaks_data = array();
			$page_title_array = array();
			
			//get page titles
			$query = "SELECT 
							element_page_title
						FROM 
							".MF_TABLE_PREFIX."form_elements
					   WHERE
							form_id = ? and element_status = 1 and element_type = 'page_break'
					ORDER BY 
					   		element_page_number asc";
			$params = array($form_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			while($row = mf_do_fetch_result($sth)){
				$page_title_array[] = $row['element_page_title'];
			}
			
			if($form_pagination_type == 'steps'){
				
				$page_titles_markup = '';
				
				$i=1;
				foreach ($page_title_array as $page_title){
					$page_titles_markup .= '<td align="center"><span id="page_num_'.$i.'" class="ap_tp_num">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text">'.$page_title.'</span></td><td align="center" class="ap_tp_arrow">&gt;</td>'."\n";
					$i++;
				}
				
				//add the last page title into the pagination header markup
				$page_titles_markup .= '<td align="center"><span id="page_num_'.$i.'" class="ap_tp_num">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text">'.$form_lastpage_title.'</span></td>';
			
				$i++;
				$page_titles_markup .= '<td align="center" class="ap_tp_arrow">&gt;</td><td align="center"><span id="page_num_'.$i.'" class="ap_tp_num ap_tp_num_active">'.$i.'</span><span id="page_title_'.$i.'" class="ap_tp_text ap_tp_text_active">'.$form_review_title.'</span></td>';
				
				
				$pagination_header =<<<EOT
			<ul>
			<li id="pagination_header" class="li_pagination">
			 <table class="ap_table_pagination" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
			  	{$page_titles_markup}
			  </tr>
			</table>
			</li>
			</ul>
EOT;
			}else if($form_pagination_type == 'percentage'){
				
				$page_total = count($page_title_array) + 2;
				$percent_value = 99;
				
				$page_number_title = sprintf($mf_lang['page_title'],$page_total,$page_total);
				$pagination_header =<<<EOT
			<ul>
				<li id="pagination_header" class="li_pagination" title="Click to edit">
			    <h3 id="page_title_{$page_total}">{$page_number_title}</h3>
				<div class="mf_progress_container">          
			    	<div id="mf_progress_percentage" class="mf_progress_value" style="width: {$percent_value}%"><span>{$percent_value}%</span></div>
				</div>
				</li>
			</ul>
EOT;
			}else{			
				$pagination_header = '';
			}
			
		}




		
		//build the button markup (image or text)
		if(!empty($form_review_use_image)){
			$button_markup =<<<EOT
<input id="review_submit" class="submit_img_primary" type="image" name="review_submit" alt="{$form_review_primary_text}" src="{$form_review_primary_img}" />
<input id="review_back" class="submit_img_secondary" type="image" name="review_back" alt="{$form_review_secondary_text}" src="{$form_review_secondary_img}" />
EOT;
		}else{
			$button_markup =<<<EOT
<input id="review_submit" class="button_text btn_primary" type="submit" name="review_submit" value="{$form_review_primary_text}" />
<input id="review_back" class="button_text btn_secondary" type="submit" name="review_back" value="{$form_review_secondary_text}" />
EOT;
		}

		//if this form is using custom theme
		if(!empty($form_theme_id)){
			//get the field highlight color for the particular theme
			$query = "SELECT 
							highlight_bg_type,
							highlight_bg_color,
							form_shadow_style,
							form_shadow_size,
							form_shadow_brightness,
							form_button_type,
							form_button_text,
							form_button_image,
							theme_has_css  
						FROM 
							".MF_TABLE_PREFIX."form_themes 
					   WHERE 
					   		theme_id = ?";
			$params = array($form_theme_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			$form_shadow_style 		= $row['form_shadow_style'];
			$form_shadow_size 		= $row['form_shadow_size'];
			$form_shadow_brightness = $row['form_shadow_brightness'];
			$theme_has_css = (int) $row['theme_has_css'];
			
			//if the theme has css file, make sure to refer to that file
			//otherwise, generate the css dynamically
			
			if(!empty($theme_has_css)){
				$theme_css_link = '<link rel="stylesheet" type="text/css" href="'.$machform_path.$mf_settings['data_dir'].'/themes/theme_'.$form_theme_id.'.css" media="all" />';
			}else{
				$theme_css_link = '<link rel="stylesheet" type="text/css" href="'.$machform_path.'css_theme.php?theme_id='.$form_theme_id.'" media="all" />';
			}
			
			if($row['highlight_bg_type'] == 'color'){
				$field_highlight_color = $row['highlight_bg_color'];
			}else{ 
				//if the field highlight is using pattern instead of color, set the color to empty string
				$field_highlight_color = ''; 
			}
			
			//get the css link for the fonts
			$font_css_markup = mf_theme_get_fonts_link($dbh,$form_theme_id);
			
			//get the form shadow classes
			if(!empty($form_shadow_style) && ($form_shadow_style != 'disabled')){
				preg_match_all("/[A-Z]/",$form_shadow_style,$prefix_matches);
				//this regex simply get the capital characters of the shadow style name
				//example: RightPerspectiveShadow result to RPS and then being sliced to RP
				$form_shadow_prefix_code = substr(implode("",$prefix_matches[0]),0,-1);
				
				$form_shadow_size_class  = $form_shadow_prefix_code.ucfirst($form_shadow_size);
				$form_shadow_brightness_class = $form_shadow_prefix_code.ucfirst($form_shadow_brightness);

				if(empty($integration_method)){ //only display shadow if the form is not being embedded using any method
					$form_container_class = $form_shadow_style.' '.$form_shadow_size_class.' '.$form_shadow_brightness_class;
				}
			}
			
			
			
		}else{ //if the form doesn't have any theme being applied
			$field_highlight_color = '#FFF7C0';
			
			if(empty($integration_method)){
				$form_container_class = 'WarpShadow WLarge WNormal'; //default shadow
			}else{
				$form_container_class = ''; //dont show any shadow when the form being embedded
			}
		}

		//if the form has enabled merchant support and set the total payment to be displayed
		if(!empty($payment_enable_merchant) && !empty($payment_show_total)){
			
			$currency_symbol = '&#36;';
			
			switch($payment_currency){
				case 'USD' : $currency_symbol = '&#36;';break;
				case 'EUR' : $currency_symbol = '&#8364;';break;
				case 'GBP' : $currency_symbol = '&#163;';break;
				case 'AUD' : $currency_symbol = 'A&#36;';break;
				case 'CAD' : $currency_symbol = 'C&#36;';break;
				case 'JPY' : $currency_symbol = '&#165;';break;
				case 'THB' : $currency_symbol = '&#3647;';break;
				case 'HUF' : $currency_symbol = '&#70;&#116;';break;
				case 'CHF' : $currency_symbol = 'CHF';break;
				case 'CZK' : $currency_symbol = '&#75;&#269;';break;
				case 'SEK' : $currency_symbol = 'kr';break;
				case 'DKK' : $currency_symbol = 'kr';break;
				case 'PHP' : $currency_symbol = '&#36;';break;
				case 'MYR' : $currency_symbol = 'RM';break;
				case 'PLN' : $currency_symbol = '&#122;&#322;';break;
				case 'BRL' : $currency_symbol = 'R&#36;';break;
				case 'HKD' : $currency_symbol = 'HK&#36;';break;
				case 'MXN' : $currency_symbol = 'Mex&#36;';break;
				case 'TWD' : $currency_symbol = 'NT&#36;';break;
				case 'TRY' : $currency_symbol = 'TL';break;
			}
		
			if($payment_total_location == 'review' || $payment_total_location == 'all'){
				$session_id = session_id();

				if($payment_price_type == 'variable'){
					$total_payment = (double) mf_get_payment_total($dbh,$form_id,$session_id,0);
				}elseif ($payment_price_type == 'fixed') {
					$total_payment = $payment_price_amount;
				}

				$payment_total_markup = <<<EOT
				<li class="total_payment mf_review">
					<span>
						<h3>{$currency_symbol}<var>{$total_payment}</var></h3>
						<h5>{$mf_lang['payment_total']}</h5>
					</span>
				</li>
EOT;
			}
		}
		
		if(empty($mf_settings['disable_machform_link'])){
			$powered_by_markup = 'Powered by MachForm';
		}else{
			$powered_by_markup = '';
		}


		$self_address = htmlentities($_SERVER['PHP_SELF']); //prevent XSS

		if($integration_method == 'php'){

			$form_markup = <<<EOT
<link rel="stylesheet" type="text/css" href="data/form_default/css/view.css" media="all" />
{$theme_css_link}
{$font_css_markup}
<style>
html{
	background: none repeat scroll 0 0 transparent;
}
</style>

<div id="main_body" class="integrated">
	<div id="form_container">
		<form id="form_{$form->id}" class="appnitro" method="post" action="{$self_address}">
		    <div class="form_description">
				<h2>{$form_review_title}</h2>
				<p>{$form_review_description}</p>
			</div>
			{$pagination_header}
			{$entry_data}
			<ul>
			{$payment_total_markup}
			<li id="li_buttons" class="buttons">
			    <input type="hidden" name="id" value="{$form_id}" />
			    <input type="hidden" name="mf_page_from" value="{$from_page_num}" />
			    {$button_markup}
			</li>
			</ul>
		</form>		
	</div>
</div>
EOT;
		}else{

			if($integration_method == 'iframe'){
				$auto_height_js =<<<EOT
<script type="text/javascript" src="{$machform_path}js/jquery.min.js"></script>
<script type="text/javascript" src="{$machform_path}js/jquery.ba-postmessage.min.js"></script>
<script type="text/javascript">
    $(function(){
    	$.postMessage({mf_iframe_height: $('body').outerHeight(true)}, '*', parent );
    });
</script>
EOT;
			}

			$form_markup = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html {$embed_class} xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$form_name}</title>
<link rel="stylesheet" type="text/css" href="data/form_default/css/view.css" media="all" />
{$theme_css_link}
{$font_css_markup}
{$auto_height_js}
</head>
<body id="main_body">
	
	<img id="top" src="{$machform_path}images/top.png" alt="" />
	<div id="form_container" class="{$form_container_class}">
	
		<h1><a>MachForm</a></h1>
		<form id="form_{$form_id}" class="appnitro" method="post" action="{$self_address}">
		    <div class="form_description">
				<h2>{$form_review_title}</h2>
				<p>{$form_review_description}</p>
			</div>
			{$pagination_header}
			{$entry_data}
			<ul>
			{$payment_total_markup}
			<li id="li_buttons" class="buttons">
			    <input type="hidden" name="id" value="{$form_id}" />
			    <input type="hidden" name="mf_page_from" value="{$from_page_num}" />
			    {$button_markup}
			</li>
			</ul>
		</form>		
			
	</div>
	<img id="bottom" src="{$machform_path}images/bottom.png" alt="" />
	</body>
</html>
EOT;
		}

		return $form_markup;
	}
	
?>