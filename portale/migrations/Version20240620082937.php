<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620082937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clienti (id INT AUTO_INCREMENT NOT NULL, ragione_sociale VARCHAR(255) NOT NULL, partita_iva VARCHAR(11) NOT NULL, indirizzo VARCHAR(255) NOT NULL, provincia VARCHAR(255) NOT NULL, cap VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, pec VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, settore_attivita VARCHAR(255) NOT NULL, id_agente INT NOT NULL, data_acquisizione DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clienti');
    }
}
