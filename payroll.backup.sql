-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2013 at 11:25 AM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE IF NOT EXISTS `absensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `hari_masuk` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `staff_id`, `date`, `hari_masuk`) VALUES
(1, 1, '2013-04-01', 10),
(2, 2, '2013-04-01', 20),
(3, 23, '2013-04-01', 3),
(4, 25, '2013-04-01', 40),
(5, 26, '2013-04-01', 5),
(6, 27, '2013-04-01', 6),
(7, 1, '2013-03-01', 22),
(8, 23, '2013-03-01', 22),
(9, 27, '2013-03-01', 23),
(10, 26, '2013-03-01', 26),
(11, 2, '2013-03-01', 25),
(12, 25, '2013-03-01', 26),
(13, 30, '2013-04-01', 25),
(14, 28, '2013-04-01', 25),
(15, 29, '2013-04-01', 26);

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE IF NOT EXISTS `airline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `email` varchar(80) NOT NULL,
  `contact_name1` varchar(50) NOT NULL,
  `contact_title1` varchar(40) NOT NULL,
  `contact_phone1` varchar(25) NOT NULL,
  `contact_email1` varchar(80) NOT NULL,
  `contact_name2` varchar(50) NOT NULL,
  `contact_title2` varchar(40) NOT NULL,
  `contact_phone2` varchar(25) NOT NULL,
  `contact_email2` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`id`, `name`, `address`, `phone`, `fax`, `email`, `contact_name1`, `contact_title1`, `contact_phone1`, `contact_email1`, `contact_name2`, `contact_title2`, `contact_phone2`, `contact_email2`) VALUES
(1, 'Lion Air', 'Jati Bening 76, Jakarta', '021-7005000', '021-7005000', 'ticketing@lionair.com', 'Dariel pratama', 'Hiring Manager', '6285721558525', 'dr.iel_pra@yahoo.co.id', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_name` varchar(30) NOT NULL,
  `asset_code` varchar(30) NOT NULL,
  `asset_status` enum('enable','disable') NOT NULL,
  `branch` varchar(50) NOT NULL,
  `date_buy` date NOT NULL,
  `date_tempo` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`asset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `asset_name`, `asset_code`, `asset_status`, `branch`, `date_buy`, `date_tempo`, `description`, `staff_id`, `date`) VALUES
