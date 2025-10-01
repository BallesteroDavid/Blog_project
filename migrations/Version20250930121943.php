<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930121943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_animal DROP FOREIGN KEY FK_6CB49FB2A1D860');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP INDEX IDX_6CB49FB2A1D860 ON article_animal');
        $this->addSql('ALTER TABLE article_animal DROP species_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article_animal ADD species_id INT NOT NULL');
        $this->addSql('ALTER TABLE article_animal ADD CONSTRAINT FK_6CB49FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6CB49FB2A1D860 ON article_animal (species_id)');
    }
}
