<?php
require_once '../config/config.php';
require_once '../config/connect.php';
require_once '../core/Router.php';
require_once '../core/Functions.php';
require_once 'user.php';

	$numberOfDays = 10;

	function sendMail($to, $subject, $body){
		$headers .= 'From: Kanbanize <noreply@'.$_Domain.'>'.$eol;
		mail($to, $subject, $body, $headers);
	}

	function duedates()
	{
		global $numberOfDays;
	        
	        $user = new user();
	        $date = Functions::dateDB();
	        
	        $users = $user -> getUsers();
	        $toSend = array();
	        $cardsToSend = array();
	        
	        foreach ($users as $groupId => $val)
	        {
	        	$cards = $user -> getCards($groupId);
	        	foreach($cards as $cardId => $val1)
	        	{
	        		$card = $cards[$cardId];
	        		$deadLine = $card['deadline'];
	        		$datediff = (int)(timeDiff($date, $deadLine));
     				if($datediff <= $numberOfDays){
     					$cardsToSend[$cardId] = $card;
     				}
	        	}
	        	$userEmail = $val['email'];
	        	if(sizeOf($cardsToSend) != 0)
	        		$toSend[$userEmail] = $cardsToSend;
	        	$cardsToSend = [];
	        }
	        
	        return $toSend;
	}
	
	function timeDiff($date1, $date2){
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);
		$interval = $date1->diff($date2);
		/* return difference in days */
		return (int)($interval->format('%a'));
	}
	 
	function main(){
		global $numberOfDays;
	        $dueDates = duedates();
	        
	        foreach($dueDates as $email => $val)
	        {
	        	$text= "Dear user 
\n we would like you to inform you that some of your cards are reaching deadline in " .$numberOfDays . " days.\n Critical cards are: \n";
	        	foreach ($dueDates[$email] as $cardId => $val2)
	        	{
	        		$name = $dueDates[$email][$cardId]['name'];
	        		$deadline = $dueDates[$email][$cardId]['deadline'];
	        		$description = $dueDates[$email][$cardId]['description'];
	        		$projectId = $dueDates[$email][$cardId]['project_id'];
	        		
	        		$text .= "- Card name: " . $name . ", card description: " . $description . ", project : " . $projectId . ", deadline: " . $deadline . "\n";	
	        	}
	        	
	        	$text .= "\n 
Best regards \n Kanbanize automated mail system";
	        	
	        	sendMail($email, "Warning", $text);
	        }
	}
	 
	 
	main();

?>