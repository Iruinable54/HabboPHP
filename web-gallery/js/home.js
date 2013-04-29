$(function() {
  $('.modal').nyroModal();
});

jQuery(document).ready(function(){
	var limite=0;
});

function load() {
	$('#close-edit').show();$('#edit-button').show();$('.edit-button').show();
	$( ".movable").draggable({ containment: "#playground" });
	//$( ".menu").draggable({ containment: "#playground" });
	$('.movable').mouseover(function(){
	var position = $(this).position();
	$('.p').html('Left :'+position.left+' Top :'+position.top+' ID : '+$(this).attr('id'));
	$('.widget').val(position.left);
	});
		
	$('.menu').mouseover(function(){
		var position = $(this).position();
		$('.p').html('Left :'+position.left+' Top :'+position.top+' ID : '+$(this).attr('id'));
		$('.widget').val(position.left);
	});

	$( ".movable" ).bind( "dragstop", function(event, ui) {
		$(this).css("z-index",parseInt($(this).css('z-index'))+1);
		var x=$(this).css('left'); //left
		var y=$(this).css('top'); //top
		var z=$(this).css('z-index'); //z-index
		var id=$(this).attr('rel'); //id
		var type=$(this).attr('wtype');
		var wid=$(this).attr('wid');
		var token = $('#token').val();
		$.get('ajax/hp_updatestyle.php?x='+x+'&y='+y+'&z='+z+'&id='+id+'&type='+type+'&wid='+wid+'&token='+token+'', function(data) {  updated(); });
	});
	
	$(".movable").click(function() {
		$(this).css("z-index",parseInt($(this).css('z-index'))+1);
		var x=$(this).css('left'); //left
		var y=$(this).css('top'); //top
		var z=$(this).css('z-index'); //z-index
		var id=$(this).attr('rel'); //id
		var type=$(this).attr('wtype');
		var wid=$(this).attr('wid');
		var token = $('#token').val();
		$.get('ajax/hp_updatestyle.php?x='+x+'&y='+y+'&z='+z+'&id='+id+'&type='+type+'&wid='+wid+'&token='+token, function(data) {  updated(); });
	});
}

$(function(){
	//load();
});

function updated() {
	$('#updated').fadeIn('fast');
	setTimeout("$('#updated').fadeOut('fast')",1000);
}

function addnewwidget(value,type,color) {
	var token = $('#token').val();
	$.get('ajax/hp_add.php?value='+value+'&type='+type+'&color='+color+'&token='+token, function(data) { 
		$('#newwidget').append(data);
		updated();
		$.nmTop().close();
	});
	setTimeout('load();',500);
}

function deletewidget(id,type) {
	var token = $('#token').val();
	$.get('ajax/hp_delete.php?id='+id+'&type='+type+'&token='+token, function(data) { 
		$('#note-'+id+'').fadeOut(); 
		$('#image-'+id+'').fadeOut(); 
		$('#widget-'+id+'').fadeOut(); 
		updated(); 
	//	alert(id);
	});
}

function hidewidget(id,type) {
	var token = $('#token').val();
	$.get('ajax/hp_hide.php?id='+id+'&type='+type+'&token='+token, function(data) { 
		$('#widget-'+type+'-'+id+'').fadeOut(); 
		//alert(data) ;
		updated(); 
	});
}

function updatebg(classe) {
	var token = $('#token').val();
	$.get('ajax/hp_updatebg.php?class='+classe+'&token='+token, function(data) { 
		//alert(data);
		$('#playground').removeClass(); 
		$('#playground').addClass(classe); 
		updated(); 
	});
}

function showwidget(id,type) {
	var token = $('#token').val();
	$.get('ajax/hp_show.php?id='+id+'&type='+type+'&token='+token, function(data) { 
		$('#widget-'+type+'-'+id+'').removeClass('class0');
		$('#widget-'+type+'-'+id+'').addClass('class1');  
		$('#widget-'+type+'-'+id+'').fadeIn(); 
		$.nmTop().close();
		updated(); 
	});
}

function classwidget(id,type,design) {
	var token = $('#token').val();
	$.get('ajax/hp_updateclass.php?id='+id+'&type='+type+'&design='+design+'&token='+token, function(data) { 
		$('#widget-'+type+'-'+id+'').fadeOut('slow',function() { 
			$('#cwidget-'+type+'-'+id+'').removeClass("w_skin_speechbubbleskin");
			$('#cwidget-'+type+'-'+id+'').removeClass("w_skin_notepadskin");
			$('#cwidget-'+type+'-'+id+'').removeClass("w_skin_goldenskin");
			$('#cwidget-'+type+'-'+id+'').removeClass("w_skin_defaultskin");
			$('#cwidget-'+type+'-'+id+'').removeClass("w_skin_metalskin");
			$('#cwidget-'+type+'-'+id+'').removeClass("w_skin_noteitskin");
			$('#cwidget-'+type+'-'+id+'').addClass(design);
			$('#edit-'+type+'-'+id+'').hide();
			setTimeout("$('#widget-"+type+"-"+id+"').fadeIn();",1000);
		updated(); 
		});
	});
}

function addbook(value,to) {
	var token = $('#token').val();
	$.get('ajax/hp_add_book.php?value='+value+'&to='+to+'&token='+token, function(data) { 
		$('#newbook').append(data);
		$('#newbook').slideDown();
		$('#txtbook').slideUp();
		updated();
		$.nmTop().close();
	});
}

