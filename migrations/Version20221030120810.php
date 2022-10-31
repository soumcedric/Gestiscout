<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030120810 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, type_document_id INT NOT NULL, activite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, extension VARCHAR(255) DEFAULT NULL, directory_path VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, user_creation VARCHAR(255) DEFAULT NULL, INDEX IDX_A2B072888826AFA6 (type_document_id), INDEX IDX_A2B072889B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072888826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072889B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP TABLE documents');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
