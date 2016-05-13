<?php
function Login()
{
	if(isset($_SESSION['UserId']) && $_SESSION['UserId']!="")
	return(1);
	else
	return(0);
}

function IsLoggedIn()
{
	$Login=Login();
	if($Login==0)
	{
	$CURL=CurrentPageURL();
	$_SESSION['CURL']=$CURL;
	$Message="You need to log in to access this page!!";
	$Type="error";
	SetNotification($Message,$Type);
	$_SESSION['NotLoggedIn']=1;
	header("Location:index.php");
	exit();
	}
}

function SetNotification($Message,$Type)
{
	$_SESSION['Alert']=1;
	$_SESSION['Message']=$Message;
	$_SESSION['Type']=$Type;
}

function DisplayNotification()
{
	if(isset($_SESSION['Alert']) && isset($_SESSION['Message']) && isset($_SESSION['Type']))
	{
	$Message=$_SESSION['Message'];
	$Type=$_SESSION['Type'];
	echo "<div class=\"span10\">
		<div class=\"alert alert-$Type\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			<strong>$Message</strong>
		</div>
	</div><div class=clearfix></div>";
	unset($_SESSION['Alert']);
	unset($_SESSION['Message']);
	unset($_SESSION['Type']);
	}
}

function ShowNotification($Message,$Type)
{
	echo "<div class=\"alert $Type\">
	<strong>$Message</strong>
	</div>";
}

function ActionButton($Content,$TabIndex)
{
echo "<div class=\"form-row row-fluid\"><div class=\"span4\"></div>
<div class=\"span8\">
<button type=\"submit\" tabindex=\"$TabIndex\" class=\"btn btn-info\">$Content</button>
</div>
</div>
<Br>";
}


function Translate($Phrase)
{
	$PhrasePassed="";
	if(!is_numeric($Phrase))
	{
		$PhrasePassed=1;
		$PhraseArray=explode(",",$_SESSION['PHRASE']);
		$PhraseIdArray=explode(",",$_SESSION['PHRASEID']);
		$PhraseSearch=array_search($Phrase,$PhraseArray);
		if($PhraseSearch===FALSE)
		$PhraseId="";
		else
		$PhraseId=$PhraseIdArray[$PhraseSearch];
	}
	else
	$PhraseId=$Phrase;
	$Found="";
	$Translation=$_SESSION['TRANSLATION'];
	if($Translation!="")
	$Translation=explode("||",$Translation);
	if($Translation!="")
	foreach($Translation as $TranslationValue)
	{
		$TP=explode("**",$TranslationValue);
		if($TP[0]==$PhraseId)
		{
			$Found=1;
			if(($TP[1]=="" && is_numeric($Phrase)) || $TP[1]!="")
			return($TP[1]);		
			else
			return($Phrase);
			break;
		}
	}
	
	if($Found!=1 && $PhrasePassed==1)
	return($Phrase);
}

function ActionConfirm($Msg)
{
$Return="onclick=\"javascript:return confirm('$Msg')\"";
return($Return);
}

function SetButton($ButtonContent)
{
echo "<div class=\"form-row row-fluid\">
	<div class=\"span4\"></div>
	<div class=\"span8\">
	   <button type=\"submit\" class=\"btn btn-info\">$ButtonContent</button>
	</div>
</div>";
}

function SetDeleteButton($TabIndex)
{
$Confirm=Confirmation();
echo "<div class=\"form-row row-fluid\">
	<div class=\"span4\"></div>
	<div class=\"span8\">
	   <button tabindex=\"$TabIndex\" type=\"submit\" class=\"btn btn-danger\" $Confirm>Delete</button>
	</div>
</div>";
}

function BreadCumbSession($BreadCumbSession){
	$CURRENTSESSION=isset($_SESSION['CURRENTSESSION']) ? $_SESSION['CURRENTSESSION'] : '';
	$CSession = "Current Session";
		if($CURRENTSESSION!="")
			echo "<a href='#' style='font-size: 20px; font-weight: 450px; margin-top: 2px;' class='btn btn-link btn-float has-text'>$CSession : $CURRENTSESSION</a>";
}

function BreadCumb($BreadCumb)
{
echo "<div class=\"heading\">
	<h3>$BreadCumb</h3> ";

echo "</div>";
}

function Calculate( $mathString )    {
    $mathString = trim($mathString);
    $mathString = ereg_replace ('[^0-9\+-\*\/\(\) ]', '', $mathString);
    $compute = create_function("", "return (" . $mathString . ");" );
    return 0 + $compute();
}

function Confirmation()
{
$Confirm="onclick=\"javascript:return confirm('Are you sure you want to proceed???')\"";
return($Confirm);
}

function GetCategoryId($Name,$Value)
{
	$check=mysqli_query($CONNECTION,"select MasterEntryId from masterentry where MasterEntryName='$Name' and MasterEntryValue='$Value' ");
	$count=mysqli_num_rows($check);
	if($count==0)
	return(0);
	else
	{
		$row=mysqli_fetch_array($check);
		$MasterEntryId=$row['MasterEntryId'];
		return($MasterEntryId);
	}
}

function GetCategoryValueOfId($Id,$Name)
{
	global $CONNECTION;
	$check=mysqli_query($CONNECTION,"select MasterEntryValue from masterentry where MasterEntryId='$Id' and MasterEntryName='$Name' ");
	$count=mysqli_num_rows($check);
	if($count==0)
	return(0);
	else
	{
		$row=mysqli_fetch_array($check);
		$MasterEntryValue=$row['MasterEntryValue'];
		return($MasterEntryValue);
	}
}

