<?php

class Disciplinas extends EntidadBase {

  private $id;
  private $descripcion;
  private $horario;
  private $lugar;
  private $entrenador;

  public function __construct($adapter) {
    $table = "disciplinas";
    parent::__construct($table, $adapter);
  }

  public function set_id($id) {
    $this->id = $id;
  }

  public function set_descripcion($descripcion) {
    $this->descripcion = $descripcion;
  }

  public function set_horario($horario) {
    $this->horario = $horario;
  }

  public function set_lugar($lugar) {
    $this->lugar = $lugar;
  }

  public function set_entrenador($entrenador) {
    $this->entrenador = $entrenador;
  }

  public function save(){

    $sql = "INSERT INTO disciplinas VALUES (
      'NULL',
      '".$this->descripcion."',
      '".$this->horario."',
      '".$this->lugar."',
      '".$this->entrenador."',
      1,
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

  $sql = "UPDATE disciplinas SET
          descripcion = '".$this->descripcion."',
          horario = '".$this->horario."',
          lugar = '".$this->lugar."',
          entrenador = '".$this->entrenador."'
          WHERE id = ".$this->id
         ;

  if ( $this->db()->query($sql) ) 
    $update = true;
  else 
    $update = "Falló la consulta: (".$this->db()->errno.")__".$this->db()->error;
        
  return $update;      
  } 


}

