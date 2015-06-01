<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'app/models/movements.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class CumulativeFlow extends Controller{

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
		$boardId= (int)(Functions::input()["GET"]["boardId"]);
		
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$width= (int)(Functions::input()["GET"]["width"]);
		
		$date = Functions::dateDB();
		$fromDate = date("Y-m-d", strtotime("-1 month"));
		
		$card = new card();
		$column = new col();
		$movement = new movements();
		
		$movements = $movement -> getMovements($boardId);
		$cards = $card -> getCardsFromBoard($boardId);
		$columns = $column -> getAllColumns($boardId);
		$cols = array();
		$crds = array();
		
		foreach ($cards as $cardId => $val)
		{
			$crd = $cards[$cardId];
			
			$crds[$cardId] = array("name" => $crd['name'], "checked" => true);
		}
		
		foreach ($columns as $colId => $val)
		{
			$col = $columns[$colId];
			$cols[$colId] = array("name" => $col['name'], "checked" => true);
		}			
		
		$dates = $this -> getDates($fromDate, $date);
		
		
		$data= $this -> numOfCards($dates, $movements, $columns, $crds);
		$numCards = sizeOf($cards);

		$data = array("cols" => $cols, "crds" => $crds, "width" => $width, "projectID" => $projectID, "boardId" => $boardId, "movements" => $movements, "number" => $numCards , "numCards" => $data, "fromDate" => $fromDate, "toDate" => $date);
		
		$this -> show("cumulativeFlow.view.php", $data);
	}
	
	public function getDates($fromDate, $date)
	{
		$dates = array();
		$current = $fromDate;
		$i = 0;
		while(true)
		{
			$dates[$i] = $current;
			$current = date("Y-m-d", strtotime($current . "+3 days"));
			
			if($current > $date)
				break;
	
			$i = $i+1;
		}
		
		return $dates;
	}
	
	public function numOfCards($dates, $movements, $columns, $cards)
	{
		$cardsPerDay = array();
		foreach($dates as $i => $val)
		{
			$date = $dates[$i];
			
			
			$numberOfCards = array();
		
			foreach ($movements as $id => $val)
			{
				$number = 0;
				$cardId = $movements[$id]['card_id'];
				if($cards[$cardId]['checked'] == false)
					continue;
				if($movements[$id]['date_input'] <= $date && ($movements[$id]['date_output'] == null || $movements[$id]['date_output'] >= $date))
				{
					$colId = $movements[$id]['column_id'];
					if(array_key_exists($colId, $numberOfCards))
						$number = $numberOfCards[$colId] + 1;
					else
						$number = 1;
						
					$numberOfCards[$colId] = $number;
				}
			}			

			foreach ($numberOfCards as $colId => $val)
			{
				$column = $columns[$colId];
				$parentId = $column['parent_id'];
				if($parentId  != null)
					if(array_key_exists($parentId , $numberOfCards))
						$numberOfCards[$parentId] = $numberOfCards[$parentId] + $numberOfCards[$colId];
					else
						$numberOfCards[$parentId] = $numberOfCards[$colId];
			}

			$cardsPerDay[$date] = $numberOfCards;	
		}
		return $cardsPerDay;
	}


	public function post()
	{
		$input = Functions::input("POST");
		$fromDate = $input["fromDate"];
		$toDate= $input["toDate"];
		$boardId = $input["boardId"];
		$width= $input["width"];
		$projectID= $input["projectID"];
		
		$card = new card();
		$column = new col();
		$movement = new movements();
		
		$movements = $movement -> getMovements($boardId);		
		$cards = $card -> getCardsFromBoard($boardId);
		$columns = $column -> getAllColumns($boardId);
		$cols = array();
		$crds = array();
		
		foreach ($cards as $cardId => $val)
		{
			$crd = $cards[$cardId];
			if(in_array($crd['name'], $input))
				$crds[$cardId] = array("name" => $crd['name'], "checked" => true);
			else
				$crds[$cardId] = array("name" => $crd['name'], "checked" => false);
		}
		
		foreach ($columns as $colId => $val)
		{
			$col = $columns[$colId];
			if(in_array($col['name'], $input))
				$cols[$colId] = array("name" => $col['name'], "checked" => true);
			else
				$cols[$colId] = array("name" => $col['name'], "checked" => false);
		}

		$dates = $this -> getDates($fromDate, $toDate);
		
		$data= $this -> numOfCards($dates, $movements, $columns, $crds);
		$numCards = sizeOf($cards);
		
		$data = array("cols" => $cols,"crds" => $crds, "width" => $width, "projectID" => $projectID, "boardId" => $boardId, "movements" => $movements, "number" => $numCards , "numCards" => $data, "fromDate" => $fromDate, "toDate" => $toDate);
		
		$this -> show("cumulativeFlow.view.php", $data);
	}
}