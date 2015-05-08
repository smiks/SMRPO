[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

		
	<br>
	<div class="center_block_header">
		Create Group
	</div><br>
			
	<div class="center_block">
		<form action='?page=creategroup' method='post'>
			
			<label class="cool_font"> Group name </label><br>
			<input type="text" name="groupname" placeholder="Group name" required /><br>
			
			<label class="cool_font"> Product owner </label><br>
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
			</select><br>
			
			<label class="cool_font"> Product developers </label><br>
			<select class="bigger_select" name="developers[]" multiple >
			<?
			foreach($developers as $key => $value){
				$developer = $developers[$key];
				$name = strtoupper($developer['name']);
				$surname = strtoupper($developer['surname']);
				$uid = $developer['id_user'];
				echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
			?>
			</select><br>
			

			<input type="submit" value="Create"/><br>
				
			
				{% if(isset($error)){ %}
					{{error}}
				{% } %}
			
				
		</form>
	</div>


[include]app/views/footer.view.php[/include]