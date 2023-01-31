<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131120414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accueil (id_acc INT AUTO_INCREMENT NOT NULL, mess_pres_acc VARCHAR(3000) DEFAULT NULL, PRIMARY KEY(id_acc)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id_admin INT AUTO_INCREMENT NOT NULL, uti_admin VARCHAR(255) NOT NULL, mdp_admin VARCHAR(255) NOT NULL, PRIMARY KEY(id_admin)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id_cont INT AUTO_INCREMENT NOT NULL, nom_cont VARCHAR(255) DEFAULT NULL, prenom_cont VARCHAR(255) DEFAULT NULL, mail_cont VARCHAR(255) NOT NULL, inscription_cont SMALLINT DEFAULT NULL, PRIMARY KEY(id_cont)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id_fichier INT AUTO_INCREMENT NOT NULL, nom_fichier VARCHAR(255) NOT NULL, chemin_fichier VARCHAR(255) NOT NULL, PRIMARY KEY(id_fichier)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_offre (id_fo INT AUTO_INCREMENT NOT NULL, id_offre INT DEFAULT NULL, id_fichier INT DEFAULT NULL, INDEX IDX_98DF32574103C75F (id_offre), INDEX IDX_98DF325745EBFC6F (id_fichier), PRIMARY KEY(id_fo)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mess_utilisateur (id_mess INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, libelle_mess LONGTEXT DEFAULT NULL, INDEX IDX_44DEE15E7A1254A (contact_id), PRIMARY KEY(id_mess)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id_offre INT AUTO_INCREMENT NOT NULL, nom_offre VARCHAR(255) NOT NULL, desc_offre LONGTEXT NOT NULL, lien_offre VARCHAR(255) NOT NULL, date_debut_val DATETIME DEFAULT NULL, date_fin_val DATETIME DEFAULT NULL, date_debut_aff DATETIME DEFAULT NULL, date_fin_aff DATETIME DEFAULT NULL, num_aff INT DEFAULT NULL, PRIMARY KEY(id_offre)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, fichier_id INT DEFAULT NULL, nom_part VARCHAR(255) NOT NULL, desc_part VARCHAR(1500) NOT NULL, lien_part VARCHAR(255) NOT NULL, INDEX IDX_32FFA373F915CFE (fichier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id_question INT AUTO_INCREMENT NOT NULL, txt_question VARCHAR(255) NOT NULL, PRIMARY KEY(id_question)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id_rep INT AUTO_INCREMENT NOT NULL, id_question INT DEFAULT NULL, libelle_rep VARCHAR(255) NOT NULL, nb_rep INT NOT NULL, INDEX IDX_5FB6DEC7E62CA5DB (id_question), PRIMARY KEY(id_rep)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichier_offre ADD CONSTRAINT FK_98DF32574103C75F FOREIGN KEY (id_offre) REFERENCES offre (id_offre)');
        $this->addSql('ALTER TABLE fichier_offre ADD CONSTRAINT FK_98DF325745EBFC6F FOREIGN KEY (id_fichier) REFERENCES fichier (id_fichier)');
        $this->addSql('ALTER TABLE mess_utilisateur ADD CONSTRAINT FK_44DEE15E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id_cont)');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id_fichier)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7E62CA5DB FOREIGN KEY (id_question) REFERENCES question (id_question)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_offre DROP FOREIGN KEY FK_98DF32574103C75F');
        $this->addSql('ALTER TABLE fichier_offre DROP FOREIGN KEY FK_98DF325745EBFC6F');
        $this->addSql('ALTER TABLE mess_utilisateur DROP FOREIGN KEY FK_44DEE15E7A1254A');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373F915CFE');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7E62CA5DB');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE fichier_offre');
        $this->addSql('DROP TABLE mess_utilisateur');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reponse');
    }
}
