<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_pareja_foto extends CI_Migration {

  public function up()
  {
  	$this->db->query('
			ALTER TABLE `parejas`
			ADD `foto` varchar(255) NULL AFTER `nombre`;
    ');
  }

  public function down()
  {
  }
}