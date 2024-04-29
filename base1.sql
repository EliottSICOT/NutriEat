-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.3.0 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour nutrieat
CREATE DATABASE IF NOT EXISTS `nutrieat` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `nutrieat`;

-- Listage de la structure de table nutrieat. aliments
CREATE TABLE IF NOT EXISTS `aliments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `calories` decimal(10,2) NOT NULL,
  `proteines` decimal(10,2) NOT NULL,
  `glucides` decimal(10,2) NOT NULL,
  `lipides` decimal(10,2) NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table nutrieat.aliments : ~70 rows (environ)
INSERT INTO `aliments` (`id`, `nom`, `calories`, `proteines`, `glucides`, `lipides`, `utilisateur_id`, `categorie`) VALUES
	(149, 'Pain, baguette ou boule, bio à la farine T55 à T110', 257.00, 8.68, 49.90, 1.19, NULL, 'produits céréaliers'),
	(150, 'Quinoa cru', 358.00, 13.20, 58.10, 6.07, NULL, 'produits céréaliers'),
	(151, 'Farine de blé tendre ou froment T80', 355.00, 9.95, 73.20, 1.18, NULL, ''),
	(152, 'Saucisse de volaille, façon charcutière', 231.00, 16.80, 1.19, 17.70, NULL, 'viandes, œufs, poissons et assimilés'),
	(153, 'Brochette de crevettes', 93.50, 18.50, 1.50, 1.50, NULL, 'entrées et plats composés'),
	(154, 'Crème caramel, rayon frais', 132.00, 4.45, 20.60, 3.60, NULL, 'produits laitiers et assimilés'),
	(155, 'Langue, boeuf, cuite', 235.00, 23.70, 0.00, 15.60, NULL, 'viandes, œufs, poissons et assimilés'),
	(156, 'Lieu noir, surgelé, cru', 82.40, 19.80, 0.00, 0.37, NULL, 'viandes, œufs, poissons et assimilés'),
	(157, 'Jambon cuit, de Paris, découenné dégraissé', 115.00, 20.00, 1.08, 3.42, NULL, 'viandes, œufs, poissons et assimilés'),
	(158, 'Boeuf, boule de macreuse, grillée/poêlée', 144.00, 26.70, 0.00, 4.11, NULL, 'viandes, œufs, poissons et assimilés'),
	(159, 'Eau minérale, plate (aliment moyen)', 0.00, 0.00, 0.00, 0.00, NULL, 'eaux et autres boissons'),
	(160, 'Julienne ou Lingue, crue', 80.80, 19.20, 0.00, 0.44, NULL, 'viandes, œufs, poissons et assimilés'),
	(161, 'Paëlla', 148.00, 7.86, 17.10, 4.90, NULL, 'entrées et plats composés'),
	(162, 'Nectarine ou brugnon, jaune, pulpe et peau, crue', 51.30, 0.69, 11.30, 0.50, NULL, 'fruits, légumes, légumineuses et oléagineux'),
	(163, 'Matière grasse mélangée (végétale et laitière), à tartiner, à 30-40% MG', 397.00, 1.69, 5.60, 40.90, NULL, 'matières grasses'),
	(164, 'Foie, poulet, cuit', 160.00, 24.50, 0.80, 6.51, NULL, 'viandes, œufs, poissons et assimilés'),
	(165, 'Huile ou graisse de palmiste, sans précision', 900.00, 0.00, 0.00, 100.00, NULL, 'matières grasses'),
	(166, 'Poitrine de porc, fumée, crue', 303.00, 15.60, 0.79, 26.10, NULL, 'viandes, œufs, poissons et assimilés'),
	(167, 'Nem ou Pâté impérial', 216.00, 6.48, 21.10, 11.20, NULL, 'entrées et plats composés'),
	(168, 'Poulet, aile, viande et peau, cru', 181.00, 20.40, 0.00, 11.00, NULL, 'viandes, œufs, poissons et assimilés'),
	(169, 'Frik (blé dur immature concassé), cru', 323.00, 9.62, 55.80, 2.25, NULL, 'produits céréaliers'),
	(170, 'Boulette végétale au soja et/ou blé, préemballée', 211.00, 17.60, 7.98, 10.60, NULL, 'entrées et plats composés'),
	(171, 'Pâtes fraîches farcies (ex : raviolis, tortellinis), aux légumes, préemballées, crues', 255.00, 9.40, 41.40, 5.06, NULL, 'entrées et plats composés'),
	(172, 'Porc, rôti, cru', 153.00, 22.30, 0.50, 6.86, NULL, 'viandes, œufs, poissons et assimilés'),
	(173, 'Sabre, cru', 125.00, 18.00, 0.00, 5.90, NULL, 'viandes, œufs, poissons et assimilés'),
	(174, 'Boeuf, braisé', 240.00, 32.10, 0.00, 12.40, NULL, 'viandes, œufs, poissons et assimilés'),
	(175, 'Vivaneau, cru', 94.10, 20.50, 0.00, 1.34, NULL, 'viandes, œufs, poissons et assimilés'),
	(176, 'Huile de pavot', 900.00, 0.00, 0.00, 100.00, NULL, 'matières grasses'),
	(177, 'Toasts ou Canapés salés, garnitures diverses, préemballés', 233.00, 9.09, 17.80, 13.30, NULL, 'entrées et plats composés'),
	(178, 'Clam, Praire ou Palourde, bouilli/cuit à eau', 99.20, 16.20, 5.33, 1.48, NULL, 'viandes, œufs, poissons et assimilés'),
	(179, 'Eau minérale Ogeu, embouteillée, gazeuse, faiblement minéralisée (Ogeu-les-Bains, 64)', 0.00, 0.00, 0.00, 0.00, NULL, 'eaux et autres boissons'),
	(180, 'Crème dessert au caramel, rayon frais', 117.00, 2.92, 18.60, 3.47, NULL, 'produits laitiers et assimilés'),
	(181, 'Frites de pommes de terre, surgelées, préfrites, pour cuisson en friteuse', 244.00, 3.12, 29.10, 12.10, NULL, 'fruits, légumes, légumineuses et oléagineux'),
	(182, 'Foie gras, canard, bloc, 30% de morceaux', 489.00, 6.88, 2.43, 50.10, NULL, 'viandes, œufs, poissons et assimilés'),
	(183, 'Pâte feuilletée pur beurre, crue', 368.00, 5.60, 39.70, 20.10, NULL, ''),
	(184, 'Panna cotta, avec préparations de fruits ou caramel, rayon frais', 198.00, 2.74, 14.90, 13.00, NULL, 'produits laitiers et assimilés'),
	(185, 'Poulet, pilon, cru', 155.00, 18.40, 0.00, 9.05, NULL, 'viandes, œufs, poissons et assimilés'),
	(186, 'Cidre bouché demi-sec', 48.00, 0.50, 4.40, 0.60, NULL, 'eaux et autres boissons'),
	(187, 'Jus ananas, à base de concentré', 52.30, 0.41, 11.90, 0.10, NULL, 'eaux et autres boissons'),
	(188, 'Fruit cru (aliment moyen)', 59.50, 0.70, 11.60, 0.26, NULL, 'fruits, légumes, légumineuses et oléagineux'),
	(189, 'Champignon, lentin comestible ou shiitaké, séché', 316.00, 9.58, 63.90, 0.99, NULL, 'fruits, légumes, légumineuses et oléagineux'),
	(190, 'Confiture, tout type de fruits, allégée en sucres (extra ou classique)', 162.00, 0.75, 38.00, 0.30, NULL, 'produits sucrés'),
	(191, 'Crème de lait ou spécialité à base de crème légère, teneur en matière grasse inconnue (aliment moyen)', 269.00, 2.88, 2.87, 26.00, NULL, 'produits laitiers et assimilés'),
	(192, 'Eau minérale Montclar, embouteillée, non gazeuse, faiblement minéralisée (Montclar, 04)', 0.00, 0.00, 0.00, 0.00, NULL, 'eaux et autres boissons'),
	(193, 'Petit salé ou saucisse aux lentilles, préemballé', 118.00, 8.24, 8.89, 4.87, NULL, 'entrées et plats composés'),
	(194, 'Ascophylle noueux ou goémon noir (Ascophyllum nodosum), séché ou déshydraté', 211.00, 7.22, 18.50, 2.78, NULL, 'aides culinaires et ingrédients divers'),
	(195, 'Boisson concentrée à diluer, sans sucres ajoutés, avec édulcorants, type "sirop 0%"', 21.70, 0.50, 2.76, 0.50, NULL, 'eaux et autres boissons'),
	(196, 'Abat, cuit (aliment moyen)', 162.00, 25.10, 1.36, 6.24, NULL, 'viandes, œufs, poissons et assimilés'),
	(197, 'Lait de coco ou Crème de coco', 188.00, 1.77, 3.40, 18.40, NULL, 'eaux et autres boissons'),
	(198, 'Boeuf, bavette aloyau, grillée/poêlée', 162.00, 25.00, 0.00, 6.94, NULL, 'viandes, œufs, poissons et assimilés'),
	(199, 'Anguille, rôtie/cuite au four', 229.00, 23.60, 0.00, 15.00, NULL, 'viandes, œufs, poissons et assimilés'),
	(200, 'Huile ou graisse de coco (coprah), sans précision', 900.00, 0.00, 0.00, 100.00, NULL, 'matières grasses'),
	(201, 'Croque-monsieur, préemballé', 273.00, 11.30, 26.80, 12.90, NULL, 'entrées et plats composés'),
	(202, 'Porc, carré, cuit', 206.00, 34.10, 0.60, 7.45, NULL, 'viandes, œufs, poissons et assimilés'),
	(203, 'Crème dessert au chocolat, rayon frais', 130.00, 3.39, 19.90, 3.93, NULL, 'produits laitiers et assimilés'),
	(204, 'Chocolat, en tablette (aliment moyen)', 557.00, 7.81, 45.30, 36.10, NULL, 'produits sucrés'),
	(205, 'Pizza aux fruits de mer, préemballée', 200.00, 10.30, 24.60, 6.65, NULL, 'entrées et plats composés'),
	(206, 'Sandwich baguette, saumon fumé, beurre', 265.00, 11.50, 40.80, 5.60, NULL, 'entrées et plats composés'),
	(207, 'Feuilleté salé (aliment moyen)', 301.00, 8.39, 26.10, 17.80, NULL, 'entrées et plats composés'),
	(208, 'Veau, escalope panée, cuite', 271.00, 22.90, 12.60, 14.10, NULL, 'viandes, œufs, poissons et assimilés'),
	(209, 'Pâté ou terrine de campagne', 323.00, 15.50, 1.50, 28.20, NULL, 'viandes, œufs, poissons et assimilés'),
	(210, 'Pâtes fraîches farcies (ex : raviolis, tortellinis, ravioles du Dauphiné), au fromage, cuites', 226.00, 10.00, 26.80, 8.30, NULL, 'entrées et plats composés'),
	(211, 'Bar commun ou loup (Méditerranée), cru, sauvage', 97.90, 20.10, 0.00, 1.94, NULL, 'viandes, œufs, poissons et assimilés'),
	(212, 'Tarte à la tomate, préemballée', 218.00, 5.17, 19.30, 12.80, NULL, 'entrées et plats composés'),
	(213, 'Sandwich (aliment moyen)', 243.00, 14.20, 27.20, 8.35, NULL, 'entrées et plats composés'),
	(214, 'Poulet, filet, sans peau, sauté/poêlé, bio', 144.00, 31.10, 0.00, 1.80, NULL, 'viandes, œufs, poissons et assimilés'),
	(215, 'Bouillon de viande et légumes type pot-au-feu, dégraissé, déshydraté', 197.00, 10.80, 30.90, 3.10, NULL, 'aides culinaires et ingrédients divers'),
	(216, 'Soupe à la tomate et aux vermicelles, préemballée à réchauffer', 37.70, 1.10, 5.87, 0.80, NULL, 'entrées et plats composés'),
	(217, 'Rognon, agneau, braisé', 127.00, 23.70, 0.00, 3.62, NULL, 'viandes, œufs, poissons et assimilés'),
	(218, 'Fond de volaille pour sauces et cuisson, déshydraté', 341.00, 7.40, 66.30, 4.90, NULL, 'aides culinaires et ingrédients divers'),
	(219, 'Poulet', 190.00, 28.00, 0.00, 7.00, NULL, NULL),
	(220, 'Poulet', 190.00, 28.00, 0.00, 7.00, NULL, NULL),
	(221, 'Banane', 90.00, 1.00, 20.00, 1.00, NULL, 'fruits_legumes');

-- Listage de la structure de table nutrieat. articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url_image` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL,
  `date_publication` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table nutrieat.articles : ~7 rows (environ)
