-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 23 août 2024 à 13:31
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ads`
--

-- --------------------------------------------------------

--
-- Structure de la table `accuse_receptions`
--

CREATE TABLE `accuse_receptions` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `courrier_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `accuse_receptions`
--

INSERT INTO `accuse_receptions` (`id`, `user_id`, `courrier_id`, `created_at`, `updated_at`) VALUES
(1, 3722, 1, '2024-05-29 18:30:48', '2024-05-29 18:30:48'),
(2, 4074, 1, '2024-05-29 18:40:34', '2024-05-29 18:40:34'),
(3, 4074, 2, '2024-05-29 19:51:55', '2024-05-29 19:51:55'),
(4, 3722, 4, '2024-07-08 09:37:32', '2024-07-08 09:37:32'),
(5, 4074, 4, '2024-07-08 09:39:44', '2024-07-08 09:39:44'),
(6, 4074, 5, '2024-07-08 09:46:10', '2024-07-08 09:46:10'),
(7, 3722, 5, '2024-07-08 09:49:04', '2024-07-08 09:49:04'),
(8, 3723, 5, '2024-07-08 09:53:57', '2024-07-08 09:53:57');

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

CREATE TABLE `adresses` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `phone_2` varchar(25) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `residence` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresses`
--

INSERT INTO `adresses` (`id`, `agent_id`, `phone`, `phone_2`, `email`, `residence`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, '+243810000001', 'contact@regideso.cd', NULL, '2022-10-26 14:41:09', '2023-10-20 15:49:22', NULL),
(2, 2, NULL, NULL, 'ntaku.salabiaku@regideso.cd', NULL, '2023-09-27 13:14:51', '2023-09-27 13:14:51', NULL),
(3, 3, NULL, NULL, 'otshumbe.loka@regideso.cd', NULL, '2023-09-27 13:23:47', '2023-09-27 13:23:47', NULL),
(4, 4, NULL, NULL, 'madila.mukalenga@regideso.cd', NULL, '2023-09-27 14:35:27', '2023-09-27 14:35:27', NULL),
(5, 5, NULL, NULL, 'vangila.muziedje@regideso.cd', NULL, '2023-09-27 14:38:28', '2023-09-27 14:38:28', NULL),
(6, 6, NULL, NULL, 'makombo.mwinaminayi@regideso.cd', NULL, '2023-09-27 14:40:37', '2023-10-05 16:37:21', NULL),
(7, 7, NULL, NULL, 'ramazani.mwanasumba@regideso.cd', NULL, '2023-09-27 14:42:32', '2023-09-27 14:42:32', NULL),
(8, 8, NULL, NULL, 'lukibu.kulemuka@regideso.cd', NULL, '2023-09-27 14:44:43', '2023-09-27 14:44:43', NULL),
(9, 9, NULL, NULL, 'magbolo.babu@regideso.cd', NULL, '2023-09-27 14:46:19', '2023-09-27 14:46:19', NULL),
(10, 10, NULL, NULL, 'kilufya.kasobe@regideso.cd', NULL, '2023-09-27 14:47:58', '2023-09-27 14:47:58', NULL),
(11, 11, NULL, NULL, 'nkayi.muzinga@regideso.cd', NULL, '2023-09-27 14:51:09', '2023-09-27 14:51:09', NULL),
(12, 12, NULL, NULL, 'bongabo.monka@regideso.cd', NULL, '2023-09-27 15:08:24', '2023-09-27 15:08:24', NULL),
(13, 13, NULL, NULL, 'katumbo.mayanga@regideso.cd', NULL, '2023-09-27 15:15:17', '2023-09-27 15:15:17', NULL),
(14, 14, NULL, NULL, 'bofili.ekononga@regideso.cd', NULL, '2023-09-27 15:20:44', '2023-09-27 15:20:44', NULL),
(15, 15, NULL, NULL, 'mafu.bwako@regideso.cd', NULL, '2023-09-27 15:22:29', '2023-09-27 15:22:29', NULL),
(16, 16, NULL, NULL, 'ntumba.tshibangu@regideso.cd', NULL, '2023-09-27 15:38:03', '2023-09-27 15:38:03', NULL),
(17, 17, NULL, NULL, 'musitu.musalu@regideso.cd', NULL, '2023-09-27 15:39:36', '2023-09-27 15:39:36', NULL),
(18, 18, NULL, NULL, 'buhangize.nabuchi@regideso.cd', NULL, '2023-09-27 15:41:41', '2023-09-27 15:41:41', NULL),
(19, 19, NULL, NULL, 'lendo.lufu@regideso.cd', NULL, '2023-09-27 15:43:47', '2023-09-27 15:43:47', NULL),
(20, 20, NULL, NULL, 'bidilu.kabasele@regideso.cd', NULL, '2023-09-27 15:45:30', '2023-09-27 15:45:30', NULL),
(21, 21, NULL, NULL, 'mbuyi.tshibwabwa@regideso.cd', NULL, '2023-09-27 15:51:10', '2023-09-27 15:51:10', NULL),
(22, 22, NULL, NULL, 'biuma.muula@regideso.cd', NULL, '2023-09-27 15:52:39', '2023-09-27 15:52:39', NULL),
(23, 23, NULL, NULL, 'maroy.zawadi@regideso.cd', NULL, '2023-09-27 15:55:34', '2023-09-27 15:55:34', NULL),
(24, 24, NULL, NULL, 'kisyaba.bisibo@regideso.cd', NULL, '2023-09-27 15:56:49', '2023-09-27 15:56:49', NULL),
(25, 25, NULL, NULL, 'koy.mubiala@regideso.cd', NULL, '2023-09-27 15:58:36', '2023-09-27 15:58:36', NULL),
(26, 26, NULL, NULL, 'tshilanda.lonengo@regideso.cd', NULL, '2023-09-27 16:00:20', '2023-09-27 16:00:20', NULL),
(27, 27, NULL, NULL, 'kayowa.tshitoko@regideso.cd', NULL, '2023-09-27 16:02:21', '2023-09-27 16:02:21', NULL),
(28, 28, NULL, NULL, 'mokonda.imemenge@regideso.cd', NULL, '2023-09-27 16:03:25', '2023-09-27 16:03:25', NULL),
(29, 29, NULL, NULL, 'mangapi.lule@regideso.cd', NULL, '2023-09-27 16:06:33', '2023-09-27 16:06:33', NULL),
(30, 30, NULL, NULL, 'tshama.tanga@regideso.cd', NULL, '2023-09-27 16:10:46', '2023-09-27 16:10:46', NULL),
(31, 31, NULL, NULL, 'kabiswe.wetchi@regideso.cd', NULL, '2023-09-27 16:31:21', '2023-09-27 16:31:21', NULL),
(32, 33, NULL, NULL, 'mashaka.letisha@regideso.cd', NULL, '2023-09-27 16:38:47', '2023-09-27 16:38:47', NULL),
(33, 34, NULL, NULL, 'mujinga.mubiayi@regideso.cd', NULL, '2023-09-27 16:44:31', '2023-09-27 16:44:31', NULL),
(34, 35, NULL, NULL, 'lulua.muamba@regideso.cd', NULL, '2023-09-28 12:04:42', '2023-09-28 12:04:42', NULL),
(35, 32, NULL, NULL, NULL, NULL, '2023-09-28 12:17:11', '2023-09-28 12:17:11', NULL),
(36, 36, NULL, NULL, 'matundu.mpaka@regideso.cd', NULL, '2023-09-28 15:48:47', '2023-09-28 15:48:47', NULL),
(37, 37, NULL, NULL, 'bakajika.sombamanya@regideso.cd', NULL, '2023-09-28 15:55:20', '2023-09-28 15:55:20', NULL),
(38, 38, NULL, NULL, 'kabeya.ngandu@regideso.cd', NULL, '2023-09-28 15:58:12', '2023-09-28 15:58:12', NULL),
(39, 39, NULL, NULL, 'kuta.bonda@regideso.cd', NULL, '2023-09-28 16:01:20', '2023-09-28 16:01:20', NULL),
(40, 40, NULL, NULL, 'asani.wamilabyo@regideso.cd', NULL, '2023-09-28 16:07:09', '2023-09-28 16:07:09', NULL),
(41, 41, NULL, NULL, 'mbudi.lelo@regideso.cd', NULL, '2023-09-28 16:13:22', '2023-09-28 16:13:22', NULL),
(42, 42, NULL, NULL, 'angoyo.rutia@regideso.cd', NULL, '2023-09-28 16:16:32', '2023-09-28 16:16:32', NULL),
(43, 43, NULL, NULL, 'ilunga.kabulo@regideso.cd', NULL, '2023-09-28 16:21:29', '2023-09-28 16:21:29', NULL),
(44, 44, NULL, NULL, 'tshijik.kapwepu@regideso.cd', NULL, '2023-09-28 16:34:48', '2023-09-28 16:34:48', NULL),
(45, 45, NULL, NULL, 'mukindji.museu@regideso.cd', NULL, '2023-09-28 16:37:11', '2023-09-28 16:37:11', NULL),
(46, 46, NULL, NULL, 'lukeka.luenga@regideso.cd', NULL, '2023-09-28 16:41:09', '2023-09-28 16:41:09', NULL),
(47, 47, NULL, NULL, 'mapwata.drago@regideso.cd', NULL, '2023-09-28 16:43:12', '2023-09-28 16:43:12', NULL),
(48, 48, NULL, NULL, 'bosenge.banyangola@regideso.cd', NULL, '2023-09-29 10:05:57', '2023-09-29 10:05:57', NULL),
(49, 49, NULL, NULL, 'kapeta.mulanga@regideso.cd', NULL, '2023-09-29 10:43:57', '2023-09-29 10:43:57', NULL),
(50, 50, NULL, NULL, 'muingi.nzita@regideso.cd', NULL, '2023-09-29 11:23:21', '2023-09-29 11:23:21', NULL),
(51, 51, NULL, NULL, 'baguma.chanisa@regideso.cd', NULL, '2023-09-29 11:29:40', '2023-09-29 11:29:40', NULL),
(52, 52, NULL, NULL, 'unyunda.salumu@regideso.cd', NULL, '2023-09-29 11:42:39', '2023-09-29 11:42:39', NULL),
(53, 53, NULL, NULL, 'doli.sokosi@regideso.cd', NULL, '2023-09-29 11:46:00', '2023-09-29 11:46:00', NULL),
(54, 3879, NULL, NULL, NULL, NULL, '2023-10-11 07:12:43', '2023-10-11 07:12:43', NULL),
(55, 3722, NULL, NULL, NULL, NULL, '2023-10-11 14:03:55', '2023-10-11 14:03:55', NULL),
(56, 4074, NULL, NULL, NULL, NULL, '2023-10-11 14:12:51', '2023-10-11 14:12:51', NULL),
(57, 3723, NULL, NULL, NULL, NULL, '2023-10-11 14:19:14', '2023-10-11 14:19:14', NULL),
(58, 3870, NULL, NULL, NULL, NULL, '2023-10-16 10:17:37', '2023-10-16 10:17:37', NULL),
(59, 4071, NULL, NULL, NULL, NULL, '2023-10-19 14:03:57', '2023-10-19 14:03:57', NULL),
(60, 4070, NULL, NULL, NULL, NULL, '2023-10-25 12:03:16', '2023-10-25 12:03:16', NULL),
(61, 3862, NULL, NULL, NULL, NULL, '2023-10-25 12:27:00', '2023-10-25 12:27:00', NULL),
(62, 2687, NULL, NULL, NULL, NULL, '2023-10-25 12:28:34', '2023-10-25 12:28:34', NULL),
(63, 4041, NULL, NULL, NULL, NULL, '2023-10-25 17:54:38', '2023-10-25 17:54:38', NULL),
(64, 4059, NULL, NULL, NULL, NULL, '2023-10-25 17:55:48', '2023-10-25 17:55:48', NULL),
(65, 4078, NULL, NULL, NULL, NULL, '2023-10-25 18:01:40', '2023-10-25 18:01:40', NULL),
(66, 4083, NULL, NULL, NULL, NULL, '2023-10-25 18:02:43', '2023-10-25 18:02:43', NULL),
(67, 4091, NULL, NULL, NULL, NULL, '2023-10-25 18:04:10', '2023-10-25 18:04:10', NULL),
(68, 4032, NULL, NULL, NULL, NULL, '2023-10-25 18:08:40', '2023-10-25 18:08:40', NULL),
(69, 3997, NULL, NULL, NULL, NULL, '2023-10-25 18:10:38', '2023-10-25 18:10:38', NULL),
(70, 4049, NULL, NULL, NULL, NULL, '2023-10-25 18:12:54', '2023-10-25 18:12:54', NULL),
(71, 4061, NULL, NULL, NULL, NULL, '2023-10-25 18:15:37', '2023-10-25 18:15:37', NULL),
(72, 3991, NULL, NULL, NULL, NULL, '2023-10-25 18:17:53', '2023-10-25 18:17:53', NULL),
(73, 3992, NULL, NULL, NULL, NULL, '2023-10-25 18:18:54', '2023-10-25 18:18:54', NULL),
(74, 4093, NULL, NULL, NULL, NULL, '2023-10-25 18:21:18', '2023-10-25 18:21:18', NULL),
(75, 3872, NULL, NULL, NULL, NULL, '2023-10-27 12:02:39', '2023-10-27 12:02:39', NULL),
(76, 3579, NULL, NULL, NULL, NULL, '2023-10-31 17:01:39', '2023-10-31 17:01:39', NULL),
(77, 3721, NULL, NULL, NULL, NULL, '2023-11-01 07:26:25', '2023-11-01 07:26:25', NULL),
(78, 3909, NULL, NULL, NULL, NULL, '2023-11-01 07:51:19', '2023-11-01 07:51:19', NULL),
(79, 4072, NULL, NULL, NULL, NULL, '2023-11-01 14:26:01', '2023-11-01 14:26:01', NULL),
(80, 3877, NULL, NULL, NULL, NULL, '2023-11-01 14:37:07', '2023-11-01 14:37:07', NULL),
(81, 3729, NULL, NULL, NULL, NULL, '2023-11-02 08:03:13', '2023-11-02 08:03:13', NULL),
(82, 3867, NULL, NULL, NULL, NULL, '2023-11-03 13:26:57', '2023-11-03 13:26:57', NULL),
(83, 3871, NULL, NULL, NULL, NULL, '2023-11-03 13:28:49', '2023-11-03 13:28:49', NULL),
(84, 4082, NULL, NULL, NULL, NULL, '2023-11-15 12:40:05', '2023-11-15 12:40:05', NULL),
(85, 4085, NULL, NULL, NULL, NULL, '2023-11-15 12:41:57', '2023-11-15 12:41:57', NULL),
(86, 4076, NULL, NULL, NULL, NULL, '2023-11-15 12:47:26', '2023-11-15 12:47:26', NULL),
(87, 4073, NULL, NULL, NULL, NULL, '2023-11-15 12:57:08', '2023-11-15 12:57:08', NULL),
(88, 3868, NULL, NULL, NULL, NULL, '2023-11-15 13:02:33', '2023-11-15 13:02:33', NULL),
(89, 4086, NULL, NULL, NULL, NULL, '2023-11-15 13:09:37', '2023-11-15 13:09:37', NULL),
(90, 4081, NULL, NULL, NULL, NULL, '2023-11-15 13:13:26', '2023-11-15 13:13:26', NULL),
(91, 3900, NULL, NULL, NULL, NULL, '2023-11-15 13:16:33', '2023-11-15 13:16:33', NULL),
(92, 3899, NULL, NULL, NULL, NULL, '2023-11-15 13:20:32', '2023-11-15 13:20:32', NULL),
(93, 3904, NULL, NULL, NULL, NULL, '2023-11-15 13:26:11', '2023-11-15 13:26:11', NULL),
(94, 3905, NULL, NULL, NULL, NULL, '2023-11-15 13:27:37', '2023-11-15 13:27:37', NULL),
(95, 3892, NULL, NULL, NULL, NULL, '2023-11-15 13:32:57', '2023-11-15 13:32:57', NULL),
(96, 3816, NULL, NULL, NULL, NULL, '2023-11-15 13:45:31', '2023-11-15 13:45:31', NULL),
(97, 3860, NULL, NULL, NULL, NULL, '2023-11-15 13:49:13', '2023-11-15 13:49:13', NULL),
(98, 3813, NULL, NULL, NULL, NULL, '2023-11-15 13:53:38', '2023-11-15 13:53:38', NULL),
(99, 3823, NULL, NULL, NULL, NULL, '2023-11-15 14:34:45', '2023-11-15 14:34:45', NULL),
(100, 3826, NULL, NULL, NULL, NULL, '2023-11-15 14:35:48', '2023-11-15 14:35:48', NULL),
(101, 3828, NULL, NULL, NULL, NULL, '2023-11-15 14:37:18', '2023-11-15 14:37:18', NULL),
(102, 3811, NULL, NULL, NULL, NULL, '2023-11-15 14:39:43', '2023-11-15 14:39:43', NULL),
(103, 3820, NULL, NULL, NULL, NULL, '2023-11-15 14:41:52', '2023-11-15 14:41:52', NULL),
(104, 3806, NULL, NULL, NULL, NULL, '2023-11-21 11:00:34', '2023-11-21 11:00:34', NULL),
(105, 4047, NULL, NULL, NULL, NULL, '2023-11-21 11:05:26', '2023-11-21 11:05:26', NULL),
(106, 3808, NULL, NULL, NULL, NULL, '2023-11-21 11:06:51', '2023-11-21 11:06:51', NULL),
(107, 3802, NULL, NULL, NULL, NULL, '2023-11-21 11:16:25', '2023-11-21 11:16:25', NULL),
(108, 3805, NULL, NULL, NULL, NULL, '2023-11-21 11:20:50', '2023-11-21 11:20:50', NULL),
(109, 330, NULL, NULL, NULL, NULL, '2023-11-21 11:25:06', '2023-11-21 11:25:06', NULL),
(110, 4054, NULL, NULL, NULL, NULL, '2023-11-21 11:26:52', '2023-11-21 11:26:52', NULL),
(111, 3931, NULL, NULL, NULL, NULL, '2023-11-21 11:36:14', '2023-11-21 11:36:14', NULL),
(112, 3789, NULL, NULL, NULL, NULL, '2023-11-21 11:46:04', '2023-11-21 11:46:04', NULL),
(113, 3782, NULL, NULL, NULL, NULL, '2023-11-21 11:49:28', '2023-11-21 11:49:28', NULL),
(114, 4040, NULL, NULL, NULL, NULL, '2023-11-21 11:52:14', '2023-11-21 11:52:14', NULL),
(115, 3795, NULL, NULL, NULL, NULL, '2023-11-21 11:54:24', '2023-11-21 11:54:24', NULL),
(116, 3791, NULL, NULL, NULL, NULL, '2023-11-21 11:57:07', '2023-11-21 11:57:07', NULL),
(117, 3793, NULL, NULL, NULL, NULL, '2023-11-21 11:58:39', '2023-11-21 11:58:39', NULL),
(118, 4043, NULL, NULL, NULL, NULL, '2023-11-21 12:00:24', '2023-11-21 12:00:24', NULL),
(119, 3799, NULL, NULL, NULL, NULL, '2023-11-21 12:04:14', '2023-11-21 12:04:14', NULL),
(120, 3796, NULL, NULL, NULL, NULL, '2023-11-21 12:07:14', '2023-11-21 12:07:14', NULL),
(121, 3798, NULL, NULL, NULL, NULL, '2023-11-21 12:14:00', '2023-11-21 12:14:00', NULL),
(122, 4045, NULL, NULL, NULL, NULL, '2023-11-21 12:16:03', '2023-11-21 12:16:03', NULL),
(123, 3779, NULL, NULL, NULL, NULL, '2023-11-21 12:18:08', '2023-11-21 12:18:08', NULL),
(124, 3781, NULL, NULL, NULL, NULL, '2023-11-21 12:19:38', '2023-11-21 12:19:38', NULL),
(125, 3770, NULL, NULL, NULL, NULL, '2023-11-21 12:23:30', '2023-11-21 12:23:30', NULL),
(126, 3772, NULL, NULL, NULL, NULL, '2023-11-21 12:27:37', '2023-11-21 12:27:37', NULL),
(127, 3778, NULL, NULL, NULL, NULL, '2023-11-21 12:30:45', '2023-11-21 12:30:45', NULL),
(128, 3780, NULL, NULL, NULL, NULL, '2023-11-21 13:10:02', '2023-11-21 13:10:02', NULL),
(129, 3792, NULL, NULL, NULL, NULL, '2023-11-21 13:11:30', '2023-11-21 13:11:30', NULL),
(130, 3773, NULL, NULL, NULL, NULL, '2023-11-21 13:14:07', '2023-11-21 13:14:07', NULL),
(131, 3786, NULL, NULL, NULL, NULL, '2023-11-21 13:16:17', '2023-11-21 13:16:17', NULL),
(132, 3787, NULL, NULL, NULL, NULL, '2023-11-21 13:19:52', '2023-11-21 13:19:52', NULL),
(133, 3775, NULL, NULL, NULL, NULL, '2023-11-21 13:21:04', '2023-11-21 13:21:04', NULL),
(134, 3523, NULL, NULL, NULL, NULL, '2023-11-21 13:25:21', '2023-11-21 13:25:21', NULL),
(135, 3524, NULL, NULL, NULL, NULL, '2023-11-21 13:26:37', '2023-11-21 13:26:37', NULL),
(136, 3525, NULL, NULL, NULL, NULL, '2023-11-21 13:27:45', '2023-11-21 13:27:45', NULL),
(137, 3771, NULL, NULL, NULL, NULL, '2023-11-21 13:29:10', '2023-11-21 13:29:10', NULL),
(138, 3774, NULL, NULL, NULL, NULL, '2023-11-21 13:31:32', '2023-11-21 13:31:32', NULL),
(139, 3785, NULL, NULL, NULL, NULL, '2023-11-21 13:33:14', '2023-11-21 13:33:14', NULL),
(140, 4079, NULL, NULL, NULL, NULL, '2023-11-21 13:36:41', '2023-11-21 13:36:41', NULL),
(141, 3889, NULL, NULL, NULL, NULL, '2023-11-21 13:38:19', '2023-11-21 13:38:19', NULL),
(142, 3830, NULL, NULL, NULL, NULL, '2023-11-21 13:45:19', '2023-11-21 13:45:19', NULL),
(143, 3887, NULL, NULL, NULL, NULL, '2023-11-21 13:46:34', '2023-11-21 13:46:34', NULL),
(144, 3923, NULL, NULL, NULL, NULL, '2023-11-21 13:47:45', '2023-11-21 13:47:45', NULL),
(145, 3895, NULL, NULL, NULL, NULL, '2023-11-21 13:49:03', '2023-11-21 13:49:03', NULL),
(146, 3888, NULL, NULL, NULL, NULL, '2023-11-21 13:50:27', '2023-11-21 13:50:27', NULL),
(147, 3874, NULL, NULL, NULL, NULL, '2023-11-21 13:52:42', '2023-11-21 13:52:42', NULL),
(148, 3876, NULL, NULL, NULL, NULL, '2023-11-21 13:54:31', '2023-11-21 13:54:31', NULL),
(149, 3941, NULL, NULL, NULL, NULL, '2023-11-21 13:56:58', '2023-11-21 13:56:58', NULL),
(150, 3943, NULL, NULL, NULL, NULL, '2023-11-21 13:58:28', '2023-11-21 13:58:28', NULL),
(151, 3940, NULL, NULL, NULL, NULL, '2023-11-21 13:59:23', '2023-11-21 13:59:23', NULL),
(152, 3942, NULL, NULL, NULL, NULL, '2023-11-21 14:00:17', '2023-11-21 14:00:17', NULL),
(153, 3859, NULL, NULL, NULL, NULL, '2023-11-21 14:03:05', '2023-11-21 14:03:05', NULL),
(154, 3854, NULL, NULL, NULL, NULL, '2023-11-21 14:06:04', '2023-11-21 14:06:04', NULL),
(155, 3881, NULL, NULL, NULL, NULL, '2023-11-21 14:07:10', '2023-11-21 14:07:10', NULL),
(156, 3869, NULL, NULL, NULL, NULL, '2023-11-21 14:08:38', '2023-11-21 14:08:38', NULL),
(157, 3873, NULL, NULL, NULL, NULL, '2023-11-21 14:10:57', '2023-11-21 14:10:57', NULL),
(158, 3864, NULL, NULL, NULL, NULL, '2023-11-21 14:13:47', '2023-11-21 14:13:47', NULL),
(159, 3883, NULL, NULL, NULL, NULL, '2023-11-21 14:16:45', '2023-11-21 14:16:45', NULL),
(160, 3882, NULL, NULL, NULL, NULL, '2023-11-21 14:18:35', '2023-11-21 14:18:35', NULL),
(161, 3875, NULL, NULL, NULL, NULL, '2023-11-21 14:19:37', '2023-11-21 14:19:37', NULL),
(162, 3745, NULL, NULL, NULL, NULL, '2023-11-21 14:20:39', '2023-11-21 14:20:39', NULL),
(163, 3945, NULL, NULL, NULL, NULL, '2023-11-21 14:22:34', '2023-11-21 14:22:34', NULL),
(164, 3947, NULL, NULL, NULL, NULL, '2023-11-21 14:23:13', '2023-11-21 14:23:13', NULL),
(165, 3944, NULL, NULL, NULL, NULL, '2023-11-21 14:23:55', '2023-11-21 14:23:55', NULL),
(166, 3946, NULL, NULL, NULL, NULL, '2023-11-21 14:25:01', '2023-11-21 14:25:01', NULL),
(167, 3884, NULL, NULL, NULL, NULL, '2023-11-21 14:25:52', '2023-11-21 14:25:52', NULL),
(168, 3851, NULL, NULL, NULL, NULL, '2023-11-21 14:27:33', '2023-11-21 14:27:33', NULL),
(169, 3553, NULL, NULL, NULL, NULL, '2023-11-21 14:28:56', '2023-11-21 14:28:56', NULL),
(170, 3617, NULL, NULL, NULL, NULL, '2023-11-21 14:30:25', '2023-11-21 14:30:25', NULL),
(171, 3856, NULL, NULL, NULL, NULL, '2023-11-21 14:33:01', '2023-11-21 14:33:01', NULL),
(172, 3855, NULL, NULL, NULL, NULL, '2023-11-21 14:35:14', '2023-11-21 14:35:14', NULL),
(173, 3848, NULL, NULL, NULL, NULL, '2023-11-21 14:38:04', '2023-11-21 14:38:04', NULL),
(174, 3842, NULL, NULL, NULL, NULL, '2023-11-21 14:39:20', '2023-11-21 14:39:20', NULL),
(175, 3843, NULL, NULL, NULL, NULL, '2023-11-21 14:40:17', '2023-11-21 14:40:17', NULL),
(176, 3838, NULL, NULL, NULL, NULL, '2023-11-21 14:42:34', '2023-11-21 14:42:34', NULL),
(177, 3847, NULL, NULL, NULL, NULL, '2023-11-21 14:43:53', '2023-11-21 14:43:53', NULL),
(178, 3840, NULL, NULL, NULL, NULL, '2023-11-21 14:46:20', '2023-11-21 14:46:20', NULL),
(179, 3834, NULL, NULL, NULL, NULL, '2023-11-21 14:47:27', '2023-11-21 14:47:27', NULL),
(180, 4062, NULL, NULL, NULL, NULL, '2023-11-21 14:50:38', '2023-11-21 14:50:38', NULL),
(181, 3846, NULL, NULL, NULL, NULL, '2023-11-21 14:52:01', '2023-11-21 14:52:01', NULL),
(182, 3844, NULL, NULL, NULL, NULL, '2023-11-21 14:54:22', '2023-11-21 14:54:22', NULL),
(183, 3863, NULL, NULL, NULL, NULL, '2023-11-21 15:00:13', '2023-11-21 15:00:13', NULL),
(184, 3837, NULL, NULL, NULL, NULL, '2023-11-21 15:00:51', '2023-11-21 15:00:51', NULL),
(185, 3753, NULL, NULL, NULL, NULL, '2023-11-21 15:01:36', '2023-11-21 15:01:36', NULL),
(186, 3732, NULL, NULL, NULL, NULL, '2023-11-21 15:03:28', '2023-11-21 15:03:28', NULL),
(187, 3736, NULL, NULL, NULL, NULL, '2023-11-21 15:04:12', '2023-11-21 15:04:12', NULL),
(188, 3731, NULL, NULL, NULL, NULL, '2023-11-21 15:05:33', '2023-11-21 15:05:33', NULL),
(189, 3852, NULL, NULL, NULL, NULL, '2023-11-21 15:06:34', '2023-11-21 15:06:34', NULL),
(190, 3573, NULL, NULL, NULL, NULL, '2023-11-21 15:07:14', '2023-11-21 15:07:14', NULL),
(191, 4038, NULL, NULL, NULL, NULL, '2023-11-21 15:12:04', '2023-11-21 15:12:04', NULL),
(192, 4037, NULL, NULL, NULL, NULL, '2023-11-21 15:33:17', '2023-11-21 15:33:17', NULL),
(193, 3866, NULL, NULL, NULL, NULL, '2023-11-21 15:34:55', '2023-11-21 15:34:55', NULL),
(194, 3920, NULL, NULL, NULL, NULL, '2023-11-21 15:36:38', '2023-11-21 15:36:38', NULL),
(195, 4039, NULL, NULL, NULL, NULL, '2023-11-21 15:38:49', '2023-11-21 15:38:49', NULL),
(196, 4046, NULL, NULL, NULL, NULL, '2023-11-21 15:40:11', '2023-11-21 15:40:11', NULL),
(197, 3910, NULL, NULL, NULL, NULL, '2023-11-21 15:41:37', '2023-11-21 15:41:37', NULL),
(198, 3917, NULL, NULL, NULL, NULL, '2023-11-21 15:42:42', '2023-11-21 15:42:42', NULL),
(199, 3914, NULL, NULL, NULL, NULL, '2023-11-21 15:43:56', '2023-11-21 15:43:56', NULL),
(200, 3912, NULL, NULL, NULL, NULL, '2023-11-21 15:44:52', '2023-11-21 15:44:52', NULL),
(201, 3918, NULL, NULL, NULL, NULL, '2023-11-21 15:45:53', '2023-11-21 15:45:53', NULL),
(202, 3919, NULL, NULL, NULL, NULL, '2023-11-21 15:46:40', '2023-11-21 15:46:40', NULL),
(203, 3915, NULL, NULL, NULL, NULL, '2023-11-21 15:48:47', '2023-11-21 15:48:47', NULL),
(204, 3924, NULL, NULL, NULL, NULL, '2023-11-21 15:52:33', '2023-11-21 15:52:33', NULL),
(205, 4084, NULL, NULL, NULL, NULL, '2023-11-21 15:56:46', '2023-11-21 15:56:46', NULL),
(206, 3911, NULL, NULL, NULL, NULL, '2023-11-21 15:58:10', '2023-11-21 15:58:10', NULL),
(207, 3850, NULL, NULL, NULL, NULL, '2023-11-21 16:02:03', '2023-11-21 16:02:03', NULL),
(208, 4087, NULL, NULL, NULL, NULL, '2023-11-21 16:04:05', '2023-11-21 16:04:05', NULL),
(209, 3916, NULL, NULL, NULL, NULL, '2023-11-21 16:05:17', '2023-11-21 16:05:17', NULL),
(210, 3922, NULL, NULL, NULL, NULL, '2023-11-21 16:06:50', '2023-11-21 16:06:50', NULL),
(211, 3984, NULL, NULL, NULL, NULL, '2023-11-21 16:09:51', '2023-11-21 16:09:51', NULL),
(212, 3906, NULL, NULL, NULL, NULL, '2023-11-21 16:13:57', '2023-11-21 16:13:57', NULL),
(213, 3897, NULL, NULL, NULL, NULL, '2023-11-21 16:15:25', '2023-11-21 16:15:25', NULL),
(214, 3896, NULL, NULL, NULL, NULL, '2023-11-21 16:19:24', '2023-11-21 16:19:24', NULL),
(215, 3898, NULL, NULL, NULL, NULL, '2023-11-21 16:21:14', '2023-11-21 16:21:14', NULL),
(216, 3901, NULL, NULL, NULL, NULL, '2023-11-21 16:23:29', '2023-11-21 16:23:29', NULL),
(217, 3621, NULL, NULL, NULL, NULL, '2023-11-21 16:24:14', '2023-11-21 16:24:14', NULL),
(218, 3623, NULL, NULL, NULL, NULL, '2023-11-24 13:33:34', '2023-11-24 13:33:34', NULL),
(219, 4077, NULL, NULL, NULL, NULL, '2023-12-06 15:34:05', '2023-12-06 15:34:05', NULL),
(220, 4420, NULL, NULL, 'mwaka.indele@regideso.cd', NULL, '2023-12-06 16:46:10', '2023-12-06 16:46:10', NULL),
(221, 3719, NULL, NULL, NULL, NULL, '2023-12-07 12:17:14', '2023-12-07 12:17:14', NULL),
(222, 3993, NULL, NULL, NULL, NULL, '2023-12-07 12:20:41', '2023-12-07 12:20:41', NULL),
(223, 3726, NULL, NULL, NULL, NULL, '2023-12-13 10:55:12', '2023-12-13 10:55:12', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `lieu_id` bigint(20) DEFAULT NULL,
  `direction_id` bigint(20) DEFAULT NULL,
  `section_id` bigint(20) DEFAULT NULL,
  `grade_id` bigint(20) DEFAULT NULL,
  `statut_id` bigint(20) DEFAULT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `post_nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `lieu_naiss` varchar(200) DEFAULT NULL,
  `date_naiss` date DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `etat_civil` varchar(25) DEFAULT NULL,
  `division_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `fonction_id` bigint(20) DEFAULT NULL,
  `nbr_enfant` tinyint(4) DEFAULT NULL,
  `nationalite` varchar(100) DEFAULT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `delegue_id` int(11) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id`, `user_id`, `lieu_id`, `direction_id`, `section_id`, `grade_id`, `statut_id`, `nom`, `post_nom`, `prenom`, `sexe`, `lieu_naiss`, `date_naiss`, `province`, `ville`, `etat_civil`, `division_id`, `service_id`, `fonction_id`, `nbr_enfant`, `nationalite`, `matricule`, `image`, `slug`, `created_by`, `delegue_id`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 12, 1, 47, 1, 1, 'Kinsala', 'Kinsala', 'Herve', 'M', NULL, NULL, NULL, NULL, NULL, 1, 28, 1, NULL, NULL, '435', 'agents/June2024/RKJI0lb9CCPs8Evn45HQ.png', 'david-mutombo-tshilumba', 1, NULL, 1, '2033-11-24 08:59:43', '2024-06-11 11:59:55', NULL),
