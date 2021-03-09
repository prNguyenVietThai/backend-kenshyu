-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 09, 2021 at 08:27 AM
-- Server version: 8.0.23
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint NOT NULL,
  `url` text NOT NULL,
  `post_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `url`, `post_id`) VALUES
(1, './public/assets/b7ea8394ed1ef77e6b1372ee17d36446.png', 10),
(2, './public/assets/26cb1e2611233ac7c3a73175595c57fc.png', 10),
(3, './public/assets/4aac95ee4ad1589588ff635dfdf8139e.jpeg', 10),
(4, './public/assets/3b0ed9932ae29eac5c168244d6bda30b.jpeg', 10),
(5, './public/assets/a50fb6dfc9c90ff71b221f8d55c5bf46.jpeg', 11),
(6, './public/assets/c218ad1fc92e6ed71784e64082d31750.jpeg', 11),
(7, './public/assets/8819ccb8fa1ee9b201e76f6af0498d61.png', 11),
(8, './public/assets/2116f1120562f3f5c928d4bb09b8c142.png', 11),
(9, './public/assets/6613de8ee6c064f528b028afaf1aa7bb.png', 11),
(10, '/public/assets/cde9a0f6ee93ccfd4072bd1124265c1d.png', 12),
(11, '/public/assets/b687779a25dc9c8fa2c55744fa40e1c5.png', 12),
(12, '/public/assets/0e196f9b4ef976f7478435286ccb77e1.jpeg', 12),
(13, '/public/assets/f4a825e41b0347d915c950cb729ab555.jpeg', 12),
(14, '/public/assets/473b6f33e9e1b92cdf2ac7a6ac9b5276.png', 12),
(15, '/public/assets/115caee8da2852fa59cf10fc95444c1f.png', 13),
(16, '/public/assets/ddc959af1ab7accb5797eadb796fc353.jpg', 14),
(17, '/public/assets/7303e77ba616c6bb93cbf735d2e47f3c.jpg', 14),
(18, '/public/assets/95d0c8615072a89b3c444c42d9cf2f6e.jpg', 15),
(19, '/public/assets/26d5507179c09d78e9c5911f272e1362.jpg', 15),
(20, '/public/assets/b0d07cf9f125089985f6316a738ebf4e.jpg', 15),
(21, '/public/assets/c513331edecd43fea39b955607b97da8.jpg', 15),
(22, '/public/assets/23ebf6d24e9fddb377fd326cfd6ccb03.', 16),
(23, '/public/assets/6d670cce3cf99474608e63f48c018bf4.', 17),
(24, '/public/assets/05f024059b4292f998ba7deecb4f9a9c.jpg', 33),
(25, '/public/assets/16e324c20c7c4df1e2cabb88636c8263.jpg', 33),
(26, '/public/assets/c7d02f01fa630b4f34e0cf5fcce68f08.jpg', 34),
(27, '/public/assets/0b63a16e252819f9f2b677e4c3e0a2d8.jpg', 34),
(28, '/public/assets/c312ea12735181a91191a64923203ffa.jpg', 37),
(29, '/public/assets/04aefc38affaaec2dfcbb4e8f47c0b1b.jpg', 37),
(30, '/public/assets/e1149d5b20e6b7590b310acb83de3f01.jpg', 37),
(31, '/public/assets/cbfdbc5115d7452a8e5629ec664456b3.png', 37),
(32, '/public/assets/44953a0d49258a10fec4fb739d7effaf.jpg', 37),
(33, '/public/assets/429d16a7d948e5855af30735cdfaad37.jpg', 38),
(34, '/public/assets/1a2de193cbc8ee35f432aed2cebf6426.jpg', 38),
(35, '/public/assets/514f0fd2b5eb8f8a6175bd39c4539681.jpg', 38),
(36, '/public/assets/324ed41295736b2cc6522d6190add9fe.jpg', 38),
(37, '/public/assets/9ab27bbf336ad302d196aac02949a43a.jpg', 39),
(38, '/public/assets/e90a11b86d673797ea19ec57a60b3f5b.jpg', 39),
(39, '/public/assets/10c52ee8a8748e12fe2c491c279d11be.jpg', 39),
(40, '/public/assets/a4da15cc7d1085640e681ae4f51df616.jpg', 40),
(41, '/public/assets/073b4918d1d8e328675bdb5a0b9a2064.jpg', 40),
(42, '/public/assets/454a414aca8156c8a9055b432221ec81.jpg', 42),
(43, '/public/assets/30efa558108b0aa3cf15479a189745cf.jpg', 42),
(44, '/public/assets/6a3317f6286dcaa9cc583a2f30e46d0e.jpg', 42),
(45, '/public/assets/97b592d7636f06666483f023df33f80f.jpg', 43),
(46, '/public/assets/f57fe4187dd4eb70179a68e703a78bb5.jpg', 43),
(47, '/public/assets/7f5b04e2117f20439e7dba429dd37759.jpg', 43),
(48, '/public/assets/5ae2593cc1b0f8dcacacccacfcd84d1d.jpg', 43),
(49, '/public/assets/6f02ed9cd03792354d706cfce1aabe32.jpg', 44),
(50, '/public/assets/bc3662a2abc90b86d5bf50217a8dcba1.jpg', 44),
(51, '/public/assets/dd2699dbc91dea9becfa8a51f07f6775.jpg', 44),
(52, '/public/assets/acd3a9787e68d2e3816ad099ecd84e5e.jpg', 44),
(53, '/public/assets/8f7c2153a1cd0679da66df3920142e52.jpg', 45),
(54, '/public/assets/a9c9c7bacbc13d603e8b5aa461fad6fb.jpg', 45),
(55, '/public/assets/fb932815a095ac473d885d3cd2f01cd6.jpg', 45),
(56, '/public/assets/cdd29b5fc852d9317687fcd56f40b2df.jpg', 45);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint NOT NULL,
  `thumbnail` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `user_id`, `thumbnail`, `created_at`) VALUES
(38, 'Chuc mung nam moi 2021', 'New year 2021', 1, NULL, '2021-03-09 06:01:36'),
(42, 'rererer23232232', 'rererere2323233323232', 1, NULL, '2021-03-09 07:31:52'),
(43, 'TEST THEM THUMBNAIL', 'gi do gi do gi do', 1, 45, '2021-03-09 07:57:17'),
(44, 'hanhhanh', 'hanhhanh', 1, 49, '2021-03-09 07:58:50'),
(45, 'hanhthai', 'hanhthai', 1, 53, '2021-03-09 07:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Nguyen Viet Thai', 'nguyenvietthai1351997@gmail.com', '$2y$10$PnB6OPAoUJptUIH4g5nZF.x8oDLvEFfOmt0/rAiEAwn8wjbqMKsZK', '2021-03-09 02:17:39'),
(2, 'Tran My Hanh', 'myhanh24@gmail.com', '$2y$10$WZmqxjgr99Wk9oiG5yFYjumCRko5C5VuzToa09F7hZo/fviedujmK', '2021-03-09 02:18:29'),
(3, 'Viet Anh', 'vietanh@gmail.com', '$2y$10$nZ/EpgFZnWFZeXOm14Qh8uL343sQPh.0ZbPkiO/wrIas6.JyfK1.W', '2021-03-09 05:54:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