INSERT INTO `articles` (`id`, `titre`, `description`, `url_image`, `source`, `date_publication`) VALUES
	(14, 'Les super-aliments de l\'endurance : Nutrition clé pour les sportifs', 'Introduction\r\nL\'endurance est cruciale dans le monde du sport. Que vous soyez coureur de marathon, cycliste, ou nageur, votre alimentation joue un rôle primordial dans vos performances. Cet article explore les super-aliments qui peuvent améliorer l\'endurance et comment les intégrer dans votre régime.\r\n\r\nLes super-aliments de l\'endurance\r\n\r\nGraines de chia : Riches en oméga-3, en fibres et en protéines, elles sont idéales pour une libération d\'énergie prolongée.\r\nBaies de Goji : Connues pour leur capacité à améliorer l\'endurance et la récupération grâce à leur haute teneur en antioxydants.\r\nQuinoa : Un super aliment complet avec une bonne balance de tous les neuf acides aminés essentiels, parfait pour la récupération musculaire.\r\nÉpinards : Riches en nitrates, ils peuvent améliorer l\'efficacité de l\'oxygénation des muscles pendant l\'exercice.\r\nBananes : Une source idéale de glucides rapides et de potassium, essentiel pour éviter les crampes musculaires.\r\nIntégration dans votre régime\r\nL\'intégration de ces aliments dans votre alimentation n\'est pas compliquée. Par exemple, commencez votre journée avec un smoothie riche en protéines incluant des graines de chia et des baies de Goji. Après l\'entraînement, optez pour une salade de quinoa garnie d\'épinards et de tranches de banane pour une récupération musculaire optimale.\r\n\r\nConclusion\r\nLa clé d\'une performance d\'endurance optimale réside dans une alimentation équilibrée intégrant des super-aliments. Essayez de les incorporer dans votre alimentation quotidienne pour voir une amélioration notable de vos performances sportives.', 'img/660ad1bdec8c3.png', 'Etudes de nutrition sportive publiées dans des journaux réputés comme le Journal of the International Society of Sports Nutrition.', '2024-04-02'),
	(15, 'Hydratation et performance : L\'eau est-elle suffisante ?', 'Introduction\r\nL\'hydratation joue un rôle essentiel dans les performances sportives. Cet article examine si l\'eau seule est suffisante et explore les alternatives pour une hydratation optimale.\r\n\r\nL\'importance de l\'hydratation\r\nUne hydratation adéquate est cruciale pour maintenir la fonction musculaire, réguler la température corporelle, et faciliter la digestion. Pendant l\'exercice, le corps perd des fluides à travers la transpiration, ce qui peut mener à la déshydratation si ces fluides ne sont pas reconstitués.\r\n\r\nEau vs. Boissons énergétiques\r\n\r\nEau : Suffisante pour la plupart des activités de courte durée ou de faible intensité. Elle aide à reconstituer les fluides perdus sans ajouter de calories supplémentaires.\r\nBoissons énergétiques : Pour les entraînements de longue durée ou de haute intensité, ces boissons peuvent être bénéfiques car elles fournissent des électrolytes perdus dans la sueur et peuvent améliorer l\'absorption de l\'eau.\r\nQuand opter pour des boissons énergétiques\r\nSi votre activité dépasse 60 minutes ou se déroule dans des conditions très chaudes, intégrer une boisson énergétique peut aider à maintenir l\'équilibre électrolytique et à prévenir la déshydratation.\r\n\r\nConclusion\r\nL\'hydratation est personnalisable. Bien que l\'eau soit souvent suffisante, les boissons énergétiques ont leur place dans le régime d\'hydratation des athlètes, en particulier pendant l\'exercice prolongé ou intense.', 'img/660ad2a93f5ea.png', 'Interview des experts en diététique sportive et recommandations de l\'American College of Sports Medicine.', '2024-04-06'),
	(16, 'La récupération musculaire : Protéines et au-delà', 'Introduction\r\nLa récupération musculaire est un élément essentiel de tout programme d\'entraînement, permettant de maximiser les performances et de minimiser les risques de blessure. Cet article examine les stratégies nutritionnelles pour optimiser la récupération musculaire.\r\n\r\nNutriments clés pour la récupération\r\n- Protéines : Essentielles pour réparer et reconstruire les fibres musculaires endommagées lors de l\'exercice.\r\n- Acides aminés à chaîne ramifiée (BCAA) : Ils peuvent réduire la douleur musculaire et accélérer la récupération.\r\n- Glucides : Aident à reconstituer les réserves de glycogène musculaire, essentielles pour l\'énergie et la récupération.\r\n- Antioxydants et Oméga-3 : Diminuent l\'inflammation et améliorent la récupération musculaire.\r\n\r\nStratégies de récupération\r\n- Timing alimentaire : Consommer des protéines et des glucides dans les 30 minutes suivant l\'exercice peut améliorer la récupération musculaire.\r\n- Hydratation : Boire suffisamment d\'eau est crucial pour faciliter les processus de récupération.\r\n- Sommeil : La qualité et la quantité de sommeil affectent la récupération musculaire et la performance globale.\r\n\r\nConclusion\r\nLa récupération musculaire est multifactorielle, nécessitant une approche équilibrée de nutrition, d\'hydratation, et de repos. En prêtant attention à ces éléments, les sportifs peuvent améliorer leur récupération et leurs performances.', 'img/660ad5553e972.png', 'Analyse d\'articles scientifiques et d\'interviews avec des physiologistes du sport.', '2024-04-20'),
	(17, 'Les mythes de la nutrition sportive démystifiés', 'Introduction\r\nLa nutrition sportive est entourée de nombreux mythes et idées fausses. Cet article vise à démystifier certains des plus courants et à fournir des conseils basés sur des preuves.\r\n\r\nMythes courants\r\n- Mythe #1 : Plus de protéines = plus de muscles : Bien que les protéines soient essentielles, en consommer en excès n\'entraîne pas une croissance musculaire plus importante et peut stresser les reins.\r\n- Mythe #2 : Les régimes sans glucides améliorent les performances : Les glucides sont une source d\'énergie essentielle, et leur restriction peut compromettre la performance et la récupération.\r\n- Mythe #3 : Les suppléments sont nécessaires pour réussir : La plupart des besoins nutritionnels peuvent être satisfaits par une alimentation équilibrée. Certains suppléments peuvent être utiles, mais ils ne remplacent pas une bonne nutrition.\r\n\r\nDémystification\r\n- Équilibrer l\'apport en protéines : Adapter votre consommation de protéines à vos besoins réels et à votre niveau d\'activité.\r\n- Incorporer des glucides : Les glucides sont essentiels, surtout pour les athlètes d\'endurance. Ils ne doivent pas être éliminés de l\'alimentation.\r\n- Suppléments : Optez pour une alimentation riche et variée avant de vous tourner vers des suppléments. Consultez un professionnel pour une recommandation personnalisée.\r\n\r\nConclusion\r\nLa clé d\'une nutrition sportive réussie réside dans l\'équilibre et la modération. Comprendre et appliquer les principes de base de la nutrition peut vous aider à éviter les pièges des mythes courants.', 'img/660ad5dbd9ebd.png', 'Discussions avec des nutritionnistes sportifs certifiés et référence à des méta-analyses dans le domaine.', '2024-04-15'),
	(18, 'Planifier ses repas comme un pro : Conseils pour les sportifs occupés', 'Introduction\r\nPour les sportifs, trouver le temps de préparer des repas nutritifs peut être un défi. Cet article offre des conseils pratiques pour planifier et préparer à l\'avance des repas équilibrés.\r\n\r\nConseils pour la planification de repas\r\n- Planification hebdomadaire : Déterminez vos besoins en calories et macronutriments pour la semaine en fonction de votre programme d\'entraînement.\r\n- Préparation en masse : Cuisinez en grandes quantités et utilisez la congélation pour conserver la fraîcheur des aliments.\r\n- Snacks intelligents : Préparez des snacks nutritifs et portables pour éviter les choix alimentaires impulsifs et peu sains.\r\n\r\nOptimiser le temps en cuisine\r\n- Choisissez des recettes simples : Optez pour des repas faciles à préparer, nutritifs et savoureux.\r\n- Utilisez des appareils de cuisine : Les autocuiseurs et les slow cookers peuvent être des alliés précieux pour préparer des repas sains avec un minimum d\'effort.\r\n\r\nConclusion\r\nAvec une planification et une préparation adéquates, même les sportifs les plus occupés peuvent maintenir une alimentation équilibrée et propice à la performance. Prenez le temps chaque semaine pour planifier vos repas, et vous verrez une différence notable dans vos niveaux d\'énergie et vos performances.', 'img/660ad64477f01.png', 'Interviews avec des diététiciens spécialisés dans le sport et des chefs cuisiniers pour des conseils professionnels.', '2024-04-25'),
	(21, 'L\'Application NutriEat Arrive sur iOS et Android Fin 2024', 'Préparez-vous à transformer votre routine de bien-être avec NutriEat, l\'application innovante qui arrive sur iOS et Android à la fin de l\'année 2024. Conçue pour les amateurs de santé et de fitness, NutriEat offre une solution intégrée pour suivre votre consommation calorique et atteindre vos objectifs sportifs avec facilité et précision.\r\n\r\nQue vous soyez un athlète chevronné ou simplement quelqu\'un qui cherche à adopter un mode de vie plus sain, NutriEat est l\'outil idéal. Grâce à son interface intuitive, vous pourrez enregistrer vos repas, calculer les calories absorbées, et suivre vos progrès sportifs au fil du temps. La plateforme utilisera des algorithmes avancés pour fournir des recommandations personnalisées adaptées à vos besoins spécifiques en matière de nutrition et d\'exercice.\r\n\r\nEn plus de ses fonctionnalités robustes, NutriEat se distinguera par son engagement envers la précision et la facilité d\'utilisation. Les utilisateurs bénéficieront de mises à jour régulières qui amélioreront continuellement l\'expérience utilisateur et enrichiront les fonctionnalités de l\'application.\r\n\r\nMarquez vos calendriers pour la fin de 2024 et soyez prêts à télécharger NutriEat, disponible gratuitement sur l\'App Store d\'Apple et le Google Play Store. Prenez le contrôle de votre santé et de votre bien-être avec NutriEat, votre partenaire incontournable pour une vie plus saine et plus active !', 'img/662cd89e44c03.png', 'L\'équipe NutriEat', '2024-04-27'),
	(22, 'Inoxtag en Route pour l\'Everest: Une Aventure Entre Défis et Controverses', 'L\'essentiel\r\nLe 10 avril, Inoxtag, de son vrai nom Inès Benazzouz, prendra son envol pour le Népal avec l\'ambition de conquérir le mont Everest, malgré les controverses que son projet a suscitées. Ce jeune créateur de contenu de 22 ans, sans expérience préalable en alpinisme, s\'est lancé dans cette aventure il y a un an. Son guide, Mathis Dumas, assure que malgré le scepticisme, Inoxtag est prêt pour ce défi colossal.\r\n\r\nUne Préparation Intensive et Débat Environnemental\r\nInoxtag a annoncé son projet en février 2023, suscitant une vague de réactions parmi ses 7,5 millions d\'abonnés. Sa décision de gravir le point culminant du monde, l\'Everest à 8.848 mètres d\'altitude, est vue par certains comme un coup de publicité plutôt qu\'un véritable défi sportif. Cependant, sa préparation incluant des expéditions régulières dans les Alpes et l\'ascension de deux sommets himalayens, démontre un engagement sérieux envers son objectif.\r\n\r\nLe coût du projet, estimé entre 600 000 et 1,2 million d\'euros, soulève des questions éthiques et environnementales, surtout compte tenu de l\'impact écologique croissant sur l\'Everest. Mathis Dumas et Inoxtag se sont engagés à minimiser leur empreinte, insistant sur le fait que tous les déchets, y compris les excréments, seront redescendus de la montagne, respectant ainsi les normes environnementales strictes en vigueur.\r\n\r\nLes Risques et la Sécurité\r\nL\'Everest reste une montagne dangereuse, plus encore pour les amateurs. La préparation d\'Inoxtag a été intensive, mais les critiques pointent du doigt le risque accru pour les novices. Les embouteillages sur les voies d\'accès durant les périodes de mauvais temps ont été mortels par le passé, et 2023 a été particulièrement tragique pour les grimpeurs inexpérimentés. Mathis Dumas reconnaît la gravité des risques mais reste confiant dans les capacités de son protégé.\r\n\r\nPerspectives et Réflexions\r\nSelon les experts, bien que l\'ascension soit sécurisée avec des cordages et de l\'oxygène, le véritable défi pour Inoxtag ne sera pas tant physique que psychologique. La montagne offre une expérience qui transcende le simple fait de gravir ses pentes; elle teste les limites de l\'endurance humaine et de la volonté. Pour Charles Dubouloz, un alpiniste chevronné, l\'ascension d\'Inoxtag est "plus anecdotique que défi sportif", mettant en lumière la distinction entre les exploits virales et les véritables conquêtes alpines.\r\n\r\nConclusion\r\nAlors que la date de départ approche, Inoxtag se prépare à faire face à l\'un des défis les plus intimidants de sa vie. Le monde de l\'alpinisme et ses millions de followers attendront de voir si sa quête pour atteindre le sommet sera couronnée de succès ou s\'il s\'agira d\'une leçon apprise au prix fort. Quel que soit le résultat, l\'aventure d\'Inoxtag sur l\'Everest sera certainement un sujet de discussion brûlant et, peut-être, un moment déterminant dans sa vie.', 'img/662e0c1f5376d.png', 'Interview de l\'équipe d\'Inoxtag avant son départ', '2024-04-30');

