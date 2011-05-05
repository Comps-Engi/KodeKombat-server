-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: dge
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bot`
--

DROP TABLE IF EXISTS `bot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bot` (
  `botID` int(10) NOT NULL AUTO_INCREMENT,
  `filesize` int(30) NOT NULL,
  `filetype` varchar(10) NOT NULL,
  `contestantID` int(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` blob NOT NULL,
  `sflag` int(11) DEFAULT NULL,
  `rflag` int(11) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `Q` double DEFAULT NULL,
  PRIMARY KEY (`botID`),
  KEY `contestantID` (`contestantID`),
  CONSTRAINT `bot_ibfk_1` FOREIGN KEY (`contestantID`) REFERENCES `contestant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bot`
--

LOCK TABLES `bot` WRITE;
/*!40000 ALTER TABLE `bot` DISABLE KEYS */;
INSERT INTO `bot` VALUES (20,275,'text/x-c++',2,'2011-03-21 07:33:02','#include<iostream> \n#include<fstream> \n#include<string.h> \n#include<stdlib.h> \nusing namespace std; \nint main(int argc, char* argv[]){	fstream f;	if(strcmp(argv[1],\"1\")==0)		f.open(\"arena\",ios::out);	else		f.open(\"arena\",ios::out | ios::app);	f<<\"6\n\";	f.close();	return 0;}',1,NULL,21,2406,1065368.86366756),(21,275,'text/x-c++',3,'2011-03-21 10:01:47','#include<iostream> \n#include<fstream> \n#include<string.h> \n#include<stdlib.h> \nusing namespace std; \nint main(int argc, char* argv[]){	fstream f;	if(strcmp(argv[1],\"1\")==0)		f.open(\"arena\",ios::out);	else		f.open(\"arena\",ios::out | ios::app);	f<<\"6\n\";	f.close();	return 0;}',1,NULL,26,2491,1757923.61395869),(22,274,'text/x-c++',4,'2011-03-21 10:07:05','#include<iostream> \n#include<fstream> \n#include<string.h> \n#include<stdlib.h> \nusing namespace std; \nint main(int argc, char* argv[]){	fstream f;	if(strcmp(argv[1],\"1\")==0)		f.open(\"arena\",ios::out);	else		f.open(\"arena\",ios::out | ios::app);	f<<\"5\\n\";	f.close();	return 0;}',1,NULL,92,2552,2304092.97605585),(23,274,'text/x-c++',5,'2011-03-21 11:18:17','#include<iostream> \n#include<fstream> \n#include<string.h> \n#include<stdlib.h> \nusing namespace std; \nint main(int argc, char* argv[]){	fstream f;	if(strcmp(argv[1],\"1\")==0)		f.open(\"arena\",ios::out);	else		f.open(\"arena\",ios::out | ios::app);	f<<\"5\n\";	f.close();	return 0;}',1,NULL,21,2551,2317394.64996849);
/*!40000 ALTER TABLE `bot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contestant`
--

DROP TABLE IF EXISTS `contestant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contestant` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` bigint(12) DEFAULT NULL,
  `uname` varchar(10) NOT NULL,
  `passwd` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contestant`
--

LOCK TABLES `contestant` WRITE;
/*!40000 ALTER TABLE `contestant` DISABLE KEYS */;
INSERT INTO `contestant` VALUES (1,'Harini','abc@xyz.com',2147483647,'harini','ûá•ªÃœ±'),(2,'George','george@gmail.com',9876543210,'george','ã/â&Ñ'),(3,'Abhinav','abhinav@gmail.com',9876543210,'abhinav','|´M´'),(4,'Niloy Gupta','niloy@gmail.com',9876543210,'niloy1','bý‡×Ý_'),(5,'Harini','harinijc@gmail.com',9876543210,'harini1','çœ¤]Ã)');
/*!40000 ALTER TABLE `contestant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `contestantID1` int(10) DEFAULT NULL,
  `contestantID2` int(10) DEFAULT NULL,
  `matchid` int(10) DEFAULT NULL,
  `trace` mediumblob,
  `result` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` VALUES (100,200,300,'This is a trace',''),(5,6,10,'bot2.cpp wins','\0'),(5,6,301,'bot2.cpp wins','\0'),(20,20,301,'bot2.cpp wins','\0'),(20,20,305,'bot2.cpp wins','\0'),(1,21,304,'bot2.cpp wins','\0'),(20,20,306,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,307,'bot2.cpp wins','\0'),(21,22,308,'bot2.cpp wins','\0'),(20,21,309,'bot2.cpp wins','\0'),(21,22,310,'bot2.cpp wins','\0'),(21,22,312,'bot2.cpp wins','\0'),(21,22,313,'bot2.cpp wins','\0'),(21,22,318,'bot2.cpp wins','\0'),(21,22,319,'bot2.cpp wins','\0'),(21,22,320,'bot2.cpp wins','\0'),(21,22,321,'bot2.cpp wins','\0'),(21,22,325,'bot2.cpp wins','\0'),(21,22,326,'bot2.cpp wins','\0'),(20,21,327,'bot2.cpp wins','\0'),(20,22,308,'bot2.cpp wins','\0'),(20,22,309,'bot2.cpp wins','\0'),(20,21,329,'bot2.cpp wins','\0'),(20,22,331,'bot2.cpp wins','\0'),(20,21,332,'bot2.cpp wins','\0'),(22,21,334,'bot2.cpp wins','\0'),(20,23,333,'bot2.cpp wins','\0'),(20,23,1,'bot2.cpp wins','\0'),(22,21,2,'bot2.cpp wins','\0'),(22,21,4,'bot2.cpp wins','\0'),(20,23,3,'bot2.cpp wins','\0'),(22,21,5,'bot2.cpp wins','\0'),(20,23,6,'bot2.cpp wins','\0'),(22,21,7,'bot2.cpp wins','\0'),(20,23,10,'bot2.cpp wins','\0'),(22,21,11,'bot2.cpp wins','\0'),(20,23,12,'bot2.cpp wins','\0'),(23,22,16,'bot2.cpp wins','\0'),(20,21,15,'bot2.cpp wins','\0'),(20,21,18,'bot2.cpp wins','\0'),(21,22,21,'bot2.cpp wins','\0'),(20,23,20,'bot2.cpp wins','\0'),(21,22,22,'bot2.cpp wins','\0'),(21,22,24,'bot2.cpp wins','\0'),(20,23,23,'bot2.cpp wins','\0'),(21,22,25,'bot2.cpp wins','\0'),(20,23,26,'bot2.cpp wins','\0'),(21,22,340,'bot2.cpp wins','\0'),(21,22,341,'bot2.cpp wins','\0'),(21,22,342,'bot2.cpp wins','\0'),(21,22,343,'bot2.cpp wins','\0'),(21,22,344,'bot2.cpp wins','\0'),(20,23,339,'bot2.cpp wins','\0');
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-05-04 10:38:43
