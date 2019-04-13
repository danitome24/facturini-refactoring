<?php

use Facturini\Database\Mysqli\MysqliConnection;
use Facturini\Database\Mysqli\MysqliQuery;

require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

$dbConnection = MysqliConnection::create($dbhost, $dbuname, $dbpass, $dbname);
$dbQuery = new MysqliQuery($dbConnection, $dbDebugMode);

$data_inici = $_POST['data_inici'];
$data_fi = $_POST['data_fi'];
$reg_inici = $_POST['reg_inici'];
$reg_fi = $_POST['reg_fi'];
$nom = $_POST['nom'];
$cobrada = $_POST['cobrada'];

$enviar = $_POST['enviar'];

if ($enviar) {
    $filtre = 0;

    $filtres['data'] = "";
    if ($data_inici != "" && $data_fi != "") {
        $filtres['data'] = "AND fecha_solicitud BETWEEN '" . $data_inici . "' AND '" . $data_fi . "' ";
        $filtre = 1;
    } else {
        if ($data_inici != "" && isset($data_inici)) {
            $filtres['data'] = "AND fecha_solicitud >= '" . $data_inici . "' ";
        } else {
            if ($data_fi != "" && isset($data_fi)) {
                $filtres['data'] = "AND fecha_solicitud <= '" . $data_fi . "' ";
            }
        }
        $filtre = 1;
    }

    $filtres['reg'] = "";
    if ($reg_inici != "" && $reg_fi != "") {
        $filtres['reg'] = "AND num_reg BETWEEN '" . $reg_inici . "' AND '" . $reg_fi . "' ";
        $filtre = 1;
    } else {
        if ($reg_inici != "" && isset($reg_inici)) {
            $filtres['reg'] = "AND num_reg >= '" . $reg_inici . "' ";
        } else {
            if ($reg_fi != "" && isset($reg_fi)) {
                $filtres['reg'] = "AND num_reg <= '" . $reg_fi . "' ";
            }
        }
        $filtre = 1;
    }

    $filtres['nom'] = "";
    if ($nom != "") {
        $filtres['nom'] = "AND nom LIKE '%" . $nom . "%' ";
        $filtre = 1;
    }

    $filtres['cobrada'] = "";
    if ($cobrada != "indiferent") {
        $filtres['cobrada'] = "AND cobrada='" . $cobrada . "' ";
    }

    $consulta = "SELECT num_reg, fecha_solicitud, nom FROM " . $table_name . " WHERE modificat = '1' ";
    if ($filtre) {
        $consulta .= $filtres['data'];
        $consulta .= $filtres['reg'];
        $consulta .= $filtres['nom'];
        $consulta .= $filtres['cobrada'];
    }
    $consulta .= "order by num_reg DESC";
    $result = $dbQuery->query($consulta) or die(mysqli_errno($dbConnection));
    $num_rows = $result->numberOfResults();
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>FACTURINI</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="includes/estil.css" media="screen" type="text/css">
    <script type="text/javascript" src="includes/js/checkbox.js"></script>
    <script type="text/javascript" src="includes/js/calendari.js"></script>
    <script type="text/javascript" src="includes/js/zebra.js"></script>
    <script type="text/javascript">window.onload = stripe;</script>
</head>

<body>

<p align="center">
    <font size="3" face="Verdana, Arial, Helvetica, sans-serif">
        <strong>Llistar factures (FACTURINI)</strong>
    </font>
</p>
<p>
    <strong>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <a href="index.htm">Anar a la plana inicial</a>
        </font>
    </strong>
</p>
<form action="llistar.php" method="post" name="form_2">
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <b>Data de sol·licitud.</b> Entre:&nbsp;
    </font>
    <input id="data_inici" name="data_inici" type="text" size="11" maxlength="10" value="<?php echo $data_inici; ?>"
           readonly onclick="displayCalendarFor('data_inici')">
    <a href="javascript:displayCalendarFor('data_inici');">
        <img align="top" src="img/calendari.png" border="0">
    </a>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">i&nbsp;</font>
    <input id="data_fi" name="data_fi" type="text" size="11" maxlength="10" value="<?php echo $data_fi; ?>" readonly
           onclick="displayCalendarFor('data_fi')"> <a href="javascript:displayCalendarFor('data_fi');">
        <img align="top" src="img/calendari.png" border="0"></a>
    <input type="button" value="Reset dates"
           onclick="document.getElementById('data_inici').value='', document.getElementById('data_fi').value='';">
    <br>
    <br>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <b>Número de registre.</b> Entre:&nbsp;
    </font>
    <input name="reg_inici" type="text" size="11" maxlength="10" value="<?php echo $reg_inici; ?>">
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">i&nbsp;</font>
    <input name="reg_fi" type="text" size="11" maxlength="10" value="<?php echo $reg_fi; ?>">
    <br>
    <br>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <b>Nom.</b>
        Conté:&nbsp;
    </font>
    <input name="nom" type="text" size="11" value="<?php echo $nom; ?>">
    <br>
    <br>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <b>Estat factures.</b>
        Cobrades:&nbsp;
    </font>
    <input type="radio" name="cobrada" value="0" <?php if ($cobrada == 0) {
        echo "checked";
    } ?>>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;No&nbsp;</font>
    <input type="radio" name="cobrada" value="1" <?php if ($cobrada == 1) {
        echo "checked";
    } ?>>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Sí&nbsp;</font>
    <input type="radio" name="cobrada" value="indiferent"
        <?php if ($cobrada == "indiferent" || !isset($cobrada) || $cobrada == "") {
            echo "CHECKED";
        } ?>>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Indiferent&nbsp;</font>

    <br><br>
    <input type="submit" name="enviar" value="Acceptar">
    <br><br><br><br>
</form>
<?php if ($enviar && $num_rows > 0) { ?>
    <form action="imprimir_llistat.php" method="post" name="imprimir_llistat" target="_blank">
        <table width="100%" cellspacing="0">
            <thead>
            <td align="center" width="5%">
                <input type="checkbox" name="tots" onclick="checkUncheckAll(this);">
            </td>
            <td width="15%">#Registre</td>
            <td width="15%">Data</td>
            <td width="65%">Nom</td>
            </thead>
            <tbody>
            <?php while ($array = $result->inArray()) { ?>
                <tr>
                    <td align='center'>
                        <input type='checkbox' name='regs[ <?php echo $array['num_reg'] ?> ]'>
                    </td>
                    <td><?php echo $array['num_reg'] ?></td>
                    <td><?php echo date_format(date_create($array['fecha_solicitud']), "d/m/Y") ?> </td>
                    <td><?php echo $array['nom'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
            <thead>
            <td align="center" width="5%">
                <input type="checkbox" name="tots" onclick="checkUncheckAll(this);">
            </td>
            <td width="15%">#Registre</td>
            <td width="15%">Data</td>
            <td width="65%">Nom</td>
            </thead>
        </table>
        <br><input type="submit" name="enviar" value="Imprimir">
    </form>
    <div style="margin-top: 25px; float: right">
        v0.3
    </div>
<?php } else {
    echo "<p>No hi ha registres que satisfacin la cerca.</p>";
}
$dbConnection->disconnect();
?>
</body>
</html>