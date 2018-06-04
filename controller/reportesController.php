<?php
class ReportesController extends ControladorBase {
  public $conectar;
  public $adapter;
  public $ObjFmTxt;
  public  $secure;
  private $val;

  public function __construct() {
    parent::__construct();
    
    $this->conectar = new Conectar();
    $this->secure   = new Middleware();
    $this->adapter = $this->conectar->cnxMySqli();
    $this->ObjFmTxt = new FormatText();
  }
  
  
  private function uncrypt($val, $pos){

    $prt = explode("x", $val);
    $this->val = $prt[$pos];

  return $this->val;
  }



  public function buscar_by_disciplina(){
    $ObjQuery = new ModeloBase("participaciones", $this->adapter);
    if ( isset($_GET['id']) ) {

      $prt = explode("X", $_GET['id']);
      $anio = $prt[1];
      $id_disc = $prt[0];

      if ($id_disc == 99)
        $result  = $ObjQuery->get_id_alu_by_anio( trim($anio) );        
      else
        $result  = $ObjQuery->get_id_alu_by_anio_disc( trim($anio), trim($id_disc) );

      $datasAlu = $result;
      $datasAlu = serialize($datasAlu);
      $datasAlu = urlencode($datasAlu);

      $string ="?datasPart=".$datasAlu;


    } else 
      die("Error al recibir parametros del formulario...");

  return $string;
  }



  public function imprimir(){
    if ( $string = $this->buscar_by_disciplina() ) 
      header("Location: ../../reportes/reporte_fua_grupal.php".$string);
    else 
      die("No se encontraron alumnos...");
  }


  public function buscar_by_periodo(){
    $ObjQuery = new ModeloBase("participaciones", $this->adapter);
    if ( isset($_GET['id']) ) {

      $prt = explode("X", $_GET['id']);
      $perio = $prt[0];
      $anio = $prt[1];
      $status = $prt[2];
      if ( $perio == 1 )
        $per = "'01' AND '06'";
      else
        $per = "'07' AND '12'";

      $result  = $ObjQuery->get_id_alu_by_periodo_edo( trim($anio), trim($per), trim($status) );

      $datasAlu = $result;
      $datasAlu = serialize($datasAlu);
      $datasAlu = urlencode($datasAlu);

      $string ="?datasPart=".$datasAlu;


    } else 
      die("Error al recibir parametros del formulario...");

  return $string;
  }


  public function listatriny(){
    if ( $string = $this->buscar_by_periodo() ) 
      header("Location: ../../reportes/reporte_lista_registros.php".$string);
    else 
      die("No se encontraron alumnos...");
  }



  public function formatofua(){
    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {
    
      $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

      $ObjQuery = new ModeloBase('', $this->adapter);
      $participacion = $ObjQuery->get_info_registro_participacion( $catch_id );

      if ( !is_bool($participacion) ):
      $ciclo_anterior = $this->ObjFmTxt->calc_backward_ciclo($participacion->grado, $participacion->mes_inicio, $participacion->anio, $participacion->fk_planesc);

      $result = $ObjQuery->find_ciclo_backward($ciclo_anterior);
      $id_ciclo_anterior = $result->id;

      $calificacion = $ObjQuery->get_calificacion_materia($id_ciclo_anterior, $participacion->id_alu);
      
      $materias = $ObjQuery->get_materias_ciclo_actual_alumno_grado($participacion->id_alu);
      
        if ( is_bool($participacion) || is_bool($calificacion) || is_bool($materias))
          die("Error al tratar de obtener complementos de la base de datos...");

      $string = "";

      $datasPart = $participacion;
      $datasPart = serialize($datasPart);
      $datasPart = urlencode($datasPart);

      $datasCalf = $calificacion;
      $datasCalf = serialize($datasCalf);
      $datasCalf = urlencode($datasCalf);

      $datasMate = $materias;
      $datasMate = serialize($datasMate);
      $datasMate = urlencode($datasMate);

      $string ="?datasPart=".$datasPart."&datasCalf=".$datasCalf."&datasMate=".$datasMate;
      
      header("Location: ../../reportes/reporte_fua_individual.php".$string);
    else:
      die("No se pudieron obtener los datos necesarios del reporte...");
    endif;
    }
  }
   
} /*END CLASS*/