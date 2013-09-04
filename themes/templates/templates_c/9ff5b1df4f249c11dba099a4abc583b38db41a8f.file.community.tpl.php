<?php /* Smarty version Smarty-3.1.8, created on 2013-09-04 11:39:05
         compiled from "/Applications/MAMP/htdocs/HabboPHP/themes/templates/community.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20809264115226ffb9d15937-19718453%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ff5b1df4f249c11dba099a4abc583b38db41a8f' => 
    array (
      0 => '/Applications/MAMP/htdocs/HabboPHP/themes/templates/community.tpl',
      1 => 1372518445,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20809264115226ffb9d15937-19718453',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'news' => 0,
    'config' => 0,
    'home' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5226ffb9ebd9f4_25791459',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5226ffb9ebd9f4_25791459')) {function content_5226ffb9ebd9f4_25791459($_smarty_tpl) {?><div id="container">
	<div id="content" style="position: relative;" class="clearfix">
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
    <?php }?>
    </div>
<?php endfor; endif; ?>


<script type="text/javascript">
    document.observe("dom:loaded", function() { PromoSlideShow.init(); });
</script>

<?php if ($_smarty_tpl->tpl_vars['home']->value!='empty'){?>
<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix blue ">
	
							<h2 class="title"><?php echo $_smarty_tpl->getConfigVariable('SomeHomePageRandom');?>

							</h2>
	<ul class="active-discussions-toplist">
	 <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['homec'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['name'] = 'homec';
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['home']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['homec']['total']);
?>
	 <?php if ($_smarty_tpl->tpl_vars['home']->value[$_smarty_tpl->getVariable('smarty')->value['section']['homec']['index']]['username']!=''){?>
	<li class="odd" >
		<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/home.php?username=<?php echo $_smarty_tpl->tpl_vars['home']->value[$_smarty_tpl->getVariable('smarty')->value['section']['homec']['index']]['username'];?>
" class="topic">
			<span><?php echo $_smarty_tpl->tpl_vars['home']->value[$_smarty_tpl->getVariable('smarty')->value['section']['homec']['index']]['username'];?>
</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                 <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/home.php?username=<?php echo $_smarty_tpl->tpl_vars['home']->value[$_smarty_tpl->getVariable('smarty')->value['section']['homec']['index']]['username'];?>
" class="topiclist-page-link secondary"><?php echo $_smarty_tpl->getConfigVariable('GoView');?>
</a>
                
             <span class="grey">)</span>
		 </div>
	</li>	
	<?php }?>
	<?php endfor; endif; ?>
	</ul>
			
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>			 

</div>	
<?php }else{ ?>

<div id="column1" class="column">		
				<div class="habblet-container ">		
						<div class="cbb clearfix blue ">
	
							<h2 class="title"><?php echo $_smarty_tpl->getConfigVariable('SomeHomePageRandom');?>

							</h2>
	<ul class="active-discussions-toplist">

	<li class="odd" >
		<a href="#" class="topic">
			<span>Pas encore de Home Page !</span>
		</a>
		<div class="topic-info post-icon">
            <span class="grey">(</span>
                 <a href="#" class="topiclist-page-link secondary"><?php echo $_smarty_tpl->getConfigVariable('GoView');?>
</a>
                
             <span class="grey">)</span>
		 </div>
	</li>	
	</ul>
			
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>			 

</div>	
	<?php }?>
	
	
					<?php }} ?>