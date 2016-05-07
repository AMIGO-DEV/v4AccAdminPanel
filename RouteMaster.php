<?php
	error_reporting(0);
	$PageName="Route Master";
	$TooltipRequired=1;
	$SearchRequired=1;
	$FormRequired=1;
	$TableRequired=1;
	include("Include.php");
	IsLoggedIn();
	include("Template/HTML.php");
?>    

<?php
	include("Template/Header.php");
?>

<?php
	include("Template/Sidebar.php");
?>

<div class="page-header">
	<div class="page-header-content">
	<?php DisplayNotification(); ?>
		<div class="page-title">
			<?php $BreadCumb="Route Master"; BreadCumb($BreadCumb); ?>			
		</div>
		<div class="heading-elements">
			<div class="heading-btn-group">	
				<?php BreadCumbSession($CURRENTSESSION); ?>			
			</div>
		</div>
	</div>		
</div>


<div class="row">
<div class="col-md-6">
	<!-- route master -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">Route Master</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
			</ul>
		</div>
	</div>
	<div class="panel-body">
	<?php
		
		$routeMastId = "";
		if(isset($_GET['Action']) && $_GET['Action'] == 'RM'){
			if($_GET['UniqueId'] == ""){
				header("Location:RouteMaster");
				exit;
			}
			$routeMastId = $_GET['UniqueId'];
			$sql = "SELECT * FROM route_master WHERE RouteMastId = '".$_GET['UniqueId']."'";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$RouteMastData = sqlsrv_query( $conn, $sql , $params, $options );
			$RouteMastData = sqlsrv_fetch_array($RouteMastData);
		}
	
	?>
	<form action="Action" name="SetRouteMaster" id="SetRouteMaster" method="Post" >
		<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			<label>State:</label>
			<select name="State" id="State" class="form-control" onChange="getCities(this.value);">
				<option>-- Select State -- </option>
				<?Php
					$state = "SELECT * FROM states WHERE country_id = '6' ORDER BY name";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$state = sqlsrv_query( $conn, $state , $params, $options );
					while($state101 = sqlsrv_fetch_array($state)){
						$sel = "";
						if($RouteMastData['State'] == $state101['id'])
							$sel = "Selected"; 
				?>
					<option value="<?php echo $state101['id']; ?>" <?php echo $sel; ?>><?php echo $state101['name']; ?></option>
				<?php } ?>	
			</select>
		</div>
		<div class="form-group">
			<label>City:</label>
			<select name="City" id="City" class="form-control" required="required">
				<?php 
				if($RouteMastData != ""){
				$cities = "SELECT * FROM cities WHERE state_id = '".$RouteMastData['State']."' ORDER BY name";
				$cities = sqlsrv_query( $conn, $cities , $params, $options );
				while($city = sqlsrv_fetch_array($cities)){ 
				  $sel = "";
				  if($RouteMastData['City'] == $city['id'])
					   $sel ="Selected";
				?>
				<option value="<?php echo $city['id']; ?>" <?php echo $sel; ?>><?php echo $city['name']; ?></option>
				<?php } } else { ?>
				<option value="">-- Select City--</option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label>Zone:</label>
			<input type="text" name="Zone" class="form-control" required="required" placeholder="Zone" value="<?php echo $RouteMastData['Zone']; ?>">
		</div>
		<div class="form-group">
			<label>Route:</label>
			<input type="text" name="Route" class="form-control" required="required" placeholder="Route" value="<?php echo $RouteMastData['RouteName']; ?>">
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
			<label>Area:</label>
			<input type="text" name="Area" class="form-control" required="required" placeholder="Area" value="<?php echo $RouteMastData['Area']; ?>">
		</div>
		<!--<div class="form-group">
			<label>Client Type:</label>
			<select name="default_select" class="form-control" required="required"> 
				<optgroup label="select client type">
					<option value="CC">Cash &amp; Carry</option>
					<option value="HM">Hyper Market</option>
					<option value="SM">Super Market</option>
					<option value="CN">Canteen</option>
					<option value="MS">Mini Shop</option>
					<option value="DST">Distributor</option>
				</optgroup>
			</select>
		</div>-->
		<div class="form-group">
			<label>Client:</label>
			<input type="text" name="Client" class="form-control" required="required" placeholder="Client" value="<?php echo $RouteMastData['ClientName']; ?>">
		</div>
		</div>
		</div>
		<input type="hidden" name="RouteMastId" value="<?php echo $routeMastId; ?>"  readolny> 
		<input type="hidden" name="Action" value="SetRouteMaster" readonly>
		<input type="hidden" name="RandomNumber" value="<?php echo $TOKEN; ?>" readonly>
		<?php $ButtonContent="Submit"; ActionButton($ButtonContent,7); ?>

		<!--<button type="submit" class="btn btn-primary stepy-finish">Submit <i class="icon-check position-right"></i></button>-->
		
	</form>
	</div>
</div>
<!-- /route master -->
	</div>
	<div class="col-md-6">
	<!-- route assignment -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">Route Assignment</h6>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
			</ul>
		</div>
	</div>
	<?php
		
		$routeAssId = "";
		if(isset($_GET['Action']) && $_GET['Action'] == 'RA'){
			if($_GET['UniqueId'] == ""){
				header("Location:RouteMaster");
				exit;
			}
			$routeAssId = $_GET['UniqueId'];
			$sql = "SELECT * FROM route_assignment WHERE RouteAssignId = '".$_GET['UniqueId']."'";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$RouteAssData = sqlsrv_query( $conn, $sql , $params, $options );
			$RouteAssData = sqlsrv_fetch_array($RouteAssData);
		}
	
	?>
	<div class="panel-body">
	<form action="Action" name="SetRouteAssignment" id="SetRouteAssignment" method="Post" >
		<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			<label>Route Name:</label>
			<select name="RouteId" class="form-control" required="required">
				<option value="">-- Select Route --</option>
				<?php 
				$sql = "SELECT * FROM route_master ORDER BY RouteName";
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$routMaster = sqlsrv_query( $conn, $sql , $params, $options );
				$count = sqlsrv_num_rows($routMaster);
				if($count){
				while($routMast = sqlsrv_fetch_array($routMaster)){
					$sel = "";
					if($routMast['RouteMastId'] == $RouteAssData['RouteId']){
						$sel = "Selected";
					}
				?>
				<option value="<?php echo $routMast['RouteMastId']; ?>" <?php echo $sel; ?>><?php echo $routMast['RouteName']?></option>
				<?php } } ?>
			</select>
		</div>
		<div class="form-group">
			<label>Start Date:</label>
			<input type="text" placeholder="start date" data-mask="99/99/9999" class="form-control daterange-single" name="start_date" id="start_date" value="<?php if($RouteAssData['StartDate'] != "") echo date("m/d/Y",$RouteAssData['StartDate']); else echo ""; ?>">
		</div>
		<div class="form-group">
			<label>End Date:</label>
			<input type="text" placeholder="End date" data-mask="99/99/9999" class="form-control daterange-single" name="end_date" id="end_date" <?php if($RouteAssData['EndDate'] != "") echo date("m/d/Y",$RouteAssData['EndDate']); else echo ""; ?>>
		</div>
		</div>
		<div class="col-md-6">
		<div class="form-group">
			<label>Day:</label>
			<input type="text" class="form-control" required="required" placeholder="Day" name="day" value="<?php echo $RouteAssData['Day']; ?>">
		</div>
		<div class="form-group">
			<label>Truck Number:</label>
			<input type="text" class="form-control" required="required" placeholder="truck number" name="truckno" value="<?php echo $RouteAssData['TruckNum']; ?>">
		</div>
		<div class="form-group">
			<label>Sales Man:</label>
			<input type="text" class="form-control" required="required" placeholder="salesman" name="salesman" value="<?php echo $RouteAssData['SalesMan']; ?>">
		</div>
		</div>
		</div>
		<input type="hidden" name="RouteAssId" value="<?php echo $routeAssId; ?>"  readolny> 
		<input type="hidden" name="Action" value="SetRouteAssignment" readonly>
		<input type="hidden" name="RandomNumber" value="<?php echo $TOKEN; ?>" readonly>
		<?php $ButtonContent="Submit"; ActionButton($ButtonContent,7); ?>

		
	</form>
	</div>
</div>
<!-- /route assignment -->
	</div>
	<div class="col-md-12">
		 <div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Route Master</h5>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
				<li><a data-action="reload"></a></li>
				<li><a data-action="close"></a></li>
			</ul>
		</div>
	</div>

	<div class="panel-body">
	</div>

	<table class="table datatable-basic">
		<thead>
			<tr>
				<th>State</th>
				<th>City</th>
				<th>Zone</th>
				<th>Route</th>
				<th>Area</th>
				<th>Client</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		    $sql = "SELECT rm.*,states.name AS stateName,cities.name AS cityName FROM route_master AS rm LEFT JOIN states ON rm.State = states.id LEFT JOIN cities ON rm.City = cities.id";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$routMaster = sqlsrv_query( $conn, $sql , $params, $options );
			$count = sqlsrv_num_rows($routMaster);
			if($count){
			while($routMast = sqlsrv_fetch_array($routMaster)){
		?>
			<tr>
				<td><?php echo $routMast['stateName']; ?></td>
				<td><?php echo $routMast['cityName']; ?></td>
				<td><?php echo $routMast['Zone']; ?></td>
				<td><?php echo $routMast['RouteName']; ?></td>
				<td><?php echo $routMast['Area']; ?></td>
				<td><?php echo $routMast['ClientName']; ?></td>
				<td class="text-center">
				<a href="RouteMaster/RM/<?Php echo $routMast['RouteMastId']; ?>">Edit</a>
				</td>
			</tr>
			<?php } } ?>
		</tbody>
	</table>
</div>
	</div>


	<!-- data table route assignment -->
	<div class="col-md-12">
		 <div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Route Assignment</h5>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
				<li><a data-action="reload"></a></li>
				<li><a data-action="close"></a></li>
			</ul>
		</div>
	</div>

	<div class="panel-body">
	</div>

	<table class="table datatable-basic">
		<thead>
			<tr>
				<th>Route Name</th>
				<th>Start Date:</th>
				<th>End Date:</th>
				<th>Day</th>
				<th>Truck Number</th>
				<th>SalesMan</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		    $sql2 = "SELECT ra.*,rm.RouteName FROM route_assignment AS ra LEFT JOIN route_master AS rm ON ra.RouteId = rm.RouteMastId ORDER BY rm.RouteName";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$routAssign = sqlsrv_query( $conn, $sql2 , $params, $options );
			$count = sqlsrv_num_rows($routAssign);
			if($count){
			while($routAss = sqlsrv_fetch_array($routAssign)){
		?>
			<tr>
				<td><?php echo $routAss['RouteName']; ?></td>
				<td><?php echo date("m/d/Y",$routAss['StartDate']); ?></td>
				<td><?php echo date("m/d/Y",$routAss['EndDate']); ?></td>
				<td><?php echo $routAss['Day']; ?></td>
				<td><?php echo $routAss['TruckNum']; ?></td>
				<td><?php echo $routAss['SalesMan']; ?></td>
				<td class="text-center">
					<a href="RouteMaster/RA/<?Php echo $routAss['RouteAssignId']; ?>">Edit</a>
				</td>
			</tr>
			<?php } } ?>
		</tbody>
	</table>
</div>
	</div>
</div>
<script>
$('.daterange-single').daterangepicker({
        singleDatePicker: true,
    });
function getCities(val){
	$.ajax({
		url: 'Action.php',
		type: 'POST',  
		dataType: 'html',
		data:{
			Action: 'GetCities',
			stateCode : val
		},
		success: function(data) {
			 $("#City").html(data);
		},
		error: function() {
		}
	});
}
</script>
<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>	    
<?php
include("Template/Footer.php");
?>