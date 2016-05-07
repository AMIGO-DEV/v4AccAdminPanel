<?php
error_reporting(E_ALL);
	$PageName="Productmaster";
	$TooltipRequired=1;
	$SearchRequired=1;
	$FormRequired=1;
	$TableRequired=1;
	require_once 'config.php';
	//include("Include.php");
	//IsLoggedIn();
	include("Template/HTML.php");
	
	if( $conn === false ) {
     die( print_r( sqlsrv_errors(), true));
}
?>    

<?php
include("Template/Header.php");
?>

<?php
include("Template/Sidebar.php");
?>
<style>
.margin-top-10px
{
	margin-top:10px;
}
</style>
<div class="page-container" style="min-height:415px">
<div class="page-content">
<div class="content-wrapper">

<!-- Content area -->
				<div class="content">
                    <div class="panel panel-white">
					<div class="panel-heading">
							<h6 class="panel-title">Dispatch Order</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a><a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
					
					
					<div class="row">
                        <div class="col-md-12">
						<div class="col-md-6">
                            <div class="form-group">
                                <label>Root:</label>
                                <select name="root" id="root" class="select" required="required">
                                    <option value="">Select Root</option> 
									<?php
									$sql = "SELECT VRootID,VRootname FROM VRoot ";
									//$query = sqlsrv_query($conn, $sql) or die(sqlsrv_errors($conn));
									
									$stmt = sqlsrv_query( $conn, $sql );
									
									if( $stmt === false ) {
										if( ($errors = sqlsrv_errors() ) != null) {
											foreach( $errors as $error ) {
												echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
												echo "code: ".$error[ 'code']."<br />";
												echo "message: ".$error[ 'message']."<br />";
											}
										}
									}
									
									
									while($row=sqlsrv_fetch_array($query))
									{
										?>
										<option value="<?php echo $row['VRootID'];?>"><?php echo $row['VRootname'];?></option>
										<?php
									}
								?>		
									
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Truck:</label>
                                <select name="truck" id="truck" class="select" required="required">
                                    <option value="">Select Truck</option> 
                                     
                                </select>
                            </div>
                        </div>
						
                    <div class="row">&nbsp;</div>
					</div>		
                    </div>
					<div class="row">
						<div class="col-md-12">
						<div class="col-md-6">
                            <div class="form-group">
                                <select name="order_status" id="order_status" class="form-control" required="required">
                                    <option value="">Select Order Status</option> 
                                    <option value="without_order">With Order</option> 
									<option value="with_order">Without Order</option> 		
                                </select>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
								<input type="text" name="order_no" id="order_no" class="form-control col-md-12">
							</div>
						</div>
						</div>
						<div class="col-md-12">
						<div id="generate_plan">	
									<div clas="row margin-top-10px">
										
										<div class="col-md-2">
											<label class="control-label">Stoke No</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Product</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Available Qnt</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Price</lable>
										</div>
										<div class="col-md-1">
											<label class="control-label">Dispatch Qnt</lable>
										</div>
										<div class="col-md-2">
											<label class="control-label">Dispatch Qnt Price</lable>
										</div>
									</div>									
									<div class="row">
										<div class="multi-field-wrapper">
										  <button type="button" class="add-field btn btn-info">+</button>
										  <div class="multi-fields col-md-12">
											<div class="multi-field">
												
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Stoke_No" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Product" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Available Qnt" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Price" value="">
												</div>
												<div class="col-md-1 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Dispatch Qnt" value="">
												</div>
												<div class="col-md-2 margin-top-10px">
													<input type="text" name="course_title[]" class="form-control" placeholder="Dispatch Price" value="">
												</div>
												
												<button type="button" class="remove-field btn btn-info margin-top-10px">-</button>
											</div>	
										</div>
										</div>		
									</div>

									<div class="row margin-top-10px">
									<div class="text-left col-md-12">
										<input type="hidden" readonly="" value="CoursePlanAdd" name="Action">
										<input type="hidden" readonly="" value="3pZYO0Z1fc2suBdwRlRmAcUXLylhP00L72JGav3Mxfybvdfaj" name="RandomNumber">
										<input type="hidden" name="CoursePlanId" value="" readonly>
										<div class="form-row row-fluid">
											<div class="col-md-12">
												<button class="btn btn-info" tabindex="7" type="submit" id="genplan">Generate Plan</button>
											</div>
										</div>
										<br>
										</div>
									</div>
									
									</div>
									
						
					</div>			
					</div>
		           
					</div>
                    </div>
	
</div>				
</div>				
</div>		
<script>
 $(document).ready(function() {
  $('.select').select2();
   
   
   
   
	$('.multi-field-wrapper').each(function() {
		var $wrapper = $('.multi-fields', this);
		$(".add-field", $(this)).click(function(e) {
			$('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
			//$('.select').select2();
		});
		$('.multi-field .remove-field', $wrapper).click(function() {
			if ($('.multi-field', $wrapper).length > 1)
				$(this).parent('.multi-field').remove();
			
		});
	});
   
   
} );

</script>			
