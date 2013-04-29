<?php
	require '../../../../init.php';
	
	$Groups = new Groups(
		array('groupid' => intval($_GET['groupId']))
	);
	
	$Info = $Groups->getInfo();
	
?>
<form action="#" method="post" id="group-settings-form">

  <div id="group-settings" style="">
    <div id="group-settings-data" class="group-settings-pane">
      <div id="group-logo">
        <img src="http://cola-hotel.net/habbo-imaging/badge.php?badge=b1512Xs05015s05173s09034s01144">
      </div>
      <div id="group-identity-area">
        <div id="group-name-area">
          <div id="group_name_message_error" class="error"></div>
          <label for="group_name" id="group_name_text">Modifier le nom du groupe:</label>
          <input type="text" name="group_name" id="group_name" onkeyup="GroupUtils.validateGroupElements('group_name', 30, 'Sujet trop long');" value="<?php echo $Info['name']; ?>"><br>
        </div>

        <div id="group-url-area">
          <div id="group_url_message_error" class="error"></div>
		              <label for="group_url" id="group_url_text">Modifier l'URL du groupe:</label><br>
            <input type="text" name="group_url" id="group_url" onkeyup="GroupUtils.validateGroupElements('group_url', 30, 'URL limit reached');" value=""><br>
            <input type="hidden" name="group_url_edited" id="group_url_edited" value="1">
		            </div>
        </div>

        <div id="group-description-area">
          <div id="group_description_message_error" class="error"></div>
          <label for="group_description" id="description_text">Modifier la description:</label>
          <span id="description_chars_left">
            <label for="characters_left">Charactères restant :</label>
            <input id="group_description-counter" type="text" value="253" size="3" readonly="readonly" class="amount">
          </span>
          <textarea name="group_description" id="group_description" onkeyup="GroupUtils.validateGroupElements('group_description', 255, 'Description trop longue');"><?php echo $Info['desc']; ?></textarea>
        </div>
      </div>
      <div id="group-settings-type" class="group-settings-pane group-settings-selection">
        <label for="group_type">Changer la nature du groupe:</label>
        <input type="radio" name="group_type" id="group_type" value="0" checked="checked">
        <div class="description">
          <div class="group-type-normal">Public</div>
          <p>Tout le monde peut rejoindre ce groupe. La limite est fixée à 5000 membres.</p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="1">
        <div class="description">
          <div class="group-type-exclusive">Restreint</div>
          <p>Les responsables de ce groupe choisissent qui peut y adhérer.</p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="2">
        <div class="description">
          <div class="group-type-private">Privé</div>
          <p>Ce groupe est fermé - Personne ne peut y adhérer</p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="3">
        <div class="description">
          <div class="group-type-large">Illimité</div>
          <p>Tout le monde peut adhérer à ce groupe. Sans limite. Impossible d'afficher les noms des membres.</p>
          <p class="description-note">Attention: si tu choisis cette option tu ne pourras pas revenir dessus!</p>
        </div>
        <input type="hidden" id="initial_group_type" value="0">
      </div>
    </div>


    <div id="forum-settings" style="display: none;">

      <div id="forum-settings-type" class="group-settings-pane group-settings-selection">
        <label for="forum_type">Modifier le forum:</label>
        <input type="radio" name="forum_type" id="forum_type" value="0" checked="checked">
        <div class="description">
          Public<br>
          <p>Tout le monde peut lire les messages du forum.</p>
        </div>
        <input type="radio" name="forum_type" id="forum_type" value="1">
        <div class="description">
          Privé<br>
          <p>Seuls les membres du groupe peuvent lire les messages du forum</p>
        </div>
      </div>

      <div id="forum-settings-topics" class="group-settings-pane group-settings-selection">
        <label for="new_topic_permission">Modifier les sujets:</label>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="2">
        <div class="description">
          Responsables<br>
          <p>Seuls les responsables peuvent lancer de nouveaux sujets.</p>
        </div>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="1">
        <div class="description">
          Membres<br>
          <p>Seuls les membres du groupe peuvent lancer un nouveau sujet.</p>
        </div>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="0" checked="checked">
        <div class="description">
          Tous<br>
          <p>Tout le monde peut lancer un nouveau sujet.</p>
        </div>
      </div>
    </div>


    <div id="room-settings" style="display: none;">
      <label>Choisis un QG pour ton groupe:</label>
      <div id="room-settings-id" class="group-settings-pane-wide group-settings-selection">
        <ul>
          <li><input type="radio" name="roomId" value="" checked="checked"><div>Pas d'appart</div></li>
		            <li class="even">
            <input type="radio" name="roomId" value="1139121">
            <a href="/client?forwardId=1&amp;roomId=1139121" onclick="HabboClient.roomForward(this, '1139121', 'private'); return false;" target="" class="room-enter">Entrer</a>
            <div>
              RobinHerzog's room<br>
              <span class="room-description"></span>
            </div>
          </li>
		          </ul>
      </div>
    </div>

    <div id="group-button-area">
      <a href="#" id="group-settings-update-button" class="new-button" onclick="showGroupSettingsConfirmation('8954');">
        <b>Sauvegarder</b><i></i>
      </a>
      <a id="group-delete-button" href="#" class="new-button red-button" onclick="openGroupActionDialog('/groups/actions/confirm_delete_group', '/groups/actions/delete_group', null , '8954', null);">
        <b>Dissoudre le groupe</b><i></i>
      </a>
      <a href="#" id="group-settings-close-button" class="new-button" onclick="closeGroupSettings(); return false;"><b>Annuler</b><i></i></a>
    </div>
  
</form>