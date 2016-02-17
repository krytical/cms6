<?php
	session_start();
	$root = $_SERVER['DOCUMENT_ROOT'];
	$includes = $root.'/Symfony/cms6/web/';
	
	require_once($includes.'includes/header.php');
    require($includes."html/login/config.php");  
	
	if (isset($_SESSION['username'])){
		session_start();
		session_destroy();
	}		
?> 

	<main class="mdl-layout__content-register">
	<div class="register-content">
		<div class="mdl-card mdl-shadow--2dp">
			<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Register</h2>
			</div>

			<form class = "form-register" id="userregister" name="userregister" method="post" action="html/login/createuser.php" accept-charset="UTF-8">
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input name="username" class="mdl-textfield__input" type="text" id="username"/>
						<label class="mdl-textfield__label" for="username">Username</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input name="firstname" class="mdl-textfield__input" type="text" id="firstname" />
						<label class="mdl-textfield__label" for="firstname">First Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input name="lastname" class="mdl-textfield__input" type="text" id="lastname" />
						<label class="mdl-textfield__label" for="lastname">Last Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input name="userpass1" class="mdl-textfield__input" type="password" id="userpass1" />
						<label class="mdl-textfield__label" for="userpass1">Password</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input name="userpass2" class="mdl-textfield__input" type="password" id="userpass2" />
						<label class="mdl-textfield__label" for="userpass2">Repeat Password</label>
					</div>
				</div>
				<div class="mdl-card__actions mdl-card--border">
					<button name="register" id="register" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="register">Register</button>
				</div>
			</form>
		</div>
	</div>
	</main>
</div> <!-- end div for header.php -- >

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script defer src="https://code.getmdl.io/1.1.1/material.min.js"></script>
</body>
</html>