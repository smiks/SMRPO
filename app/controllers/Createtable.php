<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class Createtable extends Controller{

	public function __construct() 
	{
		$board = new board();
		$group = new group();

		switch($_SERVER['REQUEST_METHOD']){
			case "GET": $this->get($board, $group); break;
		}
		
	}


	private function get($board, $group)
	{
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$groupID   = $group->getGroupIDFromProjectID($projectID);
		$data      = array("projectID" => $projectID, "groupID" => $groupID);
		$this->show("createtable.view.php", $data);
	}

}