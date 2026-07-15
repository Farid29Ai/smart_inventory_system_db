-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2026 at 01:02 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_inventory_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `admin_level` varchar(50) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `password`, `phone_no`, `admin_level`, `profile_image`, `created_at`) VALUES
(1, 'Admin Smart Inventory', 'admin@gmail.com', '12345', '01122223333', 'Super Admin', '/uploads/admins/admins-1782573089-cb91f140.jpg', '2026-06-26 22:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `description`) VALUES
(1, 'Stationery', 'Barang alat tulis'),
(2, 'IT Equipment', 'Peralatan komputer dan teknologi'),
(3, 'Computer equitment', 'kk'),
(16, 'Office Supplies', 'Keperluan operasi pejabat harian.'),
(17, 'Paper Products', 'Kertas, buku nota dan bahan cetakan.'),
(18, 'Cleaning Supplies', 'Bahan pembersihan dan kebersihan pejabat.'),
(19, 'Furniture', 'Perabot pejabat.'),
(20, 'IT Accessories', 'Aksesori komputer dan kabel.'),
(21, 'Storage & Filing', 'Fail, kabinet dan penyimpanan dokumen.');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` text,
  `category_id` int DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `quantity_available` int DEFAULT '0',
  `minimum_stock` int DEFAULT '0',
  `unit` varchar(50) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Available',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `description`, `category_id`, `vendor_id`, `quantity_available`, `minimum_stock`, `unit`, `item_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A4 Paper', 'A4 copy paper for printing and photocopying.', 1, 1, 60, 10, '1', 'items/a4-paper.png', 'Available', '2026-06-26 22:54:28', '2026-07-15 18:07:58'),
(2, 'Laptop Dell', 'Portable laptop for office productivity tasks.', 2, 1, 5, 0, '1', 'items/laptop-dell.png', 'Available', '2026-06-26 22:54:28', '2026-07-15 18:07:58'),
(6, 'Pencil', 'Pencil stock for daily office writing.', 1, 1, 19, 20, '20', 'items/pencil.png', 'Available', '2026-06-27 16:07:07', '2026-07-15 18:07:58'),
(46, 'Stapler', 'Desktop stapler for binding printed documents.', 16, 10, 120, 15, '1', 'items/stapler.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(47, 'A4 Blue Paper', 'Colored A4 paper for office printing.', 17, 11, 200, 20, '1', 'items/a4-blue-paper.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 18:07:58'),
(48, 'Printer', 'Office printer for shared departmental printing.', 2, 12, 8, 0, '1', 'items/printer.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(50, 'Office Chair', 'Ergonomic office chair.', 19, 14, 12, 20, '1', 'items/office-chair.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(51, 'Wireless Mouse', 'Wireless mouse for workstations.', 20, 12, 42, 8, '1', 'items/wireless-mouse.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(52, 'Lever Arch File', 'Lever arch file for document filing.', 21, 15, 25, 8, '1', 'items/lever-arch-file.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(53, 'Whiteboard Marker', 'Dry erase marker for meeting rooms.', 1, 10, 78, 12, '1', 'items/whiteboard-marker.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(54, 'Calculator', 'Desktop calculator for office calculations.', 16, 1, 15, 20, '1', 'items/calculator.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(55, 'Yellow Highlighter', 'Highlighter marker for documents.', 1, 10, 85, 10, '1', 'items/yellow-highlighter.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(56, 'Keyboard', 'Standard USB keyboard.', 20, 12, 22, 6, '1', 'items/keyboard.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(57, 'Desktop Monitor', 'LED monitor for workstation use.', 2, 12, 7, 0, '1', 'items/desktop-monitor.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(58, 'USB Flash Drive', 'USB storage device.', 20, 12, 55, 10, '1', 'items/usb-flash-drive.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(59, 'Extension Plug', 'Extension power strip.', 20, 1, 16, 20, '1', 'items/extension-plug.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(60, 'Scissors', 'Office scissors.', 1, 1, 24, 6, '1', 'items/scissors.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(61, 'Glue Stick', 'Glue stick for paper documents.', 1, 1, 30, 10, '1', 'items/glue-stick.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(62, 'Sticky Notes', 'Sticky note pads.', 17, 11, 50, 12, '1', 'items/sticky-notes.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(63, 'Paper Clips', 'Paper clips for documents.', 16, 10, 90, 20, '1', 'items/paper-clips.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(64, 'Puncher', 'Two-hole puncher.', 16, 1, 14, 20, '1', 'items/puncher.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(65, 'Envelope', 'Mailing envelopes.', 17, 11, 100, 25, '1', 'items/envelope.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(66, 'Document Tray', 'Stackable document tray.', 21, 15, 19, 20, '1', 'items/document-tray.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(67, 'Toner Cartridge', 'Printer toner cartridge.', 20, 12, 9, 0, '1', 'items/toner-cartridge.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(68, 'Printer Ink', 'Printer ink cartridge.', 20, 12, 11, 20, '1', 'items/printer-ink.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(69, 'Whiteboard Eraser', 'Whiteboard eraser.', 16, 10, 21, 8, '1', 'items/whiteboard-eraser.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(70, 'Cleaning Cloth', 'Microfiber cleaning cloth.', 18, 13, 40, 12, '1', 'items/cleaning-cloth.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(71, 'Hand Sanitizer', 'Hand sanitizer bottle.', 18, 13, 18, 20, '1', 'items/hand-sanitizer.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(72, 'Waste Bin', 'Office waste bin.', 18, 13, 8, 0, '1', 'items/waste-bin.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(73, 'Office Desk', 'Office desk for workstations.', 19, 14, 6, 0, '1', 'items/office-desk.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(74, 'Filing Cabinet', 'Document filing cabinet.', 21, 14, 5, 0, '1', 'items/filing-cabinet.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(75, 'Webcam', 'Webcam for online meetings.', 20, 12, 13, 20, '1', 'items/webcam.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(76, 'Headset', 'Headset with microphone.', 20, 12, 17, 20, '1', 'items/headset.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(77, 'HDMI Cable', 'HDMI cable for presentations.', 20, 12, 28, 8, '1', 'items/hdmi-cable.png', 'Available', '2026-07-15 09:09:13', '2026-07-15 09:09:13'),
(78, 'Correction Tape', 'Correction tape for document editing.', 1, 1, 0, 8, '1', 'items/correction-tape.png', 'Out of Stock', '2026-07-15 09:09:13', '2026-07-15 09:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `requisition`
--

CREATE TABLE `requisition` (
  `requisition_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `request_date` date DEFAULT (curdate()),
  `required_date` date DEFAULT NULL,
  `purpose` text,
  `status` varchar(50) DEFAULT 'Pending',
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requisition`
--

INSERT INTO `requisition` (`requisition_id`, `staff_id`, `admin_id`, `request_date`, `required_date`, `purpose`, `status`, `remarks`) VALUES
(3, 1, 1, '2026-06-26', NULL, 'saja', 'Approved', 'tiada\r\n'),
(4, 1, 1, '2026-06-26', NULL, 'kegunaan office', 'Approved', 'tiada'),
(5, 1, 1, '2026-07-06', NULL, '', 'Rejected', ''),
(7, 1, 1, '2026-07-09', '2026-07-09', 'SAYA RASA INI YANG TERBAIK', 'Approved', 'SAYA SINGLE'),
(8, 1, NULL, '2026-07-11', '2026-07-12', 'MACAM TIADA', 'Pending', 'MACAM II'),
(10, 1, NULL, '2026-07-15', NULL, 'Ofiice ', 'Pending', 'tiada');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_item`
--

CREATE TABLE `requisition_item` (
  `requisition_item_id` int NOT NULL,
  `requisition_id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantity_requested` int NOT NULL,
  `quantity_approved` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requisition_item`
--

INSERT INTO `requisition_item` (`requisition_item_id`, `requisition_id`, `item_id`, `quantity_requested`, `quantity_approved`) VALUES
(6, 7, 6, 1, 1),
(7, 8, 1, 1, 0),
(8, 8, 2, 1, 0),
(10, 10, 1, 1, 0),
(11, 10, 71, 1, 0),
(12, 10, 57, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `email`, `password`, `phone_no`, `department`, `position`, `profile_image`, `created_at`) VALUES
(1, 'Ali Bin Ahmad', 'ali@gmail.com', '12345', '01211112222', 'IT Department', 'Staff IT', '/uploads/staff/staff-1782492315-5cbfb8ae.png', '2026-06-26 22:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transaction`
--

CREATE TABLE `stock_transaction` (
  `transaction_id` int NOT NULL,
  `item_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `quantity` int NOT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_transaction`
--

INSERT INTO `stock_transaction` (`transaction_id`, `item_id`, `admin_id`, `transaction_type`, `quantity`, `transaction_date`, `remarks`) VALUES
(1, 1, 1, 'Stock In', 10, '2026-07-11 11:26:18', ''),
(2, 6, 1, 'Stock Out', 1, '2026-07-11 20:05:01', 'Auto generated from approved requisition #7 for Pencil.');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`, `contact_person`, `phone_no`, `email`, `address`) VALUES
(1, 'ABC Supply Sdn Bhd', 'Encik Amir', '0123456789', 'abc@gmail.com', 'Kuala Lumpur'),
(10, 'XYZ Office Supplies', 'Puan Sofia', '0127788990', 'sales@xyzoffice.test', 'Shah Alam'),
(11, 'PaperWorld Sdn Bhd', 'Mr Tan', '0138899001', 'orders@paperworld.test', 'Petaling Jaya'),
(12, 'TechPro Solutions', 'Daniel Lee', '0146677881', 'hello@techpro.test', 'Cyberjaya'),
(13, 'CleanPlus Sdn Bhd', 'Siti Hajar', '0119988776', 'support@cleanplus.test', 'Subang Jaya'),
(14, 'FurniHub Sdn Bhd', 'Farhan Rahman', '0192233445', 'sales@furnihub.test', 'Klang'),
(15, 'FileMaster Sdn Bhd', 'Nora Izzati', '0173322110', 'admin@filemaster.test', 'Kajang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `requisition`
--
ALTER TABLE `requisition`
  ADD PRIMARY KEY (`requisition_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `requisition_item`
--
ALTER TABLE `requisition_item`
  ADD PRIMARY KEY (`requisition_item_id`),
  ADD KEY `requisition_id` (`requisition_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `stock_transaction`
--
ALTER TABLE `stock_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `requisition`
--
ALTER TABLE `requisition`
  MODIFY `requisition_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `requisition_item`
--
ALTER TABLE `requisition_item`
  MODIFY `requisition_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_transaction`
--
ALTER TABLE `stock_transaction`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`);

--
-- Constraints for table `requisition`
--
ALTER TABLE `requisition`
  ADD CONSTRAINT `requisition_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `requisition_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `requisition_item`
--
ALTER TABLE `requisition_item`
  ADD CONSTRAINT `requisition_item_ibfk_1` FOREIGN KEY (`requisition_id`) REFERENCES `requisition` (`requisition_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requisition_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `stock_transaction`
--
ALTER TABLE `stock_transaction`
  ADD CONSTRAINT `stock_transaction_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `stock_transaction_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
