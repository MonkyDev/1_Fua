<?php
header('Content-Type: text/html; charset=utf-8');
$participa = unserialize(stripslashes ($_GET['datasPart']));
$calificacion = unserialize(stripslashes ($_GET['datasCalf']));
$materias = unserialize(stripslashes ($_GET['datasMate']));

require_once '../../larva/mi-laravel/vendor/autoload.php';
require_once "../vendor/includes/class/FormatText.php";

$ObjFmTxt = new FormatText();

$timeo_start = microtime(true);
ini_set("memory_limit","280824M");
ini_set('max_execution_time', 400);

ob_start();


$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8', 
  'format' => 'Letter', 
  'orientation' => 'P' //L
]);


$pref="";
if ($participa->sexo == 'H')
  $pref="el alumno";
else
  $pref="la alumna";

$mod = "";
if ($participa->fk_planesc == 'SEM') 
  $mod = "SEMESTRE";
else
  $mod = "CUATRIMESTRE";


  $prt = explode("/", $participa->fecha_curso);
  $ciclo_actual_ini = $ObjFmTxt->str_fech( $prt[0] , $participa->anio );
  $ciclo_actual_fin = $ObjFmTxt->str_fech( $prt[1] , $participa->anio );

  $part = str_replace("/", "-", $participa->inscripcion);
  $ingreso = $ObjFmTxt->str_fech(substr($part, 0, 5), substr($part, -4));

  $cprt = explode("/", $calificacion[0]->fecha_curso);
  $ciclo_ante_ini = $ObjFmTxt->str_fech( ($cprt[0]) , $calificacion[0]->anio );
  $ciclo_ante_fin = $ObjFmTxt->str_fech( ($cprt[1]) , $calificacion[0]->anio );


  $fecha_calf = str_replace("-", "/", $cprt[1])."/".$calificacion[0]->anio;

/*border-width: 3px;border-bottom: double rgb(36, 92, 77);*/
$encabezado =
'<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">

