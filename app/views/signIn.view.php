[include]app/views/header.view.php[/include]


		<table id="layout_login">
		<tr>
		<td>
			<div class="center_block" id="page_login">
				<div>
					<h1><center><img alt="Logo" src="../../static/images/logo7_1200.png" /></center></h1>
					<div id="login_block">
						<form id="form_login" action="https://friunilj.kanbanize.com/ctrl_login/login" method="post" style="display:block">
							<fieldset>
									<label>Email</label>
									<div class="input_holder email">
										<input type="email" value=""  title="" name="login_email" required autofocus />
									</div>
									<label>Password</label>
									<div class="input_holder password">
										<input type="password" value=""  title="" name="login_password" required />
									</div>
							</fieldset>
							<input type="submit" value="Log In" />
					</form>
					</div>

                        
				</div>
			</div>
		</td>
		</tr>
        </table>
		
[include]app/views/footer.view.php[/include]