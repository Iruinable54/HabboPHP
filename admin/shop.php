<?php include "includes/header.php"; ?>

<header class="jumbotron subhead" id="overview">
  <h1><?php echo $lang['Server']; ?></h1>
  <p class="lead"><?php echo $lang['ServerInfos']; ?></p>
  <div class="subnav">
    <ul class="nav nav-pills">
      <?php if(Tools::checkACL($user->rank,ACL_SHOP_STATS)) { ?><li><a href="#stats"><?php echo $lang['Statistics']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SHOP_VOUCHER)) { ?><li><a href="#voucher"><?php echo $lang['AddVoucher']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SHOP_CONFIG_MONEY)) {  ?><li><a href="#money"><?php echo $lang['ConfigMoney']; ?></a></li><?php } ?>
        <?php if(Tools::checkACL($user->rank,ACL_SHOP_RARES)) {  ?><li><a href="#rare"><?php echo $lang['ManageRareShop']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SHOP_BADGES)) {  ?><li><a href="#badge"><?php echo $lang['ManageBadgesShop']; ?></a></li><?php } ?>
         
      <?php if(Tools::checkACL($user->rank,ACL_SHOP_PAIEMENT)) { ?><li><a href="#paiement"><?php echo $lang['PaiementMethods']; ?></a></li><?php } ?>
      <?php if(Tools::checkACL($user->rank,ACL_SHOP_PAIEMENT_LOGS)) {  ?><li><a href="#logs"><?php echo $lang['PaymentsLogs']; ?></a></li><?php } ?>
    </ul>
  </div>
