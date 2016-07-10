<div class="wrap">
	<h2> Envato API Test </h2>

	<p>Welcome! This test makes use of the new OAuth Envato API, details here: http://build.envato.com </p>
	<p>Authenticate with your Envato account below and a list of your purchases will be displayed.</p>
	<p><em>(this uses implicit OAuth authentication flow so no secret key is distributed)</em></p>

	<h2>Setup instructions</h2>
		<ul>
			<li>Register a new app at build.envato.com</li>
			<li>Set the redirect URL to <?php echo admin_url('tools.php?page=envato-api-oauth');?></li>
			<li>Add your client ID into the envato_api_oauth.php file</li>
			<li>Come back here and click the login button</li>
		</ul>

	<?php

	if(!empty($_REQUEST['code'])) {
		// we have a login callback.
		$token = false;
		try {
			$token = $envato->get_authentication( $_REQUEST['code'] );
		} catch ( Exception $e ) {

		}
		?>

		<h2>Token Result</h2>
		<pre><?php print_r($token);?></pre>

		<?php
	}
	?>

	<!-- this URL contains the client_id from dtbaker (register your own app!) and the redirect URL back to this page -->
	<a href="https://api.envato.com/authorization?response_type=token&client_id=<?php echo _ENVATO_APP_CLIENT_ID;?>&redirect_uri=<?php echo urlencode(admin_url('tools.php?page=envato-api-oauth'));?>">Login with your Envato account</a>

</div>