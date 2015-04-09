<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

class Edituser extends Controller{
	

	private function getAllUsers()
	{
		$user = new user();
		return ($user -> getAllUsers());
	}

	public function post() {
		
	}

	public function get() {

		$allUsers = $this->getAllUsers();

		/* TODO :: get info from database */
		$isAdministrator = true;
		if($isAdministrator){
			$data = array("users" => $allUsers);
			$this->show("edituser.view.php", $data);
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