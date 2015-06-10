[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

	<br><div class="center_block_header" style="width:97%">
		Projects
		<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
	</div><br>
   	<table id="field" style="padding:30px;display:block;">
		<tr>
			<td style="padding-right:15px;"> <b> Card <br>number </b></td>
			<td style="padding-right:15px;"> <b> Card <br>name </b></td>
			<td style="padding-right:15px;"> <b> Violation <br>date </b></td>
			<td style="padding-right:15px;"> <b> User <br>name </b></td>
			<td style="padding-right:15px;"> <b> User <br>surname </b></td>
			<td style="padding-right:15px;"> <b> Cause and <br>column </b></td>
			<td style="padding-right:15px;"> <b> </b></td>
			<td style="padding-right:15px;"> <b> </b></td>
		</tr>
	<form action='?page=wipViolations' method='post' style = "float:left;">
	<script type='text/javascript'>
		var width = screen.availWidth;
	</script>
			<?php 
			foreach ($toShow as $key => $value){ 
				$violation = $toShow[$key];
				$cardID = $violation['cardID'];
				$cardName = $violation['cardName'];
				$date = date('d.m.Y', strtotime($violation['date']));
				$userName = $violation['userName'];
				$userSurname = $violation['userSurname'];
				$details = $violation['details'];
			?>
			<tr>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $cardID ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $cardName ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $date?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $userName ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $userSurname ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $details ?></div>
					</td>
			</tr>
		<?php } ?>
	</form>
   </table>

[include]app/views/footer.view.php[/include]