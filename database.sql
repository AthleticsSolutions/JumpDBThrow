SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `startlist_id` int(11) NOT NULL,
  `result` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `startlist` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `category` varchar(3) NOT NULL,
  `pb` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_startlist_id` (`startlist_id`);

ALTER TABLE `startlist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `startlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;


ALTER TABLE `results`
  ADD CONSTRAINT `fk_startlist_id` FOREIGN KEY (`startlist_id`) REFERENCES `startlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;