--
-- Structure of table `Languages`
--

CREATE TABLE `Languages` (
  `SystemName` VARCHAR(10) NOT NULL,
  `Rank` INT UNSIGNED NOT NULL DEFAULT '0',
  `Locale` VARCHAR(50),
  `Base` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `Name` VARCHAR(10) NOT NULL,
  `Short` VARCHAR(5) NOT NULL,
  `Active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`SystemName`),
  KEY (`Rank`),
  KEY (`Locale`),
  KEY (`Base`),
  KEY (`Active`)
);

--
-- Dump of table `Languages`
--

INSERT INTO `Languages` (`SystemName`, `Rank`, `Locale`, `Base`, `Name`, `Short`, `Active`) VALUES
  ('en', 0, 'en_US.UTF-8,en.UTF-8,eng.UTF-8', 1, 'English', 'En', 1),
  ('ro', 0, 'ro_RO.UTF-8,ro.UTF-8,rom.UTF-8', 0, 'Română', 'Ro', 1),
  ('ru', 0, 'ru_RU.UTF-8,ru.UTF-8,rus.UTF-8', 0, 'Русский', 'Ру', 1);

-- --------------------------------------------------------

--
-- Structure of table `Meta`
--
CREATE TABLE `Meta` (
  `Key` VARCHAR(255) NOT NULL,
  `Type` VARCHAR(50),
  `Image` VARCHAR(255),
  `Audio` VARCHAR(255),
  `Video` VARCHAR(255),
  PRIMARY KEY (`Key`),
  KEY `Type` (`Type`)
);

-- --------------------------------------------------------

--
-- Structure of table `MetaLang`
--

CREATE TABLE `MetaLang` (
  `MetaKey` VARCHAR(255) NOT NULL,
  `LangSystemName` VARCHAR(10) NOT NULL,
  `Title` VARCHAR(255),
  `Description` VARCHAR(255),
  `Image` VARCHAR(255),
  `Audio` VARCHAR(255),
  `Video` VARCHAR(255),
  PRIMARY KEY (`MetaKey`,`LangSystemName`),
  KEY `LangSystemName` (`LangSystemName`),
  CONSTRAINT `MetaLangLangSystemName` FOREIGN KEY (`LangSystemName`) REFERENCES `Languages` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MetaLangMetaKey` FOREIGN KEY (`MetaKey`) REFERENCES `Meta` (`Key`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Structure of table `Options`
--

CREATE TABLE `Options` (
  `Key` VARCHAR(50) NOT NULL,
  `Group` VARCHAR(50) NOT NULL,
  `Rank` INT UNSIGNED NOT NULL DEFAULT '0',
  `Name` VARCHAR(50) NOT NULL,
  `Description` TEXT,
  `Type` ENUM('text','number','textarea','file','image','checkbox','date','datetime','email','color','enum') NOT NULL DEFAULT 'text',
  `Values` VARCHAR(255),
  `Value` TEXT,
  `Required` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `Active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`Key`),
  KEY `Group` (`Group`),
  KEY `Rank` (`Rank`),
  KEY `Type` (`Type`),
  KEY `Required` (`Required`),
  KEY `Active` (`Active`)
);

-- --------------------------------------------------------

--
-- Structure of table `Pages`
--

CREATE TABLE `Pages` (
  `Id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `SystemName` VARCHAR(255) NOT NULL,
  `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `SystemName` (`SystemName`),
  KEY `Created` (`Created`),
  KEY `Modified` (`Modified`)
);

-- --------------------------------------------------------

--
-- Structure of table `PagesLang`
--

CREATE TABLE `PagesLang` (
  `PageSystemName` VARCHAR(255) NOT NULL,
  `LangSystemName` VARCHAR(10) NOT NULL,
  `SystemName` VARCHAR(255) NOT NULL,
  `Title` VARCHAR(255) NOT NULL,
  `Body` TEXT NOT NULL,
  PRIMARY KEY (`PageSystemName`,`LangSystemName`),
  UNIQUE KEY `LangSystemName` (`LangSystemName`,`SystemName`),
  KEY `SystemName` (`SystemName`),
  CONSTRAINT `PagesLangLangSystemName` FOREIGN KEY (`LangSystemName`) REFERENCES `Languages` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PagesLangPageSystemName` FOREIGN KEY (`PageSystemName`) REFERENCES `Pages` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Structure of table `StaticBlocksCategories`
--

CREATE TABLE IF NOT EXISTS `StaticBlocksCategories` (
  `SystemName` VARCHAR(50) NOT NULL,
  `Rank` INT UNSIGNED NOT NULL DEFAULT '0',
  `Name` VARCHAR(50) NOT NULL,
  `Active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`SystemName`),
  KEY (`Rank`),
  KEY (`Active`)
);

--
-- Dump of table `StaticBlocksCategories`
--

INSERT INTO `StaticBlocksCategories` (`SystemName`, `Rank`, `Name`, `Active`) VALUES
  ('general', 1, 'General', 1);

-- --------------------------------------------------------

--
-- Structure of table `StaticBlocks`
--

CREATE TABLE IF NOT EXISTS `StaticBlocks` (
  `SystemName` VARCHAR(255) NOT NULL,
  `CatSystemName` VARCHAR(50),
  `Rank` INT UNSIGNED NOT NULL DEFAULT '0',
  `Active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `Modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SystemName`),
  KEY (`CatSystemName`),
  KEY (`Rank`),
  KEY (`Active`),
  KEY (`Modified`),
  CONSTRAINT `StatBlCatSystemName` FOREIGN KEY (`CatSystemName`) REFERENCES `StaticBlocksCategories` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Structure of table `StaticBlocksLang`
--

CREATE TABLE IF NOT EXISTS `StaticBlocksLang` (
  `BlockSystemName` VARCHAR(255) NOT NULL,
  `LangSystemName` VARCHAR(10) NOT NULL,
  `Title` VARCHAR(255),
  `Body` TEXT,
  PRIMARY KEY (`BlockSystemName`, `LangSystemName`),
  KEY (`LangSystemName`),
  CONSTRAINT `StatBlLangBlockSystemName` FOREIGN KEY (`BlockSystemName`) REFERENCES `StaticBlocks` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `StatBlLangLangSystemName` FOREIGN KEY (`LangSystemName`) REFERENCES `Languages` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Structure of table `Translates`
--

CREATE TABLE `Translates` (
  `Key` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`Key`)
);

-- --------------------------------------------------------

--
-- Structure of table `TranslatesLang`
--

CREATE TABLE `TranslatesLang` (
  `TranslateKey` VARCHAR(255) NOT NULL,
  `LangSystemName` VARCHAR(10) NOT NULL,
  `Text` TEXT,
  PRIMARY KEY (`TranslateKey`,`LangSystemName`),
  KEY `LangSystemName` (`LangSystemName`),
  CONSTRAINT `TransLangTranslateKey` FOREIGN KEY (`TranslateKey`) REFERENCES `Translates` (`Key`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `TransLangLangSystemName` FOREIGN KEY (`LangSystemName`) REFERENCES `Languages` (`SystemName`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------
