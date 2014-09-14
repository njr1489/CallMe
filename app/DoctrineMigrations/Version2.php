<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version2 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE users ADD COLUMN password_reset_token VARCHAR(32) DEFAULT NULL");
        $this->addSql("ALTER TABLE users ADD COLUMN password_reset_expiration_date DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE users DROP COLUMN password_reset_token");
        $this->addSql("ALTER TABLE users DROP COLUMN password_reset_expiration_date");
    }
}
