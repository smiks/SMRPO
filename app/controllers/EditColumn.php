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

class EditColumn extends Controller{

	
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
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$screenWidth= (int)(Functions::input()["GET"]["width"]);
		$userId = $_SESSION['userid'];

		$colModel = new col();

		$column = $colModel -> getColumn($columnID);
		

		$data = array("column" => $column, "projectID" => $projectID, "screenWidth" => $screenWidth);
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

		$fristchildColumns = $board -> getMinColumnIDByBoardIDandParentID($boardID, $id);

		if($fristchildColumns == NULL) {
			$noOfCards = $board -> getNumberOfCardsInColumn($id);

		} else {
			$noOfCards = $card -> countChildCards($boardID, $id);
		}
		
		if ($limit <= $noOfCards && $limit != 0)
		{
			$WIPViolation = true;
		}
		else
		{
			$WIPViolation = false;
		}
		
		$column = new col();
		$column -> updateColumn($id, $name, $limit, $priority, $testing, $boardID, $WIPViolation);

		if($WIPViolation)
		{
			$message = "By changing the limit, WIP violation will occur. Change can be accepted only by an explicit requirement.";
			$data = array("message" => $message);
			$this->show("editColumnSub.view.php", $data);
		}
		else {
			$link = "?page=showtable&projectID={$projectID}&width={$width}";
			Functions::redirect($link);
		}
		
	}

}