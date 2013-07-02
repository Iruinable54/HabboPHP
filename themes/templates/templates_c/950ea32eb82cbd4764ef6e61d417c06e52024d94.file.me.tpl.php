<?php /* Smarty version Smarty-3.1.8, created on 2013-07-02 19:46:19
         compiled from "/Applications/MAMP/htdocs/HabboPHP/themes/templates/me.tpl" */ ?>
<?php /*%%SmartyHeaderCode:46035399551d311ebb4d1c8-06795308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '950ea32eb82cbd4764ef6e61d417c06e52024d94' => 
    array (
      0 => '/Applications/MAMP/htdocs/HabboPHP/themes/templates/me.tpl',
      1 => 1372518445,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '46035399551d311ebb4d1c8-06795308',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'user' => 0,
    'vip' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51d311ebd148f9_98531109',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d311ebd148f9_98531109')) {function content_51d311ebd148f9_98531109($_smarty_tpl) {?>
<div id="container">

	<div id="content" style="position: relative" class="clearfix">
	
    <div id="wide-personal-info">
    <div id="habbo-plate">
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/profile.php?page=index">
            <img alt="<?php echo $_smarty_tpl->getConfigVariable('Name');?>
" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $_smarty_tpl->tpl_vars['user']->value->look;?>
&size=b&direction=3&head_direction=3&gesture=sml"/>
        </a>
    </div>

    <div id="name-box" class="info-box">
        <div class="label"><?php echo $_smarty_tpl->getConfigVariable('Name');?>
:</div>
        <div class="content"><?php echo $_smarty_tpl->tpl_vars['user']->value->username;?>
 <?php echo $_smarty_tpl->tpl_vars['vip']->value;?>
</div>
    </div>
    <div id="motto-box" class="info-box">
        <div class="label"><?php echo $_smarty_tpl->getConfigVariable('Motto');?>
:</div>
        <div class="content"><?php echo $_smarty_tpl->tpl_vars['user']->value->motto;?>
</div>
    </div>
    <div id="last-logged-in-box" class="info-box">
        <div class="label"><?php echo $_smarty_tpl->getConfigVariable('Lastlogin');?>
:</div>
        <div class="content"><?php echo $_smarty_tpl->tpl_vars['user']->value->last_online;?>
</div>
    </div>

<div class="enter-hotel-btn">
    <div class="open enter-btn">
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/client.php" target="38bad4312a9f27ce591f69f49725def36283fe99" onclick="HabboClient.openOrFocus(this); return false;"><?php echo $_smarty_tpl->getConfigVariable('Enterhotel');?>
<i></i></a>
        <b></b>
    </div>
</div>

</div>


<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['customer'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['name'] = 'customer';
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['news']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['customer']['total']);
?>

	 <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['customer']['first']){?>
<div id="promo-box">

    <div id="promo-bullets"></div>

    <div class="promo-container" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['image'];?>
)">
        <div class="promo-content">
            <div class="title"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['title'];?>
</div>
            <div class="body"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['short'];?>
</div>
        </div>
        <a href="http://www.facebook.com/<?php echo $_smarty_tpl->tpl_vars['config']->value->facebook;?>
" target="_blank" class="facebook-link" onclick="recordOutboundLink('Promo','Horses Facebook Button');"></a>
        <a href="http://twitter.com/<?php echo $_smarty_tpl->tpl_vars['config']->value->twitter;?>
" target="_blank" class="twitter-link" onclick="recordOutboundLink('Promo','Horses Twitter Button');"></a>
<div class="enter-hotel-btn">
    <div class="open enter-btn">
            <a href="events.php?id=<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['id'];?>
"><?php echo $_smarty_tpl->getConfigVariable('ReadNext');?>
<i></i></a>
        <b></b>
    </div>
</div>
    </div>
<?php }?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']>='1'){?>
    <div class="promo-container" style="display: none; background-image: url(<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['image'];?>
);">
        <div class="promo-content">
            <div class="title"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['title'];?>
</div>
            <div class="body"><?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['short'];?>
</div>
        </div>
        <a href="http://www.facebook.com/<?php echo $_smarty_tpl->tpl_vars['config']->value->facebook;?>
" target="_blank" class="facebook-link" onclick="recordOutboundLink('Promo','SnowStorm Facebook Button');"></a>
        <a href="http://twitter.com/<?php echo $_smarty_tpl->tpl_vars['config']->value->twitter;?>
" target="_blank" class="twitter-link" onclick="recordOutboundLink('Promo','SnowStorm Twitter Button');"></a>
<div class="enter-hotel-btn">
    <div class="open enter-btn">
            <a href="events.php?id=<?php echo $_smarty_tpl->tpl_vars['news']->value[$_smarty_tpl->getVariable('smarty')->value['section']['customer']['index']]['id'];?>
"><?php echo $_smarty_tpl->getConfigVariable('ReadNext');?>
<i></i></a>
        <b></b>
    </div>
</div>
    </div>
    <?php }?>
<?php endfor; endif; ?>




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
    <a href="#" class="discussions-toggle-more-data secondary" id="discussions-toggle-more-data-h3"><?php echo $_smarty_tpl->getConfigVariable('Seemore');?>
</a>
</div>
<script type="text/javascript">
L10N.put("show.more.discussions", "<?php echo $_smarty_tpl->getConfigVariable('Seemore');?>
");
L10N.put("show.less.discussions", "<?php echo $_smarty_tpl->getConfigVariable('Seeless');?>
");
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
}).render().setUser('<?php echo $_smarty_tpl->tpl_vars['config']->value->twitter;?>
').start();
</script>
<div style="float:left;">
<?php echo $_smarty_tpl->tpl_vars['config']->value->ads300x250;?>

</div>
<div style="clear:both;"></div>

						
		</div>			
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
				
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php }} ?>