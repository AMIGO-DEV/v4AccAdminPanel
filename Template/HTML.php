<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.ico" />    
	<base href="<?php echo $BASEURL; ?>" />     
    <title><?php //echo "$SCHOOLNAME"; ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/gitproject/v4AccAdminPanel/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/gitproject/v4AccAdminPanel/assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/gitproject/v4AccAdminPanel/assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="/gitproject/v4AccAdminPanel/assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="/gitproject/v4AccAdminPanel/assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<?php if($PageName!="Login" && $PageName!="ErrorPage") { ?>
	<script type="text/javascript">
        document.documentElement.className += 'loadstate';
    </script>
	<?php } ?>

	
	<!-- Core JS files -->
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->

	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/plugins/pickers/daterangepicker.js"></script>

	<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/core/app.js"></script>
	<!--<script type="text/javascript" src="/gitproject/v4AccAdminPanel/assets/js/pages/dashboard.js"></script>-->

	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	
	<script type="text/javascript" src="assets/js/plugins/forms/wizards/stepy.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jasny_bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/wizard_stepy.js"></script>
	<!-- /theme JS files -->
	
	<?php
		if(isset($TableRequired))
		{
		?>
    		<link href="/gitproject/v4AccAdminPanel/plugins/tables/dataTables/jquery.dataTables.css" type="text/css" rel="stylesheet" />  
    		<script type="text/javascript" src="/gitproject/v4AccAdminPanel/plugins/tables/dataTables/jquery.dataTables.min.js"></script>
    		<script type="text/javascript" src="/gitproject/v4AccAdminPanel/plugins/tables/responsive-tables/responsive-tables.js"></script>
		<?php if(!isset($TW)) { ?>
    		<!--<script type="text/javascript" src="/gitproject/v4AccAdminPanel/js/datatable.js"></script>-->
		<?php } else { ?>

			<script type="text/javascript" src="/gitproject/v4AccAdminPanel/js/datatablewith.js"></script>
		<?php } }?>

</head>

<body>