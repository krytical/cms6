<?php
	require_once('includes/header.php');
    require("html/login/config.php");
?> 
	
	<main class="mdl-layout__content-login">
	<div class="login-content">
		<div class="mdl-card mdl-shadow--2dp">
			<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Login</h2>
			</div>
	  	<div class="mdl-card__supporting-text">
				<form action="#">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="username" />
						<label class="mdl-textfield__label" for="username">Username</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="password" id="userpass" />
						<label class="mdl-textfield__label" for="userpass">Password</label>
					</div>
					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
						<input type="checkbox" id="checkbox-1" class="mdl-checkbox__input" value="remember-me">
						<span class="mdl-checkbox__label">Remember Me</span>
					</label>
				</form>
			</div>
			<div class="mdl-card__actions mdl-card--border">
				<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Login</button>
			</div>
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