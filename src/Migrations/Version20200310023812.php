<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310023812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE block (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, position INT NOT NULL, discr VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, button_title VARCHAR(255) DEFAULT NULL, INDEX IDX_831B9722C4663E4 (page_id), UNIQUE INDEX UNIQ_831B97222B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_140AB6205E237E06 (name), UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2D737AEF5E237E06 (name), UNIQUE INDEX UNIQ_2D737AEF989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_page (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, page_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_91B45A2BD823E37A (section_id), INDEX IDX_91B45A2BC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_network (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, link VARCHAR(255) NOT NULL, icon_url VARCHAR(255) NOT NULL, position INT NOT NULL, INDEX IDX_EFFF5221E9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE section_page ADD CONSTRAINT FK_91B45A2BD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE section_page ADD CONSTRAINT FK_91B45A2BC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE social_network ADD CONSTRAINT FK_EFFF5221E9ED820C FOREIGN KEY (block_id) REFERENCES block (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE social_network DROP FOREIGN KEY FK_EFFF5221E9ED820C');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B9722C4663E4');
        $this->addSql('ALTER TABLE section_page DROP FOREIGN KEY FK_91B45A2BC4663E4');
        $this->addSql('ALTER TABLE section_page DROP FOREIGN KEY FK_91B45A2BD823E37A');
        $this->addSql('DROP TABLE block');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE section_page');
        $this->addSql('DROP TABLE social_network');
    }
}
