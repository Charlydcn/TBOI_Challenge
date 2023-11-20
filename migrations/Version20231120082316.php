<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120082316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boss (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, img VARCHAR(255) NOT NULL, timed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, streak INT DEFAULT NULL, creation_date DATETIME NOT NULL, restrictions_chance INT DEFAULT NULL, INDEX IDX_D709895161220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_restriction (challenge_id INT NOT NULL, restriction_id INT NOT NULL, INDEX IDX_325337398A21AC6 (challenge_id), INDEX IDX_3253373E6160631 (restriction_id), PRIMARY KEY(challenge_id, restriction_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_boss (challenge_id INT NOT NULL, boss_id INT NOT NULL, INDEX IDX_375161BC98A21AC6 (challenge_id), INDEX IDX_375161BC261FB672 (boss_id), PRIMARY KEY(challenge_id, boss_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_character (challenge_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_33ED6CAB98A21AC6 (challenge_id), INDEX IDX_33ED6CAB1136BE75 (character_id), PRIMARY KEY(challenge_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, challenge_id INT NOT NULL, creator_id INT NOT NULL, content LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, INDEX IDX_9474526C98A21AC6 (challenge_id), INDEX IDX_9474526C61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friendship (id INT AUTO_INCREMENT NOT NULL, user1_id INT NOT NULL, user2_id INT NOT NULL, INDEX IDX_7234A45F56AE248B (user1_id), INDEX IDX_7234A45F441B8B65 (user2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, challenge_id INT NOT NULL, INDEX IDX_AC6340B361220EA6 (creator_id), INDEX IDX_AC6340B398A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play_challenge (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, challenge_id INT NOT NULL, completed TINYINT(1) NOT NULL, play_date DATETIME NOT NULL, completion_time TIME DEFAULT NULL, comment VARCHAR(50) DEFAULT NULL, INDEX IDX_E01AA50CA76ED395 (user_id), INDEX IDX_E01AA50C98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play_versus (id INT AUTO_INCREMENT NOT NULL, versus_id INT NOT NULL, user_id INT NOT NULL, completion_time TIME DEFAULT NULL, play_date DATETIME NOT NULL, completed TINYINT(1) NOT NULL, comment VARCHAR(50) DEFAULT NULL, INDEX IDX_F3888429DA42C2AC (versus_id), INDEX IDX_F3888429A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restriction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(20) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, registration_date DATETIME NOT NULL, icon VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, win_streak INT DEFAULT NULL, best_win_streak INT DEFAULT NULL, discord VARCHAR(255) DEFAULT NULL, twitch VARCHAR(255) DEFAULT NULL, discord_id VARCHAR(32) NOT NULL, access_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE versus (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, winner_id INT DEFAULT NULL, challenge_id INT NOT NULL, public TINYINT(1) NOT NULL, closed TINYINT(1) NOT NULL, time_limit TIME DEFAULT NULL, INDEX IDX_31AEA46961220EA6 (creator_id), INDEX IDX_31AEA4695DFCD4B8 (winner_id), INDEX IDX_31AEA46998A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D709895161220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE challenge_restriction ADD CONSTRAINT FK_325337398A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_restriction ADD CONSTRAINT FK_3253373E6160631 FOREIGN KEY (restriction_id) REFERENCES restriction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_boss ADD CONSTRAINT FK_375161BC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_boss ADD CONSTRAINT FK_375161BC261FB672 FOREIGN KEY (boss_id) REFERENCES boss (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_character ADD CONSTRAINT FK_33ED6CAB98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_character ADD CONSTRAINT FK_33ED6CAB1136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C61220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F56AE248B FOREIGN KEY (user1_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F441B8B65 FOREIGN KEY (user2_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B361220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B398A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE play_challenge ADD CONSTRAINT FK_E01AA50CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE play_challenge ADD CONSTRAINT FK_E01AA50C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE play_versus ADD CONSTRAINT FK_F3888429DA42C2AC FOREIGN KEY (versus_id) REFERENCES versus (id)');
        $this->addSql('ALTER TABLE play_versus ADD CONSTRAINT FK_F3888429A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE versus ADD CONSTRAINT FK_31AEA46961220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE versus ADD CONSTRAINT FK_31AEA4695DFCD4B8 FOREIGN KEY (winner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE versus ADD CONSTRAINT FK_31AEA46998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D709895161220EA6');
        $this->addSql('ALTER TABLE challenge_restriction DROP FOREIGN KEY FK_325337398A21AC6');
        $this->addSql('ALTER TABLE challenge_restriction DROP FOREIGN KEY FK_3253373E6160631');
        $this->addSql('ALTER TABLE challenge_boss DROP FOREIGN KEY FK_375161BC98A21AC6');
        $this->addSql('ALTER TABLE challenge_boss DROP FOREIGN KEY FK_375161BC261FB672');
        $this->addSql('ALTER TABLE challenge_character DROP FOREIGN KEY FK_33ED6CAB98A21AC6');
        $this->addSql('ALTER TABLE challenge_character DROP FOREIGN KEY FK_33ED6CAB1136BE75');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C98A21AC6');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C61220EA6');
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45F56AE248B');
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45F441B8B65');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B361220EA6');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B398A21AC6');
        $this->addSql('ALTER TABLE play_challenge DROP FOREIGN KEY FK_E01AA50CA76ED395');
        $this->addSql('ALTER TABLE play_challenge DROP FOREIGN KEY FK_E01AA50C98A21AC6');
        $this->addSql('ALTER TABLE play_versus DROP FOREIGN KEY FK_F3888429DA42C2AC');
        $this->addSql('ALTER TABLE play_versus DROP FOREIGN KEY FK_F3888429A76ED395');
        $this->addSql('ALTER TABLE versus DROP FOREIGN KEY FK_31AEA46961220EA6');
        $this->addSql('ALTER TABLE versus DROP FOREIGN KEY FK_31AEA4695DFCD4B8');
        $this->addSql('ALTER TABLE versus DROP FOREIGN KEY FK_31AEA46998A21AC6');
        $this->addSql('DROP TABLE boss');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_restriction');
        $this->addSql('DROP TABLE challenge_boss');
        $this->addSql('DROP TABLE challenge_character');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE friendship');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE play_challenge');
        $this->addSql('DROP TABLE play_versus');
        $this->addSql('DROP TABLE restriction');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE versus');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
