[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div style="margin-left:40%;">
	<form action='?page=editproject' method='post' style = "float:left; padding-top:30px">
		<?php 
				$name = strtoupper($project['name']);
				$code = strtoupper($project['number']);
				$start = $project['date_start'];
				$end = $project['date_end']; 
                                $id = $project['id_project'];

		?>

		<p> 
			<label>Project code:
				<input type="hidden" value="<?php echo $id; ?>" name="projectID">
				<input type = "text" value="<?php echo $code; ?>" id = "projectcode" name="projectcode" placeholder = "Project code" required style="border-radius:5px; margin-top:5px"/>
			</label>
		</p>	
		<p> 
			<label>Project name:
				<input type = "text" value="<?php echo $name; ?>" id = "projectname" name="projectname" placeholder = "Project name" required style="border-radius:5px; margin-top:5px"/>
			</label>
		</p>
		<p> 
			<label>Product owner:<br>
				<select name="owners" style="border-radius:5px; margin-top:5px">
				<?
				foreach($owners as $key => $value){
					$owner   = $owners[$key];
					$name    = strtoupper($owner['name']);
					$surname = strtoupper($owner['surname']);
					$uid     = $owner['id_user'];
					echo"<option value='{$uid}'>{$name} {$surname}</option>";
				}
				?>
				</select>
			</label>
		</p>
		<p> 
			<label>Start date:
				<input type = "date" value="<?php echo $start; ?>" id = "start" name="start" required style="border-radius:5px; margin-top:5px"/>
			</label>
			<br><br>
			<label>End date:
				<input type = "date" value="<?php echo $end; ?>" id = "end" name="end" required style="border-radius:5px; margin-top:5px"/>
			</label>
		</p>
		<p> 
			<label>Development group:<br>
				<select name="groups" style="border-radius:5px; margin-top:5px">
				<?
				foreach($groups as $key => $value){
					$group = $groups[$key];
					$name    = strtoupper($group['group_name']);
					$gid     = $group['group_id'];
					echo"<option value='{$gid}'>{$name}</option>";
				}
				?>
				</select>
			</label>
		</p>

		<input type="submit" value="Edit"/>
		<br>
		<a href='?page=projects'><button onClick="location.href='?page=projects'; return false;" id="submitStyle">Cancel</button></a>
			
		</div>
		
		<p>
			{% if(isset($error)){ %}
				{{error}}
			{% } %}
		</p>
		
	</form>
</div>

[include]app/views/footer.view.php[/include]