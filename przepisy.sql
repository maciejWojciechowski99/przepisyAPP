-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 18, 2024 at 09:57 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `przepisy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przepisy_dodane`
--

CREATE TABLE `przepisy_dodane` (
  `id` int(11) NOT NULL,
  `tytul` varchar(32) NOT NULL,
  `opis` varchar(1024) NOT NULL,
  `przepis_uzytkownika` varchar(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ulubione_przepisy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `przepisy_dodane`
--

INSERT INTO `przepisy_dodane` (`id`, `tytul`, `opis`, `przepis_uzytkownika`, `user_id`, `ulubione_przepisy`) VALUES
(87, 'Lorem ipsum', 'Składniki: dolor sit, amet, consectetur adipiscing elit, Suspendisse viverra, felis imperdie, auctor varius.\r\nOpis:\r\n- Ut sit amet laoreet eros, sit amet dictum libero. \r\n- Vestibulum at est ex. Etiam fermentum quam ut volutpat lobortis. \r\n- Cras varius purus vel luctus vestibulum. Quisque nulla libero, accumsan eu dapibus vitae, \r\n- venenatis consequat ante. Sed consectetur arcu eget molestie tempus. Integer mollis tortor non auctor dignissim. \r\n\r\nPhasellus convallis nunc quis nunc consequat consequat. Mor', 'b', 0, 0),
(88, 'Aliquam porttitor', 'posuere nunc ut iaculis. Nunc finibus diam sapien, et aliquam quam blandit a. Nunc consectetur, lectus a fermentum ullamcorper, quam nulla tincidunt nibh, ut egestas tortor sapien sed nisl. Vivamus imperdiet, odio vitae maximus egestas, nibh ex efficitur turpis, vel volutpat justo metus ac quam. Donec finibus viverra dui id tincidunt. Aenean maximus ut elit eu tempor. In maximus risus eget ante volutpat, id gravida est ullamcorper. \r\n\r\n1. Proin ornare, diam et tempor semper, \r\n2. Nisl neque porta elit', 'b', 0, 0),
(89, 'Nulla interdum', 'Składniki: sed neque, 11,5 eget ultricies, Aliquam eu, tellus, imperdiet\r\nOpis:\r\nUt tortor ante, pretium id mattis non, dapibus sit amet arcu. Sed vitae ex dignissim, aliquet erat sed, congue elit. Pellentesque blandit vel leo ac pellentesque. Cras rutrum varius metus. Quisque sollicitudin molestie eros, porttitor facilisis turpis sollicitudin vitae. Aliquam felis justo, ultricies dapibus ultrices vitae, vestibulum vel sem. Nulla faucibus, odio nec tincidunt vestibulum, turpis sapien convallis diam, vitae a', 'b', 0, 0),
(90, 'Aliquam volutpat lacus', 'non varius consequat. Vestibulum porttitor ac nisl eget pretium. Nulla dignissim bibendum gravida. Suspendisse eu nunc a libero ultrices fermentum vitae id tortor. Morbi lacinia mauris consequat imperdiet facilisis. Aliquam lacinia libero efficitur, tincidunt dui in, consectetur velit. Suspendisse libero sapien, tristique nec diam consequat, tempus dapibus lorem. Maecenas eget imperdiet elit, in viverra dui. Proin cursus viverra turpis. Donec semper ut sem ac suscipit. Curabitur pharetra porta metus. Maecen', 'b', 0, 0),
(91, 'Suspendisse egestas ex at fringi', 'Nulla condimentum venenatis magna, at rhoncus velit rhoncus a. Praesent eget maximus libero. Donec lacus dolor, semper a cursus vel, hendrerit nec lacus. Duis neque urna, viverra nec erat sit amet, pharetra porta diam. Mauris feugiat, mi sit amet tempus consequat, neque quam consequat leo, et pharetra metus ex a justo. Duis at enim pretium, volutpat elit ac, molestie mauris. Cras elit massa, maximus id tincidunt quis, dignissim finibus orci. Phasellus porttitor lacinia tortor sed posuere. Pellentesque et ac', 'b', 0, 0),
(94, 'Spaghetti Bolognese', '1.Rozgrzej oliwę w garnku, dodaj posiekaną cebulę i czosnek. Smaż na złocisty kolor.\r\n2. Dodaj mielone mięso (wołowe i wieprzowe), podsmaż do momentu zrumienienia.\r\n3. Wlej czerwone wino i gotuj przez kilka minut, aby alkohol się ulotnił.\r\n4. Dodaj przecier pomidorowy, koncentrat pomidorowy, zioła (bazylia, oregano), sól i pieprz. Gotuj na małym ogniu.\r\n5. Odstaw odrobinę sosu na bok i dodaj resztę do sosu. Gotuj na wolnym ogniu przez co najmniej 30 minut.\r\n6. Ugotuj spaghetti zgodnie z instrukcjami na opakowaniu.\r\n7. Wsyp starty parmezan do odstawionego sosu i wymieszaj.\r\n8. Odcedź spaghetti, podawaj z sosem i posyp parmezanem. Smacznego!', 'b', 0, 0),
(95, 'Pad Thai', 'Składniki: Płatki ryżowe, olej, czosnek, krewetki, tofu, jajko, pasta tamarindowa, sos rybny, sos sojowy, cukier, kiełki fasoli, cebula, orzeszki ziemne, kolendra, limonka.\r\nOpis:\r\n1.Gotuj płatki ryżowe zgodnie z instrukcjami.\r\n2.Na patelni rozgrzej olej, dodaj posiekany czosnek i krewetki.\r\n3. Wrzuć tofu, jajko i mieszaj.\r\n4. Dodaj ugotowane płatki ryżowe.\r\n5. Wlej sos: pasta tamarindowa, sos rybny, sos sojowy, cukier.\r\n6. Wrzuć kiełki fasoli i cebulę.\r\n7. Posyp orzeszkami ziemnymi i kolendrą.\r\n8. Podawaj z limonką. Smacznego!', 'b', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `haslo` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`) VALUES
(0, 'a', 'a', 'a@a.pl'),
(0, 'nowy', 'Maciej123456', 'maciej@a.a'),
(0, 'b', 'b', 'b@b.b'),
(0, 'test', 'testtest!', 'testowy@mail.pl'),
(0, 'nowytestowy', '123456789', 'a@afg.aa');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `przepisy_dodane`
--
ALTER TABLE `przepisy_dodane`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `przepisy_dodane`
--
ALTER TABLE `przepisy_dodane`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
