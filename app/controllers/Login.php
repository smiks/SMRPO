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

		/* this MUST be changed */
		if($inputData['usrname'] == "test" && $inputData['passwrd'] == "test"){
			$_SESSION['loggedin'] = 1;

			/* everything is "ok" */
			Functions::redirect(Functions::internalLink("?page=homepage"));
		}

		$this->show("homepage.view.php", $data);
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