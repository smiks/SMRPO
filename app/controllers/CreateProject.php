<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class CreateProject extends Controller{


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

	private function getGroups()
	{
		$p = new project();
		return ($p -> getAllGroupsFromDb());
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
			$groups = $this->getGroups();
	
			$data = array("developers" => $developers, "owners" => $owners, "groups" => $groups);
			$this -> show("createProject.view.php", $data);
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

		$code = $input["projectcode"];
		$name = $input["projectname"];
		$owner = $input["owners"];
		$group = $input["groups"];
		$start = $input["start"];
		$end = $input["end"];

		$project = new project();
		
		if($project->addProject($code, $name, $owner, $start, $end, $group))
		{
			$message = "Successfully added project {$name}.";
			$data = array("message" => $message);
		}
		else{
			$data = array("error" => "Project was not created.");
		}
		$this->show("addProject.view.php", $data);
	}
	
}