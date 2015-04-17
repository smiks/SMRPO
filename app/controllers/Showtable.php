<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Showtable extends Controller{

	public function __construct() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		
	}



	/**/
	public function get(){
		$projectID = Functions::input()["GET"]["projectID"];
		

	}

}