<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Kanbanize - SMRPO#6</title>        
        <meta name="robots" content="" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <link rel="icon" type="image/png" href="../../static/images/favicon.png"/>
        <link type="text/css" rel="stylesheet" href="../../static/css/loginPage.css" />
        <link type="text/css" rel="stylesheet" href="../../static/css/adminMenu.css" />
        <link type="text/css" rel="stylesheet" href="../../static/css/menu.css" />
        <link type="text/css" rel="stylesheet" href="../../static/css/forms.css" />
        <!--<link type="text/css" rel="stylesheet" href="../../static/css/myStyle.css" />-->
        <link type="text/css" rel="stylesheet" href="../../static/css/openModal.css" />
 
    </head>
    <body>
    <div class="page">


		<table id="layout_login">
		<tr>
		<td>
			<div class="center_block_login" id="page_login">
				<div>
					<h1><center>
						<img alt="Logo" src="../../static/images/logo7_1200.png" />
						<a href="#info">
							<img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/>
						</a>
					</center></h1><br>
					

		
		
					<div id="login_block">
						<form id="form_login" action="?page=login" method="post" style="display:block">
							<fieldset>
									<label> <span style="font-size:20px"> Email</span></label>
									<div class="input_holder email">
										<input type="email" value=""  title="" name="login_email" required autofocus />
									</div>
									<label><span style="font-size:20px">Password</span></label>
									<div class="input_holder password">
										<input type="password" value=""  title="" name="login_password" required />
									</div>
									<div>
									{% if(isset($error)){ %}
										{{error}}
									{% } %}
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
       
        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:25px;">'Sign in' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body">
					<p>
						Input Email and Password. <br>
						You will be locked out after 3 wrong attempts!<br><br>
						Test accounts (type, email, password):<br>
						- kanban master: km@km.km ... 123456789<br>
						- developer: dev@dev.dev ... 123456789
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