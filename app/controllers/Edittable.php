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

	private function get($board, $group, $project)
	{

		$projectID = (int)(Functions::input()["GET"]["projectID"]);
		$groupID   = $group->getGroupIDFromProjectID($projectID);
		$boardInfo = $board->getBoardByProjectID($projectID, $groupID);
		$boardID   = $boardInfo['board_id'];
		$boardName = $boardInfo['name'];

		//$cols      = $board->getColumnsByBoardID($boardID);
		$userid  = $_SESSION['userid'];
		$isKM    = $project->isKanbanMaster($projectID, $userid);


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


		/* Adding subcolumns (left or right) */
		
		/* add Left */
		if(isset($_GET['addLeft'])){
			$position = (int)($_GET['addLeft']);

			/* Parent 1 */
			if(isset($_GET['P']) && $_GET['P'] == 1){
				//addBetween
				$newname = "new".rand(10,99);
				$values = array("name" => $newname, "cardLimit" => 0);
				$children[1] = $this->addBetween($children[1], $values, $position);
				#dbg($children[1]);
			}

			/* Parent 2 */
			if(isset($_GET['P']) && $_GET['P'] == 2){

			}

			/* Parent 3 */
			if(isset($_GET['P']) && $_GET['P'] == 3){

			}
		}

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

		/* get limits of children */
		$cnt = 1;
		$limitC1 = array();
		$limitC2 = array();
		$limitC3 = array();
		$nameC1  = array();
		$nameC2  = array();
		$nameC3  = array();

		/* increase $cnt by 1 only if $key == cardLimit (name is before cardLimit in array) */
		foreach($children[1] as $child)
		{
			foreach ($child as $key => $value) {
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
			"nameC3"    => $nameC3 
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

	private function addBetween($array, $values, $position){
			$cnt = 1;
			$new = array();
			foreach ($array as $key => $value) {
				if($cnt == $position){
					array_push($new, $values);
					array_push($new, $value);
				}
				else{
					array_push($new, $value);
				}
				$cnt++;
			}
			#dbg($new);
			return $new;
	}

}