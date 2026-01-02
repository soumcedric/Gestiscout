<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260102101804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable_formation MODIFY COLUMN responsable_id_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE exercer_fonction MODIFY COLUMN responsable_id CHAR(36) NOT NULL');
         $this->addSql('ALTER TABLE exercer_fonction MODIFY COLUMN responsable_id CHAR(36) NOT NULL');
         

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
