<?php
class Categorias_model extends MY_Model {
	private $table = "categorias";

   public function __construct()
   {
      parent::__construct();
   }

   public function get($id=''){
      if(!empty($id))
      {
         $data = $this->db->from($this->table)
         ->where("id", $id)
         ->get()->row();
      }else{
         $data = $this->db->from($this->table)
         ->where("estado", CATEGORIA_ACTIVO)
         ->get()->result();
      }
      return $data;
   }
}