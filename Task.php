<?php
error_reporting(0);
$PageName="Task";
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
<?php


				$Action=isset($_GET['Action']) ? $_GET['Action'] : '';
				$TaskId=isset($_GET['TaskId']) ? $_GET['TaskId'] : '';
				$GetSupplierId=$SupplierList=$addquery=$ShowTransactionOfExpense=$RequestFor="";
				$SNo=0;
				
				if($TaskId!="")
				{
					$query43="select * from vtasks where vtasksid='$TaskId' ";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt = sqlsrv_query( $conn, $query43 , $params, $options );
					$count100 = sqlsrv_num_rows($stmt);
					
					if($count100>0 && $Action=="Delete")
					{
						
						$query40="delete from vtasks where vtasksid='$TaskId' ";
						$params = array();
						$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
						$stmt = sqlsrv_query( $conn, $query40 , $params, $options );
						header("Location:Task");	
					}
				}
				
				
				$check = "select * from staff where vuserid!='$USERID'";
				
				
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $check , $params, $options );
				$count = sqlsrv_num_rows($stmt);
				if($count>0)
				{
					while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
					{
						
						$ListStaffName=$row['StaffName'];	
						$SupplierId=$row['Staffid'];
						if($SupplierId==$GetSupplierId)
							$SupplierSelected="Selected";
						else
							$SupplierSelected="";
						$SupplierList.="<option value=$SupplierId>$ListStaffName</option>";
					}
				}	
				/* $q1 = "SELECT MAX(requestno) as user_id from request";
				$check23=mysqli_query($CONNECTION,$q1);
				$row23 = mysqli_fetch_array($check23);
				$next_auto_inc = $row23['user_id'] + 1; */
				
				?>
				
               
					
		<div id="content" class="clearfix">
    <div class="contentwrapper">  			
						
						
									<!-- header -->
        <div class="page-header">
			<div class="page-header-content">
			<?php DisplayNotification(); ?>
				<div class="page-title">
					<?php $BreadCumb="Assign Task"; BreadCumb($BreadCumb); ?>			
				</div>
				<div class="heading-elements">
					<div class="heading-btn-group">	
						<?php BreadCumbSession($CURRENTSESSION); ?>			
					</div>
				</div>
			</div>		
		</div>
		
		   <div class="col-md-12">
		
		
		    <div class="col-md-5">
			    <div class="col-md-12">
							<!-- Basic layout-->
							<form class="form-horizontal" action="Action.php" name="Task" id="Task" method="Post" enctype="multipart/form-data">
								<div class="panel panel-white">
									<div class="panel-heading">
										<h5 class="panel-title">Task</h5>
										<div class="heading-elements">
											<ul class="icons-list">
												<li><a data-action="collapse"></a></li>
						                		                		
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										
										
										<div class="form-group">
											<label class="col-lg-3 control-label" for="normal">Assign To:</label>
											<div class="col-lg-9">
												<select tabindex="1"  class="form-control select" style="width:100%;"  id="AssignTo" type="text" name="AssignTo" >
													<option selected="selected">Select</option> 
													<?php echo $SupplierList; ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label" for="Name">Task Name:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" placeholder="" tabindex="2" id="TaskName" name="TaskName" value="" />
											</div>
										</div> 
										<div class="form-group">
											<label class="col-lg-3 control-label" for="Name">Task Detail:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" placeholder="" tabindex="3" id="TaskDetail" name="TaskDetail" value="" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label" for="normal">Date:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control daterange-single" placeholder="" tabindex=""4 id="Date1"  name="Date1" readonly>
											</div>
										</div>                                        
                                         
										
										<div class="text-right">
											<input type="hidden" name="Action"  value="Task" readonly>
											<input type="hidden" name="RandomNumber" value="<?php echo $TOKEN; ?>" readonly>
											<input type="hidden" name="ExpenseAccountType" value="<?php echo $ExpenseAccount; ?>" readonly>
											<?php $ButtonContent="Add"; ActionButton($ButtonContent,10); ?>
										</div>
									</div>
								</div>
							</form>
							<!-- /basic layout -->
				    </div>

					<?php
					$qu = "select StaffName,Staffid from staff where vuserid='$USERID'";
					
					
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt = sqlsrv_query( $conn, $qu , $params, $options );
					$count123 = sqlsrv_num_rows($stmt);
					if($count123>0){
					$row44=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
					$TaskByName=$row44['StaffName'];
					$TaskBy=$row44['Staffid'];
					}
					
					$query45="Select * from vtasks t join staff s on t.vassigneeid=s.Staffid where t.vassignerid='$TaskBy'";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt19 = sqlsrv_query( $conn, $query45 , $params, $options );
					$DATA=array();
					$QA=array();
						
					while($row=sqlsrv_fetch_array($stmt19, SQLSRV_FETCH_ASSOC))
					{		
						$StaffName=$row['StaffName'];	
						$TaskId=$row['vtasksid'];
						$TaskName=$row['vtaskname'];
						$Taskinfo=$row['vtaskdetail'];
						$startdate=date("d-m-Y",$row['datetime']);
						$status=$row['vtaskstatus'];
						if($startdate!="")
						$TaskDetail="<a href=TaskDetail.php/?Action=Task&Id=$TaskId><span class=\"glyphicon glyphicon-list-alt\" title=\"Task Detail\"></span></a>";
						else
						$TaskDetail="";
						if($status=="New")
						$status="<span class=\"badge badge-success\">New<span>";
						elseif($status=="Canceled")
						$status="<span class=\"date badge badge-important\">Rejected</span>";
						else
						$status="<span class=\"badge badge-success\">Accepted<span>";
						
						
						$Delete="<a href=Task.php/?Action=Delete&TaskId=$TaskId><span class=\"icon-cross\" title=\"Delete\"></span></a>";
						$QA[]=array($StaffName,$TaskByName,$TaskName,$Taskinfo,$startdate,$status,$TaskDetail,$Delete);
						$Print3.="<tr class=\"odd gradeX\">
								<td>$TaskTo</td>
								<td>$StartDate</td>
								<td>$UptoDate</td>
								<td>$status</td>
							</tr>";
					}
					
					$DATA['aaData']=$QA;
					$fp = fopen('plugins/Data/data1.txt', 'w');
					fwrite($fp, json_encode($DATA));
					fclose($fp);	
					
					$queryown="Select * from vtasks t join staff s on t.vassigneeid=s.Staffid where t.vassigneeid='$TaskBy'";
					
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt444 = sqlsrv_query( $conn, $queryown , $params, $options );
					$DATA1=array();
					$QA1=array();
					
					
					while($row99=sqlsrv_fetch_array($stmt444, SQLSRV_FETCH_ASSOC))
					{			
						$TaskId=$row99['vtasksid'];
						$TaskName=$row99['vtaskname'];
						$Taskinfo=$row99['vtaskdetail'];
						$startdate=date("d-m-Y",$row99['datetime']);
						$status=$row99['vtaskstatus'];
						$TaskBy=$row99['vassignerid'];
						$query12 = "Select StaffName from staff Where Staffid='$TaskBy'";
						$params = array();
						$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
						$stmtfetch = sqlsrv_query( $conn, $query12 , $params, $options );
						$row12=sqlsrv_fetch_array($stmtfetch, SQLSRV_FETCH_ASSOC);
						$staffBy = $row12['StaffName'];
						
						
						if($startdate!="")
						$TaskDetail="<a href=TaskDetail.php/?Action=Task&Id=$TaskId><span class=\"glyphicon glyphicon-list-alt\" title=\"Task Detail\"></span></a>";
						else
						$TaskDetail="";
						if($status=="New")
						$status="<span class=\"badge badge-success\">New<span>";
						elseif($status=="Canceled")
						$status="<span class=\"date badge badge-important\">Rejected</span>";
						else
						$status="<span class=\"badge badge-success\">Accepted<span>";
						
						
						$Delete="<a href=DeletePopUp/DeleteExpense/$ListExpenseId data-toggle=\"modal1\" data-target=\"#myModal1\"><span class=\"icon-cross\"></span></a>";
						$QA1[]=array($staffBy,$TaskName,$Taskinfo,$startdate,$status,$TaskDetail);
						$Print3.="<tr class=\"odd gradeX\">
								<td>$TaskTo</td>
								<td>$StartDate</td>
								<td>$UptoDate</td>
								<td>$status</td>
							</tr>";
					}
					$DATA1['aaData']=$QA1;
					$fp = fopen('plugins/Data/data2.txt', 'w');
					fwrite($fp, json_encode($DATA1));
					fclose($fp);
					
					?>
                       
		
		
		
		
		
		
		    </div>
			<!--table-->
			
			    <div class="col-md-12">
					<div class="panel panel-white">
							<div class="panel-heading">
								<h5 class="panel-title">Define Task List</h5>
								<div class="heading-elements">
							<ul class="icons-list">
								<li><a data-action="collapse"></a></li>
								<?php if($count>0) { ?>
								<li><div class="PrintClass">
									<form method="post" action="Print" target="_blank">
									<input type="hidden" name="Action" value="Print" readonly>
									<input type="hidden" name="PrintCategory" value="PrintCategory" readonly>
									<input type="hidden" name="SessionName" value="PrintRegistrationList" readonly>
									<input type="hidden" name="HeadingName" value="PrintRegistrationHeading" readonly>
									<button class="glyphicon glyphicon-print" title="Print Registration List"></button>
									</form>
								</div></li>
								<?php } ?>
							</ul>
								</div>
							</div>
