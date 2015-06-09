<?php

require_once 'Controller.php';
require_once 'core/Cache.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/project.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class AddProjectToBoard extends Controller{

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
	}
	
	public function get()
	{
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$userID = (int)($_SESSION['userid']);
		
		$project = new project();
		$projects = $project -> getProjectsByUserID($userID);
		
		
		$data = array("projects" => $projects, "projectID" => $projectID);
		
		$this->show("addProjectToBoard.view.php", $data);
	}
	
	public function post()
	{
		$board = new board();
		$project = new project();
		$input = Functions::input("POST");
		$projectID = (int)($input["project"]);
		$oldProjectID = (int)($input["oldproject"]);
		if($projectID != 0)
		{
			$boardID = $board->getBoardIDByProjectID($oldprojectID);
			$board->updateBoardProject($projectID, $boardID);
			$project->removeProject($oldprojectID);
		}
		$url = "?page=projects";
		$url = Functions::internalLink($url);
		Functions::redirect($url);
		
	}
	
}