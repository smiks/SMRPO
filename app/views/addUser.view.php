[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<center>

<br><div class="center_block_header"> 
	Add user 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>	
</div><br>

<div class="center_block">

	<form action='?page=adduser' method='post'>
			
				
		<label class="cool_font"> Name </label><br>
		<input type="text" name="name"><br>

		<label class="cool_font"> Surname </label><br>
		<input type="text" name="surname"><br>

		<label class="cool_font"> Email </label><br>
		<input type="email" name="email"><br>

		<label class="cool_font"> Abilities </label><br>
		<input type="checkbox" value="1" name="productOwner"> Product owner&nbsp;<br>
		<input type="checkbox" value="1" name="kanbanmaster"> Kanban master<br>
		<input type="checkbox" value="1" name="developer"> Developer
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
		<br>

		<label class="cool_font"> Administrator </label><br>
		Yes: <input type="radio" value="1" name="administrator">
		&nbsp;&nbsp;&nbsp;
		No: <input type="radio" value="0" name="administrator" checked><br>

		<br>
		<label class="cool_font"> Password </label><br>
		<input type="password" name="password"><br>

		<label class="cool_font"> Re-type password </label><br>
		<input type="password" name="repassword" ><br>				
		
		<input type='submit' value='Add' name='submit'><br>
			
	</form>
	
</div>
</center>

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Add user' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						Input name, surname, email, password, abilities and administrator password 
						for new user you wish to add. When done, click 'Add' button. You will be 
						redirected to subpage where you will be informed about (un)successful changes.  
						
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