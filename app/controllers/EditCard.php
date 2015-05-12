<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/project.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/col.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class EditCard extends Controller{

	
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
		$cardID = Functions::input("GET")["cardID"];
		$userId = $_SESSION['userid'];
		
		$user = new user();
		$cardModel = new card();
		$project = new project();
		$group = new group();
		
		$card = $cardModel -> getCard($cardID);
		
		$projectID = $card['project_id'];
		$members = $group -> getMembersFromCard($projectID);
		
		$isKM = false;
		$isPO = false;
		$isDev = false;
		
		foreach ($members as $ugId => $val)
		{
			$member = $members[$ugId];
			if($member['user_id'] == $userId)
			{
				if ($member['permission'] == "100")
					$isPO = true;
				else if($member['permission'] == "010")
					$isKM = true;
				else
					$isDev = true;
			}
			
		}
		
		$colId = $card['column_id'];
		$colName = $this -> getTopParent($colId);
		
		$canChange = false;
		
		//samo KM in PO v BackLog ali Dev in KM v Developement
		if(($colName == 'BackLog' && ($isKM || $isPO)) || ($colName == 'Development' && ($isKM || $isDev)))
			$canChange = true;

		$developers = $project -> getDevelopers($projectID);

		$data = array("developers" => $developers, "cardID" => $cardID, "card" => $card, "canChange" => $canChange);
		$this -> show("editCard.view.php", $data);
	}
	
	public function getTopParent($columnId)
	{
		$col = new col();
		
		$colmn = $col -> getColumn($columnId);

		if(is_null($colmn['parent_id']))
			return $colmn['name'];
		
		return $this -> getTopParent($colmn['parent_id']);
	}
	
	public function post()
	{
		$input = Functions::input("POST");
		$cardId = $input["cardID"];
		$cardTitle = $input["cardtitle"];
		$cardDesc = $input["carddescription"];
		$developers = $input["developers"];
		$cardSize = $input["cardsize"];
		$cardDeadLine = $input["carddeadline"];
		
	}

}