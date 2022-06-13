<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613115740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu ADD ville_no_ville_id INT NOT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D595F3DE697 FOREIGN KEY (ville_no_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_2F577D595F3DE697 ON lieu (ville_no_ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D595F3DE697');
        $this->addSql('DROP INDEX IDX_2F577D595F3DE697 ON lieu');
        $this->addSql('ALTER TABLE lieu DROP ville_no_ville_id');
    }
}
