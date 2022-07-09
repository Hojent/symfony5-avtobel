<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709091809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, body_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, original_filename VARCHAR(255) DEFAULT NULL, INDEX IDX_DD5A5B7D9B621D84 (body_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plans ADD CONSTRAINT FK_DD5A5B7D9B621D84 FOREIGN KEY (body_id) REFERENCES bodies (id)');
        $this->addSql('ALTER TABLE body_categories DROP FOREIGN KEY FK_A2B4C01B727ACA70');
        $this->addSql('DROP INDEX IDX_A2B4C01B727ACA70 ON body_categories');
        $this->addSql('ALTER TABLE body_categories DROP parent_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE plans');
        $this->addSql('ALTER TABLE bodies CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE images images LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metatitle metatitle VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metadesc metadesc LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metakey metakey LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE body_categories ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE body_categories ADD CONSTRAINT FK_A2B4C01B727ACA70 FOREIGN KEY (parent_id) REFERENCES body_categories (id)');
        $this->addSql('CREATE INDEX IDX_A2B4C01B727ACA70 ON body_categories (parent_id)');
    }
}
