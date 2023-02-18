<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217235013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bilan_treso_event (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, total_credit BIGINT NOT NULL, total_debit BIGINT NOT NULL, date_bilan DATETIME NOT NULL, utilisateur_creation INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercer_fonction CHANGE user_modification user_modification VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE fonction ADD role VARCHAR(50) NOT NULL');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT NOT NULL, CHANGE genre_id genre_id INT NOT NULL');
        // $this->addSql('ALTER TABLE mouvement_entite CHANGE entite entite SMALLINT NOT NULL');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF902177A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF9021727B4FEBF FOREIGN KEY (caisse_id) REFERENCES caisse_groupe (id)');
        // $this->addSql('ALTER TABLE mouvement_groupe ADD CONSTRAINT FK_7EF90217F975A74D FOREIGN KEY (typemouvement_id) REFERENCES type_mouvement (id)');
        // $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CD7BEAFB00 FOREIGN KEY (sous_rubrique_id) REFERENCES sous_rubrique (id)');
        // $this->addSql('ALTER TABLE mouvement_treso_activite ADD CONSTRAINT FK_5800C1CDF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id)');
        // $this->addSql('ALTER TABLE periode ADD CONSTRAINT FK_93C32DF3ED0F89B8 FOREIGN KEY (anneepastorale_id) REFERENCES annee_pastorale (id)');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) DEFAULT NULL');
        // $this->addSql('ALTER TABLE sous_rubrique ADD CONSTRAINT FK_87EA3D293BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bilan_treso_event');
        // $this->addSql('ALTER TABLE exercer_fonction CHANGE user_modification user_modification VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        // $this->addSql('ALTER TABLE fonction DROP role');
        // $this->addSql('ALTER TABLE jeune CHANGE groupe_id groupe_id INT DEFAULT NULL, CHANGE genre_id genre_id INT DEFAULT NULL');
        // $this->addSql('ALTER TABLE mouvement_entite CHANGE entite entite SMALLINT NOT NULL COMMENT \'1=groupe 2 =district\'');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF902177A45358C');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F384C1CF');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF9021727B4FEBF');
        // $this->addSql('ALTER TABLE mouvement_groupe DROP FOREIGN KEY FK_7EF90217F975A74D');
        // $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CD7BEAFB00');
        // $this->addSql('ALTER TABLE mouvement_treso_activite DROP FOREIGN KEY FK_5800C1CDF384C1CF');
        // $this->addSql('ALTER TABLE periode DROP FOREIGN KEY FK_93C32DF3ED0F89B8');
        // $this->addSql('ALTER TABLE session_formation_responsable CHANGE bconfirm_pariticpation bconfirm_pariticpation TINYINT(1) NOT NULL');
        // $this->addSql('ALTER TABLE sous_rubrique DROP FOREIGN KEY FK_87EA3D293BD38833');
        // $this->addSql('ALTER TABLE user CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
