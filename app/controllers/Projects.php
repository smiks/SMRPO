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
		$projects = $this->getProjects();

		$p = new project();

		foreach ($projects as $key => $value) {
			$project = $projects[$key];
			$projectID = $project['id_project'];
			$owner = $p->getOwner($projectID);
			$group = $p->getGroupName($projectID);
			$boardExists = $p -> boardExists($projectID);
	       		$projects[$key]['group'] = $group;
	       		$projects[$key]['ownerName'] = $owner['name'];
	        	$projects[$key]['ownerSurname'] = $owner['surname'];
	        	$projects[$key]['boardExists'] = $boardExists;
		}

		$data = array("projects" => $projects);
        	$this->show("projects.view.php", $data);
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->getProjectsToShow();
		}
	}
	
	
}