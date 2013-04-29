<?php include "includes/header.php"; ?>

<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Users']; ?></h1>
  <p class="lead"><?php echo $lang['FindUsersToManage']; ?></p>
  <div class="subnav">
    <ul class="nav nav-pills">
      <?php if(Tools::checkACL($user->rank,ACL_USERS_VIEW)) { ?><li><a href="users.php"><?php echo $lang['Users']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_USERS_BAN)) {  ?><li><a href="ban.php"><?php echo $lang['ManageBan']; ?></a></li><?php } ?>
    </ul>
  </div>
</header>

<?php if(Tools::checkACL($user->rank,ACL_USERS_VIEW)) { ?>
<section id="server">

      <div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
			<input type="text" class="" style="width:99%;font-size:24px;height:40px;" placeholder="<?php echo $lang['UsernameIPEmail']; ?>" id="input01">
          
          <div class="form-actions" style="text-align:center;">
            <a href="javascript:void(0);" onclick="searchusers($('#input01').val());" style="margin-left:-154px;font-size:24px;" class="btn btn-primary btn-large"><?php echo $lang['Search']; ?></a>
          </div>
        </fieldset>
      </div>
	        <center>    <img style="display:none" id="loaderImg" src="<?php echo $config->url_site."/web-gallery/images/ajax-loader.gif" ; ?>"></img></center>
	  <div id="resultsSearch"></div>

</section>
<?php } ?>

<?php include "includes/footer.php"; ?>