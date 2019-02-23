<?php

require_once("config.php");
require_once("includes/sql_layer.php");

// JV
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
$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
sql_query("SET NAMES utf8", $dbi);
$result = sql_query("update " . $table_name . " set nom='" . addslashes($nom) . "',adreca='" . addslashes($adreca)
    . "',nif='$nif',detalls='" . addslashes($detalls) . "',factura='$factura',observacions='" . addslashes($observacions)
    . "',tipus='$tipus',fecha_solicitud='$fecha_solicitud',cobrada='$cobrada',modificat='1' where num_reg='$num_reg'",
    $dbi);
Header("Location:index.htm");
?>
