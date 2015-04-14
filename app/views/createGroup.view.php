[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<div style="width:30%" id="toCenter">
		<div style="margin-left:40%;">
			<br>
			<div id="field">
				<h3>Create Group</h3>
			</div>
			<br>
			<form action='?page=creategroup' method='post' id="field">
				<p> 
					<label>Group name:</label>
					<center>
						<input type = "text" name="groupname" placeholder = "Group name"   id="textinput_200" required/>
					</center>
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
						<select name="developers[]" multiple style="border-radius:5px; margin-top:5px">
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
</div>	

[include]app/views/footer.view.php[/include]