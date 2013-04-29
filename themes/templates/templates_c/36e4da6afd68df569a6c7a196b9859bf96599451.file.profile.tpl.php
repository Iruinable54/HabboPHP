<?php /* Smarty version Smarty-3.1.8, created on 2012-12-31 01:31:13
         compiled from "/Users/robinherzog/github/local/HabboPHP-Dev2/themes/templates/profile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:95856409050e0dcd1e7cea0-26381753%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36e4da6afd68df569a6c7a196b9859bf96599451' => 
    array (
      0 => '/Users/robinherzog/github/local/HabboPHP-Dev2/themes/templates/profile.tpl',
      1 => 1356826086,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '95856409050e0dcd1e7cea0-26381753',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'ok' => 0,
    'error' => 0,
    'error_mail' => 0,
    'user' => 0,
    'emulator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50e0dcd1f409f4_73512309',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50e0dcd1f409f4_73512309')) {function content_50e0dcd1f409f4_73512309($_smarty_tpl) {?><div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div>

<div class="content">
<div class="habblet-container" style="float:left; width:210px;">
<div class="cbb settings">

<h2 class="title"><?php echo $_smarty_tpl->getConfigVariable('AccountSettings');?>
</h2>
<div class="box-content">
            <div id="settingsNavigation">
            <ul>

                <li class="selected"><?php echo $_smarty_tpl->getConfigVariable('Mission');?>

                </li>


                <li ><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/profile.php?page=password"><?php echo $_smarty_tpl->getConfigVariable('Password');?>
</a>
                </li>

                <li ><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value->url_site;?>
/friendsmanagement.php"><?php echo $_smarty_tpl->getConfigVariable('FriendManagement');?>
</a>
                </li>

            </ul>
            </div>
</div></div>
</div>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Changer de profile</h2>
            <div class="box-content">
            

<?php if (isset($_smarty_tpl->tpl_vars['ok']->value)){?>
	<div id="valideok" style="padding:10px;font-size:18px;display:block;opacity:1;background:#60b200;color:white;text-shadow:0 1px 0 #407700;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;"><?php echo $_smarty_tpl->getConfigVariable('profile_update_success');?>
</div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['error']->value)){?>
<div id="error-messages-container" class="">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="">
                    <?php if (isset($_smarty_tpl->tpl_vars['error_mail']->value)){?><?php echo $_smarty_tpl->tpl_vars['error_mail']->value;?>
<br/><?php }?>
                </div>
            </div>
        </div>
<br/>
<?php }?>

<form action="" method="post" id="profileForm">
<input type="hidden" name="tab" value="true" />

<h3><?php echo $_smarty_tpl->getConfigVariable('Your_status');?>
</h3>

<p>
<?php echo $_smarty_tpl->getConfigVariable('Mission_info');?>

</p>

<p>
<label class="alignLabel">Statut :</label>
<input   type="text" name="motto" size="32" maxlength="32" value="<?php if (isset($_smarty_tpl->tpl_vars['user']->value->motto)){?><?php echo $_smarty_tpl->tpl_vars['user']->value->motto;?>
<?php }?>" id="avatar motto" />
</p>

<p>
<label class="alignLabel">Mail :</label>
<input   type="text" name="email" size="32" maxlength="32" value="<?php if (isset($_smarty_tpl->tpl_vars['user']->value->mail)){?><?php echo $_smarty_tpl->tpl_vars['user']->value->mail;?>
<?php }?>" id="" />
</p>

<?php if ($_smarty_tpl->tpl_vars['emulator']->value=='phoenix'){?>

<h3>Visibilité</h3>

<p>
<?php echo $_smarty_tpl->getConfigVariable('Permission_view_online');?>
: </p><p>
<label><input type="radio" name="visibility" value="0" <?php if ($_smarty_tpl->tpl_vars['user']->value->hide_online=='0'){?> checked="checked"<?php }?> />tout le monde</label>
<label><input type="radio" name="visibility" value="1"  <?php if ($_smarty_tpl->tpl_vars['user']->value->hide_online=='1'){?> checked="checked"<?php }?> />personne</label>
</p>



<h3>Préférences &quot;rejoindre&quot;</h3>
<p>
Choisis qui peut te suivre où que tu ailles:<br />
<label><input type="radio" name="followFriendMode" value="0"  <?php if ($_smarty_tpl->tpl_vars['user']->value->hide_inroom=='0'){?> checked="checked"<?php }?> />Personne</label>
<label><input type="radio" name="followFriendMode" value="1" <?php if ($_smarty_tpl->tpl_vars['user']->value->hide_inroom=='1'){?> checked="checked"<?php }?>  />Mes amis</label>
</p>

<?php }?>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" onclick="document.forms['profileForm'].submit();" id="profileForm-submit"><b>Enregistrer</b><i></i></a>
<noscript><input type="submit" value="Enregistrer" name="save" class="submit" /></noscript>
</div>

</form>

<script type="text/javascript">
$("profileForm-submit").show();
</script>

</div>
</div>
</div>
</div>
</div><?php }} ?>