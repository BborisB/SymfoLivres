<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211104123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mytable DROP FOREIGN KEY FK_AAEAF90D37D925CB');
        $this->addSql('ALTER TABLE mytable DROP FOREIGN KEY FK_AAEAF90DFB88E14F');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE mytable');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE mytable (utilisateur_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_AAEAF90DFB88E14F (utilisateur_id), INDEX IDX_AAEAF90D37D925CB (livre_id), PRIMARY KEY(utilisateur_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mytable ADD CONSTRAINT FK_AAEAF90D37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mytable ADD CONSTRAINT FK_AAEAF90DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