</header>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_STATS)) { ?>
<section id="stats">
  <div class="page-header">
    <h1><?php echo $lang['Statistics']; ?> <small><?php echo $lang['ChartShopInfos']; ?></small></h1>
  </div>
	<?php
$admin=true;
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'Achats'],
        <?php $query=mysql_query("SELECT * FROM habbophp_shop_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['value']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Achats',
 		  style: {padding:0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <div id="chart_div" style="width: 100%; height: 400px;padding:0;"></div>
</section>
<?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_VOUCHER)) { ?>
<section id="voucher">
  <div class="page-header">
    <h1><?php echo $lang['AddVoucher']; ?> <small><?php echo $lang['AboutVoucherCode']; ?></small></h1>
  </div>

      <div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['Amount']; ?></label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="amountv">
            </div>
          </div>
          
          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" onclick="addvoucher($('#amountv').val());"><?php echo $lang['Update']; ?></button>
          </div>
        </fieldset>
      </div>
</section>
<?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_CONFIG_MONEY)) { ?>
<section id="money">
  <div class="page-header">
    <h1><?php echo $lang['ConfigMoney']; ?></h1>
  </div>

      <div class="form-horizontal">
      	<input type="hidden" name="linkimagenews" id="linkimagenews" />
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['MoneyName']; ?></label>
            <div class="controls">
              <input type="text" value="<?php echo $config->moneyname; ?>" class="input-xlarge" id="moneyname">
            </div>
            
          </div>
           <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['VipPricePerMonth']; ?></label>
            <div class="controls">
              <input type="text" value="<?php echo $config->vipprice; ?>" class="vip" id="vip">
            </div>
            
          </div>
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['WinWinGet']; ?></label>
            <div class="controls">
              <input type="text" value="<?php echo $config->winwin; ?>" class="wget" id="wget">
            </div>
            
          </div>
          <div class="control-group">
            <label class="control-label" for="input01"><?php echo $lang['WinWinPrix']; ?></label>
            <div class="controls">
              <input type="text" value="<?php echo $config->winwinprix; ?>" class="wprix" id="wprix">
            </div>
            
          </div>
          
          <div class="control-group">
            <label class="control-label" for="input01">Bots price</label>
            <div class="controls">
              <input type="text" value="<?php echo $config->botsprix; ?>" class="bprix" id="bprix">
            </div>
            
          </div>
          
          <div class="control-group">
            <label class="control-label" for="input01">Look bots</label>
            <div class="controls">
              <input type="text" value="<?php echo $config->lookbots; ?>" class="lookbots" id="lookbots">
            </div>
            
          </div>
          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary" onclick="setconfig($('#moneyname').val(),'moneyname');setconfig($('#vip').val(),'vipprice');setconfig($('#wget').val(),'winwin');setconfig($('#wprix').val(),'winwinprix');setconfig($('#bprix').val(),'botsprix');setconfig($('#lookbots').val(),'lookbots');"><?php echo $lang['Update']; ?></button>
          </div>
        </fieldset>
      </div>
</section>
<?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_RARES)) { ?>
<section id="rare">

<style>
.label-normal{
	width: 150px;
	float: left;
}
</style>

 <div class="modal hide fade badges"  id="raresadd">
		  <div class="modal-header">
		    <a class="close" data-dismiss="modal">×</a>
		    <h3><?php echo $lang['ManageRares']; ?></h3>
		  </div>
		  <div class="modal-body">
		  <div class="form-actions">
		  	 <label class="label-normal">Base Item : </label><input type="text" id="oidRare"  /><br/>
		  	 <label class="label-normal">Nom : </label><input type="text" id="nameRare"  /><br />
		  	 <label class="label-normal">Prix : </label><input type="text" id="prixRare"  /><br />
		  	 <label class="label-normal">Image ( URL ): </label><input type="text" id="imageRare"/><br />
        <button type="submit" onclick="addRareManage();" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
		    
	
		  </div>
		<div class="modal-footer">
		    <a data-dismiss="modal" class="btn">Close</a>
		  </div>
	</div>

  <div class="page-header">
    <h1><?php echo $lang['ManageRares']; ?></h1>
  </div>
  
  
	
			

<div class="row">
  	<div class="span12">
  		<button type="button" data-toggle="modal" href="#raresadd" class="btn btn-success big btn-big"><?php echo $lang['AddRare']; ?></button><br/><br/>
  		 <table  class="table table-bordered table-striped">
  <thead>
    <tr style="background:white;">
      <th><?php echo $lang['IDRare']; ?></th>
      <th><?php echo $lang['Amount']; ?></th>
 
      <th style="text-align:center;"><?php echo $lang['Action']; ?></th>
    </tr>
  </thead>
  <tbody id="newbadge">
  <?php
   $dataRare = $db->query('SELECT * FROM habbophp_shop_rares  ORDER BY id',true);
   foreach($dataRare as $data){
  ?>
    <tr id="r<?php echo $data['id']; ?>">
      <td><?php echo $data['oid'] ;?></td>
      <td><?php echo $data['prix'] ;?> <?php echo $config->moneyname ; ?></td>
  
      <td style="text-align:center;"><button type="button" onclick="deleteRareManager(<?php echo $data['id']; ?>)" class="btn btn-danger big btn-big"><?php echo $lang['Delete']; ?></button></td>
    </tr>
    
   
    <?php } ?>
  </tbody>
</table>
  	</div>
  </div>

      

</section><?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_BADGES)) { ?>
<section id="badge">
  <div class="page-header">
    <h1><?php echo $lang['ManageBadgesShop']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  		<button type="button" data-toggle="modal" href="#badges" class="btn btn-success big btn-big"><?php echo $lang['AddBadges']; ?></button><br><br/>
  		 <table  class="table table-bordered table-striped">
  <thead>
    <tr style="background:white;">
      <th><?php echo $lang['IDBadge']; ?></th>
      <th><?php echo $lang['Amount']; ?></th>
      <th style="text-align:center;"><?php echo $lang['Preview']; ?></th>
      <th style="text-align:center;"><?php echo $lang['Action']; ?></th>
    </tr>
  </thead>
  <tbody id="newbadge">
  <?php
   $req = mysql_query('SELECT * FROM habbophp_shop_badges  ORDER BY id');
   while($data = mysql_fetch_assoc($req)){
  ?>
    <tr id="b<?php echo $data['id']; ?>">
      <td><?php echo $data['idbadge'] ;?></td>
      <td><?php echo $data['amount'] ;?></td>
      <td style="text-align:center;"><img src="http://images.habbo.com/c_images/album1584/<?php echo $data['idbadge'] ; ?>.gif" alt="<?php echo $data['idbadge'] ; ?>"></img></td>
      <td style="text-align:center;"><button type="button" onclick="deleteBadgesManager(<?php echo $data['id']; ?>)" class="btn btn-danger big btn-big"><?php echo $lang['Delete']; ?></button></td>
    </tr>
    
   
    <?php } ?>
  </tbody>
</table>
  	</div>
  </div>
  <div class="modal hide fade badges"  id="badges">
		  <div class="modal-header">
		    <a class="close" data-dismiss="modal">×</a>
		    <h3><?php echo $lang['ManageBadges']; ?></h3>
		  </div>
		  <div class="modal-body">
		
		    	
		    	<div class="form-actions">
      	<input type="text" id="badgesB" placeholder="<?php echo $lang['BadgeID']; ?>" />
      	<input type="text" id="prix" placeholder="<?php echo $lang['Amount']; ?>" /><br />
        <button type="submit" onclick="addbadgesManage($('#badgesB').val(),$('#prix').val());" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
      </div>
		    
	
		  </div>
		<div class="modal-footer">
		    <a data-dismiss="modal" class="btn">Close</a>
		  </div>
	</div>
</section>


<?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_PAIEMENT)) { ?>
<section id="paiement">
  <div class="page-header">
    <h1><?php echo $lang['ConfigPayments']; ?> <small><a href="http://habbophp.com/wiki/doku.php?id=wiki:moyensdepaiements" target="_blank"><?php echo $lang['HowToConfigShop'];  ?></a></small></h1>
  </div>
  <div class="row">
  	<div class="span12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#starpass" data-toggle="tab">Starpass</a></li>
			<li><a href="#allopass" data-toggle="tab">Allopass</a></li>
			<li><a href="#paypal" data-toggle="tab">Paypal</a></li>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane active" id="starpass">
					<div style="<?php if($config->starpassacc!="" AND $config->starpassdoc!="" ) { ?>display:none;<?php } ?>" class="form-actions" id="starpassa"><a href="javascript:void(0);" onclick="$('#starpassa').hide();$('#starpassform').show();" class="btn btn-success"><?php echo $lang['Activate']; ?></a></div>
				<div id="starpassform" style="<?php if($config->starpassacc=="" AND $config->starpassdoc=="" ) { ?>display:none;<?php } ?>">
					<div class="control-group">
           			  <label class="control-label" for="input01"><?php echo $lang['StarpassAccount']; ?> (IPP)</label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" value="<?php echo $config->starpassacc; ?>" id="starpassacc">
          			  </div>
          			</div>
          			
					<div class="control-group">
           			  <label class="control-label" for="input01"><?php echo $lang['StarpassDocument']; ?> (IDP)</label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" value="<?php echo $config->starpassdoc; ?>" id="starpassdoc">
          			  </div>
          			</div>
          			
          			<div class="control-group">
           			  <label class="control-label" for="input01"><?php echo $lang['AmountOfMoneyAfterBuy']; ?></label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" value="<?php echo $config->starpassamount; ?>" id="starpassamount">
          			  </div>
          			</div>
          			
          			
          			
					<div class="form-actions">
						<a href="javascript:void(0);" onclick="setconfig($('#starpassacc').val(),'starpassacc');setconfig($('#starpassdoc').val(),'starpassdoc');setconfig($('#starpassamount').val(),'starpassamount');" class="btn btn-primary"><?php echo $lang['Update']; ?></a>
						<a href="javascript:void(0);" onclick="setconfig('','starpassacc');setconfig('','starpassdoc');setconfig('','starpassamount');$('#starpassa').show();$('#starpassform').hide();" class="btn btn-danger"><?php echo $lang['Desactivate']; ?></a>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="allopass">
					<div style="<?php if($config->allopassauth!="") { ?>display:none;<?php } ?>" class="form-actions" id="allopassa"><a href="javascript:void(0);" onclick="$('#allopassa').hide();$('#allopassform').show();" class="btn btn-success"><?php echo $lang['Activate']; ?></a></div>
				<div id="allopassform" style="<?php if($config->allopassauth=="") { ?>display:none;<?php } ?>">
					<div class="control-group">
           			  <label class="control-label" for="input01">Allopass AUTH</label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" id="allopassids" value="<?php echo $config->allopassauth; ?>">
          			  </div>
          			</div>
          			
					
          			
          			<div class="control-group">
           			  <label class="control-label" for="input01"><?php echo $lang['AmountOfMoneyAfterBuy']; ?></label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" value="<?php echo $config->allopassamount; ?>" id="allopassamount">
          			  </div>
          			</div>
          			
					<div class="form-actions">
						<a href="javascript:void(0);" onclick="setconfig($('#allopassids').val(),'allopassauth');setconfig($('#allopassamount').val(),'allopassamount');" class="btn btn-primary"><?php echo $lang['Update']; ?></a>
						<a href="javascript:void(0);" onclick="setconfig('','allopassauth');setconfig('','allopassamount');$('#allopassa').show();$('#allopassform').hide();" class="btn btn-danger"><?php echo $lang['Desactivate']; ?></a>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="paypal">
				<div style="<?php if($config->paypalemail!="") { ?>display:none;<?php } ?>" class="form-actions" id="paypala"><a href="javascript:void(0);" onclick="$('#paypala').hide();$('#paypalform').show();" class="btn btn-success"><?php echo $lang['Activate']; ?></a></div>
				<div id="paypalform" style="<?php if($config->paypalemail=="") { ?>display:none;<?php } ?>">
					<div class="control-group">
           			  <label class="control-label" for="input01">Paypal Email</label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" id="paypalemail" value="<?php echo $config->paypalemail; ?>">
          			  </div>
          			</div>
          			
					<div class="control-group">
           			  <label class="control-label" for="input01"><?php echo $lang['PaypalPricePerBuy']; ?></label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" id="paypalprice" value="<?php echo $config->paypalprice; ?>">
          			    
          			    <select id="paypalmoney">
          			    	<option value="<?php echo $config->paypalmoney; ?>"><?php echo $config->paypalmoney; ?></option>
          			    	<option value="EUR">Euro(s)</option>
          			    	<option value="USD">Dollar(s)</option>
          			    	<option value="GBP">Pound(s) Sterling</option>
          			    	<option value="BRL">Real(s)</option>
          			    	<option value="CAD">Canadian dollar(s)</option>
          			    	<option value="AUD">Australian dollar(s)</option>
          			    </select>
          			    <p class="help-block"><?php echo $lang['PaypalInfoPriceUseDot']; ?></p>
          			  </div>
          			</div>
          			
          			<div class="control-group">
           			  <label class="control-label" for="input01"><?php echo $lang['AmountOfMoneyAfterBuy']; ?></label>
        		      <div class="controls">
          			    <input type="text" class="input-xlarge" value="<?php echo $config->paypalamount; ?>" id="paypalamount">
          			  </div>
          			</div>
          			
					<div class="form-actions">
						<a href="javascript:void(0);" onclick="setconfig($('#paypalemail').val(),'paypalemail');setconfig($('#paypalprice').val(),'paypalprice');setconfig($('#paypalamount').val(),'paypalamount');setconfig($('#paypalmoney').val(),'paypalmoney');" class="btn btn-primary"><?php echo $lang['Update']; ?></a>
						<a href="javascript:void(0);" onclick="setconfig('','paypalemail');$('#paypala').show();$('#paypalform').hide();" class="btn btn-danger"><?php echo $lang['Desactivate']; ?></a>
					</div>
				</div>
			</div>
		</div>

  	</div>
  </div>
</section>
<?php } ?>

