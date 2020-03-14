-- MariaDB dump 10.17  Distrib 10.4.12-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: simple-mvc-blog
-- ------------------------------------------------------
-- Server version	10.4.12-MariaDB

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

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `publicationDate` date NOT NULL,
  `categoryId` smallint(5) unsigned NOT NULL,
  `subcategoryId` smallint(5) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` mediumtext NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `subcategoryID` (`subcategoryId`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`subcategoryId`) REFERENCES `subcategories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (36,'2017-06-21',11,NULL,'Первопроходцы ','Это статья - первопроходец','Первопроходец - человек(или статья), проложивший новые пути, открывший новые земли',1),(40,'2020-03-09',12,14,'Маппинг данных из реляционной БД','Иногда возникают ситуации, когда решение задачи выборки данных из реляционной БД не укладывается в возможности используемой в проекте ОРМ, например, либо из-за недостаточной скорости работы самой ОРМ, либо не совсем оптимальных SQL запросов генерируемых ею. В таком случае обычно приходится писать запросы вручную.','Иногда возникают ситуации, когда решение задачи выборки данных из реляционной БД не укладывается в возможности используемой в проекте ОРМ, например, либо из-за недостаточной скорости работы самой ОРМ, либо не совсем оптимальных SQL запросов генерируемых ею. В таком случае обычно приходится писать запросы вручную.\r\nПроблема в том, что данные из БД (в т.ч. в ответ на JOIN запрос) возвращаются в виде “плоского” двухмерного массива никак не отражающего сложную “древовидную” структуру данных приложения. Работать с таким массивом дальше крайне неудобно, поэтому требуется более-менее универсальное решение, позволяющее привести этот массив в более подходящий вид по заданному шаблону.\r\nРешение было найдено, удобное и достаточно быстрое.\r\nНа сколько быстрое\r\nДля оценки скорости работы библиотеки я собрал небольшой испытательный стенд на котором скорость работы моей библиотеки сравнивается со скоростью работы Eloquent. Для замеров использовался пакет phpbench.\r\nДля того чтобы развернуть стенд у себя:\r\ngit clone https://github.com/hrustbb2/env-arrayproc-bench.git<br />\r\ncd env-arrayproc-bench<br />\r\n./env\r\nЗдесь я использовал инструмент описанный в моей предыдущей статье.\r\nЗатем в меню выбираем: 1 Develop, затем: 1 Build, затем 2 Deploy and Up;\r\nЗатем запускаем тесты 5. Run tests\r\nВ базе 3000 книг. Результаты получились следующие:\r\n+-----------------+-----+------+------+-------------+--------------+<br />\r\n| subject         | set | revs | iter | mem_peak    | time_rev     |<br />\r\n+-----------------+-----+------+------+-------------+--------------+<br />\r\n| benchEloquent   | 0   | 1    | 0    | 76,442,912b | 12,781.612ms |<br />\r\n| benchEloquentId | 0   | 10   | 0    | 5,123,224b  | 16.432ms     |<br />\r\n| benchProc       | 0   | 1    | 0    | 36,364,176b | 1,053.937ms  |<br />\r\n| benchProcId     | 0   | 10   | 0    | 4,462,696b  | 7.684ms      |<br />\r\n+-----------------+-----+------+------+-------------+--------------+<br />\r\n\r\nbenchEloquent — вытаскивает все книги с авторами с использованием Eloquent\r\nbenchEloquentId — вытаскивает определенную книгу с авторами с использованием Eloquent (10 раз)\r\nbenchProc — вытаскивает все книги с авторами с использованием библиотеки\r\nbenchProcId — вытаскивает определенную книгу с авторами с использованием библиотеки (10 раз)\r\nВозможно приведенные тесты недостаточно репрезентативны, но разница заметна, как по времени выполнения, так и по расходованию памяти.\r\n',0),(41,'2020-03-09',11,19,'Почему ICQ потерял древнего пользователя после покупки Mail.Ru','История о том как я внезапно потерял свой элитный 5* ICQ\r\nпросто потому что Mail.Ru выкатили обновление!','Пишу сюда поскольку тут сидят представители Mail.Ru Group и возможно они что-то с этой несуразной чепухой в логике работы их клиента ICQ да сделают. Ведь то что попросту может без предупреждения уничтожить твой драгоценный номер «аськи», что ты годами хранил и все контакты в нём — безвозвратно исчезают, а ведь там у меня была огромная база людей с подписями о умениях каждого в имени контакта. Труда не мерено было… переписки… важная информация, недостаток которой чувствую до сих пор головной болью. В общем то вся суть в паре писем<br />\r\nХочется описать это как можно короче, и привести сразу переписку с тех.поддержкой...<br />\r\nКакие выводы я сделал лично для себя: данная «поддержка» абсолютно не отвечает на прямо поставленный вопрос, игнорируя его. Зачем она нужна?',1),(43,'2020-03-09',0,NULL,'sadg','sadfg','adfsg',0),(44,'2020-03-09',12,14,'Маппинг данных из реляционной БД New','Иногда возникают ситуации, когда решение задачи выборки данных из реляционной БД не укладывается в возможности используемой в проекте ОРМ','Иногда возникают ситуации, когда решение задачи выборки данных из реляционной БД не укладывается в возможности используемой в проекте ОРМ, например, либо из-за недостаточной скорости работы самой ОРМ, либо не совсем оптимальных SQL запросов генерируемых ею. В таком случае обычно приходится писать запросы вручную.\r\nПроблема в том, что данные из БД (в т.ч. в ответ на JOIN запрос) возвращаются в виде “плоского” двухмерного массива никак не отражающего сложную “древовидную” структуру данных приложения. Работать с таким массивом дальше крайне неудобно, поэтому требуется более-менее универсальное решение, позволяющее привести этот массив в более подходящий вид по заданному шаблону.\r\nРешение было найдено, удобное и достаточно быстрое.\r\nНа сколько быстрое\r\nДля оценки скорости работы библиотеки я собрал небольшой испытательный стенд на котором скорость работы моей библиотеки сравнивается со скоростью работы Eloquent. Для замеров использовался пакет phpbench.',1),(45,'2020-03-10',11,NULL,'Обманувшего Пугачеву на миллионы долларов банкира выпустили из «Бутырки»','Мера пресечения в виде ареста в отношении Рафановича была отменена, что и стало причиной освобождения.','Из московского следственного изолятора «Бутырка» во вторник, 10 марта, выпущен российский банкир Олег Рафанович. Об этом «Ленте.ру» сообщил источник в правоохранительных органах.\r\nПо его словам, мера пресечения в виде ареста в отношении Рафановича была отменена, что и стало причиной освобождения.\r\nАдвокаты банкира Андрей Белоусов и Сергей Жицкий от комментариев отказались. Официального подтверждения «Ленте.ру» пока не поступало.\r\nВладелец банка «Сенатор» Олег Рафанович был объявлен в международный розыск в 2015 году. В 2017-м решением суда он был заочно арестован по обвинениям в растрате в особо крупном размере – по версии следствия, в 2007-2008 годах более 38 миллионов рублей были выданы в кредит множеству фирм-однодневок, аффилированных с ним, что и привело к краху банка. Иски агентства по страхованию вкладов значительно больше – 826 миллионов рублей, они по-прежнему не удовлетворены.\r\nВ 2017 году Олег Рафанович был задержан в Словении, а в октябре 2019-го в сопровождении сотрудников Интерпола выдан Российской Федерации.\r\nСкандальную известность Олег Рафанович получил в середине нулевых – он взял у Аллы Пугачевой более 6 миллионов долларов и не вернул их. Адвокаты певицы обратились в суд, и имущество банкира было арестовано и реализовано.',1);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles_users`
--

DROP TABLE IF EXISTS `articles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_users` (
  `article_id` smallint(5) unsigned NOT NULL,
  `user_id` smallint(6) NOT NULL,
  PRIMARY KEY (`article_id`,`user_id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles_users`
--

LOCK TABLES `articles_users` WRITE;
/*!40000 ALTER TABLE `articles_users` DISABLE KEYS */;
INSERT INTO `articles_users` VALUES (36,30),(36,31),(40,26),(40,30),(43,32),(44,30),(45,31);
/*!40000 ALTER TABLE `articles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (11,'Common','About all'),(12,'Backend','All about backend and...'),(15,'Frontend','All about Frontend');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryId` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`categoryId`),
  CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (12,'HTML','HTML (от англ. HyperText Markup Language — «язык гипертекстовой разметки») — стандартизированный язык разметки документов во Всемирной паутине. Большинство веб-страниц содержат описание разметки на языке HTML (или XHTML).',15),(13,'CSS','CSS (Cascading Style Sheets) — язык таблиц стилей, который позволяет прикреплять стиль (например, шрифты и цвет) к структурированным документам (например, документам HTML и приложениям XML).',15),(14,'PHP','PHP (англ. PHP: Hypertext Preprocessor — «PHP: препроцессор гипертекста»; первоначально Personal Home Page Tools[13] — «Инструменты для создания персональных веб-страниц») — скриптовый язык общего назначения, интенсивно применяемый для разработки веб-приложений.',12),(15,'Kotlin','Kotlin (Ко́тлин) — статически типизированный язык программирования, работающий поверх Java Virtual Machine и разрабатываемый компанией JetBrains. Также компилируется в JavaScript и в исполняемый код ряда платформ через инфраструктуру LLVM. Язык назван в честь острова Котлин в Финском заливе, на котором расположен город Кронштадт.',12),(16,' Политика','Поли́тика (др.-греч. πολιτική «государственная деятельность») — деятельность органов государственной власти и их должностных лиц; а также вопросы и события общественной жизни, связанные с функционированием государства. Научное изучение политики ведётся в рамках политологии.',11),(17,'Котики','Изображения и видео с домашними кошками (жарг. ко́тэ́) — один из самых просматриваемых видов контента в Интернете, в частности крайне популярны макросы в жанре lolcat. ThoughtCatalog называет кошек «неофициальным талисманом Интернета».',11),(19,'IT/Internet','Разное об IT/Internet',11);
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` date NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` int(11) NOT NULL,
  `role` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (26,'Mery','$2y$10$YyvPebNkLg90fkx1w/NIdOF62nJ.LgOU5VhcL4LPDd/hvXmOg0NKG','2017-08-01','email@rrt',426915,'auth_user'),(30,'admin','$2y$10$pZFOjksKoy9zS0T.6w3Ll.07kvWgaV6qSXr/n5V0cu5HHR6TkXy9i','2018-07-04','admin@admin.admin',716953,'admin'),(31,'surrok','$2y$10$dO/BUnWyrsfqhpXVDdnZbeaW0Sn50eAWfGptUCncG6zh7YZlmi5Wa','2020-03-06','s6@mail.ru',633226,'admin'),(32,'boomer','$2y$10$kPPHOER10lAc856aguMh2.7Lp8BuRiwImtv8Xo48bPCXCi2ArlgWO','2020-03-07','b1@mail.ru',656786,'auth_user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'simple-mvc-blog'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-11  9:25:57