function removebook(id) {
	var token = $('#token').val();
	$.get('ajax/hp_remove_book.php?id='+id+'&token='+token, function(data) { 
		$('#bookm-'+id+'').slideUp();
		updated();
		$.nmTop().close();
	});
}

jQuery(document).ready(function(){
	
	function showLoader(){
	
		jQuery('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		jQuery('.search-background').fadeOut(200);
	};
	
	jQuery("#paging_button_stickers div").click(function(){
		
		showLoader();
		
		jQuery("#paging_button_stickers div").css({'background-color' : ''});
		jQuery(this).css({'background-color' : '#CCC'});
		var token = $('#token').val();
		jQuery("#contentstickers").load("ajax/hp_stickers.php?page=" +this.id+'&token='+token, hideLoader);
		
		return false;
	});
	
	jQuery("#1").css({'background-color' : '#CCC'});
	showLoader();
	var token = $('#token').val();
	jQuery("#contentstickers").load("ajax/hp_stickers.php?page=1&token="+token, hideLoader);
	
});




jQuery(document).ready(function(){
	
	function showLoader(){
	
		jQuery('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		jQuery('.search-background').fadeOut(200);
	};
	
	jQuery("#paging_button_bg div").click(function(){
		
		showLoader();
		
		jQuery("#paging_button_bg div").css({'background-color' : ''});
		jQuery(this).css({'background-color' : '#CCC'});
		var token = $('#token').val();
		jQuery("#contentbg").load("ajax/hp_bg.php?page=" + this.id+'&token='+token, hideLoader);
		
		return false;
	});
	
	jQuery("#bg1").css({'background-color' : '#CCC'});
	showLoader();
	var token = $('#token').val();
	jQuery("#contentbg").load("ajax/hp_bg.php?page=bg1&token="+token, hideLoader);
	
});

var isMozilla = (navigator.userAgent.toLowerCase().indexOf('gecko')!=-1) ? true : false;
var regexp = new RegExp("[\r]","gi");

function storeCaret(selec)
{
	if (isMozilla) 
	{
	// Si on est sur Mozilla

		oField = document.forms['notess'].elements['notesst'];

		objectValue = oField.value;

		deb = oField.selectionStart;
		fin = oField.selectionEnd;

		objectValueDeb = objectValue.substring( 0 , oField.selectionStart );
		objectValueFin = objectValue.substring( oField.selectionEnd , oField.textLength );
		objectSelected = objectValue.substring( oField.selectionStart ,oField.selectionEnd );

	//	alert("Debut:'"+objectValueDeb+"' ("+deb+")\nFin:'"+objectValueFin+"' ("+fin+")\n\nSelectionné:'"+objectSelected+"'("+(fin-deb)+")");
			
		oField.value = objectValueDeb + "[" + selec + "]" + objectSelected + "[/" + selec + "]" + objectValueFin;
		oField.selectionStart = strlen(objectValueDeb);
		oField.selectionEnd = strlen(objectValueDeb + "[" + selec + "]" + objectSelected + "[/" + selec + "]");
		oField.focus();
		oField.setSelectionRange(
			objectValueDeb.length + selec.length + 2,
			objectValueDeb.length + selec.length + 2);
	}
	else
	{
	// Si on est sur IE
		
		oField = document.forms['notess'].elements['notesst'];
		var str = document.selection.createRange().text;

		if (str.length>0)
		{
		// Si on a selectionné du texte
			var sel = document.selection.createRange();
			sel.text = "[" + selec + "]" + str + "[/" + selec + "]";
			sel.collapse();
			sel.select();
		}
		else
		{
			oField.focus(oField.caretPos);
		//	alert(oField.caretPos+"\n"+oField.value.length+"\n")
			oField.focus(oField.value.length);
			oField.caretPos = document.selection.createRange().duplicate();
			
			var bidon = "%~%";
			var orig = oField.value;
			oField.caretPos.text = bidon;
			var i = oField.value.search(bidon);
			oField.value = orig.substr(0,i) + "[" + selec + "][/" + selec + "]" + orig.substr(i, oField.value.length);
			var r = 0;
			for(n = 0; n < i; n++)
			{if(regexp.test(oField.value.substr(n,2)) == true){r++;}};
			pos = i + 2 + selec.length - r;
			//placer(document.forms['notess'].elements['notesst'], pos);
			var r = oField.createTextRange();
			r.moveStart('character', pos);
			r.collapse();
			r.select();

		}
	}
}


(function($){$.fn.replaceText=function(b,a,c){return this.each(function(){var f=this.firstChild,g,e,d=[];if(f){do{if(f.nodeType===3){g=f.nodeValue;e=g.replace(b,a);if(e!==g){if(!c&&/</.test(e)){$(f).before(e);d.push(f)}else{f.nodeValue=e}}}}while(f=f.nextSibling)}d.length&&$(d).remove()})}})(jQuery);


function submitenter(myfield,e) {
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   var neew = $('#notesst').val()+'[br]\n';
   $('#notesst').val(neew);
   
   var neeew = $('.valuedemonote').html()+'<br>';
   $('.valuedemonote').html(neeew);
   
   return false;
   }
else
   return true;
}