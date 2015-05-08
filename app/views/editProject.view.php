[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> Edit project</div><br>

<div class="center_block">
	<form action='?page=editproject' method='post' >
		<?php 
			$name = strtoupper($project['name']);
			$code = strtoupper($project['number']);
			$client = strtoupper($project['client']);
			$start = $project['date_start'];
			$end = $project['date_end']; 
                        $id = $project['id_project'];

		?>

		<label class="cool_font"> Project code </label><br>
		<input type="hidden" value="<?php echo $id; ?>" name="projectID">
		<input type="text" value="<?php echo $code; ?>" id="projectcode" name="projectcode" placeholder="Project code" required /><br>
			
		<label class="cool_font"> Project name </label><br>
		<input type = "text" value="<?php echo $name; ?>" id = "projectname" name="projectname" placeholder = "Project name" required /><br>
			
		<label class="cool_font"> Product client </label><br>
		<input type = "text" value="<?php echo $client; ?>" id = "projectclient" name="projectclient" placeholder = "Project client" required /><br>
			
		<label class="cool_font"> Start date </label><br>
		<input type = "date" value="<?php echo $start; ?>" id = "start" name="start" required /><br>
			
		<label class="cool_font"> End date </label><br>
		<input type = "date" value="<?php echo $end; ?>" id = "end" name="end" required /><br>
			
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
			
		

		<input type="submit" value="Edit"/><br>
		<a href='?page=projects'><button class="submit_look_like_button" onClick="location.href='?page=projects'; return false;" id="submitStyle">Cancel</button></a>
			
		
		
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>
</center>
[include]app/views/footer.view.php[/include]