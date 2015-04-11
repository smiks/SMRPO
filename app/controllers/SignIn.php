<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class Main extends Controller{
	

	public function post() {

	}

	public function get() {
		$this -> show("signIn.view.php");
	}
	
	public function home() {
		$this -> show("signIn.view.php");
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