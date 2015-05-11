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
		
		$colOrder = 1;
		/* inserting cols */
			/* insert parent one*/
			foreach ($parentOne as $key => $value) {
				$limit = $key;
				$color1 = $value;
			}
			$sql = "INSERT INTO Col (board_id, name, cardLimit, color, colOrder) VALUES ('{$boardID}', 'BackLog', '{$limit}', '{$color1}', '{$colOrder}')";
			$db -> query($sql);
			$parentOneID = $this->getLastColumnID();
			$colOrder += 1;


			/* insert parent two*/
			foreach ($parentTwo as $key => $value) {
				$limit = $key;
				$color2 = $value;
			}
			$sql = "INSERT INTO Col (board_id, name, cardLimit, color, colOrder) VALUES ('{$boardID}', 'Development', '{$limit}', '{$color2}', '{$colOrder}')";
			$db -> query($sql);
			$parentTwoID = $this->getLastColumnID();	
			$colOrder += 1;		

			/* insert parent three */
			foreach ($parentThree as $key => $value) {
				$limit = $key;
				$color3 = $value;
			}
			$sql = "INSERT INTO Col (board_id, name, cardLimit, color, colOrder) VALUES ('{$boardID}', 'Done', '{$limit}', '{$color3}', '{$colOrder}')";
			$db -> query($sql);
			$parentThreeID = $this->getLastColumnID();	
			$colOrder += 1;		


		/* inserting subcolumns */
			/* has parent one */
			foreach ($subC1 as $key => $value) {
				$name = $key;
				$limit = $value;
				$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color, colOrder) VALUES ('{$boardID}', '{$name}', '{$limit}', '{$parentOneID}','{$color1}', '{$colOrder}');";
				$db -> query($sql);
				$colOrder += 1;
			}
			
			/* has parent two */
			foreach ($subC2 as $key => $value) {
				$name = $key;
				$limit = $value;
				$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color, colOrder) VALUES ('{$boardID}', '{$name}', '{$limit}', '{$parentTwoID}','{$color2}', '{$colOrder}');";
				$db -> query($sql);
				$colOrder += 1;
			}

			/* has parent three */
			foreach ($subC3 as $key => $value) {
				$name = $key;
				$limit = $value;
				$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color, colOrder) VALUES ('{$boardID}', '{$name}', '{$limit}', '{$parentThreeID}','{$color3}', '{$colOrder}');";
				$db -> query($sql);
				$colOrder += 1;
			}
			
	}

	public function boardExists($projectId)
	{
		global $db;
		$q = $db-> query("SELECT COUNT(*) FROM Board WHERE project_id='{$projectId}';");
		
		$numOfBoard = $db -> fetch_single($q);
		
		return $numOfBoard;
	}

	public function columnExists($columnID)
	{
		global $db;
		$q = $db-> query("SELECT COUNT(*) FROM Col WHERE column_id='{$columnID}' LIMIT 1;");
		
		$numOfCols = $db -> fetch_single($q);
		
		return 1 == $numOfCols;
	}

	public function getBoardID($groupID, $projectID = 0){
		if($projectID == 0){
			$sql = "SELECT board_id FROM Board WHERE group_id = '{$groupID}' LIMIT 1;";
		}
		elseif($projectID != 0){
			$sql = "SELECT board_id FROM Board WHERE group_id = '{$groupID}' AND project_id ='{$projectID}' LIMIT 1;";
		}		
		return ($this->sql($sql, $return="single"));
	}
	
	public function getBoardIDByProjectID($projectID){
		$sql = "SELECT board_id FROM Board WHERE project_id = '{$projectID}' LIMIT 1;";
		return ($this->sql($sql, $return="single"));
	}
	
	public function getBoardByProjectID($projectID, $groupID = 0){
		global $db;
		if($groupID == 0){
			$sql = "SELECT * FROM Board WHERE project_id = '{$projectID}';";
		}
		elseif($groupID != 0){
			$sql = "SELECT * FROM Board WHERE project_id = '{$projectID}' AND group_id = '{$groupID}' LIMIT 1;";
		}	
		$q = $db -> query($sql);
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
			return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL ORDER BY colOrder ASC;", $return="array", $key="column_id");
		return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id='{$parentId}' ORDER BY colOrder ASC;", $return="array", $key="column_id");
	}
	
	public function getColumnsByBoardID($boardID)
	{
		return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardID}';", $return="array", $key="column_id");
	}

	public function getColumnsByBoardIDandParentID($boardID, $parentID)
	{
		if(is_null($parentID)){
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL ORDER BY colOrder ASC;";
		}
		else{
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id ='{$parentID}' ORDER BY colOrder ASC;";
		}
		return $this -> sql($sql, $return="array", $key="column_id");
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
	
	public function isEmpty($boardID)
	{
		$boardID = (int)($boardID);
		$sql = "SELECT COUNT(*) FROM Card WHERE board_id = '{$boardID}' LIMIT 1;";
		return 0 == $this->sql($sql, $return="single");
	}

	public function setNewBoard($id, $board_id, $group_id, $name, $project_id){
		global $db;
		$sql = "INSERT INTO Board (id, board_id, group_id, name, project_id) VALUES ('{$id}', '{$board_id}', '{$group_id}', '{$name}', '{$project_id}');";
		$db -> query($sql);
	}
	
	public function setNewColumn($board_id, $name, $limit, $parent_id, $color, $colOrder){
		global $db;
		$sql = "INSERT INTO Col (board_id, name, cardLimit, parent_id, color, colOrder) VALUES ('{$board_id}', '{$name}', '{$limit}', '{$parent_id}', '{$color}', '{$colOrder}');";
		$db -> query($sql);
	}
	

	/* shifts column order in board */
	public function shiftCols($boardID, $startAt, $shift = 1){
		global $db;
		$sql = "UPDATE Col SET colOrder = colOrder+{$shift} WHERE board_id = '{$boardID}' AND colOrder >= '{$startAt}';";
		$db -> query($sql);
	}

	public function removeCol($boardID, $columnID){
		global $db;
		$sql = "DELETE FROM Col WHERE board_id = '{$boardID}' AND column_id = '{$columnID}' LIMIT 1;";
		$db -> query($sql);	
	}
	
	public function getMinColumnIDByBoardIDandParentID($boardID, $parentID)
	{
		if(is_null($parentID)){
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL ORDER BY colOrder ASC LIMIT 1;";
		}
		else{
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id ='{$parentID}' ORDER BY colOrder  ASC LIMIT 1;";
		}		
		return ($this->sql($sql, $return="single"));
	}
	
	public function getMaxColumnIDByBoardIDandParentID($boardID, $parentID)
	{
		if(is_null($parentID)){
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id IS NULL ORDER BY colOrder DESC LIMIT 1;";
		}
		else{
			$sql = "SELECT * FROM Col WHERE board_id='{$boardID}' AND parent_id ='{$parentID}' ORDER BY colOrder DESC LIMIT 1;";
		}		
		return ($this->sql($sql, $return="single"));
	}

	public function getColumnLimit($columnID)
	{
		$sql = "SELECT cardLimit FROM Col WHERE column_id='{$columnID}';";
		return ($this->sql($sql, $return="single"));
	}

	public function getNumberOfCardsInColumn($columnID)
	{
		$sql = "SELECT COUNT(*) FROM Card WHERE column_id = '{$columnID}';";
		return $this->sql($sql, $return="single");
	}
}