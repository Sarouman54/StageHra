<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528153045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_type ADD id_data_id INT NOT NULL');
        $this->addSql('ALTER TABLE data_type ADD CONSTRAINT FK_37919CCBE968084C FOREIGN KEY (id_data_id) REFERENCES data (id)');
        $this->addSql('CREATE INDEX IDX_37919CCBE968084C ON data_type (id_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_type DROP FOREIGN KEY FK_37919CCBE968084C');
        $this->addSql('DROP INDEX IDX_37919CCBE968084C ON data_type');
        $this->addSql('ALTER TABLE data_type DROP id_data_id');
    }
}
