<?php
class Concursos_model extends MY_Model {
	private $table = "concursos";

   public function __construct()
   {
      parent::__construct();
   }

   public function save($data)
   {
      $id = (int)$data["id"];
      $this->db->trans_begin();
      if( $id == 0 )
      {
         unset($data["id"]);
         $this->db->insert($this->table, $data);
         $id = $this->db->insert_id();
      }
      else
      {
         $this->db->where("id", $data["id"]);
         $this->db->update($this->table, $data);
      }
      $response = $this->validation_query();
      return $response;
    }

   public function delete($id){
      $this->db->trans_begin();
      $this->db->where("id", $id);
      $this->db->update($this->table, array("estado"=>CONCURSO_INACTIVO));
      $response = $this->validation_query();
      return $response;
   }

   public function get($id=''){
      if(!empty($id))
      {
         $data = $this->db->from($this->table)
         ->where("id", $id)
         ->get()->row();
      }else{
         $data = $this->db->from($this->table)
         ->where("estado", CONCURSO_ACTIVO)
         ->get()->result();
      }
      return $data;
   }

   public function grid($user_id, $rol_id)
   {
      if($rol_id == ADMIN)
      {
         $this->datatables->setSelect($this->table.".nombre AS nombre_concurso, categorias.nombre, DATE_FORMAT(fecha_ini_inscripcion,'%d/%m/%Y %l:%i %p'), DATE_FORMAT(fecha_fin_inscripcion,'%d/%m/%Y %l:%i %p'), DATE_FORMAT(fecha_ini_votacion,'%d/%m/%Y %l:%i %p'), DATE_FORMAT(fecha_fin_votacion,'%d/%m/%Y %l:%i %p'), parejas_profesor, ".$this->table.".id");
      }else{
         $this->datatables->setSelect($this->table.".nombre AS nombre_concurso, categorias.nombre, DATE_FORMAT(fecha_ini_inscripcion,'%d/%m/%Y %l:%i %p'), DATE_FORMAT(fecha_fin_inscripcion,'%d/%m/%Y %l:%i %p'), DATE_FORMAT(fecha_ini_votacion,'%d/%m/%Y %l:%i %p'), DATE_FORMAT(fecha_fin_votacion,'%d/%m/%Y %l:%i %p'), concurso_id");
         $this->datatables->setJoin("concursos_users", $this->table.".id = concursos_users.concurso_id");
         $this->datatables->setWhere("concursos_users.user_id", $user_id);
         $this->datatables->setWhere("concursos_users.estado", RESPONSABLE_ACTIVO);
      }
      $this->datatables->setFrom($this->table);
      $this->datatables->setJoin("categorias", $this->table.".categoria_id = categorias.id");
      $this->datatables->setWhere($this->table.".estado", CONCURSO_ACTIVO);
      return $this->datatables->getData();
   }

   public function get_to_vote()
   {
      $today = date("Y-m-d H:i:s");
      $data = $this->db->from($this->table)
      ->where("fecha_fin_votacion >=", $today)
      ->where("fecha_ini_votacion <=", $today)
      ->where("estado", CONCURSO_ACTIVO)
      ->get()->result();
      return $data;
   }
}