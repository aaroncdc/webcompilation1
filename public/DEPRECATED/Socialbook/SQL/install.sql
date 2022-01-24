CREATE DATABASE socialbook DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_spanish_ci;

USE socialbook;

CREATE TABLE usuarios (
  IDNO bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  NOM varchar(20) NOT NULL,
  APE1 varchar(20) NOT NULL,
  APE2 varchar(20) DEFAULT NULL,
  USMAIL varchar(254) NOT NULL,
  REGDATE datetime NOT NULL,
  BDATE date DEFAULT NULL,
  DIRECC varchar(500) DEFAULT NULL,
  PAIS varchar(50) DEFAULT NULL,
  TELF1 varchar(10) DEFAULT NULL,
  TELF2 varchar(10) DEFAULT NULL,
  DESCRIP varchar(10000) DEFAULT NULL,
  PASSWD varchar(256) NOT NULL,
  USHASH varchar(256) NOT NULL,
  SESSIONID varchar(256) NOT NULL,
  PRIMARY KEY (IDNO),
  UNIQUE KEY IDNO (IDNO)
);

CREATE TABLE paginas (
  PID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  IDNO bigint(20) unsigned NOT NULL,
  NOM varchar(40) DEFAULT NULL,
  PRIMARY KEY (PID),
  UNIQUE KEY PID (PID),
  KEY IDNO (IDNO),
  CONSTRAINT paginas_ibfk_1 FOREIGN KEY (IDNO) REFERENCES usuarios (IDNO)
);

CREATE TABLE amistades (
  OWNID bigint(20) unsigned NOT NULL,
  REL bigint(20) unsigned NOT NULL,
  STATUS tinyint(4) unsigned NOT NULL,
  KEY OWNID (OWNID),
  KEY REL (REL),
  CONSTRAINT amistades_ibfk_1 FOREIGN KEY (OWNID) REFERENCES usuarios (IDNO),
  CONSTRAINT amistades_ibfk_2 FOREIGN KEY (REL) REFERENCES usuarios (IDNO)
);

CREATE TABLE contenidos (
  MID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  IDNO bigint(20) unsigned NOT NULL,
  MEDIATYPE tinyint(4) NOT NULL,
  URL varchar(512) DEFAULT NULL,
  ALT varchar(512) DEFAULT NULL,
  THUMB varchar(512) DEFAULT NULL,
  PID bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (MID),
  UNIQUE KEY MID (MID),
  KEY IDNO (IDNO),
  KEY PID (PID),
  CONSTRAINT contenidos_ibfk_1 FOREIGN KEY (IDNO) REFERENCES usuarios (IDNO),
  CONSTRAINT contenidos_ibfk_2 FOREIGN KEY (PID) REFERENCES paginas (PID)
);

CREATE TABLE comunidad (
  PID bigint(20) unsigned NOT NULL,
  REL bigint(20) unsigned NOT NULL,
  KEY PID (PID),
  KEY REL (REL),
  CONSTRAINT comunidad_ibfk_1 FOREIGN KEY (PID) REFERENCES paginas (PID),
  CONSTRAINT comunidad_ibfk_2 FOREIGN KEY (REL) REFERENCES usuarios (IDNO)
);

CREATE TABLE datosusuario (
  DID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  IDNO bigint(20) unsigned NOT NULL,
  DTYPE tinyint(4) NOT NULL,
  MID bigint(20) unsigned DEFAULT NULL,
  TID bigint(20) unsigned DEFAULT NULL,
  LIKES bigint(20) unsigned DEFAULT NULL,
  UNLIKES bigint(20) unsigned DEFAULT NULL,
  UNIQUE KEY DID (DID),
  KEY MID (MID),
  KEY IDNO (IDNO),
  CONSTRAINT datosusuario_ibfk_1 FOREIGN KEY (MID) REFERENCES contenidos (MID),
  CONSTRAINT datosusuario_ibfk_2 FOREIGN KEY (IDNO) REFERENCES usuarios (IDNO)
);

CREATE TABLE mensajes (
  MID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  IDNO bigint(20) unsigned NOT NULL,
  DEST bigint(20) unsigned NOT NULL,
  FECHA datetime NOT NULL,
  CONT varchar(5000) NOT NULL,
  PRIMARY KEY (MID),
  UNIQUE KEY MID (MID),
  KEY IDNO (IDNO),
  KEY DEST (DEST),
  CONSTRAINT mensajes_ibfk_1 FOREIGN KEY (IDNO) REFERENCES usuarios (IDNO),
  CONSTRAINT mensajes_ibfk_2 FOREIGN KEY (DEST) REFERENCES usuarios (IDNO)
);

CREATE TABLE opciones (
  IDNO bigint(20) unsigned NOT NULL,
  PERFP bit(2) NOT NULL,
  SHOWBDATE bit(2) NOT NULL,
  SHOWDIRECC bit(2) NOT NULL,
  SHOWTELFS bit(2) NOT NULL,
  SHOWEMAIL bit(2) NOT NULL,
  SHOWRELS bit(2) NOT NULL,
  KEY IDNO (IDNO),
  CONSTRAINT opciones_ibfk_1 FOREIGN KEY (IDNO) REFERENCES usuarios (IDNO)
);

CREATE TABLE textos (
  TID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  IDNO bigint(20) unsigned DEFAULT NULL,
  PID bigint(20) unsigned DEFAULT NULL,
  CONT varchar(20000) DEFAULT NULL,
  UNIQUE KEY TID (TID),
  KEY IDNO (IDNO),
  CONSTRAINT textos_ibfk_1 FOREIGN KEY (IDNO) REFERENCES usuarios (IDNO)
);

CREATE PROCEDURE NewUser(IN NAME varchar(20), IN AP1 varchar(20), IN AP2 varchar(20),
IN MAIL varchar(254), IN RDATE datetime, IN BDAT date, IN DIR varchar(500) , IN CNTRY varchar(50),
IN TLF1 varchar(10), IN TLF2 varchar(10), IN DESCR varchar(10000), IN PSSWD varchar(256),
IN HASH varchar(256))
INSERT INTO USUARIOS VALUES('',NAME, AP1, AP2, MAIL, RDATE, BDAT, DIR, CNTRY, TLF1,
TLF2,DESCR,PSSWD,HASH,0);