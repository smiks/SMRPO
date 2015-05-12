[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	
<center>

<br><div class="center_block_header"> 
	Edit user: {{r['name']}} {{r['surname']}} 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">

	
	
	<form action='?page=editusersub' method='post'>
		<input type="hidden" value="{{r['id_user']}}" name="userid">
				
		<label class="cool_font"> Name </label><br>
		<input type="text" value="{{r['name']}}" name="name"><br>



		<label class="cool_font"> Surname </label><br>
		<input type="text" value="{{r['surname']}}" name="surname"><br>

		<label class="cool_font"> Email </label><br>
		<input type="email" value="{{r['email']}}" name="email"><br>

		<label class="cool_font"> Abilities </label><br>
		<input type="checkbox" value="1" name="productOwner" {{isOwner}} > Product owner&nbsp;<br>
		<input type="checkbox" value="1" name="kanbanmaster" {{isKM}} > Kanban master<br>
		<input type="checkbox" value="1" name="developer" {{isDev}} > Developer
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
		<br>

		<label class="cool_font"> Administrator </label><br>
		Yes: <input type="radio" value="1" name="administrator" <? if($isAdmin == 1) echo("checked") ?> >
		&nbsp;&nbsp;&nbsp;
		No: <input type="radio" value="0" name="administrator" <? if($isAdmin == 0) echo("checked") ?> ><br>

		<br>
		
		<label class="cool_font"> New password (optional) </label><br>
		<input type="password" name="password"><br>

		<label class="cool_font"> Re-type password </label><br>
		<input type="password" name="repassword"><br>				
		<center><i class="cool_font" style="font-size:10px;">(Note: password will not change if left blank)</i></center>
		<br>
		<input type='submit' value='Edit' name='submit'><br>
			
	</form>
	
</div>
<center>

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Edit user' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						You can change name, surname, password, abilities and administrator status. 
						Password will be only changed if you enter new password, otherwise it will
						remain unchanged. When you are done, click 'Edit'. You will be redirect to 
						subpage where you will be informed about changes. 
						
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