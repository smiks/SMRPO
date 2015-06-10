<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/settings.php';
require_once 'core/Functions.php';


Functions::forceLogin();

class CriticalCards extends Controller{
	
	public function post() {
		// get input data
		$input = Functions::input("POST");
		$criticalDays = $input['criticalCardsDays'];
		
		// store critical days into session
		$_SESSION['criticalDays'] = $criticalDays;
		$settings = new settings();
		$settings -> insertCriticalDays($criticalDays);
		
		// redirect
		$message= "Critical Days were successfully set to value {$criticalDays}!";
		$data = array("message" => $message);
		$this->show("criticalCardsSub.view.php", $data);
			
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
	}

}