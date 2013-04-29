<?php
/*
MachForm Configuration File
*/

/** MySQL settings **/

ini_set('display_errors', 0); 
ini_set('log_errors', 0); 
error_reporting(0);

/** YOU CAN LEAVE THE SETTINGS BELOW THIS LINE UNCHANGED **/
require '../../includes/settings.inc.php'; 
/** Optional Settings **/
/** All settings below this line are optionals, you can leave them as they are now **/
define('MF_TABLE_PREFIX', 'habbophp_form_'); //The prefix for all machform tables

//by default, deleting field from the form won't actually remove all the data within the table, so that we can manually recover it
//by setting this value to 'true' the data will be removed completely, unrecoverable
define('MF_CONF_TRUE_DELETE',true);

/** reCAPTCHA settings **/
/** Below is a global key. If you prefer to use your own reCAPTCHA key, get an API key from https://www.google.com/recaptcha/admin/create **/
define('RECAPTCHA_PUBLIC_KEY','6LdDtMcSAAAAAL0O2fhNlYObanlKlbQzSfYsdHRY');
define('RECAPTCHA_PRIVATE_KEY','6LdDtMcSAAAAACXVxR-niVXMe-5KnVQQkvaZP_dw');
define('RECAPTCHA_THEME','red'); //available themes: red, white, blackglass, clean
define('RECAPTCHA_LANGUAGE','en'); //available languages: en, nl, fr, de, pt, ru, es, tr

/** Current MachForm Version **/
define('MACHFORM_VERSION','3.0');

?>