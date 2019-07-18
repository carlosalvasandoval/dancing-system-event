<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * antes de usar esto debes crear la tabla siguiente
 * 
 * 
 * CREATE TABLE `migrations` (
  `version` int(5) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  despues de creada la tabla migrations poner 0 como version
  de esa forma este campo de actualizara automaticamente despues de correr las migraciones.

 * * 
 */
class Migration_Init_structure extends CI_Migration {

  public function up()//cuando la construyes
  {
    $this->db->query(
        'CREATE TABLE `ejemplo` (
  `campo_ejemplo` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
    );

//                $this->dbforge->add_field(array(
//                        'blog_id' => array(
//                                'type' => 'INT',
//                                'constraint' => 5,
//                                'unsigned' => TRUE,
//                                'auto_increment' => TRUE
//                        ),
//                        'blog_title' => array(
//                                'type' => 'VARCHAR',
//                                'constraint' => '100',
//                        ),
//                        'blog_description' => array(
//                                'type' => 'TEXT',
//                                'null' => TRUE,
//                        ),
//                ));
//                $this->dbforge->add_key('blog_id', TRUE);
//                $this->dbforge->create_table('blog');
  }

  public function down()//cuando la destruyes
  {
    $this->db->query(
        'DROP TABLE `ejemplo` ;'
    );

//                $this->dbforge->drop_table('blog');
  }

}
