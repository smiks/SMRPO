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
	
	public function getCardsFromBoard($boardId)
	{
		return $this -> sql("SELECT * FROM Card WHERE board_id='{$boardId}';", $return="array", $key="card_id");
	}
	
	public function notExistsSilverBulletInColumn($columnID, $boardID)
	{

		$sql = "SELECT COUNT(*) FROM Card WHERE board_id='{$boardID}' AND column_id ='{$columnID}' AND color='red' LIMIT 1;";
				
		return (0 == $this->sql($sql, $return="single"));
	}
	
	public function getCard($id){
		global $db;
		$q = $db -> query("SELECT * FROM Card WHERE card_id = '{$id}';");
		$data = $db -> fetch_row($q);
		return($data);
	}
	
	public function updateCard($cardId, $cardTitle, $cardDesc, $developer, $cardSize, $cardDeadLine)
	{
		global $db;
		
		$db -> query("UPDATE Card SET name='{$cardTitle}', description='{$cardDesc}', user_id='{$developer}', size='{$cardSize}', deadline='{$cardDeadLine}' WHERE card_id='{$cardId}';");

		return true;
		
	}
	
}