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
	
	public function getCards($projectId, $boardId)
	{
		return $this -> sql("SELECT * FROM Card WHERE board_id='{$boardId}' AND project_id='{$projectId}';", $return="array", $key="card_id");
	}
	
}