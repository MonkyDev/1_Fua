<?php
class ParticipacionesController extends ControladorBase {
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
   

  public function index() {

    $ObjQuery = new ModeloBase('', $this->adapter);
    $arraydatas = $ObjQuery->get_all_participaciones_by_alu_anio_actual();
    $ObjDisc = new Disciplinas($this->adapter);
    $arraydis = $ObjDisc->getAll();


    $this->view("participaciones", 
      [
      "title" => "Alumnos entrenando: ".date('Y'),
      "fua" => "Formato Unico Academico",
      "ctl" => "calificaciones",
      "acc" => "crearfua",
      "par" => $arraydatas,
      "dis" => $arraydis,
      ]  
    );

  }


  public function consultar() {

    $this->view("consultar", 
      [
      "title" => "Entrenamiento", 
      "fua" => "Formato Unico Academico",
      "ctl" => "participaciones",
      "acc" => "buscar",
      ]  
    );
  }


  public function buscar(){

    if ( isset($_POST['ipt_search']) AND !empty(trim($_POST['ipt_search'])) ) {
       
    $find = htmlentities($_POST['ipt_search']);
    $ObjClass = new ModeloBase('', $this->adapter);

    if( is_bool($result = $ObjClass->findAlumno(trim($find))) ) $load = 0; else $load = 1;
      
      $this->view("consultar_res", 
        [
          "title" => "resultados de la busqueda", 
          "fua" => "Formato Unico Academico",
          "ctl" => "participaciones",
          "acc" => "entrenadisciplina",
          "load" => $load,
          "datas" => $result
        ]
      );

     #$this->conectar->OutCnx();

    } else 
       $this->redirect($_GET["controller"], ACCION_DEFECTO, ID_DEFECTO);
    
  }


  public function entrenadisciplina() {
    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {
      $_SESSION['uniqe'] = uniqid();
      $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

      $ObjDisciplinas = new Disciplinas($this->adapter);
      $disciplinas = $ObjDisciplinas->getAll();
      $ObjQuery = new ModeloBase('ciclos_escolares', $this->adapter);

      $listCiclos = $ObjQuery->getAll();
      $ciclos = null; 
      $mesLetra = array("01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril',
        "05" => 'Mayo', "06" => 'Junio', "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre',
        "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre');

      foreach($listCiclos AS $rowC){
        $insc = trim($rowC->mes_inicio." / ".$rowC->anio);
        $desc = trim($mesLetra[$rowC->mes_inicio]." / ".$mesLetra[$rowC->mes_fin]." ".$rowC->anio);
        $ciclos .= "<option ciclo='$insc' value='$rowC->id'>$desc</option>";
      }

        if( !is_bool($disciplinas) ) {
          
          $this->view("crear", 
            [
              "title" => "crear participacion", 
              "fua" => "Formato Unico Academico",
              "ctl" => "participaciones",
              "acc" => "guardar",
              "dis" => $disciplinas,
              "ciclos"=> $ciclos,
              "alu" => $catch_id,
              "rndUnk" => $_SESSION['uniqe']
            ]
          );    

        } else 
            die("No se pudo cargar los complemetos...");

    } else {
      die("No se recibio alumno...");
    }

  }


  public function guardar(){
    if ( isset($_POST['cuatro']) AND !empty(trim($_POST['cuatro'])) ) {
      if ( isset($_POST['rndUnk']) AND trim($_POST['rndUnk']) == $_SESSION['uniqe'] ) :

      $participacion = new Participaciones($this->adapter);

      $participacion->set_anio(trim(htmlentities($_POST['dos'])));
      $participacion->set_edo(trim(htmlentities($_POST['tres'])));
      $participacion->set_id_alumno(trim(htmlentities($_POST['cuatro'])));
      $participacion->set_id_ciclo(trim(htmlentities($_POST['seis'])));
      $participacion->set_id_disciplina(trim(htmlentities($_POST['cinco'])));

      unset($_SESSION['uniqe']);

      if ( is_bool($participacion->save()) ) {
        $_SESSION['uniqe'] = uniqid();
        $this->redirect($_GET['controller'], ACCION_DEFECTO, ID_DEFECTO);
        $this->conectar->OutCnx();

      } else
          die("Error en el guardado de participacion. =>".$participacion->save() );

      else:
        $this->redirect($_GET['controller'], ACCION_DEFECTO, ID_DEFECTO);
      endif;

    }else {
      die("No se recibieron parametros esperados...");
    }

  }

  public function universiadas(){
    $ObjQuery = new ModeloBase('', $this->adapter);
    $arraydatas = $ObjQuery->get_all_participacion_calificacion_by_alu_anio_actual();
    $ObjDisc = new Disciplinas($this->adapter);
    $arraydis = $ObjDisc->getAll();

    $this->view("universiadas", 
      [
      "title" => "Alumnos para universiadas: ".date('Y'),
      "fua" => "Formato Unico Academico",
      "ctl" => "reportes",
      "acc" => "formatofua",
      "uni" => $arraydatas,
      "dis" => $arraydis,
      ]  
    );

  }

   
} /*END CLASS*/