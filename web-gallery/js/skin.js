jQuery(function() {
	jQuery('#more-avatars').click(function(){
		jQuery.get('ajax/figure.php',function(data){
			jQuery('.figure').html(data);
		});
	});
	jQuery.get('ajax/figure.php',function(data){
			jQuery('.figure').html(data);
	});
	
});

function changeAvatar(alt,id){
	jQuery('#avatarFigure').val(alt);
	jQuery('.liFigure').removeClass('selected');
	jQuery('#'+id).addClass('selected');
}