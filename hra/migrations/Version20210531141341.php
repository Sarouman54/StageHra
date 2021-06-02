<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531141341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data ADD id_user_id INT DEFAULT NULL, ADD id_truck_id INT NOT NULL');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT FK_ADF3F36379F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT FK_ADF3F363964E905B FOREIGN KEY (id_truck_id) REFERENCES truck (id)');
        $this->addSql('CREATE INDEX IDX_ADF3F36379F37AE5 ON data (id_user_id)');
        $this->addSql('CREATE INDEX IDX_ADF3F363964E905B ON data (id_truck_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data DROP FOREIGN KEY FK_ADF3F36379F37AE5');
        $this->addSql('ALTER TABLE data DROP FOREIGN KEY FK_ADF3F363964E905B');
        $this->addSql('DROP INDEX IDX_ADF3F36379F37AE5 ON data');
        $this->addSql('DROP INDEX IDX_ADF3F363964E905B ON data');
        $this->addSql('ALTER TABLE data DROP id_user_id, DROP id_truck_id');
    }
}
