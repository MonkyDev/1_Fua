<?php
class AlumnosController extends ControladorBase {
  public $conectar;
  public $adapter;
  public $secure;
  private $val;


  public function __construct() {
    parent::__construct();
    
    $this->conectar = new Conectar();
    $this->secure   = new Middleware();
    $this->adapter  = $this->conectar->cnxMySqli();
  }


  private function uncrypt($val, $pos){

    $prt = explode("x", $val);
    $this->val = $prt[$pos];

  return $this->val;
  }

  
  public function index(){
    $this->view("consultar", 
     [
      "title" => "consultar", 
      "fua"   => "Formato Unico Academico",
      "ctl"   => "alumnos",
      "acc"   => "buscar"     
    ]  
    );
  }


  public function buscar(){

    if ( isset($_POST['ipt_search']) AND !empty(trim($_POST['ipt_search'])) ) {
       
    $find = htmlentities($_POST['ipt_search']);
    $ObjAlumno = new ModeloBase('',$this->adapter);

    if( is_bool($result = $ObjAlumno->findAlumno(trim($find))) ) $load = 0; else $load = 1;

      $this->view("consultar_res", [
                  "title" => "resultados de la busqueda", 
                  "fua" => "Formato Unico Academico",
                  "ctl" => "alumnos",
                  "acc" => "ver",
                  "load" => $load,
                  "datas" => $result
                 ]
      );

    $this->conectar->OutCnx();
    } else 
       $this->redirect("alumnos", "index", ID_DEFECTO);
    
    
  }


  public function ver(){

    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {

    $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

    $ObjQuery = new ModeloBase('ciclos_escolares',$this->adapter);
    $listGroup = $ObjQuery->getAllGruposXCarrerasXModalidad();
    $listCiclos = $ObjQuery->getAll();
    $ciclos = null; 
    $grupos = null;
    $mesLetra = array("01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril',
          "05" => 'Mayo', "06" => 'Junio', "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre',
          "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre');

    if ( !is_bool($listGroup) AND !is_bool($listCiclos)) {

      foreach($listGroup AS $rowG){
        $grupos .= "<option grado='$rowG->grado' plan='$rowG->fk_planesc' value='$rowG->id_grupo'>$rowG->desc_gpo</option>";
      }
      foreach($listCiclos AS $rowC){
        $insc = trim($rowC->mes_inicio." / ".$rowC->anio);
        $desc = trim($mesLetra[$rowC->mes_inicio]." / ".$mesLetra[$rowC->mes_fin]." ".$rowC->anio);
        $ciclos .= "<option curso='$rowC->fecha_curso' ciclo='$insc' value='$rowC->id'>$desc</option>";
      }

      $ObjAlumno = new ModeloBase('alumnos',$this->adapter);
      $result = $ObjAlumno->getById($catch_id);

      $this->view("ver", 
        [
          "title" => "Datos del alumno", 
          "fua" => "Formato Unico Academico",
          "prm" => $result,
          "grupos"=> $grupos,
          "ciclos"=> $ciclos
       ]
      );

      $this->conectar->OutCnx();

    }else 
      die ("No es posible cargar el modulo, por falta de componentes...");
    
    }else 
      die ("No se recibieron parametros esperados...");

  }


   
} /*END CLASS*/
