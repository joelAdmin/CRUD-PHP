<?php
/* Incluimos el archivo de configuracion */
require_once("dompdf_config.inc.php");


$html = '<html><head>
<title>Prueba 2</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="STYLESHEET" href="css/print_static.css" type="text/css" />
</head>

<body>


<script type="text/php">
$header=$pdf->open_object();
$font = Font_Metrics::get_font("verdana", "bold");
$texto = "Este documento sin el sello y la firma de la oficina sectorial de Control de Estudios, no tiene validez";
$hpagina = $pdf->get_height();
$wpagina = $pdf->get_width();
$wtexto = Font_Metrics::get_text_width($texto, $font, 14);
$valores = "fgndjhvjvjhv";

$pdf->image("css/images/Header.jpg","jpg", 15, 17 , 800, 80);

$pdf->page_text($wpagina/2 - $wtexto/2.30, $hpagina-50, $texto,$Courier, 9, array(0,0,0));
//$pdf->page_text($wpagina/1.20 - $wtexto/120, $hpagina-50,$valores,$Courier, 9, array(0,0,0));
$pdf->page_text($wpagina/2 , $hpagina-35, "Pgna {PAGE_NUM} / {PAGE_NUM}" , $Courier, 9, array(0,0,0));

$pdf->close_object();
$pdf->add_object($header, "all");
</script>


<?php
$var = "inicio";



?>


<h5 align=centre>REPÚBLICA BOLÍVARIANA DE VENEZUELA<br>
UNIVERSIDAD NACIONAL EXPERIMENTAL ROMULO GALLEGOS<br>
INGENIERIA DE SISTEMAS</h5>
<br /><br />
<table class="change_order_items" >
<tbody>
  <tr class="even_row">
        <th>header1</td>
        <th>header 2 </td>
        <th>header3</td>
  </tr>
  <tr class="even_row">
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
  </tr>
 <tr class="even_row">
    <td style="text-align: center"><?php echo $var?></td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
  </tr>
  <tr class="even_row">
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
  </tr>
 <tr class="even_row">
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
  </tr>
 <tr class="even_row">
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
  </tr>
  <tr class="even_row">
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
    <td style="text-align: center">1</td>
  </tr>
  <tbody>
</table>
<br />
<p>

</p>

</body>

</html>';



$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("brochure.pdf", array("Attachment" => 0));
?>
