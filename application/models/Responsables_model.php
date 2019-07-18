<?php
class Responsables_model extends MY_Model {
	private $table = "concursos_users";

   public function __construct()
   {
      parent::__construct();
   }

   public function save($data)
   {
      $this->db->trans_begin();

      $responsable = $this->db->from($this->table)
      ->where("concurso_id", $data["concurso_id"])
      ->where("user_id", $data["user_id"])
      ->get()->row();

      if(!empty($responsable))
      {
         $this->db->where("id", $responsable->id);
         $this->db->update($this->table, array("estado"=>1));
      }else{
         $this->db->insert($this->table, $data);      
      }
      $response = $this->validation_query();
      return $response;
    }

   public function delete($id){
      $this->db->trans_begin();
      $this->db->where("id", $id);
      $this->db->update($this->table, array("estado"=>RESPONSABLE_INACTIVO));
      $response = $this->validation_query();
      return $response;
   }

   public function get($concurso_id, $user_id){
      $data = $this->db->from($this->table)
      ->where("concurso_id", $concurso_id)
      ->where("user_id", $user_id)
      ->get()->row();
      return $data;
   }

   public function get_desasignados($concurso_id, $rol)
   {
      $sql_desasignados = "SELECT id, CONCAT(first_name,' ',last_name) AS full_name
      FROM users
      WHERE rol_active = ? 
      AND active = ? 
      AND NOT EXISTS ( 
         SELECT NULL FROM concursos_users 
         WHERE  concurso_id = ?
         AND user_id = users.id
         AND estado = ?
      ) ORDER BY full_name";
      $desasignados = $this->db->query($sql_desasignados, array(
         $rol, 
         USUARIO_ACTIVO,
         $concurso_id,
         RESPONSABLE_ACTIVO
      ))->result();
      return $desasignados;
   }

   public function grid($concurso_id, $rol)
   {
      $this->datatables->setSelect("CONCAT(first_name,' ',last_name) AS full_name, email, ".$this->table.".id");
      $this->datatables->setFrom($this->table);
      $this->datatables->setJoin("users", $this->table.".user_id = users.id");
      $this->datatables->setWhere($this->table.".concurso_id", $concurso_id);
      $this->datatables->setWhere($this->table.".estado", RESPONSABLE_ACTIVO);
      $this->datatables->setWhere("users.rol_active", $rol);
      $this->datatables->setWhere("users.active", USUARIO_ACTIVO);
      return $this->datatables->getData();
   }
}