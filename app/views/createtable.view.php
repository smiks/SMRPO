[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field">
		<h3>Create Board</h3>
	</div>
	<br>
	<div id="field">
		<form action='' method='post'>
			<input type='hidden' name='groupID' value='{{groupID}}'>
			<input type='hidden' name='projectID' value='{{projectID}}'>
			<center>
				<label>Board name</label>
				<input type="text" name="boardName" id="textinput_200"<br>
				<br>
				<table style='width: 99%;'>
					<tr>
						<td style='width: 33%;'>
							<center>
								BackLog
							</center>
						</td>
						<td style='width: 33%;'>
							<center>
								Development
							</center>
						</td>
						<td style='width: 33%;'>
							<center>
								Done
							</center>
						</td>
					</tr>
					<tr>
						<td style='width: 33%;'>
							<center>
								Column color &nbsp; 
								<input type='color' name='colorColsOne' value='#FF3300'><br>
								Column Limit &nbsp; 
								<input type='number' name='limitColsOne' style='width: 50px;' value='0' min='0' max='50'><br>
								Number of columns &nbsp; 
								<select name='numColsOne'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
								</select>
							</center>
						</td>
						<td style='width: 33%;'>
							<center>
								Column color &nbsp; 
								<input type='color' name='colorColsTwo' value='#FFCC00'><br>
								Column Limit &nbsp; 
								<input type='number' name='limitColsTwo' style='width: 50px;' value='0' min='0' max='50'><br>
								Number of columns &nbsp; 
								<select name='numColsTwo'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
								</select>
							</center>
						</td>
						<td style='width: 33%;'>
							<center>
								Column color &nbsp; 
								<input type='color' name='colorColsThree' value='#009933'><br>
								Column Limit &nbsp; 
								<input type='number' name='limitColsThree' style='width: 50px;' value='0' min='0' max='50'><br>
								Number of columns &nbsp; 
								<select name='numColsThree'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
								</select>
							</center>
						</td>
					</tr>
					<tr>
						<td colspan='3'>
							<center>
								<input type='submit' value='Next step'>
							</center>
						</td>
					</tr>
				</table>
					
			</center>
		</form>
	</div>

</div>




[include]app/views/footer.view.php[/include]