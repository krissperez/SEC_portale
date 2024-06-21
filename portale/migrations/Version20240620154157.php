<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620154157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenti ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE agenti_cap ADD id INT AUTO_INCREMENT NOT NULL, CHANGE codice_cap id_cap VARCHAR(255) NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenti DROP deleted_at');
        $this->addSql('ALTER TABLE agenti_cap MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON agenti_cap');
        $this->addSql('ALTER TABLE agenti_cap DROP id, CHANGE id_cap codice_cap VARCHAR(255) NOT NULL');
    }
}
