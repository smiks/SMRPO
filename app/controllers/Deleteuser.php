<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Deleteuser extends Controller{
	

	private function getAllUsers()
	{
		$user = new user();
		return ($user -> getAllUsers());
	}

	public function post() {
		$log = new log();
		$user = new user();
		$isAdministrator = $user->isAdmin($_SESSION['userid']);
		if($isAdministrator)
		{
			$input = Functions::input("POST");
			$userid = $input['userid'];

			if($user->deleteUser($userid))
			{
				$log->insertLog(1, "Deleted user with ID {$userid}");
				$message = "Successfully deleted user with ID {$userid}";
				$data = array("message" => $message);
			}
			else{
				$data = array("error" => "User was not deleted.");
			}
			$this->show("deleteusersub.view.php", $data);
		}
		else{
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}			
	}

	public function get() {

		$allUsers = $this->getAllUsers();

		$user = new user();
		$isAdministrator = $user->isAdmin($_SESSION['userid']);
		if($isAdministrator){
			$data = array("users" => $allUsers);
			$this->show("deleteuser.view.php", $data);
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