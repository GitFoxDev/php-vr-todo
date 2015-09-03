CREATE TABLE `variant_todo` (
  `id` int(3) NOT NULL auto_increment,
  `name` text,
  `date` text,
  `com` int(1),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
