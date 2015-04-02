<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

class Login extends Controller{
	
	public function post() {
		$inputData = Functions::input()["POST"];

		/* To je samo testno */
		if(strlen($inputData['usrname']) < 5){
			$data = array("error" => "Username is too short");
		}

		$this->show("home.view.php", $data);
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