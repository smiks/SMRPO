<?php
/******************/
/* Author: smiks  */
/* Version: 0.6   */
/******************/
/* Latest upgrade */
/* - Basic ORM    */
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
Router::home('main', 'app/controllers/SignIn.php');
Router::make('main', 'app/controllers/SignIn.php');
Router::make('login', 'app/controllers/Login.php');
Router::make('logout', 'app/controllers/Logout.php');
Router::make('homepage', 'app/controllers/Homepage.php');
Router::make('adminpanel', 'app/controllers/Adminpanel.php');
Router::make('edituser', 'app/controllers/Edituser.php');
Router::make('editusersub', 'app/controllers/Editusersub.php');
Router::make('adduser', 'app/controllers/AddUser.php');
Router::make('deleteuser', 'app/controllers/Deleteuser.php');
Router::make('creategroup', 'app/controllers/CreateGroup.php');
Router::make('deletegroup', 'app/controllers/DeleteGroup.php');
Router::make('groups', 'app/controllers/Groups.php');
Router::make('createproject', 'app/controllers/CreateProject.php');
Router::make('projects', 'app/controllers/Projects.php');
Router::make('editproject', 'app/controllers/EditProject.php');
Router::make('editgroup', 'app/controllers/Editgroup.php');
Router::make('deleteproject', 'app/controllers/DeleteProject.php');
Router::make('infogroup', 'app/controllers/Infogroup.php');
Router::make('showtable', 'app/controllers/Showtable.php');
Router::make('createtable', 'app/controllers/Createtable.php');
Router::make('copytable', 'app/controllers/CopyTable.php');
Router::route();
/* optional "garbage collector" */
$variables = array('user', 'group'); /* You can put name of variables that you want to unset in this array. */
foreach ($variables as $value) {
	unset($$value);
}
unset($variables);
