[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
<br><div class="center_block_header"> Analytics - Average Lead Time</div><br>

<div class="center_block">
	<form action='' method='post'>
		<b>Cards</b><br>
		<input type='checkbox' id='checkAll'> Check / Uncheck all<br><br>
		<?
			foreach($cards as $id => $name){
				echo"<input type='checkbox' name='cards[]' value='{$id}' class='chk'>{$name}<br>";
			}
		?>
		<br>
		<b>Start column<b><br>
		<select name='startCol'>
		<?
			foreach($cols as $id => $name){
				echo"<option value='{$id}'>{$name}</option>";
			}

		?>
		</select>
		<br>
		<b>End column<b><br>
		<select name='endCol'>
		<?
			$len = sizeOf($cols);
			$counter = 1;
			foreach($cols as $id => $name){
				$selected = "";
				if($counter == $len){
					$selected = " selected ";
				}
				echo"<option value='{$id}' {$selected}>{$name}</option>";
				$counter++;
			}

		?>
		</select>
		<input type='submit' value='submit'>
	</form>
</div>
</center>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="static/js/checkAll.js"></script>
[include]app/views/footer.view.php[/include]