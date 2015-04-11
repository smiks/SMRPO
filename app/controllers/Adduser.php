<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

class Adduser extends Controller{

	public function post() {
		$user = new user();
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
		if($passwd != $rpasswd)
		{
			$error = "Passwords do not match! Account was not modified.";
			$errorCode = "401";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}
		if(empty($passwd))
		{
			$error = "Password field is empty";
			$errorCode = "401";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}

		if(strlen($passwd) < 8)
		{
			$error = "Password is shorter than 8 characters.";
			$errorCode = "401";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}

		if($passwd == $name || $passwd == $surname || $passwd == $email || $passwd == $nsCombo || $passwd == $snCombo)
		{
			$error = "Password must not consist of name, surname or email.";
			$errorCode = "401";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}

		if($user->exists(array("email", $email), "User"))
		{
			$error = "This email is already in use.";
			$errorCode = "401";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}

		else
		{
			$hpassword = Functions::hashing($passwd);
			$insertData	= array("name" => $name, "surname" => $surname, "email" => $email, "abilities" => $abilities, "administrator" => $admin, "password" => $hpassword);	

			if($user->insertUser($userid, $insertData))
			{
				$log->insertLog(1, "Added user with ID {$userid}");
				$message = "Successfully added user with ID {$userid}";
				$data = array("message" => $message);
			}
			else{
				$data = array("error" => "User was not added!");
			}
			$this->show("addusersub.view.php", $data);
		}
	}

	public function get() {
		/* TODO :: get info from database */
		$isAdministrator = true;
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