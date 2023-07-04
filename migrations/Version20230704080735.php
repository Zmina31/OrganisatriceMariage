<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704080735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestation ADD temoignage_id INT DEFAULT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FADF2410A1E FOREIGN KEY (temoignage_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51C88FADF2410A1E ON prestation (temoignage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FADF2410A1E');
        $this->addSql('DROP INDEX UNIQ_51C88FADF2410A1E ON prestation');
        $this->addSql('ALTER TABLE prestation DROP temoignage_id, DROP status');
    }
}
