<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 10/2/14
 * Time: 8:15 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version3 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE audio(
            id int PRIMARY KEY AUTO_INCREMENT,
            uuid CHAR(36) NOT NULL,
            user_id int NOT NULL,
            created_at DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            updated_at DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name VARCHAR(25) NOT NULL,
            file_path varchar(50) NOT NULL,
            INDEX (id),
            INDEX (user_id),
            UNIQUE (uuid),
            FOREIGN KEY (user_id)
                REFERENCES users(id)
        )");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX audio_index ON audio");
        $this->addSql("DROP TABLE audio");
    }
}