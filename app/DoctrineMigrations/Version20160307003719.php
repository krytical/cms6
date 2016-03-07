<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160307003719 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD7532733D2E');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD7532733D2E FOREIGN KEY (hotel_registration_id) REFERENCES hotel_registration (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD7532733D2E');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD7532733D2E FOREIGN KEY (hotel_registration_id) REFERENCES hotel_registration (id) ON DELETE CASCADE');
    }
}
