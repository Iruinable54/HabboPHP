<?php

function safe($val, $type = 'SQL')
{
if($type == NULL) $type = 'SQL' ;
   if ($type == 'HTML')
   {
       $val = strip_tags($val);
       return htmlspecialchars($val);
   }
       
   else if ($type == 'SQL')
   {
       if (get_magic_quotes_gpc())
           $val = stripslashes($val); 	
      		return mysql_real_escape_string($val) ;
	}
   return (false);
}

function hashMe($str)
			{
				$config_hash = "xCg532%@%gdvf^5DGaa6&*rFTfg^FD4\$OIFThrR_gh(ugf*/";
				$str = safe(sha1($str . $config_hash),'SQL');
				return $str;
			}

function redirection($url){
	if(!headers_sent())
		header('Location:'.$url);
	else
		echo '<script>window.location.replace("'.$url.'");</script>' ;
	exit ;
}

	function FullDate($str)
			{
				$H = date('H');
				$i = date('i');
				$s = date('s');
				$m = date('m');
				$d = date('d');
				$Y = date('Y');
				$j = date('j');
				$n = date('n');
				
				switch ($str)
					{
						case "day":
							$str = $j;
							break;
						case "month":
							$str = $m;
							break;
						case "year":
							$str = $Y;
							break;
						case "today":
							$str = $d;
							break;
						case "full":
							$str = date('d-m-Y H:i:s',mktime($H,$i,$s,$m,$d,$Y));
							break;
						case "datehc":
							$str = "".$j."-".$n."-".$Y."";
							break;
						default:
							$str = date('d-m-Y',mktime($m,$d,$Y));
							break;
					}
					
				return $str;
			}
			
/*function youtube($y){
$url = $y;
parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
return '<object wmode="opaque" width="210" height="136"><param name="wmode" value="http://www.youtube.com/v/'.$my_array_of_vars['v'].'?version=3&amp;hl=fr_FR" wmode="opaque"></param><param wmode="opaque" name="wmode" value="true"></param><param wmode="opaque" name="wmode" value="always"></param><embed src="http://www.youtube.com/v/'.$my_array_of_vars['v'].'?version=3&amp;hl=fr_FR" type="application/x-shockwave-flash" width="210" height="136" allowscriptaccess="always"  wmode="opaque" allowfullscreen="true"></embed></object>';
} */

function youtube($url,$return='embed',$width='',$height='',$rel=0){
	$urls = parse_url($url);

	//url is http://youtu.be/xxxx
	if(isset($urls['host']) && $urls['host'] == 'youtu.be' ){
		$id = ltrim($urls['path'],'/');
	}
	//url is http://www.youtube.com/embed/xxxx
	else if(isset($urls['path']) && strpos($urls['path'],'embed') == 1){
		$id = end(explode('/',$urls['path']));
	}
	 //url is xxxx only
	else if(strpos($url,'/')===false){
		$id = $url;
	}
	//http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
	//url is http://www.youtube.com/watch?v=xxxx
	else{
	if(isset($urls['query'])){
		parse_str($urls['query']);
		$id = $v;
		if(!empty($feature)){
			$id = end(explode('v=',$urls['query']));
		}
	}
	}
	//return embed iframe
	if(isset($id)){
	if($return == 'embed' && isset($id)){
		//return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen></iframe>';
		return '<object wmode="opaque" width="210" height="136"><param name="wmode" value="http://www.youtube.com/v/'.$id.'?version=3&amp;hl=fr_FR" wmode="opaque"></param><param wmode="opaque" name="wmode" value="true"></param><param wmode="opaque" name="wmode" value="always"></param><embed src="http://www.youtube.com/v/'.$id.'?version=3&amp;hl=fr_FR" type="application/x-shockwave-flash" width="210" height="136" allowscriptaccess="always"  wmode="opaque" allowfullscreen="true"></embed></object>';
	}
	//return normal thumb
	else if($return == 'thumb'){
		return 'http://i1.ytimg.com/vi/'.$id.'/default.jpg';
	}
	//return hqthumb
	else if($return == 'hqthumb'){
		return 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg';
	}
	// else return id
	else{
		return $id;
	}
	}
}

