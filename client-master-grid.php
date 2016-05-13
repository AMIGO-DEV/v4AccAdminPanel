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




//$sql = "SELECT h.TrnCtrlNo FROM StkTrnHdr h join StkTrnDtls s on h.TrnType = s.TrnType and h.TrnCtrlNo = s.TrnCtrlNo and h.DocNoPrefix = s.DocNoPrefix and h.DocNo = s.DocNo join Customers c on h.PartyId = c.Code where s.StockNo = '".$_REQUEST['StockNo']."' and h.TrnType='1200'";


$sql = "SELECT c.Nm FROM Customers c left join MailingList ml on ml.RecNo = c.MailListSrlNo left join route_master r on c.Code = r.ClientName left join vgeoloc v on v.vclientID = c.Code";



$query123 = sqlsrv_query($conn, $sql) or die("registration-grid.php: get registration1");

if( $query123 === false ) {
				if( ($errors = sqlsrv_errors() ) != null) {
				foreach( $errors as $error ) {
													echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
													echo "code: ".$error[ 'code']."<br />";
													echo "message: ".$error[ 'message']."<br />";
												}
											}
										}




$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );


$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalData = sqlsrv_num_rows( $stmt );


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT c.Nm,m.StreetAddr,m.MobilePhone,m.Email,m.Town,v.vlong,v.vlat,r.RouteName ";
$sql.=" FROM Customers c left join MailingList m on m.RecNo=c.MailListSrlNo left join route_master r on c.Code = r.ClientName left join vgeoloc v on v.vclientid=c.Code";


if(!empty($requestData['columns'][0]['search']['value'])){   //name
	$sql.=" AND (c.Nm LIKE '%".$requestData['columns'][0]['search']['value']."%')";
}

if(!empty($requestData['columns'][2]['search']['value'])){   //name
	$sql.=" AND (m.StreetAddr LIKE '%".$requestData['columns'][2]['search']['value']."%') ";
}

if(!empty($requestData['columns'][3]['search']['value'])){   //name
	$sql.=" AND (m.MobilePhone LIKE '%".$requestData['columns'][3]['search']['value']."%' )";
}


if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (m.Email LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}

if(!empty($requestData['columns'][5]['search']['value'])){   //name
	$sql.=" AND (m.Town LIKE '%".$requestData['columns'][5]['search']['value']."%' )";
}



if(!empty($requestData['columns'][6]['search']['value'])){   //name
	$sql.=" AND (r.RouteName LIKE '%".$requestData['columns'][6]['search']['value']."%' )";
}




if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( c.Nm LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR m.StreetAddr LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR m.MobilePhone LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR m.Email LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR m.Town LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR r.RouteName LIKE '%".$requestData['search']['value']."%')";
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

echo $sql;

$query=sqlsrv_query($conn, $sql) or die("employee-grid-data.php: get registration3");

$data = array();
while( $row=sqlsrv_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	
	if($row["vlat"]!='' && $row["vlong"]!='')
	{
		$location ="<a href=\"https://www.google.com/maps?q=".$row["vlat"].",".$row["vlong"]."\" target=\"_blank\">Click Here</a>";
	}
	else
	{
		$location ="N/A";
	}
	
	$nestedData[] = $row["Nm"];
	$nestedData[] = $location;
	$nestedData[] = $row["StreetAddr"];
	$nestedData[] = $row["MobilePhone"];
	$nestedData[] = $row["Email"];
	$nestedData[] = $row["Town"];
	$nestedData[] = $row["RouteName"];
		
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
