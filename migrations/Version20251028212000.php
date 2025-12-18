<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add Brand, Category, and Image entities with proper relationships
 */
final class Version20251028212000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Brand, Category, and Image entities with proper relationships to Vehicle';
    }

    public function up(Schema $schema): void
    {
        // Create brand table
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, logo VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL)');
        
        // Create category table
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL)');
        
        // Add new columns to vehicule table (nullable first)
        $this->addSql('ALTER TABLE vehicule ADD COLUMN brand_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD COLUMN category_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD COLUMN description CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD COLUMN color VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD COLUMN fuel_type VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD COLUMN seats INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD COLUMN transmission VARCHAR(20) DEFAULT NULL');
        
        // Add new columns to reservation table
        $this->addSql('ALTER TABLE reservation ADD COLUMN total_price NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD COLUMN notes CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD COLUMN created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD COLUMN updated_at DATETIME DEFAULT NULL');
        
        // Create image table
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vehicle_id INTEGER NOT NULL, filename VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, is_main BOOLEAN NOT NULL, CONSTRAINT FK_C53D045F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C53D045F545317D1 ON image (vehicle_id)');
        
        // Create foreign key constraints
        $this->addSql('CREATE INDEX IDX_292FFF1D44F5D008 ON vehicule (brand_id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D12469DE2 ON vehicule (category_id)');
    }

    public function down(Schema $schema): void
    {
        // Drop foreign key constraints
        $this->addSql('DROP INDEX IDX_292FFF1D44F5D008');
        $this->addSql('DROP INDEX IDX_292FFF1D12469DE2');
        
        // Drop image table
        $this->addSql('DROP TABLE image');
        
        // Remove new columns from reservation table
        $this->addSql('ALTER TABLE reservation DROP COLUMN total_price');
        $this->addSql('ALTER TABLE reservation DROP COLUMN notes');
        $this->addSql('ALTER TABLE reservation DROP COLUMN created_at');
        $this->addSql('ALTER TABLE reservation DROP COLUMN updated_at');
        
        // Remove new columns from vehicule table
        $this->addSql('ALTER TABLE vehicule DROP COLUMN brand_id');
        $this->addSql('ALTER TABLE vehicule DROP COLUMN category_id');
        $this->addSql('ALTER TABLE vehicule DROP COLUMN description');
        $this->addSql('ALTER TABLE vehicule DROP COLUMN color');
        $this->addSql('ALTER TABLE vehicule DROP COLUMN fuel_type');
        $this->addSql('ALTER TABLE vehicule DROP COLUMN seats');
        $this->addSql('ALTER TABLE vehicule DROP COLUMN transmission');
        
        // Drop tables
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE brand');
    }
}
