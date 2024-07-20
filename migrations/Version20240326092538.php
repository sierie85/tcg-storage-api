<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326092538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, card_game_id INTEGER NOT NULL, collector_number SMALLINT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(350) NOT NULL, cost SMALLINT NOT NULL, attack SMALLINT NOT NULL, defense SMALLINT NOT NULL, image VARCHAR(2000) NOT NULL, effect_image VARCHAR(2000) DEFAULT NULL, type_or_rarity SMALLINT DEFAULT NULL, CONSTRAINT FK_161498D3B3955373 FOREIGN KEY (card_game_id) REFERENCES card_game (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_161498D3B3955373 ON card (card_game_id)');
        $this->addSql('CREATE TABLE card_game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, back_cover_image VARCHAR(2000) DEFAULT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_game');
        $this->addSql('DROP TABLE user');
    }
}
