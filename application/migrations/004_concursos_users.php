<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_concursos_users extends CI_Migration {

  public function up()
  {
    $this->db->query('
      CREATE TABLE `concursos_users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `concurso_id` int(11) NOT NULL,
        `user_id` int(11) unsigned NOT NULL,
        `estado` int(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`id`),
        KEY `concurso_id` (`concurso_id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `concursos_users_ibfk_1` FOREIGN KEY (`concurso_id`) REFERENCES `concursos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
        CONSTRAINT `concursos_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');
  }

  public function down()
  {
    $this->dbforge->drop_table('concursos_users', TRUE);
  }

}
