<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618100402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_car (equipment_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_46BD2EFC517FE9FE (equipment_id), INDEX IDX_46BD2EFCC3C6F69F (car_id), PRIMARY KEY(equipment_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment_car ADD CONSTRAINT FK_46BD2EFC517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_car ADD CONSTRAINT FK_46BD2EFCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipments_car DROP FOREIGN KEY FK_4E3EC64BD251DD7');
        $this->addSql('ALTER TABLE equipments_car DROP FOREIGN KEY FK_4E3EC64C3C6F69F');
        $this->addSql('DROP TABLE equipments_car');
        $this->addSql('DROP TABLE equipments');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipments_car (equipments_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_4E3EC64BD251DD7 (equipments_id), INDEX IDX_4E3EC64C3C6F69F (car_id), PRIMARY KEY(equipments_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE equipments (id INT AUTO_INCREMENT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', text VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipments_car ADD CONSTRAINT FK_4E3EC64BD251DD7 FOREIGN KEY (equipments_id) REFERENCES equipments (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipments_car ADD CONSTRAINT FK_4E3EC64C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_car DROP FOREIGN KEY FK_46BD2EFC517FE9FE');
        $this->addSql('ALTER TABLE equipment_car DROP FOREIGN KEY FK_46BD2EFCC3C6F69F');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_car');
    }
}
