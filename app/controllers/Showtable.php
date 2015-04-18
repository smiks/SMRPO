<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
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
	public function get($board, $group){
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		
		$boardInfo = $board -> getBoard($projectID);	
		$groupID   = $boardInfo ['group_id'];
		$boardID   = $boardInfo ['board_id'];
		$boardName = $boardInfo ['name'];
		
		#$this->projectID = $projectID;
		#$this->groupID   = $groupID;
		#$this->boardID   = $boardID;
		#$this->test();
		
		$data = array("boardID" => $boardID, "boardName" => $boardName);
		$this->show("showtable.view.php", $data);
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