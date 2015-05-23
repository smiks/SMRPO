[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> 
	History
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">

	<form action='?page=showHistory' method='post'>

		<label class="cool_font"> History </label><br>

		<table id="field" style="padding:30px;display:block;">
		<tr>
			<td style="padding-right:15px;"> <b> Date </b></td>
			<td style="padding-right:15px;"> <b> User </b></td>
			<td style="padding-right:15px;"> <b> Event </b></td>
			<td style="padding-right:15px;"> <b> Details </b></td>
		</tr>
			<?php 
					foreach ($history as $key => $value) {
					$hist = $history[$key];
					$user = $hist['user'];
					$date = date('d.m.Y', strtotime($hist['date']));
					$userName = strtoupper($user['name']);
					$userSurname = strtoupper($user['surname']);
					$event = $hist['event'];
					$details = $hist['details'];
				
				?>

				<tr>
						<td style="padding-right:15px;">
							<div style="float:left;"><?php echo $date; ?></div>
						</td>
						<td style="padding-right:15px;">
							<div style="float:left;"><?php echo "$userName $userSurname";?></div>
						</td>
						<td style="padding-right:15px;">
							<div style="float:left;"><?php echo $event; ?></div>
						</td>
						<td style="padding-right:15px;">
							<div style="float:left;"><?php echo $details; ?></div>
						</td>
				</tr>

			<?php } ?>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
	</table>
</div>
</center>
	
[include]app/views/footer.view.php[/include]