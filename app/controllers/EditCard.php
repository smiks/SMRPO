<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/project.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class EditCard extends Controller{

	
	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}	
	}

	public function get()
	{
		$cardID = Functions::input("GET")["cardID"];

		$cardModel = new card();
		$project = new project();
		
		$card = $cardModel -> getCard($cardID);

		$projectID = $card['project_id'];

        	$developers = $project -> getDevelopers($projectID);

		$data = array("developers" => $developers, "cardID" => $cardID, "card" => $card);
		$this -> show("editCard.view.php", $data);
	}

}