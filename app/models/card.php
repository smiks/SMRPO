<?php

require_once 'Model.php';

class card extends Model{	
	
	public function addCard($projectID, $boardID, $color, $name, $columnID, $description, $type, $userID, $size, $deadline)
	{
		global $db;

		$db -> query("INSERT INTO Card (project_id, board_id, color, name, column_id, description, type, user_id, size, deadline) VALUES ('{$projectID}', '{$boardID}', '{$color}', '{$name}', '{$columnID}', '{$description}', '{$type}', '{$userID}', '{$size}', '{$deadline}');");

		$db -> query("UPDATE Project SET active='0' WHERE id_project='{$projectID}';");

		return true;
	}	

	public function getBoardId($projectID)
	{
		//get board id from Card where project id = $projectId
		global $db;
		$q = $db -> query("SELECT board_id FROM Board WHERE project_id = '{$projectID}';");
		$data = $db -> fetch_single($q);
		return($data);
	}
	
	public function getCards($projectId, $boardId)
	{
		return $this -> sql("SELECT * FROM Card WHERE board_id='{$boardId}' AND project_id='{$projectId}';", $return="array", $key="card_id");
	}
	
	
	public function getMinColumnsByBoardIDandParentID($boardID, $parentID)
	{
		if(is_null($parentID)){
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL ORDER BY colOrder ASC LIMIT 1;";
		}
		else{
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id ='{$parentID}' ORDER BY colOrder  ASC LIMIT 1;";
		}		
		return ($this->sql($sql, $return="single"));
	}
	
	public function getMaxColumnsByBoardIDandParentID($boardID, $parentID)
	{
		if(is_null($parentID)){
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL ORDER BY colOrder DESC LIMIT 1;";
		}
		else{
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id ='{$parentID}' ORDER BY colOrder DESC LIMIT 1;";
		}		
		return ($this->sql($sql, $return="single"));
	}
	
}