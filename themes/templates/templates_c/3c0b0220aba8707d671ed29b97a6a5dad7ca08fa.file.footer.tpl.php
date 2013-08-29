<?php /* Smarty version Smarty-3.1.8, created on 2013-08-29 22:10:56
         compiled from "/Applications/MAMP/htdocs/HabboPHP/themes/templates/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1612769424521faad0a648e8-95416285%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c0b0220aba8707d671ed29b97a6a5dad7ca08fa' => 
    array (
      0 => '/Applications/MAMP/htdocs/HabboPHP/themes/templates/footer.tpl',
      1 => 1372518445,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1612769424521faad0a648e8-95416285',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_521faad0aeb184_39614763',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521faad0aeb184_39614763')) {function content_521faad0aeb184_39614763($_smarty_tpl) {?><div id="column3" class="column">
		

						
					
				</div>
				
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

			     		
				<?php if ($_smarty_tpl->tpl_vars['url']->value=='home.php'||$_smarty_tpl->tpl_vars['url']->value=='vip.php'||$_smarty_tpl->tpl_vars['url']->value=='shop.php'||$_smarty_tpl->tpl_vars['url']->value=='community.php'){?>
				<div class="habblet-container "></div>
				<?php }else{ ?>
				<div class="habblet-container">		
	
						
					<div style="float:right"><?php if ($_smarty_tpl->tpl_vars['url']->value=='me.php'){?>&nbsp;&nbsp;<?php }?><?php echo $_smarty_tpl->tpl_vars['config']->value->ads1X0x600;?>
</div>
						
					
				</div><?php }?>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
		 

</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
<div class="habblet-container "><br /><?php echo $_smarty_tpl->tpl_vars['config']->value->ads728x90;?>
</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
    </div>
   
<div id="footer">
	<?php echo $_smarty_tpl->tpl_vars['config']->value->adsSlide;?>

	<?php echo $_smarty_tpl->tpl_vars['config']->value->adsPopup;?>

	<p class="footer-links"><a href="https://help.habbo.se" target="_new"><?php echo $_smarty_tpl->getConfigVariable('Help');?>
</a> | <a href="http://habbophp.com" title="HabboPHP" target="_new">HabboPHP</a> | <a href="https://help.habbo.se/home" target="_new">FAQ</a></p>
	<p class="copyright"><?php echo $_smarty_tpl->tpl_vars['config']->value->name;?>
 est un projet indépendant, à but non lucratif &copy; 2010-2012.<br>
                         Habbo est une marque déposée de Sulake Corporation. Tous droits réservés à leur propriétaire respectif(s).<br>
                         Nous ne sommes pas approuvé, affiliés, ou offertes par Sulake Corporation LTD.<br>
                         Powered by HabboPHP - Valentin & Robin.</p>
</div><!--end of footer-->

</div>

</div> 
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Roundeverything(); }</script>
        


</body>
</html><?php }} ?>