<?php if(Tools::checkACL($user->rank,ACL_SHOP_PAIEMENT_LOGS)) { ?>
<section id="logs">
  <div class="page-header">
    <h1><?php echo $lang['PaymentsLogs']; ?></h1>
  </div>
  <div class="row">
  	<div class="span12">
  		<input type="text" name="search" value="" id="id_search" placeholder="<?php echo $lang['Search']; ?>" />

 <table  class="table table-bordered table-striped">
  <thead>
    <tr style="background:white;">
      <th><?php echo $lang['Username']; ?></th>
      <th><?php echo $lang['PaiementMethod']; ?></th>
      <th><?php echo $lang['Date']; ?></th>
    </tr>
  </thead>
  <tbody>
  <?php
   $req = mysql_query('SELECT * FROM habbophp_paiement_logs ORDER BY id DESC LIMIT 100');
   while($data = mysql_fetch_assoc($req)){
  ?>
    <tr id="l<?php echo $data['id']; ?>">
      <td><?php echo $data['username'] ;?></td>
      <td><?php echo $data['MoyenDePaiement'] ;?></td>
      <td><?php echo $data['date']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

  	</div>
  </div>
</section>
<?php } ?>

<div class="modal hide fade" id="voucherm">
  <div class="modal-body">
    <p id="voucherv"></p>
  </div>
  <div class="modal-footer">
    <a href="javascript:void(0);" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>


<?php include "includes/footer.php"; ?>