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
if (empty($result)) {
    $result = $_POST['result'];
}
if (empty($cobrada)) {
    $cobrada = $_POST['cobrada'];
}
//


$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
sql_query("SET NAMES utf8", $dbi);

//echo $dbi;
//$date=getDate();
$fecha = date("Y-m-d H:i:s");
if ($fecha_solicitud == "" || !isset($fecha_solicitud)) {
    $fecha_solicitud = $fecha;
}
//$result=sql_query("insert into factura values (NULL,'$num_reg','$nom','$adreca','$nif','$detalls','$factura','$observacions','$tipus','$fecha_solicitud','$fecha')",$dbi);
//$query = "insert into " . $table_name . " values ('','".addslashes($nom)."','".addslashes($adreca)."','".$nif."','".addslashes($detalls)."','".$factura."','".addslashes($observacions)."','".$tipus."','".$fecha_solicitud."','".$fecha."','".$cobrada."', DEFAULT)";
$query = "insert into " . $table_name . " values ('','" . $nom . "','" . $adreca . "','" . $nif . "','" . $detalls . "','" . $factura . "','" . $observacions . "','" . $tipus . "','" . $fecha_solicitud . "','" . $fecha . "','" . $cobrada . "', DEFAULT)";
$result = mysqli_query($dbi, $query) or die (mysqli_error());
if ($result) {
    Header("Location:index.htm");
} else {
    Header("Location:error.php?op=3");
}
?>
