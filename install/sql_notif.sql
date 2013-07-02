CREATE TABLE `habbophp_notifications` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `titre` varchar(70) NOT NULL,
  `contenu` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `date_posted` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;