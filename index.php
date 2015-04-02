<?php
/******************/
/* Author: smiks  */
/* Version: 0.5   */
/******************/
/* Latest upgrade */
/* - CSRF token   */
/* - cache        */
/* - routing      */
/* - functions    */
/******************/

session_start();
ob_start();


require_once 'config/page_settings.php';
require_once 'config/config.php';
require_once 'config/connect.php';
require_once 'core/Router.php';
require_once 'core/Functions.php';


/* routing */
Router::home('main', 'app/controllers/Main.php');
Router::make('main', 'app/controllers/Main.php');
Router::make('login', 'app/controllers/Login.php');
Router::route();


/* optional "garbage collector" */
$variables = array('route'); /* You can put name of variables that you want to unset in this array. */
foreach ($variables as $value) {
	unset($$value);
}
unset($variables);
