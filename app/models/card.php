<?php

require_once 'Model.php';
require_once 'app/models/movements.php';
require_once 'app/models/board.php';
require_once 'app/models/col.php';

class card extends Model{	
	
public function addCard($projectID, $boardID, $color, $name, $columnID, $description, $type, $userID, $size, $deadline, $WIPViolation, $currentUser)
	{
		global $db;

		$cardSql = "INSERT INTO Card (project_id, board_id, color, name, column_id, description, type, user_id, size, deadline) VALUES ('{$projectID}', '{$boardID}', '{$color}', '{$name}', '{$columnID}', '{$description}', '{$type}', '{$userID}', '{$size}', '{$deadline}');";
		$cardID = $this->insertID($cardSql);

		$db -> query("UPDATE Project SET active='0' WHERE id_project='{$projectID}';");

		$date = date("Y-m-d"); 
		$coll = new col();
		$collummn = $coll -> getColumn($columnID);
		$columnName = $collummn['name'];

		$db -> query("INSERT INTO History (card_id, type, event, user_id, details, date) VALUES ('{$cardID}', 'create', 'Card Created', '{$currentUser}', CONCAT('Card : ','{$name}'), '{$date}');");

		if($WIPViolation)
		{
			$db -> query("INSERT INTO History (card_id, type, event, user_id, details, date) VALUES ('{$cardID}', 'WIPViolation', 'WIP Violation', '{$currentUser}', CONCAT('WIP Violation happened in column : ','{$columnName}',', when creating card.'), '{$date}');");
		}

		$move = new movements();

		$move -> moveCard($cardID, $columnID, $boardID, NULL);

		return true;
	}
	
	public function countCards($boardID, $columnID){
		$sql = "SELECT COUNT(*) FROM Card WHERE board_id='{$boardID}' AND column_id='{$columnID}'";
		return $this->sql($sql, $return="single");
	}

	public function countChildCards($boardID, $columnID){
		
		$board = new board();

		$childColumns = $board -> getColumnsByParent($boardID, $columnID);

		$c = 0;

		foreach($childColumns as $key => $value){
				$col = $childColumns[$key];
				$id = $col["column_id"];
				$sql = "SELECT COUNT(*) FROM Card WHERE board_id='{$boardID}' AND column_id='{$id}'";
				$c = $c + $this->sql($sql, $return="single");
			}

		return $c;
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
	
	public function getCardName($cardID){
		$sql = "SELECT name FROM Card WHERE card_id = '{$cardID}' LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	public function getMaxCardSize($boardID){
		$sql = "SELECT MAX(size) FROM Card WHERE board_id = '{$boardID}' LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	public function getOldestCard($boardID){
		$sql = "SELECT date FROM History LEFT JOIN Card ON (History.card_id=Card.card_id) WHERE History.type LIKE ('create') AND board_id='{$boardID}' ORDER BY date ASC LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	public function updateCard($cardId, $cardTitle, $cardDesc, $developer, $cardSize, $cardDeadLine)
	{
		global $db;
		
		$db -> query("UPDATE Card SET name='{$cardTitle}', description='{$cardDesc}', user_id='{$developer}', size='{$cardSize}', deadline='{$cardDeadLine}' WHERE card_id='{$cardId}';");

		return true;	
	}

	public function updateColor($cardID, $color){
		global $db;
		$sql = "UPDATE Card SET color='{$color}' WHERE card_id='{$cardID}' LIMIT 1;";
		$db->query($sql);
		return true;
	}

	public function updateType($cardID, $type){
		global $db;
		$sql = "UPDATE Card SET type='{$type}' WHERE card_id='{$cardID}' LIMIT 1;";
		$db->query($sql);
		return true;
	}	
	
	public function moveCard($cardID, $colID){
		global $db;
		$sql = "UPDATE Card SET column_id='{$colID}' WHERE card_id='{$cardID}' LIMIT 1;";
		$db->query($sql);
		return true;
	}
	
	public function addToShow($cardId)
	{
		global $db;
		$sql = "INSERT INTO Show_Card (card_id, deadline, size, type) VALUES ('{$card_id}', 0, 0, 0);";
		$db->query($sql);
		return true;
	}
	
	public function getCardId($boardId, $cardName)
	{
		$sql = "SELECT card_id FROM Card WHERE board_id='{$boardId}' AND name LIKE '{$cardName}' LIMIT 1;";
		return $this->sql($sql, $return="single");
	}
	
	public function getData($cardId)
	{
		return $this -> sql("SELECT * FROM Show_Card WHERE card_id='{$cardId}';", $return="array", $key="card_id");
	}
}