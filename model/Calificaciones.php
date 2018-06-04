<?php

class Calificaciones extends EntidadBase {

  private $id;
  private $valor;
  private $id_ciclo;
  private $id_alumno; 
  private $id_materia;

  public function __construct($adapter) {
    $table = "calificaciones";
    parent::__construct($table, $adapter);
  }

  public function set_id($id){
    $this->id = $id;
  }

  public function set_valor($valor){
    $this->valor = $valor;
  }

  public function set_id_ciclo($id_ciclo){
    $this->id_ciclo = $id_ciclo;
  }

  public function set_id_alumno($id_alumno){
    $this->id_alumno = $id_alumno;
  }

  public function set_id_materia($id_materia){
    $this->id_materia = $id_materia;
  }

  public function save(){

    $sql = "INSERT INTO calificaciones VALUES (
      'NULL',
      ".$this->valor.",
      ".$this->id_ciclo.",
      ".$this->id_alumno.",
      '".$this->id_materia."',
      NULL,
      NULL
    )";

    if ( $this->db()->query($sql) ) 
      $save = true;
    else 
      $save = "Falló la consulta: (".$this->db()->errno.")__".$this->db()->error;
          
  return $save;      
  }
  
     
}
