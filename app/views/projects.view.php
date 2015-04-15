[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
   <table style="padding:30px;">
	<form action='?page=projects' method='post' style = "float:left;">
			<?php 
			foreach ($projects as $key => $value){ 
		
				$project = $projects[$key];
				$name = strtoupper($project['name']);
				$code = strtoupper($project['number']);
                $id = $project['id_project'];
                $isKM = $_SESSION['isKanbanMaster'];
			?>

			<tr>
					<td>
						<div style="float:left;"><?php echo $code ?></div>
					</td>
					<td>
						<div style="float:left;"><?php echo $name ?></div>
					</td>
					<? if($isKM) { ?>
						<td>
							<div id="menu_option" onClick="location.href='?page=deleteproject<? echo"&projectID={$id}"; ?>'" style="float:right;">
								<? echo"<a href='?page=deleteproject&projectID={$id}'>Delete project</a>"; ?>
							</div>
						</td>
						<td>
							<div id="menu_option" onClick="location.href='?page=editproject<? echo"&projectID={$id}&projectName={$name}"; ?>'" style="float:right;">
								<? echo"<a href='?page=editproject&projectID={$id}&projectName={$name}'>Edit project</a>"; ?>
							</div>
						</td>
					<? } ?>
			</tr>
		<?php } ?>
	</form>
   </table>

[include]app/views/footer.view.php[/include]