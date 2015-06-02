<?php

require_once 'Controller.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'app/models/board.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/user.php';
require_once 'app/models/movements.php';
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
		$move = new movements();
		$post = Functions::input("POST");
		$get = Functions::input("GET");
		$newColumn = (int)($post['columnID']);
		$cardID   = (int)($get["cardID"]);
		$boardID  = $board->getBoardByCardID($cardID);
		$width = (int)($get['width']);
		$projectID = (int)($get['projectID']);
		$success = $card->moveCard($cardID, $newColumn);
		$lastMoveID = $move->lastStatus($cardID);

		$move->moveCard($cardID, $newColumn, $boardID, $lastMoveID);

		$url = $_http.$_Domain."/?page=showtable&projectID={$projectID}&width={$width}";
		Functions::redirect($url);
		
	}

}