<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531091254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30AA601C6CC');
        $this->addSql('DROP INDEX IDX_CDCCF30AA601C6CC ON truck');
        $this->addSql('ALTER TABLE truck CHANGE id_chauffeur_id id_driver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30A4377852E FOREIGN KEY (id_driver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CDCCF30A4377852E ON truck (id_driver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30A4377852E');
        $this->addSql('DROP INDEX IDX_CDCCF30A4377852E ON truck');
        $this->addSql('ALTER TABLE truck CHANGE id_driver_id id_chauffeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30AA601C6CC FOREIGN KEY (id_chauffeur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CDCCF30AA601C6CC ON truck (id_chauffeur_id)');
    }
}
