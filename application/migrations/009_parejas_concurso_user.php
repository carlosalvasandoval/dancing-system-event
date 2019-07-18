<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_parejas_concurso_user extends CI_Migration {

  public function up()
  {
  	$this->db->query('
		SET foreign_key_checks = 0;
    ');
    $this->db->query('
		TRUNCATE TABLE `integrantes`;
    ');
    $this->db->query('
		TRUNCATE TABLE `parejas`;
    ');
    $this->db->query('
		ALTER TABLE `parejas`
		DROP FOREIGN KEY `parejas_ibfk_1`
    ');
    $this->db->query('
		ALTER TABLE `parejas`
		CHANGE `concurso_user_id` `concurso_id` int(11) NULL AFTER `id`,
		ADD `user_id` int(11) unsigned NULL AFTER `concurso_id`,
		ADD FOREIGN KEY (`concurso_id`) REFERENCES `concursos` (`id`),
		ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
    ');	
  }
  public function down()
  {
  }
}