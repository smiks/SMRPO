<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'app/models/cards.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Showtable extends Controller{

	private $projectID;
	private $groupID;
	private $boardID;

	public function __construct() {
		$board = new board();
		$group = new group();		
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get($board, $group);
		}
		
	}

	/**/
	private function get($board, $group){
		
		$user = new user();
		$userId = $_SESSION['userid'];
		$isAdmin = $user -> isAdmin($userId);		
		
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		
		$boardd = $board -> getBoardByProjectID($projectID);
		$groupId = $boardd['group_id'];
		
		$isMember = $group -> isMember($userId, $groupId);
		
		if (!$isAdmin && !$isMember)
		{
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);	
		}
		else
		{
		
			$boardId = $boardd['board_id'];
			$projects = $board -> getAllProjects($boardId);
			$boardName = $boardd['name'];
			
			
			$data = array();
			$screenWidth = (int)($_GET['width'])-5;
			
			$cells = array();
			$cells = $this -> getCells(0, 120, $screenWidth-30, null, $boardId, $cells);
			
			foreach($projects as $projectId => $val)
			{
				$project = $projects[$projectId];
				
				$card = new cards();
				$cards = $card -> getCards($projectId, $boardId);
	
				$data[$projectId] = array("cards" => $cards);
			}
			
			$dataToShow = array("data" => $data, "boardName" => $boardName, "groupId" => $groupId, "cells" => $cells);
			$this->show("showtable.view.php", $dataToShow);
		}
	}
	
	private function getCells($x, $y, $parentLength, $parentId, $boardId, $cells)
	{
		$board = new board();
		$columns = $board -> getColumnsByParent($boardId, $parentId);
		$numChildren = count($columns);

		if ($numChildren == 0)
			return $cells;
		
		$childLength = $parentLength/$numChildren;

		$i = 0;
		
		foreach ($columns as $colId => $val)
		{
			$newX = $x +  $i * $childLength;
			$name = $columns[$colId]['name'];
			$limit= $columns[$colId]['cardLimit'];
			$color = $columns[$colId]['color'];
			$cells[$colId] = array("x" => $newX, "y" => $y + 42, "length" => $childLength, "name" => $name, "limit" => $limit, "color" => $color);
			$i = $i + 1;
			$cells = $this -> getCells($newX, $y + 42, $childLength, $colId, $boardId, $cells);
		}
		return $cells;
	}


	private function test(){
		echo"<br>ProjectID:<br>";
		var_dump($this->projectID);
		echo"<br>GroupID:<br>";
		var_dump($this->groupID);
		echo"<br>BoardID:<br>";
		var_dump($this->boardID);
		exit("<br>TESTING<br>");
	}

}