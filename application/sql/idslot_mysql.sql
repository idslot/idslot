SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `idslot`
--

-- --------------------------------------------------------

--
-- Table structure for table `biography`
--

CREATE TABLE IF NOT EXISTS `biography` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_persian_ci NOT NULL,
  `tel` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `mob` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `weblog` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `map` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `use_form` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `resume_id` int(11) NOT NULL,
  `summary` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `description` text COLLATE utf8_persian_ci,
  `type` enum('experience','education') COLLATE utf8_persian_ci DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_resumes1` (`resume_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events_categories`
--

CREATE TABLE IF NOT EXISTS `events_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Dumping data for table `events_categories`
--

INSERT INTO `events_categories` (`id`, `title`, `pid`) VALUES
(1, 'Agriculture', 0),
(2, 'Agricultural Crops', 1),
(3, 'Agricultural Services', 1),
(4, 'Animals', 1),
(5, 'Biotechnology', 1),
(6, 'Farm Equipment', 1),
(7, 'Farms', 1),
(8, 'Forestry & Logging', 1),
(9, 'Forestry & Lumbering', 1),
(10, 'Forestry Services', 1),
(11, 'Hunting Trapping & Game Propagation', 1),
(12, 'Landscaping', 1),
(13, 'Lawn & Garden Services', 1),
(14, 'Livestock', 1),
(15, 'Marketing', 1),
(16, 'Miscellaneous Agriculture', 1),
(17, 'Ornamental Nursery', 1),
(18, 'Business Services', 0),
(19, 'Advertising, Marketing & PR Services', 18),
(20, 'Business & Professional Associations', 18),
(21, 'Business Legal Services', 18),
(22, 'Business Networking', 18),
(23, 'Charitable & Non-Profit Organizations', 18),
(24, 'Communications Services', 18),
(25, 'Computer & Audio Visual Services', 18),
(26, 'Computer Data Base Service', 18),
(27, 'Computer Graphics', 18),
(28, 'Computer Networks', 18),
(29, 'Computer Services', 18),
(30, 'Computer System Design', 18),
(31, 'Consultants & Services', 18),
(32, 'Copying & Duplicating Services', 18),
(33, 'Decorating & Designing Services', 18),
(34, 'Engineer & Architect Services', 18),
(35, 'General Business Services', 18),
(36, 'Graphic Designer & Artist Services', 18),
(37, 'Internet Services', 18),
(38, 'Investigative Services', 18),
(39, 'Management Consultants & Services', 18),
(40, 'Misc Business Services', 18),
(41, 'Packaging, Shipping & Labeling Services', 18),
(42, 'Printing & Publishing Services', 18),
(43, 'Rental & Leasing Business Equipment', 18),
(44, 'Repair Services', 18),
(45, 'Research Services', 18),
(46, 'Security Services', 18),
(47, 'Small Business Services', 18),
(48, 'Staffing & Support Services', 18),
(49, 'Writing Services', 18),
(50, 'Community Services', 0),
(51, 'Arts & Culture', 50),
(52, 'Community & Recreational Facilities', 50),
(53, 'Foundations, Clubs, Associations, Etc.', 50),
(54, 'Mentoring', 50),
(55, 'Political & Ideological Organizations', 50),
(56, 'Religious Organizations', 50),
(57, 'Links Services & Welfare', 50),
(58, 'Utilities', 50),
(59, 'Construction', 0),
(60, 'Builders & Contractors 1 Of 2', 59),
(61, 'Builders & Contractors 2 Of 2', 59),
(62, 'Building Supplies & Materials', 59),
(63, 'Construction Services', 59),
(64, 'Education', 0),
(65, 'Additional Educational Opportunities', 64),
(66, 'Administrative Organizations', 64),
(67, 'Administrative Professionals', 64),
(68, 'Colleges & Universities', 64),
(69, 'Education Services', 64),
(70, 'Educational Aids & Electronic Training Materials', 64),
(71, 'Educational Facilities', 64),
(72, 'Elementary Schools', 64),
(73, 'Preschools', 64),
(74, 'Religious Education', 64),
(75, 'Secondary Schools', 64),
(76, 'Finance', 0),
(77, 'Accounting, Auditing & Bookkeeping Services', 76),
(78, 'Financial Institutions', 76),
(79, 'Financial Services', 76),
(80, 'Insurance Carriers', 76),
(81, 'Insurance Services', 76),
(82, 'Investment Services & Advisors', 76),
(83, 'Government', 0),
(84, 'City & County Government', 83),
(85, 'Federal Government', 83),
(86, 'Foreign Government', 83),
(87, 'Misc Government', 83),
(88, 'National Government', 83),
(89, 'Political Organizations', 83),
(90, 'State Government', 83),
(91, 'Tribal Government', 83),
(92, 'Health & Medical', 0),
(93, 'Health And Medical Centers', 92),
(94, 'Health Care Information & Services', 92),
(95, 'Healthcare Consultants', 92),
(96, 'Healthcare Professionals', 92),
(97, 'Medical Equipment & Supplies', 92),
(98, 'Industry', 0),
(99, 'Aerospace Industry', 98),
(100, 'Aviation & Aerospace Equipment & Supplies', 98),
(101, 'Business Wholesale', 98),
(102, 'Electrical Goods', 98),
(103, 'Environmental Products', 98),
(104, 'Exporters', 98),
(105, 'Farm Products Raw Materials', 98),
(106, 'Fuel', 98),
(107, 'Hauling And Shipping', 98),
(108, 'Health & Safety Industrial', 98),
(109, 'Importers', 98),
(110, 'Industrial Contractors', 98),
(111, 'Industrial Goods & Products - Hard Goods - Large', 98),
(112, 'Industrial Goods & Products - Hard Goods - Small', 98),
(113, 'Industrial Goods & Products - Soft - Large & Small', 98),
(114, 'Industrial Machinery & Equipment', 98),
(115, 'Industrial Machinery Equipment & Supplies Rental & Leasing', 98),
(116, 'Machinery, Equipment & Supplies - Business Production Related', 98),
(117, 'Machinery, Equipment & Supplies - Business Supplies Related', 98),
(118, 'Machinery, Equipment & Supplies - Construction/Contractor Related', 98),
(119, 'Marine Products And Services', 98),
(120, 'Metal Products', 98),
(121, 'Mining', 98),
(122, 'Miscellaneous Industry', 98),
(123, 'Refuse Systems', 98),
(124, 'Scientific Equipment & Services', 98),
(125, 'Scrap & Waste Materials', 98),
(126, 'Storage And Warehousing', 98),
(127, 'Transportation Equipment', 98),
(128, 'Manufacturing', 0),
(129, 'Apparel Manufacturers', 128),
(130, 'Audio & Visual Equipment Manufacturers', 128),
(131, 'Bottling Manufacturing', 128),
(132, 'Building & Homes Manufactures', 128),
(133, 'Building Hardware & Materials', 128),
(134, 'Chemical Product Manufacturers', 128),
(135, 'Computer Manufacturers', 128),
(136, 'Electronics Manufacturers', 128),
(137, 'Finished Textiles Manufacturers', 128),
(138, 'Fitness & Beauty', 128),
(139, 'Food Product Manufacturers', 128),
(140, 'Furniture Manufacturers', 128),
(141, 'Instrument Manufacturers', 128),
(142, 'Lawn & Yard', 128),
(143, 'Leather Goods', 128),
(144, 'Machinery And Equipment Manufacturers', 128),
(145, 'Manufacturing Products', 128),
(146, 'Medical Equipment Manufacturers', 128),
(147, 'Miscellaneous Manufacturing', 128),
(148, 'Musical Instrument Manufacturers', 128),
(149, 'Oil And Petroleum Products', 128),
(150, 'Paper & Cardboard Manufacturers', 128),
(151, 'Plastic Products Manufacturers', 128),
(152, 'Publishing & Printing Manufacturers', 128),
(153, 'Recreational Good Manufacturers', 128),
(154, 'Rubber Products - Manufacturers', 128),
(155, 'Sporting Goods Manufacturers', 128),
(156, 'Stone And Glass Products', 128),
(157, 'Tobacco Products', 128),
(158, 'Transportation Equipment Manufacturers', 128),
(159, 'Waste Treatment Plants Manufacturers', 128),
(160, 'Wood Products Manufacturers', 128),
(161, 'Motorized Vehicle', 0),
(162, 'All-Terrain & Recreational Vehicle Dealers', 161),
(163, 'Auto Maintenance & Repair Services', 161),
(164, 'Auto Services', 161),
(165, 'Automotive Parts, Equipment & Supplies', 161),
(166, 'Aviation & Avionics Sales', 161),
(167, 'Heavy & Industrial Vehicle Dealers', 161),
(168, 'Heavy & Industrial Vehicle Parts & Accessories', 161),
(169, 'Motorized Vehicle Rental & Leasing', 161),
(170, 'Passenger Vehicle Dealers', 161),
(171, 'Personal Watercraft Dealers', 161),
(172, 'Work, Utility & Commercial Vehicle Dealers', 161),
(173, 'Personal Services', 0),
(174, 'Art', 173),
(175, 'Cleaning & Maintenance Services', 173),
(176, 'Employment Assistance', 173),
(177, 'Entertainment Services', 173),
(178, 'Family Services & Care', 173),
(179, 'Fitness', 173),
(180, 'Garment & Linen Services', 173),
(181, 'Household Services', 173),
(182, 'Misc Personal Services', 173),
(183, 'Party & Event Planning', 173),
(184, 'Personal Care', 173),
(185, 'Personal Document & Information Services', 173),
(186, 'Personal Financial Services', 173),
(187, 'Personal Legal Services', 173),
(188, 'Professional', 0),
(189, 'Law Enforcement Professional', 188),
(190, 'Legal Professionals', 188),
(191, 'Miscellaneous Professional', 188),
(192, 'Photography', 188),
(193, 'Professionals Equipment & Supplies', 188),
(194, 'Public Administration', 188),
(195, 'Religious Practitioners', 188),
(196, 'Science & Research', 188),
(197, 'Video, Television And Movies', 188),
(198, 'Real Estate', 0),
(199, 'Commercial & Industrial', 198),
(200, 'Real Estate Services', 198),
(201, 'Residential', 198),
(202, 'Restaurants/Food & Dining', 0),
(203, 'African Restaurants', 202),
(204, 'Asian Restaurants', 202),
(205, 'Bakeries', 202),
(206, 'Breakfast Restaurants', 202),
(207, 'Casual Dining Restaurants', 202),
(208, 'Central American Restaurants', 202),
(209, 'Drinking Establishments', 202),
(210, 'Ethnic Restaurants', 202),
(211, 'European Cuisine', 202),
(212, 'Fine Dining Restaurants', 202),
(213, 'Fish & Seafood Restaurants', 202),
(214, 'Food Services', 202),
(215, 'Middle Eastern Restaurants', 202),
(216, 'North American Restaurants', 202),
(217, 'Restaurant Information & Referral Service', 202),
(218, 'Snacks & Desserts', 202),
(219, 'South American Restaurants', 202),
(220, 'Theme & Entertainment Restaurants', 202),
(221, 'Shopping & Shopping Services', 0),
(222, 'Air Conditioning & Heating Equipment & Supplies', 221),
(223, 'Air Purification Systems', 221),
(224, 'Appliances Household & Commercial', 221),
(225, 'Arts & Crafts', 221),
(226, 'Building Restoration Equipment', 221),
(227, 'Cards Stationery & Giftwrap', 221),
(228, 'Catalog, Mail-Order, & Electronic Shopping', 221),
(229, 'Chemicals & Related Products', 221),
(230, 'Commercial Equipment', 221),
(231, 'Computers Electronics', 221),
(232, 'Direct Selling Businesses', 221),
(233, 'Drains, Pipes & Sewage Materials', 221),
(234, 'Durable & Non Durable Goods & Products', 221),
(235, 'Electric Equipment & Supplies', 221),
(236, 'Electronics', 221),
(237, 'Entertainment & Recreation', 221),
(238, 'Fencing & Gate Materials', 221),
(239, 'Flooring Materials', 221),
(240, 'Flowers & Plants', 221),
(241, 'Food & Beverage Stores & Services', 221),
(242, 'Food & Beverages Wholesale & Retail', 221),
(243, 'Fuel Dealers', 221),
(244, 'Games & Hobbies', 221),
(245, 'Garage, Door & Window Products', 221),
(246, 'General Merchandise Stores', 221),
(247, 'Glass & Glass Products', 221),
(248, 'Hardware Stores', 221),
(249, 'Home Improvement Centers', 221),
(250, 'Insulation & Energy Conservation Materials', 221),
(251, 'Kitchen & Bath Products & Supplies', 221),
(252, 'Lacquers Stains & Wood Finishes', 221),
(253, 'Lumber & Lumber Products', 221),
(254, 'Masonry Materials & Supplies', 221),
(255, 'Merchandise Sales Events', 221),
(256, 'Moldings Materials', 221),
(257, 'Music', 221),
(258, 'Nurseries & Garden Centers', 221),
(259, 'Other Building Materials', 221),
(260, 'Outdoor Equipment & Accessories', 221),
(261, 'Paint & Painting Supplies', 221),
(262, 'Paneling Materials', 221),
(263, 'Paper & Paper Products', 221),
(264, 'Pets', 221),
(265, 'Plastering Stucco Caulking & Grouting Materials', 221),
(266, 'Prefabricated Buildings', 221),
(267, 'Product Rental & Leasing', 221),
(268, 'Product Repair Services', 221),
(269, 'Roofing Materials', 221),
(270, 'Siding Materials', 221),
(271, 'Solar Products & Services', 221),
(272, 'Specialty Stores', 221),
(273, 'Steel Products', 221),
(274, 'Telecommunications', 221),
(275, 'Wallpaper & Wallcoverings', 221),
(276, 'Transportation', 0),
(277, 'Air Transportation, Except Passenger', 276),
(278, 'Ground Transportation, Except Passenger', 276),
(279, 'Passenger Air Transportation', 276),
(280, 'Passenger Ground Transportation', 276),
(281, 'Passenger Water Transportation', 276),
(282, 'Transportation Equipment And Supplies (Except Motor Vehicle)', 276),
(283, 'Transportation Facilities & Services', 276),
(284, 'Transportation Inspection Services', 276),
(285, 'Transportation Rental & Leasing', 276),
(286, 'Transportation Repair & Maintenance', 276),
(287, 'Water Transportation, Except Passenger', 276),
(288, 'Travel & Tourism', 0),
(289, 'Historical Places & Services', 288),
(290, 'Lodging', 288),
(291, 'Recreational Services', 288),
(292, 'Tourist Attractions', 288),
(293, 'Travel Arrangement & Services', 288),
(294, 'Unknown', 0),
(295, 'Unknown', 294);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_list`
--

CREATE TABLE IF NOT EXISTS `portfolio_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) NOT NULL,
  `title` varchar(2000) COLLATE utf8_persian_ci DEFAULT NULL,
  `creators` varchar(2000) COLLATE utf8_persian_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `urn` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `urn_type` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'List of URNs:http://www.iana.org/assignments/urn-namespaces/urn-namespaces.xml',
  `publisher` varchar(45) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_publications_resumes1` (`resume_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE IF NOT EXISTS `resume` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `summary` text COLLATE utf8_persian_ci,
  PRIMARY KEY (`id`),
  KEY `fk_resumes_users1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resume_has_skill`
--

CREATE TABLE IF NOT EXISTS `resume_has_skill` (
  `resume_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  PRIMARY KEY (`resume_id`,`skill_id`),
  KEY `fk_resumes_has_skills_skills1` (`skill_id`),
  KEY `fk_resumes_has_skills_resumes1` (`resume_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE IF NOT EXISTS `social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE IF NOT EXISTS `social_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_new` enum('false','true') COLLATE utf8_bin NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(160) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update` datetime NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `short_description` varchar(1000) COLLATE utf8_bin NOT NULL,
  `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `language` char(255) COLLATE utf8_bin NOT NULL DEFAULT 'english',
  PRIMARY KEY (`id`),
  KEY `is_new` (`is_new`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `resume`
--
ALTER TABLE `resume`
  ADD CONSTRAINT `fk_resumes_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

