function updateVIP(){
	jQuery('#valideok').slideUp();
	var expire = jQuery('#hidden').val();
	var token = jQuery("#token").val();
	jQuery.post('ajax/updatevip.php',{ expire:expire,token:token },function(data){
		if(data == 'nomoney'){
			window.location='shop.php?nomoney';
		}
		if(data == 'errorMois'){
			alert("Vous ne pouvez pas vous abonner pour 0 mois.");
		}
		if(data == '11'){
			jQuery('#valideok').html('Félicitation, vous êtes VIP pour '+expire+' mois !');
			jQuery('#valideok').slideDown('fast',function(){ jQuery('#valideok').animate({opacity:1}); });
		}
		if(data == 'errorRank')
			alert('Votre rank ne vous permet pas de devenir VIP.');
	});
}

function useVoucher(voucher){
	var voucher = jQuery('#voucher').val();
	var token = jQuery('#token').val();
	if(voucher == ""){ alert('Remplissez le code') ;return false ;}
	jQuery.post('ajax/voucher.php',{voucher:voucher,token:token},function(data){
		if(data == 1){
			alert('Votre code est valide.')
			window.location='shop.php';
		}
		else{
			alert('Votre code n\'est plus valide.');
		}
	});	
}