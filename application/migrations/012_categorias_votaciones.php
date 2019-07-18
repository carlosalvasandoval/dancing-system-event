<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_categorias_votaciones extends CI_Migration {

  public function up()
  {
    $this->db->query('
      SET foreign_key_checks = 0;
    ');

    $this->db->query('
      TRUNCATE TABLE `concursos`;
    ');

    $this->db->query('
      TRUNCATE TABLE `integrantes`;
    ');

    $this->db->query('
      TRUNCATE TABLE `parejas`;
    ');

  	$this->db->query('
			CREATE TABLE `categorias` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `nombre` varchar(50) NOT NULL,
        `estado` int(1) NOT NULL DEFAULT 1
      );
    ');

    $this->db->query("
      INSERT INTO `categorias` (`nombre`, `estado`) VALUES 
      ('ADULTOS', '1'),
      ('NIÑOS', '1');
    ");

    $this->db->query('
      ALTER TABLE `concursos`
      ADD `categoria_id` int(11) NOT NULL AFTER `id`,
      ADD FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
    ');

    $this->db->query('
      CREATE TABLE `votaciones` (
        `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `pareja_id` int(11) NOT NULL,
        `fb_id` varchar(255) NOT NULL,
        `datos_fb` text,
        `fecha` datetime NOT NULL,
        `estado` int(1) NOT NULL DEFAULT 1
      );
    ');

    $this->db->query('
      ALTER TABLE `votaciones`
      ADD FOREIGN KEY (`pareja_id`) REFERENCES `parejas` (`id`);
    ');


  }

  public function down()
  {
    $this->db->query('
      ALTER TABLE `concursos`
      DROP FOREIGN KEY `concursos_ibfk_1`
    ');

    $this->db->query('
      ALTER TABLE `concursos`
      DROP `categoria_id`;
    ');

    $this->dbforge->drop_table('categorias', TRUE);
    $this->dbforge->drop_table('votaciones', TRUE);
  }
}