<?php

require '../includes/init.php' ;

$per_page = 5;
$sqlc = "show columns from habbophp_news_images";
$rsdc = mysql_query($sqlc);
$cols = mysql_num_rows($rsdc);
$page = $_REQUEST['page'];

$start = ($page-1)*5;
$sql = "select * from habbophp_news_images order by id limit $start,5";
$rsd = mysql_query($sql);
?>
<br />
<table><tr>
<?php
while ($rows = mysql_fetch_assoc($rsd))
{?>
	<td><img src="<?php echo $config->url_site."/images/news/".$rows['image']; ?>" class="imagenews" onclick="$('.imagenews').removeClass('imagenewsa');$(this).addClass('imagenewsa');$('#linkimagenews').val($(this).attr('src'));" style="margin-left:10px;padding:5px;cursor:pointer;border:1px solid #dfdfdf;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;max-height:100px;"/></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php
}?>
<td>&nbsp;&nbsp;</td>
</tr></table>