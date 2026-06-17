CREATE DATABASE IF NOT EXISTS `barbershop`;
USE `barbershop`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` text NOT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `password` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

INSERT INTO `user` (`id`, `name`, `email`, `tel`, `password`, `type`) VALUES
(null, 'adm', 'teste@gmail.com', '1313', '$2y$10$/BUNPbo/Pp9JSV.cdwznt.LS3Tvs.tyRldXnN2KWj6iH9a895Ds0y', 2);

INSERT INTO `user` (`id`, `name`, `email`, `tel`, `password`, `type`) VALUES
(null, 'Felipe', 'felipe@gmail.com', '(61)98418-9541', '$2y$10$mqFdPSO8g54OClFuBwHiuuAaFQqAbb/q3lLBvFq6NATjEwGR9ajhu', 1);

INSERT INTO `user` (`id`, `name`, `email`, `tel`, `password`, `type`) VALUES
(null, 'Samuel', 'samuel@gmail.com', '(61)98150-4265', '$2y$10$ixPxvDWzXqmlEJHWgeZ2q.fzVilldf2Yhij/uTPZEMv.0kHxZyf0C', 1);

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `service` (`id`, `name`, `price`) VALUES
(1, 'Acabamento', 10.00),
(2, 'Cabelo', 30.00),
(3, 'Barba', 50.00),
(4, 'Cabelo e barba', 80.00);

CREATE TABLE IF NOT EXISTS `contact_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `tel` varchar(45) NOT NULL,
  `whatsapp` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Nova tabela "barber"
CREATE TABLE IF NOT EXISTS `barber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `barber` (`id`, `name`) VALUES
(1, 'Marinho'),
(2, 'Wesley'),
(3, 'André');


CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `tel` varchar(45) NOT NULL,
  `email` text NOT NULL,
  `service_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `message` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `barber_id` int(11) NOT NULL, -- Novo campo para o barbeiro
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_schedule_service_id` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_schedule_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_schedule_barber_id` FOREIGN KEY (`barber_id`) REFERENCES `barber` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `unavailable_datetime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
);
