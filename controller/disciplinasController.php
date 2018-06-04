 <?php
class DisciplinasController extends ControladorBase {
  public  $conectar;
  public  $adapter;
  public  $secure;
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

   
  public function index() {    

    $ObjDisciplinas = new Disciplinas($this->adapter);
    $result = $ObjDisciplinas->getAll();
    
    $this->view("disciplinas", 
      [
        "title" => "disciplinas", 
        "fua" => "Formato Unico Academico",
        "ctl" => "disciplinas",
        "acc" => "ver",
        "prm" => $result
      ]
    );
      
  }

  public function crear() {
    if ( isset($_POST['dos']) AND !empty(trim($_POST['dos'])) ) {
      if ( isset($_POST['rndUnk']) AND trim($_POST['rndUnk']) == $_SESSION['uniqe'] ) :

        $disciplina = new Disciplinas($this->adapter);

        $disciplina->set_descripcion(trim(htmlentities($_POST['dos'])));
        $disciplina->set_entrenador(trim(htmlentities($_POST['tres'])));
        $disciplina->set_horario(trim(htmlentities($_POST['cuatro'])));
        $disciplina->set_lugar(trim(htmlentities($_POST['cinco'])));
        
        unset($_SESSION['uniqe']);

          if ( is_bool($disciplina->save()) ) {

            $_SESSION['uniqe'] = uniqid();
            $this->redirect($_GET['controller'],ACCION_DEFECTO,ID_DEFECTO);
            $this->conectar->OutCnx();

          } else
              die($disciplina->save());

      else:
          $this->redirect($_GET['controller'],ACCION_DEFECTO,ID_DEFECTO);
      endif;

    } else {

      $_SESSION['uniqe'] = uniqid();
      $this->view("crear", 
        [
          "title" => "crear disciplina", 
          "fua" => "Formato Unico Academico",
          "ctl" => "disciplinas",
          "acc" => "crear",
          "prm" => ID_DEFECTO,
          "notify" => false,
          "rndUnk" => $_SESSION['uniqe']

        ]
      );

    }

  }

  public function ver() {
    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {
    
      $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

      $ObjDisciplinas = new Disciplinas($this->adapter);
      $result = $ObjDisciplinas->getById($catch_id);
      $disc = $result[0];
      if ( !is_bool($result) ){

        $this->view("editar", 
          [
            "title" => "editar disciplina", 
            "fua" => "Formato Unico Academico",
            "ctl" => "disciplinas",
            "acc" => "editar",
            "prm" => $disc,
            "notify" => false
          ]
        );

      } else
          die("No se pudo resolver la petición...");

    }else
      die("No se recibieron los parametros esperados...");

  }

  public function editar() {
    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {

      $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

      $disciplina = new Disciplinas($this->adapter);

        $disciplina->set_id($catch_id);
        $disciplina->set_descripcion(trim(htmlentities($_POST['dos'])));
        $disciplina->set_entrenador(trim(htmlentities($_POST['tres'])));
        $disciplina->set_horario(trim(htmlentities($_POST['cuatro'])));
        $disciplina->set_lugar(trim(htmlentities($_POST['cinco'])));

        if ( $disciplina->update() ) {
          $this->redirect($_GET['controller'], ACCION_DEFECTO, ID_DEFECTO);
          $this->conectar->OutCnx();
        } else
            echo $disciplina->update();

    } else 
        echo "Fallo la modificación del registro.";


  }

  public function eliminar(){
    if ( isset($_GET["id"]) AND !empty(trim($_GET["id"])) ) {

      $catch_id =  $this->uncrypt( trim($_GET["id"]), 1 );

      $disciplina = new Disciplinas($this->adapter);

      if( $disciplina->deleteById($catch_id) ) {
        $this->redirect($_GET['controller'], ACCION_DEFECTO, ID_DEFECTO);
        $this->conectar->OutCnx();        
      }else 
        echo "No sé pudo eliminar el registro.";
      
    }
  }


   
}