-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2013 at 04:40 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `net_articles`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`mod`@`localhost` FUNCTION `inc_parametre`(`numpar` CHAR(10)) RETURNS int(11)
    READS SQL DATA
BEGIN
   declare valeur int;
   select val_parametre into valeur from parametre
   where id_parametre = numpar for update;
    set valeur := valeur + 1;
   update parametre set val_parametre = valeur where id_parametre = numpar;
   return(valeur);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `achete`
--

CREATE TABLE IF NOT EXISTS `achete` (
  `id_client` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `date_achat` date DEFAULT NULL,
  PRIMARY KEY (`id_client`,`id_article`),
  KEY `fk_achete_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `achete`
--

INSERT INTO `achete` (`id_client`, `id_article`, `date_achat`) VALUES
(1, 1, '2004-12-07'),
(1, 15, '2004-12-07'),
(1, 21, '2005-01-12'),
(1, 22, '2004-12-05'),
(1, 23, '2004-12-05'),
(2, 3, '2004-10-08'),
(2, 10, '2004-11-08'),
(2, 12, '2004-12-18'),
(2, 14, '2004-10-07'),
(2, 15, '2004-10-07'),
(3, 1, '2004-11-22'),
(3, 2, '2004-11-22'),
(3, 4, '2004-10-30'),
(3, 12, '2004-10-30'),
(3, 13, '2005-02-09'),
(3, 20, '2004-11-22'),
(3, 21, '2004-12-18'),
(4, 11, '2004-12-11'),
(4, 12, '2004-12-11'),
(4, 13, '2005-01-11'),
(4, 14, '2004-10-18'),
(4, 16, '2004-12-18'),
(5, 7, '2004-10-02'),
(5, 8, '2004-10-02'),
(5, 17, '2004-11-12'),
(5, 18, '2004-10-02'),
(5, 20, '2005-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int(11) NOT NULL,
  `id_domaine` int(11) NOT NULL,
  `titre` varchar(250) DEFAULT NULL,
  `resume` varchar(2048) DEFAULT NULL,
  `prix` decimal(11,2) DEFAULT NULL,
  `date_article` date DEFAULT NULL,
  `fichier` varchar(50) NOT NULL,
  PRIMARY KEY (`id_article`),
  KEY `fk_article_domaine` (`id_domaine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `id_domaine`, `titre`, `resume`, `prix`, `date_article`, `fichier`) VALUES
