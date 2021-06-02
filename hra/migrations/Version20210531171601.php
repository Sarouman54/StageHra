<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531171601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data CHANGE id_truck_id id_truck_id INT NOT NULL, CHANGE time time TIME NOT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data CHANGE id_truck_id id_truck_id INT DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION NOT NULL, CHANGE latitude latitude DOUBLE PRECISION NOT NULL, CHANGE time time VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
