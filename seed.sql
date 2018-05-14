CREATE TABLE IF NOT EXISTS `products` (
  `id` int(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `rate` float NOT NULL DEFAULT '0',
  `rates_count` int NOT NULL DEFAULT '0',
  `picture` varchar(255)
);

INSERT INTO `products` (`id`, `name`, `price`, `rate`, `rates_count`, `picture`) VALUES
(1, 'Apple', 0.3, 0, 0, 'images/apple.jpg'),
(2, 'Beer', 2, 0, 0, 'images/beer.jpg'),
(3, 'Chese', 3.74, 0, 0, 'images/chese.jpg'),
(4, 'Water', 1, 0, 0, 'images/water.jpg');