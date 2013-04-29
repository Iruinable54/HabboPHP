<?php 
include "includes/header.php"; 
 ?>

<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Website']; ?></h1>
  <p class="lead"><?php echo $lang['WebsiteTitleInformations']; ?></p>
  <div class="subnav">
    <ul class="nav nav-pills">
      <?php if(Tools::checkACL($user->rank,ACL_SITE_NEWS)) { ?><li><a href="#postnews"><?php echo $lang['PostNews']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SITE_NEWS)) { ?><li><a href="#gnews"><?php echo $lang['ManageNews']; ?></a></li><?php } ?>
       <?php if(Tools::checkACL($user->rank,ACL_SITE_ADS)) { ?><li><a href="#ads"><?php echo $lang['Ads']; ?></a></li><?php } ?>
       <?php if(Tools::checkACL($user->rank,ACL_SITE_CONFIG)) { ?><li><a href="#configs"><?php echo $lang['BaseConfiguration']; ?></a></li><?php } ?>
       <?php if(Tools::checkACL($user->rank,ACL_SITE_CONFIG_MAIL)) { ?><li><a href="#mail"><?php echo $lang['MailConfig']; ?></a></li><?php } ?>
       <?php if(Tools::checkACL($user->rank,ACL_SITE_SOCIAL)) { ?><li><a href="#social"><?php echo $lang['SocialNetwork']; ?></a></li><?php } ?>
       <?php if(Tools::checkACL($user->rank,ACL_SITE_FB)) { ?><li><a href="#facebookconnect"><?php echo $lang['FacebookConnect']; ?></a></li><?php } ?>
    </ul>
  </div>
</header>
<div class="modal hide fade" id="postnewsload">
  <div class="modal-header">
    <h3><?php echo $lang['Loading']; ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo $lang['LoadingNewsInfo']; ?></p>
  </div>
</div>

<?php  if(Tools::checkACL($user->rank,ACL_SITE_NEWS_POST)) { ?><section id="postnews">
  <div class="page-header">
    <h1><?php echo $lang['PostNews']; ?> <small><?php echo $lang['PostNewsSubTitle']; ?></small></h1>
  </div>
	
	<ul class="nav nav-tabs">
  		<li class="active"><a href="#choose" data-toggle="tab"><?php echo $lang['ChooseImage']; ?></a></li>
  		<li><a href="#upload" data-toggle="tab"><?php echo $lang['UploadImage']; ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="choose">
		<?php
			$per_page = 5;
			$sql = "select * from habbophp_news_images";
			$rsd = mysql_query($sql);
			$count = mysql_num_rows($rsd);
			$pages = ceil($count/$per_page);
		?>
	
		<div id="imagenews">&nbsp;</div>
		<div id="paging_buttonn" style="margin-top:10px;margin-bottom:5px;" align="center">
			<?php
			for($i=1; $i<=$pages; $i++)
			{
				echo '<a style="padding:5px;border:1px solid #fff;" href="javascript:void(0);" id="'.$i.'">'.$i.'</a> ';
			}
			?>
		</div>
		</div>
		<div class="tab-pane" id="upload">
	
			<form id="imageform" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php'>
					<div class="form-actions"><span class="btn btn-primary fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span><?php echo $lang['ChooseImage']; ?></span>
                    <input type="file" name="photoimg" id="photoimg" />
                </span> 
                759x300 pixels
                <div style="clear:both;"></div></div>
			</form>
			<div id='preview'></div>
		</div>
	</div>

      <div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['Title']; ?></label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="titlenews">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['ShortDesc']; ?></label>
            <div class="controls">
              <input type="text" style="width:600px;" class="input-xlarge" id="shortdescnews">
              <p class="help-block"><?php echo $lang['ShortDescInfo']; ?></p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="input01">Commentaires</label>
            <div class="controls">
			<select id="comments">
        	<option value="1">Oui</option>
        	<option value="0">Non</option>
			</select>
              <p class="help-block">Si il faut activer les commentaires, oui ou non ? </p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="textarea"><?php echo $lang['Content']; ?></label>
            <div class="controls">
              <textarea class="input-xlarge" id="tai" rows="10" style="width:100%"></textarea>
            </div>
          </div>
          
          <div class="form-actions">
            <button type="button" onclick="postnews($('#linkimagenews').val(),$('#titlenews').val(),$('#shortdescnews').val(),$('.nicEdit-main').html(),$('#comments').val());" class="btn btn-primary"><?php echo $lang['SendMyNews']; ?></button>
          </div>
        </fieldset>
      </div>

</section><?php } ?>




