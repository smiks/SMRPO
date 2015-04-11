<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

class Login extends Controller{
	
	public function post() {
		$user 	   = new user();
		$inputData = Functions::input()["POST"];
		$email     = $inputData['login_email'];
		$passwd    = $inputData['login_password'];
		$hpasswd   = Functions::hashing($passwd);		

		$allowLogin = true;
		$error      = "";
		$numAcc     = $user->countUsersByInfo($email, $hpasswd);
		$info       = $user->userInfoByEmail($email);
		$attempts   = $info['num_invalid_login']; 
		$mattempts  = $info['max_num_invalid_login'];
		$locked     = $info['locked'];

		if($numAcc != 1){
			$user->updateFailedLoginAttempt($email);
			$error .= "Wrong username or password!<br>";
			$allowLogin = false;
		}
		if($attempts >= $mattempts){
			$user->lockUser($email);
			$error .= "Your account is now locked due to too many failed login attempts.<br>";
			$allowLogin = false;
		}
		if($locked != 0){
			$error .= "Your account is locked.<br>";
			$allowLogin = false;	
		}


		if(!$allowLogin){
			$data = array("error" => $error);
			$this->show("signIn.view.php", $data);	
		}

		else{
			$_SESSION['loggedin'] = 1;
			$_SESSION['userid']   = $info['id_user'];
			$user->resetFailedLoginAttempt($email);
			Functions::redirect(Functions::internalLink("?page=homepage"));
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