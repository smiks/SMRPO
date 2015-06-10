<?php

require_once 'Controller.php';
require_once 'app/models/card.php';
require_once 'app/models/col.php';
require_once 'app/models/board.php';
require_once 'app/models/user.php';
require_once 'app/models/history.php';
require_once 'core/Functions.php';
require_once 'core/Global.php';

Functions::forceLogin();

class WIPViolations extends Controller{

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}	
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}
	}
	
	public function get()
	{
		$userID = $_SESSION['userid'];
		$cards = $_SESSION['cards'];
		$history = new history();
		$user = new user();
		$card = new card();

		$toShow = [];

		foreach ($cards as $key => $value) {
			$cardID = $key;
			$cardHistory = $history -> getHistoryForCardIDWIP($cardID);
			$userWIPID = $cardHistory['user_id'];
			$userWIP = $user -> userInfoByID($userWIPID);
			$userName = $userWIP['name'];
			$userSurname = $userWIP['surname'];

			//Za vsako kršitev se izpiše številka in ime kartice, datum kršitve, stolpec kršitve, uporabnik, ki je s prestavljanjem kartice povzročil kršitev, in vzrok kršitve. Izpis naj bo urejen po stolpcih.

			$toShow[$key]['cardID'] = $cardID;
			$toShow[$key]['cardName'] = $card -> getCardName($cardID);
			$toShow[$key]['date'] = $cardHistory['date'];
			$toShow[$key]['userName'] = $userName;
			$toShow[$key]['userSurname'] = $userSurname;
			$toShow[$key]['details'] = $cardHistory['details'];
		}

		$data = array("toShow" => $toShow);
        $this->show("wipViolations.view.php", $data);
	}
}