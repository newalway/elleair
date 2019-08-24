<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190816051814 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_location DROP FOREIGN KEY FK_39D92CB0BE04EA9');
        $this->addSql('DROP INDEX IDX_39D92CB0BE04EA9 ON job_location');
        $this->addSql('ALTER TABLE job_location DROP job_id');
        $this->addSql('ALTER TABLE jobs ADD job_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC565213AC7 FOREIGN KEY (job_location_id) REFERENCES job_location (id)');
        $this->addSql('CREATE INDEX IDX_A8936DC565213AC7 ON jobs (job_location_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_location ADD job_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_location ADD CONSTRAINT FK_39D92CB0BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('CREATE INDEX IDX_39D92CB0BE04EA9 ON job_location (job_id)');
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC565213AC7');
        $this->addSql('DROP INDEX IDX_A8936DC565213AC7 ON jobs');
        $this->addSql('ALTER TABLE jobs DROP job_location_id');
    }
}
