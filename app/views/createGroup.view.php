[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div>
	<form action='?page=login' method='post'>
		<p style="padding-left:8px;"> 
			<label>Group name:
				<input type = "text" id = "groupname" name="groupname" placeholder = "Group name" required/>
			</label>
		</p>	
		<p style="padding-left:8px;"> 

			<label>Product owner:<br>
				<select name="owners">
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
				<select name="developers" multiple>
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
		<p>
			{% if(isset($error)){ %}
				{{error}}
			{% } %}
		</p>
		
	</form>
</div>

[include]app/views/footer.view.php[/include]