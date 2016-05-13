<?php
session_start();

set_time_limit(0);
$APPLICATIONNAME="Amigo School";
$APPLCATIONSLOGAN="Login";
$DOMAIN=$_SERVER['HTTP_HOST'];
include("Config.php");
include("Function.php");
if($DOMAIN=="localhost" && isset($PageName) && ($PageName=="Login" || $PageName=="DashBoard") )
include("Database.php");
if(!isset($SCHOOLNAME))
$SCHOOLNAME=$APPLICATIONNAME;
$PageKeywords="School Monitor";
$PageDescription="School Monitor";
$PageAuthor="Amigo Innovations";
$ApplicationName="Amigo Software";
$CurrentPageURL=CurrentPageURL();
$CurrentPageURL=urlencode($CurrentPageURL);
$extension="wb";
$MAXRECORDS=2000000;
$PHOTOPATH="Upload";
$TIMEZONE="Asia/Kolkata";
if(function_exists('date_default_timezone_set'))
date_default_timezone_set($TIMEZONE);
$Date=date("F j, Y, g:i a");
$DDMMYYYY=date("d-m-Y");
$IP=$_SERVER["REMOTE_ADDR"];
$ConfirmProceed=Confirmation();
$PRINTUNIT="cm";
$DEFAULTPRINTSIZE="21";
$ByPass=$AllowParents=$AllowStudent=0;
$SCHOOLSESSION=array();
if(isset($PageName))
{
	$PageNameArray=explode("-",$PageName);
	$PageName=$PageNameArray[0];
	if (in_array("Parents", $PageNameArray))
	$AllowParents=1;
	if (in_array("Student", $PageNameArray))
	$AllowStudent=1;
}

$DefaultPage=Array('DashBoard','Login','Logout','ChangePassword','Register');





$USERTYPE=$USERNAME=$USERID=$NAME=$USERTYPEID=$TOKEN=$USERACCOUNTTYPE=$CURRENTSESSION=$LANGUAGE=$CURRENCY="";
$ACCOUNTLIST=$LISTACCOUNT=$SelectAccount=$LISTALLACCOUNT=$LISTALLACCOUNTWITHOUTBALANCE="";
$SCHOOLSET='';
$CURRENCY="INR";
$_SESSION['CURRENCY']=$CURRENCY;
$CURRENCY=$_SESSION['CURRENCY'];
if(!isset($DatabaseError) && !isset($TableError))
{
	$LANGUAGE=isset($_SESSION['LANGUAGE']) ? $_SESSION['LANGUAGE'] : '';
	
	 
	$query="select PhraseId,Phrase from phrase";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $conn, $query , $params, $options );
	
	$PhraseArray[]="";
	$PhraseIdArray[]="";
	while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
	{
		$PhraseIdArray[]=$row['PhraseId'];
		$PhraseArray[]=$row['Phrase'];
	}	
	if($PhraseArray!="")
	$_SESSION['PHRASE']=implode(",",$PhraseArray);
	if($PhraseIdArray!="")
	$_SESSION['PHRASEID']=implode(",",$PhraseIdArray);
	$query1="select Translation from translate where LanguageId='$LANGUAGE' ";
	
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmta = sqlsrv_query( $conn, $query1 , $params, $options );
		
	$row1=sqlsrv_fetch_array($stmta, SQLSRV_FETCH_ASSOC);
	$_SESSION['TRANSLATION']=$row1['Translation'];
	if(Login())
	{
		
		 $USERNAME=$_SESSION['USERNAME'];
		 $USERID=$_SESSION['UserId'];
		 $USERTYPE=$_SESSION['USERTYPE'];
			
	}
	

	/* if($USERTYPE!="MasterUser" && $USERTYPE!="Webmaster" && $ByPass!=1)
	{
		$UserFound=0;
		$query00000="select PermissionString from permission where UserType='$USERTYPEID' ";
		$check00000=mysqli_query($CONNECTION,$query00000);
		$row00000=mysqli_fetch_array($check00000);
		$PermissionString=$row00000['PermissionString'];
		$PermissionString=explode(",",$PermissionString);
		$query00001="select PageNameId from pagename where PageName='$PageName' ";
		$check00001=mysqli_query($CONNECTION,$query00001);
		$row00001=mysqli_fetch_array($check00001);
		$PageNameId=$row00001['PageNameId'];
		foreach($PermissionString as $Permission)
		{
			if($Permission==$PageNameId)
			$UserFound++;
		}
		if($AllowParents==1 && $USERTYPEID==="Parents")
		$UserFound++;
		if($AllowStudent==1 && $USERTYPEID==="Student")
		$UserFound++;
		if($UserFound<=0)
		{
			$Message="You can not access \"$PageName\" Page!!";
			$Type="error";
			SetNotification($Message,$Type);
			header("location:DashBoard");
			exit();
		}
	} */
	
}
?>