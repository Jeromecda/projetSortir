<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613130351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD site_no_site_id INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1168A0B557 FOREIGN KEY (site_no_site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B1168A0B557 ON participant (site_no_site_id)');
        $this->addSql('ALTER TABLE sortie ADD site_organisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2D7AC6C11 FOREIGN KEY (site_organisateur_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2D7AC6C11 ON sortie (site_organisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1168A0B557');
        $this->addSql('DROP INDEX IDX_D79F6B1168A0B557 ON participant');
        $this->addSql('ALTER TABLE participant DROP site_no_site_id');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2D7AC6C11');
        $this->addSql('DROP INDEX IDX_3C3FD3F2D7AC6C11 ON sortie');
        $this->addSql('ALTER TABLE sortie DROP site_organisateur_id');
    }
}
