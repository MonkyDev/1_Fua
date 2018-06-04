<?php
class Participaciones extends EntidadBase {

  private $id;
  private $anio;
  private $fk_alumno;
  private $fk_ciclo;
  private $fk_disciplina;
  

  public function __construct($adapter) {
    $table = "participaciones";
    parent::__construct($table, $adapter);
  }

  public function  set_id($id) {
    $this->id = $id;
  }

  public function  set_anio($anio) {
    $this->anio = $anio;
  }

  public function  set_edo($edo) {
    $this->edo = $edo;
  }

  public function  set_id_alumno($fk_alumno) {
    $this->fk_alumno = $fk_alumno;
  }

  public function  set_id_ciclo($fk_ciclo) {
    $this->fk_ciclo = $fk_ciclo;
  }

  public function  set_id_disciplina($fk_disciplina) {
    $this->fk_disciplina = $fk_disciplina;
  }

  public function save(){

    $sql = "INSERT INTO participaciones VALUES (
      'NULL',
      ".$this->anio.",
      ".$this->fk_alumno.",
      ".$this->fk_disciplina.",
      ".$this->fk_ciclo.",
      ".$this->edo.",
      NULL,
      NULL
    )";

    if ( $this->db()->query($sql) ) 
      $save = true;
    else 
      $save = "Falló la consulta: (".$this->db()->errno.")__".$this->db()->error;
          
  return $save;      
  }
  

  public function update(){

    $sql = "UPDATE participaciones SET
            anio = ".$this->anio.",
            edo = ".$this->edo.",
            fk_alumno = ".$this->fk_alumno.",
            fk_ciclo = ".$this->fk_ciclo.",
            fk_disciplina = ".$this->fk_disciplina."
            WHERE 
            id = ".$this->id          
           ;

    if ( $this->db()->query($sql) ) 
      $update = true;
    else 
      $update = "Falló la consulta: (".$this->db()->errno.")__".$this->db()->error;
          
  return $update;      
  } 

   
}