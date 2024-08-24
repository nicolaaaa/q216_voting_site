DROP TABLE IF EXISTS `survey_results`;

CREATE TABLE `survey_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_negative_votes` bigint(20) NOT NULL DEFAULT '0',
  `num_total_votes` bigint(20) NOT NULL DEFAULT '0',
  `sid` varchar(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `survey_results` (image_name, num_negative_votes, num_total_votes, sid) VALUES ('05-28.jpg',1,1,'hj'),('02-21.jpg',1,1,'dh');



