<?php /* Smarty version Smarty-3.1.8, created on 2012-12-31 00:49:40
         compiled from "/Users/robinherzog/github/local/HabboPHP-Dev2/themes/templates/register-step-2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160158337350e0d314e089b6-26109637%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f782fad40aa100267cf72daec8f7b4033bbbcd5' => 
    array (
      0 => '/Users/robinherzog/github/local/HabboPHP-Dev2/themes/templates/register-step-2.tpl',
      1 => 1356825833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160158337350e0d314e089b6-26109637',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
    'error_pseudo' => 0,
    'error_pseudo_prefix' => 0,
    'error_email' => 0,
    'error_password' => 0,
    'error_passwordConfirm' => 0,
    'error_strlen' => 0,
    'error_password_different' => 0,
    'error_pseudo_strlen' => 0,
    'error_pseudo_preg' => 0,
    'error_pseudo_exist' => 0,
    'error_email_syntaxe' => 0,
    'error_termofservice' => 0,
    'error_email_exist' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50e0d315026406_53677456',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50e0d315026406_53677456')) {function content_50e0d315026406_53677456($_smarty_tpl) {?><body id="client" class="background-accountdetails-male">
<div id="overlay"></div>
<div id="stepnumbers">
    <div class="step1"><?php echo $_smarty_tpl->getConfigVariable('register_bean_and_gender');?>
</div>
    <div class="step2focus"><?php echo $_smarty_tpl->getConfigVariable('account_details');?>
</div>
    <div class="step3"><?php echo $_smarty_tpl->getConfigVariable('security_code');?>
</div>
    <div class="stephabbo"></div>
</div>

<div id="main-container">



    <div id="error-placeholder"></div>
    <?php if (isset($_smarty_tpl->tpl_vars['error']->value)){?>
<div id="error-messages-container" class="cbb">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="error">
       
       <?php if (isset($_smarty_tpl->tpl_vars['error_pseudo']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_pseudo');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_pseudo_prefix']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_pseudo_prefix');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_email']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_email');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_password']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_password');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_passwordConfirm']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_passwordConfirm');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_strlen']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_min_caracteres');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_password_different']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_password_different');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_pseudo_strlen']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_pseudo_strlen');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_pseudo_preg']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_pseudo_preg');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_pseudo_exist']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_pseudo_exist');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_email_syntaxe']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_email_syntaxe');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_termofservice']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_termofservice');?>
<br/><?php }?>
       <?php if (isset($_smarty_tpl->tpl_vars['error_email_exist']->value)){?><?php echo $_smarty_tpl->getConfigVariable('register_error_email_exist');?>
<?php }?>
   
 </div>
            </div>
        </div>

        <?php }?>
    <form method="post" action="" id="quickregister-form">

        <h2><?php echo $_smarty_tpl->getConfigVariable('account_details');?>
</h2>

      <div id="inner-container">
        <div class="inner-content bottom-border">
        <div class="field">
                <label for="pseudo">Pseudo</label>
                <input type="text" value="<?php if (isset($_POST['pseudo'])){?><?php echo $_POST['pseudo'];?>
<?php }?>" id="email-address" name="pseudo"  />
            </div>
            <div class="help"><?php echo $_smarty_tpl->getConfigVariable('pseudo_prefix');?>
</div>
            <div class="field">
                <label for="email-address">Email</label>
                <input type="text"  id="email-address" name="email" value="<?php if (isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }?>" />
            </div>
            <div class="help"><?php echo $_smarty_tpl->getConfigVariable('need_mail_register');?>
</div>
           
            <div id="password-field" class="field">
                <label for="register-password"><?php echo $_smarty_tpl->getConfigVariable('password');?>
</label>
                <input type="password" name="password" id="password" maxlength="32"  />
            </div>
            <div class="help"><?php echo $_smarty_tpl->getConfigVariable('register_password_need');?>
</b></div>
             <div id="password-field" class="field">
                <label for="register-password"><?php echo $_smarty_tpl->getConfigVariable('confirm_password');?>
</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" maxlength="32"  />
            </div>
            <div class="help"><?php echo $_smarty_tpl->getConfigVariable('confirm_password_info');?>
</b></div>

            
        </div>
		<input type="hidden"  name="submitV"  value=""/>      

        <div class="inner-content top-margin">
			<div class="field-content checkbox ">
			  <label>
			    <input type="checkbox" name="conditions" id=""  class=""/>
			    <?php echo $_smarty_tpl->getConfigVariable('I_agree');?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
" target="_blank" onclick="window.open('<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
'); return false;"><?php echo $_smarty_tpl->getConfigVariable('conditions_use');?>
</a>
			  </label>
			</div>            

        </div>
      </div>
    </form>
    <div id="select">
        <div class="button">
            <a id="" href="#"  onclick="document.forms['quickregister-form'].submit();" class="area"><?php echo $_smarty_tpl->getConfigVariable('Continue');?>
</a>
            <span class="close"></span>
        </div>
        <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/register.php?page=1" id="back-link"><?php echo $_smarty_tpl->getConfigVariable('Return');?>
</a>
   </div>
</div>






<script type="text/javascript">
    HabboView.run();
</script>

</body>
</html><?php }} ?>