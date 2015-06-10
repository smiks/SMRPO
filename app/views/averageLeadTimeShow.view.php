[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
	<br><div class="center_block_header"> 
		Average Lead Time
		<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
	</div><br>

<div class="center_block">
	<?
	if(sizeOf($cardDev)){
	echo"<b><big>Development statistics</big></b><br>";
		#$total = 0;
		$tolerance = 0.75;
		$tolerPerc = 100-($tolerance*100);
		$total = array_sum($cardDev);
		$max   = max($cardDev);
		$min   = min($cardDev);
		$average = $total / sizeof($cardDev);
		foreach($cardDev as $cardID => $time){
			$card = $cardNames[$cardID];
			echo"<li> Card <b>{$card}</b> was under development for <b>{$time}</b> days.";
			if($time*$tolerance > $average){
				echo"<a style='color:#990000; text-decoration:none;' title='Took more than {$tolerPerc}% longer compared to average.'>!!</a>";
			}
			echo"</li>";
		}
		
		echo"<br>";
		echo"
		Minimum time: {$min} days.<br>
		Maximum time: {$max} days. <br>
		Average time: {$average} days.<br>";
		echo"<br>";
	}
	?>
	<b><big>Statistics</big></b><br>
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

	<b><big>Travel Statistics</big></b><br>
	<?
		foreach($traveTime as $cardID => $time){
			$card = $cardNames[$cardID];
			echo"<li>Card <b>{$card}</b> has been travelling for <b>{$time}</b> days.</li>";
		}
	?>	
</center>

       <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Average Lead Time' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						Applied filter settings from previous page are used to show you cards' statistics.<br>
						Development statistics, shows how long has each card be in development phase. <br>
						It also shows minimum, maximum and average time of development phase. <br>
						If card has been in development phase longer than 25% more than average time, <br>
						two exclamation marks appear next to length.<br>
						Statistics, shows how long has each card be in previously selected columns.<br>
						Travel statistics, shows how long has each card been travelling through the board.
					</p>
				</div>
				<div class="modal-footer">
					<a href="#close" class="btn">Okay, thanks!</a>  <!--CHANGED TO "#close"-->
				</div>
			</div>
		</div>
		</div>
		
	<!-- /Modal -->

[include]app/views/footer.view.php[/include]