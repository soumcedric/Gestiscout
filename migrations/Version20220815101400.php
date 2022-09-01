<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815101400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE session_formation ADD stage_formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE session_formation ADD CONSTRAINT FK_3A264B5120ED475 FOREIGN KEY (stage_formation_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_3A264B5120ED475 ON session_formation (stage_formation_id)');
       // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session_formation DROP FOREIGN KEY FK_3A264B5120ED475');
        $this->addSql('DROP INDEX IDX_3A264B5120ED475 ON session_formation');
        $this->addSql('ALTER TABLE session_formation DROP stage_formation_id');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
