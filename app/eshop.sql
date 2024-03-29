CREATE DATABASE `eshop`;

USE `eshop`;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text,
  `stock` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(8,2) unsigned NOT NULL,
  `image_url` varchar(3000) NOT NULL DEFAULT 'img/imageNotFound.jpg',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
);

INSERT INTO `products` (`id`, `title`, `description`, `stock`, `price`, `image_url`) VALUES
(1, 'Apple iPhone 5S', NULL, 10, 5499.00, 'http://cf4.souqcdn.com/item/2013/10/22/57/54/74/2/item_M_5754742_3518911.jpg'),
(2, 'Apple iPad Air', NULL, 7, 5151.00, 'http://cf3.souqcdn.com/item/2013/10/23/62/76/31/2/item_M_6276312_3528682.jpg'),
(3, 'Apple Macbook Air', NULL, 12, 10000.00, 'http://cf2.souqcdn.com/item/40/81/27/9/item_M_4081279_942036.jpg'),
(4, 'Apple MacBook Pro With Retina Display', NULL, 3, 23899.00, 'http://cf3.souqcdn.com/item/2013/11/13/63/28/21/4/item_M_6328214_3621445.jpg'),
(5, 'Apple iPhone Bluetooth', NULL, 25, 138.00, 'http://cf2.souqcdn.com/item/2014/01/14/65/08/41/9/item_M_6508419_3983072.jpg'),
(6, '85W Adapter Power Charger for Apple MacBook Pro', NULL, 9, 450.00, 'http://cf3.souqcdn.com/item/2014/05/17/69/44/28/2/item_M_6944282_4718816.jpg'),
(7, 'Apple Magic Mouse', NULL, 1, 699.00, 'http://cf3.souqcdn.com/item/65/82/36/item_M_658236_556136.jpg'),
(8, 'Apple Earpods With Remote And Mic', NULL, 0, 44.74, 'http://cf3.souqcdn.com/item/2013/08/28/56/75/40/3/item_M_5675403_2783321.jpg');

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  KEY `product` (`product_id`),
  KEY `user_product` (`user_id`,`product_id`)
);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(3000) NOT NULL DEFAULT 'img/profile.png',
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `email_password` (`email`,`password`),
  KEY `username_password` (`password`)
);

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `avatar`, `password`) VALUES
(1, 'Linux', 'Inside', 'linux@eshop.com', 'http://images.my-addr.com/img/exam_gif_to_png.gif', '5f4dcc3b5aa765d61d8327deb882cf99'),
(2, 'Apple', 'Mac', 'mac@eshop.com', 'http://www.dribin.org/dave/blog/images/appleboot.png', '5f4dcc3b5aa765d61d8327deb882cf99'),
(3, 'Mr. No', 'One', 'no_one@eshop.com', 'img/profile.png', '5f4dcc3b5aa765d61d8327deb882cf99');

ALTER TABLE `transactions`
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
