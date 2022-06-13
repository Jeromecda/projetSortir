<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613115423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE lieu CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE sortie ADD etat_no_etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F21A06963E FOREIGN KEY (etat_no_etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F21A06963E ON sortie (etat_no_etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE etat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE etat CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE lieu MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE lieu DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE lieu CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F21A06963E');
        $this->addSql('DROP INDEX IDX_3C3FD3F21A06963E ON sortie');
        $this->addSql('ALTER TABLE sortie DROP etat_no_etat_id');
    }
}
