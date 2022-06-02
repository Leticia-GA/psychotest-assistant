<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602092242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, text LONGTEXT NOT NULL, score SMALLINT NOT NULL, position SMALLINT NOT NULL, INDEX IDX_DADD4A251E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE associated_test (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, test_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_69B5EA4B6B899279 (patient_id), INDEX IDX_69B5EA4B1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic (id INT NOT NULL, info VARCHAR(200) NOT NULL, phone_number VARCHAR(20) NOT NULL, email VARCHAR(180) NOT NULL, location VARCHAR(200) NOT NULL, opening_hours VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, psychologist_id INT DEFAULT NULL, diagnostic LONGTEXT DEFAULT NULL, case_history LONGTEXT DEFAULT NULL, INDEX IDX_1ADAD7EBFE8EF269 (psychologist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE psychologist (id INT NOT NULL, education VARCHAR(200) NOT NULL, specialization VARCHAR(200) NOT NULL, collegiate_number VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_FFC468E062F9D51F (collegiate_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, text LONGTEXT NOT NULL, position SMALLINT NOT NULL, INDEX IDX_B6F7494E1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, explanation LONGTEXT NOT NULL, author VARCHAR(200) NOT NULL, time VARCHAR(20) NOT NULL, application_age VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_done (id INT AUTO_INCREMENT NOT NULL, associated_test_id INT DEFAULT NULL, date DATETIME NOT NULL, read_at DATETIME DEFAULT NULL, answer_positions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_1554CA64514FB1D (associated_test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_interpretation (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, min SMALLINT NOT NULL, max SMALLINT NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_9497291A1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, surnames VARCHAR(250) NOT NULL, dni VARCHAR(30) NOT NULL, birth_date DATETIME NOT NULL, phone_number VARCHAR(20) NOT NULL, email VARCHAR(180) NOT NULL, photo VARCHAR(100) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE associated_test ADD CONSTRAINT FK_69B5EA4B1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBFE8EF269 FOREIGN KEY (psychologist_id) REFERENCES psychologist (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE psychologist ADD CONSTRAINT FK_FFC468E0BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_done ADD CONSTRAINT FK_1554CA64514FB1D FOREIGN KEY (associated_test_id) REFERENCES associated_test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_interpretation ADD CONSTRAINT FK_9497291A1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_done DROP FOREIGN KEY FK_1554CA64514FB1D');
        $this->addSql('ALTER TABLE associated_test DROP FOREIGN KEY FK_69B5EA4B6B899279');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBFE8EF269');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E5D0459');
        $this->addSql('ALTER TABLE associated_test DROP FOREIGN KEY FK_69B5EA4B1E5D0459');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E1E5D0459');
        $this->addSql('ALTER TABLE test_interpretation DROP FOREIGN KEY FK_9497291A1E5D0459');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE psychologist DROP FOREIGN KEY FK_FFC468E0BF396750');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE associated_test');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE psychologist');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test_done');
        $this->addSql('DROP TABLE test_interpretation');
        $this->addSql('DROP TABLE user');
    }
}
