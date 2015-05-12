[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> 
	Edit card 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>	
</div><br>

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
		<input type = "text" value="<?php echo $name; ?>" id = "cardtitle" name="cardtitle" placeholder = "Card title" required 
		<?php if (!$canChange)
				echo "readonly ";?> /><br>
			
		<label class="cool_font"> Card description </label><br>
		<textarea id = "carddescription" name="carddescription" placeholder = "Card description" required rows="5" cols="1" 
		<?php if (!$canChange)
				echo "readonly ";?> ><?php echo $description;?></textarea><br>
			
		<label class="cool_font"> Card assignee </label><br>
		<select name="developers" <?php if (!$canChange)
						echo "disabled";?> >
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
		<input type = "number" value="<?php echo $size; ?>" min="0" id = "cardsize" name="cardsize" placeholder = "Card size" 
		<?php if (!$canChange)
			echo "readonly ";?>/><br>
			
		<label class="cool_font"> Card deadline </label><br>
		<input type = "date" value="<?php echo $deadline; ?>" id = "carddeadline" name="carddeadline" placeholder = "Card deadline" <?php if (!$canChange)
																			echo "readonly ";?>/><br>
			
		<input type="submit" value="Edit"/><br>


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
					<br><label class="cool_font" style="font-size:30px;">'Edit card' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						User may within its limits update the data recorded on the card. User can only
						update card data for cards which are part of current user projects. 
						<br><br>
						Only Product owner and KanbanMaster can update cards before card enteres in the first (boarder) column.
						Updates within inner boarder columns may be done only by KanbanMaster and current project
						developers. 
						<br><br>
						After card is in the final column updates are not allowed.<br><br>
						Click 'Edit' to save changes. You will be informed about (un)successful changes.
						
						
					</p>
				</div>
				<div class="modal-footer">
					<a href="#close" class="btn">Okay, thanks!</a>  <!--CHANGED TO "#close"-->
				</div>
			</div>
		</div>
		</div>
		
	<!-- /Modal -->
	
[include]app/views/footer.view.php[/include]