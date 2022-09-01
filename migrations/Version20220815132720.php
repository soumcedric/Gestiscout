<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815132720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session_formation_responsable (id INT AUTO_INCREMENT NOT NULL, session_id_id INT DEFAULT NULL, responsable_id_id INT DEFAULT NULL, ref_diplome VARCHAR(50) DEFAULT NULL, bconfirm_pariticpation TINYINT(1) NOT NULL, binscrit TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, INDEX IDX_948F929EA4392681 (session_id_id), INDEX IDX_948F929E1ED5BB35 (responsable_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929EA4392681 FOREIGN KEY (session_id_id) REFERENCES session_formation (id)');
        $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929E1ED5BB35 FOREIGN KEY (responsable_id_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE session_formation_responsable');
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
