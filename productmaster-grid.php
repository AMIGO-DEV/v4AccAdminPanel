<?php
error_reporting(0);
//$PageName="productmaster-grid";
$TooltipRequired=1;
$SearchRequired=1;
$FormRequired=1;
$TableRequired=1;
require_once 'config.php';
//include("Include.php");

//IsLoggedIn();


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



//Termination StockNo,Class1Cd as brand,Class2Cd as product,SubClass1Cd as model,SubClass2Cd as packingsize,AnalCode2 as itemgroup,ItemDesc,SizeCd,LeastSalableQty,Retail_Price,ImagePresent

$columns = array( 
// datatable column index  => database column name
	0 => 'StockNo',
	1 => 'brand',
	2 => 'product',
	3 => 'model',
	4 => 'packingsize',
	5 => 'itemgroup',
	6 => 'ItemDesc',
	7 => 'SizeCd',
	8 => 'LeastSalableQty',
	9 => 'Retail_Price',
	
);


// getting total number records without any search
$sql = "SELECT StockNo FROM ItemMaster where IsBillable='True'";

$query123=sqlsrv_query($conn, $sql) or die("registration-grid.php: get registration1");

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql , $params, $options );

$totalData = sqlsrv_num_rows( $stmt );


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT StockNo,Class1Cd as brand,Class2Cd as product,SubClass1Cd as model,SubClass2Cd as packingsize,AnalCode2 as itemgroup,ItemDesc,SizeCd,LeastSalableQty,Retail_Price ";
$sql.=" FROM ItemMaster where IsBillable='True' ";


if(!empty($requestData['columns'][0]['search']['value'])){   //name
	$sql.=" AND (StockNo LIKE '%".$requestData['columns'][0]['search']['value']."%')";
}

if(!empty($requestData['columns'][1]['search']['value'])){   //name
	$sql.=" AND (Class1Cd LIKE '%".$requestData['columns'][1]['search']['value']."%') ";
}

if(!empty($requestData['columns'][2]['search']['value'])){   //name
	$sql.=" AND (Class2Cd LIKE '%".$requestData['columns'][2]['search']['value']."%' )";
}


if(!empty($requestData['columns'][3]['search']['value'])){   //name
	$sql.=" AND (SubClass1Cd LIKE '%".$requestData['columns'][3]['search']['value']."%' )";
}

if(!empty($requestData['columns'][4]['search']['value'])){   //name
	$sql.=" AND (SubClass2Cd LIKE '%".$requestData['columns'][4]['search']['value']."%' )";
}

if(!empty($requestData['columns'][5]['search']['value'])){   //name
	$sql.=" AND (AnalCode2 LIKE '%".$requestData['columns'][5]['search']['value']."%' )";
}

if(!empty($requestData['columns'][6]['search']['value'])){   //name
	$sql.=" AND (ItemDesc LIKE '%".$requestData['columns'][6]['search']['value']."%' )";
}

if(!empty($requestData['columns'][7]['search']['value'])){   //name
	$sql.=" AND (SizeCd LIKE '%".$requestData['columns'][7]['search']['value']."%' )";
}

if(!empty($requestData['columns'][8]['search']['value'])){   //name
	$sql.=" AND (LeastSalableQty LIKE '%".$requestData['columns'][8]['search']['value']."%' )";
}

if(!empty($requestData['columns'][9]['search']['value'])){   //name
	$sql.=" AND (Retail_Price LIKE '%".$requestData['columns'][9]['search']['value']."%' )";
}



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( StockNo LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR Class1Cd LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR Class2Cd LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR SubClass1Cd LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR SubClass2Cd LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR AnalCode2 LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR ItemDesc LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR SizeCd LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR LeastSalableQty LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR Retail_Price LIKE '%".$requestData['search']['value']."%' )";
	
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
//Termination StockNo,Class1Cd as brand,Class2Cd as product,SubClass1Cd as model,SubClass2Cd as packingsize,AnalCode2 as itemgroup,ItemDesc,SizeCd,LeastSalableQty,Retail_Price,ImagePresent

$query=sqlsrv_query($conn, $sql) or die("employee-grid-data.php: get registration3");

$data = array();
while( $row=sqlsrv_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	
	$nestedData[] = "<a href=\"product_master.php?id=".$row["StockNo"]."\">".$row["StockNo"]."</a>";
	$nestedData[] = $row["brand"];
	$nestedData[] = $row["product"];
	$nestedData[] = $row["model"];
	$nestedData[] = $row["packingsize"];
	$nestedData[] = $row["itemgroup"];
	$nestedData[] = $row["ItemDesc"];
	$nestedData[] = $row["SizeCd"];
	$nestedData[] = $row["LeastSalableQty"];
	$nestedData[] = $row["Retail_Price"];
	
	
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
