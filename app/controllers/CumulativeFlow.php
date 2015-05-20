<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

class CumulativeFlow extends Controller{

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}			
	}
	
	public function get()
	{
		$boardId= (int)(Functions::input()["GET"]["boardId"]);
		$column = new col();
		$card = new card();
		$columns = $column -> getAllColumns($boardId);
		$cards = $card -> getCardsFromBoard($boardId);
		
		$cols = array();
		$crds = array();
		
		foreach ($columns as $colId => $val)
		{
			$col = $columns[$colId];
			$cols[$colId] = array("name" => $col['name'], "parentId" => $col['parent_id']);
		}
		
		foreach ($cards as $cardId => $val)
		{
			$crd = $cards[$cardId];
			
			$crds[$cardId] = array("name" => $crd['name'], "columnId" => $col['column_id']);
		}
		
		$data = array("cols" => $cols, "crds" => $crds);
		
		$this -> show("cumulativeFlow.view.php", $data);
	}


}