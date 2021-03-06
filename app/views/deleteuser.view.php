[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<center>
<br><div class="center_block_header"> 
	Delete user 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">

	
	<form action='' method='post'>
		<label class="cool_font">User</label>
		<select name="userid">
			<?
			foreach($users as $key => $value){
				$user    = $users[$key];
				$name    = strtoupper($user['name']);
				$surname = strtoupper($user['surname']);
				$uid     = $user['id_user'];
				echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
			?>
		</select><br>
		
		<input type='submit' value='Delete' name='submit'><br>
		
		</form>
	
</div>
<center>

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Delete user' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						Select user from drop-down menu and click 'Delete' button.
						Selected user will not be actually deleted, it is going to be
						flagged / marked as inactive user. <br><br>
					
					<font color="red">
						Warning: when you click 'Delete' button, user is going to be flagged as inactive
						user (you will not be prompted again)! 
						
					</font>
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