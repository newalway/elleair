<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190725052035 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news_category DROP FOREIGN KEY FK_4F72BA90727ACA70');
        $this->addSql('ALTER TABLE news_category DROP FOREIGN KEY FK_4F72BA90A977936C');
        $this->addSql('DROP INDEX IDX_4F72BA90A977936C ON news_category');
        $this->addSql('DROP INDEX IDX_4F72BA90727ACA70 ON news_category');
        $this->addSql('ALTER TABLE news_category ADD image VARCHAR(255) DEFAULT NULL, ADD position SMALLINT UNSIGNED DEFAULT 0 NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD created_at DATETIME NOT NULL, DROP parent_id, DROP tree_root, DROP lft, DROP lvl, DROP rgt');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news_category ADD parent_id INT DEFAULT NULL, ADD tree_root INT DEFAULT NULL, ADD lft INT NOT NULL, ADD lvl INT NOT NULL, ADD rgt INT NOT NULL, DROP image, DROP position, DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE news_category ADD CONSTRAINT FK_4F72BA90727ACA70 FOREIGN KEY (parent_id) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_category ADD CONSTRAINT FK_4F72BA90A977936C FOREIGN KEY (tree_root) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4F72BA90A977936C ON news_category (tree_root)');
        $this->addSql('CREATE INDEX IDX_4F72BA90727ACA70 ON news_category (parent_id)');
    }
}
