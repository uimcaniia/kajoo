-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 28 juil. 2019 à 18:21
-- Version du serveur :  10.1.39-MariaDB
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `kajoo`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `rang` int(5) NOT NULL COMMENT 'rang de la catégorie pour l''affichage',
  `title` varchar(255) NOT NULL COMMENT 'libellé de la catégory',
  `id_user` int(5) NOT NULL COMMENT 'id user a qui appartient la catégorie',
  `default_category` int(11) NOT NULL DEFAULT '0' COMMENT 'category par défaut : 1 sinon 0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `rang`, `title`, `id_user`, `default_category`) VALUES
(2, 2, 'Plats', 3, 1),
(3, 3, 'Dessert', 3, 1),
(27, 1, 'Entrées', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etape`
--

CREATE TABLE `etape` (
  `id_etape` int(5) NOT NULL,
  `rang` int(5) NOT NULL COMMENT 'rang de l''étape dans la rectte',
  `text` text NOT NULL COMMENT 'texte de l''étape de la recette',
  `img` varchar(255) NOT NULL COMMENT 'lien de l''image de l''étape',
  `time` time NOT NULL COMMENT 'temps de l''étape',
  `id_recette` int(11) NOT NULL COMMENT 'id de la reccet correspondante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etape`
--

INSERT INTO `etape` (`id_etape`, `rang`, `text`, `img`, `time`, `id_recette`) VALUES
(889, 1, 'Battre les blancs d\'oeuf en neige ferme. Ajouter le sucre par petites quantités tout en continuant de battre. ', '', '00:10:01', 3),
(890, 2, 'Cuire entre 30 minutes et 1 heure à 120°C. Au bout de 30 minutes, on obtient des meringues blanches et moelleuses. Au bout d\'1 heure, on obtient des meringues rosées, craquantes et fondantes avec un coeur moelleux. ', '', '01:00:00', 3),
(891, 3, 'Une fois cuites, décoller les meringues délicatement dès la sortie du four et laisser refroidir sur une grille. ', '', '00:05:00', 3),
(922, 1, 'Cuisez les oeufs durs. ', '', '00:10:00', 38),
(923, 2, 'Lavez le persil et la salade. Prélever une dizaine de feuilles de salade, retirez les bouts durs. Hachez le persil finement. ', '', '00:05:00', 38),
(924, 3, 'Si vous avez choisi la macédoine, mélangez-la avec la mayonnaise et le vinaigre.', '', '00:05:00', 38),
(925, 4, 'Ecalez tous les oeufs et coupez-les à 1 cm du côté pointu. Coupez 6 cures dents en deux, ainsi que les cornichons en rondelles de 1,5 cm. ', '', '00:05:00', 38),
(926, 5, 'Dressez les assiettes individuellement, commencez par les feuilles de salade dans le fond. Au centre placez 2 cuillères à soupe du mélange que vous aurez choisi (macédoine, thon, jambon ou poulet), entourez de carotte et céleri. ', '', '00:05:00', 38),
(927, 6, 'Dans le centre, placez l’oeuf de poule côté rond dans le mélange, placez les cure-dents sur les côtés pour les bras. Transpercez délicatement l’oeuf de caille (pour faire la tête) et laissez le cure-dent dépasser de chaque côté puis plantez une rondelle de cornichon de façon à ce qu\'elle soit plantée à plat sur la tête et un câpre (c\'est son chapeau). ', '', '00:10:00', 38),
(928, 7, 'Plantez délicatement la tête sur le corps et placez une asperge contre le corps, comme un balai puis parsemez de persil. Terminez avec la garniture choisie, laissez faire votre imagination. ', '', '00:08:00', 38),
(929, 1, 'Couper les poires, puis les disposer dans un plat. ', '', '00:10:00', 7),
(930, 2, 'Cuire 35 min à thermostat 6/7 (200°C). ', '', '00:35:00', 7),
(931, 1, 'Fermez votre autocuiseur et compter 25 mn de cuisson une fois que celui-ci est monté en pression. ', '', '04:25:00', 27),
(932, 2, 'En attendant, lavez et coupez les courgettes en cubes et égouttez les pois chiches. ', '', '00:10:00', 27),
(933, 3, 'Une fois les 25 mn écoulées, évacuez la vapeur de votre autocuiseur, ouvrez et rajouter les courgettes et les pois chiches. Remettez au feu : comptez 10 mn de cuisson une fois votre autocuiseur sous pression.  ', '', '00:10:00', 27),
(934, 4, 'Faites cuire vos merguez sur un grill ou à la poêle, mais pas avec les légumes. Servez accompagné d\'une semoule fine. ', '', '00:20:00', 27),
(999, 1, 'Dans un saladier, versez 150 g de farine de blé et creusez-y une fontaine au centre. Ajoutez une pincée de sel et de poivre, la bière blonde et un jaune d’œuf. Mélangez à l’aide d’une cuillère en bois puis délayez peu à peu avec le lait et l’eau. Utilisez un fouet afin d\'éviter la formation de grumeaux et obtenir une pâte bien lisse et assez liquide. Couvrez la pâte à fish and chips d’un film alimentaire et laissez-la reposer pendant 30 min au réfrigérateur.', '', '00:05:00', 11),
(1000, 2, 'Pendant ce temps, battez les blancs d’œuf en neige ferme. Incorporez-les ensuite délicatement à la pâte, à l’aide d’une maryse (spatule souple). Soulevez bien la préparation pour ne pas casser les blancs en neige. Rincez les filets de cabillaud à l’eau claire puis séchez-les avec du papier absorbant. Versez les 25 g restants de farine de blé dans une assiette ou un plat creux. Retournez-y les filets de poisson afin de les couvrir uniformément de farine. Trempez-les ensuite dans la pâte en veillant bien à ce qu\'ils soient complétement recouverts.', '', '00:05:00', 11),
(1001, 3, 'Dans une grande poêle ou une friteuse, faites chauffer l’huile de friture à plus de 160°C. Plongez-y les filets de cabillaud panés pendant 5 minutes. Il faut qu’ils soient bien dorés. Déposez-les ensuite sur du papier absorbant afin d\'éliminer l\'excédent d\'huile.', '', '00:15:00', 11),
(1002, 4, 'Servez le poisson pané avec de bonnes frites maison. Pour cela, pelez et lavez les pommes de terre. Coupez-les en frites épaisses comme le veut la tradition et faites-les cuire à la friteuse jusqu’à ce qu’elles soient bien dorées.', '', '00:05:00', 11),
(1004, 1, 'Dans un saladier, ajoutez le sucre, les oeufs, la farine. Mélangez. ', '', '00:03:00', 35),
(1005, 2, 'Ajoutez le mélange chocolat/beurre. Mélangez bien. ', '', '00:02:00', 35),
(1006, 3, 'Beurrez et farinez votre moule puis y versez la pâte à gâteau. ', '', '00:00:00', 35),
(1007, 4, 'Faites cuire au four environ 20 minutes. ', '', '00:20:00', 35),
(1008, 1, 'Inciser les magrets côté peau en quadrillage sans couper la viande. ', '', '00:03:00', 1),
(1009, 2, 'Cuire les magrets à feu vif dans une cocotte en fonte, en commençant par le coté peau. Le temps de cuisson dépend du fait qu\'on aime la viande plus ou moins saignante. Compter environ 5 min de chaque côté. Retirer régulièrement la graisse en cours de cuisson. ', '', '00:05:00', 1),
(1010, 3, 'Réserver les magrets au chaud (au four, couverts par une feuille d\'aluminium). Déglacer la cocotte avec le miel et le vinaigre balsamique. Ne pas faire bouillir, la préparation tournerait au caramel. Bien poivrer. ', '', '00:03:00', 1),
(1011, 4, 'Mettre en saucière accompagnant le magret coupé en tranches. Comme accompagnement, je suggère des petits navets glacés (cuits à l\'eau puis passés au beurre avec un peu de sucre). ', '', '00:10:00', 1),
(1012, 1, 'Dans une cocotte, faire dorer les morceaux de poulet dans l\'huile d\'olive. Saler, poivrer. Ajouter de l\'eau et laisser cuire une demi-heure. ', '', '00:30:00', 6),
(1013, 2, 'Couper l\'oignon et le poivron en morceaux, les mettre dans la cocotte, ainsi que le lait de coco et le coulis de tomate. Laisser réduire une demi-heure environ. C\'est prêt. ', '', '00:15:00', 6),
(1029, 2, 'Laissez refroidir pendant au moins 3h au réfrigérateur. ', '', '03:00:00', 25),
(1030, 1, 'Emincer l\'oignon et le faire dorer avec un peu de beurre. Rajouter les champignons égouttés puis le vin blanc et porter à ébullition. ', '', '00:10:00', 36),
(1031, 2, 'Ajouter ensuite la crème, le bouquet garni, le sel et le poivre. Mélanger et laisser un peu réduire. ', '', '00:05:00', 36),
(1032, 3, 'Rincer les filets de poisson, les éponger puis les passer dans la farine (en éliminant l\'excédent). ', '', '00:05:00', 36),
(1033, 4, 'Ajouter les filets dans la cocotte et baisser le feu. Faire cuire 20 mn. ', '', '00:20:00', 36),
(1041, 1, 'Au bain-marie, faire cuire ensemble les chamallows, les carambars et le beurre.  ', '', '00:10:00', 39),
(1042, 2, 'Quand vous obtenez une pâte homogène, rajoutez le riz soufflé et placez le tout dans un plat en couronne.', '', '00:10:00', 39),
(1043, 3, 'Laissez refroidir pendant au moins 3h au réfrigérateur. ', '', '03:00:00', 39),
(1044, 1, 'Peler les avocats et les couper en cubes grossièrement. Ecraser finement à la fourchette ou mieux, passer au mixeur (celui qu\'on emploi pour la soupe). Ajouter quelques gouttes de jus de citron pour ne pas qu\'ils noircissent. Saler et poivrer. Réserver. ', '', '00:05:00', 30),
(1045, 2, 'A part, mélanger le surimi râpé avec la mayonnaise. ', '', '00:02:00', 30),
(1046, 3, 'Dans un bol, mélanger la crème fraîche avec la ciboulette ciselée. Saler et poivrer. ', '', '00:03:00', 30),
(1047, 4, 'Décortiquer les crevettes en faisant attention de ne pas les abîmer. En reserver quatre, les plus belles, et couper les huit autres en deux dans le sens de la longueur pour faire 2 moitiés équivalentes. Dans chaque verre, répartir au fond le surimi à la mayonnaise. Coller sur les parois 4 demi-crevettes (face bombée vers l\'extérieur). ', '', '00:06:00', 30),
(1048, 5, 'Répartir la purée d\'avocat dans les 4 verres, tasser légèrement le tout puis finir avec la crème à la ciboulette. ', '', '00:05:00', 30),
(1049, 6, 'Enfin, déposer sur chaque verre une crevette entière. Réfrigérer les verres jusqu\'au moment de passer à table, au moins 30 minutes. On peut mettre au congélateur si on est un peu pressé. ', '', '00:30:00', 30),
(1050, 1, 'Couper les kiwis et les traches de saumon en dés. Disposer dans les verrines. (kiwi en-dessous, saumon au-dessus. ', '', '00:10:00', 37),
(1051, 2, 'Pour la sauce, mélanger la crème liquide et la mayonnaise avec la ciboulette et un filet de jus de citron. Verser la sauce sur le saumon. ', '', '00:10:00', 37),
(1052, 1, 'Faire cuire le potimarron à la cocotte 20 minutes en prenant soin auparavant de l\'avoir coupé en quartiers. Une astuce mettre des lardons et de l\'ail dans l\'eau de cuisson, cela donnera un goût fumé au potimarron. ', '', '00:20:00', 40),
(1053, 2, 'Lorsque celui-ci est cuit, enlever la peau, le mixer avec un tout petit peu d\'eau de cuisson et 1 cuillère à soupe de crème, puis le disposer au fond des verrines. ', '', '00:05:00', 40),
(1054, 3, 'Mélanger 5 cuillères à soupe de fromage ai et fines herbes avec 3 cuillères à soupe de crème fraîche, l\'ail pressé, le persil et le basilic, et ajouter ce mélange sur le dessus de vos verrines. ', '', '00:05:00', 40);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `img_id` int(11) NOT NULL COMMENT 'clé primaire',
  `img_nom` varchar(50) NOT NULL COMMENT 'le nom de l''image d''origine',
  `img_taille` varchar(25) NOT NULL COMMENT 'l''information de la taille',
  `img_type` varchar(25) NOT NULL COMMENT 'le type de l''image',
  `img_blob` blob NOT NULL COMMENT 'contenu binaire de l''image',
  `img_src` varchar(255) NOT NULL COMMENT 'url de l''image upload'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`img_id`, `img_nom`, `img_taille`, `img_type`, `img_blob`, `img_src`) VALUES
