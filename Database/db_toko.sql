/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - db_toko
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_toko` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_toko`;

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `merk` varchar(255) NOT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `satuan_barang` varchar(255) NOT NULL,
  `stok` text NOT NULL,
  `tgl_input` varchar(255) NOT NULL,
  `tgl_update` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `barang` */

insert  into `barang`(`id`,`id_barang`,`id_kategori`,`nama_barang`,`merk`,`harga_beli`,`harga_jual`,`satuan_barang`,`stok`,`tgl_input`,`tgl_update`) values 
(1,'BR001',1,'Ramen Beef Classic','Ramen','40000','45000','PCS','20','6 October 2020, 0:41','24 July 2024, 15:02'),
(2,'BR002',1,'Ramen Seafood Supreme','Ramen','49000','55000','PCS','20','6 October 2020, 0:41','24 July 2024, 15:09'),
(3,'BR003',1,'Ramen Gyoza Combo','Ramen','48000','52000','PCS','20','6 October 2020, 1:34','24 July 2024, 15:04'),
(4,'BR004',1,'Ramen Chashu Deluxe','Ramen','45000','50000','PCS','20','24 July 2024, 15:01',NULL),
(5,'BR005',1,'Ramen Prawn Delight','Ramen','47000','52000','PCS','20','24 July 2024, 15:05',NULL),
(6,'BR006',1,'Ramen Tempura Special','Ramen','50000','55000','PCS','20','24 July 2024, 15:06',NULL),
(7,'BR007',1,'Ramen Miso Traditional','Ramen','44000','48000','PCS','20','24 July 2024, 15:07','24 July 2024, 15:08'),
(8,'BR008',1,'Ramen Pork Belly Delight','Ramen','50000','57000','PCS','20','24 July 2024, 15:08',NULL),
(9,'BR009',1,'Ramen Steakhouse Style','Ramen','45000','60000','PCS','20','24 July 2024, 15:09',NULL),
(10,'BR010',1,'Ramen Yakibuta Special','Ramen','48000','57000','PCS','20','24 July 2024, 15:10',NULL),
(11,'BR011',1,'Ramen Chicken Teriyaki','Ramen','39000','45000','PCS','20','24 July 2024, 15:10',NULL),
(12,'BR012',1,'Ramen Sushi Fushion','Ramen','36000','45000','PCS','20','24 July 2024, 15:11',NULL),
(13,'BR013',5,'Kanikawa Ankake Udon','Udon','35000','42000','PCS','20','24 July 2024, 15:12',NULL),
(14,'BR014',5,'Kotteri Udon','Udon','34000','45000','PCS','20','24 July 2024, 15:13',NULL),
(15,'BR015',5,'Spicy Oden Udon','Udon','35000','42000','PCS','20','24 July 2024, 15:14',NULL),
(16,'BR016',5,'Teriyaki Udon','Udon','34000','43000','PCS','20','24 July 2024, 15:15',NULL),
(17,'BR017',5,'Beef Abura Udon','Udon','32000','41000','PCS','20','24 July 2024, 15:16',NULL),
(18,'BR018',5,'Beef Abura Spicy Udon','Udon','32000','41000','PCS','20','24 July 2024, 15:16',NULL),
(19,'BR019',5,'Beef Curry Udon','Udon','35500','45000','PCS','20','24 July 2024, 15:17',NULL),
(20,'BR020',5,'Chickn Katsu Curry Udon','Udon','41000','52000','PCS','20','24 July 2024, 15:18',NULL),
(21,'BR021',5,'Kake Udon','Udon','30000','37000','PCS','20','24 July 2024, 15:19',NULL),
(22,'BR022',5,'Niku Udon','Udon','30000','36000','PCS','20','24 July 2024, 15:19',NULL),
(23,'BR023',5,'Spicy Tori Udon','Udon','32000','40000','PCS','20','24 July 2024, 15:20',NULL),
(24,'BR024',5,'Niku Zaru Udon','Udon','30000','39000','PCS','20','24 July 2024, 15:21',NULL),
(25,'BR025',7,'Ocha','Drink','8000','14000','PCS','30','24 July 2024, 15:21',NULL),
(26,'BR026',7,'Iced Lemon Tea','Drink','8000','15000','PCS','20','24 July 2024, 15:22',NULL),
(27,'BR027',7,'Aqua','Drink','4000','8000','PCS','30','24 July 2024, 15:23',NULL),
(28,'BR028',7,'Coca Cola','Drink','10000','15000','PCS','20','24 July 2024, 15:23',NULL),
(29,'BR029',7,'Cafe Latte','Drink','15000','25000','PCS','20','24 July 2024, 15:24',NULL);

