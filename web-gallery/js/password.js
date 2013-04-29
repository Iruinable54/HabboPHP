jQuery(document).ready(function(){
	jQuery('#change-password-submit-button').click(function(){
       		var mail = jQuery('#change-password-email-address2').val();
       		var token = jQuery('#token').val();
			
       		jQuery.get('ajax/password_forgotten.php?mail='+mail+'&token='+token,function(data){
       			console.log(data);
       			if(data == 'ok'){
       				jQuery('#forgotten-pw-form ,#change-password-submit-button').slideUp();
       				jQuery('#change-password-email-sent-notice').delay(300).slideDown('slow');
       				jQuery('#email-sent-container').html(mail);
       			}
       			if(data == 'no'){
       				jQuery('#change-password-error-container').show();
       			}
       			if(data == 'errormail'){
       				jQuery('.errorMail').show();
       			}
       		});
   });
   jQuery('#change-password-cancel-link ,#change-password-success-button').click(function(){
  	 jQuery('#change-password-form').hide(); 
  	 jQuery('#overlay').hide(); 
  	 jQuery('body').css({ opacity: 1 });	
   });
});