<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613100803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu ADD id_lieu INT AUTO_INCREMENT NOT NULL, DROP id, ADD PRIMARY KEY (id_lieu)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu MODIFY id_lieu INT NOT NULL');
        $this->addSql('ALTER TABLE lieu DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE lieu ADD id INT NOT NULL, DROP id_lieu');
    }
}
