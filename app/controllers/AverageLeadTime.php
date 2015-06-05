<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'app/models/movements.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class AverageLeadTime extends Controller{

	public function __construct() {
		$card  = new card();
		$col   = new col();
		$move  = new movements();
		$board = new board();
		switch($_SERVER['REQUEST_METHOD']){
			case "GET": $this->get($card); break;
			case "POST": $this->post($card, $col, $move, $board); break;
		}		
	}
	
	public function get(&$card)
	{
		$get = Functions::input("GET");
		$boardID = $get['boardId'];
		$cards = $card -> getCardsFromBoard($boardID);
		$cardsData = [];
		foreach($cards as $key => $value){
			$cardsData[$key] = $value['name'];
		}
		$data = array("cards" => $cardsData);
		$this -> show("averageLeadTime.view.php", $data);
	}

	public function post(&$card, &$col, &$move, &$board)
	{
		$post = Functions::input("POST");
		$projectID = Functions::input("GET")['projectID'];
		$cards = $post['cards'];
		$movements  = [];
		$boardID    = $board->getBoardIDByProjectID($projectID);
		$BackLogID  = $col->getBackLogID($boardID);
		$DevelopIDs = $col->getDevelopIDs($boardID);
		$DoneID     = $col->getDoneID($boardID);

		$cardBacklog = [];
		$cardDevelop = [];
		$cardDone    = [];

		foreach($cards as $id){
			$movements[$id]   = $move->getCardMovements($id);
			#$cardBacklog[$id] = $move->getCardStats($id, $BackLogID);
			$devStatus = [];
			foreach($DevelopIDs as $devID => $_){
				$status = $move->getCardStats($id, $devID);
				array_push($devStatus, $status);
			}
			$cardDevelop[$id] = $devStatus;
			#$cardDone[$id]    = $move->getCardStats($id, $DoneID);
		}

		$statistic = [];
		#dbg($cardDevelop);
		$datesDiffs = [];
		foreach($cardDevelop as $cID => $array){
			foreach($array as $moveLogs){
				$diffs = [];
				foreach($moveLogs as $value){
					if(!is_null($value['date_output'])){
						$diff = $this->timeDiff($value['date_input'], $value['date_output']);
					}
					else{
						$diff = $this->timeDiff($value['date_input'], Functions::dateDB());
					}

					/* if card gets in and out of the column in same day it counts as half a day */
					$diff == 0 ? $diff += 0.5 : $diff;				
					array_push($diffs, $diff);
				}
				$datesDiffs[$cID] = array_sum($diffs);
			}
		}

		$cards = [];
		foreach($datesDiffs as $cardID => $time){
			$cardName = $card->getCardName($cardID);
			$cards[$cardName] = $time;
		}

		$data = array("cardsStats" => $cards);
		$this -> show("averageLeadTimeShow.view.php", $data);

	}

	private function timeDiff($date1, $date2){
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);
		$interval = $date1->diff($date2);
		/* return difference in days */
		return (int)($interval->format('%a'));
	}

	private function minDate($dates){
		return min($dates);
	}

	private function maxDate($dates){
		return max($dates);
	}

}





