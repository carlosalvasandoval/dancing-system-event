<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_parejas_admin extends CI_Migration {

  public function up()
  {
    $this->db->query('
      ALTER TABLE `parejas`
      CHANGE `concurso_user_id` `concurso_user_id` int(11) NULL AFTER `id`;
    ');
  }

  public function down()
  {
  }
}
