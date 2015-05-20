<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'app/models/card.php';
require_once 'app/models/project.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class Showtable extends Controller{

	private $projectID;
	private $groupID;
	private $boardID;

	public function __construct() {
		$board   = new board();
		$group   = new group();
		$project = new project();	
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get($board, $group, $project);
		}
		
	}

	/**/
	private function get($board, $group, $project){
		
		$user = new user();
		$userId = (int)($_SESSION['userid']);
		$isAdmin = $user -> isAdmin($userId);		
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$screenWidth= (int)(Functions::input()["GET"]["width"]);
		$isKM    = $project -> isKanbanMaster($projectID, $userId);
		$isPO = $project -> isProductOwner($projectID, $userId);
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
			$isEmpty   = $board->isEmpty($boardId);
			
			$data = array();
			$screenWidth = (int)($_GET['width'])-5;
			
			$cells = array();
			$cells = $this -> getCells(0, 160, $screenWidth-30, null, $boardId, $cells);
			
			foreach($projects as $projectId => $val)
			{
				$project = $projects[$projectId];
				
				$card = new card();
				$cards = $card -> getCards($projectId, $boardId);
	
				$data[$projectId] = array("cards" => $cards);
			}
			
			$dataToShow = array("data" => $data, "boardName" => $boardName, "groupId" => $groupId, "cells" => $cells, "isEmpty" => $isEmpty, "projectID" => $projectID, "isKM" => $isKM, "isPO" => $isPO, "screenWidth" => $screenWidth, "boardId" => $boardId);
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
			$parent_id = $columns[$colId]['parent_id']; 
			$column_id = $columns[$colId]['column_id'];
			$cells[$colId] = array("x" => $newX, "y" => $y + 42, "length" => $childLength, "name" => $name, "limit" => $limit, "color" => $color, "parent_id" => $parent_id, "column_id" => $column_id);
			$i = $i + 1;
			$cells = $this -> getCells($newX, $y + 42, $childLength, $colId, $boardId, $cells, $parent_id, $column_id);
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