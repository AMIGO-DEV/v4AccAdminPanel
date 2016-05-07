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


//select RetailPriceEffectiveDate,RetailPriceOld,RetailPriceNew,Class1Cd,Class2Cd from PriceRevisionHistory StockNo = '".$_REQUEST['StockNo']."'



$columns = array( 
// datatable column index  => database column name
	0 => 'RetailPriceEffectiveDate',
	1 => 'RetailPriceOld',
	2 => 'RetailPriceNew',
	3 => 'Class1Cd',
	4 => 'Class2Cd'
	
);


// getting total number records without any search
$sql = "SELECT RetailPriceEffectiveDate FROM PriceRevisionHistory where StockNo = '".$_REQUEST['StockNo']."'";

$query123 = sqlsrv_query($conn, $sql) or die("registration-grid.php: get registration1");

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalData = sqlsrv_num_rows( $stmt );


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT RetailPriceEffectiveDate,RetailPriceOld,RetailPriceNew,Class1Cd,Class2Cd ";
$sql.=" FROM PriceRevisionHistory where StockNo = '".$_REQUEST['StockNo']."'";


if(!empty($requestData['columns'][0]['search']['value'])){   //name
	$sql.=" AND (RetailPriceEffectiveDate LIKE '%".$requestData['columns'][0]['search']['value']."%')";
}

if(!empty($requestData['columns'][1]['search']['value'])){   //name
	$sql.=" AND (RetailPriceOld LIKE '%".$requestData['columns'][1]['search']['value']."%') ";
}

if(!empty($requestData['columns'][2]['search']['value'])){   //name
	$sql.=" AND (RetailPriceNew LIKE '%".$requestData['columns'][2]['search']['value']."%' )";
}


if(!empty($requestData['columns'][3]['search']['value'])){   //name
	$sql.=" AND (Class1Cd LIKE '%".$requestData['columns'][3]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (Class2Cd LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}




if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( RetailPriceEffectiveDate LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR RetailPriceOld LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR RetailPriceNew LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR Class1Cd LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR Class2Cd LIKE '%".$requestData['search']['value']."%')";
	
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
	
	$nestedData[] = $row["RetailPriceEffectiveDate"];
	$nestedData[] = $row["RetailPriceOld"];
	$nestedData[] = $row["RetailPriceNew"];
	$nestedData[] = $row["Class1Cd"];
	$nestedData[] = $row["Class2Cd"];
		
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