<?php 
								$Print1="<table id=\"ExpenseTable\" class=\"table datatable-basic table-bordered table-striped table-hover\">
									<thead>
										<tr>
											
											<th>Task To</th>
											<th>Task by</th>
											<th>Task Name</th>
											<th>Task Detail</th>
											<th>Date</th>
											<th>Status</th>";
											echo $Print1;
											echo "<th><span class=\"glyphicon glyphicon-list-alt\" title=\"Task Detail\"></span></th>";
											echo "<th><span class=\"icon-cross\"></span></th>";
											$Print2="</tr>
													</thead>
													<tbody>";
											echo $Print2;
											$Print4="</tbody>
													</table>";
											echo $Print4;
													
											//$Print2 $Print3 $Print4
												$PrintRegistrationList="$Print1 $Print2 $Print3 $Print4";
												$_SESSION['PrintRegistrationList']=$PrintRegistrationList;
												$PrintHeading="List of Expense";
												$_SESSION['PrintRegistrationHeading']=$PrintHeading;
												$_SESSION['PrintCategory']="Registration";
												
							?>
				    </div>
					
					
					
					<div class="panel panel-white">
							<div class="panel-heading">
								<h5 class="panel-title">My Task List</h5>
								<div class="heading-elements">
							<ul class="icons-list">
								<li><a data-action="collapse"></a></li>
								<?php if($count>0) { ?>
								<li><div class="PrintClass">
									<form method="post" action="Print" target="_blank">
									<input type="hidden" name="Action" value="Print" readonly>
									<input type="hidden" name="PrintCategory" value="PrintCategory" readonly>
									<input type="hidden" name="SessionName" value="PrintRegistrationList" readonly>
									<input type="hidden" name="HeadingName" value="PrintRegistrationHeading" readonly>
									<button class="glyphicon glyphicon-print" title="Print Registration List"></button>
									</form>
								</div></li>
								<?php } ?>
							</ul>
								</div>
							</div>
							<?php 
								$Print1="<table id=\"ExpenseTabletwo\" class=\"table datatable-basic table-bordered table-striped table-hover\">
									<thead>
										<tr>
											
											<th>Task by</th>
											<th>Task Name</th>
											<th>Task Detail</th>
											<th>Date</th>
											<th>Status</th>";
											echo $Print1;
											echo "<th><span class=\"glyphicon glyphicon-list-alt\" title=\"Task Detail\"></span></th>";
											$Print2="</tr>
													</thead>
													<tbody>";
											echo $Print2;
											$Print4="</tbody>
													</table>";
											echo $Print4;
													
											//$Print2 $Print3 $Print4
												$PrintRegistrationList="$Print1 $Print2 $Print3 $Print4";
												$_SESSION['PrintRegistrationList']=$PrintRegistrationList;
												$PrintHeading="List of Expense";
												$_SESSION['PrintRegistrationHeading']=$PrintHeading;
												$_SESSION['PrintCategory']="Registration";
												
							?>
				    </div>
				</div>
			
			
			
			
			
			
			<!--/table-->
	    </div>
	</div> 
