<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_copia_dni extends CI_Migration {

  public function up()
  {
    $this->db->query("
    	ALTER TABLE `integrantes`
		CHANGE `copia_dni` `copia_dni` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `fecha_nacimiento`;
    ");
  }

  public function down()
  {
  }
}