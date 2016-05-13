<?php
if(isset($_POST['Action']) && $_POST['Action'] == "ManagePage")
{	
	$Page=$_POST['Page'];
	$PageNameId=$_POST['PageNameId'];
	
	if($PageNameId!="")
	{
	$Already="and PageNameId!='$PageNameId'";
	$MessageContent="updated";
	}
	else
	$MessageContent="added";
	$sql="select PageNameId from pagename where PageName='$Page' $Already ";
    $stmt = sqlsrv_query($conn, $sql);
	$count=sqlsrv_num_rows($stmt);
	
	if($Page=="")
	{
		$Message="All the fields are mandatory!!";
		$Type="error";
	}
	elseif($count>0)
	{
		$Message="This page is already added!!";
		$Type="error";	
	}
	elseif($TOKEN!=$RandomNumber)
	{
		$Message="Illegal data posted!!";
		$Type="error";
	}
	else
	{	
		if($PageNameId=="")
		{
		$query="insert into pagename(PageName) values ('$Page') ";
		}
		else
		{
		$query="update pagename set PageName='$Page'
				 where PageNameId='$PageNameId'";
		}
        $stmt = sqlsrv_query($conn, $query);
		$Message="Pagename $MessageContent successfully!!";
		$Type="success";
	}
	SetNotification($Message,$Type);
	if($PageNameId=="")
	header("Location:Permission");	
	else
	header("Location:Permission/UpdatePage/$PageNameId");	
}
$PageName="Permission";
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
					<?php $BreadCumb="Permission"; BreadCumb($BreadCumb); ?>			
				</div>
				<div class="heading-elements">
					<div class="heading-btn-group">	
						<?php BreadCumbSession($CURRENTSESSION); ?>			
					</div>
				</div>
			</div>		
		</div>
		<?php
					$UserType=isset($_GET['UniqueId']) ? $_GET['UniqueId'] : '';
					$CountAdded=$count=0;
					$ActionPage="";
					if($UserType!="" && $_GET['Action']=="SetPermission")
					{
						$sql = "SELECT Recid,Code,Descr FROM GenLookUp WHERE Recid='3' AND Descr = '$UserType'";
						
						$params = array();
						$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
						$stmt = sqlsrv_query( $conn, $sql , $params, $options );
						$count = sqlsrv_num_rows($stmt);
						if($count>0)
						{
							$row=sqlsrv_fetch_array($stmt);
							$UserTypeName=$row['Descr'];
							
							$ActionPage="Action.php";
							$ButtonContent="Save"; 
							$check77="select * from permission where UserType='$UserType' ";
							$check77 = sqlsrv_query( $conn, $check77 , $params, $options );
						    $count77 = sqlsrv_num_rows($check77);
							
							if($count77>0)
							{
								$row77=sqlsrv_fetch_array($check77);
								$PermissionString=$row77['PermissionString'];
								$PermissionString=explode(",",$PermissionString);		
								$CountAdded=count($PermissionString);
							}
						}
						$AddButton="Update Permission <a href=Permission.php><span class=\"cut-icon-plus-2 addbutton\"> Add Permission </span></a>";
					}
					else
						$AddButton="Set Permission";
						
						$sql = "select PageName,PageNameId from pagename order by PageName";
						$params = array();
						$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
						$stmt = sqlsrv_query( $conn, $sql , $params, $options );

						$count66=sqlsrv_num_rows($stmt);
						$ListOption=$ListAllPage="";
						if($count66>0)
						{
							while($row66=sqlsrv_fetch_array($stmt))
							{
								$ListPage=$row66['PageName'];
								$ListPageNameId=$row66['PageNameId'];
								$Selected="";
								if($CountAdded>0)
								{
								foreach($PermissionString as $k)
								{
									if($k==$ListPageNameId)
									{
										$Selected="selected";
										break;
									}
								}
								}
								$ListOption.="<option value=$ListPageNameId $Selected>$ListPage</option>";
								$Edit="<a href=Permission.php/?Action=UpdatePage&UniqueId=$ListPageNameId><span class=\"glyphicon glyphicon-edit\" title=\"Update\"></span></a>";
								$ListAllPage.="<tr>
													<td>$ListPage</td>
													<td>$Edit</td>
												</tr>";
							}
						}
						
						if($ActionPage=="")
						{
						  $ActionPage="ReportAction.php";
						  $ButtonContent="Get"; 
						}
				?>
		
		<div class="col-md-12">
		
		
		 <div class="col-md-12">
			    <div class="col-md-12">
							<!-- Basic layout-->
							<form class="form-horizontal" action="<?php echo $ActionPage; ?>" method="Post" name="SetPermission" id="SetPermission">
								<div class="panel panel-white">
									<div class="panel-heading">
										<h5 class="panel-title">Set Permission</h5>
										<div class="heading-elements">
											<ul class="icons-list">
												<li><a data-action="collapse"></a></li>
						                		                		
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										
										
										<div class="form-group">
											<label class="col-xs-2" for="normal">User Type:</label>
											<?php if($count>0 && $_GET['Action']=="SetPermission") { ?>
											<span class="span8"><b><?php echo $UserTypeName; ?></b></span> 
											<input type="hidden" name="UserType" value="<?php echo $UserType; ?>" readonly>
												<?php } else { ?>
											<div class="col-xs-7">
												<div class="col-lg-9">
												<?php
												GetCategoryValue('3','UserType',$UserType,'','','','',1,'');
												?>
											</div>
											</div>
											</div>
											<?php } ?>
												<?php if($count>0) { ?>
											<div class="form-group">
											<label class="col-lg-3 control-label" for="normal">Select Pages</label>
											<div class="col-lg-9">
												<select tabindex="1" name="PermissionSTR[]" id="PermissionSTR"  class="form-control select" style="width:100%;" multiple="multiple">
													<?php echo $ListOption; ?>
													
												</select>
											</div>
										</div>	<?php } ?>
											
											<div class="text-right">
											<input type="hidden" name="Action" value="SetPermission" readonly>
											<input type="hidden" name="RandomNumber" value="<?php echo $TOKEN; ?>" readonly>
											<?php $ButtonContent="Get"; ActionButton($ButtonContent,7); ?>
										</div>
										
									</div>
								</div>
							</form>
							<!-- /basic layout -->
				    </div>
		    </div>
		</div>
		<?php
		if($USERTYPE=="MasterUser") { 

				$Action=isset($_GET['Action']) ? $_GET['Action'] : '';
				$Id=isset($_GET['UniqueId']) ? $_GET['UniqueId'] : '';
				$PageButtonContentSet=$PageAddButton=$Page=$Table=$count1=$TableButtonContentSet=$TableAddButton=$UpdatePageNameId=$UpdateTableId="";
				if($Id!="" && $Action=="UpdatePage")
				{
					$query1="select * from pagename where PageNameId='$Id'";
					
					$params = array();
					$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$stmt = sqlsrv_query( $conn, $query1 , $params, $options );
					$count1=sqlsrv_num_rows($stmt);
					if($count1>0)
					{
						$row1=sqlsrv_fetch_array($stmt);
						$Page=$row1['PageName'];
						$PageButtonContentSet=1;
						$PageAddButton="Update <a href=Permission.php><span class=\"cut-icon-plus-2 addbutton\"></span></a>";
						$UpdatePageNameId=$Id;
					}
				}
				elseif($Id!="" && $Action=="UpdateTable")
				{
					$query1="select * from tablename where TableName='$Id'";
					$check1=mysqli_query($CONNECTION,$query1);
					$count1=mysqli_num_rows($check1);
					if($count1>0)
					{
						$row1=mysqli_fetch_array($check1);
						$Table=$row1['TableName'];
						$TableButtonContentSet=1;
						$TableAddButton="Update <a href=Permission><span class=\"cut-icon-plus-2 addbutton\"> Add</span></a>";
						$UpdateTableId=$Id;
					}
				}				
				if($PageButtonContentSet!=1)
					$PageAddButton="Add Page";		
				if($TableButtonContentSet!=1)
					$TableAddButton="Add Table";
				?>
		<div class="col-md-12">
		
		  <div class="col-md-6">
					<div class="panel panel-white">
							<div class="panel-heading">
								<h5 class="panel-title">Add Page</h5>
								
				                <div class="heading-elements">
									<ul class="icons-list">
			                			<li><a data-action="collapse"></a></li>
			                					                		
			                		</ul>
		                		</div>
							</div>
							
							
							<form class="form-horizontal" action="Action.php"  method="Post" name="ManagePage" id="ManagePage">
							
									    <div class="panel-body">
								            <div class="form-group">
											<label class="col-lg-3 control-label" for="MasterEntryValue">Page Name:</label>
											    <div class="col-lg-9">
												  <input type="text" class="form-control" placeholder="" tabindex="2" id="Page" name="Page" value="<?php echo $Page; ?>">
											    </div>
										    </div>  

                                            <div class="text-right">
											<input type="hidden" name="Action" value="ManagePage" readonly>
											<input type="hidden" name="RandomNumber" value="<?php echo $TOKEN; ?>" readonly>
											<?php if($count1>0) { echo "<input type=\"hidden\" name=\"PageNameId\" value=\"$UpdatePageNameId\" readonly>"; } ?>
											<?php ActionButton($PageAddButton,7); ?>
										    </div>
                                        </div>
							</form>				 
                                
<?php
						if($count66>0)
						{
						?>
							<table id="MasterEntryTable" class="table datatable-basic table-bordered table-striped table-hover">
									<thead>
								<tr>
									<th>Page Name</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php echo $ListAllPage; ?>
							</tbody>
							</table>
							<?php
						}
						?>
				    </div>
				</div>
	
		</div><?php } ?>

<script>
$('.select').select2();
</script>
<script type="text/javascript">
if($('table').hasClass('dynamicTable')){
		$('.dynamicTable').dataTable({
			"sPaginationType": "full_numbers",
			"bJQueryUI": false,
			"bAutoWidth": false,
			"bLengthChange": false,
			"fnInitComplete": function(oSettings, json) {
		      $('.dataTables_filter>label>input').attr('id', 'search');
		    }
		});
	}
$(document).ready(function() {

	

	
	
	$("#SetPermission").validate({
		ignore: 'input[type="hidden"]',
		rules: {
			UserType: {
				required: true,
			}
		},
		messages: {
			UserType: {
				required: "Please enter this field!!",
			}
		}   
	});
	$("#ManagePage").validate({
		rules: {
			Page: {
				required: true,
			}
		},
		messages: {
			Page: {
				required: "Please enter this field!!",
			}
		}   
	});
	$("#ManageTable").validate({
		rules: {
			Table: {
				required: true,
			}
		},
		messages: {
			Table: {
				required: "Please enter this field!!",
			}
		}   
	});
});
</script>    
<?php
include("Template/Footer.php");
?>