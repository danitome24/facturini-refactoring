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
if (empty($cobrada)) {
    $cobrada = $_POST['cobrada'];
}
$dbConnection = MysqliConnection::create($dbhost, $dbuname, $dbpass, $dbname);
$dbQuery = new MysqliQuery($dbConnection, false);
$sqlQuery = 'update ' . $table_name . " set nom='" . addslashes($nom) . "',adreca='" . addslashes($adreca)
    . "',nif='$nif',detalls='" . addslashes($detalls) . "',factura='$factura',observacions='" . addslashes($observacions)
    . "',tipus='$tipus',fecha_solicitud='$fecha_solicitud',cobrada='$cobrada',modificat='1' where num_reg='$num_reg'";
$result = $dbQuery->query($sqlQuery);
$dbConnection->disconnect();
Header("Location:index.htm");
?>
