<?php
require '../init.php' ;


$to=    (int) safe($_GET['to'],'SQL'); 
$value= (string) safe($_GET['value'],'SQL'); 

if($db->query('INSERT INTO habbophp_home_books VALUES ("",'.$to.','.$user->id.',"'.$value.'")')){ 

echo '<div class="guestbook-author">
                <img src="http://www.habbo.com/habbo-imaging/avatarimage?figure='.$user->look.'&size=s&direction=4"/>
		</div>
			<div class="guestbook-actions">
			</div>
		<div class="guestbook-message">
			<div class="o">
				<a href="home.php?username='.$user->username.'">'.$user->username.'</a>
			</div>
			<p>'.safe($value,"HTML").'</p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>';

}