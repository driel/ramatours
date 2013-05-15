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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

/*Data for the table `chart_of_account` */

insert  into `chart_of_account`(`glacc_id`,`glacc_parent`,`glacc_no`,`glacc_parent_stat`,`glacc_name`) values (1,0,'10000','y','Aktiva'),(2,1,'11000','y','Aktiva Lancar'),(3,2,'11100','n','Kas'),(4,2,'11150','n','Kas Kecil'),(5,2,'11200','n','Bank'),(6,2,'11300','n','Deposito'),(7,2,'11400','n','Piutang'),(8,2,'11500','n','Persediaan'),(9,2,'11600','n','Pajak'),(10,1,'13000','y','Biaya Dibayar Dimuka'),(11,10,'13100','n','Sewa Dibayar Dimuka'),(12,1,'16000','y','Aktiva Tidak Lancar'),(13,12,'16100','n','Aset'),(14,12,'16600','n','Akumulasi Depresiasi'),(15,1,'18000','y','Aktiva Tidak Berwujud'),(16,15,'18100','n','Asuransi'),(17,15,'18200','n','Perangkat Lunak'),(18,1,'19000','y','Beban Ditangguhkan'),(19,18,'19100','n','Beban Ditangguhkan'),(20,0,'20000','y','Kewajiban'),(21,20,'21000','y','Hutang Lancar'),(22,21,'21100','n','Hutang Dagang'),(23,21,'21200','n','Hutang Biaya yang Masih Harus Dibayar'),(24,20,'23000','n','Hutang Tidak Lancar'),(25,20,'27000','y','Kewajiban Jangka Panjang'),(26,25,'27100','n','Penerimaan Diterima Dimuka'),(27,0,'30000','y','Ekuitas'),(28,27,'31000','n','Modal Pendiri'),(29,27,'32000','n','Tambahan Modal Disetor'),(30,27,'33000','n','Surplus / (Defisit)'),(31,27,'34000','n','Laba / (Rugi) Ditahan'),(32,0,'40000','y','Pendapatan'),(33,32,'41000','y','Hibah'),(34,33,'41100','n','Yayasan'),(35,33,'41200','n','Pemerintah'),(36,33,'41300','n','Perusahaan'),(37,33,'41400','n','Organisasi / Institusi'),(38,33,'41900','n','Lain-lain'),(39,32,'42000','n','Iuran Anggota'),(40,32,'43000','n','Sumbangan'),(41,32,'44000','n','Sponsor'),(42,0,'50000','y','Pengeluaran'),(43,42,'51000','y','Biaya Administrasi'),(44,43,'51100','n','Sewa Kantor'),(45,43,'51200','n','Perlengkapan Kantor'),(46,43,'51300','n','Biaya Kebutuhan Umum'),(47,43,'51900','n','Biaya Lain-lain'),(48,42,'52000','y','Biaya Transportasi'),(49,48,'52100','n','Biaya Tol/Parkir/Bensin'),(50,48,'52900','n','Biaya Transportasi Lain'),(51,42,'53000','y','Biaya Gaji & Kompensasi'),(52,51,'53100','n','Kompensasi Konsultan'),(53,51,'53200','n','Gaji Karyawan'),(54,51,'53900','n','Lain-lain'),(55,41,'54000','y','Biaya Rapat/Pelatihan'),(56,55,'54100','n','Biaya Ruangan'),(57,55,'54200','n','Biaya Konsumsi'),(58,41,'55000','y','Perjalanan Dinas'),(59,58,'55100','n','Biaya Tiket'),(60,58,'55200','n','Pajak Bandara'),(61,58,'55300','n','Biaya Visa/Asuransi'),(62,58,'55400','n','Biaya Bagasi'),(63,58,'55500','n','Biaya Penginapan'),(64,58,'55600','n','Biaya Konsumsi'),(65,58,'55900','n','Lain-lain'),(66,41,'56000','y','Biaya Promosi'),(67,66,'56100','n','Spanduk'),(68,66,'56200','n','Poster'),(69,66,'56300','n','Iklan'),(70,66,'56400','n','Proposal'),(71,66,'56900','n','Lain-lain'),(72,41,'59000','n','Biaya Lain-lain'),(73,0,'60000','y','Biaya Depresiasi & Amortisasi'),(74,73,'61000','n','Biaya Depresiasi Aktiva Tetap'),(75,73,'62000','n','Biaya Depresiasi Aktiva Tak Berwujud'),(76,0,'70000','y','Pengeluaran Lain-lain'),(77,76,'71000','y','Pengeluaran Lain-lain'),(78,77,'71100','n','Biaya Administrasi Bank'),(79,77,'71200','n','Biaya Legal'),(80,76,'79000','n','Biaya Lain-lain'),(81,0,'80000','y','Pendapatan Lain-lain'),(82,81,'81000','n','Pendapatan Lain-lain'),(83,81,'82000','n','Pendapatan Bunga');