(1, 1, 'Le modèle relationnel', 'Le modèle relationnel est basé sur une organisation des données sous forme de tables. La manipulation des données se fait selon le concept mathématique de relation de la théorie des ensembles, c''est-à-dire l''algèbre relationnelle. L''algèbre relationnelle a été inventée en 1970 par E.F. Codd, le directeur de recherche du centre IBM de San José. Elle est constituée d''un ensemble d''opérations formelles sur les relations. Les opérations relationnelles permettent de créer une nouvelle relation (table) à partir d''opérations élémentaires sur d''autres tables (par exemple l''union, l''intersection, ou encore la différence)...	', 5.00, '2004-01-26', 'modelerelationnel.pdf'),
(2, 1, 'La notion de SGBD', 'Une base de données (son abréviation est BD ou BDD, en anglais DB, database) est une entité dans laquelle il est possible de stocker des données de façon structurée et avec le moins de redondance possible. Ces données doivent pouvoir être utilisées par des programmes, par des utilisateurs différents. Ainsi, la notion de base de données est généralement couplée à celle de réseau, afin de pouvoir mettre en commun ces informations, d''où le nom de base. On parle généralement de système d''information pour désigner toute la structure regroupant les moyens mis en place pour pouvoir partager des données ...									', 6.00, '2002-03-31', 'notion_SGBD.pdf'),
(3, 5, 'Le concept de système d''exploitation', 'Pour qu''un ordinateur soit capable de faire fonctionner un programme informatique (appelé parfois application ou logiciel), la machine doit être en mesure d''effectuer un certain nombre d''opérations préparatoires afin d''assurer les échanges entre le processeur, la mémoire, et les ressources physiques (périphériques). 	', 6.00, '2003-04-09', 'systeme_exploitation.pdf'),
(4, 1, 'Le langage SQL', 'SQL (Structured Query Language, traduisez Langage de requêtes structuré) est un langage de définition de données (LDD, ou en anglais DDL Data Definition Language), un langage de manipulation de données (LMD, ou en anglais DML, Data Manipulation Language), et un langage de contrôle de données (LCD, ou en anglais DCL, Data Control Language), pour les bases de données relationnelles ...			', 10.00, '2003-10-19', 'langage_SQL.pac'),
(5, 1, 'Introduction aux annuaires électroniques (LDAP)', 'Cette série d''articles s''intéresse tout particulièrement à un type spécifique d''annuaires : les annuaires électroniques. Les annuaires électroniques sont un type de base de données spécialisées permettant de stocker des informations de manière hiérarchique et offrant des mécanismes simples pour rechercher l''information, la trier, l''organiser selon un nombre limité de critères. Ainsi le but d''un annuaire électronique est approximativement le même que celui d''un annuaire papier, si ce n''est qu''il offre une grande panoplie de possibilités que les annuaires papier ne sauraient donner. ...							', 8.00, '2005-07-08', 'annuaire_electronique.pdf'),
(6, 1, 'La notion de middleware à travers l''exemple d''ODBC', 'ODBC signifie Open DataBase Connectivity. Il s''agit d''un format défini par Microsoft permettant la communication entre des clients bases de données fonctionnant sous Windows et les SGBD du marché ...						', 5.00, '2004-11-20', 'middleware.pdf'),
(7, 1, 'Introduction à JDBC', 'La technologie JDBC (Java DataBase Connectivity) est une API fournie avec Java (depuis sa version 1.1) permettant de se connecter à des bases de données, c''est-à-dire que JDBC constitue un ensemble de classes permettant de développer des applications capables de se connecter à des serveurs de bases de données (SGBD) ...', 6.00, '2003-12-09', 'introduction_JDBC.pdf'),
(8, 2, 'Le langage C', 'Le langage C a été mis au point par D.Ritchie et B.W.Kernighan au début des années 70. Leur but était de permettre de développer un langage qui permettrait d''obtenir un système d''exploitation de type UNIX portable. D.Ritchie et B.W.Kernighan se sont inspirés des langages B et BCPL, pour créer un nouveau langage: le langage C ...', 8.00, '2004-05-07', 'langage_C.pdf'),
(9, 2, 'Le langage PL/SQL', 'Le langage PL/SQL est un langage L4G (entendez par ce terme un langage de quatrième génération), fournissant une interface procédurale au SGBD Oracle. Le langage PL/SQL intègre parfaitement le langage SQL en lui apportant une dimension procédurale ...', 8.00, '2003-06-14', 'langage_PLSQL.pdf'),
(10, 2, 'Introduction au langage Java', 'Java est un langage objet ressemblant au langage C++. Il a été mis au point en 1991 par la firme Sun Microsystems. Le but de Java à l''époque était de constituer un langage de programmation pouvant être intégré dans les appareils électroménagers, afin de pouvoir les contrôler, de les rendre interactifs, et surtout de permettre une communication entre les appareils ...							', 7.00, '2002-07-21', 'langage_Java.pdf'),
(11, 2, 'Le langage PERL', 'Perl (Practical Extraction and Report Language) est un langage de programmation dérivé des scripts shell, créé en 1986 par Larry Wall afin de mettre au point un système de News entre deux réseaux. Il s''agit d''un langage interprété dont l''avantage principal est d''être très adapté à la manipulation de chaînes de caractères. De plus, ses fonctionnalités de manipulation de fichiers, de répertoires et de bases de données en ont fait le langage de prédilection pour l''écriture d''interfaces CGI ...', 8.00, '2004-03-07', 'langage_PERL.pdf'),
(12, 2, 'Introduction au langage Pascal', 'Ce langage a été créé en 1969 à l''école polytechnique de ZURICH par N. WIRTH. Il a été conçu pour permettre d''enseigner la programmation comme une science. Ce langage est à la base d''une nouvelle méthode de programmation : la programmation structurée, et c''est pour cette raison que ce langage a eu un tel succès dans l''enseignement. Il s''agit d''un langage de 3ème génération ...', 5.00, '2003-01-22', 'langage_Pascal.pdf'),
(13, 2, 'Présentation de l''Assembleur', 'Le langage assembleur est très proche du langage machine (c''est-à-dire le langage qu''utilise l''ordinateur : des informations binaires, soit des 0 et des 1). Il dépend donc fortement du type de processeur. Ainsi il n''existe pas un langage assembleur, mais un langage assembleur par type de processeur. Il est donc nécessaire de connaître un minimum le fonctionnement d''un processeur pour pouvoir aborder cette partie ...', 6.00, '2002-04-29', 'Assembleur.pdf'),
(14, 5, 'Le système d''exploitation UNIX', 'Le système Unix est un système d''exploitation multi-utilisateurs, multi-tâches, ce qui signifie qu''il permet à un ordinateur mono ou multi-processeurs de faire exécuter simultanément plusieurs programmes par un ou plusieurs utilisateurs ...', 7.00, '2001-08-19', 'UNIX.pdf'),
(15, 5, 'Le système d''exploitation Linux', 'Linus B.Torvalds est à l''origine de ce système d''exploitation entièrement libre. Au début des années 90, il voulait mettre au point son propre système d''exploitation pour son projet de fin d''étude. Linus Torvalds avait pour intention de développer une version d''UNIX pouvant être utilisé sur une architecture de type 80386 ...', 7.00, '2004-04-21', 'Linux.pdf'),
(16, 5, 'Le système d''exploitation Windows NT/XP', 'Windows NT (pour «New Technology») est un système d''exploitation 32 bits développé par Microsoft. L''apparence de Windows NT est vraisemblablement la même que celle de Windows 95/98/Millenium, mais Windows NT possède un noyau développé séparément. ainsi Windows NT possède les caractéristiques suivantes ...', 6.00, '2005-02-05', 'Windows_NT_XP.pdf'),
(17, 3, 'Créer des pages en HTML', 'Le HTML ("HyperText Markup Language") est un langage dit de "marquage" chargé de formaliser l''écriture d''un document avec des balises de formatage indiquant la façon dont doit être présenté le document et les liens qu''il établit avec d''autres documents ...', 5.00, '2003-04-05', 'HTML.pdf'),
(18, 3, 'Développer un site en PHP', 'PHP est un langage interprété (un langage de script) exécuté du côté serveur (comme les scripts CGI, ASP, ...) et non du côté client (un script écrit en Javascript ou une applet Java s''exécute sur votre ordinateur...). La syntaxe du langage provient de celles du langage C, du Perl et de Java. Ses principaux atouts sont ...', 7.00, '2002-06-15', 'Developper_PHP.pdf'),
(19, 3, 'Utiliser le javascript pour les actions côté client', 'Le Javascript est un langage de script incorporé dans un document HTML. Historiquement il s''agit même du premier langage de script pour le Web. Ce langage est un langage de programmation qui permet d''apporter des améliorations au langage HTML en permettant d''exécuter des commandes du côté client, c''est-à-dire au niveau du navigateur et non du serveur web ...', 8.00, '2003-06-12', 'javascript.pdf'),
(20, 4, 'Introduction aux réseaux', 'Un réseau est un ensemble d''objets interconnectés les uns avec les autres. Il permet de faire circuler des éléments entre chacun de ces objets selon des règles bien définies ...', 5.00, '2002-07-22', 'introduction_reseaux.pdf'),
(21, 4, 'La notion de protocole réseau', 'Aux débuts de l''informatique des ordinateurs ont été mis au point, dès qu''ils furent aptes à fonctionner seuls, des personnes eurent l''idée de les relier entre eux afin qu''ils puissent échanger des données, c''est le concept de réseau. Il a donc fallu mettre au point des liaisons physiques entre les ordinateurs pour que l''information puisse circuler, mais aussi un langage de communication pour qu''il puisse y avoir un réel échange, on a décidé de nommer ce langage: protocole ...', 7.00, '2003-01-22', 'protocole_réseau.pdf'),
(22, 6, 'Introduction à Merise', 'La conception d''un système d''information n''est pas évidente car il faut réfléchir à l''ensemble de l''organisation que l''on doit mettre en place. La phase de conception nécessite des méthodes permettant de mettre en place un modèle sur lequel on va s''appuyer. La modélisation consiste à créer une représentation virtuelle d''une réalité de telle façon à faire ressortir les points auxquels on s''intéresse ...', 7.00, '2001-10-13', 'introduction_Merise.pdf'),
(23, 6, 'Introduction à UML', 'UML (Unified Modeling Language, que l''on peut traduire par "langage de modélisation unifié) est une notation permettant de modéliser un problème de façon standard. Ce langage est né de la fusion de plusieurs méthodes existant auparavant, et est devenu désormais la référence en terme de modélisation objet, à un tel point que sa connaissance est souvent nécessaire pour obtenir un poste de développeur objet ...', 7.00, '2005-04-09', 'introduction_UML.pdf'),
(39, 3, 'ploum', 'ezrghdjfhg', 4.00, '2002-03-09', 'dfghj');

