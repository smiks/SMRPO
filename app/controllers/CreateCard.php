<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/card.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

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

            $isKM = $project -> isKanbanMaster($projectID, $userid);
            $isPO = $project -> isProductOwner($projectID, $userid);
	
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


		if($type == 0)
		{
			$color = "green";
		}
		else
		{
			$color = "red";
		}

		$columnID ="1";

		$card = new card();

		$boardID = $card -> getBoardId($projectID);

		//pogledamo če dodajamo silver bullet in če je kanban master
		//pogledamo če je navadna in če product owner 

		if($card->addCard($projectID, $boardID, $color, $name, $columnID, $desc, $type, $user, $size, $deadline))
		{
			$message = "Successfully added card {$name}.";
			$data = array("message" => $message);
		}
		else {
			$data = array("error" => "Card was not created.");
		}

		$this->show("addCard.view.php", $data);
	
	}
}