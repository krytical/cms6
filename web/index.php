<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	$includes = $root.'/Symfony/cms6/web/';
	
	require_once($includes.'includes/header.php');
?> 

	  <main class="mdl-layout__content">
		<div class="page-content">
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
			<div class="welcome-card-wide mdl-card mdl-shadow--2dp">
			  <div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Conference 1</h2>
			  </div>
			  <div class="mdl-card__supporting-text">
				Something about conference 1.
			  </div>
			  <div class="mdl-card__actions mdl-card--border">
				<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
				  Join Conference
				</a>
			  </div>
			</div>
			</section>
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
			<div class="welcome-card-wide mdl-card mdl-shadow--2dp">
			  <div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Conference 2</h2>
			  </div>
			  <div class="mdl-card__supporting-text">
				Something about conference 2.
			  </div>
			  <div class="mdl-card__actions mdl-card--border">
				<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
				  Join Conference
				</a>
			  </div>
			</div>
			</section>
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
			<div class="welcome-card-wide mdl-card mdl-shadow--2dp">
			  <div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Conference 3</h2>
			  </div>
			  <div class="mdl-card__supporting-text">
				Something about conference 3.
			  </div>
			  <div class="mdl-card__actions mdl-card--border">
				<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
				  Join Conference
				</a>
			  </div>
			</div>
			</section>
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