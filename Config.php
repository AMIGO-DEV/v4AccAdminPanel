<?php 
$serverName = "178.63.23.134"; //serverName\instanceName
$connectionInfo = array("Database" => "v4account_", "UID" => "v4account", "PWD" => "vinit.2016");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn) {
}
 else {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
}
?>