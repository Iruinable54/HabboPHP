<style>
label{
	width: 150px;
	float:left;
}
.ssh {
float:left;
width:100px;
-moz-border-radius:5px;
-webkit-border-radius:5px;
margin-left:10px;
border-radius:5px;
text-align:center;
border:3px solid #000;
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top, #ffffff 0%, #f1f1f1 50%, #e1e1e1 51%, #f6f6f6 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#f1f1f1), color-stop(51%,#e1e1e1), color-stop(100%,#f6f6f6)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* IE10+ */
background: linear-gradient(top, #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0 ); /* IE6-9 */
}
.ssh:hover {
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top, #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#f3f3f3), color-stop(51%,#ededed), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* IE10+ */
background: linear-gradient(top, #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
.r7 {

}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>
<script>
jQuery.noConflict();
</script>
<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div>


    <div class="habblet-container " style="float:left; width: 770px;">
        <div class="cbb clearfix settings">
        
			
			{foreach from=$rank key=k item=i}
				<h2 class="title">{$i.Nom}</h2>
				 <div class="box-content">
				{foreach from=$user_info key=key item=item}
				{if $item.rank eq $i.Rank}
				
				<script type="text/javascript">
				function slideSwitch{$item.id}() {
				    var $active = jQuery("#slideshow{$item.id} IMG.active");
				
				    if ( $active.length == 0 ) $active = jQuery("#slideshow{$item.id} IMG:last");
				
				    var $next =  $active.next().length ? $active.next()
				        : jQuery("#slideshow{$item.id} IMG:first");
				
				    $active.addClass("last-active");
				
				    $next.addClass("active");
				   	$active.removeClass("active last-active");
				}
				
				jQuery(function(){
				setInterval( "slideSwitch{$item.id}()", 200 );
				});
				</script>
				<style>
				#slideshow{$item.id} {
				    position:relative;
				    height:97px;
				    width:100px;
				}
				
				#slideshow{$item.id} IMG {
				    position:absolute;
				    top:0;
				    left:0;
				    z-index:8;
				    opacity:0;
				     width:100px;
				}
				
				#slideshow{$item.id} IMG.active {
				    z-index:10;
				    opacity:1;
					float: center;
					margin-left: 18px;
				    height:110px;
				    width:64px;
				}
				
				#slideshow{$item.id} IMG.last-active {
				    z-index:9;
				    opacity:0;
				} 
				</style>
				
				<script type="text/javascript">
				jQuery(document).ready(function() 
				{
				      jQuery("#tt{$item.id}").qtip({
				         content: "<div style=\'text-align:center;background:{$i.Couleur};color:white;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;padding:7px;\'><b>{$i.Nom}</b></div>{$item.motto|escape}",
				         position: {
				      		corner: {
				       		  tooltip: "leftMiddle",
				       		  target: "rightMiddle"
				     		}
				  		 }
				      });
				});
				</script>
								
					
					 <a href="home.php?username={$item.username}" style="color:black;"><div style="width:100px" class="ssh" id="tt{$item.id}" onmouseover="jQuery('#one{$item.id}').hide();jQuery('#slideshow{$item.id}').show();" onmouseout="jQuery('#slideshow{$item.id}').hide();jQuery('#one{$item.id}').show();">
<div id="slideshow{$item.id}" style="display:none;">
<img id="f1" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=0&head_direction=0&gesture=std&size=l&img_format=gif" class="active" />
<img id="f2" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=1&head_direction=1&gesture=std&size=l&img_format=gif" />
<img id="f3" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=2&head_direction=2&gesture=std&size=l&img_format=gif" />
<img id="f4" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=3&head_direction=3&gesture=std&size=l&img_format=gif" />
<img if="f5" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=4&head_direction=4&gesture=std&size=l&img_format=gif" />
<img id="f6" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=5&head_direction=5&gesture=std&size=l&img_format=gif" />
<img id="f7" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=6&head_direction=6&gesture=std&size=l&img_format=gif" />
<img id="f8" src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=7&head_direction=7&gesture=std&size=l&img_format=gif" />
</div>
<img src="http://www.habbr.info/habbo-imaging/avatarimage?figure={$item.look}&direction=3&head_direction=3&gesture=std&size=l&img_format=gif" id="one{$item.id}" /><br/>
<b style="width:60px;word-wrap: break-word;">{$item.username}</b><br /><br/></div></a>
					 
				
					{/if}
				{/foreach}
					<div style="clear:both;"></div>
				 </div>
			{/foreach}
			
			
			</div>
	</div>
</div>
</div>
