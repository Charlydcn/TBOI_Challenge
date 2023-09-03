<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903175535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restriction_challenge (restriction_id INT NOT NULL, challenge_id INT NOT NULL, INDEX IDX_CCF4EA02E6160631 (restriction_id), INDEX IDX_CCF4EA0298A21AC6 (challenge_id), PRIMARY KEY(restriction_id, challenge_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restriction_challenge ADD CONSTRAINT FK_CCF4EA02E6160631 FOREIGN KEY (restriction_id) REFERENCES restriction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restriction_challenge ADD CONSTRAINT FK_CCF4EA0298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restriction DROP FOREIGN KEY FK_7A999BCE98A21AC6');
        $this->addSql('DROP INDEX IDX_7A999BCE98A21AC6 ON restriction');
        $this->addSql('ALTER TABLE restriction DROP challenge_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restriction_challenge DROP FOREIGN KEY FK_CCF4EA02E6160631');
        $this->addSql('ALTER TABLE restriction_challenge DROP FOREIGN KEY FK_CCF4EA0298A21AC6');
        $this->addSql('DROP TABLE restriction_challenge');
        $this->addSql('ALTER TABLE restriction ADD challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restriction ADD CONSTRAINT FK_7A999BCE98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7A999BCE98A21AC6 ON restriction (challenge_id)');
    }
}
