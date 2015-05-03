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
		$q = $db -> query("SELECT board_id FROM Card WHERE project_id = '{$projectID}';");
		$data = $db -> fetch_single($q);
		return($data);
	}
}