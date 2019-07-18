<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_parejas_integrantes extends CI_Migration {

  public function up()
  {
    $this->db->query('
      CREATE TABLE `parejas` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `concurso_user_id` int(11) NOT NULL,
        `nombre` varchar(255) NOT NULL,
        `estado` int(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`id`),
        KEY `concurso_user_id` (`concurso_user_id`),
        CONSTRAINT `parejas_ibfk_1` FOREIGN KEY (`concurso_user_id`) REFERENCES `concursos_users` (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');

    $this->db->query('
      CREATE TABLE `integrantes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `pareja_id` int(11) NOT NULL,
        `dni` char(8) NOT NULL,
        `nombres` varchar(255) NOT NULL,
        `apellidos` varchar(255) NOT NULL,
        `fecha_nacimiento` date NOT NULL,
        `copia_dni` varchar(255) NOT NULL,
        `estado` int(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`id`),
        KEY `pareja_id` (`pareja_id`),
        CONSTRAINT `integrantes_ibfk_1` FOREIGN KEY (`pareja_id`) REFERENCES `parejas` (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');
  }

  public function down()
  {
    $this->dbforge->drop_table('integrantes', TRUE);
    $this->dbforge->drop_table('parejas', TRUE);
  }

}
