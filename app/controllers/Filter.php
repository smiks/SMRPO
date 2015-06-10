<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'app/models/movements.php';
require_once 'app/models/history.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class Filter extends Controller{

	public function __construct() {
		$card  = new card();
		$col   = new col();
		$move  = new movements();
		$board = new board();
		switch($_SERVER['REQUEST_METHOD']){
			case "GET": $this->get($board, $card, $col); break;
			case "POST": $this->post(); break;
		}			
	}
	
	public function get(&$board, &$card, &$col)
	{
		$get = Functions::input("GET");
		$boardID= (int)($get["boardId"]);
		$projectID = (int)($get["projectID"]);
		$width= (int)($get["width"]);
		$goto= ($get["goto"]);
		$projects = $board -> getProjects($boardID);
		$dateNow = Functions::dateDB();
		$fromDate = date("Y-m-d", strtotime("-1 month"));

		/* get date of the oldest card */
		$oldestCardDate = $card->getOldestCard($boardID);
		$dates = array($fromDate, $oldestCardDate);
		/* if oldest card is older than 1 month that fromDate is 1 month ago otherwise fromDate is oldestCard*/
		$fromDateCreation = max($dates);

		/* čas za koncanje kartice */
		$doneStartDate = $col->getStartDoneDate($boardID);
		$dates = array($fromDate, $doneStartDate);
		$fromDateDone = max($dates);

		/* čas zacetka razvoja */
		$devStartDate = $col->getStartDevelpomentDate($boardID);
		$dates = array($fromDate, $devStartDate);
		$fromDateDev = max($dates);


		/* max card size */
		$maxSize = $card->getMaxCardSize($boardID);

		/* columns */
		$colNames  = $col->getColNames($boardID);
		
		$data = array("projects" => $projects, "fromDateCreation" => $fromDateCreation, "fromDateDev" => $fromDateDev, "fromDateDone" => $fromDateDone,"maxSize" => $maxSize, "boardID" => $boardID, "projectID" => $projectID, "width" => $width, "goto" => $goto, "colNames" => $colNames);
		$this -> show("filter.view.php", $data);
	}
	
	public function post()
	{
		$input = Functions::input("POST");

		/* selectedFilters looks like
		 [0]=> string(8) "creation" [1]=> string(3) "done" [2]=> string(7) "develop" [3]=> string(5) "range" [4]=> string(4) "type" 
		*/
		$selectedFilters = $input["filters"];

		$projects = $input['projects'];
		
		$fromDateCreation = $input['fromDateCreation'];
		$toDateCreation = $input['toDateCreation'];
		
		$fromDateDone = $input['fromDateDone'];
		$toDateDone = $input['toDateDone'];
		
		$fromDateDev = $input['fromDateDev'];
		$toDateDev = $input['toDateDev'];
		
		$minSize = $input['minSize'];
		$maxSize = $input['maxSize'];
		
		$tip = $input['tip'];
		$goto = $input['goto'];

		$startCol = $input['startCol'];
		$endCol   = $input['endCol'];
		
		$boardID = $input['boardID'];
		#$projectID = $input['projectID'];
		/* as ugly as it can get and worse */
		$projectID = $projects;
		$width= $input['width'];
		
		$movement = new movements();
		$history = new history();
		$card = new card();
		$column = new col();
		//vse kartice table
		$allCards = $card -> getCards($projectID, $boardID);
		//vsi stolpci table
		$allColumns = $column -> getAllColumns($boardID);
		
		$cards = array();
		#dbg($allCards);
		foreach ($allCards as $cardId => $card)
		{
			#var_dump($cardId);
			$isOk = true;
			$cardSize = $card['size'];
			$cardType = $card['type'];
			$cardColor = $card['color'];
			#var_dump($cardSize);
			#var_dump($cardType);

			/* checking range filter */
			if(($cardSize < $minSize || $cardSize > $maxSize) && $this->isSelected("range", $selectedFilters))
			{
				echo"<li>Range filter was selected</li>";
				$isOk = false;
				continue;
			}
			
			/* checking type filter */
			if($tip != 2 && $cardType != $tip && $this->isSelected("type", $selectedFilters))
			{
				echo"<li>Type filter was selected</li>";
				$isOk = false;
				continue;
			}

			/* checking type filter */
			if($tip == 2 && $cardColor != "660066" && $this->isSelected("type", $selectedFilters))
			{
				echo"<li>Type filter was selected</li>";
				$isOk = false;
				continue;
			}


			/* checking creation filter */
			//$createdDate = $history -> getCreateDate($cardId);
			$createdDate = $movement->getLowestDate($cardId);
			#var_dump($createdDate);
			if(($createdDate < $fromDateCreation || $createdDate > $toDateCreation) && $this->isSelected("creation", $selectedFilters))
			{
				echo"<li>Creation filter was selected</li>";
				$isOk = false;
				continue;
			}
			
			/* checking develop filter */
			$lastDevDate = $column -> getFirstDevColDate($boardID);
			$isInsideDev = $movement -> checkIfExists($boardID, $cardId, $fromDateDev, $toDateDev);
			#var_dump($lastDevDate);
			if(!$isInsideDev && $this->isSelected("develop", $selectedFilters))
			{
				echo"<li>Develop filter was selected</li>";
				$isOk = false;
				continue;
			}
			
			$colIDNextTesting = $column -> getNextTesting($boardID);

			/* checking done filter */
			$doneDate = $movement -> getInputDate($boardID, $colIDNextTesting, $cardId);
			#var_dump($doneDate);
			if(($doneDate < $fromDateDone || $doneDate > $toDateDone) && $this->isSelected("done", $selectedFilters))
			{
				echo"<li>Done filter was selected</li>";
				$isOk = false;
				continue;
			}
			
			if($isOk)
			{
				$cards[$cardId] = $movement->getData($cardId);
				var_dump($cards[$cardId]);
			}

			#echo"<hr>BID {$boardID}<br>";
			#echo"<li>{$colIDNextTesting} :: {$cardId}</li>";
			#echo"<br>";
			
		}
		var_dump($cards);
		

		/* what we need */
			/* we need card_id, column_id, all date_input and all date_output */
		/* when do we need */
			/* now */
		/* what will be key */
			/* column_id */

		/* 
			$cards = [ $cardID => [  movemendID => [all movements data of card with id cardID ] ] ]
		 */
		$_SESSION['cards'] = $cards;
		$_SESSION['startCol'] = $startCol;
		$_SESSION['endCol']   = $endCol;

		$url = "?page=[{$goto}]&boardID={$boardID}&projectID={$projects}&width={$width}";
		$repl = array("[flow]", "[time]", "[wip]");
		$replc = array("cumulativeFlow", "averageLeadTime", "wipViolations");
		$url = str_replace($repl, $replc, $url);
		$url = Functions::internalLink($url);
		Functions::redirect($url);
	}

	private function isSelected($filter, $arrayOfFilters){
		if(sizeOf($arrayOfFilters) == 0)
			return false;
		foreach($arrayOfFilters as $key => $value){
			#echo"<b>::{$filter}<>{$value}::</b><br>";
			if($filter == $value)
				return true;
		}
		return false;
	}
	
}