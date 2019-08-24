<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190820103121 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attach_file DROP FOREIGN KEY FK_FD108553C8B87F1D');
        $this->addSql('ALTER TABLE attach_file ADD CONSTRAINT FK_FD108553C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE computer_skill DROP FOREIGN KEY FK_7B4FF9DBC8B87F1D');
        $this->addSql('ALTER TABLE computer_skill ADD CONSTRAINT FK_7B4FF9DBC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE educational DROP FOREIGN KEY FK_46E6650EC8B87F1D');
        $this->addSql('ALTER TABLE educational ADD CONSTRAINT FK_46E6650EC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_skill DROP FOREIGN KEY FK_2165E026C8B87F1D');
        $this->addSql('ALTER TABLE language_skill ADD CONSTRAINT FK_2165E026C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE other_skill DROP FOREIGN KEY FK_368913D9C8B87F1D');
        $this->addSql('ALTER TABLE other_skill ADD CONSTRAINT FK_368913D9C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FC8B87F1D');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_experience DROP FOREIGN KEY FK_1EF36CD0C8B87F1D');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attach_file DROP FOREIGN KEY FK_FD108553C8B87F1D');
        $this->addSql('ALTER TABLE attach_file ADD CONSTRAINT FK_FD108553C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE computer_skill DROP FOREIGN KEY FK_7B4FF9DBC8B87F1D');
        $this->addSql('ALTER TABLE computer_skill ADD CONSTRAINT FK_7B4FF9DBC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE educational DROP FOREIGN KEY FK_46E6650EC8B87F1D');
        $this->addSql('ALTER TABLE educational ADD CONSTRAINT FK_46E6650EC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE language_skill DROP FOREIGN KEY FK_2165E026C8B87F1D');
        $this->addSql('ALTER TABLE language_skill ADD CONSTRAINT FK_2165E026C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE other_skill DROP FOREIGN KEY FK_368913D9C8B87F1D');
        $this->addSql('ALTER TABLE other_skill ADD CONSTRAINT FK_368913D9C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FC8B87F1D');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE work_experience DROP FOREIGN KEY FK_1EF36CD0C8B87F1D');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
    }
}
