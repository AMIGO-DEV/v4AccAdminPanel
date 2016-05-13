<?php
include("Include.php");
$Action=$_GET['Action'];
$UniqueId=$_GET['UniqueId'];


if($Action=="SetSession")
{
	foreach($SCHOOLSESSION as $SchoolSession)
	{
		if($UniqueId==$SchoolSession)
		$CorrectSession=1;
		$Message="Wrong session!!";
		$Type=error;
	}
	
	if($CorrectSession==1)
	{
		mysqli_query($CONNECTION,"update generalsetting set CurrentSession='$UniqueId' ");
		$Message="Session set as $UniqueId successfully!!";
		$Type=success;
		$_SESSION['CURRENTSESSION']=$UniqueId;
	}
	$LastPage=$_SESSION['LastPage'];
	unset($_SESSION['LastPage']);
	SetNotification($Message,$Type);
	header("Location:$LastPage");
	exit();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////
elseif($Action=="DeleteSiblingInformation")
{
	$UniqueId=$_GET['UniqueId'];
	
	$query="Select RegistrationId from sibling where SiblingId='$UniqueId' ";
	$check=mysqli_query($CONNECTION,$query);
	$count=mysqli_num_rows($check);
	if($count>0)
	{
		$row=mysqli_fetch_array($check);
		$RegistrationId=$row['RegistrationId'];
		
		$query1="select Status from registration where RegistrationId='$RegistrationId' and Status!='Deleted' ";
		$check1=mysqli_query($CONNECTION,$query1);
		$count1=mysqli_num_rows($check1);
	}
	
	if($UniqueId=="")
	{
		$Message="All the fields are mandatory!!";
		$Type=error;
	}	
	elseif($count==0 || $count1==0)
	{	
		$Message="This is not a valid URL!!";
		$Type=error;	
	}
	else
	{
		mysqli_query($CONNECTION,"delete from sibling where SiblingId='$UniqueId' ");
		$Message="Deleted successfully!!";
		$Type=success;
	}
	SetNotification($Message,$Type);
	header("Location:Registration/$RegistrationId");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////
elseif($Action=="DeleteStudentQualification" || $Action=="DeleteStaffQualification")
{
	$UniqueId=$_GET['UniqueId'];
	
	if($Action=="DeleteStudentQualification")
	{
		$query="Select UniqueId from qualification where QualificationId='$UniqueId' and Type='Student' ";
		$check=mysqli_query($CONNECTION,$query);
		$count=mysqli_num_rows($check);
		if($count>0)
		{
			$row=mysqli_fetch_array($check);
			$RegistrationId=$row['UniqueId'];
			
			$query1="select Status from registration where RegistrationId='$RegistrationId' and Status!='Deleted' ";
			$check1=mysqli_query($CONNECTION,$query1);
			$count1=mysqli_num_rows($check1);
		}
	}
	elseif($Action=="DeleteStaffQualification")
	{
		$query="Select UniqueId from qualification where QualificationId='$UniqueId' and Type='Staff' ";
		$check=mysqli_query($CONNECTION,$query);
		$count=mysqli_num_rows($check);
		if($count>0)
		{
			$row=mysqli_fetch_array($check);
			$StaffId=$row['UniqueId'];
			
			$query1="select StaffStatus from staff where StaffId='$StaffId' and StaffStatus='Active' ";
			$check1=mysqli_query($CONNECTION,$query1);
			$count1=mysqli_num_rows($check1);
		}	
	}
	
	if($UniqueId=="")
	{
		$Message="All the fields are mandatory!!";
		$Type=error;
	}	
	elseif($count==0 || $count1==0)
	{	
		$Message="This is not a valid URL!!";
		$Type=error;	
	}
	else
	{
		$query3="delete from qualification where QualificationId='$UniqueId' ";
		mysqli_query($CONNECTION,$query3);
		$Message="Deleted successfully!!";
		
		$Type=success;
	}
	SetNotification($Message,$Type);
	//if($Action=="DeleteStudentQualification")
	header("Location:Registration");	
	//else
	//header("Location:ManageStaff/$UniqueId");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////
elseif($Action=="DeleteDocument")
{
	$PhotoId=$_GET['UniqueId'];
	
	$query="Select PhotoId,Detail,UniqueId,Path from photos where PhotoId='$PhotoId' ";
	$check=mysqli_query($CONNECTION,$query);
	$count=mysqli_num_rows($check);
	if($count>0)
	{
		$row=mysqli_fetch_array($check);
		$Path=$row['Path'];
		$Detail=$row['Detail'];
		$UniqueId=$row['UniqueId'];
		if($Detail=="StudentDocuments")
		$ReturnURL="Registration/$UniqueId";
		else
		$ReturnURL="ManageStaff/$UniqueId";
		
		$ThumbnailPath="$PHOTOPATH/thumbnail-$Path";
		$Path="$PHOTOPATH/$Path";
		
		if (file_exists($Path) && $Path!="")
		unlink($Path);
		if (file_exists($ThumbnailPath) && $ThumbnailPath!="")
		unlink($ThumbnailPath);
		
		$query1="delete from photos where PhotoId='$PhotoId' ";
		mysqli_query($CONNECTION,$query1);
	}
	
	if($PhotoId=="")
	{
		$Message="All the fields are mandatory!!";
		$Type=error;
	}	
	elseif($count==0)
	{	
		$Message="This is not a valid URL!!";
		$Type=error;	
	}
	else
	{
		$Message="Deleted successfully!!";
		$Type=success;
	}
	if($ReturnURL=="")
	$ReturnURL="DashBoard";
	SetNotification($Message,$Type);
	header("Location:$ReturnURL");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////

elseif($Action=="DeleteMemories")
{
	$PhotoId=$_GET['UniqueId'];
	
	$query="Select memoriesid,Detail,UniqueId,Path from memories where memoriesid='$PhotoId' ";
	$check=mysqli_query($CONNECTION,$query);
	$count=mysqli_num_rows($check);
	if($count>0)
	{
		$row=mysqli_fetch_array($check);
		$Path=$row['Path'];
		$Detail=$row['Detail'];
		$UniqueId=$row['UniqueId'];
		if($Detail=="StudentMemories")
		$ReturnURL="Registration/$UniqueId";
		
		$ThumbnailPath="$PHOTOPATH/thumbnail-$Path";
		$Path="$PHOTOPATH/$Path";
		
		if (file_exists($Path) && $Path!="")
		unlink($Path);
		if (file_exists($ThumbnailPath) && $ThumbnailPath!="")
		unlink($ThumbnailPath);
		
		$query1="delete from memories where memoriesid='$PhotoId' ";
		mysqli_query($CONNECTION,$query1);
	}
	
	if($PhotoId=="")
	{
		$Message="All the fields are mandatory!!";
		$Type=error;
	}	
	elseif($count==0)
	{	
		$Message="This is not a valid URL!!";
		$Type=error;	
	}
	else
	{
		$Message="Deleted successfully!!";
		$Type=success;
	}
	if($ReturnURL=="")
	$ReturnURL="DashBoard";
	SetNotification($Message,$Type);
	header("Location:$ReturnURL");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////

elseif($Action=="LockExam" || $Action=="UnLockExam")
{
	$ExamDetailId=$_GET['UniqueId'];
	$query="Select SubjectId,Locked,ExamId from examdetail where ExamDetailId='$ExamDetailId' and ExamDetailStatus='Active' ";
	$check=mysqli_query($CONNECTION,$query);
	$count=mysqli_num_rows($check);
	$row=mysqli_fetch_array($check);
	$SubjectId=$row['SubjectId'];
	$ExamId=$row['ExamId'];
	$Locked=$row['Locked'];
	
	if($ExamDetailId=="")
	{
		$Message="All the fields are mandatory!!";
		$Type=error;
	}
	elseif($count==0)
	{
		$Message="This is not a valid URL!!";
		$Type=error;
	}
	elseif($Locked==1 && $Action=="LockExam")
	{
		$Message="This exam is already locked!!";
		$Type=error;
	}
	elseif($Locked==0 && $Action=="UnLockExam")
	{
		$Message="This exam is already unlocked!!";
		$Type=error;
	}
	else
	{
		if($Action=="LockExam")
		{ $Lc=1; $Lc1="locked"; }
		else
		{ $Lc=0; $Lc1="unlocked"; }
		mysqli_query($CONNECTION,"update examdetail set Locked='$Lc' where ExamId='$ExamId' and SubjectId='$SubjectId' and ExamDetailStatus='Active' ");
		$Message="Exam $Lc1 successfully!!";
		$Type=success;
	}
	
	SetNotification($Message,$Type);
	header("Location:ExamSetup/$ExamId");
}
if($Action=="Language")
{
	
	$LanguageId=$UniqueId;
	
	$query="select LanguageName from lang where LanguageId='$LanguageId' ";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $conn, $query , $params, $options );
	$count = sqlsrv_num_rows($stmt);
	//$LastPage=isset($_SESSION['LastPage']) ? $_SESSION['LastPage'] : '';
	$LastPage = "http://localhost/gitproject/v4AccAdminPanel/Language.php";
	unset($_SESSION['LastPage']);
	
	
	
	if($count==1 || $LanguageId==0)
	{
		$_SESSION['LANGUAGE']=$LanguageId;
		$Message="Language changed successfully!!";
		$Type="success";
	}
	else
	{
		$Message="This is not a valid link!!";
		$Type="error";
	}
	if($LastPage=="")
	$LastPage="DashBoard";
	$LastPage=urldecode($LastPage);
	SetNotification($Message,$Type);
	header("Location:$LastPage");
}
else
header("Location:DashBoard.php");
?>