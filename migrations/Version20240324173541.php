<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324173541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__card_game AS SELECT id, name, back_cover_image FROM card_game');
        $this->addSql('DROP TABLE card_game');
        $this->addSql('CREATE TABLE card_game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, back_cover_image VARCHAR(2000) DEFAULT NULL)');
        $this->addSql('INSERT INTO card_game (id, name, back_cover_image) SELECT id, name, back_cover_image FROM __temp__card_game');
        $this->addSql('DROP TABLE __temp__card_game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__card_game AS SELECT id, name, back_cover_image FROM card_game');
        $this->addSql('DROP TABLE card_game');
        $this->addSql('CREATE TABLE card_game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, back_cover_image VARCHAR(2000) NOT NULL)');
        $this->addSql('INSERT INTO card_game (id, name, back_cover_image) SELECT id, name, back_cover_image FROM __temp__card_game');
        $this->addSql('DROP TABLE __temp__card_game');
    }
}