<!-- Code
================================================== -->
<?php if(Tools::checkACL($user->rank,ACL_SITE_NEWS_VIEW)) { ?><section id="gnews">
  <div class="page-header">
    <h1><?php echo $lang['ManageNews']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  	<?php
  	$page = (isset($_GET['news_page']) && is_numeric($_GET['news_page'])) ? $_GET['news_page'] : '1' ;
			$nombreDeMessagesParPage = 20; 
	
			$retour = mysql_query('SELECT COUNT(*) AS nb_bans FROM habbophp_news');
			$donnees = mysql_fetch_array($retour);
			$totalDesMessages = $donnees['nb_bans'];
			$nombreDePages  = ceil($totalDesMessages / $nombreDeMessagesParPage);

			$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;
  	?>
  	    <?php
      echo 'Page : ';
		for ($i = 1 ; $i <= $nombreDePages ; $i++)
	{
    echo '<a href="site.php?news_page='.$i.'#gnews">' . $i . '</a> ';
	}
      ?>
  	  <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><?php echo $lang['Title']; ?></th>
            <th><?php echo $lang['ShortDesc']; ?></th>
            <th><?php echo $lang['Date']; ?></th>
            <th><?php echo $lang['Options']; ?></th>
          </tr>
        </thead>
        <tbody id="addnewss">
          <?php
          $query=mysql_query('SELECT * FROM habbophp_news ORDER BY id DESC LIMIT ' . $premierMessageAafficher . ', ' . $nombreDeMessagesParPage);
          while($row=mysql_fetch_array($query)){
          ?>
          <tr id="news-<?php echo $row['id']; ?>">
            <td>
              <?php echo $row['title']; ?>
            </td>
            <td>
              <?php echo $row['short']; ?>
            </td>
            <td>
              le <?php $datetime = strtotime($row['date']); echo date("d/m/Y à H:i", $datetime); ?>
            </td>
            <td>
            	<a data-toggle="modal" href="#deletenews<?php echo $row['id']; ?>" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
            	<a href="news_edit.php?id=<?php echo $row['id'] ?>" class="btn btn-warning"><?php echo $lang['Edit']; ?></a>
            </td>
          </tr>
          
<div class="modal hide fade" style="display:none!important;" id="deletenews<?php echo $row['id']; ?>">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $lang['RealyDelete']; ?> "<?php echo $row['title']; ?>" ?</h3>
  </div>
  <div class="modal-body">
    <p><?php echo $lang['NewsWillBeDelete']; ?></p>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn btn-danger"><?php echo $lang['Cancel']; ?></a>
    <a href="#" onclick="deletenews(<?php echo $row['id']; ?>);$('#deletenews<?php echo $row['id']; ?>').modal();" data-dismiss="modal" class="btn btn-success"><?php echo $lang['Confirm']; ?></a>
  </div>
</div>
          <?php } ?>
        </tbody>
      </table>
      <?php
      echo 'Page : ';
		for ($i = 1 ; $i <= $nombreDePages ; $i++)
	{
    echo '<a href="site.php?news_page='.$i.'#gnews">' . $i . '</a> ';
	}
      ?>
  	</div>
  	
  </div><!--/row-->
</section><?php } ?>



