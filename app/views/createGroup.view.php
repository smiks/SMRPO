[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div style="margin-left:40%;">
	<form action='?page=login' method='post' style = "float:left; padding-top:30px">
		<p> 
			<label>Group name:
				<input type = "text" id = "groupname" name="groupname" placeholder = "Group name" required style="border-radius:5px; margin-top:5px"/>
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
			<br><br>
			<label>Product developers:<br>
				<select name="developers" multiple style="border-radius:5px; margin-top:5px">
				<?
				foreach($developers as $key => $value){
					$developer   = $developers[$key];
					$name		 = strtoupper($developer['name']);
					$surname	 = strtoupper($developer['surname']);
					$uid		 = $developer['id_user'];
					echo"<option value='{$uid}'>{$name} {$surname}</option>";
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