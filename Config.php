<?php 
$serverName = "NARENDRA-PC\SQLEXPRESS , 49172"; //serverName\instanceName
$connectionInfo = array("Database" => "ASTL18", "UID" => "sa", "PWD" => "password");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$BASEURL="http://localhost/gitproject/v4AccAdminPanel/";
if ($conn) {
}
 else {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
}


$BASEURL="http://localhost/gitproject/v4AccAdminPanel/";
?>