<?php if(Tools::checkACL($user->rank,ACL_SITE_ADS)) { ?>
<section id="ads">
  <div class="page-header">
    <h1><?php echo $lang['Ads']; ?> <small><?php echo $lang['LetInputEmptyToDesactivate']; ?></small></h1>
  </div>

  <div class="row">
    <div class="span7">
    	<h2><?php echo $lang['AdsCode']; ?></h2>
    	728x90
    	<textarea id="p72890" style="background:url(assets/img/728.png) no-repeat center center;width:100%;height:90px;"><?php echo $config->ads728x90; ?></textarea>
    	<div class="form-actions">
            <button type="button" onclick="setconfig($('#p72890').val(),'ads728x90');" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
            <button type="button" class="btn" onclick="$('#p72890').val('');setconfig($('#p72890').val(),'ads728x90');"><?php echo $lang['Desactivate']; ?></button>
        </div>
        Slide-In
    	<textarea id="pslide" style="background:url(assets/img/slide.png) no-repeat center center;width:100%;height:90px;"><?php echo $config->adsSlide; ?></textarea>
    	<div class="form-actions">
            <button type="button" onclick="setconfig($('#pslide').val(),'adsSlide');" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
            <button type="button" class="btn" onclick="$('#pslide').val('');setconfig($('#pslide').val(),'adsSlide');"><?php echo $lang['Desactivate']; ?></button>
        </div>
        Pop-up
    	<textarea id="ppop" style="background:url(assets/img/pop.png) no-repeat center center;width:100%;height:90px;"><?php echo $config->adsPopup; ?></textarea>
    	<div class="form-actions">
            <button type="button" onclick="setconfig($('#ppop').val(),'adsPopup');" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
            <button type="button" class="btn" onclick="$('#ppop').val('');setconfig($('#ppop').val(),'adsPopup');"><?php echo $lang['Desactivate']; ?></button>
        </div>
	</div>
	<div class="span2">
		<h2>&nbsp;</h2>
    	<textarea id="p120600" style="background:url(assets/img/120.png) no-repeat center center;width:100%;height:500px;"><?php echo $config->ads1X0x600; ?></textarea>
    	<div class="form-actions">
            <button type="button" onclick="setconfig($('#p120600').val(),'ads1X0x600');" class="btn btn-primary"><?php echo $lang['UpdateShort']; ?></button>
            <button type="button" class="btn" onclick="$('#p120600').val('');setconfig($('#p120600').val(),'ads1X0x600');"><?php echo $lang['Desactivate']; ?></button>
        </div>

    </div>
    <div class="span3">
    <h2 style="margin-bottom:5px"><?php echo $lang['Example']; ?></h2>
<pre class="prettyprint linenums">
&lt;script type="text/javascript"&gt;
  &lt;!--
    google_ad_client = "ca-pub-4702421709549081";
    google_ad_slot = "8893270011";
    google_ad_width = 728;
    google_ad_height = 90;
  //--&gt;
&lt;/script&gt;
&lt;script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js"&gt;
&lt;/script&gt;
</pre>
		<p>300x250</p>
		<textarea id="p300250" style="background:url(assets/img/300250.png) no-repeat center center;width:100%;height:200px;"><?php echo $config->ads300x250; ?></textarea>
    	<div class="form-actions">
            <button type="button" onclick="setconfig($('#p300250').val(),'ads300x250');" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
            <button type="button" class="btn" onclick="$('#p300250').val('');setconfig($('#p300250').val(),'ads300x250');"><?php echo $lang['Desactivate']; ?></button>
        </div>
    </div>
  </div>
  

</section>
<?php } ?>


