<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230712135411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE temoignage ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE temoignage ADD CONSTRAINT FK_BDADBC466BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_BDADBC466BF700BD ON temoignage (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temoignage DROP FOREIGN KEY FK_BDADBC466BF700BD');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_BDADBC466BF700BD ON temoignage');
        $this->addSql('ALTER TABLE temoignage DROP status_id');
    }
}
