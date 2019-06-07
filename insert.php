<?php

use Facturini\Database\Mysqli\MysqliConnection;
use Facturini\Database\Mysqli\MysqliQuery;

require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

if (empty($num_reg)) {
    $num_reg = $_POST['num_reg'];
}
if (empty($nom)) {
    $nom = $_POST['nom'];
}
if (empty($adreca)) {
    $adreca = $_POST['adreca'];
}
if (empty($nif)) {
    $nif = $_POST['nif'];
}
if (empty($detalls)) {
    $detalls = $_POST['detalls'];
}
if (empty($factura)) {
    $factura = $_POST['factura'];
}
if (empty($observacions)) {
    $observacions = $_POST['observacions'];
}
if (empty($tipus)) {
    $tipus = $_POST['tipus'];
}
if (empty($fecha_solicitud)) {
    $fecha_solicitud = $_POST['fecha_solicitud'];
}
if (empty($result)) {
    $result = $_POST['result'];
}
if (empty($cobrada)) {
    $cobrada = $_POST['cobrada'];
}

$dbConnection = MysqliConnection::create($dbhost, $dbuname, $dbpass, $dbname);
$sqlQuery = new MysqliQuery($dbConnection, false);
$fecha = date('Y-m-d H:i:s');
if ($fecha_solicitud == "" || !isset($fecha_solicitud)) {
    $fecha_solicitud = $fecha;
}
$query = 'insert into ' . $table_name . " values ('','" . $nom . "','" . $adreca . "','" . $nif . "','" . $detalls . "','" . $factura . "','" . $observacions . "','" . $tipus . "','" . $fecha_solicitud . "','" . $fecha . "','" . $cobrada . "', DEFAULT)";
$result = $sqlQuery->query($query);
if ($result) {
    Header('Location:index.htm');
} else {
    Header('Location:error.php?op=3');
}
?>
