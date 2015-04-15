<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/project.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class DeleteProject extends Controller{
	
	public function post() {

		$project = new project();

		$input = Functions::input("POST");
		$id = $input['projectid'];

		if($project->deleteProject($id))
		{
			$message = "Successfully deleted project.";
			$data = array("message" => $message);
		}
		else{
			$data = array("error" => "Project was not deleted.");
		}
		$this->show("deleteprojectsub.view.php", $data);			
	}

	public function get() {

		$id = Functions::input("GET")["projectID"];

		$project = new project();

		$p = $project->getProject($id);
		
		$pname = $p['name'];

		$data = array("pname" => $pname, "projectid" => $id);

		$this->show("deleteproject.view.php", $data);

		
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