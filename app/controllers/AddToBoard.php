<?php

require_once 'Controller.php';
require_once 'core/Cache.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class AddToBoard extends Controller{

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
		$groupID = (int)(Functions::input()["GET"]["groupID"]);
		
		$group = new group();
		$groupName = $group -> getGroupName($groupID);
		
		$board = new board();
		$boards = $board -> getBoardsById($groupID);
		
		$data = array("projectID" => $projectID, "groupID" => $groupID, "boards" => $boards, "groupName" => $groupName);
		
		$this->show("addToBoard.view.php", $data);
	}
	
	public function post()
	{
		$input = Functions::input("POST");
		$projectID = $input["projectID"];
		$groupID = $input["groupID"];
		$boardID = $input["boards"];
		
		$board = new board();
		$boardName = $board -> getBoardName($boardID);

		if($board->insertIntoBoard($boardID, $groupID, $boardName, $projectID))
		{
			$message = "Successfully added project to board {$boardName}.";
			$data = array("message" => $message);
		}
		else{
			$data = array("error" => "Project was not added.");
		}
		$this->show("projecToBoard.view.php", $data);
	}

}