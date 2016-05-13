<?php
error_reporting(0);
$PageName="TaskDetail";
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
$Action=$_POST['Action']; 

if($Action=="TaskDetail"){
	
	$SubTaskName=$_POST['SubTaskName'];
	$SubTaskDetail=$_POST['SubTaskDetail'];
	$TaskId=$_POST['FollowUpUniqueId'];
	$TaskDetailStatus=$_POST['Response'];
	$TaskDetailId=$_POST['FollowUpId'];
	$Assignerid=$_POST['Assigner'];
	$Assigneeid=$_POST['Assignee'];
	$DOE=strtotime($Date);
	
	
	if($SubTaskName!="" && $SubTaskDetail!="" && $TaskDetailStatus=="" )
	{
		$Message="Please fill One Task At a Time And Select Status!!";
		$Type="error";
	}
	else
	{	$Added="";
		if($TaskDetailId == "") {
			echo "Null";
			
		if($TaskId!="" && $SubTaskName!=""){
		$query756="INSERT INTO vsubtasks(vtaskid,vsubtaskname,vsubtaskdetails,vsubtaskstatus,vsubassingnerid,vsubassigneeid,vdatetime)  values('$TaskId','$SubTaskName','$SubTaskDetail','$TaskDetailStatus','$Assignerid','$Assigneeid','$DOE')";
		$Added="Added";
		}else
		{
			$Message="Sorry You can't Add This Task.";
			$Type="error";
		}
		} 
		else{
			if($TaskId!="" && $SubTaskName!=""){
			$query756="update vsubtasks set vsubtaskname='$SubTaskName',vsubtaskdetails='$SubTaskDetail',vsubtaskstatus='$TaskDetailStatus' where vsubtaskid='$TaskDetailId'";
			$Added="Updated";
		}else
		{
			$Message="Sorry You can't Edit This Task.";
			$Type="error";
		}
		}
		
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt = sqlsrv_query( $conn, $query756 , $params, $options );
		$Message="Task $Added successfully!!";
		$Type="success";
	}
	SetNotification($Message,$Type);
	if($TaskId=="")
	header("Location:TaskDetail.php/?Action=Task");	
	else
	header("Location:TaskDetail.php/?Act=Task&Tid=$TaskId");	
}else {
	
	
}
 
 
 
 
				$FollowUpType=$_GET['Action'];
				$FollowUpUniqueId=$_GET['Id'];
				$FollowUpId=$_GET['FId'];
				$FAction=$_GET['FAction'];
				
				$ButtonContentSet=$ButtonContent=$AddButton=$table=$field=$fieldStatus=$Name=$GR=$FId=$NextFollowUpDate=$DOF=$Remarks=$Address=$ResponseDetail=$count20=$count10="";
		
				
				$query20="Select * from vtasks t join staff s on t.vassigneeid=s.Staffid where t.vtasksid='$FollowUpUniqueId'";
			
				$params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $query20 , $params, $options );
				$count = sqlsrv_num_rows($stmt);
				
				
				$row20=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
				$Name=$row20['StaffName'];
				$GR=$row20['StaffMobile'];
				$Assigner=$row20['vassignerid'];
				$Assignee=$row20['vassigneeid'];
				
				$Q20="Select vassignerid from vtasks t join staff s on t.vassignerid=s.Staffid where t.vtasksid='$FollowUpUniqueId'";
				$stmt20 = sqlsrv_query( $conn, $Q20 , $params, $options );
				$count120 = sqlsrv_num_rows($stmt20);
				$row120=sqlsrv_fetch_array($stmt20, SQLSRV_FETCH_ASSOC);
				$Vassi=$row120['vassignerid'];
				
				$Q22="Select Staffid from staff where vuserid='$USERID'";
				$stmt22 = sqlsrv_query( $conn, $Q22 , $params, $options );
				$count122 = sqlsrv_num_rows($stmt22);
				$row122=sqlsrv_fetch_array($stmt22, SQLSRV_FETCH_ASSOC);
				$Staffi=$row122['Staffid'];
				
				
					
				if($FollowUpId!="")
				{	
					
					$query10="select * from vsubtasks where vsubtaskid='$FollowUpId' and vtaskid='$FollowUpUniqueId'";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt = sqlsrv_query( $conn, $query10 , $params, $options );
					
					$count10 = sqlsrv_num_rows($stmt);
					if($count10>0 && $FAction=="Update")
					{
						
						
						$row10=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
						
							$Vstatus=$row10['vsubtaskstatus'];
							$taskname=$row10['vsubtaskname'];
							$taskdetails=$row10['vsubtaskdetails'];
						
						
						
						$ButtonContent="Update";
						$UpdateFollowUpId=$FId;
						$ButtonContentSet=1;
						$AddButton="Update <a href=TaskDetail/Task/$FollowUpUniqueId><span class=\"cut-icon-plus-2 addbutton\"> Update</span></a>";
					}
					elseif($count10>0 && $FAction=="Delete")
					{
						$DeleteFollowUpName=$row20['Name'];	
					}
				}
				
				if($ButtonContentSet!=1)
				{
					$ButtonContent="Add";
					$AddButton="";
				}
				
				
				?>
				
				<div id="content" class="clearfix">
    <div class="contentwrapper">  
	<?php DisplayNotification(); ?>	
				<!-- header -->
        <div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<?php $BreadCumb="TaskDetail"; BreadCumb($BreadCumb); ?>			
				</div>
				<div class="heading-elements">
					<div class="heading-btn-group">	
						<?php BreadCumbSession($CURRENTSESSION); ?>			
					</div>
				</div>
			</div>		
		</div>
	    <div class="col-md-12">
		<?php if($Vassi==$Staffi){ ?>
		    <div class="col-md-5">
			    <div class="col-md-12">
							<!-- Basic layout-->
							<form class="form-horizontal" action=""  method="Post" name="TaskDetail" id="TaskDetail" enctype="multipart/form-data">
								<div class="panel panel-white">
									<div class="panel-heading">
										<h5 class="panel-title">Task Detail <?php echo "$Name ($GR) "; ?></h5>
										<div class="heading-elements">
											<ul class="icons-list">
												<li><a data-action="collapse"></a></li>
						                		                		
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">

										<div class="form-group">
											<label class="col-lg-3 control-label" for="Name">SubTask Name:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" placeholder="" tabindex="2" id="SubTaskName" name="SubTaskName" value="<?php echo $taskname; ?>" />
											</div>
										</div> 
										<div class="form-group">
											<label class="col-lg-3 control-label" for="Name">SubTask Detail:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" placeholder="" tabindex="3" id="SubTaskDetail" name="SubTaskDetail" value="<?php echo $taskdetails; ?>" />
											</div>
										</div> 	
                                        <div class="form-group">
											<label class="col-lg-3 control-label" for="Response">Status:</label>
											<div class="col-lg-9">
												<select tabindex="1"  class="form-control select" style="width:100%;"  name="Response" id="Response" >
													<option>Select</option>
													<option value="New"<?php if($Vstatus == 'New')echo 'selected';?>>New</option>
												<option value="Process"<?php if($Vstatus == 'Process')echo 'selected';?>>Process</option>
												<option value="Completed"<?php if($Vstatus == 'Completed')echo 'selected';?>>Completed</option>
												</select>
											</div>
										</div>
										  
										
										<div class="text-right">
											<input type="hidden" name="Action" value="TaskDetail" readonly>
											<input type="hidden" name="RandomNumber" value="<?php echo $TOKEN; ?>" readonly>
											<input type="hidden" name="FollowUpId" value="<?php echo $FollowUpId; ?>" readonly>
											<input type="hidden" name="FollowUpUniqueId" value="<?php echo $FollowUpUniqueId; ?>" readonly>
											<input type="hidden" name="Assigner" value="<?php echo $Assigner; ?>" readonly>
											<input type="hidden" name="Assignee" value="<?php echo $Assignee; ?>" readonly>
										   <?php ActionButton($ButtonContent,5); ?>
										</div>
									</div>
								</div>
							</form>
							<!-- /basic layout -->
				    </div>

		    </div>
		<?php } ?>
			<?php
					
				
					$query300="select * from vsubtasks where vtaskid='$FollowUpUniqueId'";
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt = sqlsrv_query( $conn, $query300 , $params, $options );
					$DATA=array();
					$QA=array();
					
					
					while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
					{
						$Task=$row['vsubtaskname'];	
						$TaskDetail=$row['vsubtaskdetails'];
						$Status=$row['vsubtaskstatus'];	
						$TaskDetailsId=$row['vsubtaskid'];	
						$Edit="<a href=TaskDetail.php/?Action=Task&Id=$FollowUpUniqueId&FAction=Update&FId=$TaskDetailsId><span class=\"glyphicon glyphicon-edit\" title=\"Update\"></span></a>";
						$Delete="<a href=TaskDetail/$FollowUpUniqueId/Delete/$TaskDetailsId><span class=\"icomoon-icon-cancel tip\" title=\"Delete\"></span></a>";
						$QA[]=array($Task,$TaskDetail,$Status,$Edit);
					}
					$DATA['aaData']=$QA;
					$fp = fopen('plugins/Data/data5.txt', 'w');
					fwrite($fp, json_encode($DATA));
					fclose($fp);
					?>
			<!--table-->
			
			    <div class="col-md-7">
					<div class="panel panel-white">
							<div class="panel-heading">
								<h5 class="panel-title">Task List of <?php echo "$Name ($GR)"; ?></h5>
								<div class="heading-elements">
									<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                					                		
			                		</ul>
		                		</div>
							</div>

							<table id="FollowUpTable" class="table datatable-basic table-bordered table-striped table-hover">
								<thead>
									<tr>
										
										<th> Task</th>
										<th>Task Detail</th>
										<th>Status</th>
									
										<?php if($Vassi==$Staffi){ ?>
						
						
										<th><i class="glyphicon glyphicon-edit"></i></th>
										<?php } ?>					
									</tr>
								</thead>
								<tbody>														
								</tbody>
							</table>
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
	$('#FollowUpTableeeee').dataTable({
		"sPaginationType": "two_button",
		"bJQueryUI": false,
		"bAutoWidth": false,
		"bLengthChange": false,  
		"bProcessing": true,
		"bDeferRender": true,
		"sAjaxSource": "plugins/Data/data10.txt",
		"fnInitComplete": function(oSettings, json) {
		  $('.dataTables_filter>label>input').attr('id', 'search');
		}
	});
