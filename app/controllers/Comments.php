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

class Comments extends Controller{

	public function __construct() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->post();
		}	
	}

	public function get()
	{
 	    $cardID = Functions::input("GET")["cardID"];
            $history = new history();
            $user = new user();
            $comments = new comment();

            $commentsArray = $comments -> getCommentsForCardID($cardID);

            foreach ($commentsArray as $key => $value) {
				$comm = $commentsArray[$key];
				$userID = $comm['user_id'];

				$newUser = $user -> userInfoByID($userID);

				$commentsArray[$key]['userName'] = $newUser['name'];
				$commentsArray[$key]['userSurname'] = $newUser['surname'];
			}
	
			$data = array("comments" => $commentsArray, "cardID" => $cardID);
			$this -> show("comments.view.php", $data);
	}

	public function post()
	{
		
		$input = Functions::input("POST");
		$cardID = $input["cardID"];
		$comment = $input["comment"];
		$userID = $_SESSION['userid'];

		$history = new history();
        $user = new user();
        $comments = new comment();

		if($comments->addComment($cardID, $comment, $userID))
		{
			$message = "Successfully added comment.";

		}
		else{
			$message = "Comment was not added.";
		}

        $commentsArray = $comments -> getCommentsForCardID($cardID);

        foreach ($commentsArray as $key => $value) {
			$comm = $commentsArray[$key];
			$userID = $comm['user_id'];

			$newUser = $user -> userInfoByID($userID);

			$commentsArray[$key]['userName'] = $newUser['name'];
			$commentsArray[$key]['userSurname'] = $newUser['surname'];
		}
	
			$data = array("comments" => $commentsArray, "cardID" => $cardID, "message" => $message);
			$this -> show("comments.view.php", $data);

		$this->show("comments.view.php", $data);
	}
}