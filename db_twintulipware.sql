-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2016 at 06:54 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_twintulipware`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_omzet`(node_id int(11),`unit_id` int(11),`tgl1` date,`tgl2` date) RETURNS int(11)
BEGIN
declare l int(11) default 0;

	select sum(ifnull(inttotal_omset,0)) into l
	from nota n
	where n.intid_dealer = node_id and n.intid_unit = unit_id
		and n.datetgl >= tgl1 and n.datetgl <= tgl2 and n.intid_jpenjualan = 1 and n.is_dp = 0;

	RETURN ifnull(l,0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_omzet_pv`(node_id int(11),`unit_id` int(11),`tgl1` date,`tgl2` date) RETURNS int(11)
BEGIN
declare l int(11) default 0;

	select sum(ifnull(inttotal_omset,0)) into l
	from nota n
	where n.intid_dealer = node_id and n.intid_unit = unit_id
		and n.datetgl >= tgl1 and n.datetgl <= tgl2 and n.intid_jpenjualan not in(7, 8, 10, 11) and n.is_dp = 0;

	RETURN ifnull(l,0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_pv`(node_id int(11),`unit_id` int(11),`tgl1` date,`tgl2` date) RETURNS decimal(2,0)
BEGIN
declare l decimal(2,0) default 0;

	select sum(ifnull(intpv,0)) into l
	from nota n
	where n.intid_dealer = node_id and n.intid_unit = unit_id and n.is_dp = 0
		and n.datetgl >= tgl1 and n.datetgl <= tgl2;

	RETURN ifnull(l,0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `member_hier_pv`(`node_id2` char(20),`unit_id2` int(11), tgl1 date, tgl2 date) RETURNS decimal(2,0)
BEGIN
declare v_done char(20) default 0;
declare v_depth INT(11) default 0;
declare v_sum decimal(2,0) default 0;

delete from hier2;
delete from tmp2;

insert into hier2 select strkode_upline,strkode_dealer, v_depth 
from member where strkode_dealer = node_id2 and intid_unit = unit_id2;

insert into tmp2 select strkode_upline,strkode_dealer, v_depth 
from member where strkode_dealer = node_id2 and intid_unit = unit_id2;

while not v_done do

    if exists( select 1 from member ppp
								inner join hier2 on ppp.strkode_upline = hier2.strkode_dealer
								and hier2.depth = v_depth) then

        insert into hier2
            select ppp.strkode_upline, ppp.strkode_dealer,  v_depth + 1 
						from member ppp
            inner join tmp2 on ppp.strkode_upline = tmp2.strkode_dealer
						and tmp2.depth = v_depth;

        set v_depth = v_depth + 1;          

        delete from tmp2;
				insert into tmp2 select * from hier2 where depth = v_depth;

    else
        set v_done = 1;
    end if;

end while;

select sum(omset) into v_sum from (
select 
 (select sum(ifnull(nnn.intpv,0)) from nota nnn
	where nnn.intid_dealer = ppp.intid_dealer and (nnn.datetgl >= tgl1 or tgl1 is null)and (nnn.datetgl <= tgl2 or tgl2 is null)
		and nnn.intid_unit = unit_id2) omset
from
 hier2 
inner join member ppp on hier2.strkode_dealer = ppp.strkode_dealer
inner join member bbb on hier2.strkode_upline = bbb.strkode_dealer
where ppp.intid_unit = unit_id2
)xxx;

return ifnull(v_sum,0);

end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `member_hier_sum`(`node_id2` char(20),`unit_id2` int(11), tgl1 date, tgl2 date) RETURNS int(11)
BEGIN
declare v_done char(20) default 0;
declare v_depth INT(11) default 0;
declare v_sum int(11) default 0;

delete from hier2;
delete from tmp2;

insert into hier2 select strkode_upline,strkode_dealer, v_depth 
from member where strkode_dealer = node_id2 and intid_unit = unit_id2;

insert into tmp2 select strkode_upline,strkode_dealer, v_depth 
from member where strkode_dealer = node_id2 and intid_unit = unit_id2;

while not v_done do

    if exists( select 1 from member ppp
								inner join hier2 on ppp.strkode_upline = hier2.strkode_dealer
								and hier2.depth = v_depth) then

        insert into hier2
            select ppp.strkode_upline, ppp.strkode_dealer,  v_depth + 1 
						from member ppp
            inner join tmp2 on ppp.strkode_upline = tmp2.strkode_dealer
						and tmp2.depth = v_depth;

        set v_depth = v_depth + 1;          

        delete from tmp2;
				insert into tmp2 select * from hier2 where depth = v_depth;

    else
        set v_done = 1;
    end if;

end while;

select sum(omset) into v_sum from (
select 
 (select sum(ifnull(nnn.inttotal_omset,0)) from nota nnn
	where nnn.intid_dealer = ppp.intid_dealer and (nnn.datetgl >= tgl1 or tgl1 is null)and (nnn.datetgl <= tgl2 or tgl2 is null)
		and nnn.intid_unit = unit_id2 and nnn.intid_jpenjualan = 1 and nnn.is_dp = 0) omset
from
 hier2 
inner join member ppp on hier2.strkode_dealer = ppp.strkode_dealer
inner join member bbb on hier2.strkode_upline = bbb.strkode_dealer
where ppp.intid_unit = unit_id2
)xxx;

return ifnull(v_sum,0);

end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `member_hier_sum_pv`(`node_id2` char(20),`unit_id2` int(11), tgl1 date, tgl2 date) RETURNS int(11)
BEGIN
declare v_done char(20) default 0;
declare v_depth INT(11) default 0;
declare v_sum int(11) default 0;

delete from hier2;
delete from tmp2;

insert into hier2 select strkode_upline,strkode_dealer, v_depth 
from member where strkode_dealer = node_id2 and intid_unit = unit_id2;

insert into tmp2 select strkode_upline,strkode_dealer, v_depth 
from member where strkode_dealer = node_id2 and intid_unit = unit_id2;

while not v_done do

    if exists( select 1 from member ppp
								inner join hier2 on ppp.strkode_upline = hier2.strkode_dealer
								and hier2.depth = v_depth) then

        insert into hier2
            select ppp.strkode_upline, ppp.strkode_dealer,  v_depth + 1 
						from member ppp
            inner join tmp2 on ppp.strkode_upline = tmp2.strkode_dealer
						and tmp2.depth = v_depth;

        set v_depth = v_depth + 1;          

        delete from tmp2;
				insert into tmp2 select * from hier2 where depth = v_depth;

    else
        set v_done = 1;
    end if;

end while;

select sum(omset) into v_sum from (
select 
 (select sum(ifnull(nnn.inttotal_omset,0)) from nota nnn
	where nnn.intid_dealer = ppp.intid_dealer and (nnn.datetgl >= tgl1 or tgl1 is null)and (nnn.datetgl <= tgl2 or tgl2 is null)
		and nnn.intid_unit = unit_id2 and nnn.intid_jpenjualan not in (7, 8, 10, 11) and nnn.is_dp = 0) omset
from
 hier2 
inner join member ppp on hier2.strkode_dealer = ppp.strkode_dealer
inner join member bbb on hier2.strkode_upline = bbb.strkode_dealer
where ppp.intid_unit = unit_id2
)xxx;

return ifnull(v_sum,0);

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `env_ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id_user`, `name`, `activity`, `uri`, `env_ip`, `browser`, `version`, `platform`, `user_agent`, `date`) VALUES
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 06:49:32'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 08:05:09'),
(1, 'admin', 'logout', 'localhost/tulip-demo/login/logout', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 08:09:36'),
(76, 'depok 2', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 08:09:45'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 08:33:59'),
(NULL, NULL, 'logout', 'localhost/tulip-demo/login/logout', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 09:14:38'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 09:28:03'),
(NULL, NULL, 'logout', 'localhost/tulip-demo/login/logout', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 09:47:07'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 09:47:18'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 11:45:41'),
(1, 'admin', 'logout', 'localhost/tulip-demo/login/logout', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 11:45:47'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2015-12-31 12:02:14'),
(1, 'admin', 'login', 'localhost/tulip-demo/login', '::1', 'Google Chrome', '47.0.2526.106', 'windows', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '2016-01-02 06:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `intid_barang` int(8) NOT NULL AUTO_INCREMENT,
  `intid_jsatuan` int(8) NOT NULL,
  `strnama` varchar(100) NOT NULL,
  `intid_jbarang` int(8) NOT NULL,
  `intqty` int(11) NOT NULL,
  `status_barang` int(11) DEFAULT '1',
  `is_hadiah` tinyint(1) DEFAULT '0',
  `is_sparepart` tinyint(1) DEFAULT '1',
  `tanggal_awal` date NOT NULL DEFAULT '0000-00-00',
  `tanggal_akhir` date NOT NULL DEFAULT '0000-00-00',
  `code` varchar(8) NOT NULL DEFAULT '0',
  `is_po` int(1) NOT NULL DEFAULT '1',
  `kode_pabrik` varchar(255) NOT NULL,
  `nama_pabrik` varchar(255) NOT NULL,
  PRIMARY KEY (`intid_barang`),
  KEY `intid_barang` (`intid_barang`),
  KEY `intid_barang_2` (`intid_barang`),
  KEY `intid_jsatuan` (`intid_jsatuan`,`intid_jbarang`),
  KEY `intid_jsatuan_2` (`intid_jsatuan`),
  KEY `intid_jbarang` (`intid_jbarang`),
  KEY `status_barang` (`status_barang`),
  KEY `is_hadiah` (`is_hadiah`),
  KEY `is_sparepart` (`is_sparepart`),
  KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9956 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`intid_barang`, `intid_jsatuan`, `strnama`, `intid_jbarang`, `intqty`, `status_barang`, `is_hadiah`, `is_sparepart`, `tanggal_awal`, `tanggal_akhir`, `code`, `is_po`, `kode_pabrik`, `nama_pabrik`) VALUES
(9950, 1, 'Happy Little Set Blue Diamond', 1, 0, 1, 1, 0, '2015-01-05', '2016-01-31', '321', 1, 'UB 321 BD', 'HAPPY LITTLE BLUE DIAMOND'),
(9952, 1, 'Happy Little Set Lady', 1, 0, 1, 1, 0, '2015-01-05', '2016-01-31', '321', 1, 'UB 321 VI', 'HAPPY LITTLE LADY'),
(9953, 1, 'Happy Little Set Pink Lady', 1, 0, 1, 1, 0, '2015-01-05', '2016-01-31', '321', 1, 'UB 321 PL', 'HAPPY LITTLE PINK LADY'),
(9954, 1, 'Happy Little Set Princess', 1, 0, 1, 1, 0, '2015-01-05', '2016-01-31', '321', 1, 'UB 321 AV', 'HAPPY LITTLE PRINCESS'),
(9955, 1, 'Happy Little Set Queen', 1, 0, 1, 1, 0, '2015-01-05', '2016-01-31', '321', 1, 'UB 321 QN', 'HAPPY LITTLE QUEEN');

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE IF NOT EXISTS `cabang` (
  `intid_cabang` int(8) NOT NULL AUTO_INCREMENT,
  `intkode_cabang` int(3) DEFAULT NULL,
  `jenis_cabang` enum('Cabang','BZ','SC') DEFAULT NULL,
  `intid_wilayah` int(8) DEFAULT NULL,
  `strnama_cabang` varchar(50) DEFAULT NULL,
  `strkepala_cabang` varchar(50) DEFAULT NULL,
  `stradm_cabang` varchar(50) DEFAULT NULL,
  `stralamat` text,
  `strtelepon` varchar(30) DEFAULT NULL,
  `strket` varchar(50) DEFAULT NULL,
  `fee` float NOT NULL DEFAULT '0',
  `is_scanner` tinyint(4) DEFAULT '0',
  `is_nota` tinyint(11) DEFAULT '1',
  `is_dp` tinyint(11) DEFAULT '0',
  `is_launch` tinyint(4) DEFAULT '0',
  `is_gathering` int(11) NOT NULL DEFAULT '1',
  `id_region` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intid_cabang`),
  KEY `intid_cabang` (`intid_cabang`),
  KEY `jenis_cabang` (`jenis_cabang`),
  KEY `intkode_cabang` (`intkode_cabang`),
  KEY `jenis_cabang_2` (`jenis_cabang`),
  KEY `intid_cabang_2` (`intid_cabang`,`intkode_cabang`,`jenis_cabang`,`intid_wilayah`),
  KEY `intkode_cabang_2` (`intkode_cabang`,`jenis_cabang`,`intid_wilayah`,`is_scanner`,`is_nota`,`is_dp`,`is_launch`,`is_gathering`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`intid_cabang`, `intkode_cabang`, `jenis_cabang`, `intid_wilayah`, `strnama_cabang`, `strkepala_cabang`, `stradm_cabang`, `stralamat`, `strtelepon`, `strket`, `fee`, `is_scanner`, `is_nota`, `is_dp`, `is_launch`, `is_gathering`, `id_region`) VALUES
(1, 1, 'Cabang', 1, 'Admin', 'Administrator', 'Admin', 'Jl. Wastukencana no 14 Bandung', NULL, NULL, 0, 1, 1, 1, 0, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('2fe47e6202ce4e0c4c42cab856c299e2', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1451712847, ''),
('dece803adcc51d3f8f722778a15fb883', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1451713606, ''),
('e90d62afbb1ae87f9dc5dae1aaa92475', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1451714023, 'a:10:{s:5:"token";s:32:"f2009ef1daaf601a33302256b154c4bb";s:9:"logged_as";s:17:"Administrator (1)";s:6:"userid";s:1:"1";s:7:"id_user";s:1:"1";s:8:"username";s:5:"admin";s:9:"privilege";s:1:"1";s:7:"is_nota";s:1:"1";s:5:"is_dp";s:1:"1";s:12:"is_logged_in";b:1;s:18:"notaControl_tokens";s:32:"190933ca3bb3be65832113a423a69a43";}');

-- --------------------------------------------------------

--
-- Table structure for table `control_barang_baru`
--

CREATE TABLE IF NOT EXISTS `control_barang_baru` (
  `id_control_barang` int(50) NOT NULL AUTO_INCREMENT,
  `id_control_promo` int(11) NOT NULL,
  `id_control_combo` int(11) NOT NULL DEFAULT '0',
  `id_group_class` int(11) NOT NULL DEFAULT '0',
  `qtybayar` int(11) NOT NULL,
  `qtyfree` int(11) NOT NULL,
  `tglawal` date NOT NULL,
  `tglakhir` date NOT NULL,
  `intid_barang` int(15) NOT NULL,
  `code_barang` varchar(100) NOT NULL,
  `intid_barang_free` int(15) NOT NULL,
  `status_pencarian` varchar(100) NOT NULL,
  `intharga_jawa` int(15) NOT NULL DEFAULT '0',
  `intharga_luarjawa` int(15) NOT NULL DEFAULT '0',
  `intharga_luarkualalumpur` decimal(10,2) NOT NULL DEFAULT '0.00',
  `intpv_jawa` decimal(10,2) NOT NULL DEFAULT '0.00',
  `intpv_luarjawa` decimal(10,2) NOT NULL DEFAULT '0.00',
  `intpv_luarkualalumpur` decimal(10,2) NOT NULL DEFAULT '0.00',
  `intid_cabang` int(11) NOT NULL DEFAULT '0',
  `intid_wilayah` varchar(10) NOT NULL,
  PRIMARY KEY (`id_control_barang`),
  KEY `tglawal` (`tglawal`,`tglakhir`,`status_pencarian`,`intid_cabang`,`intid_wilayah`),
  KEY `tglawal_2` (`tglawal`,`tglakhir`,`intid_barang`,`intid_barang_free`,`intid_cabang`,`intid_wilayah`),
  KEY `id_control_combo` (`id_control_combo`),
  KEY `id_control_combo_2` (`id_control_combo`),
  KEY `qtybayar` (`qtybayar`),
  KEY `qtyfree` (`qtyfree`),
  KEY `code_barang` (`code_barang`),
  KEY `intid_cabang` (`intid_cabang`),
  KEY `intid_cabang_2` (`intid_cabang`),
  KEY `id_group_class` (`id_group_class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `control_batas`
--

CREATE TABLE IF NOT EXISTS `control_batas` (
  `id_control_batas` int(11) NOT NULL AUTO_INCREMENT,
  `id_control_promo` int(11) NOT NULL,
  `intid_cabang` int(11) NOT NULL DEFAULT '0',
  `batas_min` decimal(15,2) NOT NULL DEFAULT '0.00',
  `batas_max` decimal(15,2) NOT NULL DEFAULT '0.00',
  `diskon` decimal(15,3) NOT NULL DEFAULT '1.000',
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_control_batas`),
  KEY `id_control_promo` (`id_control_promo`) USING BTREE,
  KEY `intid_cabang` (`intid_cabang`) USING BTREE,
  KEY `is_active` (`is_active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `control_cabang_jenis_penjualan`
--

CREATE TABLE IF NOT EXISTS `control_cabang_jenis_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_penjualan` text NOT NULL,
  `intid_cabang` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `control_cabang_jenis_penjualan`
--

INSERT INTO `control_cabang_jenis_penjualan` (`id`, `id_jenis_penjualan`, `intid_cabang`, `is_active`) VALUES
(1, '1,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,27,28,29', '0', 1),
(2, '26', '58', 0),
(6, '1', '1', 1),
(4, '2,3', '0', 0),
(5, '16', '20', 0),
(3, '26', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `control_cabang_promo`
--

CREATE TABLE IF NOT EXISTS `control_cabang_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_control_promo` varchar(500) NOT NULL,
  `id_control_batas` varchar(100) NOT NULL,
  `intid_cabang` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `is_voucher` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`id_control_promo`,`intid_cabang`),
  KEY `is_active` (`is_active`),
  KEY `id_control_batas` (`id_control_batas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=595 ;

--
-- Dumping data for table `control_cabang_promo`
--

INSERT INTO `control_cabang_promo` (`id`, `id_control_promo`, `id_control_batas`, `intid_cabang`, `is_active`, `tgl_mulai`, `tgl_akhir`, `is_voucher`) VALUES
(594, '1', '0', 0, 1, '2016-01-01', '2016-01-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `control_class`
--

CREATE TABLE IF NOT EXISTS `control_class` (
  `id_control_class` int(11) NOT NULL AUTO_INCREMENT,
  `id_jpenjualan` int(11) NOT NULL,
  `id_control_promo` int(11) NOT NULL,
  `diskon` decimal(10,2) NOT NULL DEFAULT '1.00',
  `kom10` enum('0','1') NOT NULL DEFAULT '0',
  `kom15` enum('0','1') NOT NULL DEFAULT '0',
  `kom20` enum('0','1') NOT NULL DEFAULT '0',
  `totomset` enum('0','1') NOT NULL DEFAULT '0',
  `pv` enum('0','1') DEFAULT '0',
  `stat_bayar` int(11) NOT NULL DEFAULT '1',
  `stat_free` int(11) NOT NULL DEFAULT '0',
  `lookup_url` enum('lookup/lookupBarang','lookup/lookupBarangBlue','lookup/lookupBarangCombo','lookup/lookupBarangCustom','lookup/lookupBarangLainlain','lookup/lookupBarangMetal','lookup/lookupBarangSparepart','lookup/lookupBarangDestiny','lookup_destiny/lookupBarang','lookup/lookupBarangTulip','lookup/lookupBarangTulipNoBlue') NOT NULL DEFAULT 'lookup/lookupBarang',
  `lookup_url_free` enum('lookup/lookupBarang','lookup/lookupBarangBlue','lookup/lookupBarangFreeCode','lookup/lookupBarangFree','lookup/lookupBarangDestiny','lookup_destiny/lookupBarang') NOT NULL DEFAULT 'lookup/lookupBarangFree',
  `id_destiny` int(11) NOT NULL DEFAULT '0',
  `plugin` enum('0','plugin/voucherGen') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_control_class`),
  KEY `id_jpenjualan` (`id_jpenjualan`,`id_control_promo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

--
-- Dumping data for table `control_class`
--

INSERT INTO `control_class` (`id_control_class`, `id_jpenjualan`, `id_control_promo`, `diskon`, `kom10`, `kom15`, `kom20`, `totomset`, `pv`, `stat_bayar`, `stat_free`, `lookup_url`, `lookup_url_free`, `id_destiny`, `plugin`) VALUES
(1, 1, 1, '1.00', '0', '0', '1', '1', '1', 1, 0, 'lookup/lookupBarang', 'lookup/lookupBarangFree', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `control_class_baru`
--

CREATE TABLE IF NOT EXISTS `control_class_baru` (
  `id_control_class` int(11) NOT NULL AUTO_INCREMENT,
  `id_jpenjualan` int(11) NOT NULL,
  `id_control_promo` int(11) NOT NULL,
  `status_pencarian` varchar(100) NOT NULL,
  `diskon` decimal(10,2) NOT NULL DEFAULT '1.00',
  `kom10` enum('0','1') NOT NULL DEFAULT '0',
  `kom15` enum('0','1') NOT NULL DEFAULT '0',
  `kom20` enum('0','1') NOT NULL DEFAULT '0',
  `totomset` enum('0','1') NOT NULL DEFAULT '0',
  `pv` enum('0','1') DEFAULT '0',
  `stat_bayar` int(11) NOT NULL DEFAULT '1',
  `stat_free` int(11) NOT NULL DEFAULT '0',
  `is_voucher` tinyint(4) NOT NULL DEFAULT '0',
  `is_komtam` tinyint(4) NOT NULL DEFAULT '0',
  `lookup_url` enum('lookup/lookupBarang','lookup_destiny/lookupBarang','lookup/lookupBarangCombo') NOT NULL DEFAULT 'lookup/lookupBarang',
  `lookup_url_free` enum('lookup/lookupBarangFree','lookup_destiny/lookupBarangFree') NOT NULL DEFAULT 'lookup/lookupBarangFree',
  `id_destiny` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_control_class`),
  KEY `id_jpenjualan` (`id_jpenjualan`,`id_control_promo`),
  KEY `status_pencarian` (`status_pencarian`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `control_class_baru`
--

INSERT INTO `control_class_baru` (`id_control_class`, `id_jpenjualan`, `id_control_promo`, `status_pencarian`, `diskon`, `kom10`, `kom15`, `kom20`, `totomset`, `pv`, `stat_bayar`, `stat_free`, `is_voucher`, `is_komtam`, `lookup_url`, `lookup_url_free`, `id_destiny`) VALUES
(1, 1, 4, '', '0.50', '1', '0', '0', '1', '1', 1, 0, 0, 0, 'lookup/lookupBarang', 'lookup/lookupBarangFree', 0);

-- --------------------------------------------------------

--
-- Table structure for table `control_lookup`
--

CREATE TABLE IF NOT EXISTS `control_lookup` (
  `id_lookup` int(11) NOT NULL AUTO_INCREMENT,
  `id_control_promo_tebus` int(11) NOT NULL,
  `lookup_url` varchar(250) NOT NULL,
  `view_url` enum('tebus_omset/form','tebus_member/form','tebus_barang/form') NOT NULL,
  PRIMARY KEY (`id_lookup`),
  KEY `id_control_promo_tebus` (`id_control_promo_tebus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `control_lookup`
--

INSERT INTO `control_lookup` (`id_lookup`, `id_control_promo_tebus`, `lookup_url`, `view_url`) VALUES
(1, 1, '#', 'tebus_omset/form');

-- --------------------------------------------------------

--
-- Table structure for table `control_plugin`
--

CREATE TABLE IF NOT EXISTS `control_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intid_cabang` int(3) NOT NULL DEFAULT '0',
  `intid_promo` int(11) NOT NULL,
  `intid_jpenjualan` int(11) NOT NULL DEFAULT '0',
  `plugin` enum('template/plugin/voucher_nota','template/plugin/voucher') NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `intid_cabang` (`intid_cabang`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `control_program`
--

CREATE TABLE IF NOT EXISTS `control_program` (
  `id_control_program` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `max` int(11) NOT NULL DEFAULT '0',
  `jawa` int(11) NOT NULL DEFAULT '0',
  `luar_jawa` int(11) NOT NULL DEFAULT '0',
  `id_control_promo` int(3) NOT NULL DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_control_program`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=124 ;

-- --------------------------------------------------------

--
-- Table structure for table `control_promo_baru`
--

CREATE TABLE IF NOT EXISTS `control_promo_baru` (
  `intid_control_promo` int(11) NOT NULL AUTO_INCREMENT,
  `intid_jpenjualan` varchar(20) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `nama_promo` varchar(200) NOT NULL,
  `intid_wilayah` varchar(100) NOT NULL DEFAULT '1,2,3,4',
  `pencarian` varchar(20) NOT NULL DEFAULT 'default',
  `id_control_status` int(2) NOT NULL DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `nama_id` varchar(100) NOT NULL,
  `is_Con_B` int(1) NOT NULL DEFAULT '0',
  `is_pengejaranChall` int(11) NOT NULL DEFAULT '0',
  `is_pengejaran` int(11) NOT NULL DEFAULT '0',
  `is_pengejaranNG` int(11) NOT NULL DEFAULT '0',
  `is_komtam` int(1) NOT NULL DEFAULT '0',
  `is_voucher` int(1) NOT NULL DEFAULT '0',
  `is_tebus` enum('1','0') NOT NULL DEFAULT '0',
  `view` enum('template/form_addBrg.php','template/form_addBrg_destiny.php','template/form_addBrg_fh.php','template/form_addPaket.php') NOT NULL DEFAULT 'template/form_addBrg.php',
  PRIMARY KEY (`intid_control_promo`),
  KEY `is_Con_B` (`is_Con_B`),
  KEY `is_pengejaranChall` (`is_pengejaranChall`),
  KEY `is_pengejaranChall_2` (`is_pengejaranChall`),
  KEY `is_pengejaranNG` (`is_pengejaranNG`),
  KEY `is_komtam` (`is_komtam`),
  KEY `is_voucher` (`is_voucher`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `control_promo_baru`
--

INSERT INTO `control_promo_baru` (`intid_control_promo`, `intid_jpenjualan`, `tanggal_mulai`, `tanggal_akhir`, `nama_promo`, `intid_wilayah`, `pencarian`, `id_control_status`, `is_active`, `nama_id`, `is_Con_B`, `is_pengejaranChall`, `is_pengejaran`, `is_pengejaranNG`, `is_komtam`, `is_voucher`, `is_tebus`, `view`) VALUES
(1, '1, 2, 4', '2015-02-27', '2016-01-09', 'Promo Lunas', '1, 2,4', 'default', 0, 1, '', 0, 0, 0, 0, 0, 1, '0', 'template/form_addBrg.php');

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE IF NOT EXISTS `counter` (
  `id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`id`) VALUES
(43);

-- --------------------------------------------------------

--
-- Table structure for table `harga`
--

CREATE TABLE IF NOT EXISTS `harga` (
  `intid_harga` int(8) NOT NULL AUTO_INCREMENT,
  `intid_barang` int(8) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `intharga_jawa` int(11) NOT NULL DEFAULT '0',
  `intpv_jawa` decimal(10,2) NOT NULL DEFAULT '0.00',
  `intharga_luarjawa` int(11) NOT NULL DEFAULT '0',
  `intpv_luarjawa` decimal(10,2) NOT NULL DEFAULT '0.00',
  `intharga_kualalumpur` float DEFAULT '0',
  `intpv_kualalumpur` decimal(10,2) DEFAULT '0.00',
  `intharga_luarkualalumpur` float DEFAULT '0',
  `intpv_luarkualalumpur` decimal(10,2) DEFAULT '0.00',
  `intum_jawa` int(8) NOT NULL DEFAULT '0',
  `intcicilan_jawa` int(8) NOT NULL DEFAULT '0',
  `intum_luarjawa` int(8) NOT NULL DEFAULT '0',
  `intcicilan_luarjawa` int(8) NOT NULL DEFAULT '0',
  `intspecial_jawa` int(8) NOT NULL DEFAULT '0',
  `intspecial_luarjawa` int(8) NOT NULL DEFAULT '0',
  `intspecial_kualalumpur` decimal(11,2) NOT NULL DEFAULT '0.00',
  `intspecial_luarkualalumpur` decimal(11,2) NOT NULL DEFAULT '0.00',
  `intpoint_jawa` int(8) NOT NULL DEFAULT '0',
  `intpoint_luarjawa` int(8) NOT NULL DEFAULT '0',
  `intfee_jawa` int(11) DEFAULT '0',
  `intfee_luarjawa` int(11) DEFAULT '0',
  `harga_lain` decimal(12,2) NOT NULL DEFAULT '0.00',
  `harga_lain_luar_jawa` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`intid_harga`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7140 ;

--
-- Dumping data for table `harga`
--

INSERT INTO `harga` (`intid_harga`, `intid_barang`, `date_start`, `date_end`, `intharga_jawa`, `intpv_jawa`, `intharga_luarjawa`, `intpv_luarjawa`, `intharga_kualalumpur`, `intpv_kualalumpur`, `intharga_luarkualalumpur`, `intpv_luarkualalumpur`, `intum_jawa`, `intcicilan_jawa`, `intum_luarjawa`, `intcicilan_luarjawa`, `intspecial_jawa`, `intspecial_luarjawa`, `intspecial_kualalumpur`, `intspecial_luarkualalumpur`, `intpoint_jawa`, `intpoint_luarjawa`, `intfee_jawa`, `intfee_luarjawa`, `harga_lain`, `harga_lain_luar_jawa`) VALUES
(7134, 9950, '2015-01-05', '2016-01-31', 298000, '2.38', 328000, '2.62', NULL, '115.00', 115, '0.00', 0, 0, 0, 0, 0, 0, '0.00', '0.00', 0, 0, 0, 0, '0.00', '0.00'),
(7136, 9952, '2015-01-05', '2016-01-31', 298000, '2.38', 328000, '2.62', NULL, '115.00', 115, '0.00', 0, 0, 0, 0, 0, 0, '0.00', '0.00', 0, 0, 0, 0, '0.00', '0.00'),
(7137, 9953, '2015-01-05', '2016-01-31', 298000, '2.38', 328000, '2.62', NULL, '115.00', 115, '0.00', 0, 0, 0, 0, 0, 0, '0.00', '0.00', 0, 0, 0, 0, '0.00', '0.00'),
(7138, 9954, '2015-01-05', '2016-01-31', 298000, '2.38', 328000, '2.62', NULL, '115.00', 115, '0.00', 0, 0, 0, 0, 0, 0, '0.00', '0.00', 0, 0, 0, 0, '0.00', '0.00'),
(7139, 9955, '2015-01-05', '2016-01-31', 298000, '2.38', 328000, '2.62', NULL, '115.00', 115, '0.00', 0, 0, 0, 0, 0, 0, '0.00', '0.00', 0, 0, 0, 0, '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `inpormasi`
--

CREATE TABLE IF NOT EXISTS `inpormasi` (
  `id` int(2) NOT NULL DEFAULT '1',
  `pesan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `inpormasi`
--

INSERT INTO `inpormasi` (`id`, `pesan`) VALUES
(1, '<h1 class="MsoNormal" style="text-align: center; font-size: 30px;" align="center">USER MANUAL</h1>\r\n\n<h1 class="MsoNormal" style="text-align: center; font-size: 30px;" align="center">SISTEM MEMBER ONLINE</h1>\r\n\n<p class="MsoNormal" style="text-align: justify;">&nbsp;</p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">Sistem Member Online ini dapat digunakan baik oleh dealer, manager, maupun kepala cabang dan stockist yang aktif dalam berkarya di Twin Tulipware Indonesia. Untuk mulai menggunakan system ini, member harus mendaftarkan unit, nama, alamat email, dan nomor telepon nya ke cabang terdekat dan admin akan dapat mendaftarkan member tersebut dengan mengakses halaman <strong>Manager &gt; Registrasi Member Online</strong>.</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">&nbsp;</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;"><img src="images/info/SMO1.jpg" alt="" width="500" height="242" /><br /><!--[endif]--></span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;" data-mce-mark="1">&nbsp;</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">Setelah masuk ke dalam halaman Register Member Online, ketik nama unit dan nama member yang ingin didaftarkan lalu klik tombol <strong>Cari</strong>. Apabila member tersebut belum pernah mendaftarkan dirinya ke dalam Sistem Member Online maka user akan diminta untuk memasukkan alamat email dan nomor hp member untuk segera didaftarkan ke dalam system.</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">Perlu diperhatikan beberapa kondisi yang dapat menyebabkan gagalnya pendaftaran member online</span></p>\r\n\n<ul>\r\n\n<li><span style="font-size: 12pt; text-indent: -0.25in;">@gmail.com &nbsp; &nbsp;=&gt; email akan diterima secepatnya tanpa delay</span></li>\r\n\n<li><span style="font-size: 12pt; text-indent: -0.25in;">@yahoo.com&nbsp;&nbsp; =&gt; kemungkinan delay selama kurang lebih 10 menit &ndash; 1 jam</span></li>\r\n\n<li><span style="font-size: 12pt; text-indent: -0.25in;">@ymail.com&nbsp;&nbsp;&nbsp; =&gt; email otomatis dari sistem akan ditolak oleh provider ini</span></li>\r\n\n<li><span style="font-size: 12pt; text-indent: -0.25in;">@outlook.com =&gt; email otomatis dari sistem akan ditolak oleh provider ini</span></li>\r\n\n</ul>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">Halaman sukses akan muncul apabila member berhasil didaftarkan.</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">&nbsp;</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;" data-mce-mark="1"><img src="images/info/SMO2.jpg" alt="" width="500" height="260" /><br /><!--[endif]--></span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;" data-mce-mark="1">&nbsp;</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">Apabila member sudah pernah terdaftar di dalam Sistem Member Online maka halaman berikut akan muncul.</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">&nbsp;</span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;"><img src="images/info/SMO3.jpg" alt="" width="500" height="147" /><br /><!--[endif]--></span></p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">&nbsp;</span>&nbsp;</p>\r\n\n<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt;">Apabila diperlukan, user dapat menghubungi kantor pusat untuk me-reset ulang member dan melakukan penginputan ulang Registrasi Member Online.</span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_penjualan`
--

CREATE TABLE IF NOT EXISTS `jenis_penjualan` (
  `intid_jpenjualan` int(8) NOT NULL AUTO_INCREMENT,
  `strnama_jpenjualan` varchar(50) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `sortby` int(11) NOT NULL DEFAULT '0',
  `fee_kc` int(11) NOT NULL DEFAULT '0',
  `fee_sc` int(11) NOT NULL DEFAULT '0',
  `is_omset` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`intid_jpenjualan`),
  KEY `intid_jpenjualan` (`intid_jpenjualan`) USING BTREE,
  KEY `is_omset` (`is_omset`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=33 ;

--
-- Dumping data for table `jenis_penjualan`
--

INSERT INTO `jenis_penjualan` (`intid_jpenjualan`, `strnama_jpenjualan`, `is_active`, `sortby`, `fee_kc`, `fee_sc`, `is_omset`) VALUES
(1, 'Reguler', 1, 0, 0, 0, 1),
(26, 'Chall SC', 0, 0, 0, 0, 1),
(27, 'Waffle Pan Special Surprise', 1, 0, 0, 0, 0),
(28, 'Hoki Promo 75', 1, 0, 0, 0, 1),
(29, 'Hoki Promo 150', 1, 0, 0, 0, 1),
(30, 'Promo Red White', 1, 0, 0, 0, 0),
(31, 'Avenger', 1, 0, 0, 0, 0),
(32, 'Lain-lain LG', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_satuan`
--

CREATE TABLE IF NOT EXISTS `jenis_satuan` (
  `intid_jsatuan` int(8) NOT NULL AUTO_INCREMENT,
  `strnama_jsatuan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`intid_jsatuan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jenis_satuan`
--

INSERT INTO `jenis_satuan` (`intid_jsatuan`, `strnama_jsatuan`) VALUES
(1, 'set'),
(2, 'pcs');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `intid_dealer` int(8) NOT NULL AUTO_INCREMENT,
  `strkode_dealer` varchar(20) DEFAULT NULL,
  `strnama_dealer` varchar(100) DEFAULT NULL,
  `intid_cabang` int(8) DEFAULT NULL,
  `datetanggal` date DEFAULT NULL,
  `strkode_upline` varchar(20) DEFAULT NULL,
  `strnama_upline` varchar(100) DEFAULT NULL,
  `intlevel_dealer` int(2) DEFAULT NULL,
  `intparent_leveldealer` int(2) DEFAULT NULL,
  `intid_unit` int(8) NOT NULL,
  `strno_ktp` varchar(20) DEFAULT NULL,
  `stralamat` varchar(255) DEFAULT NULL,
  `strtlp` varchar(20) DEFAULT NULL,
  `pathPicture` text NOT NULL,
  `strhp` varchar(20) NOT NULL DEFAULT '0',
  `jmlanak` int(11) NOT NULL DEFAULT '0',
  `pendidikan` varchar(50) NOT NULL,
  `strtmp_lahir` varchar(30) DEFAULT NULL,
  `datetgl_lahir` date DEFAULT NULL,
  `stragama` varchar(20) DEFAULT NULL,
  `intid_bank` varchar(255) DEFAULT NULL,
  `intno_rekening` int(50) DEFAULT NULL,
  `strnama_pemilikrekening` varchar(50) DEFAULT NULL,
  `strkode_manager` int(8) DEFAULT NULL,
  `intid_starterkit` int(8) DEFAULT NULL,
  `intid_posisi` int(8) DEFAULT NULL,
  `strjk` char(6) DEFAULT NULL,
  `strstatus` varchar(20) DEFAULT NULL,
  `stremail` varchar(30) DEFAULT NULL,
  `strwarganegara` varchar(30) DEFAULT NULL,
  `strpekerjaan` varchar(50) DEFAULT NULL,
  `strtelp_upline` varchar(30) DEFAULT NULL,
  `intid_unit_upline` int(8) DEFAULT NULL,
  `intid_cabang_upline` int(8) NOT NULL,
  `intid_week` int(9) NOT NULL,
  `cabang_pengambilan` int(11) DEFAULT '0',
  `is_cm` tinyint(4) DEFAULT '0',
  `is_abo` tinyint(1) NOT NULL DEFAULT '0',
  `is_acc_abo` tinyint(1) NOT NULL DEFAULT '0',
  `is_hut` int(11) NOT NULL DEFAULT '0',
  `is_promorekrut` int(11) NOT NULL DEFAULT '0',
  `point` int(11) DEFAULT '0',
  `date_modified_point` datetime DEFAULT '0000-00-00 00:00:00',
  `is_promo` tinyint(2) NOT NULL DEFAULT '0',
  `is_banned` tinyint(1) DEFAULT '0',
  `is_ng` tinyint(11) DEFAULT '0',
  `is_pengejaran` int(1) NOT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`intid_dealer`),
  KEY `mind1` (`strkode_dealer`) USING BTREE,
  KEY `mind2` (`strkode_upline`) USING BTREE,
  KEY `mind3` (`intid_dealer`) USING BTREE,
  KEY `mind4` (`intid_unit`) USING BTREE,
  KEY `intid_dealer` (`intid_dealer`) USING BTREE,
  KEY `intid_cabang` (`intid_cabang`) USING BTREE,
  KEY `strkode_dealer` (`strkode_dealer`) USING BTREE,
  KEY `strkode_upline` (`strkode_upline`) USING BTREE,
  KEY `intid_unit` (`intid_unit`) USING BTREE,
  KEY `strkode_dealer_2` (`strkode_dealer`,`intid_cabang`,`strkode_upline`,`intlevel_dealer`,`intparent_leveldealer`,`intid_unit`,`is_cm`,`is_abo`,`is_acc_abo`,`is_hut`,`is_promorekrut`,`point`,`is_promo`,`is_banned`,`is_ng`) USING BTREE,
  KEY `is_pengejaran` (`is_pengejaran`) USING BTREE,
  KEY `intid_starterkit` (`intid_starterkit`) USING BTREE,
  KEY `is_cm` (`is_cm`) USING BTREE,
  KEY `is_abo` (`is_abo`) USING BTREE,
  KEY `intid_week` (`intid_week`) USING BTREE,
  KEY `is_acc_abo` (`is_acc_abo`) USING BTREE,
  KEY `cabang_pengambilan` (`cabang_pengambilan`) USING BTREE,
  KEY `strhp` (`strhp`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=110211 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`intid_dealer`, `strkode_dealer`, `strnama_dealer`, `intid_cabang`, `datetanggal`, `strkode_upline`, `strnama_upline`, `intlevel_dealer`, `intparent_leveldealer`, `intid_unit`, `strno_ktp`, `stralamat`, `strtlp`, `pathPicture`, `strhp`, `jmlanak`, `pendidikan`, `strtmp_lahir`, `datetgl_lahir`, `stragama`, `intid_bank`, `intno_rekening`, `strnama_pemilikrekening`, `strkode_manager`, `intid_starterkit`, `intid_posisi`, `strjk`, `strstatus`, `stremail`, `strwarganegara`, `strpekerjaan`, `strtelp_upline`, `intid_unit_upline`, `intid_cabang_upline`, `intid_week`, `cabang_pengambilan`, `is_cm`, `is_abo`, `is_acc_abo`, `is_hut`, `is_promorekrut`, `point`, `date_modified_point`, `is_promo`, `is_banned`, `is_ng`, `is_pengejaran`, `active`) VALUES
(325, 'M12000331', NULL, 6, '2012-01-01', 'M12000283', 'SRI ENDAH LESTARI DR', 5, 4, 49, NULL, NULL, NULL, '', '0', 0, '', NULL, '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 6, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '1'),
(110210, 'M783071', 'USER IKHLAS', 28, '2013-03-13', 'M780165', 'User Elisabeth', 1, 0, 725, '1111111111111111', '-', '0817170820', 'pictn1438248669.jpg', '0978762653', 0, '', 'LOKSEUMAWE ', '1989-11-11', 'ISLAM', 'bca', 12345, 'ikhlas', 0, 11219, NULL, 'PRIA', 'TIDAK KAWIN', 'efan.himawan@gmail.com', '-', '0', '-', NULL, 0, 11, 28, 1, 0, 0, 0, 0, 12, '2014-01-21 07:51:06', 1, 0, 0, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE IF NOT EXISTS `nota` (
  `intid_nota` int(8) NOT NULL AUTO_INCREMENT,
  `intno_nota` varchar(255) NOT NULL,
  `intid_jpenjualan` int(8) NOT NULL,
  `intid_cabang` int(8) NOT NULL,
  `intid_dealer` int(8) NOT NULL,
  `intid_unit` int(8) NOT NULL,
  `datetgl` date NOT NULL,
  `intid_week` int(8) DEFAULT NULL,
  `intomset10` decimal(11,2) DEFAULT '0.00',
  `intomset20` decimal(11,2) DEFAULT '0.00',
  `inttotal_omset` decimal(11,2) DEFAULT '0.00',
  `inttotal_bayar` decimal(11,2) DEFAULT '0.00',
  `intdp` decimal(11,2) DEFAULT '0.00',
  `intcash` decimal(11,2) DEFAULT '0.00',
  `intdebit` decimal(11,2) DEFAULT '0.00',
  `intkkredit` decimal(11,2) DEFAULT '0.00',
  `intsisa` decimal(11,2) DEFAULT '0.00',
  `intkomisi10` decimal(11,2) DEFAULT '0.00',
  `intkomisi20` decimal(11,2) DEFAULT '0.00',
  `intpv` decimal(10,2) DEFAULT NULL,
  `intvoucher` decimal(11,2) DEFAULT '0.00',
  `is_dp` tinyint(4) DEFAULT '0',
  `inttrade_in` int(5) DEFAULT '0',
  `is_lg` tinyint(4) NOT NULL DEFAULT '0',
  `is_vpromo` int(1) NOT NULL DEFAULT '0',
  `nokk` bigint(20) NOT NULL,
  `is_asi` tinyint(4) NOT NULL DEFAULT '0',
  `intkomisi_asi` int(8) NOT NULL DEFAULT '0',
  `is_arisan` tinyint(4) NOT NULL DEFAULT '0',
  `is_sp` tinyint(4) NOT NULL DEFAULT '0',
  `is_lglain` int(1) NOT NULL,
  `is_lgBaru` int(1) NOT NULL DEFAULT '0',
  `is_lgOval` int(1) NOT NULL DEFAULT '0',
  `is_ten` int(1) NOT NULL DEFAULT '0',
  `is_think` int(1) NOT NULL DEFAULT '0',
  `intpromo_rekrut` int(11) DEFAULT '0',
  `halaman` varchar(100) DEFAULT NULL,
  `intomset15` decimal(11,2) DEFAULT '0.00',
  `intkomisi15` decimal(11,2) DEFAULT '0.00',
  `otherKom` decimal(10,2) NOT NULL,
  `persen` decimal(15,4) NOT NULL,
  `no_kkredit` varchar(20) DEFAULT '0',
  PRIMARY KEY (`intid_nota`),
  UNIQUE KEY `intno_nota` (`intno_nota`) USING BTREE,
  KEY `hind1` (`intid_dealer`) USING BTREE,
  KEY `hind2` (`intid_unit`) USING BTREE,
  KEY `intid_nota` (`intid_nota`) USING BTREE,
  KEY `intid_jpenjualan` (`intid_jpenjualan`) USING BTREE,
  KEY `intid_cabang` (`intid_cabang`) USING BTREE,
  KEY `intid_dealer` (`intid_dealer`) USING BTREE,
  KEY `intid_unit` (`intid_unit`) USING BTREE,
  KEY `intid_week` (`intid_week`) USING BTREE,
  KEY `is_dp` (`is_dp`,`is_lg`,`is_asi`,`is_arisan`,`is_sp`) USING BTREE,
  KEY `datetgl` (`datetgl`) USING BTREE,
  KEY `is_lglain` (`is_lglain`) USING BTREE,
  KEY `intid_dealer_2` (`intid_dealer`) USING BTREE,
  KEY `is_lgBaru` (`is_lgBaru`) USING BTREE,
  KEY `otherKom` (`otherKom`) USING BTREE,
  KEY `persen` (`persen`) USING BTREE,
  KEY `no_kkredit` (`no_kkredit`) USING BTREE,
  KEY `is_lgOval` (`is_lgOval`) USING BTREE,
  KEY `is_ten` (`is_ten`) USING BTREE,
  KEY `is_think` (`is_think`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`intid_nota`, `intno_nota`, `intid_jpenjualan`, `intid_cabang`, `intid_dealer`, `intid_unit`, `datetgl`, `intid_week`, `intomset10`, `intomset20`, `inttotal_omset`, `inttotal_bayar`, `intdp`, `intcash`, `intdebit`, `intkkredit`, `intsisa`, `intkomisi10`, `intkomisi20`, `intpv`, `intvoucher`, `is_dp`, `inttrade_in`, `is_lg`, `is_vpromo`, `nokk`, `is_asi`, `intkomisi_asi`, `is_arisan`, `is_sp`, `is_lglain`, `is_lgBaru`, `is_lgOval`, `is_ten`, `is_think`, `intpromo_rekrut`, `halaman`, `intomset15`, `intkomisi15`, `otherKom`, `persen`, `no_kkredit`) VALUES
(4, '1.52.00012', 1, 1, 110210, 725, '2015-12-31', 52, '0.00', '298000.00', '298000.00', '238400.00', '0.00', '238400.00', '0.00', '0.00', '0.00', '0.00', '59600.00', '2.38', '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Promo Lunas', '0.00', '0.00', '0.00', '0.0000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `nota_detail`
--

CREATE TABLE IF NOT EXISTS `nota_detail` (
  `intid_detail_nota` int(8) NOT NULL AUTO_INCREMENT,
  `intid_nota` int(8) DEFAULT NULL,
  `intid_barang` int(8) DEFAULT NULL,
  `intquantity` int(8) DEFAULT NULL,
  `intid_harga` int(8) DEFAULT NULL,
  `is_free` tinyint(4) NOT NULL DEFAULT '0',
  `intharga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nomor_nota` varchar(255) DEFAULT NULL,
  `is_hutang` varchar(1) DEFAULT '0',
  `is_diskon` decimal(4,2) NOT NULL DEFAULT '1.00',
  `intnormal` int(8) DEFAULT '0',
  `intvoucher` int(8) DEFAULT '0',
  `id_jpenjualan` int(11) NOT NULL DEFAULT '0',
  `intomset` decimal(15,2) DEFAULT '0.00',
  `intomset10` decimal(15,2) DEFAULT '0.00',
  `intomset15` decimal(15,2) DEFAULT '0.00',
  `intomset20` decimal(15,2) DEFAULT '0.00',
  `intpv` decimal(10,2) DEFAULT NULL,
  `intkomisi` decimal(15,2) DEFAULT '0.00',
  `inttotal_bayar` decimal(15,2) DEFAULT '0.00',
  `intid_control_promo` int(11) NOT NULL DEFAULT '0',
  `reduced` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`intid_detail_nota`),
  KEY `id_nota` (`intid_nota`) USING BTREE,
  KEY `intid_nota` (`intid_nota`) USING BTREE,
  KEY `intid_barang` (`intid_barang`) USING BTREE,
  KEY `intomset10` (`intomset10`,`intomset15`,`intomset20`,`intkomisi`) USING BTREE,
  KEY `intomset` (`intomset`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Dumping data for table `nota_detail`
--

INSERT INTO `nota_detail` (`intid_detail_nota`, `intid_nota`, `intid_barang`, `intquantity`, `intid_harga`, `is_free`, `intharga`, `nomor_nota`, `is_hutang`, `is_diskon`, `intnormal`, `intvoucher`, `id_jpenjualan`, `intomset`, `intomset10`, `intomset15`, `intomset20`, `intpv`, `intkomisi`, `inttotal_bayar`, `intid_control_promo`, `reduced`) VALUES
(1, 4, 9950, 1, 9950, 0, '298000.00', '1.52.00012', '0', '1.00', 298000, 0, 1, '298000.00', '0.00', '0.00', '298000.00', '2.38', '59600.00', '238400.00', 1, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isi` text NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_privilege`
--

CREATE TABLE IF NOT EXISTS `system_privilege` (
  `intid_privilege` int(3) NOT NULL AUTO_INCREMENT,
  `strname_privilege` varchar(35) NOT NULL,
  `strdesc_privilege` text NOT NULL,
  PRIMARY KEY (`intid_privilege`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Dumping data for table `system_privilege`
--

INSERT INTO `system_privilege` (`intid_privilege`, `strname_privilege`, `strdesc_privilege`) VALUES
(1, 'admin', 'eksekusi view, insert, update, delete.'),
(2, 'user', 'eksekusi view, insert, update, delete, cetak: report,nota. '),
(3, 'gudang', 'eksekusi view, insert, update, delete, cetak : gudang'),
(4, 'accounting', 'eksekusi view, insert, update, delete, cetak : laporan'),
(5, 'bs', 'eksekusi view, insert, update, delete, cetak: report,nota. ');

-- --------------------------------------------------------

--
-- Table structure for table `system_user`
--

CREATE TABLE IF NOT EXISTS `system_user` (
  `intid_user` int(5) NOT NULL AUTO_INCREMENT,
  `strnama_user` varchar(30) NOT NULL,
  `strpass_user` varchar(50) NOT NULL,
  `strnama_asli` varchar(50) NOT NULL,
  `intid_privilege` int(3) NOT NULL,
  `intid_cabang` int(8) NOT NULL,
  `intid_cabang2` int(8) NOT NULL,
  `intid_cabang3` int(8) NOT NULL,
  `intid_cabang4` int(8) NOT NULL,
  `intid_cabang5` int(8) NOT NULL,
  `intid_cabang6` int(8) NOT NULL,
  `intid_cabang7` int(8) NOT NULL,
  `intid_cabang8` int(8) NOT NULL,
  `intid_cabang9` int(8) NOT NULL,
  `intid_cabang10` int(8) NOT NULL,
  `enumblocked` enum('y','n') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`intid_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=200 ;

--
-- Dumping data for table `system_user`
--

INSERT INTO `system_user` (`intid_user`, `strnama_user`, `strpass_user`, `strnama_asli`, `intid_privilege`, `intid_cabang`, `intid_cabang2`, `intid_cabang3`, `intid_cabang4`, `intid_cabang5`, `intid_cabang6`, `intid_cabang7`, `intid_cabang8`, `intid_cabang9`, `intid_cabang10`, `enumblocked`) VALUES
(1, 'admin', '6e4c25128c945028bde7560e0f42c146', 'Administrator', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'n');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` char(1) NOT NULL COMMENT '1 untuk active, 0 untuk nonactive',
  `intid_dealer` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `passPhone` varchar(10) NOT NULL,
  `startTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `intid_dealer` (`intid_dealer`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=123 ;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `active`, `intid_dealer`, `token`, `passPhone`, `startTime`, `endTime`) VALUES
(24, '1', 128948, '5eebc60c5af67253a6be1bce63670c1a', '', '2015-07-31 17:03:07', '2015-08-07 17:03:07'),
(36, '0', 144438, '3a0825b9fe79e8a6d3053a97a5f0e1ee', '', '2015-08-18 15:53:34', '2015-08-25 15:53:34'),
(111, '0', 146270, '7d0715ca82fe3470b2ecb7172f8fc06a', '', '2015-12-08 22:48:52', '2015-12-15 22:48:52'),
(114, '1', 45, '107745626fcc2a95312581bb40f3f002', '', '2015-12-11 17:45:17', '2015-12-18 17:45:17'),
(105, '1', 144752, '3ee99061d4358b7e18db9812bc30316d', '', '2015-11-20 13:50:39', '2015-11-27 13:50:39'),
(100, '0', 110474, 'd3eee92f47c5a58b0844fa5111abc34c', '', '2015-11-10 21:27:22', '2015-11-17 21:27:22'),
(96, '1', 136614, '862dbab0f93f4f3f6802492ea6b900cc', '', '2015-11-08 12:53:06', '2015-11-15 12:53:06'),
(121, '1', 144752, '157c53179f385903416c9633705bbb18', '', '2015-12-30 15:02:29', '2016-01-06 15:02:29'),
(38, '0', 56643, '391732de560367eb6c580a847b7e36f4', '', '2015-08-27 15:20:09', '2015-09-03 15:20:09'),
(110, '1', 124576, '06faed8d48f081afdff1d55b70b1fc1d', '', '2015-12-06 20:18:16', '2015-12-13 20:18:16'),
(97, '0', 121202, 'c7a057ae195c2fe4f4937bdfd4880e8d', '', '2015-11-09 08:30:41', '2015-11-16 08:30:41'),
(23, '0', 128948, 'b86034d9420c6331ccf3a889007c5569', '', '2015-07-31 15:45:54', '2015-08-07 15:45:54'),
(108, '1', 124576, 'be81a8d7eeec290cbe89af2050fcdbfc', '', '2015-11-29 10:51:12', '2015-12-06 10:51:12'),
(78, '1', 144970, '666a6d36e234ac4a9967e1b4c3764df6', '', '2015-10-20 08:46:13', '2015-10-27 08:46:13'),
(37, '0', 56643, '470f7ba82fc04b5bb37420f7a0c622a8', '', '2015-08-27 10:31:11', '2015-09-03 10:31:11'),
(122, '0', 139144, 'fe8c34c6ca9f3c8b48313e781a62064a', '', '2015-12-30 22:58:14', '2016-01-06 22:58:14'),
(58, '0', 131776, 'eb6a5611d84386125da1b7cd27060d99', '', '2015-09-24 14:19:33', '2015-10-01 14:19:33'),
(76, '1', 124576, '78cf7c84170c96a658b1261882d06597', '', '2015-10-13 14:24:07', '2015-10-20 14:24:07'),
(115, '1', 124576, 'e99f76234740828ab4463cf94cecc595', '', '2015-12-14 10:57:45', '2015-12-21 10:57:45'),
(109, '1', 144752, '5aa0eb37a01222ad4890b4961a23639d', '', '2015-12-01 10:36:55', '2015-12-08 10:36:55'),
(89, '0', 145389, 'de564e7f9cbf0d6ad0e832f576df6ca3', '', '2015-10-29 15:34:04', '2015-11-05 15:34:04'),
(90, '1', 124576, 'bbd8af0b8288cf633ce8c9c5bd560b7b', '', '2015-10-30 08:10:48', '2015-11-06 08:10:48'),
(45, '0', 118487, '3c428843a8a1499a82c859777b68fe65', '', '2015-09-12 15:51:29', '2015-09-19 15:51:29'),
(83, '0', 109473, '0cfb2ca02428ca9c7290c3240cc80c34', '', '2015-10-21 15:23:10', '2015-10-28 15:23:10'),
(46, '1', 113734, '1aafd5f93f24dafd3e87dfea2344893d', '', '2015-09-14 10:59:42', '2015-09-21 10:59:42'),
(103, '1', 146172, '22dce854a2a1f2be65c2575c2cb5f402', '', '2015-11-18 15:01:08', '2015-11-25 15:01:08'),
(73, '0', 141027, '1c3bd054bc7897d058c3f0de4b9330a7', '', '2015-10-09 12:23:57', '2015-10-16 12:23:57'),
(86, '1', 124576, '36b6711ce088065f64a9b83f53906c08', '', '2015-10-23 03:57:35', '2015-10-30 03:57:35'),
(74, '0', 32534, 'd3b95bd7f2e2acf3391dd0666d5318b4', '', '2015-10-09 22:14:28', '2015-10-16 22:14:28'),
(55, '1', 144038, '3e3466e5928c1deb1eaa72e74c52266f', '', '2015-09-22 18:12:20', '2015-09-29 18:12:20'),
(84, '0', 109473, '0cfb2ca02428ca9c7290c3240cc80c34', '', '2015-10-21 15:23:10', '2015-10-28 15:23:10'),
(95, '0', 60378, '30064d29fc672c12d85155c70189311e', '', '2015-11-06 07:24:01', '2015-11-13 07:24:01'),
(69, '1', 43791, '813568c639ee7d3f5dee3b52489b7b54', '', '2015-09-29 21:49:39', '2015-10-06 21:49:39'),
(80, '1', 109473, 'a8b8388014bd673abeb0ecdd554765fa', '', '2015-10-21 15:22:48', '2015-10-28 15:22:48'),
(64, '0', 56005, 'c95fd88b37c91243a91246ceb1474776', '', '2015-09-26 07:37:30', '2015-10-03 07:37:30'),
(63, '0', 96141, '0fc63b6f84b546d30fbeff06b7401c3f', '', '2015-09-25 16:20:11', '2015-10-02 16:20:11'),
(21, '0', 144438, '9e95b364b146f476d44975c349192010', '', '2015-07-30 14:21:57', '2015-08-06 14:21:57'),
(68, '1', 17116, '9592f79e18f6ed0c1dabb47f94df5712', '', '2015-09-28 16:34:35', '2015-10-05 16:34:35'),
(82, '0', 109473, '0cfb2ca02428ca9c7290c3240cc80c34', '', '2015-10-21 15:23:10', '2015-10-28 15:23:10'),
(101, '1', 144752, '976c9f7c9d19dacbe5d5f3f64685ef6b', '', '2015-11-12 11:24:51', '2015-11-19 11:24:51'),
(53, '1', 11953, 'd5aac60caaf88e630478673580e1452d', '', '2015-09-19 10:43:55', '2015-09-26 10:43:55'),
(62, '0', 106869, '0c5306d6c53916057d0d1070efc14e52', '', '2015-09-25 11:53:15', '2015-10-02 11:53:15'),
(85, '1', 144079, '86e0b71d5d2f2f98d055f3500b4f6e2f', '', '2015-10-22 06:56:01', '2015-10-29 06:56:01'),
(102, '1', 124576, '9eb38d11c970a3d9e92389466f54a680', '', '2015-11-13 14:15:07', '2015-11-20 14:15:07'),
(42, '1', 140428, '6ae4f5013b05b5ec2eb2b97d1c140f8e', '', '2015-09-04 10:10:19', '2015-09-11 10:10:19'),
(119, '1', 134972, 'a7035e6f7efcd3a3931f0972d86fd778', '', '2015-12-29 15:42:50', '2016-01-05 15:42:50'),
(87, '1', 140956, '02c01b6f16381a6be9b24581ca4f8af3', '', '2015-10-28 16:38:30', '2015-11-04 16:38:30'),
(94, '0', 144433, 'b7fbc866fd44b159d0a024262899b838', '', '2015-11-04 23:25:01', '2015-11-11 23:25:01'),
(39, '0', 56643, '864746565c81f403da78b6c5dcccc763', '', '2015-08-27 15:22:43', '2015-09-03 15:22:43'),
(61, '0', 117212, '3aae9bd2935b0bcebb501d95c9aab0b4', '', '2015-09-24 21:01:00', '2015-10-01 21:01:00'),
(26, '0', 12350, '7125dc4dfa6b1576d9ece038b2cfb820', '', '2015-08-03 15:00:02', '2015-08-10 15:00:02'),
(60, '1', 131776, '89e2fbc187ccf36102731c76e6f94606', '', '2015-09-24 14:19:56', '2015-10-01 14:19:56'),
(44, '1', 144055, '5a7f7fbdc1ef86c1b680f322c5069dcc', '', '2015-09-12 13:34:35', '2015-09-19 13:34:35'),
(72, '1', 110680, '28d55bfa80f6f03097cc4f6c4ad0f380', '', '2015-10-07 13:13:13', '2015-10-14 13:13:13'),
(116, '0', 133083, 'b0d416979e73c240d9f02da56f3a698b', '', '2015-12-14 12:58:06', '2015-12-21 12:58:06'),
(106, '1', 124576, '23181bfc5acc0d5b826babe147850478', '', '2015-11-21 09:48:54', '2015-11-28 09:48:54'),
(57, '1', 309, '412963bf9c979475a1c59d693bedd48a', '', '2015-09-23 14:41:53', '2015-09-30 14:41:53'),
(27, '0', 12350, '81a5e34deeff0b1edea9cf39832e5521', '', '2015-08-05 10:12:14', '2015-08-12 10:12:14'),
(70, '0', 130998, '3513761c7e12459b295bb734bf77664b', '', '2015-09-29 21:51:59', '2015-10-06 21:51:59'),
(99, '1', 63439, '75364a116af7f1b583e1c2530c8b57c1', '', '2015-11-09 08:56:12', '2015-11-16 08:56:12'),
(34, '0', 56643, 'f87a1af55f0686e7e82214521e4adccc', '', '2015-08-10 13:21:31', '2015-08-17 13:21:31'),
(20, '0', 144438, 'a7807a7415a2034bf0d4c7fd0486a74c', '', '2015-07-30 14:16:41', '2015-08-06 14:16:41'),
(120, '1', 124576, 'aba564b339486d7b8f8636bded4ef2e6', '', '2015-12-29 21:41:57', '2016-01-05 21:41:57'),
(18, '1', 110210, 'cb0dfc88057f47e571430e284261e469', '', '2015-07-30 14:05:52', '2015-08-06 14:05:52'),
(25, '0', 12350, '9b72f1d847c61b97b57080a66a60937d', '', '2015-08-03 14:45:12', '2015-08-10 14:45:12'),
(81, '0', 109473, '0cfb2ca02428ca9c7290c3240cc80c34', '', '2015-10-21 15:23:10', '2015-10-28 15:23:10'),
(93, '0', 146615, 'e64c3a976e9f762eb2ed7c0ecb15d023', '', '2015-11-02 10:05:32', '2015-11-09 10:05:32'),
(88, '0', 140956, '380f0dec4b8cc880ff8e459f4fa2c05c', '', '2015-10-28 16:38:35', '2015-11-04 16:38:35'),
(104, '1', 45, '83c758eacf364031b266188a7e879364', '', '2015-11-19 20:06:20', '2015-11-26 20:06:20'),
(113, '0', 115204, '5e1dd1a7f1750e827ee296253670828e', '', '2015-12-10 19:36:06', '2015-12-17 19:36:06'),
(28, '0', 12350, '4b09ee9e46d2a90bc66355378c228cdf', '', '2015-08-05 11:14:22', '2015-08-12 11:14:22'),
(118, '1', 124576, '7cb7887c5dcff77f2a8305b2462f5a27', '', '2015-12-21 19:20:42', '2015-12-28 19:20:42'),
(71, '1', 124576, '4289d3fbdb0ccb5fcf6c7fff7d83ad19', '', '2015-10-06 05:00:26', '2015-10-13 05:00:26'),
(35, '0', 144438, 'b22e9e5f860a00c6cf922d54778dfab7', '', '2015-08-12 09:41:39', '2015-08-19 09:41:39'),
(92, '1', 41900, '94629883b117b7b2abfc9d90db0477aa', '', '2015-11-02 09:57:16', '2015-11-09 09:57:16'),
(50, '1', 11953, 'b858aa9fc26c08003cea2764508c780e', '', '2015-09-19 10:43:30', '2015-09-26 10:43:30'),
(112, '1', 146270, 'ca0c48d0b93bc15bab7e06b1cd31f33e', '', '2015-12-08 22:49:00', '2015-12-15 22:49:00'),
(30, '0', 56643, '84a18c4ea825e7002e850fbcce950166', '', '2015-08-05 14:07:08', '2015-08-12 14:07:08'),
(65, '1', 138882, 'd09fb582d8b5ec5190a7aaaa8699cc65', '', '2015-09-26 11:09:34', '2015-10-03 11:09:34'),
(75, '0', 103366, '50fe1c3069852e81f6bbf1d9beee7f44', '', '2015-10-12 17:30:14', '2015-10-19 17:30:14'),
(49, '1', 43791, 'd87b43413781cd98bc539b4d67d5f6b4', '', '2015-09-16 17:22:32', '2015-09-23 17:22:32'),
(47, '0', 142091, 'c1e370ba11b6bb5028bd3e7a75b91ef5', '', '2015-09-15 16:07:18', '2015-09-22 16:07:18'),
(31, '0', 12350, '56b59955d4a35d469ff0d2a5378350c7', '', '2015-08-07 10:43:42', '2015-08-14 10:43:42'),
(22, '0', 144438, '8fe916b0b4d8be05ee8df5dc1d60533d', '', '2015-07-30 14:25:17', '2015-08-06 14:25:17'),
(51, '1', 11953, 'b858aa9fc26c08003cea2764508c780e', '', '2015-09-19 10:43:30', '2015-09-26 10:43:30'),
(98, '1', 63439, '49b31e14d071c0d58a6e2822e9d3d569', '', '2015-11-09 08:56:09', '2015-11-16 08:56:09'),
(40, '0', 74151, 'e221cb06dc426882948e908f5d59eebd', '', '2015-09-02 23:26:26', '2015-09-09 23:26:26'),
(59, '1', 131776, 'e63b16e16fd457b80af15ea85ae0d6a8', '', '2015-09-24 14:19:35', '2015-10-01 14:19:35'),
(48, '0', 140173, '003f8f25945f6522cde745165cd1016d', '', '2015-09-16 17:17:21', '2015-09-23 17:17:21'),
(66, '0', 138882, '99ca43a8997cb0a9214a88a51f0edbcc', '', '2015-09-26 11:09:38', '2015-10-03 11:09:38'),
(33, '0', 56643, '2a53eb40aa7fc73eb0c26dc83a1196dc', '', '2015-08-10 11:33:18', '2015-08-17 11:33:18'),
(41, '0', 140428, '4666e762265ca6ed62be9e613a3a4555', '', '2015-09-04 10:10:07', '2015-09-11 10:10:07'),
(29, '0', 12350, 'ed76cef06029315221192695ef92f83a', '', '2015-08-05 13:14:52', '2015-08-12 13:14:52'),
(56, '0', 309, '53da511ece49fe3ffacacd75a685fa26', '', '2015-09-23 14:41:41', '2015-09-30 14:41:41'),
(43, '1', 91841, 'afcde19dad35ceb97527abcf6313d564', '', '2015-09-12 11:59:15', '2015-09-19 11:59:15'),
(91, '0', 146961, 'ee430f0b17e485945d0b6f0a5939b743', '', '2015-10-31 14:05:21', '2015-11-07 14:05:21'),
(52, '1', 11953, '4b9924e67fb965908ee922eb9e3a2fce', '', '2015-09-19 10:43:53', '2015-09-26 10:43:53'),
(77, '1', 145738, '431f48f8770b4215d0319ebde9978739', '', '2015-10-17 15:43:15', '2015-10-24 15:43:15'),
(107, '0', 91295, '94dcebc73e798c03aa98e6cc5ea766a2', '', '2015-11-28 15:25:20', '2015-12-05 15:25:20'),
(32, '1', 108117, '379c3fa01897735a9592be029234e4f1', '', '2015-08-10 10:30:02', '2015-08-17 10:30:02'),
(19, '0', 144438, '59a320f7c2d9485ba5cb1d59c1720d3a', '', '2015-07-30 14:06:18', '2015-08-06 14:06:18'),
(79, '1', 137775, 'c3e357b7028aa19c1cb9b82c3c7de186', '', '2015-10-20 09:52:09', '2015-10-27 09:52:09'),
(67, '0', 127344, '74cf00cb71c1ae35ae21fd92484409e1', '', '2015-09-28 07:11:19', '2015-10-05 07:11:19'),
(117, '0', 146209, 'c50103e4399aaa9eb0b2eb00beaab80c', '', '2015-12-17 12:12:18', '2015-12-24 12:12:18'),
(54, '0', 59341, 'df7ad5a286dd527e661bacf0dad2c7ca', '', '2015-09-21 10:21:03', '2015-09-28 10:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `translator`
--

CREATE TABLE IF NOT EXISTS `translator` (
  `id_trans` int(11) NOT NULL AUTO_INCREMENT,
  `barcode_wastu` varchar(20) NOT NULL,
  `code_satuan` varchar(255) NOT NULL,
  `barcode_pabrik` varchar(20) NOT NULL,
  PRIMARY KEY (`id_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `intid_unit` int(8) NOT NULL AUTO_INCREMENT,
  `strnama_unit` varchar(50) DEFAULT NULL,
  `intkode_cabang` int(11) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`intid_unit`),
  KEY `intid_unit` (`intid_unit`,`intkode_cabang`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1177 ;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`intid_unit`, `strnama_unit`, `intkode_cabang`, `date_add`) VALUES
(725, 'Xzinputer', 29, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_token`
--

CREATE TABLE IF NOT EXISTS `users_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(32) NOT NULL,
  `intid_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=297153 ;

--
-- Dumping data for table `users_token`
--

INSERT INTO `users_token` (`id`, `token`, `intid_user`) VALUES
(520, 'a155105dadbb8cd64e5c97f0e7f4e8e2', 15),
(606, '55cf520094fc213b4b1ca6ea751cbc34', 12),
(790, 'df1c93c90f55dcfa07233ecccf411480', 30),
(791, 'da7999ddd25c6438da4e0c14de7bfc33', 29),
(794, 'c73daf2a712237a445a932103a958223', 28),
(795, 'ddf125866afa3efaba1ca1041a3dfc5d', 40),
(796, '2857e09ad687bb6047b331828e0b844a', 45),
(827, '20fdf98fe63e5b8a43f69f1ad5c0be37', 26),
(890, '99f238b839fe043db6fad317d5f3d74c', 24),
(896, 'a88477eaee5956113df73b6b605f3a59', 35),
(996, '932bbe3ebb9b2252c23f7555674e1843', 23),
(4054, '5c51ec39207f1f47a6c538a324071023', 72),
(4378, '07d0090c4e6d28132e6c0506b3d01d68', 80),
(4461, '155c712ef90a69edfe7b5dcc1af05e1c', 60),
(8543, '7ce3bdfa437b5b10de2e40e99176b228', 90),
(9124, 'fb0ec846fb0750e6e96b4b9c48d7cb1e', 64),
(11991, '1872c9d0960d05ac55ae967644510aa7', 104),
(15056, 'e0389dc75d6534b31d24196fbcf19572', 115),
(15138, 'd293d6dff8ef930816a998b53d84170f', 119),
(15276, '6a5fccfaf7be1aecd76bbce3d52fdb88', 102),
(15319, 'cd079e33fbc0540ed0316d21df604844', 91),
(15624, '5848db2a8a5000e2e810e770c79531c9', 116),
(16820, '0278490246bf87e5f749e64643d44871', 125),
(19734, 'dffbf1a7179ae71d8b156c9b45a63091', 108),
(20436, '1c84bd61e38d5edab57d04e9c9afe439', 122),
(24974, 'e139f6877c2b930e44c4a2d7b9338acf', 118),
(26501, 'ef8957ab34fac8c011aa39a473842244', 138),
(31929, 'e2644d34dbe92eda3386d3aa083e4541', 139),
(35023, '2ef65b25991c4c79f15444ef480cac5a', 123),
(55473, '6b56521cafeb139a5db7df199c9f35db', 120),
(55485, '94b5a52ab7e6b4ebdfb5b58cd24b2fe5', 137),
(59411, '07cc64124d38b1bc1145860e923d4ff2', 121),
(67561, '973348aff28c6552d350520d8d584888', 58),
(67594, '046fbbc611c4e1dcaca6116b87f3a7bb', 89),
(78817, 'f73d138c0c93034688ddb8d76ae6efd9', 129),
(78834, 'a33f6186efdea1e545513d202ec123dd', 86),
(79304, '813004418ec60b4cfc9a197de6a56893', 20),
(80155, 'f37432dc1863442b2d43351c815547ec', 55),
(87556, 'a67132dce00212435c3f3c631c5cae8a', 54),
(87882, '7b9d6892b812b31ceac8e1e03ed75e1a', 143),
(99874, 'd43a98be58b5275145123b7e772f1ecc', 148),
(109726, '2ff1bafd7f18d9259484aa477c0948ca', 140),
(121815, 'b63121e0ac29d7dd1b051810114f595b', 66),
(122516, '9b327bc4555cc05b63b675087b5bff66', 153),
(123028, '6c7e5870f9013ee95f4e8949ebbe8cf5', 149),
(124677, '1ec20349d9492c0caa1a221c59044563', 155),
(125133, 'd3a977c75e6dffeefdbf4bda7179622e', 154),
(130052, 'd38fa53023456e17688e75d3edae1f72', 114),
(130417, 'c3e48aa52457d42e61131e0d0f7130ea', 67),
(132068, 'a6d732d4f32ac60362ce461422fedbf5', 145),
(145434, 'e479119adc7689231683ef258084b509', 110),
(146389, 'bf7cba527a6b5491ddea927b1f662e03', 152),
(156299, '7db4a1272b92628416a1de2bc0ce184c', 57),
(156778, '58b49e8bbfc0c71f125325c5b9d76357', 46),
(158225, '0985d1a1b8b4a6ea7bf3044b548fa90a', 127),
(161996, 'a4b0441eab0d344852ac13204fce8c91', 22),
(162767, '0ac9181eaa09c111537363adea56dfc5', 25),
(168459, 'b0b3332767ca2c7607a95bc353854eff', 166),
(172148, '2e42cb978db16d8b52cbdf0824ed7119', 100),
(177631, 'd81ca81ee1353cc0c8116f40bc31db3d', 161),
(183238, '82f3590394327eb651af20714254dfd4', 174),
(183311, 'dddc2d21d9efd9403ee9664323bcd80c', 175),
(183320, '8c6f88265b70731f76afad91ef0b9b44', 176),
(203789, '03965fa9d123fd5f1977b898af9d8bd0', 97),
(208996, '797c77bb00a961dee555a29ce7b59476', 157),
(211844, '20915c69183d56d5e523096dc15953ca', 146),
(218128, '59b963dbd3d33a672ce349fbdf77d7a4', 141),
(218801, 'b2fb821ebd98851c8f9fca0ee8327dc3', 187),
(219541, 'b2c37a7ee8e5fbb3948516656876c3f5', 85),
(223419, '533114c4c4dac9b6ba52875520a64bb5', 159),
(226742, '8ec2525397700ce28cdf986368c7d855', 117),
(230104, 'f3624557e81d6234d350bf616c3adae3', 163),
(238568, 'a753c51845a07c65cbc50f90d3bb961d', 70),
(239144, 'bdae91958fd8083d9c5c1a7fbae57054', 162),
(244159, '61e9bb13738ef919b01c167e43a2d91d', 109),
(249327, 'd873dcb36db0509a9031a7e81d85e5ca', 184),
(254330, '1957a547c6b9a79229e2b6bdffda2d8d', 193),
(260073, '0afa95d6c72d5ed0a38939a66d376420', 48),
(260661, '3c91cc61e024dc938dd996e1ed264ac4', 142),
(263706, '8126873ef3cf7ce222479d25e1df88d9', 126),
(265202, '5d0efc1a9cf0e079165d0cb08f6c2428', 178),
(267408, '4cbb5378902612464670024a8cb3a3fb', 73),
(268775, '2d6edff6c44e6a8d2104e15189e1655c', 182),
(268941, '3292185e950f43065566fe18dd02037c', 156),
(274801, 'd449ad1087160f61b594a47566c3339f', 198),
(275512, '82f89ab6ce54be8538288b2ec6dcfaa9', 101),
(277734, '4f500c11827dabe6a0bb58a23f2d6aeb', 169),
(281737, '5e0fe2cb33f7f6a0863af09a38c22048', 96),
(281794, '2d898efd4556ce1d469623ee08f2e25d', 52),
(286212, 'da432e3be9f597a4b612378b086d4a86', 94),
(286360, 'fe9aaabdf5c2e9a715baa169f0fb4e3a', 93),
(286379, '79147fe2185ab744a24929c2dd5b5000', 59),
(290870, '68030929e4b7245519b55e5c08f7b661', 53),
(293655, '3f555bbd44ddeb7f32c4f4da2a4a8df0', 128),
(293870, '61ccdedaf36a6a2adcbd46722df0bca0', 82),
(293871, '64b52ef8ba24773010afbe169243daa9', 186),
(293883, 'f39d5e1abf093b0f1612e5dd04495d96', 14),
(293969, 'ab099d36c459a105a894520f342444f9', 197),
(294712, '525bc525e2d512891f821ea34e9d151a', 180),
(294819, '3c0f6f0a78522e1c917884b3e8f7bb58', 17),
(295012, '3460599ce95c482cc9bfd931e41b4e88', 88),
(296233, '30f35bc5fc75c53b9632c09b95958680', 164),
(296237, 'b68b9f7603ceb5c5b176c10538e37483', 167),
(296393, 'e0482f51d2a5ab88241684b4b60b6604', 179),
(296629, '918f8a76fb0237480d31d3d9af908d30', 177),
(296775, '577aea1ab7ff5fd93691be6d5125212b', 168),
(296950, '0297f65d3cd50a8e3f608edd740fc435', 171),
(296952, '89b24c5d53fb0e9a2bf104f6a4df3ccf', 50),
(296966, 'eb1f6849c4c243737227587d0c123c96', 18),
(296971, '247043b7834454cc949ec93bf7d0ff0a', 189),
(296999, 'd2b33d2c1fa2cf03e7aeeb353faae280', 192),
(297001, 'e65fab667cf492e93080ffd719fe66ee', 62),
(297009, 'c97bb606522c28de98515cfd4d48fce3', 151),
(297013, '2617420c854cf23e033230d0a31eb3e9', 181),
(297014, '879237679d168824a4145264bd8907e2', 87),
(297018, '605edf5cd60038f385b5de800817e1cb', 75),
(297025, 'e4f0707176009b4d56c534bb3b69b7a5', 113),
(297028, 'dfae97a8cb2fc04c89da94f0cb9bb496', 8),
(297030, '415f80cde4fd106252c034db06c89da1', 78),
(297036, 'a0bb586feafef11b7f8ab5cec2ce0738', 49),
(297040, '87c1f1cc4adde8de42ec9253b35b719c', 7),
(297041, '97109a5a9afe39ce5c19cf9faf627a2d', 111),
(297049, 'd7875087bb30c00ddc65bf595bd0e27a', 47),
(297054, '840b80fd6829ad85837d7dc868219e3c', 99),
(297066, '4ec75ae3aeae87e1208908cc4637385e', 199),
(297067, 'dde7eba0e05a0163527f675aed34aca0', 79),
(297069, '48423918dd0bc4160bdd713671dbba16', 9),
(297072, 'b51149ae1d312dc523255a9f6abf5c1f', 150),
(297073, '7aaf170fdb05f9fc5aaa377a15570fca', 69),
(297074, 'cbe51d14c1d76eebf46d247a6d7a6009', 185),
(297075, '5948351225bd191ace4fc036b621e087', 51),
(297076, '7550ba361a1b92e87f686fa7f40b0039', 65),
(297078, '6444f078803f085b8a2339c09ca846a7', 74),
(297079, '5ce6863ca5e3f167b279b679a4f90e74', 92),
(297081, '6dd97189fcaee5f69db2d9f93e2123d2', 195),
(297084, '890a3224a972f2d841a04e893267db8b', 190),
(297090, '5ea8106c8d5883816839d57948084dab', 188),
(297091, '93b0b731ff0ec466129ff6c9eced6a5f', 147),
(297095, 'f010a5d5d0a6a03be6e88a0c7dcc70a9', 160),
(297097, '3c32b369eee6648e35ddc025a1562698', 13),
(297100, 'cb3b65820124ec4d0afc9f8954f65f23', 172),
(297102, '1eac85fbb450e45d001627bad700f531', 196),
(297105, '7292e5faad1d1637436ad59588eded67', 71),
(297111, '6016c599ca527b200295785fdf8379a9', 19),
(297114, '1e264d6fcab1fd6a37fb20e443cd5b5b', 21),
(297116, '2dc8a2e3ea1b01905dbe444f83b5d877', 61),
(297118, '3d2b7f9bf53e94fcaaa7caf4ea6b5fba', 144),
(297120, '709791d4db3fd6986618d885bcf30f1a', 183),
(297121, 'a68c01b540dd6e49c56a21a5b67fd6d2', 11),
(297125, '278469bb66a4cda31f56fd30f01e69e6', 170),
(297126, '4a037808a5d21cca861fba6f4b856c42', 173),
(297127, '771a62f34724b909d5e567a35dc19f9a', 16),
(297128, '057775416281bf5465e1eb075dfa6e02', 63),
(297129, 'b96b4894804e4b93eff2aaca1e508f43', 2),
(297131, '156bf3b45b343aca8beabee3ba10f417', 68),
(297132, 'f4b9684402e906b29d6b3bc034a9072e', 56),
(297133, 'ca7839dd30ebd8c10bba26d22a759cc6', 98),
(297135, 'eae2545b842decfea67337060220bde7', 112),
(297136, '857914ce526fdda64e6e78732f486d07', 84),
(297137, '38d961d9f4f7d8a4d875881e7b1fc4c3', 191),
(297139, '5fa7dbad6817c026bd0a799c988a9dba', 10),
(297140, 'b34c493ff2a4a2b3124b60affe7a2549', 158),
(297141, '637e144fb126848cb720c8ab2b5bb751', 165),
(297142, '6567a5fb592920c5713a5afa94d874a1', 83),
(297143, '1594804a86d9f3cd1e9867920d70df33', 77),
(297146, '83923c8ae73888be1788855a47024f52', 76),
(297152, 'f2009ef1daaf601a33302256b154c4bb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `id_dealer` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT '1',
  `date_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id_auto`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_log`
--

CREATE TABLE IF NOT EXISTS `user_login_log` (
  `id_auto` int(11) NOT NULL AUTO_INCREMENT,
  `last_activity` text NOT NULL,
  `id_auto_login` int(11) NOT NULL,
  `date_login` datetime DEFAULT NULL,
  `session_id` text NOT NULL,
  `ip_address` text NOT NULL,
  `user_agent` text NOT NULL,
  PRIMARY KEY (`id_auto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE IF NOT EXISTS `week` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `intid_week` int(8) NOT NULL,
  `intbulan` tinyint(4) NOT NULL,
  `inttahun` int(11) NOT NULL DEFAULT '0',
  `dateweek_start` date NOT NULL,
  `dateweek_end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `intid_week` (`intid_week`,`intbulan`,`inttahun`,`dateweek_start`,`dateweek_end`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=273 ;

--
-- Dumping data for table `week`
--

INSERT INTO `week` (`id`, `intid_week`, `intbulan`, `inttahun`, `dateweek_start`, `dateweek_end`) VALUES
(1, 1, 1, 2014, '2014-01-01', '2014-01-04'),
(166, 1, 1, 2015, '2015-01-05', '2015-01-10'),
(221, 1, 1, 2016, '2016-01-04', '2016-01-09'),
(2, 2, 1, 2013, '2013-01-07', '2013-01-12'),
(114, 2, 1, 2014, '2014-01-06', '2014-01-11'),
(167, 2, 1, 2015, '2015-01-12', '2015-01-17'),
(222, 2, 1, 2016, '2016-01-11', '2016-01-16'),
(3, 3, 1, 2013, '2013-01-14', '2013-01-19'),
(115, 3, 1, 2014, '2014-01-13', '2014-01-18'),
(169, 3, 1, 2015, '2015-01-19', '2015-01-24'),
(223, 3, 1, 2016, '2016-01-18', '2016-01-23'),
(4, 4, 1, 2013, '2013-01-21', '2013-01-26'),
(116, 4, 1, 2014, '2014-01-20', '2014-01-25'),
(170, 4, 1, 2015, '2015-01-26', '2015-01-31'),
(224, 4, 1, 2016, '2016-01-25', '2016-01-30'),
(5, 5, 1, 2013, '2013-01-28', '2013-02-02'),
(117, 5, 1, 2014, '2014-01-27', '2014-02-01'),
(171, 5, 2, 2015, '2015-02-02', '2015-02-07'),
(225, 5, 2, 2016, '2016-02-01', '2016-02-06'),
(6, 6, 2, 2013, '2013-02-04', '2013-02-09'),
(118, 6, 2, 2014, '2014-02-03', '2014-02-08'),
(172, 6, 2, 2015, '2015-02-09', '2015-02-14'),
(226, 6, 2, 2016, '2016-02-08', '2016-02-13'),
(7, 7, 2, 2013, '2013-02-11', '2013-02-16'),
(119, 7, 2, 2014, '2014-02-10', '2014-02-15'),
(173, 7, 2, 2015, '2015-02-16', '2015-02-21'),
(227, 7, 2, 2016, '2016-02-15', '2016-02-20'),
(8, 8, 2, 2013, '2013-02-18', '2013-02-23'),
(120, 8, 2, 2014, '2014-02-17', '2014-02-22'),
(174, 8, 2, 2015, '2015-02-23', '2015-02-28'),
(228, 8, 2, 2016, '2016-02-22', '2016-02-27'),
(9, 9, 2, 2013, '2013-02-25', '2013-03-02'),
(121, 9, 2, 2014, '2014-02-24', '2014-03-01'),
(175, 9, 3, 2015, '2015-03-02', '2015-03-07'),
(229, 9, 3, 2016, '2016-02-29', '2016-03-05'),
(10, 10, 3, 2013, '2013-03-04', '2013-03-09'),
(122, 10, 3, 2014, '2014-03-03', '2014-03-08'),
(176, 10, 3, 2015, '2015-03-09', '2015-03-14'),
(230, 10, 3, 2016, '2016-03-07', '2016-03-12'),
(11, 11, 3, 2013, '2013-03-11', '2013-03-16'),
(123, 11, 3, 2014, '2014-03-10', '2014-03-15'),
(177, 11, 3, 2015, '2015-03-16', '2015-03-21'),
(231, 11, 3, 2016, '2016-03-14', '2016-03-19'),
(12, 12, 3, 2013, '2013-03-18', '2013-03-23'),
(124, 12, 3, 2014, '2014-03-17', '2014-03-22'),
(178, 12, 3, 2015, '2015-03-23', '2015-03-28'),
(232, 12, 3, 2016, '2016-03-21', '2016-03-26'),
(13, 13, 3, 2013, '2013-03-25', '2013-03-30'),
(125, 13, 3, 2014, '2014-03-24', '2014-03-29'),
(233, 13, 3, 2016, '2016-03-28', '2016-04-02'),
(179, 13, 4, 2015, '2015-03-30', '2015-04-04'),
(14, 14, 4, 2013, '2013-04-01', '2013-04-06'),
(126, 14, 4, 2014, '2014-03-31', '2014-04-05'),
(180, 14, 4, 2015, '2015-04-06', '2015-04-11'),
(234, 14, 4, 2016, '2016-04-04', '2016-04-09'),
(15, 15, 4, 2013, '2013-04-08', '2013-04-13'),
(127, 15, 4, 2014, '2014-04-07', '2014-04-12'),
(181, 15, 4, 2015, '2015-04-13', '2015-04-18'),
(235, 15, 4, 2016, '2016-04-11', '2016-04-16'),
(16, 16, 4, 2013, '2013-04-15', '2013-04-20'),
(128, 16, 4, 2014, '2014-04-14', '2014-04-19'),
(182, 16, 4, 2015, '2015-04-20', '2015-04-25'),
(236, 16, 4, 2016, '2016-04-18', '2016-04-23'),
(17, 17, 4, 2013, '2013-04-22', '2013-04-27'),
(129, 17, 4, 2014, '2014-04-21', '2014-04-26'),
(183, 17, 4, 2015, '2015-04-27', '2015-05-02'),
(237, 17, 4, 2016, '2016-04-25', '2016-04-30'),
(130, 18, 4, 2014, '2014-04-28', '2014-05-03'),
(18, 18, 5, 2013, '2013-04-29', '2013-05-04'),
(184, 18, 5, 2015, '2015-05-04', '2015-05-09'),
(238, 18, 5, 2016, '2016-05-02', '2016-05-07'),
(19, 19, 5, 2013, '2013-05-06', '2013-05-11'),
(131, 19, 5, 2014, '2014-05-05', '2014-05-10'),
(185, 19, 5, 2015, '2015-05-11', '2015-05-16'),
(239, 19, 5, 2016, '2016-05-09', '2016-05-14'),
(20, 20, 5, 2013, '2013-05-13', '2013-05-18'),
(132, 20, 5, 2014, '2014-05-12', '2014-05-17'),
(186, 20, 5, 2015, '2015-05-18', '2015-05-23'),
(240, 20, 5, 2016, '2016-05-16', '2016-05-21'),
(21, 21, 5, 2013, '2013-05-20', '2013-05-25'),
(133, 21, 5, 2014, '2014-05-19', '2014-05-24'),
(187, 21, 5, 2015, '2015-05-25', '2015-05-30'),
(241, 21, 5, 2016, '2016-05-23', '2016-05-28'),
(22, 22, 5, 2013, '2013-05-27', '2013-06-01'),
(134, 22, 5, 2014, '2014-05-26', '2014-05-31'),
(190, 22, 6, 2015, '2015-06-01', '2015-06-06'),
(242, 22, 6, 2016, '2016-05-30', '2016-06-04'),
(23, 23, 6, 2013, '2013-06-03', '2013-06-08'),
(135, 23, 6, 2014, '2014-06-02', '2014-06-07'),
(191, 23, 6, 2015, '2015-06-08', '2015-06-13'),
(243, 23, 6, 2016, '2016-06-06', '2016-06-11'),
(24, 24, 6, 2013, '2013-06-10', '2013-06-15'),
(136, 24, 6, 2014, '2014-06-09', '2014-06-14'),
(192, 24, 6, 2015, '2015-06-15', '2015-06-20'),
(244, 24, 6, 2016, '2016-06-13', '2016-06-18'),
(25, 25, 6, 2013, '2013-06-17', '2013-06-22'),
(137, 25, 6, 2014, '2014-06-16', '2014-06-21'),
(193, 25, 6, 2015, '2015-06-22', '2015-06-27'),
(245, 25, 6, 2016, '2016-06-20', '2016-06-25'),
(26, 26, 6, 2013, '2013-06-24', '2013-06-29'),
(138, 26, 6, 2014, '2014-06-23', '2014-06-28'),
(246, 26, 6, 2016, '2016-06-27', '2016-07-02'),
(194, 26, 7, 2015, '2015-06-29', '2015-07-04'),
(27, 27, 7, 2013, '2013-07-01', '2013-07-06'),
(139, 27, 7, 2014, '2014-06-30', '2014-07-05'),
(195, 27, 7, 2015, '2015-07-06', '2015-07-11'),
(247, 27, 7, 2016, '2016-07-04', '2016-07-09'),
(28, 28, 7, 2013, '2013-07-08', '2013-07-13'),
(140, 28, 7, 2014, '2014-07-07', '2014-07-12'),
(196, 28, 7, 2015, '2015-07-13', '2015-07-18'),
(248, 28, 7, 2016, '2016-07-11', '2016-07-16'),
(29, 29, 7, 2013, '2013-07-15', '2013-07-20'),
(141, 29, 7, 2014, '2014-07-14', '2014-07-19'),
(197, 29, 7, 2015, '2015-07-20', '2015-07-25'),
(249, 29, 7, 2016, '2016-07-18', '2016-07-23'),
(30, 30, 7, 2013, '2013-07-22', '2013-07-27'),
(142, 30, 7, 2014, '2014-07-21', '2014-07-26'),
(198, 30, 7, 2015, '2015-07-27', '2015-08-01'),
(250, 30, 7, 2016, '2016-07-25', '2016-07-30'),
(31, 31, 7, 2013, '2013-07-29', '2013-08-03'),
(143, 31, 7, 2014, '2014-07-28', '2014-08-02'),
(199, 31, 8, 2015, '2015-08-03', '2015-08-08'),
(251, 31, 8, 2016, '2016-08-01', '2016-08-06'),
(32, 32, 8, 2013, '2013-08-05', '2013-08-10'),
(144, 32, 8, 2014, '2014-08-04', '2014-08-09'),
(200, 32, 8, 2015, '2015-08-10', '2015-08-15'),
(252, 32, 8, 2016, '2016-08-08', '2016-08-13'),
(33, 33, 8, 2013, '2013-08-12', '2013-08-17'),
(145, 33, 8, 2014, '2014-08-11', '2014-08-16'),
(201, 33, 8, 2015, '2015-08-17', '2015-08-22'),
(253, 33, 8, 2016, '2016-08-15', '2016-08-20'),
(34, 34, 8, 2013, '2013-08-19', '2013-08-24'),
(146, 34, 8, 2014, '2014-08-18', '2014-08-23'),
(202, 34, 8, 2015, '2015-08-24', '2015-08-29'),
(254, 34, 8, 2016, '2016-08-22', '2016-08-27'),
(35, 35, 8, 2013, '2013-08-26', '2013-08-31'),
(147, 35, 8, 2014, '2014-08-25', '2014-08-30'),
(203, 35, 9, 2015, '2015-08-31', '2015-09-05'),
(255, 35, 9, 2016, '2016-08-29', '2016-09-03'),
(36, 36, 9, 2013, '2013-09-02', '2013-09-07'),
(148, 36, 9, 2014, '2014-09-01', '2014-09-06'),
(204, 36, 9, 2015, '2015-09-07', '2015-09-12'),
(256, 36, 9, 2016, '2016-09-05', '2016-09-10'),
(37, 37, 9, 2013, '2013-09-09', '2013-09-14'),
(149, 37, 9, 2014, '2014-09-08', '2014-09-13'),
(205, 37, 9, 2015, '2015-09-14', '2015-09-19'),
(257, 37, 9, 2016, '2016-09-12', '2016-09-17'),
(38, 38, 9, 2013, '2013-09-16', '2013-09-21'),
(150, 38, 9, 2014, '2014-09-15', '2014-09-20'),
(206, 38, 9, 2015, '2015-09-21', '2015-09-26'),
(258, 38, 9, 2016, '2016-09-19', '2016-09-24'),
(39, 39, 9, 2013, '2013-09-23', '2013-09-28'),
(151, 39, 9, 2014, '2014-09-22', '2014-09-27'),
(207, 39, 9, 2015, '2015-09-28', '2015-10-03'),
(259, 39, 9, 2016, '2016-09-26', '2016-10-01'),
(40, 40, 10, 2013, '2013-09-30', '2013-10-05'),
(152, 40, 10, 2014, '2014-09-29', '2014-10-04'),
(208, 40, 10, 2015, '2015-10-05', '2015-10-10'),
(260, 40, 10, 2016, '2016-10-03', '2016-10-08'),
(41, 41, 10, 2013, '2013-10-07', '2013-10-12'),
(153, 41, 10, 2014, '2014-10-06', '2014-10-11'),
(209, 41, 10, 2015, '2015-10-12', '2015-10-17'),
(261, 41, 10, 2016, '2016-10-10', '2016-10-15'),
(42, 42, 10, 2013, '2013-10-14', '2013-10-19'),
(154, 42, 10, 2014, '2014-10-13', '2014-10-18'),
(210, 42, 10, 2015, '2015-10-19', '2015-10-24'),
(262, 42, 10, 2016, '2016-10-17', '2016-10-22'),
(43, 43, 10, 2013, '2013-10-21', '2013-10-26'),
(155, 43, 10, 2014, '2014-10-20', '2014-10-25'),
(211, 43, 10, 2015, '2015-10-26', '2015-10-31'),
(263, 43, 10, 2016, '2016-10-24', '2016-10-29'),
(44, 44, 10, 2013, '2013-10-28', '2013-11-02'),
(156, 44, 10, 2014, '2014-10-27', '2014-11-01'),
(212, 44, 11, 2015, '2015-11-02', '2015-11-07'),
(264, 44, 11, 2016, '2016-10-31', '2016-11-05'),
(45, 45, 11, 2013, '2013-11-04', '2013-11-09'),
(157, 45, 11, 2014, '2014-11-03', '2014-11-08'),
(213, 45, 11, 2015, '2015-11-09', '2015-11-14'),
(265, 45, 11, 2016, '2016-11-07', '2016-11-12'),
(46, 46, 11, 2013, '2013-11-11', '2013-11-16'),
(158, 46, 11, 2014, '2014-11-10', '2014-11-15'),
(214, 46, 11, 2015, '2015-11-16', '2015-11-21'),
(266, 46, 11, 2016, '2016-11-14', '2016-11-19'),
(47, 47, 11, 2013, '2013-11-18', '2013-11-23'),
(159, 47, 11, 2014, '2014-11-17', '2014-11-22'),
(215, 47, 11, 2015, '2015-11-23', '2015-11-28'),
(267, 47, 11, 2016, '2016-11-21', '2016-11-26'),
(48, 48, 11, 2013, '2013-11-25', '2013-11-30'),
(160, 48, 11, 2014, '2014-11-24', '2014-11-29'),
(268, 48, 11, 2016, '2016-11-28', '2016-12-03'),
(216, 48, 12, 2015, '2015-11-30', '2015-12-05'),
(49, 49, 12, 2013, '2013-12-02', '2013-12-07'),
(161, 49, 12, 2014, '2014-12-01', '2014-12-06'),
(217, 49, 12, 2015, '2015-12-07', '2015-12-12'),
(269, 49, 12, 2016, '2016-12-05', '2016-12-10'),
(50, 50, 12, 2013, '2013-12-09', '2013-12-14'),
(162, 50, 12, 2014, '2014-12-08', '2014-12-13'),
(218, 50, 12, 2015, '2015-12-14', '2015-12-19'),
(270, 50, 12, 2016, '2016-12-12', '2016-12-17'),
(51, 51, 12, 2013, '2013-12-16', '2013-12-21'),
(163, 51, 12, 2014, '2014-12-15', '2014-12-20'),
(219, 51, 12, 2015, '2015-12-21', '2015-12-26'),
(271, 51, 12, 2016, '2016-12-19', '2016-12-24'),
(52, 52, 12, 2013, '2013-12-23', '2013-12-28'),
(164, 52, 12, 2014, '2014-12-22', '2014-12-27'),
(220, 52, 12, 2015, '2015-12-28', '2016-01-02'),
(272, 52, 12, 2016, '2016-12-26', '2016-12-31'),
(188, 53, 12, 2014, '2014-12-29', '2014-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE IF NOT EXISTS `wilayah` (
  `intid_wilayah` int(8) NOT NULL AUTO_INCREMENT,
  `strwilayah` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`intid_wilayah`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`intid_wilayah`, `strwilayah`) VALUES
(1, 'Jawa'),
(2, 'Luar Jawa'),
(3, 'Kuala Lumpur'),
(4, 'Luar Kuala Lumpur');

-- --------------------------------------------------------

--
-- Table structure for table `_activity_log`
--

CREATE TABLE IF NOT EXISTS `_activity_log` (
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `env_ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `_md5hash`
--

CREATE TABLE IF NOT EXISTS `_md5hash` (
  `text` varchar(255) NOT NULL,
  `md5` text,
  PRIMARY KEY (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `_md5hash`
--

INSERT INTO `_md5hash` (`text`, `md5`) VALUES
('ghiffari', '1551dde8fd43cfa9cc809d588f27111d'),
('hanapi', '33c7901b76751a7ed023b5bbbfc82a5d'),
('divalexander', 'b2df28f1487f16365abfe7df0da2e453'),
('M541159', '617080db51b6c864249cd0703e056f94'),
('chscha', '210f34436a5934f1b56552f0cc71229e'),
('m527881', 'f5846001c465cad7b54eab31146fda83'),
('399600', '5329c90eabb83c2a65314a08ae037f08'),
('090580juliani', '76abb2ed3d7c89f7e03d9c424c2789cc'),
('M527888', '3bd22a9476df063cddfae369fae802cc'),
('M539816', '43e819303643c566efee9e503cf546b6'),
('051700am', '5c0f9a59e92d93e2b86c02875e8fdc63'),
('lupalagi', 'caca60fed150e9b827e82e417726d3a0'),
('M01007177', '0f30c5c9f8784338cbec0ade6a520def'),
('M11000424', '7771e3027d3ce5553c7dc397456f8d79'),
('j', '1ac4f3ad6c04d630250716d9b3277051'),
('m541504', '5058732ab3bd4061ded4d9d962618132'),
('m544336', '9d54a3a84342659057bdce111355b45c'),
('280212', 'c43e56aee449d172282dbbaba35c5823'),
('M544344', '2fbe3cde0e627b429401f4c0c2c96828'),
('M535942', 'f1ab25513e427fde5e4b38ad5a33dd65'),
('M01029160', 'af272ade697b45b7fb186f5f98750b7d'),
('ay120675', '46468490e6f7ec016d065fa8906b5c5c'),
('Bismillah', 'a8e52217c48d055fb98e2732c587d056'),
('elda13', '8f5dd03b66559c10e86541a2d46120d1'),
('M544407', '8a26fb9ab40428793e6eb6adfd343ca6'),
('ambu7282', '4a6bec438c54aca413a1de5ea799c02e'),
('badak37', '151001f03b9ceafa214ff681a2993125'),
('161274', '71cd3a1cb01f919bbd6f4fe6d8917d03'),
('M01008403', 'ea64477a09f42c597401ef0193eb4de0'),
('m536408', '845b2818c8081019bae77ccd065cceb8'),
('M528355', '73e4671758e5a5d54f15b064e4a65be6'),
('m544707', 'b213b3a7d103e605c7e38ed5ff6eb26d'),
('M541756', '4182800819e27e175712ee49c8046afc'),
('halo', '57f842286171094855e51fc3a541c1e2'),
('66554433322', '292ba94c779ed1632dffd0234961bc9b'),
('M00701106', '0bab6e27ffa5751fa5a06c8349ed4722'),
('M544366', '6ec5289dc7a95e760614043bad30ca72'),
('m532940', 'db3c35366a4e9de5b2a9604b5c82977e'),
('170956', 'd605266e308134cff30e6671da1bab77'),
('M01001374', 'f3a8fa57b799b4a7f78dc436c2f7a441'),
('lampung3012', '1dd3a33d93bd30a9b18d2c8eae0f2e46'),
('M12010548', '7fb59317372d96e023deed08e4ac3442'),
('herlinshop05', '565b769d3c2a94eba515655b3a599b24'),
('d35tiati', 'b20d78920bcb92552e91e9b30a37f340'),
('?01002412', '8aac87fc5624f8f63acd0f0baf2e2f7c'),
('cinere17', '8e5f93bfc07a0c9ab0440638d21682c3'),
('123', '202cb962ac59075b964b07152d234b70'),
('M0103928', '4a7788e3bc5f6c8af74dec2415f36447'),
('bebek', '69492767a592621ec0e785e0135e1c6f'),
('081984', 'f120ba3891b8853ad6a9ed360b361e13'),
('bronisss', '7317aba52340a46f027579ccc3923efb'),
('m537922', '75e9e47a68e2db2da1e6af4f5ca91f40'),
('M01013670', 'b728b6c65c124cdcf66f9235ba3814f5'),
('furqani', 'e0c07d9c4481455be35bb8086058f9a2'),
('M25475', 'd895a57c2d52da6ee1ad56fd775b7500'),
('efan', '3f1a34018a7048fcc8bf7027fb0ae6f7'),
('M543426', '6d3ce3fc04610527d5e680fccb2edb9d'),
('082181927678', 'f989036fc2510acde612025fc3fc8d65'),
('M01027743', 'ada9ae1512636311e7dbf72c4f0be7ef'),
('M525502', '7702d29ae4b781e9558a6d0f70c5b93e'),
('felice12', '415dcc6ad8edccced5240f3cfbedc45d'),
('dafamar1hot', 'e0fdf175b0493fcbfba36551c1c1a1c6'),
('ciamis157', 'abc63ff521e74435335efccbf5ff83ad'),
('m01024729', 'a47dff10bb2b5358d225d0184af15c0c'),
('M524526', '22427da8162e76fdc35b2d3d535f72f8'),
('M544448', '3433cb5fb83821b657323a106508b0fe'),
('lampung105', 'b0bfee0f0348272351452d8a4663fc5b'),
('M01040336', 'd144bdd57a5437c49b7c8864b034a075'),
('blora93', '8502921f193b83fd5f70d7c09bb8fe57'),
('atayafirzha07', 'fa92e38f3cdaa1e34a61e2a1ed87a3f0'),
('26122012es', 'b2d5de5edcfc78400783d2276ee3b298'),
('M01021397', '52c78458d58b3f86f80692de33564f90'),
('M21001003', '9046d9698b613d333697781d11cdc85a'),
('0313285124', '52ee8fd73389ff805ce8727271fa03fb'),
('deailka', 'e662fa48ac00a85d136701470868d71b'),
('bebas', '55068633833f96992f430cb156bb08dd'),
('1', 'c4ca4238a0b923820dcc509a6f75849b'),
('horningkarl', '6a4b8bb40c02a719a93c706145c373aa'),
('eldarini13', '30e78b08e70fcc9ed065e701bbf88d32'),
('Inlove08', 'bbf80483bc5dea7b79d05f7633d2be56'),
('bintang25', '3e991f4593cd79f65319dfd9a93a18e3'),
('060604', 'e2aea6510a27a26cbbd4e27099c46637'),
('M540375', '62e7098be7c0e374232d201f7413a5fb'),
('021106abiumi', '1dc9fa7f65a67b8212a1104597c411b1'),
('"Halo"', 'f9dd651add9f639832663a7ecc64e45d'),
('M1013470', 'f124f356fb884ba214f892196a049ded'),
('19850513', '73de7277f541c6f3df24fbfa63448bb6'),
('M540958', '1ecd5e67596b72c33e57cbf7c0ef6b67'),
('m536178', '8129acbdf5ee31c31f26f6f0d5c5d148'),
('.12005188', '95d8ad90eb8925fb5ce7e459eb29e84e'),
('140201', 'd29b5ce9c2883f0b7e90f79071a2ca82'),
('cirengenak', 'e8cb9d8f0649aff51f1b3586758899ba'),
('1234', '81dc9bdb52d04dc20036dbd8313ed055'),
('garut070482', '5d34db278dca9ed6a6f81eb7d8d2da79'),
('M01038337', '26920ba77a407a954765be2e55ac2ab0'),
('M542715', '475b234eaeae04e00c21000185d8186b'),
('garut82', 'bf6f5b03221922bf260760e0e5deab7f'),
('m01 005246', '10c9c21e356545271a9bd4e3a898bb81'),
('lestari69', '2991132caf7c9aec5465627e541e07b6'),
('27882160', 'cda856f1bc6d647366f9e15861dd21b1'),
('ana.surbakti01', '0103f6eca10a85f2a25cc3651fabf053'),
('ay260406', 'e6a998cdd516000337837cf194c07568'),
('M01016437', 'a9b58bbac47c5b8fe84dbe11c64acac6'),
('F041322', '872bf9747b7bb49d6a6dc5917cee7f8b'),
('ely12345', 'fda35a7e646ba30f60d8af6415826bcd'),
('M543388', '597c80a115a8741a0772931be82407a0'),
('JJH2005', '8c749954592d0326204041fe3ac47104'),
('M34495', 'f46e7763b067c8e0a32941215d7999d8'),
('HERLI000404', '90bd5695e104168479a1ff9908260ddd'),
('Happy..', '4af74e6fbe000b5c077d1f06c8e27e66'),
('M0103670', '57a90849a1a5e3a775978bcf22407925'),
('FAIZIZUL', '2fcad829a374a6699f3674773663aa7a'),
('M530375', '045c096e5aeb3ef252c6c2cf7451a124'),
('M532802', '3c9096fa612690aaf1023679abef8f23'),
('M545289', '6fea2ae4e06ce48f8a2f99b9c997d8a4'),
('8860923', 'cb5bb1daa2d5df39a1be98003753e0d2'),
('lmajafin', '7859d8f3d14739f5ed1717bb0dafa7e7'),
('bukit161', '7e1fcbea8c98b103bf82ddded86bcdb6'),
('bu paswordna M544050', 'ec71d8dce59b1b6577adbb927f003385'),
('herlina', '4e196a6c133a04f8a81d742b04e7ffe7'),
('300538', 'd217a5796936f9047b7d14d84061e34a'),
('habibiebintang', 'fa7aecafdd3c5bd7a6995ee81a2c50ca'),
('M544418', 'a2b1f2cbcb2675f3836dccda68d5208c'),
('antonantin', '0e55da18451289e27253b4adbd360ddf'),
('101079', '713060b0e45474086a605470114e0551'),
('M01021333', '985fe2d43666c154ea3d3bc2896248a4'),
('ferina', '7450ebdc4ed9beb12d90b1f9672be1fc'),
('042984', '2d43372e324fd6471f80b5f24f59c620'),
('311986', '3a9e7bfea30aac0f47c13fa863ee2428'),
('M535679', '440c9dc6805b4b373289168db6bf9707'),
('M544587', '9057f0a89c71c13d5d212003406429bf'),
('M01032178', '83d83882ae2026e227cdf0ebb2e606cc'),
('8888888', '388ec3e3fa4983032b4f3e7d8fcb65ad'),
('M010320', '39309243385b29b87b0c4372d75cb438'),
('eliseadhi', 'e1b273cd610644ebe677aa6d4f73d7ad'),
('26122012', 'aa470f8e7cfe134101416c8abf1cc215'),
(' M01004842', '9885f251f191c8764564867d672c9fca'),
('930425', 'bdf88443307a4ce69258fd788b7b0fdf'),
('bintang14', '67109d8560ee1d43c64037dc1d75f65e'),
('M153323', '2693a4f9d0fafae9b45c2a59a455b296'),
('M12004691', '50fdc28eba1a8a5e644fe28d1b81ce1b'),
('M544523', '08f4c2583348c38c95eb547caa041fa9'),
('m01002422', 'e57ac4d20944dad5c985d82e9b2f1724'),
('jqnganlupa136', 'b04dd8ac16cc9a69ae619fd46b9bbc10'),
('dandangan83', 'd5cb5c9bfd3896d09f573b77334fad25'),
('M529280', 'cbcb9b6cf0b0e132fc46bfad4428d828'),
('M01004703', 'e9a2a58386627d323cda4fc23e99d34b'),
('M01042622', '82c7b1d2414a62ddc152e6c8d8f1862f'),
('iqbalku', '8257fae1f3cc2625c779a8b2cbb3fdbf'),
('alyahaly', '2eede8bae32175a8afb2b2ce614726db'),
('M528673', '09857defa16dc65c44dae7ba49fe7030'),
('M.01016473', '465d9461cc22591868e4a670e0b3a284'),
('M543936', '987416c4744037684bcf3d4bddf24436'),
('happy', '56ab24c15b72a457069c5ea42fcfc640'),
('291006', 'ca6c95dcc917dade6c78921f1456530d'),
('110508', '8968c88ecaeea18a6ab465c52a6dceee'),
(' 	AAC93925 ', '63ae4392b380d6502dce9f25a5e05193'),
('lely 05', '0c60fbe0ca60aedd803b24072e742cb5'),
('ER193175', '958d93162b6c2310a873c6077c704a73'),
('albanna', '68a998619a12221a6fe379575be5390f'),
('katasandi12', 'd28be49df1d3414659b10d7cacab9f7b'),
('dimasatria', 'c309d2ad83d21d8705368e4a0bce5467'),
('29111981', '97eed19e2d8aa16a9079d94a175137df'),
('F391322', 'e3971fd3cb6e76facc45af5c867a04b3'),
('leanoah', '4043e3926f7eaa97992efb4ce1fcc187'),
('khanzanillah', '3f9317c239885964077dc83e259c93e3'),
('kanadya210', '83614329126c3207623d09920c372959'),
('M44601', '0b60bd3f4e8d80d71647b75fb238d615'),
('lokung1973', '5b081922e70d60e9238fc7fdd0956e52'),
('M543195', '717510447f0d6a3e0047ad23b2dba198'),
('cita010109', '79c80f6a52c8a52188d5783bcc976dc2'),
('m0100e412', 'b883a5847a7588bd6469aff62a4b0cd6'),
('M528994', 'cca4e750bf2974fc8d9177926450e871'),
('dewitul1p', '61756eac0240100930943dc6b985bde5'),
('bintaro158', '17eaa126ccdfac88d3e53e0b3deae36b'),
('M529451', '2a54f7d595d549bb9c8119974e54ccf9'),
('hammam212', 'c0bb054b2e3b0df305271e65ee38a4a8'),
('donald1106', '8ebded912b7ccb25b8b031f01f9275db'),
('M525465', 'a30473823b8c45c32e574ebce1bc73d2'),
('19111987es', '70df00312a94dfdcc2c91fb184ced937'),
('M534168', '92cacf04fc2a74b07e2f4675d250bdd3'),
('M538810', '4acdd1839160ca197fedc61c0ceff6d6'),
('lina15', '7e3a94c570fcc58bfcfe5a4ba0e3d431'),
('M525342', '0b3a5a8b7d52bb7e2437953b88377a03'),
('M543682', 'd559982e59eee707bdd606ec3503798c'),
('m524415', 'a6062e8642f10d1658357f12b0da4921'),
('M534737', '0fc91b8879b7e12b60d079badd653d82'),
('291119811314', '8ef11391fdb13537c9c182387d512f2f'),
('daffamar1ot', 'a5ea5d23000385a8414c560eeb061ada'),
('m525789', '3d86016223189fc8d30972e14cdffa10'),
('H12001181', 'c5ee24e6c03b3f9cd4dbe0aab6f9293c'),
('M544708', '059e0deed132f8ee0382f94a15872d99'),
(' M783082', '57237c5b4d3bf5873a5da6d49253f31c'),
('loverimba', '02399f55efd9f0099324f4081479d0a6'),
('102877', '3ddb4575c30fc4bdc1f26a18c70aa693'),
('040378', '59ca19890b83dacbb16d24a461dfa275'),
('alyahali', '1df18eb66d34994d7fda3081d7187a49'),
('M01013470', '0e024010a9bd829d9cada79850fc3a8b'),
('m11000432', '4e17cb42531d87d495febf64ef31113e'),
('m543259', '1dc90261b2cf8cd0768097771ad41b2e'),
('M544809', '354116ded1245bba871c5443565daabe'),
('M01010474', '8b8e4d134ed249a363d7c8655736d5c3'),
('festival', 'ae8fc55ccdc61c9812a7e247cf4dafdf'),
('M01013480', '974a9d063a1e388b90af2ca73c45cf07'),
('39600', 'c8288308562df62a6a837190f9ccaa45'),
('liajuhlia79', 'c96981c57abe0b35c9025ed742ac6a11'),
('http://www.gotulipware.com/member/member/detailProfile1', '681395e644d26e4c315975f8cee09662'),
('jidadroi', 'fc214b80f6782e0c96ae6b8c6544d94f'),
('M01005787', 'ac61c842928424c4ee7acaee6402c077'),
('M544607', '1d388a112c329c91df3f85a1f0249979'),
('bayak', 'fe606c8f92b6e39ca8e384c43ed85f62'),
('m01002s12', '41ea15491a43b37105236d7465869912'),
('m544844', '6280b00f64f848a13e2d4e58304d1eff'),
('M545878', 'b0191e258d5bbd628a330295ed0c9490'),
('M0101374', 'f1cd1d0d18b3b6d68019ca8f05745e62'),
('M524475', 'e82b7036c60bbd4020c2df3453d30a71'),
('F390422', 'eeaf96dba96f12c6e96000694be0c2d4'),
('M540044', 'ce8b9321d7449abe88545914eb1c86eb'),
('M001002412', '22a626f8a28238885d944cb5008f2da7'),
('m0141482', 'ec8282977493ae0c8dc1876cf0910645'),
('m530484', '804d5dd77e17b6e89730cf7f058b4f1e'),
('F220439', '2e1c8cdbb5cc31883930bb87832712b1'),
('2806185', 'a4d1d2ec11d546798946d1c7cdb01a51'),
('665443322', '1e8d3daf02971affe7a2e381f5dc2525'),
('M545815', 'b68cd529c51455dd1877c662cccbc7ce'),
('020387', '4358c63903e0be933e390482f50b6edd'),
('antaloka24', '942a4de5a1ce6a154f76938d62a322f1'),
('juli090580', 'd0b697608aeb25b408eec41a6368a7ad'),
('M524846', 'd6280a30b13315f562b09d03a5c7fb31'),
('Anggaran96', '9329a4f1e19888f8a26c8d854f2236de'),
('anasurbakti01', '3ec79b3ba3311a5a7b2c4bf66903498e'),
('M120011875', 'b2d2c6a5ff21e0b316ea8302be5a66b8'),
('M01026100', '5b373a097a209d18f0073b51dfd7ce39'),
('795708', 'a69fad5383b59f64029934c3c8c648c7'),
('M01013390', '283924524f81886e587bcc2e925b8ed9'),
('M12001151', '0fb033209107f9627e6bf2256a70729f'),
('blora2015', 'f68befc411f70731b73cc367a45b0602'),
('M525836', 'fd43e6c6011e3a7d223300158fdfb760'),
('herlina0404', '5af8ef31e6d2ca79dd7d7e462dbd8cb8'),
('m01031571', 'a0cd4450e7ebe01672caa8f9f71d7679'),
('041884', 'a9a3a2ff97534ad300f2f66637cf80f6'),
('ay1120674', '114a688273eb43024c2adbdd4b8bc9ac'),
('M0120012', 'f1a9860b2f37ef14dda123d35f8fbc4f'),
('anasayang', 'c54deff466222473a31ac7aa3ba7dfec'),
('fetyfajri', '5ac190358f5526003b9957d8430f980d'),
('M5429O1', '1ec976bb3e422f3157840cadb488cd78'),
('M525572', 'e78754b723e70f09891f3f251279b538'),
('M11000408', '64934018fa1dc0719101b12da3e87ce7'),
('M12001649', '0c3f03977ba2805317080f4d4cf7eb77'),
('dianadee180677', '9f56d1ee87fd15cd5d85e453a550ab70'),
('4546saha', 'e62917d4426bd0791414b76f68b1d8af'),
('m543554', '3a07a00ab47f6754435bb077a0087234'),
('6655443322', '3151a6125f0161176ce4bb0d1dde46a7'),
('benizaid', '4fe9cc063b83e733f4f0087383c7dbfa'),
('M540434', '74e651fa241aa39c6785b19410e4330d'),
('M537430', 'd4bfc62580f41fd6c91af90e9648160c'),
('M01002958', '954ad51ce1df76d669d6aab7d908ef74'),
('M12001181', '84e73f6f82ebf67f4283ac4725a56a40'),
('\0', '93b885adfe0da089cdf634904fd59f71'),
('M543601', '853dbe7c743fcd865ba249f220893740'),
('231085', '40aa93b3e88c1af79e99cda867b81307'),
('hydayat', 'b1543ce0b58f228e7baf09017206b156'),
('2006as2010', '586eee1d4a8cf5405ee9ac75d6cf565c'),
('daffamarihot', '43f51bb76e3f0a448c5931db45ad21d0'),
('Alicha', '1acd5339bb218f3cbb7aa75f3766de65'),
('bayk', 'd3130a5fed71a5fa781fceff8c953428'),
('herlina000404', '8a7b705226ab3074f0b2bc5271c93e60'),
('donya123', 'c968bbe6495788047bc0051c282674bc'),
('M544374', 'b3e35157e7623803e7cd346b450fe033'),
('bintangs', 'c48a9be69e1177339aa8eb919a9e1f07'),
('M528684', 'c5c92fe2e1c60301ebe4a7c92673c30a'),
('M%25%23%26%26%5E%26', '3755d498cc1919a2e5541243bfd20d89'),
('103535', '2d29d1f03e5fa696e8b47e78b202b124'),
('m525162', 'c6bae261f1d74ddf1c0620c94458d2f1'),
('M525228', '96ced169482a422db7a12de9c36a2865'),
('kalipayan123', 'c3149da95a9c4a86d945286b0ad24766'),
('jember60', 'ef6f13e4f8bb01bcef94a5f154a96d56'),
('M12007942', 'b015b27bdd0036c35db08c1c141258c6'),
('M01004959', '6f64e41f14fea1770bde1ca8b4cbe5c7'),
('M010101320', 'efbba8a810f2acaee530ae8f8a433fbd'),
('bekasi2010', '9a2f8109413b82b6832b069e9b29f928'),
('ilovetulip', '950b9d4330e5f72f775bfca5689e31df'),
('28061985:', 'd3f0838e31403e97cfb4b1242ce357e9'),
('041984', '28320b2ccbba4e69e22d63e040872f60'),
('M21002890', 'aca947bf5af08d299cdcc0a2f24d4611'),
('M01015426', '34957dd19471a917b6d77da28752f7f7'),
('M543903', '70cbc7aa2c18414aa39cbfed98ae18ba'),
('fcwulan31', '834246495dbfc59ded88f9fd94cecd96'),
('M539058', '3a9b47525f183fda0323cd3f0700ac3e'),
('M527945', 'bcc6b8f4ca990534196c57a6e0cf05da'),
('m1234', '77c12394ef7d4f23a8fa07d87309afd9'),
('123011mm', '112625cea833fb32f18908fb66fdffed'),
('M540707', '080aea99259d6e9ce6280b26de56f466'),
('and190772', '6af607242b53e852c35a7f712585bf2c'),
('M01003393', '34d1eabd0a0a863097747c2e2e804e13'),
('M020025', 'e9f652a33dcaa392a2a8fab3081fff80'),
('000404', '546a11d10729d20275b96075bc883f17'),
('cengkareng07', 'b6e0d2e170e421a0eacf37f6b7c843bd'),
('m01010320', '2eba1729aa0983d306b2d23c57ed9f45'),
('admin', '21232f297a57a5a743894a0e4a801fc3'),
('970214', 'f8b906b1b34965b712bb25ae96123b16'),
(' M782567', 'af5533efc3b0122b2403c934722d20e9'),
('hoswary0004e04', 'fc568f857bbf7204a944b70b757bced5'),
('332211epi', '7e7af62286960357899bcc779ef281c8'),
('.01041831', '55bb66010adadcf716e5aae809069f21'),
('a2kha_a2kiya', '2a0eb9a4106d8b880065a9414c8b03c3'),
('desilka', '7a717b5606c5c6c3ea04a2a34e8fa592'),
('M2100649', 'de41ca2e5e1d3ee55c0fb9444105a753'),
('heaven905', '5b55acf24a230ae5034888d0cfc3869b'),
('M02038928', 'c1d8fdfb315463e3589d1db31c784551'),
('kungmi@w 1979', '328552950fdefd0adc61cfd46a3e541d'),
('M538598', 'dea83f4f535d66c0f99c9e57739ce3c5'),
('m01010395', 'f978c21d82f6818148aa7da937cf1c6a'),
('M5432444', 'b7eb1f0dec9f61420ca9ecb735b8117d'),
('121212', '93279e3308bdbbeed946fc965017f67a'),
('m543684', '02d026a6371ea92cc8679d222f69b347'),
('271009', 'feed8186a402b7e95d14c3b578567de9'),
('M5394444', '6d723d29ddb6e145e2654cb6122455be'),
('antaloka246', 'c5ed96380cc835b7204832197426ee1b'),
('M53O411', '52c2e6dc50877809c2ba7ec797ac407c'),
('M533697', 'b24e16a5e163fe6feee964d8aacfaa23'),
('M12009735', 'aea8185c5128a8337e2974a4f65acdb5'),
('02072013', '8ab3228907bfc312dd8cf46152fd0101'),
('9143', 'd1d7015fbf729403d7329560afecff1d'),
('m545577', 'ce9e9da7f6075b148de3b0b361dec598'),
('10121972', 'f965e707a2bfbf82aa7c79b144f84deb'),
('kembangapi', '44c1de82c07b441da7fe5b4db2757688'),
('16091979', 'e2e0bd4aa95e806dec222dd9919631cd'),
('m543349', '127fadc1baf892d1213d6661377a20fb'),
('farizanurrahima', '3eb66515f2052f73ef4750cc2738f20c'),
('m01017', '4f8c5a98d7145c2f8028d8a4220425c6'),
('Aiyaati', 'ce0a7e1a2d4fd74500072d143c092f80'),
('bestari2010', 'f756ea0640abeedc51db84264f1f72fb'),
('hylmitsaqib', 'a9f9bc833be84d64925548289ca2bc99'),
('M537593', '26d6cccf02562978bcc94817d9d758f2'),
('777777', 'f63f4fbc9f8c85d409f2f59f2b9e12d5'),
('gma313013', '30649ac3927545f905c7102a870b6634'),
('arazona89', 'a8b9adc366a205e0080818d53880b299'),
('darren3ganteng', '83664f50c9f7531b924e36591a453391'),
('M01041117', '581f8e5c4d8586e32f654d1ac9195d8e'),
('M532812', '17d9c2b0fa200821d656d42c0cb41734'),
('harimlautcantik', '3134954754cb7dd03399203eff9a5967'),
('jauziy', '78d0db34ad75f1cf54791d79defa8fd5'),
('jogja2813', '72bab4ccc15a83c45b84a1eb75e4ad5d'),
('bintang12', '82311e62b25f5175cabb42878449e871'),
('M529406', 'fc1879d252dd8f818199b55a4ca12d8f'),
('M010170048', '758b233605e84e9121e8e8493f310d3b'),
('kualamas379', '79ab3b2ff9980fc6a589296129ea3cf4'),
('606577', 'a52cadbb90666cb1bfb26d73df7579f4'),
('februari13', '700b8f75107dfac943c9159c604849ef'),
('M12010999', 'e57f7f2291b6394eb617eae8eee3715e'),
('bryan0', '7367b951fb5a89e8afba441094d1c839'),
('M537538', 'c1915530cfe9cadf0c516fd86bf4c260'),
('M538636', 'e225ee94d019b939e5b08ef4b1708681'),
('M01041813', '266eb250dd33074fbc2256982d24b5fa'),
('lailaalwin26', '2e793de549950913b47da3a256f87f2b'),
('almanar890', 'e8107b06dafa0401d821d58dedd69348'),
('M542616', '8d1f59f1d8fdd54bf0c7c89e46d3992c'),
('791797', 'b55ca6d86fbb2d0db74e6209a0c41151'),
('0923', '3f4d7a5a8f8f1f72f7d27173d30eb91f'),
('ciprut', 'def97b764dd6a3ca9aca3564f3c8437e'),
('200390', 'dc16ea7578073cfad69f707dd63a77e1'),
('m532591', '283dfb6b3df95efbe6efa82681d89ef3'),
('*arifhidayath#', 'abd50c30e2368e75b9d3e4aa4b42d456'),
('janganlupa146', '3bf95d0548a4485564b6d310f33ef3a7'),
('545284', 'ea129760deb6d42e4285eb54eee9cea8'),
('@zmie1608', 'a11ed25172fe1bca3c9f6b8101ebb235'),
('cikampek3012', 'ee40171ecf52fe08b9cb44fa4c7bc627'),
('kolamrenang', '865f97f4af833a48c09f2ce8b0d40344'),
('embutok', '3cc060ddefcdb6d243bed938ffb55697'),
('M545263', '3c669ec45a9102bbede9f8ef0099174d'),
('011002', 'dce6c0d2880fac41b02971beb31bc24b'),
('M532508', 'a25254f4e83a208c9539e546d079aa76'),
('M01030493', 'acfe242f906a15d27cf7de9f57b4ad48'),
('M535127', '53a9bd764327c3d0b7115700898879d9'),
('bekasi2013', '46e39f9e58c4c8711a901dd4b7e381ff'),
('M544637', '087301af490c62aaaf7a3504785a91f4'),
('090499', '80403dc02a883d0a2cc2a0d48aad063c'),
('m545703', 'fd819535166b7a6561bd6930138c31dc'),
('18april1980', 'b9564db2fa950a34ccbec6b1c22d5d8c'),
('ahnafabdurrahman', 'e24816a44645cafe620dfe0e8937b32d'),
('02031987', 'ca9ee71279256df3df6e10d9c651b2a7'),
('bpp231213', '8859abb7736dbc17c9a7f5ca39e9000a'),
('M544071', 'e9fc3896ed17915bbc14b5da95c11c49'),
('furqania', 'ac55982ca0a3461de5a5831b4cf98097'),
('ay1206744', '36c6a8dfad5b6937bc4af9213e911ebf'),
('1206004', '21593341131f9f4505d788a26fbab41e'),
('M01039544', '5f99b4ee9f6879ee537b82d57dd2f239'),
('M545410', 'd0a1724f6bfa969b1cd0fca19434a7f8'),
('daffamar1hot', '1e095f00405906cd53207c123f35378e'),
('Ini pass w nya M797810', 'eef8868073401848b21cb478d8e1badf'),
('M011002412', '6366afc48a0d0608e594f9b251727765'),
('m543336', 'f77d868a4980302b9dd7d74e9fb5b52c'),
('abiumi221106', '8d3b3a1f93a65fdf2be666bed6fd49a4'),
('M537643', '0f4e9255d81666e0a0249dc212f461e2'),
('akulupalagi', 'fed22f455d8663aa8d7fea5c6531283b'),
('eliermawati', '229772ea0adfdca38cb5bb2910cc78a8'),
('112233', 'd0970714757783e6cf17b26fb8e2298f'),
('M01011143', '53bf669f7efb6e59ad1a2e96267b3c85'),
('m545718', '90132520e927326568ef7c3defa9bb00'),
('M534177', '33d616225171181f58ba04ad70624ee5'),
('041285', 'ab0c2c1992b8fd8ac834833fe2be6034'),
('dee180677', '9ad2b0949367beaf7e2b967614fe334e'),
('bendan1', '54362174cf9f4f91ef81a50918d20620'),
('3713ermawati', '6193123b82f4fe2f4125bef344e6c32e'),
('M01038200', '1b44d57d9fffc570a0244ee4ab26132a'),
('777888', '82819567b9ad4e8c5212f49f67743616'),
('abhi1wed', 'e62f66ca9cf2c7f44689b64d5efe4569'),
('*afaniahidayath#', '81f52cf86976b069020d8ab08ef920fd'),
('M540217', '0fba8eabbc15f8f38b9f09355d9e320f'),
('M43395', '25eb83e3ff29fb5031b02f10ea780054'),
('asd', '7815696ecbf1c96e6894b779456d330e'),
('M538379', '9030e6545265c5a59904874b0499f11c'),
('M536888', '0c304d703f9b94eb514bff2646b59bf2'),
('bundayasiuzan', 'eba2726541ad9601cecfb0cba0aec310'),
('faizizul2', '1b7e39880bfaf932d026ca9fd5af87d9'),
('M537776', '907124c5ac05ec74b2817494cf5e8639'),
('M543309', 'd9eecaf7adfaee974c4336a00bed22da'),
('160688', '12eea6b661af05f82c110368d552b079'),
('M01025103', '2f688833172252a338fceb7e381e6c7f'),
('M540376', '13647cbfdf8e69701d7761cde1064da6'),
('cimaynawa', 'b79b2c7feb442ede4c620948ed65d1cb'),
('231867', 'b527e6821fe6af4e66a028cd74b69016'),
('150853', 'a1bd6eb0c1bcd09e650330b0df01abb7'),
('M01042557', '4fc092ba1ff5a015670cd43c329b2a68'),
('m503484', 'dc3afa2d2062f318aaadd4537e42f831'),
('M0w0swxrw', 'a69ff1db457fadc2c1581e0e56056465'),
('05082014', 'd0cc943d197eb35574d9985bfa028863'),
('bestari2013', '296eee017d80f380cb26eb4cd0567d1d'),
('m0w00eswe', '6b7a28e8dc4d427ce088c29f87386611'),
('540217', 'dd94740f884784987cd47b91f460fc70'),
('M530376', 'bd1e06b627f3b0025d5ec29adf4e146e'),
('M526299', 'c23148b624658aa83138ac6f5637ddfc'),
('at0376jg', '0a54b7817a63c15f658b1f50e95dd6f5'),
('736011tulip', 'd813097c7163825759a180fc5ac4046d'),
('797972', 'b8ef2e32b6910698ab62e6c33eab55dd'),
('3713harusikhlas', 'b2f29859426fdc72ed8aae0847c9e93d'),
('kembar', 'd9b49eff12e749cc01022fa319009a53'),
('bintangs25', '0267c008d47460167eb0bc260a8b4c6a'),
('c@ntik1x', 'b62256b89af9760347763ef2bce205cf'),
('18 april1980', '563bbf7a1ac9a581443c9121018a8644'),
('02mei2010', '4bd09e03551bb9926d2c41082ede99af'),
('3996sayang', 'e22eac14c141d597d54f30a2f73e9f5d'),
(' M794468 ', '1b140f585ddf6e4c5babb26cf8d5c9db'),
('*rafaniahidayath#', '0ea9279161da5daba1f10fea76fc6102'),
('M542901', '48bd617fee1dc2d5de3592b28cb510be'),
('3285125', '5d44e6b4df4c694891cb02d3c1278f47'),
('hoswary000404', 'd4da30658096f007008ddf0d47b0214b'),
('M543281', 'cfe0aef10c7ffd159933c4d5eba1f330'),
('lncr154', 'd08b571d5b4ff69c4ba84876cab8e26e'),
('amarfarqhuhar', '484c4f392fa5bfebdd0f391b805674a9'),
('lusie150853', 'd4c6ad3c1f4964de05112831c680b45a'),
('ichaacha', '8a5c271ca63b591519103cbbaeceb7b8'),
('enambeLas5deLapan9', '52004a2899151451a1e519c2cab0f94d'),
('bryan10', '70e5d9bb4072c82c8ba2ec55799c41cc'),
('liverimba', 'fc98ef675d59719775e7c88fee59d989'),
('M540476', 'e0f789a1cb0f7216405042c961b2cd25'),
('27982160', '048084cc52eb36b0f38f4a50566f0a70'),
('banjarnegara35', 'fcc0e63f6c30e11b8f57dec9132e4d49'),
('260406', '8a567704e637a3472f43ba2c723f3c4a'),
('M01035818', 'cbdd6225045038cbd9c4a175f4514360'),
('M01034756', '23c4feaec106ad71bd664b23f8c53d43'),
('m537789', 'aaa242288d0024be811e01a53fb3a355'),
('M537757', 'ca1c15d35236bec450d0545bf296c17a'),
('abiumitifathur', 'e35060827e64a9c3170d3ea31d7a36fe'),
('M541409', '2c76285de57d23fe380f9243640f6117'),
('051176', '16acdc7e5d3cef6f8e983d1694a00c7a'),
('28061985', 'd7a27a8e15fd8388d8400fb2d7917968'),
('M545581', 'e1ea3b5b28c4eacb0dee262311deb0ba'),
('m21001649', '48c4102794fd2612c98e7c856f5c7bd9'),
('M545080', 'ea9d55382dabee8176a38a0c8c409fe7'),
('112233epi22', '2674ddd173b15e6c0b4c50454c87ee5d'),
('M545793', '3340c2f50077f7f43642f457cbbb996b'),
('emerald007', '05e46b8e9a906d83bf4cd77c7ed8b974'),
('divalexander1409', '4655633d7e4269e7a0c5a3e3c0ebfe42'),
('HaloM12001181', '5d7834869f5e4093e4ebcec4af327584'),
('M545812', 'bfd1a091e405b9e4a4831a11bcc3e242'),
('acc312el', '73adfa865fb3f2e6dd86563939d20516'),
('friends', '28f20a02bf8a021fab4fcec48afb584e'),
('M12009610', 'aedff0c51f9953f80e91b56efd59b5b0'),
('08563192275', '807f4248d0ca28e90c4cf78d595c048e'),
('F042239', '2bef0a900ec9a9e316b1dd33f26e6ab1'),
('M542786', '4d5a573f907fe54de2d49b17e4c7752c'),
('M540276', 'cd8ee08a1685c2d279767f2d10e41eb2'),
('fathihbinar', 'b2676e2e7c87d0599a47065abb4994d7'),
('M526194', 'f60b26d3796568beca3f95e4f4e6b687'),
('bdg002', '93971957d48e965cf7917834b471cf51'),
('M524436', '7099c38291d0f685ea5e3b84dcaf8160'),
('328512', 'b0bd2bf54fa0e8c58f96325c54c2276b'),
('m534535', 'dfb43243e0e6804b14e5cc98ef8c4777'),
('m01010113', '3bc382f18a3fb17c6a5d5cbd32180ef1'),
('210691', '5d3f7b8b28ad7227f03495eb1e835b9a'),
('.89993', 'f5f11042b0c29b720e33856a6dd92b60'),
('12002319', 'c38d223d7146d9187a0ed759b99f0b95'),
('cilegon65', 'b7aacf94096c7f6300f0fb2e582d1833'),
('M010117048', '9c7e2dac83f06eda7b70a09f02085b8d'),
('M524577', '3b323b24a4d9966df1350d6c0539ef59'),
(' M01008403', '14132f69a151234328688a6fbfad2ba2'),
('donald', '0d343c0f0ca763f983c8042350059f56'),
('081317782143', 'da8f01a67c937c50fb364d0a302288d9'),
('december15', '46cd08aae185ab7c49ff02adbb881087'),
('M528527', '2f190377f8781b2c3c9e2b87cd76fbe5'),
('D281286', '08b4793a44bee065d035367e177f947e'),
('M530563', 'e1cb08418cfc2a4982d6f3a1d42aa0c7'),
('M0101748', '278f0826c513c51c018d58840fa990f8'),
('M1025426', 'b700a1ecc9bb3d2d6dfc0cee0a90199e'),
('m356170', '964accfc64987bf956c1895f7d730a53'),
('M010134701013470', 'a0e4c1aa29d3874bc9802bab7ea97a41'),
('decembee15', '3186ab783ee10d35c27da15392357e32'),
('fatyfajri', '82eaf823eebb80d3e51cfdb7cfe40ce1'),
(',ibtas2008', '57cae495b5d93d41127057ef9460b2ee'),
('M543457', '5760d1a5f50d38369cd0340d35df4b95'),
('bandung1961', '2de6e95e202f9ff1488f9252b612c305'),
('GustiYesus1', 'dbde6b26c6744d677d53778ee56b33b9'),
('M537539', '9eb4234e60ef042adc4017dc2d34c44a'),
('fadhilakmal', 'a141fb9fdfdae7ca8584786fe659556d'),
('harapan23', '453d3bd063d887df6306f5ce631825d1'),
('email130176', 'fe5e212b8248d78dc08ea74d7a773a1c'),
('condet20', 'd94c7cbc71c98acc520101fdeba1c6fb'),
('M530411', '96192accf80648f37d15f6616c4cbfbe'),
('M541505', '8ee4a1de02efc203fe2e7dccaa0d5610'),
('M 21000650', '5ee92cd4b50ede6ab59e8915a8f449dc'),
('M530864', 'c9f1ca29f37fb0a9ebe956e0c5575f33'),
('corporate', '061117da4e327cac66b31d2b35068c0a'),
('M.01038337', '484bef25f3b8f1c0f37ed24574ec1b52'),
('M545176', '339305d3c1fcf0fe7034112c07f23021'),
('lilistulipware123', 'b8912913a9f1f04bbe6bb32aee581a32'),
('M543328', 'f76cdde57aa9716940b98cbca37ccb75'),
('M1010358118', '879bd96b8fafcb5314eed36a99057f08'),
('8890623', '1da48c05f69978fa331b3f349efca2da'),
('gar7t1982', 'cdd64701ccea3ee0b755c502982f9fa9'),
('kiedank19121991', '25af94f478884458d56e3031a3ccb9e5'),
('050378', '2f2bacd9c52f43de695170bd09f6976a'),
('129880', '26326c27fd911fe0465d106453d1c654'),
('M11000011', '7022094063ccb43b3f5f8f5e5b9a6052'),
('200390op', 'b0ed2d312ae00802966d643f046ee4fa'),
('M536170', '473a3226b7a5c32be01f8b44433624fd'),
('M0w002412', '4518c0bde521c486c38e42ee1404c7be'),
('880923', '362adb8ece9766f3af06d66b4e051e3f'),
('M010004842', '53ba8fe5af5c55a95acc7f45618247cd'),
('m01016473', 'd38b145b3c868dd2a561458efae54afa'),
('m12010860', 'd659d78340b6a2808d7b3e0164981f96'),
('M545007', '90d8a94a93c28b70b014c7373caaf853'),
('FER1NA', '43481baabc2fbbdab45dd754ff15ace4'),
('M533119', 'f41074cc1515719c916c49a7ab42c4f8'),
('M01017964', 'd4cfaf15e88d14e3fdcc5481ef6da2f9'),
('M1013390', 'f50b05cd4f6f46693888b32efc4a579e'),
('147pdg', 'b79d4fc14b6a829983fafb4c1448494f'),
('gotulipware', '4113ddf0171c2d7e82540acd7c516ed4'),
('indramayu3012', '762d52227ded2cd13f0d691284d325c6'),
('condet', 'f15870d4f5c0d298532c640d7b28b84a'),
('alvaraby2009', '935b9441ca6db9583a8ed9a7851fb6b4'),
('141420', 'c827c6685f5134a8990d6d230bcfa1a9'),
('M544355', 'b872791ef911698d37de368bb315c8ba'),
('m545220', 'b5703be09f44b64a48ac59a43de4382d'),
('live', 'd0dbe915091d400bd8ee7f27f0791303'),
('M534715', '998674666a60cef00533996989bb4d05'),
('feli211025', '582af93cb5766f38a63eb7efd25bc7c5'),
('M01014373', '2cfb3ae0e8889c538dbc6f2ad7ca6673'),
('M01031287', '358a44094a9acaba8ceff9d3a32a219e'),
('17111982', 'ee68168ed1fd3e96fbda19f2c3bd9fee'),
('asbari153106', 'ac6fa4de089cc457c8df0f2b3554d1f9'),
('1439829', '60ce80cdf05ee5d5b0a46262f90033f6'),
('fadhilah3', '23195127d135f4c10cb476ff559d2ba4'),
('M544017', 'cef62fe21130f0f8eed61e140af5882a'),
('linalina15', '8e2ac61fbfbcd9fea81358210f126f13'),
('M54581', '6bafe50ea5b8169053fecf2ebc244080'),
('M01025426', '2698b4e7ec3d2efd68ac3193d48f26ff'),
('665543322', '3e9d656c97f6f67accd6bd51bedd77df'),
('anggoro123', 'f718fc4227383cf2328a6de5759bcec8'),
('M01006357', '58242ef5a38f049acd035c8a655581f5'),
('lailaalwin88', '712d9afaa33c7bb7321f645bea3fdefb'),
('buncit', 'd83ff6adeb2fcceb50f99cdf44b60362'),
('azkaaldari', 'fd064db4fd0ea3443c77020c0e4ebd38'),
('8869023', '9e77357acf7da5e98e4f1b375dea2861'),
('3285124', 'e46a252c487fb56d9cd93cfa25f23b2d'),
('123456789', '25f9e794323b453885f5181f1b624d0b'),
('ikhlas', 'aa0ee80222d036323033ca7e5c029b95'),
('joyceline16', '8ee6f7b5869e0660e2e0381979aa7692'),
('105103', '4632e96c98e8b9f54c55a096f37fff51'),
('M544050', '74d58f9cfc03fafbb02e5cac55dd5042'),
('13082000', 'ee462b2662b5557507704999c57d69c9'),
('231105', 'bde798e328b8becda52aa46ed8b98d5a'),
('M010024q2', '761453fa134c46d896045ddcef8aa954'),
('M525779', 'a9323160f6b1e44c438c2f49bf0d8173'),
('m3544455', '918fdc68ec3740a002aba44b770bc362'),
(' M784578', 'aa803fab99f711685a4736eb7e87346b'),
('abiumi', '64832dd83e3bdc855cdea77e66282e6e'),
('kdr002', 'cacd93d2f6edf68128e290bfe318fb70'),
('gotulifware', '88eab23b114d340316f252239a54ddba'),
('12062004', '1ba9b56de77e1311bccb77072faa055c'),
('m01032629', '1f710b3793d8964b2d7fa1d64b8cd743'),
('M544780', '13d40ba353997f9cd8c0b2f239012a69'),
('Ageluba99', '5dfa7347f63d4135b91d2c35a0e04cb9'),
('085383828029', '0163aa090907f365b42f0d466d5a6827'),
('aldroan', 'b604d94bd44015686e1efed7090bcf0b'),
('030405', 'bf49202ef1470b244bc096ce89055201'),
('M539234', 'c2aaa4956783532eb14117a142110467'),
('M01017118', '3cdb4383e53905b014d63df9b6c1b7c7'),
('loverimva', 'a2804d4c7462e86da838cc6641bcc15b'),
('katasandiI2', 'e7aa13cbaeb1dc66d8518fa960ce4f7c'),
('M303013', '9eb925ff1841e1cc337b84e9dbc1c211'),
('M540960', 'f2b43afb1c084bf7f7c21b18ec9ac80b'),
('M544837', 'b83d4ee7c19e85147dd11a155321e297'),
('m01041482', 'd78b518731543725117aade0d2933c3d'),
('280112', 'e7a909c22b43cce085fe15901d526de9'),
('m017', 'f996d096040dba18091db1a555a94e59'),
('herlin', 'd34fb357dde0fe2a7aa0687c9a855fd2'),
('M01027248', '816ba5d87cd13c1cf63412b4b80d7a40'),
('M54480900', 'd12f56c86c0bb1068b2494b4f4e50cdc'),
('aldrian1', 'cda6abef73addfa8deacd27b1f77db46'),
('asbari153131', 'b364bf1077636c47e31ae3405ed36ae3'),
('m01017885', 'f3e7015cc3982d9cb24276484156102e'),
('iraanshor', '6a0ca278d61d651f2f5ebc5418093ef4'),
('M544834', '5056d2a2edd6292f344f2e5492273b05'),
('M526381', '25f14f0a3ea36e89dc1b829a60508a33'),
('m53650', '14ea4ca14c08e97e4ad1213b9169d8de'),
('banyuwangi152', '4787cbbc974835795edbec3afd4f38e1'),
('garut20', '41d5512bba49f79da0bcdea642ec0c50'),
('061852362', '0f7a1d5a8a9d39182950b06efac5d4bc'),
('121149', 'a703d2f05b20bf9bb7e35a9f44d7ccce'),
('keluarganabi', '04b845f3744944bc01baa0bae5bf610a'),
('JJH233011', '9a6aa35eb39e2939fc002f8d53d59f00'),
('M01004672', '84e0b8c5667c4867fef82aa8c74b91c6'),
('m12001356', '3381f9b4e925645fac182167fa2f3cfc'),
('M544802', '9c587a5cc6ff3c92c3609f26f1e93d86'),
('aina031271', '25118a934651e7465eb745c2727d271d'),
('hidupon', 'ba1e7c7e3f7a0191780be5d1457e0949'),
('M12009924', '9fc5fa992a150f97bcb909dcfee35315'),
('lilis tulipware', '7592978eaf1c310b09b7f2daf2ababa5'),
('015013', '4e3c047e4fc092d027f1b2cf4ed346b0'),
('Bombay', 'd26231b6974940cda2c97f51f4755729'),
('M535260', '8714d1460e55ee2c48a2a3888291aad2'),
('m530120', 'ca7d82a48154938db969238334d267e6'),
('M545284', '6656256d5c08f04aaae4a16fdf5dab40'),
('M545119', '3a70e5c812de6e8f7dcc3c4afc4eb1bf'),
('M539396', '2b8bb3cabcedf45051f59d05624f44e3'),
('M1017048', '69321316edd5926ee92812278c85214c'),
('M543244', '902d199f8624ccb514c831e5e229f4ec'),
('fahmi', 'f11d50d63d3891a44c332e46d6d7d561'),
('761207', '5c8dda43648717759460a8a89a218850'),
('4lyc4hn', '2ddaac9e88e110e48e47bbf3ba35594c'),
('lely05', '0b6b9428af50053f6730a12099a277f5'),
('M010254426', 'ccb3a14156dc13acfdfe7bf5701d0831'),
('M01040969', '0c3a5647eaaf5e244da3f0d009e7351c'),
('bahtera7070', '110e58992bec7b8ea62bfb8c68cab700'),
('211025', 'cd558c9e27af4aad42559c547963d2f0'),
('140219', '33d7d0769bfdc19059c4068d98508ec5'),
('16121974', '8799e1ff694c0000f6ec24787d14603d'),
('M545684', 'b59ff8fe63c3fe94958580da6c5a491f'),
('M01004842', 'bca1f0ed8a0806a72fdee22cd4270e75'),
('M01021432', 'cfe31e23a261db8a7e960592135b1e5a'),
('m531233', 'c40fe3b871fb47dd484174de5c8e6f2c'),
('M542836', '22cf94cdf60f1ae1e36ddb271ce64127'),
('M130998', '62829d1a1dc9575d7444af7fda06e7f2'),
('M0107048', 'efaf6e1ebc7091b8161dac1eb8f3f962'),
('M01018440', '74a5778b4a8b45dca193dc2975195b2e'),
('garut2011', '2463183b4d1f1861645f465f43b48978'),
('M531587', '8454d1e7a1a5c6044e6e333be8774273'),
('bintulu104', 'a1422bcce23646739390b5d945d28dfb'),
('2015desemberlaunching', '6e4c25128c945028bde7560e0f42c146'),
('12345', '827ccb0eea8a706c4c34a16891f84e7b'),
('M535293', '1efac2b09ba0493e2a7e57173469030e'),
(' M534535', '645e3fe476e33baaa91427a94f09aa9a'),
('M540568  ', '0a6395975e4f463df3816a95a92980fc'),
('bismillah01', 'f1ba52c4f12c7d32885cbb965bfe0027'),
('m54433', 'a4733d6e6d8ac82f49bc9e2044f9a718'),
('farizaurrahima', '422cdf9fb31cf2f7ae12c6bd94d52ceb'),
('M538442', '552d7fe82237e305eea601a6198bbccb'),
('M532095', 'a3cfd01f672efd973875675b8722f9b3'),
('bsd12', '65b442ae2b77f9732bf4ee4ee8ca4e96'),
('M539598', 'ea6d71f875d57f9538d9b7aed2c53cf3'),
('jack ''mobcky', '711adbd8c96e703b07e03c6307782785'),
('M12000181', '0ff744f982844ab3b23abe6ce76922b1'),
('lovw rimba', 'eb8f683492beb0bd20bab10031e8d370'),
('m3r4pi', '88bf5e9f656fd01fff2700d919d926a2'),
('M12991181', '4fb2556243f2059a614af5de505e48fd'),
('M538532', 'c1b6d3af071f54f85b96bcdb51ce3a0c'),
('2327april', 'dea539f26b99718b2c2f29120a904e31'),
('M533057', 'a4d9c124d588b673d7c83acce7595324'),
('M0108200', 'debc8e0e73700f55a411486dc6582c75'),
('M306046', 'd945a6e9b8348e600257352279f10469'),
('339966', 'db680031b7e28dbf2f85eab19fe68854'),
('enuryati', 'f6720a73076013a0026fe3854f16a891'),
('M01037673', '326c8c9743d6c838ef1db696d66e894e'),
('elly12345', 'dbb0781e4ad3d9aeb36043e0824a108d'),
('11223344EPI', '23a41a9e55ff6ee1bcb14154c374d10e'),
('arinikanisa', '61c8df31698d8ba835a211c3667b82f8'),
('dewitulip', 'cff83eefbd4b3729cdfc3bcb5aadd626'),
('M545006', 'fc1511639e7be31cca0c42cd38bc1e0f'),
('M01024644', '3d51d0414558515f1facb8d53442a78e'),
('2061985', 'd2407899ad632a2b9e54ea30cdc1394f'),
('leha12345', '7ac7ce0fa7a4ee038b3692fdec73320f'),
('M532704', '3511c1442f160e61b5db934becc1231d'),
('ER194175', 'c254a4d2d7f67b896e9b8050dc4a19f8'),
('01041384', 'ba42c5bc6095b1f60904946b082289b8'),
('m523967', 'ef0d38fd61243d4650ce409182e36866'),
('kaka080213', 'f5ea6dea72aba023d527f04ad04d4184'),
('m545551', '8e46114bb93e18ada1599661b7b6bf1c'),
('M545339', 'ab5b62f54d742cc270aed5c440980637'),
('191284', 'aa6eef4ecaded2abf890f09906d65c2a'),
('181011', '298209216669d2feb0833cb5d2b6d1ce'),
('ga4ut070482', '6f73113df0d2dd105a77c3e225b5f8a2'),
('6655443323', 'b16028f48ba6755d2fcf0bd9b6e90e40'),
('232704', '47547c5f4947080c82f88e98a81a983b'),
('M525759', '21839c3d0fe7bf9b94f54e75a2e62a13'),
('m544601', '75dde8349daa4c70cc06d8899072adfd'),
('M537474', '350fd1e69d0ef76aea35abf35418228a'),
('happy**', 'cc87709beff2aefd9547d658e5ecd89b'),
('M528324', 'e3c0abb971b96f5aa0945e61ae3a73c2'),
('1298800', 'b948195367648ecf9d8d5b8a827ec031'),
('m01005246', '4db9dfb1903a9762da6f474f252d6284'),
('M541595', '1aabd921a326833b79c3bf527847f083'),
('M543282', '0b3687bf8f4636f289460385db8439dc'),
('bandung01', '1369aec3f5d0a2e4a3500f2b25da21b0'),
('akubisa', '91bbc47bcb557253ef739a6e771d2d68'),
('abiumi021106', '67dd0d761af2f5f6856203d6485f70c4'),
('m010107048', 'd52b3ca4a84e759743d91dd3ecaa3886'),
('M010418(1', 'c3724935ca18a2737fe4a905ebded7be'),
('M110011', '1887ab643a7bbe2ba95088329461dfb7'),
('Abid2ridlo9', 'ebac8294475356181f93b81bcb9b23b0'),
('123455', '00c66aaf5f2c3f49946f15c1ad2ea0d3'),
('M530526', '75aec091a9ce4475a250e02098290cd4'),
('131429111981', '052f7d767bd6518d06fb7a2805685e63'),
('M538384', '2688d17313f95114e847caac033c9488'),
('m523979', 'b9d8e87fb17a7740cc569e87cfb35e41'),
('karina22', 'a9e6e27f2fe0b68921a2b03da562a2ce'),
('M536204', '8e4d942c831906d53c579c3547479572'),
('M254475', 'ab31edbc0d1be6ce23cb14d246e8faf0'),
(' M542780', 'b4af9315edc63014242e54d4c4000b63'),
('bismillaah01', 'a404f1916e623743657df0a5b94f7772'),
('M01004704', '0eb5d2045bd87ea22bed181f2dc8260b'),
('M2100650', 'e2a4d746f759fb7424c27146b41d1e55'),
('171182', '5b734aa159271ea8b7d19a11077b67c8'),
('M536815', '5b8e045eaa9c327a0cef9db747efbd87'),
('lilis', 'b4c7848b06d83bbca966b1fd05cfabf8'),
('18apri', 'cdfa1ff3cd041786804c80a47a6f41b6'),
('M0108', '37496018ac957a02e01eb1e82a0e070f'),
('M542590', '5261c4934643205bb585dd427588d7d0'),
('M01004556', 'dc4c36960b3d1c9516a3986eafd4a37e'),
('112233epi', '49035a62c8324a183cabcd93ac909bd2'),
('01101111', '9d3df1dcf24587d43a0482ebd7a6757f'),
('M537932', 'e5aed0cd25c8b99481817b2c75f2cc38'),
('F043922', '3830c78ed0852a8637af5965c15be8a3'),
('bengkulu15', 'af4baec9d39e39d7c1d82884df6b78f0'),
('M271009', '24600938c23fdc23f2957c47354cc264'),
('M12001181Halo', '2e0dfbcc936f83d8070cb10d0e791aa7'),
('04038', '4a5e65dea375520cfe8f4382f0d90fc4'),
('bintangbismabalqis', '2926c725531ececf20bf0fb330fe9a44'),
('M01017395', '7eb0bb5931b394f98b08fcb48638845f'),
('M01042497', '62173e1f7e701bbf689e0453df88de4b'),
('111187', '56c39d5ab4d6ceb6c28c6a9571d9f23b'),
('aowpramnisa', '1217063bfde464c805bc0ec7cf68be10'),
('lamongan123', '7ad25e0e7afb1a862e7dda42fbdd3fcb'),
('051700', 'c777c2a999caae3b714bc1a651365fc7'),
('m544334', '6d676a8e6128a4c481597a06699c8abf'),
('M01022556', 'b5aebd970b641c7e51a8dd54c0a188d0'),
('jacknocky', 'd7147c6fccde78a44a0158597032aaf0'),
('M544430', 'a1210bc3d46cf5a14421607898b61b30'),
('888888', '21218cca77804d2ba1922c33e0151105'),
('kampungnusa', '3745d2214d9194a90db298df4b36157b'),
('M01003735', '317634d4d363f85a05fb52100a5b65c3'),
('M532198', 'edbfb05581245b82c33b4f3d91edee2b'),
('@murdiana@', '3293cff75899990108ba8a36e565f376'),
('dicky', 'ee0b6db238b075d0da86340048fb147a'),
('Andre_cmhi **avada 49.213.24.15', 'ac2992f37af2b0d621687565d2fdf800'),
('f8b0400', 'ccbee49477f4042cafed5784fdceb4e1'),
('lestari110508', '083a38b2720fa5a3354967f54d511f62'),
('M504541', '5583e65411ae251a4fd0b7c95e6021b3'),
('indrasj221095\\', '968fbcc3d839328f32d07bf94a8501dc'),
('M534613', '988171d98f3bc44cce5e654139c22dbd'),
('dagfamar1hot', '6cde112b9120eafb34529bbe7052a0ca'),
('bangka22', 'ed2c0df6d5c1d1d05703b5e3083c6841'),
('beyan10', '204b2fc6c036e34596fbb92fbc08dbb4'),
('bukittinggi161', 'bbb1390dbf27445a6d3fc78bb2a2ffc0'),
('ay12p674', 'e643ad36f44f8e8914edc852d2bcae5a'),
('M532329', '319c071d3e5e16bd6710794be88ecff6'),
('M12000045', '517fe0a1b25f33a408c0f710a803f09b'),
('M010247252', '5fb95cc042d18f7f7e05491f7808e28e'),
('544837', '81632fd3858345a907b711053fc4dbda'),
('daffamat1hot', 'f75465af6de425a59718e7ae18fe37da'),
('12345qwerty', 'b717415eb5e699e4989ef3e2c4e9cbf7'),
('anaantik', 'e9171ec81ff7a94302593391739e77a1'),
('911911', 'd68e84140e6956552ce2dd8edc2dd627'),
('m01025274', 'f1fc91a7d54837daaa9309ca6b686720'),
('asdasd', 'a8f5f167f44f4964e6c998dee827110c'),
('m01035191', '5a6406a0e6d3e0fd1cf515cfb7e664f6'),
('M0100474', 'fc359cad589d0efdc9b70347e3bd87c2'),
('M435577', '3fc87439dc0d830c1bee9038e70459d3'),
('040512', '633187149fd50ffbd2583cfa31438b0b'),
('M544205', '587d59a754ba302d617bcde2e56f326a'),
('F042273', '6db5a8abe8a6485a29ee2ef2b39cddee'),
('M543919', '681184c7868131f5d67ec6504cb1ee1c'),
('Halo12001181', '703f0f661b15b9f2ded43a255d514c5b'),
('M545478', 'bc472d0c7f2df2992df1900a3dc089ed'),
('inimiracle', 'bd49507b80b8d24a219262f8e599784f'),
('M542788', '3db6519ee4eeaefb3b94a5e3bbca0efc'),
('m015246', 'b269a34337909f94c8896d6d64fc6c6e'),
('indah123', 'fcc460c203d840d04d91f9bb55b7520f'),
('M536763', '298a4dee21fa655ca8a7f4750b9b31ee'),
('M533389', '07b0a6ac388d9d11f413449912b5d9de'),
('happyy', '0207b0e527fa1e2fde5dc7bd51c971ec'),
('M539411', 'e473ab6120f340dd52fd1782485122c1'),
('M545196', '45eb9eff604bca7d5a6b36fce7d965b5'),
('281286', '9c98caaefffe43909582de5cc7ad8cff'),
('arcisha321', '1cb29ade91ca254b19fa2d98b59ff2c1'),
('M010049559', '1d4e25e94de123c9ec57385229714a21'),
('karina...', '67b4de038bfb866533a23f7053a83f6b'),
('M543093', 'f5f9d295f73ffffae7ec37aa6080e902'),
('M1002412', '669dd1fed29061fee44b5d6e8243bcb5'),
('541839', '6b853c1c900c2d179f64387452bac2a4'),
('0c05080juliani', 'e4f3a7c6bc3b7465b81b7ec708076de7'),
('081382075277', '35435f64a75407df6d6ab05f5ab207a5'),
('23061978', '4720db4e79a4d758519cb16848718ddb'),
('adsada', '611fc48cf4e68a30efb69e669869b08b'),
('m01002412', '6f7a93c61c642275732e200ca1374b31'),
('836433', '23fea24bcf121d3bb97b9b73c9f19512'),
('22091992epi', 'e0727565c96b4ff2e7fc7c9de835b0ed'),
('M542780', '4e723de948270c743e9fbf0ada0ff1c1'),
('M539444', '100838ceb4eef97d63f4f924cc574581'),
('88888888', '8ddcff3a80f4189ca1c9d4d902c3c909'),
('Krismayanti14', '88050359bdb1dda10c033d6b154883f6'),
('M1207942', 'eeb8db78d1f47ba10ed2ba220396a74e'),
('M541839', 'b8856688758dd8d5980ef13aeac99d54'),
('M543257', 'ee85968d3ff419f7c0f4fcc7bd381d8a'),
('M12005188', '3fbac6620c5c626c19ea92ffbae1146d'),
('ani6791', 'f4969febdd9648add911c8ca8c1fdc78'),
('M545033', 'd87dcb4a4515475b8afc9ba8d7a1f241'),
('chacha', '86b86014d1f8ca4f6054db174be70841'),
('M5243', '8b639d759c8ecb0086287cf4a8059c7c'),
('cirebon3012', '00c866ac78d1d45e3705aeb8df32cff8'),
('haidargundul', 'fa89487778e1a23d76c08f9f67e91cc9'),
('M534908', '1368a2629db16a6687c2c818cb3377ea'),
('M01036895', 'ff1fa533e2fb78fba77af189f1ab5230'),
('M01020050', '28c1246b9edc1aae76fa2d9d4f8f0c7a'),
('M0102242', 'a69eba6d9a6d7203d851b46a730a9646'),
('bandung1', '27de26b33c0e90b330a77256cb28f99c'),
('M538614', 'c4defd5e74134352b6668cd2d31bc6a8'),
('kiki2014', 'aeacd14b2181160f0bf8f60e320d0d01'),
('m543395', '77e77629258d4f26c24014dd67f6a47a'),
('bahtera707070', '089bbab71b466074b7e3a0c8cc64112e'),
('fcwulan3w', 'eae543a7f99d8caee7c6f9598133d0dd'),
('M0103085', '95a2e30460f42ebfd22a298478164582'),
('24041969', 'a0f0df9eab05096ac918299b42fba69d'),
('18101986', '8a09f5d98c3e12389ecd1ad65da8fb33'),
('M21001750', '34b23b24a150addc08d9e47d5d21b220'),
('4desember1981', 'b3aab6af460dc8fcc440229703136d0a'),
('kendedes', 'fc4e5c9fbc4842705c9f40d143c34c81'),
('akaufamily29', '605e57818c34744b1e8a0ef3ac90b5dc'),
('athaya2011islamay', 'fa924357af3d02be3e3949b0cf855045'),
('M543949', '8331d5980e5ccf1b29f785435e2c3531'),
('M281286', '7c6fce460bdbbe91ca8955dba4a12d7f'),
('m01024422', '73f667c46155eba3e80582f9f0c54326'),
('M544915', '8e7bc7d12ced9cb9c6c761c392290fa5'),
('M538051', '7ec87f1615d2c5b37c22fb4b334c6d6d'),
('janganlupa136', 'abfe398e42d150299dde9c4936985a89'),
('lilistulipware', '499abdf6a576986d928c4f2cffe5ad92'),
('500.349', '6518d7bce7ce0b87055efbbf60d829d0'),
('km040507', 'bfff501fcdec80d71f039e9d84c529d2'),
('m.606046', '580058fb8b37791dc4c083f1be8b00f3'),
('M0038337', '050ec764ff5a38154ed152fd5218b18e'),
('hizaki', '3354d0f8db52b6cd0e104d7309120163'),
('harapanindah23', 'f93781c6d5aace64c3a5a9949103c9dd'),
('d3w1tul1p', 'fb266454c3bf5f41e6d35d49a968b74e'),
('ariniknisa', '531b931a55f798bfd9c538e2ff615f4a'),
('M01005501', '73cb37f5a564bd76634204f374edd521'),
('blugrin1010', '0f5f558e2a301a998f8548a263ddc820'),
('aularto', '7f0bab9e39a45dced55f1b0b98d9646e'),
('060410', 'f59ef58280d6c482a13dd2d49e949422'),
('M536867', 'c00f6fdc72e8563a09dccd597df3ce81'),
('hizzan', '7ca8208f05d7e6b2eb8c43243984a11f'),
('M545125', '0302ff500cc2100dbca3f454d82fbaf4'),
('M536429', '0506f2e97e3e89b1003eee729471a4b5'),
('depok118', 'c25d9f85ad518d32ca1f5ab72db0b495'),
('fadholah3', 'dea7675af991522c8b42a835a44e2f60'),
('M543626', '841e73c53f332c1945fb1e939fbc81d4'),
('M01041834', 'c33dec95ecee92711e38f3fa55a549dd'),
('M110775', '75f7368ed0a12d43a27fa98ddac550ab'),
('328124', '495ffc2e1fd3b0030a3b724bcbaef831'),
('M210649', '025bf68249e31d4c2c68dfdd81fa31ad'),
('M544337', '2d222dc5324af9f542a77431dfc8e438'),
('khanzabillah', '44c344576f7681eaafaceeb6cb2f6bf8'),
('000000000', '4c93008615c2d041e33ebac605d14b5b'),
('aldrian', '1ac34504e4f4e627174d284ac4318386'),
('dafdbar1hot', '2772ffd60f6f4c714a4c2e08dbf1fa82'),
('batam29', 'ca2014525f29874d0b5e01cb8b494135'),
('M541834', 'e5d7d623b5e0d25e04b308d21a2b4082'),
('M01008860', 'dcc1b08605b811427c89f22728ca86e1'),
('amor', '5da2297bad6924526e48e00dbfc3c27a'),
('bpujiantoro78', '2c4a072a95a1ae59d5d21d029560e782'),
('faizah', '7aedeb3c0483c19498be5786acfb79df'),
('011003', 'd00e5ad1b1fd671420be5d7f07498f13'),
('m010052246', 'b1332f0d355eaa3c757419886f89bb7e'),
('M01005256', 'a44cc189ebae6415b50bb3cce190643d'),
('ay120674', 'e178163ffd801e581888c91e9044cb6a'),
('241981', '7743ba5ab1419080e53b9dcaffc93c81'),
('16027882', '2eaa610f55a0473313adb1e614971063'),
('ay12061974', '7f9f289b71454828e0cc69d1bcf7a384'),
('banjar156', '895d61eb88774df2cf817a54193ebaef'),
('DEWI190689', '7950ea5d75d53b32799354bd3e2b237f'),
('M540415', 'df5efe26d7a678278a98daff92fbfec0'),
('M530025', 'e6ddca3bac8ebaf563c7148747cd3c3d'),
('M12001401', 'fc11fd706105de833b3286f0a452079a'),
('anacantik', '69dae3c58b594fdded1f5375bc0c9a2a'),
('M01024719', '2d9d13d891e5fea52ec9b917bc0ac0cb'),
('23575', '5735438d64589c7672b1b246cc3b2b24'),
('M541475', 'ae5645f386d05ae4384c7088e166deda'),
('M0004556', 'ef5e13232ecf75c22ad4e65c60131dc9'),
('alfajr', '6127c5d361c47be8192f1e5c186060bd'),
('399500', '27db208b7a395b1ec545750f6a31f2fe'),
('Kpo0034', '0dcf960ab80f078683c0dfbb8a784cd3'),
('123456', 'e10adc3949ba59abbe56e057f20f883e'),
('M01041831', '99d3220c3a32ca3386c4275c820c0670'),
('bini_irfanlho', 'd4f70c31fa28c586cd48bd8aa41adb05'),
('J040106', 'd4451b11276366bc215a17f70db76a99'),
('M540790', '64ce1d5294987ca805f3db24784db19d'),
('citra38', '64fe3e71b78dedfdfb84dfd1b24ef6cb'),
('M01013085', '6faeb13f8dcbf9ae4cdc26d32a3d73c1'),
('M533117', '4f8ee1483fd7476379947ff044cd1506'),
('F180422', 'ad3005d5b63533d11f2d0fada1be23c1'),
('M533518', 'f0ace685a07f71244406c9a4779228db'),
('70bahtera70', 'ee2e562e3a684f7712cf6f3c08980300'),
('m', '6f8f57715090da2632453988d9a1501b'),
('M21002380', 'c81ccd2447700739860bbaa5dcff4ea0'),
('M544383', '5216da2e347a25cbef9fdfa268310b2e'),
('28121986', '8f03a56b6e760ef87ef03bb5b90276ec'),
('M01024725', 'e2e119190933f97af5550900371dd73b'),
('hika1507', '0dfbdfcd75a42f1ede2c336fbea7c4d2'),
('M01038928', '68334aa59f9ab51e7271b970e2ecf903'),
('M01035466', '11249732e281f441a450bef863fd0078'),
('amandaandini', 'c8ec48c7b076c783fb2302e610ab310e'),
('M544887', '8c17d382c22ca4a2bdf66fb5f19a5d25'),
('antonganteng', '544ebe1bc23324fd85db1c792c6d7a12'),
('ad', '523af537946b79c4f8369ed39ba78605'),
('01017118', '6bfeedd2e6bc1d1fe5c9f913a95fb5f8'),
('M528756', 'f7f47982466387b04e07937443b8ceec'),
('M535808', 'f2c447e0e21e06270013b8f9614bb9c0'),
('danielanggara', 'fee2b7d4b720b7fd00041c0cf2f57182'),
('M532520', 'e48d1bbfaa14041d4f2ed415302fffc1'),
('4054pagenotfound', '89cfb9f647c48ca68463a26c918147d0'),
('ayahsayang', '7af79281cb640f6ac846e9db3da1f244'),
('*rafaniahidayath', '2d254929a6875c4b95c7333366100da6'),
('*arifhidayatth#', '85cba3aea72f215b3c2879b41deb38f3'),
('085645417882', '33a5025031c251f7372ec67c6bdedb32'),
('220683', '09630a7ea55cbe136f8d0031c02d9ffb'),
('M21000650', '934fc4ef10f704f091a92c0ae55d8c21'),
('4dessmber1981', '1a5ad057856ecb6068b9b7010b59f6c7'),
('m01017048', '34bbfb13af404cc97db0b35297e54271'),
('736011', '83fd368785f3a7e4d7e46f5eb115855a'),
('m2710', '72aebedb78b69fe562124f1b370ba029'),
('10071978', '792acfc51b49317aab936d0933a2dbba'),
('021287', '2762e3df2b0a739e2db9d069423d657e'),
('12001649', '0e0e4e45bcf83c7465435bc114f0e361'),
('hind1906', '7f4fdfe4b6c9bd81cac68f37217c57f6'),
('3286224', '5b1af0409f90a58874564a6005bc75d1'),
('hafihisan', '8ce86281d58552172aefa025dbdd4ebd'),
('M544435', '8310ceaeb0e1752f7f28ebf91f6b655c'),
('kelakan', '8ec2243d912c4f273b3da2955900a009'),
('bryan01', 'f35f84206d3e25ccfd5a7934e6c6828a'),
('27882170', '826d547b16df05bf773f974c3f413abe'),
('M01005069', '55b3ff1670b7bba40820e38baa769c92'),
('9juli2011', '199028ac0b9f11b5f44f728e52edac27'),
('M12003919', '0bc795d530eff70f4f9075f168da4a98'),
('M01030538', '032f56dc122ae92c91b17a72c568b45b'),
('281091', 'd0855e33c866035123e527c77b294fc3'),
('M532088', '6e67428966d94566ce3192cc791ddc65'),
('cintaallah', 'c308a3b9309db87f3e259c3e1a18d199'),
('M542864', '6e5b42cae0c443411156a9884b29c723'),
('kodok@sawah', 'ec39d310bda902aba2492c75f130c967'),
('M01038902', 'a4ef8d845aebc85bffc83347d655fe5e'),
('0905809', '97d957239c93c8ee0923a22df02e6b88'),
('M533287', '0429e2c7669899ba6d4b9ca713b1d294'),
('M12007650', 'b03c5e3e30cf1ac2479fdf6a3c2f6b98'),
('lusie0509', '33d577439eef177b0219c3e941bb408f'),
('M12009258', 'd50186901145435961a3d0da86be3997'),
('jawatimur254', 'f1034094f4f8b4980db82bd2d9568fa8'),
('Kanadya2010', '822b06a6e9520704bd393cb39f9f571e'),
('M541996', 'e5dbe1f1fc99f3e3665d0dcb527d5206'),
('M540825', 'df0d827ab4498138482d506c82e1edbe'),
('M534888', '80cf24423615276685587a8c6f1f3b95'),
('M545734', '16bf6781b6226d4e28afdc1861d3d411'),
('181007', 'e7b54d3c55a4f56066feee32ddc96d0d'),
('fagmi', '432bfeffcbec9455640be7ee1a4bcb14'),
('aisyah21', '286a72caf7dbb3a4c3e964463002534c'),
('cimahi25', '27db3db06c6a2162696147b010b142b5'),
('0004038', 'fe7b05c66f4fbbf4d319b7e049dfce95'),
('hasil123', '1449baff33a16953bb9119b1d9201a42'),
('kelapagading3', 'a3e9a1c8df4d09536cc8bdc5d999ac15'),
('lusie1508', '63e39fe6bde1e5d055d20d97c6b7aea3'),
('M12010715', '436815afb08fbc5d2ba45a4d3c475918'),
('090580', 'f6d4649214540112cb19a3450b2accc9'),
('fansaforever', '1256c9f0da223a538538ffc95356594e'),
('M537767', '259f7b14efbff3c87c7e56c6ed1829b8'),
('ganteng', '8b6bc5d8046c8466359d3ac43ce362ab'),
('M52447d', '3572424e48a88074bc762767d16ff84e'),
('asamanru', 'c4056488baddbdeec039f83c1174f895'),
('m12004248', '660a1afd04db28d1098a2a1d405db55e'),
('decemver15', '75d4a06403d5b7de5646760334e7c97c'),
('070482garut', 'b2545eb67f815a208c469bffdbbf44e2'),
('M01028442', '4a6084d80b0b94b07112aeac296b7731'),
('mustika', 'f872533a62f1a23afa0291337401561f'),
('M809622', '620f148514417ac444e6dbd5bffbf525'),
('perbanas', 'ee93d22fd45db591418acb626038a0ce'),
('srimulyani', 'd9dbc374f98464291854564d286868a5'),
('nayla', '5ca3049442f0c6e643ad75f68ac9a6bf'),
('omahmanten', '9251fcd4dd3af2d75a3c20d326c3554a'),
('M800016', '45e09412ec8e6495637c96ff34f71302'),
('M7791769', '2bbcbece5a70cc69a8bbe7f50647f04e'),
('M807013', '125f3572cb9a77558f041533a2ae823e'),
('m762034', 'c5fd8998e4edf9a4695a4f494edab58c'),
('M804101', 'a11a454fbc6cf0907d854ad6678de34f'),
('zahra_99', 'c888bda4ced0b9b0e1948b4e735dbdb4'),
('pelamgi123456', 'ddb36de74a9cb332d98ae51fcad255c9'),
('M811104', '10ecc094788c111247cc3b171478a442'),
('M606046', '2399658c69a0a163440e813dd91e7456'),
('M766094', '14577a693c0f37332fa2bb1ccaf059aa'),
('M809810', 'b6dcd88d04748e967af0d03fcb33a124'),
('pelangihati', '5e89a3cfeed082e1de47fa4902caadc2'),
('M768061', '83409170ae9747c5810c289a24b3132d'),
('rohayati', 'a6b0e5b7bd0ecbbc05ed4807fcdcc219'),
('qwerty123', '3fc0a7acf087f549ac2b266baf94b8b1'),
('M796309', '2b254fa96977528fa70c0aadce91141e'),
('salmajadin', '9dab52d8c11a97f2b28f504c65c29dd2'),
('m783792', '62d5470b5d16fcf46625a9e9a33d99f5'),
('M760571', 'c305a51ad8010e41b46201ac0df6e842'),
('M782825', '016943d2d08084aacaf7bb3e7032f93f'),
('rarinsyl9', '0f81bc4f42771107d5295dcb25a58ed5'),
('siti1234', '4e8daf0bc5014c2286af8d30fb26bc04'),
('rafasyah', 'dcd994a838c598359ee0450fe2de6339'),
('N2403311', '979413de0cc13f7cdddf487befaf9dda'),
('yati1982', 'd4ddfb8df2457954b868865117ba6488'),
('pelangi123456', '99035d7f6c298b1be942a3071d3aaca1');
INSERT INTO `_md5hash` (`text`, `md5`) VALUES
('M823487', 'a46814b68884ae90fb93fcca2d8fce5a'),
('pipit@dadang', '124b9fb96a0b78097f3ebe09a69960a3'),
('romance', 'b9e37b7b239ee4aefc75352fe3fa6dc6'),
('m796310', 'd36fa9ce629f9259baf40572d246fe63'),
('m814868', '0db9114f254a37aabbcd76265c152a5b'),
('m817436', 'b698a78a141a6dadd9598d7af61c3eac'),
('newyogya2', '66782a1496b2d39e105280d2a195a8ee'),
('Sakhiong1973', '1ac4faaec92b75f50457bc4c3c1391cc'),
('M771769', '05c96fbc9947f90071cc14df055df262'),
('sumedang4510', '1cd645624aa7185a1af0a06a95ed59b7'),
('ms101010', '5286b08c69d786807acb77eda1a89a10'),
('M614331', '60290a97b263bc7d3a9858647a1dca54'),
('uber53', '45e1a35e0ee41c3bb853ff8ce8e41441'),
('M767991', 'd51c3491cc3a52ee921cb0a47d8386fe'),
('M780155', '8d8938f461de291a7c44d42e4d1e4333'),
('M819455', 'e4bad0db54c0416b8ed91db68023f4f9'),
('M822551', 'af12f3c1620348f1ec5d0e421f3ea152'),
('passwordhamrilhappy', 'b07935f37012ff5d18fa8e82fb26cc26'),
('m601154', 'e600da7598714159d57747df75073543'),
('M821489', '83d762ae9433d479cddb0ee27687706c'),
('ninet68', '2247f7e59649b93d9ec6dad5b316473b'),
('M764798', 'f23948388c3627d70a8d0712a2650384'),
('M798188', 'e2916692001152c82c4645503201ad76'),
('v''$', '5586070b33a2d69a57b7813492418165'),
('M753359', '2d2a8f1002fc12c7845d16995bc429b2'),
('M761876', 'a63e37d5c241064810b2d47c7c75d5e2'),
('tifathurabiumi', '776138f72170b14d26cee5414dbd103e'),
('M615738', 'db75bdadb69a241743def433d1b66020'),
('M554022', 'aeb990768b8a0ca356af2fd2b1a89fec'),
('salyaanaku', 'd0cd940198db52841867c175aebcb7aa'),
('sahabat', '9112112fe05b8fb04ac1c1e817a185c3'),
('M818811', '253114cd2b304601dc4db6c7a7233578'),
('udasayang', 'cafc75d5a5cedfaeaefffb9480732085'),
('m818863', '50e87ab8f953a281274ef08f85929be7'),
('sudiyanto', 'e48dad9199bc4d7771ceb926dd9c2b53'),
('m780758', '1e76d5381c57194ea302706bd0b3dcee'),
('nandasf', 'fc26421159f04510862a74a1cb8041eb'),
('M764234', '39ae35db0e89c05570e22ab713ef4f98'),
('M²71009', '0b85c1e5982a98a2252a3f716c012a13'),
('sularto', 'd9343dae199ccfb0404fbf1d0c4dab23'),
('M794244', '3e6cacfd752e8c93d7e16156583fb202'),
('nuda9hijau', '398814fd3181850c3fd853c9611244fe'),
('M794430', 'd51ccfc1afef55c77cc03ecce61edd3e'),
('pbana22', '958470ab3e2690008f4c2f795de20cef'),
('M757531', '49e270ae08a83d1f5039407074ec08f7'),
('M798696', '60d693e3f87f3124489592054ac2dc3d'),
('M798678', '1d64747a7d1ab8415294ef4319203477'),
('M822356', 'a9fbfe31d4256e0e2f132bfcc4fec758'),
('R5OYAN', 'ba7f291661ecae8e5d1d50dba5232885'),
('m601391', '6bfcbd0d2c255dea5905065c07874c4f'),
('wongrembangtuli', '0ebbfff3ce605ef510a466207403872d'),
('pondokkopi32', '3ea68d73ec390a09c0272c114bfe9fef'),
('M767327', '0bce1b919d397b3a5c6e1684f83ff001'),
('M796579', '29e9a153090426bec492ee8b9d9713c2'),
('ve''nics', '81b3f7de98450a26cbdaa1d177556f59'),
('M600630', '4c59056c727fcaeb76440b1ac0dc2cbd'),
('M780795', '8681b1c4b717e4aefa901abd757fcd2a'),
('M797661', '3549aa3665b4dc9ed464e9c9fcf823b1'),
('newyogya2162', 'ecafb18da57fead60f6bee7f394dbcd4'),
('M823646', 'dad04ed680c825d570ca8e326c67198c'),
('rizalandetu@12', 'd699181b1da320519a417ffacdcff8a0'),
('nagalaut', '248051fef2dd6ba56dfe4c1667ff15be'),
('M785995', '979207f5a074bc4e87da39cf21c45d2e'),
('m791086', '7f2eb6fdeab6b7210987672359d4ce40'),
('M810771', '4839e2b643434aeb49a1d8e378534190'),
('NURWATHANIII', '53db0eaa30d19150a2330b34c4906bb0'),
('yogya221', 'a538837e093bdc57b9adb374ed02ae29'),
('M794086', '7ceaed9bd1ee64d132a75e22d67af9a0'),
('smh230367', '074de96758206aa90b3c87b4195edb22'),
('unitrisms', 'f3cdc66df67346744d10616735941b48'),
('M815178', '29a822055ed12ae5660333d621a918f7'),
('shedhidoy', 'ed5739c45210a8c5dc56a2cc8bf40edb'),
('M780255', '5c944274702e0cb43ed2e53cb5a5c183'),
('mataripagi', '5a428d18dbf831432c8e48349bc79658'),
('M793891', 'cb6e3b1a1b57ec641749d527294994ed'),
('raqina', '264b6f45f14101f5285bfa885da831d4'),
('rosmawati', '0cec6fbcd21ff24fc674991c999d5cd2'),
('wadassari1', '33283f992cb40839ee1b7892c23c0792'),
('m777678', '20398eb422c2d5e95e626aaf13798268'),
('shedidoy', '5451eed293716ca8deaaff68292b1042'),
('siti12345', 'ae668d18b246077d491f75c9794fede8'),
('M814251', 'f8587557093ee6902b559f2a699cb1e9'),
('sidiksudori', '51f34e24134817b2b82c8d1de186bcd8'),
('M741908', '09dec37ce309c6083489ee97dee6b10e'),
('pelangiWERSDF', '0d67d65314b20da9c4cfeeeecad85063'),
('M783071', 'adc714892cbec9028c3c299b08847565'),
('M82087', 'ae65aef4a6d9be7f6ea9a12f96e55cdc'),
('Ni ras2008', 'c2df71d6429e60467c44c5649646aaaa'),
('M765999', '6f97438eb61927cad6495cc54b5f665c'),
('yanticimut1', 'eed13c2027896fa1a86c079f3a8485ea'),
('uluy', '05cd163b1ae20004d7395abd3bc77165'),
('octavia13', 'c1688a3d4f9cc50544b6c00bf7350c94'),
('vryan10', 'c33b31e404f951ec7047d127d3371994'),
('monique', '6c4f158d214fab78e77b36922dad2ba3'),
('Sekartaji74', '5a59f27a46b1116d93c4233894112d55'),
('U010108', '835c6152639d8cd34787af6d2fce31ca'),
('M808913', 'd041f120a6407f508f2ac9baffecc312'),
('M785544', '4c590e726eecfba5be3a97312bc2d78a'),
('M824085', 'd723c0bf1076db7a0d066ca7a6fd129f'),
('M615991', '1637af9ef8fee1bf21be289eb7bef7cd'),
('M80787', '1b9e25b72206528447b872af6e341dcb'),
('M82143', '1484db6c4d3b3a52070016373a0e7063'),
('satria', '477054c78baea7a1242f79d898a2ca46'),
('M760751', '58f2137ead65bf3e12f567430aabc9b8'),
('muoyeqp', '4cb28eb3ca853e988b5d29e3e9ffc691'),
('M780790', 'c418a4c2725ebe786bffcf3b8a87e1ab'),
('pasbar1615', 'b8b1e23572e2bb8d7c69e8644556d23c'),
('triica123', '185b0cbf0bd072b2598c1ea1c83f5f9d'),
('_@jbm', 'bfe694034ae3b35485e994f754fb7dbe'),
('pasarbaru0904', 'ab45e06739fb3065a1944f49e32b433b'),
('yatienur', '00909d967abc12473a2c87c319792999'),
('shedhidhoy', '9f744de2c9da97d15bef9caca7f26a4f'),
('m773204', '10ccdf1304b5b04794db470c02979f6a'),
('SAIFULANAMFAIZIZUL3', '25a82634fcd5c36b3b890746e36cd944'),
('M784958', 'd962fa4eb37ff68a826654f7bf1ca8f2'),
('M553897', 'd2e2a18317dfdc9a1e9cd627cf923b05'),
('M601004', '037e9a88b949bf6ac795a079de1fef88'),
('sud1sud1', '3ad0bae016a42f99b4377ab558b0d2bf'),
('putri80', 'bc5c946984ccfde3b3e6b5b51b3f5667'),
('pbana1622', 'a4f8b9345178ee21a0781e316064536b'),
('unitrisma', '4459d9e55a07619be838532b0df07c6d'),
('M811140', '44174a5281160b1e15bcd27521d48a0f'),
('M602626', '40f9d3d493d2fdb7c4b3abc3435b7c79'),
('M600599', '302785fc9d931450e748334a780497c4'),
('M550227', '51199312d9f4761f315cc831d059fcbe'),
('M818979', '7869459e5177297f6edd9486fc71915f'),
('M768599', '0238922c43d3e00ba886dba59242b201'),
('TULIP12345', '5146336ac5ad7a239e4f4f5619662d9c'),
('M804469', '38e0e5b6b06ba5ff6a8b12dd7bfe6611'),
('M793570', '6a46c045dc356a034153c4c852fb052d'),
('m779802', '5803802cbece10f65117444e37ca2051'),
('M783344', 'ee2c6c5b90c7dc89fde71516f39787af'),
('M797471', 'd50eac1788a78b9f8f22a94a4dcaf8fd'),
('M783082', 'aacf43f9b3fa2d2b3e0f0e99b2205c67'),
('rarinsylsyl9', '4acd6097408def87fdd21670df6591e3'),
('m795708', '9a51e936c1b5fce162ab18881fbefad4'),
('purwakarta3012', '6591cbee1bce01884e5eee4ff21d9239'),
('unit al - fajr', '696bd458067927e4a6918a2f95737bed'),
('M614877', '55bdc5617b1f32b45848d20c68b2629c'),
('M814388', '5e1829f5d5ba3c5fc74a447d8d117c34'),
('M89993', '172d59dee98a8873c0c457403d12fa76'),
('RuminiRamli', 'dd4c0f14e0488af7c8d885d613645828'),
('M820236', '0ed56d20f126d7f5c903041a3d27629c'),
('tulip1234', '574b5412b8460f6b6f446f61662c4524'),
('tstiana', 'c19942a6be678e32ee30b9fa6545b4f5'),
('qiradzaky5687', '96843657ac6a8026c4a198f48eeebc1c'),
('M796709', '1a14dda2cdaa356837c00c3ed6b4a712'),
('M796005', '5a6b5bcf3d50695058b3aca325096c3b'),
('M796680', 'cdf7946776cddac08fbdc47126b80e07'),
('tulip123', '81bb0acedb160f0890ca521a1c916383'),
('M763234', '27dea17ca17008800e2f229d28e92681'),
('M553896', 'f136fa2092f389f3a4d413ff1e05cb06'),
('onengs11', '2bc6b2987dac8901e18bf7d48d1bce31'),
('M620383', 'a21f0677692bee381224d51d4beae913'),
('M778324', 'ad9d4b0a5a5933e5b0cbd7f3c62248a4'),
('MO10022412', 'cc16ac150a6e5343a494727d1f36515c'),
('tulipware37', '614079b082d98b7d48ebb376f72f3950'),
('tifathur021106', '80d66e16d6f98227cb2d2f9e4b17a7ca'),
('M796908', '2ea69587056a4f579595d3a05b2c6a64'),
('putrajataya07', '12ccbf9d7727b153f52f41cacc9f84e4'),
('siti123', '5c2e4a2563f9f4427955422fe1402762'),
('sidoarjo', '4ffe11d722d36697c617574f0a424bd6'),
('mb10583', 'c65a85d91f3d88a7f331d8d1f3fb0d7d'),
('M553481', '3a4aa22706eea2490e98987f44ce52d2'),
('M792764', '18a170f606389ff2a7ecf919daa57a3b'),
('tasikmalaya3012', '1b5417081fb57aea69cc79dd355fb8d2'),
('srimulyan15', 'a946a826fa0628a0c114e3c5e61553e0'),
('m604540', '134d67d746008ce19eb3189ac15ab4bb'),
('M791798', '2370bb1a8326afab746385a629e90b0d'),
('tulip82', '1f0f243127d4b6d291987824365e3024'),
('Tulipwersd', '65a720e0f675888bb3be8b759f11d185'),
('oktober82', 'fe0024439bd0c0318f853869c0926344'),
('M763271', 'b93141bef39c8d35b19e99ad37e9373d'),
('M758618', 'dd7ece4e44230be7316657135f3f12d3'),
('ratnasilmi', 'afeaaf8e6bb312c414f6ce225f7c5ede'),
('manhgarai', '8190480b837bb2de0f5c959c5358774a'),
('M823119', 'c552ecdea95143d8afd0f15357631f83'),
('M765156', '17e0a363cabd5ef03cb9af88b2ae3f1b'),
('yudhistira', '8e4ce768b5e2182b5b49baa1a1fb3604'),
('m781996', '94da9b553538cc93af26de540e5cd553'),
('M786042', 'eaace412962b354724a4326486ba9f86'),
('sella', 'cd22631a7f2cdcc84838beb4da2c8118'),
('M795908', '4651b782fbca0b9f4b68bec8e86a79f1'),
('M930425', '9b8638629ffe222a4f2abe3131945ce8'),
('M804593', 'e46d9e4618d07a191ae7467308204f22'),
('twntulipwarenme', 'd83134340c6a24d9206d314f87a66cb5'),
('SAIFULANAM', '2e5478b26d6c8e97342ced7da73ccbd2'),
('M790899', '3b9e000ba124280164a3458d9b3c7b81'),
('yati07041982', '44bd08ab91373595f209d7c19427d636'),
('M804070', '4414c6f1b055c9aa8dbf9c2eadba8672'),
('M776464', 'd7bc1101b4c44c954b12bb065cb693ec'),
('tulipware77', '15111653291ac62b5c5d48815798f5f0'),
('m812799', '753e01684bf3ebbbaea6ffe6c425a73e'),
('m610280', '4c08378402e1a72fd0e9bc4ca1d69c25'),
('m7768673', 'efb13dbe9d82cd6f144d7edfac8a669c'),
('M813621', 'b4f7cb74d3e7dcaf5150176bd63598e4'),
('Purwokerto12', 'fcc7bce714fdf342390d93f82fcc732e'),
('M777408', 'c143d01cad44f70150bc304c69be6cc1'),
('M82;00787', '92c8a15bc362f89570a4c2eafb739ad5'),
('salsabila', 'fe1e33bb1f71656d0d06d68e0dd2f8f0'),
('M79608', '1b9d78a999f934fd69150ca8b4f26c23'),
('pbana2216', 'bbdd189fe08d7962373eab4ba960520a'),
('salmajafin', '108d650e20e02f00b782c42c76ba5344'),
('pratama25', '45198239de99cc02249ec84c6fc7c90e'),
('tulipware', '80028900a71d235703398b103d719470'),
('wongrembangtulip', 'f1fe47205bf432a6c8cb6c2149504940'),
('M742240', 'ca5f21fe4a08a1c74b835dc77b596248'),
('M791392', '81c73a9a5d2a774e54ee0a680bead64f'),
('M771576', '37ce38a9f3f66715d3d2e08070fd5ac2'),
('m817030', 'e54d279cd7cbfb5044f0f3eeea84efd3'),
('M820787', '4df750d8220afe49c600c64ca08dba11'),
('myfajar132', '268dab949af7c7dca240dadf2b38fdea'),
('notnet', 'dc434717c974acfa91e2ae7e6bf1eaac'),
('permataphb', '6f70829ce051b7a0a42c6fc0f6b0f552'),
('tifathur', '38a8e8e69a8b939f9811a70a1353f0d8'),
('uklamuklam', 'ac96e1bef86285286fe30ae278851963'),
('paiyempaijo', '33dd35343ff6208e61a56d3068b5f60e'),
('m707371', '1e1bcee49ad29a5a5d0d3983b05a0bd0'),
('M787356', '8a5a5c42701415c2fe350a40e7cfaafa'),
('M602766', 'ce339fe336ec8f69b58c34542232abd8'),
('M791048', '5f4b4087a80fad46857c8487bec5b11b'),
('m794601', '97d7ba83f424bcc7fd68aae69b8edfc6'),
('m822863', '0f92fe70aa42fa259fe1a2bb32204ce8'),
('sativa', '8f0a20e111a2823f837dd39886fddcb6'),
('M813328', 'b8fff90613f6a8ec8abc0ab50cc99924'),
('menilo', '8ae6e29792baca877fd564f605b005cc'),
('M546726', 'ac53a96f185711cc9da6ade554d40ddd'),
('u', '7b774effe4a349c6dd82ad4f4f21d34c'),
('M809662', '59fab5c308dcc8bf0b3a3fcb38965f8b'),
('tangerang106', '46602ce5fdac65bebfcd1f106da3685d'),
('M820383', 'd8aba112df8b1243a9978c7c67e804cf'),
('M798597', 'a790d599270e26a8272123c4923622f4'),
('nandas', 'b0ab39aadb6ea57136f46b032144d41b'),
('M821254', '10abb01f4506aed33cb07e14326383cd'),
('sativasativa', '6beef63a6fd0e647a6f9e1fa0cf986f7'),
('M742779', '74a34d735eeccbd1fcf153d90401b86d'),
('M784218', 'aa0f88c97d193932765b03609acb1aeb'),
('mdrewcx', '8dade6d9e21ffeac1bab8f09b00d5ba6'),
('mutia', 'ab250ab2e876197de1c2c98fd18873a9'),
('M754073', 'b26507fce07394ed37593b90d1459830'),
('M763144', '90e744dd9c95baadeecacb6b79ed6014'),
('M601158', '021389ec6cd73031e3c5d8e113c7de10'),
('M797371', '1e23ec0cf9ce0314ce430109ca547243'),
('M546374', '495e581e70806d70b40a864f86ca8bf0'),
('m761684', 'afbd2ad386f6da89fa225620c774b423'),
('M788059', 'd9bab08a255990fe568a953721399fc8'),
('M794583', '4760d0c62363d515277812c6e9c93f90'),
('nurhayati', '601a351d479b5cf47d2b544b27484c71'),
('M803207', 'b9b3451eeaa3a81606b1d80898a73519'),
('mo1025274', '29ef9f34ba589269476dab451259356d'),
('Ummus4lm4n', '165c1814c9381b72470e769188671176'),
('ttiana', 'd2e8e08920dc4e563f387c6db9c58ecb'),
('tuliware', 'c8d31295101cc8518ac10f626ea33071'),
('ponti19', '98f709d4dc3477302c91fb76a774a60f'),
('shedidhoy', '00986aaa658ca8fa68b698d8295e7492'),
('palangkaraya159', 'c62a21128a89bfe92bd70b27ed376a2e'),
('m81688', '70a006627aa362c469dd341c5d54c174'),
('tul1pd3w1', '1b1cc5f3f6257aaf8ffc102e488e213e'),
('wawasan30', '44e23a68a22b49f1fb5325f4b1a86667'),
('M768673', 'd40eeb75029c5beb73e5314748b5cb67'),
('rahasiabanget', 'e1b64ce40f59dd357805ffd4aef5feac'),
('M799658', 'e848f12eec2774140023ae7eff11ccec'),
('v', '9e3669d19b675bd57058fd4664205d2a'),
('M761701', 'd376152a627498690ea7b2b6cf00fa85'),
('sby009', 'f2dfd4cb840cbb98c9b61e939c4e65fe'),
('putri123556', 'f767982f7fbf1bcadae11d81a9211405'),
('rafivian', '03678bd75c148619a04eb6f2ee2f54e5'),
('m8168x8', '1ef97b0aaf921feb46675e35f2fc7af7'),
('M762864', 'b556d3248294d4ef237dfe76f5958544'),
('yatirosmawati', '53e49bc1ef1916db6723c4fad3a1cfd9'),
('uthmaina17062007', '599812e5ba9b5a694cd81f69af9f89c3'),
('mubarok', '695fa7d1e6baf3c2cbf8422c56523616'),
('m812889', '241f88ce3977b6bc298012ac59ba391a'),
('M546570', 'a880812114a44ae5ff09b52ae4da6978'),
('M706312', '86173c3e5ca8aca523a11cee9651b7b5'),
('tulipdewi', 'b6353db08b9c7901eb3e2a1cc0bcc9c8'),
('medan15', '979ae91ab5334aba892af992db689a9c'),
('t1t1es', '98c6d1fdc21f9c63d16df6b0481da32e'),
('MS37539', '6cb84fe382e87e49787cc5c9be2d9893'),
('YL233011', '87a188dac993285a44b257cfb2827f25'),
('M776737', '5958cd6d9957ee80e4d1a1146446f1c8'),
('M791797', '615e98d9e5daf480a619f739e26c230a'),
('ragilanghisyam', 'a631bf598560d86a559d275f109b78a4'),
('M772871', 'e2b67c4edf30eff18b9763be8ebaa32d'),
('M546143', 'bbba1568a52b9141ab1a9a37c2529aef'),
('pelangi 123456', '38c028b1b7ed66f1ad3c6cc56ccab928'),
('suta0094', '1362fc7288ef70b39e5c8e19be0ee943'),
('siti', 'db04eb4b07e0aaf8d1d477ae342bdff9'),
('mantomasku', '8611a92acdb753c479cd7bbab7f16423'),
('mom12011959', 'c86e2dfef4ccde417b6e0d76a9422325'),
('R777888', '5c43b8eeaee0d98e46493db25fc58546'),
('M787580', '956c46d99ca4f6606c280860dd351e6a'),
('M763798', 'a0da3ebd67c923119d6f367ab335c225'),
('persibbandung', '4d409a250121d1788325fddbfc49b5c7'),
('rafasha', 'd69637a3a95453239e5fdd0a9d8612fe'),
('manda', '86cc266e1c70ed60524b9f23c79e3a28'),
('sebikanseptember84', '7df9a3eb244d93fc7dd14ba83b40c7ff'),
('M7883344', '47d49aa6ac0dd11e98b6e502afe5cdcc'),
('M789697', '12c97b892cf6397c7f2a0438e91d8411'),
('m764236', '802ca07ff5d58b3ed3e4a3cb5223b66a'),
('m821011', 'ff81dcdc1f4d2777cff78be5cb321938'),
('M782567', 'cb979dd423680251a8bd718ebf8b390a'),
('unitalfajr', '24179d0d5d72f62174106c541a4eae43'),
('m816888', '54a04121a3521665bc5d40824d651196'),
('semarang07', 'c2fe5ab6ff64e4bbe946089b3cb55270'),
('twintulipwarenme', 'ced1e0a0ed202386aad4531b5eba495a'),
('r4uz4n', '6add461084e5cd1185748fa65e53c373'),
('M600036', 'ad3f7f841d4fc1d3f4ba80d3b30dce13'),
('M804175', '336b7b04dd3b26f702b7e5a6db5f9528'),
('surabaya9', '9fd1c42aac1287d25a26cb714f3dab3a'),
('M810149', '42ef72aa219744182c395d2ba7807bf8'),
('malang30', '2f49617dfaa336be754df9b74d58d00b'),
('ve''onis', '35e9b70dd8b29139c4bf0ba845d2df69'),
('su ayyah', 'e1bfe2bb2db85124c29b6966532b179b'),
('M875995', '99aeb2eada507870286805c73ea399dc'),
('Mo1oo2412', '0e2abac3787057b53beb73f8f38d0a3b'),
('M810583', '42ebb79a612297f900af3ff5f55ba774'),
('senopati', 'd91f691b11eb003b7531346a6d100532'),
('reginaday', '6f3f1104fc1d6431aa5bb061afc6cd72'),
('MO1013470', '7f28f823890fba45c3d0adf7aa8aceab'),
('yati070482', 'f48a5c2b5c3cf95d1a947c35c27b379d'),
('Mz01004556', '96684b25c322f8316314d884ad32eeab'),
('M554336', '5c50449424b7fafffdc3d1a16d7cefe5'),
('M812545', '734c2970ffb1e50c82ba96c81575ac1f'),
('nainggolan', '994e541beaf1972aac47f0fe38b3c826'),
('M743246', 'db67a174244af2484af71cb9364dc7e8'),
('M787923', '1f0a11341985f10bd07b95b60ec12173'),
('manggarai', 'c425b9aa854e8dbe10301b475725a1db'),
('M7886199', 'fdbda9fc4f94d5005d56997a8369eea5'),
('medical', '7cbdd4e997c3b8e759f8d579bb30f6f1'),
('m816688', '13051dabab0be9c1ffcf8cacd860bc21'),
('Mhalo', '0091b01b4532588670816aaec8b6c29e'),
('mo1)94176', '303dfd1582e23a3ba202401d21dad991'),
('M618076', 'abd2f307623b903fdee2de0551fa0fee'),
('sularyo', '139d712882211870f489c56aa0738a84'),
('penga08', 'd8a72623833b6155e3e2a3c503f5cc46'),
('muthmaina17062007', '809bffb55fba31b787e8b22d7c8ead28'),
('m726207', '3d349a8bcce7b147f88b9c9a84bf2b4d'),
('M797008', '72be920ed0a266d0241d1e1662f7e9ca'),
('M758814', 'ef4104f4cf35d45132aeac57458b4e37'),
('M79826', 'c185ba6a537a3e740d26bd80f0a6738c'),
('M761207', 'f1af8c807013e5174b0d988a1f4e491a'),
('unitrohmah', 'b2739c5b4ea08cfcacf9a71d43860ffe'),
('sayang3996', 'f76f08c032ee61b6fec158cb447511eb'),
('M803968', 'cedca214aa30078c3eec286970faa750'),
('rizhwan', '84a121f6e4fc3379a737095182a1c21f'),
('MO1041482', '6abf6a1307b54c9db9af7cd884004fa8'),
('M545879', 'f3bf77c1d0717e406f75d30e3961bc20'),
('m545911', '538d7475aa9c0a4c5b0d87c060a6cdb6'),
('m788619', '1532d8b71fbc97f69a31778170ec35a3'),
('nadivaanaksolehsh', '9362fe73fa54d6f000bef7bcdd9da64f'),
('tulip', '0ae57c94574802400bb2b31a4ac950ed'),
('vantiana154', '0ea69c671d86411cdc3a93a0679d25a4'),
('M772305', 'ecaf22cc4a5040e7c3fe22a1d7faa135'),
('M809359', 'fa4e88c20dc95602805d7d8a150f5cbd'),
('medan3103', '934e3025e70cfc1f4bdca63486a70df9'),
('nabila21', '1ab373391c26734d96d5a3a32e5d0163'),
('M761001', 'b6b87fc8683fdfe8d9966a09bc82f64c'),
('ROSMAWAT8', '7ff133492d6d7ffeb3183b9c180cb62c'),
('qiradzaky', '20f8fd20e7971eeecac4f0cc41d18253'),
('M546188', '8a12b94e3eb21a70794580dac657adb0'),
('srimulyni15', 'a4fbbda519397007cafe2b26d21c7163'),
('w1L5on', '4fcf737a70b88abe84feff1f07e726d2'),
('ma26ta26ta', 'd08d0d9b08a8114e8cf9e1328f01791c'),
('m783483', 'bf968ef3391ae9de813ced44d1f42ed1'),
('serang37', '22cdea10b281f08ac581541e321165a0'),
('M641385', '09cfb759d0b3b97756a59db70d3dfde5'),
('nasya123', 'c58152a0270f465b85e5338a3272ffb4'),
('maysaroh', 'db2d5bfdeab866fccd18e8b1cc5a7201'),
('tulipware1234', '22dbd1d85b6d0cda48039850d0653136'),
('W808013', '204a5585b2e12b3a4f469e9f5bab5fae'),
('M546123', '27f1882ab69054778aa0f5d8f0398182'),
('M824043', '0ab70789b299f6397506c92228ee931a'),
('pekanbaru98', 'f5c40cb9112cc3554251f926ee4a9d19'),
('N240311', 'affe54e6dcf7b01c0920902bfd5ec5ca'),
('yatirosmawaty', 'd928490220e7ba9a22baeac39a74f8c4'),
('m7427799', '5f895c144a1c923a74204ff2004bfa25'),
('samsungtulip2015', '51ed1ff9aecabe0376bfdef50e986922'),
('M553684', '28404b630747947e875b9da4d48826df'),
('m600717', '6b0f8b0ca7a404813c5c0abec62a8f2e'),
('ups_happynur@yahoo.com', 'e690e926391c1f86c63f9352e2106f26'),
('M802389', 'b6b92a36e90e136f179c6a6c92c12ce7'),
('MT01035818', 'ba9ad34eef4381f61da767b83036cd68'),
('mumtazrasyidridho', '415f080501dc2434500a6c0c6b739d39'),
('srimulyani15', '8ef43197606cf5aff07cd5b84fe8f5a3'),
('makasar10', 'da291deb989eb74afbe9e7af6e20c242'),
('M819196', '453671d169d863fe00c71d704f7ee436'),
('M800260', 'b0ecdcc3bd5ec396162e20ae448293ec'),
('u icha65', '0845f49a9c74118119a0ca237094d423'),
('M822512', '471a9765bfab78e6f70fec2d90ea6476'),
('M545988', '6f460856ec27dc6f7d53cf9d10fcdf67'),
('M754078', 'ddb0b04f813b2ed4b0b39c43889c79e5'),
('M546765', '0c24c0533a89bf0b64b12cd5811f9e6d'),
('mariaantin', 'b207c54ca49114adaaa8350fac0f549d'),
('M783056', 'b4d68d662d18cc2928fbdc99d57976a9'),
('NURWATAHNIIIU', 'f86acee383d22a97b6d9efe0e110ae9a'),
('m803193', 'a2a2238ca30005cea7ff29c8f889931e'),
('sembilanseptember84', 'a26e4abeaaa8617f66fa678a1681eba4'),
('ummay2007', 'bd20e9f33e0eb3b3e006035ff78fbc24'),
('sura9', '98f8876c7ec6d196ddf0c7fd96e176d8'),
('sitis0l3h4', '2baf65054e5bb6fcdc548d019d4b437a'),
('sayyidain', '7c718a3ab5fe016849d75b21b6d5a09d'),
('SayangkuCintaku', '227995c6a58a3f66f1f60cee89f23af1'),
('M812689', '788c338ebcdd52469a855ab60ee9ced7'),
('tulip0106', 'de83b9da09d6c9a414c65292e5fb9a74'),
('mamagazifi', 'e06553e4dc5524f5664946cc1795b616'),
('M77769', '6fc176c2c6fc3ce46708c1fd117a9de9'),
('zaid2813', 'd3bd4909bb5547fdf59fc88aa0fad700'),
('M790748', 'e3bab401af15509ed8c311aa7a3cb0a7'),
('m553503', 'dc856050afe052c3382dd758417ea43a'),
('rkt1305', '422d2424f0e3e80686a5adc06b3b68b3'),
('M811558', '96f7e3c8068474fbc61534a31ead7d4c'),
('ujungberung3012', 'ab465abe81e0804c33f0726eeac7a96e'),
('M780796', 'bc2b3b3009a8fa202bb02e17cb30b94a'),
('um7cha65', '4c8762509b894d43b1c447e5ffb1ca23'),
('YL07091971', '79ea5834cb87e206a98aa9dc4c2dc9a1'),
('paijopaiyem', 'e3f3b0f514b42d5ff6699b0e80dfb000'),
('mumtazrasridridho', '00a1c1aea5fae82e996710aa9ddfb2f0'),
('rcpsionis?', '05e8a6aeaecb13dd2434488bf5e76837'),
('rimba', 'a6dc4c5d7d67614c6b7476ab01ae5ec7'),
('M808103', '1d27229dfa132d985667c1a24847d149'),
('maisaroh', 'e61b85018771f9028f52d39d4c0899c0'),
('M763797', '50d817baa01d1d402821bd621541cba2'),
('m786742', '7b6cdec7800515d4680a7528e3cef8e1'),
('M742658', '465c66be2ee08ffc8830e6b2812fc7d0'),
('ninangmatari', 'd641560779445f8715cc729c5b1df282'),
('M601448', 'df449a731c4661129648c8df6014255f'),
('M790399', '72b2fd831d82eedb88a555b30161cd12'),
('M818926', 'd015a0e9d828cc33cf5265adb4a4dc84'),
('Mo141482', '599ec47990029c1de852dcf9209a3860'),
('M772315', '0109855b99cf2cb84ebf572bba5e6948'),
('M7?8188', 'f316952065cff89005727ff9e74c1ff9'),
('m7616684', 'a4e3708608eed6affef653c873a594d1'),
('M546085', 'd02e2e24fc0fafab07d925d9a45bbbae'),
('M797810', '7a30be066b1e381d4c5715dddac42370'),
('nusa9hijaau', 'be2b79cf4ae37aeb749f60a718fa4549'),
('M798726', 'ce61dcdefc82dd44b9ba87d8d54e6e3f'),
('m61591', 'f863c7b0060c19a4197e82e900e39205'),
('ummunadhifa', 'ed4b20cc91371ac8ad4699e65a6a63aa'),
('Md24415', 'c91cbceb896a2b029fe74a5e48517b82'),
('M60131', '531b65a31c4dc1b64f6a0972ed1dbe6e'),
('M777440', 'fc5302ad3ac0af07163b2748ec0484f2'),
('M760', '95f78ce6bdb440381f65964d5062bc62'),
('viviandkgroup2013', '0f01c6cb3d9aac89702144450d02213b'),
('mariaulfa', '98f56d0b73932e12096f2a3092b08e7b'),
('M7969?8', 'a52b2c0806297e58973e3bdd5bfb1687'),
('M787184', '9baba7c7af1685c585a7ff9ae324b3f2'),
('q150586', 'c97ca452e8c00920c096e45b8b05b9c0'),
('ve''', '9779e492b17935409b3c44fc8f545942'),
('newbali149', '3b03725506f08cff08064eb769864d43'),
('m7981888', 'f0df86f5f39805ff631151d430540bc8'),
('M811102', 'ca7ffbc0ee934323cadde4c4a329f4b5'),
('M810979', 'b6f861fb666b230d17cd439e3e169f67'),
('M797972', '7eedc0bba8548f417f4ba8d3082ce86e'),
('m794468', 'b4f092f88976bcab227bafca81f01cc1'),
('M822336', 'f00654a99c94d59bb6e1fd1b81a12048'),
('prambils', 'a8813e6a1bd727028b5a3ee07a16d860'),
('M762856', '07f6033d35e97687439902aa5bda564e'),
('m816761', 'd94363f911ad05fbb723f1bed27c68c0'),
('M800918', 'b64fc8a54b2d092da835a07f1f58e033'),
('yamahafz16', '83d5e6836f0260ed8cfde251672d6631'),
('SATIVE', 'fae9b6cdfcbb19e7ed86e5eff12cd233'),
('M817707', '440fa29d8b171d164df1ee4792886e65'),
('Mo1027248', '93f0b27713d6b896e87742c49262695d'),
('M760799', '1bd23bd2e4c999147318fb38c997c69d'),
('r1g1t4217', '3cdaab82527073bca8e0ca5c053328ca'),
('m77230', '2e8ec40c3e43ad545e65f5423d42fe7d'),
('tambun66', '83fd614a1370e0f52cd71f53a4f008d4'),
('M701106', '526b144aa9230751cec3a433135e5b38'),
('umicha65', 'c37e800779d664608d5e87fc8ffb78ae'),
('UNITASALAM', 'f2f21541d383055bb9d2265e065050df'),
('M799703', 'd7c1e1507b82fad2e9af1eed8323af62'),
('M616557', 'a4ed0e7384a865f0d023dcaf22876b13'),
('myfajar146', '7dd733bcf277501ab1f0020e078cfe07'),
('M822298', '8b8ca32fcc51d38310496deddf043dd6'),
('M797453', '55e81681e5ffced097bbe2a8e71da2da'),
('m696175', 'b6c6c1b69c6ff70f2a641006fee29075'),
('M742581', '280e5d23d2a0a820415a6da97005b739'),
('M602569', '3e2616367631f3f2dce81bae6ea38c8f'),
('SAIFULANAMFAIZIZUL', '9d750a1c45717e5d8c03a1dafa335e58'),
('M545938', '16f5aaa24ce82cf45f0bc083034476e9'),
('M755156', 'fe186e9fa6532b6e5afa76132cf9c548'),
('M798908', '301e73ad8b12ad44a91e9b6ccd6c0051'),
('tul8pware', 'a595797e57febe11a21a307607ca8de2'),
('M779031', '2ecd5a7c34a246b7c3f90ad45db959b0'),
('M815604', '06ad03e5470733809fd1198d9ef75389'),
('M814893', '0b7a513948aefdb9f5fa4b77108fafc1'),
('ratnasum', '36c4a730e0e669074fdf1ac755a69004'),
('Nibras2008', '064a617f915b1dd738f24089e57498bf'),
('puspitaruni68', '4767e6f9d35627df8d93a4f11c23356e'),
('M716207', '532fee476de2f05161d74c0bc75a7a7e'),
('nanisumartini', '4fb6dfe8b9fab39084f9ed763dd6b7f0'),
('M823291', 'dee4eecb9dc24a886b1c5cc26da34f10'),
('nusa9hijau', 'edf3d90ad6784c4346a9c56ea7ce9451'),
('upandang', 'f67c2ec9fa27e0df7eae0bbef279474f'),
('M800520', '402a169f9494872d863c044105951b18'),
('M54685', 'cdf223aca79f9a52023a67b0f8ea931c'),
('M817666', '5da33d5a67fcb90245166bab7a4f70c3'),
('M783931', 'ed81dc6ff91f8b9feff6d5a0f892f510'),
('M607134', '4be3a328804bd19e9f15c9a1c90ae50e'),
('M818387', 'db61a556abc9375166421bb1dad6a7b9'),
('mkt1245', '12ad232d803bff4f5e48b545c374eb9a'),
('siswanto', '675cf5697f0ae9943d6e5b24ee32ddf0'),
('M820473', '4b6523b85e40db295b3f891c171ec7a3'),
('ROYAN', '4a45b4707718058073818dd119be9043'),
('maria999', 'cb451dca194315bf6e78b7a0476eac6b'),
('meruya62', '79e28bcb1c245e86c5e179179b4a8a15'),
('M762154', '7ae88116082ddbd9b7715ce262907ff1'),
('mhjjnykfuj', 'ffbec610ecdf3a0a6f6304e0934c171c'),
('SAIFULAMAMFAIZIZUL3', 'c18e612849f25657ba33467b208e95b5'),
('tbn001', '1f5a174cf1a663a8414684f553f8dddc'),
('pentolbakar', 'ffdcdfeacd552a9bb70f7f015c2b922a'),
('yogya112', '71ccbfc60fd4178850d2bfe3b274fbb9'),
('M753731', '5df29813f497103f2a9716ad280727cf'),
('M600715', 'bde85eb27023073d52bd9469e0fe7d0a'),
('ngokngok84', '9abb2f056be7d711ba13517240103f58'),
('M809498', 'a29fcec3f8afd05b3e8a1df69a066951'),
('M546386', 'e46653655cad15cb7c51b3ce7f60e7f3'),
('m768009', '7b72b9deb62f2f0e08ec6a591270fb54'),
('revanavi', '250bdfe1c3a334d257dc351229dbb7c4'),
('ramadhona', '5721ff15fa469da7d417c54a92ea00af'),
('y120777', '3a518f1d5553c9b9a8d8049aea726173'),
('M797222', 'f143a0a50a981888f8526cde13b1fc39'),
('m81104', 'a618ec89bdee9bd45c6016896d205966'),
('M803383', 'b6a224fb727a90dea92b415e3bcc0e0c'),
('M603300', 'e142f78fd40ce1715583de00c22cafba'),
('M796738', '38a68a5a6815cc92c95708c9fea19364'),
('test', '098f6bcd4621d373cade4e832627b4f6'),
('Sakhiong2003', '009a7efab07151d5662141d1f651af80'),
('sulthansiti', '821a3133c32f3d582745c8092853b852'),
('M821243', '244769115565c5774fd2220d60bc3bd8'),
('widyalestari', '5aa57c768d3b87b33b7d0938624f230f'),
('M613374', 'd13d87bdb8613bf1d10dce1cbbfcbb34'),
('m786458', 'ce533152db72edeb81a1e5c9aae1b41f'),
('M813474', 'ba7286fb6fa9b0eb3f903ec1d19cba1b'),
('n4g4l4ut', '4d04eb2a765c9f6ac01277af92e1a43c'),
('nadivaoral123', '6395ba4a9e7ad6627ce8cf160e70c6ea'),
('sidiksyahid', '54138030dc00c46eaa9afcdd3c9cd885'),
('M822626', '9d1f42f3185f25141325553506b5f741'),
('M794254', '2daec24b1f9e7612fff27c74f87250df'),
('seigerong1961', '9e78199015a8627d425509733e6d7588'),
('M798132', 'cc75f14f5b5f841e37d17f11010ea443'),
('M615793', '1a356b80df64468ac7164670e159fef9'),
('tatiana', '3e57f7ee22713728335920e979ed0bde'),
('pas m779031', '8ab8ecacf2d44b7f2c3099e319095430'),
('M802177', 'f48bd6effd76ed1ff92fa9262ccf7661'),
('M801136', 'a18e727ab38ae3ef66797990092f91a7'),
('wbachtiar', '5b1b0ef64879d5905e9ae9faf6a9eade'),
('samsungprime', '339996a2e443eeede0b0a4ce630dd612'),
('M814573', '8bd1406a9c0fc972183683c7e4ed5f0f'),
('m814882', '63841af1dd2148bcf2e3fc5d2e959f8a'),
('mojokerto90', 'f48e5d4596918e9a18d2835179f98b77'),
('M601082', 'c2e8af40877fb796150155be03c1b7c1'),
('M799736', 'd2c99c155239f53923e7c72a5e9131e4'),
('nusa9gijau', '1c4136128d880e345619811aea607fed'),
('m810720', 'ad92b194c35215cc1e060a07f43ad3aa'),
('nengdian', '683903a8ad9cf9d850cab0c023bd7747'),
('M814389', 'ba45eb70e669dd1230fed04353599a77'),
('twintulipware', '69690865798de8e775fde5654cf98178'),
('unitrisa', '8895fea7316e294425da238c155db846'),
('M809972', '8edf401ac18905e3e75f2589d98be848'),
('M799763', '70a2898f3dbc8e7b9610682dfcbbfa4b'),
('M617911', 'fe6cbd193059cf5c8fa9e082f5472eaa'),
('tulipd3w1', '9074ad7471f49b26247a0d5d2be20e3e'),
('yatitulipware', '7c7009208b28677454780ceba23c16d8'),
('M776928', 'd07935098e48f2919bcf8a3eafa6bb25'),
('mila270677', 'b3ee698324f374485f4c8d4b9fc80857'),
('xxf0cer', '36eaecd5fb69e8c69151859bfc949d71'),
('sidoarjo73', '321dc7eddc505326c15393fc621f3818'),
('M79008', '9f38b27a91cca6aae7ea76396ea66f55'),
('wilsonbison', '5c3f9e9e3bec46670f3140cd68b028c5'),
('M7651556', '8efbe918b844e3526bd956b91851a25b'),
('nusa 9hijau', '53e353ce684069bab2f5b92cfc615478'),
('M797807', 'ed8e14442446b6a6c18f5fc4f07df22e'),
('M784639', '0fd86dd5f39e90355877167fc1bb9ebc'),
('tatiana4', '139683b6a1979a5a865fba2e0b9733b5'),
('twintulipwarenmr', 'cb955d7b3574d2a709eabe3af5248ff5'),
('m808013', 'ea112b83f7b864454e53b600fa00ffc5'),
('ramaindra5121970', '28617f5b681c046551c4cf1db68f3aa0'),
('SAIFULANAM1', 'eed9a5d5ec74c06b99166dae83942322'),
('M613386', 'e14ff161ea30ddabdd592137605cd792'),
('samarinda43', '803d3eed152e69e9f25a187032ddf8d8'),
('M606577', 'a6422e218944ba207777c2144055c50d'),
('shitaiwan06', '7d85c62daab11a506e72952b9e709c90'),
('m786148', '0bfa170f474dd868dcbe367f393c7f13'),
('M798782', '505953fa0b1213c07e7a215643995c74'),
('sepuluhdesember', 'f6a827de425338413c7f41bf193d16b1'),
('puspitarini68', 'dd33baafc037ac130ba676fd103c8ce5'),
('M762858', '37e505bffff7a508455d34e45f482afc'),
('sukabumi3012', '5ce0dcd99234542c002fd1aa38ff6692'),
('M808254', '8a42dde80b4e16317efe04bbab52608c'),
('ml270677', '150458bc5f20c158ec6fc1973631313d'),
('smrg16042009', '6d5449633506a692621ffa1ac70eabcc'),
('M800811', '08a285764c15aa418d5573e604130dd2'),
('w1L5on99', '89a23db78b15cd0b52f0de1536a5b621'),
('probolinggo151', '0fc92344c8d0d282b3e458462c1210c2'),
('M787719', '375315abed053c2725911b5c58381a62'),
('w819455', 'b1dd435c2987268fe7b059f1370b11af'),
('ve''onics', 'f80d0799f2c63c7c8b34d1d2938691f3'),
('m5535444', 'fd754a76fd9e6f47a7926787acf40f17'),
('M780166', '2e0feb00faa937535f093278560bf175'),
('srumulyani', '29e43a564aab1c0e496c689c92f43057'),
('salmajafinb', '6e97dc77ef0561877a41615fd44ee37d'),
('M784915', '7b8cc60bbf4f15025182ffdb99c3b4f2'),
('muhammadariqpradana', 'c014d958c87a6957d88bfcb8e2fdc1cb');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
