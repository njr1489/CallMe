<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version1 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE users(
            id int PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(25) NOT NULL,
            last_name VARCHAR(25) NOT NULL,
            email VARCHAR(200) NOT NULL,
            password VARCHAR(72) NOT NULL,
            created_at DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            updated_at DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL
        )");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE users;");
    }
}