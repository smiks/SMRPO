<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

class Login extends Controller{
	
	public function post() {
		$inputData = Functions::input()["POST"];

		/* this MUST be changed */
		if($inputData['login_email'] == "test@test.test" && $inputData['login_password'] == "test"){
			$_SESSION['loggedin'] = 1;

			/* everything is "ok" */
			Functions::redirect(Functions::internalLink("?page=homepage"));
		}

		$data = array("error" => "Wrong login credentials!");
		$this->show("signIn.view.php", $data);
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