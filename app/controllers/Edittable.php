<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/project.php';
require_once 'app/models/group.php';
require_once 'app/models/board.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class Edittable extends Controller{

	public function __construct() 
	{
		$board   = new board();
		$group   = new group();
		$project = new project();

		switch($_SERVER['REQUEST_METHOD']){
			case "GET": $this->get($board, $group, $project); break;
			case "POST": $this->post($board, $group, $project); break;
		}
		
	}

	private function get(&$board, &$group, &$project)
	{

		$projectID   = (int)(Functions::input()["GET"]["projectID"]);
		$screenWidth = (int)(Functions::input()["GET"]["screenwidth"]);
		$groupID     = $group->getGroupIDFromProjectID($projectID);
		$boardInfo   = $board->getBoardByProjectID($projectID, $groupID);
		$boardID     = $boardInfo['board_id'];
		//var_dump($boardID);
		//exit();
		/* ugly thing...redirect if board does not exist */
		if($boardID == 0){
			Functions::redirect("?page=projects");
		}

		$boardName = $boardInfo['name'];

		//$cols      = $board->getColumnsByBoardID($boardID);
		$userid  = $_SESSION['userid'];
		$isKM    = $project->isKanbanMaster($projectID, $userid);

		/* removing subcolumns */
		if(isset($_GET['remove'])){
			$cid = (int)($_GET['remove']);
			if($board->columnExists($cid)){
				$pos = (int)($_GET['pos'])+3;  // First three are always Parents (can't be deleted or extra added)
				$board->shiftCols($boardID, $pos, $shift = -1);
				$board->removeCol($boardID, $cid);
			}
		}

		/* get info of parents and children */
		$parentsArray = $board->getColumnsByBoardIDandParentID($boardID, NULL);
		$cnt = 1;
		$parents = array();
		$children = array();
		foreach ($parentsArray as $key => $value) {
			$parents[$cnt] = $value;
			$children[$cnt] = $board->getColumnsByBoardIDandParentID($boardID, $key);
			$cnt++;
		}


		/* Adding subcolumns (left or right) and save to database */
		$addNewCol = false;
		/* add Left */
		if(isset($_GET['addLeft']) || isset($_GET['addRight'])){
			$addNewCol = true;
		}

		if(isset($_GET['addLeft'])){
			$position = (int)($_GET['addLeft'])+3;  // First three are always Parents (can't be deleted or extra added)
			if(isset($_GET['P'])){
				$parent = (int)($_GET['P']);
				$board->shiftCols($boardID, $position);
				$limit = $parents[$parent]['cardLimit'];
				$color = $parents[$parent]['color'];
				$parID = $parents[$parent]['column_id'];
				$board->setNewColumn($boardID, '', $limit, $parID, $color, $position);
			}
		}
		elseif(isset($_GET['addRight'])){
			$position = (int)($_GET['addRight'])+1+3;  // First three are always Parents (can't be deleted or extra added) +1 because it adds to right
			if(isset($_GET['P'])){
				$parent = (int)($_GET['P']);
				$board->shiftCols($boardID, $position);
				$limit = $parents[$parent]['cardLimit'];
				$color = $parents[$parent]['color'];
				$parID = $parents[$parent]['column_id'];
				$board->setNewColumn($boardID, '', $limit, $parID, $color, $position);
			}
		}		

		if($addNewCol){
			/* get info of parents and children after adding new columns*/
			$parentsArray = $board->getColumnsByBoardIDandParentID($boardID, NULL);
			$cnt = 1;
			$parents = array();
			$children = array();
			foreach ($parentsArray as $key => $value) {
				$parents[$cnt] = $value;
				$children[$cnt] = $board->getColumnsByBoardIDandParentID($boardID, $key);
				$cnt++;
			}
		}
		#dbg($children[1]);

		/* prepare data for view */
		$nCols1    = count($children[1]);
		$nCols2    = count($children[2]);
		$nCols3    = count($children[3]);
		$colorCol1 = $parents[1]['color'];
		$colorCol2 = $parents[2]['color'];
		$colorCol3 = $parents[3]['color'];		
		$totalCols = $nCols1+$nCols2+$nCols3;
		$wCol1     = $nCols1 > 0 ? 33 / $nCols1 : 33;
		$wCol2     = $nCols2 > 0 ? 33 / $nCols2 : 33;
		$wCol3     = $nCols3 > 0 ? 33 / $nCols3 : 33;
		$limitP1   = $parents[1]['cardLimit'];
		$limitP2   = $parents[2]['cardLimit'];
		$limitP3   = $parents[3]['cardLimit'];
		$pID1      = $parents[1]['column_id'];
		$pID2      = $parents[2]['column_id'];
		$pID3      = $parents[3]['column_id'];

		/* get limits of children */
		$cnt = 1;
		$limitC1 = array();
		$limitC2 = array();
		$limitC3 = array();
		$nameC1  = array();
		$nameC2  = array();
		$nameC3  = array();
		$colIDC1 = array();
		$colIDC2 = array();
		$colIDC3 = array();

		/* increase $cnt by 1 only if $key == cardLimit (name is before cardLimit in array) */
		foreach($children[1] as $child)
		{
			foreach ($child as $key => $value) {
				if($key == "column_id"){
					$colIDC1[$cnt] = $value;
				}
				if($key == "name"){
					$nameC1[$cnt] = $value;
				}				
				elseif($key == "cardLimit"){
					$limitC1[$cnt] = $value;
				}
				if($key == "cardLimit"){
					$cnt ++;
				}
			}
		}

		foreach($children[2] as $child)
		{
			foreach ($child as $key => $value) {
				if($key == "column_id"){
					$colIDC2[$cnt] = $value;
				}
				if($key == "name"){
					$nameC2[$cnt] = $value;
				}				
				elseif($key == "cardLimit"){
					$limitC2[$cnt] = $value;
				}
				if($key == "cardLimit"){
					$cnt ++;
				}
			}
		}

		foreach($children[3] as $child)
		{
			foreach ($child as $key => $value) {
				if($key == "column_id"){
					$colIDC3[$cnt] = $value;
				}
				if($key == "name"){
					$nameC3[$cnt] = $value;
				}				
				elseif($key == "cardLimit"){
					$limitC3[$cnt] = $value;
				}
				if($key == "cardLimit"){
					$cnt ++;
				}
			}
		}



		$data = array(
			"projectID" => $projectID, 
			"groupID"   => $groupID, 
			"boardName" => $boardName, 
			"nCols1"    => $nCols1, 
			"nCols2"    => $nCols2, 
			"nCols3"    => $nCols3,	
			"colorCol1"	=> $colorCol1, 
			"colorCol2"	=> $colorCol2, 
			"colorCol3"	=> $colorCol3, 
			"totalCols" => $totalCols, 
			"wCol1"     => $wCol1,
			"wCol2"     => $wCol2,
			"wCol3"     => $wCol3,
			"limitP1"   => $limitP1, 
			"limitP2"   => $limitP2, 
			"limitP3"   => $limitP3, 
			"limitC1"   => $limitC1, 
			"limitC2"   => $limitC2, 
			"limitC3"   => $limitC3, 
			"nameC1"    => $nameC1, 
			"nameC2"    => $nameC2, 
			"nameC3"    => $nameC3,
			"colIDC1"   => $colIDC1,
			"colIDC2"   => $colIDC2,
			"colIDC3"   => $colIDC3, 
			"pID1"		=> $pID1, 
			"pID2"		=> $pID2, 
			"pID3"		=> $pID3,
			"scrWidth"  => $screenWidth
		);

		if(!$isKM)
		{
			$error = "Access Denied.";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);		
		}
		else
		{
			$this->show("edittable.view.php", $data);			
		}



	}

	private function post(&$board, &$group, &$project)
	{
		$projectID   = (int)(Functions::input()["GET"]["projectID"]);
		$screenWidth = (int)(Functions::input()["GET"]["screenwidth"])+5;
		$groupID     = $group->getGroupIDFromProjectID($projectID);
		$boardInfo   = $board->getBoardByProjectID($projectID, $groupID);
		$boardID     = $boardInfo['board_id'];

		/* ugly thing...redirect if board does not exist */
		if($boardID == 0){
			Functions::redirect("?page=projects");
		}

		//$cols      = $board->getColumnsByBoardID($boardID);
		$userid  = $_SESSION['userid'];
		$isKM    = $project->isKanbanMaster($projectID, $userid);

		$post    = Functions::input("POST");

		$boardName = $post['boardName'];

		$nCols1    = $post['nCols1'];
		$nCols2    = $post['nCols2'];
		$nCols3    = $post['nCols3'];

		/* info about parent columns */
		$limitCol1 = $post['limitP1'];
		$limitCol2 = $post['limitP2'];
		$limitCol3 = $post['limitP3'];

		$colorCol1 = $post['colorCols1'];
		$colorCol2 = $post['colorCols2'];
		$colorCol3 = $post['colorCols3'];

		$namePC1   = "BackLog";
		$namePC2   = "Development";
		$namePC3   = "Done";

		// TODO :: fix, add editing subcolumns (don't forget to add subcolumn ID (column_id))
		/* info about first subcolumns */
		$subC1 = array();
		for($i=1; $i<=$nCols1; $i++){
			$cName  = "1_".($i);
			$cLimit = $cName."_limit";
			$cID    = $cName."_id";
			$name   = $post[$cName];
			$limit  = $post[$cLimit];
			$cID 	= $post[$cID];
			$subC1[$cID]  = ["name" => $name, "limit" => $limit];
		}
		
		/* info about second subcolumns */
		$subC2 = array();
		for($i=1; $i<=$nCols2; $i++){
			$cName  = "2_".($i);
			$cLimit = $cName."_limit";
			$cID    = $cName."_id";
			$name   = $post[$cName];
			$limit  = $post[$cLimit];
			$cID 	= $post[$cID];
			$subC2[$cID]  = ["name" => $name, "limit" => $limit];
		}

		/* info about third subcolumns */
		$subC3 = array();
		for($i=1; $i<=$nCols3; $i++){
			$cName  = "3_".($i);
			$cLimit = $cName."_limit";
			$cID    = $cName."_id";
			$name   = $post[$cName];
			$limit  = $post[$cLimit];
			$cID 	= $post[$cID];
			$subC3[$cID]  = ["name" => $name, "limit" => $limit];
		}

		$parentOne   = array($limitCol1 => $colorCol1);
		$parentTwo   = array($limitCol2 => $colorCol2);
		$parentThree = array($limitCol3 => $colorCol3);
		$parentIDs   = array(1 => $post['pID1'], 2 => $post['pID2'], 3 => $post['pID3']);

		#dbg($post);

		if(!$isKM)
		{
			$error = "Access Denied.";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);		
		}
		else
		{
			$board -> updateBoard($boardName, $groupID, $projectID, $parentOne, $parentTwo, $parentThree, $subC1, $subC2, $subC3, $parentIDs, $boardID);
			$url = "?page=showtable&projectID={$projectID}&width={$screenWidth}";
			echo"<br>Redirecting to: {$url}<br>";
			Functions::redirect($url);
		}

	}

}