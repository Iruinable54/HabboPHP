<?php

require '../../../init.php';

$error_name = $error_desc = false ;
if(!isset($_GET['name']) or empty($_GET['name'])){
	$error_name = true ;
}

if(!isset($_GET['description']) or empty($_GET['description']) or strlen($_GET['description']) > 255){
	$error_desc = true ;
}

if(!$error_name && !$error_desc){
	$Groups = new Groups(array(
		'name' => $_GET['name'],
		'desc' => $_GET['description']
	));
	echo $Groups->add();
}

?>
<div id="group-purchase-header">
   <img src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1458/web-gallery/images/groups/group_icon.gif" alt="" width="46" height="46" />
</div>
<?php  if($error_name && $error_desc){ ?>
<form action="#" method="post" id="purchase-group-form-id">

<div id="group-name-area">
    <div id="group_name_message_error" class="error">
	    <?php
	    	if($error_name){
		    	echo 'Nom de groupe indéfini.';
	    	}
	    ?>
    </div>
    <label for="group_name" id="group_name_text">Nom du groupe:</label>
    <input type="text" name="group_name" id="group_name" maxlength="30" onKeyUp="GroupUtils.validateGroupElements('group_name', 30, 'Nom de groupe trop long');" value=""/><br />
</div>

<div id="group-description-area">
    <div id="group_description_message_error" class="error">
	     <?php
	    	if($error_desc){
		    	echo 'Description indéfini.';
	    	}
	    ?>
    </div>
    <label for="group_description" id="description_text">Description du groupe:</label>
    <span id="description_chars_left"><label for="characters_left">caractères restants:</label>
    <input id="group_description-counter" type="text" value="255" size="3" readonly="readonly" class="amount" /></span><br/>
    <textarea name="group_description" id="group_description" onKeyUp="GroupUtils.validateGroupElements('group_description', 255, 'Description trop longue');"></textarea>
</div>
</form>

<div class="new-buttons clearfix">
	<a class="new-button" id="group-purchase-cancel-button" href="#" onclick='GroupPurchase.close(); return false;'><b>Annuler</b><i></i></a>	
	<a class="new-button" href="#" onclick="GroupPurchase.confirm(); return false;"><b>Acheter ce groupe</b><i></i></a>
</div>

<?php }else{  ?>


<p id="purchase-result-success">
Bravo ! Le groupe que tu as crée se nomme: <?php echo safe($_GET['name'],HTML); ?>
</p>

<p>

<div class="new-buttons clearfix">
	<a class="new-button" id="group-purchase-cancel-button" href="#" onclick="GroupPurchase.close(); return false;"><b>Plus tard</b><i></i></a>	
	<a class="new-button" href="<?php echo $config->url_site; ?>/groups/<?php echo $Groups->groupid; ?>/id"><b>Voir mon groupe</b><i></i></a>
</div>

</p>






<?php } ?>