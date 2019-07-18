<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_concursos extends CI_Migration {

  public function up()
  {
    $this->db->query('
      CREATE TABLE `concursos` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nombre` varchar(100) NOT NULL,
        `fecha_ini_inscripcion` datetime NOT NULL,
        `fecha_fin_inscripcion` datetime NOT NULL,
        `fecha_ini_votacion` datetime NOT NULL,
        `fecha_fin_votacion` datetime NOT NULL,
        `parejas_profesor` int(11) NOT NULL,
        `voto_espectador` int(11) NOT NULL,
        `estado` int(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');
  }

  public function down()
  {
    $this->dbforge->drop_table('concursos', TRUE);
  }

}
