<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160329002149 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_957A6479A0D96FBF ON fos_user');
        $this->addSql('ALTER TABLE fos_user ADD emailCanonical VARCHAR(50) DEFAULT NULL, DROP email_canonical');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479E7927C74 ON fos_user (email)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_957A6479E7927C74 ON fos_user');
        $this->addSql('ALTER TABLE fos_user ADD email_canonical VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP emailCanonical');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
    }
}
