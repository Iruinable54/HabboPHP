<?php include "includes/header.php"; ?>

<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Server']; ?></h1>
  <p class="lead"><?php echo $lang['ServerInfos']; ?></p>
  <div class="subnav">
    <ul class="nav nav-pills">
      <?php if(Tools::checkACL($user->rank,ACL_SERVER_CONFIG)) { ?><li><a href="#server"><?php echo $lang['ServerConfig']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SERVER_WORDS)) { ?><li><a href="#bannedwords"><?php echo $lang['BannedWords']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SERVER_MAINTENACE)) { ?><li><a href="#off"><?php echo $lang['Maintenance']; ?></a></li><?php } ?>
    </ul>
  </div>
</header>

<?php  if(Tools::checkACL($user->rank,ACL_SERVER_CONFIG)) { ?>
<section id="server">
  <div class="page-header">
    <h1><?php echo $lang['ServerConfig']; ?></h1>
  </div>

      <div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="inip"><?php echo $lang['AdressIP']; ?></label>
            <div class="controls">
              <input type="text" class="input-xlarge" value="<?php echo $config->server_ip ; ?>" id="inip"> :
              <input type="text" class="input" id="port" style="width:40px;" value="<?php echo $config->server_port ; ?>">
              <p class="help-block"><?php echo $lang['HelpIPEmu']; ?></p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="intexts">Texts</label>
            <div class="controls">
              <input type="text" class="input-xlarge" value="<?php echo $config->server_texts ; ?>" id="intexts">
              <p class="help-block"><?php echo $lang['HelpTexts']; ?></p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="invars">Vars</label>
            <div class="controls">
              <input type="text" class="input-xlarge" value="<?php echo $config->server_vars ; ?>" id="invars">
               <p class="help-block"><?php echo $lang['HelpVars']; ?></p>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inswf">SWF</label>
            <div class="controls">
              <input type="text" class="input-xlarge" value="<?php echo $config->server_swf ; ?>" id="inswf">
               <p class="help-block"><?php echo $lang['HelpSWF']; ?></p>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" onclick="editServer();setconfig($('#port').val(),'server_port');setconfig($('#inbase').val(),'server_base');" class="btn btn-primary"><?php echo $lang['Update']; ?></button>
          </div>
        </fieldset>
      </div>
</section>
<?php } ?>


