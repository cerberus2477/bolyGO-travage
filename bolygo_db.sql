-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Okt 22. 13:29
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `bolygo_db`
--
CREATE DATABASE IF NOT EXISTS `bolygo_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `bolygo_db`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `bolygo`
--

CREATE TABLE IF NOT EXISTS `bolygo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi azonosító',
  `nev` varchar(256) NOT NULL COMMENT 'Bolygó neve',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `csomag`
--

CREATE TABLE IF NOT EXISTS `csomag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi azonosító',
  `nev` varchar(256) NOT NULL COMMENT 'Csomag neve',
  `leiras` varchar(1024) NOT NULL COMMENT 'Csomag leírása',
  `bolygoid` int(11) NOT NULL COMMENT 'Csomag helyszíne',
  `kezdes` date NOT NULL COMMENT 'Csomag érvényességének kezdete',
  `vege` date NOT NULL COMMENT 'Csomag érvényességének vége',
  `ar` int(11) NOT NULL COMMENT 'ár/fő/nap',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `csomagjarmu`
--

CREATE TABLE IF NOT EXISTS `csomagjarmu` (
  `csomagid` int(11) NOT NULL COMMENT 'Csomag azonosítója',
  `jarmuid` int(11) NOT NULL COMMENT 'Jármű azonosítója',
  `ar` int(11) NOT NULL COMMENT 'A csomaghoz tartozó útiköltség az adott járművel fejenként.',
  PRIMARY KEY (`csomagid`,`jarmuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Kapcsoló tábla a Csomag és Jarmu táblák között. Ez határozza meg, milyen járművek választhatóak egyes csomagokban.';

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `csoport`
--

CREATE TABLE IF NOT EXISTS `csoport` (
  `foglalasid` int(11) NOT NULL COMMENT 'Foglalás azonosítója',
  `ugyfelid` int(11) NOT NULL COMMENT 'Ügyfél azonosítója',
  PRIMARY KEY (`foglalasid`,`ugyfelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Kapcsolótábla az Ugyfel és Foglalas táblák között. Ezen keresztül lehet egy foglaláshoz hozzárendelni az ügyfeleket.';

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `foglalas`
--

CREATE TABLE IF NOT EXISTS `foglalas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi azonosító',
  `csomagid` int(11) NOT NULL COMMENT 'A foglaláshoz tartozó csomag azonosítója',
  `kezdes` date NOT NULL COMMENT 'A foglalás kezdetének dátuma',
  `vege` date NOT NULL COMMENT 'A foglalás végének dátuma',
  `ar` int(11) NOT NULL COMMENT 'A foglalás teljes ára',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmu`
--

CREATE TABLE IF NOT EXISTS `jarmu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi azonosító',
  `nev` varchar(256) NOT NULL COMMENT 'A jármű neve',
  `osztaly` int(11) NOT NULL COMMENT 'A jármű kényelmi osztálybesorolása',
  `fekvohely` tinyint(1) NOT NULL COMMENT 'Fekvőhelyes-e a jármű',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ugyfel`
--

CREATE TABLE IF NOT EXISTS `ugyfel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Egyedi azonosító',
  `nev` varchar(256) NOT NULL COMMENT 'Ügyfél neve',
  `lakcim` varchar(256) NOT NULL COMMENT 'Ügyfél lakcíme',
  `szul` date NOT NULL COMMENT 'Ügyfél születési ideje',
  `nem` varchar(256) DEFAULT NULL COMMENT 'Ügyfél neme',
  `tel` varchar(256) DEFAULT NULL COMMENT 'Ügyfél telefonszáma',
  `email` varchar(256) DEFAULT NULL COMMENT 'Ügyfél email-címe',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `csomag`
--
ALTER TABLE `csomag`
  DROP CONSTRAINT IF EXISTS `fk_csomag_bolygo`;
ALTER TABLE `csomag`
  ADD CONSTRAINT `fk_csomag_bolygo` FOREIGN KEY (`bolygoid`) REFERENCES `bolygo` (`id`);

--
-- Megkötések a táblához `csomagjarmu`
--
ALTER TABLE `csomagjarmu`
  DROP CONSTRAINT IF EXISTS `fk_csomagjarmu_csomag`,
  DROP CONSTRAINT IF EXISTS `fk_csomagjarmu_jarmu`;
ALTER TABLE `csomagjarmu`
  ADD CONSTRAINT `fk_csomagjarmu_csomag` FOREIGN KEY (`csomagid`) REFERENCES `csomag` (`id`),
  ADD CONSTRAINT `fk_csomagjarmu_jarmu` FOREIGN KEY (`jarmuid`) REFERENCES `jarmu` (`id`);

--
-- Megkötések a táblához `csoport`
--
ALTER TABLE `csoport`
  DROP CONSTRAINT IF EXISTS `fk_csoport_foglalas` ,
  DROP CONSTRAINT IF EXISTS `fk_csoport_ugyfel` ;
ALTER TABLE `csoport`
  ADD CONSTRAINT `fk_csoport_foglalas` FOREIGN KEY (`foglalasid`) REFERENCES `foglalas` (`id`),
  ADD CONSTRAINT `fk_csoport_ugyfel` FOREIGN KEY (`ugyfelid`) REFERENCES `ugyfel` (`id`);

--
-- Megkötések a táblához `foglalas`
--
ALTER TABLE `foglalas`
  DROP CONSTRAINT IF EXISTS `fk_foglalas_csomag` ;
ALTER TABLE `foglalas`
  ADD CONSTRAINT `fk_foglalas_csomag` FOREIGN KEY (`csomagid`) REFERENCES `csomag` (`id`);
COMMIT;

-- --------------------------------------------------------

--
-- Fontos alapadatok
--

DELETE FROM csomagjarmu WHERE jarmuid = -1;
DELETE FROM csomagjarmu WHERE csomagid = -1;
DELETE FROM csoport WHERE foglalasid IN (SELECT id FROM foglalas WHERE csomagid = -1);

DELETE FROM csomag WHERE id = -1;
DELETE FROM jarmu WHERE id = -1;
DELETE FROM bolygo WHERE id = -1;

INSERT INTO `bolygo` (`id`,`nev`) VALUES ('-1','Nincs megadva');
INSERT INTO `jarmu` (`id`, `nev`, `osztaly`, `fekvohely`) VALUES ('-1','Nincs megadva','0','0');
INSERT INTO `csomag` (`id`, `nev`, `leiras`, `bolygoid`, `kezdes`, `vege`, `ar`) VALUES ('-1', 'Nincs megadva','Leírás megadása', '-1', '1753-01-01', '1753-01-01', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;