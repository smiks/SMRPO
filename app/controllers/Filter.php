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

		/*  */
		
		$data = array("projects" => $projects, "fromDateCreation" => $fromDateCreation, "fromDateDev" => $fromDateDev, "fromDateDone" => $fromDateDone,"maxSize" => $maxSize, "boardID" => $boardID, "projectID" => $projectID, "width" => $width, "goto" => $goto);
		$this -> show("filter.view.php", $data);
	}
	
	public function post()
	{
		$input = Functions::input("POST");
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
			if($minSize != "" && $maxSize != "" && $cardSize < $minSize && $cardSize > $maxSize)
			{
				$isOk = false;
				continue;
			}
			
			if($tip != "" && $cardType != $tip)
			{
				$isOk = false;
				continue;				
			}

			if($tip == 2 && $color != "66066")
			{
				$isOk = false;
				continue;
			}

			$createdDate = $history -> getCreateDate($cardId);
			#var_dump($createdDate);
			if($createdDate < $fromDateCreation || $createdDate > $toDateCreation)
			{
				$isOk = false;
				continue;
			}
			
			$lastDevDate = $column -> getFirstDevColDate($boardID);
			#var_dump($lastDevDate);
			if($lastDevDate < $fromDateDev || $lastDevDate > $toDateDev)
			{
				$isOk = false;
				continue;
			}
			echo"<hr>BID {$boardID}<br>";
			$colIDNextTesting = $column -> getNextTesting($boardID);
			echo"<li>{$colIDNextTesting} :: {$cardId}</li>";
			echo"<br>";
			$doneDate = $movement -> getInputDate($boardID, $colIDNextTesting, $cardId);
			var_dump($doneDate);
			echo"<br>";
			if($doneDate < $fromDateDone || $doneDate > $toDateDone)
			{
				$isOk = false;
				continue;
			}
			
			if($isOk)
			{
				$cards[$cardId] = $card;
			}
			
		}
		
		var_dump($cards);

		$_SESSION['cards'] = $cards;
		
		
		//$url = "?page=[{$goto}]&boardID={$boardID}&projectID={$projects}&width={$width}";
		//$repl = array("[flow]", "[time]");
		//$replc = array("cumulativeFlow", "averageLeadTime");
		//$url = str_replace($repl, $replc, $url);
		//$url = Functions::internalLink($url);
		//Functions::redirect($url);
	}
	
}