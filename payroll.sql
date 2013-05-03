/*
SQLyog Community v8.3 
MySQL - 5.5.16 : Database - payroll
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`payroll` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `payroll`;

/*Table structure for table `absensi` */

DROP TABLE IF EXISTS `absensi`;

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `hari_masuk` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `absensi` */

insert  into `absensi`(`id`,`staff_id`,`date`,`hari_masuk`) values (1,1,'2013-04-10',24),(2,2,'2013-04-10',24),(3,23,'2013-04-10',8);

/*Table structure for table `asset_details` */

DROP TABLE IF EXISTS `asset_details`;

CREATE TABLE `asset_details` (
  `assetd_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `staff_id` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `assetd_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`assetd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `asset_details` */

/*Table structure for table `asset_handover` */

DROP TABLE IF EXISTS `asset_handover`;

CREATE TABLE `asset_handover` (
  `trasset_id` int(11) NOT NULL AUTO_INCREMENT,
  `trasset_date_time` date NOT NULL,
  `trasset_status` enum('Penyerahan','Pengembalian') NOT NULL,
  `trasset_asset_id` int(11) NOT NULL,
  `trasset_doc_no` varchar(100) DEFAULT NULL,
  `trasset_staff_id_from` int(11) NOT NULL,
  `trasset_staff_id_to` int(11) NOT NULL,
  `trasset_note` varchar(255) NOT NULL,
  PRIMARY KEY (`trasset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `asset_handover` */

insert  into `asset_handover`(`trasset_id`,`trasset_date_time`,`trasset_status`,`trasset_asset_id`,`trasset_doc_no`,`trasset_staff_id_from`,`trasset_staff_id_to`,`trasset_note`) values (1,'2013-04-19','Penyerahan',1,'N 9302 PK',1,2,'jgn lupa balikin lg ya ...'),(3,'2013-04-21','Pengembalian',1,NULL,2,1,'dah dibalikin lg, om ....'),(4,'2013-04-20','Penyerahan',2,NULL,1,7,'pek pake heula tah'),(5,'2013-04-22','Penyerahan',2,NULL,7,2,'bilang dulu ke pak budi mo pinjem motor gitu ya'),(6,'2013-04-23','Penyerahan',2,NULL,2,7,'tolong bilangin aja ya, ini aku balikin'),(7,'2013-04-25','Pengembalian',2,NULL,7,1,'pak, ini motornya, maaf klo lama, soalnya dipinjem puteri dulu, saya suruh langsung ngomong ke bapak dianya gak mau, maaf ya');

/*Table structure for table `assets` */

DROP TABLE IF EXISTS `assets`;

CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_name` varchar(30) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `asset_status` enum('enable','disable') NOT NULL,
  `branch` varchar(50) NOT NULL,
  `date_buy` date NOT NULL,
  `date_tempo` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`asset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `assets` */

insert  into `assets`(`asset_id`,`asset_name`,`asset_code`,`asset_status`,`branch`,`date_buy`,`date_tempo`,`description`,`staff_id`,`date`) values (1,'Motor v-ixion 150','','disable','Bandung','2013-04-02','0000-00-00','<p>Nopol : D6249JI</p>\n',0,'0000-00-00 00:00:00');

/*Table structure for table `branches` */

DROP TABLE IF EXISTS `branches`;

CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(50) NOT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `branches` */

insert  into `branches`(`branch_id`,`branch_name`) values (1,'Bandung'),(4,'Bali'),(10,'Jakarta');

/*Table structure for table `chart_of_account` */

DROP TABLE IF EXISTS `chart_of_account`;

CREATE TABLE `chart_of_account` (
  `glacc_id` int(11) NOT NULL AUTO_INCREMENT,
  `glacc_parent` int(11) DEFAULT NULL,
  `glacc_no` varchar(50) NOT NULL,
  `glacc_parent_stat` enum('y','n') NOT NULL,
  `glacc_name` varchar(100) NOT NULL,
  PRIMARY KEY (`glacc_id`),
  UNIQUE KEY `glacc_no` (`glacc_no`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `chart_of_account` */

insert  into `chart_of_account`(`glacc_id`,`glacc_parent`,`glacc_no`,`glacc_parent_stat`,`glacc_name`) values (1,0,'11100','y','Kas'),(2,0,'21000','y','Hutang Lancar');

/*Table structure for table `components` */

DROP TABLE IF EXISTS `components`;

CREATE TABLE `components` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(20) NOT NULL,
  `comp_type` varchar(8) NOT NULL COMMENT 'kalau Opsi daily ketika input gaji maka opsi amount_daily muncul, misalnya uang makan',
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `components` */

insert  into `components`(`comp_id`,`comp_name`,`comp_type`) values (4,'Gaji Pokok','Monthly'),(5,'Tunjangan Jabatan','Monthly'),(6,'Uang Makan','Daily'),(7,'THR','Yearly');

/*Table structure for table `cuti` */

DROP TABLE IF EXISTS `cuti`;

CREATE TABLE `cuti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `date_request` date NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` enum('approve','pending','decline') NOT NULL DEFAULT 'pending',
  `approveby_staff_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cuti` */

insert  into `cuti`(`id`,`staff_id`,`date_request`,`date_start`,`date_end`,`status`,`approveby_staff_id`) values (2,1,'2013-04-02','2013-04-05','2013-04-15','decline',1),(3,2,'2013-04-01','2013-04-01','2013-04-02','approve',2);

/*Table structure for table `cuti_detail` */

DROP TABLE IF EXISTS `cuti_detail`;

CREATE TABLE `cuti_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuti_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cuti_detail` */

insert  into `cuti_detail`(`id`,`cuti_id`,`comment_date`,`comment`) values (2,2,'2013-04-13 10:39:49','<p>ga boleh cuti wae!</p>\n'),(3,3,'2013-04-16 09:50:42','<p>test comment approval</p>\n');

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(50) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `departments` */

insert  into `departments`(`dept_id`,`dept_name`) values (1,'Accounting'),(2,'Marketing'),(3,'Reservation'),(4,'Operation'),(5,'Ticketing'),(6,'Transportation');

/*Table structure for table `educations` */

DROP TABLE IF EXISTS `educations`;

CREATE TABLE `educations` (
  `edu_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `edu_year` year(4) NOT NULL,
  `edu_gelar` varchar(50) NOT NULL,
  `edu_name` varchar(30) NOT NULL,
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `educations` */

insert  into `educations`(`edu_id`,`staff_id`,`edu_year`,`edu_gelar`,`edu_name`) values (5,1,2010,'S1','Sarjana Informasi'),(6,1,2011,'S2','Teknik Informatika'),(7,2,2010,'s1','Sarjana Informasi'),(8,1,2005,'-','SMA Margahayu'),(9,1,2000,'-','SMP Negri 1'),(11,22,2013,'asdasd','adada'),(12,23,2013,'Sarjana Teknik','UIN SGD Bandung');

/*Table structure for table `employees_status` */

DROP TABLE IF EXISTS `employees_status`;

CREATE TABLE `employees_status` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `sk_name` varchar(10) NOT NULL,
  PRIMARY KEY (`sk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `employees_status` */

insert  into `employees_status`(`sk_id`,`sk_name`) values (1,'Kontrak'),(2,'Tetap'),(4,'Freelance');

/*Table structure for table `families` */

DROP TABLE IF EXISTS `families`;

CREATE TABLE `families` (
  `staff_fam_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_fam_staff_id` int(11) NOT NULL,
  `staff_fam_order` varchar(20) NOT NULL,
  `staff_fam_name` varchar(30) NOT NULL,
  `staff_fam_birthdate` date NOT NULL,
  `staff_fam_birthplace` varchar(30) NOT NULL,
  `staff_fam_sex` enum('laki-laki','perempuan') NOT NULL,
  `staff_fam_relation` varchar(10) NOT NULL,
  PRIMARY KEY (`staff_fam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `families` */

insert  into `families`(`staff_fam_id`,`staff_fam_staff_id`,`staff_fam_order`,`staff_fam_name`,`staff_fam_birthdate`,`staff_fam_birthplace`,`staff_fam_sex`,`staff_fam_relation`) values (3,21,'','dad','2018-09-30','a','perempuan','Ibu'),(5,23,'','Muhamad Kamaludin','2023-01-27','Bandung','laki-laki','Ayah'),(6,23,'','Yayah Rodiah','2013-04-02','Ciamis','perempuan','Ibu'),(7,23,'','Muhamad Dzulfikar','2013-04-25','Bandung','laki-laki','Anak Ke-1');

/*Table structure for table `fiscals` */

DROP TABLE IF EXISTS `fiscals`;

CREATE TABLE `fiscals` (
  `date` varchar(6) NOT NULL DEFAULT '000000',
  `status` varchar(5) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fiscals` */

/*Table structure for table `izin` */

DROP TABLE IF EXISTS `izin`;

CREATE TABLE `izin` (
  `izin_id` int(11) NOT NULL AUTO_INCREMENT,
  `izin_staff_id` int(11) NOT NULL,
  `izin_date` date NOT NULL,
  `izin_jumlah_hari` int(11) NOT NULL,
  `izin_note` varchar(255) NOT NULL,
  PRIMARY KEY (`izin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `izin` */

insert  into `izin`(`izin_id`,`izin_staff_id`,`izin_date`,`izin_jumlah_hari`,`izin_note`) values (1,2,'2013-04-22',2,'jalan2');

/*Table structure for table `maritals_status` */

DROP TABLE IF EXISTS `maritals_status`;

CREATE TABLE `maritals_status` (
  `sn_id` int(11) NOT NULL AUTO_INCREMENT,
  `sn_name` varchar(8) NOT NULL,
  PRIMARY KEY (`sn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `maritals_status` */

insert  into `maritals_status`(`sn_id`,`sn_name`) values (1,'Single'),(2,'Married'),(4,'Divorce');

/*Table structure for table `medical_histories` */

DROP TABLE IF EXISTS `medical_histories`;

CREATE TABLE `medical_histories` (
  `medic_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `medic_date` date NOT NULL,
  `medic_description` text NOT NULL,
  PRIMARY KEY (`medic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `medical_histories` */

insert  into `medical_histories`(`medic_id`,`staff_id`,`medic_date`,`medic_description`) values (3,2,'2010-01-01','Flur'),(4,6,'2013-03-07','wahahah'),(5,6,'2013-03-29','Enak aja luh'),(6,6,'2013-03-28','gue cape tau!'),(7,7,'2013-03-25','Tipes'),(8,7,'2013-03-25','Maag'),(9,9,'2013-04-16','Masuk rumah sakit karena sakit'),(10,10,'2013-04-16','Masuk rumah sakit karena sakit'),(11,12,'2013-04-02','asd'),(12,13,'2013-04-02','asd'),(13,14,'2013-04-02','asd'),(14,19,'2013-04-18','asdasdasd'),(15,21,'2013-04-02','asdasd'),(16,22,'2013-04-02','asdasd'),(17,23,'2013-12-12','Flue wae');

/*Table structure for table `module` */

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `module` */

insert  into `module`(`id`,`name`) values (1,'Assets'),(2,'Branch'),(3,'Departements'),(8,'Taxes Employess'),(11,'Staff'),(12,'Title');

/*Table structure for table `salaries` */

DROP TABLE IF EXISTS `salaries`;

CREATE TABLE `salaries` (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_periode` date NOT NULL,
  `salary_staffid` int(11) NOT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `salaries` */

insert  into `salaries`(`salary_id`,`salary_periode`,`salary_staffid`) values (2,'2010-01-01',3);

/*Table structure for table `salary_components_a` */

DROP TABLE IF EXISTS `salary_components_a`;

CREATE TABLE `salary_components_a` (
  `gaji_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `gaji_component_id` int(11) NOT NULL,
  `gaji_daily_value` decimal(10,0) NOT NULL,
  `gaji_amount_value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`gaji_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `salary_components_a` */

insert  into `salary_components_a`(`gaji_id`,`staff_id`,`gaji_component_id`,`gaji_daily_value`,`gaji_amount_value`) values (1,1,4,'0','10000000'),(2,1,5,'0','500000'),(3,2,4,'0','10000000'),(4,2,0,'0','2000000'),(5,22,4,'0','10000000'),(6,23,4,'0','12000000'),(7,23,5,'0','1500000'),(24,23,6,'1000000','0');

/*Table structure for table `salary_components_b` */

DROP TABLE IF EXISTS `salary_components_b`;

CREATE TABLE `salary_components_b` (
  `gaji_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `gaji_component_id` int(11) NOT NULL,
  `gaji_daily_value` decimal(10,0) NOT NULL,
  `gaji_amount_value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`gaji_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `salary_components_b` */

insert  into `salary_components_b`(`gaji_id`,`staff_id`,`gaji_component_id`,`gaji_daily_value`,`gaji_amount_value`) values (1,1,5,'0','1000000'),(2,2,5,'0','1000000'),(3,22,5,'0','1000000'),(4,23,7,'0','5000000');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `settings` */

insert  into `settings`(`id`,`name`,`value`) values (1,'COMPANY_NAME','Rama Tours'),(2,'ADDRESS','Jl. Riau No. 265'),(3,'COMPANY_PHONE','(022) 6798 987 89'),(4,'PPH21_PERCENT','10'),(5,'PENSIUN','N'),(6,'LOGO','-');

/*Table structure for table `staffs` */

DROP TABLE IF EXISTS `staffs`;

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_nik` int(10) NOT NULL,
  `staff_kode_absen` varchar(5) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_address` text NOT NULL,
  `staff_email` varchar(30) NOT NULL,
  `staff_email_alternatif` varchar(30) NOT NULL,
  `staff_phone_home` varchar(20) NOT NULL,
  `staff_phone_hp` varchar(20) NOT NULL,
  `staff_status_pajak` varchar(10) NOT NULL,
  `staff_status_nikah` varchar(10) NOT NULL,
  `staff_status_karyawan` varchar(10) NOT NULL,
  `staff_cabang` varchar(20) NOT NULL,
  `staff_departement` varchar(20) NOT NULL,
  `staff_jabatan` varchar(20) NOT NULL,
  `staff_photo` varchar(30) NOT NULL,
  `staff_birthdate` date NOT NULL,
  `staff_birthplace` varchar(20) NOT NULL,
  `staff_sex` enum('laki-laki','perempuan') NOT NULL,
  `staff_password` varchar(255) NOT NULL,
  `pph_by_company` enum('y','n') NOT NULL,
  `saldo_cuti` int(10) NOT NULL,
  `no_passport` int(11) NOT NULL,
  `passport_expired` date NOT NULL,
  `no_kitas` int(11) NOT NULL,
  `kitas_expired` date NOT NULL,
  `mulai_kerja` date NOT NULL,
  `contract_from` date NOT NULL,
  `contract_to` date NOT NULL,
  `date_out` date NOT NULL,
  `out_note` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `staffs` */

insert  into `staffs`(`staff_id`,`staff_nik`,`staff_kode_absen`,`staff_name`,`staff_address`,`staff_email`,`staff_email_alternatif`,`staff_phone_home`,`staff_phone_hp`,`staff_status_pajak`,`staff_status_nikah`,`staff_status_karyawan`,`staff_cabang`,`staff_departement`,`staff_jabatan`,`staff_photo`,`staff_birthdate`,`staff_birthplace`,`staff_sex`,`staff_password`,`pph_by_company`,`saldo_cuti`,`no_passport`,`passport_expired`,`no_kitas`,`kitas_expired`,`mulai_kerja`,`contract_from`,`contract_to`,`date_out`,`out_note`) values (1,6305280,'3101','Budi Setiawan','Jl. RE. Martadinata No. 15','budi@gmail.com','budi@gmail.com','541000000','082116914774','K1','Married','Tetap','Bandung','Transportation','Supervisor','-','1985-03-13','Bandung','','','n',0,0,'0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',''),(2,6305281,'3102','Puteri Berlianty','Komp. Margahayu Kencana Blok I 1 No. 19','jasmine@gmail.com','jasmine@gmail.com','541000000','08512121212','K2','Single','Tetap','Bandung','Accounting','Manager','','2011-03-21','Bandung','','','y',0,0,'0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',''),(23,9874,'63052','Dariel pratama','Test','dr.iel_pra@yahoo.co.id','dr.iel_pra@yahoo.co.id','6285721558525','6285721558525','TK','Married','Tetap','Bandung','Accounting','Manager','2012-10-27_14.09_.34_1.jpg','2013-04-02','ciamis','laki-laki','d41d8cd98f00b204e9800998ecf8427e','n',10,0,'0000-00-00',0,'0000-00-00','2013-04-01','0000-00-00','0000-00-00','0000-00-00','');

/*Table structure for table `sub_salaries` */

DROP TABLE IF EXISTS `sub_salaries`;

CREATE TABLE `sub_salaries` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_id` int(11) NOT NULL,
  `salary_periode` date NOT NULL,
  `salary_component_id` int(11) NOT NULL,
  `salary_daily_value` decimal(10,0) NOT NULL,
  `salary_amount_value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `sub_salaries` */

insert  into `sub_salaries`(`sub_id`,`salary_id`,`salary_periode`,`salary_component_id`,`salary_daily_value`,`salary_amount_value`) values (1,2,'2013-01-01',2013,'9000','1500000'),(6,2,'2010-01-01',4,'0','2350000');

/*Table structure for table `taxes_employees` */

DROP TABLE IF EXISTS `taxes_employees`;

CREATE TABLE `taxes_employees` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_status` varchar(3) NOT NULL,
  `sp_ptkp` int(11) NOT NULL,
  `sp_note` varchar(255) NOT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `taxes_employees` */

insert  into `taxes_employees`(`sp_id`,`sp_status`,`sp_ptkp`,`sp_note`) values (1,'TK',100000000,'Test note'),(2,'K0',1380000,''),(3,'K1',200,''),(4,'K2',300,''),(5,'K3',400,'');

/*Table structure for table `titles` */

DROP TABLE IF EXISTS `titles`;

CREATE TABLE `titles` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `title_name` varchar(20) NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `titles` */

insert  into `titles`(`title_id`,`title_name`) values (1,'Manager'),(2,'General Manager'),(3,'Supervisor'),(5,'Staff');

/*Table structure for table `user_roled` */

DROP TABLE IF EXISTS `user_roled`;

CREATE TABLE `user_roled` (
  `roled_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `roled_add` tinyint(1) NOT NULL,
  `roled_edit` tinyint(1) NOT NULL,
  `roled_delete` tinyint(1) NOT NULL,
  `roled_approve` tinyint(1) NOT NULL,
  `roled_super` tinyint(1) NOT NULL COMMENT 'this role only used for "president"',
  PRIMARY KEY (`roled_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `user_roled` */

insert  into `user_roled`(`roled_id`,`role_id`,`module_id`,`roled_add`,`roled_edit`,`roled_delete`,`roled_approve`,`roled_super`) values (6,2,1,1,1,1,1,0),(7,2,2,1,1,1,1,0),(8,2,3,1,1,1,1,0),(9,2,8,0,0,0,0,0),(10,2,11,1,1,1,1,0),(11,2,12,1,1,1,1,0);

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user_roles` */

insert  into `user_roles`(`role_id`,`role_name`) values (2,'President');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`staff_id`,`username`,`password`,`avatar`,`role_id`,`created_at`,`updated_at`) values (1,1,'admin','d8578edf8458ce06fbc5bb76a58c5ca4','-',1,'2013-03-13 08:26:00','2013-03-13 08:26:00'),(2,1,'budi','d8578edf8458ce06fbc5bb76a58c5ca4','',1,'2013-03-19 08:57:32','2013-03-19 08:57:32');

/*Table structure for table `work_histories` */

DROP TABLE IF EXISTS `work_histories`;

CREATE TABLE `work_histories` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `history_date` date NOT NULL,
  `history_description` text NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `work_histories` */

insert  into `work_histories`(`history_id`,`staff_id`,`history_date`,`history_description`) values (10,2,'2013-09-09','Web Developer'),(11,1,'2000-03-21','EDP Bank BRI'),(12,1,'0000-00-00','0'),(13,1,'2012-03-21','Manager Marketing Garuda Travel'),(14,3,'2013-04-03','IT Manager at PT.Waybe Home Appliance'),(15,9,'2013-04-01','SDT Krida Nusantara'),(16,10,'2013-04-01','SDT Krida Nusantara'),(22,21,'2013-04-17','adasdasd'),(23,22,'2013-04-17','adasdasd'),(24,23,'2013-04-30','41Studio Inc');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