function bbcode($text)
{
 
$text=safe($text,'HTML');
if(preg_match('#youtube#',$text)){
$youtube = preg_replace('!\[youtube\](.+)\[/youtube\]!isU', '$1',$text);
if(isset($youtube) && !empty($youtube)){$text = youtube($youtube,'embed');}
}
$text = preg_replace('!\[quote\](.+)\[/quote\]!isU', '<div class="citationforum">$1</div>', $text);

$text = preg_replace("!\[quote\=(.+)\](.+)\[\/quote\]!isU", "<div class='citationforum'><strong>$1 :</strong><br>$2</div>", $text); 

$text = preg_replace('!\[b\](.+)\[/b\]!isU', '<strong>$1</strong>', $text);
$text = preg_replace('!\[i\](.+)\[/i\]!isU', '<em>$1</em>', $text);
$text = preg_replace('!\[u\](.+)\[/u\]!isU', '<span style="text-decoration:underline;">$1</span>', $text);
$text = preg_replace('!\[center\](.+)\[/center\]!isU', '<p tyle="text-align:center;margin:0px;padding:0px;">$1</p>', $text);
$text = preg_replace('!\[right\](.+)\[/right\]!isU', '<p style="text-align:right;margin:0px;padding:0px;">$1</p>', $text);
$text = preg_replace('!\[left\](.+)\[/left\]!isU', '<p style="text-align:left;margin:0px;padding:0px;">$1</p>', $text);

$text = preg_replace('!\[titre\](.+)\[/titre\]!isU', '<h3>$1</h3>',$text);

$text = preg_replace('!\[email\](.+)\[/email\]!isU', '<a href="mailto:$1">$1</a>',$text);

$text = preg_replace('!\[img\](.+)\[/img\]!isU', '<img src="$1" border="0">',$text);

$text = preg_replace('!\[url\](.+)\[/url\]!isU', '<a href="$1" target="_blank">$1</a>',$text);

$text = preg_replace('!\[facebook\](.+)\[/facebook\]!isU', '<a href="http://facebook.com/$1" class="uibutton confirm" target="_blank">Facebook</a>',$text);

$text = preg_replace('!\[red\](.+)\[/red\]!isU', '<font color="red">$1</font>',$text);
$text = preg_replace('!\[blue\](.+)\[/blue\]!isU', '<font color="blue">$1</font>',$text);
$text = preg_replace('!\[green\](.+)\[/green\]!isU', '<font color="green">$1</font>',$text);
$text = preg_replace('!\[orange\](.+)\[/orange\]!isU', '<font color="orange">$1</font>',$text);
$text = preg_replace('!\[pink\](.+)\[/pink\]!isU', '<font color="darkpink">$1</font>',$text);

$text = preg_replace('!\[small\](.+)\[/small\]!isU', '<font style="font-size:8px;">$1</font>',$text);
$text = preg_replace('!\[medium\](.+)\[/medium\]!isU', '<font style="font-size:12px;">$1</font>',$text);
$text = preg_replace('!\[large\](.+)\[/large\]!isU', '<font style="font-size:18px;">$1</font>',$text);


$text = preg_replace('!\[br\]!isU', '<br />',$text);

return($text);

}  

//Cette fonction génère, sauvegarde et retourne un token
//Vous pouvez lui passer en paramètre optionnel un nom pour différencier les formulaires
function generer_token($nom = '')
{
	$token = uniqid(rand(), true);
	$_SESSION[$nom.'_token'] = $token;
	$_SESSION[$nom.'_token_time'] = time();
	return $token;
}


//**************************************************************************//
//**************************************************************************//
//**************************************************************************//


//Cette fonction vérifie le token
//Vous passez en argument le temps de validité (en secondes)
//Le referer attendu (adresse absolue, rappelez-vous :D)
//Le nom optionnel si vous en avez défini un lors de la création du token
function verifier_token($referer = '', $nom = '')
{
	if(isset($_GET['token'])){
		if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_GET['token']))
			if($_SESSION[$nom.'_token'] == $_GET['token'])
				if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
					if(strtolower($_SERVER['HTTP_REFERER']) == strtolower($referer))
						return true;
		echo 'ERROR TOKEN' ;
		return false;
	}
	if(isset($_POST['token'])){
		if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']))
			if($_SESSION[$nom.'_token'] == $_POST['token'])
				if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
					if(strtolower($_SERVER['HTTP_REFERER']) == strtolower($referer))
						return true;
		return false;
	}
} 


function false_token(){
	
}


//cette fonction récupère la dernière page

function getLastIndice(){
	$e = explode('/',$_SERVER['HTTP_REFERER']) ;
	$lastPage = count($e);
	return $e[$lastPage - 1];
}

//Function Log

function addLog($user,$action){
	if(mysql_query('INSERT INTO habbophp_logs VALUES ("","'.safe($user,'SQL').'","'.safe($action,'SQL').'",NOW(),"'.safe($_SERVER['REMOTE_ADDR'],'SQL').'")')) return(true) ;  else return(false);
}

function addLogsPaiement($uid,$MoyenDePaiement){
	if(mysql_query('INSERT INTO  habbophp_paiement_logs VALUES ("","'.safe($uid,'SQL').'","'.safe($MoyenDePaiement,'SQL').'",NOW())')) return (true);
}

