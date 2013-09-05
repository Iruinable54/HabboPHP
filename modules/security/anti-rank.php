<?php

//Système de sécurité qui permet de vérifier si il y a un nouveau rank non autorisé. Attention, ce système peut être gourmand en ressources.

require '../../init.php';
//Config
$anti_rank_security_enable = true ; //Activer ou désactiver cette vérification
$rank_min = 5 ; //Le rank à partir du quel on doit vérifier si c'est un rank autorisé.

if(!$anti_rank_security_enable) die('LOL');

//Liste des utilisateurs ranked avec leurs grade ===> 'pseudo' => rank

$user_ranked = array(
	'sd' => 7,
	'Admin' => 7
);

$req = mysql_query('SELECT id,username,rank FROM users');
while($data = mysql_fetch_assoc($req)){
	if($data['rank'] >= 5){
		if($user_ranked[$data['username']] != $data['rank']){
			echo '<span style="color:red">'.$data['username'].' n\'a pas le droit d\'avoir le rank '.$data['rank'].'</span><br/>';
			if(mysql_query('UPDATE users SET rank=1 WHERE id="'.$data['id'].'"'))
				echo $data['username'].' a été dérank<br/>';
			}
	}
}

