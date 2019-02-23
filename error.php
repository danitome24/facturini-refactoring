<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>FACTURINI</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<p>&nbsp;</p>
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>-ERROR-</strong></font></p>

<?php
// JV
if (empty($op)) {
    $op = $_POST['op'];
}
//

switch ($op) {
    case "1":
        echo '<br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">El número de registre ja existeix</font><br>';
        break;

    case "2":
        echo '<br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Has de canviar el número de registre</font><br>';
        break;
    case "3":
        echo '<br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Has de canviar el número de registre</font><br>';
        break;
    case "4":
        echo '<br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">No hi ha cap registre amb aquest número</font><br>';
        break;

    default:
        echo '<br><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Error al introduïr el registre a la Base de dades</font><br>';
        break;
}
?>

<p>
    <strong>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <a href="index.htm">Anar a la plana inicial</a>
        </font>
    </strong>
</p>
</body>
</html>
