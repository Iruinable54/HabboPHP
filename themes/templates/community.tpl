<div id="container">
	<div id="content" style="position: relative;" class="clearfix">
{section name=customer loop=$news}

	 {if $smarty.section.customer.first}
<div id="promo-box">

    <div id="promo-bullets"></div>

    <div class="promo-container" style="background-image: url({$news[customer].image})">
        <div class="promo-content">
            <div class="title">{$news[customer].title}</div>
            <div class="body">{$news[customer].short}</div>
        </div>
        <a href="http://www.facebook.com/{$config->facebook}" target="_blank" class="facebook-link" onclick="recordOutboundLink('Promo','Horses Facebook Button');"></a>
        <a href="http://twitter.com/{$config->twitter}" target="_blank" class="twitter-link" onclick="recordOutboundLink('Promo','Horses Twitter Button');"></a>
<div class="enter-hotel-btn">
    <div class="open enter-btn">
            <a href="events.php?id={$news[customer].id}">{#ReadNext#}<i></i></a>
        <b></b>
    </div>
</div>
    </div>
{/if}
{if  $smarty.section.customer.index ge '1'}
    <div class="promo-container" style="display: none; background-image: url({$news[customer].image});">
        <div class="promo-content">
            <div class="title">{$news[customer].title}</div>
            <div class="body">{$news[customer].short}</div>
        </div>
        <a href="http://www.facebook.com/{$config->facebook}" target="_blank" class="facebook-link" onclick="recordOutboundLink('Promo','SnowStorm Facebook Button');"></a>
        <a href="http://twitter.com/{$config->twitter}" target="_blank" class="twitter-link" onclick="recordOutboundLink('Promo','SnowStorm Twitter Button');"></a>
<div class="enter-hotel-btn">
    <div class="open enter-btn">
            <a href="events.php?id={$news[customer].id}">{#ReadNext#}<i></i></a>
        <b></b>
    </div>
</div>
    {/if}
    </div>
{/section}


<script type="text/javascript">
    document.observe("dom:loaded", function() { PromoSlideShow.init(); });
</script>

{if $home neq 'empty' }
<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix blue ">
	
							<h2 class="title">{#SomeHomePageRandom#}
							</h2>
	<ul class="active-discussions-toplist">
	 {section name=homec loop=$home}
	 {if $home[homec].username neq ''}
	<li class="odd" >
		<a href="{$config->url_site}/home.php?username={$home[homec].username}" class="topic">
			<span>{$home[homec].username}</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                 <a href="{$config->url_site}/home.php?username={$home[homec].username}" class="topiclist-page-link secondary">{#GoView#}</a>
                
             <span class="grey">)</span>
		 </div>
	</li>	
	{/if}
	{/section}
	</ul>
			
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>			 

</div>	
{else}

<div id="column1" class="column">		
				<div class="habblet-container ">		
						<div class="cbb clearfix blue ">
	
							<h2 class="title">{#SomeHomePageRandom#}
							</h2>
	<ul class="active-discussions-toplist">

	<li class="odd" >
		<a href="#" class="topic">
			<span>Pas encore de Home Page !</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                 <a href="#" class="topiclist-page-link secondary">{#GoView#}</a>
                
             <span class="grey">)</span>
		 </div>
	</li>	
	</ul>
			
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>			 

</div>	
	{/if}
	
	
					