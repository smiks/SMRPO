<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Adduser extends Controller{

	public function post() {
		$user = new user();
		$isAdministrator = $user->isAdmin($_SESSION['userid']);
		$allowAdd = true;
		if($isAdministrator){		
			$log  = new log();
			$input 	 = Functions::input("POST");
			$userid  = $user->lastUserID()+1;
			$name 	 = $input['name'];
			$surname = $input['surname'];
			$email   = $input['email'];
			$pOwner  = $input['productOwner'];
			$kMaster = $input['kanbanmaster'];
			$develop = $input['developer'];
			$admin   = $input['administrator'];
			$passwd  = $input['password'];
			$rpasswd = $input['repassword'];
			$nsCombo = $name.$surname;
			$snCombo = $surname.$name;

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
			if($passwd != $rpasswd && $allowAdd)
			{
				$error = "Passwords do not match! Account was not modified.";
				$errorCode = "401";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$allowAdd = false;
			}
			if(empty($passwd) && $allowAdd)
			{
				$error = "Password field is empty";
				$errorCode = "401";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$allowAdd = false;
			}

			if(strlen($passwd) < 8 && $allowAdd)
			{
				$error = "Password is shorter than 8 characters.";
				$errorCode = "401";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$allowAdd = false;
			}

			if(strtoupper($passwd) == strtoupper($name) || strtoupper($passwd) == strtoupper($surname) || strtoupper($passwd) == strtoupper($email) || strtoupper($passwd) == strtoupper($nsCombo) || strtoupper($passwd) == strtoupper($snCombo) && $allowAdd)
			{
				$error = "Password must not consist of name, surname or email.";
				$errorCode = "401";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$allowAdd = false;
			}

			if($user->exists(array("email", $email), "User") && $allowAdd)
			{
				$error = "This email is already in use.";
				$errorCode = "401";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$allowAdd = false;
			}

			if($allowAdd)
			{
				$hpassword = Functions::hashing($passwd);
				$insertData	= array("name" => $name, "surname" => $surname, "email" => $email, "abilities" => $abilities, "administrator" => $admin, "password" => $hpassword, "locked" => '0', "max_num_invalid_login" => '3');

				if($user->insertUser($userid, $insertData))
				{
					$log->insertLog($_SESSION['userid'], "Added user with ID {$userid}");
					$message = "Successfully added user with ID {$userid}. <br> Email: {$email} <br> Password: {$passwd}";
					$data = array("message" => $message);
				}
				else{
					$data = array("error" => "User was not added!");
				}
				$this->show("addusersub.view.php", $data);
			}
		}
		else{
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}			
	}

	public function get() {
		$user = new user();
		$isAdministrator = $user->isAdmin($_SESSION['userid']);
		if($isAdministrator){
			$this->show("addUser.view.php");
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