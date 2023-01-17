<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221208220503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE district ADD commissariat_district_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C154876066AA10 FOREIGN KEY (commissariat_district_id) REFERENCES commissariat_district (id)');
        $this->addSql('CREATE INDEX IDX_31C154876066AA10 ON district (commissariat_district_id)');
        // $this->addSql('ALTER TABLE exercer_fonction CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C154876066AA10');
        // $this->addSql('DROP INDEX IDX_31C154876066AA10 ON district');
        // $this->addSql('ALTER TABLE district DROP commissariat_district_id');
        // $this->addSql('ALTER TABLE exercer_fonction CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
