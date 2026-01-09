<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260108161023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, logo VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE image (id SERIAL NOT NULL, vehicle_id INT NOT NULL, filename VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, is_main BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C53D045F545317D1 ON image (vehicle_id)');
        $this->addSql('CREATE TABLE reservation (id SERIAL NOT NULL, utilisateur_id INT NOT NULL, vehicule_id INT NOT NULL, debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, statut VARCHAR(20) NOT NULL, total_price NUMERIC(10, 2) DEFAULT NULL, notes TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C84955FB88E14F ON reservation (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_42C849554A4A3511 ON reservation (vehicule_id)');
        $this->addSql('COMMENT ON COLUMN reservation.debut IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reservation.fin IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reservation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reservation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, age INT DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, address TEXT DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, birthday DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE vehicule (id SERIAL NOT NULL, brand_id INT NOT NULL, category_id INT NOT NULL, model VARCHAR(100) NOT NULL, year INT NOT NULL, price_per_day DOUBLE PRECISION NOT NULL, available BOOLEAN NOT NULL, description TEXT DEFAULT NULL, color VARCHAR(20) DEFAULT NULL, fuel_type VARCHAR(20) DEFAULT NULL, seats INT DEFAULT NULL, transmission VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_292FFF1D44F5D008 ON vehicule (brand_id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D12469DE2 ON vehicule (category_id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F545317D1');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955FB88E14F');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C849554A4A3511');
        $this->addSql('ALTER TABLE vehicule DROP CONSTRAINT FK_292FFF1D44F5D008');
        $this->addSql('ALTER TABLE vehicule DROP CONSTRAINT FK_292FFF1D12469DE2');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE vehicule');
    }
}
