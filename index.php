<?php
error_reporting(0);
$PageName="Login";
$FormRequired=1;
$TooltipRequired=1;
$SearchRequired=1;
include("Include.php");
SESSION_START();
require_once 'config.php';
 
if($ErrorMessage!="")
{}
else {
	$Login=Login();
	if($Login==1)
	header("Location:dashboard.php");
if(isset($_POST['login']))
{
	$Username=isset($_POST['username']) ? $_POST['username'] : '';
	$Password=isset($_POST['password']) ? $_POST['password'] : '';
	
	
	if($Username!='' && $Password!='')
	{
		
		
		
		$sql = "select vuserid,vusertype from vuser where 
			vusername='$Username' and 
			vpassword='$Password' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt = sqlsrv_query( $conn, $sql , $params, $options );
		

		$count = sqlsrv_num_rows($stmt);
		
		 if($count>0)
		 {
			
			$row_data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
			
			 $_SESSION['UserId'] = $row_data['vuserid'];
			 $_SESSION['USERTYPE'] = $row_data['vusertype'];
			 $_SESSION['USERNAME']=$Username;
			
			header("Location:dashboard.php");
			$Message="Logged in Successful!!";
			$Type="success";
		}
		
	}
	else
	{
		echo "<script>";
		echo "alert('Username and password is required')";
		echo "</script>";
	}
}
}
SetNotification($Message,$Type);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/login.js"></script>
	<!-- /theme JS files -->

</head>

<body background="assets\images\backgrounds\bannerschool1.jpg" style="background-repeat: no-repeat;background-size: cover;>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="assets/images/logo.png" style="width:329px;height:51px" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
		
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Advanced login -->
					<form action="" id="loginForm" method="post">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" placeholder="Username" id="username" name="username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" placeholder="Password" id="password" name="password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" checked="checked">
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="login_password_recover.html">Forgot password?</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" name="login"  class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
							</div>

							

							<div class="content-divider text-muted form-group"><span>Don't have an account?</span></div>
							<a href="login_registration.html" class="btn btn-default btn-block content-group">Sign up</a>
							
						</div>
					</form>
					<!-- /advanced login -->


					<!-- Footer -->
					
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
<script type="text/javascript">
        $(document).ready(function() {
            $("input, textarea, select").not('.nostyle').uniform();
            $("#loginForm").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    username: {
                        required: "Fill me please!!",
                        minlength: "My name is bigger!!"
                    },
                    password: {
                        required: "Please provide a password!!",
                        minlength: "My password is more that 6 chars!!"
                    }
                }   
            });
        });
    </script>
