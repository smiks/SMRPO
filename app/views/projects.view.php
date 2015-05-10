[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

	<br><div class="center_block_header" style="width:97%">
		Projects
		<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
	</div><br>
   	<table id="field" style="padding:30px;display:block;">
		<tr>
			<td style="padding-right:15px;"> <b> Project <br>code </b></td>
			<td style="padding-right:15px;"> <b> Project <br>name </b></td>
			<td style="padding-right:15px;"> <b> Client </b></td>
			<td style="padding-right:15px;"> <b> Start <br>date </b></td>
			<td style="padding-right:15px;"> <b> End date </b></td>
			<td style="padding-right:15px;"> <b> Development <br>group </b></td>
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
                $name = Functions::splitText($name, 15);
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
						<? if($boardExists == 1) { //ROK ?> 
							<td style="padding-right:15px;">
								<div id="menu_option" onClick="location.href='?page=copytable<? echo"&projectID={$id}"; ?>'" style="float:right;">
									<? echo"<a href='?page=copytable&projectID={$id}'>Copy board</a>"; ?>
								</div>
							</td>
						<? } // ROK ?> 
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
   
           <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Projects' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					
						
						On this website are listed all existing projects you have access to. Project atributes are 
						shown in table. There are five choices avaliable for every project: <br><br>
						
						- For adding new project click 'Create project' button in upper right corner of this page. <br>
						- If you want to delete project, click on 'Delete project' button. You will be 
						prompted again for project deletion. <br>
						- Click 'Edit project' button if you wish to edit properties of selected project.
						Project consists of 'Project code', 'Project name', 'Product client', 'Start date',
						'End date' and 'Development group'. <br>
						- Click 'Copy board' button for making copy of selected project board (only empty layout with 
						board properties, project cards will not be copied). This action will redirect you to subpage
						where you will have to input additional information. <br>
						- Click 'Show board' if you would like to see project board with all corresponding project cards.
						
						
					
				</div>
				<div class="modal-footer">
					<a href="#close" class="btn">Okay, thanks!</a>  <!--CHANGED TO "#close"-->
				</div>
			</div>
		</div>
		</div>
		
	<!-- /Modal -->

[include]app/views/footer.view.php[/include]