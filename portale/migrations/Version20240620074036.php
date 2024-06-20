<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620074036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clienti (id INT AUTO_INCREMENT NOT NULL, cap_id INT NOT NULL, id_agente_id INT NOT NULL, ragione_sociale VARCHAR(255) NOT NULL, partita_iva VARCHAR(11) NOT NULL, indirizzo VARCHAR(255) NOT NULL, provincia VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, pec VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, settore_attivita VARCHAR(255) NOT NULL, data_acquisizione DATETIME NOT NULL, INDEX IDX_FDAAD70E69CF3E14 (cap_id), INDEX IDX_FDAAD70E85D0C4B8 (id_agente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clienti ADD CONSTRAINT FK_FDAAD70E69CF3E14 FOREIGN KEY (cap_id) REFERENCES cap (id)');
        $this->addSql('ALTER TABLE clienti ADD CONSTRAINT FK_FDAAD70E85D0C4B8 FOREIGN KEY (id_agente_id) REFERENCES agenti (id)');
        $this->addSql('ALTER TABLE cap CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clienti DROP FOREIGN KEY FK_FDAAD70E69CF3E14');
        $this->addSql('ALTER TABLE clienti DROP FOREIGN KEY FK_FDAAD70E85D0C4B8');
        $this->addSql('DROP TABLE clienti');
        $this->addSql('ALTER TABLE cap CHANGE id id VARCHAR(10) NOT NULL');
    }
}
