-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage des données de la table tboichallenge.boss : ~13 rows (environ)
INSERT INTO `boss` (`id`, `name`, `img`) VALUES
	(1, 'Blue Baby', 'bluebaby.webp'),
	(2, 'Delirium', 'delirium.webp'),
	(3, 'Hush', 'hush.webp'),
	(4, 'Isaac', 'isaac.webp'),
	(5, 'Mega Satan', 'mega_satan.webp'),
	(7, 'Mom', 'mom.webp'),
	(8, 'Mom\'s Heart', 'moms_heart.webp'),
	(9, 'Mother', 'mother.webp'),
	(10, 'Satan', 'satan.webp'),
	(11, 'The Beast', 'thebeast.webp'),
	(12, 'The Lamb', 'thelamb.webp'),
	(13, 'Ultra greed', 'ultra_greed.webp'),
	(14, 'Ultra greedier', 'ultra_greedier.webp');

-- Listage des données de la table tboichallenge.challenge : ~0 rows (environ)

-- Listage des données de la table tboichallenge.challenge_boss : ~0 rows (environ)

-- Listage des données de la table tboichallenge.challenge_character : ~0 rows (environ)

-- Listage des données de la table tboichallenge.challenge_user : ~0 rows (environ)

-- Listage des données de la table tboichallenge.character : ~34 rows (environ)
INSERT INTO `character` (`id`, `name`, `img`) VALUES
	(1, 'Isaac', 'isaac.webp'),
	(2, 'Magdalene', 'magdalene.webp'),
	(3, 'Cain', 'cain.webp'),
	(4, 'Judas', 'judas.webp'),
	(5, 'Blue Baby', 'bluebaby.webp'),
	(6, 'Eve', 'eve.webp'),
	(7, 'Samson', 'samson.webp'),
	(8, 'Azazel', 'azazel.webp'),
	(9, 'Lazarus', 'lazarus.webp'),
	(10, 'Eden', 'eden.webp'),
	(11, 'The Lost', 'thelost.webp'),
	(12, 'Lilith', 'lilith.webp'),
	(13, 'Keeper', 'keeper.webp'),
	(14, 'Apollyon', 'apollyon.webp'),
	(15, 'The Forgotten', 'forgotten.webp'),
	(16, 'Bethany', 'bethany.webp'),
	(17, 'Jacob & Esau', 'jacobesau.webp'),
	(18, 'Tainted Isaac', 'tainted_isaac.webp'),
	(19, 'Tainted Magdalene', 'tainted_magdalene.webp'),
	(20, 'Tainted Cain', 'tainted_cain.webp'),
	(21, 'Tainted Judas', 'tainted_judas.webp'),
	(22, 'Tainted Blue Baby', 'tainted_bluebaby.webp'),
	(23, 'Tainted Eve', 'tainted_eve.webp'),
	(24, 'Tainted Samson', 'tainted_samson.webp'),
	(25, 'Tainted Azazel', 'tainted_azazel.webp'),
	(26, 'Tainted Lazarus', 'tainted_lazarus.webp'),
	(27, 'Tainted Eden', 'tainted_eden.webp'),
	(28, 'Tainted Lost', 'tainted_lost.webp'),
	(29, 'Tainted Lilith', 'tainted_lilith.webp'),
	(30, 'Tainted Keeper', 'tainted_keeper.webp'),
	(31, 'Tainted Apollyon', 'tainted_apollyon.webp'),
	(32, 'Tainted Forgotten', 'tainted_forgotten.webp'),
	(33, 'Tainted Bethany', 'tainted_bethany.webp'),
	(34, 'Tainted Jacob', 'tainted_jacob.webp');

-- Listage des données de la table tboichallenge.comment : ~0 rows (environ)

-- Listage des données de la table tboichallenge.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230906155419', '2023-09-06 15:54:26', 744);

-- Listage des données de la table tboichallenge.like : ~0 rows (environ)

-- Listage des données de la table tboichallenge.messenger_messages : ~0 rows (environ)

-- Listage des données de la table tboichallenge.restriction : ~15 rows (environ)
INSERT INTO `restriction` (`id`, `name`, `img`) VALUES
	(1, 'No using consumables (Pills, cards, runes etc.)', 'no_consumables.png'),
	(2, 'No bombs', 'no_bombs.png'),
	(3, 'No hearts', 'no_hearts.png'),
	(4, 'No chests (except endgame chest)', 'no_chests.png'),
	(5, 'No trinkets', 'no_trinkets.png'),
	(6, 'No treasure rooms', 'no_treasurerooms.png'),
	(7, 'No self damage', 'no_selfdmg.png'),
	(8, 'No secret rooms', 'no_secretrooms.png'),
	(9, 'No shops', 'no_shops.png'),
	(10, 'No devil rooms', 'no_devilrooms.png'),
	(11, 'No angel rooms', 'no_angelrooms.png'),
	(12, 'No treasure rooms until a planetarium appears', 'no_treasurerooms_untilplanetarium.png'),
	(13, 'Take all items', 'take_all_items.png'),
	(14, 'Go to every curse room (if not lethal)', 'goto_all_curserooms.png'),
	(15, 'Clear every room each floors', 'clear_everyrooms.png');

-- Listage des données de la table tboichallenge.restriction_challenge : ~0 rows (environ)

-- Listage des données de la table tboichallenge.user : ~0 rows (environ)

-- Listage des données de la table tboichallenge.versus : ~0 rows (environ)

-- Listage des données de la table tboichallenge.versus_user : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
