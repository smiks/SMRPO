<?php

require_once 'Model.php';
require_once 'core/Functions.php';

class board extends Model{	
	
	private function cleanInput($value)
	{
		$replace     = array("'",'"','<','>','\\');
		$replacement = array("&#39;",'&quot;','&lt;','&gt;','&#092;');
		$outputVal   = str_replace($replace, $replacement, $value);
		return $outputVal;
	}


	public function addNewBoard($boardName, $groupID, $projectID, $parentOne, $parentTwo, $parentThree, $subC1, $subC2, $subC3){
		global $db;
		$boardID = $this->getLastBoardID()+1;

		/* inserting board */
		$sql = "INSERT INTO Board (board_id, group_id, name, project_id) VALUES ('{$boardID}','{$groupID}','{$boardName}','{$projectID}');";
		$db -> query($sql);
		
		/* inserting cols */
			/* insert parent one*/
			foreach ($parentOne as $key => $value) {
				$limit = $key;
				$color1 = $value;
			}
			$sql = "INSERT INTO Col (board_id, name, cardLimit, color) VALUES ('{$boardID}', 'BackLog', '{$limit}', '{$color1}')";
			$db -> query($sql);
			$parentOneID = $this->getLastColumnID();			
			
			/* insert parent two*/
			foreach ($parentTwo as $key => $value) {
				$limit = $key;
				$color2 = $value;
			}
			$sql = "INSERT INTO Col (board_id, name, cardLimit, color) VALUES ('{$boardID}', 'Development', '{$limit}', '{$color2}')";
			$db -> query($sql);
			$parentTwoID = $this->getLastColumnID();			

			/* insert parent three */
			foreach ($parentThree as $key => $value) {
				$limit = $key;
				$color3 = $value;
			}
			$sql = "INSERT INTO Col (board_id, name, cardLimit, color) VALUES ('{$boardID}', 'Done', '{$limit}', '{$color3}')";
			$db -> query($sql);
			$parentThreeID = $this->getLastColumnID();			


		/* inserting subcolumns */
			/* has parent one */
			foreach ($subC1 as $key => $value) {
				$name = $key;
				$limit = $value;
				$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color) VALUES ('{$boardID}', '{$name}', '{$limit}', '{$parentOneID}','{$color1}');";
				$db -> query($sql);
			}
			
			/* has parent two */
			foreach ($subC2 as $key => $value) {
				$name = $key;
				$limit = $value;
				$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color) VALUES ('{$boardID}', '{$name}', '{$limit}', '{$parentTwoID}','{$color2}');";
				$db -> query($sql);
			}

			/* has parent three */
			foreach ($subC3 as $key => $value) {
				$name = $key;
				$limit = $value;
				$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color) VALUES ('{$boardID}', '{$name}', '{$limit}', '{$parentThreeID}','{$color3}');";
				$db -> query($sql);
			}
			
	}

	public function boardExists($projectId)
	{
		global $db;
		$q = $db-> query("SELECT COUNT(*) FROM Board WHERE project_id='{$projectId}';");
		
		$numOfBoard = $db -> fetch_single($q);
		
		return $numOfBoard;
	}

	public function getBoardID($groupID){
		$sql = "SELECT board_id FROM Board WHERE group_id = '{$groupID}' LIMIT 1;";
		return ($this->sql($sql, $return="single"));
	}
	
	public function getBoardIDByProjectID($projectID){
		$sql = "SELECT board_id FROM Board WHERE project_id = '{$projectID}' LIMIT 1;";
		return ($this->sql($sql, $return="single"));
	}
	
	public function getBoardByProjectID($projectID){
		global $db;
		$q = $db -> query("SELECT * FROM Board WHERE project_id = '{$projectID}';");
		$board = $db -> fetch_row($q);
		return $board;
	}
	
	
	public function getAllProjects($boardId)
	{
		return $this -> sql("SELECT * FROM Board WHERE board_id='{$boardId}';", $return="array", $key="project_id");
	}
	
	public function getColumnsByParent($boardID, $parentId)
	{
		if ($parentId == null)
			return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL;", $return="array", $key="column_id");
		return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id='{$parentId}';", $return="array", $key="column_id");
	}
	
	public function getColumnsByBoardID($boardID)
	{
		return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardID}';", $return="array", $key="column_id");
	}

	public function getLastBoardID()
	{
		$sql = "SELECT MAX(board_id) FROM Board;";
		return ($this->sql($sql, $return="single"));
	}	
	
	public function getLastColumnID()
	{
		$sql = "SELECT MAX(column_id) FROM Col;";
		return ($this->sql($sql, $return="single"));
	}
	
	public function getLastPrimaryKey()
	{
		$sql = "SELECT MAX(id) FROM Board;";
		return ($this->sql($sql, $return="single"));
	}	
	
	public function setNewBoard($id, $board_id, $group_id, $name, $project_id){
		global $db;
		$sql = "INSERT INTO Board (id, board_id, group_id, name, project_id) VALUES ('{$id}', '{$board_id}', '{$group_id}', '{$name}', '{$project_id}');";
		$this->insertID($sql);
	}
	
	public function setNewColumn($column_id, $board_id, $name, $limit, $parent_id, $color){
		global $db;
		$sql = "INSERT INTO Col (column_id, board_id, name, cardLimit, parent_id, color) VALUES ('{$column_id}', '{$board_id}', '{$name}', '{$limit}', '{$parent_id}', '{$color}');";
		$this->insertID($sql);
	}
	
}