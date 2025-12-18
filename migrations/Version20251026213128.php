<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026213128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicule AS SELECT id, disponible FROM vehicule');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('CREATE TABLE vehicule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, available BOOLEAN NOT NULL, brand VARCHAR(100) NOT NULL, model VARCHAR(100) NOT NULL, year INTEGER NOT NULL, price_per_day DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO vehicule (id, available) SELECT id, disponible FROM __temp__vehicule');
        $this->addSql('DROP TABLE __temp__vehicule');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicule AS SELECT id, available FROM vehicule');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('CREATE TABLE vehicule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, marque_id INTEGER DEFAULT NULL, categorie_id INTEGER DEFAULT NULL, disponible BOOLEAN NOT NULL, modele VARCHAR(180) NOT NULL, prix_journalier NUMERIC(10, 2) NOT NULL, description CLOB DEFAULT NULL, transmission VARCHAR(20) NOT NULL, carburant VARCHAR(20) NOT NULL, places SMALLINT NOT NULL, portes SMALLINT NOT NULL, CONSTRAINT FK_292FFF1D4827B9B2 FOREIGN KEY (marque_id) REFERENCES brand (id) ON UPDATE NO ACTION ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_292FFF1DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO vehicule (id, disponible) SELECT id, available FROM __temp__vehicule');
        $this->addSql('DROP TABLE __temp__vehicule');
        $this->addSql('CREATE INDEX IDX_292FFF1DBCF5E72D ON vehicule (categorie_id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D4827B9B2 ON vehicule (marque_id)');
    }
}
