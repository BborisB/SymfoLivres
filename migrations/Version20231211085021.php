<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211085021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_livre (utilisateur_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_6AA61747FB88E14F (utilisateur_id), INDEX IDX_6AA6174737D925CB (livre_id), PRIMARY KEY(utilisateur_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_livre ADD CONSTRAINT FK_6AA61747FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_livre ADD CONSTRAINT FK_6AA6174737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_livre DROP FOREIGN KEY FK_6AA61747FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_livre DROP FOREIGN KEY FK_6AA6174737D925CB');
        $this->addSql('DROP TABLE utilisateur_livre');
    }
}
