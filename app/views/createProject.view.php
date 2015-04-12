[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div style="margin-left:40%;">
	<form action='?page=createproject' method='post' style = "float:left; padding-top:30px">
		<p> 
			<label>Project code:
				<input type = "text" id = "projectcode" name="projectcode" placeholder = "Project code" required style="border-radius:5px; margin-top:5px"/>
			</label>
		</p>	
		<p> 
			<label>Project name:
				<input type = "text" id = "projectname" name="projectname" placeholder = "Project name" required style="border-radius:5px; margin-top:5px"/>
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
				<input type = "date" id = "start" name="start" required style="border-radius:5px; margin-top:5px"/>
			</label>
			<br><br>
			<label>End date:
				<input type = "date" id = "end" name="end" required style="border-radius:5px; margin-top:5px"/>
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

		<input type="submit" value="Create"/>
		
		<p>
			{% if(isset($error)){ %}
				{{error}}
			{% } %}
		</p>
		
	</form>
</div>

[include]app/views/footer.view.php[/include]