<?php  if(Tools::checkACL($user->rank,ACL_SERVER_WORDS) && EMULATOR == 'phoenix') { ?>
<section id="bannedwords">
  <div class="page-header">
    <h1><?php echo $lang['BannedWords']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  	  <table id="tablewf" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><?php echo $lang['BannedWord']; ?></th>
            <th><?php echo $lang['Replacement']; ?></th>
            <th><?php echo $lang['Strict']; ?></th>
            <th><?php echo $lang['Options']; ?></th>
          </tr>
        </thead>
        <tbody id="addword">
          <?php
          $i=0;
          $query=mysql_query("SELECT * FROM wordfilter");
          while($row=mysql_fetch_array($query)){
          ?>
          <tr id="word-<?php echo str_replace(' ','',$row['word']); ?>">
            <td>
              <?php echo $row['word']; ?>
            </td>
            <td>
              <?php echo $row['replacement']; ?>
            </td>
            <td>
              <?php if($row['strict']==1){ echo $lang['Yes'];}else{echo $lang['No'];} ?>
            </td>
            <td>
            	<a href="javascript:void(0);" onclick="removewordfilter('<?php echo $row['word']; ?>','<?php echo str_replace(' ','',$row['word']); ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
            </td>
          </tr>
          <?php $i++; } 
          if($i==0) { ?>
          	<tr id="nowords"><td><?php echo $lang['NoWordsNow']; ?></td><td></td><td></td><td></td></tr>
          <?php } ?>
        </tbody>
      </table>
      
      <div class="control-group span3">
        <label class="control-label" for="textarea"><?php echo $lang['BannedWord']; ?></label>
        <div class="controls">
           <input type="text" id="word" placeholder="<?php echo $lang['Obligatory']; ?>" />
         </div>
      </div>
      
      <div class="control-group span3">
        <label class="control-label" for="textarea"><?php echo $lang['ReplaceBy']; ?></label>
        <div class="controls">
           <input type="text" id="new" placeholder="<?php echo $lang['Obligatory']; ?>" />
         </div>
      </div>
      
      <div class="control-group span3">
        <label class="control-label" for="textarea"><?php echo $lang['Strict']; ?> ?</label>
        <div class="controls">
           <select id="strict">
           	<option value="0"><?php echo $lang['No']; ?></option>
           	<option value="1"><?php echo $lang['Yes']; ?></option>
           </select>
         </div>
      </div>
      
      <div style="clear:both;"></div>
      
      <div class="form-actions">
        <button type="submit" onclick="addwordfilterPhoenix($('#word').val(),$('#new').val(),$('#strict').val());" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
  	</div>
  </div>
</section>
<?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SERVER_WORDS) && EMULATOR == 'butterfly') {?>
<section id="bannedwords">
  <div class="page-header">
    <h1><?php echo $lang['BannedWords']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  	  <table id="tablewf" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><?php echo $lang['BannedWord']; ?></th>
            <th><?php echo $lang['Options']; ?></th>
          </tr>
        </thead>
        <tbody id="addword">
          <?php
          $i=0;
          $query=mysql_query("SELECT * FROM room_swearword_filter");
          while($row=mysql_fetch_array($query)){
          ?>
          <tr id="word-<?php echo str_replace(' ','',$row['word']); ?>">
            <td>
              <?php echo $row['word']; ?>
            </td>
            <td>
            	<a href="javascript:void(0);" onclick="removewordfilter('<?php echo $row['word']; ?>','<?php echo str_replace(' ','',$row['word']); ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a>
            </td>
          </tr>
          <?php $i++; } 
          if($i==0) { ?>
          	<tr id="nowords"><td><?php echo $lang['NoWordsNow']; ?></td><td></td><td></td><td></td></tr>
          <?php } ?>
        </tbody>
      </table>
      
      <div class="control-group span3">
        <label class="control-label" for="textarea"><?php echo $lang['BannedWord']; ?></label>
        <div class="controls">
           <input type="text" id="word" placeholder="<?php echo $lang['Obligatory']; ?>" />
         </div>
      </div>
      
      <div style="display:none;" class="control-group span3">
        <label class="control-label" for="textarea"><?php echo $lang['ReplaceBy']; ?></label>
        <div class="controls">
           <input type="text" id="new" placeholder="<?php echo $lang['Obligatory']; ?>" />
         </div>
      </div>
      
      <div style="display:none;" class="control-group span3">
        <label class="control-label" for="textarea"><?php echo $lang['Strict']; ?> ?</label>
        <div class="controls">
           <select id="strict">
           	<option value="0"><?php echo $lang['No']; ?></option>
           	<option value="1"><?php echo $lang['Yes']; ?></option>
           </select>
         </div>
      </div>
      
      <div style="clear:both;"></div>
      
      <div class="form-actions">
        <button type="submit" onclick="addwordfilterButterfly($('#word').val(),$('#new').val(),$('#strict').val());" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
  	</div>
  </div>
</section>
<?php } ?>


<?php if(Tools::checkACL($user->rank,ACL_SERVER_MAINTENACE)){  ?>
<section id="off">
  <div class="page-header">
    <h1><?php echo $lang['Maintenance']; ?> <small><?php echo $lang['MaintenanceInfo']; ?></small></h1>
  </div>

  <div class="span11" style="text-align:center;">
  	<div class="form-actions">
        <button type="button" <?php if($config->maintenance == 'true'){ echo' disabled="disabled"' ;} ?> onclick="maintenanceon();" class="btn btn-success"><?php echo $lang['Activate']; ?></button>
        <button type="button" onclick="maintenanceoff();" <?php if($config->maintenance == 'false'){ echo' disabled="disabled"' ;} ?>  class="btn btn-danger"><?php echo $lang['Desactivate']; ?></button>
    </div>
  </div>
  <div style="clear:both;"></div>
</section>
<?php } ?>


<?php include "includes/footer.php"; ?>