--
-- Triggers `article`
--
DROP TRIGGER IF EXISTS `tbi_article`;
DELIMITER //
CREATE TRIGGER `tbi_article` BEFORE INSERT ON `article`
 FOR EACH ROW begin
	declare ck_article_prix condition for sqlstate '45000';
	if (new.prix <= 0) then
		signal ck_article_prix set message_text = 'ck_article_prix : prix négatif.';
	end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tbu_article`;
DELIMITER //
CREATE TRIGGER `tbu_article` BEFORE UPDATE ON `article`
 FOR EACH ROW begin
	declare ck_article_prix condition for sqlstate '45000';
	if (new.prix <= 0) then
		signal ck_article_prix set message_text = 'ck_article_prix : prix négatif.';
	end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE IF NOT EXISTS `auteur` (
  `id_auteur` int(11) NOT NULL,
  `identite_auteur` varchar(80) DEFAULT NULL,
  `adresse_auteur` varchar(200) DEFAULT NULL,
  `login_auteur` varchar(50) NOT NULL,
  `pwd_auteur` varchar(20) NOT NULL,
  PRIMARY KEY (`id_auteur`),
  UNIQUE KEY `un_auteur_login` (`login_auteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`id_auteur`, `identite_auteur`, `adresse_auteur`, `login_auteur`, `pwd_auteur`) VALUES
