/*
SQLyog Ultimate v12.09 (32 bit)
MySQL - 10.1.38-MariaDB : Database - crud
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`crud` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `crud`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `cat_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(200) NOT NULL,
  `cat_description` varchar(200) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`cat_id`,`cat_name`,`cat_description`) values (1,'Acer','Acer'),(2,'Asus','Asus'),(3,'HP','HP'),(4,'Dell','Dell'),(5,'Lenovo','Lenovo'),(6,'Msi','Msi'),(7,'Toshiba','Toshiba');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `pay_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(200) NOT NULL,
  `pay_description` varchar(200) NOT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `payments` */

insert  into `payments`(`pay_id`,`pay_name`,`pay_description`) values (1,'Finpay','Finpay'),(2,'Ipaymu','Ipaymu'),(3,'Veritrans','Veritrans'),(4,'Doku','Doku');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `prod_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_description` varchar(200) NOT NULL,
  `prod_image` varchar(200) NOT NULL,
  `prod_price` float NOT NULL,
  `prod_created` datetime DEFAULT NULL,
  `prod_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `products` */

insert  into `products`(`prod_id`,`cat_id`,`prod_name`,`prod_description`,`prod_image`,`prod_price`,`prod_created`,`prod_updated`) values (1,5,'Lenovo 123 AA T','-','files/products/asus.jpg',4500,'0000-00-00 00:00:00','2019-03-20 05:16:37'),(2,4,'Dell ABC','-','files/products/lenovo.jpg',6550,'0000-00-00 00:00:00','2019-03-20 05:16:19'),(3,2,'Asus XZY','-','files/products/asus.jpg',6000,'0000-00-00 00:00:00','2019-03-20 05:16:13'),(4,3,'HP Pavilion 15X','-','files/products/hp.jpg',3000,'2019-03-13 04:21:37','2019-03-20 05:16:31');

/*Table structure for table `shipping` */

DROP TABLE IF EXISTS `shipping`;

CREATE TABLE `shipping` (
  `ship_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ship_name` varchar(200) NOT NULL,
  `ship_description` varchar(200) NOT NULL,
  `ship_image` varchar(200) NOT NULL,
  PRIMARY KEY (`ship_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `shipping` */

insert  into `shipping`(`ship_id`,`ship_name`,`ship_description`,`ship_image`) values (1,'JNE Express','JNE Express','files/shipping/JNE.jpg'),(2,'J&T Express','J&T Express','files/shipping/J&T.png'),(3,'Pos Indonesia','Pos Indonesia','files/shipping/POS.png'),(4,'Tiki Online','Tiki Online',''),(5,'Pandu Logistic','Pandu Logistic',''),(6,'Wahana','Wahana','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
