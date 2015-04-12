<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class CreateGroup extends Controller{

	//vrne vse uporabnike, ki imajo ability biti product owner
	private function getOwners()
	{
		$user = new user();
		return ($user -> getAllUsersWithAbilities("100"));
	}
	//vrne vse uporabnike, ki imajo ability biti razvijalci
	private function getDevelopers()
	{
		$user = new user();
		return ($user -> getAllUsersWithAbilities("001"));
	}

	//ce uporabnik ni KM, ne more kreirati grupe
	//ta funkcija se uporabi za pridobitev seznama uporabnikov z ability-ji razvijalca in product owner-ja
	public function getUsersWithAbilities()
	{
		$isMaster = false;
		$user = new user();
		$isMaster = $user->isKanbanMaster($_SESSION['userid']);

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
	
	//pridobivanje podatkov za kreiranje nove skupine
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