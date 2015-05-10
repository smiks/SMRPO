[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>
<br><div class="center_block_header"> 
	Create project 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">


	<form action='?page=createproject' method='post'>
	
		<label class="cool_font"> Project code </label><br>
		<input type="text" id="projectcode" name="projectcode" placeholder="Project code" required /><br>
		
		<label class="cool_font"> Project name </label><br>
		<input type="text" id="projectname" name="projectname" placeholder="Project name" required /><br>
			
		<label class="cool_font"> Client </label><br>
		<input type = "text" id = "projectclient" name="projectclient" placeholder = "Project client" required /><br>
			
		
		<label class="cool_font"> Start date </label><br>
		<input type="date" id = "start" name="start" required /><br>
			
		<label class="cool_font"> End date </label><br>
		<input type = "date" id = "end" name="end" required /><br>
			
		<label class="cool_font"> Development group </label><br>
			<select name="groups">
			<?
			foreach($groups as $key => $value){
				$group = $groups[$key];
				$name    = strtoupper($group['group_name']);
				$gid     = $group['group_id'];
				echo"<option value='{$gid}'>{$name}</option>";
			}
			?>
			</select><br>
			
		<input type="submit" value="Create"/><br>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>
</center>

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Create project' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						For creating new project, you MUST enter 'Project code', 'Project name', 'Client', 
						'Start date', 'End date', 'Development group'. Same development group is able to 
						work on more than one project at the time. Click 'Create' button to confirm. You
						will be redirect to subpage where you will be informed about (un)successful creation.
						<br><br>
						
						Warning: 'Start date' must be greater or equal to today's date. 'End date' must be greater
						than 'Start date'. 
						
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