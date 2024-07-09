<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618135310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE opening (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, day VARCHAR(255) NOT NULL, open TIME NOT NULL, close TIME NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_E35D4C3B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE opening ADD CONSTRAINT FK_E35D4C3B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE store DROP text, DROP name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opening DROP FOREIGN KEY FK_E35D4C3B092A811');
        $this->addSql('DROP TABLE opening');
        $this->addSql('ALTER TABLE store ADD text VARCHAR(255) NOT NULL, ADD name VARCHAR(255) NOT NULL');
    }
}
