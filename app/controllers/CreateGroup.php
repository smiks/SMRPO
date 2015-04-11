<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class CreateGroup extends Controller{


	private function getOwners()
	{
		$user = new user();
		return ($user -> getAllUsersWithAbilities("100"));
	}

	private function getDevelopers()
	{
		$user = new user();
		return ($user -> getAllUsersWithAbilities("001"));
	}

	public function getUsersWithAbilities()
	{
	
		// TODO: iz baze podatkov
		$isMaster = true;
		if(!$isMaster){
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}
		else
		{
			
			$developers = $this->getDevelopers();
			$owners = $this->getOwners();
	
			$data = array("developers" => $developers, "owners" => $owners);
			$this -> show("createGroup.view.php", $data);
		}
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->getUsersWithAbilities();
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
		
	}
	
	public function post()
	{
		$input = Functions::input("POST");

		$owner = $input["owners"];
		$gName = $input["groupname"];
		$develop = $input["developers"];

		$group = new group();
		if($group->addGroup($gName, $develop, $owner))
		{
			$message = "Successfully added group {$gName}.";
			$data = array("message" => $message);
		}
		else{
			$data = array("error" => "Group was not created.");
		}
		$this->show("addGroup.view.php", $data);
	}
	
}