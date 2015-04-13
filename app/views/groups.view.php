[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div style="width:50%" id="toCenter">
	<form action='?page=groups' method='post' style = "float:left">
		<table style="margin-top:50px; width=100%" id="field_50">
			<tr>
				<th style="width:30%; align:center"> Group name </th>
				<th style="width:10%;align:center"> Group Id </th>
				<th style="width:10%;align:center"> Owner</th>
				<th style="width:10%;align:center"> Developers</th>				
			</tr>
	
			<?php 
			$data = $viewdata;

				foreach ($data as $groupID => $info) {
					$groupName = $info['groupName'];

			?>

			<tr>
					<td>
						<div style="align:center"><?php echo $groupName ?></div>
					</td>
					<td>
						<div style="align:center"><?php echo $groupID?></div>
					</td>
					<td>
						<!-- owners -->
						<div style="align:center">
							<div style="width: 100px; height: 75px; overflow: auto;">
							<?
								foreach ($info['members'] as $userID => $r) {
									if($r['permission'] == "100" || $r['permission'] == "110" || $r['permission'] == "101" || $r['permission'] == "111"){
										echo"{$r['name']} {$r['surname']} <br>";
									}
								}

							?>
							</div>
						</div>
					</td>					
					<td>
						<!-- developers -->
						<div style="align:center">
							<div style="width: 100px; height: 75px; overflow: auto;">
							<?
								foreach ($info['members'] as $userID => $r) {
									if($r['permission'] == "001" || $r['permission'] == "011" || $r['permission'] == "111" || $r['permission'] == "101"){
										echo"{$r['name']} {$r['surname']} <br>";
									}
								}

							?>
							</div>
						</div>
					</td>					
					<td>
						<div id="menu_option" onClick="location.href='?page=deletegroup'" style="float:right;">
							<? echo"<a href='?page=deletegroup&groupID={$groupID}'>Delete group</a>"; ?>
						</div>
					</td>
					<td>
						<div id="menu_option" onClick="location.href='?page=editgroup'" style="float:right;">
							<? echo"<a href='?page=editgroup&groupID={$groupID}&groupName={$groupName}'>Edit group</a>"; ?>
						</div>
					</td>
			</tr>
			<br><br>
			<?php } ?>
		</table>
	</form>

</div>

[include]app/views/footer.view.php[/include]