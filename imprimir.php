<?php

use Facturini\Database\Mysqli\MysqliConnection;
use Facturini\Database\Mysqli\MysqliQuery;

require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

if (empty($num_reg)) {
    $num_reg = $_REQUEST['num_reg'];
}
$dbConnection = MysqliConnection::create($dbhost, $dbuname, $dbpass, $dbname);
$dbQuery = new MysqliQuery($dbConnection, false);

$result = $dbQuery->query('select * from ' . $table_name . " where num_reg='" . $num_reg . "'");

if (isset($num_reg) && $result->numberOfResults() > 0) {
    $res = $result->inArray();
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
    $dbConnection->disconnect();
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
