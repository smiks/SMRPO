<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Createtable extends Controller{

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
		$boardName = $post["boardName"];
		$nCols1    = $post['numColsOne'];
		$nCols2    = $post['numColsTwo'];
		$nCols3    = $post['numColsThree'];
		$colorCol1 = $post['colorColsOne'];
		$colorCol2 = $post['colorColsTwo'];
		$colorCol3 = $post['colorColsThree'];
		$totalCols = $nCols1+$nCols2+$nCols3;
		$wCol1     = 33 / $nCols1;
		$wCol2     = 33 / $nCols2;
		$wCol3     = 33 / $nCols3;
		$limitCol1 = $post['limitColsOne'];
		$limitCol2 = $post['limitColsTwo'];
		$limitCol3 = $post['limitColsThree'];
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$groupID   = $group->getGroupIDFromProjectID($projectID);
		$data      = array("projectID" => $projectID, "groupID" => $groupID, "boardName" => $boardName, 
							"nCols1" => $nCols1, "nCols2" => $nCols2, "nCols3" => $nCols3,
							"colorCol1" => $colorCol1, "colorCol2" => $colorCol2, "colorCol3" => $colorCol3, 
							"wCol1" => $wCol1, "wCol2" => $wCol2, "wCol3" => $wCol3, 
							"totalCols" => $totalCols, 
							"limitCol1" => $limitCol1, "limitCol2" => $limitCol2, "limitCol3" => $limitCol3);
		$this->show("createtablenext.view.php", $data);
	}

	private function get($board, $group)
	{
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$groupID   = $group->getGroupIDFromProjectID($projectID);
		$data      = array("projectID" => $projectID, "groupID" => $groupID);
		$this->show("createtable.view.php", $data);
	}

}