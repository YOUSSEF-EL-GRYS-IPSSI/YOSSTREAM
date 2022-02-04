<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204104722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movies_genre (movies_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_F8B211F953F590A4 (movies_id), INDEX IDX_F8B211F94296D31F (genre_id), PRIMARY KEY(movies_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies_genre ADD CONSTRAINT FK_F8B211F953F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_genre ADD CONSTRAINT FK_F8B211F94296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movies_genre');
       
    }
}
