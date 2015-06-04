[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> 
	Edit card 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>	
</div><br>

<div class="center_block">

	<form action='?page=editColumn' method='post' >
		<?php 
			$name = $column['name'];
			$limit = $column['cardLimit'];
			$priority = $column['priority_col'];
			$testing = $column['testing_col'];
            $id = $column['column_id'];
		?>
		 
		<label class="cool_font"> Column name </label><br>
		<input type="hidden" value="<?php echo $id; ?>" name="columnID">
		<input type = "text" value="<?php echo $name; ?>" id ="name" name="name" placeholder = "Column name" required /><br>
			
		<label class="cool_font"> Column limit </label><br>
		<input type ="text" value="<?php echo $limit; ?>" id ="limit" name="limit" placeholder = "Column limit" required /><br>
			
		<label class="cool_font"> Highest priority column </label><br>
		Yes: <input type="radio" value="1" name="priority"<?php if ($priority) echo "checked ";?>>
		&nbsp;&nbsp;&nbsp;
		No: <input type="radio" value="0" name="priority" <?php if (!$priority) echo "checked ";?>><br>

		<label class="cool_font"> Acceptance testing column </label><br>
		Yes: <input type="radio" value="1" name="testing" <?php if ($testing) echo "checked ";?>>
		&nbsp;&nbsp;&nbsp;
		No: <input type="radio" value="0" name="testing" <?php if (!$testing) echo "checked ";?>><br>

		<input type="hidden" value="<?php echo $projectID; ?>" name="projectID" id="projectID">
		<input type="hidden" value="<?php echo $screenWidth; ?>" name="screenWidth" id="screenWidth">
			
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