(51, '3_38', '27358', 'image/jpeg', '', 'public/upload/3_38'),
(52, '3_7', '37706', 'image/jpeg', '', 'public/upload/3_7'),
(53, '3_27', '56689', 'image/jpeg', '', 'public/upload/3_27'),
(54, '3_36', '49806', 'image/jpeg', '', 'public/upload/3_36'),
(57, '3_11', '63796', 'image/jpeg', '', 'public/upload/3_11'),
(58, '3_25', '46479', 'image/jpeg', '', 'public/upload/3_25'),
(59, '3_35', '38009', 'image/jpeg', '', 'public/upload/3_35'),
(60, '3_1', '81090', 'image/jpeg', '', 'public/upload/3_1'),
(61, '3_6', '38613', 'image/jpeg', '', 'public/upload/3_6'),
(62, '3_30', '33526', 'image/jpeg', '', 'public/upload/3_30'),
(63, '3_39', '46479', 'image/jpeg', '', 'public/upload/3_39'),
(64, '3_40', '34062', 'image/jpeg', '', 'public/upload/3_40');

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE `ingredient` (
  `id_ingredient` int(11) NOT NULL COMMENT 'id de l''ingrédient',
  `title` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL COMMENT 'unité de mesure des ingrédients (gr, ml, unité...)',
  `check_ingredient` int(11) NOT NULL COMMENT 'verification de l''ingrédient : 0 vérifié, 1 vérifié',
  `id_user` int(11) NOT NULL COMMENT 'id de l''utilisateur qui a inséré l''ingrédient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`id_ingredient`, `title`, `unit`, `check_ingredient`, `id_user`) VALUES
(1, 'abricot ', 'unit', 0, 0),
(2, 'agneau', 'gr', 0, 0),
(3, 'ail', 'unit', 0, 0),
(4, 'airelle', 'gr', 0, 0),
(5, 'algue', 'unit', 0, 0),
(6, 'amande', 'gr', 0, 0),
(7, 'ananas', 'unit', 0, 0),
(8, 'anchois', 'gr', 0, 0),
(9, 'aneth', 'gr', 0, 0),
(10, 'anguille', 'gr', 0, 0),
(11, 'armagnac', 'cl', 0, 0),
(12, 'artichaut', 'unit', 0, 0),
(13, 'asperge', 'gr', 0, 0),
(14, 'aubergine', 'unit', 0, 0),
(15, 'autruche', 'gr', 0, 0),
(16, 'avocat', 'unit', 0, 0),
(17, 'bacon', 'gr', 0, 0),
(18, 'baguette', 'unit', 0, 0),
(19, 'banane', 'unit', 0, 0),
(20, 'bar', 'gr', 0, 0),
(21, 'basilic', 'gr', 0, 0),
(22, 'batavia', 'gr', 0, 0),
(23, 'beaufort', 'gr', 0, 0),
(24, 'béchamel', 'cl', 0, 0),
(25, 'betterave', 'gr', 0, 0),
(26, 'beurre', 'gr', 0, 0),
(27, 'bière', 'cl', 0, 0),
(28, 'biscotte', 'gr', 0, 0),
(29, 'biscuit', 'gr', 0, 0),
(30, 'blé', 'gr', 0, 0),
(31, 'blette', 'gr', 0, 0),
(32, 'bleu', 'gr', 0, 0),
(33, 'boeuf', 'gr', 0, 0),
(34, 'bonbon', 'gr', 0, 0),
(35, 'boudin', 'gr', 0, 0),
(36, 'bouquet garni', 'unit', 0, 0),
(37, 'bourbon', 'gr', 0, 0),
(38, 'boursin', 'gr', 0, 0),
(39, 'brandy', 'cl', 0, 0),
(40, 'brioche', 'gr', 0, 0),
(41, 'brocoli', 'gr', 0, 0),
(42, 'cabillaud', 'gr', 0, 0),
(43, 'cacahuète', 'gr', 0, 0),
(44, 'cacao', 'gr', 0, 0),
(45, 'café', 'gr', 0, 0),
(46, 'caille', 'gr', 0, 0),
(47, 'calamar', 'gr', 0, 0),
(48, 'calvados', 'cl', 0, 0),
(49, 'camembert', 'gr', 0, 0),
(50, 'canard', 'gr', 0, 0),
(51, 'cannelle', 'gr', 0, 0),
(52, 'cantal', 'gr', 0, 0),
(53, 'câpre', 'gr', 0, 0),
(54, 'caramel', 'gr', 0, 0),
(55, 'carotte', 'unit', 0, 0),
(56, 'carpe', 'gr', 0, 0),
(57, 'cassis', 'gr', 0, 0),
(58, 'céleri', 'gr', 0, 0),
(59, 'cèpe', 'gr', 0, 0),
(60, 'cerfeuil', 'gr', 0, 0),
(61, 'cerise', 'gr', 0, 0),
(62, 'champagne', 'cl', 0, 0),
(63, 'champignon', 'gr', 0, 0),
(64, 'chanterelle', 'gr', 0, 0),
(65, 'chapon', 'gr', 0, 0),
(66, 'châtaigne', 'gr', 0, 0),
(67, 'chèvre', 'gr', 0, 0),
(68, 'chocolat', 'gr', 0, 0),
(69, 'chorizo', 'gr', 0, 0),
(70, 'chou', 'unit', 0, 0),
(71, 'chou-fleur', 'unit', 0, 0),
(72, 'ciboulette', 'gr', 0, 0),
(73, 'cidre', 'cl', 0, 0),
(74, 'citron', 'unit', 0, 0),
(75, 'citrouille', 'gr', 0, 0),
(76, 'clémentine', 'gr', 0, 0),
(77, 'clou de girofle', 'gr', 0, 0),
(78, 'coca-cola', 'cl', 0, 0),
(79, 'coeur de palmier', 'gr', 0, 0),
(80, 'cognac', 'cl', 0, 0),
(81, 'coing', 'gr', 0, 0),
(82, 'cointreau', 'cl', 0, 0),
(83, 'colin', 'gr', 0, 0),
(84, 'compote', 'gr', 0, 0),
(85, 'comté', 'gr', 0, 0),
(86, 'concombre', 'unit', 0, 0),
(87, 'confiture', 'gr', 0, 0),
(88, 'coquelet', 'gr', 0, 0),
(89, 'coquille Saint-Jacques', 'gr', 0, 0),
(90, 'coquillettes', 'gr', 0, 0),
(91, 'coriandre', 'gr', 0, 0),
(92, 'corn flakes', 'gr', 0, 0),
(93, 'cornichon', 'gr', 0, 0),
(94, 'courge', 'unit', 0, 0),
(95, 'courgette', 'unit', 0, 0),
(96, 'couscous', 'gr', 0, 0),
(97, 'crabe', 'unit', 0, 0),
(98, 'crème fraîche', 'cl', 0, 0),
(99, 'crêpe', 'unit', 0, 0),
(100, 'cresson', 'gr', 0, 0),
(101, 'crevette', 'gr', 0, 0),
(102, 'crosne', 'gr', 0, 0),
(103, 'crottin de chèvre', 'gr', 0, 0),
(104, 'cumin', 'gr', 0, 0),
(105, 'curcuma', 'gr', 0, 0),
(106, 'curry', 'gr', 0, 0),
(107, 'datte', 'unit', 0, 0),
(108, 'daurade', 'gr', 0, 0),
(109, 'dinde', 'gr', 0, 0),
(110, 'eau de vie', 'cl', 0, 0),
(111, 'échalote', 'unit', 0, 0),
(112, 'emmental', 'gr', 0, 0),
(113, 'endive', 'unit', 0, 0),
(114, 'épinards', 'gr', 0, 0),
(115, 'escalope', 'gr', 0, 0),
(116, 'escargot', 'gr', 0, 0),
(117, 'estragon', 'gr', 0, 0),
(118, 'farine', 'gr', 0, 0),
(119, 'fenouil', 'gr', 0, 0),
(120, 'feta', 'gr', 0, 0),
(121, 'feuille de brick', 'unit', 0, 0),
(122, 'fève', 'gr', 0, 0),
(123, 'figue', 'unit', 0, 0),
(124, 'foie gras', 'gr', 0, 0),
(125, 'fraise', 'gr', 0, 0),
(126, 'framboise', 'gr', 0, 0),
(127, 'fromage', 'gr', 0, 0),
(128, 'fromage blanc', 'gr', 0, 0),
(129, 'fruit de la passion', 'gr', 0, 0),
(130, 'fruits de mer', 'gr', 0, 0),
(131, 'gamba', 'gr', 0, 0),
(132, 'gibier', 'gr', 0, 0),
(133, 'gigot', 'gr', 0, 0),
(134, 'gin', 'cl', 0, 0),
(135, 'gingembre', 'gr', 0, 0),
(136, 'girolle', 'gr', 0, 0),
(137, 'glace', 'gr', 0, 0),
(138, 'goyave', 'unit', 0, 0),
(139, 'grand marnier', 'cl', 0, 0),
(140, 'grenadine', 'cl', 0, 0),
(141, 'grenouille', 'gr', 0, 0),
(142, 'griotte au sirop', 'gr', 0, 0),
(143, 'groseille', 'gr', 0, 0),
(144, 'gruyère', 'gr', 0, 0),
(145, 'haddock', 'gr', 0, 0),
(146, 'hareng', 'gr', 0, 0),
(147, 'haricot', 'gr', 0, 0),
(148, 'harissa', 'gr', 0, 0),
(149, 'homard', 'gr', 0, 0),
(150, 'huître', 'unit', 0, 0),
(151, 'jambon', 'gr', 0, 0),
(152, 'jambonneau', 'gr', 0, 0),
(153, 'jus', 'cl', 0, 0),
(154, 'kiwi', 'unit', 0, 0),
(155, 'lait', 'cl', 0, 0),
(156, 'lait de coco', 'cl', 0, 0),
(157, 'laitue', 'unit', 0, 0),
(158, 'langouste', 'unit', 0, 0),
(159, 'langoustine', 'unit', 0, 0),
(160, 'lapin', 'gr', 0, 0),
(161, 'lard', 'gr', 0, 0),
(162, 'lardon', 'gr', 0, 0),
(163, 'lasagne', 'unit', 0, 0),
(164, 'laurier', 'gr', 0, 0),
(165, 'lentille', 'gr', 0, 0),
(166, 'lieu', 'gr', 0, 0),
(167, 'lièvre', 'gr', 0, 0),
(168, 'limonade', 'cl', 0, 0),
(169, 'liqueur', 'cl', 0, 0),
(170, 'litchi', 'unit', 0, 0),
(171, 'lotte', 'gr', 0, 0),
(172, 'loup', 'gr', 0, 0),
(173, 'macaron', 'unit', 0, 0),
(174, 'macaroni', 'gr', 0, 0),
(175, 'mâche', 'gr', 0, 0),
(176, 'magret', 'gr', 0, 0),
(177, 'maïs', 'gr', 0, 0),
(178, 'malibu', 'cl', 0, 0),
(179, 'mangue', 'unit', 0, 0),
(180, 'maquereau', 'gr', 0, 0),
(181, 'marron', 'gr', 0, 0),
(182, 'marshmallow', 'gr', 0, 0),
(183, 'martini', 'cl', 0, 0),
(184, 'melon', 'unit', 0, 0),
(185, 'menthe', 'gr', 0, 0),
(186, 'merguez', 'gr', 0, 0),
(187, 'merlan', 'gr', 0, 0),
(188, 'merlu', 'gr', 0, 0),
(189, 'miel', 'gr', 0, 0),
(190, 'mirabelle', 'gr', 0, 0),
(191, 'morue', 'gr', 0, 0),
(192, 'moules', 'gr', 0, 0),
(193, 'mouton', 'gr', 0, 0),
(194, 'mozzarella', 'gr', 0, 0),
(195, 'munster', '', 0, 0),
(196, 'mûre', 'gr', 0, 0),
(197, 'muscade', 'gr', 0, 0),
(198, 'myrtille', 'gr', 0, 0),
(199, 'navet', 'unit', 0, 0),
(200, 'nectar', 'cl', 0, 0),
(201, 'noisette', 'gr', 0, 0),
(202, 'noix', 'gr', 0, 0),
(203, 'noix de cajou', 'gr', 0, 0),
(204, 'noix de coco', 'unit', 0, 0),
(205, 'nougat', 'gr', 0, 0),
(206, 'oeuf', 'unit', 0, 0),
(207, 'oie', 'gr', 0, 0),
(208, 'oignon', 'unit', 0, 0),
(209, 'olive', 'gr', 0, 0),
(210, 'orange', 'unit', 0, 0),
(211, 'origan', 'gr', 0, 0),
(212, 'oseille', 'gr', 0, 0),
(213, 'pain', 'gr', 0, 0),
(214, 'pamplemousse', 'unit', 0, 0),
(215, 'papaye', 'unit', 0, 0),
(216, 'paprika', 'gr', 0, 0),
(217, 'parmesan', 'gr', 0, 0),
(218, 'pastis', 'cl', 0, 0),
(219, 'pâte', 'gr', 0, 0),
(220, 'pâtes', 'gr', 0, 0),
(221, 'pêche', 'unit', 0, 0),
(222, 'persil', 'gr', 0, 0),
(223, 'petit suisse', 'gr', 0, 0),
(224, 'petits pois', 'gr', 0, 0),
(225, 'pigeon', 'gr', 0, 0),
(226, 'pignon', 'gr', 0, 0),
(227, 'piment', 'gr', 0, 0),
(228, 'pineau', 'cl', 0, 0),
(229, 'pintade', 'gr', 0, 0),
(230, 'poire', 'unit', 0, 0),
(231, 'poireau', 'unit', 0, 0),
(232, 'pois', 'gr', 0, 0),
(233, 'poisson', 'gr', 0, 0),
(234, 'poitrine fumée', 'gr', 0, 0),
(235, 'poivron', 'unit', 0, 0),
(236, 'pomme', 'unit', 0, 0),
(237, 'pomme de terre', 'gr', 0, 0),
(238, 'porc', 'gr', 0, 0),
(239, 'porto', 'cl', 0, 0),
(240, 'potimarron', 'gr', 0, 0),
(241, 'poulet', 'gr', 0, 0),
(242, 'poulpe', 'gr', 0, 0),
(243, 'pousse de bambou', 'gr', 0, 0),
(244, 'prune', 'gr', 0, 0),
(245, 'pruneau', 'gr', 0, 0),
(246, 'purée', 'gr', 0, 0),
(247, 'radis', 'gr', 0, 0),
(248, 'raie', 'gr', 0, 0),
(249, 'raisin', 'gr', 0, 0),
(250, 'rascasse', 'gr', 0, 0),
(251, 'ratatouille', 'gr', 0, 0),
(252, 'raviolis', 'gr', 0, 0),
(253, 'reblochon', 'gr', 0, 0),
(254, 'reine claude', 'unit', 0, 0),
(255, 'rhubarbe', 'unit', 0, 0),
(256, 'rhum', 'cl', 0, 0),
(257, 'ricotta', 'gr', 0, 0),
(258, 'risotto', 'gr', 0, 0),
(259, 'riz', 'gr', 0, 0),
(260, 'romarin', 'gr', 0, 0),
(261, 'roquefort', 'gr', 0, 0),
(262, 'rouget', 'gr', 0, 0),
(263, 'rumsteak', 'gr', 0, 0),
(264, 'safran', 'gr', 0, 0),
(265, 'saint-Moret', 'gr', 0, 0),
(266, 'saint-Nectaire', 'gr', 0, 0),
(267, 'saké', 'cl', 0, 0),
(268, 'salade', 'unit', 0, 0),
(269, 'sardine', 'gr', 0, 0),
(270, 'saucisse', 'gr', 0, 0),
(271, 'saucisson', 'gr', 0, 0),
(272, 'saumon', 'gr', 0, 0),
(273, 'seiche', 'gr', 0, 0),
(274, 'semoule', 'gr', 0, 0),
(275, 'sésame', 'gr', 0, 0),
(276, 'soda', 'cl', 0, 0),
(277, 'soja', 'gr', 0, 0),
(278, 'sole', 'gr', 0, 0),
(279, 'sorbet', 'gr', 0, 0),
(280, 'spaghetti', 'gr', 0, 0),
(281, 'spéculos', 'gr', 0, 0),
(282, 'steak', 'gr', 0, 0),
(283, 'sucre', 'gr', 0, 0),
(284, 'surimi', 'gr', 0, 0),
(285, 'tagliatelle', 'gr', 0, 0),
(286, 'tapenade', 'gr', 0, 0),
(287, 'tequila', 'cl', 0, 0),
(288, 'thé', 'cl', 0, 0),
(289, 'thon', 'gr', 0, 0),
(290, 'thym', 'gr', 0, 0),
(291, 'tofu', 'gr', 0, 0),
(292, 'tomate', 'unit', 0, 0),
(293, 'topinambour', 'unit', 0, 0),
(294, 'tournedos', 'gr', 0, 0),
(295, 'truffe', 'gr', 0, 0),
(296, 'truite', 'gr', 0, 0),
(297, 'turbot', 'gr', 0, 0),
(298, 'vanille', 'gr', 0, 0),
(299, 'veau', 'gr', 0, 0),
(300, 'vermouth', 'gr', 0, 0),
(301, 'viande des grisons', 'gr', 0, 0),
(302, 'vin', 'cl', 0, 0),
(303, 'vodka', 'cl', 0, 0),
(304, 'volaille', 'gr', 0, 0),
(305, 'whisky', 'cl', 0, 0),
(306, 'yaourt', 'gr', 0, 0),
(311, 'kangourou', 'gr', 1, 3),
(312, 'lait ribot', 'cl', 1, 3),
(313, 'citron vert', 'unit', 1, 3),
(314, 'chocolat noir', 'gr', 1, 3),
(317, 'chocolat blanc', 'gr', 1, 3),
(318, 'chocolat au lait', 'gr', 1, 3),
(319, '   ', 'unit', 1, 3),
(320, 'pignon de pin', 'unit', 1, 3),
(321, 'magret de canard gras', 'unit', 1, 3),
(322, 'vinaigre balsamique', 'cl', 1, 3),
(323, 'sel', 'gr', 1, 3),
(324, 'eau', 'cl', 1, 3),
(325, 'huile de friture', 'cl', 1, 3),
(326, 'poivre', 'gr', 1, 3),
(327, 'petits pains ronds au sésame', 'unit', 1, 3),
(328, 'steack haché', 'unit', 1, 3),
(329, 'oignon rouge', 'unit', 1, 3),
(330, 'cheddar (tranche)', 'unit', 1, 3),
(331, 'chamallow', 'unit', 1, 3),
(332, 'carambar', 'unit', 1, 3),
(333, 'riz soufflé', 'gr', 1, 3),
(334, 'crevette rose', 'unit', 1, 3),
(335, 'mayonnaise', 'gr', 1, 3),
(336, 'blanc d\'oeuf', 'unit', 1, 3),
(337, 'sucre semoule', 'gr', 1, 3),
(338, 'coulis de tomate', 'cl', 1, 3),
(339, 'poivron rouge', 'unit', 1, 3),
(340, 'huile d\'olive', 'cl', 1, 3),
(341, 'pilon de poulet', 'unit', 1, 3),
(342, 'épice à couscous', 'gr', 1, 3),
(343, 'bouillon cube de boeuf', 'unit', 1, 3),
(344, 'pois chiches', 'gr', 1, 3),
(345, 'lieu noir', 'gr', 1, 3),
(346, 'vin blanc', 'cl', 1, 3),
(347, 'crème fraîche liquide', 'cl', 1, 3),
(348, 'saumon fumé', 'gr', 1, 3),
(349, 'oeuf de caille', 'unit', 1, 3),
(350, 'macédoine de légume', 'gr', 1, 3),
(351, 'vinaigre', 'cl', 1, 3),
(352, 'fromage ail et fines herbes', 'gr', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `ingredient_recette`
--

CREATE TABLE `ingredient_recette` (
  `id_ingredient_recette` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'quantité de l''ingrédient (gr;cl;unité...)',
  `id_ingredient` int(11) NOT NULL COMMENT 'id de l''ingrédient',
  `id_recette` int(11) NOT NULL COMMENT 'id de la redette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ingredient_recette`
--

INSERT INTO `ingredient_recette` (`id_ingredient_recette`, `quantity`, `id_ingredient`, `id_recette`) VALUES
(817, 4, 336, 3),
(818, 250, 337, 3),
(879, 1, 350, 38),
(880, 20, 58, 38),
(881, 10, 222, 38),
(882, 1, 55, 38),
(883, 6, 349, 38),
(884, 6, 206, 38),
(885, 10, 351, 38),
(886, 1, 268, 38),
(887, 10, 127, 38),
(888, 6, 53, 38),
(889, 1, 93, 38),
(890, 1, 51, 7),
(891, 1, 323, 7),
(892, 3, 230, 7),
(893, 150, 186, 27),
(894, 1, 338, 27),
(895, 8, 341, 27),
(896, 10, 342, 27),
(897, 2, 343, 27),
(898, 10, 148, 27),
(899, 30, 292, 27),
(900, 5, 55, 27),
(901, 2, 95, 27),
(902, 400, 344, 27),
(1028, 500, 325, 11),
(1029, 5, 323, 11),
(1030, 20, 324, 11),
(1031, 20, 155, 11),
(1032, 10, 326, 11),
(1037, 3, 206, 35),
(1038, 100, 283, 35),
(1039, 50, 118, 35),
(1040, 100, 26, 35),
(1041, 30, 189, 1),
(1042, 3, 323, 1),
(1043, 15, 322, 1),
(1044, 1, 323, 6),
(1045, 1, 326, 6),
(1046, 40, 156, 6),
(1047, 3000, 241, 6),
(1048, 10, 340, 6),
(1049, 1, 208, 6),
(1075, 15, 346, 36),
(1076, 1, 36, 36),
(1077, 1, 323, 36),
(1078, 600, 345, 36),
(1079, 1, 208, 36),
(1080, 400, 63, 36),
(1081, 40, 118, 36),
(1082, 10, 26, 36),
(1095, 30, 331, 39),
(1096, 30, 332, 39),
(1097, 125, 26, 39),
(1098, 125, 333, 39),
(1100, 1, 74, 30),
(1101, 10, 335, 30),
(1102, 1, 334, 30),
(1103, 1, 72, 30),
(1104, 4, 16, 30),
(1105, 1, 323, 30),
(1106, 1, 326, 30),
(1107, 1, 348, 37),
(1108, 5, 347, 37),
(1109, 4, 154, 37),
(1110, 10, 335, 37),
(1111, 5, 72, 37),
(1112, 500, 240, 40),
(1113, 50, 352, 40),
(1114, 10, 222, 40),
(1115, 1, 3, 40),
(1116, 20, 98, 40),
(1117, 10, 21, 40);

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE `list` (
  `id_list` int(11) NOT NULL,
  `id_planning_day` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL DEFAULT '0' COMMENT 'quantité à retirer des ingrédient que l''utilisateur a déjà '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `list_shop`
--

CREATE TABLE `list_shop` (
  `id_list_shop` int(11) NOT NULL,
  `id_list` int(11) NOT NULL COMMENT 'id de la liste de course du planning_day',
  `more` varchar(255) NOT NULL COMMENT 'ajout de la personne de chose qui ne sont pas des ingrédient d''une recette'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mentions`
--

CREATE TABLE `mentions` (
  `id` int(11) NOT NULL COMMENT 'id des zone de texte',
  `titre` varchar(255) NOT NULL COMMENT 'titre de la mention',
  `texte` text NOT NULL COMMENT 'texte de la mention'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mentions`
--

INSERT INTO `mentions` (`id`, `titre`, `texte`) VALUES
(1, 'Directeur de la publication :', 'Kajoo - Amérique tropicale - Tel : perdu!'),
(2, 'Nom de l’entreprise :', 'Kajoo'),
(3, 'Développeur du site :', 'Collin anaïs – 38 rue des granitiers 56120 St Servant sur Oust.'),
(4, 'Hébergement : ', 'O2switch - 222 Boulevard Gustave Flaubert, 63000 Clermont-Ferrand'),
(5, 'Droit d’auteur et d’image : ', 'Kajoo – images non libres de droit.');

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `id_planning` int(11) NOT NULL,
  `date_planning` date NOT NULL COMMENT 'date correspondante au repas',
  `list` int(11) NOT NULL DEFAULT '0' COMMENT 'indicateur si planning est présent sur une liste de course(0 non; 1 oui)',
  `month` int(2) NOT NULL COMMENT 'mois concerné par le planing pour le calendrier',
  `title` varchar(255) NOT NULL COMMENT 'titre du repas',
  `id_user` int(11) NOT NULL COMMENT 'id de lutilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `planning`
--

INSERT INTO `planning` (`id_planning`, `date_planning`, `list`, `month`, `title`, `id_user`) VALUES
(847, '2019-07-31', 1, 7, 'annif mamie', 3),
(848, '2019-07-29', 0, 7, 'Mamie vient manger', 3),
(849, '2019-07-30', 0, 7, '', 3),
(850, '2019-08-01', 0, 8, 'Les cousins débarquent', 3);

-- --------------------------------------------------------

--
-- Structure de la table `planning_day`
--

CREATE TABLE `planning_day` (
  `id_planning_day` int(11) NOT NULL,
  `rang` int(3) NOT NULL COMMENT 'ra,g du planning dans la journée 1 : entree ; 2: plat ; 3:dessert ',
  `id_recette` int(11) NOT NULL COMMENT 'id de la recette',
  `id_planning` int(100) NOT NULL COMMENT 'id du planning correspondant ',
  `other` text NOT NULL COMMENT 'liste des plats ou autre qui ne viennet pas d''une recette',
  `personn` int(11) NOT NULL COMMENT 'nbr de personne a manger',
  `id_user` int(11) NOT NULL COMMENT 'id de l''utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `planning_day`
--

INSERT INTO `planning_day` (`id_planning_day`, `rang`, `id_recette`, `id_planning`, `other`, `personn`, `id_user`) VALUES
(250, 1, 1, 848, 'Magrets de canard au miel', 5, 3),
(251, 1, 3, 848, 'Meringue', 5, 3),
(252, 1, 0, 848, 'haricots vert et salade', 5, 3),
(253, 2, 6, 848, 'Poulet coco réunionnais', 5, 3),
(254, 2, 35, 848, 'Gâteau au chocolat', 5, 3),
(255, 1, 0, 849, 'carotte', 4, 3),
(256, 1, 39, 849, 'Gâteau carambar et chamallows', 4, 3),
(257, 1, 6, 849, 'Poulet coco réunionnais', 4, 3),
(258, 0, 0, 847, 'céréale, brioche, jus d\'orange +\nTartelette', 1, 3),
(259, 0, 3, 847, 'Meringue', 1, 3),
(260, 1, 1, 847, 'Magrets de canard au miel', 1, 3),
(261, 1, 7, 847, 'Clafoutis aux poires facile', 1, 3),
(262, 1, 0, 847, 'carottes rapées et tomates', 1, 3),
(263, 2, 0, 847, 'soupe de mamie avec des croutons', 1, 3),
(264, 2, 0, 847, 'burger', 1, 3),
(265, 2, 7, 847, 'Clafoutis aux poires facile', 1, 3),
(266, 1, 27, 850, 'Couscous poulet et merguez facile', 8, 3),
(267, 1, 38, 850, 'Bonhomme de neige', 8, 3);

-- --------------------------------------------------------

--
-- Structure de la table `politique`
--

CREATE TABLE `politique` (
  `id` int(11) NOT NULL COMMENT 'id de la zone',
  `titre` varchar(255) NOT NULL COMMENT 'titre de la sous partie de la politique',
  `texte` text NOT NULL COMMENT 'texte de la sous partie de la politique'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `politique`
--

INSERT INTO `politique` (`id`, `titre`, `texte`) VALUES
(1, 'Qui sommes-nous ?', 'L’adresse de notre site Web est : http://www.kajoo.uimainon.com.'),
(2, 'Utilisation des données personnelles collectées', 'Une chaîne anonymisée créée à partir de votre adresse de messagerie (également appelée hash) peut être envoyée au service Gravatar pour vérifier si vous utilisez ce dernier. Les clauses de confidentialité du service Gravatar sont disponibles ici : https://automattic.com/privacy/. Après validation de votre commentaire, votre photo de profil sera visible publiquement à coté de votre commentaire.'),
(3, 'Formulaires – Utilisation et transmission de vos données personnelles', 'Type de données récoltées : lors de l’inscription sur notre site web : email et pseudo. Combien de temps nous stockons ces données : Les données sont stocké indéfiniment. Nous les utilisons pour l\'affichage des commentaires que vous allez poster. Votre pseudo sera votre identité à l\'affichage. '),
(4, 'Contenu embarqué depuis d’autres sites', 'Les articles de ce site peuvent inclure des contenus intégrés (par exemple des vidéos, images, articles…). Le contenu intégré depuis d’autres sites se comporte de la même manière que si le visiteur se rendait sur cet autre site.\r\n\r\nCes sites web pourraient collecter des données sur vous, utiliser des cookies, embarquer des outils de suivis tiers, suivre vos interactions avec ces contenus embarqués si vous disposez d’un compte connecté sur leur site web.'),
(5, 'Durées de stockage de vos données', 'Si vous laissez un commentaire, le commentaire et ses métadonnées sont conservés indéfiniment. Cela permet de reconnaître automatiquement les commentaires suivants.\r\n\r\nPour les utilisateurs et utilisatrices qui s’enregistrent sur notre site (si cela est possible), nous stockons également les données personnelles indiquées dans leur profil. Tous les utilisateurs et utilisatrices peuvent voir, modifier ou supprimer leurs informations personnelles (password) à tout moment (à l’exception de leur mail). Les gestionnaires du site peuvent aussi voir et modifier ces informations.'),
(6, 'Les droits que vous avez sur vos données', 'Si vous avez un compte ou si vous avez laissé des commentaires sur le site, vous pouvez demander à recevoir un fichier contenant toutes les données personnelles que nous possédons à votre sujet, incluant celles que vous nous avez fournies. Vous pouvez également demander la suppression des données personnelles vous concernant. Cela ne prend pas en compte les données stockées à des fins administratives, légales ou pour des raisons de sécurité.'),
(7, 'Transmission de vos données personnelles', 'Aucune de vos données ne sera transmise à un tiers.'),
(8, 'Informations de contact', 'Vous pouvez nous contacter aux coordonnées suivante : Kajoo - Amérique tropicale - Tel : perdu!');

-- --------------------------------------------------------

--
-- Structure de la table `preference`
--

CREATE TABLE `preference` (
  `id_pref` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `people_planning` int(11) NOT NULL,
  `people_recipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `preference`
--

INSERT INTO `preference` (`id_pref`, `id_user`, `people_planning`, `people_recipe`) VALUES
(1, 3, 5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

CREATE TABLE `recettes` (
  `id_recette` int(11) NOT NULL COMMENT 'id des recettes',
  `title` varchar(255) NOT NULL COMMENT 'titre de la recette',
  `prepare_time` time NOT NULL COMMENT 'temps de préparation',
  `people` int(2) NOT NULL COMMENT 'nombre de personne ',
  `img` varchar(255) NOT NULL COMMENT 'lien de l''image de la recette',
  `id_category` int(3) NOT NULL DEFAULT '0' COMMENT 'id de la catégorie de la recette',
  `alpha` varchar(1) NOT NULL COMMENT 'lettre de rangement alphabetique pour trier : correspont à la première lettre du titre de la recette',
  `love` int(3) DEFAULT '0' COMMENT 'indicateur de la recette (0 : rien ; 1 : aime)',
  `price` int(11) NOT NULL DEFAULT '1' COMMENT 'définit le cout de la recette',
  `easy` int(11) NOT NULL DEFAULT '1' COMMENT 'indicateur de la facilité',
  `id_user` int(11) NOT NULL COMMENT 'id de lutilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recettes`
--

INSERT INTO `recettes` (`id_recette`, `title`, `prepare_time`, `people`, `img`, `id_category`, `alpha`, `love`, `price`, `easy`, `id_user`) VALUES
(1, 'Magrets de canard au miel', '00:21:00', 5, '', 2, 'M', 1, 2, 1, 3),
(3, 'Meringue', '01:15:01', 4, '', 3, 'M', 1, 1, 1, 3),
(6, 'Poulet coco réunionnais', '00:45:00', 4, '', 2, 'P', 0, 2, 2, 3),
(7, 'Clafoutis aux poires facile', '00:45:00', 6, '', 3, 'C', 1, 1, 1, 3),
(11, 'Fish and chips facile', '00:30:00', 3, '', 2, 'F', 1, 3, 2, 3),
(27, 'Couscous poulet et merguez facile', '05:05:00', 6, '', 2, 'C', 1, 2, 2, 3),
(30, 'Verrines salées faîcheur avocat-crevettes', '00:51:00', 4, '', 27, 'V', 0, 2, 1, 3),
(35, 'Gâteau au chocolat', '00:25:00', 5, '', 3, 'G', 0, 3, 2, 3),
(36, 'Blanquette de poisson', '00:40:00', 4, '', 2, 'B', 1, 2, 1, 3),
(37, 'Verrines bicolores kiwi-saumon', '00:20:00', 4, '', 27, 'V', 1, 1, 1, 3),
(38, 'Bonhomme de neige', '00:48:00', 6, '', 2, 'B', 0, 2, 2, 3),
(39, 'Gâteau carambar et chamallows', '03:20:00', 6, '', 3, 'G', 1, 1, 1, 3),
(40, 'Verrine d\'automne', '00:30:00', 4, '', 27, 'V', 0, 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `shop`
--

CREATE TABLE `shop` (
  `id_shop` int(11) NOT NULL,
  `date_planning_start` date DEFAULT NULL COMMENT 'date du début du planing',
  `date_planning_end` date NOT NULL COMMENT 'date de fin du planning',
  `list` text NOT NULL COMMENT 'liste de courses',
  `recall` date NOT NULL COMMENT 'date du début du rappelrappel ',
  `id_user` int(11) NOT NULL COMMENT 'id de lutilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'email de l''utilisateur',
  `registration` date NOT NULL COMMENT 'date d''inscription',
  `password` varchar(255) NOT NULL COMMENT 'mot de pass',
  `pseudo` varchar(255) NOT NULL COMMENT 'pseudo de l''utilisateur',
  `admin` int(11) NOT NULL DEFAULT '0' COMMENT '0 : utilisateur ; 1:admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `registration`, `password`, `pseudo`, `admin`) VALUES
(3, 'sweetandpick@gmail.com', '2019-06-23', '$2y$10$e89GdWgOICdrW8TnyBfFxOyek3e4Jt6ugpXi.TnooJsfnuy2lrCai', 'Anais', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `etape`
--
ALTER TABLE `etape`
  ADD PRIMARY KEY (`id_etape`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`);

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id_ingredient`);

--
-- Index pour la table `ingredient_recette`
--
ALTER TABLE `ingredient_recette`
  ADD PRIMARY KEY (`id_ingredient_recette`);

--
-- Index pour la table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id_list`);

--
-- Index pour la table `list_shop`
--
ALTER TABLE `list_shop`
  ADD PRIMARY KEY (`id_list_shop`);

--
-- Index pour la table `mentions`
--
ALTER TABLE `mentions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id_planning`);

--
-- Index pour la table `planning_day`
--
ALTER TABLE `planning_day`
  ADD PRIMARY KEY (`id_planning_day`);

--
-- Index pour la table `politique`
--
ALTER TABLE `politique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`id_pref`);

--
-- Index pour la table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id_recette`);

--
-- Index pour la table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id_shop`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `etape`
--
ALTER TABLE `etape`
  MODIFY `id_etape` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1058;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clé primaire', AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id_ingredient` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de l''ingrédient', AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT pour la table `ingredient_recette`
--
ALTER TABLE `ingredient_recette`
  MODIFY `id_ingredient_recette` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1123;

--
-- AUTO_INCREMENT pour la table `list`
--
ALTER TABLE `list`
  MODIFY `id_list` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `list_shop`
--
ALTER TABLE `list_shop`
  MODIFY `id_list_shop` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mentions`
--
ALTER TABLE `mentions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id des zone de texte', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `planning`
--
ALTER TABLE `planning`
  MODIFY `id_planning` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=851;

--
-- AUTO_INCREMENT pour la table `planning_day`
--
ALTER TABLE `planning_day`
  MODIFY `id_planning_day` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT pour la table `politique`
--
ALTER TABLE `politique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la zone', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `preference`
--
ALTER TABLE `preference`
  MODIFY `id_pref` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `id_recette` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id des recettes', AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `shop`
--
ALTER TABLE `shop`
  MODIFY `id_shop` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
