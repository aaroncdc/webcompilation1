CREATE DATABASE @db DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_bin;

USE @db;

CREATE TABLE @tpboard_category (
  ID int(11) NOT NULL AUTO_INCREMENT,
  NAME varchar(30) NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE @tpboards (
  ID int(11) NOT NULL AUTO_INCREMENT,
  NAME text NOT NULL,
  PREFIX tinytext NOT NULL,
  CATEGORY int(11) NOT NULL,
  STYLE text NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (CATEGORY) REFERENCES @tpboard_category(ID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE @tpthreads (
  ID int(11) NOT NULL AUTO_INCREMENT,
  UID int(11) NOT NULL,
  BOARD int(11) NOT NULL,
  NAME text NOT NULL,
  REPLIES int(11) NOT NULL DEFAULT '0',
  OWNER text NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (BOARD) REFERENCES @tpboards(ID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE @tpposts (
  ID bigint(20) NOT NULL AUTO_INCREMENT,
  THREAD int(11) NOT NULL,
  OWNER text NOT NULL,
  CONTENT text NOT NULL,
  DATE datetime NOT NULL,
  LINK text,
  PRIMARY KEY (ID),
  FOREIGN KEY (THREAD) REFERENCES @tpthreads(ID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE @tpconfig (
  name text NOT NULL,
  description text NOT NULL,
  news text NOT NULL,
  default_style text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE @tpstatistics (
  UNIQUEVISITORS bigint(20) NOT NULL DEFAULT '0',
  VISITORS bigint(20) NOT NULL DEFAULT '0',
  HISTORYTHREADS bigint(20) NOT NULL DEFAULT '0',
  HISTORYPOSTS bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE @tpusers (
  ID int(11) NOT NULL AUTO_INCREMENT,
  IP varchar(40) NOT NULL DEFAULT '0.0.0.0',
  LASTSEEN datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  BAN tinyint(1) NOT NULL DEFAULT '0',
  BANEXPIRES datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  COOLDOWN datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;