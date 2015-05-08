[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>

<br><div class="center_block_header"> Edit card </div><br>

<div class="center_block">

	<form action='?page=editCard' method='post' >
		<?php 
			$name = $card['name'];
			$description = $card['description'];
			$user = $card['assignee'];
			$size = $card['size'];
			$deadline = $card['deadline']; 
                	$id = $card['card_id'];
		?>
		 
		<label class="cool_font"> Card title </label><br>
		<input type="hidden" value="<?php echo $id; ?>" name="cardID">
		<input type = "text" value="<?php echo $name; ?>" id = "cardtitle" name="cardtitle" placeholder = "Card title" required /><br>
			
		<label class="cool_font"> Card description </label><br>
		<textarea id = "carddescription" name="carddescription" placeholder = "Card description" required rows="5" cols="1"><?php echo $description;?></textarea><br>
			
		<label class="cool_font"> Card assignee </label><br>
		<select name="developers">
			<?
			foreach($developers as $key => $value){
				$developer = $developers[$key];
				$name    = strtoupper($developer['UserName']);
				$surname    = strtoupper($developer['UserSurname']);
				$uid    = $developer['id_user'];
				echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
			?>
		</select><br>
			
		<label class="cool_font"> Card size </label><br>
		<input type = "number" value="<?php echo $size; ?>" min="0" id = "cardsize" name="cardsize" placeholder = "Card size" /><br>
			
		<label class="cool_font"> Card deadline </label><br>
		<input type = "date" value="<?php echo $deadline; ?>" id = "carddeadline" name="carddeadline" placeholder = "Card deadline" /><br>
			
		<input type="submit" value="Edit"/><br>


		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>
</center>
[include]app/views/footer.view.php[/include]