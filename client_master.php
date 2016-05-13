<?php
	$PageName="Productmaster";
	$TooltipRequired=1;
	$SearchRequired=1;
	$FormRequired=1;
	$TableRequired=1;
	require_once 'config.php';
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




				<!-- Content area -->
				<div class="content">
                   
					
					
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
						<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Client Master</h5>
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="collapse"></a></li>
									<li><a data-action="reload"></a></li>
									<li><a data-action="close"></a></li>
								</ul>
							</div>
						</div>

						<div class="panel-body">
					
											<table class="table datatable-basic display" id="client_master-grid" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Name 
														<input type="text" data-column="0"  class="search-input-text">
														</th>
														<th>Location
														<input type="text" data-column="1"  class="search-input-text">
														</th>
														<th>Address
														<input type="text" data-column="2"  class="search-input-text">
														</th>
														<th>Phone No.
														<input type="text" data-column="3"  class="search-input-text">
														</th>
														<th>Email
														<input type="text" data-column="4"  class="search-input-text">
														</th>
														<th>Zone
														<input type="text" data-column="5"  class="search-input-text">
														</th>
														<th>Root Name 
														<input type="text" data-column="6"  class="search-input-text">
														</th>
														
													</tr>
												</thead>
												</table>
											</div>
						</div>				
                    
                    </div>
					
