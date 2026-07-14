CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `admins` VALUES
(1,'admin-mySYK','$2a$10$cHXnZvuzF0z0a8K47bp.retOCxoAVE76YK9pCjGcWDdavcxlgkfY.');


CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `blog_posts` VALUES
(1,'Welcome Post','This is a sample blog post content.',NULL);


CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `images` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `size` text DEFAULT NULL,
  `price` text DEFAULT NULL,
  `rooms` text DEFAULT NULL,
  `masterBedrooms` text DEFAULT NULL,
  `bedrooms` text DEFAULT NULL,
  `bathrooms` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `facebookPost` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


INSERT INTO `properties` VALUES
(1,'SampleProperty',NULL,'City',NULL,'100000',NULL,NULL,NULL,NULL,NULL,NULL);
