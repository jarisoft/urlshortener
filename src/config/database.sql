-- Setup database for this application

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `urlshortener`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shortener`
--

CREATE TABLE IF NOT EXISTS `shortener` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortName` varchar(4) COLLATE utf8_bin NOT NULL,
  `target` varchar(100) COLLATE utf8_bin NOT NULL,
  `dateCreated` int(11) NOT NULL,
  `dateExpired` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=41 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
