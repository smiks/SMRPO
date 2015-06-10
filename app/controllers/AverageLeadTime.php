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
			case "GET": $this->get($card, $col); break;
			case "POST": $this->post($card, $col, $move, $board); break;
		}		
	}
	
	public function get(&$card, &$col)
	{
		$boardId= (int)(Functions::input()["GET"]["boardID"]);		
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$width= (int)(Functions::input()["GET"]["width"]);
		$cards = $_SESSION['cards'];

		dbg($cards);

		exit();
		$this -> show("averageLeadTime.view.php", $data);
	}

	public function post(&$card, &$col, &$move, &$board)
	{
		$post = Functions::input("POST");
		$projectID = Functions::input("GET")['projectID'];
		$cards = $post['cards'];
		$width = Functions::input("GET")['width']+91;
		if(sizeOf($cards) == 0){
			$url = "?page=showtable&projectID={$projectID}&width={$width}";
			$url = Functions::internalLink($url);
			Functions::redirect($url);
		}

		$startCol = $post["startCol"];
		$endCol   = $post["endCol"];
		$movements  = [];
		$boardID    = $board->getBoardIDByProjectID($projectID);
		$DevelopIDs = $col->getDevelopIDs($boardID);
		$colRange = $col->getColumnsBetween($startCol, $endCol, $boardID);


		/* development statistic */
		$cardDevelop = [];
		$cardNames = [];
		foreach($cards as $id){
			$movements[$id]   = $move->getCardMovements($id);
			$cardNames[$id] = $card->getCardName($id);
			$devStatus = [];
			foreach($DevelopIDs as $devID => $_){
				$status = $move->getCardStats($id, $devID);
				array_push($devStatus, $status);
			}
			$cardDevelop[$id] = $devStatus;
		}

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


		/* column range statistic */
			/* build list with column IDs you are checking */
			$colRangeIDs = [];
			$selectedColsNames = [];
			foreach($colRange as $colArray){
				foreach($colArray as $key => $value){
					if($key == "column_id"){
						$colID = $value;
						array_push($colRangeIDs, $value);
					}
					if($key == "name"){
						$colName = $value;
					}
				}
				$selectedColsNames[$colID] = $colName;
			}


			/* prepare card-col map */	
			$cardColMap = array();
			foreach($movements as $card2 => $cardMoves){
				foreach($cardMoves as $moveID => $moveStats){
					
					/* saved check if column_id is one of selected columns */
					$selected = false;

					foreach($moveStats as $key => $value){
						if($key == "column_id"){
							/* check if column_id is one of selected */
							if(in_array($value, $colRangeIDs)){
								$selected = true;
							}
							$columnID = $value;
						}
						if($key == "date_input"){
							$dateInput = $value;
						}
						if($key == "date_output"){
							$dateOutput = $value;
						}
					}
					/* if column_id is selected, save it */
					if($selected){
						if(!is_null($dateOutput)){
							$diff = $this->timeDiff($dateInput, $dateOutput);
						}
						else{
							$diff = $this->timeDiff($dateInput, Functions::dateDB());
						}
						/* if card gets in and out of the column in same day it counts as half a day */
						$diff == 0 ? $diff += 0.5 : $diff;	
						$cardColMap[$card2][$columnID] += $diff;
					}
				}
			}

		/* development statistic */
		$cards = [];
		foreach($datesDiffs as $cardID => $time){
			$cardName = $card->getCardName($cardID);
			$cards[$cardName] = $time;
		}
		$data = array("cardsStats" => $cards, "colNames" => $selectedColsNames, "cardColMap" => $cardColMap, "cardNames" => $cardNames);
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





