<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260107223549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE session_formation CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE session_formation ADD CONSTRAINT FK_3A264B5120ED475 FOREIGN KEY (stage_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE session_id_id session_id_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929EA4392681 FOREIGN KEY (session_id_id) REFERENCES session_formation (id)');
        $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929E1ED5BB35 FOREIGN KEY (responsable_id_id) REFERENCES responsable (id)');
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       
        $this->addSql('ALTER TABLE session_formation DROP FOREIGN KEY FK_3A264B5120ED475');
        $this->addSql('ALTER TABLE session_formation CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE session_formation_responsable DROP FOREIGN KEY FK_948F929EA4392681');
        $this->addSql('ALTER TABLE session_formation_responsable DROP FOREIGN KEY FK_948F929E1ED5BB35');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE session_id_id session_id_id INT DEFAULT NULL');
      
    }
}
