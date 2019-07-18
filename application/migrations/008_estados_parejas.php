<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_estados_parejas extends CI_Migration {

  public function up()
  {
    $this->db->query('
		ALTER TABLE `parejas`
		ADD `estado_pareja` int NOT NULL DEFAULT 1 AFTER `nombre`,
		ADD `checkin` int NOT NULL DEFAULT 0 AFTER `estado_pareja`,
		ADD `fecha_checkin` datetime NOT NULL AFTER `checkin`;
    ');
  }

  public function down()
  {
  }
}