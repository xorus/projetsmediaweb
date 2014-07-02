-- Josua Gonzalez
-- 2014 GNU GPL v2
-- SQL dump

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Export de la structure de table IUT. media
CREATE TABLE IF NOT EXISTS `media` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(50) DEFAULT NULL,
  `Categorie` varchar(50) DEFAULT NULL,
  `Type` enum('VID','AUD','MAG') DEFAULT NULL,
  `Liens` mediumtext COMMENT 'Lien|qualite|taille',
  `Duree` int(11) DEFAULT NULL,
  `Auteurs` mediumtext,
  `Description` mediumtext,
  `Jour` tinyint(4) DEFAULT NULL,
  `Ordre` tinyint(4) DEFAULT NULL,
  `Show` enum('Y','N') NOT NULL DEFAULT 'Y',
  `Poster` varchar(255) DEFAULT NULL,
  `Prix` varchar(255) DEFAULT NULL,
  `NotePresentation` float unsigned DEFAULT NULL,
  `NoteRealisation` float unsigned DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- L'exportation de données n'été pas sélectionné.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
