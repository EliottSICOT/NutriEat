<?php
session_start();

// Vérifier si l'utilisateur est connecté et définir $est_connecte en conséquence
$est_connecte = isset($_SESSION['user_id']);

if (!$est_connecte) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "root", "NutriEat");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$sql = "SELECT nom, objectif_nutritionnel, poids, taille, sexe, age FROM utilisateurs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom_utilisateur = $row['nom'];
    $objectif_nutritionnel = $row['objectif_nutritionnel'];
    $poids = $row['poids'];
    $taille = $row['taille']; // Taille en cm
    $sexe = $row['sexe'];
    $age = $row['age'];
} else {
    die("Utilisateur non trouvé.");
}

$stmt->close();

// Conversion de la taille en mètres pour le calcul
$taille = $taille / 100;

// Calcul du métabolisme basal avec la formule de Mifflin-St Jeor
if ($sexe == 'homme') {
    $mb = (10 * $poids) + (6.25 * $taille * 100) - (5 * $age) + 5;
} else { // femme
    $mb = (10 * $poids) + (6.25 * $taille * 100) - (5 * $age) - 161;
}

// Ajustement des calories selon l'objectif
switch ($objectif_nutritionnel) {
    case 'prise_de_masse':
        $calories = $mb * 1.15;
        $objectif_nutritionnel_text = "Prise de masse";
        break;
    case 'maintien':
        $calories = $mb;
        $objectif_nutritionnel_text = "Maintien";
        break;
    case 'perte_de_poids':
        $calories = $mb * 0.85;
        $objectif_nutritionnel_text = "Perte de poids";
        break;
    default:
        $calories = "Aucun objectif nutritionnel défini";
        $objectif_nutritionnel_text = $calories;
        break;
}

// Requête pour obtenir les données du dernier jour d'activité alimentaire de l'utilisateur
$sql_derniere_activite = "SELECT date, 
                          SUM(aliments.calories * journalalimentaire.quantite / 100) AS calories_totales,
                          SUM(aliments.proteines * journalalimentaire.quantite / 100) AS proteines_totales,
                          SUM(aliments.glucides * journalalimentaire.quantite / 100) AS glucides_totales,
                          SUM(aliments.lipides * journalalimentaire.quantite / 100) AS lipides_totales
                          FROM journalalimentaire
                          INNER JOIN aliments ON journalalimentaire.aliment_id = aliments.id
                          WHERE journalalimentaire.utilisateur_id = ?
                          GROUP BY date
                          ORDER BY date DESC
                          LIMIT 1";
$stmt_derniere_activite = $conn->prepare($sql_derniere_activite);
$stmt_derniere_activite->bind_param("i", $user_id);
$stmt_derniere_activite->execute();
$result_derniere_activite = $stmt_derniere_activite->get_result();

$derniere_activite = null;
if ($result_derniere_activite->num_rows > 0) {
    $derniere_activite = $result_derniere_activite->fetch_assoc();
}

$stmt_derniere_activite->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo-nutrieat.png" alt="NutriEat Logo" style="height: 30px;">
            NutriEat
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <?php if ($est_connecte): ?>
                <li class="nav-item">
                    <a class="nav-link" href="parametre.php">Paramètre du compte</a>
                </li>
                <li class="nav-item">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                    </form>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">Inscription</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<header class="header">
    <div class="container">
        <h1 class="text-center">Bonjour, <?php echo htmlspecialchars($nom_utilisateur); ?></h1>
    </div>
</header>

<div class="container mt-3">
    <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
</div>

<main class="container mt-4">
    <section class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Objectifs Nutritionnels</h2>
                    <?php
                    echo "<p>Ton métabolisme basal est de " . round($mb) . " kcal.</p>";
                    if (is_numeric($calories)) {
                        echo "<p>Pour ton objectif de <strong>$objectif_nutritionnel_text</strong>, tu devrais consommer environ <strong>" . round($calories) . " kcal</strong> par jour.</p>";
                    } else {
                        echo "<p>$objectif_nutritionnel_text</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Activité Récente</h2>
                    <?php if ($derniere_activite): ?>
                        <?php
                        // Définition de la locale en français
                        setlocale(LC_TIME, 'fr_FR', 'french');

                        // Conversion de la chaîne de date en objet DateTime
                        $dateObj = DateTime::createFromFormat('Y-m-d', $derniere_activite['date']);

                        // Tableau pour la traduction des mois
                        $mois = ['January' => 'janvier', 'February' => 'février', 'March' => 'mars', 'April' => 'avril', 'May' => 'mai', 'June' => 'juin', 'July' => 'juillet', 'August' => 'août', 'September' => 'septembre', 'October' => 'octobre', 'November' => 'novembre', 'December' => 'décembre'];

                        // Formatage de la date
                        $formattedDate = $dateObj->format('j F Y');
                        
                        // Traduction du mois
                        foreach ($mois as $en => $fr) {
                            $formattedDate = str_replace($en, $fr, $formattedDate);
                        }
                        ?>
                        <p>Le <strong><?php echo $formattedDate; ?></strong>, tu as consommé :</p>
                        <ul>
                            <li><strong>Calories Totales :</strong> <?php echo round($derniere_activite['calories_totales']); ?> Cal</li>
                            <li><strong>Protéines Totales :</strong> <?php echo round($derniere_activite['proteines_totales']); ?> g</li>
                            <li><strong>Glucides Totales :</strong> <?php echo round($derniere_activite['glucides_totales']); ?> g</li>
                            <li><strong>Lipides Totales :</strong> <?php echo round($derniere_activite['lipides_totales']); ?> g</li>
                        </ul>
                    <?php else: ?>
                        <p>Aucune activité récente enregistrée.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="row">
        <div class="col-lg-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Journal Alimentaire</h2>
                    <a href="journal_alimentaire.php" class="btn btn-success">Accéder au Journal</a>
                </div>
            </div>
        </div>
    </section>
    <section class="row mt-4">
        <div class="col-lg-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Modifier Objectifs</h2>
                    <a href="modifier_objectifs.php" class="btn btn-warning">Modifier les Objectifs</a>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer mt-5 bg-light">
    <div class="container text-center">
        <p class="mb-0">&copy; NutriEat 2024 | 
            <a href="contact.php">Contactez-nous</a> | 
            <a href="mentions_legales.html">Mentions Légales</a>
        </p>
        <p>Suivez-nous sur <a href="https://www.instagram.com/nutrieat_app/" target="_blank" rel="noopener noreferrer">Instagram</a></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
