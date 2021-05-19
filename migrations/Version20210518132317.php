<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518132317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offres (id INT AUTO_INCREMENT NOT NULL, remise INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD connect TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE voyage ADD offres_id INT DEFAULT NULL, ADD price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D89556C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id)');
        $this->addSql('CREATE INDEX IDX_3F9D89556C83CD9F ON voyage (offres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D89556C83CD9F');
        $this->addSql('DROP TABLE offres');
        $this->addSql('ALTER TABLE client DROP connect');
        $this->addSql('DROP INDEX IDX_3F9D89556C83CD9F ON voyage');
        $this->addSql('ALTER TABLE voyage DROP offres_id, DROP price');
    }
}
