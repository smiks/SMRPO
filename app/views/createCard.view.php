[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div style="margin-left:40%;">
	<form action='?page=createcard' method='post' style = "float:left; padding-top:30px">
		<p> 
			<label>Card title:
				<input type = "text" id = "cardtitle" name="cardtitle" placeholder = "Card title" required style="border-radius:5px; margin-top:5px" required/>
			</label>
		</p>	
		<p> 
			<label>Card description:
			<br>
				<textarea id = "carddescription" name="carddescription" placeholder = "Card description" required style="border-radius:5px; margin-top:5px" required; rows=5; cols=60;></textarea>
			</label>
		</p>
		<p> 
			<label>Card type:
				<select name = "cardtype" id ="cardtype" style="border-radius:5px; margin-top:5px" required>
					<?
					if($isPO){
					?>
					<option value='0'>New feature</option>
					<?
					}
					?>
					<?
					if($isKM){
					?>
					<option value='1'>Silver bullet</option>
					<?
					}
					?>
				</select>
			</label>
		</p>
		<p> 
			<label>Card assignee:<br>
				<select name="developers" style="border-radius:5px; margin-top:5px">
				<?
				foreach($developers as $key => $value){
					$developer = $developers[$key];
					$name    = strtoupper($developer['UserName']);
					$surname    = strtoupper($developer['UserSurname']);
					$uid    = $developer['id_user'];
					echo"<option value='{$uid}'>{$name} {$surname}</option>";
				}
				?>
				</select>
			</label>
		</p>
		<p> 
			<label>Card size:
				<input type = "number" min="0" id = "cardsize" name="cardsize" placeholder = "Card size" style="border-radius:5px; margin-top:5px"/>
			</label>
		</p>
		<p> 
			<label>Card deadline:
				<input type = "date" id = "carddeadline" name="carddeadline" placeholder = "Card deadline" style="border-radius:5px; margin-top:5px"/>
			</label>
		</p>

		<input type="hidden" value="<?php echo $projectID; ?>" name="projectID">
		<input type="submit" value="Create"/>
		
		<p>
			{% if(isset($error)){ %}
				{{error}}
			{% } %}
		</p>
		
	</form>
</div>

[include]app/views/footer.view.php[/include]