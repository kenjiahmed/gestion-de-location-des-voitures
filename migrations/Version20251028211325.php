<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251028211325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__brand AS SELECT id FROM brand');
        $this->addSql('DROP TABLE brand');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, logo VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO brand (id) SELECT id FROM __temp__brand');
        $this->addSql('DROP TABLE __temp__brand');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO category (id) SELECT id FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vehicle_id INTEGER NOT NULL, filename VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, is_main BOOLEAN NOT NULL, CONSTRAINT FK_C53D045F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, filename) SELECT id, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F545317D1 ON image (vehicle_id)');
        $this->addSql('ALTER TABLE reservation ADD COLUMN total_price NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD COLUMN notes CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD COLUMN created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD COLUMN updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicule AS SELECT id, available, model, year, price_per_day FROM vehicule');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('CREATE TABLE vehicule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brand_id INTEGER NOT NULL, category_id INTEGER NOT NULL, available BOOLEAN NOT NULL, model VARCHAR(100) NOT NULL, year INTEGER NOT NULL, price_per_day DOUBLE PRECISION NOT NULL, description CLOB DEFAULT NULL, color VARCHAR(20) DEFAULT NULL, fuel_type VARCHAR(20) DEFAULT NULL, seats INTEGER DEFAULT NULL, transmission VARCHAR(20) DEFAULT NULL, CONSTRAINT FK_292FFF1D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_292FFF1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO vehicule (id, available, model, year, price_per_day) SELECT id, available, model, year, price_per_day FROM __temp__vehicule');
        $this->addSql('DROP TABLE __temp__vehicule');
        $this->addSql('CREATE INDEX IDX_292FFF1D44F5D008 ON vehicule (brand_id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D12469DE2 ON vehicule (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__brand AS SELECT id FROM brand');
        $this->addSql('DROP TABLE brand');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(120) NOT NULL)');
        $this->addSql('INSERT INTO brand (id) SELECT id FROM __temp__brand');
        $this->addSql('DROP TABLE __temp__brand');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C52F9586C6E55B5 ON brand (nom)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(120) NOT NULL)');
        $this->addSql('INSERT INTO category (id) SELECT id FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C16C6E55B5 ON category (nom)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, filename FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vehicule_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_C53D045F4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON UPDATE NO ACTION ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, url) SELECT id, filename FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F4A4A3511 ON image (vehicule_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, utilisateur_id, vehicule_id, debut, fin, statut FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, utilisateur_id INTEGER NOT NULL, vehicule_id INTEGER NOT NULL, debut DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , fin DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , statut VARCHAR(20) NOT NULL, CONSTRAINT FK_42C84955FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C849554A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reservation (id, utilisateur_id, vehicule_id, debut, fin, statut) SELECT id, utilisateur_id, vehicule_id, debut, fin, statut FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C84955FB88E14F ON reservation (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_42C849554A4A3511 ON reservation (vehicule_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicule AS SELECT id, model, year, price_per_day, available FROM vehicule');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('CREATE TABLE vehicule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, model VARCHAR(100) NOT NULL, year INTEGER NOT NULL, price_per_day DOUBLE PRECISION NOT NULL, available BOOLEAN NOT NULL, brand VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO vehicule (id, model, year, price_per_day, available) SELECT id, model, year, price_per_day, available FROM __temp__vehicule');
        $this->addSql('DROP TABLE __temp__vehicule');
    }
}
