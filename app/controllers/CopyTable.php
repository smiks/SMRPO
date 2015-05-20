<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/project.php';
require_once 'app/models/log.php';
require_once 'app/models/board.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class CopyTable extends Controller{
	
	public function post() {

		
		
		$input = Functions::input("POST");
		// store data from input
		$projectId = $input['id'];
		$newBoardName = $input['boardname'];
		
		
		// GET BOARD
		// get board_id of board you wish to copy
		$board = new board();
		$board_id = $board->getBoardIDByProjectID($projectId); // XXX: TO RABM ZA COLUMNS
		
		// get next avaliable 'DB_board/id' (primary key ... for inserting into DB)
		$new_board_pk = $board->getLastPrimaryKey();
		$new_board_pk = $new_board_pk + 1;
		
		// get next avaliable 'DB_board/board_id' (for inserting into DB)
		$new_board_id = $board->getLastBoardID();
		$new_board_id = $new_board_id + 1;

	
		// CREATE NEW PROJECT
		// get next avaliable 'DB_Project/id_project' (for inserting into DB)
		$project = new project();
		$new_id_project = $project->getLastProjectID();
		$new_id_project = $new_id_project + 1;
		$new_project_number= "NA";
		$new_project_active = 0;
		$new_project_start_date = "0000-00-00"; // $today = date('Y-m-j'); 
		$new_project_end_date = "0000-00-00";
		$new_project_name = "NA";
		$new_project_client = "NA";
		
		
		// CREATE NEW GROUP_PROJECT
		//get DB/Group_Project by id_project
		$groupProject = $project->getGroupProjectByProjectID($projectId);
		//$gp_id = $groupProject[$projectId]["gp_id"];
		$gp_id = $board->getLastGroupProjectID();
		$gp_id = $gp_id + 1;
		$group_id = $groupProject[$projectId]["group_id"]; 
		
		// INSERT INTO DATABASE: new row into "DB/Group_Project" and "DB/Project" and "DB/Board" and "DB/Col"
		
		$project->addNewGroup_Project(intval($gp_id), intval($new_id_project), intval($group_id));
		$project->addNewProject($new_id_project , $new_project_number, $new_project_active , 
			$new_project_start_date , $new_project_end_date , $new_project_name , $new_project_client );
		$board->setNewBoard($new_board_pk, $new_board_id, $group_id, $newBoardName, $new_id_project);
		
		
	
		// CREATE NEW COLUMNS IN "DB/COL"
		// get columns for board you wish to copy 
		// FIXME: should select which projectID on board should be copied. Can't be done right now since all projects on one board have same layout
		$col = $board->getColumnsByBoardID($board_id);
			
		// get last column_id (for inserting into DB) 
		$new_column_id = $board->getLastColumnID();
		
		// array for converting old column IDs to new
		$convert_old_new_id = [];


		foreach($col as $key => $value){
			
			$tmpCol = $col[$key];
			
			//var_dump($tmpCol);
			//echo "<br><br>";
			
			$new_column_id = $new_column_id + 1;
			$old_column_id = $tmpCol["column_id"];
			$name = $tmpCol["name"];
			$cardLimit = $tmpCol["cardLimit"]; 
			$parent_id = $tmpCol["parent_id"];
			$color = $tmpCol["color"];
			$colOrder = $tmpCol["colOrder"];
			//$new_project_id = $tmpCol["project_id"]; // FIXME: DATABASE NEEDS TO BE CHANGE BEFORE IMPLEMENTING THIS!
			//var_dump($parent_id);

			if($parent_id == NULL){
				$convert_old_new_id[$old_column_id] = $new_column_id;
				$board->setNewColumnWithoutParent($new_column_id, $new_board_id, $name, $cardLimit, $color, $colOrder);
				
			}
			else{
				$old_parent_id = $board->getParentIDByColumnID($old_column_id);
				$parent_id = $convert_old_new_id[$old_parent_id];			
				$board->setNewColumnWithParent($new_column_id, $new_board_id, $name, $cardLimit, $parent_id, $color, $colOrder);
			}

		}
		
		//var_dump($convert_old_new_id);
		
		//exit("<br><br>CopyTable.php ... POST");
		$message= "Table copied successfully. To change project parameters and group, go to Projects --> Edit project.";
		$data = array("message" => $message);
		$this->show("copyTableSub.view.php", $data); // TODO
		
			
	}

	public function get() {
	
		//exit("CopyTable.php ... GET");

		$id = Functions::input("GET")["projectID"];
		
		$project = new project();
		$p = $project->getProject($id);
		$pname = $p['name'];
		
		$user_id = $_SESSION['userid'];
		$group= new group();
		$allGroups = $group->getArrayOfAllGroups();

		$data = array("pname" => $pname, "id" => $id, "allGroups" => $allGroups);
		$this->show("copyTable.view.php", $data);
		
	}

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
		elseif($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}			
	}

}