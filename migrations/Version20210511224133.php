<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511224133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(8) NOT NULL, password VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aeroport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avion (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) DEFAULT NULL, nb_place INT DEFAULT NULL, heberg VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avion_voyage (id INT AUTO_INCREMENT NOT NULL, av_id INT DEFAULT NULL, voy_id INT DEFAULT NULL, etat VARCHAR(100) DEFAULT NULL, INDEX IDX_EE3E1C56B5244A82 (av_id), INDEX IDX_EE3E1C56F8EC5CD7 (voy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, cin VARCHAR(8) NOT NULL, nom_prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) DEFAULT NULL, tel VARCHAR(8) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, cl_id INT DEFAULT NULL, voy_id INT DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, INDEX IDX_67F068BCF040AE19 (cl_id), INDEX IDX_67F068BCF8EC5CD7 (voy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, cl_id INT DEFAULT NULL, voy_id INT DEFAULT NULL, nb_pers INT DEFAULT NULL, INDEX IDX_42C84955F040AE19 (cl_id), INDEX IDX_42C84955F8EC5CD7 (voy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage (id INT AUTO_INCREMENT NOT NULL, ar_depart_id INT DEFAULT NULL, ar_arrive_id INT DEFAULT NULL, ar_escale_id INT DEFAULT NULL, date_aller DATE NOT NULL, date_retour DATE DEFAULT NULL, INDEX IDX_3F9D89556E783A1A (ar_depart_id), INDEX IDX_3F9D895534784219 (ar_arrive_id), INDEX IDX_3F9D8955A29489BF (ar_escale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage_org (id INT AUTO_INCREMENT NOT NULL, voy_id INT DEFAULT NULL, nb_jour INT NOT NULL, ville VARCHAR(255) NOT NULL, INDEX IDX_5FC0A58FF8EC5CD7 (voy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avion_voyage ADD CONSTRAINT FK_EE3E1C56B5244A82 FOREIGN KEY (av_id) REFERENCES avion (id)');
        $this->addSql('ALTER TABLE avion_voyage ADD CONSTRAINT FK_EE3E1C56F8EC5CD7 FOREIGN KEY (voy_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF040AE19 FOREIGN KEY (cl_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF8EC5CD7 FOREIGN KEY (voy_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955F040AE19 FOREIGN KEY (cl_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955F8EC5CD7 FOREIGN KEY (voy_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D89556E783A1A FOREIGN KEY (ar_depart_id) REFERENCES aeroport (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D895534784219 FOREIGN KEY (ar_arrive_id) REFERENCES aeroport (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955A29489BF FOREIGN KEY (ar_escale_id) REFERENCES aeroport (id)');
        $this->addSql('ALTER TABLE voyage_org ADD CONSTRAINT FK_5FC0A58FF8EC5CD7 FOREIGN KEY (voy_id) REFERENCES voyage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D89556E783A1A');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D895534784219');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955A29489BF');
        $this->addSql('ALTER TABLE avion_voyage DROP FOREIGN KEY FK_EE3E1C56B5244A82');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF040AE19');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955F040AE19');
        $this->addSql('ALTER TABLE avion_voyage DROP FOREIGN KEY FK_EE3E1C56F8EC5CD7');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF8EC5CD7');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955F8EC5CD7');
        $this->addSql('ALTER TABLE voyage_org DROP FOREIGN KEY FK_5FC0A58FF8EC5CD7');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE aeroport');
        $this->addSql('DROP TABLE avion');
        $this->addSql('DROP TABLE avion_voyage');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE voyage');
        $this->addSql('DROP TABLE voyage_org');
    }
}
