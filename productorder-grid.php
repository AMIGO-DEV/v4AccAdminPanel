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

//Orignal query
//select s.DocQty,h.PartyId,h.TrnCtrlNo,h.DocNoPrefix,h.DocDt,p.Nm,s.DocEntNetValue from StkTrnHdr h join StkTrnDtls s on h.TrnType = s.TrnType and h.TrnCtrlNo = s.TrnCtrlNo and h.DocNoPrefix = s.DocNoPrefix and h.DocNo = s.DocNo join Personnel p on h.VAUid = p.Code join Customers c on h.PartyId = c.Code where s.StockNo = 19501


//select c.Nm,h.TrnCtrlNo,h.DocNoPrefix,h.DocDt,s.DocQty,s.DocEntRate,s.DocEntNetValue from StkTrnHdr h join StkTrnDtls s on h.TrnType = s.TrnType and h.TrnCtrlNo = s.TrnCtrlNo and h.DocNoPrefix = s.DocNoPrefix and h.DocNo = s.DocNo join Customers c on h.PartyId = c.Code where s.StockNo = '".$_REQUEST['StockNo']."' 



$columns = array( 
// datatable column index  => database column name
	0 => 'TrnCtrlNo',
	1 => 'Nm',
	2 => 'DocNoPrefix',
	3 => 'DocDt',
	4 => 'DocQty',
	5 => 'DocEntRate',
	6 => 'DocEntNetValue'
	
);


// getting total number records without any search
$sql = "SELECT h.TrnCtrlNo FROM StkTrnHdr h join StkTrnDtls s on h.TrnType = s.TrnType and h.TrnCtrlNo = s.TrnCtrlNo and h.DocNoPrefix = s.DocNoPrefix and h.DocNo = s.DocNo join Customers c on h.PartyId = c.Code where s.StockNo = '".$_REQUEST['StockNo']."' ";

$query123 = sqlsrv_query($conn, $sql) or die("registration-grid.php: get registration1");

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalData = sqlsrv_num_rows( $stmt );


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT c.Nm,h.TrnCtrlNo,h.DocNoPrefix,h.DocDt,s.DocQty,s.DocEntRate,s.DocEntNetValue ";
$sql.=" FROM StkTrnHdr h join StkTrnDtls s on h.TrnType = s.TrnType and h.TrnCtrlNo = s.TrnCtrlNo and h.DocNoPrefix = s.DocNoPrefix and h.DocNo = s.DocNo join Customers c on h.PartyId = c.Code where s.StockNo = '".$_REQUEST['StockNo']."'";


if(!empty($requestData['columns'][0]['search']['value'])){   //name
	$sql.=" AND (h.TrnCtrlNo LIKE '%".$requestData['columns'][0]['search']['value']."%')";
}

if(!empty($requestData['columns'][1]['search']['value'])){   //name
	$sql.=" AND (c.Nm LIKE '%".$requestData['columns'][1]['search']['value']."%') ";
}

if(!empty($requestData['columns'][2]['search']['value'])){   //name
	$sql.=" AND (h.DocNoPrefix LIKE '%".$requestData['columns'][2]['search']['value']."%' )";
}


if(!empty($requestData['columns'][3]['search']['value'])){   //name
	$sql.=" AND (h.DocDt LIKE '%".$requestData['columns'][3]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (s.DocQty LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}

if(!empty($requestData['columns'][5]['search']['value'])){   //name
	$sql.=" AND (s.DocEntRate LIKE '%".$requestData['columns'][5]['search']['value']."%' )";
}

if(!empty($requestData['columns'][6]['search']['value'])){   //name
	$sql.=" AND (s.DocEntNetValue LIKE '%".$requestData['columns'][6]['search']['value']."%' )";
}



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( h.TrnCtrlNo LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR c.Nm LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR h.DocNoPrefix LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR h.DocDt LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR s.DocQty LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR s.DocEntRate LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR s.DocEntNetValue LIKE '%".$requestData['search']['value']."%')";
	
	
}

//echo $sql;

$query=sqlsrv_query($conn, $sql) or die("employee-grid-data.php: get registration2");

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalFiltered = sqlsrv_num_rows( $stmt );

//$totalFiltered = sqlsrv_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." OFFSET ".$requestData['start']."  ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	


$query=sqlsrv_query($conn, $sql) or die("employee-grid-data.php: get registration3");

$data = array();
while( $row=sqlsrv_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	
	$nestedData[] = $row["TrnCtrlNo"];
	$nestedData[] = $row["Nm"];
	$nestedData[] = $row["DocNoPrefix"];
	$nestedData[] = $row["DocDt"];
	$nestedData[] = $row["DocQty"];
	$nestedData[] = $row["DocEntRate"];
	$nestedData[] = $row["DocEntNetValue"];
		
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
