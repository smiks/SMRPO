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
		$projectId = $input['id'];
		
		$board = new board();
		$board_id = $board->getBoardIDByProjectID($projectId);
		$col = $board->getColumnsByBoardID($board_id);
		
		//var_dump($col);
		
		$tmp = $col[1][3];
		echo " $tmp <br>";
		
		
		echo "Izpis i-jev: <br><br>";
		for($i = 1; $i <= count($col); $i++) {
				echo "i = $col[$i] ";
				echo "<br>";
				$tempArr = $col[$i];
			for ($j = 1 ; $j <= count($col[$i]) ; $j++){
				echo "  $tempArr[$j]";
				echo "<br>";
			}
		}
		
		echo "<br>";
		var_dump($col);
		
		
		
			
	}

	public function get() {

		$id = Functions::input("GET")["projectID"];
		
		$project = new project();

		$p = $project->getProject($id);
		
		$pname = $p['name'];

		$data = array("pname" => $pname, "id" => $id);
		
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