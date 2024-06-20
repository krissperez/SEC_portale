<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620072226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cap (id INT AUTO_INCREMENT NOT NULL, sigla_provincia_id INT NOT NULL, comune VARCHAR(255) NOT NULL, INDEX IDX_993387B19F59A79A (sigla_provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cap ADD CONSTRAINT FK_993387B19F59A79A FOREIGN KEY (sigla_provincia_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE province ADD sigla VARCHAR(2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cap DROP FOREIGN KEY FK_993387B19F59A79A');
        $this->addSql('DROP TABLE cap');
        $this->addSql('ALTER TABLE province DROP sigla');
    }
}
