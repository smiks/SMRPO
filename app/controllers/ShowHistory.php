<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/project.php';
require_once 'app/models/comment.php';
require_once 'app/models/history.php';
require_once 'core/Cache.php';
require_once 'app/models/user.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class ShowHistory extends Controller{

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}	
	}

	public function get()
	{
	 $cardID = Functions::input("GET")["cardID"];
            $history = new history();
            $user = new user();

            $historyArray = $history -> getHistoryForCardID($cardID);

            foreach ($historyArray as $key => $value) {
				$hist = $historyArray[$key];
				$userID = $hist['user_id'];

				$newUser = $user -> userInfoByID($userID);

				$historyArray[$key]['user'] = $newUser;
			}
	
			$data = array("history" => $historyArray, "cardID" => $cardID);
			$this -> show("showHistory.view.php", $data);
	}	
}