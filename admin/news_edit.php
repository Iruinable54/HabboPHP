<?php 

include "includes/header.php";

if(!isset($_GET['id']) OR !is_numeric($_GET['id'])) exit ;
$userDB = new Db('habbophp_news',$_GET['id']);
if($userDB->NumRows('id') == 0) redirection ('site.php');
$userDB->id = safe($_GET['id'],'SQL');
$userDB->read();
if($user->rank<7) exit();

?>

<div class="modal hide fade" id="postnewsload">
  <div class="modal-header">
    <h3><?php echo $lang['Loading']; ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo $lang['LoadingNewsInfo']; ?></p>
  </div>
   <div class="modal-footer">
    <a href="#" class="btn">Close</a>
  </div>
</div>

<?php if($user->rank>=5){ ?>



<section id="postnews" style="padding:0">
  <div class="page-header">
    <h1><?php echo $lang['EditNews']; ?> <small><?php echo $lang['PostNewsSubTitle']; ?></small></h1>
  </div>

      <div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['Title']; ?></label>
            <div class="controls">
              <input type="text" class="input-xlarge"  value="<?php echo $userDB->title ; ?>" id="titlenews">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['ShortDesc']; ?></label>
            <div class="controls">
              <input type="text" style="width:600px;"  value="<?php echo $userDB->short ; ?>" class="input-xlarge" id="shortdescnews">
              <p class="help-block"><?php echo $lang['ShortDescInfo']; ?></p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="textarea"><?php echo $lang['Content']; ?></label>
            <div class="controls">
              <textarea class="input-xlarge" id="tai" rows="10" style="width:100%"><?php echo $userDB->content ; ?></textarea>
            </div>
          </div>
          <input type="hidden" id="idNews" value="<?php echo $userDB->id; ?>"/>
          <div class="form-actions">
            <button type="button" onclick="editnews($('#idNews').val(),$('#titlenews').val(),$('#shortdescnews').val(),$('.nicEdit-main').html(),$('#token').val());" class="btn btn-primary"><?php echo $lang['SendMyNews']; ?></button>
            <a class="btn" href="site.php">Retour aux news</a>
          </div>
        </fieldset>
      </div>

</section><?php } ?>

<?php include "includes/footer.php"; ?>