<?php
class Integrantes_model extends MY_Model {
	private $table = "integrantes";

   public function __construct()
   {
      parent::__construct();
   }

   public function save($integrantes)
   {
      $data_insert = array();
      $data_update = array();
      foreach($integrantes as $integrante)
      {
         if(empty($integrante["copia_dni"]))
         {
            unset($integrante["copia_dni"]);
         }

         if(empty($integrante["id"]))
         {
            unset($integrante["id"]);
            $data_insert[] = $integrante;
         }else{
            $data_update[] = $integrante;
         }
      }
      $this->db->trans_begin();
      if(count($data_insert)>0)
      {
         $this->db->insert_batch($this->table, $data_insert);
      }
      if(count($data_update)>0)
      {
         $this->db->update_batch($this->table, $data_update, "id");
      }
      $response = $this->validation_query();
      return $response;
   }

   public function update($data)
   {
      $this->db->trans_begin();
      $this->db->where("id", $data["id"]);
      unset($data["id"]);
      $this->db->update($this->table, $data);
      $response = $this->validation_query();
      return $response;
   }

   public function get($integrante_id)
   {
      $data = $this->db->from($this->table)
      ->where("id", $integrante_id)
      ->get()->row();
      return $data;
   }

   public function get_by_dni($dni)
   {
      $data = $this->db->from($this->table)
      ->where("dni", $dni)
      ->get()->row();
      return $data;
   }

   public function get_by_pareja($pareja_id)
   {
      $data = $this->db->select("id, pareja_id, dni, nombres, apellidos, DATE_FORMAT(fecha_nacimiento,'%d/%m/%Y') AS fecha_nacimiento, copia_dni")
      ->from($this->table)
      ->where("pareja_id", $pareja_id)
      ->get()->result();
      return $data;
   }
}