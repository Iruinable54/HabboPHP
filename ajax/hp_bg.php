<?php
require '../init.php';

$p = $_REQUEST['page'];

$page = substr($p,-strlen($p)+2); 

$start = ($page-1)*10;
$sql = "select * from habbophp_home_backgrounds_list order by class limit $start,10";
$rsd = mysql_query($sql);
?>

<?php
$time=0;
while ($rowcata = mysql_fetch_assoc($rsd)) {
?>
	<div class="b_<?php echo strtolower($rowcata['class']); ?>" onclick="updatebg('b_<?php echo strtolower($rowcata['class']); ?>');" id="astickerc<?php echo $rowcata['id']; ?>" style="cursor:pointer;padding:5px;-moz-border-radius:5px;margin-bottom:3px;margin-right:12px;-webkit-border-radius:5px;border-radius:5px;border:1px solid #ccc;border-bottom:2px solid #ccc;float:left;width:90px!important;height:162px!important;"></div>
<?php
}?>
<div style="clear:both"></div>