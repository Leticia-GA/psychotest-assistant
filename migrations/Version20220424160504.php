<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424160504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE associated_test DROP INDEX UNIQ_69B5EA4B1E5D0459, ADD INDEX IDX_69B5EA4B1E5D0459 (test_id)');
        $this->addSql('ALTER TABLE associated_test DROP INDEX UNIQ_69B5EA4B6B899279, ADD INDEX IDX_69B5EA4B6B899279 (patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE associated_test DROP INDEX IDX_69B5EA4B6B899279, ADD UNIQUE INDEX UNIQ_69B5EA4B6B899279 (patient_id)');
        $this->addSql('ALTER TABLE associated_test DROP INDEX IDX_69B5EA4B1E5D0459, ADD UNIQUE INDEX UNIQ_69B5EA4B1E5D0459 (test_id)');
    }
}