(3722, 3722, 12, 1, 0, 16, 1, 'Kabengele', 'Tala', 'Yasmine', 'F', NULL, '2023-10-19', NULL, NULL, NULL, 1, 2, 63, NULL, NULL, '2863', 'agents/May2024/alCnuKDXT8SiK691Xh8O.jpg', 'mbombo-tshitende-lydie', 1, NULL, 3879, '2033-12-05 08:59:43', '2024-05-30 10:20:35', NULL),
(3723, 3723, 12, 1, NULL, 16, 1, 'Isasi', 'Mbadu', 'Francis', 'M', NULL, '2023-10-31', NULL, NULL, NULL, 0, NULL, 57, NULL, NULL, '3465', 'agents/May2024/OwNuwMfrXQNwZEUkW4WX.jpg', 'luzolo-mbadu-martin', 1, NULL, 3879, '2033-12-06 08:59:43', '2024-05-30 10:22:16', NULL),
(4074, 4074, 12, 1, 0, 18, 1, 'Kuedisala', 'Mbongo', 'Caleb', 'M', NULL, '2023-10-25', NULL, NULL, NULL, 1, 1, 64, NULL, NULL, '2399', 'agents/May2024/C6BDfRwrFvVwTXNPoam4.jpg', 'mbulungu-mukuna-sylvestre', 1, NULL, 3879, '2034-11-22 08:59:43', '2024-05-30 10:19:23', NULL),
(4420, 4420, 12, 1, 0, 18, 1, 'Ntumba', 'Indele', 'Jeanpy', 'M', NULL, '2023-12-07', NULL, NULL, NULL, 0, 0, 126, NULL, NULL, '0000', 'agents/June2024/YelB7GHKevD899Kj9i42.jpg', 'mwaka-indele-jean-bosco', 3879, NULL, 3879, '2023-12-06 15:46:10', '2024-06-11 11:58:53', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `agent_brouillons`
--

CREATE TABLE `agent_brouillons` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `brouillon_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `agent_statuts`
--

CREATE TABLE `agent_statuts` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agent_statuts`
--

INSERT INTO `agent_statuts` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Actif', '2022-11-17 01:15:17', '2022-11-17 01:15:17', NULL),
(2, 'Inactif', '2022-11-17 01:15:17', '2022-11-17 01:15:17', NULL),
(3, 'Archivé', '2022-11-17 01:15:17', '2022-11-17 01:15:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `archive_permissions`
--

CREATE TABLE `archive_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `permissionable_id` bigint(20) DEFAULT NULL,
  `permissionable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `assistanats`
--

CREATE TABLE `assistanats` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction_id` bigint(20) DEFAULT NULL,
  `responsable_id` bigint(20) DEFAULT NULL,
  `for_dg` tinyint(1) DEFAULT '0',
  `for_dga` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assistanats`
--

INSERT INTO `assistanats` (`id`, `titre`, `direction_id`, `responsable_id`, `for_dg`, `for_dga`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Assistant DG', 1, 4074, 1, 0, '2023-10-16 08:54:54', '2023-10-17 10:10:23', NULL),
(2, 'Assistant DGA', 1, 3993, 0, 1, '2023-10-16 08:55:17', '2023-10-17 10:10:39', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `authentication_log`
--

CREATE TABLE `authentication_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `authenticatable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authenticatable_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `login_at` timestamp NULL DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `authentication_log`
--

INSERT INTO `authentication_log` (`id`, `authenticatable_type`, `authenticatable_id`, `ip_address`, `user_agent`, `login_at`, `logout_at`) VALUES
(1, 'App\\Models\\User', 3723, 'fe80::218a:af84:85c6:a454', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2024-01-09 14:06:29'),
(2, 'App\\Models\\User', 3879, 'fe80::218a:af84:85c6:a454', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', '2024-01-09 14:20:00', NULL),
(3, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 17:51:20', NULL),
(4, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 18:23:12', '2024-05-29 18:36:31'),
(5, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 18:23:38', '2024-05-29 18:41:30'),
(6, 'App\\Models\\User', 3722, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '2024-05-29 18:28:28', NULL),
(7, 'App\\Models\\User', 3722, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 18:37:55', '2024-05-29 18:39:07'),
(8, 'App\\Models\\User', 4074, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 18:39:39', NULL),
(9, 'App\\Models\\User', 4420, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 18:42:12', '2024-05-29 18:42:24'),
(10, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-29 18:42:50', NULL),
(11, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-30 10:00:48', NULL),
(12, 'App\\Models\\User', 3722, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-30 10:18:01', '2024-05-30 10:18:10'),
(13, 'App\\Models\\User', 4074, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-30 10:18:36', '2024-05-30 10:19:51'),
(14, 'App\\Models\\User', 3722, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-30 10:20:02', '2024-05-30 10:20:48'),
(15, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-30 10:21:35', NULL),
(16, 'App\\Models\\User', 3722, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '2024-05-30 11:04:01', '2024-05-30 11:07:30'),
(17, 'App\\Models\\User', 4074, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '2024-05-30 11:08:08', NULL),
(18, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-05-31 23:27:02', NULL),
(19, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-11 11:48:45', '2024-06-11 11:52:03'),
(20, 'App\\Models\\User', 4420, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-11 11:57:38', '2024-06-11 11:59:08'),
(21, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-11 11:59:17', '2024-06-11 11:59:24'),
(22, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-11 11:59:35', '2024-06-11 12:01:18'),
(23, 'App\\Models\\User', 4420, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-11 12:01:34', '2024-06-11 12:15:59'),
(24, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-11 12:17:44', NULL),
(25, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:126.0) Gecko/20100101 Firefox/126.0', '2024-06-12 13:24:01', NULL),
(26, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-20 15:05:46', '2024-06-20 15:07:10'),
(27, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-20 15:07:20', NULL),
(28, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-21 11:31:20', NULL),
(29, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-21 15:02:15', NULL),
(30, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-21 16:49:40', NULL),
(31, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-25 10:03:58', NULL),
(32, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-25 10:24:42', NULL),
(33, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-06-28 09:48:58', NULL),
(34, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-01 11:08:33', NULL),
(35, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-04 10:00:47', NULL),
(36, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-05 10:08:25', NULL),
(37, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-07 20:43:04', '2024-07-07 20:44:24'),
(38, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-07 20:44:33', NULL),
(39, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-07 21:40:02', NULL),
(40, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 09:21:09', '2024-07-08 09:29:04'),
(41, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4.1 Safari/605.1.15', '2024-07-08 09:29:25', NULL),
(42, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 09:30:44', '2024-07-08 09:38:52'),
(43, 'App\\Models\\User', 3722, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 09:36:38', NULL),
(44, 'App\\Models\\User', 4074, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 09:39:12', '2024-07-08 09:46:48'),
(45, 'App\\Models\\User', 4074, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 09:47:07', '2024-07-08 09:49:27'),
(46, 'App\\Models\\User', 3723, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 09:49:49', NULL),
(47, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:127.0) Gecko/20100101 Firefox/127.0', '2024-07-08 13:03:13', NULL),
(48, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4.1 Safari/605.1.15', '2024-07-08 13:18:39', NULL),
(49, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:129.0) Gecko/20100101 Firefox/129.0', '2024-08-14 15:15:53', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `brouillons`
--

CREATE TABLE `brouillons` (
  `id` bigint(20) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `content` text,
  `participants` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `brouillon_commentaires`
--

CREATE TABLE `brouillon_commentaires` (
  `id` bigint(20) NOT NULL,
  `message` text,
  `brouillon_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `classeurs`
--

CREATE TABLE `classeurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `direction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classeurs`
--

INSERT INTO `classeurs` (`id`, `direction_id`, `titre`, `reference`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Direction Générale', 'DIR/0001', NULL, 3723, NULL, '2024-05-29 18:25:32', '2024-05-29 18:25:32', NULL),
(2, 1, 'Tâches', 'DG', 'Ce classeur contient tous les documents liés à vos tâches', 1, 1, '2024-06-20 15:25:14', '2024-06-20 15:25:14', NULL),
(3, 1, 'Taches Direction générale', 'CL/0003', 'Ce classeur contient les documents liés aux tâches', 1, 1, '2024-06-20 15:28:04', '2024-06-20 15:28:04', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tache_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `message`, `created_at`, `updated_at`, `tache_id`, `user_id`, `statut_id`) VALUES
(1, 'Les documents ont été signés et paraphés', '2024-06-20 15:35:56', '2024-06-20 15:35:56', 2, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courriers`
--

CREATE TABLE `courriers` (
  `id` int(11) NOT NULL,
  `document_id` bigint(20) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `exped_externe` int(11) DEFAULT NULL,
  `exped_interne_id` bigint(20) DEFAULT NULL,
  `dest_externe_id` bigint(20) DEFAULT NULL,
  `dest_interne_id` bigint(20) DEFAULT NULL,
  `departement_id` bigint(20) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_traitant_id` bigint(20) DEFAULT NULL,
  `is_intern` int(11) DEFAULT '1',
  `title` text,
  `confidentiel` int(11) DEFAULT NULL,
  `reference_courrier` varchar(200) DEFAULT NULL,
  `reference_interne` varchar(200) DEFAULT NULL,
  `priorite_id` int(11) DEFAULT NULL,
  `date_du_courrier` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_arrive` timestamp NULL DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `nature_id` bigint(20) DEFAULT NULL,
  `objet` text,
  `copie` int(11) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `is_classified` int(11) DEFAULT '0',
  `traitement_id` bigint(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `statut_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `mark_as_done` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `courriers`
--

INSERT INTO `courriers` (`id`, `document_id`, `type_id`, `exped_externe`, `exped_interne_id`, `dest_externe_id`, `dest_interne_id`, `departement_id`, `service_id`, `service_traitant_id`, `is_intern`, `title`, `confidentiel`, `reference_courrier`, `reference_interne`, `priorite_id`, `date_du_courrier`, `date_arrive`, `date_fin`, `nature_id`, `objet`, `copie`, `category_id`, `is_classified`, `traitement_id`, `created_by`, `parent_id`, `statut_id`, `updated_at`, `created_at`, `mark_as_done`) VALUES
(1, 1, 1, 60, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'La cour d\'appel : Organisation, compétence, organisation et exposer la procédure et ses effets', 0, '12345', 'DG-0001-ENT', 0, '2024-05-13 23:00:00', '2024-05-28 23:00:00', NULL, 2, NULL, NULL, 2, 0, 1, 3723, NULL, 3, '2024-05-29 19:49:27', '2024-05-29 18:25:32', 1),
(2, 1, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 'La cour d\'appel : Organisation, compétence, organisation et exposer la procédure et ses effets', 0, '12345', 'DG-0002-SOR', 0, '2024-05-13 23:00:00', '2024-05-28 23:00:00', NULL, 2, NULL, NULL, 2, 0, NULL, 1, NULL, 2, '2024-05-29 19:49:27', '2024-05-29 19:49:27', NULL),
(3, 2, 1, 44, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Conditions générales des services accessibles sur la plateforme\r\nskello.io', 0, '12/10/2020', 'DG-0003-ENT', NULL, '2024-05-22 23:00:00', '2024-05-29 23:00:00', NULL, 6, NULL, NULL, 5, 0, NULL, 3723, NULL, 1, '2024-05-30 10:50:46', '2024-05-30 10:50:46', NULL),
(4, 6, 1, 61, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'FICHE D’ACCEPTATION\r\nRAPPORT D’INTERVENTION', 0, '1/03/1055', 'DG-0004-ENT', 0, '2024-07-02 23:00:00', '2024-07-04 23:00:00', NULL, 2, NULL, NULL, 5, 0, 1, 3723, NULL, 3, '2024-07-08 09:43:50', '2024-07-07 20:52:03', 1),
(5, 6, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 'FICHE D’ACCEPTATION\r\nRAPPORT D’INTERVENTION', 0, '1/03/1055', 'DG-0005-SOR', 0, '2024-07-02 23:00:00', '2024-07-04 23:00:00', NULL, 2, NULL, NULL, 5, 0, NULL, 1, NULL, 3, '2024-07-08 09:53:57', '2024-07-08 09:43:49', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courriers_annotations`
--

CREATE TABLE `courriers_annotations` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `courrier_id` bigint(20) DEFAULT NULL,
  `note` text,
  `is_done` tinyint(4) DEFAULT '0',
  `done_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courriers_annotations`
--

INSERT INTO `courriers_annotations` (`id`, `user_id`, `courrier_id`, `note`, `is_done`, `done_by`, `created_at`, `updated_at`) VALUES
(1, 4074, 1, 'RAS', 0, NULL, '2024-05-29 18:41:04', '2024-05-29 18:41:04'),
(2, 4074, 4, 'Prière de signer ce document au plus tôt. Merci !', 1, 1, '2024-07-08 09:40:15', '2024-07-08 09:43:27');

-- --------------------------------------------------------

--
-- Structure de la table `courriers_etapes`
--

CREATE TABLE `courriers_etapes` (
  `id` bigint(20) NOT NULL,
  `etape_id` bigint(20) DEFAULT NULL,
  `courrier_id` bigint(20) DEFAULT NULL,
  `view_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courriers_etapes`
--

INSERT INTO `courriers_etapes` (`id`, `etape_id`, `courrier_id`, `view_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 3722, '2024-05-29 18:25:32', '2024-05-29 18:30:48', NULL),
(2, 3, 1, 4074, '2024-05-29 18:34:23', '2024-05-29 18:40:34', NULL),
(3, 4, 1, NULL, '2024-05-29 18:41:04', '2024-05-29 18:41:04', NULL),
(4, 4, 1, NULL, '2024-05-29 19:00:52', '2024-05-29 19:00:52', NULL),
(5, 4, 1, NULL, '2024-05-29 19:06:23', '2024-05-29 19:06:23', NULL),
(6, 3, 1, NULL, '2024-05-29 19:49:26', '2024-05-29 19:49:26', NULL),
(7, 3, 2, 4074, '2024-05-29 19:49:27', '2024-05-29 19:51:55', NULL),
(8, 2, 2, NULL, '2024-05-29 19:51:55', '2024-05-29 19:51:55', NULL),
(9, 2, 3, NULL, '2024-05-30 10:50:47', '2024-05-30 10:50:47', NULL),
(10, 4, 2, NULL, '2024-06-25 12:30:28', '2024-06-25 12:30:28', NULL),
(11, 4, 2, NULL, '2024-07-04 10:02:14', '2024-07-04 10:02:14', NULL),
(12, 4, 2, NULL, '2024-07-05 10:14:48', '2024-07-05 10:14:48', NULL),
(13, 2, 4, 3722, '2024-07-07 20:52:03', '2024-07-08 09:37:32', NULL),
(14, 3, 4, 4074, '2024-07-08 09:38:37', '2024-07-08 09:39:44', NULL),
(15, 4, 4, NULL, '2024-07-08 09:40:15', '2024-07-08 09:40:15', NULL),
(16, 4, 4, NULL, '2024-07-08 09:43:06', '2024-07-08 09:43:06', NULL),
(17, 3, 4, NULL, '2024-07-08 09:43:49', '2024-07-08 09:43:49', NULL),
(18, 3, 5, 4074, '2024-07-08 09:43:49', '2024-07-08 09:46:10', NULL),
(19, 2, 5, 3722, '2024-07-08 09:46:10', '2024-07-08 09:49:04', NULL),
(20, 1, 5, 3723, '2024-07-08 09:49:04', '2024-07-08 09:53:57', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courriers_partages`
--

CREATE TABLE `courriers_partages` (
  `id` bigint(20) NOT NULL,
  `courrier_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `traitement_id` int(11) DEFAULT NULL,
  `send_by` int(11) DEFAULT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `courriers_traitements_agents`
--

CREATE TABLE `courriers_traitements_agents` (
  `id` bigint(20) NOT NULL,
  `courrier_id` bigint(20) DEFAULT NULL,
  `traitement_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courriers_traitements_agents`
--

INSERT INTO `courriers_traitements_agents` (`id`, `courrier_id`, `traitement_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 2, 1, NULL, NULL),
(7, 2, 2, NULL, NULL),
(8, 2, 3, NULL, NULL),
(9, 2, 4, NULL, NULL),
(10, 2, 5, NULL, NULL),
(11, 2, 6, NULL, NULL),
(12, 2, 7, NULL, NULL),
(13, 2, 8, NULL, NULL),
(14, 2, 9, NULL, NULL),
(15, 4, 10, NULL, NULL),
(16, 4, 11, NULL, NULL),
(17, 4, 12, NULL, NULL),
(18, 4, 13, NULL, NULL),
(19, 5, 10, NULL, NULL),
(20, 5, 11, NULL, NULL),
(21, 5, 12, NULL, NULL),
(22, 5, 13, NULL, NULL),
(23, 5, 14, NULL, NULL),
(24, 5, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courrier_categories`
--

CREATE TABLE `courrier_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `courrier_categories`
--

INSERT INTO `courrier_categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Institution Publique', NULL, NULL),
(2, 'Institution Privée', NULL, NULL),
(3, 'Entreprise Publique', NULL, NULL),
(4, 'Organisme', NULL, NULL),
(5, 'Particulier', NULL, NULL),
(6, 'Banque', '2023-09-08 11:08:47', '2023-09-08 11:08:47'),
(7, 'Cabinet Avocat', '2023-09-08 11:08:47', '2023-09-08 11:08:47'),
(8, 'Direction Regionale', '2023-09-08 11:08:47', '2023-09-08 11:08:47'),
(9, 'Ministère', '2023-09-08 11:08:47', '2023-09-08 11:08:47'),
(10, 'Université', '2023-09-08 11:08:47', '2023-09-08 11:08:47'),
(11, 'Autres', '2023-09-08 11:08:47', '2023-09-08 11:08:47');

-- --------------------------------------------------------

--
-- Structure de la table `courrier_destinateurs`
--

CREATE TABLE `courrier_destinateurs` (
  `id` int(11) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `courrier_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_destinateurs`
--

INSERT INTO `courrier_destinateurs` (`id`, `agent_id`, `courrier_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3722, 1, NULL, NULL, NULL),
(2, 3726, 1, NULL, NULL, NULL),
(3, 4074, 1, NULL, NULL, NULL),
(4, 1, 1, NULL, NULL, NULL),
(5, 1, 1, NULL, NULL, NULL),
(6, 1, 1, NULL, NULL, NULL),
(7, 3722, 2, NULL, NULL, NULL),
(8, 3726, 2, NULL, NULL, NULL),
(9, 4074, 2, NULL, NULL, NULL),
(10, 3722, 2, NULL, NULL, NULL),
(11, 3722, 3, NULL, NULL, NULL),
(12, 3726, 3, NULL, NULL, NULL),
(13, 1, 2, NULL, NULL, NULL),
(14, 1, 2, NULL, NULL, NULL),
(15, 1, 2, NULL, NULL, NULL),
(16, 3722, 4, NULL, NULL, NULL),
(17, 3726, 4, NULL, NULL, NULL),
(18, 4074, 4, NULL, NULL, NULL),
(19, 1, 4, NULL, NULL, NULL),
(20, 1, 4, NULL, NULL, NULL),
(21, 3722, 5, NULL, NULL, NULL),
(22, 3726, 5, NULL, NULL, NULL),
(23, 4074, 5, NULL, NULL, NULL),
(24, 3722, 5, NULL, NULL, NULL),
(25, 3723, 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courrier_destinateur_externes`
--

CREATE TABLE `courrier_destinateur_externes` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_destinateur_externes`
--

INSERT INTO `courrier_destinateur_externes` (`id`, `nom`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'EVOLVE', '2023-11-06 08:47:27', '2023-11-06 08:47:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courrier_expediteurs`
--

CREATE TABLE `courrier_expediteurs` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_expediteurs`
--

INSERT INTO `courrier_expediteurs` (`id`, `category_id`, `nom`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Présidence', '2023-09-08 11:00:13', '2023-09-08 11:00:13', NULL),
(2, 1, 'ANAPI', '2023-09-08 11:00:28', '2023-09-08 11:00:28', NULL),
(3, 1, 'Journal officiel', '2023-09-08 11:01:04', '2023-09-08 11:01:04', NULL),
(4, 1, 'Primature', '2023-09-08 11:01:17', '2023-09-08 11:01:17', NULL),
(5, 1, 'SENAT', '2023-09-08 11:01:29', '2023-09-08 11:01:29', NULL),
(6, 1, 'Assemblé Nationnal', '2023-09-08 11:01:59', '2023-09-08 11:01:59', NULL),
(7, 1, 'DGCMP', '2023-09-08 11:03:25', '2023-09-08 11:03:25', NULL),
(8, 1, 'Autre', '2023-09-08 11:04:00', '2023-09-08 11:04:00', NULL),
(9, 3, 'ONATRA', '2023-09-08 11:04:19', '2023-09-08 11:04:19', NULL),
(10, 3, 'SONAS', '2023-09-08 11:04:26', '2023-09-08 11:04:26', NULL),
(11, 3, 'DGRAD', '2023-09-08 11:04:35', '2023-09-08 11:04:35', NULL),
(12, 3, 'DGRK', '2023-09-08 11:04:43', '2023-09-08 11:04:43', NULL),
(13, 3, 'DGDA', '2023-09-08 11:04:50', '2023-09-08 11:04:50', NULL),
(14, 3, 'SCPT', '2023-09-08 11:05:09', '2023-09-08 11:05:09', NULL),
(15, 3, 'CNSS', '2023-09-08 11:05:17', '2023-09-08 11:05:17', NULL),
(16, 3, 'SNEL', '2023-09-08 11:05:28', '2023-09-08 11:05:28', NULL),
(17, 3, 'Autre', '2023-09-08 11:05:33', '2023-09-08 11:05:33', NULL),
(18, 10, 'UNIKIN', '2023-09-08 11:13:34', '2023-09-08 11:13:34', NULL),
(19, 10, 'UPN', '2023-09-08 11:13:41', '2023-09-08 11:13:41', NULL),
(20, 6, 'BOA', '2023-09-08 11:14:11', '2023-09-08 11:14:11', NULL),
(21, 6, 'RawBank', '2023-09-08 11:14:45', '2023-09-08 11:14:45', NULL),
(22, 6, 'TMB', '2023-09-08 11:15:05', '2023-09-08 11:15:05', NULL),
(23, 6, 'UBA', '2023-09-08 11:15:20', '2023-09-08 11:15:20', NULL),
(24, 6, 'Afriland', '2023-09-08 11:15:47', '2023-09-08 11:15:47', NULL),
(25, 6, 'Sofibanque', '2023-09-08 11:16:10', '2023-09-08 11:16:10', NULL),
(26, 6, 'BCC', '2023-09-08 11:16:51', '2023-09-08 11:16:51', NULL),
(27, 6, 'Access', '2023-09-08 11:17:18', '2023-09-08 11:17:18', NULL),
(28, 6, 'Equity BCDC', '2023-09-08 11:17:43', '2023-09-08 11:17:43', NULL),
(29, 9, 'RHE', '2023-09-08 11:18:25', '2023-09-08 11:18:25', NULL),
(30, 9, 'PORTEF', '2023-09-08 11:19:08', '2023-09-08 11:19:08', NULL),
(31, 9, 'Autres', '2023-09-08 11:19:27', '2023-09-08 11:19:27', NULL),
(32, 6, 'Autres', '2023-09-08 11:19:47', '2023-09-08 11:19:47', NULL),
(33, 10, 'Autres', '2023-09-08 11:20:07', '2023-09-08 11:20:07', NULL),
(34, 7, 'cabinet peter kazadi', '2023-09-08 13:27:22', '2023-09-08 13:27:22', NULL),
(35, 5, 'newtch', '2023-09-08 13:47:13', '2023-09-08 13:47:13', NULL),
(36, 8, 'drb', '2023-09-08 17:59:52', '2023-09-08 17:59:52', NULL),
(37, 2, 'Ministère de finance', '2023-09-13 11:15:44', '2023-09-13 11:15:44', NULL),
(38, 8, 'Drk', '2023-09-20 14:28:55', '2023-09-20 14:28:55', NULL),
(39, 8, 'db', '2023-09-20 14:35:59', '2023-09-20 14:35:59', NULL),
(40, 8, 'Direction regionale Kin', '2023-09-20 14:36:24', '2023-09-20 14:36:24', NULL),
(41, 2, 'LIQUID', '2023-09-24 10:11:20', '2023-09-24 10:11:20', NULL),
(42, 5, 'A.E', '2023-09-26 10:20:17', '2023-09-26 10:20:17', NULL),
(43, 5, 'Jasper Inc.', '2023-09-29 11:14:43', '2023-09-29 11:14:43', NULL),
(44, 5, 'Newtech', '2023-09-29 12:32:40', '2023-09-29 12:32:40', NULL),
(45, 7, 'Cabinet AE', '2023-09-29 12:47:08', '2023-09-29 12:47:08', NULL),
(46, 5, 'EVOLVE', '2023-10-11 14:20:25', '2023-10-11 14:20:25', NULL),
(47, 5, 'microsoft 365', '2023-10-19 12:45:40', '2023-10-19 12:45:40', NULL),
(48, 2, 'letsignit', '2023-10-25 07:26:59', '2023-10-25 07:26:59', NULL),
(49, 5, 'express car', '2023-10-30 12:29:04', '2023-10-30 12:29:04', NULL),
(50, 5, 'GRISDOC', '2023-10-31 06:42:49', '2023-10-31 06:42:49', NULL),
(51, 5, 'CEP-O', '2023-10-31 14:23:31', '2023-10-31 14:23:31', NULL),
(52, 11, 'rrr', '2023-11-02 07:25:23', '2023-11-02 07:25:23', NULL),
(53, 5, 'Trello', '2023-11-16 11:10:58', '2023-11-16 11:10:58', NULL),
(54, 5, 'Licence Zone', '2023-11-28 07:32:57', '2023-11-28 07:32:57', NULL),
(55, 4, 'ONU', '2023-11-29 08:54:35', '2023-11-29 08:54:35', NULL),
(56, 2, 'EVOLVE', '2023-12-06 07:49:58', '2023-12-06 07:49:58', NULL),
(57, 4, 'USAID', '2023-12-12 11:15:30', '2023-12-12 11:15:30', NULL),
(58, 8, 'DR kisangani', '2024-01-03 10:07:54', '2024-01-03 10:07:54', NULL),
(59, 16, 'Bulela', '2024-01-09 09:38:43', '2024-01-09 09:38:43', NULL),
(60, 2, 'DGRK', '2024-05-29 18:24:45', '2024-05-29 18:24:45', NULL),
(61, 5, 'Newtech Consulting', '2024-07-07 20:47:03', '2024-07-07 20:47:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courrier_followers`
--

CREATE TABLE `courrier_followers` (
  `id` bigint(20) NOT NULL,
  `courrier_id` bigint(20) DEFAULT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `courrier_natures`
--

CREATE TABLE `courrier_natures` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `modele` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_natures`
--

INSERT INTO `courrier_natures` (`id`, `titre`, `modele`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lettre ordinaire', 'template-1', '2022-11-07 21:52:27', '2022-11-07 21:52:27', NULL),
(2, 'Lettre administrative', NULL, '2022-11-07 21:52:27', '2022-11-07 21:52:27', NULL),
(3, 'Lettre amicale', NULL, '2022-11-07 21:53:55', '2022-11-07 21:53:55', NULL),
(4, 'Lettre officielle', 'template-2', '2022-11-07 21:53:55', '2022-11-07 21:53:55', NULL),
(6, 'Lettre commerciale', NULL, '2022-11-07 21:53:55', '2022-11-07 21:53:55', NULL),
(7, 'Lettre professionnelle', NULL, '2022-11-07 21:53:55', '2022-11-07 21:53:55', NULL),
(8, NULL, NULL, '2023-09-08 11:08:13', '2023-09-08 11:08:13', NULL),
(9, 'Contrat', NULL, '2023-09-29 12:47:46', '2023-09-29 12:47:46', NULL),
(10, 'Demande de service', NULL, '2023-10-31 06:43:46', '2023-10-31 06:43:46', NULL),
(11, 'Offre de service', NULL, '2023-10-31 06:44:04', '2023-10-31 06:44:04', NULL),
(12, NULL, NULL, '2023-10-31 14:22:06', '2023-10-31 14:22:06', NULL),
(13, NULL, NULL, '2023-10-31 14:22:15', '2023-10-31 14:22:15', NULL),
(14, 'Facture', NULL, '2023-11-01 07:52:55', '2023-11-01 07:52:55', NULL),
(15, 'Correspondance', NULL, '2024-01-03 10:09:00', '2024-01-03 10:09:00', NULL),
(16, NULL, NULL, '2024-01-09 09:38:32', '2024-01-09 09:38:32', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `courrier_traitements`
--

CREATE TABLE `courrier_traitements` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `note` longtext,
  `document_url` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_traitements`
--

INSERT INTO `courrier_traitements` (`id`, `agent_id`, `note`, `document_url`, `created_at`, `updated_at`) VALUES
(1, 3722, 'Document traité', NULL, '2024-05-29 18:34:23', '2024-05-29 18:34:23'),
(2, 4074, 'RAS', NULL, '2024-05-29 18:41:04', '2024-05-29 18:41:04'),
(3, 1, 'Document validé', '[{\"download_link\":\"documents\\/May2024\\/YWsILxvjyYF15NWEWqrK.pdf\",\"original_name\":\"cour_appel_1.pdf\"}]', '2024-05-29 19:00:52', '2024-05-29 19:00:52'),
(4, 1, 'Document validé', '[{\"download_link\":\"documents\\/May2024\\/ormGdulI3cvRFTgs18Gi.pdf\",\"original_name\":\"cour_appel_1.pdf\"}]', '2024-05-29 19:06:23', '2024-05-29 19:06:23'),
(5, 1, 'Document traité', NULL, '2024-05-29 19:49:26', '2024-05-29 19:49:26'),
(6, 4074, NULL, NULL, '2024-05-29 19:51:55', '2024-05-29 19:51:55'),
(7, 1, 'Document validé', '[{\"download_link\":\"documents\\/June2024\\/fevtQw7d1ID4rXDo8e8l.pdf\",\"original_name\":\"cour_appel_1.pdf\"}]', '2024-06-25 12:30:28', '2024-06-25 12:30:28'),
(8, 1, 'Document validé', '[{\"download_link\":\"documents\\/July2024\\/CULuOP0TEBQ0QKJRN8RQ.pdf\",\"original_name\":\"cour_appel_1.pdf\"}]', '2024-07-04 10:02:14', '2024-07-04 10:02:14'),
(9, 1, 'Document validé', '[{\"download_link\":\"documents\\/July2024\\/TcctX9ScJ8WkxCWMqOIA.pdf\",\"original_name\":\"cour_appel_1.pdf\"}]', '2024-07-05 10:14:48', '2024-07-05 10:14:48'),
(10, 3722, 'Document traité', NULL, '2024-07-08 09:38:37', '2024-07-08 09:38:37'),
(11, 4074, 'Prière de signer ce document au plus tôt. Merci !', NULL, '2024-07-08 09:40:15', '2024-07-08 09:40:15'),
(12, 1, 'Document validé', '[{\"download_link\":\"documents\\/July2024\\/O82AcvE5Vf64sbIDvkBr.pdf\",\"original_name\":\"Fiche d\'acceptation : Rapport d\'intervention.pdf\"}]', '2024-07-08 09:43:06', '2024-07-08 09:43:06'),
(13, 1, 'Document traité', NULL, '2024-07-08 09:43:49', '2024-07-08 09:43:49'),
(14, 4074, NULL, NULL, '2024-07-08 09:46:10', '2024-07-08 09:46:10'),
(15, 3722, 'Accusé de reception', NULL, '2024-07-08 09:49:04', '2024-07-08 09:49:04');

-- --------------------------------------------------------

--
-- Structure de la table `courrier_types`
--

CREATE TABLE `courrier_types` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_types`
--

INSERT INTO `courrier_types` (`id`, `titre`, `created_at`, `updated_at`) VALUES
(1, 'Entrant', '2022-11-10 12:36:35', '2022-11-10 12:36:35'),
(2, 'Sortant', '2022-11-10 12:36:35', '2022-11-10 12:36:35'),
(3, 'Interne', '2022-11-14 14:13:24', '2022-11-14 14:13:24');

-- --------------------------------------------------------

--
-- Structure de la table `courrier_types_traitements`
--

CREATE TABLE `courrier_types_traitements` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `courrier_types_traitements`
--

INSERT INTO `courrier_types_traitements` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Signer', '2023-09-25 09:34:09', '2023-09-24 23:00:00', NULL),
(2, 'Valider', '2022-11-14 13:22:39', '2022-11-14 13:22:39', '2023-09-24 23:00:00'),
(3, 'Assigner', '2022-11-14 13:22:39', '2022-11-14 13:22:39', NULL),
(4, 'Traiter', '2022-11-14 13:22:39', '2022-11-14 13:22:39', NULL),
(5, 'Consulter', '2022-11-14 13:34:24', '2022-11-14 13:34:24', '2023-09-25 09:35:39');

-- --------------------------------------------------------

--
-- Structure de la table `delegue_permissions`
--

CREATE TABLE `delegue_permissions` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `permission_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `directions`
--

CREATE TABLE `directions` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `description` text,
  `lieu_id` bigint(20) NOT NULL DEFAULT '12',
  `responsable_id` bigint(20) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `adjoint_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `directions`
--

INSERT INTO `directions` (`id`, `titre`, `code`, `description`, `lieu_id`, `responsable_id`, `slug`, `created_at`, `updated_at`, `deleted_at`, `adjoint_id`) VALUES
(1, 'Direction générale', 'DG', NULL, 12, 1, NULL, '2023-07-13 08:21:14', '2023-12-12 12:28:00', NULL, 4420),
(2, 'Secrétariat Général', 'SG', NULL, 12, 4032, NULL, '2023-07-13 08:55:11', '2023-10-16 10:10:34', NULL, NULL),
(3, 'Direction des Stratégies et Contrôle de Gestion', 'DSCG', NULL, 12, 4078, NULL, '2023-07-13 08:55:45', '2023-10-16 10:07:37', NULL, NULL),
(4, 'Direction de l\'audit interne et inspection', 'DAII', NULL, 12, 3997, NULL, '2023-07-13 08:56:00', '2023-10-16 09:39:19', NULL, NULL),
(5, 'Direction de la Brigade Anti-fraude', 'DBA', NULL, 12, 4093, NULL, '2023-07-13 08:56:15', '2023-10-16 09:41:59', NULL, NULL),
(6, 'Direction de l\'exploitation', 'DE', NULL, 12, 4041, NULL, '2023-07-13 08:57:40', '2023-10-16 09:20:10', NULL, NULL),
(7, 'Direction Commerciale', 'DC', NULL, 12, 4049, NULL, '2023-07-13 08:57:54', '2023-10-16 10:11:44', NULL, NULL),
(8, 'Direction des Projets et Travaux', 'DPT', NULL, 12, 4059, NULL, '2023-07-13 09:01:07', '2023-10-16 10:01:24', NULL, NULL),
(9, 'Direction des Approvisionnements et Logistique', 'DAL', NULL, 12, 4061, NULL, '2023-07-13 09:01:27', '2023-10-16 09:50:51', NULL, NULL),
(11, 'Direction Financière', 'DF', NULL, 12, 4083, NULL, '2023-07-13 09:02:35', '2023-10-16 10:09:02', NULL, NULL),
(12, 'Direction des Ressources Humaines', 'DRH', NULL, 12, 4091, NULL, '2023-07-13 09:02:56', '2023-10-16 10:05:32', NULL, NULL),
(13, 'Direction de la Digitalisation et Gestion de l\'Information', 'DDGI', NULL, 12, 4070, NULL, '2023-07-26 08:13:34', '2023-10-16 09:16:17', NULL, NULL),
(19, 'Direction Régionale de Kinshasa-Ouest', 'DRKO', NULL, 1, 114, NULL, '2023-09-28 15:13:10', '2023-11-28 15:11:28', NULL, NULL),
(20, 'Direction Régionale de Kinshasa-Est', 'DRKE', NULL, 2, 852, NULL, '2023-09-28 15:14:03', '2023-11-28 15:11:11', NULL, NULL),
(21, 'Direction Régionale de Kongo Central', 'DRKC', NULL, 3, 2117, NULL, '2023-09-28 15:15:16', '2023-10-16 10:34:46', NULL, NULL),
(22, 'Direction Régionale de la Grande Orientale', 'DRGO', NULL, 4, 3473, NULL, '2023-09-28 15:16:55', '2023-10-16 10:36:39', NULL, NULL),
(23, 'Direction Régionale du Sud-Kivu', 'DRSK', NULL, 5, 3135, NULL, '2023-09-28 15:19:27', '2023-10-16 10:45:47', NULL, NULL),
(24, 'Direction Régionale du Nord-Kivu', 'DRNK', NULL, 6, 4372, NULL, '2023-09-28 15:20:21', '2023-10-16 10:44:45', NULL, NULL),
(25, 'Direction Régionale du Grand Kasai-Oriental', 'DRGKO', NULL, 7, 2706, NULL, '2023-09-28 15:21:21', '2023-10-16 10:43:57', NULL, NULL),
(26, 'Direction Régionale du Grand Bandundu', 'DRGB', NULL, 8, 3199, NULL, '2023-09-28 15:22:08', '2023-10-16 10:41:14', NULL, NULL),
(27, 'Direction Régionale du Grand Kasai-Occident', 'DRGKOC', NULL, 9, 2799, NULL, '2023-09-28 15:23:27', '2023-10-16 10:42:46', NULL, NULL),
(28, 'Direction Régionale de Maniema', 'DRM', NULL, 10, 4419, NULL, '2023-09-28 15:25:04', '2023-10-16 10:38:12', NULL, NULL),
(29, 'Direction Régionale du Grand Katanga', 'DRGK', NULL, 11, 2635, NULL, '2023-09-28 15:28:53', '2023-10-16 10:44:27', NULL, NULL),
(30, 'Direction Régionale de l\'équateur', 'DRE', NULL, 13, 2224, NULL, '2023-09-28 15:34:51', '2023-10-16 10:35:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `direction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `responsable_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `divisions`
--

INSERT INTO `divisions` (`id`, `libelle`, `description`, `created_at`, `updated_at`, `direction_id`, `responsable_id`, `statut_id`) VALUES
(1, 'Direction générale', NULL, '2023-07-13 08:25:29', '2023-11-28 14:57:16', 1, '1', 1),
(2, 'Division Juridique et Assurances', NULL, '2023-07-14 04:39:14', '2023-07-14 04:39:14', 2, NULL, 1),
(3, 'Division communication', NULL, '2023-07-14 04:40:03', '2023-11-28 15:01:24', 2, '4031', 1),
(4, 'Division Etudes et Stratégies', NULL, '2023-07-14 04:41:52', '2023-11-28 15:00:17', 3, '4077', 1),
(5, 'Division Contrôle de Gestion', NULL, '2023-07-15 14:07:50', '2023-07-15 14:07:50', 3, NULL, 1),
(6, 'Corps de l\'Audit Interne', NULL, '2023-07-15 14:15:05', '2023-11-28 15:07:48', 4, '3996', 1),
(7, 'Corps de l\'Inspection', NULL, '2023-07-15 14:15:31', '2023-11-28 15:08:26', 4, '4020', 1),
(8, 'Division sécurité et prévoyance', NULL, '2023-07-15 14:19:06', '2023-07-15 14:19:06', 4, NULL, 1),
(9, 'Division BAF DRK EST', NULL, '2023-07-15 14:22:26', '2023-11-28 15:04:10', 5, '374', 1),
(10, 'Division BAF DRK OUEST', NULL, '2023-07-15 14:26:02', '2023-11-28 15:04:34', 5, '4092', 1),
(11, 'Service Courrier', NULL, '2023-07-15 14:30:16', '2023-11-28 14:56:30', 1, '3723', 1),
(12, 'Division Technique', NULL, '2023-07-15 14:41:03', '2023-11-28 14:48:56', 6, '4044', 1),
(13, 'Division Production', NULL, '2023-07-15 14:49:14', '2023-07-15 14:49:14', 6, NULL, 1),
(14, 'Division Distribution', NULL, '2023-07-15 14:55:50', '2023-11-28 14:47:08', 6, '1637', 1),
(15, 'Division de l\'Audit Interne et Inspection', NULL, '2023-07-15 15:00:51', '2023-07-15 15:00:51', 4, NULL, 1),
(16, 'Divison de la Brigade Anti-fraude', NULL, '2023-07-15 15:04:19', '2023-07-15 15:04:19', 5, NULL, 1),
(17, 'Division de l\'Exploitation', NULL, '2023-07-15 15:06:50', '2023-11-28 14:50:07', 6, '3989', 1),
(18, 'Division Admin. Pers, Rénum. et Content', NULL, '2023-07-22 10:50:58', '2023-11-28 14:38:43', 12, '4088', 1),
(19, 'Division Formation et Dévelop. du Capital Humain', NULL, '2023-07-22 11:12:06', '2023-11-28 14:40:46', 12, '4098', 1),
(20, 'Division Centres Medicaux REGIDESO', NULL, '2023-07-22 11:34:56', '2023-11-28 14:39:41', 12, '4094', 1),
(21, 'Division Facturation et Clientèle', NULL, '2023-07-22 12:49:27', '2023-11-28 14:54:20', 7, '4048', 1),
(22, 'Division Recouvrement et Contentieux', NULL, '2023-07-22 12:56:41', '2023-11-28 14:53:08', 7, '4052', 1),
(23, 'Division Planification et Gestion des Projets', NULL, '2023-07-24 08:51:42', '2023-11-28 14:44:50', 8, '4058', 1),
(24, 'Division des Travaux', NULL, '2023-07-24 09:35:09', '2023-11-28 14:46:15', 8, '4060', 1),
(25, 'Division Ingénierie', NULL, '2023-07-24 09:49:45', '2023-07-24 09:49:45', 8, NULL, 1),
(26, 'Division Logistique', NULL, '2023-07-24 10:29:33', '2023-11-28 15:06:10', 9, '4069', 1),
(27, 'Division des Approvisionnements', NULL, '2023-07-24 10:37:30', '2023-11-28 15:05:30', 9, '4064', 1),
(28, 'Division Infrastructure et Réseaux Informatiques', NULL, '2023-07-26 08:19:55', '2023-07-26 08:19:55', 13, NULL, 1),
(29, 'Division Développement Digital', NULL, '2023-07-26 08:30:51', '2023-07-26 08:30:51', 13, NULL, 1),
(30, 'Division Comptabilité', NULL, '2023-07-26 08:36:29', '2023-11-28 14:43:50', 11, '4085', 1),
(31, 'Division de Trésorerie', NULL, '2023-07-26 09:07:14', '2023-11-28 12:23:24', 11, '4082', 1),
(32, 'Division Budget', NULL, '2023-07-26 09:14:25', '2023-11-28 14:35:49', 11, '4076', 1),
(33, 'Division Centres Secondaires', NULL, '2023-11-21 15:10:37', '2023-11-21 15:10:37', 6, '4038', 1);

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dossier_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` bigint(20) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidentiel` tinyint(3) UNSIGNED DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`id`, `dossier_id`, `category_id`, `reference`, `libelle`, `type`, `description`, `document`, `confidentiel`, `password`, `user_id`, `statut_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, '12345', 'La cour d\'appel : Organisation, compétence, organisation et exposer la procédure et ses effets', 1, NULL, '[{\"download_link\":\"documents\\/May2024\\/42AYLHZf4zlW2vIlFZPe.pdf\",\"original_name\":\"cour_appel_1.pdf\"}]', 0, NULL, 3723, 6, 3723, '2024-05-29 18:25:32', '2024-05-29 19:00:52', NULL),
(2, 1, 5, '12/10/2020', 'Conditions générales des services accessibles sur la plateforme\r\nskello.io', 1, NULL, '[{\"download_link\":\"documents\\/May2024\\/zFu99N3rXaFTaqA3Q3P0.pdf\",\"original_name\":\"CG-Skello.pdf\"}]', 0, NULL, 3723, 1, 3723, '2024-05-30 10:50:46', '2024-05-30 10:50:46', NULL),
(3, 2, 6, 'DT/435', '230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1)', 3, NULL, '[{\"download_link\":\"documents\\/June2024\\/OOsUHQlPk8uDQtF13aws.pdf\",\"original_name\":\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1).pdf\"}]', 0, NULL, 1, 1, 1, '2024-06-20 15:25:14', '2024-06-20 15:25:14', NULL),
(4, 3, 6, 'DT/0004', '230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V', 3, NULL, '[{\"download_link\":\"documents\\/June2024\\/amCm6DRtrhJvSAO2dZm8.pdf\",\"original_name\":\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1).pdf\"}]', 0, NULL, 1, 1, 1, '2024-06-20 15:28:04', '2024-06-20 15:28:04', NULL),
(5, 3, 6, 'DT/0005', '230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V', 3, NULL, '[{\"download_link\":\"documents\\/June2024\\/VEE9IGjhZ1WcY0J2c3WM.pdf\",\"original_name\":\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1).pdf\"}]', 0, NULL, 1, 1, 1, '2024-06-20 15:34:43', '2024-06-20 15:34:43', NULL),
(6, 1, 5, '1/03/1055', 'FICHE D’ACCEPTATION\r\nRAPPORT D’INTERVENTION', 1, NULL, '[{\"download_link\":\"documents\\/July2024\\/WCafcZGQWbMHhHrgjMFu.pdf\",\"original_name\":\"Fiche d\'acceptation : Rapport d\'intervention.pdf\"}]', 0, NULL, 3723, 6, 3723, '2024-07-07 20:52:03', '2024-07-08 09:43:06', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `document_followers`
--

CREATE TABLE `document_followers` (
  `id` bigint(20) NOT NULL,
  `document_id` bigint(20) DEFAULT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `traitement_id` int(11) DEFAULT NULL,
  `send_by` int(11) DEFAULT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `document_followers`
--

INSERT INTO `document_followers` (`id`, `document_id`, `agent_id`, `traitement_id`, `send_by`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 4420, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 5, 4420, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 5, 3722, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `document_natures`
--

CREATE TABLE `document_natures` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `document_natures`
--

INSERT INTO `document_natures` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lettre ordinaire', '2022-11-07 22:52:27', '2022-11-07 22:52:27', NULL),
(2, 'Lettre administrative', '2022-11-07 22:52:27', '2022-11-07 22:52:27', NULL),
(3, 'Lettre amicale', '2022-11-07 22:53:55', '2022-11-07 22:53:55', NULL),
(4, 'Lettre officielle', '2022-11-07 22:53:55', '2022-11-07 22:53:55', NULL),
(5, 'Lettre administrative', '2022-11-07 22:53:55', '2022-11-07 22:53:55', NULL),
(6, 'Lettre commerciale', '2022-11-07 22:53:55', '2022-11-07 22:53:55', NULL),
(7, 'Lettre professionnelle', '2022-11-07 22:53:55', '2022-11-07 22:53:55', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `document_notes`
--

CREATE TABLE `document_notes` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document_statuts`
--

CREATE TABLE `document_statuts` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `document_statuts`
--

INSERT INTO `document_statuts` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'En attente de traitement', '2022-11-16 14:51:46', '2022-11-16 14:51:46', NULL),
(2, 'En cours de traitement', '2022-11-16 14:51:46', '2022-11-16 14:51:46', NULL),
(3, 'Bloqué', '2022-11-16 14:51:46', '2022-11-16 14:51:46', NULL),
(4, 'Réjéter', '2022-11-16 14:51:46', '2022-11-16 14:51:46', NULL),
(5, 'Traité', '2022-11-16 14:51:46', '2022-11-16 14:51:46', NULL),
(6, 'Archivé', '2022-11-16 14:51:46', '2022-11-16 14:51:46', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `document_templates`
--

CREATE TABLE `document_templates` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `modele` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `document_templates`
--

INSERT INTO `document_templates` (`id`, `titre`, `modele`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lettre officielle', 'template-2', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL),
(2, 'Bon de Commande', 'template-3', '2023-09-06 08:50:29', '2023-09-05 22:00:00', NULL),
(3, 'Demande Achat', 'template-4', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL),
(4, 'Lettre Interne', 'template-1', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL),
(5, 'Note Circulaire', 'template-5', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL),
(6, 'Message Email', 'template-6', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL),
(7, 'Ordre de Mission', 'template-7', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL),
(8, 'Note de Service', 'template-8', '2023-09-06 08:48:43', '2023-09-06 08:48:43', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `document_types`
--

INSERT INTO `document_types` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Entrant', '2022-11-10 12:36:35', '2022-11-10 12:36:35', NULL),
(2, 'Sortant', '2022-11-10 12:36:35', '2022-11-10 12:36:35', NULL),
(3, 'Interne', '2022-11-14 14:13:24', '2022-11-14 14:13:24', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dossiers`
--

CREATE TABLE `dossiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `classeur_id` bigint(20) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `confidentiel` int(11) DEFAULT '0',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dossiers`
--

INSERT INTO `dossiers` (`id`, `classeur_id`, `reference`, `titre`, `description`, `confidentiel`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'DIR/0002', 'Courriers', NULL, 0, 3723, 3723, '2024-05-29 18:25:32', '2024-05-29 18:25:32', NULL),
(2, 2, 'DIR0002', 'Taches', 'Ce dossier contient les documents liés aux tâches', 0, 1, 1, '2024-06-20 15:25:14', '2024-06-20 15:25:14', NULL),
(3, 3, 'DT/0003', 'Taches', 'Dossier des documents liés aux tâches', 0, 1, 1, '2024-06-20 15:28:04', '2024-06-20 15:28:04', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dossier_passwords`
--

CREATE TABLE `dossier_passwords` (
  `id` bigint(20) NOT NULL,
  `dossier_id` bigint(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

CREATE TABLE `etapes` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etapes`
--

INSERT INTO `etapes` (`id`, `titre`, `created_at`, `updated_at`) VALUES
(1, 'Service courrier', '2023-07-27 13:29:31', '2023-07-27 13:29:31'),
(2, 'Secrétariat général', '2023-07-27 13:29:31', '2023-07-27 13:29:31'),
(3, 'Assistant', '2023-07-27 13:30:29', '2023-07-27 13:30:29'),
(4, 'Direction général', '2023-07-27 13:30:51', '2023-07-27 13:30:51');

-- --------------------------------------------------------

--
-- Structure de la table `etats`
--

CREATE TABLE `etats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etats`
--

INSERT INTO `etats` (`id`, `libelle`, `created_at`, `updated_at`, `user_id`, `statut_id`) VALUES
(1, 'Priorité absolu', '2022-07-04 14:06:19', '2022-07-04 14:06:19', 1, 1),
(2, 'Urgent', '2022-07-04 14:06:19', '2022-07-04 14:06:19', 1, 1),
(3, 'Normal', '2022-07-04 14:06:19', '2022-07-04 14:06:19', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

CREATE TABLE `fonctions` (
  `id` int(11) NOT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `section_id` bigint(20) DEFAULT NULL,
  `division_id` bigint(20) DEFAULT NULL,
  `direction_id` int(11) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fonctions`
--

INSERT INTO `fonctions` (`id`, `service_id`, `section_id`, `division_id`, `direction_id`, `titre`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 1, 1, 'Directeur général', NULL, '2023-07-14 08:32:02', '2023-07-22 18:22:01', NULL),
(2, NULL, NULL, NULL, 8, 'Directeur Direction des Projets et Travaux', '', '2023-09-27 13:14:51', '2023-09-27 13:14:51', NULL),
(3, NULL, NULL, NULL, 2, 'Directeur Secrétariat Général', '', '2023-09-27 13:23:47', '2023-09-27 13:23:47', NULL),
(4, NULL, NULL, NULL, 6, 'Directeur Direction de l\'exploitation', '', '2023-09-27 14:35:27', '2023-09-27 14:35:27', NULL),
(5, NULL, NULL, NULL, 3, 'Directeur Direction des Stratégies et Contrôle de Gestion', '', '2023-09-27 14:38:28', '2023-09-27 14:38:28', NULL),
(6, NULL, NULL, NULL, 11, 'Directeur Direction Financière', '', '2023-09-27 14:40:37', '2023-09-27 14:40:37', NULL),
(7, NULL, NULL, NULL, 12, 'Directeur Direction des Ressources Humaines', '', '2023-09-27 14:42:32', '2023-09-27 14:42:32', NULL),
(8, NULL, NULL, NULL, 4, 'Directeur Direction de l\'audit interne et inspection', '', '2023-09-27 14:44:43', '2023-09-27 14:44:43', NULL),
(9, NULL, NULL, NULL, 7, 'Directeur Direction Commerciale', '', '2023-09-27 14:46:19', '2023-09-27 14:46:19', NULL),
(10, NULL, NULL, NULL, 9, 'Directeur Direction des Approvisionnements et Logistique', '', '2023-09-27 14:47:58', '2023-09-27 14:47:58', NULL),
(11, NULL, NULL, NULL, 5, 'Directeur Direction de la Brigade Anti-fraude', '', '2023-09-27 14:51:09', '2023-09-27 14:51:09', NULL),
(12, NULL, NULL, NULL, 3, 'Secretaire Direction des Stratégies et Contrôle de Gestion', '', '2023-09-27 15:08:24', '2023-09-27 15:08:24', NULL),
(13, NULL, NULL, NULL, 13, 'Secretaire Direction de la Digitalisation et Gestion de l\'Information', '', '2023-09-27 15:15:17', '2023-09-27 15:15:17', NULL),
(14, NULL, NULL, NULL, 6, 'Secretaire Direction de l\'exploitation', '', '2023-09-27 15:20:44', '2023-09-27 15:20:44', NULL),
(15, NULL, NULL, NULL, 4, 'Secretaire Direction de l\'audit interne et inspection', '', '2023-09-27 15:38:03', '2023-09-27 15:38:03', NULL),
(16, NULL, NULL, NULL, 4, 'Secretaire Division sécurité et prévoyance', '', '2023-09-27 15:39:36', '2023-09-27 15:39:36', NULL),
(17, NULL, NULL, NULL, 2, 'Secretaire Secrétariat Général', '', '2023-09-27 15:41:41', '2023-09-27 15:41:41', NULL),
(18, NULL, NULL, NULL, 2, 'Secretaire Division communication', '', '2023-09-27 15:43:47', '2023-09-27 15:43:47', NULL),
(19, NULL, NULL, NULL, 7, 'Secretaire Direction Commerciale', '', '2023-09-27 15:45:30', '2023-09-27 15:45:30', NULL),
(20, NULL, NULL, NULL, 8, 'Secretaire Direction des Projets et Travaux', '', '2023-09-27 15:51:10', '2023-09-27 15:51:10', NULL),
(21, NULL, NULL, NULL, 8, 'Secretaire Division Planification et Gestion des Projets', '', '2023-09-27 15:52:39', '2023-09-27 15:52:39', NULL),
(22, NULL, NULL, NULL, 9, 'Secretaire Direction des Approvisionnements et Logistique', '', '2023-09-27 15:55:34', '2023-09-27 15:55:34', NULL),
(23, NULL, NULL, NULL, 9, 'Secretaire Division Logistique', '', '2023-09-27 15:56:49', '2023-09-27 15:56:49', NULL),
(24, NULL, NULL, NULL, 11, 'Secretaire Direction Financière', '', '2023-09-27 15:58:36', '2023-09-27 15:58:36', NULL),
(25, NULL, NULL, NULL, 11, 'Secretaire Division Comptabilité', '', '2023-09-27 16:00:20', '2023-09-27 16:00:20', NULL),
(26, NULL, NULL, NULL, 11, 'Secretaire Division de Trésorerie', '', '2023-09-27 16:02:21', '2023-09-27 16:02:21', NULL),
(27, NULL, NULL, NULL, 11, 'Secretaire Division Budget', '', '2023-09-27 16:03:25', '2023-09-27 16:03:25', NULL),
(28, NULL, NULL, NULL, 12, 'Secretaire Direction des Ressources Humaines', '', '2023-09-27 16:06:33', '2023-09-27 16:06:33', NULL),
(29, NULL, NULL, NULL, 12, 'Secretaire Division Centres Medicaux REGIDESO', '', '2023-09-27 16:10:46', '2023-09-27 16:10:46', NULL),
(30, NULL, NULL, NULL, 12, 'Secretaire Division Formation et Dévelop. du Capital Humain', '', '2023-09-27 16:31:21', '2023-09-27 16:31:21', NULL),
(31, NULL, NULL, NULL, 12, 'Secretaire Division Admin. Pers, Rénum. et Content', '', '2023-09-27 16:38:47', '2023-09-27 16:38:47', NULL),
(32, NULL, NULL, NULL, 5, 'Secretaire Direction de la Brigade Anti-fraude', '', '2023-09-27 16:44:31', '2023-09-27 16:44:31', NULL),
(33, NULL, NULL, NULL, 14, 'Responsable Directeur Régional de Kinshasa-Ouest', NULL, '2023-09-28 14:51:14', '2023-09-28 14:51:14', NULL),
(34, NULL, NULL, NULL, 20, 'Responsable Directeur Régional de Kinshasa-Est', NULL, '2023-09-28 15:14:03', '2023-09-28 15:14:03', NULL),
(35, NULL, NULL, NULL, 21, 'Responsable Directeur Régional de Kongo Central', NULL, '2023-09-28 15:15:16', '2023-09-28 15:15:16', NULL),
(36, NULL, NULL, NULL, 22, 'Responsable Directeur Régional de la Grande Orientale', NULL, '2023-09-28 15:16:55', '2023-09-28 15:16:55', NULL),
(37, NULL, NULL, NULL, 23, 'Responsable Directeur Régional du Sud-Kivu', NULL, '2023-09-28 15:19:27', '2023-09-28 15:19:27', NULL),
(38, NULL, NULL, NULL, 24, 'Responsable Directeur Régional du Nord-Kivu', NULL, '2023-09-28 15:20:21', '2023-09-28 15:20:21', NULL),
(39, NULL, NULL, NULL, 25, 'Responsable Directeur Régional du Grand Kasai-Oriental', NULL, '2023-09-28 15:21:21', '2023-09-28 15:21:21', NULL),
(40, NULL, NULL, NULL, 26, 'Responsable Directeur Régional du Grand Bandundu', NULL, '2023-09-28 15:22:08', '2023-09-28 15:22:08', NULL),
(41, NULL, NULL, NULL, 27, 'Responsable Directeur Régional du Grand Kasai-Occident', NULL, '2023-09-28 15:23:27', '2023-09-28 15:23:27', NULL),
(42, NULL, NULL, NULL, 28, 'Responsable Directeur Régional de Maniema', NULL, '2023-09-28 15:25:04', '2023-09-28 15:25:04', NULL),
(43, NULL, NULL, NULL, 29, 'Responsable Directeur Régional du Grand Katanga', NULL, '2023-09-28 15:28:53', '2023-09-28 15:28:53', NULL),
(44, NULL, NULL, NULL, 30, 'Responsable Directeur Régional de l\'équateur', NULL, '2023-09-28 15:34:51', '2023-09-28 15:34:51', NULL),
(45, NULL, NULL, NULL, 19, 'Directeur Direction Régionale de Kinshasa-Ouest', '', '2023-09-28 15:48:47', '2023-09-28 15:48:47', NULL),
(46, NULL, NULL, NULL, 20, 'Directeur Direction Régionale de Kinshasa-Est', '', '2023-09-28 15:55:20', '2023-09-28 15:55:20', NULL),
(47, NULL, NULL, NULL, 21, 'Directeur Direction Régionale de Kongo Central', '', '2023-09-28 15:58:12', '2023-09-28 15:58:12', NULL),
(48, NULL, NULL, NULL, 22, 'Directeur Direction Régionale de la Grande Orientale', '', '2023-09-28 16:01:20', '2023-09-28 16:01:20', NULL),
(49, NULL, NULL, NULL, 27, 'Directeur Direction Régionale du Grand Kasai-Occident', '', '2023-09-28 16:07:09', '2023-09-28 16:07:09', NULL),
(50, NULL, NULL, NULL, 25, 'Directeur Direction Régionale du Grand Kasai-Oriental', '', '2023-09-28 16:13:22', '2023-09-28 16:13:22', NULL),
(51, NULL, NULL, NULL, 24, 'Directeur Direction Régionale du Nord-Kivu', '', '2023-09-28 16:16:32', '2023-09-28 16:16:32', NULL),
(52, NULL, NULL, NULL, 23, 'Directeur Direction Régionale du Sud-Kivu', '', '2023-09-28 16:21:29', '2023-09-28 16:21:29', NULL),
(53, NULL, NULL, NULL, 28, 'Directeur Direction Régionale de Maniema', '', '2023-09-28 16:34:48', '2023-09-28 16:34:48', NULL),
(54, NULL, NULL, NULL, 26, 'Directeur Direction Régionale du Grand Bandundu', '', '2023-09-28 16:37:11', '2023-09-28 16:37:11', NULL),
(55, NULL, NULL, NULL, 29, 'Directeur Direction Régionale du Grand Katanga', '', '2023-09-28 16:41:09', '2023-09-28 16:41:09', NULL),
(56, NULL, NULL, NULL, 30, 'Directeur Direction Régionale de l\'équateur', '', '2023-09-28 16:43:12', '2023-09-28 16:43:12', NULL),
(57, NULL, NULL, 11, 1, 'Chef Service Courrier', '', '2023-09-29 10:05:57', '2023-09-29 10:05:57', NULL),
(58, NULL, NULL, 11, 1, 'Secretaire Service Courrier', '', '2023-09-29 10:43:57', '2023-09-29 10:43:57', NULL),
(59, NULL, NULL, NULL, 21, 'Secretaire Direction Régionale de Kongo Central', '', '2023-09-29 11:23:21', '2023-09-29 11:23:21', NULL),
(60, NULL, NULL, NULL, 23, 'Secretaire Direction Régionale du Sud-Kivu', '', '2023-09-29 11:29:40', '2023-09-29 11:29:40', NULL),
(61, NULL, NULL, NULL, 28, 'Secretaire Direction Régionale de Maniema', '', '2023-09-29 11:42:39', '2023-09-29 11:42:39', NULL),
(62, NULL, NULL, NULL, 30, 'Secretaire Direction Régionale de l\'équateur', '', '2023-09-29 11:46:00', '2023-09-29 11:46:00', NULL),
(63, 2, 0, 1, 1, 'Secrétaire DG', NULL, '2023-10-11 14:33:41', '2023-10-11 14:33:41', NULL),
(64, NULL, NULL, NULL, 1, 'Assistant DG', NULL, '2023-10-16 08:54:54', '2023-10-16 08:54:54', NULL),
(65, NULL, NULL, NULL, 1, 'Assistant DGA', NULL, '2023-10-16 08:55:17', '2023-10-16 08:55:17', NULL),
(66, NULL, NULL, NULL, 2, 'Secrétariat Secrétaire Général', NULL, '2023-10-16 11:53:02', '2023-10-16 11:53:02', NULL),
(67, 0, 0, 28, 13, 'DINFR', NULL, '2023-10-19 14:03:17', '2023-10-19 14:03:17', NULL),
(68, 0, 0, 0, 13, 'Directeur', NULL, '2023-10-25 12:02:58', '2023-10-25 12:02:58', NULL),
(69, 0, 0, 0, 13, 'chef de service assistance aux utilisateurs', NULL, '2023-10-25 16:52:01', '2023-10-25 16:52:01', NULL),
(70, 0, 0, 0, 13, 'Directeur DDGI', NULL, '2023-10-25 16:58:37', '2023-10-25 16:58:37', NULL),
(71, NULL, NULL, NULL, NULL, 'secrétaire du comité de direction', NULL, '2023-10-25 18:17:25', '2023-10-25 18:17:25', NULL),
(72, 11, 15, 5, 3, 'Chef de Section', NULL, '2023-10-27 12:00:54', '2023-10-27 12:00:54', NULL),
(73, 0, 0, 0, 13, 'Support IT', NULL, '2023-10-30 14:09:23', '2023-10-30 14:09:23', NULL),
(74, 57, 0, 29, 13, 'Chef de section archiviste', NULL, '2023-10-31 16:59:53', '2023-10-31 16:59:53', NULL),
(75, 3, 1, 1, 1, 'service courrier interne', NULL, '2023-11-01 07:25:48', '2023-11-01 07:25:48', NULL),
(76, 0, 0, 28, 13, 'S', NULL, '2023-11-01 14:35:50', '2023-11-01 14:35:50', NULL),
(77, 55, 0, 28, 13, 'chef de service Réseaux et Informatiques et telecoms', NULL, '2023-11-03 13:24:51', '2023-11-03 13:24:51', NULL),
(78, 0, 0, 31, 11, 'chef de division trésorie', NULL, '2023-11-15 12:38:37', '2023-11-15 12:38:37', NULL),
(79, 0, 0, 30, 11, 'chef de division comptabilité', NULL, '2023-11-15 12:41:43', '2023-11-15 12:41:43', NULL),
(80, 0, 0, 32, 11, 'chef de division budget', NULL, '2023-11-15 12:47:20', '2023-11-15 12:47:20', NULL),
(81, 57, 0, 29, 13, 'chef de service', NULL, '2023-11-15 12:57:00', '2023-11-15 12:57:00', NULL),
(82, 63, 0, 31, 11, 'Programmation', NULL, '2023-11-15 13:25:58', '2023-11-15 13:25:58', NULL),
(83, 45, 0, 23, 8, 'coordonnateur chantiers', NULL, '2023-11-15 14:39:31', '2023-11-15 14:39:31', NULL),
(84, 0, 0, 0, 7, 'chef de service interface avec le système d\'inforations commerciales', NULL, '2023-11-21 11:00:27', '2023-11-21 11:00:27', NULL),
(85, 38, 0, 21, 7, 'chef de service facturation', NULL, '2023-11-21 11:05:15', '2023-11-21 11:05:15', NULL),
(86, 38, 73, 21, 7, 'chef de section facturation', NULL, '2023-11-21 11:06:44', '2023-11-21 11:06:44', NULL),
(87, 0, 0, 12, 6, 'ingénieur d\'études', NULL, '2023-11-21 11:45:59', '2023-11-21 11:45:59', NULL),
(88, 18, 0, 12, 6, 'chef de section bobinage', NULL, '2023-11-21 11:57:03', '2023-11-21 11:57:03', NULL),
(89, 0, 0, 13, 6, 'ingénieur d\'étude', NULL, '2023-11-21 13:16:13', '2023-11-21 13:16:13', NULL),
(90, 23, 0, 13, 6, 'opérateur tamisseur', NULL, '2023-11-21 13:25:07', '2023-11-21 13:25:07', NULL),
(91, 0, 0, 28, 13, 'Ingénieur IOT', NULL, '2023-11-21 13:56:48', '2023-11-21 13:56:48', NULL),
(92, NULL, NULL, 33, 6, 'Responsable Division Centres Secondaires', NULL, '2023-11-21 15:10:37', '2023-11-21 15:10:37', NULL),
(93, 67, 136, 33, 6, 'Chef Section Reporting', NULL, '2023-11-21 15:19:08', '2023-11-21 15:19:08', NULL),
(94, 67, 137, 33, 6, 'Chef Section Reporting Exploitation', NULL, '2023-11-21 15:23:00', '2023-11-21 15:23:00', NULL),
(95, 67, 136, 33, 6, 'Responsable Section Reporting Commercial', NULL, '2023-11-21 15:24:11', '2023-11-21 15:24:11', NULL),
(96, 68, 138, 33, 6, 'Chef Service Administratif et Financier', NULL, '2023-11-21 15:25:30', '2023-11-21 15:25:30', NULL),
(97, 68, 138, 33, 6, 'Responsable Section Administratif et Financier', NULL, '2023-11-21 15:26:56', '2023-11-21 15:26:56', NULL),
(98, 68, 139, 33, 6, 'Chef Section Suivi du Personnel', NULL, '2023-11-21 15:29:44', '2023-11-21 15:29:44', NULL),
(99, 63, 0, 31, 11, 'Analyste Fiancier', NULL, '2023-11-21 16:13:35', '2023-11-21 16:13:35', NULL),
(100, 10, 13, 4, 3, 'Responsable Section études économiques et financières', NULL, '2023-11-30 14:39:23', '2023-11-30 14:39:23', NULL),
(101, 44, 81, 23, 8, 'Responsable Section Planification et Développement', NULL, '2023-11-30 14:39:57', '2023-11-30 14:39:57', NULL),
(102, 44, 82, 23, 8, 'Responsable Section Suivi et Évaluation des Projets', NULL, '2023-11-30 14:42:03', '2023-11-30 14:42:03', NULL),
(103, 45, 83, 23, 8, 'Responsable Section Bureaux Projets 1', NULL, '2023-11-30 14:43:57', '2023-11-30 14:43:57', NULL),
(104, 48, 91, 25, 8, 'Responsable Section Hydrologie', NULL, '2023-11-30 14:48:21', '2023-11-30 14:48:21', NULL),
(105, 49, 92, 25, 8, 'Responsable Section Génie Civil et Structure', NULL, '2023-11-30 14:49:01', '2023-11-30 14:49:01', NULL),
(106, 49, 93, 25, 8, 'Responsable Section Hydraulique', NULL, '2023-11-30 14:49:47', '2023-11-30 14:49:47', NULL),
(107, 49, 94, 25, 8, 'Responsable Section Génie Mécanique', NULL, '2023-11-30 14:50:42', '2023-11-30 14:50:42', NULL),
(108, 50, 99, 25, 8, 'Responsable Section Cartographie', NULL, '2023-11-30 14:51:43', '2023-11-30 14:51:43', NULL),
(109, 50, 100, 25, 8, 'Responsable Section Dessin et Modèle', NULL, '2023-11-30 14:52:34', '2023-11-30 14:52:34', NULL),
(110, 46, 86, 24, 8, 'Responsable Section Travaux Génie Civil', NULL, '2023-11-30 14:56:02', '2023-11-30 14:56:02', NULL),
(111, 47, 89, 24, 8, 'Responsable Section Travaux Sources', NULL, '2023-11-30 14:57:33', '2023-11-30 14:57:33', NULL),
(112, 46, 140, 24, 8, 'Chef Section Travaux Réseaux', NULL, '2023-11-30 15:05:20', '2023-11-30 15:05:20', NULL),
(113, 47, 141, 24, 8, 'Chef Section Travaux Forages', NULL, '2023-11-30 15:07:24', '2023-11-30 15:07:24', NULL),
(114, 38, 73, 21, 7, 'Responsable Section Facturation', NULL, '2023-11-30 15:08:15', '2023-11-30 15:08:15', NULL),
(115, 40, 76, 22, 7, 'Responsable Section Litige et PVR', NULL, '2023-11-30 15:09:02', '2023-11-30 15:09:02', NULL),
(116, 41, 77, 22, 7, 'Responsable Section Recouvrement Privé DR', NULL, '2023-11-30 15:09:51', '2023-11-30 15:09:51', NULL),
(117, 42, 79, 22, 7, 'Responsable Section Certification', NULL, '2023-11-30 15:10:30', '2023-11-30 15:10:30', NULL),
(118, 27, 46, 17, 6, 'Responsable Section environnement et bassin versant', NULL, '2023-11-30 15:13:13', '2023-11-30 15:13:13', NULL),
(119, 18, 28, 12, 6, 'Responsable Section atelier mécanique', NULL, '2023-11-30 15:57:21', '2023-11-30 15:57:21', NULL),
(120, 18, 142, 12, 6, 'Chef Section Bobinage', NULL, '2023-11-30 15:58:30', '2023-11-30 15:58:30', NULL),
(121, 18, 29, 12, 6, 'Responsable Section atelier électrique et automation', NULL, '2023-11-30 15:59:33', '2023-11-30 15:59:33', NULL),
(122, 19, 30, 12, 6, 'Responsable Section contrôle de la qualité de l\'eau', NULL, '2023-11-30 16:00:24', '2023-11-30 16:00:24', NULL),
(123, 19, 31, 12, 6, 'Responsable Section entretien ouvrage et chaîne de traitement', NULL, '2023-11-30 16:01:07', '2023-11-30 16:01:07', NULL),
(124, NULL, NULL, NULL, NULL, '', '', '2023-12-06 16:46:10', '2023-12-06 16:46:10', NULL),
(125, NULL, NULL, NULL, 1, 'Secrétaire DGA', NULL, '2023-12-07 11:47:57', '2023-12-07 11:47:57', NULL),
(126, 0, 0, 0, 1, 'Directeur général adjoint', NULL, '2023-12-07 12:16:10', '2023-12-07 12:16:10', NULL),
(127, NULL, NULL, NULL, 1, 'Secrétaire DG adjoint', NULL, '2023-12-13 11:00:34', '2023-12-13 11:00:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `grades`
--

INSERT INTO `grades` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'C-1', '2023-07-15 15:01:39', '2023-07-15 15:01:39', NULL),
(2, 'C-2', '2023-07-15 15:01:39', '2023-07-15 15:01:39', NULL),
(3, 'C-3', '2023-07-18 12:08:55', '2023-07-18 12:08:55', NULL),
(4, 'C-4', '2023-07-18 12:09:09', '2023-07-18 12:09:09', NULL),
(5, 'C-5', '2023-07-18 12:09:21', '2023-07-18 12:09:21', NULL),
(6, 'C-6', '2023-07-18 12:09:35', '2023-07-18 12:09:35', NULL),
(7, 'C-7', '2023-07-18 12:09:48', '2023-07-18 12:09:48', NULL),
(8, 'C-8', '2023-07-18 12:10:01', '2023-07-18 12:10:01', NULL),
(9, 'C-9', '2023-07-18 12:10:13', '2023-07-18 12:10:13', NULL),
(10, 'C-10', '2023-07-18 12:10:28', '2023-07-18 12:10:28', NULL),
(11, 'C-10', '2023-07-18 12:10:28', '2023-07-18 12:10:28', NULL),
(12, 'C-11', '2023-07-18 12:10:39', '2023-07-18 12:10:39', NULL),
(13, 'C-12', '2023-07-18 12:10:55', '2023-07-18 12:10:55', NULL),
(14, 'C-13', '2023-07-18 12:11:09', '2023-07-18 12:11:09', NULL),
(15, 'C-14', '2023-07-18 12:11:46', '2023-07-18 12:12:05', NULL),
(16, 'C-15', '2023-07-18 12:12:21', '2023-07-18 12:12:21', NULL),
(17, 'C-16', '2023-07-18 12:12:46', '2023-07-18 12:12:46', NULL),
(18, 'C-17', '2023-07-18 12:13:08', '2023-07-18 12:13:08', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `historiquecable_id` int(11) DEFAULT NULL,
  `historiquecable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historiques`
--

INSERT INTO `historiques` (`id`, `key`, `historiquecable_id`, `historiquecable_type`, `description`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Accusé de reception', 1, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-05-29 18:30:48', '2024-05-29 18:30:48', 3722),
(2, 'Accusé de reception', 1, 'App\\Models\\Courrier', 'A effectué un traitement sur ce courrier', '2024-05-29 18:34:23', '2024-05-29 18:34:23', 3722),
(3, 'Accusé de reception', 1, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-05-29 18:40:35', '2024-05-29 18:40:35', 4074),
(4, 'Accusé de reception', 1, 'App\\Models\\Courrier', 'A effectué un traitement sur ce courrier', '2024-05-29 18:41:04', '2024-05-29 18:41:04', 4074),
(5, 'Signature', 1, 'App\\Models\\Courrier', 'A signé le document du courrier', '2024-05-29 19:00:52', '2024-05-29 19:00:52', 1),
(6, 'Signature', 1, 'App\\Models\\Courrier', 'A signé le document du courrier', '2024-05-29 19:06:23', '2024-05-29 19:06:23', 1),
(7, 'Accusé de reception', 2, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-05-29 19:51:55', '2024-05-29 19:51:55', 4074),
(8, 'Accusé de reception', 2, 'App\\Models\\Courrier', 'A effectué des traitements sur ce courrier', '2024-05-29 19:51:55', '2024-05-29 19:51:55', 4074),
(9, 'Signature', 2, 'App\\Models\\Tache', 'A signé le document', '2024-06-20 15:28:04', '2024-06-20 15:28:04', 1),
(10, 'Signature', 2, 'App\\Models\\Tache', 'A signé le document', '2024-06-20 15:34:43', '2024-06-20 15:34:43', 1),
(11, 'Signature', 2, 'App\\Models\\Courrier', 'A signé le document du courrier', '2024-06-25 12:30:28', '2024-06-25 12:30:28', 1),
(12, 'Signature', 2, 'App\\Models\\Courrier', 'A signé le document du courrier', '2024-07-04 10:02:14', '2024-07-04 10:02:14', 1),
(13, 'Signature', 2, 'App\\Models\\Courrier', 'A signé le document du courrier', '2024-07-05 10:14:48', '2024-07-05 10:14:48', 1),
(14, 'Accusé de reception', 4, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-07-08 09:37:32', '2024-07-08 09:37:32', 3722),
(15, 'Accusé de reception', 4, 'App\\Models\\Courrier', 'A effectué un traitement sur ce courrier', '2024-07-08 09:38:37', '2024-07-08 09:38:37', 3722),
(16, 'Accusé de reception', 4, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-07-08 09:39:44', '2024-07-08 09:39:44', 4074),
(17, 'Accusé de reception', 4, 'App\\Models\\Courrier', 'A effectué un traitement sur ce courrier', '2024-07-08 09:40:15', '2024-07-08 09:40:15', 4074),
(18, 'Signature', 4, 'App\\Models\\Courrier', 'A signé le document du courrier', '2024-07-08 09:43:06', '2024-07-08 09:43:06', 1),
(19, 'Accusé de reception', 5, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-07-08 09:46:10', '2024-07-08 09:46:10', 4074),
(20, 'Accusé de reception', 5, 'App\\Models\\Courrier', 'A effectué des traitements sur ce courrier', '2024-07-08 09:46:10', '2024-07-08 09:46:10', 4074),
(21, 'Accusé de reception', 5, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-07-08 09:49:04', '2024-07-08 09:49:04', 3722),
(22, 'Accusé de reception', 5, 'App\\Models\\Courrier', 'A effectué des traitements sur ce courrier', '2024-07-08 09:49:04', '2024-07-08 09:49:04', 3722),
(23, 'Accusé de reception', 5, 'App\\Models\\Courrier', 'A accusé reception du courrier', '2024-07-08 09:53:57', '2024-07-08 09:53:57', 3723);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `type_image` enum('SIGNATURE','TAMPON','INITIALES') DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `image_url`, `type_image`, `user_id`, `password`, `created_at`, `updated_at`) VALUES
(1, 'images/May2024/OatDxg7TWCAqNYrTydVn.png', 'SIGNATURE', 1, '', '2024-05-29 19:00:36', '2024-05-29 19:00:36'),
(2, 'images/June2024/dAhr07Hk3tK6EucDSmbn.png', 'INITIALES', 1, '', '2024-06-20 15:33:41', '2024-06-20 15:33:41');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lieu_affectations`
--

CREATE TABLE `lieu_affectations` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu_affectations`
--

INSERT INTO `lieu_affectations` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Direction Régionale de Kinshasa-Ouest', '2023-07-15 13:12:42', '2023-07-15 13:16:33', NULL),
(2, 'Direction Régionale de Kinshasa-Est', '2023-07-15 13:13:13', '2023-07-15 13:17:07', NULL),
(3, 'Direction Régionale du Kongo Central', '2023-07-15 13:13:30', '2023-07-15 13:13:30', NULL),
(4, 'Direction Régionale de la Grande Orientale', '2023-07-15 13:13:44', '2023-07-15 13:13:44', NULL),
(5, 'Direction Régionale du Sud-Kivu', '2023-07-15 13:14:15', '2023-07-15 13:14:15', NULL),
(6, 'Direction Régionale du Nord-Kivu', '2023-07-15 13:14:36', '2023-07-15 13:14:36', NULL),
(7, 'Direction Régionale du Grand Kasai Oriental', '2023-07-15 13:14:55', '2023-07-15 13:14:55', NULL),
(8, 'Direction Régionale du Grand Bandundu', '2023-07-15 13:15:18', '2023-07-15 13:15:18', NULL),
(9, 'Direction Régionale du Grand Kasai Occidental', '2023-07-15 13:15:35', '2023-07-15 13:15:35', NULL),
(10, 'Direction Régionale de Maniema', '2023-07-15 13:15:49', '2023-07-15 13:15:49', NULL),
(11, 'Direction Régionale du Grand Katanga', '2023-07-15 13:17:41', '2023-07-15 13:17:41', NULL),
(12, 'Direction Générale', '2023-07-24 08:03:12', '2023-07-24 08:04:19', NULL),
(13, 'Direction Régionale de l\'équateur', '2023-09-28 15:33:34', '2023-09-28 15:33:51', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2022-10-14 14:10:55', '2022-10-14 14:10:55');

-- --------------------------------------------------------

--
-- Structure de la table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_regular` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_solid` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `route`, `policy`, `target`, `icon_regular`, `icon_solid`, `order`, `parameters`, `created_at`, `updated_at`, `deleted_at`) VALUES
(25, 1, NULL, 'Gestion de tâches', '', 'regidoc.taches.index', 'Voir les taches', '_self', 'fi fi-rr-list-check fi-rr', 'fi fi-sr-list-check fi-sr', 3, NULL, '2022-10-15 09:59:25', '2022-10-15 09:59:25', NULL),
(28, 1, NULL, 'Employés', '', 'regidoc.personnels.index', 'Gerer les personnels', '_self', 'fi fi-rr-users-alt fi-rr', 'fi fi-sr-users-alt fi-sr', 7, NULL, '2022-10-15 10:07:43', '2022-10-15 10:07:43', NULL),
(40, 1, NULL, 'Paramètres', '', NULL, 'Voir les parametres', '_self', 'fi fi-rr-settings fi-rr', 'fi fi-sr-settings fi-sr', 8, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(48, 1, NULL, 'A-propos', '#', NULL, 'voir_le_menu_à_propos', '_blank', 'fi fi-rr-info fi-rr', 'fi fi-sr-info fi-sr', 10, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', '2023-07-10 06:09:10'),
(52, 1, NULL, 'Archivage', '', 'regidoc.archivages.index', 'Voir les archives', '_self', 'fi fi-rr-box fi-rr', 'fi fi-sr-box fi-sr', 5, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(53, 1, NULL, 'Boîte de reception ', '', 'regidoc.courriers.index', 'Voir les courriers', '_self', 'fi fi-rr-envelope fi-rr', 'fi fi-sr-envelope fi-sr', 2, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(54, 1, 40, 'Section', '', 'regidoc.sections.index', 'Voir les Sections', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 3, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(55, 1, NULL, 'Tableau de bord', '/', 'regidoc.home', 'Voir le tableau de bord', '_self', 'fi fi-rr-apps fi-rr', 'fi fi-sr-apps fi-sr', 1, NULL, '2022-10-14 14:15:06', '2022-10-14 14:15:06', NULL),
(56, 1, NULL, 'Chat', '', 'regidoc.chat.index', 'voir_les_messages', '_self', 'fi fi-rr-comment fi-rr', 'fi fi-sr-comment fi-sr', 6, NULL, '2022-10-15 10:07:43', '2022-10-15 10:07:43', '2023-07-09 22:00:00'),
(57, 1, NULL, 'Documents', '', 'regidoc.documents.index', 'Voir les documents', '_self', 'fi fi-rr-folder fi-rr', 'fi fi-sr-folder fi-sr', 4, NULL, '2022-10-14 14:15:06', '2022-10-14 14:15:06', NULL),
(58, 1, 40, 'Directions', '', 'regidoc.directions.index', 'Voir les Directions', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 2, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(59, 1, 40, 'Divisions', '', 'regidoc.divisions.index', 'Voir les Divisions', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 4, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(60, 1, 40, 'Services', '', 'regidoc.services.index', 'Voir les Services', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 5, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(61, 1, 40, 'Fonctions', '', 'regidoc.fonctions.index', 'Voir les Fonctions', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 6, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(62, 1, 40, 'Grades', '', 'regidoc.grades.index', 'Voir les Grades\n', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 7, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(63, 1, 40, 'Lieu d\'affectation', '', 'regidoc.lieux.index', 'Voir les lieux d\'affectations', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 1, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(64, 1, 40, 'Secretariat', '', 'regidoc.secretariats.index', 'Voir les Secretaires', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 3, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(65, 1, 40, 'Assistanat', '', 'regidoc.assistants.index', 'Voir les Assistants', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 4, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', NULL),
(66, 1, 40, 'Sessions Log', '', 'regidoc.session', 'Voir l\'historique des sessions', '_self', 'fi fi-rr-building fi-rr', 'fi fi-sr-building fi-sr', 11, NULL, '2022-10-15 10:04:19', '2022-10-15 10:04:19', '2023-09-22 19:42:58');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2017_09_01_000000_create_authentication_log_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_11_13_012944_create_sessions_table', 1),
(8, '2023_01_18_123517_create_notifications_table', 2),
(9, '2013_04_09_062329_create_revisions_table', 3),
(10, '2023_07_15_191628_create_views_table', 3),
(11, '2023_07_26_105638_create_permission_tables', 4),
(12, '2023_10_23_181852_create_jobs_table', 5),
(13, '2023_11_10_164053_create_pivot_taches_agents_table', 6),
(14, '2023_11_16_171319_add_courrier_id_columns_to_taches_table', 7),
(15, '2023_11_30_154955_create_push_subscriptions_table', 8),
(16, '2023_12_04_165208_add_adjoint_id_columns_to_direction_table', 8),
(17, '2023_12_05_131930_add_mark_as_done_columns_to_courriers_table', 9),
(18, '2016_06_01_000001_create_oauth_auth_codes_table', 10),
(19, '2016_06_01_000002_create_oauth_access_tokens_table', 10),
(20, '2016_06_01_000003_create_oauth_refresh_tokens_table', 10),
(21, '2016_06_01_000004_create_oauth_clients_table', 10),
(22, '2016_06_01_000005_create_oauth_personal_access_clients_table', 10),
(23, '2024_01_11_180327_drop_date_debut_columns_to_courriers_partages_table', 10);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 2),
(18, 'App\\Models\\User', 2),
(20, 'App\\Models\\User', 2),
(28, 'App\\Models\\User', 2),
(31, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 4),
(17, 'App\\Models\\User', 4),
(18, 'App\\Models\\User', 4),
(19, 'App\\Models\\User', 4),
(20, 'App\\Models\\User', 4),
(21, 'App\\Models\\User', 4),
(22, 'App\\Models\\User', 4),
(23, 'App\\Models\\User', 4),
(24, 'App\\Models\\User', 4),
(25, 'App\\Models\\User', 4),
(26, 'App\\Models\\User', 4),
(27, 'App\\Models\\User', 4),
(28, 'App\\Models\\User', 4),
(29, 'App\\Models\\User', 4),
(30, 'App\\Models\\User', 4),
(31, 'App\\Models\\User', 4),
(32, 'App\\Models\\User', 4),
(33, 'App\\Models\\User', 4),
(34, 'App\\Models\\User', 4),
(35, 'App\\Models\\User', 4),
(36, 'App\\Models\\User', 4),
(37, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 5),
(18, 'App\\Models\\User', 5),
(19, 'App\\Models\\User', 5),
(29, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 6),
(6, 'App\\Models\\User', 6),
(7, 'App\\Models\\User', 6),
(8, 'App\\Models\\User', 6),
(9, 'App\\Models\\User', 6),
(10, 'App\\Models\\User', 6),
(11, 'App\\Models\\User', 6),
(12, 'App\\Models\\User', 6),
(13, 'App\\Models\\User', 6),
(14, 'App\\Models\\User', 6),
(15, 'App\\Models\\User', 6),
(16, 'App\\Models\\User', 6),
(17, 'App\\Models\\User', 6),
(18, 'App\\Models\\User', 6),
(19, 'App\\Models\\User', 6),
(20, 'App\\Models\\User', 6),
(21, 'App\\Models\\User', 6),
(22, 'App\\Models\\User', 6),
(23, 'App\\Models\\User', 6),
(24, 'App\\Models\\User', 6),
(25, 'App\\Models\\User', 6),
(26, 'App\\Models\\User', 6),
(27, 'App\\Models\\User', 6),
(28, 'App\\Models\\User', 6),
(29, 'App\\Models\\User', 6),
(30, 'App\\Models\\User', 6),
(31, 'App\\Models\\User', 6),
(32, 'App\\Models\\User', 6),
(33, 'App\\Models\\User', 6),
(34, 'App\\Models\\User', 6),
(35, 'App\\Models\\User', 6),
(36, 'App\\Models\\User', 6),
(37, 'App\\Models\\User', 6),
(38, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 7),
(17, 'App\\Models\\User', 7),
(18, 'App\\Models\\User', 7),
(19, 'App\\Models\\User', 7),
(21, 'App\\Models\\User', 7),
(22, 'App\\Models\\User', 7),
(24, 'App\\Models\\User', 7),
(25, 'App\\Models\\User', 7),
(26, 'App\\Models\\User', 7),
(27, 'App\\Models\\User', 7),
(28, 'App\\Models\\User', 7),
(30, 'App\\Models\\User', 7),
(31, 'App\\Models\\User', 7),
(32, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 11),
(18, 'App\\Models\\User', 11),
(28, 'App\\Models\\User', 11),
(30, 'App\\Models\\User', 11),
(31, 'App\\Models\\User', 11),
(33, 'App\\Models\\User', 11),
(36, 'App\\Models\\User', 11),
(1, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 18),
(5, 'App\\Models\\User', 18),
(17, 'App\\Models\\User', 18),
(21, 'App\\Models\\User', 18),
(25, 'App\\Models\\User', 18),
(28, 'App\\Models\\User', 18),
(31, 'App\\Models\\User', 18),
(37, 'App\\Models\\User', 18),
(1, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 21),
(17, 'App\\Models\\User', 21),
(18, 'App\\Models\\User', 21),
(19, 'App\\Models\\User', 21),
(20, 'App\\Models\\User', 21),
(21, 'App\\Models\\User', 21),
(22, 'App\\Models\\User', 21),
(23, 'App\\Models\\User', 21),
(24, 'App\\Models\\User', 21),
(25, 'App\\Models\\User', 21),
(26, 'App\\Models\\User', 21),
(27, 'App\\Models\\User', 21),
(28, 'App\\Models\\User', 21),
(29, 'App\\Models\\User', 21),
(30, 'App\\Models\\User', 21),
(31, 'App\\Models\\User', 21),
(32, 'App\\Models\\User', 21),
(33, 'App\\Models\\User', 21),
(34, 'App\\Models\\User', 21),
(35, 'App\\Models\\User', 21),
(36, 'App\\Models\\User', 21),
(1, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 25),
(28, 'App\\Models\\User', 25),
(31, 'App\\Models\\User', 25),
(35, 'App\\Models\\User', 25),
(36, 'App\\Models\\User', 25),
(1, 'App\\Models\\User', 37),
(2, 'App\\Models\\User', 37),
(3, 'App\\Models\\User', 37),
(4, 'App\\Models\\User', 37),
(17, 'App\\Models\\User', 37),
(18, 'App\\Models\\User', 37),
(20, 'App\\Models\\User', 37),
(21, 'App\\Models\\User', 37),
(28, 'App\\Models\\User', 37),
(30, 'App\\Models\\User', 37),
(31, 'App\\Models\\User', 37),
(33, 'App\\Models\\User', 37),
(35, 'App\\Models\\User', 37),
(36, 'App\\Models\\User', 37),
(1, 'App\\Models\\User', 39),
(2, 'App\\Models\\User', 39),
(3, 'App\\Models\\User', 39),
(4, 'App\\Models\\User', 39),
(17, 'App\\Models\\User', 39),
(21, 'App\\Models\\User', 39),
(22, 'App\\Models\\User', 39),
(23, 'App\\Models\\User', 39),
(24, 'App\\Models\\User', 39),
(25, 'App\\Models\\User', 39),
(26, 'App\\Models\\User', 39),
(27, 'App\\Models\\User', 39),
(28, 'App\\Models\\User', 39),
(31, 'App\\Models\\User', 39),
(33, 'App\\Models\\User', 39),
(1, 'App\\Models\\User', 42),
(2, 'App\\Models\\User', 42),
(3, 'App\\Models\\User', 42),
(4, 'App\\Models\\User', 42),
(6, 'App\\Models\\User', 42),
(17, 'App\\Models\\User', 42),
(18, 'App\\Models\\User', 42),
(19, 'App\\Models\\User', 42),
(20, 'App\\Models\\User', 42),
(21, 'App\\Models\\User', 42),
(22, 'App\\Models\\User', 42),
(23, 'App\\Models\\User', 42),
(24, 'App\\Models\\User', 42),
(25, 'App\\Models\\User', 42),
(26, 'App\\Models\\User', 42),
(27, 'App\\Models\\User', 42),
(28, 'App\\Models\\User', 42),
(29, 'App\\Models\\User', 42),
(30, 'App\\Models\\User', 42),
(31, 'App\\Models\\User', 42),
(32, 'App\\Models\\User', 42),
(33, 'App\\Models\\User', 42),
(34, 'App\\Models\\User', 42),
(35, 'App\\Models\\User', 42),
(36, 'App\\Models\\User', 42),
(1, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 46),
(4, 'App\\Models\\User', 46),
(5, 'App\\Models\\User', 46),
(20, 'App\\Models\\User', 46),
(21, 'App\\Models\\User', 46),
(22, 'App\\Models\\User', 46),
(23, 'App\\Models\\User', 46),
(24, 'App\\Models\\User', 46),
(25, 'App\\Models\\User', 46),
(26, 'App\\Models\\User', 46),
(27, 'App\\Models\\User', 46),
(28, 'App\\Models\\User', 46),
(29, 'App\\Models\\User', 46),
(32, 'App\\Models\\User', 46),
(33, 'App\\Models\\User', 46),
(1, 'App\\Models\\User', 48),
(2, 'App\\Models\\User', 48),
(3, 'App\\Models\\User', 48),
(4, 'App\\Models\\User', 48),
(17, 'App\\Models\\User', 48),
(18, 'App\\Models\\User', 48),
(28, 'App\\Models\\User', 48),
(29, 'App\\Models\\User', 48),
(1, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 50),
(3, 'App\\Models\\User', 50),
(4, 'App\\Models\\User', 50),
(18, 'App\\Models\\User', 50),
(20, 'App\\Models\\User', 50),
(24, 'App\\Models\\User', 50),
(25, 'App\\Models\\User', 50),
(26, 'App\\Models\\User', 50),
(28, 'App\\Models\\User', 50),
(31, 'App\\Models\\User', 50),
(35, 'App\\Models\\User', 50),
(1, 'App\\Models\\User', 51),
(2, 'App\\Models\\User', 51),
(3, 'App\\Models\\User', 51),
(4, 'App\\Models\\User', 51),
(17, 'App\\Models\\User', 51),
(18, 'App\\Models\\User', 51),
(28, 'App\\Models\\User', 51),
(31, 'App\\Models\\User', 51),
(1, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 52),
(3, 'App\\Models\\User', 52),
(4, 'App\\Models\\User', 52),
(17, 'App\\Models\\User', 52),
(18, 'App\\Models\\User', 52),
(20, 'App\\Models\\User', 52),
(21, 'App\\Models\\User', 52),
(28, 'App\\Models\\User', 52),
(35, 'App\\Models\\User', 52),
(36, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 53),
(4, 'App\\Models\\User', 53),
(17, 'App\\Models\\User', 53),
(18, 'App\\Models\\User', 53),
(28, 'App\\Models\\User', 53),
(32, 'App\\Models\\User', 53),
(33, 'App\\Models\\User', 53),
(35, 'App\\Models\\User', 53),
(36, 'App\\Models\\User', 53),
(1, 'App\\Models\\User', 54),
(2, 'App\\Models\\User', 54),
(3, 'App\\Models\\User', 54),
(4, 'App\\Models\\User', 54),
(17, 'App\\Models\\User', 54),
(18, 'App\\Models\\User', 54),
(28, 'App\\Models\\User', 54),
(30, 'App\\Models\\User', 54),
(31, 'App\\Models\\User', 54),
(1, 'App\\Models\\User', 56),
(2, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 56),
(17, 'App\\Models\\User', 56),
(18, 'App\\Models\\User', 56),
(19, 'App\\Models\\User', 56),
(20, 'App\\Models\\User', 56),
(21, 'App\\Models\\User', 56),
(22, 'App\\Models\\User', 56),
(23, 'App\\Models\\User', 56),
(24, 'App\\Models\\User', 56),
(25, 'App\\Models\\User', 56),
(26, 'App\\Models\\User', 56),
(27, 'App\\Models\\User', 56),
(28, 'App\\Models\\User', 56),
(29, 'App\\Models\\User', 56),
(30, 'App\\Models\\User', 56),
(31, 'App\\Models\\User', 56),
(32, 'App\\Models\\User', 56),
(33, 'App\\Models\\User', 56),
(2, 'App\\Models\\User', 2726),
(17, 'App\\Models\\User', 2726),
(18, 'App\\Models\\User', 2726),
(19, 'App\\Models\\User', 2726),
(20, 'App\\Models\\User', 2726),
(21, 'App\\Models\\User', 2726),
(22, 'App\\Models\\User', 2726),
(23, 'App\\Models\\User', 2726),
(24, 'App\\Models\\User', 2726),
(25, 'App\\Models\\User', 2726),
(26, 'App\\Models\\User', 2726),
(27, 'App\\Models\\User', 2726),
(29, 'App\\Models\\User', 2726),
(30, 'App\\Models\\User', 2726),
(31, 'App\\Models\\User', 2726),
(32, 'App\\Models\\User', 2726),
(33, 'App\\Models\\User', 2726),
(34, 'App\\Models\\User', 2726),
(35, 'App\\Models\\User', 2726),
(36, 'App\\Models\\User', 2726),
(1, 'App\\Models\\User', 3579),
(5, 'App\\Models\\User', 3579),
(1, 'App\\Models\\User', 3719),
(2, 'App\\Models\\User', 3719),
(3, 'App\\Models\\User', 3719),
(4, 'App\\Models\\User', 3719),
(17, 'App\\Models\\User', 3719),
(21, 'App\\Models\\User', 3719),
(24, 'App\\Models\\User', 3719),
(25, 'App\\Models\\User', 3719),
(26, 'App\\Models\\User', 3719),
(27, 'App\\Models\\User', 3719),
(28, 'App\\Models\\User', 3719),
(32, 'App\\Models\\User', 3719),
(1, 'App\\Models\\User', 3721),
(2, 'App\\Models\\User', 3721),
(3, 'App\\Models\\User', 3721),
(4, 'App\\Models\\User', 3721),
(17, 'App\\Models\\User', 3721),
(18, 'App\\Models\\User', 3721),
(19, 'App\\Models\\User', 3721),
(23, 'App\\Models\\User', 3721),
(24, 'App\\Models\\User', 3721),
(25, 'App\\Models\\User', 3721),
(28, 'App\\Models\\User', 3721),
(29, 'App\\Models\\User', 3721),
(30, 'App\\Models\\User', 3721),
(31, 'App\\Models\\User', 3721),
(32, 'App\\Models\\User', 3721),
(1, 'App\\Models\\User', 3722),
(2, 'App\\Models\\User', 3722),
(3, 'App\\Models\\User', 3722),
(4, 'App\\Models\\User', 3722),
(17, 'App\\Models\\User', 3722),
(18, 'App\\Models\\User', 3722),
(25, 'App\\Models\\User', 3722),
(26, 'App\\Models\\User', 3722),
(27, 'App\\Models\\User', 3722),
(28, 'App\\Models\\User', 3722),
(30, 'App\\Models\\User', 3722),
(31, 'App\\Models\\User', 3722),
(32, 'App\\Models\\User', 3722),
(37, 'App\\Models\\User', 3722),
(1, 'App\\Models\\User', 3723),
(2, 'App\\Models\\User', 3723),
(4, 'App\\Models\\User', 3723),
(17, 'App\\Models\\User', 3723),
(18, 'App\\Models\\User', 3723),
(19, 'App\\Models\\User', 3723),
(22, 'App\\Models\\User', 3723),
(23, 'App\\Models\\User', 3723),
(29, 'App\\Models\\User', 3723),
(30, 'App\\Models\\User', 3723),
(31, 'App\\Models\\User', 3723),
(32, 'App\\Models\\User', 3723),
(1, 'App\\Models\\User', 3726),
(2, 'App\\Models\\User', 3726),
(3, 'App\\Models\\User', 3726),
(17, 'App\\Models\\User', 3726),
(21, 'App\\Models\\User', 3726),
(24, 'App\\Models\\User', 3726),
(25, 'App\\Models\\User', 3726),
(26, 'App\\Models\\User', 3726),
(28, 'App\\Models\\User', 3726),
(1, 'App\\Models\\User', 3862),
(2, 'App\\Models\\User', 3862),
(3, 'App\\Models\\User', 3862),
(4, 'App\\Models\\User', 3862),
(17, 'App\\Models\\User', 3862),
(18, 'App\\Models\\User', 3862),
(22, 'App\\Models\\User', 3862),
(23, 'App\\Models\\User', 3862),
(24, 'App\\Models\\User', 3862),
(25, 'App\\Models\\User', 3862),
(26, 'App\\Models\\User', 3862),
(27, 'App\\Models\\User', 3862),
(28, 'App\\Models\\User', 3862),
(31, 'App\\Models\\User', 3862),
(33, 'App\\Models\\User', 3862),
(1, 'App\\Models\\User', 3867),
(2, 'App\\Models\\User', 3867),
(3, 'App\\Models\\User', 3867),
(4, 'App\\Models\\User', 3867),
(5, 'App\\Models\\User', 3867),
(6, 'App\\Models\\User', 3867),
(7, 'App\\Models\\User', 3867),
(8, 'App\\Models\\User', 3867),
(9, 'App\\Models\\User', 3867),
(10, 'App\\Models\\User', 3867),
(11, 'App\\Models\\User', 3867),
(12, 'App\\Models\\User', 3867),
(13, 'App\\Models\\User', 3867),
(14, 'App\\Models\\User', 3867),
(15, 'App\\Models\\User', 3867),
(16, 'App\\Models\\User', 3867),
(17, 'App\\Models\\User', 3867),
(18, 'App\\Models\\User', 3867),
(19, 'App\\Models\\User', 3867),
(20, 'App\\Models\\User', 3867),
(21, 'App\\Models\\User', 3867),
(22, 'App\\Models\\User', 3867),
(23, 'App\\Models\\User', 3867),
(24, 'App\\Models\\User', 3867),
(25, 'App\\Models\\User', 3867),
(26, 'App\\Models\\User', 3867),
(27, 'App\\Models\\User', 3867),
(28, 'App\\Models\\User', 3867),
(29, 'App\\Models\\User', 3867),
(30, 'App\\Models\\User', 3867),
(31, 'App\\Models\\User', 3867),
(32, 'App\\Models\\User', 3867),
(33, 'App\\Models\\User', 3867),
(34, 'App\\Models\\User', 3867),
(35, 'App\\Models\\User', 3867),
(36, 'App\\Models\\User', 3867),
(37, 'App\\Models\\User', 3867),
(38, 'App\\Models\\User', 3867),
(1, 'App\\Models\\User', 3872),
(2, 'App\\Models\\User', 3872),
(3, 'App\\Models\\User', 3872),
(4, 'App\\Models\\User', 3872),
(6, 'App\\Models\\User', 3872),
(21, 'App\\Models\\User', 3872),
(24, 'App\\Models\\User', 3872),
(25, 'App\\Models\\User', 3872),
(32, 'App\\Models\\User', 3872),
(33, 'App\\Models\\User', 3872),
(3, 'App\\Models\\User', 3877),
(1, 'App\\Models\\User', 3879),
(2, 'App\\Models\\User', 3879),
(3, 'App\\Models\\User', 3879),
(4, 'App\\Models\\User', 3879),
(5, 'App\\Models\\User', 3879),
(6, 'App\\Models\\User', 3879),
(7, 'App\\Models\\User', 3879),
(8, 'App\\Models\\User', 3879),
(9, 'App\\Models\\User', 3879),
(10, 'App\\Models\\User', 3879),
(11, 'App\\Models\\User', 3879),
(12, 'App\\Models\\User', 3879),
(13, 'App\\Models\\User', 3879),
(14, 'App\\Models\\User', 3879),
(15, 'App\\Models\\User', 3879),
(16, 'App\\Models\\User', 3879),
(17, 'App\\Models\\User', 3879),
(18, 'App\\Models\\User', 3879),
(19, 'App\\Models\\User', 3879),
(20, 'App\\Models\\User', 3879),
(21, 'App\\Models\\User', 3879),
(22, 'App\\Models\\User', 3879),
(23, 'App\\Models\\User', 3879),
(24, 'App\\Models\\User', 3879),
(25, 'App\\Models\\User', 3879),
(26, 'App\\Models\\User', 3879),
(27, 'App\\Models\\User', 3879),
(28, 'App\\Models\\User', 3879),
(29, 'App\\Models\\User', 3879),
(30, 'App\\Models\\User', 3879),
(31, 'App\\Models\\User', 3879),
(32, 'App\\Models\\User', 3879),
(33, 'App\\Models\\User', 3879),
(34, 'App\\Models\\User', 3879),
(35, 'App\\Models\\User', 3879),
(36, 'App\\Models\\User', 3879),
(37, 'App\\Models\\User', 3879),
(38, 'App\\Models\\User', 3879),
(1, 'App\\Models\\User', 3883),
(2, 'App\\Models\\User', 3883),
(3, 'App\\Models\\User', 3883),
(4, 'App\\Models\\User', 3883),
(5, 'App\\Models\\User', 3883),
(6, 'App\\Models\\User', 3883),
(7, 'App\\Models\\User', 3883),
(8, 'App\\Models\\User', 3883),
(9, 'App\\Models\\User', 3883),
(10, 'App\\Models\\User', 3883),
(11, 'App\\Models\\User', 3883),
(12, 'App\\Models\\User', 3883),
(13, 'App\\Models\\User', 3883),
(14, 'App\\Models\\User', 3883),
(15, 'App\\Models\\User', 3883),
(16, 'App\\Models\\User', 3883),
(17, 'App\\Models\\User', 3883),
(18, 'App\\Models\\User', 3883),
(19, 'App\\Models\\User', 3883),
(20, 'App\\Models\\User', 3883),
(21, 'App\\Models\\User', 3883),
(22, 'App\\Models\\User', 3883),
(23, 'App\\Models\\User', 3883),
(24, 'App\\Models\\User', 3883),
(25, 'App\\Models\\User', 3883),
(26, 'App\\Models\\User', 3883),
(27, 'App\\Models\\User', 3883),
(28, 'App\\Models\\User', 3883),
(29, 'App\\Models\\User', 3883),
(30, 'App\\Models\\User', 3883),
(31, 'App\\Models\\User', 3883),
(32, 'App\\Models\\User', 3883),
(33, 'App\\Models\\User', 3883),
(34, 'App\\Models\\User', 3883),
(35, 'App\\Models\\User', 3883),
(36, 'App\\Models\\User', 3883),
(37, 'App\\Models\\User', 3883),
(38, 'App\\Models\\User', 3883),
(2, 'App\\Models\\User', 3885),
(3, 'App\\Models\\User', 3885),
(4, 'App\\Models\\User', 3885),
(22, 'App\\Models\\User', 3885),
(24, 'App\\Models\\User', 3885),
(25, 'App\\Models\\User', 3885),
(27, 'App\\Models\\User', 3885),
(28, 'App\\Models\\User', 3885),
(32, 'App\\Models\\User', 3885),
(1, 'App\\Models\\User', 3909),
(2, 'App\\Models\\User', 3909),
(3, 'App\\Models\\User', 3909),
(4, 'App\\Models\\User', 3909),
(17, 'App\\Models\\User', 3909),
(22, 'App\\Models\\User', 3909),
(24, 'App\\Models\\User', 3909),
(25, 'App\\Models\\User', 3909),
(26, 'App\\Models\\User', 3909),
(27, 'App\\Models\\User', 3909),
(31, 'App\\Models\\User', 3909),
(32, 'App\\Models\\User', 3909),
(1, 'App\\Models\\User', 3993),
(2, 'App\\Models\\User', 3993),
(3, 'App\\Models\\User', 3993),
(4, 'App\\Models\\User', 3993),
(17, 'App\\Models\\User', 3993),
(21, 'App\\Models\\User', 3993),
(24, 'App\\Models\\User', 3993),
(25, 'App\\Models\\User', 3993),
(27, 'App\\Models\\User', 3993),
(28, 'App\\Models\\User', 3993),
(32, 'App\\Models\\User', 3993),
(1, 'App\\Models\\User', 3997),
(2, 'App\\Models\\User', 3997),
(3, 'App\\Models\\User', 3997),
(17, 'App\\Models\\User', 3997),
(21, 'App\\Models\\User', 3997),
(25, 'App\\Models\\User', 3997),
(26, 'App\\Models\\User', 3997),
(27, 'App\\Models\\User', 3997),
(28, 'App\\Models\\User', 3997),
(31, 'App\\Models\\User', 3997),
(32, 'App\\Models\\User', 3997),
(33, 'App\\Models\\User', 3997),
(34, 'App\\Models\\User', 3997),
(36, 'App\\Models\\User', 3997),
(1, 'App\\Models\\User', 4032),
(2, 'App\\Models\\User', 4032),
(3, 'App\\Models\\User', 4032),
(4, 'App\\Models\\User', 4032),
(17, 'App\\Models\\User', 4032),
(18, 'App\\Models\\User', 4032),
(19, 'App\\Models\\User', 4032),
(20, 'App\\Models\\User', 4032),
(21, 'App\\Models\\User', 4032),
(24, 'App\\Models\\User', 4032),
(25, 'App\\Models\\User', 4032),
(26, 'App\\Models\\User', 4032),
(27, 'App\\Models\\User', 4032),
(28, 'App\\Models\\User', 4032),
(31, 'App\\Models\\User', 4032),
(32, 'App\\Models\\User', 4032),
(33, 'App\\Models\\User', 4032),
(34, 'App\\Models\\User', 4032),
(35, 'App\\Models\\User', 4032),
(36, 'App\\Models\\User', 4032),
(1, 'App\\Models\\User', 4041),
(2, 'App\\Models\\User', 4041),
(3, 'App\\Models\\User', 4041),
(17, 'App\\Models\\User', 4041),
(20, 'App\\Models\\User', 4041),
(21, 'App\\Models\\User', 4041),
(22, 'App\\Models\\User', 4041),
(23, 'App\\Models\\User', 4041),
(24, 'App\\Models\\User', 4041),
(25, 'App\\Models\\User', 4041),
(27, 'App\\Models\\User', 4041),
(28, 'App\\Models\\User', 4041),
(31, 'App\\Models\\User', 4041),
(32, 'App\\Models\\User', 4041),
(33, 'App\\Models\\User', 4041),
(34, 'App\\Models\\User', 4041),
(36, 'App\\Models\\User', 4041),
(3, 'App\\Models\\User', 4049),
(17, 'App\\Models\\User', 4049),
(20, 'App\\Models\\User', 4049),
(21, 'App\\Models\\User', 4049),
(24, 'App\\Models\\User', 4049),
(25, 'App\\Models\\User', 4049),
(26, 'App\\Models\\User', 4049),
(27, 'App\\Models\\User', 4049),
(28, 'App\\Models\\User', 4049),
(31, 'App\\Models\\User', 4049),
(32, 'App\\Models\\User', 4049),
(34, 'App\\Models\\User', 4049),
(35, 'App\\Models\\User', 4049),
(36, 'App\\Models\\User', 4049),
(1, 'App\\Models\\User', 4059),
(2, 'App\\Models\\User', 4059),
(3, 'App\\Models\\User', 4059),
(17, 'App\\Models\\User', 4059),
(20, 'App\\Models\\User', 4059),
(21, 'App\\Models\\User', 4059),
(23, 'App\\Models\\User', 4059),
(24, 'App\\Models\\User', 4059),
(25, 'App\\Models\\User', 4059),
(27, 'App\\Models\\User', 4059),
(28, 'App\\Models\\User', 4059),
(31, 'App\\Models\\User', 4059),
(32, 'App\\Models\\User', 4059),
(33, 'App\\Models\\User', 4059),
(34, 'App\\Models\\User', 4059),
(36, 'App\\Models\\User', 4059),
(1, 'App\\Models\\User', 4061),
(2, 'App\\Models\\User', 4061),
(3, 'App\\Models\\User', 4061),
(4, 'App\\Models\\User', 4061),
(17, 'App\\Models\\User', 4061),
(20, 'App\\Models\\User', 4061),
(21, 'App\\Models\\User', 4061),
(24, 'App\\Models\\User', 4061),
(25, 'App\\Models\\User', 4061),
(26, 'App\\Models\\User', 4061),
(27, 'App\\Models\\User', 4061),
(28, 'App\\Models\\User', 4061),
(31, 'App\\Models\\User', 4061),
(32, 'App\\Models\\User', 4061),
(33, 'App\\Models\\User', 4061),
(34, 'App\\Models\\User', 4061),
(35, 'App\\Models\\User', 4061),
(36, 'App\\Models\\User', 4061),
(1, 'App\\Models\\User', 4070),
(2, 'App\\Models\\User', 4070),
(3, 'App\\Models\\User', 4070),
(4, 'App\\Models\\User', 4070),
(17, 'App\\Models\\User', 4070),
(18, 'App\\Models\\User', 4070),
(19, 'App\\Models\\User', 4070),
(20, 'App\\Models\\User', 4070),
(21, 'App\\Models\\User', 4070),
(22, 'App\\Models\\User', 4070),
(23, 'App\\Models\\User', 4070),
(24, 'App\\Models\\User', 4070),
(25, 'App\\Models\\User', 4070),
(26, 'App\\Models\\User', 4070),
(27, 'App\\Models\\User', 4070),
(28, 'App\\Models\\User', 4070),
(31, 'App\\Models\\User', 4070),
(32, 'App\\Models\\User', 4070),
(33, 'App\\Models\\User', 4070),
(34, 'App\\Models\\User', 4070),
(35, 'App\\Models\\User', 4070),
(1, 'App\\Models\\User', 4071),
(2, 'App\\Models\\User', 4071),
(3, 'App\\Models\\User', 4071),
(4, 'App\\Models\\User', 4071),
(17, 'App\\Models\\User', 4071),
(18, 'App\\Models\\User', 4071),
(19, 'App\\Models\\User', 4071),
(20, 'App\\Models\\User', 4071),
(21, 'App\\Models\\User', 4071),
(22, 'App\\Models\\User', 4071),
(23, 'App\\Models\\User', 4071),
(24, 'App\\Models\\User', 4071),
(25, 'App\\Models\\User', 4071),
(26, 'App\\Models\\User', 4071),
(27, 'App\\Models\\User', 4071),
(28, 'App\\Models\\User', 4071),
(31, 'App\\Models\\User', 4071),
(32, 'App\\Models\\User', 4071),
(33, 'App\\Models\\User', 4071),
(34, 'App\\Models\\User', 4071),
(35, 'App\\Models\\User', 4071),
(36, 'App\\Models\\User', 4071),
(37, 'App\\Models\\User', 4071),
(1, 'App\\Models\\User', 4072),
(3, 'App\\Models\\User', 4072),
(4, 'App\\Models\\User', 4072),
(1, 'App\\Models\\User', 4074),
(2, 'App\\Models\\User', 4074),
(3, 'App\\Models\\User', 4074),
(4, 'App\\Models\\User', 4074),
(17, 'App\\Models\\User', 4074),
(18, 'App\\Models\\User', 4074),
(19, 'App\\Models\\User', 4074),
(21, 'App\\Models\\User', 4074),
(25, 'App\\Models\\User', 4074),
(26, 'App\\Models\\User', 4074),
(27, 'App\\Models\\User', 4074),
(28, 'App\\Models\\User', 4074),
(1, 'App\\Models\\User', 4077),
(2, 'App\\Models\\User', 4077),
(3, 'App\\Models\\User', 4077),
(4, 'App\\Models\\User', 4077),
(20, 'App\\Models\\User', 4077),
(21, 'App\\Models\\User', 4077),
(24, 'App\\Models\\User', 4077),
(25, 'App\\Models\\User', 4077),
(26, 'App\\Models\\User', 4077),
(28, 'App\\Models\\User', 4077),
(29, 'App\\Models\\User', 4077),
(32, 'App\\Models\\User', 4077),
(33, 'App\\Models\\User', 4077),
(2, 'App\\Models\\User', 4078),
(3, 'App\\Models\\User', 4078),
(4, 'App\\Models\\User', 4078),
(17, 'App\\Models\\User', 4078),
(21, 'App\\Models\\User', 4078),
(24, 'App\\Models\\User', 4078),
(25, 'App\\Models\\User', 4078),
(26, 'App\\Models\\User', 4078),
(27, 'App\\Models\\User', 4078),
(28, 'App\\Models\\User', 4078),
(31, 'App\\Models\\User', 4078),
(32, 'App\\Models\\User', 4078),
(33, 'App\\Models\\User', 4078),
(34, 'App\\Models\\User', 4078),
(35, 'App\\Models\\User', 4078),
(36, 'App\\Models\\User', 4078),
(1, 'App\\Models\\User', 4082),
(2, 'App\\Models\\User', 4082),
(3, 'App\\Models\\User', 4082),
(4, 'App\\Models\\User', 4082),
(21, 'App\\Models\\User', 4082),
(28, 'App\\Models\\User', 4082),
(32, 'App\\Models\\User', 4082),
(33, 'App\\Models\\User', 4082),
(1, 'App\\Models\\User', 4083),
(2, 'App\\Models\\User', 4083),
(3, 'App\\Models\\User', 4083),
(4, 'App\\Models\\User', 4083),
(17, 'App\\Models\\User', 4083),
(18, 'App\\Models\\User', 4083),
(20, 'App\\Models\\User', 4083),
(21, 'App\\Models\\User', 4083),
(24, 'App\\Models\\User', 4083),
(25, 'App\\Models\\User', 4083),
(27, 'App\\Models\\User', 4083),
(28, 'App\\Models\\User', 4083),
(31, 'App\\Models\\User', 4083),
(33, 'App\\Models\\User', 4083),
(35, 'App\\Models\\User', 4083),
(36, 'App\\Models\\User', 4083),
(1, 'App\\Models\\User', 4091),
(3, 'App\\Models\\User', 4091),
(4, 'App\\Models\\User', 4091),
(17, 'App\\Models\\User', 4091),
(20, 'App\\Models\\User', 4091),
(21, 'App\\Models\\User', 4091),
(24, 'App\\Models\\User', 4091),
(25, 'App\\Models\\User', 4091),
(26, 'App\\Models\\User', 4091),
(27, 'App\\Models\\User', 4091),
(28, 'App\\Models\\User', 4091),
(31, 'App\\Models\\User', 4091),
(32, 'App\\Models\\User', 4091),
(33, 'App\\Models\\User', 4091),
(34, 'App\\Models\\User', 4091),
(35, 'App\\Models\\User', 4091),
(36, 'App\\Models\\User', 4091),
(1, 'App\\Models\\User', 4093),
(2, 'App\\Models\\User', 4093),
(3, 'App\\Models\\User', 4093),
(4, 'App\\Models\\User', 4093),
(17, 'App\\Models\\User', 4093),
(20, 'App\\Models\\User', 4093),
(21, 'App\\Models\\User', 4093),
(25, 'App\\Models\\User', 4093),
(26, 'App\\Models\\User', 4093),
(27, 'App\\Models\\User', 4093),
(28, 'App\\Models\\User', 4093),
(31, 'App\\Models\\User', 4093),
(32, 'App\\Models\\User', 4093),
(33, 'App\\Models\\User', 4093),
(34, 'App\\Models\\User', 4093),
(35, 'App\\Models\\User', 4093),
(36, 'App\\Models\\User', 4093),
(1, 'App\\Models\\User', 4420),
(2, 'App\\Models\\User', 4420),
(3, 'App\\Models\\User', 4420),
(4, 'App\\Models\\User', 4420),
(6, 'App\\Models\\User', 4420),
(17, 'App\\Models\\User', 4420),
(18, 'App\\Models\\User', 4420),
(19, 'App\\Models\\User', 4420),
(20, 'App\\Models\\User', 4420),
(21, 'App\\Models\\User', 4420),
(22, 'App\\Models\\User', 4420),
(23, 'App\\Models\\User', 4420),
(24, 'App\\Models\\User', 4420),
(25, 'App\\Models\\User', 4420),
(26, 'App\\Models\\User', 4420),
(27, 'App\\Models\\User', 4420),
(28, 'App\\Models\\User', 4420),
(29, 'App\\Models\\User', 4420),
(30, 'App\\Models\\User', 4420),
(31, 'App\\Models\\User', 4420),
(32, 'App\\Models\\User', 4420),
(33, 'App\\Models\\User', 4420),
(34, 'App\\Models\\User', 4420),
(35, 'App\\Models\\User', 4420),
(36, 'App\\Models\\User', 4420),
(37, 'App\\Models\\User', 4420),
(38, 'App\\Models\\User', 4420),
(39, 'App\\Models\\User', 4420);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 39),
(2, 'App\\Models\\User', 42),
(2, 'App\\Models\\User', 46),
(2, 'App\\Models\\User', 48),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 3579),
(3, 'App\\Models\\User', 3719),
(3, 'App\\Models\\User', 3721),
(3, 'App\\Models\\User', 3722),
(3, 'App\\Models\\User', 3723),
(3, 'App\\Models\\User', 3862),
(1, 'App\\Models\\User', 3867),
(3, 'App\\Models\\User', 3872),
(3, 'App\\Models\\User', 3877),
(1, 'App\\Models\\User', 3879),
(3, 'App\\Models\\User', 3879),
(1, 'App\\Models\\User', 3883),
(3, 'App\\Models\\User', 3885),
(3, 'App\\Models\\User', 3991),
(3, 'App\\Models\\User', 3993),
(2, 'App\\Models\\User', 3997),
(2, 'App\\Models\\User', 4032),
(2, 'App\\Models\\User', 4041),
(2, 'App\\Models\\User', 4049),
(2, 'App\\Models\\User', 4059),
(2, 'App\\Models\\User', 4070),
(3, 'App\\Models\\User', 4071),
(3, 'App\\Models\\User', 4072),
(3, 'App\\Models\\User', 4073),
(3, 'App\\Models\\User', 4074),
(3, 'App\\Models\\User', 4077),
(2, 'App\\Models\\User', 4078),
(3, 'App\\Models\\User', 4082),
(2, 'App\\Models\\User', 4083),
(3, 'App\\Models\\User', 4085),
(3, 'App\\Models\\User', 4086),
(2, 'App\\Models\\User', 4091),
(2, 'App\\Models\\User', 4093),
(3, 'App\\Models\\User', 4420);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `titre`, `created_at`, `updated_at`) VALUES
(1, 'Tableau de bord', '2023-07-26 11:42:07', '2023-07-26 11:42:07'),
(2, 'Courriers', '2023-07-26 11:45:06', '2023-07-26 11:45:06'),
(3, 'Tâches', '2023-07-26 11:45:06', '2023-07-26 11:45:06'),
(4, 'Documents', '2023-07-26 11:46:05', '2023-07-26 11:46:05'),
(5, 'Archivage', '2023-07-26 11:46:05', '2023-07-26 11:46:05'),
(6, 'Employés', '2023-07-26 11:46:05', '2023-07-26 11:46:05'),
(7, 'Parametres', '2023-07-26 11:47:17', '2023-07-26 11:47:17');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('03c93e58-2d6d-42a4-97a2-3dbc8a4253a7', 'App\\Notifications\\TacheNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Vous a envoy\\u00e9 un nouvel objectif < Faire le compte rendu au DGA > pour la t\\u00e2che Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"object\":\"\",\"tache\":{\"id\":2,\"user_id\":1,\"statut_id\":1,\"tache_statut_id\":1,\"priorite_id\":1,\"parent_id\":null,\"titre\":\"Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"pourcentage\":0,\"description\":\"<p>Bonjour ceci un message test<\\/p>\",\"date_debut\":\"2024-06-23T23:00:00.000000Z\",\"date_fin\":\"2024-06-25T23:00:00.000000Z\",\"created_at\":\"2024-06-20T15:25:14.000000Z\",\"updated_at\":\"2024-06-20T15:25:14.000000Z\",\"deleted_at\":null,\"courrier_id\":null,\"documents\":[{\"id\":3,\"dossier_id\":2,\"category_id\":6,\"reference\":\"DT\\/435\",\"libelle\":\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1)\",\"type\":3,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/OOsUHQlPk8uDQtF13aws.pdf\\\",\\\"original_name\\\":\\\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1).pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":1,\"statut_id\":1,\"created_by\":1,\"created_at\":\"2024-06-20T15:25:14.000000Z\",\"updated_at\":\"2024-06-20T15:25:14.000000Z\",\"deleted_at\":null,\"pivot\":{\"tache_id\":2,\"document_id\":3}},{\"id\":4,\"dossier_id\":3,\"category_id\":6,\"reference\":\"DT\\/0004\",\"libelle\":\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V\",\"type\":3,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/amCm6DRtrhJvSAO2dZm8.pdf\\\",\\\"original_name\\\":\\\"230821MISE A JOUR ET DEVELOPPEMENT BLUE APP V.05(1).pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":1,\"statut_id\":1,\"created_by\":1,\"created_at\":\"2024-06-20T15:28:04.000000Z\",\"updated_at\":\"2024-06-20T15:28:04.000000Z\",\"deleted_at\":null,\"pivot\":{\"tache_id\":2,\"document_id\":4}}],\"courrier\":null,\"user\":{\"id\":1,\"role_id\":null,\"statut_id\":1,\"name\":\"Herve Kinsala\",\"email\":\"hervekinsala@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=H+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null}},\"objectifs\":[{\"id\":3,\"libelle\":\"Contacter le secretariat g\\u00e9n\\u00e9ral\",\"statut\":\"0\",\"created_at\":\"2024-06-20T15:25:53.000000Z\",\"updated_at\":\"2024-06-20T15:25:53.000000Z\",\"tache_id\":2,\"agent_id\":4420,\"user_id\":1,\"agent\":{\"id\":4420,\"user_id\":4420,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Ntumba\",\"post_nom\":\"Indele\",\"prenom\":\"Jeanpy\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-07\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":0,\"fonction_id\":126,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"0000\",\"image\":\"agents\\/June2024\\/YelB7GHKevD899Kj9i42.jpg\",\"slug\":\"mwaka-indele-jean-bosco\",\"created_by\":3879,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2023-12-06T15:46:10.000000Z\",\"updated_at\":\"2024-06-11T11:58:53.000000Z\",\"deleted_at\":null,\"direction\":{\"id\":1,\"titre\":\"Direction g\\u00e9n\\u00e9rale\",\"code\":\"DG\",\"description\":null,\"lieu_id\":12,\"responsable_id\":1,\"slug\":null,\"created_at\":\"2023-07-13T08:21:14.000000Z\",\"updated_at\":\"2023-12-12T12:28:00.000000Z\",\"deleted_at\":null,\"adjoint_id\":4420}}}],\"priorite\":{\"id\":1,\"titre\":\"Normale\",\"created_at\":\"2022-11-14T03:33:03.000000Z\",\"updated_at\":\"2022-11-14T03:33:03.000000Z\",\"deleted_at\":null},\"agents\":[{\"id\":4420,\"user_id\":4420,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Ntumba\",\"post_nom\":\"Indele\",\"prenom\":\"Jeanpy\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-07\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":0,\"fonction_id\":126,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"0000\",\"image\":\"agents\\/June2024\\/YelB7GHKevD899Kj9i42.jpg\",\"slug\":\"mwaka-indele-jean-bosco\",\"created_by\":3879,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2023-12-06T15:46:10.000000Z\",\"updated_at\":\"2024-06-11T11:58:53.000000Z\",\"deleted_at\":null,\"pivot\":{\"tache_id\":2,\"agent_id\":4420,\"type\":null,\"type_id\":null,\"created_at\":\"2024-06-20T15:25:53.000000Z\",\"updated_at\":\"2024-06-20T15:25:53.000000Z\"}}]}}}', NULL, '2024-06-20 15:29:44', '2024-06-20 15:29:44'),
('0eedad42-12b8-4282-ad80-1423c85ce6fd', 'App\\Notifications\\TacheNotification', 'App\\Models\\Agent', 4420, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Vous a envoy\\u00e9 un nouvel objectif < Contacter le secretariat g\\u00e9n\\u00e9ral > pour la t\\u00e2che Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"object\":\"\",\"tache\":{\"id\":2,\"user_id\":1,\"statut_id\":1,\"tache_statut_id\":1,\"priorite_id\":1,\"parent_id\":null,\"titre\":\"Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"pourcentage\":0,\"description\":\"<p>Bonjour ceci un message test<\\/p>\",\"date_debut\":\"2024-06-23T23:00:00.000000Z\",\"date_fin\":\"2024-06-25T23:00:00.000000Z\",\"created_at\":\"2024-06-20T15:25:14.000000Z\",\"updated_at\":\"2024-06-20T15:25:14.000000Z\",\"deleted_at\":null,\"courrier_id\":null,\"agents\":[],\"user\":{\"id\":1,\"role_id\":null,\"statut_id\":1,\"name\":\"Herve Kinsala\",\"email\":\"hervekinsala@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=H+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null}}}}}', NULL, '2024-06-20 15:25:53', '2024-06-20 15:25:53'),
('10ffca59-2788-4f50-aff1-bf5c45c8db6f', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 1, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":null},\"message\":\"A accus\\u00e9 reception du courrier transmis\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":5,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":2,\"visitor\":\"bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z\",\"collection\":null,\"user_id\":1,\"viewed_at\":\"2024-05-29 20:50:59\"},{\"id\":6,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":2,\"visitor\":\"ul7Va7KeLc3AK4X2pxKdpIv8BQg17LHZSmWwgE6qIREJQOkyCKQXn56oPW34zIfEn7igfKwmjpqYV4dE\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-05-29 20:51:41\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}}],\"etapes\":[{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":2,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\"}}],\"author\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/May2024\\/SsethDWqm2jPxeOpHw1l.jpg\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-05-29T19:48:46.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[]}}}', '2024-05-30 10:27:06', '2024-05-29 19:51:55', '2024-05-30 10:27:06'),
('17509f5f-8e2f-4272-86fb-69520adc15c6', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-06-25 12:30:28', '2024-06-25 12:30:28'),
('2e446605-731e-4056-b538-aa26658360b0', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}},{\"id\":7,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/fevtQw7d1ID4rXDo8e8l.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-06-25T12:30:28.000000Z\",\"updated_at\":\"2024-06-25T12:30:28.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":7}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-07-04 10:02:15', '2024-07-04 10:02:15'),
('327bd509-3083-4def-a998-2261dccec0f0', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Francis Isasi\",\"image\":\"agents\\/May2024\\/OwNuwMfrXQNwZEUkW4WX.jpg\"},\"message\":\"A cr\\u00e9\\u00e9 un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"type_id\":\"1\",\"category_id\":\"5\",\"exped_externe\":\"61\",\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"confidentiel\":\"0\",\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"nature_id\":\"2\",\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"objet\":null,\"document_id\":6,\"created_by\":3723,\"statut_id\":1,\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"id\":4,\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":3722}}],\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-07-07 20:52:04', '2024-07-07 20:52:04'),
('35e9b0aa-cc09-4162-8096-95b37384f40f', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 1, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\"},\"message\":\"Vous a transmis un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":\"1\",\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-07-08 09:40:15', '2024-07-08 09:40:15'),
('36220ea6-c8b4-41ed-bbbb-0bd14695df0a', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/May2024\\/SsethDWqm2jPxeOpHw1l.jpg\"},\"message\":\"Un nouveau courrier trait\\u00e9 vous a \\u00e9t\\u00e9 transmis !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":1,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":5}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-05-29 19:49:27', '2024-05-29 19:49:27'),
('38ce0505-5cc4-4be0-8875-bbd84f577847', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Yasmine Kabengele\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\"},\"message\":\"Vous a transmis un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":\"1\",\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-07-08 09:38:37', '2024-07-08 09:38:37'),
('3d964d9c-8c71-4cf3-99c5-0b08bd1cc3cc', 'App\\Notifications\\TacheNotification', 'App\\Models\\Agent', 1, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"La t\\u00e2che Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral a un nouveau commentaire\",\"object\":\"\",\"tache\":{\"id\":2,\"user_id\":1,\"statut_id\":1,\"tache_statut_id\":1,\"priorite_id\":1,\"parent_id\":null,\"titre\":\"Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"pourcentage\":0,\"description\":\"<p>Bonjour ceci un message test<\\/p>\",\"date_debut\":\"2024-06-23T23:00:00.000000Z\",\"date_fin\":\"2024-06-25T23:00:00.000000Z\",\"created_at\":\"2024-06-20T15:25:14.000000Z\",\"updated_at\":\"2024-06-20T15:25:14.000000Z\",\"deleted_at\":null,\"courrier_id\":null,\"user\":{\"id\":1,\"role_id\":null,\"statut_id\":1,\"name\":\"Herve Kinsala\",\"email\":\"hervekinsala@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=H+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null}}}}}', NULL, '2024-06-20 15:35:56', '2024-06-20 15:35:56'),
('3edabaab-18e9-4cbf-8094-56aca63d5fa6', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herv\\u00e9 Kinsala\",\"image\":null},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":3}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":4074}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}}]}}}', NULL, '2024-05-29 19:06:23', '2024-05-29 19:06:23');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('47bf20ad-4c42-4d7b-9455-b6c6aa335473', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}},{\"id\":7,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/fevtQw7d1ID4rXDo8e8l.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-06-25T12:30:28.000000Z\",\"updated_at\":\"2024-06-25T12:30:28.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":7}},{\"id\":8,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/CULuOP0TEBQ0QKJRN8RQ.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-07-04T10:02:14.000000Z\",\"updated_at\":\"2024-07-04T10:02:14.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":8}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-07-05 10:14:49', '2024-07-05 10:14:49'),
('4aa24f13-ded9-4cad-8995-98e6f7ee29d8', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":null},\"message\":\"A accus\\u00e9 reception du courrier transmis\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":1,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":1,\"visitor\":\"bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z\",\"collection\":null,\"user_id\":3723,\"viewed_at\":\"2024-05-29 19:25:32\"},{\"id\":2,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":1,\"visitor\":\"0iQFadonlAd4dgG1ePdcHkeN94NCKDbYGa7MAURejYql7xrLxZE8kxjuPkPOIaLboi592vaa52ovHYPI\",\"collection\":null,\"user_id\":3722,\"viewed_at\":\"2024-05-29 19:29:32\"},{\"id\":3,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":1,\"visitor\":\"ul7Va7KeLc3AK4X2pxKdpIv8BQg17LHZSmWwgE6qIREJQOkyCKQXn56oPW34zIfEn7igfKwmjpqYV4dE\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-05-29 19:40:15\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":4074}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}}],\"etapes\":[{\"id\":2,\"titre\":\"Secr\\u00e9tariat g\\u00e9n\\u00e9ral\",\"created_at\":\"2023-07-27T13:29:31.000000Z\",\"updated_at\":\"2023-07-27T13:29:31.000000Z\",\"pivot\":{\"courrier_id\":1,\"etape_id\":2,\"view_by\":3722,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:30:48.000000Z\"}},{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":1,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:40:34.000000Z\"}}],\"author\":{\"id\":3723,\"user_id\":3723,\"lieu_id\":12,\"direction_id\":1,\"section_id\":null,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Isasi\",\"post_nom\":\"Mbadu\",\"prenom\":\"Francis\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-31\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":null,\"fonction_id\":57,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"3465\",\"image\":null,\"slug\":\"luzolo-mbadu-martin\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-06T08:59:43.000000Z\",\"updated_at\":\"2023-10-31T05:37:03.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[{\"id\":1,\"user_id\":3722,\"courrier_id\":1,\"created_at\":\"2024-05-29T18:30:48.000000Z\",\"updated_at\":\"2024-05-29T18:30:48.000000Z\",\"user\":{\"id\":3722,\"role_id\":null,\"statut_id\":1,\"name\":\"Yasmine Kabengele\",\"email\":\"yasminekabengele@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-11T13:24:59.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=Y+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null}}}]}}}', NULL, '2024-05-29 18:40:35', '2024-05-29 18:40:35'),
('4d197c67-f06d-45ba-8658-2b472ff5564c', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Yasmine Kabengele\",\"image\":null},\"message\":\"Vous a transmis un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":\"1\",\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"deleted_at\":null}}}}', '2024-05-29 18:43:08', '2024-05-29 18:34:23', '2024-05-29 18:43:08'),
('4e08b50c-482a-480d-8ecb-c46e017533db', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3723, '{\"data\":{\"agent\":{\"name\":\"Yasmine Kabengele\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\"},\"message\":\"Vous a transmi un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":5,\"document_id\":6,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0005-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":13,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":5,\"visitor\":\"ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-07-08 10:46:01\"},{\"id\":14,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":5,\"visitor\":\"NUE6dgeZ0Re9NfFGjQae6JMayBkzo9xdrGBfaWcwPdP40ZgZwbca6oGiwC39cG9E5171UIrA9Oq2fi47\",\"collection\":null,\"user_id\":3722,\"viewed_at\":\"2024-07-08 10:49:00\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":3722}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":11}},{\"id\":12,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/O82AcvE5Vf64sbIDvkBr.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"created_at\":\"2024-07-08T09:43:06.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":12}},{\"id\":13,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":13}},{\"id\":14,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-07-08T09:46:10.000000Z\",\"updated_at\":\"2024-07-08T09:46:10.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":14}}],\"etapes\":[{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":5,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:46:10.000000Z\"}},{\"id\":2,\"titre\":\"Secr\\u00e9tariat g\\u00e9n\\u00e9ral\",\"created_at\":\"2023-07-27T13:29:31.000000Z\",\"updated_at\":\"2023-07-27T13:29:31.000000Z\",\"pivot\":{\"courrier_id\":5,\"etape_id\":2,\"view_by\":3722,\"created_at\":\"2024-07-08T09:46:10.000000Z\",\"updated_at\":\"2024-07-08T09:49:04.000000Z\"}}],\"author\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[{\"id\":6,\"user_id\":4074,\"courrier_id\":5,\"created_at\":\"2024-07-08T09:46:10.000000Z\",\"updated_at\":\"2024-07-08T09:46:10.000000Z\"}]}}}', NULL, '2024-07-08 09:49:04', '2024-07-08 09:49:04'),
('5db7fb6e-a425-4b52-955f-113acabdd089', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":11}}],\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":4074}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":1}}]}}}', NULL, '2024-07-08 09:43:06', '2024-07-08 09:43:06'),
('64efce14-99d6-43dc-9831-87f520f82f0f', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-06-25 12:30:28', '2024-06-25 12:30:28'),
('7335fd46-2d7b-4636-a211-3f1b2176cdc8', 'App\\Notifications\\TacheNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Vous a envoy\\u00e9 un nouvel objectif < Pr\\u00e9parer les visuels marketing du projet  > pour la t\\u00e2che Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"object\":\"\",\"tache\":{\"id\":2,\"user_id\":1,\"statut_id\":1,\"tache_statut_id\":1,\"priorite_id\":1,\"parent_id\":null,\"titre\":\"Deploiement du projet Jurixio pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"pourcentage\":0,\"description\":\"<p>Bonjour ceci un message test<\\/p>\",\"date_debut\":\"2024-06-23T23:00:00.000000Z\",\"date_fin\":\"2024-06-25T23:00:00.000000Z\",\"created_at\":\"2024-06-20T15:25:14.000000Z\",\"updated_at\":\"2024-06-20T15:25:14.000000Z\",\"deleted_at\":null,\"courrier_id\":null,\"agents\":[{\"id\":4420,\"user_id\":4420,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Ntumba\",\"post_nom\":\"Indele\",\"prenom\":\"Jeanpy\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-07\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":0,\"fonction_id\":126,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"0000\",\"image\":\"agents\\/June2024\\/YelB7GHKevD899Kj9i42.jpg\",\"slug\":\"mwaka-indele-jean-bosco\",\"created_by\":3879,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2023-12-06T15:46:10.000000Z\",\"updated_at\":\"2024-06-11T11:58:53.000000Z\",\"deleted_at\":null,\"pivot\":{\"tache_id\":2,\"agent_id\":4420,\"type\":null,\"type_id\":null,\"created_at\":\"2024-06-20T15:25:53.000000Z\",\"updated_at\":\"2024-06-20T15:25:53.000000Z\"}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"tache_id\":2,\"agent_id\":3722,\"type\":null,\"type_id\":null,\"created_at\":\"2024-06-20T15:29:44.000000Z\",\"updated_at\":\"2024-06-20T15:29:44.000000Z\"}}],\"user\":{\"id\":1,\"role_id\":null,\"statut_id\":1,\"name\":\"Herve Kinsala\",\"email\":\"hervekinsala@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=H+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null}}}}}', NULL, '2024-06-20 15:36:58', '2024-06-20 15:36:58'),
('7421b7c6-fd4c-47a3-bf2c-a1282c413af8', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herv\\u00e9 Kinsala\",\"image\":null},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":2}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":4074}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}}]}}}', NULL, '2024-05-29 19:00:52', '2024-05-29 19:00:52'),
('74367c7f-abaa-46b7-8720-68fa62a448ea', 'App\\Notifications\\TacheNotification', 'App\\Models\\Agent', 1, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Vous a envoy\\u00e9 un nouvel objectif < Signer le document > pour la t\\u00e2che qfjqdfdq pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"object\":\"\",\"tache\":{\"id\":1,\"user_id\":1,\"statut_id\":1,\"tache_statut_id\":1,\"priorite_id\":1,\"parent_id\":null,\"titre\":\"qfjqdfdq pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"pourcentage\":0,\"description\":\"<p>qdfdqfjbdhfjld fdqhfdjfdf fdfhdlkhdfhdlfkf<\\/p>\",\"date_debut\":\"2024-06-20T23:00:00.000000Z\",\"date_fin\":\"2024-06-26T23:00:00.000000Z\",\"created_at\":\"2024-06-20T15:18:12.000000Z\",\"updated_at\":\"2024-06-20T15:18:12.000000Z\",\"deleted_at\":null,\"courrier_id\":null,\"agents\":[],\"user\":{\"id\":1,\"role_id\":null,\"statut_id\":1,\"name\":\"Herve Kinsala\",\"email\":\"hervekinsala@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=H+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null}}}}}', NULL, '2024-06-20 15:21:21', '2024-06-20 15:21:21');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('743966cc-d3e9-463e-a2b8-3f30f12503f6', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}},{\"id\":7,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/fevtQw7d1ID4rXDo8e8l.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-06-25T12:30:28.000000Z\",\"updated_at\":\"2024-06-25T12:30:28.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":7}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-07-04 10:02:15', '2024-07-04 10:02:15'),
('7e405230-c283-4a4c-b020-0c4a5e5daf27', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 1, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\"},\"message\":\"A accus\\u00e9 reception du courrier transmis\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":5,\"document_id\":6,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0005-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":13,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":5,\"visitor\":\"ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-07-08 10:46:01\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":4074}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":11}},{\"id\":12,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/O82AcvE5Vf64sbIDvkBr.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"created_at\":\"2024-07-08T09:43:06.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":12}},{\"id\":13,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":13}}],\"etapes\":[{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":5,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:46:10.000000Z\"}}],\"author\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[]}}}', NULL, '2024-07-08 09:46:10', '2024-07-08 09:46:10'),
('942c73a9-1fdb-4ff0-b4de-20d4b9ccba77', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}},{\"id\":7,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/fevtQw7d1ID4rXDo8e8l.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-06-25T12:30:28.000000Z\",\"updated_at\":\"2024-06-25T12:30:28.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":7}},{\"id\":8,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/CULuOP0TEBQ0QKJRN8RQ.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-07-04T10:02:14.000000Z\",\"updated_at\":\"2024-07-04T10:02:14.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":8}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-07-05 10:14:49', '2024-07-05 10:14:49'),
('9aa1f6e0-3575-4d26-9ecd-e4b51ea28e68', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Un nouveau courrier trait\\u00e9 vous a \\u00e9t\\u00e9 transmis !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":1,\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":11}},{\"id\":12,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/O82AcvE5Vf64sbIDvkBr.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"created_at\":\"2024-07-08T09:43:06.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":12}},{\"id\":13,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":13}}],\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-07-08 09:43:49', '2024-07-08 09:43:49'),
('a5ab5625-1299-458b-a5cd-929afb0007cf', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herv\\u00e9 Kinsala\",\"image\":null},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":2}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":4074}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}}]}}}', NULL, '2024-05-29 19:00:52', '2024-05-29 19:00:52'),
('b3a4d4c8-6403-416c-925d-584c3f17935e', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}},{\"id\":7,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/fevtQw7d1ID4rXDo8e8l.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-06-25T12:30:28.000000Z\",\"updated_at\":\"2024-06-25T12:30:28.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":7}},{\"id\":8,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/CULuOP0TEBQ0QKJRN8RQ.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-07-04T10:02:14.000000Z\",\"updated_at\":\"2024-07-04T10:02:14.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":8}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-07-05 10:14:49', '2024-07-05 10:14:49'),
('bb6f268b-955e-4c07-9fd4-9c424a5b541c', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}},{\"id\":7,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/June2024\\\\\\/fevtQw7d1ID4rXDo8e8l.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-06-25T12:30:28.000000Z\",\"updated_at\":\"2024-06-25T12:30:28.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":7}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-07-04 10:02:14', '2024-07-04 10:02:14'),
('c0435aad-6714-4197-8454-1fe8e83c8024', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Francis Isasi\",\"image\":null},\"message\":\"A cr\\u00e9\\u00e9 un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"type_id\":\"1\",\"category_id\":\"2\",\"exped_externe\":\"60\",\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"confidentiel\":\"0\",\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"nature_id\":\"2\",\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"objet\":null,\"document_id\":1,\"created_by\":3723,\"statut_id\":1,\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"id\":1,\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-05-29 18:25:32', '2024-05-29 18:25:32');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('c4b5b2c5-47ef-41f5-b779-ca8e8066945a', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 1, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":null},\"message\":\"Vous a transmis un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":\"1\",\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"deleted_at\":null}}}}', '2024-05-29 19:42:13', '2024-05-29 18:41:05', '2024-05-29 19:42:13'),
('ca0cb926-e177-4f17-a56e-ce12887a37c1', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herv\\u00e9 Kinsala\",\"image\":null},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":3}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":4074}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herv\\u00e9\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-12-12\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":null,\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":1}}]}}}', NULL, '2024-05-29 19:06:23', '2024-05-29 19:06:23'),
('ccf56084-7870-4d9e-8521-bfcaf5758ae8', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}},{\"id\":6,\"agent_id\":4074,\"note\":null,\"document_url\":null,\"created_at\":\"2024-05-29T19:51:55.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":6}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}},{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":1}}]}}}', NULL, '2024-06-25 12:30:28', '2024-06-25 12:30:28'),
('d40f1b20-d094-4e89-a671-014849663ca2', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\"},\"message\":\"A accus\\u00e9 reception du courrier transmis\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":9,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":4,\"visitor\":\"mQydOUQimRJgpzJL2WIYDq5UdWfE72kyBF6PvEq8NK8IuMyJ5DHFyeILBy3MyHmW5v0qaLQmSm5OwS5u\",\"collection\":null,\"user_id\":3723,\"viewed_at\":\"2024-07-07 21:52:04\"},{\"id\":10,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":4,\"visitor\":\"NUE6dgeZ0Re9NfFGjQae6JMayBkzo9xdrGBfaWcwPdP40ZgZwbca6oGiwC39cG9E5171UIrA9Oq2fi47\",\"collection\":null,\"user_id\":3722,\"viewed_at\":\"2024-07-08 10:37:24\"},{\"id\":11,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":4,\"visitor\":\"ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-07-08 10:39:25\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":4074}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":10}}],\"etapes\":[{\"id\":2,\"titre\":\"Secr\\u00e9tariat g\\u00e9n\\u00e9ral\",\"created_at\":\"2023-07-27T13:29:31.000000Z\",\"updated_at\":\"2023-07-27T13:29:31.000000Z\",\"pivot\":{\"courrier_id\":4,\"etape_id\":2,\"view_by\":3722,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:37:32.000000Z\"}},{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":4,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:39:44.000000Z\"}}],\"author\":{\"id\":3723,\"user_id\":3723,\"lieu_id\":12,\"direction_id\":1,\"section_id\":null,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Isasi\",\"post_nom\":\"Mbadu\",\"prenom\":\"Francis\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-31\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":null,\"fonction_id\":57,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"3465\",\"image\":\"agents\\/May2024\\/OwNuwMfrXQNwZEUkW4WX.jpg\",\"slug\":\"luzolo-mbadu-martin\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-06T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:22:16.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[{\"id\":4,\"user_id\":3722,\"courrier_id\":4,\"created_at\":\"2024-07-08T09:37:32.000000Z\",\"updated_at\":\"2024-07-08T09:37:32.000000Z\",\"user\":{\"id\":3722,\"role_id\":null,\"statut_id\":1,\"name\":\"Yasmine Kabengele\",\"email\":\"yasminekabengele@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-11T13:24:59.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=Y+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null}}}]}}}', NULL, '2024-07-08 09:39:44', '2024-07-08 09:39:44'),
('d593960d-468c-4dda-ba30-c714babacb6a', 'App\\Notifications\\TacheNotification', 'App\\Models\\Agent', 4420, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Vous a envoy\\u00e9 un nouvel objectif < Facture proforma > pour la t\\u00e2che qfjqdfdq pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"object\":\"\",\"tache\":{\"id\":1,\"user_id\":1,\"statut_id\":1,\"tache_statut_id\":1,\"priorite_id\":1,\"parent_id\":null,\"titre\":\"qfjqdfdq pour Secr\\u00e9tariat G\\u00e9n\\u00e9ral\",\"pourcentage\":0,\"description\":\"<p>qdfdqfjbdhfjld fdqhfdjfdf fdfhdlkhdfhdlfkf<\\/p>\",\"date_debut\":\"2024-06-20T23:00:00.000000Z\",\"date_fin\":\"2024-06-26T23:00:00.000000Z\",\"created_at\":\"2024-06-20T15:18:12.000000Z\",\"updated_at\":\"2024-06-20T15:18:12.000000Z\",\"deleted_at\":null,\"courrier_id\":null,\"agents\":[{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"tache_id\":1,\"agent_id\":1,\"type\":null,\"type_id\":null,\"created_at\":\"2024-06-20T15:21:21.000000Z\",\"updated_at\":\"2024-06-20T15:21:21.000000Z\"}}],\"user\":{\"id\":1,\"role_id\":null,\"statut_id\":1,\"name\":\"Herve Kinsala\",\"email\":\"hervekinsala@newtech-rdc.net\",\"email_verified_at\":null,\"two_factor_confirmed_at\":null,\"current_team_id\":null,\"profile_photo_path\":null,\"first_use\":0,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2023-12-12T11:33:31.000000Z\",\"profile_photo_url\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=H+K&color=7F9CF5&background=EBF4FF\",\"agent\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null}}}}}', NULL, '2024-06-20 15:21:44', '2024-06-20 15:21:44'),
('dcc31ad5-52d1-40c5-9407-2ae7ce09ef59', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3723, '{\"data\":{\"agent\":{\"name\":\"Yasmine Kabengele\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\"},\"message\":\"A accus\\u00e9 reception du courrier transmis\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":null,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":null,\"created_by\":3723,\"parent_id\":null,\"statut_id\":1,\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-07T20:52:03.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":9,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":4,\"visitor\":\"mQydOUQimRJgpzJL2WIYDq5UdWfE72kyBF6PvEq8NK8IuMyJ5DHFyeILBy3MyHmW5v0qaLQmSm5OwS5u\",\"collection\":null,\"user_id\":3723,\"viewed_at\":\"2024-07-07 21:52:04\"},{\"id\":10,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":4,\"visitor\":\"NUE6dgeZ0Re9NfFGjQae6JMayBkzo9xdrGBfaWcwPdP40ZgZwbca6oGiwC39cG9E5171UIrA9Oq2fi47\",\"collection\":null,\"user_id\":3722,\"viewed_at\":\"2024-07-08 10:37:24\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":3722}}],\"followers\":[],\"partages\":[],\"traitements\":[],\"etapes\":[{\"id\":2,\"titre\":\"Secr\\u00e9tariat g\\u00e9n\\u00e9ral\",\"created_at\":\"2023-07-27T13:29:31.000000Z\",\"updated_at\":\"2023-07-27T13:29:31.000000Z\",\"pivot\":{\"courrier_id\":4,\"etape_id\":2,\"view_by\":3722,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:37:32.000000Z\"}}],\"author\":{\"id\":3723,\"user_id\":3723,\"lieu_id\":12,\"direction_id\":1,\"section_id\":null,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Isasi\",\"post_nom\":\"Mbadu\",\"prenom\":\"Francis\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-31\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":null,\"fonction_id\":57,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"3465\",\"image\":\"agents\\/May2024\\/OwNuwMfrXQNwZEUkW4WX.jpg\",\"slug\":\"luzolo-mbadu-martin\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-06T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:22:16.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[]}}}', NULL, '2024-07-08 09:37:32', '2024-07-08 09:37:32'),
('de66dd2a-3c4f-4434-bf01-0aa53ee78d83', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\"},\"message\":\"Vous a transmi un courrier sortant !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":5,\"document_id\":6,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0005-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":13,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":5,\"visitor\":\"ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-07-08 10:46:01\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":5,\"agent_id\":4074}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":11}},{\"id\":12,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/O82AcvE5Vf64sbIDvkBr.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"created_at\":\"2024-07-08T09:43:06.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":12}},{\"id\":13,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"pivot\":{\"courrier_id\":5,\"traitement_id\":13}}],\"etapes\":[{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":5,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:46:10.000000Z\"}}],\"author\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[]}}}', NULL, '2024-07-08 09:46:10', '2024-07-08 09:46:10'),
('e27da09e-8a8c-49d0-ba94-cbfcfc621f40', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"Un nouveau courrier trait\\u00e9 vous a \\u00e9t\\u00e9 transmis !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":1,\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":11}},{\"id\":12,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/O82AcvE5Vf64sbIDvkBr.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"created_at\":\"2024-07-08T09:43:06.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":12}},{\"id\":13,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:43:49.000000Z\",\"updated_at\":\"2024-07-08T09:43:49.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":13}}],\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-07-08 09:43:49', '2024-07-08 09:43:49'),
('e3944fab-6c21-4573-9cb0-c03c77be4e24', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\"},\"message\":\"A sign\\u00e9 le document du courrier\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"courrier\":{\"id\":4,\"document_id\":6,\"type_id\":1,\"exped_externe\":61,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"confidentiel\":0,\"reference_courrier\":\"1\\/03\\/1055\",\"reference_interne\":\"DG-0004-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-07-02T23:00:00.000000Z\",\"date_arrive\":\"2024-07-04T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":5,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"mark_as_done\":null,\"traitements\":[{\"id\":10,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-07-08T09:38:37.000000Z\",\"updated_at\":\"2024-07-08T09:38:37.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":10}},{\"id\":11,\"agent_id\":4074,\"note\":\"Pri\\u00e8re de signer ce document au plus t\\u00f4t. Merci !\",\"document_url\":null,\"created_at\":\"2024-07-08T09:40:15.000000Z\",\"updated_at\":\"2024-07-08T09:40:15.000000Z\",\"pivot\":{\"courrier_id\":4,\"traitement_id\":11}}],\"document\":{\"id\":6,\"dossier_id\":1,\"category_id\":5,\"reference\":\"1\\/03\\/1055\",\"libelle\":\"FICHE D\\u2019ACCEPTATION\\r\\nRAPPORT D\\u2019INTERVENTION\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/July2024\\\\\\/WCafcZGQWbMHhHrgjMFu.pdf\\\",\\\"original_name\\\":\\\"Fiche d\'acceptation : Rapport d\'intervention.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-07-07T20:52:03.000000Z\",\"updated_at\":\"2024-07-08T09:43:06.000000Z\",\"deleted_at\":null},\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":\"agents\\/May2024\\/C6BDfRwrFvVwTXNPoam4.jpg\",\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:19:23.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":4074}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":1}},{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/June2024\\/RKJI0lb9CCPs8Evn45HQ.png\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-06-11T11:59:55.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":4,\"agent_id\":1}}]}}}', NULL, '2024-07-08 09:43:06', '2024-07-08 09:43:06'),
('e9aab20a-3c21-4c75-9104-499ad179b8ec', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 4074, '{\"data\":{\"agent\":{\"name\":\"Herve Kinsala\",\"image\":\"agents\\/May2024\\/SsethDWqm2jPxeOpHw1l.jpg\"},\"message\":\"Un nouveau courrier trait\\u00e9 vous a \\u00e9t\\u00e9 transmis !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":1,\"created_by\":3723,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":1,\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":1,\"traitement_id\":5}}],\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-05-29 19:49:27', '2024-05-29 19:49:27');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('ea95925d-7653-4327-93cc-0fbbdb7dde23', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Caleb Kuedisala\",\"image\":null},\"message\":\"Vous a transmi un courrier sortant !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":2,\"document_id\":1,\"type_id\":2,\"exped_externe\":null,\"exped_interne_id\":1,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0002-SOR\",\"priorite_id\":0,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":1,\"parent_id\":null,\"statut_id\":2,\"updated_at\":\"2024-05-29T19:49:27.000000Z\",\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":6,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":5,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":2,\"visitor\":\"bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z\",\"collection\":null,\"user_id\":1,\"viewed_at\":\"2024-05-29 20:50:59\"},{\"id\":6,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":2,\"visitor\":\"ul7Va7KeLc3AK4X2pxKdpIv8BQg17LHZSmWwgE6qIREJQOkyCKQXn56oPW34zIfEn7igfKwmjpqYV4dE\",\"collection\":null,\"user_id\":4074,\"viewed_at\":\"2024-05-29 20:51:41\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":3722}},{\"id\":4074,\"user_id\":4074,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":18,\"statut_id\":1,\"nom\":\"Kuedisala\",\"post_nom\":\"Mbongo\",\"prenom\":\"Caleb\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-25\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":1,\"fonction_id\":64,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2399\",\"image\":null,\"slug\":\"mbulungu-mukuna-sylvestre\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2034-11-22T08:59:43.000000Z\",\"updated_at\":\"2023-10-25T11:22:20.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":2,\"agent_id\":4074}}],\"followers\":[],\"partages\":[],\"traitements\":[{\"id\":1,\"agent_id\":3722,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T18:34:23.000000Z\",\"updated_at\":\"2024-05-29T18:34:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":1}},{\"id\":2,\"agent_id\":4074,\"note\":\"RAS\",\"document_url\":null,\"created_at\":\"2024-05-29T18:41:04.000000Z\",\"updated_at\":\"2024-05-29T18:41:04.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":2}},{\"id\":3,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/YWsILxvjyYF15NWEWqrK.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:00:52.000000Z\",\"updated_at\":\"2024-05-29T19:00:52.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":3}},{\"id\":4,\"agent_id\":1,\"note\":\"Document valid\\u00e9\",\"document_url\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/ormGdulI3cvRFTgs18Gi.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"created_at\":\"2024-05-29T19:06:23.000000Z\",\"updated_at\":\"2024-05-29T19:06:23.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":4}},{\"id\":5,\"agent_id\":1,\"note\":\"Document trait\\u00e9\",\"document_url\":null,\"created_at\":\"2024-05-29T19:49:26.000000Z\",\"updated_at\":\"2024-05-29T19:49:26.000000Z\",\"pivot\":{\"courrier_id\":2,\"traitement_id\":5}}],\"etapes\":[{\"id\":3,\"titre\":\"Assistant\",\"created_at\":\"2023-07-27T13:30:29.000000Z\",\"updated_at\":\"2023-07-27T13:30:29.000000Z\",\"pivot\":{\"courrier_id\":2,\"etape_id\":3,\"view_by\":4074,\"created_at\":\"2024-05-29T19:49:27.000000Z\",\"updated_at\":\"2024-05-29T19:51:55.000000Z\"}}],\"author\":{\"id\":1,\"user_id\":1,\"lieu_id\":12,\"direction_id\":1,\"section_id\":47,\"grade_id\":1,\"statut_id\":1,\"nom\":\"Kinsala\",\"post_nom\":\"Kinsala\",\"prenom\":\"Herve\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":null,\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":28,\"fonction_id\":1,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"435\",\"image\":\"agents\\/May2024\\/SsethDWqm2jPxeOpHw1l.jpg\",\"slug\":\"david-mutombo-tshilumba\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":1,\"created_at\":\"2033-11-24T08:59:43.000000Z\",\"updated_at\":\"2024-05-29T19:48:46.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[]}}}', NULL, '2024-05-29 19:51:55', '2024-05-29 19:51:55'),
('f3edd0d9-29f6-4c8a-9777-bf87e81840a8', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3722, '{\"data\":{\"agent\":{\"name\":\"Francis Isasi\",\"image\":\"agents\\/May2024\\/OwNuwMfrXQNwZEUkW4WX.jpg\"},\"message\":\"A cr\\u00e9\\u00e9 un nouveau courrier !\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/zFu99N3rXaFTaqA3Q3P0.pdf\\\",\\\"original_name\\\":\\\"CG-Skello.pdf\\\"}]\",\"courrier\":{\"type_id\":\"1\",\"category_id\":\"5\",\"exped_externe\":\"44\",\"reference_courrier\":\"12\\/10\\/2020\",\"reference_interne\":\"DG-0003-ENT\",\"confidentiel\":\"0\",\"title\":\"Conditions g\\u00e9n\\u00e9rales des services accessibles sur la plateforme\\r\\nskello.io\",\"nature_id\":\"6\",\"date_du_courrier\":\"2024-05-22T23:00:00.000000Z\",\"date_arrive\":\"2024-05-29T23:00:00.000000Z\",\"objet\":null,\"document_id\":2,\"created_by\":3723,\"statut_id\":1,\"updated_at\":\"2024-05-30T10:50:46.000000Z\",\"created_at\":\"2024-05-30T10:50:46.000000Z\",\"id\":3,\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":\"agents\\/May2024\\/alCnuKDXT8SiK691Xh8O.jpg\",\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2024-05-30T10:20:35.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":3,\"agent_id\":3722}}],\"document\":{\"id\":2,\"dossier_id\":1,\"category_id\":5,\"reference\":\"12\\/10\\/2020\",\"libelle\":\"Conditions g\\u00e9n\\u00e9rales des services accessibles sur la plateforme\\r\\nskello.io\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/zFu99N3rXaFTaqA3Q3P0.pdf\\\",\\\"original_name\\\":\\\"CG-Skello.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-05-30T10:50:46.000000Z\",\"updated_at\":\"2024-05-30T10:50:46.000000Z\",\"deleted_at\":null}}}}', NULL, '2024-05-30 10:50:47', '2024-05-30 10:50:47'),
('ff6cccf7-18ee-4638-986f-4c6dd67c6f19', 'App\\Notifications\\CourrierNotification', 'App\\Models\\Agent', 3723, '{\"data\":{\"agent\":{\"name\":\"Yasmine Kabengele\",\"image\":null},\"message\":\"A accus\\u00e9 reception du courrier transmis\",\"object\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"courrier\":{\"id\":1,\"document_id\":1,\"type_id\":1,\"exped_externe\":60,\"exped_interne_id\":null,\"dest_externe_id\":null,\"dest_interne_id\":null,\"departement_id\":null,\"service_id\":null,\"service_traitant_id\":null,\"is_intern\":1,\"title\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"confidentiel\":0,\"reference_courrier\":\"12345\",\"reference_interne\":\"DG-0001-ENT\",\"priorite_id\":null,\"date_du_courrier\":\"2024-05-13T23:00:00.000000Z\",\"date_arrive\":\"2024-05-28T23:00:00.000000Z\",\"date_fin\":null,\"nature_id\":2,\"objet\":null,\"copie\":null,\"category_id\":2,\"is_classified\":0,\"traitement_id\":null,\"created_by\":3723,\"parent_id\":null,\"statut_id\":1,\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"mark_as_done\":null,\"document\":{\"id\":1,\"dossier_id\":1,\"category_id\":2,\"reference\":\"12345\",\"libelle\":\"La cour d\'appel : Organisation, comp\\u00e9tence, organisation et exposer la proc\\u00e9dure et ses effets\",\"type\":1,\"description\":null,\"document\":\"[{\\\"download_link\\\":\\\"documents\\\\\\/May2024\\\\\\/42AYLHZf4zlW2vIlFZPe.pdf\\\",\\\"original_name\\\":\\\"cour_appel_1.pdf\\\"}]\",\"confidentiel\":0,\"password\":null,\"user_id\":3723,\"statut_id\":1,\"created_by\":3723,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:25:32.000000Z\",\"deleted_at\":null},\"views\":[{\"id\":1,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":1,\"visitor\":\"bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z\",\"collection\":null,\"user_id\":3723,\"viewed_at\":\"2024-05-29 19:25:32\"},{\"id\":2,\"viewable_type\":\"App\\\\Models\\\\Courrier\",\"viewable_id\":1,\"visitor\":\"0iQFadonlAd4dgG1ePdcHkeN94NCKDbYGa7MAURejYql7xrLxZE8kxjuPkPOIaLboi592vaa52ovHYPI\",\"collection\":null,\"user_id\":3722,\"viewed_at\":\"2024-05-29 19:29:32\"}],\"destinateurs\":[{\"id\":3722,\"user_id\":3722,\"lieu_id\":12,\"direction_id\":1,\"section_id\":0,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Kabengele\",\"post_nom\":\"Tala\",\"prenom\":\"Yasmine\",\"sexe\":\"F\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-19\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":1,\"service_id\":2,\"fonction_id\":63,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"2863\",\"image\":null,\"slug\":\"mbombo-tshitende-lydie\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-05T08:59:43.000000Z\",\"updated_at\":\"2023-10-19T06:13:08.000000Z\",\"deleted_at\":null,\"pivot\":{\"courrier_id\":1,\"agent_id\":3722}}],\"followers\":[],\"partages\":[],\"traitements\":[],\"etapes\":[{\"id\":2,\"titre\":\"Secr\\u00e9tariat g\\u00e9n\\u00e9ral\",\"created_at\":\"2023-07-27T13:29:31.000000Z\",\"updated_at\":\"2023-07-27T13:29:31.000000Z\",\"pivot\":{\"courrier_id\":1,\"etape_id\":2,\"view_by\":3722,\"created_at\":\"2024-05-29T18:25:32.000000Z\",\"updated_at\":\"2024-05-29T18:30:48.000000Z\"}}],\"author\":{\"id\":3723,\"user_id\":3723,\"lieu_id\":12,\"direction_id\":1,\"section_id\":null,\"grade_id\":16,\"statut_id\":1,\"nom\":\"Isasi\",\"post_nom\":\"Mbadu\",\"prenom\":\"Francis\",\"sexe\":\"M\",\"lieu_naiss\":null,\"date_naiss\":\"2023-10-31\",\"province\":null,\"ville\":null,\"etat_civil\":null,\"division_id\":0,\"service_id\":null,\"fonction_id\":57,\"nbr_enfant\":null,\"nationalite\":null,\"matricule\":\"3465\",\"image\":null,\"slug\":\"luzolo-mbadu-martin\",\"created_by\":1,\"delegue_id\":null,\"updated_by\":3879,\"created_at\":\"2033-12-06T08:59:43.000000Z\",\"updated_at\":\"2023-10-31T05:37:03.000000Z\",\"deleted_at\":null},\"accuse_receptions\":[]}}}', '2024-06-20 15:06:21', '2024-05-29 18:30:48', '2024-06-20 15:06:21');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'Voir le tableau de bord', 'web', 1, '2023-07-26 10:51:07', '2023-07-26 10:51:07'),
(2, 'Voir les courriers', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(3, 'Voir les taches', 'web', 3, '2023-07-26 10:56:11', '2023-07-26 10:56:11'),
(4, 'Voir les documents', 'web', 4, '2023-07-26 11:06:21', '2023-07-26 11:06:21'),
(5, 'Voir les archives', 'web', 5, '2023-07-26 11:25:51', '2023-07-26 11:25:51'),
(6, 'Gerer les personnels', 'web', 6, '2023-07-26 11:31:15', '2023-07-26 11:31:15'),
(7, 'Voir les parametres', 'web', 7, '2023-07-26 11:37:37', '2023-07-26 11:37:37'),
(8, 'Voir les lieux d\'affectations', 'web', 7, '2023-07-26 11:51:06', '2023-07-26 11:51:06'),
(9, 'Voir les Directions', 'web', 7, '2023-07-26 11:56:45', '2023-07-26 11:56:45'),
(10, 'Voir les Divisions', 'web', 7, '2023-07-26 11:56:45', '2023-07-26 11:56:45'),
(11, 'Voir les Services', 'web', 7, '2023-07-26 11:56:45', '2023-07-26 11:56:45'),
(12, 'Voir les Sections', 'web', 7, '2023-07-26 11:56:45', '2023-07-26 11:56:45'),
(13, 'Voir les Fonctions', 'web', 7, '2023-07-26 12:02:42', '2023-07-26 12:02:42'),
(14, 'Voir les Grades', 'web', 7, '2023-07-26 12:02:42', '2023-07-26 12:02:42'),
(15, 'Voir les Secretaires', 'web', 7, '2023-07-26 12:02:42', '2023-07-26 12:02:42'),
(16, 'Voir les Assistants', 'web', 7, '2023-07-26 12:02:42', '2023-07-26 12:02:42'),
(17, 'Suivi des courriers', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(18, 'Enregistre un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(19, 'Modifier un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(20, 'Signer un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(21, 'Traiter un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(22, 'Classer un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(23, 'Cloturer un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(24, 'Mettre en copie', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(25, 'Définir la priorité du courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(26, 'Definir le traitement', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(27, 'Définir la date d\'échéance', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(28, 'Créer un document', 'web', 4, '2023-07-26 11:06:21', '2023-07-26 11:06:21'),
(29, 'Enregistrer un courrier entrant', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(30, 'Enregistrer un courrier sortant', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(31, 'Enregistrer un courrier interne', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(32, 'Partager un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(33, 'Assigner une tâche', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(34, 'Rejeter un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(35, 'Annoter un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(36, 'Valider un courrier', 'web', 2, '2023-07-26 10:53:19', '2023-07-26 10:53:19'),
(37, 'Archiver les documents', 'web', 4, '2023-07-26 11:06:21', '2023-07-26 11:06:21'),
(38, 'Telecharger un document', 'web', 4, '2023-12-21 11:04:20', '2023-12-21 11:04:20'),
(39, 'Imprimer un document', 'web', 4, '2023-12-21 11:04:21', '2023-12-21 11:04:21');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pivot_agent_fonctions`
--

CREATE TABLE `pivot_agent_fonctions` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `fonction_id` bigint(20) DEFAULT NULL,
  `statut_id` bigint(20) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pivot_documents_agents`
--

CREATE TABLE `pivot_documents_agents` (
  `id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `document_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pivot_documents_notes`
--

CREATE TABLE `pivot_documents_notes` (
  `id` bigint(20) NOT NULL,
  `document_id` bigint(20) DEFAULT NULL,
  `note_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pivot_taches_agents`
--

CREATE TABLE `pivot_taches_agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `tache_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pivot_taches_agents`
--

INSERT INTO `pivot_taches_agents` (`id`, `agent_id`, `tache_id`, `type`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, '2024-06-20 15:21:21', '2024-06-20 15:21:21'),
(2, 4420, 1, NULL, NULL, '2024-06-20 15:21:44', '2024-06-20 15:21:44'),
(3, 4420, 2, NULL, NULL, '2024-06-20 15:25:53', '2024-06-20 15:25:53'),
(4, 3722, 2, NULL, NULL, '2024-06-20 15:29:44', '2024-06-20 15:29:44'),
(5, 4074, 2, NULL, NULL, '2024-06-20 15:36:58', '2024-06-20 15:36:58');

-- --------------------------------------------------------

--
-- Structure de la table `pivot_taches_cibles`
--

CREATE TABLE `pivot_taches_cibles` (
  `id` bigint(20) NOT NULL,
  `cible_id` bigint(20) DEFAULT NULL,
  `tache_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pivot_user_conges`
--

CREATE TABLE `pivot_user_conges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `debut` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jour` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `montant` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conge_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pivot_user_taches`
--

CREATE TABLE `pivot_user_taches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `tache_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pointages`
--

CREATE TABLE `pointages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplementaire` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00:00',
  `majoree` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `priorites`
--

CREATE TABLE `priorites` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `priorites`
--

INSERT INTO `priorites` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Normale', '2022-11-14 03:33:03', '2022-11-14 03:33:03', NULL),
(2, 'Absolue', '2022-11-14 03:33:03', '2022-11-14 03:33:03', NULL),
(3, 'Urgente', '2022-11-14 13:33:46', '2022-11-14 13:33:46', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscribable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribable_id` bigint(20) UNSIGNED NOT NULL,
  `endpoint` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_encoding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `push_subscriptions`
--

INSERT INTO `push_subscriptions` (`id`, `subscribable_type`, `subscribable_id`, `endpoint`, `public_key`, `auth_token`, `content_encoding`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Agent', 1, 'https://updates.push.services.mozilla.com/wpush/v2/gAAAAABmdEzETjGhfz3HgE_IK7db3iGXaOi3_MZEINIhXrGofIR8lRCU2ehWeUNgP4IKs6RYucYtZ5yN_tePzkinQ-Z6VZ66m12Pp0fiRZ9wt8JAUpBt6a7suL-QYfzFKxrR6FMb3Iwz6QKBaoc2vBBcJ80za3N3eosDobnEnVuL8MDvu6YEdQk', 'BA-WYlKJxFz8Z90qzPKnbNXZqDI4E382f8UFKC_F0bmNhZdk-4VTPaWW0_YQ46jk2bjFugfaz8566P-jsPbl3yo', '463HrbA9Crd8oiF0LdYTFA', NULL, '2024-06-20 15:37:41', '2024-06-20 15:37:41');

-- --------------------------------------------------------

--
-- Structure de la table `revisions`
--

CREATE TABLE `revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `revisionable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `revisions`
--

INSERT INTO `revisions` (`id`, `revisionable_type`, `revisionable_id`, `user_id`, `key`, `old_value`, `new_value`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Document', 1, 3723, 'created_at', NULL, '2023-11-29 09:55:05', '2023-11-29 08:55:05', '2023-11-29 08:55:05'),
(2, 'App\\Models\\Courrier', 1, 3723, 'created_at', NULL, '2023-11-29 09:55:05', '2023-11-29 08:55:05', '2023-11-29 08:55:05'),
(3, 'App\\Models\\Courrier', 1, 3722, 'statut_id', '1', '2', '2023-11-29 08:55:59', '2023-11-29 08:55:59'),
(4, 'App\\Models\\Courrier', 1, 3722, 'traitement_id', NULL, '4', '2023-11-29 08:56:08', '2023-11-29 08:56:08'),
(5, 'App\\Models\\Document', 2, 3723, 'created_at', NULL, '2023-11-30 15:24:47', '2023-11-30 14:24:47', '2023-11-30 14:24:47'),
(6, 'App\\Models\\Courrier', 2, 3723, 'created_at', NULL, '2023-11-30 15:24:47', '2023-11-30 14:24:47', '2023-11-30 14:24:47'),
(7, 'App\\Models\\Courrier', 2, 3722, 'statut_id', '1', '2', '2023-11-30 14:25:45', '2023-11-30 14:25:45'),
(8, 'App\\Models\\Courrier', 2, 3722, 'traitement_id', NULL, '4', '2023-11-30 14:25:54', '2023-11-30 14:25:54'),
(9, 'App\\Models\\Document', 3, 4082, 'created_at', NULL, '2023-11-30 16:30:15', '2023-11-30 15:30:15', '2023-11-30 15:30:15'),
(10, 'App\\Models\\Document', 2, 4083, 'statut_id', '1', '6', '2023-11-30 15:34:41', '2023-11-30 15:34:41'),
(11, 'App\\Models\\Document', 3, 4083, 'statut_id', '1', '6', '2023-11-30 15:34:41', '2023-11-30 15:34:41'),
(12, 'App\\Models\\Document', 4, 4083, 'created_at', NULL, '2023-11-30 16:37:15', '2023-11-30 15:37:15', '2023-11-30 15:37:15'),
(13, 'App\\Models\\Document', 4, 1, 'statut_id', '1', '6', '2023-11-30 15:39:56', '2023-11-30 15:39:56'),
(14, 'App\\Models\\Document', 5, 1, 'created_at', NULL, '2023-11-30 16:39:56', '2023-11-30 15:39:56', '2023-11-30 15:39:56'),
(15, 'App\\Models\\Document', 6, 1, 'created_at', NULL, '2023-11-30 16:39:57', '2023-11-30 15:39:57', '2023-11-30 15:39:57'),
(16, 'App\\Models\\Courrier', 3, 1, 'created_at', NULL, '2023-11-30 16:39:57', '2023-11-30 15:39:57', '2023-11-30 15:39:57'),
(17, 'App\\Models\\Document', 7, 3723, 'created_at', NULL, '2023-12-02 13:18:15', '2023-12-02 12:18:15', '2023-12-02 12:18:15'),
(18, 'App\\Models\\Courrier', 4, 3723, 'created_at', NULL, '2023-12-02 13:18:15', '2023-12-02 12:18:15', '2023-12-02 12:18:15'),
(19, 'App\\Models\\Courrier', 4, 3722, 'statut_id', '1', '2', '2023-12-02 12:19:37', '2023-12-02 12:19:37'),
(20, 'App\\Models\\Courrier', 4, 3722, 'traitement_id', NULL, '4', '2023-12-02 12:20:03', '2023-12-02 12:20:03'),
(21, 'App\\Models\\Document', 8, 4082, 'created_at', NULL, '2023-12-02 13:37:33', '2023-12-02 12:37:33', '2023-12-02 12:37:33'),
(22, 'App\\Models\\Document', 7, 4083, 'statut_id', '1', '6', '2023-12-02 12:39:45', '2023-12-02 12:39:45'),
(23, 'App\\Models\\Document', 8, 4083, 'statut_id', '1', '6', '2023-12-02 12:39:45', '2023-12-02 12:39:45'),
(24, 'App\\Models\\Document', 9, 4083, 'created_at', NULL, '2023-12-02 13:42:06', '2023-12-02 12:42:06', '2023-12-02 12:42:06'),
(25, 'App\\Models\\Document', 9, 1, 'statut_id', '1', '6', '2023-12-02 12:46:10', '2023-12-02 12:46:10'),
(26, 'App\\Models\\Document', 10, 1, 'created_at', NULL, '2023-12-02 13:46:10', '2023-12-02 12:46:10', '2023-12-02 12:46:10'),
(27, 'App\\Models\\Document', 11, 1, 'created_at', NULL, '2023-12-02 13:46:10', '2023-12-02 12:46:10', '2023-12-02 12:46:10'),
(28, 'App\\Models\\Courrier', 5, 1, 'created_at', NULL, '2023-12-02 13:46:10', '2023-12-02 12:46:10', '2023-12-02 12:46:10'),
(29, 'App\\Models\\Document', 12, 3723, 'created_at', NULL, '2023-12-05 11:41:53', '2023-12-05 10:41:53', '2023-12-05 10:41:53'),
(30, 'App\\Models\\Courrier', 6, 3723, 'created_at', NULL, '2023-12-05 11:41:53', '2023-12-05 10:41:53', '2023-12-05 10:41:53'),
(31, 'App\\Models\\Courrier', 6, 3722, 'statut_id', '1', '2', '2023-12-05 10:44:22', '2023-12-05 10:44:22'),
(32, 'App\\Models\\Courrier', 6, 3722, 'traitement_id', NULL, '4', '2023-12-05 10:45:44', '2023-12-05 10:45:44'),
(33, 'App\\Models\\Document', 13, 4082, 'created_at', NULL, '2023-12-05 12:42:35', '2023-12-05 11:42:35', '2023-12-05 11:42:35'),
(34, 'App\\Models\\Document', 12, 4083, 'statut_id', '1', '6', '2023-12-05 11:45:58', '2023-12-05 11:45:58'),
(35, 'App\\Models\\Document', 13, 4083, 'statut_id', '1', '6', '2023-12-05 11:45:58', '2023-12-05 11:45:58'),
(36, 'App\\Models\\Document', 14, 1, 'created_at', NULL, '2023-12-05 14:38:20', '2023-12-05 13:38:20', '2023-12-05 13:38:20'),
(37, 'App\\Models\\Courrier', 7, 1, 'created_at', NULL, '2023-12-05 14:38:20', '2023-12-05 13:38:20', '2023-12-05 13:38:20'),
(38, 'App\\Models\\Document', 15, 3723, 'created_at', NULL, '2023-12-05 19:42:43', '2023-12-05 18:42:44', '2023-12-05 18:42:44'),
(39, 'App\\Models\\Courrier', 8, 3723, 'created_at', NULL, '2023-12-05 19:42:44', '2023-12-05 18:42:44', '2023-12-05 18:42:44'),
(40, 'App\\Models\\Courrier', 8, 3722, 'statut_id', '1', '2', '2023-12-05 18:43:50', '2023-12-05 18:43:50'),
(41, 'App\\Models\\Courrier', 8, 3722, 'traitement_id', NULL, '4', '2023-12-05 18:44:04', '2023-12-05 18:44:04'),
(42, 'App\\Models\\Document', 16, 4082, 'created_at', NULL, '2023-12-05 19:52:23', '2023-12-05 18:52:24', '2023-12-05 18:52:24'),
(43, 'App\\Models\\Document', 17, 4082, 'created_at', NULL, '2023-12-05 19:52:47', '2023-12-05 18:52:47', '2023-12-05 18:52:47'),
(44, 'App\\Models\\Document', 18, 4082, 'created_at', NULL, '2023-12-05 19:56:35', '2023-12-05 18:56:35', '2023-12-05 18:56:35'),
(45, 'App\\Models\\Document', 15, 4083, 'statut_id', '1', '6', '2023-12-05 19:05:25', '2023-12-05 19:05:25'),
(46, 'App\\Models\\Document', 16, 4083, 'statut_id', '1', '6', '2023-12-05 19:05:25', '2023-12-05 19:05:25'),
(47, 'App\\Models\\Document', 17, 4083, 'statut_id', '1', '6', '2023-12-05 19:05:25', '2023-12-05 19:05:25'),
(48, 'App\\Models\\Document', 18, 4083, 'statut_id', '1', '6', '2023-12-05 19:05:25', '2023-12-05 19:05:25'),
(49, 'App\\Models\\Document', 19, 3723, 'created_at', NULL, '2023-12-06 08:51:08', '2023-12-06 07:51:08', '2023-12-06 07:51:08'),
(50, 'App\\Models\\Courrier', 9, 3723, 'created_at', NULL, '2023-12-06 08:51:08', '2023-12-06 07:51:08', '2023-12-06 07:51:08'),
(51, 'App\\Models\\Courrier', 9, 3722, 'statut_id', '1', '2', '2023-12-06 07:57:47', '2023-12-06 07:57:47'),
(52, 'App\\Models\\Courrier', 9, 3722, 'priorite_id', NULL, '3', '2023-12-06 07:58:22', '2023-12-06 07:58:22'),
(53, 'App\\Models\\Courrier', 9, 3722, 'traitement_id', NULL, '4', '2023-12-06 07:58:22', '2023-12-06 07:58:22'),
(54, 'App\\Models\\Courrier', 9, 4074, 'priorite_id', '3', '1', '2023-12-06 08:07:32', '2023-12-06 08:07:32'),
(55, 'App\\Models\\Document', 20, 4077, 'created_at', NULL, '2023-12-06 16:34:32', '2023-12-06 15:34:32', '2023-12-06 15:34:32'),
(56, 'App\\Models\\Document', 21, 4077, 'created_at', NULL, '2023-12-06 16:35:18', '2023-12-06 15:35:18', '2023-12-06 15:35:18'),
(57, 'App\\Models\\Document', 22, 4077, 'created_at', NULL, '2023-12-06 16:38:49', '2023-12-06 15:38:49', '2023-12-06 15:38:49'),
(58, 'App\\Models\\Document', 23, 4077, 'created_at', NULL, '2023-12-06 16:42:21', '2023-12-06 15:42:21', '2023-12-06 15:42:21'),
(59, 'App\\Models\\Document', 24, 4077, 'created_at', NULL, '2023-12-06 16:54:50', '2023-12-06 15:54:50', '2023-12-06 15:54:50'),
(60, 'App\\Models\\Document', 25, 4077, 'created_at', NULL, '2023-12-06 17:08:49', '2023-12-06 16:08:49', '2023-12-06 16:08:49'),
(61, 'App\\Models\\Document', 26, 4077, 'created_at', NULL, '2023-12-06 17:31:43', '2023-12-06 16:31:43', '2023-12-06 16:31:43'),
(62, 'App\\Models\\Document', 19, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:30', '2023-12-06 16:36:30'),
(63, 'App\\Models\\Document', 20, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:30', '2023-12-06 16:36:30'),
(64, 'App\\Models\\Document', 21, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:31', '2023-12-06 16:36:31'),
(65, 'App\\Models\\Document', 22, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:31', '2023-12-06 16:36:31'),
(66, 'App\\Models\\Document', 23, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:31', '2023-12-06 16:36:31'),
(67, 'App\\Models\\Document', 24, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:31', '2023-12-06 16:36:31'),
(68, 'App\\Models\\Document', 25, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:31', '2023-12-06 16:36:31'),
(69, 'App\\Models\\Document', 26, 4078, 'statut_id', '1', '6', '2023-12-06 16:36:31', '2023-12-06 16:36:31'),
(70, 'App\\Models\\Document', 27, 3723, 'created_at', NULL, '2023-12-07 12:06:22', '2023-12-07 11:06:23', '2023-12-07 11:06:23'),
(71, 'App\\Models\\Courrier', 10, 3723, 'created_at', NULL, '2023-12-07 12:06:23', '2023-12-07 11:06:23', '2023-12-07 11:06:23'),
(72, 'App\\Models\\Courrier', 10, 3722, 'statut_id', '1', '2', '2023-12-07 11:07:26', '2023-12-07 11:07:26'),
(73, 'App\\Models\\Courrier', 10, 3722, 'traitement_id', NULL, '4', '2023-12-07 11:07:34', '2023-12-07 11:07:34'),
(74, 'App\\Models\\Document', 27, 4083, 'statut_id', '1', '6', '2023-12-07 11:23:16', '2023-12-07 11:23:16'),
(75, 'App\\Models\\Document', 28, 4082, 'created_at', NULL, '2023-12-07 12:24:53', '2023-12-07 11:24:53', '2023-12-07 11:24:53'),
(76, 'App\\Models\\Document', 28, 4083, 'statut_id', '1', '6', '2023-12-07 11:28:00', '2023-12-07 11:28:00'),
(77, 'App\\Models\\Document', 29, 4083, 'created_at', NULL, '2023-12-07 12:29:29', '2023-12-07 11:29:29', '2023-12-07 11:29:29'),
(78, 'App\\Models\\Document', 30, 4083, 'created_at', NULL, '2023-12-07 12:30:17', '2023-12-07 11:30:17', '2023-12-07 11:30:17'),
(79, 'App\\Models\\Document', 29, 1, 'statut_id', '1', '6', '2023-12-07 11:31:50', '2023-12-07 11:31:50'),
(80, 'App\\Models\\Document', 30, 1, 'statut_id', '1', '6', '2023-12-07 11:31:50', '2023-12-07 11:31:50'),
(81, 'App\\Models\\Document', 31, 1, 'created_at', NULL, '2023-12-07 12:31:50', '2023-12-07 11:31:50', '2023-12-07 11:31:50'),
(82, 'App\\Models\\Document', 32, 1, 'created_at', NULL, '2023-12-07 12:31:50', '2023-12-07 11:31:50', '2023-12-07 11:31:50'),
(83, 'App\\Models\\Document', 33, 1, 'created_at', NULL, '2023-12-07 12:31:53', '2023-12-07 11:31:53', '2023-12-07 11:31:53'),
(84, 'App\\Models\\Document', 34, 1, 'created_at', NULL, '2023-12-07 12:31:53', '2023-12-07 11:31:53', '2023-12-07 11:31:53'),
(85, 'App\\Models\\Document', 35, 1, 'created_at', NULL, '2023-12-07 12:34:28', '2023-12-07 11:34:28', '2023-12-07 11:34:28'),
(86, 'App\\Models\\Document', 36, 1, 'created_at', NULL, '2023-12-07 12:34:29', '2023-12-07 11:34:29', '2023-12-07 11:34:29'),
(87, 'App\\Models\\Document', 37, 1, 'created_at', NULL, '2023-12-07 12:36:00', '2023-12-07 11:36:00', '2023-12-07 11:36:00'),
(88, 'App\\Models\\Document', 38, 1, 'created_at', NULL, '2023-12-07 12:36:00', '2023-12-07 11:36:00', '2023-12-07 11:36:00'),
(89, 'App\\Models\\Document', 39, 3723, 'created_at', NULL, '2023-12-11 15:36:24', '2023-12-11 14:36:24', '2023-12-11 14:36:24'),
(90, 'App\\Models\\Courrier', 11, 3723, 'created_at', NULL, '2023-12-11 15:36:24', '2023-12-11 14:36:24', '2023-12-11 14:36:24'),
(91, 'App\\Models\\Document', 40, 3723, 'created_at', NULL, '2023-12-11 15:39:28', '2023-12-11 14:39:28', '2023-12-11 14:39:28'),
(92, 'App\\Models\\Courrier', 12, 3723, 'created_at', NULL, '2023-12-11 15:39:28', '2023-12-11 14:39:28', '2023-12-11 14:39:28'),
(93, 'App\\Models\\Document', 41, 3723, 'created_at', NULL, '2023-12-12 12:17:51', '2023-12-12 11:17:51', '2023-12-12 11:17:51'),
(94, 'App\\Models\\Courrier', 13, 3723, 'created_at', NULL, '2023-12-12 12:17:51', '2023-12-12 11:17:51', '2023-12-12 11:17:51'),
(95, 'App\\Models\\Courrier', 13, 3722, 'statut_id', '1', '2', '2023-12-12 11:22:31', '2023-12-12 11:22:31'),
(96, 'App\\Models\\Courrier', 13, 4074, 'traitement_id', NULL, '4', '2023-12-12 11:28:49', '2023-12-12 11:28:49'),
(97, 'App\\Models\\Document', 42, 3723, 'created_at', NULL, '2023-12-12 13:18:50', '2023-12-12 12:18:50', '2023-12-12 12:18:50'),
(98, 'App\\Models\\Courrier', 14, 3723, 'created_at', NULL, '2023-12-12 13:18:50', '2023-12-12 12:18:50', '2023-12-12 12:18:50'),
(99, 'App\\Models\\Courrier', 14, 3722, 'statut_id', '1', '2', '2023-12-12 12:19:40', '2023-12-12 12:19:40'),
(100, 'App\\Models\\Courrier', 14, 3722, 'traitement_id', NULL, '4', '2023-12-12 12:19:49', '2023-12-12 12:19:49'),
(101, 'App\\Models\\Document', 43, 3723, 'created_at', NULL, '2023-12-12 13:30:41', '2023-12-12 12:30:41', '2023-12-12 12:30:41'),
(102, 'App\\Models\\Courrier', 15, 3723, 'created_at', NULL, '2023-12-12 13:30:41', '2023-12-12 12:30:41', '2023-12-12 12:30:41'),
(103, 'App\\Models\\Courrier', 15, 3722, 'statut_id', '1', '2', '2023-12-12 12:31:21', '2023-12-12 12:31:21'),
(104, 'App\\Models\\Courrier', 15, 3722, 'traitement_id', NULL, '4', '2023-12-12 12:31:36', '2023-12-12 12:31:36'),
(105, 'App\\Models\\Document', 44, 4082, 'created_at', NULL, '2023-12-12 13:40:50', '2023-12-12 12:40:50', '2023-12-12 12:40:50'),
(106, 'App\\Models\\Document', 43, 4083, 'statut_id', '1', '6', '2023-12-12 12:45:35', '2023-12-12 12:45:35'),
(107, 'App\\Models\\Document', 44, 4083, 'statut_id', '1', '6', '2023-12-12 12:45:35', '2023-12-12 12:45:35'),
(108, 'App\\Models\\Document', 45, 4083, 'created_at', NULL, '2023-12-12 13:48:01', '2023-12-12 12:48:01', '2023-12-12 12:48:01'),
(109, 'App\\Models\\Document', 46, 4083, 'created_at', NULL, '2023-12-12 13:50:17', '2023-12-12 12:50:17', '2023-12-12 12:50:17'),
(110, 'App\\Models\\Courrier', 15, 1, 'mark_as_done', NULL, '1', '2023-12-12 13:01:59', '2023-12-12 13:01:59'),
(111, 'App\\Models\\Document', 47, 1, 'created_at', NULL, '2023-12-12 14:01:59', '2023-12-12 13:01:59', '2023-12-12 13:01:59'),
(112, 'App\\Models\\Courrier', 16, 1, 'created_at', NULL, '2023-12-12 14:01:59', '2023-12-12 13:01:59', '2023-12-12 13:01:59'),
(113, 'App\\Models\\Document', 48, 3721, 'created_at', NULL, '2023-12-12 14:29:47', '2023-12-12 13:29:47', '2023-12-12 13:29:47'),
(114, 'App\\Models\\Courrier', 17, 3721, 'created_at', NULL, '2023-12-12 14:29:47', '2023-12-12 13:29:47', '2023-12-12 13:29:47'),
(115, 'App\\Models\\Document', 49, 3723, 'created_at', NULL, '2023-12-12 14:29:55', '2023-12-12 13:29:55', '2023-12-12 13:29:55'),
(116, 'App\\Models\\Courrier', 18, 3723, 'created_at', NULL, '2023-12-12 14:29:55', '2023-12-12 13:29:55', '2023-12-12 13:29:55'),
(117, 'App\\Models\\Courrier', 17, 3722, 'statut_id', '1', '2', '2023-12-12 15:34:09', '2023-12-12 15:34:09'),
(118, 'App\\Models\\Courrier', 17, 3722, 'traitement_id', NULL, '4', '2023-12-12 15:34:20', '2023-12-12 15:34:20'),
(119, 'App\\Models\\Courrier', 18, 3722, 'statut_id', '1', '2', '2023-12-13 10:56:49', '2023-12-13 10:56:49'),
(120, 'App\\Models\\Document', 50, 3723, 'created_at', NULL, '2023-12-13 11:58:30', '2023-12-13 10:58:30', '2023-12-13 10:58:30'),
(121, 'App\\Models\\Courrier', 19, 3723, 'created_at', NULL, '2023-12-13 11:58:30', '2023-12-13 10:58:30', '2023-12-13 10:58:30'),
(122, 'App\\Models\\Document', 51, 3723, 'created_at', NULL, '2023-12-13 12:02:18', '2023-12-13 11:02:18', '2023-12-13 11:02:18'),
(123, 'App\\Models\\Courrier', 20, 3723, 'created_at', NULL, '2023-12-13 12:02:19', '2023-12-13 11:02:19', '2023-12-13 11:02:19'),
(124, 'App\\Models\\Courrier', 19, 3722, 'statut_id', '1', '2', '2023-12-13 11:03:04', '2023-12-13 11:03:04'),
(125, 'App\\Models\\Courrier', 19, 3722, 'traitement_id', NULL, '4', '2023-12-13 11:03:12', '2023-12-13 11:03:12'),
(126, 'App\\Models\\Courrier', 20, 3722, 'statut_id', '1', '2', '2023-12-13 11:03:37', '2023-12-13 11:03:37'),
(127, 'App\\Models\\Courrier', 20, 3726, 'priorite_id', NULL, '3', '2023-12-13 11:03:57', '2023-12-13 11:03:57'),
(128, 'App\\Models\\Courrier', 20, 3726, 'traitement_id', NULL, '4', '2023-12-13 11:03:57', '2023-12-13 11:03:57'),
(129, 'App\\Models\\Courrier', 20, 3722, 'priorite_id', '3', '0', '2023-12-13 11:06:58', '2023-12-13 11:06:58'),
(130, 'App\\Models\\Document', 52, 4082, 'created_at', NULL, '2023-12-13 13:00:29', '2023-12-13 12:00:29', '2023-12-13 12:00:29'),
(131, 'App\\Models\\Document', 53, 4082, 'created_at', NULL, '2023-12-13 13:04:48', '2023-12-13 12:04:48', '2023-12-13 12:04:48'),
(132, 'App\\Models\\Document', 54, 4083, 'created_at', NULL, '2023-12-13 13:09:23', '2023-12-13 12:09:23', '2023-12-13 12:09:23'),
(133, 'App\\Models\\Document', 51, 4083, 'statut_id', '1', '6', '2023-12-13 12:09:55', '2023-12-13 12:09:55'),
(134, 'App\\Models\\Document', 52, 4083, 'statut_id', '1', '6', '2023-12-13 12:09:55', '2023-12-13 12:09:55'),
(135, 'App\\Models\\Document', 53, 4083, 'statut_id', '1', '6', '2023-12-13 12:09:55', '2023-12-13 12:09:55'),
(136, 'App\\Models\\Document', 54, 4083, 'statut_id', '1', '6', '2023-12-13 12:09:55', '2023-12-13 12:09:55'),
(137, 'App\\Models\\Document', 55, 1, 'created_at', NULL, '2023-12-13 13:14:11', '2023-12-13 12:14:11', '2023-12-13 12:14:11'),
(138, 'App\\Models\\Document', 56, 1, 'created_at', NULL, '2023-12-13 13:14:11', '2023-12-13 12:14:11', '2023-12-13 12:14:11'),
(139, 'App\\Models\\Document', 57, 1, 'created_at', NULL, '2023-12-13 13:14:11', '2023-12-13 12:14:11', '2023-12-13 12:14:11'),
(140, 'App\\Models\\Courrier', 20, 1, 'mark_as_done', NULL, '1', '2023-12-13 12:31:44', '2023-12-13 12:31:44'),
(141, 'App\\Models\\Document', 58, 1, 'created_at', NULL, '2023-12-13 13:31:44', '2023-12-13 12:31:44', '2023-12-13 12:31:44'),
(142, 'App\\Models\\Courrier', 21, 1, 'created_at', NULL, '2023-12-13 13:31:44', '2023-12-13 12:31:44', '2023-12-13 12:31:44'),
(143, 'App\\Models\\Document', 59, 3723, 'created_at', NULL, '2023-12-14 12:01:15', '2023-12-14 11:01:15', '2023-12-14 11:01:15'),
(144, 'App\\Models\\Courrier', 22, 3723, 'created_at', NULL, '2023-12-14 12:01:15', '2023-12-14 11:01:15', '2023-12-14 11:01:15'),
(145, 'App\\Models\\Courrier', 22, 3722, 'statut_id', '1', '2', '2023-12-14 11:06:12', '2023-12-14 11:06:12'),
(146, 'App\\Models\\Courrier', 22, 3722, 'traitement_id', NULL, '4', '2023-12-14 11:06:46', '2023-12-14 11:06:46'),
(147, 'App\\Models\\Document', 60, 4082, 'created_at', NULL, '2023-12-14 12:17:31', '2023-12-14 11:17:32', '2023-12-14 11:17:32'),
(148, 'App\\Models\\Document', 61, 4082, 'created_at', NULL, '2023-12-14 12:21:32', '2023-12-14 11:21:32', '2023-12-14 11:21:32'),
(149, 'App\\Models\\Document', 59, 4083, 'statut_id', '1', '6', '2023-12-14 11:24:58', '2023-12-14 11:24:58'),
(150, 'App\\Models\\Document', 60, 4083, 'statut_id', '1', '6', '2023-12-14 11:24:58', '2023-12-14 11:24:58'),
(151, 'App\\Models\\Document', 61, 4083, 'statut_id', '1', '6', '2023-12-14 11:24:58', '2023-12-14 11:24:58'),
(152, 'App\\Models\\Document', 62, 4083, 'created_at', NULL, '2023-12-14 12:35:16', '2023-12-14 11:35:16', '2023-12-14 11:35:16'),
(153, 'App\\Models\\Document', 62, 1, 'statut_id', '1', '6', '2023-12-14 11:42:05', '2023-12-14 11:42:05'),
(154, 'App\\Models\\Document', 63, 1, 'created_at', NULL, '2023-12-14 12:42:05', '2023-12-14 11:42:05', '2023-12-14 11:42:05'),
(155, 'App\\Models\\Document', 64, 1, 'created_at', NULL, '2023-12-14 12:42:05', '2023-12-14 11:42:05', '2023-12-14 11:42:05'),
(156, 'App\\Models\\Document', 65, 1, 'created_at', NULL, '2023-12-14 12:42:05', '2023-12-14 11:42:05', '2023-12-14 11:42:05'),
(157, 'App\\Models\\Document', 66, 1, 'created_at', NULL, '2023-12-14 12:42:09', '2023-12-14 11:42:09', '2023-12-14 11:42:09'),
(158, 'App\\Models\\Document', 67, 1, 'created_at', NULL, '2023-12-14 12:42:09', '2023-12-14 11:42:09', '2023-12-14 11:42:09'),
(159, 'App\\Models\\Document', 68, 1, 'created_at', NULL, '2023-12-14 12:42:09', '2023-12-14 11:42:09', '2023-12-14 11:42:09'),
(160, 'App\\Models\\Document', 69, 1, 'created_at', NULL, '2023-12-14 12:43:05', '2023-12-14 11:43:05', '2023-12-14 11:43:05'),
(161, 'App\\Models\\Document', 70, 1, 'created_at', NULL, '2023-12-14 12:43:05', '2023-12-14 11:43:05', '2023-12-14 11:43:05'),
(162, 'App\\Models\\Document', 71, 1, 'created_at', NULL, '2023-12-14 12:43:05', '2023-12-14 11:43:05', '2023-12-14 11:43:05'),
(163, 'App\\Models\\Courrier', 22, 1, 'mark_as_done', NULL, '1', '2023-12-14 12:28:21', '2023-12-14 12:28:21'),
(164, 'App\\Models\\Document', 72, 1, 'created_at', NULL, '2023-12-14 13:28:22', '2023-12-14 12:28:22', '2023-12-14 12:28:22'),
(165, 'App\\Models\\Courrier', 23, 1, 'created_at', NULL, '2023-12-14 13:28:22', '2023-12-14 12:28:22', '2023-12-14 12:28:22'),
(166, 'App\\Models\\Document', 73, 3723, 'created_at', NULL, '2023-12-15 15:39:26', '2023-12-15 14:39:26', '2023-12-15 14:39:26'),
(167, 'App\\Models\\Courrier', 24, 3723, 'created_at', NULL, '2023-12-15 15:39:26', '2023-12-15 14:39:26', '2023-12-15 14:39:26'),
(168, 'App\\Models\\Courrier', 24, 3722, 'statut_id', '1', '2', '2023-12-15 14:41:32', '2023-12-15 14:41:32'),
(169, 'App\\Models\\Courrier', 24, 3722, 'traitement_id', NULL, '4', '2023-12-15 14:41:57', '2023-12-15 14:41:57'),
(170, 'App\\Models\\Document', 74, 4082, 'created_at', NULL, '2023-12-15 16:07:20', '2023-12-15 15:07:20', '2023-12-15 15:07:20'),
(171, 'App\\Models\\Document', 75, 4083, 'created_at', NULL, '2023-12-15 16:21:44', '2023-12-15 15:21:44', '2023-12-15 15:21:44'),
(172, 'App\\Models\\Document', 73, 4083, 'statut_id', '1', '6', '2023-12-15 15:22:51', '2023-12-15 15:22:51'),
(173, 'App\\Models\\Document', 74, 4083, 'statut_id', '1', '6', '2023-12-15 15:22:51', '2023-12-15 15:22:51'),
(174, 'App\\Models\\Document', 75, 4083, 'statut_id', '1', '6', '2023-12-15 15:22:51', '2023-12-15 15:22:51'),
(175, 'App\\Models\\Document', 76, 1, 'created_at', NULL, '2023-12-15 16:28:52', '2023-12-15 15:28:52', '2023-12-15 15:28:52'),
(176, 'App\\Models\\Document', 77, 1, 'created_at', NULL, '2023-12-15 16:28:52', '2023-12-15 15:28:52', '2023-12-15 15:28:52'),
(177, 'App\\Models\\Document', 78, 1, 'created_at', NULL, '2023-12-15 16:31:36', '2023-12-15 15:31:36', '2023-12-15 15:31:36'),
(178, 'App\\Models\\Document', 79, 1, 'created_at', NULL, '2023-12-15 16:31:36', '2023-12-15 15:31:36', '2023-12-15 15:31:36'),
(179, 'App\\Models\\Courrier', 24, 1, 'mark_as_done', NULL, '1', '2023-12-15 16:30:24', '2023-12-15 16:30:24'),
(180, 'App\\Models\\Document', 80, 1, 'created_at', NULL, '2023-12-15 17:30:24', '2023-12-15 16:30:24', '2023-12-15 16:30:24'),
(181, 'App\\Models\\Courrier', 25, 1, 'created_at', NULL, '2023-12-15 17:30:24', '2023-12-15 16:30:24', '2023-12-15 16:30:24'),
(182, 'App\\Models\\Document', 81, 3723, 'created_at', NULL, '2023-12-19 17:55:04', '2023-12-19 16:55:04', '2023-12-19 16:55:04'),
(183, 'App\\Models\\Courrier', 26, 3723, 'created_at', NULL, '2023-12-19 17:55:04', '2023-12-19 16:55:04', '2023-12-19 16:55:04'),
(184, 'App\\Models\\Courrier', 26, 3722, 'statut_id', '1', '2', '2023-12-19 16:56:10', '2023-12-19 16:56:10'),
(185, 'App\\Models\\Courrier', 26, 3722, 'traitement_id', NULL, '4', '2023-12-19 16:56:19', '2023-12-19 16:56:19'),
(186, 'App\\Models\\Document', 82, 4082, 'created_at', NULL, '2023-12-19 18:24:07', '2023-12-19 17:24:07', '2023-12-19 17:24:07'),
(187, 'App\\Models\\Document', 81, 4083, 'statut_id', '1', '6', '2023-12-19 17:31:27', '2023-12-19 17:31:27'),
(188, 'App\\Models\\Document', 82, 4083, 'statut_id', '1', '6', '2023-12-19 17:31:27', '2023-12-19 17:31:27'),
(189, 'App\\Models\\Document', 83, 1, 'created_at', NULL, '2023-12-19 18:33:09', '2023-12-19 17:33:10', '2023-12-19 17:33:10'),
(190, 'App\\Models\\Courrier', 26, 1, 'mark_as_done', NULL, '1', '2023-12-19 17:40:04', '2023-12-19 17:40:04'),
(191, 'App\\Models\\Document', 84, 1, 'created_at', NULL, '2023-12-19 18:40:05', '2023-12-19 17:40:05', '2023-12-19 17:40:05'),
(192, 'App\\Models\\Courrier', 27, 1, 'created_at', NULL, '2023-12-19 18:40:05', '2023-12-19 17:40:05', '2023-12-19 17:40:05'),
(193, 'App\\Models\\Document', 85, 3723, 'created_at', NULL, '2023-12-22 09:46:21', '2023-12-22 08:46:21', '2023-12-22 08:46:21'),
(194, 'App\\Models\\Courrier', 28, 3723, 'created_at', NULL, '2023-12-22 09:46:21', '2023-12-22 08:46:21', '2023-12-22 08:46:21'),
(195, 'App\\Models\\Courrier', 28, 3722, 'statut_id', '1', '2', '2023-12-22 08:51:34', '2023-12-22 08:51:34'),
(196, 'App\\Models\\Courrier', 28, 3722, 'traitement_id', NULL, '4', '2023-12-22 08:54:09', '2023-12-22 08:54:09'),
(197, 'App\\Models\\Document', 86, 4082, 'created_at', NULL, '2023-12-22 10:07:52', '2023-12-22 09:07:52', '2023-12-22 09:07:52'),
(198, 'App\\Models\\Document', 85, 4083, 'statut_id', '1', '6', '2023-12-22 09:12:01', '2023-12-22 09:12:01'),
(199, 'App\\Models\\Document', 86, 4083, 'statut_id', '1', '6', '2023-12-22 09:12:01', '2023-12-22 09:12:01'),
(200, 'App\\Models\\Document', 87, 1, 'created_at', NULL, '2023-12-22 10:14:04', '2023-12-22 09:14:04', '2023-12-22 09:14:04'),
(201, 'App\\Models\\Courrier', 28, 1, 'mark_as_done', NULL, '1', '2023-12-22 09:19:12', '2023-12-22 09:19:12'),
(202, 'App\\Models\\Document', 88, 1, 'created_at', NULL, '2023-12-22 10:19:12', '2023-12-22 09:19:12', '2023-12-22 09:19:12'),
(203, 'App\\Models\\Courrier', 29, 1, 'created_at', NULL, '2023-12-22 10:19:12', '2023-12-22 09:19:12', '2023-12-22 09:19:12'),
(204, 'App\\Models\\Document', 89, 3723, 'created_at', NULL, '2023-12-22 13:19:41', '2023-12-22 12:19:41', '2023-12-22 12:19:41'),
(205, 'App\\Models\\Courrier', 30, 3723, 'created_at', NULL, '2023-12-22 13:19:41', '2023-12-22 12:19:41', '2023-12-22 12:19:41'),
(206, 'App\\Models\\Courrier', 30, 3722, 'statut_id', '1', '2', '2023-12-22 12:21:04', '2023-12-22 12:21:04'),
(207, 'App\\Models\\Courrier', 30, 3722, 'traitement_id', NULL, '4', '2023-12-22 12:21:17', '2023-12-22 12:21:17'),
(208, 'App\\Models\\Document', 90, 4082, 'created_at', NULL, '2023-12-22 13:29:38', '2023-12-22 12:29:38', '2023-12-22 12:29:38'),
(209, 'App\\Models\\Document', 89, 4083, 'statut_id', '1', '6', '2023-12-22 12:42:29', '2023-12-22 12:42:29'),
(210, 'App\\Models\\Document', 90, 4083, 'statut_id', '1', '6', '2023-12-22 12:42:29', '2023-12-22 12:42:29'),
(211, 'App\\Models\\Document', 91, 1, 'created_at', NULL, '2023-12-22 14:10:08', '2023-12-22 13:10:08', '2023-12-22 13:10:08'),
(212, 'App\\Models\\Courrier', 30, 1, 'mark_as_done', NULL, '1', '2023-12-22 13:15:31', '2023-12-22 13:15:31'),
(213, 'App\\Models\\Document', 92, 1, 'created_at', NULL, '2023-12-22 14:15:31', '2023-12-22 13:15:31', '2023-12-22 13:15:31'),
(214, 'App\\Models\\Courrier', 31, 1, 'created_at', NULL, '2023-12-22 14:15:31', '2023-12-22 13:15:31', '2023-12-22 13:15:31'),
(215, 'App\\Models\\Document', 93, 3723, 'created_at', NULL, '2024-01-03 09:27:51', '2024-01-03 08:27:51', '2024-01-03 08:27:51'),
(216, 'App\\Models\\Courrier', 32, 3723, 'created_at', NULL, '2024-01-03 09:27:51', '2024-01-03 08:27:51', '2024-01-03 08:27:51'),
(217, 'App\\Models\\Courrier', 32, 3722, 'statut_id', '1', '2', '2024-01-03 08:32:49', '2024-01-03 08:32:49'),
(218, 'App\\Models\\Courrier', 32, 3722, 'traitement_id', NULL, '4', '2024-01-03 08:59:42', '2024-01-03 08:59:42'),
(219, 'App\\Models\\Courrier', 32, 1, 'confidentiel', '0', '1', '2024-01-03 09:07:20', '2024-01-03 09:07:20'),
(220, 'App\\Models\\Document', 93, 1, 'confidentiel', '0', '1', '2024-01-03 09:07:21', '2024-01-03 09:07:21'),
(221, 'App\\Models\\Document', 93, 1, 'password', NULL, '641991', '2024-01-03 09:07:21', '2024-01-03 09:07:21'),
(222, 'App\\Models\\Courrier', 32, 1, 'confidentiel', '1', '0', '2024-01-03 09:08:52', '2024-01-03 09:08:52'),
(223, 'App\\Models\\Document', 94, 3721, 'created_at', NULL, '2024-01-03 11:09:29', '2024-01-03 10:09:29', '2024-01-03 10:09:29'),
(224, 'App\\Models\\Courrier', 33, 3721, 'created_at', NULL, '2024-01-03 11:09:29', '2024-01-03 10:09:29', '2024-01-03 10:09:29'),
(225, 'App\\Models\\Document', 95, 3723, 'created_at', NULL, '2024-01-09 10:39:36', '2024-01-09 09:39:36', '2024-01-09 09:39:36'),
(226, 'App\\Models\\Courrier', 34, 3723, 'created_at', NULL, '2024-01-09 10:39:37', '2024-01-09 09:39:37', '2024-01-09 09:39:37'),
(227, 'App\\Models\\Courrier', 34, 3722, 'statut_id', '1', '2', '2024-01-09 09:43:06', '2024-01-09 09:43:06'),
(228, 'App\\Models\\Courrier', 34, 3722, 'traitement_id', NULL, '4', '2024-01-09 09:47:08', '2024-01-09 09:47:08'),
(229, 'App\\Models\\Document', 96, 4082, 'created_at', NULL, '2024-01-09 11:11:23', '2024-01-09 10:11:23', '2024-01-09 10:11:23'),
(230, 'App\\Models\\Document', 96, 4082, 'document', '[{\"download_link\":\"documents\\\\January2024\\\\Mbf4ztGfmMutMMAMu8w4.pdf\",\"original_name\":\"PROGRAMME DE FORMATION REGIDOCS (1).pdf\"}]', '[{\"download_link\":\"documents\\\\January2024\\\\6kaQjlPQslcOmpmfUF3M.pdf\",\"original_name\":\"PROGRAMME DE FORMATION REGIDOCS (1).pdf\"}]', '2024-01-09 10:41:55', '2024-01-09 10:41:55'),
(231, 'App\\Models\\Document', 95, 4083, 'statut_id', '1', '6', '2024-01-09 10:44:28', '2024-01-09 10:44:28'),
(232, 'App\\Models\\Document', 96, 4083, 'statut_id', '1', '6', '2024-01-09 10:44:28', '2024-01-09 10:44:28'),
(233, 'App\\Models\\Document', 96, 4083, 'document', '[{\"download_link\":\"documents\\\\January2024\\\\6kaQjlPQslcOmpmfUF3M.pdf\",\"original_name\":\"PROGRAMME DE FORMATION REGIDOCS (1).pdf\"}]', '[{\"download_link\":\"documents\\\\January2024\\\\VPO5xbUDkKz4ELGdxIiW.pdf\",\"original_name\":\"PROGRAMME DE FORMATION REGIDOCS (1).pdf\"}]', '2024-01-09 10:52:29', '2024-01-09 10:52:29'),
(234, 'App\\Models\\Document', 97, 1, 'created_at', NULL, '2024-01-09 11:56:35', '2024-01-09 10:56:35', '2024-01-09 10:56:35'),
(235, 'App\\Models\\Courrier', 34, 1, 'mark_as_done', NULL, '1', '2024-01-09 11:25:41', '2024-01-09 11:25:41'),
(236, 'App\\Models\\Document', 98, 1, 'created_at', NULL, '2024-01-09 12:25:42', '2024-01-09 11:25:42', '2024-01-09 11:25:42'),
(237, 'App\\Models\\Courrier', 35, 1, 'created_at', NULL, '2024-01-09 12:25:42', '2024-01-09 11:25:42', '2024-01-09 11:25:42'),
(238, 'App\\Models\\Document', 1, 3723, 'created_at', NULL, '2024-05-29 19:25:32', '2024-05-29 18:25:32', '2024-05-29 18:25:32'),
(239, 'App\\Models\\Courrier', 1, 3723, 'created_at', NULL, '2024-05-29 19:25:32', '2024-05-29 18:25:32', '2024-05-29 18:25:32'),
(240, 'App\\Models\\Courrier', 1, 3722, 'statut_id', '1', '2', '2024-05-29 18:30:48', '2024-05-29 18:30:48'),
(241, 'App\\Models\\Courrier', 1, 3722, 'traitement_id', NULL, '1', '2024-05-29 18:34:23', '2024-05-29 18:34:23'),
(242, 'App\\Models\\Document', 1, 1, 'statut_id', '1', '6', '2024-05-29 19:00:52', '2024-05-29 19:00:52'),
(243, 'App\\Models\\Courrier', 1, 1, 'mark_as_done', NULL, '1', '2024-05-29 19:49:26', '2024-05-29 19:49:26'),
(244, 'App\\Models\\Courrier', 2, 1, 'created_at', NULL, '2024-05-29 20:49:27', '2024-05-29 19:49:27', '2024-05-29 19:49:27'),
(245, 'App\\Models\\Document', 2, 3723, 'created_at', NULL, '2024-05-30 11:50:46', '2024-05-30 10:50:46', '2024-05-30 10:50:46'),
(246, 'App\\Models\\Courrier', 3, 3723, 'created_at', NULL, '2024-05-30 11:50:46', '2024-05-30 10:50:46', '2024-05-30 10:50:46'),
(247, 'App\\Models\\Document', 3, 1, 'created_at', NULL, '2024-06-20 16:25:14', '2024-06-20 15:25:14', '2024-06-20 15:25:14'),
(248, 'App\\Models\\Document', 4, 1, 'created_at', NULL, '2024-06-20 16:28:04', '2024-06-20 15:28:04', '2024-06-20 15:28:04'),
(249, 'App\\Models\\Document', 5, 1, 'created_at', NULL, '2024-06-20 16:34:43', '2024-06-20 15:34:43', '2024-06-20 15:34:43'),
(250, 'App\\Models\\Document', 6, 3723, 'created_at', NULL, '2024-07-07 21:52:03', '2024-07-07 20:52:03', '2024-07-07 20:52:03'),
(251, 'App\\Models\\Courrier', 4, 3723, 'created_at', NULL, '2024-07-07 21:52:03', '2024-07-07 20:52:03', '2024-07-07 20:52:03'),
(252, 'App\\Models\\Courrier', 4, 3722, 'statut_id', '1', '2', '2024-07-08 09:37:32', '2024-07-08 09:37:32'),
(253, 'App\\Models\\Courrier', 4, 3722, 'traitement_id', NULL, '1', '2024-07-08 09:38:37', '2024-07-08 09:38:37'),
(254, 'App\\Models\\Document', 6, 1, 'statut_id', '1', '6', '2024-07-08 09:43:06', '2024-07-08 09:43:06'),
(255, 'App\\Models\\Courrier', 4, 1, 'mark_as_done', NULL, '1', '2024-07-08 09:43:49', '2024-07-08 09:43:49'),
(256, 'App\\Models\\Courrier', 5, 1, 'created_at', NULL, '2024-07-08 10:43:49', '2024-07-08 09:43:49', '2024-07-08 09:43:49'),
(257, 'App\\Models\\Courrier', 5, 3723, 'statut_id', '2', '3', '2024-07-08 09:53:57', '2024-07-08 09:53:57');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2023-07-26 10:13:25', '2023-07-26 10:13:25'),
(2, 'Responsable Directions', 'web', '2023-07-26 14:41:51', '2023-07-26 14:41:51'),
(3, 'Agents', 'web', '2023-07-26 14:41:51', '2023-07-26 14:41:51');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `secretariats`
--

CREATE TABLE `secretariats` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction_id` bigint(20) DEFAULT NULL,
  `responsable_id` bigint(20) DEFAULT NULL,
  `for_dg` tinyint(1) DEFAULT '0',
  `for_dga` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `secretariats`
--

INSERT INTO `secretariats` (`id`, `titre`, `direction_id`, `responsable_id`, `for_dg`, `for_dga`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Secretaire Direction des Stratégies et Contrôle de Gestion', 3, 3885, 0, 0, '2023-09-27 15:08:24', '2023-10-16 11:46:34', NULL),
(2, 'Secretaire Direction de la Digitalisation et Gestion de l\'Information', 13, 3862, 0, 0, '2023-09-27 15:15:17', '2023-10-16 11:47:00', NULL),
(3, 'Secretaire Direction de l\'exploitation', 6, 3769, 0, 0, '2023-09-27 15:20:44', '2023-11-28 15:15:13', NULL),
(4, 'Secretaire Direction de l\'audit interne et inspection', 4, 3768, 0, 0, '2023-09-27 15:38:03', '2023-10-16 11:51:05', NULL),
(5, 'Secretaire Direction Commerciale', 7, 3803, 0, 0, '2023-09-27 15:45:30', '2023-10-16 11:54:13', NULL),
(6, 'Secretaire Direction des Projets et Travaux', 8, 3747, 0, 0, '2023-09-27 15:51:10', '2023-10-16 12:01:31', NULL),
(7, 'Secretaire Direction des Approvisionnements et Logistique', 9, 3839, 0, 0, '2023-09-27 15:55:34', '2023-10-16 12:03:23', NULL),
(8, 'Secretaire Direction Financière', 11, 3909, 0, 0, '2023-09-27 15:58:36', '2023-10-16 12:06:29', NULL),
(9, 'Secretaire Direction des Ressources Humaines', 12, 3925, 0, 0, '2023-09-27 16:06:33', '2023-10-16 12:10:12', NULL),
(10, 'Secretaire Direction de la Brigade Anti-fraude', 5, 34, 0, 0, '2023-09-27 16:44:31', '2023-09-27 16:44:31', NULL),
(11, 'Secretaire Direction Régionale de Kongo Central', 21, 50, 0, 0, '2023-09-29 11:23:21', '2023-09-29 11:23:21', NULL),
(12, 'Secretaire Direction Régionale du Sud-Kivu', 23, 51, 0, 0, '2023-09-29 11:29:40', '2023-09-29 11:29:40', NULL),
(13, 'Secretaire Direction Régionale de Maniema', 28, 52, 0, 0, '2023-09-29 11:42:39', '2023-09-29 11:42:39', NULL),
(14, 'Secretaire Direction Régionale de l\'équateur', 30, 53, 0, 0, '2023-09-29 11:46:00', '2023-09-29 11:46:00', NULL),
(15, 'Secrétaire DG', 1, 3722, 1, 0, '2023-10-11 15:31:40', '2023-10-17 10:07:18', NULL),
(16, 'Secrétariat Secrétaire Général', 2, 3718, 0, 0, '2023-10-16 11:53:02', '2023-10-16 11:53:02', NULL),
(17, 'Secrétaire DGA', 1, 3719, 0, 1, '2023-12-07 11:47:57', '2023-12-07 11:47:57', NULL),
(18, 'Secrétaire DG adjoint', 1, 3726, 1, 0, '2023-12-13 11:00:34', '2023-12-13 11:00:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) NOT NULL,
  `division_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `statut_id` bigint(20) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `division_id`, `service_id`, `responsable_id`, `titre`, `description`, `statut_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 3, 1, 'Section courrier interne', NULL, 1, '2023-07-13 11:19:39', '2023-07-13 11:19:39', NULL),
(2, NULL, 5, 1, 'Section contentieux judiciaire', NULL, 1, '2023-07-15 14:49:43', '2023-07-15 14:49:43', NULL),
(3, NULL, 5, 1, 'Section contentieux non judiciaire', NULL, 1, '2023-07-15 14:50:27', '2023-07-15 14:50:27', NULL),
(4, NULL, 6, 1, 'Section études et documentation juridique', NULL, 1, '2023-07-15 14:52:36', '2023-07-15 14:52:36', NULL),
(5, NULL, 6, 1, 'Section patrimoine immobilière et assurances', NULL, 1, '2023-07-15 14:53:04', '2023-07-15 14:53:04', NULL),
(6, NULL, 7, 1, 'Section support de communication', NULL, 1, '2023-07-15 14:55:47', '2023-07-15 14:55:47', NULL),
(7, NULL, 7, 1, 'Section relation publique', NULL, 1, '2023-07-15 14:56:13', '2023-07-15 14:56:13', NULL),
(8, NULL, 8, 1, 'Section voyages et accueil', NULL, 1, '2023-07-15 14:57:54', '2023-07-15 14:57:54', NULL),
(9, NULL, 8, 1, 'Section hébergement', NULL, 1, '2023-07-15 14:58:25', '2023-07-15 14:58:25', NULL),
(10, NULL, 8, 1, 'Section Protocole', NULL, 1, '2023-07-15 14:58:47', '2023-07-15 14:58:47', NULL),
(11, NULL, 9, 1, 'Section organisation', NULL, 1, '2023-07-15 15:01:04', '2023-07-15 15:01:04', NULL),
(12, NULL, 9, 1, 'Section procédures', NULL, 1, '2023-07-15 15:01:29', '2023-07-15 15:01:29', NULL),
(13, NULL, 10, 3816, 'Section études économiques et financières', NULL, NULL, '2023-07-15 15:03:50', '2023-11-30 14:39:22', NULL),
(14, NULL, 10, 1, 'Section étudestarifaires', NULL, 1, '2023-07-15 15:04:18', '2023-07-15 15:04:18', NULL),
(15, NULL, 11, 1, 'Section contrôle de gestion DG + DRK Est et Ouest', NULL, 1, '2023-07-15 15:09:37', '2023-07-15 15:09:37', NULL),
(16, NULL, 11, 1, 'Section contrôle de gestion DR Catégories A et D', NULL, 1, '2023-07-15 15:10:14', '2023-07-15 15:10:14', NULL),
(17, NULL, 11, 1, 'Section contrôle de gestion DR Catégories B et .C', NULL, 1, '2023-07-15 15:10:41', '2023-07-15 15:10:41', NULL),
(18, NULL, 12, 1, 'Section de données administratives, financières et commerciales', NULL, 1, '2023-07-15 15:12:26', '2023-07-15 15:12:26', NULL),
(19, NULL, 12, 1, 'Section de données techniques', NULL, 1, '2023-07-15 15:12:52', '2023-07-15 15:12:52', NULL),
(20, NULL, 15, 1, 'Section investigation', NULL, 1, '2023-07-15 15:24:37', '2023-07-15 15:24:37', NULL),
(21, NULL, 15, 1, 'Section intervention', NULL, 1, '2023-07-15 15:25:01', '2023-07-15 15:25:01', NULL),
(22, NULL, 16, 1, 'Section investigation', NULL, 1, '2023-07-15 15:27:49', '2023-07-15 15:27:49', NULL),
(23, NULL, 16, 1, 'Section intervention', NULL, 1, '2023-07-15 15:28:10', '2023-07-15 15:28:10', NULL),
(25, NULL, 3, 1, 'Section courrier externe', NULL, 1, '2023-07-15 15:31:38', '2023-07-15 15:31:38', NULL),
(26, NULL, 4, 1, 'Secrétariat', NULL, 1, '2023-07-15 15:33:49', '2023-07-15 15:33:49', NULL),
(27, NULL, 18, 1, 'Section gestion stocks', NULL, 1, '2023-07-15 15:42:38', '2023-07-15 15:42:38', NULL),
(28, NULL, 18, 3795, 'Section atelier mécanique', NULL, NULL, '2023-07-15 15:43:00', '2023-11-30 15:57:21', NULL),
(29, NULL, 18, 3793, 'Section atelier électrique et automation', NULL, NULL, '2023-07-15 15:43:28', '2023-11-30 15:59:33', NULL),
(30, NULL, 19, 3799, 'Section contrôle de la qualité de l\'eau', NULL, NULL, '2023-07-15 15:45:16', '2023-11-30 16:00:24', NULL),
(31, NULL, 19, 3796, 'Section entretien ouvrage et chaîne de traitement', NULL, NULL, '2023-07-15 15:45:41', '2023-11-30 16:01:07', NULL),
(32, NULL, 19, 1, 'Section chimie et microbiologie', NULL, 1, '2023-07-15 15:46:01', '2023-07-15 15:46:01', NULL),
(33, NULL, 20, 1, 'Section maintenance mécanique', NULL, 1, '2023-07-15 15:48:13', '2023-07-15 15:48:13', NULL),
(34, NULL, 20, 1, 'Section maintenance électrique et automation', NULL, 1, '2023-07-15 15:48:33', '2023-07-15 15:48:33', NULL),
(35, NULL, 21, 1, 'section gestion produits chimiques', NULL, 1, '2023-07-15 15:50:38', '2023-07-15 15:50:38', NULL),
(36, NULL, 21, 1, 'Section énergie force motrice', NULL, 1, '2023-07-15 15:51:05', '2023-07-15 15:51:05', NULL),
(37, NULL, 21, 1, 'Section sablière de maluku', NULL, 1, '2023-07-15 15:51:28', '2023-07-15 15:51:28', NULL),
(38, NULL, 22, 1, 'Section exploitation des forages et hydrogéologie', NULL, 1, '2023-07-15 15:53:32', '2023-07-15 15:53:32', NULL),
(39, NULL, 22, 1, 'Section exploitation des sources et bassins versants', NULL, 1, '2023-07-15 15:53:54', '2023-07-15 15:53:54', NULL),
(40, NULL, 23, 1, 'Section exploitation des usines', NULL, 1, '2023-07-15 15:55:03', '2023-07-15 15:55:03', NULL),
(41, NULL, 24, 1, 'Section supervision technique', NULL, 1, '2023-07-15 15:57:47', '2023-07-15 15:57:47', NULL),
(42, NULL, 25, 1, 'Contrôleurs seniors avec rang de C14', NULL, 1, '2023-07-15 16:02:19', '2023-07-15 16:02:19', NULL),
(43, NULL, 25, 1, 'Contrôleurs juniors avec rang de C13', NULL, 1, '2023-07-15 16:02:42', '2023-07-15 16:02:42', NULL),
(44, NULL, 26, 1, 'Section juridique', NULL, 1, '2023-07-15 16:05:35', '2023-07-15 16:05:35', NULL),
(45, NULL, 27, 1, 'Section statistiques et reporting', NULL, 1, '2023-07-15 16:08:17', '2023-07-15 16:08:17', NULL),
(46, NULL, 27, 3782, 'Section environnement et bassin versant', NULL, NULL, '2023-07-15 16:09:07', '2023-11-30 15:13:13', NULL),
(47, NULL, 28, 1, 'Direction Générale', NULL, 1, '2023-07-21 13:36:53', '2023-07-21 13:36:53', NULL),
(48, NULL, 29, 1, 'Section Administration Cadre de Dorection', NULL, 1, '2023-07-22 11:54:32', '2023-07-22 11:54:32', NULL),
(49, NULL, 29, 1, 'Section Administration du Personnel Classifié DG', NULL, 1, '2023-07-22 11:56:34', '2023-07-22 11:56:34', NULL),
(50, NULL, 29, 1, 'Section Administration du Personnel Classifié DR', NULL, 1, '2023-07-22 11:58:16', '2023-07-22 11:58:16', NULL),
(51, NULL, 30, 1, 'Section Paie du Personnel Classifié DG', NULL, 1, '2023-07-22 12:01:59', '2023-07-22 12:01:59', NULL),
(52, NULL, 30, 1, 'Section Paie Cadres de Direction', NULL, 1, '2023-07-22 12:03:02', '2023-07-22 12:03:02', NULL),
(53, NULL, 30, 1, 'Section Assistance et Projets Sociaux', NULL, 1, '2023-07-22 12:04:05', '2023-07-22 12:04:05', NULL),
(54, NULL, 31, 1, 'Section juridique', NULL, 1, '2023-07-22 12:08:25', '2023-07-22 12:08:25', NULL),
(55, NULL, 31, 1, 'Section Relation Profes. & Proc. Disciol. avec les Parten.', NULL, 1, '2023-07-22 12:10:45', '2023-07-22 12:10:45', NULL),
(56, NULL, 32, 1, 'Section Planification', NULL, 1, '2023-07-22 12:16:49', '2023-07-22 12:16:49', NULL),
(57, NULL, 32, 1, 'Section Gestion des Performances', NULL, 1, '2023-07-22 12:17:56', '2023-07-22 12:17:56', NULL),
(58, NULL, 33, 1, 'Section Intendance', NULL, 1, '2023-07-22 12:20:07', '2023-07-22 12:20:07', NULL),
(59, NULL, 33, 1, 'Section Programmation et Evaluation', NULL, 1, '2023-07-22 12:23:21', '2023-07-22 12:23:21', NULL),
(60, NULL, 33, 1, 'Section Administrative, Finances et Comptabilités', NULL, 1, '2023-07-22 12:24:34', '2023-07-22 12:24:34', NULL),
(61, NULL, 34, 1, 'Section Sociale', NULL, 1, '2023-07-22 12:37:13', '2023-07-22 12:37:13', NULL),
(62, NULL, 34, 1, 'Section Comptabilité', NULL, 1, '2023-07-22 12:38:08', '2023-07-22 12:38:08', NULL),
(63, NULL, 35, 1, 'Section Dispensaire Médicale', NULL, 1, '2023-07-22 12:39:54', '2023-07-22 12:39:54', NULL),
(64, NULL, 35, 1, 'Section Dépôt et Classement Prod. Pharm', NULL, 1, '2023-07-22 12:41:19', '2023-07-22 12:41:19', NULL),
(65, NULL, 36, 1, 'Pool des Médecins Consultants', NULL, 1, '2023-07-22 12:47:47', '2023-07-22 12:47:47', NULL),
(66, NULL, 36, 1, 'Section Laboratoire', NULL, 1, '2023-07-22 12:49:10', '2023-07-22 12:49:10', NULL),
(67, NULL, 36, 1, 'Section Imagérie', NULL, 1, '2023-07-22 12:50:50', '2023-07-22 12:50:50', NULL),
(68, NULL, 36, 1, 'Section Nursing', NULL, 1, '2023-07-22 12:51:38', '2023-07-22 12:51:38', NULL),
(69, NULL, 37, 1, 'Section Bloc Opératoire', NULL, 1, '2023-07-22 12:53:56', '2023-07-22 12:53:56', NULL),
(70, NULL, 37, 1, 'Section Coordination Equipes Tournantes', NULL, 1, '2023-07-22 12:54:38', '2023-07-22 12:54:38', NULL),
(71, NULL, 37, 1, 'Section Kinésithérapie', NULL, 1, '2023-07-22 12:55:26', '2023-07-22 12:55:26', NULL),
(72, NULL, 38, 1, 'Section Chiffre d\'affaires', NULL, 1, '2023-07-22 13:52:22', '2023-07-22 13:52:22', NULL),
(73, NULL, 38, 3808, 'Section Facturation', NULL, NULL, '2023-07-22 13:53:08', '2023-11-30 15:08:15', NULL),
(74, NULL, 39, 3, 'Section Clientèle', NULL, 1, '2023-07-22 13:54:59', '2023-07-22 13:54:59', NULL),
(75, NULL, 39, 3, 'Section Marketing', NULL, 1, '2023-07-22 13:55:40', '2023-07-22 13:55:40', NULL),
(76, NULL, 40, 3805, 'Section Litige et PVR', NULL, NULL, '2023-07-22 13:58:20', '2023-11-30 15:09:02', NULL),
(77, NULL, 41, 330, 'Section Recouvrement Privé DR', NULL, NULL, '2023-07-22 14:00:21', '2023-11-30 15:09:51', NULL),
(78, NULL, 42, 2, 'Section Globalisation', NULL, 1, '2023-07-22 14:02:06', '2023-07-22 14:02:06', NULL),
(79, NULL, 42, 3931, 'Section Certification', NULL, NULL, '2023-07-22 14:02:36', '2023-11-30 15:10:30', NULL),
(80, NULL, 43, 1, 'Section Etudes Economiques et Financières', NULL, 1, '2023-07-24 09:56:53', '2023-07-24 09:56:53', NULL),
(81, NULL, 44, 3813, 'Section Planification et Développement', NULL, NULL, '2023-07-24 10:29:26', '2023-11-30 14:39:57', NULL),
(82, NULL, 44, 3829, 'Section Suivi et Évaluation des Projets', NULL, NULL, '2023-07-24 10:30:14', '2023-11-30 14:42:03', NULL),
(83, NULL, 45, 3823, 'Section Bureaux Projets 1', NULL, NULL, '2023-07-24 10:32:36', '2023-11-30 14:43:57', NULL),
(84, NULL, 45, 1, 'Section Bureaux Projets 2', NULL, 1, '2023-07-24 10:33:02', '2023-07-24 10:33:02', NULL),
(85, NULL, 45, 7, 'Section Bureaux Projets 3', NULL, 1, '2023-07-24 10:33:34', '2023-07-24 10:33:34', NULL),
(86, NULL, 46, 3827, 'Section Travaux Génie Civil', NULL, NULL, '2023-07-24 10:38:05', '2023-11-30 14:56:02', NULL),
(87, NULL, 46, 3, 'Section Réseau', NULL, 1, '2023-07-24 10:38:33', '2023-07-24 10:38:33', NULL),
(88, NULL, 47, 1, 'Secion Travaux Forages', NULL, 1, '2023-07-24 10:43:40', '2023-07-24 10:43:40', NULL),
(89, NULL, 47, 3809, 'Section Travaux Sources', NULL, NULL, '2023-07-24 10:44:27', '2023-11-30 14:57:33', NULL),
(90, NULL, 48, 1, 'Section Hydrogéologie', NULL, 1, '2023-07-24 10:55:58', '2023-07-24 10:55:58', NULL),
(91, NULL, 48, 3820, 'Section Hydrologie', NULL, NULL, '2023-07-24 11:11:40', '2023-11-30 14:48:21', NULL),
(92, NULL, 49, 3822, 'Section Génie Civil et Structure', NULL, NULL, '2023-07-24 11:14:13', '2023-11-30 14:49:01', NULL),
(93, NULL, 49, 3833, 'Section Hydraulique', NULL, NULL, '2023-07-24 11:14:50', '2023-11-30 14:49:46', NULL),
(94, NULL, 49, 3832, 'Section Génie Mécanique', NULL, NULL, '2023-07-24 11:15:39', '2023-11-30 14:50:42', NULL),
(95, NULL, 49, 3, 'Section Génie Electrique', NULL, 1, '2023-07-24 11:16:09', '2023-07-24 11:16:09', NULL),
(96, NULL, 49, 1, 'Section Génie d\'Automation', NULL, 1, '2023-07-24 11:17:04', '2023-07-24 11:17:04', NULL),
(97, NULL, 49, 2, 'Section Génie de l\'Environnement', NULL, 1, '2023-07-24 11:17:48', '2023-07-24 11:17:48', NULL),
(98, NULL, 49, 5, 'Section Génie de Procédés', NULL, 1, '2023-07-24 11:19:47', '2023-07-24 11:19:47', NULL),
(99, NULL, 50, 3824, 'Section Cartographie', NULL, NULL, '2023-07-24 11:23:39', '2023-11-30 14:51:43', NULL),
(100, NULL, 50, 3810, 'Section Dessin et Modèle', NULL, NULL, '2023-07-24 11:24:11', '2023-11-30 14:52:34', NULL),
(101, NULL, 51, 4, 'Section Gestion Immobilière', NULL, 1, '2023-07-24 11:32:27', '2023-07-24 11:32:27', NULL),
(102, NULL, 51, 1, 'Section Maintenance Électromécanique', NULL, 1, '2023-07-24 11:33:36', '2023-07-24 11:33:36', NULL),
(103, NULL, 51, 2, 'Section Parcs Automatique et Garage', NULL, 1, '2023-07-24 11:35:16', '2023-07-24 11:35:16', NULL),
(104, NULL, 52, 2, 'Section Achats Locaux', NULL, 1, '2023-07-24 11:40:45', '2023-07-24 11:40:45', NULL),
(105, NULL, 52, 1, 'Section Importation et Support aux Achats', NULL, 1, '2023-07-24 11:42:33', '2023-07-24 11:42:33', NULL),
(106, NULL, 53, 2, 'Section Analyse et Etudes', NULL, 1, '2023-07-24 11:45:42', '2023-07-24 11:45:42', NULL),
(107, NULL, 53, 1, 'Section Programmation', NULL, 1, '2023-07-24 11:46:42', '2023-07-24 11:46:42', NULL),
(108, NULL, 54, 1, 'Section Comptabilité Magasin', NULL, 1, '2023-07-24 12:10:49', '2023-07-24 12:10:49', NULL),
(109, NULL, 54, 1, 'Section Magasin Central', NULL, 1, '2023-07-24 12:11:17', '2023-07-24 12:11:17', NULL),
(110, NULL, 54, 1, 'Section Expédition', NULL, 1, '2023-07-24 12:11:52', '2023-07-24 12:11:52', NULL),
(111, NULL, 55, 7, 'Section Réseaux Informatiques', NULL, 1, '2023-07-26 09:23:40', '2023-07-26 09:23:40', NULL),
(112, NULL, 55, 7, 'Section Télécoms', NULL, 1, '2023-07-26 09:24:11', '2023-07-26 09:24:11', NULL),
(113, NULL, 55, 5, 'Section Télécommunication', NULL, 1, '2023-07-26 09:25:00', '2023-07-26 09:25:00', NULL),
(114, NULL, 56, 7, 'Section Logistique', NULL, 1, '2023-07-26 09:27:11', '2023-07-26 09:27:11', NULL),
(115, NULL, 56, 4, 'Section maintenance', NULL, 1, '2023-07-26 09:27:51', '2023-07-26 09:27:51', NULL),
(116, NULL, 59, 5, 'Section Centralisation Comptabilité', NULL, 1, '2023-07-26 09:41:08', '2023-07-26 09:41:08', NULL),
(117, NULL, 59, 3, 'Section Etats Comptables DG', NULL, 1, '2023-07-26 09:44:31', '2023-07-26 09:44:31', NULL),
(118, NULL, 59, 4, 'Section Paie', NULL, 1, '2023-07-26 09:45:52', '2023-07-26 09:45:52', NULL),
(119, NULL, 59, 4, 'Section Tiers', NULL, 1, '2023-07-26 09:46:17', '2023-07-26 09:46:17', NULL),
(120, NULL, 59, 4, 'Section Stocks', NULL, 1, '2023-07-26 09:47:02', '2023-07-26 09:47:02', NULL),
(121, NULL, 60, 3, 'Section Fiscalité DG', NULL, 1, '2023-07-26 09:48:34', '2023-07-26 09:48:34', NULL),
(122, NULL, 60, 3, 'Section Fiscalité DR', NULL, 1, '2023-07-26 09:49:07', '2023-07-26 09:49:07', NULL),
(123, NULL, 61, 2, 'Section CAG/DG', NULL, 1, '2023-07-26 10:00:54', '2023-07-26 10:00:54', NULL),
(124, NULL, 61, 2, 'Section CAG/DR', NULL, 1, '2023-07-26 10:01:20', '2023-07-26 10:01:20', NULL),
(125, NULL, 62, 1, 'Section Gestion Comptable des Immobilisations', NULL, 1, '2023-07-26 10:03:56', '2023-07-26 12:14:28', NULL),
(126, NULL, 62, 2, 'Section Gestion Comptable des Projets', NULL, 1, '2023-07-26 10:04:43', '2023-07-26 10:04:43', NULL),
(127, NULL, 63, 3, 'Section Gestion de Trésorerie DR', NULL, 1, '2023-07-26 10:09:09', '2023-07-26 10:09:09', NULL),
(128, NULL, 63, 3, 'Section Trésorerie DG et Gestion des Emprunts', NULL, 1, '2023-07-26 10:10:03', '2023-07-26 10:10:03', NULL),
(129, NULL, 63, 2, 'Section Base des Données de Trésorerie', NULL, 1, '2023-07-26 10:11:16', '2023-07-26 10:11:16', NULL),
(130, NULL, 64, 3, 'Sections Banques', NULL, 1, '2023-07-26 10:12:44', '2023-07-26 10:12:44', NULL),
(131, NULL, 64, 3, 'Section Caisses', NULL, 1, '2023-07-26 10:13:11', '2023-07-26 10:13:11', NULL),
(132, NULL, 64, 3, 'Section Opérations Diverses', NULL, 1, '2023-07-26 10:13:50', '2023-07-26 10:13:50', NULL),
(133, NULL, 65, 4, 'Section Budget d\'Exploitation', NULL, 1, '2023-07-26 10:17:01', '2023-07-26 10:17:01', NULL),
(134, NULL, 65, 2, 'Section Budget d\'Investissement', NULL, 1, '2023-07-26 10:17:37', '2023-07-26 10:17:37', NULL),
(135, NULL, 66, 2, 'Section Budget de Trésorerie', NULL, 1, '2023-07-26 10:19:21', '2023-07-26 10:19:21', NULL),
(136, NULL, 67, 4037, 'Section Reporting Commercial', NULL, NULL, '2023-11-21 15:19:08', '2023-11-21 15:24:11', NULL),
(137, NULL, 67, 3866, 'Section Reporting Exploitation', NULL, NULL, '2023-11-21 15:23:00', '2023-11-21 15:34:55', NULL),
(138, NULL, 68, 1891, 'Section Administratif et Financier', NULL, NULL, '2023-11-21 15:25:30', '2023-11-21 15:26:56', NULL),
(139, NULL, 68, 3729, 'Section Suivi du Personnel', NULL, NULL, '2023-11-21 15:29:44', '2023-11-21 15:37:50', NULL),
(140, NULL, 46, 3818, 'Section Travaux Réseaux', NULL, NULL, '2023-11-30 15:05:20', '2023-11-30 15:05:20', NULL),
(141, NULL, 47, 3831, 'Section Travaux Forages', NULL, NULL, '2023-11-30 15:07:24', '2023-11-30 15:07:24', NULL),
(142, NULL, 18, 3791, 'Section Bobinage', NULL, NULL, '2023-11-30 15:58:30', '2023-11-30 15:58:30', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) NOT NULL,
  `direction_id` int(11) DEFAULT NULL,
  `division_id` bigint(20) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `statut_id` bigint(20) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `direction_id`, `division_id`, `responsable_id`, `titre`, `description`, `statut_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 'Assistants DG/DGA', NULL, 1, '2023-07-13 10:36:41', '2023-07-13 10:36:41', NULL),
(2, 1, 1, 3722, 'Secrétariats DG/DGA', NULL, NULL, '2023-07-13 12:02:43', '2023-10-16 12:19:51', NULL),
(3, 1, 1, 3723, 'Service Courrier', NULL, NULL, '2023-07-13 12:11:52', '2023-10-16 12:26:53', NULL),
(4, 1, 1, 3992, 'Secrétariat CODIR', NULL, NULL, '2023-07-13 12:13:25', '2023-11-28 15:22:31', NULL),
(5, 2, 2, 3760, 'Service contentieux', NULL, NULL, '2023-07-15 15:47:44', '2023-11-29 07:54:17', NULL),
(6, 2, 2, 4034, 'Service études et documentation juridique', NULL, NULL, '2023-07-15 15:52:01', '2023-11-29 07:55:56', NULL),
(7, 2, 3, 3937, 'Service Communication', NULL, NULL, '2023-07-15 15:54:30', '2023-11-29 07:57:26', NULL),
(8, 2, 3, 3751, 'Service protocole', NULL, NULL, '2023-07-15 15:57:03', '2023-11-29 07:58:11', NULL),
(9, 6, 4, 4079, 'Service organisation et procédures', NULL, NULL, '2023-07-15 15:59:53', '2023-11-28 16:07:15', NULL),
(10, NULL, 4, NULL, 'Service études économiques et financières', NULL, 1, '2023-07-15 16:02:45', '2023-07-15 16:02:45', NULL),
(11, 3, 5, 3887, 'Service contrôle de gestion', NULL, NULL, '2023-07-15 16:08:36', '2023-11-28 16:11:00', NULL),
(12, 3, 5, 3701, 'Service de données d\'entreprise', NULL, NULL, '2023-07-15 16:11:30', '2023-11-29 07:38:58', NULL),
(13, NULL, 8, NULL, 'Service sécurité physique', NULL, 1, '2023-07-15 16:19:54', '2023-07-15 16:19:54', NULL),
(14, NULL, 8, NULL, 'Service sécurité au travail.', NULL, 1, '2023-07-15 16:20:17', '2023-07-15 16:20:17', NULL),
(15, NULL, 9, NULL, 'Service Brigade Anti-fraude', NULL, 1, '2023-07-15 16:23:53', '2023-07-15 16:23:53', NULL),
(16, NULL, 10, NULL, 'Service Brigade Anti-fraude', NULL, 1, '2023-07-15 16:27:02', '2023-07-15 16:27:02', NULL),
(17, 1, 1, 3719, 'Secrétariats DG/DGA', NULL, NULL, '2023-07-15 16:32:28', '2023-11-28 15:22:18', NULL),
(18, 6, 12, 4040, 'Service atelier central', NULL, NULL, '2023-07-15 16:41:43', '2023-11-28 15:55:49', NULL),
(19, 6, 12, 4043, 'Service qualité de l\'eau', NULL, NULL, '2023-07-15 16:44:19', '2023-11-28 15:57:39', NULL),
(20, 6, 12, 4045, 'Service maintenance et GMAO', NULL, NULL, '2023-07-15 16:47:16', '2023-11-28 15:58:25', NULL),
(21, 6, 13, 3778, 'Service des intrants', NULL, NULL, '2023-07-15 16:49:48', '2023-11-28 15:59:16', NULL),
(22, NULL, 13, NULL, 'Service eaux souterraines', NULL, 1, '2023-07-15 16:52:40', '2023-07-15 16:52:40', NULL),
(23, 6, 13, 3775, 'Service eaux de surface', NULL, NULL, '2023-07-15 16:54:29', '2023-11-28 16:01:04', NULL),
(24, NULL, 14, NULL, 'Service de Distribution', NULL, 1, '2023-07-15 16:57:13', '2023-07-15 16:57:13', NULL),
(25, NULL, 15, NULL, 'Corps des assistants au contrôle', NULL, 1, '2023-07-15 17:01:32', '2023-07-15 17:01:32', NULL),
(26, NULL, 16, NULL, 'Service de la Brigade Anti-fraude Secrétariat', NULL, 1, '2023-07-15 17:04:58', '2023-07-15 17:04:58', NULL),
(27, NULL, 17, NULL, 'Service de l\'Exploitation', NULL, 1, '2023-07-15 17:07:24', '2023-07-15 17:07:24', NULL),
(28, NULL, 1, NULL, 'Direction Générale', NULL, 1, '2023-07-21 14:35:49', '2023-07-21 14:35:49', NULL),
(29, 12, 18, 3950, 'Service Administration du personnel', NULL, NULL, '2023-07-22 12:53:10', '2023-11-28 15:25:02', NULL),
(30, 12, 18, 3935, 'Service Rémunération du personnel et Av. sociaux', NULL, NULL, '2023-07-22 13:00:01', '2023-11-28 15:36:34', NULL),
(31, 12, 18, 3948, 'Service Proc. Discipl., Réclamation & Partenaires Sociaux', NULL, NULL, '2023-07-22 13:07:25', '2023-11-28 15:34:32', NULL),
(32, 12, 19, 4100, 'Service Gest. Prév. des Empl. et des Compétences (GPEC)', NULL, NULL, '2023-07-22 13:14:35', '2023-11-28 15:38:43', NULL),
(33, 12, 19, 4099, 'Service Formation', NULL, NULL, '2023-07-22 13:18:47', '2023-11-28 15:30:30', NULL),
(34, 12, 20, 3967, 'Service Gestion Hospitalière', NULL, NULL, '2023-07-22 13:36:24', '2023-11-29 08:04:34', NULL),
(35, 12, 20, 3964, 'Service Pharmacie', NULL, NULL, '2023-07-22 13:38:46', '2023-11-29 08:05:09', NULL),
(36, NULL, 20, NULL, 'Service CRM Réferences', NULL, 1, '2023-07-22 13:45:33', '2023-07-22 13:45:33', NULL),
(37, 12, 20, 3959, 'Service Hospitalisation Kinshasa', NULL, NULL, '2023-07-22 13:52:54', '2023-11-29 08:13:32', NULL),
(38, 7, 21, 4047, 'Service Facturation', NULL, NULL, '2023-07-22 14:50:56', '2023-11-28 15:49:08', NULL),
(39, 7, 21, 3802, 'Service Clientèle et Marketing', NULL, NULL, '2023-07-22 14:54:21', '2023-11-28 15:48:33', NULL),
(40, NULL, 22, NULL, 'Service Recouvrement et Contentieux', NULL, 1, '2023-07-22 14:57:39', '2023-07-22 14:57:39', NULL),
(41, NULL, 22, NULL, 'Service Recouvrement Privé', NULL, 1, '2023-07-22 14:59:17', '2023-07-22 14:59:17', NULL),
(42, 7, 22, 4054, 'Service Recouvrements I.O', NULL, NULL, '2023-07-22 15:01:22', '2023-11-28 15:50:16', NULL),
(43, NULL, 23, NULL, 'Service Etudes Economiques et Financières', NULL, 1, '2023-07-24 10:55:59', '2023-07-24 10:55:59', NULL),
(44, 8, 23, 3860, 'Service Planification et Contrôle des Projets', NULL, NULL, '2023-07-24 10:58:28', '2023-11-28 15:43:53', NULL),
(45, NULL, 23, NULL, 'Service Gestion Projets', NULL, 1, '2023-07-24 11:31:08', '2023-07-24 11:31:08', NULL),
(46, 8, 24, 4057, 'Service Travaux Génie Civil et Réseau', NULL, NULL, '2023-07-24 11:36:47', '2023-11-28 15:45:23', NULL),
(47, 8, 24, 4056, 'Service Travaux Forages et Sources', NULL, NULL, '2023-07-24 11:42:52', '2023-11-28 15:45:58', NULL),
(48, NULL, 25, NULL, 'Service Resource en Eau', NULL, 1, '2023-07-24 11:55:01', '2023-07-24 11:55:01', NULL),
(49, 8, 25, 3814, 'Service des Etudes de Génie', NULL, NULL, '2023-07-24 12:12:43', '2023-11-29 07:32:29', NULL),
(50, 8, 25, 3815, 'Service Cartographie et Dessin', NULL, NULL, '2023-07-24 12:21:03', '2023-11-28 15:44:42', NULL),
(51, NULL, 26, NULL, 'Service Intendance', NULL, 1, '2023-07-24 12:30:29', '2023-07-24 12:30:29', NULL),
(52, 9, 27, 3848, 'Service Achats Locaux', NULL, NULL, '2023-07-24 12:38:54', '2023-11-29 07:50:35', NULL),
(53, NULL, 27, NULL, 'Section Analyse et Programmation', NULL, 1, '2023-07-24 12:44:49', '2023-07-24 12:44:49', NULL),
(54, 9, 27, 3834, 'Service Gestion Stocks et Magasin', NULL, NULL, '2023-07-24 13:08:31', '2023-11-29 07:52:24', NULL),
(55, 13, 28, 4071, 'Service Réseaux Informatiques et Télécoms', NULL, NULL, '2023-07-26 10:21:08', '2023-11-29 07:46:05', NULL),
(56, 13, 28, 3881, 'Service Parc Informatique', NULL, NULL, '2023-07-26 10:26:12', '2023-11-29 07:46:46', NULL),
(57, 13, 29, 4073, 'Service Administration Base des données et Archives', NULL, NULL, '2023-07-26 10:31:56', '2023-11-29 07:47:37', NULL),
(58, NULL, 29, NULL, 'Service Etudes, Développement Digital et Cybersécurité', NULL, 1, '2023-07-26 10:33:34', '2023-07-26 10:33:34', NULL),
(59, 11, 30, 3910, 'Service Comptabilité Générale', NULL, NULL, '2023-07-26 10:38:06', '2023-11-29 08:14:59', NULL),
(60, 11, 30, 4086, 'Service Fiscalité', NULL, NULL, '2023-07-26 10:47:53', '2023-11-29 08:39:49', NULL),
(61, NULL, 30, NULL, 'Service CAG', NULL, 1, '2023-07-26 10:59:49', '2023-07-26 10:59:49', NULL),
(62, 11, 30, 4087, 'Service Comptabilité Immob.', NULL, NULL, '2023-07-26 11:02:12', '2023-11-29 08:40:51', NULL),
(63, 11, 31, 4081, 'Service Planification Financière', NULL, NULL, '2023-07-26 11:08:09', '2023-11-29 08:45:56', NULL),
(64, 11, 31, 3900, 'Service Opérations Financières', NULL, NULL, '2023-07-26 11:12:09', '2023-11-29 08:47:53', NULL),
(65, 11, 32, 1003, 'Service Budget d\'Exploitation et d\'Investissement', NULL, NULL, '2023-07-26 11:15:46', '2023-11-29 08:48:30', NULL),
(66, NULL, 32, NULL, 'Service Budget de Trésorerie', NULL, 1, '2023-07-26 11:18:34', '2023-07-26 11:18:34', NULL),
(67, 6, 33, 4037, 'service technique', NULL, NULL, '2023-11-21 15:14:51', '2023-11-21 15:14:51', NULL),
(68, 6, 33, 3920, 'Service Administratif et Financier', NULL, NULL, '2023-11-21 15:16:16', '2023-11-21 15:16:16', NULL),
(69, 6, 14, 3776, 'Service comptage', NULL, NULL, '2023-11-28 16:03:18', '2023-11-28 16:03:18', NULL),
(70, 6, 14, 3774, 'Service Maintenance Réseau', NULL, NULL, '2023-11-28 16:04:05', '2023-11-28 16:04:05', NULL),
(71, 6, 12, 3770, 'Service Expertise Groupe Electrogène', NULL, NULL, '2023-11-28 16:05:17', '2023-11-28 16:05:17', NULL),
(72, 13, 28, 4072, 'Service assistance aux utilisateurs', NULL, NULL, '2023-11-29 07:41:27', '2023-11-29 07:41:27', NULL),
(73, 12, 20, 4096, 'Service CMR Référence', NULL, NULL, '2023-11-29 08:12:35', '2023-11-29 08:12:35', NULL),
(74, 11, 30, 4084, 'Service comptabilité Analytique de gestion', NULL, NULL, '2023-11-29 08:41:59', '2023-11-29 08:41:59', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HYlY8B0oDSTGu6VESyQxbks08nGJmFMDeykd8bxS', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:129.0) Gecko/20100101 Firefox/129.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiemt5NEJiak9Oc2Jieml4ZFROSThXV2FzMk5veGFrQ21veXR0c0E3WSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvdGFjaGVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRnT3hPaHBMWXpsSEo0ZmVpRFRGYmoueEF0YktIYnJRYXFPWmVSWmxpczY1STh0eTJKdVhkZSI7fQ==', 1723650938);

-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

CREATE TABLE `statuts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id_updated_at` int(11) DEFAULT NULL,
  `id_deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statuts`
--

INSERT INTO `statuts` (`id`, `libelle`, `created_at`, `updated_at`, `deleted_at`, `id_updated_at`, `id_deleted_at`) VALUES
(1, 'En attente', '2022-04-19 13:08:36', '2022-04-19 13:08:36', NULL, NULL, NULL),
(2, 'En cours', '2022-04-19 13:08:36', '2022-04-19 13:08:36', NULL, NULL, NULL),
(3, 'Traité', '2022-04-19 13:09:08', '2022-04-19 13:09:08', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE `taches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED DEFAULT '1',
  `tache_statut_id` bigint(20) DEFAULT '1',
  `priorite_id` bigint(20) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pourcentage` int(11) DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `courrier_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `taches`
--

INSERT INTO `taches` (`id`, `user_id`, `statut_id`, `tache_statut_id`, `priorite_id`, `parent_id`, `titre`, `pourcentage`, `description`, `date_debut`, `date_fin`, `created_at`, `updated_at`, `deleted_at`, `courrier_id`) VALUES
(1, 1, 1, 4, 1, NULL, 'qfjqdfdq pour Secrétariat Général', 0, '<p>qdfdqfjbdhfjld fdqhfdjfdf fdfhdlkhdfhdlfkf</p>', '2024-06-21', '2024-06-27', '2024-06-20 15:18:12', '2024-06-28 10:03:36', NULL, NULL),
(2, 1, 1, 4, 1, NULL, 'Deploiement du projet Jurixio pour Secrétariat Général', 0, '<p>Bonjour ceci un message test</p>', '2024-06-24', '2024-06-26', '2024-06-20 15:25:14', '2024-06-28 10:03:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `taches_statuts`
--

CREATE TABLE `taches_statuts` (
  `id` bigint(20) NOT NULL,
  `titre` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taches_statuts`
--

INSERT INTO `taches_statuts` (`id`, `titre`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Initial', '2022-11-29 15:53:15', '2022-11-29 15:53:15', NULL),
(2, 'En cours', '2022-11-29 15:53:15', '2022-11-29 15:53:15', NULL),
(3, 'Fini', '2022-11-29 15:53:15', '2022-11-29 15:53:15', NULL),
(4, 'Hors délai', '2023-11-15 10:26:52', '2023-11-15 10:26:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tache_documents`
--

CREATE TABLE `tache_documents` (
  `id` bigint(20) NOT NULL,
  `tache_id` bigint(20) NOT NULL,
  `document_id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tache_documents`
--

INSERT INTO `tache_documents` (`id`, `tache_id`, `document_id`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2024-06-20 16:25:14', '2024-06-20 16:25:14'),
(2, 2, 4, '2024-06-20 16:28:04', '2024-06-20 16:28:04'),
(3, 2, 5, '2024-06-20 16:34:43', '2024-06-20 16:34:43');

-- --------------------------------------------------------

--
-- Structure de la table `tache_objectifs`
--

CREATE TABLE `tache_objectifs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tache_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tache_objectifs`
--

INSERT INTO `tache_objectifs` (`id`, `libelle`, `statut`, `created_at`, `updated_at`, `tache_id`, `agent_id`, `user_id`) VALUES
(1, 'Signer le document', '0', '2024-06-20 15:21:21', '2024-06-20 15:21:21', 1, 1, 1),
(2, 'Facture proforma', '0', '2024-06-20 15:21:44', '2024-06-20 15:21:44', 1, 4420, 1),
(3, 'Contacter le secretariat général', '0', '2024-06-20 15:25:53', '2024-06-20 15:25:53', 2, 4420, 1),
(4, 'Faire le compte rendu au DGA', '0', '2024-06-20 15:29:44', '2024-06-20 15:29:44', 2, 3722, 1),
(5, 'Préparer les visuels marketing du projet ', '0', '2024-06-20 15:36:58', '2024-06-20 15:36:58', 2, 4074, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_notifications`
--

CREATE TABLE `type_notifications` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_notifications`
--

INSERT INTO `type_notifications` (`id`, `libelle`, `content`, `created_at`, `updated_at`) VALUES
(1, 'message', 'A envoyé un message', NULL, NULL),
(2, 'tache', 'Vient de laisser un commentaire sur le projet', NULL, NULL),
(3, 'courrier', 'A envoyé un courrier', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `statut_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_use` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `statut_id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `first_use`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Herve Kinsala', 'hervekinsala@newtech-rdc.net', NULL, '$2y$10$gOxOhpLYzlHJ4feiDTFbj.xAtbKHbrQaqOZeRZlis65I8ty2JuXde', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2033-11-24 08:59:43', '2023-12-12 11:33:31'),
(3722, NULL, 1, 'Yasmine Kabengele', 'yasminekabengele@newtech-rdc.net', NULL, '$2y$10$gOxOhpLYzlHJ4feiDTFbj.xAtbKHbrQaqOZeRZlis65I8ty2JuXde', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2033-12-05 08:59:43', '2023-10-11 13:24:59'),
(3723, NULL, 1, 'Francis Isasi', 'francisisasi@newtech-rdc.net', NULL, '$2y$10$gOxOhpLYzlHJ4feiDTFbj.xAtbKHbrQaqOZeRZlis65I8ty2JuXde', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2033-12-06 08:59:43', '2023-10-31 05:35:48'),
(4074, NULL, 1, 'Caleb Kuedisala', 'calebkuedisala@newtech-rdc.net', NULL, '$2y$10$gOxOhpLYzlHJ4feiDTFbj.xAtbKHbrQaqOZeRZlis65I8ty2JuXde', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2034-11-22 08:59:43', '2023-10-19 06:23:28'),
(4420, NULL, 1, 'Jeanpy Ntumba', 'jeanpyntumba@newtech-rdc.net', NULL, '$2y$10$gOxOhpLYzlHJ4feiDTFbj.xAtbKHbrQaqOZeRZlis65I8ty2JuXde', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-06 15:46:10', '2023-12-06 15:50:36');

-- --------------------------------------------------------

--
-- Structure de la table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `viewable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewable_id` bigint(20) UNSIGNED NOT NULL,
  `visitor` text COLLATE utf8mb4_unicode_ci,
  `collection` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `views`
--

INSERT INTO `views` (`id`, `viewable_type`, `viewable_id`, `visitor`, `collection`, `user_id`, `viewed_at`) VALUES
(1, 'App\\Models\\Courrier', 1, 'bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z', NULL, 3723, '2024-05-29 18:25:32'),
(2, 'App\\Models\\Courrier', 1, '0iQFadonlAd4dgG1ePdcHkeN94NCKDbYGa7MAURejYql7xrLxZE8kxjuPkPOIaLboi592vaa52ovHYPI', NULL, 3722, '2024-05-29 18:29:32'),
(3, 'App\\Models\\Courrier', 1, 'ul7Va7KeLc3AK4X2pxKdpIv8BQg17LHZSmWwgE6qIREJQOkyCKQXn56oPW34zIfEn7igfKwmjpqYV4dE', NULL, 4074, '2024-05-29 18:40:15'),
(4, 'App\\Models\\Courrier', 1, 'bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z', NULL, 1, '2024-05-29 18:43:34'),
(5, 'App\\Models\\Courrier', 2, 'bWyod1bCpW3m6UrhvkVp75f15Sq2AzFCA7Do5nPlM2LwrTCZNKv2yofiHmQumOeGBPi9G8wwPSqbyx9Z', NULL, 1, '2024-05-29 19:50:59'),
(6, 'App\\Models\\Courrier', 2, 'ul7Va7KeLc3AK4X2pxKdpIv8BQg17LHZSmWwgE6qIREJQOkyCKQXn56oPW34zIfEn7igfKwmjpqYV4dE', NULL, 4074, '2024-05-29 19:51:41'),
(7, 'App\\Models\\Courrier', 3, '7snaeCMWSBPP2sYVFoPmM0G80S7glj8xduSBQTdefPZBlS7sMAaWtjR2BguUUQPite9kXfnwnOpDOke8', NULL, 3723, '2024-05-30 10:50:47'),
(8, 'App\\Models\\Courrier', 3, 'q5RDhzSfZGnuHR32vq4q3iZkT3XimsBNCZMIykCzj5i05B6BkUXqJf6kIZCIIYGW9feyKmUcwAmpnBEt', NULL, 3722, '2024-05-30 11:04:17'),
(9, 'App\\Models\\Courrier', 4, 'mQydOUQimRJgpzJL2WIYDq5UdWfE72kyBF6PvEq8NK8IuMyJ5DHFyeILBy3MyHmW5v0qaLQmSm5OwS5u', NULL, 3723, '2024-07-07 20:52:04'),
(10, 'App\\Models\\Courrier', 4, 'NUE6dgeZ0Re9NfFGjQae6JMayBkzo9xdrGBfaWcwPdP40ZgZwbca6oGiwC39cG9E5171UIrA9Oq2fi47', NULL, 3722, '2024-07-08 09:37:24'),
(11, 'App\\Models\\Courrier', 4, 'ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT', NULL, 4074, '2024-07-08 09:39:25'),
(12, 'App\\Models\\Courrier', 4, 'qWyxodijoFsoA0FxaPUVchI49c3XsRv4BkbC2KXiFSZZmuwY9ylSHvGr1UIGXQfk6GsqMO40NU4xiIm9', NULL, 1, '2024-07-08 09:41:25'),
(13, 'App\\Models\\Courrier', 5, 'ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT', NULL, 4074, '2024-07-08 09:46:01'),
(14, 'App\\Models\\Courrier', 5, 'NUE6dgeZ0Re9NfFGjQae6JMayBkzo9xdrGBfaWcwPdP40ZgZwbca6oGiwC39cG9E5171UIrA9Oq2fi47', NULL, 3722, '2024-07-08 09:49:00'),
(15, 'App\\Models\\Courrier', 5, 'ng9Nmn3lxVaN2MHmLDJmwHGjCZrQPMrmdUGWkwiTjVpOM7H9y76JPq3HZI50PEcUusRRMB3ed2e4KhJT', NULL, 3723, '2024-07-08 09:50:28');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accuse_receptions`
--
ALTER TABLE `accuse_receptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Index pour la table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_matricule` (`matricule`);

--
-- Index pour la table `agent_brouillons`
--
ALTER TABLE `agent_brouillons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `agent_statuts`
--
ALTER TABLE `agent_statuts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `archive_permissions`
--
ALTER TABLE `archive_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archive_permissions_agent_id_foreign` (`agent_id`);

--
-- Index pour la table `assistanats`
--
ALTER TABLE `assistanats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `authentication_log`
--
ALTER TABLE `authentication_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authentication_log_authenticatable_type_authenticatable_id_index` (`authenticatable_type`,`authenticatable_id`);

--
-- Index pour la table `brouillons`
--
ALTER TABLE `brouillons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `brouillon_commentaires`
--
ALTER TABLE `brouillon_commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `classeurs`
--
ALTER TABLE `classeurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classeurs_departement_id_foreign` (`direction_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commentaires_tache_id_foreign` (`tache_id`),
  ADD KEY `commentaires_user_id_foreign` (`user_id`),
  ADD KEY `commentaires_statut_id_foreign` (`statut_id`);

--
-- Index pour la table `courriers`
--
ALTER TABLE `courriers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courriers_annotations`
--
ALTER TABLE `courriers_annotations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courriers_etapes`
--
ALTER TABLE `courriers_etapes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courriers_partages`
--
ALTER TABLE `courriers_partages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courriers_traitements_agents`
--
ALTER TABLE `courriers_traitements_agents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_categories`
--
ALTER TABLE `courrier_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_destinateurs`
--
ALTER TABLE `courrier_destinateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_destinateur_externes`
--
ALTER TABLE `courrier_destinateur_externes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_expediteurs`
--
ALTER TABLE `courrier_expediteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_followers`
--
ALTER TABLE `courrier_followers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_natures`
--
ALTER TABLE `courrier_natures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_traitements`
--
ALTER TABLE `courrier_traitements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_types`
--
ALTER TABLE `courrier_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `courrier_types_traitements`
--
ALTER TABLE `courrier_types_traitements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `delegue_permissions`
--
ALTER TABLE `delegue_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `directions`
--
ALTER TABLE `directions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisions_departement_id_foreign` (`direction_id`),
  ADD KEY `divisions_statut_id_foreign` (`statut_id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`),
  ADD KEY `documents_statut_id_foreign` (`statut_id`);

--
-- Index pour la table `document_followers`
--
ALTER TABLE `document_followers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_natures`
--
ALTER TABLE `document_natures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_notes`
--
ALTER TABLE `document_notes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_statuts`
--
ALTER TABLE `document_statuts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_templates`
--
ALTER TABLE `document_templates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dossiers`
--
ALTER TABLE `dossiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dossier_passwords`
--
ALTER TABLE `dossier_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etapes`
--
ALTER TABLE `etapes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etats`
--
ALTER TABLE `etats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etats_user_id_foreign` (`user_id`),
  ADD KEY `etats_statut_id_foreign` (`statut_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historiques_user_id_foreign` (`user_id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `lieu_affectations`
--
ALTER TABLE `lieu_affectations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Index pour la table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Index pour la table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Index pour la table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Index pour la table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Index pour la table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `pivot_agent_fonctions`
--
ALTER TABLE `pivot_agent_fonctions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pivot_documents_agents`
--
ALTER TABLE `pivot_documents_agents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pivot_documents_notes`
--
ALTER TABLE `pivot_documents_notes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pivot_taches_agents`
--
ALTER TABLE `pivot_taches_agents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pivot_user_conges`
--
ALTER TABLE `pivot_user_conges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pivot_user_conges_conge_id_foreign` (`conge_id`),
  ADD KEY `pivot_user_conges_user_id_foreign` (`user_id`),
  ADD KEY `pivot_user_conges_statut_id_foreign` (`statut_id`);

--
-- Index pour la table `pivot_user_taches`
--
ALTER TABLE `pivot_user_taches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pivot_user_taches_tache_id_foreign` (`tache_id`),
  ADD KEY `pivot_user_taches_user_id_foreign` (`user_id`),
  ADD KEY `pivot_user_taches_statut_id_foreign` (`statut_id`);

--
-- Index pour la table `pointages`
--
ALTER TABLE `pointages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pointages_user_id_foreign` (`user_id`),
  ADD KEY `agent_pointage` (`agent_id`);

--
-- Index pour la table `priorites`
--
ALTER TABLE `priorites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  ADD KEY `push_subscriptions_subscribable_type_subscribable_id_index` (`subscribable_type`,`subscribable_id`);

--
-- Index pour la table `revisions`
--
ALTER TABLE `revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `secretariats`
--
ALTER TABLE `secretariats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `statuts`
--
ALTER TABLE `statuts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taches_user_id_foreign` (`user_id`);

--
-- Index pour la table `taches_statuts`
--
ALTER TABLE `taches_statuts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tache_documents`
--
ALTER TABLE `tache_documents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tache_objectifs`
--
ALTER TABLE `tache_objectifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cibles_tache_id_foreign` (`tache_id`),
  ADD KEY `cibles_user_id_foreign` (`user_id`);

--
-- Index pour la table `type_notifications`
--
ALTER TABLE `type_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_viewable_type_viewable_id_index` (`viewable_type`,`viewable_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accuse_receptions`
--
ALTER TABLE `accuse_receptions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `adresses`
--
ALTER TABLE `adresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT pour la table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4421;

--
-- AUTO_INCREMENT pour la table `agent_brouillons`
--
ALTER TABLE `agent_brouillons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `agent_statuts`
--
ALTER TABLE `agent_statuts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `archive_permissions`
--
ALTER TABLE `archive_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `assistanats`
--
ALTER TABLE `assistanats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `authentication_log`
--
ALTER TABLE `authentication_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `brouillons`
--
ALTER TABLE `brouillons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `brouillon_commentaires`
--
ALTER TABLE `brouillon_commentaires`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classeurs`
--
ALTER TABLE `classeurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `courriers`
--
ALTER TABLE `courriers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `courriers_annotations`
--
ALTER TABLE `courriers_annotations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `courriers_etapes`
--
ALTER TABLE `courriers_etapes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `courriers_partages`
--
ALTER TABLE `courriers_partages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `courriers_traitements_agents`
--
ALTER TABLE `courriers_traitements_agents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `courrier_categories`
--
ALTER TABLE `courrier_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `courrier_destinateurs`
--
ALTER TABLE `courrier_destinateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `courrier_destinateur_externes`
--
ALTER TABLE `courrier_destinateur_externes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `courrier_expediteurs`
--
ALTER TABLE `courrier_expediteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `courrier_followers`
--
ALTER TABLE `courrier_followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `courrier_natures`
--
ALTER TABLE `courrier_natures`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `courrier_traitements`
--
ALTER TABLE `courrier_traitements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `courrier_types`
--
ALTER TABLE `courrier_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `courrier_types_traitements`
--
ALTER TABLE `courrier_types_traitements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `delegue_permissions`
--
ALTER TABLE `delegue_permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `directions`
--
ALTER TABLE `directions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `document_followers`
--
ALTER TABLE `document_followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `document_natures`
--
ALTER TABLE `document_natures`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `document_notes`
--
ALTER TABLE `document_notes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `document_statuts`
--
ALTER TABLE `document_statuts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `document_templates`
--
ALTER TABLE `document_templates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `dossiers`
--
ALTER TABLE `dossiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `dossier_passwords`
--
ALTER TABLE `dossier_passwords`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etapes`
--
ALTER TABLE `etapes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `etats`
--
ALTER TABLE `etats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonctions`
--
ALTER TABLE `fonctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT pour la table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lieu_affectations`
--
ALTER TABLE `lieu_affectations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pivot_agent_fonctions`
--
ALTER TABLE `pivot_agent_fonctions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pivot_documents_agents`
--
ALTER TABLE `pivot_documents_agents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pivot_documents_notes`
--
ALTER TABLE `pivot_documents_notes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pivot_taches_agents`
--
ALTER TABLE `pivot_taches_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `pivot_user_conges`
--
ALTER TABLE `pivot_user_conges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pivot_user_taches`
--
ALTER TABLE `pivot_user_taches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pointages`
--
ALTER TABLE `pointages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `priorites`
--
ALTER TABLE `priorites`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `revisions`
--
ALTER TABLE `revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `secretariats`
--
ALTER TABLE `secretariats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `statuts`
--
ALTER TABLE `statuts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `taches_statuts`
--
ALTER TABLE `taches_statuts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tache_documents`
--
ALTER TABLE `tache_documents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tache_objectifs`
--
ALTER TABLE `tache_objectifs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `type_notifications`
--
ALTER TABLE `type_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4421;

--
-- AUTO_INCREMENT pour la table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
