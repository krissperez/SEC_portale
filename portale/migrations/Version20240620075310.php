<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620075310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agenti_cap (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agenti_cap_agenti (agenti_cap_id INT NOT NULL, agenti_id INT NOT NULL, INDEX IDX_3A28814710DE1C7 (agenti_cap_id), INDEX IDX_3A2881474F33C727 (agenti_id), PRIMARY KEY(agenti_cap_id, agenti_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agenti_cap_cap (agenti_cap_id INT NOT NULL, cap_id INT NOT NULL, INDEX IDX_F7E6B5D010DE1C7 (agenti_cap_id), INDEX IDX_F7E6B5D069CF3E14 (cap_id), PRIMARY KEY(agenti_cap_id, cap_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cap (id INT AUTO_INCREMENT NOT NULL, sigla_provincia_id INT NOT NULL, comune VARCHAR(255) NOT NULL, INDEX IDX_993387B19F59A79A (sigla_provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agenti_cap_agenti ADD CONSTRAINT FK_3A28814710DE1C7 FOREIGN KEY (agenti_cap_id) REFERENCES agenti_cap (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agenti_cap_agenti ADD CONSTRAINT FK_3A2881474F33C727 FOREIGN KEY (agenti_id) REFERENCES agenti (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agenti_cap_cap ADD CONSTRAINT FK_F7E6B5D010DE1C7 FOREIGN KEY (agenti_cap_id) REFERENCES agenti_cap (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agenti_cap_cap ADD CONSTRAINT FK_F7E6B5D069CF3E14 FOREIGN KEY (cap_id) REFERENCES cap (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cap ADD CONSTRAINT FK_993387B19F59A79A FOREIGN KEY (sigla_provincia_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE clienti ADD CONSTRAINT FK_FDAAD70E69CF3E14 FOREIGN KEY (cap_id) REFERENCES cap (id)');
        $this->addSql('ALTER TABLE clienti ADD CONSTRAINT FK_FDAAD70E85D0C4B8 FOREIGN KEY (id_agente_id) REFERENCES agenti (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clienti DROP FOREIGN KEY FK_FDAAD70E69CF3E14');
        $this->addSql('ALTER TABLE agenti_cap_agenti DROP FOREIGN KEY FK_3A28814710DE1C7');
        $this->addSql('ALTER TABLE agenti_cap_agenti DROP FOREIGN KEY FK_3A2881474F33C727');
        $this->addSql('ALTER TABLE agenti_cap_cap DROP FOREIGN KEY FK_F7E6B5D010DE1C7');
        $this->addSql('ALTER TABLE agenti_cap_cap DROP FOREIGN KEY FK_F7E6B5D069CF3E14');
        $this->addSql('ALTER TABLE cap DROP FOREIGN KEY FK_993387B19F59A79A');
        $this->addSql('DROP TABLE agenti_cap');
        $this->addSql('DROP TABLE agenti_cap_agenti');
        $this->addSql('DROP TABLE agenti_cap_cap');
        $this->addSql('DROP TABLE cap');
        $this->addSql('ALTER TABLE clienti DROP FOREIGN KEY FK_FDAAD70E85D0C4B8');
    }
}
