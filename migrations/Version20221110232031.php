<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110232031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caisse_district (id INT AUTO_INCREMENT NOT NULL, district_id INT DEFAULT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usermodification INT DEFAULT NULL, usercreate INT NOT NULL, UNIQUE INDEX UNIQ_E6F63F1FB08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caisse_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usercreate INT DEFAULT NULL, user_modification INT DEFAULT NULL, solde BIGINT DEFAULT NULL, UNIQUE INDEX UNIQ_89EA3407A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement_district (id INT AUTO_INCREMENT NOT NULL, typemouvement_id INT NOT NULL, caisse_id INT NOT NULL, periode_id INT NOT NULL, user_id INT NOT NULL, date_mvt DATETIME NOT NULL, montant BIGINT NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, datemodification DATETIME DEFAULT NULL, usermodifcation INT DEFAULT NULL, INDEX IDX_B2DD1195F975A74D (typemouvement_id), INDEX IDX_B2DD119527B4FEBF (caisse_id), INDEX IDX_B2DD1195F384C1CF (periode_id), INDEX IDX_B2DD1195A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, periode_id INT DEFAULT NULL, caisse_id INT DEFAULT NULL, typemouvement_id INT DEFAULT NULL, datemouvement DATETIME NOT NULL, montant BIGINT NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, datemodification DATETIME DEFAULT NULL, usermodification INT DEFAULT NULL, INDEX IDX_7EF902177A45358C (groupe_id), INDEX IDX_7EF90217F384C1CF (periode_id), INDEX IDX_7EF9021727B4FEBF (caisse_id), INDEX IDX_7EF90217F975A74D (typemouvement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, etat INT NOT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usercreate INT NOT NULL, usermodification INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_mouvement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(1) NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caisse_district ADD CONSTRAINT FK_E6F63F1FB08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE caisse_groupe ADD CONSTRAINT FK_89EA3407A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD119527B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_district (id)');
        $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF902177A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF9021727B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_groupe (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mouvement_district DROP FOREIGN KEY FK_B2DD119527B4FEBF');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF9021727B4FEBF');
        $this->addSql('ALTER TABLE mouvement_district DROP FOREIGN KEY FK_B2DD1195F384C1CF');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F384C1CF');
        $this->addSql('ALTER TABLE mouvement_district DROP FOREIGN KEY FK_B2DD1195F975A74D');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F975A74D');
        $this->addSql('DROP TABLE caisse_district');
        $this->addSql('DROP TABLE caisse_groupe');
        $this->addSql('DROP TABLE mouvement_district');
        $this->addSql('DROP TABLE mouvement_groupe');
        $this->addSql('DROP TABLE periode');
        $this->addSql('DROP TABLE type_mouvement');
        $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