</div>	  
            
		
		

<script>
$('.select').select2();
</script>						
	
<script type="text/javascript">
$('#ExpenseTable').dataTable({
		"sPaginationType": "two_button",
		"bJQueryUI": false,
		"bAutoWidth": false,
		"bLengthChange": false,  
		"bProcessing": true,
		"bDeferRender": true,
		"sAjaxSource": "plugins/Data/data1.txt",
		"fnInitComplete": function(oSettings, json) {
		  $('.dataTables_filter>label>input').attr('id', 'search');
			$('#myModal').modal({ show: false});
			$('#myModal').on('hidden', function () {
				console.log('modal is closed');
			})
			$("a[data-toggle=modal]").click(function (e) {
			lv_target = $(this).attr('data-target');
			lv_url = $(this).attr('href');
			$(lv_target).load(lv_url);
			});	
		}
	});
	
	$('#ExpenseTabletwo').dataTable({
		"sPaginationType": "two_button",
		"bJQueryUI": false,
		"bAutoWidth": false,
		"bLengthChange": false,  
		"bProcessing": true,
		"bDeferRender": true,
		"sAjaxSource": "plugins/Data/data2.txt",
		"fnInitComplete": function(oSettings, json) {
		  $('.dataTables_filter>label>input').attr('id', 'search');
			$('#myModal1').modal({ show: false});
			$('#myModal1').on('hidden', function () {
				console.log('modal is closed');
			})
			$("a[data-toggle=modal]").click(function (e) {
			lv_target = $(this).attr('data-target');
			lv_url = $(this).attr('href');
			$(lv_target).load(lv_url);
			});	
		}
	});
