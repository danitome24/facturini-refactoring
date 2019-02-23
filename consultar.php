<?php
require_once("config.php");
require_once("includes/sql_layer.php");

$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
sql_query("SET NAMES utf8", $dbi);

$camp = $_GET['camp'];
$ordre = $_GET['ordre'];
$pagina = $_GET['pagina'];

if (!isset($camp) || $camp == "") {
    $camp = "modificat";
    $ordre = "asc";
    $pagina = 0;
}

$query = "SELECT count(*) total from " . $table_name;
$result = mysqli_query($dbi, $query) or die (mysqli_error());
$array = mysqli_fetch_assoc($result);
$total = $array['total'];

if ($camp == "modificat") {
    $camp = "modificat " . $ordre . ", num_reg desc";
    $ordre = "";
}
$query = "SELECT num_reg, fecha_solicitud, nom, modificat from " . $table_name . " order by " . $camp . " " . $ordre . " limit " . $pagina . ",20";
$result = mysqli_query($dbi, $query) or die (mysqli_error());

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>FACTURINI</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="includes/estil.css" media="screen" type="text/css">
    <script type="text/javascript" src="includes/js/zebra.js"></script>
    <script type="text/javascript">window.onload = stripe;</script>
</head>

<body>
<p align="center">
    <font size="3" face="Verdana, Arial, Helvetica, sans-serif">
        <strong>Consultar factures (FACTURINI)</strong>
    </font>
</p>
<p>
    <strong>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <a href="index.htm">Anar a la plana inicial</a>
        </font>
    </strong>
</p>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">
    <strong>Consulta de registres anteriors</strong>
</font>
<form action="consulta_anterior.php" method="post" name="form_2">
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">N&uacute;mero de registre:&nbsp;
    </font>
    <input name="num_reg" type="text" size="11" maxlength="11">
    <input type="submit" name="acceptar" value="Acceptar"><br><br>
</form>
<table width="100%" cellspacing="0">
    <thead>
    <td width="15%">#Registre
        <a href="consultar.php?camp=num_reg&ordre=asc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/>
        </a>
        <a href="consultar.php?camp=num_reg&ordre=desc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_desc.png" alt="Descendent" title="Descendent" width="11" height="9" border="0"/>
        </a>
    </td>
    <td width="15%">Data
        <a href="consultar.php?camp=fecha_solicitud&ordre=asc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/>
        </a>
        <a href="consultar.php?camp=fecha_solicitud&ordre=desc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_desc.png" alt="Descendent" title="Descendent" width="11" height="9" border="0"/>
        </a>
    </td>
    <td width="50%">Nom
        <a href="consultar.php?camp=nom&ordre=asc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/>
        </a>
        <a href="consultar.php?camp=nom&ordre=desc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_desc.png" alt="Descendent" title="Descendent" width="11" height="9" border="0"/>
        </a>
    </td>
    <td width="10%">Estat
        <a href="consultar.php?camp=modificat&ordre=asc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/>
        </a>
        <a href="consultar.php?camp=modificat&ordre=desc&pagina=<?php echo $pagina; ?>">
            <img src="img/s_desc.png" alt="Descendent" title="Descendent" width="11" height="9" border="0"/>
        </a>
    </td>
    <td width="10%">Imprimir</td>
    </thead>
    <tbody>
    <?php while ($array = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td>
                <a href='consulta_anterior.php?num_reg=" <?php echo $array['num_reg'] ?> "'
                   target='_self'>  <?php echo $array['num_reg'] ?></a>
            </td>
            <td><?php echo date_format(date_create($array['fecha_solicitud']), "d/m/Y") ?></td>
            <td><?php echo stripslashes($array['nom']) ?></td>
            <?php if ($array['modificat']) { ?>
                <td> Verificat</td>
            <?php } else { ?>
                <td style='text-decoration: blink; color:red'> Pendent</td>
            <?php } ?>
            <td>
                <a href=imprimir.php?num_reg=" <?php echo $array['num_reg'] ?> target='_blank'> Imprimir </a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
$menu = "<p align='center'>";
if ($pagina > 0) {
    $menu .= "<a href='consultar.php?camp=$camp&ordre=$ordre&pagina=" . ($pagina - 20) . "'>&lt; Anterior</a>";
} else {
    $menu .= "&lt; Anterior";
}
if ($pagina < ($total - 20)) {
    $menu .= "<span style='margin-left:500px'><a
                href='consultar.php?camp=$camp&ordre=$ordre&pagina=" . ($pagina + 20) . "'>Seg&uuml;ent &gt</a></span>";
} else {
    $menu .= "<span style='margin-left:500px'>Seg&uuml;ent &gt</span>";
}
$menu .= "</p>";
echo $menu;
?>
<div style="margin-top: 25px; float: right">
    v0.1
</div>
</body>
</html>
