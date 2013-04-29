<?php include "includes/header.php"; ?>

<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Page']; ?></h1>
  <p class="lead"><?php echo $lang['PageInfo']; ?></p>
  <div class="subnav">
    <ul class="nav nav-pills">
      <?php if(Tools::checkACL($user->rank,ACL_PAGES_ADD)) {  ?><li><a href="#addpage"><?php echo $lang['AddPage']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_PAGES_VIEW)) {  ?><li><a href="#listpage"><?php echo $lang['ListPage']; ?></a></li><?php } ?>
    </ul>
  </div>
</header>
<div class="modal hide fade" id="postpageload">
  <div class="modal-header">
    <h3><?php echo $lang['Loading']; ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo $lang['LoadingPageInfo']; ?></p>
  </div>
</div>
<?php if(Tools::checkACL($user->rank,ACL_PAGES_ADD)) { ?>
<?php
if(isset($_GET['id']) && is_numeric($_GET['id']))
$dataPage = mysql_fetch_assoc(mysql_query('select * from habbophp_pages WHERE id="'.safe($_GET['id'],'SQL').'"'));
?>
<section id="addpage">
<div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['Title']; ?></label>
            <div class="controls">
              <input type="text" class="input-xlarge" value="<?php if(isset($dataPage['title'])) echo $dataPage['title'] ; ?>" id="titlenews">
            </div>
          </div> 
          <div class="control-group">
            <label class="control-label" for="textarea"><?php echo $lang['Content']; ?></label>
            <div class="controls">
              <textarea class="input-xlarge" id="tai" rows="10" style="width:100%"><?php if(isset($dataPage['content'])) echo $dataPage['content'] ; ?></textarea>
            </div>
          </div>
          
          <div class="form-actions">
          <?php if(isset($_GET['id'])){ ?>
            <button type="button" onclick="addPage(<?php echo $_GET['id']; ?>);" class="btn btn-primary"><?php echo $lang['SendMyPage']; ?></button>
            <a href="page.php" class="btn btn-alert"><?php echo $lang['Back']; ?></a>

            <?php }else{ ?>
            	<button type="button" onclick="addPage(0)" class="btn btn-primary"><?php echo $lang['SendMyPage']; ?>
            <?php } ?>
          </div>
        </fieldset>
      </div>

</section>
<?php } ?>
<?php if(Tools::checkACL($user->rank,ACL_PAGES_VIEW)) {  ?>
<section id="listpage">
<?php
$req = mysql_query('select * from habbophp_pages');
?>
<input type="text" name="search" value="" id="id_search" placeholder="<?php echo $lang['Search']; ?>" />
<table  class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Titre</th>
      <th>Contenu</th>
      <th>Lien</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php
   while($data = mysql_fetch_assoc($req)){
  ?>
    <tr id="l<?php echo safe($data['id'],'HTML'); ?>">
      <td><?php echo safe($data['title'],'HTML') ;?></td>
      <td><?php echo safe(substr($data['content'],0,300),'HTML') ;?>…</td>
      <td><?php echo $config->url_site.'/page.php?id='.safe($data['id'],'HTML')  ; ?></td>
      <td> 
      <a href="page.php?id=<?php echo safe($data['id'],'HTML') ; ?>" class="btn btn-alert"><?php echo $lang['Edit']; ?></a>
            	<a href="javascript:void(0);" onclick="deletePage('<?php echo $data['id']; ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</section>
<?php } ?>
<?php include "includes/footer.php"; ?>