/*Table structure for table `chart_of_account_detail` */

DROP TABLE IF EXISTS `chart_of_account_detail`;

CREATE TABLE `chart_of_account_detail` (
  `glacc_period` char(6) NOT NULL,
  `glacc_saldo` decimal(10,0) NOT NULL,
  `glaccd_dr` decimal(10,0) NOT NULL,
  `glaccd_cr` decimal(10,0) NOT NULL,
  PRIMARY KEY (`glacc_period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `chart_of_account_detail` */

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `families` */

insert  into `families`(`staff_fam_id`,`staff_fam_staff_id`,`staff_fam_order`,`staff_fam_name`,`staff_fam_birthdate`,`staff_fam_birthplace`,`staff_fam_sex`,`staff_fam_relation`) values (3,21,'','dad','2018-09-30','a','perempuan','Ibu'),(5,23,'','Muhamad Kamaludin','2023-01-27','Bandung','laki-laki','Ayah'),(6,23,'','Yayah Rodiah','2013-04-02','Ciamis','perempuan','Ibu'),(7,23,'','Muhamad Dzulfikar','2013-04-25','Bandung','laki-laki','Anak Ke-1'),(8,32,'','Max Syat','1970-05-05','Medan','laki-laki','Bapak');

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

/*Table structure for table `journal` */

DROP TABLE IF EXISTS `journal`;

CREATE TABLE `journal` (
  `gltr_id` int(11) NOT NULL AUTO_INCREMENT,
  `gltr_date` char(6) NOT NULL,
  `gltr_voucher` varchar(20) NOT NULL,
  `gltr_status` enum('New','Post') NOT NULL DEFAULT 'New',
  PRIMARY KEY (`gltr_id`),
  UNIQUE KEY `gltr_date` (`gltr_date`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `journal` */

insert  into `journal`(`gltr_id`,`gltr_date`,`gltr_voucher`,`gltr_status`) values (1,'201301','V12121','New'),(2,'201302','V12121','New'),(3,'201303','qwq','New'),(4,'201304','qwq','New'),(5,'201305','5555','New'),(6,'201306','4545454','New'),(7,'201307','V45454','New'),(8,'201308','45454','New');

/*Table structure for table `journal_detail` */

DROP TABLE IF EXISTS `journal_detail`;

CREATE TABLE `journal_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gltr_id` int(11) NOT NULL,
  `gltr_accno` varchar(100) NOT NULL,
  `gltr_rti` varchar(100) DEFAULT NULL,
  `gltr_keterangan` varchar(255) NOT NULL,
  `gltr_dr` decimal(10,0) NOT NULL,
  `gltr_cr` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `journal_detail` */

insert  into `journal_detail`(`id`,`gltr_id`,`gltr_accno`,`gltr_rti`,`gltr_keterangan`,`gltr_dr`,`gltr_cr`) values (1,8,'11300','','qwq','45','0'),(2,8,'11400','','wqwq','0','45'),(3,5,'11200','','Tarik tunai','400','0'),(4,5,'11500','','Cadangan','0','400');

/*Table structure for table `kurs_pajak` */

DROP TABLE IF EXISTS `kurs_pajak`;

CREATE TABLE `kurs_pajak` (
  `kurs_id` int(11) NOT NULL AUTO_INCREMENT,
  `kurs_date` date NOT NULL,
  `kurs_us_rp` decimal(10,0) NOT NULL,
  `kurs_yen_rp` decimal(10,0) NOT NULL,
  PRIMARY KEY (`kurs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `kurs_pajak` */

insert  into `kurs_pajak`(`kurs_id`,`kurs_date`,`kurs_us_rp`,`kurs_yen_rp`) values (1,'2013-05-15','9590','2839');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `medical_histories` */

insert  into `medical_histories`(`medic_id`,`staff_id`,`medic_date`,`medic_description`) values (3,2,'2010-01-01','Flur'),(4,6,'2013-03-07','wahahah'),(5,6,'2013-03-29','Enak aja luh'),(6,6,'2013-03-28','gue cape tau!'),(7,7,'2013-03-25','Tipes'),(8,7,'2013-03-25','Maag'),(9,9,'2013-04-16','Masuk rumah sakit karena sakit'),(10,10,'2013-04-16','Masuk rumah sakit karena sakit'),(11,12,'2013-04-02','asd'),(12,13,'2013-04-02','asd'),(13,14,'2013-04-02','asd'),(14,19,'2013-04-18','asdasdasd'),(15,21,'2013-04-02','asdasd'),(16,22,'2013-04-02','asdasd'),(17,23,'2013-12-12','Flue wae'),(18,32,'2013-05-08','Sakit pilek');

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `salary_components_a` */

insert  into `salary_components_a`(`gaji_id`,`staff_id`,`gaji_component_id`,`gaji_daily_value`,`gaji_amount_value`) values (1,1,4,'0','10000000'),(2,1,5,'0','500000'),(3,2,4,'0','10000000'),(4,2,0,'0','2000000'),(5,22,4,'0','10000000'),(6,23,4,'0','12000000'),(7,23,5,'0','1500000'),(24,23,6,'1000000','0'),(25,33,4,'0','4040400'),(26,33,5,'0','34343433');

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
  `staff_status_pajak` int(11) NOT NULL,
  `staff_status_nikah` int(11) NOT NULL,
  `staff_status_karyawan` int(11) NOT NULL,
  `staff_cabang` int(11) NOT NULL,
  `staff_departement` int(11) NOT NULL,
  `staff_jabatan` int(11) NOT NULL,
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
  `contract_number` int(11) NOT NULL,
  `contract_from` date NOT NULL,
  `contract_to` date NOT NULL,
  `date_out` date NOT NULL,
  `out_note` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `staffs` */

insert  into `staffs`(`staff_id`,`staff_nik`,`staff_kode_absen`,`staff_name`,`staff_address`,`staff_email`,`staff_email_alternatif`,`staff_phone_home`,`staff_phone_hp`,`staff_status_pajak`,`staff_status_nikah`,`staff_status_karyawan`,`staff_cabang`,`staff_departement`,`staff_jabatan`,`staff_photo`,`staff_birthdate`,`staff_birthplace`,`staff_sex`,`staff_password`,`pph_by_company`,`saldo_cuti`,`no_passport`,`passport_expired`,`no_kitas`,`kitas_expired`,`mulai_kerja`,`contract_number`,`contract_from`,`contract_to`,`date_out`,`out_note`) values (1,6305280,'3101','Budi Setiawan','Jl. RE. Martadinata No. 15','budi@gmail.com','budi@gmail.com','541000000','082116914774',3,2,2,0,6,3,'-','1985-03-13','Bandung','laki-laki','d41d8cd98f00b204e9800998ecf8427e','y',0,0,'2013-05-08',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00',''),(2,6305281,'3102','Puteri Berlianty','Komp. Margahayu Kencana Blok I 1 No. 19','jasmine@gmail.com','jasmine@gmail.com','541000000','08512121212',4,1,2,0,1,1,'','2011-03-21','Bandung','','','y',0,0,'0000-00-00',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00',''),(23,9874,'63052','Dariel pratama','Test','dr.iel_pra@yahoo.co.id','dr.iel_pra@yahoo.co.id','6285721558525','6285721558525',1,2,2,1,1,1,'2012-10-27_14.09_.34_1.jpg','2013-04-02','ciamis','laki-laki','d41d8cd98f00b204e9800998ecf8427e','y',10,0,'0000-00-00',0,'0000-00-00','2013-04-01',0,'0000-00-00','0000-00-00','0000-00-00',''),(25,6305280,'3104','Sunil Watir','Jl. RE. Martadinata No. 15','budi@gmail.com','budi@gmail.com','541000000','082116914774',3,2,2,0,6,3,'-','1985-03-13','Bandung','','','y',0,0,'0000-00-00',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00',''),(26,6305281,'3103','Michael Kurap','Komp. Margahayu Kencana Blok I 1 No. 19','jasmine@gmail.com','jasmine@gmail.com','541000000','08512121212',4,1,2,0,1,1,'','2011-03-21','Bandung','','','y',0,0,'0000-00-00',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00',''),(27,9874,'3105','Eman Si Pasi','Test','dr.iel_pra@yahoo.co.id','dr.iel_pra@yahoo.co.id','6285721558525','6285721558525',1,2,2,0,1,1,'2012-10-27_14.09_.34_1.jpg','2013-04-02','ciamis','laki-laki','d41d8cd98f00b204e9800998ecf8427e','y',10,0,'0000-00-00',0,'0000-00-00','2013-04-01',0,'0000-00-00','0000-00-00','0000-00-00',''),(28,6305280,'3106','Sanda','Jl. RE. Martadinata No. 15','budi@gmail.com','budi@gmail.com','541000000','082116914774',3,2,2,0,6,3,'-','1985-03-13','Bandung','','','y',0,0,'0000-00-00',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00',''),(29,6305281,'3107','Bara patirajawane','Komp. Margahayu Kencana Blok I 1 No. 19','jasmine@gmail.com','jasmine@gmail.com','541000000','08512121212',4,1,2,0,1,1,'','2011-03-21','Bandung','','','y',0,0,'0000-00-00',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00',''),(30,9874,'3108','Asep Balon','Test','dr.iel_pra@yahoo.co.id','dr.iel_pra@yahoo.co.id','6285721558525','6285721558525',1,2,2,0,1,1,'2012-10-27_14.09_.34_1.jpg','2013-04-02','ciamis','laki-laki','d41d8cd98f00b204e9800998ecf8427e','y',10,0,'0000-00-00',0,'0000-00-00','2013-04-01',0,'0000-00-00','0000-00-00','0000-00-00',''),(31,125788,'3109','Eyang Subur','Jakarta','suburban@suburjayamotor.com','','081212345678','081212345678',1,1,2,0,6,1,'','2011-07-28','Bandung','laki-laki','d41d8cd98f00b204e9800998ecf8427e','n',10,0,'0000-00-00',0,'0000-00-00','2009-09-15',1458,'2009-09-15','2013-09-15','0000-00-00',''),(32,56565,'3322','Daniel Sembarang','Jln Pelicin 66 Denpasar','daniel.s@onewaymail.com','-','05625541','0598527441',1,1,1,4,5,5,'','1983-05-15','Bukit Asam','laki-laki','d41d8cd98f00b204e9800998ecf8427e','n',0,0,'0000-00-00',0,'0000-00-00','2013-05-01',0,'2013-05-01','2013-11-01','0000-00-00',''),(33,0,'','','','','','','',0,0,0,0,0,0,'','0000-00-00','','laki-laki','d8578edf8458ce06fbc5bb76a58c5ca4','n',0,0,'0000-00-00',0,'0000-00-00','0000-00-00',0,'0000-00-00','0000-00-00','0000-00-00','');

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

/*Table structure for table `tahun_fiskal` */

DROP TABLE IF EXISTS `tahun_fiskal`;

CREATE TABLE `tahun_fiskal` (
  `fiskal_date` char(6) NOT NULL,
  `fiskal_status` enum('Open','Close') NOT NULL DEFAULT 'Open',
  `fiskal_retained_earning` decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fiskal_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tahun_fiskal` */

insert  into `tahun_fiskal`(`fiskal_date`,`fiskal_status`,`fiskal_retained_earning`) values ('201305','Open','0');

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

insert  into `users`(`id`,`staff_id`,`username`,`password`,`avatar`,`role_id`,`created_at`,`updated_at`) values (1,1,'admin','d8578edf8458ce06fbc5bb76a58c5ca4','-',2,'2013-03-13 08:26:00','2013-03-13 08:26:00'),(2,1,'budi','d8578edf8458ce06fbc5bb76a58c5ca4','',1,'2013-03-19 08:57:32','2013-03-19 08:57:32');

/*Table structure for table `work_histories` */

DROP TABLE IF EXISTS `work_histories`;

CREATE TABLE `work_histories` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `history_date` date NOT NULL,
  `history_description` text NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `work_histories` */

insert  into `work_histories`(`history_id`,`staff_id`,`history_date`,`history_description`) values (10,2,'2013-09-09','Web Developer'),(11,1,'2000-03-21','EDP Bank BRI'),(12,1,'0000-00-00','0'),(13,1,'2012-03-21','Manager Marketing Garuda Travel'),(14,3,'2013-04-03','IT Manager at PT.Waybe Home Appliance'),(15,9,'2013-04-01','SDT Krida Nusantara'),(16,10,'2013-04-01','SDT Krida Nusantara'),(22,21,'2013-04-17','adasdasd'),(23,22,'2013-04-17','adasdasd'),(24,23,'2013-04-30','41Studio Inc'),(25,32,'2012-05-01','magang');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
