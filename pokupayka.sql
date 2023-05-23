-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 23 2023 г., 19:32
-- Версия сервера: 8.0.29
-- Версия PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pokupayka`
--

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `ID_order` bigint NOT NULL,
  `Address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` varchar(32) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `User_ID` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`ID_order`, `Address`, `status`, `created_at`, `User_ID`) VALUES
(6, 'Город Москва, улица Липовая, дом 3, подъезд 2, квартира 22', 'В рассмотрении', '2023-05-08 05:17:43', 1),
(12, 'Город Москва, улица Липовая, дом 3, подъезд 2, квартира 21', 'В изготовление', '2023-05-12 21:57:52', 3),
(13, 'Город Москва, улица Каскадная, дом 28, подъезд 1, квартира 3', 'Отменён', '2023-05-12 22:01:28', 3),
(14, 'Город Москва, улица Липа, дом 28, подъезд 3, квартира 28', 'В рассмотрении', '2023-05-12 22:04:19', 3),
(15, 'Город Москва, улица Обручева, дом 19 к 2, подъезд 1, квартира 28', 'Передан в доставку', '2023-05-13 19:38:43', 8),
(16, 'Город Москва, улица ajsndnsa, дом asnduas, подъезд sunda, квартира ausabd', 'В рассмотрении', '2023-05-19 10:27:59', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `ID_Order_Item` bigint NOT NULL,
  `Order_ID` bigint NOT NULL,
  `Product_ID` bigint NOT NULL,
  `Quantity` int NOT NULL,
  `Price` decimal(20,2) DEFAULT NULL
) ;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`ID_Order_Item`, `Order_ID`, `Product_ID`, `Quantity`, `Price`) VALUES
(1, 6, 71, 2, '20000.00'),
(2, 6, 80, 3, '10.00'),
(7, 12, 68, 1, '500.00'),
(8, 12, 70, 1, '10000.00'),
(9, 12, 71, 1, '20000.00'),
(10, 13, 68, 3, '500.00'),
(11, 14, 71, 1, '20000.00'),
(12, 15, 80, 1, '10.00'),
(13, 16, 71, 1, '20000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` bigint NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Отсуствует',
  `price` float NOT NULL
) ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`) VALUES
(67, 'Стул', 'Элегантный стул, который отлично подойдет для вашего дома или офиса. Изготовлен из прочного дерева и обтянут качественной обивкой из мягкого материала, он предлагает удобное сиденье с поддержкой спины. Его стильный дизайн и нейтральный цвет позволяют легко сочетать его с любым интерьером. Стул имеет прочные ножки, обеспечивающие стабильность и долговечность. Это идеальный выбор для обеденного стола, рабочего пространства или гостиной.', 2000),
(68, 'Подушка', 'Предлагаем вам мягкую и уютную подушку, которая превратит вашу кровать или диван в идеальное место для расслабления. Наполнена высококачественным пухом, эта подушка обеспечивает идеальную поддержку для вашей головы и шеи, помогая вам получить комфортный сон или отдых. Обложка изготовлена из мягкого и прочного материала, который легко снимается и стирается для удобства использования.', 500),
(69, 'Сушка для вещей', 'Идеальное решение для сушки вашей одежды после стирки - сушка для вещей. Это компактное и функциональное приспособление, которое поможет сушить вашу одежду быстро и эффективно. Сушка оснащена прочной рамой и несколькими штангами, на которые вы можете повесить ваши вещи. Благодаря складному дизайну, она легко хранится, когда ее не используют. Сушка для вещей идеально подходит для квартир с ограниченным пространством или для тех, кто хочет сэкономить время и энергию, избегая использования сушилки.', 5500),
(70, 'Посуда', 'Для тех, кто ценит качество и стиль в кухне, у нас есть широкий выбор посуды. Наша коллекция включает в себя высококачественные тар', 10000),
(71, 'Стол', 'Продаю прекрасный стол, который идеально подойдет для вашей гостиной, столовой или кабинета. Он выполнен из качественного дерева и имеет устойчивую конструкцию, что обеспечивает долговечность и надежность. Стол имеет простой, но элегантный дизайн, который легко впишется в любой интерьер. ', 20000),
(72, 'Bug', 'Busanfunafnasuasnduasudn', 10),
(73, 'Bug2', 'Busanfunafnasuasnduasudn', 10),
(74, 'Bug3', 'Busanfunafnasuasnduasudn', 10),
(75, 'Bug4', 'Busanfunafnasuasnduasudn', 10),
(76, 'Bug6', 'Busanfunafnasuasnduasudn', 10),
(77, 'Bug301', 'asdkmasidmasmdmiasmdmaismdim', 10),
(78, 'Bug302', 'asdkmasidmasmdmiasmdmaismdim', 10),
(79, 'Bug303', 'asdkmasidmasmdmiasmdmaismdim', 10),
(80, 'Bug304', 'texttexttexttexttexttexttext', 10),
(81, 'Item1234', 'ОченьОченьОченьОченьОченьОченьОченьОченьОченьОчень', 20000);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `ID_user` bigint NOT NULL,
  `First_Name` varchar(35) NOT NULL,
  `Second_Name` varchar(35) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(64) NOT NULL
) ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`ID_user`, `First_Name`, `Second_Name`, `Email`, `Password`) VALUES
(1, 'Василий', 'Помидоркин', 'isip_mpt@gmail.com', 'Password123'),
(2, 'asd', 'asd', 'a@a.ru', '688787d8ff144c502c7f5cffaafe2cc588d86079f9de88304c26b0cb99ce91c6'),
(3, 'Завьялов', 'Михаил', 'b@b.ru', '008c70392e3abfbd0fa47bbc2ed96aa99bd49e159727fcba0f2e6abeb3a9d601'),
(4, 'Password123', 'asd', 'misha@g.ru', '008c70392e3abfbd0fa47bbc2ed96aa99bd49e159727fcba0f2e6abeb3a9d601'),
(6, 'somebody', 'somebody', 'b@c.ru', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(7, 'asd', 'asdf1328', 'asd3@gmail.com', 'ec70738ba57e398813db972bdabe2945cdb483d7647bda5976f5c36294a158f2'),
(8, 'Завьялов', 'Александр', 'lilalexk4@gmail.com', '21d8076695cc7f51a307e7441b078edb3a9daf0c437622ef04ef75a99f2ec158'),
(9, 'aisnfinasf', 'inasiasnd', 'gmail@gmail.com', '008c70392e3abfbd0fa47bbc2ed96aa99bd49e159727fcba0f2e6abeb3a9d601');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID_order`),
  ADD KEY `FK_User` (`User_ID`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`ID_Order_Item`),
  ADD KEY `FK_Order` (`Order_ID`),
  ADD KEY `FK_Product` (`Product_ID`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_Name` (`name`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_user`),
  ADD UNIQUE KEY `UQ_Email` (`Email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `ID_order` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `ID_Order_Item` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `ID_user` bigint NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_User` FOREIGN KEY (`User_ID`) REFERENCES `user` (`ID_user`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `FK_Order` FOREIGN KEY (`Order_ID`) REFERENCES `order` (`ID_order`),
  ADD CONSTRAINT `FK_Product` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
