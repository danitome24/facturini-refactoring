<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>FACTURINI</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="includes/form_insert.css" media="screen" type="text/css">
    <script type="text/javascript" src="includes/js/calendari.js"></script>
    <script type="text/javascript">
        function IsNumeric(data) {
            return parseFloat(data) == data;
        }

        function reset_error(campError) {
            var div = document.getElementById(campError);
            div.innerHTML = "";
        }

        function validar_formulari(form) {
            var form_ok = 1;
            if (!IsNumeric(form.factura.value)) {
                document.getElementById('facturaError').innerHTML = "El total ha de ser un valor numeric amb '.' per separar la part decimal.";
                form_ok = 0;
            }

            return (form_ok == 1);
        }
    </script>

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

if (empty($num_reg)) {
    $num_reg = $_REQUEST['num_reg'];
}

$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
sql_query("SET NAMES utf8", $dbi);
$result = sql_query("select * from " . $table_name . " where num_reg='$num_reg'", $dbi);

$res = sql_fetch_array($result, $dbi);

if ($res != 0) {
    echo '<form action="update.php" method="post" name="form_2" id="form_2">
  <p align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulta 
    factura (FACTURINI)</strong></font></p><br>
	<p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.htm">Anar 
  a la plana inicial</a></font></strong> </p>
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Num. registre: </b>' . $res['num_reg'] . '<br><br>
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Tipus de factura:<br>
  <br>';
    if ($res['tipus']) {

        echo '<INPUT TYPE=RADIO NAME= tipus VALUE="0">&nbsp;Interna&nbsp;
	  <INPUT TYPE=RADIO NAME= tipus VALUE="1" CHECKED>&nbsp;Externa<BR>';
    } else {

        echo '<INPUT TYPE=RADIO NAME= tipus VALUE="0"CHECKED>&nbsp;Interna&nbsp;
	  <INPUT TYPE=RADIO NAME= tipus VALUE="1">&nbsp;Externa<BR>';
    }
    echo '<br><br>

  <table width="100%">
    <tr> 
      <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nom:</font></td>
      <td> <div align="left"> 
          <textarea name="nom" cols="50" rows="5" wrap="hard">' . stripslashes($res['nom']) . '</textarea>
        </div></td>
    </tr>
    <tr> 
      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Adreça:</font></td>
      <td> <div align="left"> 
          <textarea name="adreca" cols="50" rows="3" wrap="hard">' . stripslashes($res['adreca']) . '</textarea>
       </div></td>
    </tr>
    <tr><td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">NIF:</font></td>
    <td> <div align="left"> 
        <input name="nif" type="text" size="11" maxlength="11" value="' . stripslashes($res['nif']) . '">
      </div></td>
    </tr>
	<tr><td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Data sol·licitud:</font></td>
    <td> <div align="left"> 
    	<input id="fecha_solicitud" name="fecha_solicitud" type="text" size="11" maxlength="10" value="' . $res['fecha_solicitud'] . '" READONLY onclick="displayCalendarFor(\'fecha_solicitud\')"> <a href="javascript:displayCalendarFor(\'fecha_solicitud\');"><img align="top" src="img/calendari.png" border="0"></a>
       ' .// <input name="fecha_solicitud" type="text" size="11" maxlength="10" value="'.$res[fecha_solicitud].'">
        '&nbsp;<font size="1" face="Verdana, Arial, Helvetica, sans-serif">(exemple: 2010-02-23)</font></div></td>
    </tr>
  </table>
  <br>
  Detalls servei:<br>
  <textarea name="detalls" cols="50" rows="5" wrap="hard">' . stripslashes($res['detalls']) . '</textarea>
  
  <br><br>

  ';
    ?>
    Total Factura:  <input id="factura" name="factura" size="10" value="<?php echo stripslashes($res['factura']); ?>"
                           onfocus="reset_error('facturaError')"><font size="1"
                                                                       face="Verdana, Arial, Helvetica, sans-serif"> (N&uacute;mero
        decimal amb punt i sense s&iacute;mbol de moneda. exemple: 50.25)</font>
    <div id="facturaError"></div>

    <?php
    echo '<br>
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Cobrada:<br>

  <br>';
    if ($res['cobrada']) {
        echo '<INPUT TYPE=RADIO NAME="cobrada" VALUE="0" >&nbsp;No&nbsp;

 	 <INPUT TYPE=RADIO NAME="cobrada" VALUE="1" CHECKED>&nbsp;S&iacute;<BR>';
    } else {
        echo '<INPUT TYPE=RADIO NAME="cobrada" VALUE="0" CHECKED>&nbsp;No&nbsp;

  	<INPUT TYPE=RADIO NAME="cobrada" VALUE="1" >&nbsp;S&iacute;<BR>';
    }
    echo '<br>
  Observacions:<br>
  <textarea name="observacions" cols="50" rows="5" wrap="hard">' . stripslashes($res['observacions']) . '</textarea>
  </font>
  <br><br>
  <input type=hidden name=num_reg value=' . $res['num_reg'] . '>';
    ?>
    <input type="button" alt="Insertar" value="Tramet la consulta"
           onclick="if (validar_formulari(document.getElementById('form_2'))) document.getElementById('form_2').submit();">
    <?php
    echo '</form>';
    echo '<div style="margin-top: 25px; float: right">
    v0.1
</div>';

} else {
    echo '<p>&nbsp;</p>
		<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>-ERROR-</strong></font></p>
  
		<br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">No hi ha cap registre amb aquest número</font><br>
	
		<p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.htm">Anar 
  						a la plana inicial</a></font></strong> </p>';
}
?>
</body>
</html>

