<?php
	$PageName="Productmaster";
	$TooltipRequired=1;
	$SearchRequired=1;
	$FormRequired=1;
	$TableRequired=1;
	require_once 'config.php';
	//include("Include.php");
	//IsLoggedIn();
	include("Template/HTML.php");
	
	
?>    

<?php
include("Template/Header.php");
?>

<?php
include("Template/Sidebar.php");
?>




				<!-- Content area -->
				<div class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="basic" class="form-control" required="required" placeholder="NAME">
                            </div>
                            <div class="form-group">
                                <label>Contact No.:</label>
                                <input type="phone" name="basic" class="form-control" required="required" placeholder="CONTACT NO.">
                            </div>
                            <div class="form-group">
                                <label>Email Address:</label>
                                <input type="email" name="basic" class="form-control" required="required" placeholder="">
                            </div>   
                            <div class="form-group">
                                <label>Website:</label>
                                <input type="email" name="basic" class="form-control" required="required" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Client Type:</label>
                                <select name="default_select" class="form-control" required="required">
                                    <option value="">Client type</option> 
                                    <optgroup label="">
                                        <option value="HP">Cleint type1</option>
                                        <option value="DE">Cleint type2</option>
                                        <option value="LE">Cleint type3</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="row"><div class="col-md-6">
                            <div class="form-group">
                                <label>Manufacturer:</label>
                                <select name="default_select" class="form-control" required="required">
                                    <option value="">Select Manufacturer from the list</option> 
                                    <optgroup label="HP / Dell / Lenovo">
                                        <option value="HP">HP</option>
                                        <option value="DE">Dell</option>
                                        <option value="LE">Lenovo</option>
                                    </optgroup>
                                </select>
                            </div></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Supplier:</label>
                                <select name="default_select" class="form-control" required="required">
                                    <option value="">Select supplier</option> 
                                        <option value="HP">Supplier1</option>
                                        <option value="DE">Supplier2</option>
                                        <option value="LE">Supplier3</option>
                                </select>
                                </div></div>
                            </div>
                            
                            <div class="form-group">
                                <label>Dealer:</label>
                                <select name="default_select" class="form-control" required="required">
                                    <option value="">Select dealer</option> 
                                        <option value="HP">Dealer1</option>
                                        <option value="DE">Dealer2</option>
                                        <option value="LE">Dealer3</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Distributor:</label>
                                <select name="default_select" class="form-control" required="required">
                                    <option value="">Select distributor</option> 
                                        <option value="HP">Distributor1</option>
                                        <option value="DE">Distributor2</option>
                                        <option value="LE">Distributor3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Client Address:</label>
                        <input type="text" name="basic" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                        <label>Client Address2:</label>
                        <input type="text" name="basic" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                        <label>Client Zone:</label>
                        <select name="default_select" class="form-control" required="required">
                        <option value="">client zone</option> 
                        <option value="HP">value1</option>
                        <option value="DE">value2</option>
                        <option value="LE">value3</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label>City:</label>
                        <select name="default_select" class="form-control" required="required">
                        <option value="">Select City</option> 
                        <option value="HP">City1</option>
                        <option value="DE">City2</option>
                        <option value="LE">City3</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Zone:</label>
                        <select name="default_select" class="form-control" required="required">
                        <option value="">Select Zone</option> 
                        <option value="HP">Zone1</option>
                        <option value="DE">Zone2</option>
                        <option value="LE">Zone3</option>
                        </select>
                        </div>

                        <div class="form-group">
                        <label>State:</label>
                        <select name="default_select" class="form-control" required="required">
                        <option value="">Select State</option> 
                        <option value="HP">State1</option>
                        <option value="DE">State2</option>
                        <option value="LE">State3</option>
                        </select>
                        </div>
                        
                        <div class="form-group">
                        <label>Country:</label>
                        <select name="default_select" class="form-control" required="required">
                        <option value="">Select Country</option> 
                        <option value="HP">Country1</option>
                        <option value="DE">Country2</option>
                        <option value="LE">Country3</option>
                        </select>
                        </div>
                        
                        <div class="form-group">
                        <label>Pincode:</label>
                        <input type="text" name="basic" class="form-control" placeholder="">
                        </div>
                        
                        
                    </div>
                    </div>
                    
					
					
					
					<link href="assets/css/responce_datatable/jquery.dataTables.css" rel="stylesheet" type="text/css">
	<link href="assets/css/responce_datatable/dataTables.responsive.css" rel="stylesheet" type="text/css">
	
	<script type="text/javascript" src="assets/js/resposive_datatable/jquery.js"></script>
	<script>
		var $1_11_1 = jQuery.noConflict();
	</script>
	<script type="text/javascript" src="assets/js/resposive_datatable/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/js/resposive_datatable/dataTables.responsive.min.js"></script>
	
	<script type="text/javascript" language="javascript" >
			$1_11_1(document).ready(function() {
			   var dataTable =  $1_11_1('#client_master-grid').DataTable( {
			   	    responsive: {
					details: {
					    renderer: function ( api, rowIdx ) {
						var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
						    
							var header = $1_11_1( api.column( cell.column ).header() );
						    
							return  '<p style="color:#00A">'+header.text()+' : '+api.cell( cell ).data()+'</p>';
						} ).toArray().join('');
 
						return data ?    $1_11_1('<table/>').append( data ) :    false;
					    }
					}
				    },
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				],
				processing: true,
				serverSide: true,
				ajax: "client-master-grid.php", // json datasource
			    } );
				
				$1_11_1('.search-input-text').on( 'keyup click', function () {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
				
				
			} );
	</script>
	
	
		<script type="text/javascript" src="assets/js/resposive_datatable/export_jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_dataTables.buttons.min.js"></script>
		
		<script type="text/javascript" src="assets/js/resposive_datatable/export_buttons.flash.min.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_jszip.min.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_pdfmake.min.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_vfs_fonts.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_buttons.html5.min.js"></script>
		<script type="text/javascript" src="assets/js/resposive_datatable/export_buttons.print.min.js"></script>
	
	
		<style>
			select[multiple], select[size] {
				height: 23px;
				padding: 2px;
			}
			div.container {
			    max-width: 100%;
			    margin: 0 auto;
			}
			div.header {
			    margin: 0 auto;
			    max-width:100%;
			}	
			.dataTables_filter
			{
				float:left !important;
			}
			.dt-button.buttons-copy.buttons-html5,.dt-button.buttons-csv.buttons-html5,.dt-button.buttons-excel.buttons-html5,.dt-button.buttons-pdf.buttons-html5,.dt-button.buttons-print {
				padding: 5px;
				margin:2px;
			}

			</style>
					<div class="container">
											<table class="table datatable-basic display" id="client_master-grid" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Name 
														<input type="text" data-column="0"  class="search-input-text">
														</th>
														<th>Address
														<input type="text" data-column="1"  class="search-input-text">
														</th>
														<th>Phone No.
														<input type="text" data-column="2"  class="search-input-text">
														</th>
														<th>Email
														<input type="text" data-column="3"  class="search-input-text">
														</th>
														<th>Zone
														<input type="text" data-column="4"  class="search-input-text">
														</th>
														<th>Root Name 
														<input type="text" data-column="4"  class="search-input-text">
														</th>
														
													</tr>
												</thead>
												</table>
											</div>
										
                    
                    </div>
					
