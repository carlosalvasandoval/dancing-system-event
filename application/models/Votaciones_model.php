<?php
class Votaciones_model extends MY_Model {
	private $table = "votaciones";

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

   public function already_voted($fb_id, $pareja_id){
      $this->load->model("Parejas_model", "Parejas");
      $pareja = $this->Parejas->get($pareja_id);

      $data = $this->db->from($this->table)
      ->join("parejas", $this->table.".pareja_id = parejas.id")
      ->where("concurso_id", $pareja->concurso_id)
      ->where("fb_id", $fb_id)
      ->where($this->table.".estado", VOTO_ACTIVO)
      ->get()->result();
      $cant_votos = count($data);
      return ($cant_votos>0)?TRUE:FALSE;
   }

   public function get_votos_by_pareja($pareja_id)
   {
      $data = $this->db->select("COUNT(id) AS votos")
      ->from($this->table)
      ->where("pareja_id", $pareja_id)
      ->get()->row();
      return $data->votos;
   }
}