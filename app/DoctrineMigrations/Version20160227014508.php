<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160227014508 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE conference_hotel_map (id INT AUTO_INCREMENT NOT NULL, conference_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, INDEX IDX_A78B485D604B8382 (conference_id), INDEX IDX_A78B485D3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference_registration (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, conference_id INT DEFAULT NULL, hotel_registration_id INT DEFAULT NULL, arrival_datetime DATETIME DEFAULT NULL, guests INT NOT NULL, accommodations VARCHAR(255) NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_ED68CD75A76ED395 (user_id), INDEX IDX_ED68CD75604B8382 (conference_id), UNIQUE INDEX UNIQ_ED68CD7532733D2E (hotel_registration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_registration (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, event_id INT DEFAULT NULL, guests INT NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_8FBBAD54A76ED395 (user_id), INDEX IDX_8FBBAD5471F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, location VARCHAR(100) NOT NULL, capacity INT DEFAULT NULL, vacancy INT DEFAULT NULL, img_name VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_registration (id INT AUTO_INCREMENT NOT NULL, conference_registration_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, check_in_datetime DATETIME DEFAULT NULL, check_out_datetime DATETIME DEFAULT NULL, room VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_C9A754B49462F0F (conference_registration_id), INDEX IDX_C9A754B43243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conference_hotel_map ADD CONSTRAINT FK_A78B485D604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE conference_hotel_map ADD CONSTRAINT FK_A78B485D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD75A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD75604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD7532733D2E FOREIGN KEY (hotel_registration_id) REFERENCES hotel_registration (id)');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD54A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE hotel_registration ADD CONSTRAINT FK_C9A754B49462F0F FOREIGN KEY (conference_registration_id) REFERENCES conference_registration (id)');
        $this->addSql('ALTER TABLE hotel_registration ADD CONSTRAINT FK_C9A754B43243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE conference ADD description VARCHAR(255) NOT NULL, ADD start_datetime DATETIME NOT NULL, ADD end_datetime DATETIME NOT NULL, DROP start_date, DROP end_date');
        $this->addSql('ALTER TABLE event ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fos_user ADD approved TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_registration DROP FOREIGN KEY FK_C9A754B49462F0F');
        $this->addSql('ALTER TABLE conference_hotel_map DROP FOREIGN KEY FK_A78B485D3243BB18');
        $this->addSql('ALTER TABLE hotel_registration DROP FOREIGN KEY FK_C9A754B43243BB18');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD7532733D2E');
        $this->addSql('DROP TABLE conference_hotel_map');
        $this->addSql('DROP TABLE conference_registration');
        $this->addSql('DROP TABLE event_registration');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE hotel_registration');
        $this->addSql('ALTER TABLE conference ADD start_date DATETIME NOT NULL, ADD end_date DATETIME NOT NULL, DROP description, DROP start_datetime, DROP end_datetime');
        $this->addSql('ALTER TABLE event DROP description');
        $this->addSql('ALTER TABLE fos_user DROP approved');
    }
}
