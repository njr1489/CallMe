<?php
/**
 * Created by PhpStorm.
 * User: maxpowers
 * Date: 12/6/14
 * Time: 8:38 AM
 */

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version4 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE phone_calls(
            id int PRIMARY KEY AUTO_INCREMENT,
            uuid CHAR(36) NOT NULL,
            user_id int NOT NULL,
            name VARCHAR(50) NOT NULL,
            created_at DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            updated_at DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            is_active tinyint DEFAULT 1 NOT NULL,
            INDEX (id),
            INDEX (user_id),
            INDEX (uuid),
            UNIQUE (uuid),
            FOREIGN KEY (user_id)
                REFERENCES users(id)
        )");


        $this->addSql("CREATE TABLE phone_call_audio(
            id int PRIMARY KEY AUTO_INCREMENT,
            user_id int NOT NULL,
            audio_id int NOT NULL,
            position int NOT NULL,
            FOREIGN KEY (user_id)
                REFERENCES users(id),
            FOREIGN KEY (audio_id)
                REFERENCES audio(id)
        )");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE phone_call_audio");
        $this->addSql("DROP TABLE phone_calls");
    }
}