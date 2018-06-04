<?php 

class ModeloBase extends EntidadBase {
  private $table;

  public function __construct($table, $adapter) {
     $this->table = (string) $table;
     parent::__construct($table, $adapter);

  }

/*--------------------- INICIO alumnosController ---------------------*/

  public function findAlumno($find){
    $query = $this->db()->query("
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
               $resultSet[] = $row;
           
       }else
           $resultSet = false;
         
     }else
         $resultSet = false;
     
  return $resultSet;
  }



  public function getAllGruposXCarrerasXModalidad(){
    $sql = "  
            SELECT
            gpo.id AS id_grupo,
            gpo.grado,fk_planesc,
            CONCAT(gpo.grado,'',gpo.letra,' ',car.clave,' ',gpo.fk_planesc) AS desc_gpo
            FROM grupos gpo
            INNER JOIN carreras car ON car.clave = gpo.fk_carrera
            INNER JOIN planes_escolares psc ON psc.id = gpo.fk_planesc
            ORDER BY id_grupo
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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

/*--------------------- FIN alumnosController ---------------------*/



/*--------------------- INICIO participacionesController ---------------------*/

public function get_all_participaciones_by_alu_anio_actual(){
    $sql = "  
            SELECT *,
            alu.id AS id_alu,
            alu.fk_ciclo AS id_cic,
            CONCAT(nombres,' ',a_pat,' ',a_mat) AS nomb_alumno,
            CONCAT(car.clave,' ',ple.id) AS nomb_carrera,
            CONCAT(gpo.grado,gpo.letra,' ',gpo.turno) AS nomb_grupo,
            CONCAT(mes_inicio,'-',mes_fin,'-',cie.anio) AS desc_ciclo
            FROM participaciones par
            INNER JOIN alumnos alu ON alu.id = par.fk_alumno
            INNER JOIN ciclos_escolares cie ON cie.id = par.fk_ciclo
            INNER JOIN grupos gpo ON gpo.id = alu.fk_grupo
            INNER JOIN planes_escolares ple ON ple.id = gpo.fk_planesc
            INNER JOIN carreras car ON car.clave = gpo.fk_carrera
            GROUP BY par.fk_alumno HAVING par.anio = '".date('Y')."'
            ORDER BY par.created_at DESC
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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


  public function check_exist_calificaciones_alumno($id_alumno){
    $sql = "  
            SELECT 
            IF( COUNT(id) >= 1, 1,0 ) AS encontro 
            FROM calificaciones 
            WHERE fk_alumno = ".$id_alumno."
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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



  public function get_all_participacion_calificacion_by_alu_anio_actual(){
    $sql = "  
            SELECT *,
            alu.id AS id_alu,
            alu.fk_ciclo AS id_cic,
            par.id AS id_par,
            CONCAT(nombres,' ',a_pat,' ',a_mat) AS nomb_alumno,
            CONCAT(car.clave,' ',ple.id) AS nomb_carrera,
            CONCAT(gpo.grado,gpo.letra,' ',gpo.turno) AS nomb_grupo,
            CONCAT(mes_inicio,'-',mes_fin,'-',cie.anio) AS desc_ciclo
            FROM participaciones par
            INNER JOIN alumnos alu ON alu.id = par.fk_alumno
            INNER JOIN ciclos_escolares cie ON cie.id = par.fk_ciclo
            INNER JOIN grupos gpo ON gpo.id = alu.fk_grupo
            INNER JOIN planes_escolares ple ON ple.id = gpo.fk_planesc
            INNER JOIN carreras car ON car.clave = gpo.fk_carrera
            RIGHT JOIN calificaciones cal ON cal.fk_alumno = par.fk_alumno
            GROUP BY CAL.fk_alumno HAVING par.anio = '".date('Y')."'
            ORDER BY cal.created_at DESC
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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


/*--------------------- FIN participacionesController ---------------------*/


/*--------------------- INICIO calificacionesController ---------------------*/

public function find_ciclo_backward($fech_ciclo_actual){
    $query = $this->db()->query("
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
    $query = $this->db()->query(
    "
    SELECT
    mat.id AS id_mat,
    mat.nombre AS nomb_mat
    FROM materias mat
    INNER JOIN plan_estudios pla ON pla.id = mat.fk_plan
    INNER JOIN carreras car ON car.clave = pla.clave_carrera
    INNER JOIN planes_escolares pes ON pes.id = pla.fk_planesc
    WHERE mat.grado IN (
    SELECT (grado - 1) FROM grupos gpo WHERE gpo.id IN(
    SELECT alu.fk_grupo FROM alumnos alu WHERE alu.id = ".$id_alumno."))
    AND mat.fk_plan IN (
      SELECT id FROM plan_estudios WHERE clave_carrera in (
        SELECT fk_carrera FROM grupos WHERE id IN (
          SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno.")))
    AND pla.fk_planesc IN (
      SELECT fk_planesc FROM grupos WHERE id IN (
        SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno."))
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
    $query = $this->db()->query(
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



  public function get_materias_alumno_grado($id_alumno) {
    $query = $this->db()->query(
    "
     SELECT
    mat.id AS id_mat,
    mat.nombre AS nomb_mat
    FROM materias mat
    INNER JOIN plan_estudios pla ON pla.id = mat.fk_plan
    INNER JOIN carreras car ON car.clave = pla.clave_carrera
    INNER JOIN planes_escolares pes ON pes.id = pla.fk_planesc
    WHERE mat.grado IN (
    SELECT (grado - 1) FROM grupos gpo WHERE gpo.id IN(
    SELECT alu.fk_grupo FROM alumnos alu WHERE alu.id = ".$id_alumno."))
    AND mat.fk_plan IN (
      SELECT id FROM plan_estudios WHERE clave_carrera in (
        SELECT fk_carrera FROM grupos WHERE id IN (
          SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno.")))
    AND pla.fk_planesc IN (
      SELECT fk_planesc FROM grupos WHERE id IN (
        SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno."))
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

    if( $query = $this->db()->query($sql) ){
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
     $query = $this->db()->query("
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


/*--------------------- FIN calificacionesController ---------------------*/



/*--------------------- INICIO reportesController ---------------------*/


public function get_info_registro_participacion($id_participacion){
  $query = $this->db()->query("
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
    INNER JOIN carreras CAR ON CAR.clave = GPO.fk_carrera
    WHERE PAR.id= ".$id_participacion."
    GROUP BY fk_alumno
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
            INNER JOIN carreras CAR ON CAR.clave = GPO.fk_carrera
            INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
            WHERE anio = '".$anio."'
            AND fk_disciplina =  ".$disc."
            AND PAR.edo = 1
            ORDER BY DIS.descripcion
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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
            INNER JOIN carreras CAR ON CAR.clave = GPO.fk_carrera
            INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
            WHERE anio = '".$anio."'
            AND PAR.edo = 1
            ORDER BY DIS.descripcion
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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
            INNER JOIN carreras CAR ON CAR.clave = GPO.fk_carrera
            INNER JOIN disciplinas DIS ON DIS.id = PAR.fk_disciplina
            WHERE YEAR(PAR.created_at) = '".$anio."'
            AND MONTH(PAR.created_at) BETWEEN ".$periodo."
            AND PAR.edo = ".$edo."
            ORDER BY DIS.descripcion     
           ";
    if ( $result = $this->db()->query($sql) ){
      if ($result->num_rows == 1 ) {
        $row = $result->fetch_object();
          $resultSet[] =$row;

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


  /*--------------------- FIN reportesController ---------------------*/


  /*------------------ DETERMINAMOS, que los usuarios al fua son con el estado 9----------------*/
  public function getDatasUsuario($id){
    $query = $this->db()->query("
      SELECT
      ams.id as id_administrativo,
      fk_cuenta,name,password,nombre,usr.edo
      FROM users usr
      INNER JOIN administrativos ams ON ams.id = usr.fk_cuenta
      WHERE usr.edo = 9
      AND usr.id = ".$id."
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

/**
 * @return change query because fail this.
 */
/*  SELECT
    mat.id AS id_mat,
    mat.nombre AS nomb_mat
    FROM materias mat
    INNER JOIN plan_estudios pla ON pla.id = mat.fk_plan
    INNER JOIN carreras car ON car.clave = pla.clave_carrera
    INNER JOIN planes_escolares pes ON pes.id = pla.fk_planesc
    WHERE mat.grado IN (
    SELECT grado FROM grupos gpo WHERE gpo.id IN(
    SELECT alu.fk_grupo FROM alumnos alu WHERE alu.id = ".$id_alumno."))
    AND mat.fk_plan IN (
      SELECT id FROM plan_estudios WHERE clave_carrera IN (
        SELECT fk_carrera FROM grupos WHERE id IN (
          SELECT fk_grupo FROM alumnos WHERE id = ".$id_alumno.")))
    AND pla.fk_planesc IN ()
 */