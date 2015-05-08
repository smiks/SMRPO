[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>
<br><div class="center_block_header"> Create project </div><br>

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
[include]app/views/footer.view.php[/include]