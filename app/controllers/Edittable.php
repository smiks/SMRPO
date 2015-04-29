<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class Edittable extends Controller{

	public function __construct() 
	{
		$board   = new board();
		$group   = new group();
		$project = new project();

		switch($_SERVER['REQUEST_METHOD']){
			case "GET": $this->get($board, $group, $project); break;
			case "POST": $this->post($board, $group, $project); break;
		}
		
	}

	private function get($board, $group, $project)
	{

		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$userid  = $_SESSION['userid'];
		$isKM    = $project->isKanbanMaster($projectID, $userid);

		if(!$isKM)
		{
			$error = "Access Denied.";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);		
		}
		else
		{
			$error = "Page is not finished.";
			$errorCode = "404";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);			
		}



	}

}