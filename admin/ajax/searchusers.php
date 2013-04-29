<?php
define('RANK','6');
require '../includes/init.php';
$s=safe($_GET['search'],'SQL');
$o=0;
$c = (filter_var($s,FILTER_VALIDATE_EMAIL)) ? 'mail' : (filter_var($s,FILTER_VALIDATE_IP) ? 'ip' : 'username');


if($c == 'mail')
	$query=mysql_query("SELECT * FROM users WHERE mail LIKE '%".$s."%'");
elseif($c == 'ip')
	$query=mysql_query("SELECT * FROM users WHERE ip_last='".$s."' OR ip_reg='".$s."'");
else
	$query=mysql_query("SELECT * FROM users WHERE username LIKE '%".$s."%'");


	while($row=mysql_fetch_array($query)){
	
	$req = mysql_query('SELECT * FROM habbophp_users_jetons WHERE uid="'.safe($row['id'],'SQL').'"');
	$dataJ = mysql_fetch_assoc($req);
	$req = mysql_query('SELECT * FROM habbophp_users_vip WHERE uid="'.safe($row['id'],'SQL').'"');
 	$dataV = mysql_fetch_assoc($req);
	
		$o++;
		$id=safe($row['id'],'HTML');
		$username=safe($row['username'],'HTML');
		$mail=safe($row['mail'],'SQL');
		$rank=safe($row['rank'],'SQL');
		$lastonline= safe($row['last_online'],'SQL');
		$ip_last=safe($row['ip_last'],'SQL');
		$ip_reg=safe($row['ip_reg'],'SQL');
		?>
		<div class="span1 well" style="width:100px">
			<center>
			<h3 style="overflow: hidden;"><?php echo safe($username,'HTML'); ?></h3>
			<img src="http://www.habbr.info/habbo-imaging/avatarimage?figure=<?php echo $row['look'] ; ?>&direction=3&head_direction=3&gesture=sml&action=wav">
			<a data-toggle="modal" href="#profil<?php echo $id; ?>" style="margin-top:14px;" class="btn btn-primary"><?php echo $lang['Profil']; ?></a>
			<a data-toggle="modal" href="#ban<?php echo $id; ?>" style="margin-top:14px;" class="btn btn-danger"><?php echo $lang['Ban']; ?></a>
			<?php if($user->rank>=7){ ?><a data-toggle="modal" href="#badges<?php echo $id; ?>" style="margin-top:14px;" class="btn"><?php echo $lang['Badges']; ?></a><?php } ?>
			</center>
		</div>
		<div class="modal hide fade" id="profil<?php echo $id; ?>">
		  <div class="modal-header">
		    <a class="close" data-dismiss="modal">×</a>
		    <h3><?php echo $lang['Profil'].' "'.safe($username,'HTML').'"'; ?></h3>
		  </div>
		  <div class="modal-body">
		    <p>
		    	<div class="control-group">
          		  <label class="control-label" for="input01">ID</label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" disabled="disabled" id="inid_<?php echo $id ; ?>" value="<?php echo $id; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['Username']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" id="inusername_<?php echo $id ; ?>" value="<?php echo safe($username,'HTML'); ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['Password']; ?> ( Laissez vide pour ne pas changer )</label>
        	      <div class="controls">
          		    <input type="password" class="input-xlarge" id="inpassword_<?php echo $id ; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['Mail']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" id="inmail_<?php echo $id ; ?>" value="<?php echo $mail; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['Credits']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" id="incredits_<?php echo $id ; ?>" value="<?php echo $row['credits']; ?>">
                  </div>
        		</div>
        		<?php if(isset($dataV['uid'])){ ?>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['VipExpire']; ?></label>
        	      <div class="controls">
          		    <input type="text"disabled="disabled" class="input-xlarge" id="incredits_<?php echo $id ; ?>" value="<?php echo date('d/m/Y',$dataV['expire']); ?>">
                  </div>
        		</div>
        		<?php } ?>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo safe($config->moneyname,'HTML') ; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" id="injetons_<?php echo $id ; ?>" value="<?php echo $dataJ['jetons'] ; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['VipPoints']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" id="invippoints_<?php echo $id ; ?>" value="<?php echo $row['vip_points']; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['Mission']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" id="inmotto_<?php echo $id ; ?>" value="<?php echo $row['motto']; ?>">
                  </div>
        		</div>
        		<div class="control-group" style="<?php if($user->rank<7){ ?>display:none;<?php } ?>">
          		  <label class="control-label" for="input01"><?php echo $lang['Rank']; ?></label>
        	      <div class="controls">
        	      	<?php $rankl="Rank".$rank; ?>
          		    <select name="inrank" id="inrank_<?php echo $id ; ?>">
          		    	<option value="<?php echo $rank; ?>"><?php echo $lang[$rankl]; ?></option>
          		    	<?php if($user->rank>=7){ ?><option value="1"><?php echo $lang['Rank1']; ?></option>
          		    	<option value="2"><?php echo $lang['Rank2']; ?></option>
          		    	<option value="3"><?php echo $lang['Rank3']; ?></option>
          		    	<option value="4"><?php echo $lang['Rank4']; ?></option>
          		    	<option value="5"><?php echo $lang['Rank5']; ?></option>
          		    	<option value="6"><?php echo $lang['Rank6']; ?></option>
          		    	<option value="7"><?php echo $lang['Rank7']; ?></option>
          		    	<?php } ?>
          		    </select>
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['LastOnline']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" disabled="disabled" value="<?php echo $lastonline; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['LastIP']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" disabled="disabled" value="<?php echo $ip_last; ?>">
                  </div>
        		</div>
        		<div class="control-group">
          		  <label class="control-label" for="input01"><?php echo $lang['RegisterIP']; ?></label>
        	      <div class="controls">
          		    <input type="text" class="input-xlarge" disabled="disabled" value="<?php echo $ip_reg; ?>">
                  </div>
        		</div>
		    </p>
		  </div>
		  <div class="modal-footer">
		    <a data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
		    <button onclick="ChangeUsers($('#inid_<?php echo $id ; ?>').val());" type="button" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
		  </div>
		</div>
		
		
		<div class="modal hide fade ban" id="ban<?php echo $id; ?>">
		  <div class="modal-header">
		    <a class="close" data-dismiss="modal">×</a>
		    <h3><?php echo $lang['Ban'].' "'.safe($username,'HTML').'"'; ?></h3>
		  </div>
		  <div class="modal-body">
		    <p>
		    	<center>
		    	<input type="text" id="reason<?php echo $id; ?>" placeholder="<?php echo $lang['Reason']; ?>" />
		    <select id="duree<?php echo $id; ?>">
      		      		<option value="">Durée</option>
      		      		<option value="<?php echo 3600 ; ?>">1 heure</option>
      		      		<option value="<?php echo 3600 * 24 * 7 ; ?>">1 jours</option>
   						<option value="<?php echo 3600 * 24 * 7 ; ?>">7 jours</option>
   						<option value="<?php echo 3600 * 24 * 7 * 4; ?>">1 mois</option>
   						<option value="<?php echo 3600 * 24 * 7 * 4 * 6; ?>">6 mois</option>
   						<option value="<?php echo 3600 * 24 * 7 * 4 * 12; ?>">1 ans</option>
   						<option value="<?php echo 3600 * 24 * 7 * 4 * 12 * 10; ?>">Infini</option>
      	</select><br />
		    	<button onclick="ban('user', '<?php echo safe($username,'HTML'); ?>', $('#reason<?php echo $id; ?>').val(),$('#duree<?php echo $id; ?>').val());" type="button" class="btn btn-warning big btn-big"><?php echo $lang['BanUser']; ?></button>
		    	<button onclick="ban('ip', '<?php echo safe($username,'HTML'); ?>', $('#reason<?php echo $id; ?>').val(),$('#duree<?php echo $id; ?>').val());"  type="button" class="btn btn-danger big btn-big"><?php echo $lang['BanIP']; ?></button></center>
		    </p>
		  </div>
		  <div class="modal-footer">
		    <a data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
		  </div>
		</div>
		
		<?php if($user->rank>=7){ ?><div class="modal hide fade" id="badges<?php echo $id; ?>">
		  <div class="modal-header">
		    <a class="close" data-dismiss="modal">×</a>
		    <h3><?php echo $lang['BadgesOf'].' "'.safe($username,'HTML').'"'; ?></h3>
		  </div>
		  <div class="modal-body">
		    <p>
		    
  <div class="">
  	<div class="">
  	  <table id="tablewf" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:250px;"><?php echo $lang['Badges']; ?></th>
            <th style="width:100px;"></th>
          </tr>
        </thead>
        <tbody id="addbadge<?php echo $id; ?>">
          <?php
          $iff=0;
          $queryd=mysql_query("SELECT * FROM user_badges WHERE user_id=".$id."");
          while($row=mysql_fetch_array($queryd)){
          ?>
          <tr id="badge-<?php echo str_replace(' ','',$row['badge_id']); ?>">
            <td>
              <?php echo $row['badge_id']; ?>
            </td>
            <td>
            	<a href="javascript:void(0);" onclick="removebadges(<?php echo $id; ?>,'<?php echo str_replace(' ','',$row['badge_id']); ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
            </td>
          </tr>
          <?php $iff++; } 
          if($iff==0) { ?>
          	<tr id="nobadges<?php echo $id; ?>"><td><?php echo $lang['NoBadgesNow']; ?></td><td></td></tr>
          <?php } ?>
        </tbody>
      </table>
      
      <input type="hidden" id="uid<?php echo $id; ?>" value="<?php echo $id; ?>" />
      
      <div class="form-actions">
      	<input type="text" id="bid<?php echo $id; ?>" placeholder="<?php echo $lang['BadgeID']; ?>" /><br />
        <button type="submit" onclick="addbadges($('#uid<?php echo $id; ?>').val(),$('#bid<?php echo $id; ?>').val());" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
  	</div>
</div>
		    </p>
		  </div>
		  <div class="modal-footer">	  
		    <a data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
		  </div>
		</div><?php } ?>
		<?php
	}
if($o==0) {
	echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>Aucuns r&eacute;sultats pour la recherche "'.$s.'"</div>';
}
?>
<div style="clear:both;"></div>
