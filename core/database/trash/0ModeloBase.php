<?php 

class ModeloBase extends EntidadBase {
  private $table;

  public function __construct($table, $adapter) {
     $this->table = (string) $table;
     parent::__construct($table, $adapter);

  }

  public function getAllGruposXCarrerasXModalidad(){
    $sql = "  
            SELECT
            gpo.id AS id_grupo,
            gpo.grado,fk_planesc,
            CONCAT(gpo.grado,'',gpo.grupo,' ',car.clave,' ',gpo.fk_planesc) AS desc_gpo
            FROM grupos gpo
            INNER JOIN carreras car ON car.id = gpo.fk_carrera
            INNER JOIN planes_escolares psc ON psc.id = gpo.fk_planesc
            ORDER BY id_grupo
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }


  public function getAllCiclosXPlanEscolar(){
    $sql = "  
            SELECT cie.id,mes_inicio,mes_fin,anio,descripcion
            FROM ciclo_escolar cie
            INNER JOIN plan_escolar pes ON pes.id = cie.fk_plnesc
            
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }

  public function getCiclosXPlanEscolarById($id){
    $sql = "  
            SELECT cie.id,mes_inicio,mes_fin,anio,descripcion,fk_plnesc
            FROM ciclo_escolar cie
            INNER JOIN plan_escolar pes ON pes.id = cie.fk_plnesc
            WHERE cie.id = ".$id
          ;
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }

  public function getAllCarreras(){
    $sql = "  
            SELECT *
            FROM $this->table car            
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }

  public function getAllGruposXCarreras(){
    $sql = "  
            SELECT gpo.id_grupo,gpo.grado,gpo.salon,car.clave,pes.descripcion
            FROM $this->table gpo
            INNER JOIN carreras car ON car.id_carrera = gpo.id_carrera
            INNER JOIN plan_escolar pes ON pes.id_plnesc = gpo.id_plnesc         
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }

  public function get_id_alu_by_anio_disc($anio, $disc){
    $sql = "
            SELECT
            CONCAT(CAR.nombre,' ',PLE.descripcion) AS desc_carrera,
            CONCAT(nombres,' ',a_pat,' ',a_mat) AS nomb_alumno,
            GPO.grado,
            ALU.matricula,
            DIS.descripcion,
            PAR.anio
            FROM participaciones PAR
            INNER JOIN alumnos ALU ON ALU.id = PAR.fk_alumno
            INNER JOIN grupos GPO ON GPO.id = ALU.fk_grupo
            INNER JOIN planes_escolares PLE ON PLE.id = GPO.fk_planesc
            INNER JOIN carreras CAR ON CAR.id = GPO.fk_carrera
            INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
            WHERE anio = '".$anio."'
            AND fk_disciplina =  ".$disc."
            AND PAR.edo = 1
            ORDER BY DIS.descripcion
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }


  public function get_id_alu_by_anio($anio){
    $sql = "
            SELECT
            CONCAT(CAR.nombre,' ',PLE.descripcion) AS desc_carrera,
            CONCAT(nombres,' ',a_pat,' ',a_mat) AS nomb_alumno,
            GPO.grado,
            ALU.matricula,
            DIS.descripcion,
            PAR.anio
            FROM participaciones PAR
            INNER JOIN alumnos ALU ON ALU.id = PAR.fk_alumno
            INNER JOIN grupos GPO ON GPO.id = ALU.fk_grupo
            INNER JOIN planes_escolares PLE ON PLE.id = GPO.fk_planesc
            INNER JOIN carreras CAR ON CAR.id = GPO.fk_carrera
            INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
            WHERE anio = '".$anio."'
            AND PAR.edo = 1
            ORDER BY DIS.descripcion
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }




  public function get_id_alu_by_periodo_edo($anio, $periodo, $edo){
    $sql = "
            SELECT
            CONCAT(CAR.nombre,' ',PLE.descripcion) AS desc_carrera,
            CONCAT(nombres,' ',a_pat,' ',a_mat) AS nomb_alumno,
            GPO.grado,
            ALU.matricula,
            DIS.descripcion,
            PAR.anio,
            DATE_FORMAT(PAR.created_at, '%m') AS registro,
            PAR.edo
            FROM participaciones PAR
            INNER JOIN alumnos ALU ON ALU.id = PAR.fk_alumno
            INNER JOIN grupos GPO ON GPO.id = ALU.fk_grupo
            INNER JOIN planes_escolares PLE ON PLE.id = GPO.fk_planesc
            INNER JOIN carreras CAR ON CAR.id = GPO.fk_carrera
            INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
            WHERE YEAR(PAR.created_at) = '".$anio."'
            AND MONTH(PAR.created_at) BETWEEN ".$periodo."
            AND PAR.edo = ".$edo."
            ORDER BY DIS.descripcion     
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet=$row;

      } elseif ( $result->num_rows > 1 ) {
        while( $row = $result->fetch_object() ) {
          $resultSet[]=$row;
        }

      } else
        $resultSet = false;

    } else
      $resultSet = false;
      
  return $resultSet;
  }
  
  

}