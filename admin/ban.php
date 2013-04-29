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
<script src="assets/js/jquery.js"></script>

<br/>
 <?php if(Tools::checkACL($user->rank,ACL_USERS_BAN)) {  ?>
<div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          <form action="" method="post">
			<input type="text" class="" name="search" style="width:99%;font-size:24px;height:40px;" placeholder="Nom d'utilisateur ou IP" id="input01">
			          <div class="form-actions" style="text-align:center;">
          	            <button  style="margin-left:-154px;font-size:24px;" class="btn btn-primary btn-large"><?php echo $lang['Search']; ?></button>
          </div>
         </form>
        </fieldset>
      </div>
	        <center>    <img style="display:none" id="loaderImg" src="<?php echo $config->url_site."/web-gallery/images/ajax-loader.gif" ; ?>"></img></center>


<section id="server" >


<?php
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int) $_GET['page'] : '1' ;
$nombreDeMessagesParPage = 40; // Essayez de changer ce nombre pour voir :o)

if(isset($_POST['search']) && !empty($_POST['search'])){
$req = mysql_query("select * from bans WHERE value LIKE '%".safe($_POST['search'],'SQL')."%' ORDER BY id desc");
}
else
	$req = mysql_query("select * from bans ORDER BY id desc LIMIT 0,30");


//NOT LIKE "%This is an english hotel%"
?>
<p>Pour voir plus de ban, utilisez le formulaire de recherche.</p>

<table  class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Utilisateur/IP</th>
      <th>Raison</th>
      <th>Expire</th>
      <th>Banni par</th>
      <th>Date ajoutée</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php
   while($data = mysql_fetch_assoc($req)){
  ?>
    <tr id="l<?php echo $data['id']; ?>">
      <td><?php echo $data['value'] ;?></td>
      <td><?php echo $data['reason'] ;?></td>
      <td><?php echo date('d/m/Y à H:i:s',$data['expire']) ;?></td>
      <td><?php echo $data['added_by'] ;?></td>
      <td><?php echo $data['added_date'] ;?></td>
      <td> 
            	<a href="javascript:void(0);" onclick="removeban('<?php echo $data['id']; ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>




</section>
<?php } ?>
<?php include "includes/footer.php"; ?>