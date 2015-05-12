[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>
<br><div class="center_block_header" style="width:58%;"> {{data['groupName']}} </div><br>

<div class="center_block" style="max-width:50%;">

		
	<table>
		<tr>
			<td class="cool_font" style="width:10%;align:center"> <b> Name </b></td>
			<td class="cool_font" style="width:10%; align:center"> <b>Surname </b></td>
			<td class="cool_font" style="width:10%;align:center"> <b> Permission </b></td>
			<td class="cool_font" style="width:10%;align:center"> <b> Active start </b></td>
			<td class="cool_font" style="width:10%;align:center"> <b> Active end </b></td>
		</tr>
		<tr>
			<td colspan="5"><hr></td>
		</tr>
	
		<?php 
			$mem = $data['active'];
			foreach ($mem as $userID => $info) {
				$userName = $info['name'];
				$userSurname = $info['surname'];
				$permission = $info['permission'];
				$activeStart = $info['active_start'];
				$activeEnd = $info['active_end'];
		?>

		<tr style="height: 80px; vertical-align: middle;">
			<td>
				<div style="align:center"><i><?php echo $userName ?></i></div>
			</td>
			<td>
				<div style="align:center"><?php echo $userSurname ?></div>
			</td>
			<td>
				<!-- permissions-->
				<div style="align:center">
					<div style="width: 100px; overflow: auto;">
						<?
						if($permission == "100" || $permission == "110" || $permission == "101" || $permission == "111"){
							echo"Owner <br>";
						}
						else if($permission == "001" || $permission == "011" || $permission == "111" || $permission == "101"){
							echo"Developer <br>";
						}
						else
							echo"Kanban Master<br>";

						?>
					</div>
				</div>
			</td>									
			<td>
				<div style="align:center"><i><?php echo $activeStart ?></i></div>
			</td>
			<td>
				<div style="align:center"><?php echo $activeEnd ?></div>
			</td>
		</tr>
			
		<?php } ?>
		<tr>
			<td colspan="5"><hr></td>
		</tr>
		<?php 
			$mem = $data['inactive'];
			foreach ($mem as $userID => $info) {
				$userName = $info['name'];
				$userSurname = $info['surname'];
				$permission = $info['permission'];
				$activeStart = $info['active_start'];
				$activeEnd = $info['active_end'];
		?>
			
		<tr style="height: 80px; vertical-align: middle;">
			<td>
				<div style="align:center"><i><?php echo $userName ?></i></div>
			</td>
			<td>
				<div style="align:center"><?php echo $userSurname ?></div>
			</td>
			<td>
				<!-- permissions-->
				<div style="align:center">
					<div style="width: 100px; overflow: auto;">
						<?
						if($permission == "100" || $permission == "110" || $permission == "101" || $permission == "111"){
							echo"Owner <br>";
						}
						else if($permission == "001" || $permission == "011" || $permission == "111" || $permission == "101"){
							echo"Developer <br>";
						}
						else
							echo"Kanban Master<br>";

						?>
					</div>
				</div>
			</td>									
			<td>
				<div style="align:center"><i><?php echo $activeStart ?></i></div>
			</td>
			<td>
				<div style="align:center"><?php echo $activeEnd ?></div>
			</td>
		</tr>
		<?php } ?>
	</table>
	
	<div onClick="location.href='?page=groups'">
		<a href='?page=groups'> 
			<img src="../../static/images/back_button_image.png" alt="Back" style="width:120px;height:70px;border:0">
		</a>
	</div>

</div>
</center>
[include]app/views/footer.view.php[/include]