<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/project.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'app/models/user.php';
require_once 'app/models/board.php';
require_once 'app/models/col.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class EditColumnSub extends Controller{

	
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

	}
	
	public function post()
	{
		$input = Functions::input("POST");

		$id = $input["columnID"];
		$cName = $input["cName"];

		$limit = $input["limit"];
		$priority = $input["priority"];
		$testing = $input["testing"];
		$width = $input["screenWidth"] + 5;
		$projectID = $input["projectID"];

		$board = new board();
		$card = new card();

		$b = $board -> getBoardByProjectID($projectID);
		$boardID = $b["board_id"];


		if(isset($_POST['submitNo'])){
			$url = "?page=showtable&projectID={$projectID}&width={$width}";
			$url = Functions::internalLink($url);
			Functions::redirect($url);
		}

		if(isset($_POST['submitYes'])){

			$column = new col();
						
			$column -> updateColumn($id, $cName, $limit, $priority, $testing, $boardID, true);

			$link = "?page=showtable&projectID={$projectID}&width={$width}";
			Functions::redirect($link);
		}		
	}

}