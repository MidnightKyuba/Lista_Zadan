-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Cze 2023, 09:43
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `listazadan`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'grupa1', 'Jest to pierwsza grupa testowa.'),
(2, 'grupa2', 'Jest to druga grupa testowa.'),
(3, 'grupa3', 'Jest to trzecia grupa testowa.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL CHECK (0 <= `status` < 3),
  `endDate` date NOT NULL,
  `priorityLevel` int(11) NOT NULL CHECK (0 <= `priorityLevel` < 3),
  `userId` int(11) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `status`, `endDate`, `priorityLevel`, `userId`, `groupId`) VALUES
(1, 'Zadanie1', 'Opis pierwszego testowego zadania. edited', 2, '2023-06-15', 1, NULL, 2),
(2, 'Zadanie2', 'Opis drugiego zadania testowego.', 0, '2023-06-30', 0, 10, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `confirm_password`, `email`, `is_admin`) VALUES
(1, 'admin', 'admin123', 'admin123', 'admin@example.com', 1),
(4, 'Hubert2', '$2y$10$.oeeO6PuNDzbf/fJiB4LwO35Ri8XOzhDGE1c.KDtL2jn.aXRB0SEu', '', 'Hubert00@gmail.com', 0),
(5, 'Piotr', '$2y$10$pN/eZGmKwblExphoWP0B7uEiCZ71eLoONzbfn/lZ/Rpc8NLmU5qva', '', 'Pawelak@interia.pl', 0),
(6, 'Pawel', '$2y$10$4h50Y1jcazvcuCOKOLD1nedOiqGkSKKiqdCRSB4iXyXv/jYO.dvoa', '', 'Pawelak@interia.pl', 0),
(8, 'Dawid', '$2y$10$G/Mq8KdpbxPxSPMbgdIB6.z266nvwNfSpg93jLhHiLNfObkKikyim', '$2y$10$vn96g8SJG3Mpxg.sLU3XpuMSJobMHFd0c4xhNwTaewUli8XSlqM4q', 'Dawid00@gmail.com', 0),
(10, 'jakub', '$2y$10$BbklJ704TombiXh5ApyudOI88bN/hEWitNmZdbd2fKW2coKdQBJZ2', '', 'jakubkittel@example.com', 0),
(11, 'bukaj', '$2y$10$KCDXEZ1qnkk7y/Ct9GWueuSXXBBQkOfQdngm6sJcvnYloGAcPvfCS', '', 'bukaj@example.com', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `usersgroups`
--

CREATE TABLE `usersgroups` (
  `groupId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `usersgroups`
--

INSERT INTO `usersgroups` (`groupId`, `userId`) VALUES
(1, 10),
(2, 10),
(2, 11),
(3, 1),
(1, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
