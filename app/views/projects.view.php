[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
	<div id="field">
		<h3>Projects</h3>
	</div>
   	<table id="field" style="padding:30px;display:block;">
		<tr>
			<td style="padding-right:15px;"> <b> Project code </b></td>
			<td style="padding-right:15px;"> <b> Project name </b></td>
			<td style="padding-right:15px;"> <b> Owner Name </b></td>
			<td style="padding-right:15px;"> <b> Owner Surname </b></td>
			<td style="padding-right:15px;"> <b> Start date </b></td>
			<td style="padding-right:15px;"> <b> End date </b></td>
			<td style="padding-right:15px;"> <b> Development group </b></td>
			<td style="padding-right:15px;"> <b> </b></td>
			<td style="padding-right:15px;"> <b> </b></td>
		</tr>
	<form action='?page=projects' method='post' style = "float:left;">
			<?php 
			foreach ($projects as $key => $value){ 
				$project = $projects[$key];
				$name = strtoupper($project['name']);
				$code = strtoupper($project['number']);
		                $id = $project['id_project'];
		                $isKM = $_SESSION['isKanbanMaster'];
		                $start = date('d.m.Y', strtotime($project['date_start']));
		                $end = date('d.m.Y', strtotime($project['date_end']));
		                $group = $project['group'];
		                $ownerN = strtoupper($project['ownerName']);
		                $ownerS = strtoupper($project['ownerSurname']);
		                $boardExists = $project['boardExists'];
			?>

			<tr>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $code ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $name ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $ownerN ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $ownerS ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $start ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $end ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $group ?></div>
					</td>
					<? if($isKM) { ?>
						<td style="padding-right:15px;">
							<div id="menu_option" onClick="location.href='?page=deleteproject<? echo"&projectID={$id}"; ?>'" style="float:right;">
								<? echo"<a href='?page=deleteproject&projectID={$id}'>Delete project</a>"; ?>
							</div>
						</td>
						<td style="padding-right:15px;">
							<div id="menu_option" onClick="location.href='?page=editproject<? echo"&projectID={$id}&projectName={$name}"; ?>'" style="float:right;">
								<? echo"<a href='?page=editproject&projectID={$id}&projectName={$name}'>Edit project</a>"; ?>
							</div>
						</td>
						<? if($boardExists == 0) { ?>
							<td style="padding-right:15px;">
								<div id="menu_option" onClick="location.href='?page=createtable<? echo"&projectID={$id}"; ?>'" style="float:right;">
									<? echo"<a href='?page=createtable&projectID={$id}'>Create table</a>"; ?>
								</div>
							</td>
						<? } ?>
					<? } ?>
					<? if($boardExists == 1) { ?>
						<td style="padding-right:15px;">
							<div id="menu_option" onClick="location.href='?page=showtable<? echo"&projectID={$id}"; ?>'" style="float:right;">
								<? echo"<a href='?page=showtable&projectID={$id}'>Show table</a>"; ?>
							</div>
						</td>
					<? } ?>
			</tr>
		<?php } ?>
	</form>
   </table>

[include]app/views/footer.view.php[/include]