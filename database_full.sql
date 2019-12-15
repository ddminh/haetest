/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.8-MariaDB : Database - haetest
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `status` ENUM('active','deleted','edited') COLLATE utf8_unicode_ci DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `messages` */

insert  into `messages`(`id`,`name`,`email`,`message`,`created_at`,`status`) values (4,'Tran Thi Hoang Anh','hatran@gmail.com','truong em mai ngoi do tuoi\nCo hang dam but','2019-12-14 02:13:06','active'),(15,'Tran Thanh Nghia','ddminh.sion@gmail.com','Lầu Năm Góc lên án \"nỗ lực trơ trẽn\" phá hoại chủ quyền lãnh thổ láng giềng của Trung Quốc và xếp Bắc Kinh vào ưu tiên quân sự hàng đầu.','2019-12-14 06:43:30','active'),(17,'Minh','ddminh.sion@gmail.com','ĐH Kinh doanh và Công nghệ Hà Nội cảnh cáo Ban chủ nhiệm khoa Trung - Nhật, Chủ nhiệm khoa Bùi Văn Thanh vì dùng giáo trình có bản đồ \"đường lưỡi bò\".','2019-12-14 06:51:20','active'),(19,'Janie Jones','janie@gmail.com','Nemo enim ispam voluptatem quia vlptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui.','2019-12-14 08:37:41','active'),(20,'Nguyen Thi Cam Thuyen','thuyen@yahoo.com','Nemo enim ispam voluptatem quia vlptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui.','2019-12-14 08:47:50','active'),(21,'Tran Thanh Nghia','nghia@gmail.com','Sau nhiều ngày duy trì mức độ ô nhiễm không khí ở thang màu tím nguy hại cho sức khỏe con ngườ','2019-12-14 08:48:46','active'),(22,'Do Duc Minh','minh@gmail.com','Các trang tin tức của Trung Quốc đưa tin, ngày 30/12 năm nay sẽ là tròn 16 năm diva đình đám Mai Diễm Phương qua đời. \"Đến hẹn lại lên\", những ngày này, bà Đàm Mỹ Kim Do Duc Minh','2019-12-14 08:49:19','active'),(23,'Janie Jones','jones@gmail.com','Nemo enim ispam voluptatem quia vlptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui.\n\n','2019-12-14 05:06:16','active'),(24,'Janie Jones','janies@gmail.com','Nemo enim ispam voluptatem quia vlptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui.\n\n','2019-12-14 05:07:38','active'),(25,'abc','abc@gmail.com','abc','2019-12-14 05:14:07','deleted');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`password`,`created_at`,`email`) values (1,'admin','$2y$10$Ck9O52vCrc9cnFm6lvgme.FYcCNZOqHaj2pVhFPGHkxGuMky3KKdG','2019-12-14 22:08:09','admin@gmail.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
