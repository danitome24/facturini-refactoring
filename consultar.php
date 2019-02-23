<?php
require_once("config.php");
require_once("includes/sql_layer.php");
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

<?php
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

echo '<p align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consultar factures (FACTURINI)</strong></font></p>';
echo '<p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.htm">Anar 
  a la plana inicial</a></font></strong> </p>';

echo '<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulta de registres anteriors</strong></font>';
echo '<form action="consulta_anterior.php" method="post" name="form_2">';
echo '<font size="2" face="Verdana, Arial, Helvetica, sans-serif">N&uacute;mero de registre:&nbsp;</font><input name="num_reg" type="text" size="11" maxlength="11"> ';
echo '<input type="submit" name="acceptar" value="Acceptar"><br><br>';
echo '</form>';
?>
<!-- <table width='85%' border='1' style='font-size:12px; border-collapse:collapse; border-style:solid;'> -->
<table width="100%" cellspacing="0">
    <thead>
    <td width="15%">#Registre <a href="consultar.php?camp=num_reg&ordre=asc&pagina=<?php echo $pagina; ?>"><img
                    src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/></a><a
                href="consultar.php?camp=num_reg&ordre=desc&pagina=<?php echo $pagina; ?>"><img src="img/s_desc.png"
                                                                                                alt="Descendent"
                                                                                                title="Descendent"
                                                                                                width="11" height="9"
                                                                                                border="0"/></a></td>
    <td width="15%">Data <a href="consultar.php?camp=fecha_solicitud&ordre=asc&pagina=<?php echo $pagina; ?>"><img
                    src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/></a><a
                href="consultar.php?camp=fecha_solicitud&ordre=desc&pagina=<?php echo $pagina; ?>"><img
                    src="img/s_desc.png" alt="Descendent" title="Descendent" width="11" height="9" border="0"/></a></td>
    <td width="50%">Nom <a href="consultar.php?camp=nom&ordre=asc&pagina=<?php echo $pagina; ?>"><img
                    src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/></a><a
                href="consultar.php?camp=nom&ordre=desc&pagina=<?php echo $pagina; ?>"><img src="img/s_desc.png"
                                                                                            alt="Descendent"
                                                                                            title="Descendent"
                                                                                            width="11" height="9"
                                                                                            border="0"/></a></td>
    <td width="10%">Estat <a href="consultar.php?camp=modificat&ordre=asc&pagina=<?php echo $pagina; ?>"><img
                    src="img/s_asc.png" alt="Ascendent" title="Ascendent" width="11" height="9" border="0"/></a><a
                href="consultar.php?camp=modificat&ordre=desc&pagina=<?php echo $pagina; ?>"><img src="img/s_desc.png"
                                                                                                  alt="Descendent"
                                                                                                  title="Descendent"
                                                                                                  width="11" height="9"
                                                                                                  border="0"/></a></td>
    <td width="10%">Imprimir</td>
    </thead>
    <?php
    echo "<tbody>";
    if ($camp == "modificat") {
        $camp = "modificat " . $ordre . ", num_reg desc";
        $ordre = "";
    }
    $query = "SELECT num_reg, fecha_solicitud, nom, modificat from " . $table_name . " order by " . $camp . " " . $ordre . " limit " . $pagina . ",20";
    $result = mysqli_query($dbi, $query) or die (mysqli_error());

    while ($array = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><a href='consulta_anterior.php?num_reg=" . $array['num_reg'] . "' target='_self'> " . $array['num_reg'] . " </a></td>";
        echo "<td> " . date_format(date_create($array['fecha_solicitud']), "d/m/Y") . " </td>";
        echo "<td> " . stripslashes($array['nom']) . " </td>";
        if ($array['modificat']) {
            echo "<td> Verificat </td>";
        } else {
            echo "<td style='text-decoration: blink; color:red'> Pendent </td>";
        }
        echo "<td><a href=imprimir.php?num_reg=" . $array['num_reg'] . " target='_blank'> Imprimir </a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    $menu = "<p align='center'>";
    if ($pagina > 0) {
        $menu .= "<a href='consultar.php?camp=$camp&ordre=$ordre&pagina=" . ($pagina - 20) . "'>&lt; Anterior</a>";
    } else {
        $menu .= "&lt; Anterior";
    }
    if ($pagina < ($total - 20)) {
        $menu .= "<span style='margin-left:500px'><a href='consultar.php?camp=$camp&ordre=$ordre&pagina=" . ($pagina + 20) . "'>Seg&uuml;ent &gt</a></span>";
    } else {
        $menu .= "<span style='margin-left:500px'>Seg&uuml;ent &gt</span>";
    }
    $menu .= "</p>";
    echo $menu;
    ?>
</body>
</html>
