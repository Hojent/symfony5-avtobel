<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812075806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_CD58C0F1989D9B62 ON bodies');
        $this->addSql('ALTER TABLE plans ADD diagonal SMALLINT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bodies CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE slug slug VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE images images LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metatitle metatitle VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metadesc metadesc LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metakey metakey LONGTEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD58C0F1989D9B62 ON bodies (slug)');
        $this->addSql('ALTER TABLE plans DROP diagonal');
    }
}
