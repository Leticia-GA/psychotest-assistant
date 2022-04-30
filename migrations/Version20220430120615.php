<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430120615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE associated_test DROP FOREIGN KEY FK_69B5EA4B1E5D0459');
        $this->addSql('ALTER TABLE associated_test DROP FOREIGN KEY FK_69B5EA4B6B899279');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE associated_test DROP FOREIGN KEY FK_69B5EA4B6B899279');
        $this->addSql('ALTER TABLE associated_test DROP FOREIGN KEY FK_69B5EA4B1E5D0459');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
