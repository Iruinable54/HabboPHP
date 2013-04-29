<?php $admin=true;   ?>

<div class="row-fluid">

</div>

<div class="row-fluid">
  <div class="span4">
  <h2>Statistiques</h2>
  <div class="btn-group">
  <a class="btn" data-toggle="modal" href="#visitors">Visiteurs</a>
  <a class="btn btn-primary" data-toggle="modal" href="#pages">Pages vues</a>
  <a class="btn" data-toggle="modal" href="#connections">Connexions</a>
  <a class="btn btn-primary" data-toggle="modal" href="#registers">Inscriptions</a>
  <h2>Aider HabboPHP</h2>
  <iframe src="http://release.habbophp.com/dons/dons.php" height="200" width="100%" style="height:200px;width:100%;"></iframe>
</div>
  </div>
  <div class="span8">
  <h2>Notes</h2>
  	<textarea style="width:100%" id="notes" ><?php echo $config->notes ; ?></textarea><br/>
  	 <button type="button" onclick="setconfig($('#notes').val(),'notes');" class="btn btn-primary"><?php echo $lang['Save']; ?></button>
  </div>
</div>



    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
<div id="visitors" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Modal header</h3>
  </div>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'Visites'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['visites']; ?>],
        <?php }?>
          
        ]);

        var options = {
 		 
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width:950px;height:500px;"></div>
   <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>

<div id="pages" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Modal header</h3>
  </div>    
        <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'Pages vues'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['pagesvues']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Pages vues',
 		  style: {padding:0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div2" style="width:560px!important;height:300px;"></div>
   <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>
    
<div id="registers" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Modal header</h3>
  </div>    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'Inscriptions'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['inscrits']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Inscriptions',
 		  style: {padding:0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div3" style="width:560px!important;height:500px;"></div>
       <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>

<div id="connections" class="modal" style="display:none;">
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Modal header</h3>
  </div>    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'Connexions'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY date  LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['connexions']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Connexion',
 		  style: {padding:0},
 		  'highlightDot' : 'last',
 		  'scaleColumns' : 'allfixed'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div4'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div4" style="width:560px!important;height:300px;"></div>
       <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>