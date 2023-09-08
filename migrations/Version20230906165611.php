<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906165611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boss (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, `character` VARCHAR(25) NOT NULL, boss VARCHAR(25) NOT NULL, streak INT DEFAULT NULL, creation_date DATETIME NOT NULL, INDEX IDX_D709895161220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_user (challenge_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_843CD1CF98A21AC6 (challenge_id), INDEX IDX_843CD1CFA76ED395 (user_id), PRIMARY KEY(challenge_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_boss (challenge_id INT NOT NULL, boss_id INT NOT NULL, INDEX IDX_375161BC98A21AC6 (challenge_id), INDEX IDX_375161BC261FB672 (boss_id), PRIMARY KEY(challenge_id, boss_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_character (challenge_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_33ED6CAB98A21AC6 (challenge_id), INDEX IDX_33ED6CAB1136BE75 (character_id), PRIMARY KEY(challenge_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, challenge_id INT NOT NULL, creator_id INT NOT NULL, content LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, INDEX IDX_9474526C98A21AC6 (challenge_id), INDEX IDX_9474526C61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, challenge_id INT NOT NULL, INDEX IDX_AC6340B361220EA6 (creator_id), INDEX IDX_AC6340B398A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restriction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restriction_challenge (restriction_id INT NOT NULL, challenge_id INT NOT NULL, INDEX IDX_CCF4EA02E6160631 (restriction_id), INDEX IDX_CCF4EA0298A21AC6 (challenge_id), PRIMARY KEY(restriction_id, challenge_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(20) NOT NULL, registration_date DATETIME NOT NULL, icon VARCHAR(255) DEFAULT NULL, banner VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE versus (id INT AUTO_INCREMENT NOT NULL, challenge_id INT NOT NULL, creator_id INT NOT NULL, time_limit INT DEFAULT NULL, INDEX IDX_31AEA46998A21AC6 (challenge_id), INDEX IDX_31AEA46961220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE versus_user (versus_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_93264AE4DA42C2AC (versus_id), INDEX IDX_93264AE4A76ED395 (user_id), PRIMARY KEY(versus_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D709895161220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CF98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_boss ADD CONSTRAINT FK_375161BC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_boss ADD CONSTRAINT FK_375161BC261FB672 FOREIGN KEY (boss_id) REFERENCES boss (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_character ADD CONSTRAINT FK_33ED6CAB98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_character ADD CONSTRAINT FK_33ED6CAB1136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C61220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B361220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B398A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE restriction_challenge ADD CONSTRAINT FK_CCF4EA02E6160631 FOREIGN KEY (restriction_id) REFERENCES restriction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restriction_challenge ADD CONSTRAINT FK_CCF4EA0298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE versus ADD CONSTRAINT FK_31AEA46998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE versus ADD CONSTRAINT FK_31AEA46961220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE versus_user ADD CONSTRAINT FK_93264AE4DA42C2AC FOREIGN KEY (versus_id) REFERENCES versus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE versus_user ADD CONSTRAINT FK_93264AE4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D709895161220EA6');
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CF98A21AC6');
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CFA76ED395');
        $this->addSql('ALTER TABLE challenge_boss DROP FOREIGN KEY FK_375161BC98A21AC6');
        $this->addSql('ALTER TABLE challenge_boss DROP FOREIGN KEY FK_375161BC261FB672');
        $this->addSql('ALTER TABLE challenge_character DROP FOREIGN KEY FK_33ED6CAB98A21AC6');
        $this->addSql('ALTER TABLE challenge_character DROP FOREIGN KEY FK_33ED6CAB1136BE75');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C98A21AC6');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C61220EA6');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B361220EA6');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B398A21AC6');
        $this->addSql('ALTER TABLE restriction_challenge DROP FOREIGN KEY FK_CCF4EA02E6160631');
        $this->addSql('ALTER TABLE restriction_challenge DROP FOREIGN KEY FK_CCF4EA0298A21AC6');
        $this->addSql('ALTER TABLE versus DROP FOREIGN KEY FK_31AEA46998A21AC6');
        $this->addSql('ALTER TABLE versus DROP FOREIGN KEY FK_31AEA46961220EA6');
        $this->addSql('ALTER TABLE versus_user DROP FOREIGN KEY FK_93264AE4DA42C2AC');
        $this->addSql('ALTER TABLE versus_user DROP FOREIGN KEY FK_93264AE4A76ED395');
        $this->addSql('DROP TABLE boss');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_user');
        $this->addSql('DROP TABLE challenge_boss');
        $this->addSql('DROP TABLE challenge_character');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE restriction');
        $this->addSql('DROP TABLE restriction_challenge');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE versus');
        $this->addSql('DROP TABLE versus_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
