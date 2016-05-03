<?php
function CheckMobile($GR)
{
	global $MOBILENUMBERDIGIT;
	if(!is_numeric($GR) || strlen($GR)!=$MOBILENUMBERDIGIT)
	return(0);
	else
	return(1);
}
function CheckLandline($Landline)
{
	global $LANDLINENUMBERDIGIT;
	if(!is_numeric($Landline) || strlen($Landline)!=$LANDLINENUMBERDIGIT)
	return(0);
	else
	return(1);
}
function CheckEmail($Email)
{
	if (!filter_var($Email, FILTER_VALIDATE_EMAIL))
	return(0);
	else
	return(1);
}

function CheckNegative($Number)
{
	if($Number<0)
	return(0);
	else
	return(1);
}

function CheckZero($Number)
{
	if($Number==0)
	return(0);
	else
	return(1);
}

function CheckNumeric($Number)
{
	if(!is_numeric($Number))
	return(0);
	else
	return(1);
}

function CheckAmountWithZero($Number)
{
	if(!is_numeric($Number) || $Number<0)
	return(0);
	else
	return(1);
}

function CheckAmountWithoutZero($Number)
{
	if(!is_numeric($Number) || $Number<=0)
	return(0);
	else
	return(1);
}

?>