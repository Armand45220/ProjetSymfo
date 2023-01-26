<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123143915 extends AbstractMigration
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
        $this->addSql('CREATE TABLE fichier (id_fichier INT AUTO_INCREMENT NOT NULL, nom_fichier VARCHAR(255) NOT NULL, chemin_fichier VARCHAR(255) NOT NULL, PRIMARY KEY(id_fichier)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, fichier_id INT DEFAULT NULL, nom_part VARCHAR(255) NOT NULL, desc_part VARCHAR(1500) NOT NULL, lien_part VARCHAR(255) NOT NULL, INDEX IDX_32FFA373F915CFE (fichier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id_fichier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373F915CFE');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE partenaire');
    }
}
