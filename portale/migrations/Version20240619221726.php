<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619221726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agenti (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cognome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents_zip_codes DROP FOREIGN KEY FK_CE43D72E85D0C4B8');
        $this->addSql('ALTER TABLE agents_zip_codes DROP FOREIGN KEY FK_CE43D72E84F95A00');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E7485D0C4B8');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E7469CF3E14');
        $this->addSql('ALTER TABLE zip_code DROP FOREIGN KEY FK_A1ACE158A7D28100');
        $this->addSql('DROP TABLE agents');
        $this->addSql('DROP TABLE agents_zip_codes');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE provinces');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE utenti');
        $this->addSql('DROP TABLE zip_code');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agents (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cognome VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE agents_zip_codes (id INT AUTO_INCREMENT NOT NULL, id_agente_id INT NOT NULL, id_zip_code_id INT NOT NULL, UNIQUE INDEX UNIQ_CE43D72E84F95A00 (id_zip_code_id), INDEX IDX_CE43D72E85D0C4B8 (id_agente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, cap_id INT NOT NULL, id_agente_id INT NOT NULL, ragione_sociale VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, partita_iva VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, indirizzo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, provincia VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pec VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, data_acquisizione DATETIME NOT NULL, telefono VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C82E7485D0C4B8 (id_agente_id), INDEX IDX_C82E7469CF3E14 (cap_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE provinces (id INT AUTO_INCREMENT NOT NULL, codice VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nome VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sigla VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utenti (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE zip_code (id INT AUTO_INCREMENT NOT NULL, codice_provincia_id INT NOT NULL, comune VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A1ACE158A7D28100 (codice_provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE agents_zip_codes ADD CONSTRAINT FK_CE43D72E85D0C4B8 FOREIGN KEY (id_agente_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE agents_zip_codes ADD CONSTRAINT FK_CE43D72E84F95A00 FOREIGN KEY (id_zip_code_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E7485D0C4B8 FOREIGN KEY (id_agente_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E7469CF3E14 FOREIGN KEY (cap_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE zip_code ADD CONSTRAINT FK_A1ACE158A7D28100 FOREIGN KEY (codice_provincia_id) REFERENCES provinces (id)');
        $this->addSql('DROP TABLE agenti');
    }
}
