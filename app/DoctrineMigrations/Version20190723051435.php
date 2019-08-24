<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190723051435 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE apply_jobs (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, file_uploadpath VARCHAR(255) DEFAULT NULL, file_uploadname VARCHAR(255) DEFAULT NULL, file_uploadsize NUMERIC(10, 1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_D2F3C526BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, job_position_opening SMALLINT UNSIGNED DEFAULT 0 NOT NULL, position SMALLINT UNSIGNED DEFAULT 0 NOT NULL, status SMALLINT NOT NULL, public_date DATE DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description MEDIUMTEXT DEFAULT NULL, qualification MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_CC7390B02C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX jobs_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apply_jobs ADD CONSTRAINT FK_D2F3C526BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE jobs_translation ADD CONSTRAINT FK_CC7390B02C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES jobs (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apply_jobs DROP FOREIGN KEY FK_D2F3C526BE04EA9');
        $this->addSql('ALTER TABLE jobs_translation DROP FOREIGN KEY FK_CC7390B02C2AC5D3');
        $this->addSql('DROP TABLE apply_jobs');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE jobs_translation');
    }
}
