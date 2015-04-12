<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Editusersub extends Controller{
	
	public function post() {
		$user = new user();
		$isAdministrator = $user->isAdmin($_SESSION['userid']);
		if($isAdministrator)
		{
			$input 	 = Functions::input("POST");
			$userid  = $input['userid'];
			$name 	 = $input['name'];
			$surname = $input['surname'];
			$email   = $input['email'];
			$pOwner  = $input['productOwner'];
			$kMaster = $input['kanbanmaster'];
			$develop = $input['developer'];
			$admin   = $input['administrator'];
			$passwd  = $input['password'];
			$rpasswd = $input['repassword'];

			if(empty($pOwner))
			{
				$pOwner = 0;
			}
			if(empty($kMaster))
			{
				$kMaster = 0;
			}
			if(empty($develop))
			{
				$develop = 0;
			}
			
			$abilities = "".$pOwner.$kMaster.$develop."";

			if(empty($passwd) && empty($rpasswd)){
				$updateData	= array("name" => $name, "surname" => $surname, "email" => $email, "abilities" => $abilities, "administrator" => $admin);
			}
			else{
				if($passwd != $rpasswd)
				{
					$error = "Passwords do not match! Account was not modified.";
					$errorCode = "401";
					$data = array("error" => $error, "errorCode" => $errorCode);
					$this->show("error.view.php", $data);
				}
				else{
					$hpassword = Functions::hashing($password);
					$updateData	= array("name" => $name, "surname" => $surname, "email" => $email, "abilities" => $abilities, "administrator" => $administrator, "password" => $hpassword);	
				}
			}

			$user = new user();
			$log  = new log();
			if($user->updateUser($userid, $updateData))
			{
				$log->insertLog(1, "Modified user with ID {$userid}");
				$message = "Successfully modified user with ID {$userid}";
				$data = array("message" => $message);
			}
			else{
				$data = array("error" => "User was not modified!");
			}
			$this->show("editusersub.view.php", $data);
		}
		else{
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}
		

	}

	public function get() {

		
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