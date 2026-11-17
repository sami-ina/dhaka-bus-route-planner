-- =====================================================================
-- Dhaka Bus Route Planner & Transit Information System
-- Database Schema and Initial Seed Data
-- Compatible with MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `dhaka_transit` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dhaka_transit`;

-- ---------------------------------------------------------------------
-- 1. Table: places (Locations in Dhaka with English & Bengali names)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `bus_stops`;
DROP TABLE IF EXISTS `buses`;
DROP TABLE IF EXISTS `road_updates`;
DROP TABLE IF EXISTS `places`;
DROP TABLE IF EXISTS `system_settings`;

CREATE TABLE `places` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name_en` VARCHAR(100) NOT NULL UNIQUE,
  `name_bn` VARCHAR(150) NOT NULL,
  `is_popular` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 2. Table: buses (Bus Companies, Routes, and Service Details)
-- ---------------------------------------------------------------------
CREATE TABLE `buses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `bus_name` VARCHAR(120) NOT NULL,
  `bus_number` VARCHAR(30) NOT NULL,
  `duration_text` VARCHAR(50) NOT NULL,
  `duration_minutes` INT NOT NULL,
  `distance_text` VARCHAR(50) NOT NULL,
  `distance_km` DECIMAL(5,2) NOT NULL,
  `fare` INT NOT NULL,
  `traffic_condition` ENUM('light', 'moderate', 'heavy') DEFAULT 'moderate',
  `badge_color` VARCHAR(20) DEFAULT '#087f5b',
  `frequency` VARCHAR(50) NOT NULL,
  `note` VARCHAR(100) DEFAULT '',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 3. Table: bus_stops (Sequential stops for each bus route)
-- ---------------------------------------------------------------------
CREATE TABLE `bus_stops` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `bus_id` INT NOT NULL,
  `stop_name` VARCHAR(100) NOT NULL,
  `stop_order` INT NOT NULL,
  CONSTRAINT `fk_bus_stops_buses` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 4. Table: road_updates (Live construction and road closure reports)
-- ---------------------------------------------------------------------
CREATE TABLE `road_updates` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `road_en` VARCHAR(150) NOT NULL,
  `road_bn` VARCHAR(200) NOT NULL,
  `area_en` VARCHAR(150) NOT NULL,
  `area_bn` VARCHAR(200) NOT NULL,
  `status_en` VARCHAR(100) NOT NULL,
  `status_bn` VARCHAR(150) NOT NULL,
  `remaining_en` VARCHAR(50) NOT NULL,
  `remaining_bn` VARCHAR(50) NOT NULL,
  `impact_level` ENUM('Low impact', 'Medium impact', 'High impact') DEFAULT 'Medium impact',
  `updated_en` VARCHAR(50) NOT NULL,
  `updated_bn` VARCHAR(50) NOT NULL,
  `detail_en` TEXT NOT NULL,
  `detail_bn` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 5. Table: system_settings (System configurations & External APIs)
-- ---------------------------------------------------------------------
CREATE TABLE `system_settings` (
  `setting_key` VARCHAR(50) PRIMARY KEY,
  `setting_value` TEXT,
  `description` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- SEED DATA INSERTIONS
-- =====================================================================

-- Places Seed
INSERT INTO `places` (`name_en`, `name_bn`, `is_popular`) VALUES
('Abdullahpur', 'আব্দুল্লাহপুর', 0),
('Agargaon', 'আগারগাঁও', 1),
('Airport', 'বিমানবন্দর', 1),
('Asad Gate', 'আসাদ গেট', 0),
('Azimpur', 'আজিমপুর', 1),
('Badda', 'বাড্ডা', 0),
('Banani', 'বনানী', 1),
('Bashundhara', 'বসুন্ধরা', 0),
('Dhanmondi 27', 'ধানমন্ডি ২৭', 1),
('Farmgate', 'ফার্মগেট', 1),
('Gabtoli', 'গাবতলী', 0),
('Gulistan', 'গুলিস্তান', 1),
('Gulshan 1', 'গুলশান ১', 1),
('Jatrabari', 'যাত্রাবাড়ী', 1),
('Kakrail', 'কাকরাইল', 0),
('Kalabagan', 'কলাবাগান', 0),
('Kazipara', 'কাজীপাড়া', 0),
('Khilgaon', 'খিলগাঁও', 0),
('Malibagh', 'মালিবাগ', 0),
('Mirpur 1', 'মিরপুর ১', 0),
('Mirpur 10', 'মিরপুর ১০', 1),
('Mohakhali', 'মহাখালী', 1),
('Motijheel', 'মতিঝিল', 1),
('New Market', 'নিউ মার্কেট', 1),
('Paltan', 'পল্টন', 1),
('Rampura', 'রামপুরা', 0),
('Shahbagh', 'শাহবাগ', 1),
('Shewrapara', 'শেওড়াপাড়া', 0),
('Shyamoli', 'শ্যামলী', 0),
('Technical', 'টেকনিক্যাল', 0),
('Uttara', 'উত্তরা', 1),
('Wari', 'ওয়ারী', 0);

-- Buses Seed
INSERT INTO `buses` (`id`, `bus_name`, `bus_number`, `duration_text`, `duration_minutes`, `distance_text`, `distance_km`, `fare`, `traffic_condition`, `badge_color`, `frequency`, `note`, `is_active`) VALUES
(1, 'Bahon Express', 'B-17', '48 min', 48, '12.4 km', 12.40, 45, 'moderate', '#f59e0b', '12–15 min', 'Fastest route', 1),
(2, 'Shikor Paribahan', 'S-08', '42 min', 42, '10.1 km', 10.10, 40, 'light', '#18a572', '15–20 min', 'Less crowded', 1),
(3, 'Bihanga Paribahan', 'B-22', '55 min', 55, '14.6 km', 14.60, 50, 'heavy', '#ef6a54', '18–22 min', 'More seats', 1),
(4, 'Airport Bangabandhu Avenue', 'A-11', '49 min', 49, '15.2 km', 15.20, 55, 'moderate', '#3b82f6', '10–15 min', 'Airport route', 1),
(5, 'Victor Classic', 'V-05', '44 min', 44, '11.8 km', 11.80, 40, 'heavy', '#8b5cf6', '12–18 min', 'City route', 1),
(6, 'Turag Transport', 'T-19', '58 min', 58, '16.3 km', 16.30, 60, 'moderate', '#0ea5a4', '15–20 min', 'Long route', 1),
(7, 'Achim Paribahan', 'A-07', '52 min', 52, '13.9 km', 13.90, 50, 'light', '#db2777', '14–18 min', 'Popular route', 1),
(8, 'Raida Enterprise', 'R-03', '47 min', 47, '14.1 km', 14.10, 50, 'moderate', '#ca8a04', '10–16 min', 'Northern route', 1);

-- Bus Stops Seed
-- 1. Bahon Express (Mirpur 10 to Motijheel)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(1, 'Mirpur 10', 1),
(1, 'Kazipara', 2),
(1, 'Shewrapara', 3),
(1, 'Agargaon', 4),
(1, 'Farmgate', 5),
(1, 'Shahbagh', 6),
(1, 'Paltan', 7),
(1, 'Motijheel', 8);

-- 2. Shikor Paribahan (Mirpur 10 to Azimpur)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(2, 'Mirpur 10', 1),
(2, 'Mirpur 1', 2),
(2, 'Technical', 3),
(2, 'Shyamoli', 4),
(2, 'Dhanmondi 27', 5),
(2, 'New Market', 6),
(2, 'Azimpur', 7);

-- 3. Bihanga Paribahan (Mirpur 10 to Badda)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(3, 'Mirpur 10', 1),
(3, 'Agargaon', 2),
(3, 'Mohakhali', 3),
(3, 'Gulshan 1', 4),
(3, 'Badda', 5);

-- 4. Airport Bangabandhu Avenue (Uttara to Shahbagh)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(4, 'Uttara', 1),
(4, 'Airport', 2),
(4, 'Banani', 3),
(4, 'Mohakhali', 4),
(4, 'Farmgate', 5),
(4, 'Shahbagh', 6);

-- 5. Victor Classic (Badda to Motijheel)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(5, 'Badda', 1),
(5, 'Rampura', 2),
(5, 'Malibagh', 3),
(5, 'Kakrail', 4),
(5, 'Paltan', 5),
(5, 'Motijheel', 6);

-- 6. Turag Transport (Jatrabari to Mohakhali)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(6, 'Jatrabari', 1),
(6, 'Gulistan', 2),
(6, 'Paltan', 3),
(6, 'Shahbagh', 4),
(6, 'Farmgate', 5),
(6, 'Mohakhali', 6);

-- 7. Achim Paribahan (Gabtoli to Gulistan)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(7, 'Gabtoli', 1),
(7, 'Shyamoli', 2),
(7, 'Asad Gate', 3),
(7, 'Dhanmondi 27', 4),
(7, 'Kalabagan', 5),
(7, 'Shahbagh', 6),
(7, 'Gulistan', 7);

-- 8. Raida Enterprise (Abdullahpur to Rampura)
INSERT INTO `bus_stops` (`bus_id`, `stop_name`, `stop_order`) VALUES
(8, 'Abdullahpur', 1),
(8, 'Uttara', 2),
(8, 'Airport', 3),
(8, 'Bashundhara', 4),
(8, 'Badda', 5),
(8, 'Rampura', 6);

-- Road Construction Updates Seed
INSERT INTO `road_updates` (`id`, `road_en`, `road_bn`, `area_en`, `area_bn`, `status_en`, `status_bn`, `remaining_en`, `remaining_bn`, `impact_level`, `updated_en`, `updated_bn`, `detail_en`, `detail_bn`) VALUES
(1, 'Begum Rokeya Avenue', 'বেগম রোকেয়া সরণি', 'Kazipara to Shewrapara', 'কাজীপাড়া থেকে শেওড়াপাড়া', 'Lane restricted', 'লেন সীমিত', '12 days', '১২ দিন', 'High impact', '8 min ago', '৮ মিনিট আগে', 'Utility relocation is restricting the left lane. Use Mirpur Road through Agargaon as an alternative.', 'ইউটিলিটি স্থানান্তরের কারণে বাম লেন সীমিত। বিকল্প হিসেবে আগারগাঁও হয়ে মিরপুর রোড ব্যবহার করুন।'),
(2, 'Airport Road', 'বিমানবন্দর সড়ক', 'Banani rail crossing', 'বনানী রেল ক্রসিং', 'Night work only', 'শুধু রাতে কাজ', '5 days', '৫ দিন', 'Low impact', '24 min ago', '২৪ মিনিট আগে', 'Resurfacing work runs from 11:00 PM to 5:00 AM. Daytime traffic is operating normally.', 'রাত ১১টা থেকে ভোর ৫টা পর্যন্ত সড়ক মেরামত চলে। দিনের বেলা যান চলাচল স্বাভাবিক।'),
(3, 'Moghbazar Flyover', 'মগবাজার ফ্লাইওভার', 'Moghbazar intersection', 'মগবাজার মোড়', 'One lane closed', 'একটি লেন বন্ধ', '8 days', '৮ দিন', 'Medium impact', '41 min ago', '৪১ মিনিট আগে', 'Expansion joint repair is underway. Expect delays during the evening peak period.', 'এক্সপ্যানশন জয়েন্ট মেরামত চলছে। সন্ধ্যার ব্যস্ত সময়ে বিলম্ব হতে পারে।');

-- System Settings Seed
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `description`) VALUES
('app_name', 'RouteDhaka', 'Application display title'),
('app_subtitle', 'Dhaka Bus Route Planner & Transit Information System', 'Application subtitle'),
('google_maps_api_key', '', 'Google Maps JavaScript API Key (Optional; embeds work without key)'),
('default_origin', 'Mirpur 10', 'Default selected origin'),
('default_destination', 'Farmgate', 'Default selected destination');

