<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class EditProject extends Controller{

	
	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}	
	}

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

	public function get()
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
			$projectID = Functions::input("GET")["projectID"];

			$project = new project();
			$p = $project->getProject($projectID);

			$owners = $this->getOwners();
			$groups = $this->getGroups();

			$data = array("project" => $p, "owners" => $owners, "groups" => $groups);
			$this -> show("editProject.view.php", $data);
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
		$id = $input["projectID"];

		$project = new project();
		
		if($start <= $end) {
			if($project->updateProject($id, $code, $name, $owner, $start, $end, $group))
			{
				$message = "Successfully updated project {$name}.";
				$data = array("message" => $message);
			}
			else{
				$data = array("error" => "Project was not updated.");
			}
		}
		else
		{
			$data = array("error" => "End date must be bigger or equal than start date. Go back and try again.");
		}
		$this->show("updateProject.view.php", $data);
	}

}