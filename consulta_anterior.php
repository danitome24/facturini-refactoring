<?php

use Facturini\Invoice\Infrastructure\Persistence\Mysqli\MysqliConnection;
use Facturini\Invoice\Infrastructure\Persistence\Mysqli\MysqliQuery;

require_once 'config.php';

require_once __DIR__ . '/vendor/autoload.php';

if (empty($num_reg)) {
    $num_reg = $_REQUEST['num_reg'];
}

$dbConnection = MysqliConnection::create($dbhost, $dbuname, $dbpass, $dbname);
$dbQuery = new MysqliQuery($dbConnection, $dbDebugMode);
$result = $dbQuery->query('select * from ' . $table_name . " where num_reg='$num_reg'");
$res = $result->inArray();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>FACTURINI</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="includes/form_insert.css" media="screen" type="text/css">
    <link rel="stylesheet" href="includes/calendar.css" media="screen" type="text/css">
    <script type="text/javascript" src="includes/js/calendari.js"></script>
    <script type="text/javascript" src="includes/js/facturini.js"></script>
</head>
<body>
<?php if ($res == 0) { ?>
    <p>&nbsp;</p>
    <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>-ERROR-</strong></font></p>
    <br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">No hi ha cap registre amb aquest número</font><br>
    <p>
        <strong>
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.htm">Anar a la plana inicial</a>
            </font>
        </strong>
    </p>
<?php } else { ?>
<form action="update.php" method="post" name="form_2" id="form_2">
    <p align="center">
        <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulta factura (FACTURINI)</strong>
        </font>
    </p>
    <br>
    <p>
        <strong>
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <a href="index.htm">Anar a la plana inicial</a>
            </font>
        </strong>
    </p>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <b>Num. registre: </b> <?php echo $res['num_reg']; ?>
        <br>
        <br>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Tipus de factura:<br>
            <br>
            <?php if ($res['tipus']) { ?>
                <input TYPE=RADIO NAME=tipus VALUE="0">&nbsp;Interna&nbsp;
                <input TYPE=RADIO NAME=tipus VALUE="1" CHECKED>&nbsp;Externa<br>
            <?php } else { ?>
                <input TYPE=RADIO NAME=tipus VALUE="0" CHECKED>&nbsp;Interna&nbsp;
                <input TYPE=RADIO NAME=tipus VALUE="1">&nbsp;Externa<br>
            <?php } ?>
            <br>
            <br>
            <table width="100%">
                <tr>
                    <td valign="top">
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nom:</font></td>
                    <td>
                        <div align="left">
                            <textarea name="nom" cols="50" rows="5" wrap="hard"><?php echo stripslashes($res['nom']) ?>
                            </textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Adreça:</font></td>
                    <td>
                        <div align="left">
                            <textarea name="adreca" cols="50" rows="3"
                                      wrap="hard"><?php echo stripslashes($res['adreca']) ?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">NIF:</font>
                    </td>
                    <td>
                        <div align="left">
                            <input name="nif" type="text" size="11" maxlength="11"
                                   value="<?php echo stripslashes($res['nif']) ?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Data sol·licitud:</font>
                    </td>
                    <td>
                        <div align="left">
                            <input id="fecha_solicitud" name="fecha_solicitud" type="text" size="11" maxlength="10"
                                   value="<?php echo $res['fecha_solicitud'] ?>"
                                   onclick="displayCalendarFor('fecha_solicitud')"
                                   readonly>
                            <a href="javascript:displayCalendarFor('fecha_solicitud');">
                                <img align="top" src="img/calendari.png" border="0">
                            </a>
                            &nbsp;<font size="1" face="Verdana, Arial, Helvetica, sans-serif">(exemple:
                                2010-02-23)</font>
                        </div>
                    </td>
                </tr>
            </table>
            <br>
            Detalls servei:
            <br>
            <textarea name="detalls" cols="50" rows="5" wrap="hard"><?php echo stripslashes($res['detalls']) ?>
            </textarea>
            <br>
            <br>
            Total Factura: <input id="factura" name="factura" size="10"
                                  value="<?php echo stripslashes($res['factura']); ?>"
                                  onfocus="reset_error('facturaError')">
            <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                (N&uacute;mero decimal amb punt i sense s&iacute;mbol de moneda. exemple: 50.25)</font>
            <div id="facturaError"></div>
            <br>
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Cobrada:<br>
                <br>
                <?php if ($res['cobrada']) { ?>
                    <input TYPE=RADIO NAME="cobrada" VALUE="0">&nbsp;No&nbsp;
                    <input TYPE=RADIO NAME="cobrada" VALUE="1" CHECKED>&nbsp;S&iacute;<BR>
                <?php } else { ?>
                    <input TYPE=RADIO NAME="cobrada" VALUE="0" CHECKED>&nbsp;No&nbsp;
                    <input TYPE=RADIO NAME="cobrada" VALUE="1">&nbsp;S&iacute;<BR>
                <?php } ?>

                <br>
                Observacions:
                <br>
                <textarea name="observacions" cols="50" rows="5"
                          wrap="hard"><?php echo stripslashes($res['observacions']) ?></textarea>
            </font>
            <br>
            <br>
            <input type=hidden name=num_reg value=<?php echo $res['num_reg'] ?>>
            <input type="button" alt="Insertar" value="Tramet la consulta"
                   onclick="if (validar_formulari(document.getElementById('form_2'))) document.getElementById('form_2').submit();">
</form>
<div style="margin-top: 25px; float: right">
    v0.3
</div>
</body>
</html>
<?php
}
$dbConnection->disconnect();
?>
