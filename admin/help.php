<?php include "includes/header.php"; ?>

<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Help']; ?></h1>
  <p class="lead"><?php echo $lang['HelpInfos']; ?></p>
  <div class="subnav">
    <ul class="nav nav-pills">
       <?php if(Tools::checkACL($user->rank,ACL_SUPPORT_CATEGORIES)) {  ?><li><a href="#category"><?php echo $lang['Categories']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SUPPORT_ARTICLES)) {  ?><li><a href="#articlesadd"><?php echo $lang['Topics']; ?></a></li><?php } ?>
    </ul>
  </div>
</header>

<?php
$query=mysql_query("SELECT * FROM habbophp_help_category");
while($row=mysql_fetch_array($query)) {
	$id='r'.$row['id'];
	$category[$id]=$row['value'];
}
?>

<?php  if(Tools::checkACL($user->rank,ACL_SUPPORT_CATEGORIES)) {  ?>
<section id="category">
  <div class="page-header">
    <h1><?php echo $lang['Categories']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  	  <table id="tablewf" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><?php echo $lang['CategoryName']; ?></th>
            <th> </th>
          </tr>
        </thead>
        <tbody id="addcategoryc">
          <?php
          $i=0;
          $query=mysql_query("SELECT * FROM habbophp_help_category");
          while($row=mysql_fetch_array($query)){
          ?>
          <tr id="category-<?php echo $row['id']; ?>">
            <td>
              <?php echo $row['value']; ?>
            </td>
            <td>
            	<a href="javascript:void(0);" onclick="removehcategory('<?php echo $row['id']; ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
            </td>
          </tr>
          <?php $i++; } 
          if($i==0) { ?>
          	<tr id="nocategory"><td><?php echo $lang['NoCategoriesNow']; ?></td><td></td></tr>
          <?php } ?>
        </tbody>
      </table>
      
      <div class="form-actions">
      	<input type="text" id="categoryname" placeholder="<?php echo $lang['CategoryName']; ?>" />
		<br />
        <button type="submit" onclick="addhcategory($('#categoryname').val());" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
  	</div>
  </div>
</section>
<?php } ?>

<?php  if(Tools::checkACL($user->rank,ACL_SUPPORT_ARTICLES)) {  ?>
<section id="articlesadd">
  <div class="page-header">
    <h1><?php echo $lang['Topics']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  	  <table id="tablewf" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><?php echo $lang['CategoryName']; ?></th>
            <th><?php echo $lang['Title']; ?></th>
            <th> </th>
          </tr>
        </thead>
        <tbody id="addarticlesc">
          <?php
          $i=0;
          $query=mysql_query("SELECT * FROM habbophp_help_articles");
          while($row=mysql_fetch_array($query)){
          ?>
          <tr id="articles-<?php echo $row['id']; ?>">
          	<td>
              <?php $id='r'.$row['cid']; echo $category[$id]; ?>
            </td>
            <td>
              <?php echo $row['title']; ?>
            </td>
            <td>
            	<a href="javascript:void(0);" onclick="removeharticles('<?php echo $row['id']; ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
            </td>
          </tr>
          <?php $i++; } 
          if($i==0) { ?>
          	<tr id="noarticles"><td><?php echo $lang['NoCategoriesNow']; ?></td><td></td><td></td></tr>
          <?php } ?>
        </tbody>
      </table>
      
      <div class="form-actions">
      	<select id="articlescat">
      		<?php
      		$query=mysql_query("SELECT * FROM habbophp_help_category");
			while($row=mysql_fetch_array($query)) {
			?>
      		<option value="<?php echo $row['id']; ?>"><?php echo $row['value']; ?></option>
      		<?php } ?>
      	</select>&nbsp;&nbsp;&nbsp;
      	<input type="text" id="articlestitle" placeholder="<?php echo $lang['Title']; ?>" />
      	<textarea style="width:700px;height:200px;"></textarea>
		<br />
        <button type="submit" onclick="addharticle($('#articlescat').val(),$('#articlestitle').val(),$('.nicEdit-main').html());" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
  	</div>
  </div>
</section>
<?php } ?>

<?php include "includes/footer.php"; ?>