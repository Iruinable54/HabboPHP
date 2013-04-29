<?php $admin=true;   ?>
<?php include "includes/header.php"; ?>
<div class="row-fluid">

</div>

<div class="row-fluid">
  <div class="span4">
  <?php if(Tools::checkACL($user->rank,ACL_INDEX_STATS)) : ?>
  <h2>Statistiques</h2>
  <div class="btn-group">
  	<a class="btn" data-toggle="modal" href="#visitors"><?php echo $lang['Visites']; ?></a>
  	<a class="btn btn-primary" data-toggle="modal" href="#pages"><?php echo $lang['PagesViews']; ?></a>
  	<a class="btn" data-toggle="modal" href="#connections"><?php echo $lang['Connections']; ?></a>
  	<a class="btn btn-primary" data-toggle="modal" href="#registers"><?php echo $lang['Registers']; ?></a>
  </div>
  <br />
 <?php endif ; ?>
  <h2><?php echo $lang['HelpHabboPHP']; ?></h2>
  <iframe src="http://release.habbophp.com/dons/dons.php?lang=<?php echo $config->langadmin; ?>" width="100%" border="0" scrolling="no" style="border:0;height:280px;width:100%;"></iframe>
  </div>
  <div class="span8">
    <?php if(Tools::checkACL($user->rank,ACL_INDEX_NOTES)) : ?>
  <h2><?php echo $lang['Notes']; ?></h2>
  	<textarea style="width:100%" id="notes" ><?php echo $config->notes ; ?></textarea><br/>
  	<button type="button" onclick="setconfig($('.nicEdit-main').html(),'notes');" class="btn btn-primary"><?php echo $lang['Save']; ?></button>
  <?php endif ;?>
  <br /><br />
 
  <h2><?php echo $lang['NewsFromHabboPHP']; ?></h2>
  <ul class="nav nav-pills">
  	<li class="active"><a href="#home" data-toggle="tab">Twitter HabboPHP</a></li>
  		<li ><a href="http://habbophp.com/forum" target="_blank" >Forum <?php echo $lang['Help']; ?></a></li>
  </ul>
  
	<div style="margin-left:20px;" class="tab-content">
	  <div class="tab-pane active well" id="home"><div id="lasttweet"><?php echo $lang['Loading']; ?>…</div><div style="float:right;"><a href="" style="font-family:georgia;font-style:italic;"><?php echo $lang['FollowHabboPHPonTwitter']; ?></a></div><div style="clear:both;"></div></div>
	</div>
  </div>
   </div>

<style>
.modal {
position: fixed;
top: 50%;
left: 50%;
z-index: 1050;
max-height: 700px;
overflow: auto;
width: 800px;
margin: -250px 0 0 -400px;
background-color: white;
border: 1px solid #999;
border: 1px solid rgba(0, 0, 0, 0.3);
-webkit-border-radius: 6px;
-moz-border-radius: 6px;
border-radius: 6px;
-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
-moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
-webkit-background-clip: padding-box;
-moz-background-clip: padding-box;
background-clip: padding-box;
}
</style>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
<div id="visitors" class="modal"  style="display:none;">
<div class="modal-header" >
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $lang['Visites']; ?></h3>
  </div>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', '<?php echo $lang['Visites']; ?>'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['visites']; ?>],
        <?php }?>
          
        ]);

        var options = {
 		 	width:780,
 		 	height:360
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width:780px;height:360px"></div>
   <div class="modal-footer">
    <a href="#" data-dismiss="modal"   class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>

<div id="pages" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $lang['PagesViews']; ?></h3>
  </div>    
        <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', '<?php echo $lang['PagesViews']; ?>'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['pagesvues']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Pages vues',
          width:780,
 		 height:360
 		  
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
    
     <div id="chart_div2" style="width:780px;height:360px"></div>
   <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>
    
<div id="registers" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $lang['Registers']; ?></h3>
  </div>    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', '<?php echo $lang['Registers']; ?>'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['inscrits']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Inscriptions',
 			width:780,
 		 	height:360
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div3" style="width:780px;height:360px"></div>
       <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>

<div id="connections" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $lang['Connections']; ?></h3>
  </div>    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', '<?php echo $lang['Connections']; ?>'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['connexions']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Connexion',
 		  width:780,
 		 	height:360,
 		  'highlightDot' : 'last',
 		  'scaleColumns' : 'allfixed'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div4'));
        chart.draw(data, options);
      }
    </script>
    
     <div id="chart_div4" style="width:780px;height:360px"></div>
       <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>

<?php include "includes/footer.php"; ?>