(1, 'Annie Zhette', '28, rue du Comptoir 69009 LYON', 'zhette', 'annie'),
(2, 'Jean Dhort', '15, rue du Sommeil 69004 LYON', 'dhort', 'jean'),
(3, 'Louis Seize', '64, rue du Roi 69002 LYON', 'seize', 'louis'),
(4, 'Rémi Fassol', '6, avenue de la Clé 69001 LYON', 'fassol', 'rémi'),
(5, 'Vincent Thimaitre', '12, rue Cinécita 69007 LYON', 'thimaitre', 'vincent'),
(6, 'Pierre Kyhroul', '31, rue Tassigny 69009 LYON', 'kyhroul', 'pierre');

--
-- Triggers `auteur`
--
DROP TRIGGER IF EXISTS `tbi_auteur`;
DELIMITER //
CREATE TRIGGER `tbi_auteur` BEFORE INSERT ON `auteur`
 FOR EACH ROW begin
	declare ck_auteur_pwd_auteur condition for sqlstate '45000';
	declare ck_auteur_pwd_login condition for sqlstate '45000';
	if (length(new.pwd_auteur) < 4) then
		signal ck_auteur_pwd_auteur set message_text = 'ck_auteur_pwd_auteur : le mot de passe doit avoir au moins 4 caractères.';
	end if;
	if (new.pwd_auteur = new.login_auteur) then
		signal ck_auteur_pwd_login set message_text = 'ck_auteur_pwd_login : le mot de passe doit être différent du login.';
	end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tbu_auteur`;
DELIMITER //
CREATE TRIGGER `tbu_auteur` BEFORE UPDATE ON `auteur`
 FOR EACH ROW begin
	declare ck_auteur_pwd_auteur condition for sqlstate '45000';
	declare ck_auteur_pwd_login condition for sqlstate '45000';
	if (length(new.pwd_auteur) < 4) then
		signal ck_auteur_pwd_auteur set message_text = 'ck_auteur_pwd_auteur : le mot de passe doit avoir au moins 4 caractères.';
	end if;
	if (new.pwd_auteur = new.login_auteur) then
		signal ck_auteur_pwd_login set message_text = 'ck_auteur_pwd_login : le mot de passe doit être différent du login.';
	end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int(11) NOT NULL,
  `lib_categorie` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `lib_categorie`) VALUES
(1, 'Particulier'),
(2, 'Entreprise'),
(3, 'Administration'),
(4, 'Education'),
(5, 'Indépendant'),
(6, 'Autres');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `identite_client` varchar(80) DEFAULT NULL,
  `adresse_client` varchar(200) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `login_client` varchar(50) NOT NULL,
  `pwd_client` varchar(20) NOT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `un_client_login` (`login_client`),
  KEY `fk_client_categorie` (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `id_categorie`, `identite_client`, `adresse_client`, `credits`, `login_client`, `pwd_client`) VALUES
(1, 1, 'Ali Néa', '18, rue de la Grande Armée 69002 LYON', 100, 'néa', 'alinéa'),
(2, 3, 'Eric Hochet', '7, rue de la Bande dessinée 75002 PARIS', 78, 'hochet', 'éric'),
(3, 2, 'Paul Auchon', '54, Avenue du Grand Matelas 71000 MACON', 45, 'auchon', 'paul'),
(4, 2, 'Sylvie Anquore', '87, rue Espoir 33000 BORDEAUX', 0, 'anquore', 'sylvie'),
(5, 5, 'Alain Decx', '3, rue de la Mise 01000 BOURG-en-BRESSE', 130, 'decx', 'alain'),
(6, 4, 'Tom POUCE', '18 rue billon 69100 villeurbanne', 200, 'tom', 'pouce'),
(7, 1, 'Sacha TOUILLE', '7 rue Guilli', 1, 'sacha', 'touille'),
(8, 2, 'Sarah CROCHE', '301 rue du téléphone', 453, 'sarah', 'croche');

--
-- Triggers `client`
--
DROP TRIGGER IF EXISTS `tbi_client`;
DELIMITER //
CREATE TRIGGER `tbi_client` BEFORE INSERT ON `client`
 FOR EACH ROW begin
	declare ck_client_pwd_auteur condition for sqlstate '45000';
	declare ck_client_pwd_login condition for sqlstate '45000';
	declare ck_client_credits condition for sqlstate '45000';
	if (length(new.pwd_client) < 4) then
		signal ck_client_pwd_auteur set message_text = 'ck_client_pwd_client : le mot de passe doit avoir au moins 4 caractères.';
	end if;
	if (new.pwd_client = new.login_client) then
		signal ck_client_pwd_login set message_text = 'ck_client_pwd_login : le mot de passe doit être différent du login.';
	end if;
	if (new.credits < 0) then
		signal ck_client_credits set message_text = 'ck_client_credits : Le crédit d'un compte ne peut pas être négatif.';
	end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tbu_client`;
