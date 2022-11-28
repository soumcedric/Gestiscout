<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128225233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fonction ADD role VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE responsable DROP email');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP first_connection, DROP last_connection, CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fonction DROP role');
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable ADD email VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD first_connection TINYINT(1) NOT NULL, ADD last_connection DATETIME DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
