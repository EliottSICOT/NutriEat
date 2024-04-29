<?php
session_start();

// Redirige si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "root", "NutriEat");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['objectif'])) {
    $objectif = $_POST['objectif'];
    // Préparer la requête pour mettre à jour l'objectif
    $stmt = $conn->prepare("UPDATE utilisateurs SET objectif_nutritionnel = ? WHERE id = ?");
    $stmt->bind_param("si", $objectif, $user_id);

    if ($stmt->execute()) {
        // Redirection ou affichage d'un message de succès
        echo "<script>alert('Objectif mis à jour avec succès.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Erreur lors de la mise à jour de l'objectif.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Objectif Nutritionnel</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Tableau de Bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-5 pt-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h2 class="mb-4">Modifier Objectif Nutritionnel</h2>
            <form action="modifier_objectifs.php" method="post">
                <div class="form-group">
                    <label for="objectif">Choisissez votre objectif nutritionnel :</label>
                    <select class="form-control" id="objectif" name="objectif">
                        <option value="perte_de_poids">Perte de poids</option>
                        <option value="maintien">Maintien</option>
                        <option value="prise_de_masse">Prise de masse</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Mettre à jour l'objectif</button>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-4">
            <div class="card">
                <img src="img/perte_de_poids.png" class="card-img-top" alt="Perte de poids">
                <div class="card-body">
                    <h5 class="card-title">Perte de poids</h5>
                    <p class="card-text">Réduisez votre apport calorique tout en maintenant une alimentation équilibrée pour atteindre une perte de poids saine.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="img/maintien.png" class="card-img-top" alt="Maintien">
                <div class="card-body">
                    <h5 class="card-title">Maintien</h5>
                    <p class="card-text">Gardez votre poids actuel en équilibrant les calories consommées avec celles brûlées.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="img/prise_de_masse.png" class="card-img-top" alt="Prise de masse">
                <div class="card-body">
                    <h5 class="card-title">Prise de masse</h5>
                    <p class="card-text">Augmentez votre apport calorique et associez-le à un entraînement intensif pour gagner de la masse musculaire.</p>
                </div>
            </div>
        </div>
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