function setGlobalStats(){
	$t = 'habbophp_stats' ;
	$d = date('Y-m-d') ;
	$req = mysql_query('SELECT date FROM habbophp_stats WHERE date="'.$d.'"');
	if(mysql_num_rows($req) == 0)
		$req = mysql_query('INSERT INTO habbophp_stats (date) VALUES (NOW())');
	if(!isset($_COOKIE['View'])){
		setcookie('View','true', time() + 2*3600, null, null, false, true);
		$req = mysql_query('UPDATE '.$t.' SET visites=visites+1 WHERE date="'.$d.'"');
	}
		$req = mysql_query('UPDATE '.$t.' SET pagesvues=pagesvues+1 WHERE date="'.$d.'"');
}

function selectmod($username)
{
		$prefix = array('ADM-','MOD-','M0D-','SOS-','S0S-','XXX-','OWN-','0WN-','HELP-','SPONSO-','SP0NSO-','SP0NS0-','SPONS0-');
			$first = substr($username, 0, 4);
			$first2 = substr($username, 0, 7);
			$first3 = substr($username, 0, 5);
			$return = "f";
			$select1 = mysql_query("SELECT * FROM users WHERE username = '".$username."'");
			$select2 = mysql_fetch_assoc($select1);
			
			if($select2['rank'] < 2) {
			if (strnatcasecmp($first,"ADM-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"MOD-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"M0D-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"SOS-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"S0S-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"XXX-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"0WN-") == false) { $return = "t"; }
			if (strnatcasecmp($first,"OWN-") == false) { $return = "t"; }
			if (strnatcasecmp($first2,"SPONSO-") == false) { $return = "t"; }
			if (strnatcasecmp($first2,"SP0NSO-") == false) { $return = "t"; }
			if (strnatcasecmp($first2,"SP0NS0-") == false) { $return = "t"; }
			if (strnatcasecmp($first2,"SPONS0-") == false) { $return = "t"; }
			if (strnatcasecmp($first3,"HELP-") == false) { $return = "t"; }
			}

	return $return;
}

	$smtp = array(
		'Gmail' 	=>	array('host' => 'smtp.gmail.com','port' => '465','AUTH' => 'TLS'),
		'Hotmail' 	=> 	array('host' => 'smtp.live.com','port'=>'25','AUTH'=>'SSL'),
		'Free' 		=>	array('host' => 'smtp.free.fr','port' => '25','AUTH' => 'SSL')
	);

function TicketRefresh($id)
{
	
	$base = uniqid("HABBOPHP-" . rand(0,99)) . "-HABBOPHP";
	$request = mysql_query("UPDATE users SET auth_ticket = '".$base."' WHERE id = '".$id."' LIMIT 1");
	return $base;
}


		function GenerateRandom($type = "sso", $length = 0)
	     {
		switch($type)
		{
			case "sso":
				$data = GenerateRandom("random",8)."-".GenerateRandom("random",4)."-".GenerateRandom("random",4)."-".GenerateRandom("random",4)."-".GenerateRandom("random",12);
				return $data;
			break; 
			case "app_key":
				$data = strtoupper(GenerateRandom("random",32)).".resin-fe-".GenerateRandom("random_number",1);
				return $data;
			break; 
			case "random":
				$data = "";
				$possible = "0123456789abcdef"; 
				$i = 0;
				while ($i < $length) { 
					$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
					$data .= $char;
					$i++;
				}
				return $data;
			break; 
			case "random_number":
				$data = "";
				$possible = "0123456789"; 
				$i = 0;
				while ($i < $length) { 
					$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
					$data .= $char;
					$i++;
				}
				return $data;
			break;
		}
	}
		
			
		function UpdateSSO($id)
	    {       
	
	       
			$myticket = GenerateRandom();
			if(mysql_num_rows(mysql_query("SELECT * FROM user_tickets WHERE userid = '".$id."'")) > 0)
					{
					$remote_ip=safe($_SERVER["REMOTE_ADDR"],'SQL');
					mysql_query("UPDATE user_tickets SET sessionticket = '".$myticket."' WHERE userid = '".$id."'") or die(mysql_error()); ;
					mysql_query("UPDATE user_tickets SET ipaddress = '".safe($_SERVER["REMOTE_ADDR"],'SQL')."' WHERE userid = '".$id."'") or die(mysql_error()); ;
					} else {
					mysql_query("INSERT INTO user_tickets (userid,sessionticket,ipaddress) VALUES ('".$id."','".$myticket."','".safe($_SERVER["REMOTE_ADDR"],'SQL')."')") or die(mysql_error());
					}

			return $myticket;
}

function checked($source,$compare,$input){
	if($source == $compare && $input == 'radio')
		echo 'checked="checked"' ;
	if($source == $compare && $input == 'select')
		echo 'selected="selected"' ;
	
	
}

function VersionIsLast(){
	//Get last version
	if(defined('VERSION')){
		$data = file_get_contents('http://release.habbophp.com');
		
		//Compare
		if(VERSION == $data)
			return true;
		}
	return false;
}

?>