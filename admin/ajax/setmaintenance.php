<?php
define('RANK','7');
require '../includes/init.php';

if($_GET['action']=='true') {
if(mysql_query("UPDATE habbophp_config SET value='true' WHERE name='maintenance'") AND addLog($user->username,"Active maintenance mode")) { echo "1"; }
} else {
if(mysql_query("UPDATE habbophp_config SET value='false' WHERE name='maintenance'") AND addLog($user->username,"Disable maintenance mode")) { echo "1"; }
}