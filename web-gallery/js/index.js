function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

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
   
   jQuery('#register-new-use').submit(function(){
   
  
  
	  var pseudo = jQuery('#registration-pseudo');
	  var pwd = jQuery('#registration-password');
	  var email = jQuery('#registration-email');
	  var rec = jQuery('#recaptcha_response_field');
	  var recaptcha_response_field = jQuery("#recaptcha_response_field");
	  var recaptcha_challenge_field = jQuery("#recaptcha_challenge_field");
	  	  
	  var reg = new RegExp('^[a-z0-9\-]*$','i');
	  	 
	  if(pseudo.val() == ''){
		  pseudo.addClass('error');
		   $('#error-pseudo').show();
		   $('#error-pseudo').html('Tu dois donner un pseudo.');
		  return false;
	  }else if(pseudo.val().length < 3){
		  pseudo.addClass('error');
		   $('#error-pseudo').show();
		   $('#error-pseudo').html('Ton pseudo doit faire plus de 3 caractères.');
		  return false; 
	  }else if(!reg.test(pseudo.val())){
		pseudo.addClass('error');  
		   $('#error-pseudo').show();
		   $('#error-pseudo').html('Ton pseudo ne peut contenir que des lettres, nombres et -.');
		   return false;
	  }
	   else{
		  pseudo.removeClass('error'); 
		     $('#error-pseudo').hide(); 
	  }
	  
	  Recaptcha.reload();
	
	  
	  if(pwd.val() == ''){
		  pwd.addClass('error');
		  $('#error-pwd').show();
		  $('#error-pwd').html('Pas de mot de passe ?');
		  return false;
	  } else if(pwd.val().length < 5){
		   $('#error-pwd').show();
		   $('#error-pwd').html('Ton mot de passe doit faire plus de 6 caractères.');
		    pwd.addClass('error');
		   return false; 
	  }
	  else{
		   pwd.removeClass('error'); 
		   $('#error-pwd').hide(); 
	  }
	  
	  var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	  if(email.val() == ''){
		  email.addClass('error');
		   $('#error-email').show();
		   $('#error-email').html('Il faut un email.');
		  return false;
	  }
	  else if(!reg.test(email.val())){
		   email.addClass('error');
		   $('#error-email').show();
		   $('#error-email').html('Il faut un email valide.');
		  return false;
	  }else{
		  email.removeClass('error');
		   $('#error-email').hide();
	  }
	  
	  jQuery.post('ajax/register.php',{
	  pseudo:pseudo.val(),
	  password:pwd.val(),
	  email:email.val(),
	  recaptcha_challenge_field:recaptcha_challenge_field.val(),
	  recaptcha_response_field:recaptcha_response_field.val()}
	  ,function(dataForm){
		 if(dataForm.pseudo){
			 $('#error-pseudo').show();
			$('#error-pseudo').html(dataForm.pseudo);
		}
		if(dataForm.email){
			 $('#error-email').show();
			 $('#error-email').html(dataForm.email);
		 }
		 if(dataForm.c){
			 $('#error-c').show();
			 $('#error-c').html(dataForm.c);
		 }
		 else{
			 $('#error-c').hide(); 
		 }
		 
		 if(dataForm.fini == 'yep'){
		 	 setCookie('Auth',dataForm.Auth,'3600');
		     window.location = 'me.php';
		 }
		 
		 console.log(dataForm); 
	  },'json');
	  
	  return false;
		  
   });
});


