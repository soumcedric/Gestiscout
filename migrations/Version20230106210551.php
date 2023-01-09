<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106210551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE caisse_activite (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE caisse_district (id INT AUTO_INCREMENT NOT NULL, district_id INT DEFAULT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usermodification INT DEFAULT NULL, usercreate INT NOT NULL, solde INT NOT NULL, date_solde DATETIME NOT NULL, UNIQUE INDEX UNIQ_E6F63F1FB08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE caisse_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usercreate INT DEFAULT NULL, user_modification INT DEFAULT NULL, solde BIGINT DEFAULT NULL, UNIQUE INDEX UNIQ_89EA3407A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, user_creation INT NOT NULL, date_modification DATETIME DEFAULT NULL, user_modification INT DEFAULT NULL, entite INT NOT NULL, id_entite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE mouvement_district (id INT AUTO_INCREMENT NOT NULL, typemouvement_id INT NOT NULL, caisse_id INT DEFAULT NULL, periode_id INT DEFAULT NULL, user_id INT NOT NULL, district_id INT NOT NULL, date_mvt DATETIME NOT NULL, montant BIGINT NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, datemodification DATETIME DEFAULT NULL, usermodifcation INT DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_B2DD1195F975A74D (typemouvement_id), INDEX IDX_B2DD119527B4FEBF (caisse_id), INDEX IDX_B2DD1195F384C1CF (periode_id), INDEX IDX_B2DD1195A76ED395 (user_id), INDEX IDX_B2DD1195B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE mouvement_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, periode_id INT DEFAULT NULL, caisse_id INT DEFAULT NULL, typemouvement_id INT DEFAULT NULL, datemouvement DATETIME NOT NULL, montant BIGINT NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, datemodification DATETIME DEFAULT NULL, usermodification INT DEFAULT NULL, INDEX IDX_7EF902177A45358C (groupe_id), INDEX IDX_7EF90217F384C1CF (periode_id), INDEX IDX_7EF9021727B4FEBF (caisse_id), INDEX IDX_7EF90217F975A74D (typemouvement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE mouvement_treso_activite (id INT AUTO_INCREMENT NOT NULL, sous_rubrique_id INT NOT NULL, periode_id INT NOT NULL, montant BIGINT NOT NULL, date_mouvement DATETIME NOT NULL, event_id INT NOT NULL, commentaire VARCHAR(50) DEFAULT NULL, user_creation SMALLINT NOT NULL, INDEX IDX_5800C1CD7BEAFB00 (sous_rubrique_id), INDEX IDX_5800C1CDF384C1CF (periode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, anneepastorale_id INT NOT NULL, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, etat INT NOT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usercreate INT NOT NULL, usermodification INT DEFAULT NULL, code VARCHAR(50) NOT NULL, INDEX IDX_93C32DF3ED0F89B8 (anneepastorale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, libelle VARCHAR(50) NOT NULL, type INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE sous_rubrique (id INT AUTO_INCREMENT NOT NULL, rubrique_id INT NOT NULL, code VARCHAR(50) NOT NULL, libelle VARCHAR(50) NOT NULL, type INT DEFAULT NULL, date_creation DATETIME NOT NULL, user_creation INT DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification INT DEFAULT NULL, INDEX IDX_87EA3D293BD38833 (rubrique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE tresorerie_activite (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, solde BIGINT NOT NULL, date_solde DATETIME NOT NULL, date_creation DATETIME NOT NULL, user_creation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_mouvement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(1) NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE caisse_district ADD CONSTRAINT FK_E6F63F1FB08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        // $this->addSql('ALTER TABLE caisse_groupe ADD CONSTRAINT FK_89EA3407A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        // $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD119527B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_district (id)');
        // $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE mouvement_district ADD CONSTRAINT FK_B2DD1195B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF902177A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF9021727B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        // $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CD7BEAFB00 FOREIGN KEY (sous_rubrique_id) REFERENCES sous_rubrique (id)');
        // $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CDF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF3ED0F89B8 FOREIGN KEY (anneepastorale_id) REFERENCES annee_pastorale (id)');
        // $this->addSql('ALTER TABLE sous_rubrique ADD CONSTRAINT FK_87EA3D293BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        // $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C154876066AA10');
        // $this->addSql('DROP INDEX IDX_31C154876066AA10 ON district');
        // $this->addSql('ALTER TABLE district DROP commissariat_district_id, DROP email');
        //$this->addSql('ALTER TABLE exercer_fonction CHANGE user_modification user_modification VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE fonction DROP role');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        // $this->addSql('ALTER TABLE responsable DROP email, CHANGE user_modification user_modification VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        // $this->addSql('ALTER TABLE user DROP first_connection, DROP last_connection, CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE mouvement_district DROP FOREIGN KEY FK_B2DD119527B4FEBF');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF9021727B4FEBF');
        // $this->addSql('ALTER TABLE mouvement_district DROP FOREIGN KEY FK_B2DD1195F384C1CF');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F384C1CF');
        // $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CDF384C1CF');
        // $this->addSql('ALTER TABLE sous_rubrique DROP FOREIGN KEY FK_87EA3D293BD38833');
        // $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CD7BEAFB00');
        // $this->addSql('ALTER TABLE mouvement_district DROP FOREIGN KEY FK_B2DD1195F975A74D');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F975A74D');
        // $this->addSql('DROP TABLE caisse_activite');
        // $this->addSql('DROP TABLE caisse_district');
        // $this->addSql('DROP TABLE caisse_groupe');
        // $this->addSql('DROP TABLE evenement');
        // $this->addSql('DROP TABLE mouvement_district');
        // $this->addSql('DROP TABLE mouvement_groupe');
        // $this->addSql('DROP TABLE mouvement_treso_activite');
        // $this->addSql('DROP TABLE periode');
        // $this->addSql('DROP TABLE rubrique');
        // $this->addSql('DROP TABLE sous_rubrique');
        // $this->addSql('DROP TABLE tresorerie_activite');
        // $this->addSql('DROP TABLE type_mouvement');
        // $this->addSql('ALTER TABLE district ADD commissariat_district_id INT DEFAULT NULL, ADD email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        // $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C154876066AA10 FOREIGN KEY (commissariat_district_id) REFERENCES commissariat_district (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        // $this->addSql('CREATE INDEX IDX_31C154876066AA10 ON district (commissariat_district_id)');
        // $this->addSql('ALTER TABLE exercer_fonction CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        // $this->addSql('ALTER TABLE fonction ADD role VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        // $this->addSql('ALTER TABLE responsable ADD email VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        // $this->addSql('ALTER TABLE user ADD first_connection TINYINT(1) NOT NULL, ADD last_connection DATETIME DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
