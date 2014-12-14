<?php
/**
 * Created by PhpStorm.
 * User: maxpowers
 * Date: 12/6/14
 * Time: 8:38 AM
 */

namespace Application\Migrations;

use CallMe\WebBundle\Core\AbstractManager;
use Doctrine\DBAL\Schema\Schema;

class Version4 extends AbstractManager
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE phone_calls(
            id int PRIMARY KEY AUTO_INCREMENT,
            uuid CHAR(36) NOT NULL,
            user_id int NOT NULL,
            name VARCHAR(50) NOT NULL,
            file_path varchar(400) NOT NULL,
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


        $this->addSqll("CREATE TABLE phone_call_audio(
            id int PRIMARY KEY AUTO_INCREMENT,
            user_id int NOT NULL,
            phone_id int NOT NULL,
            FOREIGN KEY (user_id)
                REFERENCES users(id),
            FOREIGN KEY (phone_id)
                REFERENCES phone(id)
        )");
    }

    public function down()
    {
        $this->down("DROP TABLE phone_call_audio");
        $this->down("DROP TABLE phone_calls");
    }
}