<?php
if ( isset($_GET['datasPart']) AND !empty($_GET['datasPart']) ) :
//var_dump($_GET['datasPart']);die;

$participa = unserialize(stripslashes ($_GET['datasPart']));

require_once '../../larva/mi-laravel/vendor/autoload.php';
require_once "../vendor/includes/class/FormatText.php";

$ObjFmTxt = new FormatText();

$timeo_start = microtime(true);
ini_set("memory_limit","280824M");
ini_set('max_execution_time', 400);
ob_start();

if (count($participa) == 1 ){
  $anio = $participa->anio;
  $descripcion = $participa->descripcion;
  $mes_per = (int)($participa->registro);
  if ($mes_per >= 1 AND $mes_per <= 6) 
    $desc_per = 'ENERO - JUNIO DEL ' ;
  else
    $desc_per = 'JULIO - DICIEMBRE DEL ';
  
}
else{
  $anio = $participa[0]->anio;
  $descripcion = $participa[0]->descripcion;
  $mes_per = (int)($participa[0]->registro);
  if ($mes_per >=1  AND $mes_per <= 6) 
    $desc_per = 'ENERO - JUNIO DEL ';
  else
    $desc_per = 'JULIO - DICIEMBRE DEL ';
}


$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8', 
  'format' => 'Letter', 
  'orientation' => 'P' //L
]);

$encabezado =
'<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">

body {font-family: "Arial, Helvetica", sans-serif;}
.text  { font-size:12px;}
.text2 {font-size:11px;text-align:justify;}
.titulos {font-size:15px;}
.bg {background-color:#E9E9E9;}

.e3 {border-width: 1px;border-bottom: solid rgb(36, 92, 77);}
.e4 {border-width: 5px;border-top: solid rgb(36, 92, 77); margin-top:2px;}

.tbl1 {border-top:solid 1px black;border-right:solid 1px black;border-left:solid 1px black;}
.td {border-bottom:solid 1px black;}
.td1 {border-right:solid 1px black;}

</style>
</head>

<body>

<table cellpadding="0" cellspacing="0" border="0" width="805" align="center" class="titulos e3">
  <tr>
    <td><div><img src="../assets/images/salazar/logo_uni.png" height="80" width="80"/></div></td>
    <td>
      <center>
      <b>INSTITUTO DE ESTUDIOS SUPERIORES DE CHIAPAS EN TUXTLA GUTIÉRREZ, S.C.
      </center>
    </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="805" align="center" class="e4 titulos">
  <tr><td>&nbsp;</td>
  <tr><td><center><b>REPORTE GENERAL DE ALUMNOS EN ACTIVIDADES DEPORTIVAS</center></td>
  <tr><td><center><b>PERIODO '.$desc_per.$anio.'</center></td>
</table>
<br>
';

$tablePart_head = '
<table cellpadding="0" cellspacing="0" border="0" width="805" align="center" class="text2 tbl1">
  <tr>
    <td class="bg td td1"><center><b>#</center></td>
    <td class="bg td td1"><center><b>MATRICULA</center></td>
    <td class="bg td td1"><center><b>NOMBRE</center></td>
    <td class="bg td td1"><center><b>GRADO</center></td>
    <td class="bg td td1"><center><b>CARRERA</center></td>
    <td class="bg td"><center><b>DEPORTE</center></td>
  </tr>
';

$tablePart_foot = '</table>';

$tablePart_body = '';
$i=0;

if (count($participa) == 1 ) {
  $rowPart = $participa;
  $tablePart_body .= '
    <tr>
      <td class="td td1"><center>'.(++$i).'</center></td>
      <td class="td td1"><center>'.$rowPart->matricula.'</center></td>
      <td class="td td1"><center>'.ucwords($rowPart->nomb_alumno).'</center></td>
      <td class="td td1"><center>'.$rowPart->grado.'o</center></td>
      <td class="td td1"><center>'.ucwords($rowPart->desc_carrera).'</center></td>
      <td class="td"><center>'.ucwords($rowPart->descripcion).'</center></td>
    </tr>
  ';
} else {
  foreach ($participa as $rowPart) {
    $tablePart_body .= '
      <tr>
        <td class="td td1"><center>'.(++$i).'</center></td>
        <td class="td td1"><center>'.$rowPart->matricula.'</center></td>
        <td class="td td1"><center>'.ucwords($rowPart->nomb_alumno).'</center></td>
        <td class="td td1"><center>'.$rowPart->grado.'o</center></td>
        <td class="td td1"><center>'.ucwords($rowPart->desc_carrera).'</center></td>
        <td class="td"><center>'.ucwords($rowPart->descripcion).'</center></td>
      </tr>
    ';
  }
}



$tab_Part = $tablePart_head.$tablePart_body.$tablePart_foot;


$DOM = $encabezado.$tab_Part;
//$mpdf->AddPage('P','','','','','','','','','','');
$mpdf->SetFooter('LED. Luigi Palacios Urbina| Promotor Deportivo y Cultural | '.date('d/m/Y'));
$mpdf->WriteHTML($DOM);
$mpdf->Output('fua_participacion_'.$descripcion.'_'.$anio.'.pdf','I');

else : 
  die("No se recibieron parametros del servidor...");

endif;