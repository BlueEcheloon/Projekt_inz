<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029120321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, type VARCHAR(30) NOT NULL, os VARCHAR(20) NOT NULL, os_type VARCHAR(30) NOT NULL, model VARCHAR(80) NOT NULL, manufacturer VARCHAR(100) NOT NULL, ip_address VARCHAR(15) NOT NULL, location VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specification (id INT AUTO_INCREMENT NOT NULL, device_id INT NOT NULL, os_version VARCHAR(20) NOT NULL, memory VARCHAR(30) NOT NULL, processor VARCHAR(50) NOT NULL, motherboard VARCHAR(50) NOT NULL, graphics VARCHAR(60) NOT NULL, harddisk VARCHAR(40) NOT NULL, antivirus VARCHAR(80) NOT NULL, serial_number VARCHAR(20) NOT NULL, date_of_purchase DATE NOT NULL, warranty_exp DATE NOT NULL, UNIQUE INDEX UNIQ_E3F1A9A94A4C7D4 (device_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specification ADD CONSTRAINT FK_E3F1A9A94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE specification DROP FOREIGN KEY FK_E3F1A9A94A4C7D4');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP TABLE specification');
    }
}
