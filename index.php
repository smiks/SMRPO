<?php
/******************/
/* Author: smiks  */
/* Version: 0.6.5 */
/******************/
/* Latest upgrade */
/* - Global Funcs */
/* - Basic ORM    */
/* - CSRF token   */
/* - cache        */
/* - routing      */
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
Router::make('createtablesub', 'app/controllers/Createtablesub.php');
Router::make('edittable', 'app/controllers/Edittable.php');
Router::make('copytable', 'app/controllers/CopyTable.php');
Router::make('createcard', 'app/controllers/CreateCard.php');
Router::make('editCard', 'app/controllers/EditCard.php');
Router::make('showHistory', 'app/controllers/ShowHistory.php');
Router::make('comments', 'app/controllers/Comments.php');
Router::make('cumulativeFlow', 'app/controllers/CumulativeFlow.php');
Router::make('movecard', 'app/controllers/MoveCard.php');
Router::make('confirmwip', 'app/controllers/Confirmwip.php');
Router::make('editColumn', 'app/controllers/EditColumn.php');
Router::make('editColumnSub', 'app/controllers/EditColumnSub.php');
Router::make('averageleadtime', 'app/controllers/AverageLeadTime.php');
Router::make('criticalcards', 'app/controllers/CriticalCards.php');
Router::make('addtoboard', 'app/controllers/AddToBoard.php');
Router::make('wipViolations', 'app/controllers/WIPViolations.php');
Router::route();
/* optional "garbage collector" */
$variables = array('user', 'group', 'board', 'project'); /* You can put name of variables that you want to unset in this array. */
foreach ($variables as $value) {
	unset($$value);
}
unset($variables);