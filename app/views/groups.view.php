[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header" style="width:88%;"> Groups</div><br>

<div class="center_block" style="max-width:80%;">
			
	<table >
		<tr>
			<td class="cool_font" style="width:10%;align:center"> <b> Group Id </b></td>
			<td class="cool_font" style="width:30%; align:center"> <b>Group name </b></td>
			<td class="cool_font" style="width:15%;align:center"> <b> Owner </b></td>
			<td class="cool_font" style="width:15%;align:center"> <b> Developers </b></td>
			<td class="cool_font" colspan="3"> <b> Options </b></td>
		</tr>
		<tr>
			<td colspan="7"><hr></td>
		</tr>
	
		<?php 
		$data = $viewdata;
		foreach ($data as $groupID => $info) {
			$groupName = $info['groupName'];
		?>

		<tr style="height: 80px; vertical-align: middle;">
			<td>
				<div style="align:center"><i><?php echo $groupID?></i></div>
			</td>
			<td>
				<div style="align:center"><?php echo $groupName ?></div>
			</td>
			<td>
				<!-- owners -->
				<div style="align:center">
					<div style="width: 105px; overflow: auto;">
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
					<div style="width: 105px; overflow: auto;">
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
				<div id="menu_option" onClick="location.href='?page=deletegroup<? echo"&groupID={$groupID}"; ?>'" style="float:right;">
					<? echo"<a href='?page=deletegroup&groupID={$groupID}'>Delete group</a>"; ?>
				</div>
			</td>
			<td>
				<div id="menu_option" onClick="location.href='?page=editgroup<? echo"&groupID={$groupID}&groupName={$groupName}"; ?>'" style="float:right;">
					<? echo"<a href='?page=editgroup&groupID={$groupID}&groupName={$groupName}'>Edit group</a>"; ?>
				</div>
			</td>
			<td>
				<div id="menu_option" onClick="location.href='?page=infogroup<? echo"&groupID={$groupID}&groupName={$groupName}"; ?>'" style="float:right;">
					<? echo"<a href='?page=infogroup&groupID={$groupID}&groupName={$groupName}'>Info</a>"; ?>
				</div>
			</td>
		</tr>
		<?php } ?>
	</table>

</div>
</center>
[include]app/views/footer.view.php[/include]