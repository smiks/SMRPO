[include]app/views/header.view.php[/include]


			<div style="background-color:#FFFFFF; padding-left:10%; padding-top:2%">
				<div style="width:20%; min-width:200px; border-style:solid; border-color:#BBC9D3; border-radius:20px; background-color: #D0E0EB">
					<form action='?page=login' method='post'>
						<div style = "background-color: #BBC9D3; height:30px; padding-top:0px"> <h3 style="padding-left:8px; padding-top:5px"> Sign in </h3></div>
						<p style="padding-left:8px;"> 
							<label>Username:
								<input type = "text" id = "usrname" name="usrname" placeholder = "Username" required/>
							</label>
						</p>	
						<p style="padding-left:8px;"> 
							<label>Password:
								<input type = "password" id = "passwrd" name="passwrd" placeholder = "Password" required/>
							</label>
						</p>
						<p>
							{% if(isset($error)){ %}
								{{error}}
							{% } %}
						</p>
						<p style="padding-left:8px;">
							<input type="submit" value="Sign in" id="signInButton" style="border-radius:20px; background-color: #F1F4F6; height:28px"/>
							<input type="button" value="Register" id="registerButton" style="border-radius:30px; background-color: #F1F4F6; height:28px"/>
						</p>
					</form>
				</div>
			</div>
		
[include]app/views/footer.view.php[/include]