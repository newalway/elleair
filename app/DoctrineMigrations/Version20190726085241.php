<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190726085241 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE our_brand_videos (id INT AUTO_INCREMENT NOT NULL, our_brand_video_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, video VARCHAR(255) DEFAULT NULL, video_id VARCHAR(255) DEFAULT NULL, video_width SMALLINT DEFAULT NULL, video_height SMALLINT DEFAULT NULL, video_duration SMALLINT DEFAULT NULL, thumbnail_url VARCHAR(255) DEFAULT NULL, thumbnail_width SMALLINT DEFAULT NULL, thumbnail_height SMALLINT DEFAULT NULL, thumbnail_url_play_button VARCHAR(255) DEFAULT NULL, video_embed TEXT DEFAULT NULL, INDEX IDX_9AC78E305B28DAC7 (our_brand_video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE our_brand_videos ADD CONSTRAINT FK_9AC78E305B28DAC7 FOREIGN KEY (our_brand_video_id) REFERENCES our_brand (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE our_brand_videos');
    }
}
