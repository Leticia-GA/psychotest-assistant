<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430103851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD psychologist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBFE8EF269 FOREIGN KEY (psychologist_id) REFERENCES psychologist (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EBFE8EF269 ON patient (psychologist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBFE8EF269');
        $this->addSql('DROP INDEX IDX_1ADAD7EBFE8EF269 ON patient');
        $this->addSql('ALTER TABLE patient DROP psychologist_id');
    }
}
