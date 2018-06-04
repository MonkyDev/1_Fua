<?php
class EntidadBase {
   private $table;
   private $db;
   private $conectar;
   
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

   public function getAll(){
      $resultSet = NULL;
      $query=$this->db->query("SELECT * FROM $this->table ORDER BY id ASC");

      if ($query) {
        while ( $row = $query->fetch_object() ) {
           $resultSet[]=$row;
        }
        
      } else
        $resultSet = false;     

   return $resultSet;
   }

  public function getById($id){
    $resultSet = NULL;
    $query=$this->db->query("SELECT * FROM $this->table WHERE id = $id");

    if ($query) {
       if( $row = $query->fetch_object() ) {
         $resultSet[]=$row;

      } else
        $resultSet = false;

    } else
      $resultSet = false;

  return $resultSet;
  }
   
  public function getBy($column, $value){
    $resultSet = NULL;
    $query = $this->db->query("SELECT * FROM $this->table WHERE $column = '$value'");;
    
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

  public function deleteById($id){
    $resultSet = NULL;
    $query=$this->db->query("DELETE FROM $this->table WHERE id = $id"); 

    if ($query)
      $resultSet = true;      
    else 
      $resultSet = false;

  return $resultSet;
  }



}
