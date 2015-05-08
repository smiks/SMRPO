[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> Edit group</div><br>

<div class="center_block">
			
	<form action='?page=editgroup' method='post'>
		
			
		<label class="cool_font"> Group name </label><br>
		<input type="hidden" value="{{groupid}}" name="groupid">
		<input type = "text" name="groupname" value="{{groupName}}" /><br>
			
		<label class="cool_font"> Product owner </label><br>
			
		<select name="owners">
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
		</select><br>
			
		<label class="cool_font"> Product developers </label><br>
		
		<select class="bigger_select" name="developers[]" multiple>
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
		</select><br>
			
		<input type="submit" value="Edit"/><br>
		
		
		<a href='?page=groups'><button class="submit_look_like_button" onClick="location.href='?page=groups'; return false;" >Cancel</button></a>
			
		
		
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>

</center>
[include]app/views/footer.view.php[/include]