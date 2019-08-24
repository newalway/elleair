<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190816082952 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, house_number VARCHAR(255) NOT NULL, road VARCHAR(255) NOT NULL, sub_district VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, address_type VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_D4E6F81C8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attach_file (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, file_upload_path VARCHAR(255) NOT NULL, file_upload_name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_FD108553C8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE computer_skill (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, skill_text TEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_7B4FF9DBC8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educational (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, level VARCHAR(255) NOT NULL, institution VARCHAR(255) NOT NULL, degree VARCHAR(255) NOT NULL, major VARCHAR(255) NOT NULL, gpa VARCHAR(255) NOT NULL, graduation_year VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_46E6650EC8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_skill (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, value SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_2165E026C8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE other_skill (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, skill_text TEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_368913D9C8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, duration_from_to TEXT DEFAULT NULL, institution TEXT DEFAULT NULL, courses TEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_D5128A8FC8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_experience (id INT AUTO_INCREMENT NOT NULL, apply_jobs_id INT DEFAULT NULL, duration_from_to TEXT DEFAULT NULL, workplace TEXT DEFAULT NULL, position TEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_1EF36CD0C8B87F1D (apply_jobs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE attach_file ADD CONSTRAINT FK_FD108553C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE computer_skill ADD CONSTRAINT FK_7B4FF9DBC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE educational ADD CONSTRAINT FK_46E6650EC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE language_skill ADD CONSTRAINT FK_2165E026C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE other_skill ADD CONSTRAINT FK_368913D9C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FC8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0C8B87F1D FOREIGN KEY (apply_jobs_id) REFERENCES apply_jobs (id)');
        $this->addSql('ALTER TABLE apply_jobs ADD first_name_en VARCHAR(255) NOT NULL, ADD last_name_en VARCHAR(255) DEFAULT NULL, DROP file_uploadpath, DROP file_uploadname, DROP file_uploadsize, CHANGE name first_name VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE attach_file');
        $this->addSql('DROP TABLE computer_skill');
        $this->addSql('DROP TABLE educational');
        $this->addSql('DROP TABLE language_skill');
        $this->addSql('DROP TABLE other_skill');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE work_experience');
        $this->addSql('ALTER TABLE apply_jobs ADD name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD file_uploadname VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD file_uploadsize NUMERIC(10, 1) DEFAULT NULL, DROP first_name, DROP first_name_en, CHANGE last_name_en file_uploadpath VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