<?php if(Tools::checkACL($user->rank,ACL_SITE_CONFIG)) { ?>
<section id="configs">
	<div class="page-header">
		<h1><?php echo $lang['BaseConfiguration']; ?></h1>
	</div>
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['Name']; ?></h3>
      <p><?php echo $lang['NameInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="namevalue" value="<?php echo $config->name; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#namevalue').val(),'name');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['ShortName']; ?></h3>
      <p><?php echo $lang['ShortNameInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="shortnamevalue" value="<?php echo $config->shortname; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#shortnamevalue').val(),'shortname');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
     
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['UrlSite']; ?></h3>
      <p><?php echo $lang['UrlSiteInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="urlsite" value="<?php echo $config->url_site; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#urlsite').val(),'url_site');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['Keywords']; ?></h3>
      <p><?php echo $lang['KeywordsInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="keywords" style="width:800px" value="<?php echo $config->meta_keywords; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#keywords').val(),'meta_keywords');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
   <div class="row">
    <div class="span3">
      <h3><?php echo $lang['Description']; ?></h3>
      <p><?php echo $lang['DescriptionInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="meta_description" style="width:800px;" value="<?php echo $config->meta_description; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#meta_description').val(),'meta_description');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['WelcomeMessage']; ?></h3>
      <p><?php echo $lang['WelcomeMessageInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="welcome_message" style="width:800px;" value="<?php echo $config->welcome_message; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#welcome_message').val(),'welcome_message');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
   <div class="row">
    <div class="span3">
      <h3><?php echo $lang['EmailContact']; ?></h3>
      <p><?php echo $lang['EmailContactInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="email" value="<?php echo $config->email; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#email').val(),'email');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
   <div class="row">
    <div class="span3">
      <h3><?php echo $lang['MissionDefault']; ?></h3>
      <p><?php echo $lang['MissionDefaultInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="motto_default" value="<?php echo $config->motto_default; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#motto_default').val(),'motto_default');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>

 <div class="row">
    <div class="span3">
      <h3><?php echo $lang['CreditDefault']; ?></h3>
      <p><?php echo $lang['CreditDefaultInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="credit_default" value="<?php echo $config->credit_default; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#credit_default').val(),'credit_default');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>

  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['SiteLang']; ?></h3>
    </div>
    <div class="span9">
      <div class="well">
        <select id="lang">
        	<option value="<?php echo $config->lang; ?>"><?php echo $config->lang; ?></option>
        	<?php
        	$dirname = '../lang/';
			$dir = opendir($dirname);
        	while($file = readdir($dir)) {
				if($file != '.' && $file != '..' && !is_dir($dirname.$file)) {
					$file=str_replace(".lang","",$file);
					echo '<option value="'.$file.'">'.$file.'</option>';
				}
			}
			?>
        </select>
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#lang').val(),'lang');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['AdminLang']; ?></h3>
    </div>
    <div class="span9">
      <div class="well">
        <select id="langadmin">
        	<option value="<?php echo $config->langadmin; ?>"><?php echo $config->langadmin; ?></option>
        	<?php
        	$dirname = 'lang/';
			$dir = opendir($dirname);
        	while($file = readdir($dir)) {
				if($file != '.' && $file != '..' && !is_dir($dirname.$file)) {
					$file=str_replace(".php","",$file);
					echo '<option value="'.$file.'">'.$file.'</option>';
				}
			}
			?>
        </select>
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#langadmin').val(),'langadmin');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['WebsiteLogo']; ?></h3>
    </div>
    <div class="span9">
      <div class="well">
        	<form id="imageformlogo" method="post" enctype="multipart/form-data" action='ajax/ajaximagelogo.php'>
				<span class="btn btn-primary fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span><?php echo $lang['ChooseImage']; ?></span>
                    <input type="file" name="photoimg" id="photoimglogo" />
                </span>
			</form>
			<div id="logoupdatesubmited"></div>
			<div style="clear:both;"></div>
			<div id="logoupdatei" style="display:none;margin-top:10px;"><?php echo $lang['LogoUpdated']; ?></div>
      </div>
    </div>
  </div>
     <div class="row">
    <div class="span3">
      <h3><?php echo $lang['NewsImages']; ?></h3>
      <p><?php echo $lang['NewsImagesInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="slideNews" value="<?php echo $config->slideNews; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#slideNews').val(),'slideNews');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['IndexDescMessage']; ?></h3>
      <p><?php echo $lang['IndexDescMessageInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
		<textarea style="width:100%;height:100px" id="desc_index"><?php echo $config->desc_index; ?></textarea>

        <button type="button" onclick="setconfig($('#desc_index').val(),'desc_index');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
   <div class="row">
    <div class="span3">
      <h3><?php echo $lang['Comments']; ?></h3>
      <p><?php echo $lang['CommentsInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
   
         <select name="comments" id="commentsType">
         	<option <?php checked($config->comments,'normal','select'); ?> value="normal">Normal</option>
         	<option <?php checked($config->comments,'facebook','select'); ?> value="facebook">Facebook</option>
         </select>
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#commentsType').val(),'comments');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
</section>

<?php } ?>
<?php if(Tools::checkACL($user->rank,ACL_SITE_CONFIG_MAIL)) { ?>
<section id="mail">
	<div class="page-header">
		<h1><?php echo $lang['ConfigMail']; ?> Gmail</h1>
	</div>

  
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['Username']; ?> Gmail</h3>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="smtp_username" value="<?php echo preg_replace('#@gmail.com#','',$config->smtp_username); ?>">@gmail.com
        <label class="checkbox">
        </label>
    	 <button type="button" onclick="setconfig($('#smtp_username').val(),'smtp_username');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="span3">
      <h3><?php echo $lang['Password']; ?> Gmail</h3>
    </div>
    <div class="span9">
      <div class="well">
        <input type="password" class="span3" id="smtp_password" value="<?php echo $config->smtp_password; ?>">
        <label class="checkbox">
        </label>
         <button type="button" onclick="setconfig($('#smtp_password').val(),'smtp_password');" class="btn"><?php echo $lang['Update']; ?></button>
             </div>
    </div>
    
  </div>
</section>
<?php } ?>
<?php if(Tools::checkACL($user->rank,ACL_SITE_SOCIAL)){ ?>
<section id="social">
  <div class="page-header">
    <h1><?php echo $lang['SocialNetwork']; ?></h1>
  </div>

  <div class="row">
    <div class="span3">
      <h3>Twitter</h3>
      <p><?php echo $lang['WhereIsTwitter']; ?></a></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="twittervalue" value="<?php echo $config->twitter; ?>" placeholder="<?php echo $lang['TwitterPlaceHolder']; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#twittervalue').val(),'twitter');" class="btn btn-info"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3>Facebook</h3>
      <p><?php echo $lang['WhereIsFacebook']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="facebookvalue" value="<?php echo $config->facebook; ?>" placeholder="<?php echo $lang['FacebookPlaceHolder']; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#facebookvalue').val(),'facebook');" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
</section>
<?php } ?>



<?php if(Tools::checkACL($user->rank,ACL_SITE_FB)) {  ?>
<section id="facebookconnect">
  <div class="page-header">
    <h1><?php echo $lang['FacebookConnect']; ?> <small><a href="http://habbophp.com/wiki/doku.php?id=wiki:facebookconnect" target="_blank"><?php echo $lang['HowToConfigFacebookConnect'];  ?></a></small></h1>
  </div>
 <div class="alert alert-error">
        	<?php echo $lang['NoFacebook']; ?>
      	</div>
    <div class="alert">
  <button class="close" data-dismiss="alert">×</button>
  <strong>Warning ! </strong> <?php echo $lang['CurlFacebbok'];  ?>
</div> 	
     
  <div class="row">
    <div class="span3">
      <h3>AppID</h3>
      <p><?php echo $lang['AppIDInfo']; ?></p>
    </div>
     <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="appid" value="<?php echo $config->fb_appid; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#appid').val(),'fb_appid');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="span3">
      <h3>AppSecret</h3>
      <p><?php echo $lang['AppSecretInfo']; ?></p>
    </div>
    <div class="span9">
      <div class="well">
        <input type="text" class="span3" id="fb_secret" value="<?php echo $config->fb_secret; ?>">
        <label class="checkbox">
        </label>
        <button type="button" onclick="setconfig($('#fb_secret').val(),'fb_secret');" class="btn"><?php echo $lang['Update']; ?></button>
      </div>
    </div>
  </div>
  
</section>
<?php } ?>
<?php include "includes/footer.php"; ?>