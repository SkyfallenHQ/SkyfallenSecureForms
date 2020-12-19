-- Skyfallen Secure Forms, SQL INSTALL SCRIPT
-- version SFDBSQLV-301001
-- https://www.theskyafallen.com
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `ssf_fields` (
  `form_id` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `field_order` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `field_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_id` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `field_charlimit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `field_options` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ssf_forms` (
  `formid` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `formname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formcreator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formcreationtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formdomain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formvisibility` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ssf_form_meta` (
  `formid` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `form_meta` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `form_meta_value` varchar(1024) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ssf_key_meta` (
  `keyid` varchar(4096) COLLATE utf8_unicode_ci NOT NULL,
  `meta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(8192) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ssf_responses` (
  `ssf_form_id` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `ssf_respondent_id` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `ssf_form_field_id` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `ssf_field_response` varchar(8192) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ssf_settings` (
  `setting` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ssf_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hashed_password` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `ssf_forms`
  ADD UNIQUE KEY `formid` (`formid`);

ALTER TABLE `ssf_settings`
  ADD UNIQUE KEY `setting` (`setting`);

ALTER TABLE `ssf_users`
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `ssf_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
