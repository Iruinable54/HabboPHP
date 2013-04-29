<?php
$admin=true;
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Jour', 'Visites'],
        <?php $query=mysql_query("SELECT * FROM habbophp_stats ORDER BY id DESC LIMIT 15"); 
		while($row=mysql_fetch_array($query)) { ?>
          
          ['<?php $datetime = strtotime($row['date']); echo date("d/m/Y", $datetime); ?>',  <?php echo $row['visites']; ?>],
        <?php }?>
          
        ]);

        var options = {
          title: 'Visites',
 		  style: {padding:0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>