[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> 
	Create card 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

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

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Create card' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					
						
						User is able to create a new card within its limits. The card may represent 
						new functionality to be developed (common card), or urgent request 
						(silver bullet). Each type of card has its own color. The number of 
						urgent requests is limited. Card can be created only by Product owner. New 
						created card will appear in first column of corresponding board. Card size may
						be left empty, all other data must be entered! <br><br>
						
						Urgent request card may be only created by KanbanMaster. This card is automatically placed 
						in the column with the cards with the highest priority (just before the border column).
						It is recorded if WIP limit is violated. There can be only one silver bullet at any given 
						momentin in the column with the cards with the highest priority. <br><br>
						
						Click 'Create' button to create new card. You will be redirected to subpage where
						you will be informed about (un)successful creation. 
						
					
				</div>
				<div class="modal-footer">
					<a href="#close" class="btn">Okay, thanks!</a>  <!--CHANGED TO "#close"-->
				</div>
			</div>
		</div>
		</div>
		
	<!-- /Modal -->
	
[include]app/views/footer.view.php[/include]