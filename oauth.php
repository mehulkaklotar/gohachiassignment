<?php
include_once ("configure/configure.php");
session_start();
?>

<?php

require_once 'google-api-php-client/src/Google_Client.php';

$client = new Google_Client();
$client -> setApplicationName('Google Contacts');
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
if (!$client -> getAccessToken()) {
	$auth = $client -> createAuthUrl();
}
print "<div style='margin-top:20px;'></div>";
if (isset($auth)) {

	print "<a class=login style='background-color:#E32B1D;color:#FFFFFF;padding: 10px;' href='$auth'>Connect Using Gmail</a>";
} else {
	print "<a class=logout style='background-color:#E32B1D;color:#FFFFFF;padding: 10px;' href='?logout'>Disconnect Gmail</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Assigment</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">

		<!-- Add custom CSS here -->
		<link href="css/modern-business.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
	</head>

	<body>

		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
					<a class="navbar-brand" href="index.php">Assignment</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
			</div>
		</nav>
		<div class="container">
			<div class="row">
				<div style="margin: 20px;"></div>
				<h3>Gmail Contacts</h3>
				<div class="col-lg-12">

					<?php
					if ($client -> getAccessToken()) {
						$max_results = 10;
						$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full?max-results=" . $max_results . "&alt=json");
						$val = $client -> getIo() -> authenticatedRequest($req);

						// The contacts api only returns XML responses.
						//$response = json_encode(simplexml_load_string($val -> getResponseBody()));
						$response = $val -> getResponseBody();

						$response_as_array = json_decode($response, true);

						$feed = $response_as_array['feed'];

						//$id = $feed['id'];
						$author = $feed['author'];

						foreach ($author as $obj) {
							$name = $obj['name']['$t'];
							$email = $obj['email']['$t'];
						}

						$totalresults = $feed['openSearch$totalResults'];
						//echo $totalresults['$t'];
						$entries = $feed['entry'];

						//print "<pre>" . print_r($response_as_array, true) . "</pre>";
						print "<table class='table'><tr><th>Name</th>
								<th>Phone Numbers</th>
								</tr>";

						foreach ($entries as $entry) {
							print "<tr>";
							print "<td>";
							echo $entry['title']['$t'];
							print "</td>";
							print "<td>";
							if (isset($entry['gd$phoneNumber'])) {
								$phonenumber = $entry['gd$phoneNumber'];
								foreach ($phonenumber as $obj) {
									echo $obj['$t'];
								}
							}
							print "</td>";
							print "</tr>";
						}
						
							print "</table>";
						// The access token may have been updated lazily.
						$_SESSION['token'] = $client -> getAccessToken();

					} else {
						$auth = $client -> createAuthUrl();
						print "<h3>No Contacts. Connect Using Gmail</h3>";
					}
					?>
					
				</div>
			</div>

		</div><!-- /.container -->

		<div class="container">

			<hr>

			<footer>
				<div class="row">
					<div class="col-lg-12">
						<p>
							Copyright &copy; 2013
						</p>
					</div>
				</div>
			</footer>

		</div><!-- /.container -->

		<!-- JavaScript -->
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/modern-business.js"></script>
	</body>
</html>

