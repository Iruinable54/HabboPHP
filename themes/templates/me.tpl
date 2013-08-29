
<div id="container">

	<div id="content" style="position: relative" class="clearfix">
	
    <div id="wide-personal-info">
    <div id="habbo-plate">
            <a href="{$config->url_site}/profile.php?page=index">
            <img alt="{#Name#}" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure={$user->look}&size=b&direction=3&head_direction=3&gesture=sml"/>
        </a>
    </div>

    <div id="name-box" class="info-box">
        <div class="label">{#Name#}:</div>
        <div class="content">{$user->username} {$vip}</div>
    </div>
    <div id="motto-box" class="info-box">
        <div class="label">{#Motto#}:</div>
        <div class="content">{$user->motto}</div>
    </div>
    <div id="last-logged-in-box" class="info-box">
        <div class="label">{#Lastlogin#}:</div>
        <div class="content">{$user->last_online}</div>
    </div>

<div class="enter-hotel-btn">
    <div class="open enter-btn">
            <a href="{$config->url_site}/client.php" target="38bad4312a9f27ce591f69f49725def36283fe99" onclick="HabboClient.openOrFocus(this); return false;">{#Enterhotel#}<i></i></a>
        <b></b>
    </div>
</div>

</div>


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
          {if $news[customer].button_link_display eq 1}
<div class="enter-hotel-btn">
    <div class="open enter-btn">
  
    	{if $news[customer].button_link_me eq 'hotel'}
			    <a href="{$config->url_site}/client.php" target="38bad4312a9f27ce591f69f49725def36283fe99" onclick="HabboClient.openOrFocus(this); return false;">{#Enterhotel#}<i></i></a>
			    {elseif  empty($news[customer].button_link_me)}
			    	<a href="events.php?id={$news[customer].id}">{$news[customer].button_text_me}<i></i></a>
			    {else}
			     
			     <a href="{$news[customer].button_link_me}">{$news[customer].button_text_me}<i></i></a>
    		{/if}
       
        <b></b>
    </div>
</div>
{/if}
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
          {if $news[customer].button_link_display eq 1}
<div class="enter-hotel-btn">
    <div class="open enter-btn">
  
    		{if $news[customer].button_link_me eq 'hotel'}
			    <a href="{$config->url_site}/client.php" target="38bad4312a9f27ce591f69f49725def36283fe99" onclick="HabboClient.openOrFocus(this); return false;">{#Enterhotel#}<i></i></a>
			    {elseif  empty($news[customer].button_link_me)}
			    	<a href="events.php?id={$news[customer].id}">{$news[customer].button_text_me}<i></i></a>
			    {else}
			     
			     <a href="{$news[customer].button_link_me}">{$news[customer].button_text_me}<i></i></a>
    		{/if}
       
        <b></b>
    </div>
</div>
{/if}
    </div>
    {/if}
{/section}




</div>
<script type="text/javascript">
    document.observe("dom:loaded", function() { PromoSlideShow.init(); });
</script>

<div id="column1" class="column" style="display:none">
			     		
				<div class="habblet-container " >		
						<div class="cbb clearfix blue ">
	
							<h2 class="title">Grupper
							</h2>
						<ul class="active-discussions-toplist">
						
	<li class="odd" >
		<a href="/groups/16764/id/discussions/155172/id" class="topic">
			<span>Habbo X kommer tillbaka</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                     <a href="/groups/16764/id/discussions/155172/id/page/1" class="topiclist-page-link secondary">1</a>
             <span class="grey">)</span>
		 </div>
	</li>
	<li class="even" >
		<a href="/groups/16764/id/discussions/155168/id" class="topic">
			<span>Katy Perry gör en film!</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                     <a href="/groups/16764/id/discussions/155168/id/page/1" class="topiclist-page-link secondary">1</a>
             <span class="grey">)</span>
		 </div>
	</li>
	
	</ul>
<div id="active-discussions-toplist-hidden-h3" style="display: none">
    <ul class="active-discussions-toplist">
	<li class="odd" >
		<a href="/groups/21650/id/discussions/152662/id" class="topic">
			<span>2012 - undergången?</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                     <a href="/groups/21650/id/discussions/152662/id/page/1" class="topiclist-page-link secondary">1</a>
                     <a href="/groups/21650/id/discussions/152662/id/page/2" class="topiclist-page-link secondary">2</a>
                     <a href="/groups/21650/id/discussions/152662/id/page/3" class="topiclist-page-link secondary">3</a>
                     <a href="/groups/21650/id/discussions/152662/id/page/4" class="topiclist-page-link secondary">4</a>
             <span class="grey">)</span>
		 </div>
	</li>
	<li class="even" >
		<a href="/groups/21650/id/discussions/129630/id" class="topic">
			<span>[LEK] Lektråd [LEK]</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                 <a href="/groups/21650/id/discussions/129630/id/page/1" class="topiclist-page-link secondary">1</a>
                 …
                     <a href="/groups/21650/id/discussions/129630/id/page/591" class="topiclist-page-link secondary">591</a>
                     <a href="/groups/21650/id/discussions/129630/id/page/592" class="topiclist-page-link secondary">592</a>
                     <a href="/groups/21650/id/discussions/129630/id/page/593" class="topiclist-page-link secondary">593</a>
             <span class="grey">)</span>
		 </div>
	</li>
	
	</ul>
</div>
<div class="clearfix">
    <a href="#" class="discussions-toggle-more-data secondary" id="discussions-toggle-more-data-h3">{#Seemore#}</a>
</div>
<script type="text/javascript">
L10N.put("show.more.discussions", "{#Seemore#}");
L10N.put("show.less.discussions", "{#Seeless#}");
var discussionMoreDataHelper = new MoreDataHelper("discussions-toggle-more-data-h3", "active-discussions-toplist-hidden-h3","discussions");
</script>

						
							
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	
						<div style="float:left;" id="twitterfeed-habblet-container">

<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 30000,
  width: 453,
   height: 161,
  theme: {
    shell: {
      background: '#4a4d4f',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#4a4d4f',
      links: '#fe6201'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    behavior: 'all'
  }
}).render().setUser('{$config->twitter}').start();
</script>
<div style="float:left;">
{$config->ads300x250}
</div>
<div style="clear:both;"></div>

						
		</div>			
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
				
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
