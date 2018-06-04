<?php
class EntidadBase {
   private $table;
   private $db;
   private $conectar;
   private $resultSet;
   
   public function __construct($table, $adapter) {
     $this->table=(string) $table;
     $this->conectar = null;
     $this->db = $adapter;
   }

   public function getConetar(){
      return $this->conectar;
   }

   public function db(){
      return $this->db;
   }

   public function getAll($id){
      $query=$this->db->query("SELECT * FROM $this->table ORDER BY $id DESC");

      if ($query) {
        while ( $row = $query->fetch_object() ) {
           $resultSet[]=$row;
        }
        
      } else
        $resultSet = false;     

   return $resultSet;
   }

  public function getById($id){
    $query=$this->db->query("SELECT * FROM $this->table WHERE id = $id");

    if ($query) {
       if( $row = $query->fetch_object() ) {
         $resultSet=$row;

      } else
        $resultSet = false;

    } else
      $resultSet = false;

  return $resultSet;
  }
   
  public function getBy($column, $value){
    $query = $this->db->query("SELECT * FROM $this->table WHERE $column = '$value'");;
    
   if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function deleteById($id){
    $query=$this->db->query("DELETE FROM $this->table WHERE id = $id"); 

    if ($query)
      $resultSet = true;      
    else 
      $resultSet = false;

  return $resultSet;
  }

  public function findAlumno($find){
    $query = $this->db->query("
      SELECT *,
      alu.id AS id_alu,
      CONCAT_WS( ' ', TRIM(a_pat) , TRIM(a_mat), TRIM(nombres) ) AS NombreCompleto
      FROM alumnos alu
      INNER JOIN grupos gpo ON gpo.id = alu.fk_grupo
      WHERE matricula
      LIKE '%$find%'
      OR  CONCAT_WS( ' ', TRIM(a_pat) , TRIM(a_mat) )  LIKE '%$find%'"
    );

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }


  public function findAlumnoXCalficaciones($alumno){
     $query = $this->db->query("
      SELECT
      *,alu.id as id_alu,cie.id AS id_cic
      FROM calificaciones cal
      INNER JOIN alumnos alu ON alu.id = cal.fk_alumno
      INNER JOIN ciclos_escolares cie ON cie.id = cal.fk_ciclo
      INNER JOIN planes_escolares pln ON pln.id = cie.fk_planesc
      INNER JOIN materias mat ON mat.id = cal.fk_materia
      WHERE alu.id = ".$alumno."
      GROUP BY cal.fk_ciclo
      ORDER BY cal.fk_ciclo DESC
      ");

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function get_materias_alumno_grado($id_alumno) {
    $query = $this->db->query(
    "
    SELECT
    mat.id AS id_mat,
    mat.nombre AS nomb_mat
    FROM materias mat
    INNER JOIN plan_estudios pla ON pla.id = mat.fk_plan
    INNER JOIN carreras car ON car.id = pla.fk_carrera
    INNER JOIN planes_escolares pes ON pes.id = pla.fk_planesc
    WHERE mat.grado IN (
    SELECT (grado - 1) FROM grupos gpo WHERE gpo.id IN(
    SELECT alu.fk_grupo FROM alumnos alu WHERE alu.id = ".$id_alumno."))
    AND mat.fk_plan IN (
      SELECT id FROM plan_estudios WHERE fk_carrera IN (
        SELECT fk_carrera FROM grupos WHERE id IN (
          SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno.")))
    ");
    if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function get_calificacion_materia($ciclo, $alumno) {
    $sql = "
     SELECT
    CIE.fecha_curso,CIE.anio,MAT.nombre,CAL.valor,
    MAT.id AS id_mat
    FROM calificaciones CAL
    INNER JOIN materias MAT ON MAT.id = CAL.fk_materia
    INNER JOIN ciclos_escolares CIE ON CIE.id = CAL.fk_ciclo
    WHERE CAL.fk_ciclo = ".$ciclo."
    AND CAL.fk_alumno = ".$alumno."
    ";

    if( $query = $this->db->query($sql) ){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;

  return $resultSet;
  }

  public function find_alumno_participaciones($alumno){
     $query = $this->db->query("
      SELECT *,
      par.id AS id_par,alu.id AS id_alu,dis.id AS id_dis
      FROM participaciones par
      INNER JOIN alumnos alu ON alu.id = par.fk_alumno
      INNER JOIN disciplinas dis ON dis.id = par.fk_disciplina
      WHERE alu.id = ".$alumno
    );

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function find_registros_pagos_alumno($alumno){
    $query = $this->db->query("
      SELECT *,
      pag.id AS id_pag,alu.id AS id_alu,cpt.id AS id_cpt,cie.id_ciclo AS id_cie,
      COUNT(pag.id) AS totalRecibos,
      SUM(pag.monto) AS montoRecibos
      FROM pagos pag
      INNER JOIN alumnos alu ON alu.id = pag.id_alumno
      INNER JOIN conceptos cpt ON cpt.id = pag.id_concepto
      INNER JOIN ciclo_escolar cie ON cie.id_ciclo = pag.id_ciclo
      WHERE alu.id = ".$alumno."
      GROUP BY pag.id_ciclo
      ORDER BY pag.id_ciclo ASC
    ");

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function find_alumno_pagos($alumno, $ciclo){
    $query = $this->db->query("
    SELECT *,
    pag.id AS id_pag,alu.id AS id_alu,cpt.id AS id_cpt,cie.id AS id_cie
    FROM pagos pag
    INNER JOIN alumnos alu ON alu.id = pag.id_alumno
    INNER JOIN conceptos cpt ON cpt.id = pag.id_concepto
    INNER JOIN ciclo_escolar cie ON cie.id = pag.id_ciclo
    WHERE pag.id_alumno = ".$alumno."
    AND pag.id_ciclo = ".$ciclo 
    );

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function get_info_registro_participacion($id_participacion){
  $query = $this->db->query("
    SELECT *, 
    PAR.id AS id_par,PAR.fk_alumno AS id_alu,PAR.fk_ciclo AS id_cic,PAR.anio AS anio_part,
    ALU.matricula,ALU.sexo,ALU.foto,ALU.tipo_ingreso,ALU.inscripcion,ALU.a_pat,ALU.a_mat,ALU.nombres,
    CIE.mes_inicio,CIE.anio,CIE.fecha_curso,CIE.fk_planesc,
    GPO.grado,CAR.nombre,
    CONCAT_WS( ' ', TRIM(ALU.a_pat) , TRIM(ALU.a_mat), TRIM(ALU.nombres) ) AS NombreCompleto
    FROM participaciones PAR
    INNER JOIN alumnos ALU ON ALU.id = PAR.fk_alumno
    INNER JOIN ciclos_escolares CIE ON CIE.id = PAR.fk_ciclo
    INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
    INNER JOIN grupos GPO ON GPO.id = ALU.fk_grupo
    INNER JOIN carreras CAR ON CAR.id = GPO.fk_carrera
    WHERE PAR.id = ".$id_participacion."
    ");

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function find_ciclo_backward($fech_ciclo_actual){
    $query = $this->db->query("
      SELECT *
      FROM ciclos_escolares
      WHERE
      CONCAT_WS('',TRIM(mes_inicio),'-',TRIM(mes_fin),'-',TRIM(anio)) = '".$fech_ciclo_actual."'
      ");

     if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function get_materias_ciclo_actual_alumno_grado($id_alumno) {
    $query = $this->db->query(
    "
    SELECT
    mat.id AS id_mat,
    mat.nombre AS nomb_mat
    FROM materias mat
    INNER JOIN plan_estudios pla ON pla.id = mat.fk_plan
    INNER JOIN carreras car ON car.id = pla.fk_carrera
    INNER JOIN planes_escolares pes ON pes.id = pla.fk_planesc
    WHERE mat.grado IN (
    SELECT grado FROM grupos gpo WHERE gpo.id IN(
    SELECT alu.fk_grupo FROM alumnos alu WHERE alu.id = ".$id_alumno."))
    AND mat.fk_plan IN (
      SELECT id FROM plan_estudios WHERE fk_carrera IN (
        SELECT fk_carrera FROM grupos WHERE id IN (
          SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno.")))
    ");
    if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }

  public function get_info_alumno_grado_ciclo($id_alumno) {
    $query = $this->db->query(
    "
    SELECT *
    FROM alumnos ALU
    INNER JOIN grupos GPO ON GPO.id = ALU.fk_grupo
    INNER JOIN ciclos_escolares CIE ON CIE.id = ALU.fk_ciclo
    WHERE ALU.id =".$id_alumno."
    ");
    if($query){
       if( $query->num_rows > 1 ){
           while( $row = $query->fetch_object() ) {
              $resultSet[] = $row;
           }

       }else if( $query->num_rows == 1 ){
           $row = $query->fetch_object();
               $resultSet = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }


}

/*"
SELECT
mat.id AS id_mat,
mat.nombre AS nomb_mat
FROM $this->table mat
INNER JOIN plan_estudios pla ON pla.id = mat.fk_plan
INNER JOIN carreras car ON car.id = pla.fk_carrera
INNER JOIN plan_escolar pes ON pes.id = pla.fk_plnesc
WHERE mat.grado IN (SELECT grado
FROM grupos gpo
WHERE gpo.id IN(
SELECT
alu.id_grupo
FROM alumnos alu
WHERE alu.id = ".$id_alumno."))
    


SELECT *, PAR.id AS id_par
FROM participaciones PAR
INNER JOIN alumnos ALU ON ALU.id = PAR.id_alumno
INNER JOIN ciclo_escolar CIE ON CIE.id_ciclo = PAR.id_ciclo
INNER JOIN disciplinas DIS ON DIS.id = PAR.id_disciplina
INNER JOIN calificaciones CAL ON (CAL.id_alumno = PAR.id_alumno AND CAL.id_ciclo = PAR.id_ciclo)
WHERE PAR.id =
 */