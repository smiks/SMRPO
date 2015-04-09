<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

class Adduser extends Controller{

	public function post() {
		
	}

	public function get() {
		/* TODO :: get info from database */
		$isAdministrator = true;
		if($isAdministrator){
			$this->show("adduser.view.php");
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