<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210502181744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeune (id INT NOT NULL, branche_id INT DEFAULT NULL, groupe_id INT NOT NULL, genre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, dob DATE NOT NULL, lieu_habitation VARCHAR(255) DEFAULT NULL, occupation VARCHAR(255) DEFAULT NULL, nom_pere VARCHAR(255) DEFAULT NULL, num_pere VARCHAR(255) DEFAULT NULL, nom_mere VARCHAR(255) DEFAULT NULL, num_mere VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, statut INT NOT NULL, date_creation DATETIME NOT NULL, user_creation VARCHAR(255) NOT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, telephone VARCHAR(15) DEFAULT NULL, INDEX IDX_8DC4E6859DDF9A9E (branche_id), INDEX IDX_8DC4E6857A45358C (groupe_id), UNIQUE INDEX UNIQ_8DC4E6854296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT NOT NULL, groupe_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, dob DATE NOT NULL, habitation VARCHAR(255) NOT NULL, occupation VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) NOT NULL, date_modification VARCHAR(255) DEFAULT NULL, user_modification VARCHAR(255) NOT NULL, statut INT NOT NULL, INDEX IDX_52520D077A45358C (groupe_id), INDEX IDX_52520D074296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6859DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6857A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6854296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D077A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D074296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE cotisation CHANGE jeune_id jeune_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED15924E15 FOREIGN KEY (jeune_id) REFERENCES jeune (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED6E32D7DB FOREIGN KEY (annee_pastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C15487A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercer_fonction CHANGE responsable_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A70306E32D7DB FOREIGN KEY (annee_pastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A703053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A703057889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE exercer_fonction_district ADD CONSTRAINT FK_E44521067DCF23F5 FOREIGN KEY (exercer_fonction_id) REFERENCES exercer_fonction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercer_fonction_district ADD CONSTRAINT FK_E4452106B08FA272 FOREIGN KEY (district_id) REFERENCES district (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription CHANGE jeunes_id jeunes_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D68AB9CB80 FOREIGN KEY (jeunes_id) REFERENCES jeune (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64953C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE responsable_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B353C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED15924E15');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D68AB9CB80');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED53C59D72');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A703053C59D72');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64953C59D72');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B353C59D72');
        $this->addSql('DROP TABLE jeune');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED6E32D7DB');
        $this->addSql('ALTER TABLE cotisation CHANGE jeune_id jeune_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\', CHANGE responsable_id responsable_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C15487A76ED395');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A70306E32D7DB');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A703057889920');
        $this->addSql('ALTER TABLE exercer_fonction CHANGE responsable_id responsable_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE exercer_fonction_district DROP FOREIGN KEY FK_E44521067DCF23F5');
        $this->addSql('ALTER TABLE exercer_fonction_district DROP FOREIGN KEY FK_E4452106B08FA272');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6543EC5F0');
        $this->addSql('ALTER TABLE inscription CHANGE jeunes_id jeunes_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A45358C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B08FA272');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE utilisateur CHANGE responsable_id responsable_id CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\'');
    }
}
