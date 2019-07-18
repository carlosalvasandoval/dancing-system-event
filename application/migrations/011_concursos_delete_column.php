<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_concursos_delete_column extends CI_Migration {

  public function up()
  {
  	$this->db->query('
			ALTER TABLE `concursos`
			DROP COLUMN `voto_espectador`;
    ');
  }

  public function down()
  {
  }
}