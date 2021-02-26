-- MariaDB dump 10.17  Distrib 10.4.15-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: website
-- ------------------------------------------------------
-- Server version	10.4.15-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


USE `website`;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20210208230750','2021-02-26 13:50:46',25),('DoctrineMigrations\\Version20210208230934','2021-02-26 13:50:49',23),('DoctrineMigrations\\Version20210213123954','2021-02-26 13:50:50',21);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,'Tempora accusamus et alias earum.','tempora-accusamus-et-alias-earum','Suscipit voluptas in aut temporibus et. Deserunt et culpa dolore dolores voluptatem. Libero error minima tenetur molestiae atque dolores. Qui maxime cum adipisci et explicabo.','https://picsum.photos/id/10/300/200'),(2,'Ut et expedita quam totam molestiae.','ut-et-expedita-quam-totam-molestiae','Architecto fuga ut rem voluptatem sint. Sequi voluptas illum soluta nulla dolor soluta ducimus. Veniam eos eveniet esse non accusantium repellendus. Numquam nemo adipisci aliquid.','https://picsum.photos/id/11/300/200'),(3,'Ut dignissimos autem fugit.','ut-dignissimos-autem-fugit','Corrupti ex aut eos doloremque veritatis. Voluptas magnam non sequi qui. Minima et magni nemo optio praesentium. Et accusamus ut quis rerum magni repellat. Iure fuga molestias qui voluptates.','https://picsum.photos/id/12/300/200'),(4,'Labore culpa aut fuga non.','labore-culpa-aut-fuga-non','A eum id nesciunt quasi commodi. Eum aliquid rem aut et animi. Omnis maxime eum quo delectus quidem sequi deserunt.','https://picsum.photos/id/13/300/200'),(5,'Numquam dolorem earum sequi et odit.','numquam-dolorem-earum-sequi-et-odit','Quo quia voluptatem perspiciatis dolores. Hic eum quibusdam corrupti cupiditate illo. Sed sint veritatis commodi eum qui id. Voluptatum magni fuga neque explicabo. Nisi optio dolore tempore quam.','https://picsum.photos/id/14/300/200'),(6,'Quas qui quos totam.','quas-qui-quos-totam','Sit et suscipit sunt quae. Sunt vel sint quasi debitis. Ducimus quos omnis labore voluptas. Non et et amet pariatur officiis neque minima.','https://picsum.photos/id/15/300/200'),(7,'Excepturi quo autem voluptate.','excepturi-quo-autem-voluptate','Sequi impedit repudiandae accusamus rerum. Culpa sunt dolorem aliquam qui adipisci sunt temporibus. Et porro voluptatem quia consectetur aliquid rerum quo. Consequatur incidunt asperiores iste consectetur exercitationem quia quia.','https://picsum.photos/id/16/300/200'),(8,'Omnis animi id mollitia aliquam.','omnis-animi-id-mollitia-aliquam','Hic aut sint aut minus. Est qui dolores delectus nihil. Voluptatibus quas quia et sit non ex dolor. Harum cupiditate tenetur corporis qui et sint consequatur et.','https://picsum.photos/id/17/300/200'),(9,'Atque ut earum aut ducimus.','atque-ut-earum-aut-ducimus','Maxime est esse saepe. Sed ipsam et praesentium aut. Veniam et et ut qui.','https://picsum.photos/id/18/300/200'),(10,'A molestiae soluta quo culpa quia.','a-molestiae-soluta-quo-culpa-quia','Voluptatem totam sed aut dolores atque ut autem. Ipsa dignissimos blanditiis beatae. Sed quos dignissimos sint sint aut cumque laudantium. Natus velit blanditiis maiores ullam quia.','https://picsum.photos/id/19/300/200'),(11,'Praesentium quae laboriosam tempore provident.','praesentium-quae-laboriosam-tempore-provident','Iure consectetur fugiat nisi perspiciatis culpa maiores numquam. Adipisci ullam quae qui perferendis voluptatem. Id et quo facere quia est in aut. Tenetur et recusandae quod voluptatem eos sint molestiae.','https://picsum.photos/id/20/300/200'),(12,'Eveniet magnam cumque necessitatibus rem voluptas.','eveniet-magnam-cumque-necessitatibus-rem-voluptas','Qui eius odit recusandae nihil molestiae. Consequatur voluptatem incidunt nam occaecati. Odit vitae sed qui esse ducimus sint hic aliquam. Ratione esse quae exercitationem et.','https://picsum.photos/id/21/300/200'),(13,'Sint ut autem autem rerum at quo.','sint-ut-autem-autem-rerum-at-quo','Officia vel et sint dolor. Culpa sint voluptatem consequatur. Dolores aut et et tempore explicabo reiciendis rerum. Nulla numquam in dolorem nulla.','https://picsum.photos/id/22/300/200'),(14,'Est ut dolorem libero.','est-ut-dolorem-libero','Quae quod facilis repellat voluptatem rerum tempore voluptatem. Quia laboriosam nobis totam molestias sed in. Aliquid ut est et omnis repellendus. Quod aut hic id ut occaecati debitis corrupti cum.','https://picsum.photos/id/23/300/200'),(15,'Voluptatem rerum eveniet rerum dicta.','voluptatem-rerum-eveniet-rerum-dicta','Qui et fugiat laudantium placeat voluptatum blanditiis reiciendis. Ratione commodi veritatis et saepe voluptas consequuntur odio. Maxime illo tempore voluptatum harum.','https://picsum.photos/id/24/300/200'),(16,'Officiis velit animi eum.','officiis-velit-animi-eum','Quisquam et ad praesentium qui incidunt veniam ut dolor. Molestiae quibusdam et minima laboriosam.','https://picsum.photos/id/25/300/200'),(17,'Autem amet eligendi qui.','autem-amet-eligendi-qui','Sit labore natus optio deleniti. Voluptatem molestiae ut rerum iste dolor eaque asperiores. Ullam consequatur nostrum dolorem.','https://picsum.photos/id/26/300/200'),(18,'Sed incidunt mollitia consectetur rerum omnis commodi.','sed-incidunt-mollitia-consectetur-rerum-omnis-commodi','Pariatur ut ullam totam. Quibusdam error reiciendis harum similique voluptatem non consequatur. Reprehenderit magnam nihil voluptatibus rerum eaque animi.','https://picsum.photos/id/27/300/200'),(19,'Nisi consequatur quo officia voluptate.','nisi-consequatur-quo-officia-voluptate','Eligendi nemo iusto itaque tenetur sed incidunt modi sit. Fugiat voluptate quo placeat odio labore atque sunt. Voluptas quia qui explicabo ipsam.','https://picsum.photos/id/28/300/200'),(20,'Dignissimos placeat repellendus possimus unde cupiditate libero.','dignissimos-placeat-repellendus-possimus-unde-cupiditate-libero','Harum ipsa non asperiores fugit quos aut beatae. Sit voluptatem illum veniam dolor.','https://picsum.photos/id/29/300/200');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649D17F50A6` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$utVswbkKAQCVIciZ3vQaOw$nxgv6R0C4lPMWwoH/AFMSYkj2PN2U65KnCBpCmIPA0w','admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-26 13:56:49
