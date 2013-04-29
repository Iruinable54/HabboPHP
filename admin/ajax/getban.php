<?php
session_start();
define('CORE','CORE');
$admin = true ;
include("../../includes/core.php");
include("../lang/fr.php");
if(!$Auth->isConnected()) redirection('/logout.php');
if($user->rank<7) exit();

$page = isset($_POST['page']) ? $_POST['page'] : '1' ;

// On met dans une variable le nombre de messages qu'on veut par page
$nombreDeMessagesParPage = 40; // Essayez de changer ce nombre pour voir :o)
// On récupère le nombre total de messages
$retour = mysql_query("SELECT COUNT(*) AS nb_bans FROM bans WHERE reason NOT LIKE '%This is an english hotel%'");
$donnees = mysql_fetch_array($retour);
$totalDesMessages = $donnees['nb_bans'];
// On calcule le nombre de pages à créer
$nombreDePages  = ceil($totalDesMessages / $nombreDeMessagesParPage);
// Puis on fait une boucle pour écrire les liens vers chacune des pages



$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;

$req = mysql_query('select * from bans  WHERE reason NOT LIKE "%This is an english hotel%" order by id desc LIMIT ' . $premierMessageAafficher . ', ' . $nombreDeMessagesParPage );
?>
<input type="text" name="search" value="" id="id_search" placeholder="<?php echo $lang['Search']; ?>" />
<table  class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Utilisateur/IP</th>
      <th>Raison</th>
      <th>Expire</th>
      <th>Banni par</th>
      <th>Date ajoutée</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php
   while($data = mysql_fetch_assoc($req)){
  ?>
    <tr id="l<?php echo $data['id']; ?>">
      <td><?php echo $data['value'] ;?></td>
      <td><?php echo $data['reason'] ;?></td>
      <td><?php echo date('d/m/Y à H:i:s',$data['expire']) ;?></td>
      <td><?php echo $data['added_by'] ;?></td>
      <td><?php echo $data['added_date'] ;?></td>
      <td> 
            	<a href="javascript:void(0);" onclick="removeban('<?php echo $data['id']; ?>');" class="btn btn-danger"><?php echo $lang['Delete']; ?></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php
echo 'Page : ';
for ($i = 1 ; $i <= $nombreDePages ; $i++)
{
    echo '<a href="javascript:void(0);" onclick="changePage('.$i.')" id="'.$i.'">' . $i . '</a> ';
}
?>