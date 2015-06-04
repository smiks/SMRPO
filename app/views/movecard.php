[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
<br><div class="center_block_header"> Move Card <b>{{cardName}}</b></div><br>

<div class="center_block">
	<form action='' method='post'>
		Move card to column:<br>
		<select name='columnID'>
		<?
			foreach($columns as $id => $name){
				$style="";
				$selected="";
				if($id == $currCol){
					$style = "style='color:#990000;'";
					$selected=" selected ";
				}
				echo"
				<option value='{$id}' {$style} {$selected}>{$name}</option>
				";
			}
		?>
		</select>
		<br>
		<input type='submit' name='submit' value='Move'>
		<br>
		or move card back to backlog (rejected card).
		<br>
		<input type='submit' name='rejected' value='Reject card'>
	</form>
	
</div>
</center>
[include]app/views/footer.view.php[/include]