<?php
session_start();

// Vérifier si l'utilisateur est connecté et définir $est_connecte en conséquence
$est_connecte = isset($_SESSION['user_id']);

if (!$est_connecte) {
    header('Location: connexion.php');
    exit;
}

$date = $_GET['date'] ?? die('Date non spécifiée.');
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "root", "NutriEat");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$sql = "SELECT journalalimentaire.id as journal_id, aliments.nom, journalalimentaire.quantite, 
               aliments.calories * journalalimentaire.quantite / 100 AS calories, 
               aliments.proteines * journalalimentaire.quantite / 100 AS proteines,
               aliments.glucides * journalalimentaire.quantite / 100 AS glucides,
               aliments.lipides * journalalimentaire.quantite / 100 AS lipides
        FROM journalalimentaire 
        INNER JOIN aliments ON journalalimentaire.aliment_id = aliments.id
        WHERE journalalimentaire.utilisateur_id = ? AND journalalimentaire.date = ?
        ORDER BY aliments.nom";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$aliments_consommes = [];
$totalCalories = $totalProteines = $totalGlucides = $totalLipides = 0;

while ($row = $result->fetch_assoc()) {
    $nom = $row['nom'];
    if (!isset($aliments_consommes[$nom])) {
        $aliments_consommes[$nom] = [
            'journal_id' => $row['journal_id'], // Ajout de cette ligne
            'quantite' => 0,
            'calories' => 0,
            'proteines' => 0,
            'glucides' => 0,
            'lipides' => 0
        ];
    }

    $aliments_consommes[$nom]['quantite'] += $row['quantite'];
    $aliments_consommes[$nom]['calories'] += $row['calories'];
    $aliments_consommes[$nom]['proteines'] += $row['proteines'];
    $aliments_consommes[$nom]['glucides'] += $row['glucides'];
    $aliments_consommes[$nom]['lipides'] += $row['lipides'];

    $totalCalories += $row['calories'];
    $totalProteines += $row['proteines'];
    $totalGlucides += $row['glucides'];
    $totalLipides += $row['lipides'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Alimentaire - Détails</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet">
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

<main class="container mt-5 pt-5">
    <h2 class="mb-4 text-center">Détails de la consommation pour le <?php echo htmlspecialchars($date); ?></h2>
    <div class="mb-3">
        <a href="journal_alimentaire.php" class="btn btn-secondary">Retour au journal alimentaire</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nom de l'Aliment</th>
                    <th>Quantité (g)</th>
                    <th>Calories (kcal)</th>
                    <th>Protéines (g)</th>
                    <th>Glucides (g)</th>
                    <th>Lipides (g)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aliments_consommes as $nom => $totals): ?>
                <tr>
                    <td><?php echo htmlspecialchars($nom); ?></td>
                    <td><?php echo htmlspecialchars($totals['quantite']); ?></td>
                    <td><?php echo round($totals['calories']); ?></td>
                    <td><?php echo round($totals['proteines']); ?> g</td>
                    <td><?php echo round($totals['glucides']); ?> g</td>
                    <td><?php echo round($totals['lipides']); ?> g</td>
                    <td>
                        <a href="modifier_quantite.php?id=<?php echo urlencode($aliments_consommes[$nom]['journal_id']); ?>&date=<?php echo urlencode($date); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="supprimer_aliment.php?id=<?php echo urlencode($totals['journal_id'] ?? ''); ?>&date=<?php echo urlencode($date); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet aliment ?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-info">
                    <th>Total Journée</th>
                    <th></th>
                    <th><?php echo round($totalCalories); ?> Cal</th>
                    <th><?php echo round($totalProteines); ?> g</th>
                    <th><?php echo round($totalGlucides); ?> g</th>
                    <th><?php echo round($totalLipides); ?> g</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
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
