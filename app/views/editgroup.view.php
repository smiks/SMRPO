[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

	<div style="margin-left:40%;">
		<form action='?page=groups' method='post' style = "float:left; padding-top:30px">
			<p> 
				<label>Group name:
					<input type="hidden" value="{{groupid}}" name="groupid">
					<input type = "text" name="groupname" value="{{groupName}}" style="border-radius:5px; margin-top:5px"/>
				</label>
			</p>	
			<p> 
	
				<label>Product owner:<br>
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
				</label>
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
			<div id="menu_option" onClick="location.href='?page=groups'">
				<? echo"<a href='?page=groups'>Cancel</a>"; ?>
			</div>
			
			<p>
				{% if(isset($error)){ %}
					{{error}}
				{% } %}
			</p>
			
		</form>
	</div>


[include]app/views/footer.view.php[/include]