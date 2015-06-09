[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
<br><div class="center_block_header"> Analytics - Average Lead Time</div><br>

<div class="center_block">
	<?
	echo"<b>Development statistics</b><br>";
		#$total = 0;
		$tolerance = 0.75;
		$tolerPerc = 100-($tolerance*100);
		$total = array_sum($cardsStats);
		$max   = max($cardsStats);
		$min   = min($cardsStats);
		$average = $total / sizeof($cardsStats);
		foreach($cardsStats as $name => $time){
			echo"<li> Card <b>{$name}</b> was under development for <b>{$time}</b> days.";
			if($time*$tolerance > $average){
				echo"<a style='color:#990000; text-decoration:none;' title='Took more than {$tolerPerc}% longer compared to average.'>!!</a>";
			}
			echo"</li>";
			#$total += $time;
		}
		
		echo"<br>";
		echo"
		Minimum time: {$min} days.<br>
		Maximum time: {$max} days. <br>
		Average time: {$average} days.<br>";
	echo"<br>";
	?>
	<b>Statistics</b><br>
	<?
		foreach($cardColMap as $cardID => $cols){
			#echo"<li>{$cardID} => {$cols}</li>";
			foreach($cols as $colID => $time){
				$card = $cardNames[$cardID];
				$col  = $colNames[$colID];
				echo"<li>Card <b>{$card}</b> was in column <b>{$col}</b> for <b>{$time}</b> days.</li>";
			}
			echo"<br>";
		}
	?>
</center>
[include]app/views/footer.view.php[/include]