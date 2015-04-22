[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
	<div id="field">
		<h3>Projects</h3>
	</div>
   	<table id="field" style="padding:30px;display:block;">
		<tr>
			<td style="padding-right:15px;"> <b> Project code </b></td>
			<td style="padding-right:15px;"> <b> Project name </b></td>
			<td style="padding-right:15px;"> <b> Client </b></td>
			<td style="padding-right:15px;"> <b> Start date </b></td>
			<td style="padding-right:15px;"> <b> End date </b></td>
			<td style="padding-right:15px;"> <b> Development group </b></td>
			<td style="padding-right:15px;"> <b> </b></td>
			<td style="padding-right:15px;"> <b> </b></td>
		</tr>
	<form action='?page=projects' method='post' style = "float:left;">
	<script type='text/javascript'>
		var width = screen.availWidth;
	</script>
			<?php 
			$isAdmin = $data['isAdmin'];
			foreach ($projects as $key => $value){ 
				$project = $projects[$key];
				$name = strtoupper($project['name']);
				$code = strtoupper($project['number']);
		                $id = $project['id_project'];
		                $isKM = $_SESSION['isKanbanMaster'];
		                $start = date('d.m.Y', strtotime($project['date_start']));
		                $end = date('d.m.Y', strtotime($project['date_end']));
		                $group = $project['group'];
		                $client = strtoupper($project['client']);
		                $boardExists = $project['boardExists'];
		                $numActive = $project['numActive'];
			?>

			<tr>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $code ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $name ?></div>
					</td>
					<td style="padding-right:15px;">
						<div style="float:left;"><?php echo $client?></div>
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
									<? echo"<a href='?page=createtable&projectID={$id}'>Create board</a>"; ?>
								</div>
							</td>
						<? } ?>
					<? } ?>
					<? if($boardExists == 1 && (($numActive > 0) || $isAdmin)) { ?>
						<td style="padding-right:15px;">
							<?
							echo"
							<script type='text/javascript'>
								var link  = '?page=showtable&projectID={$id}&width=';
								link  = link+width;
								var divlink = '<div id=\"menu_option\" onClick=\"location.href=\'';
								var enddivlink = '\'\" style=\"float:right;\">';
								divlink = divlink+link+enddivlink;
							</script>
							";?>
						<script type='text/javascript'>document.write(divlink);</script>
								<script type='text/javascript'>document.write("<a href='"+link+"'>Show Board</a>");</script>
							</div>
						</td>
					<? } ?>
			</tr>
		<?php } ?>
	</form>
   </table>

[include]app/views/footer.view.php[/include]