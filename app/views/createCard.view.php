[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> Create card </div><br>

<div class="center_block">

	<form action='?page=createcard' method='post'>
		 
		<label class="cool_font"> Card title </label><br>
		<input type="text" id="cardtitle" name="cardtitle" placeholder="Card title" required="required" /><br>
			
		
		<label class="cool_font"> Card description </label><br>
		<textarea id="carddescription" name="carddescription" placeholder="Card description" required="required" rows="5" cols="1" ></textarea><br>
			
		 
		<label class="cool_font"> Card type </label><br>
		<select name = "cardtype" id ="cardtype" required>
			<? if($isPO){ ?>
				<option value='0'>New feature</option>
			<? } ?>
					
			<? if($isKM){ ?>
				<option value='1'>Silver bullet</option>
			<? } ?>
		</select><br>
			
		
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
			
		 
		<label class="cool_font">Card size </label><br>
		<input type = "number" min="0" id = "cardsize" name="cardsize" placeholder = "Card size" /><br>
			
		 
		<label> Card deadline </label><br>
		<input type = "date" id = "carddeadline" name="carddeadline" placeholder = "Card deadline" /><br>
			
		

		<input type="hidden" value="<?php echo $projectID; ?>" name="projectID">
		<input type="submit" value="Create"/><br>
		
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>
</center>
[include]app/views/footer.view.php[/include]