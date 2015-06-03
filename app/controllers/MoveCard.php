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
			$columns[$key] = $value['name'];
		}

		$data = array("columns" => $columns, "cardName" => $cardName, "currCol" => $currCol);
		$this->show("movecard.view.php", $data);

	}

	public function post(&$board, &$card, &$col)
	{
		global $_http, $_Domain;
		$userid = $_SESSION['userid'];
		$move = new movements();
		$project = new project();
		$post = Functions::input("POST");
		$get = Functions::input("GET");
		$newColumn = (int)($post['columnID']);
		$cardID   = (int)($get["cardID"]);
		$boardID  = $board->getBoardByCardID($cardID);
		$width = (int)($get['width']);
		$projectID = (int)($get['projectID']);
		$colInfo = $col->getColumn($newColumn);
		$colLimit = $colInfo['cardLimit'];
		$numCards = $card->countCards($boardID, $newColumn);


		/* URL of project */
		$url = "?page=showtable&projectID={$projectID}&width={$width}";
		$url = Functions::internalLink($url);

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
		if($numCards > $colLimit){
			// TODO 
		}
		/* 	Preveri prestavljanje za več stolpcev (prepovedano, izjema je vračanje iz sprejemenga testiranja) */

		/* 	Preveri prestavljanje kartice, ki predstavlja zavrnjeno zgodbo (kartico lahko prestavi samo Product Owner, 
			kartica se lahko prestavi v stolpec s karticami z najvišjo prioriteto ali v kateregakoli levo od njega; 
			če pri tem pride do kršitve omejitve WIP, se ta kršitev zabeleži; tip/barva kartice se spremeni) */
		
		/* If moved back to parent with name BackLog check if product owner */
		/* isPO = $project->isProductOwner($projectID, $userid); */

		/* Everything ok - user is allowed to move the card */
		if(!$error){
			$success = $card->moveCard($cardID, $newColumn);
			$lastMoveID = $move->lastStatus($cardID);
			$move->moveCard($cardID, $newColumn, $boardID, $lastMoveID);

			Functions::redirect($url);
		}
	}

}