$('#FollowUpTable').dataTable({
		"sPaginationType": "two_button",
		"bJQueryUI": false,
		"bAutoWidth": false,
		"bLengthChange": false,  
		"bProcessing": true,
		"bDeferRender": true,
		"sAjaxSource": "plugins/Data/data5.txt",
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
$(document).ready(function() {
	
	if($('#DOF').length) {
	$('#DOF').datetimepicker({ dateFormat: 'dd-mm-yy' });
	}
	$("#DefineTask").select2();
	$('#DefineTask').select2({placeholder: "Select"});
	$("#Response").select2();
	$('#Response').select2({placeholder: "Select"});
	if($('#NextFollowUpDate').length) {
	$('#NextFollowUpDate').datetimepicker({ dateFormat: 'dd-mm-yy' });
	}
	$("input, textarea, select").not('.nostyle').uniform();
	$("#ManageFollowUp").validate({
		rules: {
			ResponseDetail: {
				required: true,
			},
			DOF: {
				required: true,
			}
		},
		messages: {
			ResponseDetail: {
				required: "Please enter response!!",
			},
			DOF: {
				required: "Please select date!!",
			}
		}   
	});
	$("#DeleteFollowUp").validate({
		rules: {
			Password: {
				required: true,
			}
		},
		messages: {
			Password: {
				required: "Please enter this!!",
			}
		}   
	});
});
</script>    
<?php
include("Template/Footer.php");
?>