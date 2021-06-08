<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210605123556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre_book (genre_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_70087AC14296D31F (genre_id), INDEX IDX_70087AC116A2B381 (book_id), PRIMARY KEY(genre_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genre_book ADD CONSTRAINT FK_70087AC14296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_book ADD CONSTRAINT FK_70087AC116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
        $this->addSql('ALTER TABLE borrower ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE borrower ADD CONSTRAINT FK_DB904DB4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB904DB4A76ED395 ON borrower (user_id)');
        $this->addSql('ALTER TABLE borrowing ADD book_id INT NOT NULL, ADD borrower_id INT NOT NULL');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E589716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E589711CE312B FOREIGN KEY (borrower_id) REFERENCES borrower (id)');
        $this->addSql('CREATE INDEX IDX_226E589716A2B381 ON borrowing (book_id)');
        $this->addSql('CREATE INDEX IDX_226E589711CE312B ON borrowing (borrower_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE genre_book');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B ON book');
        $this->addSql('ALTER TABLE book DROP author_id');
        $this->addSql('ALTER TABLE borrower DROP FOREIGN KEY FK_DB904DB4A76ED395');
        $this->addSql('DROP INDEX UNIQ_DB904DB4A76ED395 ON borrower');
        $this->addSql('ALTER TABLE borrower DROP user_id');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589716A2B381');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589711CE312B');
        $this->addSql('DROP INDEX IDX_226E589716A2B381 ON borrowing');
        $this->addSql('DROP INDEX IDX_226E589711CE312B ON borrowing');
        $this->addSql('ALTER TABLE borrowing DROP book_id, DROP borrower_id');
    }
}
