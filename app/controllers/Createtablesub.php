<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class Createtablesub extends Controller{

	public function __construct() 
	{
		$board = new board();
		$group = new group();

		switch($_SERVER['REQUEST_METHOD']){
			case "GET": $this->get($board, $group); break;
			case "POST": $this->post($board, $group); break;
		}
		
	}

	private function post($board, $group)
	{
		$post      = Functions::input()["POST"];

		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$groupID   = $group->getGroupIDFromProjectID($projectID);
	
		$boardName = $post["boardName"];

		$nCols1    = $post['nCols1'];
		$nCols2    = $post['nCols2'];
		$nCols3    = $post['nCols3'];

		/* info about parent columns */
		$limitCol1 = $post['limitCol1'];
		$limitCol2 = $post['limitCol2'];
		$limitCol3 = $post['limitCol3'];

		$colorCol1 = $post['colorCol1'];
		$colorCol2 = $post['colorCol2'];
		$colorCol3 = $post['colorCol3'];

		$namePC1   = "BackLog";
		$namePC2   = "Development";
		$namePC3   = "Done";

		/* info about first subcolumns */
		$subC1 = array();
		for($i=0; $i<$nCols1; $i++){
			$cName  = "1_".($i+1);
			$cLimit = $cName."_limit";
			$name   = $post[$cName];
			$limit  = $post[$cLimit];
			$subC1[$name] = $limit;
		}
		
		/* info about second subcolumns */
		$subC2 = array();
		for($i=0; $i<$nCols2; $i++){
			$cName  = "2_".($i+1);
			$cLimit = $cName."_limit";
			$name   = $post[$cName];
			$limit  = $post[$cLimit];
			$subC2[$name] = $limit;
		}

		/* info about third subcolumns */
		$subC3 = array();
		for($i=0; $i<$nCols3; $i++){
			$cName  = "3_".($i+1);
			$cLimit = $cName."_limit";
			$name   = $post[$cName];
			$limit  = $post[$cLimit];
			$subC3[$name] = $limit;
		}

		/* addNewBoard($boardName, $groupID, $projectID, $parentOne, $parentTwo, $parentThree, $firstSubColumn, $secondSubColumn, $thirdSubColumn) */
		$parentOne   = array($limitCol1 => $colorCol1);
		$parentTwo   = array($limitCol2 => $colorCol2);
		$parentThree = array($limitCol3 => $colorCol3);

		$board -> addNewBoard($boardName, $groupID, $projectID, $parentOne, $parentTwo, $parentThree, $subC1, $subC2, $subC3);

		$data = array("boardName" => $boardName);
		$this->show("createtablesub.view.php", $data);

	}

}