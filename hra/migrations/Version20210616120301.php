<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616120301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data ADD id_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT FK_ADF3F3631BD125E3 FOREIGN KEY (id_type_id) REFERENCES data_type (id)');
        $this->addSql('CREATE INDEX IDX_ADF3F3631BD125E3 ON data (id_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data DROP FOREIGN KEY FK_ADF3F3631BD125E3');
        $this->addSql('DROP INDEX IDX_ADF3F3631BD125E3 ON data');
        $this->addSql('ALTER TABLE data DROP id_type_id');
    }
}