$(document).ready(function() {

	
	
		
	if($('#Date2').length) {
	$('#Date2').datetimepicker({ yearRange: "-10:+10", dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true });
	}
	if($('#RemainingDOP').length) {
	$('#RemainingDOP').datetimepicker({ yearRange: "-10:+10", dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true });
	}
	if($('#Date1').length) {
	$('#Date1').datetimepicker({ yearRange: "-10:+10", dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true });
	}
	$("input, textarea, select").not('.nostyle').uniform();
	
	$("#AssignTo").select2();
	$('#AssignTo').select2({placeholder: "Select"});
	$("#RequestFor").select2();
	$('#RequestFor').select2({placeholder: "Select"});
	
	$("#Account").select2();
	$('#Account').select2({placeholder: "Select"});
	$("#RemainingAccount").select2();
	$('#RemainingAccount').select2({placeholder: "Select"});
	$("#Expense").validate({
		ignore: 'input[type="hidden"]',
		rules: {
			
			RequestTo: {
				required: true,
			},
			RequestFor: {
				required: true,
				remote: "RemoteValidation?Action=IsAmountWithoutZero&Id=Amount"
			},
			Date1: {
				required: true,
			},
			AmountPaid: {
				required: "#Payment:checked",
				remote: "RemoteValidation?Action=IsAmountWithoutZero&Id=AmountPaid"
			},
			Account: {
				required: "#Payment:checked",
			},
			Date2: {
				required: "#Payment:checked",
			}
		},
		messages: {
			
			RequestTo: {
				required: "Please select this!!",
			},
			RequestFor: {
				required: "Please enter this!!",
			},
			Date1: {
				required: "Please enter this!!",
			},
			AmountPaid: {
				required: "Please enter this!!",
				remote: jQuery.format("Numeric & greater than zero!!"),
			},
			Account: {
				required: "Please select this!!",
			},
			Date2: {
				required: "Please enter this!!",
			}
		}   
	});
	$("#ExpenseMakePayment").validate({
		ignore: 'input[type="hidden"]',
		rules: {
			RemainingAmountPaid: {
				required : true,
				remote: "RemoteValidation?Action=IsAmountWithoutZero&Id=RemainingAmountPaid"
			},
			RemainingAccount: {
				required : true,
			},
			RemainingDOP: {
				required : true,
			},
			RemainingRemarks: {
				required : true,
			}
		},
		messages: {
			RemainingAmountPaid: {
				required: "Please enter this!!",
				remote: jQuery.format("Numeric & greater than zero!!"),
			},
			RemainingAccount: {
				required: "Please select this!!",
			},
			RemainingDOP: {
				required: "Please enter this!!",
			},
			RemainingRemarks: {
				required: "Please enter this!!",
			}
		}   
	});
});
</script>	
<script>	
					$('.daterange-single').daterangepicker({
        singleDatePicker: true,
        
    });</script>	
<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>	    
<?php
include("Template/Footer.php");
?>