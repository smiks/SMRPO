[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>

<br><div class="center_block_header"> 
	Delete project 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>	
</div><br>

<div class="center_block" style="max-width:20%;">
	
	
	<form action='' method='post'>
		
		<input type="hidden" value="<?php echo $projectid; ?>" name="projectid"><br>	
		<center><big>Are you sure you want to </big><br><big> delete project <b><?php echo $pname; ?></b>?</big><br></center>
		
		<br><input type='submit' value='Yes, delete it!' name='submit'><br>
		
		
	</form> 
	
</div>
</center>

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Delete project' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						Click 'Yes, delete it!' button if you want to delete project <b><?php echo $pname; ?></b>.<br><br>
						
						Warning: if there are existing project cards for this project, project will not be deleted,
						it will be flagged as inactive.
						
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