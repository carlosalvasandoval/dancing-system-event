<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_ion_auth extends CI_Migration {

  public function up()
  {
    $this->db->query('
      CREATE TABLE groups (
        id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(20) NOT NULL,
        description varchar(100) NOT NULL,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');

    $this->db->query("
      INSERT INTO groups (id, name, description) VALUES
      (1,'admin','Administrator'),
      (2,'PROFESOR','Profesor'),
      (3,'RECEPCIONISTA','Recepcionista');
    ");

    $this->db->query('
      CREATE TABLE `users` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `ip_address` varchar(45) NOT NULL,
        `username` varchar(100) NULL,
        `password` varchar(255) NOT NULL,
        `salt` varchar(255) DEFAULT NULL,
        `email` varchar(254) NOT NULL,
        `activation_code` varchar(40) DEFAULT NULL,
        `forgotten_password_code` varchar(40) DEFAULT NULL,
        `forgotten_password_time` int(11) unsigned DEFAULT NULL,
        `remember_code` varchar(40) DEFAULT NULL,
        `created_on` int(11) unsigned NOT NULL,
        `last_login` int(11) unsigned DEFAULT NULL,
        `active` tinyint(1) unsigned DEFAULT NULL,
        `first_name` varchar(50) DEFAULT NULL,
        `last_name` varchar(50) DEFAULT NULL,
        `company` varchar(100) DEFAULT NULL,
        `phone` varchar(20) DEFAULT NULL,
        `rol_active` integer DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');

    $this->db->query("
      INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `rol_active`) VALUES
      ('1','127.0.0.1','administrator', 'password','','admin@admin.com','',NULL,'1268889823','1268889823','1', 'Admin','istrator','ADMIN','0', 1);
    ");

    $this->db->query('
      CREATE TABLE `users_groups` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(11) unsigned NOT NULL,
        `group_id` mediumint(8) unsigned NOT NULL,
        PRIMARY KEY (`id`),
        KEY `fk_users_groups_users1_idx` (`user_id`),
        KEY `fk_users_groups_groups1_idx` (`group_id`),
        CONSTRAINT `uc_users_groups` UNIQUE (`user_id`, `group_id`),
        CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
        CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');

    $this->db->query("
      INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
      (1,1,1);
    ");

    $this->db->query('
      CREATE TABLE `login_attempts` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `ip_address` varchar(45) NOT NULL,
        `login` varchar(100) NOT NULL,
        `time` int(11) unsigned DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');
  }

  public function down()
  {
    $this->dbforge->drop_table('users_groups', TRUE);
    $this->dbforge->drop_table('groups', TRUE);
    $this->dbforge->drop_table('users', TRUE);
    $this->dbforge->drop_table('login_attempts', TRUE);
  }

}
