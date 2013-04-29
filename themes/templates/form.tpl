
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
   				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 
			    
				<div class="habblet-container" id="okt" style="float:left; width: 770px;">		
										<div class="cbb clearfix blue ">
	

							<div style="padding-left:30px;padding-right:30px;padding-top:15px;padding-bottom:15px;">
							<div id="loader"><center><img src="images/load.gif" alt="" /><br />Chargement</center></div>
<iframe src="{$config->url_site}/admin/form/view.php?id={$formid}" id="iframeform" width="695" scrolling="no" frameborder="0" style="border:0;opacity:0;display:none;" onload="resizer();"></iframe>
<br style="clear:both"/>
					</div>
</div>
		
				
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>



</div>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
{literal}
<script type='text/javascript'>

    jQuery(function(){

        var iFrames = jQuery('#iframeform');
	
    	function iResize() {

    		for (var i = 0, j = iFrames.length; i < j; i++) {
    		  iFrames[i].style.height = iFrames[i].contentWindow.document.body.offsetHeight + 'px';}
    	    }
		function resizer(){
		if ($.browser.safari || $.browser.opera) { 

        	   iFrames.load(function(){
        	       setTimeout(iResize, 0);
               });

        	   for (var i = 0, j = iFrames.length; i < j; i++) {
        			var iSource = iFrames[i].src;
        			iFrames[i].src = '';
        			iFrames[i].src = iSource;
               }

        	} else {
        	   iFrames.load(function() {
        	       this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
        	   });
        	}
		}
        	resizer();
        	//setInterval(resizer,4000);
			
        });
        
        function resizer2(){
         var iFrames = jQuery('#iframeform');
		if ($.browser.safari || $.browser.opera) { 

        	   iFrames.load(function(){
        	       setTimeout(iResize, 0);
               });

        	   for (var i = 0, j = iFrames.length; i < j; i++) {
        			var iSource = iFrames[i].src;
        			iFrames[i].src = '';
        			iFrames[i].src = iSource;
               }

        	} else {
        	   iFrames.load(function() {
        	       this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
        	   });
        	}
		}
        
        setTimeout("jQuery('#loader').animate({opacity:0}).slideUp();jQuery('#iframeform').slideDown().animate({opacity:1});",2000);
		
</script>
{/literal}
