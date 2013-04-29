<?php
require'../init.php';


if(!is_numeric($_REQUEST['page'])) $_REQUEST['page'] = 1 ;

$page = $_REQUEST['page'];

$start = ($page-1)*27;
$sql = "select * from habbophp_home_images_list order by class limit $start,27";
$rsd = mysql_query($sql);
?>

<?php
$time=0;
while ($rowcata = mysql_fetch_assoc($rsd)) {
$margin=0;
$height=100;
if($rowcata['height']<100) { $margin=100-$rowcata['height']; $margin=$margin/2; $height=100-$margin;}
?>
	<div onclick="addnewwidget('<?php echo $rowcata['class']; ?>','image');" id="astickerc<?php echo $rowcata['id']; ?>" style="cursor:pointer;opacity:0;padding:5px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border:1px solid #ccc;border-bottom:2px solid #ccc;height:<?php echo ceil($height); ?>px;float:left;padding-top:<?php echo floor($margin); ?>px;margin-left:10px;margin-bottom:10px;"><img src="<?php echo $config->url_site; ?>/web-gallery/homepage/stickers/<?php echo $rowcata['image']; ?>" style="width:40px;max-height:100px;" /></div>
	<script>
	setTimeout("$('#astickerc<?php echo $rowcata['id']; ?>').animate({ opacity: 1 });",<?php echo $time; ?>);
	</script>
<?php
$time=$time+50;
}?>

<script type="text/javascript">
jQuery(document).ready(function(){
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
	
});

function bring ( selecter )
{	
	jQuery('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '60px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}

</script>
<div style="clear:both"></div>