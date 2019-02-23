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

    <style>
        .fc_main {
            background: #DDDDDD;
            border: 1px solid #000000;
            font-family: Verdana;
            font-size: 10px;
        }

        .fc_date {
            border: 1px solid #D9D9D9;
            cursor: pointer;
            font-size: 10px;
            text-align: center;
        }

        .fc_dateHover, TD.fc_date:hover {
            cursor: pointer;
            border-top: 1px solid #FFFFFF;
            border-left: 1px solid #FFFFFF;
            border-right: 1px solid #999999;
            border-bottom: 1px solid #999999;
            background: #E7E7E7;
            font-size: 10px;
            text-align: center;
        }

        .fc_wk {
            font-family: Verdana;
            font-size: 10px;
            text-align: center;
        }

        .fc_wknd {
            color: #FF0000;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }

        .fc_head {
            background: #000066;
            color: #FFFFFF;
            font-weight: bold;
            text-align: left;
            font-size: 11px;
        }
    </style>
</head>

<body>

<?php

require_once("config.php");
require_once("includes/sql_layer.php");

$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
sql_query("SET NAMES utf8", $dbi);

$data_inici = $_POST['data_inici'];
$data_fi = $_POST['data_fi'];
$reg_inici = $_POST['reg_inici'];
$reg_fi = $_POST['reg_fi'];
$nom = $_POST['nom'];
$cobrada = $_POST['cobrada'];

?>
<p align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Llistar factures
            (FACTURINI)</strong></font></p>
<p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.htm">Anar a la plana
                inicial</a></font></strong></p>

<form action="llistar.php" method="post" name="form_2">
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Data de sol·licitud.</b> Entre:&nbsp;</font>
    <input id="data_inici" name="data_inici" type="text" size="11" maxlength="10" value="<?php echo $data_inici; ?>"
           READONLY onclick="displayCalendarFor('data_inici')"> <a
            href="javascript:displayCalendarFor('data_inici');"><img align="top" src="img/calendari.png" border="0"></a>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">i&nbsp;</font>
    <input id="data_fi" name="data_fi" type="text" size="11" maxlength="10" value="<?php echo $data_fi; ?>" READONLY
           onclick="displayCalendarFor('data_fi')"> <a href="javascript:displayCalendarFor('data_fi');"><img align="top"
                                                                                                             src="img/calendari.png"
                                                                                                             border="0"></a>
    <input type="button" value="Reset dates"
           onclick="document.getElementById('data_inici').value='', document.getElementById('data_fi').value='';">
    <br><br>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Número de registre.</b> Entre:&nbsp;</font>
    <input name="reg_inici" type="text" size="11" maxlength="10" value="<?php echo $reg_inici; ?>">
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">i&nbsp;</font>
    <input name="reg_fi" type="text" size="11" maxlength="10" value="<?php echo $reg_fi; ?>">
    <br><br>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Nom.</b> Conté:&nbsp;</font>
    <input name="nom" type="text" size="11" value="<?php echo $nom; ?>">
    <br><br>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Estat factures.</b> Cobrades:&nbsp;</font>
    <INPUT TYPE=RADIO NAME="cobrada" VALUE="0" <?php if ($cobrada == 0) {
        echo "CHECKED";
    } ?>><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;No&nbsp;</font>
    <INPUT TYPE=RADIO NAME="cobrada" VALUE="1" <?php if ($cobrada == 1) {
        echo "CHECKED";
    } ?>><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Sí&nbsp;</font>
    <INPUT TYPE=RADIO NAME="cobrada"
           VALUE="indiferent" <?php if ($cobrada == "indiferent" || !isset($cobrada) || $cobrada == "") {
        echo "CHECKED";
    } ?>><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Indiferent&nbsp;</font>

    <br><br>
    <input type="submit" name="enviar" value="Acceptar">
    <br><br><br><br>
</form>

<?php

$enviar = $_POST['enviar'];

if ($enviar) {

    //print_r($_POST);

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

    //echo $consulta;
    $result = mysqli_query($dbi, $consulta) or die (mysql_error());
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {

        ?>
        <form action="imprimir_llistat.php" method="post" name="imprimir_llistat" target="_blank">
            <table width="100%" cellspacing="0">
                <thead>
                <td align="center" width="5%"><input type="checkbox" name="tots" onclick="checkUncheckAll(this);"></td>
                <td width="15%">#Registre</td>
                <td width="15%">Data</td>
                <td width="65%">Nom</td>
                </thead>
                <tbody>
                <?php

                while ($array = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td align='center'><input type='checkbox' name='regs[" . $array['num_reg'] . "]'></td>";
                    echo "<td>" . $array['num_reg'] . "</td>";
                    echo "<td> " . date_format(date_create($array['fecha_solicitud']), "d/m/Y") . " </td>";
                    echo "<td> " . $array['nom'] . " </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
                <thead>
                <td align="center" width="5%"><input type="checkbox" name="tots" onclick="checkUncheckAll(this);"></td>
                <td width="15%">#Registre</td>
                <td width="15%">Data</td>
                <td width="65%">Nom</td>
                </thead>
            </table>
            <br><input type="submit" name="enviar" value="Imprimir">
        </form>


        <?php
    } else {
        echo "<p>No hi ha registres que satisfacin la cerca.</p>";
    }

}
?>
</body>
</html>