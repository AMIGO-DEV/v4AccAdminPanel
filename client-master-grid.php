<?php
error_reporting(0);
//$PageName="productorder-grid";
$TooltipRequired=1;
$SearchRequired=1;
$FormRequired=1;
$TableRequired=1;
require_once 'config.php';
//include("Include.php");

//IsLoggedIn();


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

/* select c.Nm,c.StreetAddr,c.MobilePhone,c.Email,c.Town,v.vlong,v.vlat,vr.VRootname from Customers c join MailingList m on m.RecNo=c.Code join vgeoloc v on v.vclientid=c.Code join VRootdetails rd on c.Code = rd.VClientID join VRoot vr on rd.VRootID = vr.VRootID */


$columns = array( 
// datatable column index  => database column name
	0 => 'Nm',
	1 => 'StreetAddr',
	2 => 'MobilePhone',
	3 => 'Email',
	4 => 'Town',
	5 => 'VRootname'
	
);


// getting total number records without any search




$sql = "SELECT h.TrnCtrlNo FROM StkTrnHdr h join StkTrnDtls s on h.TrnType = s.TrnType and h.TrnCtrlNo = s.TrnCtrlNo and h.DocNoPrefix = s.DocNoPrefix and h.DocNo = s.DocNo join Customers c on h.PartyId = c.Code where s.StockNo = '".$_REQUEST['StockNo']."' and h.TrnType='1200'";


$sql = "SELECT c.Nm FROM Customers c join MailingList ml on ml.RecNo = c.MailListSrlNo join `vgeoloc` v on v.`vclientid` = c.Code join VRootdetails r on c.Code = r.VClientID join VRoot v1 on v1.VRootID = r.VRootID";



$query123 = sqlsrv_query($conn, $sql) or die("registration-grid.php: get registration1");

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalData = sqlsrv_num_rows( $stmt );


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT c.Nm,c.StreetAddr,c.MobilePhone,c.Email,c.Town,v.vlong,v.vlat,vr.VRootname ";
$sql.=" FROM Customers c join MailingList m on m.RecNo=c.MailListSrlNo join vgeoloc v on v.vclientid=c.Code join VRootdetails rd on c.Code = rd.VClientID join VRoot vr on rd.VRootID = vr.VRootID";


if(!empty($requestData['columns'][0]['search']['value'])){   //name
	$sql.=" AND (c.Nm LIKE '%".$requestData['columns'][0]['search']['value']."%')";
}

if(!empty($requestData['columns'][1]['search']['value'])){   //name
	$sql.=" AND (c.StreetAddr LIKE '%".$requestData['columns'][1]['search']['value']."%') ";
}

if(!empty($requestData['columns'][2]['search']['value'])){   //name
	$sql.=" AND (c.MobilePhone LIKE '%".$requestData['columns'][2]['search']['value']."%' )";
}


if(!empty($requestData['columns'][3]['search']['value'])){   //name
	$sql.=" AND (c.Email LIKE '%".$requestData['columns'][3]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (c.Town LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (v.vlong LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (v.vlat LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (vr.VRootname LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}




if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( c.Nm LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR c.StreetAddr LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR c.MobilePhone LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR c.Email LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR c.Town LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR v.vlong LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR v.vlat LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR vr.VRootname LIKE '%".$requestData['search']['value']."%')";
}

//echo $sql;

$query=sqlsrv_query($conn, $sql) or die("employee-grid-data.php: get registration2");

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalFiltered = sqlsrv_num_rows( $stmt );

//$totalFiltered = sqlsrv_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."  ".$requestData['order'][0]['dir']." OFFSET ".$requestData['start']."  ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	


$query=sqlsrv_query($conn, $sql) or die("employee-grid-data.php: get registration3");

$data = array();
while( $row=sqlsrv_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	
	$nestedData[] = $row["Nm"];
	$nestedData[] = $row["StreetAddr"];
	$nestedData[] = $row["MobilePhone"];
	$nestedData[] = $row["Email"];
	$nestedData[] = $row["Town"];
	$nestedData[] = $row["VRootname"];
		
	$data[] = $nestedData;
}

//print_r($requestData['draw']);

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
