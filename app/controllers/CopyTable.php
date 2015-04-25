<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/project.php';
require_once 'app/models/log.php';
require_once 'app/models/board.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class CopyTable extends Controller{
	
	public function post() {

		
		$input = Functions::input("POST");
		// store data from input
		$projectId = $input['id'];
		$selectedBoardName = $input['boardname'];
		$selectedGroupID = $input['selectedGroupID'];
		
		// get board_id of board you wish to copy
		$board = new board();
		$board_id = $board->getBoardIDByProjectID($projectId);
		
		// create new board_id (for inserting into DB)
		$newBoardID = $board->getLastBoardID();
		$newBoardID = $newBoardID + 1;
		
		// create new id of a board (primary key ... for inserting into DB)
		$newIDkey = $board->getLastPrimaryKey();
		$newIDkey = $newIDkey + 1;
		
		// get columns for board you wish to copy
		$col = $board->getColumnsByBoardID($board_id);
		
		// get last column_id (for inserting into DB) 
		$lastColID = $board->getLastColumnID();
		
		// write data into Board.sql
	 	//$board->setNewBoard($newIDkey, $newBoardID, $selectedGroupID, $selectedBoardName, $projectId); //FIXME: can I add projectId for copycat? If not, change Board.sql (project_id null allowed)
	 	$board->setNewBoard($newIDkey, $newBoardID, 0, $selectedBoardName, 0); //FIXME: can I add projectId for copycat? If not, change Board.sql (project_id null allowed)

		foreach($col as $key => $value){
			
			$lastColID = $lastColID + 1;

			$tmpCol = $col[$key];
			$name = $tmpCol["name"];
			$limit = $tmpCol["limit"]; 
			$parent_id = $tmpCol["parent_id"];
			$color = $tmpCol["color"];

			if($parent_id == NULL){
				// FIXME: spodnja vrstica ne deluje
				//$board->setNewColumn($lastColID, $newBoardID, $tmpCol["name"], $tmpCol["limit"], 0, $tmpCol["color"]);
			}
			else{
				// FIXME: spodnja vrstica ne deluje
				$board->setNewColumn($lastColID, $newBoardID, $tmpCol["name"], $tmpCol["limit"], $tmpCol["parent_id"], $tmpCol["color"]);
			}
		
			
			
		}
		
		
		$message= "Table copied successfully";
		$data = array("message" => $message);
		$this->show("deleteprojectsub.view.php", $data); // TODO
		
			
	}

	public function get() {

		$id = Functions::input("GET")["projectID"];
		
		$project = new project();
		$p = $project->getProject($id);
		$pname = $p['name'];
		
		$user_id = $_SESSION['userid'];
		$group= new group();
		$allGroups = $group->getArrayOfAllGroups();

		$data = array("pname" => $pname, "id" => $id, "allGroups" => $allGroups);
		$this->show("copyTable.view.php", $data);
		
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
		elseif($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}			
	}

}