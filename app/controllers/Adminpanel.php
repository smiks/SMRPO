<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Adminpanel extends Controller{
	
	public function post() {
		
	}

	public function get() {
		$user = new user();
		$isAdministrator = $user->isAdmin($_SESSION['userid']);
		if($isAdministrator){
			$this->show("adminpanel.view.php");
		}
		else{
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}
		
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
		elseif($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}		
		else{
			$this->home();
		}	
	}

}