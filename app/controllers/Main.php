<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class Main extends Controller{
	

	public function post() {

	}


	public function home() {
		$this -> show("home.view.php");
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