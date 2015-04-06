<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class Main extends Controller{
	

	public function post() {

	}


	public function home() {
		if($_SESSION['loggedin'] == 1){

			Functions::redirect(Functions::internalLink("?page=homepage"));
		}		
		$this -> show("signIn.view.php");
	}

	public function __construct() {
	
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
		elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}		
		else{
			$this->home();
		}	
	}
	

}