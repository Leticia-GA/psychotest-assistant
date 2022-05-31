<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531185825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP phone_number');
        $this->addSql('ALTER TABLE psychologist DROP phone_number');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD phone_number VARCHAR(20) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE psychologist ADD phone_number VARCHAR(20) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP phone_number');
    }
}
