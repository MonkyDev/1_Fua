<?php
class CalificacionesController extends ControladorBase {
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


  public function crearfua(){

    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {
        $_SESSION['uniqe'] = uniqid();

        $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

        $find = htmlentities( trim($catch_id) );
        $ObjCalificaciones = new ModeloBase("materias", $this->adapter);

        $ObjAlumno = new ModeloBase("alumnos",$this->adapter);
        $alumno = $ObjAlumno->getById($find);
        $cic_alu = $ObjAlumno->get_info_alumno_grado_ciclo($find);

        $ciclo_anterior = $this->ObjFmTxt->calc_backward_ciclo($cic_alu->grado, $cic_alu->mes_inicio, $cic_alu->anio, $cic_alu->fk_planesc);

        $result = $ObjAlumno->find_ciclo_backward($ciclo_anterior);
        if (is_bool($result))
          die('Uppss, algo salió mal al encontrar un ciclo anterior próximo.');  
        else
          $id_ciclo_anterior = $result->id;
        
          if( !is_bool($materias = $ObjCalificaciones->get_materias_alumno_grado($find)) ) {
            
            $this->view("crear", 
              [
                "title" => "crear calificacion", 
                "fua" => "Formato Unico Academico",
                "ctl" => "calificaciones",
                "acc" => "guardar",
                "materias" => $materias,
                "alumno" => $alumno,
                "id_ciclo_back" => $id_ciclo_anterior,
                "rndUnk" => $_SESSION['uniqe'],
              ]
            );    

          } else 
              die("No se pudo encontrar materias a capturar...");

      } else {
        die("No se recibio alumno...");
      }

  }



  public function guardar() {

    if ( isset($_POST['tres']) AND isset($_POST['cuatro']) ) {
      if ( isset($_POST['rndUnk']) AND trim($_POST['rndUnk']) == $_SESSION['uniqe'] ) :

      $calificacion = new Calificaciones($this->adapter);
      $ObjCalf = new ModeloBase('', $this->adapter);

      $find = htmlentities(trim($_POST['cuatro']));
      $res = $ObjCalf->findAlumnoXCalficaciones(trim($find));

      if ( is_array($res) && $res[0]->id_cic == $_POST['tres'])
        die("Existe un registro de calificaciones en el ciclo actual del alumno...");

      $ix=["A","B","C","D","E","F","G","H","I","J","K","L","M"];
      $valor = "dos_";
      $materia = "cinco_";
      $up = false;
        foreach ($ix as $i) :
          if ( isset($_POST[$materia.$i]) ) {

            $calificacion->set_valor(trim(htmlentities($_POST[$valor.$i])));
            $calificacion->set_id_ciclo(trim(htmlentities($_POST['tres'])));
            $calificacion->set_id_alumno(trim(htmlentities($_POST['cuatro'])));
            $calificacion->set_id_materia(trim(htmlentities($_POST[$materia.$i])));

            if ( is_bool($calificacion->save()) ){
              $up = true;
              unset($_SESSION['uniqe']);
            }
            else
              die("Error en el guardado de calificaciones. =>".$calificacion->save() );

          } else {
              if ($up) {
                $this->redirect("participaciones", "universiadas", ID_DEFECTO);
                $this->conectar->OutCnx();

              } else
                  die("Error en el procesamiento de las calificaciones. =>".$calificacion->save());
          }           
        endforeach;

      else:
        $this->redirect($_GET['controller'], ACCION_DEFECTO, ID_DEFECTO);
      endif;     

    } else {
        die("No se recibio alumno...");
    }

  }

   
}