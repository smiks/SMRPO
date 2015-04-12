<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Edituser extends Controller{
	

	private function getAllUsers()
	{
		$user = new user();
		return ($user -> getAllUsers());
	}

	public function post() {
		$input = Functions::input("POST");
		$userid = $input['userid'];
		$user = new user();
		$info = $user->userInfoByID($userid);
		$abilities = $info['abilities'];

		$isAdmin = $info['administrator'];

		$isOwner = substr($abilities, 0, 1);  // takes bit that represents owner abilities
		$isKM    = substr($abilities, 1, 1);  // takes bit that represents kanban master abilities
		$isDev   = substr($abilities, 2, 1);  // takes bit that represents developer abilities

		/* prepares checked command for checkboxes in view */
		if($isOwner == 1){
			$isOwner = " checked ";
		}
		if($isKM == 1){
			$isKM = " checked ";
		}
		if($isDev == 1){
			$isDev = " checked ";
		}

		$data = array("r" => $info, "isOwner" => $isOwner, "isKM" => $isKM, "isDev" => $isDev, "isAdmin" => $isAdmin);
		$this->show("edituserform.view.php", $data);
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