	<style>  
	input[type="text"], input[type="password"] {  
	  background-color: #F1F1F1;  
	  border: 1px solid #999999;  
	  width: 175px;  
	  padding: 5px;  
	  font-family: verdana;  
	  font-size: 10px;  
	  color: #666666;  
	}  
	input[type="submit"] {  
	  background-color: #F1F1F1;  
	  border: 1px solid #999999;  
	  padding: 5px;  
	  font-family: verdana;  
	  font-size: 10px;  
	  color: #666666;  
	}  
	textarea {  
	  background-color: #F1F1F1;  
	  border: 1px solid #999999;  
	  padding: 5px;  
	  width: 517px;  
	  height: 70px;  
	  font-family: verdana;  
	  font-size: 10px;  
	  color: #666666;  
	}  
	select {  
	  background-color: #F1F1F1;  
	  border: 1px solid #999999;  
	  padding: 5px;  
	  font-family: verdana;  
	  font-size: 10px;  
	  color: #666666 ;  
	}  
	</style> 
	
	<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div>

<div class="content">
<div class="habblet-container" style="float:left; width:210px;">
<div class="cbb settings">

<h2 class="title">{#Events#}</h2>
<div class="box-content">
            <div id="settingsNavigation">
            <ul>
            {section name=customer loop=$menu}
               	<li style="margin-top:5px"><a href="{$config->url_site}/events.php?id={$menu[customer].id}">{$menu[customer].title}</a></li>
            {/section}
            </ul>
            </div>
</div></div>
</div>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix">

            <h2 class="title" >{$title}</h2>
            <div class="box-content">
            
			{$content}

</div>
</div>

{if $comments_type eq 'normal' && $displayComment eq '1'}

<div class="cbb clearfix green">
	<h2 class="title" id="post">Poster un commentaire</h2>
        <div class="box-content">
      	{if isset($success)}
			<font color="green"><b>Commentaire envoy&eacute; !</b></font><br><br />
		{/if} 
		{if isset($error)}
			<font color="red"><b>Veuillez attendre 1 minute avant de reposter !</b></font><br />
		{/if}
       
	<form action="#post" method="post">  
        <center>
       	 <textarea name="comment" maxlength="500" style="width: 505px;"></textarea>
        </center><br /><br />
        	<input type="submit" name="post_comment" value="Envoyer !" style="float: right; position: relative; margin-top: -18px;"/>  
        </form> 
	</div>
</div>
	        
	<div class="cbb clearfix blue">
	<h2 class="title" >Commentaire{if isset($s)}{$s}{/if}({if isset($number)}{$number}{/if})</h2>
	<div class="box-content">
		<table width="100%">
		{if $news_existe eq 'true'}
		{if isset($commentsData)}
		 {section name=customer loop=$commentsData}
		 <tr>  
			<td width="90px" valign="top"> <br/> 
				<div style="float:left"><img src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure={$commentsData[customer].look}&size=s&direction=2&head_direction=2&gesture=sml"></div>  
						</td>  
							<td width="427px" valign="top">  
							  <u>Commentaire: {$title}</u>
							 {if $user->rank gt '4'}
							  <a href="events.php?id={$news_id}&amp;delete={$commentsData[customer].id}#post" style="float: right;" title="Supprimer"><font color="red"><b>X</b></font></a>
							 {/if} 
							  <br /><br /><div style="width: 422px; word-wrap: break-word;">{$commentsData[customer].comment}</div>
							</td>  
						  </tr>  
				  <tr>  
							<td width="0px" valign="top">  
							</td>  
					<td width="70px" align="right">  
					  <i style="margin-top: -20px; position: relative; ">Post&eacute; par <strong><a href="home.php?username={$commentsData[customer].username}">{$commentsData[customer].username}</a></strong></i><hr color="#FFFFFF" style="border-bottom: 1px dashed #666;" />
					</td>  
				  </tr>
				 {/section} 
				{/if}
			{else}
			<div class="cbb clearfix">
				<h2 class="title" >Commentaires</h2>
     			   <div class="box-content">
						Les commentaires sont d&eacute;sactiv&eacute;s pour cet articles !
					</div>
			</div>
		{/if}
		</table>
	</div>


{/if}

{if $comments_type eq 'facebook'}
<div class="habblet-container " style="float:left; width: 560px;">
	<div class="cbb clearfix">
    	<h2 class="title" >Commentaires</h2>
            <div class="box-content">
            <br /><br />
            	<div style="border-top:1px solid #ddd;"></div><br /><div id="fb-root"></div>
					<script>(function(d, s, id) {
				 	 var js, fjs = d.getElementsByTagName(s)[0];
				 	 if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
				 	 js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=110031495788439";
				 	 fjs.parentNode.insertBefore(js, fjs);
					}(document, "script", "facebook-jssdk"));</script>
					<div class="fb-comments" data-href="{$config->url_site}/events.php?id={$news_id}" data-num-posts="10" data-width="515">
					</div>
			</div>
	</div>
</div>
{/if}


</div>
</div>
</div>