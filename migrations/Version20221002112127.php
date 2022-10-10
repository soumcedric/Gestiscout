<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002112127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
       // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
       // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD b_actif TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
      //  $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
       // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user DROP b_actif');
    }
}
