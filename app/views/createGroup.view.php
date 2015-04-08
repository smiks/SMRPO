[include]app/views/header.view.php[/include]

<div style="background-color:#FFFFFF">
	<div style="background-color: #D0E0EB; height:30px">
		<a href='?page=homepage'>Back</a>
		{% if($isAdministrator) { %}
		&nbsp;<a href='?page=adminpanel'>Admin Panel</a>
		{% } %}
		&nbsp;
		<div style="float:right; padding-right:5px; padding-top:5px"><a href='?page=logout'>Logout</a></div>
		&nbsp;
	</div>
</div>

<div>
	<form action='?page=login' method='post'>
		<div style = "background-color: #BBC9D3; height:30px; padding-top:0px"> <h3 style="padding-left:8px; padding-top:5px"> Create group </h3></div>
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