(1, 'Motor v-ixion 150', 'v-ixion6249JI', 'enable', 'Bandung', '2013-04-02', '2013-04-25', '<p>Nopol : D6249JI</p>\n', 0, '0000-00-00 00:00:00'),
(2, 'Table Office', '', 'enable', '0', '0000-00-00', '0000-00-00', '', 1, '2013-09-09 00:00:00'),
(3, 'Motor Honda Supra RX', '', 'enable', '0', '0000-00-00', '0000-00-00', '', 1, '2013-04-25 00:00:00'),
(4, 'Kursi', '', 'enable', '0', '0000-00-00', '0000-00-00', '', 2, '2013-01-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `asset_details`
--

CREATE TABLE IF NOT EXISTS `asset_details` (
  `assetd_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `staff_id` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `assetd_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`assetd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `asset_handover`
--

CREATE TABLE IF NOT EXISTS `asset_handover` (
  `trasset_id` int(11) NOT NULL AUTO_INCREMENT,
  `trasset_date_time` date NOT NULL,
  `trasset_status` enum('Penyerahan','Pengembalian') NOT NULL,
  `trasset_asset_id` int(11) NOT NULL,
  `trasset_doc_no` varchar(100) DEFAULT NULL,
  `trasset_staff_id_from` int(11) NOT NULL,
  `trasset_staff_id_to` int(11) NOT NULL,
  `trasset_note` varchar(255) NOT NULL,
  PRIMARY KEY (`trasset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `asset_handover`
--

INSERT INTO `asset_handover` (`trasset_id`, `trasset_date_time`, `trasset_status`, `trasset_asset_id`, `trasset_doc_no`, `trasset_staff_id_from`, `trasset_staff_id_to`, `trasset_note`) VALUES
(1, '2013-04-19', 'Penyerahan', 1, 'N 9302 PK', 1, 2, 'jgn lupa balikin lg ya ...'),
(3, '2013-04-21', 'Pengembalian', 1, NULL, 2, 1, 'dah dibalikin lg, om ....'),
(4, '2013-04-20', 'Penyerahan', 2, NULL, 1, 7, 'pek pake heula tah'),
(5, '2013-04-22', 'Penyerahan', 2, NULL, 7, 2, 'bilang dulu ke pak budi mo pinjem motor gitu ya'),
(6, '2013-04-23', 'Penyerahan', 2, NULL, 2, 7, 'tolong bilangin aja ya, ini aku balikin'),
(7, '2013-04-25', 'Pengembalian', 2, NULL, 7, 1, 'pak, ini motornya, maaf klo lama, soalnya dipinjem puteri dulu, saya suruh langsung ngomong ke bapak dianya gak mau, maaf ya');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(50) NOT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_name`) VALUES
(1, 'Bandung'),
(4, 'Bali'),
(10, 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_account`
--

CREATE TABLE IF NOT EXISTS `chart_of_account` (
  `glacc_id` int(11) NOT NULL AUTO_INCREMENT,
  `glacc_parent` int(11) DEFAULT NULL,
  `glacc_no` varchar(50) NOT NULL,
  `glacc_parent_stat` enum('y','n') NOT NULL,
  `glacc_name` varchar(100) NOT NULL,
  PRIMARY KEY (`glacc_id`),
  UNIQUE KEY `glacc_no` (`glacc_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `chart_of_account`
--

INSERT INTO `chart_of_account` (`glacc_id`, `glacc_parent`, `glacc_no`, `glacc_parent_stat`, `glacc_name`) VALUES
(1, 0, '11100', 'y', 'Kas'),
(2, 0, '21000', 'y', 'Hutang Lancar');

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(20) NOT NULL,
  `comp_type` varchar(8) NOT NULL COMMENT 'kalau Opsi daily ketika input gaji maka opsi amount_daily muncul, misalnya uang makan',
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`comp_id`, `comp_name`, `comp_type`) VALUES
(4, 'Gaji Pokok', 'Monthly'),
(5, 'Tunjangan Jabatan', 'Monthly'),
(6, 'Uang Makan', 'Daily'),
(7, 'THR', 'Yearly');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE IF NOT EXISTS `cuti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `date_request` date NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` enum('approve','pending','decline') NOT NULL DEFAULT 'pending',
  `approveby_staff_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `staff_id`, `date_request`, `date_start`, `date_end`, `status`, `approveby_staff_id`) VALUES
(2, 1, '2013-04-02', '2013-04-05', '2013-04-15', 'decline', 1),
(3, 2, '2013-04-01', '2013-05-01', '2013-05-15', 'approve', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cuti_detail`
--

CREATE TABLE IF NOT EXISTS `cuti_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuti_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cuti_detail`
--

INSERT INTO `cuti_detail` (`id`, `cuti_id`, `comment_date`, `comment`) VALUES
(2, 2, '2013-04-13 10:39:49', '<p>ga boleh cuti wae!</p>\n'),
(3, 3, '2013-04-16 09:50:42', '<p>test comment approval</p>\n');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(50) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`) VALUES
(1, 'Accounting'),
(2, 'Marketing'),
(3, 'Reservation'),
(4, 'Operation'),
(5, 'Ticketing'),
(6, 'Transportation');

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE IF NOT EXISTS `educations` (
  `edu_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `edu_year` year(4) NOT NULL,
  `edu_gelar` varchar(50) NOT NULL,
  `edu_name` varchar(30) NOT NULL,
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`edu_id`, `staff_id`, `edu_year`, `edu_gelar`, `edu_name`) VALUES
(5, 1, 2010, 'S1', 'Sarjana Informasi'),
(6, 1, 2011, 'S2', 'Teknik Informatika'),
(7, 2, 2010, 's1', 'Sarjana Informasi'),
(11, 22, 2013, 'asdasd', 'adada'),
(12, 23, 2013, 'Sarjana Teknik', 'UIN SGD Bandung'),
(16, 1, 2017, 'MBA', 'XXX'),
(17, 1, 2020, 'ASD', 'YUV'),
(18, 31, 2015, 'S3', 'Hahaha');

-- --------------------------------------------------------

--
-- Table structure for table `employees_status`
--

CREATE TABLE IF NOT EXISTS `employees_status` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `sk_name` varchar(10) NOT NULL,
  PRIMARY KEY (`sk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `employees_status`
--

INSERT INTO `employees_status` (`sk_id`, `sk_name`) VALUES
(1, 'Kontrak'),
(2, 'Tetap'),
(5, 'nganggur');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE IF NOT EXISTS `families` (
  `staff_fam_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_fam_staff_id` int(11) NOT NULL,
  `staff_fam_order` varchar(20) NOT NULL,
  `staff_fam_name` varchar(30) NOT NULL,
  `staff_fam_birthdate` date NOT NULL,
  `staff_fam_birthplace` varchar(30) NOT NULL,
  `staff_fam_sex` enum('laki-laki','perempuan') NOT NULL,
  `staff_fam_relation` varchar(10) NOT NULL,
  PRIMARY KEY (`staff_fam_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`staff_fam_id`, `staff_fam_staff_id`, `staff_fam_order`, `staff_fam_name`, `staff_fam_birthdate`, `staff_fam_birthplace`, `staff_fam_sex`, `staff_fam_relation`) VALUES
(3, 21, '', 'dad', '2018-09-30', 'a', 'perempuan', 'Ibu'),
(5, 23, '', 'Muhamad Kamaludin', '2023-01-27', 'Bandung', 'laki-laki', 'Ayah'),
(6, 23, '', 'Yayah Rodiah3', '2013-04-02', 'Ciamis', 'perempuan', 'Ibu'),
(7, 1, '', 'Anita', '2013-05-30', 'Bandung', 'perempuan', 'Istri'),
(8, 1, '', 'Argin', '2013-05-01', 'Bandung', 'perempuan', 'Anak Ke-1'),
(21, 1, '', 'Sunade', '2013-05-03', 'Jati Nangor', 'laki-laki', 'Anak Ke-3'),
(22, 31, '', 'Leili Sagita', '1970-05-27', 'Jakarta', 'perempuan', 'Istri'),
(23, 31, '', 'Hanoman', '1989-05-23', 'Jakarta', 'laki-laki', 'Anak Ke-1');

-- --------------------------------------------------------

--
-- Table structure for table `fiscals`
--

CREATE TABLE IF NOT EXISTS `fiscals` (
  `date` varchar(6) NOT NULL DEFAULT '000000',
  `status` varchar(5) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `izin`
--

CREATE TABLE IF NOT EXISTS `izin` (
  `izin_id` int(11) NOT NULL AUTO_INCREMENT,
  `izin_staff_id` int(11) NOT NULL,
  `izin_date` date NOT NULL,
  `izin_jumlah_hari` int(11) NOT NULL,
  `izin_note` varchar(255) NOT NULL,
  PRIMARY KEY (`izin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `gltr_id` int(11) NOT NULL AUTO_INCREMENT,
  `gltr_date` date NOT NULL,
  `gltr_voucher` varchar(100) NOT NULL,
  `gltr_status` enum('New','Post') NOT NULL DEFAULT 'New',
  PRIMARY KEY (`gltr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kurs_pajak`
--

CREATE TABLE IF NOT EXISTS `kurs_pajak` (
  `kurs_id` int(11) NOT NULL AUTO_INCREMENT,
  `kurs_date` date NOT NULL,
  `kurs_us_rp` decimal(10,0) NOT NULL,
  `kurs_yen_rp` decimal(10,0) NOT NULL,
  PRIMARY KEY (`kurs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kurs_pajak`
--

INSERT INTO `kurs_pajak` (`kurs_id`, `kurs_date`, `kurs_us_rp`, `kurs_yen_rp`) VALUES
(1, '2013-05-15', 9590, 2839);

-- --------------------------------------------------------

--
-- Table structure for table `maritals_status`
--

CREATE TABLE IF NOT EXISTS `maritals_status` (
  `sn_id` int(11) NOT NULL AUTO_INCREMENT,
  `sn_name` varchar(50) NOT NULL,
  PRIMARY KEY (`sn_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `maritals_status`
--

INSERT INTO `maritals_status` (`sn_id`, `sn_name`) VALUES
(1, 'Single'),
(2, 'Married'),
(4, 'Divorce');

-- --------------------------------------------------------

--
-- Table structure for table `medical_histories`
--

CREATE TABLE IF NOT EXISTS `medical_histories` (
  `medic_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `medic_date` date NOT NULL,
  `medic_description` text NOT NULL,
  PRIMARY KEY (`medic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `medical_histories`
--

INSERT INTO `medical_histories` (`medic_id`, `staff_id`, `medic_date`, `medic_description`) VALUES
(3, 2, '2010-01-01', 'Flur'),
(4, 6, '2013-03-07', 'wahahah'),
(5, 6, '2013-03-29', 'Enak aja luh'),
(6, 6, '2013-03-28', 'gue cape tau!'),
(7, 7, '2013-03-25', 'Tipes'),
(8, 7, '2013-03-25', 'Maag'),
(9, 9, '2013-04-16', 'Masuk rumah sakit karena sakit'),
(10, 10, '2013-04-16', 'Masuk rumah sakit karena sakit'),
(11, 12, '2013-04-02', 'asd'),
(12, 13, '2013-04-02', 'asd'),
(13, 14, '2013-04-02', 'asd'),
(14, 19, '2013-04-18', 'asdasdasd'),
(15, 21, '2013-04-02', 'asdasd'),
(16, 22, '2013-04-02', 'asdasd'),
(17, 23, '2013-12-12', 'Flue wae'),
(18, 1, '2003-05-14', 'masuk rs'),
(19, 1, '2003-05-01', 'masuk hotel prodeo'),
(20, 1, '2003-05-29', 'masuk rm ampera'),
(22, 1, '2013-05-30', 'Hasemelekete'),
(23, 31, '2013-05-14', 'adasd');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`) VALUES
(1, 'Assets'),
(2, 'Branch'),
(3, 'Departments'),
(11, 'Staff'),
(12, 'Title'),
(15, 'Taxes_Employees'),
(16, 'Employee_Status'),
(17, 'Marital_Status'),
(18, 'Component');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_ticket`
--

CREATE TABLE IF NOT EXISTS `penjualan_ticket` (
  `tix_id` int(11) NOT NULL AUTO_INCREMENT,
  `tix_branch_id` int(11) NOT NULL,
  `tix_staff` int(11) NOT NULL,
  `tix_tour_id` int(11) NOT NULL,
  `tix_invoice_no` varchar(50) NOT NULL,
  `tix_date_time` datetime NOT NULL,
  `tix_agent_id` int(11) NOT NULL,
  `tix_name` varchar(50) NOT NULL,
  `tix_address` varchar(100) NOT NULL,
  `tix_due_date` date NOT NULL,
  `tix_biaya_surcharge_rp` decimal(8,2) NOT NULL,
  `tix_kurs_pajak` int(11) NOT NULL,
  `tix_status` varchar(20) NOT NULL DEFAULT 'new',
  `tix_glaccno_dr` decimal(18,2) NOT NULL,
  `tix_glaccno_cr` decimal(18,2) NOT NULL,
  PRIMARY KEY (`tix_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `penjualan_ticket`
--

INSERT INTO `penjualan_ticket` (`tix_id`, `tix_branch_id`, `tix_staff`, `tix_tour_id`, `tix_invoice_no`, `tix_date_time`, `tix_agent_id`, `tix_name`, `tix_address`, `tix_due_date`, `tix_biaya_surcharge_rp`, `tix_kurs_pajak`, `tix_status`, `tix_glaccno_dr`, `tix_glaccno_cr`) VALUES
(10, 1, 23, 1585, '0', '2012-10-09 00:00:00', 0, 'Dariel', 'Cikini bottom', '2013-05-29', 0.00, 9590, 'new', 12000.00, 185000.00),
(11, 1, 23, 123, '0', '2013-05-17 00:00:00', 0, 'Dariel', 'tead', '2013-05-14', 0.00, 9590, 'new', 16000000.00, 7000000.00),
(12, 1, 23, 758, '0', '2013-05-01 00:00:00', 1, 'Dariel', 'test', '2013-05-30', 0.00, 9590, 'new', 16000000.00, 7000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_ticket_detail`
--

CREATE TABLE IF NOT EXISTS `penjualan_ticket_detail` (
  `tix_id` int(11) NOT NULL,
  `tix_air` int(11) NOT NULL,
  `tix_route` varchar(80) NOT NULL,
  `tix_description` varchar(255) NOT NULL,
  `tix_price_rp` decimal(16,2) NOT NULL,
  `tix_price_us` decimal(16,2) NOT NULL,
  `tix_discount_rp` decimal(16,2) NOT NULL,
  `tix_discount_us` decimal(16,2) NOT NULL,
  `tix_komisi_rp` decimal(16,2) NOT NULL,
  `tix_komisi_us` decimal(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_ticket_detail`
--

INSERT INTO `penjualan_ticket_detail` (`tix_id`, `tix_air`, `tix_route`, `tix_description`, `tix_price_rp`, `tix_price_us`, `tix_discount_rp`, `tix_discount_us`, `tix_komisi_rp`, `tix_komisi_us`) VALUES
(10, 0, 'Arab Saudi', 'ini adalah test', 580000.00, 58.00, 0.00, 0.00, 58000.00, 6.00),
(11, 0, 'Arab Saudi', 'TEsatasdasd', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(12, 0, 'Arab Saudi', '', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE IF NOT EXISTS `salaries` (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_periode` date NOT NULL,
  `salary_staffid` int(11) NOT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salary_id`, `salary_periode`, `salary_staffid`) VALUES
(2, '2010-01-01', 3);

-- --------------------------------------------------------

--
-- Table structure for table `salary_components_a`
--

CREATE TABLE IF NOT EXISTS `salary_components_a` (
  `gaji_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `gaji_component_id` int(11) NOT NULL,
  `gaji_daily_value` decimal(10,0) NOT NULL,
  `gaji_amount_value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`gaji_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `salary_components_a`
--

INSERT INTO `salary_components_a` (`gaji_id`, `staff_id`, `gaji_component_id`, `gaji_daily_value`, `gaji_amount_value`) VALUES
(1, 7, 4, 0, 1000000),
(2, 7, 5, 0, 500000),
(3, 12, 4, 0, 1000000),
(4, 13, 0, 0, 2000000),
(5, 14, 4, 0, 1000000),
(6, 23, 4, 0, 120000000),
(7, 23, 5, 0, 1500000),
(24, 23, 6, 1000000, 0),
(25, 1, 4, 0, 100000),
(26, 1, 5, 0, 2000000),
(27, 1, 4, 0, 1800000);

-- --------------------------------------------------------

--
-- Table structure for table `salary_components_b`
--

CREATE TABLE IF NOT EXISTS `salary_components_b` (
  `gaji_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `gaji_component_id` int(11) NOT NULL,
  `gaji_daily_value` decimal(10,0) NOT NULL,
  `gaji_amount_value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`gaji_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `salary_components_b`
--

INSERT INTO `salary_components_b` (`gaji_id`, `staff_id`, `gaji_component_id`, `gaji_daily_value`, `gaji_amount_value`) VALUES
(1, 12, 5, 0, 1000000),
(2, 13, 5, 0, 1000000),
(3, 14, 5, 0, 1000000),
(4, 23, 7, 0, 5000000),
(5, 1, 7, 0, 1500000),
(6, 1, 6, 20000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'company_name', 'Rama Tours'),
(2, 'address', 'Bali'),
(3, 'phone', ''),
(4, 'fax', ''),
(5, 'email', ''),
(6, 'city', ''),
(7, 'no_npwp', ''),
(8, 'logo', 'logo6.jpg'),
(9, 'hrd_wp', '24300000'),
(10, 'hrd_tj_percent', '5'),
(11, 'hrd_tj_max', '6000000'),
(12, 'hrd_net1', '50000000'),
(13, 'hrd_net2', '250000000'),
(14, 'hrd_net3', '500000000'),
(15, 'hrd_pph_percent1', '5'),
(16, 'hrd_pph_percent2', '15'),
(17, 'hrd_pph_percent3', '25'),
(18, 'hrd_pph_percent4', '30'),
(19, 'invoice_note', '<p>Testing note invoice</p>\n'),
(20, 'invoice_number_length', 'jkt'),
(21, 'invoice_ticketing_ho_start', '015'),
(22, 'invoice_ticketing_jkt_start', '016'),
(23, 'invoice_ticketing_jog_start', '017'),
(24, 'code_behind_invoice', '018'),
(25, 'rti_start_from', '130'),
(26, 'rti_length', '8'),
(27, 'login_page_bg', 'cheap_bali_holidays.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE IF NOT EXISTS `staffs` (
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
  `staff_cabang` int(11) NOT NULL,
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
  `contract_number` int(11) NOT NULL,
  `contract_from` date NOT NULL,
  `contract_to` date NOT NULL,
  `date_out` date NOT NULL,
  `out_note` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `staff_nik`, `staff_kode_absen`, `staff_name`, `staff_address`, `staff_email`, `staff_email_alternatif`, `staff_phone_home`, `staff_phone_hp`, `staff_status_pajak`, `staff_status_nikah`, `staff_status_karyawan`, `staff_cabang`, `staff_departement`, `staff_jabatan`, `staff_photo`, `staff_birthdate`, `staff_birthplace`, `staff_sex`, `staff_password`, `pph_by_company`, `saldo_cuti`, `no_passport`, `passport_expired`, `no_kitas`, `kitas_expired`, `mulai_kerja`, `contract_number`, `contract_from`, `contract_to`, `date_out`, `out_note`) VALUES
(1, 6305280, '3101', 'Budi Setiawan', 'Jl. RE. Martadinata No. 15', 'budi@gmail.com', 'budi@gmail.com', '541000000', '082116914774', 'K1', 'Married', 'Tetap', 0, 'Transportation', 'Supervisor', '-', '1985-03-13', 'Bandung', 'laki-laki', 'd41d8cd98f00b204e9800998ecf8427e', 'y', 0, 0, '2013-05-08', 0, '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(2, 6305281, '3102', 'Puteri Berlianty', 'Komp. Margahayu Kencana Blok I 1 No. 19', 'jasmine@gmail.com', 'jasmine@gmail.com', '541000000', '08512121212', 'K2', 'Single', 'Tetap', 0, 'Accounting', 'Manager', '', '2011-03-21', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(23, 9874, '63052', 'Dariel pratama', 'Test', 'dr.iel_pra@yahoo.co.id', 'dr.iel_pra@yahoo.co.id', '6285721558525', '6285721558525', 'TK', 'Married', 'Tetap', 1, 'Accounting', 'Manager', '2012-10-27_14.09_.34_1.jpg', '2013-04-02', 'ciamis', 'laki-laki', 'd41d8cd98f00b204e9800998ecf8427e', 'y', 10, 0, '0000-00-00', 0, '0000-00-00', '2013-04-01', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(25, 6305280, '3104', 'Sunil Watir', 'Jl. RE. Martadinata No. 15', 'budi@gmail.com', 'budi@gmail.com', '541000000', '082116914774', 'K1', 'Married', 'Tetap', 0, 'Transportation', 'Supervisor', '-', '1985-03-13', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(26, 6305281, '3103', 'Michael Kurap', 'Komp. Margahayu Kencana Blok I 1 No. 19', 'jasmine@gmail.com', 'jasmine@gmail.com', '541000000', '08512121212', 'K2', 'Single', 'Tetap', 0, 'Accounting', 'Manager', '', '2011-03-21', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(27, 9874, '3105', 'Eman Si Pasi', 'Test', 'dr.iel_pra@yahoo.co.id', 'dr.iel_pra@yahoo.co.id', '6285721558525', '6285721558525', 'TK', 'Married', 'Tetap', 0, 'Accounting', 'Manager', '2012-10-27_14.09_.34_1.jpg', '2013-04-02', 'ciamis', 'laki-laki', 'd41d8cd98f00b204e9800998ecf8427e', 'y', 10, 0, '0000-00-00', 0, '0000-00-00', '2013-04-01', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(28, 6305280, '3106', 'Sanda', 'Jl. RE. Martadinata No. 15', 'budi@gmail.com', 'budi@gmail.com', '541000000', '082116914774', 'K1', 'Married', 'Tetap', 0, 'Transportation', 'Supervisor', '-', '1985-03-13', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(29, 6305281, '3107', 'Bara patirajawane', 'Komp. Margahayu Kencana Blok I 1 No. 19', 'jasmine@gmail.com', 'jasmine@gmail.com', '541000000', '08512121212', 'K2', 'Single', 'Tetap', 0, 'Accounting', 'Manager', '', '2011-03-21', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(30, 9874, '3108', 'Asep Balon', 'Test', 'dr.iel_pra@yahoo.co.id', 'dr.iel_pra@yahoo.co.id', '6285721558525', '6285721558525', 'TK', 'Married', 'Tetap', 0, 'Accounting', 'Manager', '2012-10-27_14.09_.34_1.jpg', '2013-04-02', 'ciamis', 'laki-laki', 'd41d8cd98f00b204e9800998ecf8427e', 'y', 10, 0, '0000-00-00', 0, '0000-00-00', '2013-04-01', 0, '0000-00-00', '0000-00-00', '0000-00-00', ''),
(31, 125788, '3109', 'Eyang Subur', 'Jakarta', 'suburban@suburjayamotor.com', '', '081212345678', '081212345678', 'TK', 'Single', 'Tetap', 0, 'Transportation', 'Manager', '', '2011-07-28', 'Bandung', 'laki-laki', 'd41d8cd98f00b204e9800998ecf8427e', 'n', 10, 0, '0000-00-00', 0, '0000-00-00', '2009-09-15', 1458, '2009-09-15', '2013-09-15', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_salaries`
--

CREATE TABLE IF NOT EXISTS `sub_salaries` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_id` int(11) NOT NULL,
  `salary_periode` date NOT NULL,
  `salary_component_id` int(11) NOT NULL,
  `salary_daily_value` decimal(10,0) NOT NULL,
  `salary_amount_value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sub_salaries`
--

INSERT INTO `sub_salaries` (`sub_id`, `salary_id`, `salary_periode`, `salary_component_id`, `salary_daily_value`, `salary_amount_value`) VALUES
(1, 2, '2013-01-01', 2013, 9000, 1500000),
(6, 2, '2010-01-01', 4, 0, 2350000);

-- --------------------------------------------------------

--
-- Table structure for table `taxes_employees`
--

CREATE TABLE IF NOT EXISTS `taxes_employees` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_status` varchar(3) NOT NULL,
  `sp_ptkp` int(11) NOT NULL,
  `sp_note` varchar(255) NOT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `taxes_employees`
--

INSERT INTO `taxes_employees` (`sp_id`, `sp_status`, `sp_ptkp`, `sp_note`) VALUES
(1, 'TK', 100000000, 'Test note'),
(2, 'K0', 1380000, ''),
(3, 'K1', 200, ''),
(4, 'K2', 300, ''),
(5, 'K3', 400, '');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_agent`
--

CREATE TABLE IF NOT EXISTS `ticket_agent` (
  `tixa_id` int(11) NOT NULL AUTO_INCREMENT,
  `tixa_code` varchar(50) NOT NULL,
  `tixa_name` varchar(100) NOT NULL,
  `tixa_address` varchar(255) NOT NULL,
  `tixa_city` varchar(50) NOT NULL,
  `tixa_since` date NOT NULL,
  `tixa_disable_date` date NOT NULL,
  `tixa_credit_limit_rp` decimal(18,2) NOT NULL,
  `tixa_credit_limit_us` decimal(18,2) NOT NULL,
  `tixa_glacc_dr` int(11) NOT NULL,
  `tixa_glacc_cr` int(11) NOT NULL,
  PRIMARY KEY (`tixa_id`),
  UNIQUE KEY `tixa_code` (`tixa_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ticket_agent`
--

INSERT INTO `ticket_agent` (`tixa_id`, `tixa_code`, `tixa_name`, `tixa_address`, `tixa_city`, `tixa_since`, `tixa_disable_date`, `tixa_credit_limit_rp`, `tixa_credit_limit_us`, `tixa_glacc_dr`, `tixa_glacc_cr`) VALUES
(1, 'BL1', 'Bali tourism', 'Ubud', 'Bali', '2003-11-05', '0000-00-00', 10000000.00, 1000.00, 2, 1),
(3, 'JKT1', 'Hari Tours & Travel', 'Pademangan', 'Jakarta', '2003-02-21', '0000-00-00', 10000000.00, 1000.00, 1, 2),
(5, 'R14K', 'Riak tours', 'Jl. Soekarno Hatta No.104, Bandung', 'Bandung City', '2011-06-08', '0000-00-00', 1500000.00, 150.00, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE IF NOT EXISTS `titles` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `title_name` varchar(20) NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`title_id`, `title_name`) VALUES
(1, 'Manager'),
(2, 'General Manager'),
(3, 'Supervisor'),
(5, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staff_id`, `username`, `password`, `avatar`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'helen1.jpg', 3, '2013-03-13 08:26:00', '2013-03-13 08:26:00'),
(2, 1, 'budi', 'd8578edf8458ce06fbc5bb76a58c5ca4', '', 1, '2013-03-19 08:57:32', '2013-03-19 08:57:32'),
(3, 23, 'dariel', 'e10adc3949ba59abbe56e057f20f883e', '', 3, '2013-04-22 08:54:25', '2013-04-22 08:54:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_roled`
--

CREATE TABLE IF NOT EXISTS `user_roled` (
  `roled_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `roled_view` tinyint(1) NOT NULL,
  `roled_add` tinyint(1) NOT NULL,
  `roled_edit` tinyint(1) NOT NULL,
  `roled_delete` tinyint(1) NOT NULL,
  `roled_approve` tinyint(1) NOT NULL,
  `roled_super` tinyint(1) NOT NULL COMMENT 'this role only used for "president"',
  PRIMARY KEY (`roled_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_roled`
--

INSERT INTO `user_roled` (`roled_id`, `role_id`, `module_id`, `roled_view`, `roled_add`, `roled_edit`, `roled_delete`, `roled_approve`, `roled_super`) VALUES
(2, 3, 1, 1, 1, 1, 1, 1, 1),
(3, 3, 2, 1, 1, 1, 1, 0, 1),
(4, 3, 3, 1, 1, 1, 1, 0, 1),
(5, 3, 11, 1, 1, 1, 1, 0, 1),
(6, 3, 12, 1, 1, 1, 1, 1, 1),
(8, 3, 15, 1, 1, 1, 1, 0, 1),
(9, 3, 16, 1, 1, 1, 1, 0, 1),
(10, 3, 17, 1, 1, 1, 1, 1, 1),
(11, 3, 18, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(3, 'President');

-- --------------------------------------------------------

--
-- Table structure for table `work_histories`
--

CREATE TABLE IF NOT EXISTS `work_histories` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `history_date` date NOT NULL,
  `history_description` text NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `work_histories`
--

INSERT INTO `work_histories` (`history_id`, `staff_id`, `history_date`, `history_description`) VALUES
(10, 2, '2013-09-09', 'Web Developer'),
(14, 3, '2013-04-03', 'IT Manager at PT.Waybe Home Appliance'),
(15, 9, '2013-04-01', 'SDT Krida Nusantara'),
(16, 10, '2013-04-01', 'SDT Krida Nusantara'),
(22, 21, '2013-04-17', 'adasdasd'),
(23, 22, '2013-04-17', 'adasdasd'),
(24, 23, '2013-04-30', '41Studio Inc'),
(32, 1, '2013-05-10', 'Jamsostek'),
(33, 1, '2013-05-22', 'Waybe'),
(35, 31, '2013-05-29', 'XTC'),
(36, 31, '2013-05-31', 'Moal Atuh'),
(37, 31, '2013-05-01', 'Hello World');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
