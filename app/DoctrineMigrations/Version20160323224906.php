<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160323224906 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_registration ADD conference_registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD549462F0F FOREIGN KEY (conference_registration_id) REFERENCES conference_registration (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8FBBAD549462F0F ON event_registration (conference_registration_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD549462F0F');
        $this->addSql('DROP INDEX IDX_8FBBAD549462F0F ON event_registration');
        $this->addSql('ALTER TABLE event_registration DROP conference_registration_id');
    }
}
