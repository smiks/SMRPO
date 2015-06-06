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

class MoveCard extends Controller{

	
	public function __construct() {
		$board = new board();
		$card  = new card();
		$col   = new col();
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get($board, $card, $col);
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post($board, $card, $col);
		}	
	}

	public function get(&$board, &$card, &$col)
	{
		$cardID   = (int)(Functions::input("GET")["cardID"]);
		$boardID  = $board->getBoardByCardID($cardID);
		$cols     = $col->getAllColumns($boardID);
		$cardInfo = $card->getCard($cardID);
		$cardName = $cardInfo['name'];
		$currCol  = $cardInfo['column_id'];
		$columns  = [];
		foreach($cols as $key => $value){
			if($col->isNeighbour($currCol, $key)){
				$columns[$key] = $value['name'];
			}
		}

		$data = array("columns" => $columns, "cardName" => $cardName, "currCol" => $currCol);
		$this->show("movecard.view.php", $data);

	}

	public function post(&$board, &$card, &$col)
	{
		$userid = $_SESSION['userid'];
		$move = new movements();
		$project = new project();
		$post = Functions::input("POST");
		$get = Functions::input("GET");
		$history = new history();
		$newColumn = (int)($post['columnID']);
		$cardID   = (int)($get["cardID"]);
		$boardID  = $board->getBoardByCardID($cardID);
		$width = (int)($get['width']);
		$projectID = (int)($get['projectID']);
		$colInfo = $col->getColumn($newColumn);
		$colLimit = $colInfo['cardLimit'];
		$cardInfo = $card->getCard($cardID);
		$currCol  = $cardInfo['column_id'];
		$numCards = $card->countCards($boardID, $newColumn);

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

		/* 	Preveri prestavljanje za en stolpec levo/desno (praviloma so dovoljeni samo pomiki za en stolpec v vsako smer). */

		/* 	Preveri, ali se upošteva omejitev WIP (če pride do kršitve, se izpiše opozorilo, 
			kartica pa se lahko premakne samo na izrecno zahtevo; kršitev se avtomatsko zabeleži). 
			Limit 0 means no limit */
		if($numCards > $colLimit && $colLimit > 0){
			/* confirmation page */
			$url = "?page=confirmwip&cardID={$cardID}&newColumn={$newColumn}&boardID={$boardID}&projectID={$projectID}&width={$width}";
			$url = Functions::internalLink($url);
			Functions::redirect($url);
			$error = true;
		}


		/* 	Preveri prestavljanje za več stolpcev (prepovedano, izjema je vračanje iz sprejemenga testiranja) */
		if(!isset($_POST['rejected'])){
			/* 	check previous and new column id and check for neighbours 
				if neighbours true is ok, if false -> throw error */
			$isNeighbour = $col->isNeighbour($currCol, $newColumn);
			if(!$isNeighbour){
				$error = "Forbidden. Only adjacent columns are allowed.";
				$errorCode = "403";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$error = true;
			}

		}


		/* 	Preveri prestavljanje kartice, ki predstavlja zavrnjeno zgodbo (kartico lahko prestavi samo Product Owner, 
			kartica se lahko prestavi v stolpec s karticami z najvišjo prioriteto ali v kateregakoli levo od njega; 
			če pri tem pride do kršitve omejitve WIP, se ta kršitev zabeleži; tip/barva kartice se spremeni) */
		
			/* If moved back to parent with name BackLog check if product owner */
			$isPO = $project->isProductOwner($projectID, $userid);
			if($isPO && isset($_POST['rejected'])){
				/* find right column */
				$newColumn = $col->getRejectColumn($boardID);
				/* updace card color */
				$color = "660066";
				$card->updateColor($cardID, $color);
				$type = "Rejection";
				$event = "Card rejected";
				$details = "Card was rejected";
				$date = Functions::dateDB();
				$history->insertHistory($cardID, $type, $event, $userid, $details, $date);			
			}

			elseif(!$isPO && isset($_POST['rejected'])){
				$error = "Forbidden. Only Product Owner can reject card.";
				$errorCode = "403";
				$data = array("error" => $error, "errorCode" => $errorCode);
				$this->show("error.view.php", $data);
				$error = true;
			}

		/* Everything ok - user is allowed to move the card */
		if(!$error){
			$success = $card->moveCard($cardID, $newColumn);
			$lastMoveID = $move->lastStatus($cardID);
			$move->moveCard($cardID, $newColumn, $boardID, $lastMoveID);
			/* URL of project */
			$url = "?page=showtable&projectID={$projectID}&width={$width}";
			$url = Functions::internalLink($url);
			Functions::redirect($url);
		}
	}

}