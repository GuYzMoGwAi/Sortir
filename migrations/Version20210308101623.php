<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308101623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sortie_utilisateur (id INT AUTO_INCREMENT NOT NULL, sortie_id_id INT NOT NULL, utilisateur_id_id INT NOT NULL, UNIQUE INDEX UNIQ_2C57C50FE64A3B53 (sortie_id_id), UNIQUE INDEX UNIQ_2C57C50FB981C689 (utilisateur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sortie_utilisateur ADD CONSTRAINT FK_2C57C50FE64A3B53 FOREIGN KEY (sortie_id_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE sortie_utilisateur ADD CONSTRAINT FK_2C57C50FB981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sortie_utilisateur');
    }
}
