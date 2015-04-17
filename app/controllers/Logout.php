<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';

class Logout extends Controller{
	
	public function post() {

	}

	public function get() {


		
	}

	public function home(){

	}

	public function __construct() {
		$_SESSION['loggedin'] = 0;
		$_SESSION['userid']   = 0;
		unset($_SESSION);
		Functions::redirect("http://dev.smrpo.avatar-rpg.net/index.php?page=main");
	}

}