<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251126213623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activites (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, branche_id INT DEFAULT NULL, anneepastorale_id INT NOT NULL, description VARCHAR(500) DEFAULT NULL, localisation VARCHAR(500) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, heure_debut TIME DEFAULT NULL, heure_fin TIME DEFAULT NULL, statut INT NOT NULL, autorisation VARCHAR(255) DEFAULT NULL, nbre_participant INT NOT NULL, prix INT NOT NULL, nom VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, date_validation DATETIME DEFAULT NULL, date_creation DATETIME NOT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, bactif TINYINT(1) NOT NULL, cible VARCHAR(255) NOT NULL, b_one_day TINYINT(1) NOT NULL, b_soumis TINYINT(1) NOT NULL, INDEX IDX_766B5EB57A45358C (groupe_id), INDEX IDX_766B5EB59DDF9A9E (branche_id), INDEX IDX_766B5EB5ED0F89B8 (anneepastorale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annee_pastorale (id INT AUTO_INCREMENT NOT NULL, code_annee VARCHAR(15) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, b_actif TINYINT(1) NOT NULL, date_creation DATE DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATE DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilan_treso_event (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, total_credit BIGINT NOT NULL, total_debit BIGINT NOT NULL, date_bilan DATETIME NOT NULL, utilisateur_creation INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE branche (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, tranche_age VARCHAR(255) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caisse_activite (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caisse_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usercreate INT DEFAULT NULL, user_modification INT DEFAULT NULL, solde BIGINT DEFAULT NULL, UNIQUE INDEX UNIQ_89EA3407A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commissariat_district (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, datecreation DATETIME DEFAULT NULL, usercreation DATETIME DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, telephone VARCHAR(15) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cotisation (id INT AUTO_INCREMENT NOT NULL, jeune_id INT DEFAULT NULL, responsable_id INT DEFAULT NULL, annee_pastorale_id INT NOT NULL, matricule VARCHAR(20) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, INDEX IDX_AE64D2ED15924E15 (jeune_id), INDEX IDX_AE64D2ED53C59D72 (responsable_id), INDEX IDX_AE64D2ED6E32D7DB (annee_pastorale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE details (id INT AUTO_INCREMENT NOT NULL, branche_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, deroulement VARCHAR(500) DEFAULT NULL, date DATE NOT NULL, heuredebut TIME NOT NULL, heure_fin TIME NOT NULL, cible VARCHAR(255) NOT NULL, objectif VARCHAR(500) DEFAULT NULL, impact VARCHAR(500) DEFAULT NULL, statut INT NOT NULL, commentaire VARCHAR(500) DEFAULT NULL, bactif TINYINT(1) NOT NULL, user_creation INT DEFAULT NULL, date_creation DATETIME DEFAULT NULL, user_modification INT DEFAULT NULL, date_modification DATETIME DEFAULT NULL, responsable_activite VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(15) DEFAULT NULL, date_validation DATETIME DEFAULT NULL, INDEX IDX_72260B8A9DDF9A9E (branche_id), INDEX IDX_72260B8A9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, commissariat_district_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, dob VARCHAR(255) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, telephone VARCHAR(10) DEFAULT NULL, email VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_31C15487A76ED395 (user_id), INDEX IDX_31C154876066AA10 (commissariat_district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, type_document_id INT NOT NULL, activite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, extension VARCHAR(255) DEFAULT NULL, directory_path VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, user_creation VARCHAR(255) DEFAULT NULL, INDEX IDX_A2B072888826AFA6 (type_document_id), INDEX IDX_A2B072889B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, user_creation INT NOT NULL, date_modification DATETIME DEFAULT NULL, user_modification INT DEFAULT NULL, entite INT NOT NULL, id_entite INT NOT NULL, statut SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercer_fonction (id INT AUTO_INCREMENT NOT NULL, annee_pastorale_id INT DEFAULT NULL, responsable_id INT DEFAULT NULL, fonction_id INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL, date_fin DATETIME DEFAULT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, INDEX IDX_F99A70306E32D7DB (annee_pastorale_id), INDEX IDX_F99A703053C59D72 (responsable_id), INDEX IDX_F99A703057889920 (fonction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercer_fonction_district (exercer_fonction_id INT NOT NULL, district_id INT NOT NULL, INDEX IDX_E44521067DCF23F5 (exercer_fonction_id), INDEX IDX_E4452106B08FA272 (district_id), PRIMARY KEY(exercer_fonction_id, district_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation DATETIME DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, ordre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_responsable (formation_id INT NOT NULL, responsable_id INT NOT NULL, INDEX IDX_DAF2DDC5200282E (formation_id), INDEX IDX_DAF2DDC53C59D72 (responsable_id), PRIMARY KEY(formation_id, responsable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, commissariat_district_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, nick_name VARCHAR(255) NOT NULL, phone1 VARCHAR(15) DEFAULT NULL, phone2 VARCHAR(15) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, slogan VARCHAR(255) DEFAULT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, paroisse VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, extension VARCHAR(255) DEFAULT NULL, filebase VARCHAR(255) DEFAULT NULL, filebasetext LONGTEXT DEFAULT NULL, INDEX IDX_4B98C216066AA10 (commissariat_district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, jeunes_id INT NOT NULL, annee_id INT NOT NULL, date_inscription DATETIME NOT NULL, INDEX IDX_5E90F6D68AB9CB80 (jeunes_id), INDEX IDX_5E90F6D6543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeune (id INT NOT NULL, branche_id INT DEFAULT NULL, groupe_id INT NOT NULL, genre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, dob DATE NOT NULL, lieu_habitation VARCHAR(255) DEFAULT NULL, occupation VARCHAR(255) DEFAULT NULL, nom_pere VARCHAR(255) DEFAULT NULL, num_pere VARCHAR(255) DEFAULT NULL, nom_mere VARCHAR(255) DEFAULT NULL, num_mere VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, statut INT NOT NULL, date_creation DATETIME NOT NULL, user_creation VARCHAR(255) NOT NULL, date_modification DATETIME DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, telephone VARCHAR(15) DEFAULT NULL, INDEX IDX_8DC4E6859DDF9A9E (branche_id), INDEX IDX_8DC4E6857A45358C (groupe_id), INDEX IDX_8DC4E6854296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maitrise (id INT AUTO_INCREMENT NOT NULL, activite_id INT DEFAULT NULL, relation_id INT DEFAULT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification DATETIME DEFAULT NULL, bactif TINYINT(1) NOT NULL, INDEX IDX_9F5E12959B0F88B1 (activite_id), INDEX IDX_9F5E12953256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement_entite (id INT AUTO_INCREMENT NOT NULL, periode_id INT NOT NULL, sousrubrique_id INT NOT NULL, datemvt DATETIME NOT NULL, montant BIGINT NOT NULL, description VARCHAR(255) NOT NULL, entite_id INT NOT NULL, usermvt INT NOT NULL, entite SMALLINT NOT NULL, INDEX IDX_60699611F384C1CF (periode_id), INDEX IDX_60699611BEE02DA1 (sousrubrique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, periode_id INT DEFAULT NULL, caisse_id INT DEFAULT NULL, typemouvement_id INT DEFAULT NULL, datemouvement DATETIME NOT NULL, montant BIGINT NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, datemodification DATETIME DEFAULT NULL, usermodification INT DEFAULT NULL, INDEX IDX_7EF902177A45358C (groupe_id), INDEX IDX_7EF90217F384C1CF (periode_id), INDEX IDX_7EF9021727B4FEBF (caisse_id), INDEX IDX_7EF90217F975A74D (typemouvement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement_treso_activite (id INT AUTO_INCREMENT NOT NULL, sous_rubrique_id INT NOT NULL, periode_id INT NOT NULL, montant BIGINT NOT NULL, date_mouvement DATETIME NOT NULL, event_id INT NOT NULL, commentaire VARCHAR(50) DEFAULT NULL, user_creation SMALLINT NOT NULL, INDEX IDX_5800C1CD7BEAFB00 (sous_rubrique_id), INDEX IDX_5800C1CDF384C1CF (periode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, anneepastorale_id INT NOT NULL, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, etat INT NOT NULL, datecreate DATETIME NOT NULL, datemodification DATETIME DEFAULT NULL, usercreate INT NOT NULL, usermodification INT DEFAULT NULL, code VARCHAR(50) NOT NULL, INDEX IDX_93C32DF3ED0F89B8 (anneepastorale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, datecreation DATETIME DEFAULT NULL, usercreation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT NOT NULL, groupe_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, dob DATE NOT NULL, habitation VARCHAR(255) NOT NULL, occupation VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) NOT NULL, date_modification VARCHAR(255) DEFAULT NULL, user_modification VARCHAR(255) DEFAULT NULL, statut INT NOT NULL, email VARCHAR(100) DEFAULT NULL, INDEX IDX_52520D077A45358C (groupe_id), INDEX IDX_52520D074296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable_formation (id INT AUTO_INCREMENT NOT NULL, responsable_id_id INT NOT NULL, formation_id_id INT NOT NULL, datecreation DATETIME DEFAULT NULL, dateformation VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, identification VARCHAR(255) DEFAULT NULL, INDEX IDX_BD0670A91ED5BB35 (responsable_id_id), INDEX IDX_BD0670A99CF0022 (formation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, libelle VARCHAR(50) NOT NULL, sens VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique_budget (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, bactif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sens_rubrique (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, sens VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_formation (id INT AUTO_INCREMENT NOT NULL, stage_formation_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, directeur_stage VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, INDEX IDX_3A264B5120ED475 (stage_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_formation_responsable (id INT AUTO_INCREMENT NOT NULL, session_id_id INT DEFAULT NULL, responsable_id_id INT DEFAULT NULL, ref_diplome VARCHAR(50) DEFAULT NULL, bconfirm_pariticpation TINYINT(1) DEFAULT NULL, binscrit TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, INDEX IDX_948F929EA4392681 (session_id_id), INDEX IDX_948F929E1ED5BB35 (responsable_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_rubrique (id INT AUTO_INCREMENT NOT NULL, rubrique_id INT NOT NULL, code VARCHAR(50) NOT NULL, libelle VARCHAR(50) NOT NULL, type INT DEFAULT NULL, date_creation DATETIME NOT NULL, user_creation INT DEFAULT NULL, date_modification DATETIME DEFAULT NULL, user_modification INT DEFAULT NULL, INDEX IDX_87EA3D293BD38833 (rubrique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tresorerie_activite (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, solde BIGINT NOT NULL, date_solde DATETIME NOT NULL, date_creation DATETIME NOT NULL, user_creation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, bactif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_mouvement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(1) NOT NULL, datecreate DATETIME NOT NULL, usercreate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, responsable_id INT NOT NULL, district_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, user_creation VARCHAR(255) NOT NULL, b_actif TINYINT(1) NOT NULL, first_connection TINYINT(1) NOT NULL, last_connection DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D6497A45358C (groupe_id), UNIQUE INDEX UNIQ_8D93D64953C59D72 (responsable_id), UNIQUE INDEX UNIQ_8D93D649B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, responsable_id INT DEFAULT NULL, password VARCHAR(255) NOT NULL, date_creation DATETIME DEFAULT NULL, user_creation VARCHAR(255) NOT NULL, date_modification DATETIME DEFAULT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B353C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB57A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB59DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB5ED0F89B8 FOREIGN KEY (anneepastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE caisse_groupe ADD CONSTRAINT FK_89EA3407A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED15924E15 FOREIGN KEY (jeune_id) REFERENCES jeune (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED6E32D7DB FOREIGN KEY (annee_pastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A9DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C15487A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C154876066AA10 FOREIGN KEY (commissariat_district_id) REFERENCES commissariat_district (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072888826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072889B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A70306E32D7DB FOREIGN KEY (annee_pastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A703053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A703057889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE exercer_fonction_district ADD CONSTRAINT FK_E44521067DCF23F5 FOREIGN KEY (exercer_fonction_id) REFERENCES exercer_fonction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercer_fonction_district ADD CONSTRAINT FK_E4452106B08FA272 FOREIGN KEY (district_id) REFERENCES district (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_responsable ADD CONSTRAINT FK_DAF2DDC5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_responsable ADD CONSTRAINT FK_DAF2DDC53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C216066AA10 FOREIGN KEY (commissariat_district_id) REFERENCES commissariat_district (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D68AB9CB80 FOREIGN KEY (jeunes_id) REFERENCES jeune (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6859DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6857A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6854296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE maitrise ADD CONSTRAINT FK_9F5E12959B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE maitrise ADD CONSTRAINT FK_9F5E12953256915B FOREIGN KEY (relation_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE mouvement_entite ADD CONSTRAINT FK_60699611F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE mouvement_entite ADD CONSTRAINT FK_60699611BEE02DA1 FOREIGN KEY (sousrubrique_id) REFERENCES sous_rubrique (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF902177A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF9021727B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_groupe (id)');
        $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CD7BEAFB00 FOREIGN KEY (sous_rubrique_id) REFERENCES sous_rubrique (id)');
        $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CDF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF3ED0F89B8 FOREIGN KEY (anneepastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D077A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D074296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE responsable_formation ADD CONSTRAINT FK_BD0670A91ED5BB35 FOREIGN KEY (responsable_id_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE responsable_formation ADD CONSTRAINT FK_BD0670A99CF0022 FOREIGN KEY (formation_id_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session_formation ADD CONSTRAINT FK_3A264B5120ED475 FOREIGN KEY (stage_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929EA4392681 FOREIGN KEY (session_id_id) REFERENCES session_formation (id)');
        $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929E1ED5BB35 FOREIGN KEY (responsable_id_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE sous_rubrique ADD CONSTRAINT FK_87EA3D293BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64953C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B353C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB57A45358C');
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB59DDF9A9E');
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB5ED0F89B8');
        $this->addSql('ALTER TABLE caisse_groupe DROP FOREIGN KEY FK_89EA3407A45358C');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED15924E15');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED53C59D72');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED6E32D7DB');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8A9DDF9A9E');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8A9B0F88B1');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C15487A76ED395');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C154876066AA10');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072888826AFA6');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072889B0F88B1');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A70306E32D7DB');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A703053C59D72');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A703057889920');
        $this->addSql('ALTER TABLE exercer_fonction_district DROP FOREIGN KEY FK_E44521067DCF23F5');
        $this->addSql('ALTER TABLE exercer_fonction_district DROP FOREIGN KEY FK_E4452106B08FA272');
        $this->addSql('ALTER TABLE formation_responsable DROP FOREIGN KEY FK_DAF2DDC5200282E');
        $this->addSql('ALTER TABLE formation_responsable DROP FOREIGN KEY FK_DAF2DDC53C59D72');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C216066AA10');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D68AB9CB80');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6543EC5F0');
        $this->addSql('ALTER TABLE jeune DROP FOREIGN KEY FK_8DC4E6859DDF9A9E');
        $this->addSql('ALTER TABLE jeune DROP FOREIGN KEY FK_8DC4E6857A45358C');
        $this->addSql('ALTER TABLE jeune DROP FOREIGN KEY FK_8DC4E6854296D31F');
        $this->addSql('ALTER TABLE maitrise DROP FOREIGN KEY FK_9F5E12959B0F88B1');
        $this->addSql('ALTER TABLE maitrise DROP FOREIGN KEY FK_9F5E12953256915B');
        $this->addSql('ALTER TABLE mouvement_entite DROP FOREIGN KEY FK_60699611F384C1CF');
        $this->addSql('ALTER TABLE mouvement_entite DROP FOREIGN KEY FK_60699611BEE02DA1');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF902177A45358C');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F384C1CF');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF9021727B4FEBF');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F975A74D');
        $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CD7BEAFB00');
        $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CDF384C1CF');
        $this->addSql('ALTER TABLE periode DROP FOREIGN KEY FK_93C32DF3ED0F89B8');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D077A45358C');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D074296D31F');
        $this->addSql('ALTER TABLE responsable_formation DROP FOREIGN KEY FK_BD0670A91ED5BB35');
        $this->addSql('ALTER TABLE responsable_formation DROP FOREIGN KEY FK_BD0670A99CF0022');
        $this->addSql('ALTER TABLE session_formation DROP FOREIGN KEY FK_3A264B5120ED475');
        $this->addSql('ALTER TABLE session_formation_responsable DROP FOREIGN KEY FK_948F929EA4392681');
        $this->addSql('ALTER TABLE session_formation_responsable DROP FOREIGN KEY FK_948F929E1ED5BB35');
        $this->addSql('ALTER TABLE sous_rubrique DROP FOREIGN KEY FK_87EA3D293BD38833');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A45358C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64953C59D72');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B08FA272');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B353C59D72');
        $this->addSql('DROP TABLE activites');
        $this->addSql('DROP TABLE annee_pastorale');
        $this->addSql('DROP TABLE bilan_treso_event');
        $this->addSql('DROP TABLE branche');
        $this->addSql('DROP TABLE caisse_activite');
        $this->addSql('DROP TABLE caisse_groupe');
        $this->addSql('DROP TABLE commissariat_district');
        $this->addSql('DROP TABLE cotisation');
        $this->addSql('DROP TABLE details');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE exercer_fonction');
        $this->addSql('DROP TABLE exercer_fonction_district');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_responsable');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE jeune');
        $this->addSql('DROP TABLE maitrise');
        $this->addSql('DROP TABLE mouvement_entite');
        $this->addSql('DROP TABLE mouvement_groupe');
        $this->addSql('DROP TABLE mouvement_treso_activite');
        $this->addSql('DROP TABLE periode');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE responsable_formation');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE rubrique_budget');
        $this->addSql('DROP TABLE sens_rubrique');
        $this->addSql('DROP TABLE session_formation');
        $this->addSql('DROP TABLE session_formation_responsable');
        $this->addSql('DROP TABLE sous_rubrique');
        $this->addSql('DROP TABLE tresorerie_activite');
        $this->addSql('DROP TABLE type_document');
        $this->addSql('DROP TABLE type_mouvement');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utilisateur');
    }
}
