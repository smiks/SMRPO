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

	public function getBoardID($groupID){
		$sql = "SELECT board_id FROM Board WHERE group_id = '{$groupID}' LIMIT 1;";
		return ($this->sql($sql, $return="single"));
	}
	
	public function getBoardIDByProjectID($projectID){
		$sql = "SELECT board_id FROM Board WHERE project_id = '{$projectID}' LIMIT 1;";
		return ($this->sql($sql, $return="single"));
	}
	
	public function getBoard($projectId)
	{		
		global $db;
		$q = $db-> query("SELECT board_id, group_id, name FROM Board WHERE project_id = '{$projectId}';");
		
		$boardInfo= $db -> fetch_row($q);
		
		return $boardInfo;
	}

		
	public function boardExists($projectId)
	{
		global $db;
		$q = $db-> query("SELECT COUNT(*) FROM Board WHERE project_id='{$projectId}';");
		
		$numOfBoard = $db -> fetch_single($q);
		
		return $numOfBoard;
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
}