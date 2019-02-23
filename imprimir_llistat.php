<?php
require_once("config.php");
require_once("includes/sql_layer.php");
include('includes/php-pdf/class.ezpdf.php');

$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);

$regs = $_POST['regs'];

if (isset($regs)) {
    $registres = "";
    foreach ($regs as $clau => $value) {
        $registres .= ("'" . $clau . "', ");
    }

    $consulta = "SELECT num_reg, fecha_solicitud, YEAR(fecha_solicitud) any, nom, adreca, factura, cobrada FROM " . $table_name . " WHERE num_reg IN (" . substr($registres,
            0, -2) . ") ORDER BY num_reg";
    $result = mysqli_query($dbi, $consulta) or die (mysqli_error());
    while ($array = mysqli_fetch_assoc($result)) {
        $factures[] = $array;
    }

    $any = $factures[0]['any'];

    $pdf = new Cezpdf('a4');
    $pdf->selectFont('includes/php-pdf/fonts/Helvetica.afm');

    $nom = utf8_decode("FACTURACIÓ INTERNA SOL·LICITADA");
    $data = array(
        array("camp" => "<b>FACTURINI                                                                                                 " . $any . "</b>"),
        array("camp" => ""),
        array("camp" => "<b>$nom</b>")
    );
    $pdf->ezTable($data, array('camp' => ''), '',
        array('showHeadings' => 0, 'shaded' => 0, 'xPos' => 580, 'xOrientation' => 'left', 'width' => 550));

    $pdf->ezText("\n", 10, 'left');
    $data = array();
    $total_facturat = 0;
    $total_cobrat = 0;
    foreach ($factures as $taula) {
        $total_facturat += $taula['factura'];
        if ($taula['cobrada']) {
            $total_cobrat += $taula['factura'];
            $taula['cobrada'] = $taula['factura'];
            $taula['cobrada'] .= chr(128);
        } else {
            $taula['cobrada'] = "";
        }
        $taula['factura'] .= chr(128);

        $taula['fecha_solicitud'] = date_format(date_create($taula['fecha_solicitud']), "d/m/Y");
        $data[] = array(
            "camp" => $taula['num_reg'],
            "camp2" => $taula['fecha_solicitud'],
            "camp3" => $taula['nom'],
            "camp4" => $taula['adreca'],
            "camp5" => $taula['factura'],
            "camp6" => $taula['cobrada']
        );
    }
    $num_fils = count($factures);

    for ($i = $num_fils; $i <= 30; $i++) {
        $data[] = array("camp" => "", "camp2" => "", "camp3" => "", "camp4" => "", "camp5" => "", "camp6" => "");
    }

    $pdf->ezTable($data, array(
        'camp' => '<b>REGISTRE</b>',
        'camp2' => '<b>DATA</b>',
        'camp3' => '<b>USUARI</b>',
        'camp4' => '<b>LLOC COST</b>',
        'camp5' => '<b>FACTURAT</b>',
        'camp6' => '<b>COBRAT</b>'
    ), '', array(
        'showHeadings' => 1,
        'titleFontSize' => 10,
        'fontSize' => 9,
        'shaded' => 1,
        'xPos' => 580,
        'xOrientation' => 'left',
        'width' => 550,
        'cols' => array(
            'camp' => array('justification' => 'center'),
            'camp2' => array('width' => 56),
            'camp5' => array('width' => 60),
            'camp6' => array('width' => 60)
        )
    ));

    $pdf->ezText("\n", 10, 'left');

    $data = array(
        array("camp" => "<b>TOTAL FACTURAT: </b>" . $total_facturat . chr(128) . "                                                                                                 <b>TOTAL COBRAT: </b>" . $total_cobrat . chr(128))
    );
    $pdf->ezTable($data, array('camp' => ''), '',
        array('showHeadings' => 0, 'shaded' => 0, 'xPos' => 580, 'xOrientation' => 'left', 'width' => 550));


    $pdf->ezStream();

} else {
    ?>
    <p align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Llistar factures
                (FACTURINI)</strong></font></p>
    <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="llistar.php">Anar a la plana
                    anterior</a></font></strong></p>
    <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Has de seleccionar els registres que vulguis
            imprimir.</font></p>
    <?php
}
?>