DELIMITER //
CREATE TRIGGER `tbu_client` BEFORE UPDATE ON `client`
 FOR EACH ROW begin
	declare ck_client_pwd_auteur condition for sqlstate '45000';
	declare ck_client_pwd_login condition for sqlstate '45000';
	declare ck_client_credits condition for sqlstate '45000';
	if (length(new.pwd_client) < 4) then
		signal ck_client_pwd_auteur set message_text = 'ck_client_pwd_client : le mot de passe doit avoir au moins 4 caractères.';
	end if;
	if (new.pwd_client = new.login_client) then
		signal ck_client_pwd_login set message_text = 'ck_client_pwd_login : le mot de passe doit être différent du login.';
	end if;
	if (new.credits < 0) then
		signal ck_client_credits set message_text = 'ck_client_credits : Le crédit d'un compte ne peut pas être négatif.';
	end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `domaine`
--

CREATE TABLE IF NOT EXISTS `domaine` (
  `id_domaine` int(11) NOT NULL,
  `lib_domaine` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_domaine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `domaine`
--

INSERT INTO `domaine` (`id_domaine`, `lib_domaine`) VALUES
(1, 'Bases de données'),
(2, 'Langages'),
(3, 'Développement Internet'),
(4, 'Réseaux'),
(5, 'Systèmes d''exploitation'),
(6, 'Modélisation');

-- --------------------------------------------------------

--
-- Table structure for table `droits`
--

CREATE TABLE IF NOT EXISTS `droits` (
  `id_auteur` int(11) NOT NULL,
  `annee` year(4) NOT NULL,
  `trimestre` int(11) NOT NULL,
  `etat_droits` char(1) NOT NULL,
  `montants_droits` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id_auteur`,`annee`,`trimestre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `droits`
--
DROP TRIGGER IF EXISTS `tbi_droits`;
DELIMITER //
CREATE TRIGGER `tbi_droits` BEFORE INSERT ON `droits`
 FOR EACH ROW begin
	declare ck_droits_etat_droits condition for sqlstate '45000';
	if (new.etat_droits not in ('C','P')) then
		signal ck_droits_etat_droits set message_text = 'ck_droits_etat_droits : la colonne etat_droits doit contenir C ou P.';
	end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tbu_droits`;
DELIMITER //
CREATE TRIGGER `tbu_droits` BEFORE UPDATE ON `droits`
 FOR EACH ROW begin
	declare ck_droits_etat_droits condition for sqlstate '45000';
	if (new.etat_droits not in ('C','P')) then
		signal ck_droits_etat_droits set message_text = 'ck_droits_etat_droits : la colonne etat_droits doit contenir C ou P.';
	end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `parametre`
--

CREATE TABLE IF NOT EXISTS `parametre` (
  `id_parametre` char(10) NOT NULL,
  `val_parametre` int(11) DEFAULT NULL,
  `lib_parametre` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_parametre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parametre`
--

INSERT INTO `parametre` (`id_parametre`, `val_parametre`, `lib_parametre`) VALUES
('ARTICLE', 44, 'Dernier n° article'),
('AUTEUR', 12, 'Dernier n° auteur'),
('CATEGORIE', 6, 'Dernier n° catégorie'),
('CLIENT', 8, 'Dernier n° client'),
('DOMAINE', 6, 'Dernier n° domaine');

-- --------------------------------------------------------

--
-- Table structure for table `redige`
--

CREATE TABLE IF NOT EXISTS `redige` (
  `id_article` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `part` int(11) NOT NULL,
  PRIMARY KEY (`id_article`,`id_auteur`),
  KEY `fk_redige_auteur` (`id_auteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `redige`
--

INSERT INTO `redige` (`id_article`, `id_auteur`, `part`) VALUES
(1, 2, 100),
(2, 2, 50),
(2, 4, 25),
(2, 6, 25),
(3, 1, 100),
(4, 3, 100),
(5, 2, 50),
(5, 5, 50),
(6, 3, 30),
(6, 5, 70),
(7, 2, 100),
(8, 1, 20),
(8, 2, 10),
(8, 3, 40),
(8, 6, 30),
(9, 4, 100),
(10, 3, 25),
(10, 4, 75),
(11, 4, 100),
(12, 4, 100),
(13, 3, 100),
(14, 1, 100),
(15, 1, 100),
(16, 1, 50),
(16, 4, 50),
(17, 6, 100),
(18, 6, 100),
(19, 6, 100),
(20, 2, 100),
(21, 2, 100),
(22, 4, 100),
(23, 4, 100);

--
-- Triggers `redige`
--
DROP TRIGGER IF EXISTS `tbi_redige`;
DELIMITER //
CREATE TRIGGER `tbi_redige` BEFORE INSERT ON `redige`
 FOR EACH ROW begin
	declare ck_redige_part condition for sqlstate '45000';
	if (new.part < 1 || new.part > 100) then
		signal ck_redige_part set message_text = 'ck_redige_part : la part d'un auteur doit être comprise entre 1 et 100.';
	end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tbu_redige`;
DELIMITER //
CREATE TRIGGER `tbu_redige` BEFORE UPDATE ON `redige`
 FOR EACH ROW begin
	declare ck_redige_part condition for sqlstate '45000';
	if (new.part < 1 || new.part > 100) then
		signal ck_redige_part set message_text = 'ck_redige_part : la part d'un auteur doit être comprise entre 1 et 100.';
	end if;
end
//
DELIMITER ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achete`
--
ALTER TABLE `achete`
  ADD CONSTRAINT `fk_achete_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `fk_achete_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_domaine` FOREIGN KEY (`id_domaine`) REFERENCES `domaine` (`id_domaine`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_client_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Constraints for table `droits`
--
ALTER TABLE `droits`
  ADD CONSTRAINT `fk_droits_auteur` FOREIGN KEY (`id_auteur`) REFERENCES `auteur` (`id_auteur`);

--
-- Constraints for table `redige`
--
ALTER TABLE `redige`
  ADD CONSTRAINT `fk_redige_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `fk_redige_auteur` FOREIGN KEY (`id_auteur`) REFERENCES `auteur` (`id_auteur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
