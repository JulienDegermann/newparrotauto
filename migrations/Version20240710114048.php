<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710114048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_car DROP FOREIGN KEY FK_46BD2EFC517FE9FE');
        $this->addSql('ALTER TABLE equipment_car DROP FOREIGN KEY FK_46BD2EFCC3C6F69F');
        $this->addSql('DROP TABLE equipment_car');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_car (equipment_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_46BD2EFC517FE9FE (equipment_id), INDEX IDX_46BD2EFCC3C6F69F (car_id), PRIMARY KEY(equipment_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipment_car ADD CONSTRAINT FK_46BD2EFC517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_car ADD CONSTRAINT FK_46BD2EFCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
