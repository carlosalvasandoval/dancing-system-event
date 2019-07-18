<?php
class Parejas_model extends MY_Model {
	private $table = "parejas";

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
         $this->db->where("id", $id);
         $this->db->update($this->table, $data);
      }
      $response = $this->validation_query();
      $response["data"] = $this->get($id);
      return $response;
   }

   public function get($id=''){
      $data = $this->db->from($this->table)
      ->where("id", $id)
      ->get()->row();
      return $data;
   }

   public function delete($id){
      $this->db->trans_begin();
      $this->db->where("id", $id);
      $this->db->update($this->table, array("estado"=>PAREJA_INACTIVO));
      $response = $this->validation_query();
      return $response;
   }

   public function grid($concurso_id, $user)
   {
      $this->datatables->setSelect("nombre, estado_pareja, checkin, DATE_FORMAT(fecha_checkin,'%d/%m/%Y %l:%i %p'), id");
      $this->datatables->setFrom($this->table);
      $this->datatables->setWhere("concurso_id", $concurso_id);
      if($user->rol_active==PROFESOR)
      {
         $this->datatables->setWhere("user_id", $user->id);
      }
      $this->datatables->setWhere("estado", PAREJA_ACTIVO);
      return $this->datatables->getData();
   }

   public function is_added($dni, $concurso_id)
   {
      $data = $this->db->from($this->table)
      ->join("integrantes", $this->table.".id = integrantes.pareja_id")
      ->where("dni", $dni)
      ->where("concurso_id", $concurso_id)
      ->get()->row();
      return $data;
   }

   public function get_by_concurso_profesor($concurso_id, $user_id)
   {
      $data = $this->db->from($this->table)
      ->where("concurso_id", $concurso_id)
      ->where("user_id", $user_id)
      ->where("estado", PAREJA_ACTIVO)
      ->get()->result();
      return $data;
   }

   public function get_to_vote($concurso_id)
   {
      $sql_votos = "(SELECT COUNT(id) FROM votaciones WHERE pareja_id = pareja.id)";
      $sql = "SELECT pareja.id, pareja.nombre, pareja.foto , ".$sql_votos." AS votos 
      FROM parejas pareja 
      WHERE concurso_id = ? 
      AND estado_pareja = ? 
      AND checkin = ? 
      AND estado = ?";
      $data = $this->db->query($sql, array($concurso_id, PAREJA_VALIDADA, PAREJA_CHECKED_YES, PAREJA_ACTIVO))->result();
      return $data;
   }

   public function get_to_statistic($concurso_id)
   {
      $data = $this->db->select("parejas.id AS pareja_id, parejas.nombre AS pareja, CONCAT(integrantes.nombres,' ',integrantes.apellidos) AS nombre")
      ->from($this->table)
      ->join("integrantes", $this->table.".id = integrantes.pareja_id")
      ->where($this->table.".concurso_id", $concurso_id)
      ->where("estado_pareja", PAREJA_VALIDADA)
      ->where($this->table.".estado", PAREJA_ACTIVO)
      ->order_by("pareja_id")
      ->get()->result();
      return $data;
   }
}