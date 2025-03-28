-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: alumni
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `comm_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `comment_text` text,
  `parent_comment_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comm_id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  KEY `parent_comment_id` (`parent_comment_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`comm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_information`
--

DROP TABLE IF EXISTS `contact_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_information` (
  `contact_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `linkedin_profile` varchar(255) DEFAULT NULL,
  `github_profile` varchar(255) DEFAULT NULL,
  `portfolio` varchar(255) DEFAULT NULL,
  `profile_visibility` enum('Public','Private') DEFAULT 'Public',
  `contact_visibility` enum('Visible','Only Admins','Hidden') DEFAULT 'Visible',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_information`
--

LOCK TABLES `contact_information` WRITE;
/*!40000 ALTER TABLE `contact_information` DISABLE KEYS */;
INSERT INTO `contact_information` VALUES (1,1,'9874563210','http://localhost/alumni_project/users/contact_info.html','http://localhost/alumni_project/users/contact_info.html','http://localhost/alumni_project/users/contact_info.html','Private','Only Admins');
/*!40000 ALTER TABLE `contact_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_profile_curr`
--

DROP TABLE IF EXISTS `job_profile_curr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_profile_curr` (
  `job_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `work_experience` int DEFAULT NULL,
  `skills` text,
  `projects` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_profile_curr`
--

LOCK TABLES `job_profile_curr` WRITE;
/*!40000 ALTER TABLE `job_profile_curr` DISABLE KEYS */;
INSERT INTO `job_profile_curr` VALUES (1,1,'devops Engineer','TCS','IT',3,'were','rewe','2025-03-04 10:12:38'),(3,1,'Software Engineer','dxjjt','bvc',3,'vghn','cvgfc','2025-03-04 10:16:05');
/*!40000 ALTER TABLE `job_profile_curr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `like_id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `l` int DEFAULT NULL,
  `d` int DEFAULT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (14,3,1,1,0),(15,4,1,0,1),(16,2,1,1,0),(17,1,1,NULL,1),(18,4,2,0,1);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_type` enum('text','image') DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `media_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,NULL,'text','Achievement','hii hello my name is patrick. I am a boy. i like to play bgmi, cricket. I am 21 years old. HIIII',NULL,'2025-03-06 09:50:35'),(2,NULL,'image','Achievement','hii hello my name is patrick. I am a boy. i like to play bgmi, cricket. I am 21 years old. HIIII',NULL,'2025-03-06 09:56:45'),(3,NULL,'image','Achievement','hii hello my name is patrick. I am a boy. i like to play bgmi, cricket. I am 21 years old. HIIII',NULL,'2025-03-06 09:58:27'),(4,NULL,'image','Achievement','hii hello my name is patrick. I am a boy. i like to play bgmi, cricket. I am 21 years old. HIIII','','2025-03-06 10:00:03');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info1`
--

DROP TABLE IF EXISTS `user_info1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info1` (
  `user_info_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `profile_pic_name` varchar(50) DEFAULT NULL,
  `profile_pic_path` varchar(250) DEFAULT NULL,
  `bio` text,
  `graduation_year` year NOT NULL,
  `course_degree` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `u_email` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`user_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info1`
--

LOCK TABLES `user_info1` WRITE;
/*!40000 ALTER TABLE `user_info1` DISABLE KEYS */;
INSERT INTO `user_info1` VALUES (1,'dummy','2003-11-14','Other','acc3.jpg','uploads/1741078137_acc3.jpg','oyee',2022,'abc','abc','2025-02-20 06:46:22','abc@gmail.com',NULL),(2,'ritu gaikwad','2025-02-01','Female',NULL,NULL,'oyeeee',1902,'Msc','Gym','2025-02-25 08:52:14','pratik@gmail.com',NULL),(3,'pratik','2025-02-11','Male','acc1.jpg','uploads/1740474764_acc1.jpg','ddd',2024,'Msc','Gym','2025-02-25 09:12:48','pratik@gmail.com',NULL),(4,'pratik Dhamal','2025-02-11','Male','acc1.jpg','uploads/1740478285_acc1.jpg','ddd',2024,'Msc','Gym','2025-02-25 10:11:37','pratik@gmail.com',NULL),(5,'abc','2025-02-05','Female','advertisementimg.jpg','uploads/1740478539_advertisementimg.jpg','dsdfa',1908,'sdf','sdf','2025-02-25 10:20:31','pratik@gmail.com',NULL),(6,'pratik','2025-02-07','Female','acc3.jpg','uploads/1740639254_acc3.jpg','asdfa',1914,'Msc','Gym','2025-02-27 06:54:25','pratik@gmail.com',NULL);
/*!40000 ALTER TABLE `user_info1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_prn` varchar(10) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `batch_year` year NOT NULL,
  `month_section` enum('February','August') NOT NULL,
  `username` varchar(15) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_prn` (`user_prn`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1234567890','Ritu Gaikwad','ritugaikwad@gmail.com',2024,'February','ritu0803','$2y$10$4DDhNiN6nvsgl31ZVSoRV.imymz5e5xMnyc3oqNJuEF0W4BfhsCw6','2025-02-20 06:42:43',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-28 13:56:09
