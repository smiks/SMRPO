[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div style="margin-left:40%;">
	<br>
	<div id="field_50">
		<h3>Edit Group</h3>
	</div>
	<br>			
	<form action='?page=editgroup' method='post' id="field_50">
		<p> 
			<center>
			<label>Group name:</label>
				<input type="hidden" value="{{groupid}}" name="groupid">
				<input type = "text" name="groupname" value="{{groupName}}"  id="textinput_200"/>
			</center>
		</p>	
		<p> 

			<label>Product owner:<br></label>
			<center>
				<select name="owners" style="border-radius:5px; margin-top:5px">
				<?
				foreach($allOwners as $key => $value){						
					$own   = $allOwners[$key];
					$name    = strtoupper($own['name']);
					$surname = strtoupper($own['surname']);
					$uid     = $own['id_user'];
					if ($uid  == $owner['user_id'])
						echo"<option value='{$uid}' selected>{$name} {$surname}</option>";
					else
						echo"<option value='{$uid}'>{$name} {$surname}</option>";
				}
				?>
				</select>
			</center>
			<br><br>
			<label>Product developers:<br>
				<select name="developers[]" multiple style="border-radius:5px; margin-top:5px">
				<?
				$selected = array();
				foreach ($developers as $user_id => $r)
				{
					$selected[$r['user_id']] = 1;
				}
				foreach($allDevelopers as $key => $value){
					$developer   = $allDevelopers[$key];
					$name		 = strtoupper($developer['name']);
					$surname	 = strtoupper($developer['surname']);
					$uid		 = $developer['id_user'];
					$select = "";
					$sid = $developer['id_user'];
					if($selected[$sid] == 1){
						$select = " selected ";
					}
					echo"<option value='{$uid}' {$select}>{$name} {$surname}</option><br>";
				}
				?>
				</select>
			</label>
		</p>

		<input type="submit" value="Edit"/>
		<br>
		<a href='?page=groups'><button onClick="location.href='?page=groups'; return false;" id="submitStyle">Cancel</button></a>
			
		</div>
		
		<p>
			{% if(isset($error)){ %}
				{{error}}
			{% } %}
		</p>
		
	</form>
</div>


[include]app/views/footer.view.php[/include]