/*Table structure for table `feedback` */

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `satisfaction` enum('Sangat Puas','Cukup Puas','Tidak Puas') NOT NULL,
  `terms_accepted` tinyint(1) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_feedback`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `feedback` */

insert  into `feedback`(`id_feedback`,`name`,`email`,`message`,`satisfaction`,`terms_accepted`,`tgl_input`) values 
(2,'ilham','ilham@gmail.com','restaurant nya sangat bagus dan bersih makanannya pun sangat enak sekali!','Sangat Puas',1,'2024-07-14 14:12:11'),
(3,'budi','budi@gmail.com','ramen nya bukan kaleng - kaleng','Sangat Puas',1,'2024-07-14 14:12:50'),
(4,'rina','rina@gmail.com','sangat enak kuahnya kental mie ramennya juga mantap','Sangat Puas',1,'2024-07-14 14:13:22'),
(5,'rudi','rudi@gmail.com','pesanan saya sangat lama','Tidak Puas',1,'2024-07-14 14:38:13'),
(6,'Naufal','naufalhilman@gmail.com','Ramen sangat Enak','Sangat Puas',1,'2024-08-09 20:30:19'),
(7,'Naufal','naufalhilman21@gmail.com','ramen sangat enak','Sangat Puas',1,'2024-08-09 20:36:16');

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `tgl_input` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `kategori` */

insert  into `kategori`(`id_kategori`,`nama_kategori`,`tgl_input`) values 
(1,'Ramen','7 May 2017, 10:23'),
(5,'Udon','7 May 2017, 10:28'),
(6,'Snack','6 October 2020, 0:19'),
(7,'Drink','6 October 2020, 0:20');

/*Table structure for table `login` */

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `pass` char(32) NOT NULL,
  `id_member` int(11) NOT NULL,
  PRIMARY KEY (`id_login`),
  KEY `fk_member_login` (`id_member`),
  CONSTRAINT `fk_member_login` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `login` */

insert  into `login`(`id_login`,`user`,`pass`,`id_member`) values 
(1,'admin','123',1),
(2,'kasir','kasir',2),
(3,'chef','chef',3),
(4,'waiter','waiter',4);

/*Table structure for table `meja` */

DROP TABLE IF EXISTS `meja`;

CREATE TABLE `meja` (
  `table_number` int(11) NOT NULL,
  `costumer_name` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `total_order` int(11) DEFAULT NULL,
  `status` enum('kosong','direservasi','diisi') DEFAULT 'kosong',
  PRIMARY KEY (`table_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `meja` */

insert  into `meja`(`table_number`,`costumer_name`,`order_date`,`total_order`,`status`) values 
(0,'','2024-07-24 00:00:00',90000,'diisi'),
(12,'naufal','2024-08-09 00:00:00',100000,'diisi');

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL AUTO_INCREMENT,
  `nm_member` varchar(255) NOT NULL,
  `alamat_member` text NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `NIK` text NOT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `member` */

insert  into `member`(`id_member`,`nm_member`,`alamat_member`,`telepon`,`email`,`gambar`,`NIK`) values 
(1,'Owner','RameninAjahUNIKOM','081234567890','RameninAjah@gmail.com','1721116119Designer(4).jpeg','12314121'),
(2,'kasir','RameninAjah Unikom','081234567890','RameninAjah@gmail.com','1721116004Designer(4).jpeg','123456789'),
(3,'chef','','','','1721247537Designer(4).jpeg',''),
(4,'waiter','','','','1721247609Designer(4).jpeg','');

/*Table structure for table `nota` */

DROP TABLE IF EXISTS `nota`;

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL,
  `periode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `nota` */

insert  into `nota`(`id_nota`,`id_barang`,`id_member`,`jumlah`,`total`,`tanggal_input`,`periode`) values 
(1,'BR001',1,'2','86000','13 July 2024, 13:33','07-2024'),
(2,'BR003',1,'1','41000','13 July 2024, 13:33','07-2024');

/*Table structure for table `order_items` */

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `order_items` */

insert  into `order_items`(`id`,`order_id`,`item_id`,`quantity`,`subtotal`) values 
(56,45,1,1,45000.00),
(57,45,2,1,55000.00),
(58,46,1,1,45000.00),
(59,46,2,1,55000.00);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` varchar(10) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `total_order` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `items_details` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`table_number`,`customer_name`,`order_date`,`total_order`,`status`,`items_details`) values 
(46,'12','naufal','2024-08-09 00:00:00',100000.00,'Pending','Ramen Beef Classic (1), Ramen Seafood Supreme (1)');

/*Table structure for table `penjualan` */

DROP TABLE IF EXISTS `penjualan`;

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `penjualan` */

/*Table structure for table `reservasi` */

DROP TABLE IF EXISTS `reservasi`;

CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `tanggal_reservasi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_reservasi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `reservasi` */

insert  into `reservasi`(`id_reservasi`,`nama`,`jumlah_orang`,`email`,`nomor_telepon`,`tanggal_reservasi`) values 
(2,'Naufal',4,'naufalhilman20@gmail.com','08123456789','2024-08-09 20:31:36'),
(3,'Naufal',4,'naufalhilman21@gmail.com','08123456789','2024-08-09 20:36:38');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`role_name`,`description`) values 
(1,'admin','Administrator with full access'),
(2,'waiter','Waiter with access to waiter functionalities'),
(3,'cashier','Cashier with access to cashier functionalities'),
(4,'chef','Chef with access to chef functionalities');

/*Table structure for table `toko` */

DROP TABLE IF EXISTS `toko`;

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `tlp` varchar(255) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  PRIMARY KEY (`id_toko`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `toko` */

insert  into `toko`(`id_toko`,`nama_toko`,`alamat_toko`,`tlp`,`nama_pemilik`) values 
(1,'RameninAjah UNIKOM','Jl. Dipati Ukur No.112-116, Kota Bandung, Jawa Barat','081234567890','RameninAjah');

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_member` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_member` (`id_member`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`),
  CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_roles` */

insert  into `user_roles`(`id`,`id_member`,`role_id`) values 
(1,1,1),
(2,2,3),
(3,3,4),
(4,4,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
