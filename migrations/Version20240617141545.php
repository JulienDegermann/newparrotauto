<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617141545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, model_id INT DEFAULT NULL, energy_id INT DEFAULT NULL, author_id INT DEFAULT NULL, mile_age INT NOT NULL, circulation_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', text VARCHAR(255) NOT NULL, INDEX IDX_773DE69D7975B7E7 (model_id), INDEX IDX_773DE69DEDDF52D (energy_id), INDEX IDX_773DE69DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE energy (id INT AUTO_INCREMENT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipments (id INT AUTO_INCREMENT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipments_car (equipments_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_4E3EC64BD251DD7 (equipments_id), INDEX IDX_4E3EC64C3C6F69F (car_id), PRIMARY KEY(equipments_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, phone VARCHAR(255) NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEDDF52D FOREIGN KEY (energy_id) REFERENCES energy (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE equipments_car ADD CONSTRAINT FK_4E3EC64BD251DD7 FOREIGN KEY (equipments_id) REFERENCES equipments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipments_car ADD CONSTRAINT FK_4E3EC64C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEDDF52D');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF675F31B');
        $this->addSql('ALTER TABLE equipments_car DROP FOREIGN KEY FK_4E3EC64BD251DD7');
        $this->addSql('ALTER TABLE equipments_car DROP FOREIGN KEY FK_4E3EC64C3C6F69F');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE energy');
        $this->addSql('DROP TABLE equipments');
        $this->addSql('DROP TABLE equipments_car');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE user');
    }
}
