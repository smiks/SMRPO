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

		$columnID = Functions::input("GET")["columnID"];
		$name = Functions::input("GET")["name"];
		$limit = (int)(Functions::input("GET")["limit"]);
		$priority = Functions::input("GET")["priority"];
		$testing = Functions::input("GET")["testing"];
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$width= (int)(Functions::input()["GET"]["width"]);
		$userId = $_SESSION['userid'];

		$colModel = new col();

		$column = $colModel -> getColumn($columnID);
		

		$data = array("columnID" => $columnID, "projectID" => $projectID, "width" => $width, "name" => $name, "limit" => $limit, "priority" => $priority, "testing" => $testing);
		$this -> show("editColumn.view.php", $data);

	}
	
	public function post()
	{
		$input = Functions::input("POST");

		$id = $input["columnID"];
		$name = $input["name"];
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
			$column -> updateColumn($id, $name, $limit, $priority, $testing, $boardID, true);

			$link = "?page=showtable&projectID={$projectID}&width={$width}";
			Functions::redirect($link);
		}		
	}

}