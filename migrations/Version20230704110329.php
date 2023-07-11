<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704110329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187E9E4C8C');
        $this->addSql('DROP INDEX IDX_14B784187E9E4C8C ON photo');
        $this->addSql('ALTER TABLE photo CHANGE photo_id mariage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418192813B FOREIGN KEY (mariage_id) REFERENCES mariage (id)');
        $this->addSql('CREATE INDEX IDX_14B78418192813B ON photo (mariage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418192813B');
        $this->addSql('DROP INDEX IDX_14B78418192813B ON photo');
        $this->addSql('ALTER TABLE photo CHANGE mariage_id photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187E9E4C8C FOREIGN KEY (photo_id) REFERENCES mariage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_14B784187E9E4C8C ON photo (photo_id)');
    }
}
