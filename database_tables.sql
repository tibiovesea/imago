-- Database: `imago`
-- 
CREATE DATABASE `imago` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE imago;

-- --------------------------------------------------------

-- 
-- Table structure for table `pictures`
-- 

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `intID` bigint(20) unsigned NOT NULL auto_increment,
  `blnDeleted` tinyint(1) NOT NULL,
  `blnLive` tinyint(1) NOT NULL,
  `txtFileName` varchar(256) NOT NULL,
  `dttDigitized` datetime default NULL,
  `txtPath` varchar(512) NOT NULL,
  `txtThumbPath` varchar(256) default NULL,
  `txtHash` varchar(64) NOT NULL,
  `txtUniq` varchar(64) NOT NULL,
  `intOrder` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`intID`),
  KEY `txtHash` (`txtHash`),
  KEY `txtDateTimeDigitized` (`dttDigitized`),
  KEY `intOrder` (`intOrder`),
  KEY `txtUniq` (`txtUniq`)
) ENGINE=InnoDB AUTO_INCREMENT=7086 DEFAULT CHARSET=utf8 AUTO_INCREMENT=7086 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `comments`
-- 

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `intID` bigint(20) unsigned NOT NULL auto_increment,
  `txtUniq` varchar(64) NOT NULL,
  `txtUniqTarget` varchar(64) default NULL,
  `txtUniqUser` varchar(64) default NULL,
  `txtName` varchar(64) default '',
  `txtTitle` varchar(256) default NULL,
  `txtComment` text,
  `dttPosted` datetime default NULL,
  `txtModule` varchar(16) default NULL,
  PRIMARY KEY  (`intID`),
  UNIQUE KEY `txtUniq` (`txtUniq`),
  KEY `txtUniqUser` (`txtUniqUser`),
  KEY `txtUniqTarget` (`txtUniqTarget`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tags`
-- 

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `intID` bigint(20) unsigned NOT NULL auto_increment,
  `txtUniq` varchar(64) NOT NULL,
  `txtUniqTarget` varchar(64) NOT NULL,
  `txtTag` varchar(64) NOT NULL,
  `txtTagText` varchar(64) NOT NULL,
  PRIMARY KEY  (`intID`),
  UNIQUE KEY `txtUniq` (`txtUniq`),
  KEY `txtUniqPicture` (`txtUniqTarget`),
  KEY `tag index` (`txtTag`)
) ENGINE=InnoDB AUTO_INCREMENT=16699 DEFAULT CHARSET=utf8 AUTO_INCREMENT=16699 ;

-- --------------------------------------------------------
