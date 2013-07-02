<?php
if (!headers_sent())
	header('Content-Type: text/html; charset=utf-8');
	
ini_set('default_charset', 'utf-8');

if (function_exists('date_default_timezone_set')){
	@date_default_timezone_set('Europe/Paris');
}
if(file_exists("../includes/settings.inc.php")){
	include "../includes/settings.inc.php";
	mysql_connect(HOST,USER_DB,PASSWORD_DB);
	mysql_select_db(NAME_DB);
	$req = mysql_query('SHOW TABLES FROM '.NAME_DB.'');
	
	$d = array();
	while ($row = mysql_fetch_array($req)) { $d[] =  $row[0]; }

	if(in_array('habbophp_config',$d)){
		die( 'Votre base de donn&eacute;e  contient  des tables de HabboPHP. Videz votre DB pour refaire une installation') ;
	}
}

$step = (isset($_GET['step'])) ? intval($_GET['step']) : '1';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Habbophp : Installation</title>
<link rel="stylesheet" href="assets/css/install.css" type="text/css" />
<link rel="stylesheet" href="assets/css/buttons.css" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Dosis:300,400' rel='stylesheet' type='text/css'>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
<script src="assets/js/alajax-1.2.js"></script>


</head>
<body class="wp-core-ui">
<h1 id="logo">HabboPHP</h1>
<!--Step 1-->
<?php if($step == 1){ ?>
<p>Bienvenue dans HabboPHP. Avant de nous lancer, assure toi bien d'avoir en ta possession une base de donnée <strong>Phoneix/Butterfly.</strong> La base de donnée où va se passer l'installation doit être vide.</p>
<p class="step"><a href="index.php?step=2" class="button button-large">C&rsquo;est parti&nbsp;!</a></p>
<?php } ?>

<!--Step 2-->
<?php if($step == 2){ ?>
<form method="post" action="ajax-3/mysql.php" id="mysql">
	<p>Vous devez saisir ci-dessous les détails de connexion à votre base de données. Si vous ne les connaissez pas, contactez votre hébergeur.</p>
	<tr>
		<p id="error-mysql" style="color:red;display:none">Les informations de connexion vers la base de donnée sont incorrecte.</p>
	</tr>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Nom de la base de données</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="" /></td>
			<td>Le nom de la base de données dans laquelle vous souhaitez installer HabboPHP.</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">Identifiant</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="" /></td>
			<td>Votre identifiant MySQL</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Mot de passe</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="" /></td>
			<td>&hellip;et son mot de passe MySQL.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Adresse de la base de données</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			
		</tr>
	</table>

		<p class="step"><input name="submit" type="submit" value="Envoyer" class="button button-large" /></p>
</form>

<?php } ?>


<?php if($step == 3){ ?>

	<p>A présent nous allons créer les tables dont nous avons besoin.</p>
	<p>Tout d'abord nous avons besoin des tables vide de Phoenix/Butterfly. Utilise ton logiciel préféré (Navicat, PhpMyadmin...) pour uploader ta base de donnée.<br/>Une fois l'opération faite, clique sur le bouton "Vérifier"</p>
	<form method="post" action="ajax-3/insert.php" id="insert">
	<p class="step"><input name="submit" type="submit" value="Vérifier" class="button button-large" /></p>
	</form>
	<tr>
		<p id="error-mysql" style="color:red;display:none">Les informations de connexion vers la base de donnée sont incorrecte.</p>
	</tr>
<?php } ?>

<?php if($step == 4){ ?>
<form method="post" action="ajax-3/admin.php" id="retro">
	<p>Félicitation ! Il ne reste plus grand chose à faire :)</p>
	<tr>
		<p id="error-mysql" style="color:red;display:none">Les informations de connexion vers la base de donnée sont incorrecte.</p>
	</tr>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Login Admin</label></th>
			<td><input name="login" id="admin" type="text" size="25" value="" /></td>
			<td>Le login pour pouvoir se connecter à l'admin</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">Mot de passe Admin</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Nom du rétro</label></th>
			<td><input name="nom_retro" id="nom_retro" type="text" size="25" value="" /></td>
		</tr>
		<?php
		
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$url=substr($url,0,-25);
		?>
		<input type="hidden" name="url" value="<?php echo $url ; ?>"/>
	</table>

		<p class="step"><input name="submit" type="submit" value="Envoyer" class="button button-large" /></p>
</form>
<?php } ?>

<?php if($step == 5){ ?>
<p><strong>Amazing !</strong>
	Tout est prêt pour commencer à jouer sur ton hotel :)
	<br/><strong>Tu DOIS supprimer le dossier INSTALL</strong> Sinon une personne peut se faire un compte admin !
	<?php
	//	rmdir('ajax-3');
	?>
</p>
<?php } ?>
<script>
$(function(){
	$("#mysql").alajax({
		success: function (result){
			console.log(result);
			if(result != 'true'){
				$('#error-mysql').html(result);
				$('#error-mysql').show();
			}else{
				window.location = 'index.php?step=3';
			}
		}
	});
	$("#insert").alajax({
		success: function (result){
			console.log(result);
			if(result != 'true'){
				$('#error-mysql').html(result);
				$('#error-mysql').show();
			}else{
				window.location = 'index.php?step=4';
			}
		}
	});
	$("#retro").alajax({
		success: function (result){
			console.log(result);
			if(result != 'true'){
				$('#error-mysql').html(result);
				$('#error-mysql').show();
			}else{
				window.location = 'index.php?step=5';
			}
		}
	});
});
</script>
<center>
<i style="font-size:10px;text-align:center;">Installateur de Wordpress</i>
</center>
</body>
</html>
