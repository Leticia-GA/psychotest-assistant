<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424154148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE associated_test (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, test_id INT DEFAULT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_69B5EA4B6B899279 (patient_id), UNIQUE INDEX UNIQ_69B5EA4B1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE associated_test');
    }
}
