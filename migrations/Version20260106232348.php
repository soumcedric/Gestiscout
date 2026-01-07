<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106232348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE localisation localisation VARCHAR(500) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE commune commune VARCHAR(255) DEFAULT NULL, CHANGE autorisation autorisation VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE commentaire commentaire VARCHAR(255) DEFAULT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL, CHANGE cible cible VARCHAR(255) NOT NULL');
        //$this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB57A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        //$this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB59DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        //$this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB5ED0F89B8 FOREIGN KEY (anneepastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE annee_pastorale CHANGE code_annee code_annee VARCHAR(15) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE branche CHANGE libelle libelle VARCHAR(255) NOT NULL, CHANGE tranche_age tranche_age VARCHAR(255) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL');
       // $this->addSql('ALTER TABLE caisse_groupe ADD CONSTRAINT FK_89EA3407A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE commissariat_district CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE nickname nickname VARCHAR(255) DEFAULT NULL, CHANGE filename filename VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(15) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        //$this->addSql('ALTER TABLE cotisation CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE jeune_id jeune_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE responsable_id responsable_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE matricule matricule VARCHAR(20) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED15924E15 FOREIGN KEY (jeune_id) REFERENCES jeune (id) ON DELETE SET NULL');
        // $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE SET NULL');
        // $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED6E32D7DB FOREIGN KEY (annee_pastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE details CHANGE libelle libelle VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE deroulement deroulement VARCHAR(500) DEFAULT NULL, CHANGE cible cible VARCHAR(255) NOT NULL, CHANGE objectif objectif VARCHAR(500) DEFAULT NULL, CHANGE impact impact VARCHAR(500) DEFAULT NULL, CHANGE commentaire commentaire VARCHAR(500) DEFAULT NULL, CHANGE responsable_activite responsable_activite VARCHAR(255) DEFAULT NULL, CHANGE fonction fonction VARCHAR(255) DEFAULT NULL, CHANGE contact contact VARCHAR(15) DEFAULT NULL');
        // $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A9DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        // $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE district CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenoms prenoms VARCHAR(255) NOT NULL, CHANGE dob dob VARCHAR(255) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(10) DEFAULT NULL, CHANGE email email VARCHAR(50) NOT NULL');
        // $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C15487A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C154876066AA10 FOREIGN KEY (commissariat_district_id) REFERENCES commissariat_district (id)');
        $this->addSql('ALTER TABLE documents CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE extension extension VARCHAR(255) DEFAULT NULL, CHANGE directory_path directory_path VARCHAR(255) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072888826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
        // $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072889B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE evenement CHANGE libelle libelle VARCHAR(50) NOT NULL');
       // $this->addSql('ALTER TABLE exercer_fonction CHANGE responsable_id responsable_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A70306E32D7DB FOREIGN KEY (annee_pastorale_id) REFERENCES annee_pastorale (id)');
        // $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A703053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        // $this->addSql('ALTER TABLE exercer_fonction ADD CONSTRAINT FK_F99A703057889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE exercer_fonction_district CHANGE district_id district_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        // $this->addSql('ALTER TABLE exercer_fonction_district ADD CONSTRAINT FK_E44521067DCF23F5 FOREIGN KEY (exercer_fonction_id) REFERENCES exercer_fonction (id) ON DELETE CASCADE');
        // $this->addSql('ALTER TABLE exercer_fonction_district ADD CONSTRAINT FK_E4452106B08FA272 FOREIGN KEY (district_id) REFERENCES district (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fonction CHANGE code code VARCHAR(255) NOT NULL, CHANGE libelle libelle VARCHAR(255) NOT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL, CHANGE role role VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE formation CHANGE libelle libelle VARCHAR(255) NOT NULL');
        //$this->addSql('ALTER TABLE formation_responsable CHANGE responsable_id responsable_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        // $this->addSql('ALTER TABLE formation_responsable ADD CONSTRAINT FK_DAF2DDC5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        // $this->addSql('ALTER TABLE formation_responsable ADD CONSTRAINT FK_DAF2DDC53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre CHANGE libelle libelle VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE groupe CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE nick_name nick_name VARCHAR(255) NOT NULL, CHANGE phone1 phone1 VARCHAR(15) DEFAULT NULL, CHANGE phone2 phone2 VARCHAR(15) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE logo logo VARCHAR(255) DEFAULT NULL, CHANGE slogan slogan VARCHAR(255) DEFAULT NULL, CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL, CHANGE paroisse paroisse VARCHAR(255) NOT NULL, CHANGE region region VARCHAR(255) NOT NULL, CHANGE filename filename VARCHAR(255) DEFAULT NULL, CHANGE extension extension VARCHAR(255) DEFAULT NULL, CHANGE filebase filebase VARCHAR(255) DEFAULT NULL, CHANGE filebasetext filebasetext LONGTEXT DEFAULT NULL');
       // $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C216066AA10 FOREIGN KEY (commissariat_district_id) REFERENCES commissariat_district (id)');
        $this->addSql('ALTER TABLE inscription CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE jeunes_id jeunes_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
      //  $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D68AB9CB80 FOREIGN KEY (jeunes_id) REFERENCES jeune (id)');
      //  $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE jeune CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenoms prenoms VARCHAR(255) NOT NULL, CHANGE lieu_habitation lieu_habitation VARCHAR(255) DEFAULT NULL, CHANGE occupation occupation VARCHAR(255) DEFAULT NULL, CHANGE nom_pere nom_pere VARCHAR(255) DEFAULT NULL, CHANGE num_pere num_pere VARCHAR(255) DEFAULT NULL, CHANGE nom_mere nom_mere VARCHAR(255) DEFAULT NULL, CHANGE num_mere num_mere VARCHAR(255) DEFAULT NULL, CHANGE matricule matricule VARCHAR(255) DEFAULT NULL, CHANGE user_creation user_creation VARCHAR(255) NOT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(15) DEFAULT NULL');
        // $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6859DDF9A9E FOREIGN KEY (branche_id) REFERENCES branche (id)');
        // $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6857A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        // $this->addSql('ALTER TABLE jeune ADD CONSTRAINT FK_8DC4E6854296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE maitrise CHANGE relation_id relation_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE user_creation user_creation VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE maitrise ADD CONSTRAINT FK_9F5E12959B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        // $this->addSql('ALTER TABLE maitrise ADD CONSTRAINT FK_9F5E12953256915B FOREIGN KEY (relation_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE mouvement_entite CHANGE description description VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE mouvement_entite ADD CONSTRAINT FK_60699611F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE mouvement_entite ADD CONSTRAINT FK_60699611BEE02DA1 FOREIGN KEY (sousrubrique_id) REFERENCES sous_rubrique (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF902177A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF9021727B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        $this->addSql('ALTER TABLE mouvement_treso_activite CHANGE commentaire commentaire VARCHAR(50) DEFAULT NULL');
        // $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CD7BEAFB00 FOREIGN KEY (sous_rubrique_id) REFERENCES sous_rubrique (id)');
        // $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CDF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        $this->addSql('ALTER TABLE periode CHANGE code code VARCHAR(50) NOT NULL');
       // $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF3ED0F89B8 FOREIGN KEY (anneepastorale_id) REFERENCES annee_pastorale (id)');
        $this->addSql('ALTER TABLE region CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE nickname nickname VARCHAR(255) NOT NULL, CHANGE usercreation usercreation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenoms prenoms VARCHAR(255) NOT NULL, CHANGE habitation habitation VARCHAR(255) NOT NULL, CHANGE occupation occupation VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) NOT NULL, CHANGE date_modification date_modification VARCHAR(255) DEFAULT NULL, CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(100) DEFAULT NULL');
       // $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D077A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
       // $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D074296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        //$this->addSql('ALTER TABLE responsable_formation CHANGE responsable_id_id responsable_id_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE dateformation dateformation VARCHAR(255) DEFAULT NULL, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL, CHANGE identification identification VARCHAR(255) DEFAULT NULL');
       // $this->addSql('ALTER TABLE responsable_formation ADD CONSTRAINT FK_BD0670A91ED5BB35 FOREIGN KEY (responsable_id_id) REFERENCES responsable (id)');
       // $this->addSql('ALTER TABLE responsable_formation ADD CONSTRAINT FK_BD0670A99CF0022 FOREIGN KEY (formation_id_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE rubrique CHANGE code code VARCHAR(50) NOT NULL, CHANGE libelle libelle VARCHAR(50) NOT NULL, CHANGE sens sens VARCHAR(1) NOT NULL');
        $this->addSql('ALTER TABLE rubrique_budget CHANGE libelle libelle VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sens_rubrique CHANGE libelle libelle VARCHAR(255) NOT NULL, CHANGE sens sens VARCHAR(1) NOT NULL');
        $this->addSql('ALTER TABLE session_formation CHANGE directeur_stage directeur_stage VARCHAR(255) DEFAULT NULL, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL');
        //$this->addSql('ALTER TABLE session_formation ADD CONSTRAINT FK_3A264B5120ED475 FOREIGN KEY (stage_formation_id) REFERENCES formation (id)');
        //$this->addSql('ALTER TABLE session_formation_responsable CHANGE responsable_id_id responsable_id_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE ref_diplome ref_diplome VARCHAR(50) DEFAULT NULL');
       // $this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929EA4392681 FOREIGN KEY (session_id_id) REFERENCES session_formation (id)');
        //$this->addSql('ALTER TABLE session_formation_responsable ADD CONSTRAINT FK_948F929E1ED5BB35 FOREIGN KEY (responsable_id_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE sous_rubrique CHANGE code code VARCHAR(50) NOT NULL, CHANGE libelle libelle VARCHAR(50) NOT NULL');
        //$this->addSql('ALTER TABLE sous_rubrique ADD CONSTRAINT FK_87EA3D293BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE type_document CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE type_mouvement CHANGE libelle libelle VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(1) NOT NULL');
        //$this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE district_id district_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE username username VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        // $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64953C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        // $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
       // $this->addSql('ALTER TABLE utilisateur CHANGE responsable_id responsable_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE password password VARCHAR(255) NOT NULL, CHANGE user_creation user_creation VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(255) NOT NULL');
       // $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B353C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       // $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB57A45358C');
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB59DDF9A9E');
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB5ED0F89B8');
        $this->addSql('ALTER TABLE activites CHANGE description description VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE localisation localisation VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commune commune VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE autorisation autorisation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commentaire commentaire VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cible cible VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE annee_pastorale CHANGE code_annee code_annee VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE branche CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tranche_age tranche_age VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE caisse_groupe DROP FOREIGN KEY FK_89EA3407A45358C');
        $this->addSql('ALTER TABLE commissariat_district CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nickname nickname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED15924E15');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED53C59D72');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED6E32D7DB');
        $this->addSql('ALTER TABLE cotisation CHANGE id id CHAR(36) NOT NULL, CHANGE jeune_id jeune_id CHAR(36) DEFAULT NULL, CHANGE responsable_id responsable_id CHAR(36) DEFAULT NULL, CHANGE matricule matricule VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8A9DDF9A9E');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8A9B0F88B1');
        $this->addSql('ALTER TABLE details CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE deroulement deroulement VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cible cible VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE objectif objectif VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE impact impact VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commentaire commentaire VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE responsable_activite responsable_activite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fonction fonction VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact contact VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C15487A76ED395');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C154876066AA10');
        $this->addSql('ALTER TABLE district CHANGE id id CHAR(36) NOT NULL, CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenoms prenoms VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE dob dob VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072888826AFA6');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072889B0F88B1');
        $this->addSql('ALTER TABLE documents CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE extension extension VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE directory_path directory_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evenement CHANGE libelle libelle VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A70306E32D7DB');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A703053C59D72');
        $this->addSql('ALTER TABLE exercer_fonction DROP FOREIGN KEY FK_F99A703057889920');
        $this->addSql('ALTER TABLE exercer_fonction CHANGE responsable_id responsable_id CHAR(36) DEFAULT NULL, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE exercer_fonction_district DROP FOREIGN KEY FK_E44521067DCF23F5');
        $this->addSql('ALTER TABLE exercer_fonction_district DROP FOREIGN KEY FK_E4452106B08FA272');
        $this->addSql('ALTER TABLE exercer_fonction_district CHANGE district_id district_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE fonction CHANGE code code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE role role VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation_responsable DROP FOREIGN KEY FK_DAF2DDC5200282E');
        $this->addSql('ALTER TABLE formation_responsable DROP FOREIGN KEY FK_DAF2DDC53C59D72');
        $this->addSql('ALTER TABLE formation_responsable CHANGE responsable_id responsable_id INT NOT NULL');
        $this->addSql('ALTER TABLE genre CHANGE libelle libelle VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C216066AA10');
        $this->addSql('ALTER TABLE groupe CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nick_name nick_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone1 phone1 VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone2 phone2 VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE logo logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slogan slogan VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE paroisse paroisse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE region region VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE extension extension VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE filebase filebase VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE filebasetext filebasetext LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D68AB9CB80');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6543EC5F0');
        $this->addSql('ALTER TABLE inscription CHANGE id id CHAR(36) NOT NULL, CHANGE jeunes_id jeunes_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE jeune DROP FOREIGN KEY FK_8DC4E6859DDF9A9E');
        $this->addSql('ALTER TABLE jeune DROP FOREIGN KEY FK_8DC4E6857A45358C');
        $this->addSql('ALTER TABLE jeune DROP FOREIGN KEY FK_8DC4E6854296D31F');
        $this->addSql('ALTER TABLE jeune CHANGE id id CHAR(36) NOT NULL, CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenoms prenoms VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu_habitation lieu_habitation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE occupation occupation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_pere nom_pere VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_pere num_pere VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_mere nom_mere VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_mere num_mere VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE matricule matricule VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE maitrise DROP FOREIGN KEY FK_9F5E12959B0F88B1');
        $this->addSql('ALTER TABLE maitrise DROP FOREIGN KEY FK_9F5E12953256915B');
        $this->addSql('ALTER TABLE maitrise CHANGE relation_id relation_id INT DEFAULT NULL, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE mouvement_entite DROP FOREIGN KEY FK_60699611F384C1CF');
        $this->addSql('ALTER TABLE mouvement_entite DROP FOREIGN KEY FK_60699611BEE02DA1');
        $this->addSql('ALTER TABLE mouvement_entite CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF902177A45358C');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F384C1CF');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF9021727B4FEBF');
        $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F975A74D');
        $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CD7BEAFB00');
        $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CDF384C1CF');
        $this->addSql('ALTER TABLE mouvement_treso_activite CHANGE commentaire commentaire VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE periode DROP FOREIGN KEY FK_93C32DF3ED0F89B8');
        $this->addSql('ALTER TABLE periode CHANGE code code VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE region CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nickname nickname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE usercreation usercreation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D077A45358C');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D074296D31F');
        $this->addSql('ALTER TABLE responsable CHANGE id id CHAR(36) NOT NULL, CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenoms prenoms VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE habitation habitation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE occupation occupation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_modification date_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE responsable_formation DROP FOREIGN KEY FK_BD0670A91ED5BB35');
        $this->addSql('ALTER TABLE responsable_formation DROP FOREIGN KEY FK_BD0670A99CF0022');
        $this->addSql('ALTER TABLE responsable_formation CHANGE responsable_id_id responsable_id_id CHAR(36) NOT NULL, CHANGE dateformation dateformation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu lieu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE identification identification VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rubrique CHANGE code code VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE libelle libelle VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sens sens VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rubrique_budget CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sens_rubrique CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sens sens VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE session_formation DROP FOREIGN KEY FK_3A264B5120ED475');
        $this->addSql('ALTER TABLE session_formation CHANGE directeur_stage directeur_stage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu lieu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE session_formation_responsable DROP FOREIGN KEY FK_948F929EA4392681');
        $this->addSql('ALTER TABLE session_formation_responsable DROP FOREIGN KEY FK_948F929E1ED5BB35');
        $this->addSql('ALTER TABLE session_formation_responsable CHANGE responsable_id_id responsable_id_id INT DEFAULT NULL, CHANGE ref_diplome ref_diplome VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sous_rubrique DROP FOREIGN KEY FK_87EA3D293BD38833');
        $this->addSql('ALTER TABLE sous_rubrique CHANGE code code VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE libelle libelle VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_document CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_mouvement CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code code VARCHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A45358C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64953C59D72');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B08FA272');
        $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id CHAR(36) DEFAULT NULL, CHANGE district_id district_id CHAR(36) DEFAULT NULL, CHANGE username username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B353C59D72');
        $this->addSql('ALTER TABLE utilisateur CHANGE responsable_id responsable_id INT DEFAULT NULL, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_creation user_creation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
