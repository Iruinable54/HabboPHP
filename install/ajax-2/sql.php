<?php
	require '../lang/fr.php';
	if(isset($_POST['submit'])){
		if(!mysql_connect($_POST['host'],$_POST['user'],$_POST['password']))
			echo'mysql-test-false';	
		exit;
	}
?>
<style>
	label{
		width:180px;
		float:left;
		text-align: left;
	}
	input{
		text-align: left;
	}
</style>
<p>

	<div class="error" style="display:none"><span id="SQLConnectionFalse" style="display:none"><?php echo $lang['SQLConnectionFalse']; ?></span></div>

	<form action="ajax-2/sql.php" id="mysql-ajax" method="post">
		<label>Host</label><input type="text" name="host"/><br/>
		<label>Nom d'utilisateur</label><input type="text" name="user"/><br/>
		<label>Mot de passe</label><input type="password" name="password"/><br/>
		<label>Base de donnée</label><input type="text" name="bdd"/><br/>
		<input type="hidden" name="submit" value="submit"/>
		<input type="submit" class="downloadButton" value="Submit"/>
		<br/>
		<a href="" onclick="load('sql')" class="downloadButton" lang="en">Vérifier</a>
	</form>
	<script>
		$(document).ready(function (){
			$('#mysql-ajax').alajax({
				success: function (result){ 
					if(result == 'mysql-test-false'){
						$('.error').show();
						$('#SQLConnectionFalse').show();
					}
	    	}
	      });
		});
	</script>	
</p>