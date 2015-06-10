<?php

require_once 'Controller.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'app/models/board.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/user.php';
require_once 'app/models/movements.php';
require_once 'app/models/project.php';
require_once 'app/models/history.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class Confirmwip extends Controller{

	
	public function __construct() {
		$board = new board();
		$card  = new card();
		$col   = new col();
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post($board, $card, $col);
		}	
	}

	public function get()
	{
		$get       = Functions::input("GET");
		$cardID    = (int)($get["cardID"]);
		$boardID   = (int)($get["boardID"]);
		$newColumn   = (int)($get["newColumn"]);
		$projectID   = (int)($get["projectID"]);
		$width = (int)($get['width']);


		$data = array("cardID" => $carID, "boardID" => $boardID, "newColumn" => $newColumn, "projectID" => $projectID, "width" => $width);
		$this->show("confirmwip.view.php", $data);

	}

	public function post(&$board, &$card, &$col)
	{
		$userid = $_SESSION['userid'];
		$move = new movements();
		$project = new project();
		$history = new history();
		$get       = Functions::input("GET");
		$post      = Functions::input("POST");
		$cardID    = (int)($get["cardID"]);
		$boardID   = (int)($get["boardID"]);
		$newColumn   = (int)($get["newColumn"]);
		$projectID   = (int)($get["projectID"]);
		$width = (int)($get['width']);

		/* 	Errors */
		$error = false;
		/* 	Preveri, da uporabnik prestavlja samo kartice, ki pripadajo njegovemu projektu. */
		$isMember = $project->isMemberOfProject($projectID, $userid);
		if(!$isMember){
			$error = "Forbidden. You do not work on this project.";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
			$error = true;
		}


		/* check if confirmed */
		if(isset($_POST['submitNo'])){
			$error = true;
			$url = "?page=showtable&projectID={$projectID}&width={$width}";
			$url = Functions::internalLink($url);
			Functions::redirect($url);
		}

		/* Everything ok - user is allowed to move the card */
		if(!$error){
			$success = $card->moveCard($cardID, $newColumn);
			$lastMoveID = $move->lastStatus($cardID);
			$colName = $col->getColName($newColumn);
			$move->moveCard($cardID, $newColumn, $boardID, $lastMoveID);
			$type = "WIPViolation";
			$event = "WIP Violation";
			$details = "WIP Violation happened when moving card in column: {$colName}.";
			$date = Functions::dateDB();
			$history->insertHistory($cardID, $type, $event, $userid, $details, $date);
			$type = "Movement";
			$event = "Card moved";
			$details = "Card was moved to column {$colName} (WIP Violation occured)";
			$history->insertHistory($cardID, $type, $event, $userid, $details, $date);
			/* URL of project */
			$url = "?page=showtable&projectID={$projectID}&width={$width}";
			$url = Functions::internalLink($url);
			Functions::redirect($url);
		}
	}

}