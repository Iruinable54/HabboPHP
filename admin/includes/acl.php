<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright � 2012 Valentin & Robin. All rights reserved.        #|
#|  																	  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

/*
@tuto : Pour ajouter un autorisation � un rank, s�parez le deuxi�me param�tre par un ";" ex : define('ACL_MENU_SERVER','6;7;8,5,4');
@warning : Ne pas mettre deux fois le m�me chiffre : 6;7;8;6;7;8
*/

//Global
define('ACL_GLOBAL_ADMIN','6;7;8'); //Les ranks qui ont le droit d'acc�der � l'administration

//Index
define('ACL_INDEX_STATS','6;7;8;8');
define('ACL_INDEX_NOTES','6;7;8');


//Menu
define('ACL_MENU_SERVER','6;7;8');
define('ACL_MENU_SITE','6;7;8');
define('ACL_MENU_USERS','6;7;8');
define('ACL_MENU_SHOP','6;7;8');
define('ACL_MENU_HELP','6;7;8');
define('ACL_MENU_LOGS','6;7;8');
define('ACL_MENU_PAGE','6;7;8');
define('ACL_MENU_FORM','6;7;8');


//Serveur
define('ACL_SERVER_CONFIG','6;7;8');
define('ACL_SERVER_WORDS','6;7;8');
define('ACL_SERVER_MAINTENACE','6;7;8');

//Site
define('ACL_SITE_NEWS','6;7;8');
define('ACL_SITE_NEWS_POST','6;7;8');
define('ACL_SITE_NEWS_VIEW','6;7;8');

define('ACL_SITE_ADS','6;7;8');
define('ACL_SITE_CONFIG','6;7;8');
define('ACL_SITE_CONFIG_MAIL','6;7;8');
define('ACL_SITE_SOCIAL','6;7;8');
define('ACL_SITE_FB','6;7;8;6;7;8');
define('ACL_SITE_NOTIF','6;7;8;6;7;8');

//Users
define('ACL_USERS_VIEW','6;7;8');
define('ACL_USERS_BAN','6;7;8');

//Shop
define('ACL_SHOP_STATS','6;7;8');
define('ACL_SHOP_VOUCHER','6;7;8');
define('ACL_SHOP_CONFIG_MONEY','6;7;8');
define('ACL_SHOP_BADGES','6;7;8');
define('ACL_SHOP_RARES','6;7;8;6');
define('ACL_SHOP_PAIEMENT','6;7;8');
define('ACL_SHOP_PAIEMENT_LOGS','6;7;8');

//Support
define('ACL_SUPPORT_ARTICLES','6;7;8');
define('ACL_SUPPORT_CATEGORIES','6;7;8');

//Logs
define('ACL_LOGS_VIEW','6;7;8');

//Pages
define('ACL_PAGES_ADD','6;7;8');
define('ACL_PAGES_VIEW','6;7;8');


//Form
define('ACL_FORM_MANAGE','6;7;8');

?>