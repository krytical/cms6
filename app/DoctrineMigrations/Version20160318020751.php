<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160318020751 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference ADD full_description LONGTEXT NOT NULL, CHANGE description short_description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE conference_registration ADD flight_number VARCHAR(25) DEFAULT NULL, ADD needs_accommodation TINYINT(1) NOT NULL, ADD additional_info VARCHAR(255) DEFAULT NULL, DROP accommodations');
        $this->addSql('ALTER TABLE event ADD full_description LONGTEXT NOT NULL, CHANGE description short_description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fos_user ADD last_name VARCHAR(100) NOT NULL, CHANGE name first_name VARCHAR(100) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference DROP full_description, CHANGE short_description description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE conference_registration ADD accommodations VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP flight_number, DROP needs_accommodation, DROP additional_info');
        $this->addSql('ALTER TABLE event DROP full_description, CHANGE short_description description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE fos_user ADD name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, DROP first_name, DROP last_name');
    }
}
