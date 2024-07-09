<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618132408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758778BAC62AF');
        $this->addSql('DROP INDEX IDX_FF5758778BAC62AF ON store');
        $this->addSql('ALTER TABLE store ADD city VARCHAR(255) DEFAULT NULL, DROP city_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE store ADD city_id INT DEFAULT NULL, DROP city');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758778BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FF5758778BAC62AF ON store (city_id)');
    }
}
