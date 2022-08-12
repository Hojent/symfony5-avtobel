<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812082147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE german (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A23440A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE german');
        $this->addSql('ALTER TABLE bodies CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE slug slug VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE images images LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metatitle metatitle VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metadesc metadesc LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metakey metakey LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
