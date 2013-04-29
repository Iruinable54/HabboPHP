<?php
$admin=true;
function generateFigure($club=null,$gender=null){
//generateFigure function
//Generates a valid Habbo figure
//Copyright ® 2009 - Yifan Lu (www.yifanlu.com)
//Please do not remove this :-)
	if($gender == null){ if(rand(0,1) == 0){ $gender = "M"; }else{ $gender = "F"; } }
	if($club == null){ $club = (bool) rand(0,1); }
	$xml = simplexml_load_file('../includes/figuredata.xml');
	$figure = "";
	foreach($xml->sets->settype as $settype){
		if((string) $settype['mandatory'] == "1" || rand(0,1) == 1){
			$item['settype'] = $settype['type'];
			$palette = (int) $settype['paletteid'];
			$possible = array();
			foreach($settype->set as $xset){
				if($xset['gender'] != "U" && $xset['gender'] != $gender){ $fail = true; }
				if($xset['selectable'] == "0"){ $fail = true; }
				if($xset['colorable'] == "0"){ $color = false; }else{ $color = true; }
				if($xset['club'] == "1" && $club == false){ $fail = true; }
				if(isset($fail) && $fail != true){ $possible[] = array($xset['id'],$color); }
				$fail = false; $color = false;
			}
			$count = count($possible);
			$num = rand(0,$count-1);
			if(isset($possible[$num][1]))
			$item['set'] = $possible[$num][0];
			if(isset($possible[$num][1]) && $possible[$num][1] == false){ $item['color'] = ""; }else{
				$possible = array();
				foreach($xml->colors->palette[$palette-1]->color as $color){
					if($color['club'] == "1" && $club == false){ $fail = true; }
					if($color['selectable'] == "0"){ $fail = true; }
					if($fail != true){ $possible[] = $color['id']; }
					$fail = false;
				}
				$count = count($possible);
				$num = rand(0,$count-1);
				$item['color'] = $possible[$num];
			}
			$figure .= $item['settype']."-".$item['set']."-".$item['color'].".";
		}
	}
	$figure = substr($figure, 0, -1);
	return array($figure,$gender);
}
?>
<?php
$count = 6;
$i = 0;
while($i != $count){
	$i++;
	$figure = generateFigure(); $figure = $figure[0];
	$id = uniqid();

echo'  <li id="'.$id.'" class="liFigure" onclick="changeAvatar(\''.$figure.'\',\''.$id.'\')"> <span class="bgtop"></span>
        <span class="bgbottom"></span>
        <img   alt="'.$figure.'" src="http://www.habbr.info/habbo-imaging/avatarimage?figure='.$figure.'" width="64" class="avatar"  height="110"/>
    </li>';
   }
?>

     