<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190816051420 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_location (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, position SMALLINT UNSIGNED DEFAULT 0 NOT NULL, status SMALLINT NOT NULL, public_date DATE DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_39D92CB0BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_location_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, address MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_332A616F2C2AC5D3 (translatable_id), UNIQUE INDEX job_location_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_location ADD CONSTRAINT FK_39D92CB0BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE job_location_translation ADD CONSTRAINT FK_332A616F2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES job_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE our_brand DROP image_label');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_location_translation DROP FOREIGN KEY FK_332A616F2C2AC5D3');
        $this->addSql('DROP TABLE job_location');
        $this->addSql('DROP TABLE job_location_translation');
        $this->addSql('ALTER TABLE our_brand ADD image_label VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