body {font-family: "Arial, Helvetica", sans-serif;}
.text  { font-size:12px;}
.text2 {font-size:12px;text-align:justify;}
.text3 {font-size:12px;}
.text4 {font-size:10px;text-align:justify;}
.text5 {font-size:9px;text-align:justify;}
.titulos {font-size:17px;}
.bg {background-color:#E9E9E9;}

.e3 {border-width: 1px;border-bottom: solid rgb(36, 92, 77);}
.e4 {border-width: 5px;border-top: solid rgb(36, 92, 77); margin-top:2px;}

.tbl1 {border-top:solid 1px black;border-right:solid 1px black;border-left:solid 1px black;}
.td {border-bottom:solid 1px black;}
.td1 {border-right:solid 1px black;}

</style>
</head>

<body>

<table cellpadding="0" cellspacing="0" width="805" align="center" class="e3 titulos">
  <tr>
    <td><div><img src="../assets/images/salazar/logo_uni.png" height="80" width="80"/></div></td>
    <td>
      <center>
      <b>INSTITUTO DE ESTUDIOS SUPERIORES DE CHIAPAS EN TUXTLA GUTIÉRREZ, S.C.
      </center>
    </td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="805" class="e4"><tr><td>&nbsp;</td></tr></table>

<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="titulos">
  <tr>
    <td width="20"><div><img src="http://'.$_SERVER['HTTP_HOST'].'/sia/'.$participa->foto.'" height="100"/></div></td>
    <td>
      <center>
      <b>FORMATO UNICO ACADEMICO
      </center>
    </td>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text">
  <tr><td>A QUIEN CORRESPONDA</td></tr>
  <tr><td>PRESENTE.</td></tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
</table>
<br>

<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text2">
  <tr>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  El que suscribe, director de Asuntos Estudiantiles del <b><u>INSTITUTO DE ESTUDIOS SUPERIORES DE CHIAPAS (IESCH)</u></b>, con clave <b><u>07PSU0002D</u></b> hace constar que '.$pref.' <b><u>'.strtoupper($participa->NombreCompleto).'</u></b>, es '.substr($pref, -6).' regular en esta Institución, cursa actualmente el <b><u>'.$participa->grado.'o '.strtoupper($mod).'</u></b> de  <b><u>'.strtoupper($participa->nombre).'</u></b>, comprendido del <b><u>'.$ciclo_actual_ini.'</u></b> al <b><u>'.$ciclo_actual_fin.'</u></b> del ciclo escolar <b><u>'.$participa->anio.'</u></b>, cuyos documentos obran en el archivo general de esta Institución y en expediente personal d'.$pref.' con número de matrícula: <b><u>'.$participa->matricula.'</u></b>  y fecha de ingreso a esta Institución <b><u>'.$ingreso.'</u></b> obteniendo las calificaciones del semestre anterior que se mencionan a continuación:
  </td>
  </tr>
  <tr><td></td></tr>
</table>
<br>

<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text">
  <tr><td><center><b>SEMESTRE PRÓXIMO ANTERIOR</center></td></tr>
  <tr><td><center>Fecha de Inicio: <b><u>'.$ciclo_ante_ini.'</u></b> Termina : <b><u>'.$ciclo_ante_fin.'</u></b></center></td></tr>
</table>

';

$tableCalf_head = '
<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text5 tbl1">
  <tr>
    <td class="bg td td1" width="405"><center><b>MATERIAS</center></td>
    <td class="bg td td1" width="100"><center><b>CALIFICACIÓN</center></td>
    <td class="bg td" width="100"><center><b>FECHA</center></td>
  </tr>
';

$tableCalf_foot = '</table>';

$rows = count($calificacion);
$table_create_blank = "";
if ($rows < 10) {
  $blank = 10 - $rows;
  for ($i=1; $i<=$blank; $i++) {
    $table_create_blank .= '
      <tr>
        <td width="405" class="td td1"><center>&nbsp;</center></td>
        <td width="100" class="td td1"><center><b>&nbsp;</center></td>
        <td width="100" class="td"><center><b>&nbsp;</center></td>
      </tr>
    ';
  }
}

$tableCalf_body = '';

foreach ($calificacion as $rowCalf) {
  $tableCalf_body .= '
    <tr>
      <td width="405" class="td td1"><center>'.strtoupper(html_entity_decode($rowCalf->nombre)).'</center></td>
      <td width="100" class="td td1"><center>'.$rowCalf->valor.'</center></td>
      <td width="100" class="td"><center>'.$fecha_calf.'</center></td>
    </tr>
  ';
}

$tab_calf = $tableCalf_head.$tableCalf_body.$table_create_blank.$tableCalf_foot;



$midBody = '
<br>
<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text">
  <tr><td><center><b>SEMESTRE ACTUAL</center></td></tr>
  <tr>
    <td><center>Fecha de Inicio: <b><u>'.$ciclo_actual_ini.'</u></b> Termina : <b><u>'.$ciclo_actual_fin.'</u></b></center></td>
  </tr>
</table>
';


$tableMate_head = '
<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text5 tbl1 ">
  <tr>
    <td class="bg td"><center><b>MATERIAS</center></td>
  </tr>
';


$tableMate_foot = '</table>';

$rows = count($materias);
$table_create_blank = "";
if ($rows < 10) {
  $blank = 10 - $rows;
  for ($i=1; $i<=$blank; $i++) {
    $table_create_blank .= '
      <tr>
        <td width="455" class="td"><center>&nbsp;</center></td>
      </tr>
    ';
  }
}

$tableMate_body = '';

foreach ($materias as $rowMate) {
  $tableMate_body .= '
    <tr>
      <td class="td"><center>'.strtoupper(html_entity_decode($rowMate->nomb_mat)).'</center></td>
    </tr>
  ';
}


$tab_mate = $tableMate_head.$tableMate_body.$table_create_blank.$tableMate_foot;
$date = date('Y-m-d');
$pt = explode("-", $date);
$day = (int)($pt[2]);
$mon = (int)($pt[1]);
$year = (int)($pt[0]);

$head = '

<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text2">
  <tr>
  <td>A petición de la parte interesada para los fines legales que a la misma convengan, se extiende la presente en la ciudad de '.$ObjFmTxt->date_today_print().'.
  </td>
  </tr>
</table>
<br>
';

$tableFirma = '
<table cellpadding="0" cellspacing="0" border="0" width="605" align="center" class="text3">
  <tr><td><center>ATENTAMENTE</center></td></tr>
  <tr><td><center>&nbsp;</center></td></tr>
  <tr><td><center><b><u>LEM. PERLA SANTILLAN FARRERA</center></td></tr>
  <tr><td><center>JEFA DEL  DEPARTAMENTO DE ASUNTOS ESTUDIANTILES</center></td></tr>
</table>
';
/*
$tableInfo = '
<table border="0" width="605" align="center" class="text4">
  <tr><td><center>BLVD. PASO LIMON NO. 244 TELS. 61 4 04 18, 61 4 16 21, 61 4 16 26, 61 4 04 19, TUXTLA GUTIÉRREZ</center></td></tr>
  <tr><td></td></tr>
  <tr><td><center>Correo electrónico estudiantiles@iesch.edu.mx &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WEB. <u>www.iesch.edu.mx</u></center></td></tr>
</table>
';*/

$DOM = $encabezado.$tab_calf.$midBody.$tab_mate.$head.$tableFirma.$tableInfo;
//$mpdf->AddPage('P','','','','','','','','','','');
$mpdf->SetFooter('blvd. paso limon no. 244; tel. 61 4 04 18|estudiantiles@iesch.edu.mx|www.iesch.edu.mx');
$mpdf->WriteHTML($DOM);
$mpdf->Output('fua_alumno_'.$participa->matricula.'.pdf','I');
