<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620074307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clienti ADD CONSTRAINT FK_FDAAD70E69CF3E14 FOREIGN KEY (cap_id) REFERENCES cap (id)');
        $this->addSql('ALTER TABLE clienti ADD CONSTRAINT FK_FDAAD70E85D0C4B8 FOREIGN KEY (id_agente_id) REFERENCES agenti (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clienti DROP FOREIGN KEY FK_FDAAD70E69CF3E14');
        $this->addSql('ALTER TABLE clienti DROP FOREIGN KEY FK_FDAAD70E85D0C4B8');
    }
}
