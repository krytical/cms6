<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160306232623 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference_hotel_map DROP FOREIGN KEY FK_A78B485D3243BB18');
        $this->addSql('ALTER TABLE conference_hotel_map DROP FOREIGN KEY FK_A78B485D604B8382');
        $this->addSql('ALTER TABLE conference_hotel_map ADD CONSTRAINT FK_A78B485D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conference_hotel_map ADD CONSTRAINT FK_A78B485D604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD7532733D2E');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD75604B8382');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD75A76ED395');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD7532733D2E FOREIGN KEY (hotel_registration_id) REFERENCES hotel_registration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD75604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD75A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD5471F7E88B');
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD54A76ED395');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD54A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel_registration DROP FOREIGN KEY FK_C9A754B43243BB18');
        $this->addSql('ALTER TABLE hotel_registration DROP FOREIGN KEY FK_C9A754B49462F0F');
        $this->addSql('ALTER TABLE hotel_registration ADD CONSTRAINT FK_C9A754B43243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel_registration ADD CONSTRAINT FK_C9A754B49462F0F FOREIGN KEY (conference_registration_id) REFERENCES conference_registration (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference_hotel_map DROP FOREIGN KEY FK_A78B485D604B8382');
        $this->addSql('ALTER TABLE conference_hotel_map DROP FOREIGN KEY FK_A78B485D3243BB18');
        $this->addSql('ALTER TABLE conference_hotel_map ADD CONSTRAINT FK_A78B485D604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE conference_hotel_map ADD CONSTRAINT FK_A78B485D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD75A76ED395');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD75604B8382');
        $this->addSql('ALTER TABLE conference_registration DROP FOREIGN KEY FK_ED68CD7532733D2E');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD75A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD75604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE conference_registration ADD CONSTRAINT FK_ED68CD7532733D2E FOREIGN KEY (hotel_registration_id) REFERENCES hotel_registration (id)');
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD54A76ED395');
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD5471F7E88B');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD54A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE hotel_registration DROP FOREIGN KEY FK_C9A754B49462F0F');
        $this->addSql('ALTER TABLE hotel_registration DROP FOREIGN KEY FK_C9A754B43243BB18');
        $this->addSql('ALTER TABLE hotel_registration ADD CONSTRAINT FK_C9A754B49462F0F FOREIGN KEY (conference_registration_id) REFERENCES conference_registration (id)');
        $this->addSql('ALTER TABLE hotel_registration ADD CONSTRAINT FK_C9A754B43243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }
}
