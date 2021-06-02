<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531090808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE truck ADD id_chauffeur_id INT DEFAULT NULL, ADD id_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30AA601C6CC FOREIGN KEY (id_chauffeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30A94513350 FOREIGN KEY (id_card_id) REFERENCES electronic_card (id)');
        $this->addSql('CREATE INDEX IDX_CDCCF30AA601C6CC ON truck (id_chauffeur_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDCCF30A94513350 ON truck (id_card_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30AA601C6CC');
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30A94513350');
        $this->addSql('DROP INDEX IDX_CDCCF30AA601C6CC ON truck');
        $this->addSql('DROP INDEX UNIQ_CDCCF30A94513350 ON truck');
        $this->addSql('ALTER TABLE truck DROP id_chauffeur_id, DROP id_card_id');
    }
}
