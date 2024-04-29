<?php
// Démarrage de la session et connexion à la base de données
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=NutriEat;charset=utf8', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté
$est_connecte = isset($_SESSION["user_id"]);

// Récupération de l'ID de l'article depuis l'URL
$idArticle = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Récupération de l'article depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$idArticle]);
$article = $stmt->fetch();

if (!$article) {
    die('Article non trouvé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['titre']); ?> | NutriEat</title>
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
                        <a class="nav-link" href="dashboard.php">Tableau de bord</a>
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
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mt-4"><?= htmlspecialchars($article['titre']); ?></h1>
            <!-- Ajout de la date de publication et de la source ici -->
            <p class="lead">
                Publié le <?= date("d/m/Y", strtotime($article['date_publication'])); ?>
                <?php if (!empty($article['source'])): ?>
                    | Source: <?= htmlspecialchars($article['source']); ?>
                <?php endif; ?>
            </p>
            <img src="<?= htmlspecialchars($article['url_image']); ?>" class="img-fluid my-4" alt="<?= htmlspecialchars($article['titre']); ?>">
            <p><?= nl2br(htmlspecialchars($article['description'])); ?></p>
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
