<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518154919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC43C13CE');
        $this->addSql('DROP INDEX IDX_C53D045FC43C13CE ON image');
        $this->addSql('ALTER TABLE image CHANGE voyage_org_id voyageorg_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F742BAC68 FOREIGN KEY (voyageorg_id) REFERENCES voyage_org (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F742BAC68 ON image (voyageorg_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F742BAC68');
        $this->addSql('DROP INDEX IDX_C53D045F742BAC68 ON image');
        $this->addSql('ALTER TABLE image CHANGE voyageorg_id voyage_org_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC43C13CE FOREIGN KEY (voyage_org_id) REFERENCES voyage_org (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FC43C13CE ON image (voyage_org_id)');
    }
}
