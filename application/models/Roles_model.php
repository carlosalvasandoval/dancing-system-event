<?php
class Roles_model extends MY_Model {
   public function grid()
   {
      $this->datatables->setSelect("name, description, id");
      $this->datatables->setFrom("groups");
      return $this->datatables->getData();
   }
}