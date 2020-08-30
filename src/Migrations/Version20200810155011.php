<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810155011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
          'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode_tag DROP FOREIGN KEY FK_BEBD579A362B62A0');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAD94388BD');
        $this->addSql('ALTER TABLE name DROP FOREIGN KEY FK_5E237E06D94388BD');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA446F285F');
        $this->addSql('ALTER TABLE episode_tag DROP FOREIGN KEY FK_BEBD579ABAD26311');
        $this->addSql('ALTER TABLE episode CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE serie_id serie_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE studio_id studio_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE episode_tag CHANGE episode_id episode_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE tag_id tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE name CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE serie_id serie_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE serie CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE studio CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE tag CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE tracking CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('ALTER TABLE episode_tag ADD CONSTRAINT FK_BEBD579A362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode_tag ADD CONSTRAINT FK_BEBD579ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE name ADD CONSTRAINT FK_5E237E06D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
          'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE serie_id serie_id INT NOT NULL, CHANGE studio_id studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE episode_tag CHANGE episode_id episode_id INT NOT NULL, CHANGE tag_id tag_id INT NOT NULL');
        $this->addSql('ALTER TABLE name CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE serie_id serie_id INT NOT NULL');
        $this->addSql('ALTER TABLE serie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE studio CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tracking CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
