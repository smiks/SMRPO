<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class Projects extends Controller{

	private function getProjects()
	{
		$project = new project();
		return ($project -> getAllProjects());
	}

	public function getProjectsToShow()
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
			$projects = $this->getProjects();

			$data = array("projects" => $projects);
                        $this->show("projects.view.php", $data);
			
		}
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->getProjectsToShow();
		}

	}
	
	
}