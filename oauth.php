<!DOCTYPE html>
<html>
	<head>
		<title>Assignment</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!--Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700' rel='stylesheet' type='text/css'>

		<!--CSS-->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css"/>

		<!--Default Theme-->
		<link rel="stylesheet" href="assets/css/style.css" type="text/css"/>

	</head>
	<body>
		<!--Wrapper-->
		<div id="wrapper">
			<!--Container-->
			<div class="container page-body">

				<!--Authorization-->
				<div id="profile" class="nav-target">
					<div style="margin: 10px 0 0 30px;float:left;">
							<?php

							require_once 'google-api-php-client/src/Google_Client.php';
							session_start();

							$client = new Google_Client();
							$client -> setApplicationName('Google Contacts PHP Sample');
							$client -> setScopes("http://www.google.com/m8/feeds/");
							// Documentation: http://code.google.com/apis/gdata/docs/2.0/basics.html
							// Visit https://code.google.com/apis/console?api=contacts to generate your
							// oauth2_client_id, oauth2_client_secret, and register your oauth2_redirect_uri.
							// $client->setClientId('insert_your_oauth2_client_id');
							// $client->setClientSecret('insert_your_oauth2_client_secret');
							// $client->setRedirectUri('insert_your_redirect_uri');
							// $client->setDeveloperKey('insert_your_developer_key');

							if (isset($_GET['code'])) {
								$client -> authenticate();
								$_SESSION['token'] = $client -> getAccessToken();
								$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
								header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
							}

							if (isset($_SESSION['token'])) {
								$client -> setAccessToken($_SESSION['token']);
							}

							if (isset($_REQUEST['logout'])) {
								unset($_SESSION['token']);
								$client -> revokeToken();
							}

							if ($client -> getAccessToken()) {
								$max_results = 10000;
								$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full?max-results=" . $max_results);
								$val = $client -> getIo() -> authenticatedRequest($req);

								// The contacts api only returns XML responses.
								$response = json_encode(simplexml_load_string($val -> getResponseBody()));
								$result = json_decode($response, true);
								$author = $result['author'];
								print "<h3>Hello, ". $author['name']. "</h3>";
								print "<h4>Your Contacts List</h4>";
								//print "<pre>" . print_r($result, true) . "</pre>";
								$entry = $result['entry'];
								foreach ($entry as $obj) {
									if (!is_array($obj['title']))
										echo "<br>" . $obj['title'] . "<br />";
								}

								// The access token may have been updated lazily.
								$_SESSION['token'] = $client -> getAccessToken();
							} else {
								$auth = $client -> createAuthUrl();
							}

							if (isset($auth)) {
								print "<a class=login href='$auth'>Login Using Gmail</a>";
							} else {
								print "<a class=logout href='?logout'>Logout</a>";
							}
							?>
					</div>
				</div>
				<!--End Wrapper -->

	</body>
</html>
<!--Javascript-->
<script src="assets/js/jquery-1.10.2.min.js"></script>
<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

