-- MySQL dump 10.13  Distrib 5.5.52, for Linux (x86_64)
--
-- Host: localhost    Database: ttpco_toptenpercent_test
-- ------------------------------------------------------
-- Server version	5.5.52-cll
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'ttpco_toptenpercent_test'
--
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE FUNCTION `CoordinateDistanceMiles`(`latitude1` float,`longitude1` float,`latitude2` float,`longitude2` float) RETURNS float
BEGIN
	#Routine body goes here...

	RETURN acos( cos( radians(latitude2) ) * cos( radians( latitude1 ) ) * cos( radians( longitude1 ) - radians(longitude2) ) + sin( radians(latitude2) ) * sin( radians( latitude1 ) ) ) * 3963.1 ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE PROCEDURE `calculateInitialValues`()
BEGIN
	
	update promos as p inner join (select * from vw_promos) as vp on p.id = vp.id set p.totalSignedUp = vp.totalSignedUp, p.totalActivated = vp.totalActivated;

	update zipcodes as z inner join (select count(id) as users, zipcode from users where isDeleted = 0 group by zipcode) as u on z.zipcode = u.zipcode set z.totalUsers = u.users;

	update zipcodes as z inner join (select count(id) as users, zipcode from users where isDeleted = 0 and isActivated = 1 group by zipcode) as u on z.zipcode = u.zipcode set z.totalActivatedUsers = u.users;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-23 22:31:07


DELIMITER $$
DROP PROCEDURE IF EXISTS proc_loop_test$$
CREATE PROCEDURE proc_loop_test()
BEGIN
DECLARE p1 int DEFAULT 0;
 label1: LOOP
    SET p1 = p1 + 1;
		IF EXISTS (SELECT * FROM businesses WHERE id = p1) THEN
			INSERT INTO logoimages VALUES(p1, CONCAT('/Images/logos/', p1, '.png'), now());
		END IF;

    IF p1 < 602 THEN
      ITERATE label1;
    END IF;
    LEAVE label1;
  END LOOP label1;
END;

