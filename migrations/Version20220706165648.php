<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706165648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE body_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, published TINYINT(1) NOT NULL, metatitle VARCHAR(255) DEFAULT NULL, metadesc LONGTEXT DEFAULT NULL, metakey LONGTEXT DEFAULT NULL, created_time DATETIME NOT NULL, INDEX IDX_A2B4C01B727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE body_categories ADD CONSTRAINT FK_A2B4C01B727ACA70 FOREIGN KEY (parent_id) REFERENCES body_categories (id)');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP INDEX bodies_id_uindex ON bodies');
        $this->addSql('ALTER TABLE bodies ADD created DATE DEFAULT NULL, ADD ordering INT DEFAULT NULL, ADD metakey LONGTEXT DEFAULT NULL, ADD featured TINYINT(1) DEFAULT NULL, DROP files, DROP metakeys, DROP type, CHANGE published published TINYINT(1) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE images images LONGTEXT DEFAULT NULL, CHANGE metatitle metatitle VARCHAR(255) DEFAULT NULL, CHANGE metadesc metadesc LONGTEXT DEFAULT NULL, CHANGE bodycat_id body_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bodies ADD CONSTRAINT FK_CD58C0F1DBD2FAE2 FOREIGN KEY (body_category_id) REFERENCES body_categories (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD58C0F1989D9B62 ON bodies (slug)');
        $this->addSql('CREATE INDEX IDX_CD58C0F1DBD2FAE2 ON bodies (body_category_id)');
        $this->addSql('ALTER TABLE categories CHANGE alias alias VARCHAR(255) NOT NULL, CHANGE metakey metakey LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF34668E16C6B94 ON categories (alias)');
        $this->addSql('ALTER TABLE categories RENAME INDEX categories__self TO IDX_3AF34668727ACA70');
        $this->addSql('ALTER TABLE posts CHANGE published published TINYINT(1) DEFAULT NULL, CHANGE created created DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_885DBAFA12469DE2 ON posts (category_id)');
        $this->addSql('ALTER TABLE posts RENAME INDEX alias_uindex TO UNIQ_885DBAFAE16C6B94');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_1483a5e9e7927c74 TO UNIQ_8D93D649E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bodies DROP FOREIGN KEY FK_CD58C0F1DBD2FAE2');
        $this->addSql('ALTER TABLE body_categories DROP FOREIGN KEY FK_A2B4C01B727ACA70');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, selector VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hashed_token VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE body_categories');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_CD58C0F1989D9B62 ON bodies');
        $this->addSql('DROP INDEX IDX_CD58C0F1DBD2FAE2 ON bodies');
        $this->addSql('ALTER TABLE bodies ADD bodycat_id INT DEFAULT NULL, ADD files TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, ADD metakeys TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, ADD type VARCHAR(11) DEFAULT NULL COLLATE `utf8mb4_general_ci`, DROP body_category_id, DROP created, DROP ordering, DROP metakey, DROP featured, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE published published TINYINT(1) DEFAULT 1 NOT NULL, CHANGE images images TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metatitle metatitle TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE metadesc metadesc TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('CREATE UNIQUE INDEX bodies_id_uindex ON bodies (id)');
        $this->addSql('DROP INDEX UNIQ_3AF34668E16C6B94 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE alias alias VARCHAR(255) DEFAULT NULL, CHANGE metakey metakey TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories RENAME INDEX idx_3af34668727aca70 TO categories__self');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA12469DE2');
        $this->addSql('DROP INDEX IDX_885DBAFA12469DE2 ON posts');
        $this->addSql('ALTER TABLE posts CHANGE published published TINYINT(1) DEFAULT 1, CHANGE created created DATE NOT NULL');
        $this->addSql('ALTER TABLE posts RENAME INDEX uniq_885dbafae16c6b94 TO alias_uindex');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_1483A5E9E7927C74');
    }
}
