-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2013 at 02:22 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `staff_id`, `date`, `hari_masuk`) VALUES
(1, 1, '2013-04-10', 24),
(2, 2, '2013-04-10', 24),
(3, 7, '2013-04-10', 8);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_name` varchar(30) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `asset_status` enum('enable','disable') NOT NULL,
  `date_buy` date NOT NULL,
  `date_tempo` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`asset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`asset_id`, `asset_name`, `asset_code`, `asset_status`, `date_buy`, `date_tempo`, `description`, `staff_id`, `date`) VALUES
(1, 'Motor v-ixion 150', '', 'disable', '2013-04-02', '0000-00-00', '<p>Nopol : D6249JI</p>\n', 0, '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`edu_id`, `staff_id`, `edu_year`, `edu_gelar`, `edu_name`) VALUES
(5, 1, 2010, 'S1', 'Sarjana Informasi'),
(6, 1, 2011, 'S2', 'Teknik Informatika'),
(7, 2, 2010, 's1', 'Sarjana Informasi'),
(8, 1, 2005, '-', 'SMA Margahayu'),
(9, 1, 2000, '-', 'SMP Negri 1'),
(11, 22, 2013, 'asdasd', 'adada'),
(12, 23, 2013, 'Sarjana Teknik', 'UIN SGD Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `employees_status`
--

CREATE TABLE IF NOT EXISTS `employees_status` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `sk_name` varchar(10) NOT NULL,
  PRIMARY KEY (`sk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `employees_status`
--

INSERT INTO `employees_status` (`sk_id`, `sk_name`) VALUES
(1, 'Kontrak'),
(2, 'Tetap'),
(4, 'Freelance');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`staff_fam_id`, `staff_fam_staff_id`, `staff_fam_order`, `staff_fam_name`, `staff_fam_birthdate`, `staff_fam_birthplace`, `staff_fam_sex`, `staff_fam_relation`) VALUES
(3, 21, '', 'dad', '2018-09-30', 'a', 'perempuan', 'Ibu'),
(5, 23, '', 'Muhamad Kamaludin', '2023-01-27', 'Bandung', 'laki-laki', 'Ayah'),
(6, 23, '', 'Yayah Rodiah', '2013-04-02', 'Ciamis', 'perempuan', 'Ibu'),
(7, 23, '', 'Muhamad Dzulfikar', '2013-04-25', 'Bandung', 'laki-laki', 'Anak Ke-1');

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
-- Table structure for table `maritals_status`
--

CREATE TABLE IF NOT EXISTS `maritals_status` (
  `sn_id` int(11) NOT NULL AUTO_INCREMENT,
  `sn_name` varchar(8) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

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
(17, 23, '2013-12-12', 'Flue wae');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

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
(24, 23, 6, 1000000, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `salary_components_b`
--

INSERT INTO `salary_components_b` (`gaji_id`, `staff_id`, `gaji_component_id`, `gaji_daily_value`, `gaji_amount_value`) VALUES
(1, 12, 5, 0, 1000000),
(2, 13, 5, 0, 1000000),
(3, 14, 5, 0, 1000000),
(4, 23, 7, 0, 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'COMPANY_NAME', 'Rama Tours'),
(2, 'ADDRESS', 'Jl. Riau No. 265'),
(3, 'COMPANY_PHONE', '(022) 6798 987 89'),
(4, 'PPH21_PERCENT', '10'),
(5, 'PENSIUN', 'N'),
(6, 'LOGO', '-');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `staff_nik`, `staff_kode_absen`, `staff_name`, `staff_address`, `staff_email`, `staff_email_alternatif`, `staff_phone_home`, `staff_phone_hp`, `staff_status_pajak`, `staff_status_nikah`, `staff_status_karyawan`, `staff_cabang`, `staff_departement`, `staff_jabatan`, `staff_photo`, `staff_birthdate`, `staff_birthplace`, `staff_sex`, `staff_password`, `pph_by_company`, `saldo_cuti`, `no_passport`, `passport_expired`, `no_kitas`, `kitas_expired`, `mulai_kerja`, `contract_from`, `contract_to`, `date_out`, `out_note`) VALUES
(1, 6305280, '3101', 'Budi Setiawan', 'Jl. RE. Martadinata No. 15', 'budi@gmail.com', 'budi@gmail.com', '541000000', '082116914774', 'K1', 'Married', 'Tetap', 'Bandung', 'Transportation', 'Supervisor', '-', '1985-03-13', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(2, 6305281, '3102', 'Puteri Berlianty', 'Komp. Margahayu Kencana Blok I 1 No. 19', 'jasmine@gmail.com', 'jasmine@gmail.com', '541000000', '08512121212', 'K2', 'Single', 'Tetap', 'Bandung', 'Accounting', 'Manager', '', '2011-03-21', 'Bandung', '', '', 'y', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(22, 1337, '12354', 'Dariel pratama', '', 'dr.iel_pra@yahoo.co.id', 'dr.iel_pra@yahoo.co.id', '6285721558525', '6285721558525', '', '', '', '', '', '', '', '0000-00-00', '', 'laki-laki', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'n', 0, 0, '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(23, 9874, '63052', 'Dariel pratama', 'Test', 'dr.iel_pra@yahoo.co.id', 'dr.iel_pra@yahoo.co.id', '6285721558525', '6285721558525', 'TK', 'Married', 'Tetap', 'Bandung', 'Accounting', 'Manager', '2012-10-27_14.09_.34_1.jpg', '2013-04-02', 'ciamis', 'laki-laki', 'd41d8cd98f00b204e9800998ecf8427e', 'y', 10, 0, '0000-00-00', 0, '0000-00-00', '2013-04-01', '0000-00-00', '0000-00-00', '0000-00-00', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staff_id`, `username`, `password`, `avatar`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'd8578edf8458ce06fbc5bb76a58c5ca4', '-', 1, '2013-03-13 08:26:00', '2013-03-13 08:26:00'),
(2, 1, 'budi', 'd8578edf8458ce06fbc5bb76a58c5ca4', '', 1, '2013-03-19 08:57:32', '2013-03-19 08:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_roled`
--

CREATE TABLE IF NOT EXISTS `user_roled` (
  `roled_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `roled_module` varchar(50) NOT NULL,
  `roled_add` tinyint(1) NOT NULL,
  `roled_edit` tinyint(1) NOT NULL,
  `roled_delete` tinyint(1) NOT NULL,
  `roled_approval` tinyint(1) NOT NULL,
  `roled_select` tinyint(1) NOT NULL,
  PRIMARY KEY (`roled_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `user_roled`
--

INSERT INTO `user_roled` (`roled_id`, `role_id`, `roled_module`, `roled_add`, `roled_edit`, `roled_delete`, `roled_approval`, `roled_select`) VALUES
(1, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(2, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(3, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(4, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(5, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(6, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(7, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(8, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(9, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(10, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(11, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(12, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(13, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(14, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(15, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(16, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(17, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(18, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(19, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(20, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(21, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(22, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(23, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(24, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(25, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(26, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(27, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(28, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(29, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(30, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(31, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(32, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(33, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(34, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(35, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(36, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(37, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(38, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(39, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(40, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(41, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(42, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(43, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(44, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(45, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(46, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(47, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(48, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(49, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(50, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(51, 1, 'Employees_Status', 1, 1, 1, 1, 0),
(52, 1, 'Work_Histories', 1, 1, 1, 1, 1),
(53, 1, 'Staffs', 1, 1, 1, 1, 1),
(54, 1, 'Absensi', 1, 1, 1, 1, 1),
(55, 1, 'Departments', 1, 1, 1, 1, 1),
(56, 1, 'Searches', 1, 1, 1, 1, 1),
(57, 1, 'Izin', 1, 1, 1, 1, 1),
(58, 1, 'Assets_Details', 1, 1, 1, 1, 1),
(59, 1, 'Maritals_Status', 1, 1, 1, 1, 1),
(60, 1, 'Salary_Components', 1, 1, 1, 1, 1),
(61, 1, 'Branches', 1, 1, 1, 1, 1),
(62, 1, 'Assets', 1, 1, 1, 1, 1),
(63, 1, 'Titles', 1, 1, 1, 1, 1),
(64, 1, 'Educations', 1, 1, 1, 1, 1),
(65, 1, 'Families', 1, 0, 1, 1, 1),
(66, 1, 'Components', 1, 1, 1, 1, 1),
(67, 1, 'Users', 1, 1, 1, 1, 1),
(68, 1, 'Sub_Salaries', 1, 1, 1, 1, 1),
(69, 1, 'Taxes_Employees', 1, 1, 1, 1, 1),
(70, 1, 'Index', 1, 1, 1, 1, 1),
(71, 1, 'Role_Details', 1, 1, 1, 1, 1),
(72, 1, 'Cuti', 1, 1, 1, 1, 1),
(73, 1, 'Salaries', 1, 1, 1, 1, 1),
(74, 1, 'Medical_Histories', 1, 1, 1, 1, 1),
(75, 1, 'Settings', 1, 1, 1, 1, 1),
(76, 1, 'Welcome', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(1, 'root');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `work_histories`
--

INSERT INTO `work_histories` (`history_id`, `staff_id`, `history_date`, `history_description`) VALUES
(10, 2, '2013-09-09', 'Web Developer'),
(11, 1, '2000-03-21', 'EDP Bank BRI'),
(12, 1, '0000-00-00', '0'),
(13, 1, '2012-03-21', 'Manager Marketing Garuda Travel'),
(14, 3, '2013-04-03', 'IT Manager at PT.Waybe Home Appliance'),
(15, 9, '2013-04-01', 'SDT Krida Nusantara'),
(16, 10, '2013-04-01', 'SDT Krida Nusantara'),
(22, 21, '2013-04-17', 'adasdasd'),
(23, 22, '2013-04-17', 'adasdasd'),
(24, 23, '2013-04-30', '41Studio Inc');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
