<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190725044821 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE our_brand_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, description MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_F88C125B2C2AC5D3 (translatable_id), UNIQUE INDEX our_brand_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE our_brand_translation ADD CONSTRAINT FK_F88C125B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES our_brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE our_brand ADD image VARCHAR(255) DEFAULT NULL, ADD image_logo VARCHAR(255) DEFAULT NULL, ADD image_label VARCHAR(255) DEFAULT NULL, ADD status SMALLINT NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD position SMALLINT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE our_brand_translation');
        $this->addSql('ALTER TABLE our_brand DROP image, DROP image_logo, DROP image_label, DROP status, DROP updated_at, DROP created_at, DROP position');
    }
}
