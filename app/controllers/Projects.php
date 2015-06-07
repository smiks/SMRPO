<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

Functions::forceLogin();

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
		$board = new board();
		$user = new user();
		
		$userId = $_SESSION['userid'];
		$isAdmin = $user -> isAdmin($userId);

		foreach ($projects as $key => $value) {
			$project = $projects[$key];
			$projectID = $project['id_project'];
			$group = $p->getGroupName($projectID);
			$groupId = $p -> getGroupId($projectID);
			$boardExists = $board -> boardExists($projectID);
			$numActive = $p -> activeUserOnProject($userId, $projectID);
       		$projects[$key]['group'] = $group;
       		$projects[$key]['groupId'] = $groupId;
       		$projects[$key]['client'] = $project['client'];
        	$projects[$key]['boardExists'] = $boardExists;
        	$projects[$key]['numActive'] = $numActive;
		}

		$data = array("projects" => $projects, "isAdmin" => $isAdmin);
        $this->show("projects.view.php", $data);
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->getProjectsToShow();
		}
	}
	
	
}