function GetCategoryValue($Name,$FieldName,$DefaultValue,$Ajx,$AjaxField,$AjaxFieldTxt,$Readonly,$TabIndex,$Multiple)
{
global $conn;
$FieldNameId=$FieldName;
if($Multiple==1)
{	
	$Multiple="multiple=\"multiple\"";
	$FieldName.="[]";
}
if($Ajx==1)
echo "<select tabindex=$TabIndex name=$FieldName onchange=\"showdetail(this.value,'$AjaxField','$AjaxFieldTxt')\" required id=$FieldNameId class=\"form-control select\" \"$Readonly\" style=\"width:100%;\" $Multiple>";
else
echo "<select tabindex=$TabIndex name=$FieldName id=$FieldNameId class=\"form-control select\" $Readonly style=\"width:100%;\" $Multiple>";
if($Multiple=="")
echo "<option selected='selected'>Select</option>";
$sql = "SELECT Recid,Code,Descr FROM GenLookUp WHERE Recid='$Name'";
$stmt = sqlsrv_query($conn, $sql);
while($row=sqlsrv_fetch_array($stmt))
{
	$MasterEntryId=$row['Recid'];
	$MasterEntryValue=$row['Descr'];
	if($Multiple=="")
	{
	if($DefaultValue==$MasterEntryValue)
	$selected="selected";
	else
	$selected="";
	}
	else
	{
		$selected="";
		foreach($DefaultValue as $kk)
		{
			if($kk==$MasterEntryValue)
			{
				$selected="selected";
				break;
			}
		}
	}
	echo "<option value=$MasterEntryValue $selected>$MasterEntryValue</option>";
}
echo "</select>";
}

function CheckDateFormat($date)
{
  if (preg_match ("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $date, $parts))
  {
        if(checkdate($parts[2],$parts[1],$parts[3]))
          return true;
        else
         return false;
  }
  else
    return false;
}

function MonthDifference($startDate, $endDate) {
	$startDate=date("Y-m-d",$startDate);
	$endDate=date("Y-m-d",$endDate);
    $retval = "";
    $splitStart = explode('-', $startDate);
    $splitEnd = explode('-', $endDate);

    if (is_array($splitStart) && is_array($splitEnd)) {
        $difYears = $splitEnd[0] - $splitStart[0];
        $difMonths = $splitEnd[1] - $splitStart[1];
        $difDays = $splitEnd[2] - $splitStart[2];

        $retval = ($difDays > 0) ? $difMonths : $difMonths - 1;
        $retval += $difYears * 12;
    }
    return $retval;
}

function GetDateFormat($Date)
{
	if($Date!="")
	{
	$TimeCheck=date("h:ia",$Date);
	$DateAll=date("d M Y,h:ia",$Date);
	$Date=date("d M Y",$Date);
	if($TimeCheck=="12:00am")
	return($Date);
	else
	return($DateAll);	
	}
	else
	return;
}

function yyyyMMddtoddMMyyyy($d)
{
$yy=substr($d,0,4);
$mm=substr($d,5,2);
$dd=substr($d,8,2);
$ed=$dd."-".$mm."-".$yy;
return($ed);
}

function ddMMyyyytoyyyyMMdd($d)
{
$dd=substr($d,0,2);
$mm=substr($d,3,2);
$yy=substr($d,6,4);
$ed=$yy."-".$mm."-".$dd;
return($ed);
}

function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "", $string);
}

function mynl2br($string)
{
    $string=str_replace("'", "&#039;", $string);
    $string=nl2br($string);
    return($string);
}

function MakeSeed() {
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function PasswordGenerator($c)
{
srand(MakeSeed());
$password_length = $c;
$m=0;
$alfa = "1234567890QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz";
$token = "";
for($i = 0; $i < $password_length; $i ++) {
  $m=rand(0, strlen($alfa));
  if(isset($alfa[$m]))
  $token .= $alfa[$m];
}
return($token);
}

function CurrentPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function GetMAC()
{
ob_start(); 
system("ipconfig /all"); 
 $cominfo=ob_get_contents(); 
ob_clean(); 
$search = "Physical";
$primarymac = strpos($cominfo, $search); 
$mac=substr($cominfo,($primarymac+36),17);
$mac = PREG_REPLACE("/[^0-9a-zA-Z]/i", '', $mac);
$mac=strrev($mac);
$mac=substr($mac,0,4);
return($mac);
}

function CopyDirectory( $source, $destination ) {
	if ( is_dir( $source ) ) {
		@mkdir( $destination );
		$directory = dir( $source );
		while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
			if ( $readdirectory == '.' || $readdirectory == '..' ) {
				continue;
			}
			$PathDir = $source . '/' . $readdirectory; 
			if ( is_dir( $PathDir ) ) {
				CopyDirectory( $PathDir, $destination . '/' . $readdirectory );
				continue;
			}
			copy( $PathDir, $destination . '/' . $readdirectory );
		}
 
		$directory->close();
	}else {
		copy( $source, $destination );
	}
}
function Escape($array){
global $conn;
	if(is_array($array)) {
		foreach($array as $key => $value) {
			if(is_array($array[$key]))
				$array[$key] = $this->filterParameters($array[$key]);
	   
			if(is_string($array[$key]))
				$array[$key] = mssql_escape($array[$key]);
		}           
	}
	if(is_string($array))
		$array = mssql_escape($array);
	return $array;
}
function mssql_escape($data) {
    if(is_numeric($data))
        return $data;
    $unpacked = unpack('H*hex', $data);
    return '0x' . $unpacked['hex'];
}
function GetRandomColor()
{
	$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	return($color);
}
?>