-- Listage de la structure de table nutrieat. journalalimentaire
CREATE TABLE IF NOT EXISTS `journalalimentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `aliment_id` int DEFAULT NULL,
  `date` date NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `aliment_id` (`aliment_id`),
  CONSTRAINT `journalalimentaire_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `journalalimentaire_ibfk_2` FOREIGN KEY (`aliment_id`) REFERENCES `aliments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table nutrieat.journalalimentaire : ~1 rows (environ)
INSERT INTO `journalalimentaire` (`id`, `utilisateur_id`, `aliment_id`, `date`, `quantite`) VALUES
	(49, 1, 191, '2024-04-03', 50.00);

-- Listage de la structure de table nutrieat. messages_contact
CREATE TABLE IF NOT EXISTS `messages_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  `traite` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table nutrieat.messages_contact : ~1 rows (environ)
INSERT INTO `messages_contact` (`id`, `nom`, `email`, `sujet`, `message`, `date_envoi`, `traite`) VALUES
	(11, 'Eliott SICOT', 'eliott.sicot@outlook.fr', 'Demande de suppression', 'EEEEE', '2024-04-27 14:57:19', 1);

-- Listage de la structure de table nutrieat. utilisateurs
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `objectif_nutritionnel` enum('perte_de_poids','maintien','prise_de_masse') NOT NULL,
  `age` int DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL,
  `taille` decimal(5,2) DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  `role` varchar(10) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table nutrieat.utilisateurs : ~1 rows (environ)
INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `objectif_nutritionnel`, `age`, `sexe`, `taille`, `poids`, `role`) VALUES
	(1, 'Eliott', 'eliott.sicot@outlook.fr', '$2y$10$gRlmIKrUXJaqNSGNKjjWVu48iTFhhuZVepuiRvwmCVR14rug6YWD2', 'prise_de_masse', 19, 'Homme', 176.00, 76.00, 'admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
