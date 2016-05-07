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
			   var dataTable =  $1_11_1('#productorder-grid').DataTable( {
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
				ajax: "productorder-grid.php?StockNo=<?php echo $_REQUEST['id'];?>", // json datasource
			    } );
				
				$1_11_1('.search-input-text').on( 'keyup click', function () {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
				
				
			} );
	</script>
	
	<script type="text/javascript" language="javascript" >
			$1_11_1(document).ready(function() {
			
			$('#productmaster-head-1').click(function(){
				 var dataTable =  $1_11_1('#productsales-grid').DataTable( {
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
				ajax: "productsales-grid.php?StockNo=<?php echo $_REQUEST['id'];?>", // json datasource
			    } );
				
				$1_11_1('.search-input-text').on( 'keyup click', function () {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
			 });
			
			$('#productmaster-head-2').click(function(){
				 var dataTable =  $1_11_1('#productprise-grid').DataTable( {
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
				ajax: "productprise-grid.php?StockNo=<?php echo $_REQUEST['id'];?>", // json datasource
			    } );
				
				$1_11_1('.search-input-text').on( 'keyup click', function () {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
			 });
			  
				
				
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
			.dt-buttons { float:right;margin-top:10px;}
			#productorder-grid .search-input-text { width:90%;}
			
			table.dataTable th.sorting_asc, table.dataTable th.sorting { padding:10px 0;}
			
			.dataTable thead .sorting:before, .dataTable thead .sorting:after, .dataTable thead .sorting_asc:after, .dataTable thead .sorting_desc:after, .dataTable thead .sorting_asc_disabled:after, .dataTable thead .sorting_desc_disabled:after {top:65%;}

			</style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			

			<!-- Main content -->
			<div class="content-wrapper">

				
				<!-- Content area -->
				<div class="content">

		            <!-- Clickable title -->
		            
		            <!-- /clickable title -->
                    
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Item History</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                	</ul>
		                	</div>
						</div>

	                	<form class="stepy-clickable" name="productmaster" id="productmaster" action="#">
							<fieldset title="1">
								<legend class="text-semibold">Order Detail</legend>

								<div class="row">
									<div class="panel">
										<div class="panel-body">
											<div class="row">
											<table class="table datatable-basic display" id="productorder-grid" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Order No.
														<input type="text" data-column="0"  class="search-input-text form-control">
														</th>
														<th>Order Name
														<input type="text" data-column="1"  class="search-input-text form-control">
														</th>
														<th>Order No Prefix
														<input type="text" data-column="2"  class="search-input-text form-control">
														</th>
														<th>Order Date
														<input type="text" data-column="3"  class="search-input-text form-control">
														</th>
														<th>Quantity
														<input type="text" data-column="4"  class="search-input-text form-control">
														</th>
														<th class="text-center">Rate 
														<input type="text" data-column="5"  class="search-input-text form-control">
														</th>
														<th>Net Value
														<input type="text" data-column="6"  class="search-input-text form-control">
														</th>
														
													</tr>
												</thead>
												</table>
											</div>
										</div>
									</div>
								</div>



							</fieldset>

							<fieldset title="2">
								<legend class="text-semibold">Sales Detail</legend>

								<div class="row">
									<div class="panel">
										<div class="panel-body">
											<div class="container">
											<table class="table datatable-basic display" id="productsales-grid" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Order No.
														<input type="text" data-column="0"  class="search-input-text">
														</th>
														<th>Order Name
														<input type="text" data-column="1"  class="search-input-text">
														</th>
														<th>Order No Prefix
														<input type="text" data-column="2"  class="search-input-text">
														</th>
														<th>Order Date
														<input type="text" data-column="3"  class="search-input-text">
														</th>
														<th>Quantity
														<input type="text" data-column="4"  class="search-input-text">
														</th>
														<th class="text-center">Rate 
														<input type="text" data-column="5"  class="search-input-text">
														</th>
														<th>Net Value
														<input type="text" data-column="6"  class="search-input-text">
														</th>
														
													</tr>
												</thead>
												</table>
											</div>
											
										</div>
									</div>
								</div>
							</fieldset>

							<fieldset title="3">
								<legend class="text-semibold">Price</legend>

                                <div class="row">
									<div class="panel">
										<div class="panel-body">
											
										
										
											<div class="container">
											<table class="table datatable-basic display" id="productprise-grid" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Date
														<input type="text" data-column="0"  class="search-input-text">
														</th>
														<th>Old Prise
														<input type="text" data-column="1"  class="search-input-text">
														</th>
														<th>New Prise
														<input type="text" data-column="2"  class="search-input-text">
														</th>
														<th>Brand
														<input type="text" data-column="3"  class="search-input-text">
														</th>
														<th>Category
														<input type="text" data-column="4"  class="search-input-text">
														</th>
														
													</tr>
												</thead>
												</table>
											</div>
										
										</div>
									</div>
								</div>
							</fieldset>

							<fieldset title="4">
								<legend class="text-semibold">Sales Man</legend>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>WEIGHT / UNIT:</label>
			                                <div class="row">
                                                <div class="col-md-6"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                                <div class="col-md-2"><label>K.G.</label></div>
                                                <div class="col-md-4"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                            </div>
		                                </div>
                                        
                                        <div class="form-group">
											<label>PIECES / CARTON:</label>
			                                <div class="row">
                                                <div class="col-md-6"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                                <div class="col-md-2"><label>NOS.</label></div>
                                                <div class="col-md-4"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                            </div>
		                                </div>
                                        
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>WEIGHT / CARTON:</label>
			                                <div class="row">
                                                <div class="col-md-6"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                                <div class="col-md-2"><label>NOS.</label></div>
                                                <div class="col-md-4"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                            </div>
		                                </div>
                                        
                                        <div class="form-group">
											<label>VOLUME OF CARTON:</label>
			                                <div class="row">
                                                <div class="col-md-6"><input type="text" name="basic" class="form-control" required="required" placeholder=""></div>
                                                <div class="col-md-2"><label>CU.FT.</label></div>
                                                <div class="col-md-4"><a href="#" id="calcfunc">CALC</a></div>
                                                <div id="background_calc" style="display: none;"><!-- Main background -->

                                                <div id="result"></div>

                                                <div id="main">
                                                <div id="first-rows">
                                                <button class="del-bg" id="delete">Del</button>
                                                <button value="%" class="btn-style operator opera-bg fall-back">%</button>
                                                <button value="+" class="btn-style opera-bg value align operator">+</button>
                                                </div>

                                                <div class="rows">
                                                <button value="7" class="btn-style num-bg num first-child">7</button>
                                                <button value="8" class="btn-style num-bg num">8</button>
                                                <button value="9" class="btn-style num-bg num">9</button>
                                                <button value="-" class="btn-style opera-bg operator">-</button>
                                                </div>

                                                <div class="rows">
                                                <button value="4" class="btn-style num-bg num first-child">4</button>
                                                <button value="5" class="btn-style num-bg num">5</button>
                                                <button value="6" class="btn-style num-bg num">6</button>
                                                <button value="*" class="btn-style opera-bg operator">x</button>
                                                </div>

                                                <div class="rows">
                                                <button value="1" class="btn-style num-bg num first-child">1</button>
                                                <button value="2" class="btn-style num-bg num">2</button>
                                                <button value="3" class="btn-style num-bg num">3</button>
                                                <button value="/" class="btn-style opera-bg operator">/</button>
                                                </div>

                                                <div class="rows">
                                                <button value="0" class="num-bg zero" id="delete">0</button>
                                                <button value="." class="btn-style num-bg period fall-back">.</button>
                                                <button value="=" id="eqn-bg" class="eqn align">=</button>
                                                </div>

                                                </div>

                                                </div>
                                            </div>
		                                </div>
                                        
                                        
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Additional information:</label>
		                                    <textarea name="additional-info" rows="5" cols="5" placeholder="If you want to add any info, do it here." class="form-control"></textarea>
	                                    </div>
									</div>
								</div>
							</fieldset>

							<button type="submit" class="btn btn-primary stepy-finish">Submit <i class="icon-check position-right"></i></button>
						</form>
		            </div>


























		            <!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</div>
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
