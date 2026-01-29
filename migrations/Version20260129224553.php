<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260129224553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE district DROP CONSTRAINT IF EXISTS fk_31c15487a76ed395');
        $this->addSql('DROP SEQUENCE IF EXISTS user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, groupe_id INT DEFAULT NULL, responsable_id UUID NOT NULL, district_id UUID DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_creation VARCHAR(255) NOT NULL, b_actif BOOLEAN NOT NULL, first_connection BOOLEAN NOT NULL, last_connection TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE INDEX IDX_1483A5E97A45358C ON users (groupe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E953C59D72 ON users (responsable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9B08FA272 ON users (district_id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E953C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B08FA272 FOREIGN KEY (district_id) REFERENCES district (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT IF EXISTS fk_8d93d64953c59d72');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT IF EXISTS fk_8d93d6497a45358c');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT IF EXISTS fk_8d93d649b08fa272');
        $this->addSql('DROP TABLE IF EXISTS "user"');
        $this->addSql('ALTER TABLE district DROP CONSTRAINT IF EXISTS FK_31C15487A76ED395');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C15487A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE district DROP CONSTRAINT IF EXISTS FK_31C15487A76ED395');
        $this->addSql('DROP SEQUENCE IF EXISTS users_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, groupe_id INT DEFAULT NULL, responsable_id UUID NOT NULL, district_id UUID DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_creation VARCHAR(255) NOT NULL, b_actif BOOLEAN NOT NULL, first_connection BOOLEAN NOT NULL, last_connection TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_8d93d6497a45358c ON "user" (groupe_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d64953c59d72 ON "user" (responsable_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649b08fa272 ON "user" (district_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON "user" (username)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d64953c59d72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d6497a45358c FOREIGN KEY (groupe_id) REFERENCES groupe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649b08fa272 FOREIGN KEY (district_id) REFERENCES district (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT IF EXISTS FK_1483A5E97A45358C');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT IF EXISTS FK_1483A5E953C59D72');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT IF EXISTS FK_1483A5E9B08FA272');
        $this->addSql('DROP TABLE IF EXISTS users');
        $this->addSql('ALTER TABLE district DROP CONSTRAINT IF EXISTS fk_31c15487a76ed395');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT fk_31c15487a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
