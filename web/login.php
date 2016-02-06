<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	$includes = $root.'/Symfony/cms6/web/';
	
	require_once($includes.'includes/header.php');
    require($includes."html/login/config.php");  
?> 

	  <main class="mdl-layout__content">
	  <div class ="page-content">
		<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
		<div class="login-card-wide mdl-card mdl-shadow--2dp">
			<form class="form-signin" name="form1" method="post">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Login</h2>
				</div>			
					<label for="inputUsername" class="sr-only">Username:</label>
					<input name="username" id="inputUsername" class="form-control" placeholder="Username" required
					autofocus>
					<label for="inputPassword" class="sr-only">Password:</label>
					<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
					
				<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2">
				  <input type="checkbox" id="checkbox-2" class="mdl-checkbox__input" value="remember-me">
				  <span class="mdl-checkbox__label">Remember Me</span>
				</label>	
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
				  Login
				</button>
			</form>
		</div>
		</section>
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