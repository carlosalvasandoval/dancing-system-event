<?php
class MY_Model extends CI_Model {
   public function __construct()
   {
      parent::__construct();
   }

   public function validation_query()
   {
      if ($this->db->trans_status() === TRUE)
      {
         $this->db->trans_commit();
         $response = array("result" => true, "msg" => "");
      }
      else
      {
         $this->db->trans_rollback();
         $response = array("result" => false, "msg" =>  $this->db->_error_message());
      }
      return $response;
   }
}