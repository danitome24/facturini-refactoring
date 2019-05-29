<?php
require_once 'config.php';
require_once 'includes/sql_layer.php';
require_once __DIR__ . '/vendor/autoload.php';

if (empty($num_reg)) {
    $num_reg = $_REQUEST['num_reg'];
}

$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
sql_query("SET NAMES utf8", $dbi);
$result = sql_query("select * from " . $table_name . " where num_reg='" . $num_reg . "'", $dbi);

if (isset($num_reg) && mysqli_num_rows($result) > 0) {
    $res = sql_fetch_array($result, $dbi);
    $pdf = new Cezpdf('a4');
    $pdf->selectFont(__DIR__ . '/vendor/rebuy/ezpdf/src/ezpdf/fonts/Helvetica.afm');
    $pdf->ezText("Facturini\n", 8, array('left' => 45));
    $pdf->ezText("Carrer major, 7", 6, array('left' => 45));
    $pdf->ezText("40000 Barcelona", 6, array('left' => 45));
    $pdf->ezText("A/e: hello@facturini.es\n\n\n\n\n\n", 6, array('left' => 45));

    $pdf->ezText("<b>Registre num:</b> " . $res['num_reg'], 10, 'left');
    $pdf->ezText("<b>Data:</b> " . date_format(date_create($res['fecha_solicitud']), "d/m/Y") . "\n\n", 10, 'left');


    $data = array(
        array("camp" => "<b>Nom:</b> " . stripslashes($res['nom'])),
        array("camp" => utf8_decode("<b>Adreça:</b> ") . stripslashes($res['adreca'])),
        array("camp" => "<b>NIF:</b> " . stripslashes($res['nif']))
    );
    $pdf->ezTable($data, array('camp' => ''), '',
        array('showHeadings' => 0, 'shaded' => 0, 'xPos' => 535, 'xOrientation' => 'left', 'width' => 500));
    $pdf->ezText("\n\n", 10, 'left');
    $detalls = explode("\n", stripslashes($res['detalls']));

    $data = array(
        array("camp" => "<b>Concepte:</b>")
    );

    foreach ($detalls as $value) {
        if ($value != "\r") {
            $data[] = array("camp" => $value);
        }
    }

    $mida = count($data);
    for ($i = 14; $i > $mida; $i--) {
        $data[] = array("camp" => "");
    }
    $data[] = array("camp" => "<b>Total:</b> " . $res['factura'] . chr(128));

    $pdf->ezTable($data, array('camp' => ''), '',
        array('showHeadings' => 0, 'shaded' => 0, 'xPos' => 535, 'xOrientation' => 'left', 'width' => 500));

    $pdf->ezText("\n\n", 10, 'left');

    $data = array(
        array("camp" => "<b>Observacions:</b>"),
        array("camp" => stripslashes($res['observacions'])),
        array("camp" => ""),
        array("camp" => "")
    );
    $pdf->ezTable($data, array("camp" => ""), "",
        array('showHeadings' => 0, 'shaded' => 0, 'xPos' => 535, 'xOrientation' => 'left', 'width' => 500));


    $pdf->ezText("\n\n", 10, 'left');
    $pdf->ezStream();
} else {
    ?>
    <p align="center">
        <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Imprimir factura (FACTURINI)</strong></font>
    </p>
    <p>
        <strong>
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <a href="index.htm">Anar a la plana inicial</a>
            </font>
        </strong>
    </p>
    <p>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">No hi ha cap registre amb aquest
            n&uacute;mero.</font>
    </p>
    <?php
}
?>
