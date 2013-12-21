<?php
include_once ("configure/configure.php");
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
			</div>
		</nav>
		<div class="container">

			<div class="row">
				<div style="margin: 20px;"></div>
				<div class="col-lg-6">
					<h3>Sign in</h3>
					<form class="form-horizontal" id="frmsignin"name="frmsignin" role="form" method="post" action="signin.php">
						<?php if(isset($_REQUEST['alert'])){ ?><span class="alert"><?php echo $_REQUEST['alert']; ?></span><?php } ?>
						<div class="alert alert-error hide">
							<button class="close" data-dismiss="alert"></button>
							You have some form errors. Please check below.
						</div>
						<div class="alert alert-success hide">
							<button class="close" data-dismiss="alert"></button>
							Your form validation is successful!
						</div>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" name="emailsignin" id="inputEmail3" placeholder="Email">

							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="passwordsignin" id="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" name="submit" class="btn btn-default">
									Login
								</button>
							</div>
						</div>
					</form>

				</div>
				<div class="col-lg-6">
					<h3>Sign Up</h3>
					<form class="form-horizontal" id="frmsignup"name="frmsignup" role="form" method="post" action="signup.php">
						<?php if(isset($_REQUEST['msg'])){ ?><span class="alert"><?php echo $_REQUEST['msg']; ?></span><?php } ?>
						<div class="alert alert-error hide">
						<button class="close" data-dismiss="alert"></button>
						You have some form errors. Please check below.
						</div>
						<div class="alert alert-success hide">
						<button class="close" data-dismiss="alert"></button>
						Your form validation is successful!
						</div>

						<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email">

						</div>
						</div>
						<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						</div>
						</div>
						<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>
						<div class="col-sm-10">
						<input type="password" class="form-control" name="password2" id="password2" placeholder="Password">
						</div>
						</div>

						<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="submit" class="btn btn-default">
						Register
						</button>
						</div>
						</div>
					</form>

				</div>
				<center>
					<h3>Or</h3>
					<a href="https://accounts.google.com/o/oauth2/auth?response_type=code&redirect_uri=http://php-hachiassignment.rhcloud.com/oauth.php&client_id=1044765685023.apps.googleusercontent.com&scope=http%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds%2F&access_type=offline&approval_prompt=force" style="background-color:#E32B1D;color:#FFFFFF;padding: 10px; ">Sign In Using Gmail</a>
				</center>
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
		<!-- validation -->
		<script src="js/jquery.validate.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var form1 = $('#frmsignup');
				var error1 = $('.alert-error', form1);
				var success1 = $('.alert-success', form1);
				form1.validate({
					errorElement : 'span', //default input error message container
					errorClass : 'help-inline', // default input error message class
					focusInvalid : false, // do not focus the last invalid input
					ignore : "",
					rules : {
						email : {
							required : true
						},
						password : {
							required : true
						},
						password2 : {
							required : true,
							equalTo : '#password'
						}
					},
					invalidHandler : function(event, validator) {//display error alert on form submit
						success1.hide();
						error1.show();
					},
					highlight : function(element) {// hightlight error inputs
						$(element).closest('.help-inline').removeClass('ok');
						// display OK icon
						$(element).closest('.control-group').removeClass('success').addClass('error');
						// set error class to the control group
					},
					unhighlight : function(element) {// revert the change done by hightlight
						$(element).closest('.control-group').removeClass('error');
						// set error class to the control group
					},
					success : function(label) {
						label.addClass('valid').addClass('help-inline ok')// mark the current input as valid and display OK icon
						.closest('.control-group').removeClass('error').addClass('success');
						// set success class to the control group
					},
					submitHandler : function(form) {
						success1.show();
						form.submit();
						error1.hide();
					}
				});

				var form2 = $('#frmsignin');
				var error1 = $('.alert-error', form1);
				var success1 = $('.alert-success', form1);
				form2.validate({
					errorElement : 'span', //default input error message container
					errorClass : 'help-inline', // default input error message class
					focusInvalid : false, // do not focus the last invalid input
					ignore : "",
					rules : {
						emailsignin : {
							required : true
						},
						passwordsignin : {
							required : true
						}
					},
					invalidHandler : function(event, validator) {//display error alert on form submit
						success1.hide();
						error1.show();
					},
					highlight : function(element) {// hightlight error inputs
						$(element).closest('.help-inline').removeClass('ok');
						// display OK icon
						$(element).closest('.control-group').removeClass('success').addClass('error');
						// set error class to the control group
					},
					unhighlight : function(element) {// revert the change done by hightlight
						$(element).closest('.control-group').removeClass('error');
						// set error class to the control group
					},
					success : function(label) {
						label.addClass('valid').addClass('help-inline ok')// mark the current input as valid and display OK icon
						.closest('.control-group').removeClass('error').addClass('success');
						// set success class to the control group
					},
					submitHandler : function(form) {
						success1.show();
						form.submit();
						error1.hide();
					}
				});

			});
		</script>
		<!-- validation end -->
	</body>
</html>

