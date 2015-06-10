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
		$boardId= (int)(Functions::input()["GET"]["boardID"]);		
		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$width= (int)(Functions::input()["GET"]["width"]);
		//$cards = [ $cardID => [  movemendID => [all movements data of card with id cardID ] ] ]
		$cards = $_SESSION['cards'];

		$column = new col();
		$columns = $column -> getAllColumns($boardId);
		
		$cols = array();
				
		foreach ($columns as $colId => $val)
		{
			$col = $columns[$colId];
			$cols[$colId] = array("name" => $col['name'], "checked" => true);
		}	

		$date = Functions::dateDB();
		$fromDate = date("Y-m-d", strtotime("-10 days"));	
		
		$dates = $this -> getDates($fromDate, $date);
		
		
		$data= $this -> numOfCards($dates, $cards, $columns);
		
		$maxNumber = 0;
		$number = 0;
		foreach($data as $date => $columnIDs)
		{
			foreach ($columnIDs as $colID => $num)
				$number += $num;
			if($maxNumber < $number)
				$maxNumber = $number;
			$number = 0;
		}
		
		$data = array("cols" => $cols, "width" => $width, "projectID" => $projectID, "boardId" => $boardId, "number" => $maxNumber, "numCards" => $data, "fromDate" => $fromDate, "toDate" => $date);
		
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
	
	private function timeDiff($date1, $date2){
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);
		$interval = $date1->diff($date2);
		/* return difference in days */
		return (int)($interval->format('%a'));
	}
	
	public function numOfCards($dates, $cards, $columns)
	{
		$cardsPerDay = array();
		foreach ($dates as $i => $date)
		{
			$numberOfCards = array();
			foreach($cards as $cardID => $movementIDs)
			{
				foreach($movementIDs as $movementID => $movement)
				{
					$columnID = $movement['column_id'];
					$inputDate = $movement['date_input'];
					$outputDate = $movement['date_output'];
					
					//echo"<li>DATE: {$date}</li>";					
					if($inputDate <= $date && (is_null($outputDate) || $outputDate >= $date))
					{
						$parentID = $columns[$columnID]['parent_id'];
						$columnToCheck = $columnID;
						if(!is_null($parentID))
							$columnToCheck = $parentID;

						if(array_key_exists($columnID, $numberOfCards))
							$numberOfCards[$columnID] += 1;
						else
							$numberOfCards[$columnID] = 1;
						
						if(!is_null($parentID))
						{
							if(array_key_exists($parentID, $numberOfCards))
								$numberOfCards[$parentID] += 1;
							else
								$numberOfCards[$parentID] = 1;
						}
					}
				}	
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
		$width = $input['width'];
		
		$cards = $_SESSION['cards'];
		
		$column = new col();
		$columns = $column -> getAllColumns($boardId);
		
		$cols = array();
		
		$minColNumber = 50000;
		$maxColNumber = 0;
		
		foreach ($columns as $colId => $col)
		{
			if(in_array($col['name'], $input))
			{
				$cols[$colId] = array("name" => $col['name'], "checked" => true);
				
				$colNum = $col['colOrder'];
				if($colNum < $minColNumber)
					$minColNumber = $colNum;
				if($colNum > $maxColNumber)
					$maxColNumber = $colNum;
			}
			else
				$cols[$colId] = array("name" => $col['name'], "checked" => false);
		}
		
		foreach ($cols as $colId => $val)
		{
			$col = $columns[$colId];
			
			if($col['colOrder'] >= $minColNumber && $col['colOrder'] <= $maxColNumber)
				$cols[$colId]['checked'] = true;
			
			$parentId = $col['parent_id'];
			$parent = $columns[$parentId];
			if($parent['colOrder'] == $minColNumber || $parent ['colOrder'] == $maxColNumber)
				$cols[$colId]['checked'] = true;
		}
		
		$dates = $this -> getDates($fromDate, $toDate);
		
		$data= $this -> numOfCards($dates, $cards, $columns);
		
		$maxNumber = 0;
		$number = 0;
		foreach($data as $date => $columnIDs)
		{
			foreach ($columnIDs as $colID => $num)
				$number += $num;
			if($maxNumber < $number)
				$maxNumber = $number;
			$number = 0;
		}
		
		$data = array("cols" => $cols, "width" => $width, "projectID" => $projectID, "boardId" => $boardId, "number" => $maxNumber, "numCards" => $data, "fromDate" => $fromDate, "toDate" => $toDate);
		
		$this -> show("cumulativeFlow.view.php", $data);
	}
}