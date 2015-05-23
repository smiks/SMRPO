<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/card.php';
require_once 'app/models/board.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class CreateCard extends Controller{

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
		
	}

	public function get()
	{
            $projectID = Functions::input("GET")["projectID"];
            $project = new Project();

            $developers = $project -> getDevelopers($projectID);
            
            $userId = $_SESSION['userid'];

            $isKM = $project -> isKanbanMaster($projectID, $userId);
            $isPO = $project -> isProductOwner($projectID, $userId);
	
			$data = array("developers" => $developers, "projectID" => $projectID, "isKM" => $isKM, "isPO" => $isPO);
			$this -> show("createCard.view.php", $data);
	}

	public function post()
	{
		$input = Functions::input("POST");

		$name = $input["cardtitle"];
		$desc = $input["carddescription"];
		$type = $input["cardtype"];
		$user = $input["developers"];
		$size = $input["cardsize"];
		$deadline = $input["carddeadline"];

		$projectID = $input["projectID"];

		$card = new card();
		$board = new board();

		$boardID = $board -> getBoardIDByProjectID($projectID);
		
		$topColumns = $board -> getMinColumnIDByBoardIDandParentID($boardID, null);

		$fristchildColumns = $board -> getMinColumnIDByBoardIDandParentID($boardID, $topColumns);
		
		$lastchildColumns = $board -> getMaxColumnIDByBoardIDandParentID($boardID, $topColumns);
		
		if($type == 0)
		{
			$color = "green";
			if($fristchildColumns == NULL)
			{
				$columnID = $topColumns;
			}
			else
			{
				$columnID = $fristchildColumns;
			}

			$notExistsSilverBulletInColumn = true;
		}
		else
		{
			$color = "red";
			if($fristchildColumns == NULL)
			{
				$columnID = $topColumns;
			}
			else
			{
				$columnID = $lastchildColumns;
			}

			$notExistsSilverBulletInColumn = $card -> notExistsSilverBulletInColumn($columnID, $boardID);
		}

		//Get limit for column

		$limit = $board -> getColumnLimit($columnID);

		$noOfCards = $board -> getNumberOfCardsInColumn($columnID);
		
		if ($limit == $noOfCards && $limit != 0)
		{
			$WIPViolation = true;
		}
		else
		{
			$WIPViolation = false;
		}
		
		$userId = $_SESSION['userid'];
		
		if($notExistsSilverBulletInColumn) 
		{
			if($card->addCard($projectID, $boardID, $color, $name, $columnID, $desc, $type, $user, $size, $deadline, $WIPViolation, $userId))
			{
				if($WIPViolation)
				{
					$message = "WIP limit violation, but successfully added card {$name}.";
					$data = array("message" => $message);
				}
				else {
					$message = "Successfully added card {$name}.";
					$data = array("message" => $message);
				}
			}
			else {
				$data = array("error" => "Card was not created.");
			}
		}
		else
		{
			$data = array("error" => "Silver bullet already exists in this column, you can't create it. Go back and try again.");
		}
	
		$this->show("addCard.view.php", $data);
	
	}
}