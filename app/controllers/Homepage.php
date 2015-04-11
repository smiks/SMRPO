<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class Homepage extends Controller{
	

	public function post() {

	}

	public function get() {
		$user = new user();
		$info = $user->userInfoByID($_SESSION['userid']);
		$name = $info['name'];
		$surname = $info['surname'];
		$isAdministrator = $info['administrator'];
		$data = array("myName" => $name, "mySurname" => $surname, "isAdministrator" => $isAdministrator);
		$this -> show("homepage.view.php", $data);
	}

	public function home() {
		$user = new user();
		$info = $user->userInfoByID($_myUserID);
		$name = $info['name'];
		$surname = $info['surname'];
		$data = array("myName" => $name, "mySurname" => $surname);
		$this -> show("homepage.view.php", $data);
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