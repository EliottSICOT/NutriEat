<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
$est_connecte = isset($_SESSION["user_id"]);
$nom_utilisateur = '';

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=NutriEat;charset=utf8', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Si l'utilisateur est connecté, récupérer son nom depuis la base de données
if ($est_connecte) {
    $stmt = $pdo->prepare("SELECT nom FROM utilisateurs WHERE id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $utilisateur = $stmt->fetch();
    if ($utilisateur) {
        $nom_utilisateur = $utilisateur['nom'];
    }
}

// Récupérer les 3 derniers articles
$articles = $pdo->query("SELECT id, titre, description, url_image FROM articles ORDER BY id DESC LIMIT 3")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriEat - Accueil</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <?php if (!$est_connecte): ?>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">Inscription</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="parametre.php">Paramètre du compte</a>
                </li>
                <li class="nav-item">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                    </form>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<header class="header">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/caroussel.png" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="img/caroussel-1.png" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="img/caroussel-2.png" class="d-block w-100" alt="Image 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>

<main class="container mt-4">
    <section class="row">
        <div class="col-lg-12">
            <h2>Bienvenue sur NutriEat <?php echo $nom_utilisateur; ?> !</h2>
            <p>Je suis Eliott SICOT, passionné de musculation et de nutrition. En parallèle de mon BTS, j'ai développé NutriEat, une plateforme dédiée à tous ceux qui, comme moi, cherchent à comprendre et à atteindre leurs objectifs nutritionnels. Que vous souhaitiez perdre du poids, maintenir un régime alimentaire équilibré, ou optimiser votre nutrition pour la musculation, NutriEat est là pour vous soutenir.</p>
        </div>
    </section>
    <section class="row mt-3">
        <div class="col-md-4">
            <h3>Un Besoin Personnel, Universel</h3>
            <p>NutriEat est né d'un besoin personnel, mais je sais que je ne suis pas le seul. Beaucoup d'entre nous cherchent à mieux comprendre leur alimentation et à soutenir leurs objectifs nutritionnels.</p>
        </div>
        <div class="col-md-4">
            <h3>Comprendre les Utilisateurs</h3>
            <p>En tant que développeur de NutriEat, je m'efforce de comprendre le besoin des utilisateurs pour leur offrir une expérience qui réponde vraiment à leurs attentes.</p>
        </div>
        <div class="col-md-4">
            <h3>Soutien aux Objectifs Nutritionnels</h3>
            <p>Peu importe votre objectif nutritionnel, NutriEat est conçu pour vous fournir les outils et les connaissances nécessaires pour vous soutenir sur votre chemin vers une meilleure santé.</p>
        </div>
    </section>
    <section class="text-center mt-4">
        <?php if ($est_connecte) : ?>
            <a href="dashboard.php" class="btn btn-secondary">Accède à ton tableau de bord</a>
        <?php else : ?>
            <a href="inscription.php" class="btn btn-secondary">Rejoignez NutriEat dès aujourd'hui</a>
        <?php endif; ?>
    </section>
    <h2 class="mt-5">Les Articles les Plus Récents sur NutriEat</h2>
    <div class="row">
    <?php foreach ($articles as $article): ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <!-- Afficher l'image de l'article -->
            <img src="<?= htmlspecialchars($article['url_image']); ?>" class="card-img-top" alt="Image de <?= htmlspecialchars($article['titre']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($article['titre']); ?></h5>
                <?php if ($est_connecte): ?>
                    <a href="article.php?id=<?= $article['id']; ?>" class="btn btn-info">Lire l'article</a>
                <?php else: ?>
                    <p>Pour lire la suite, <a href="connexion.php">connectez-vous</a> ou <a href="inscription.php">inscrivez-vous</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
    <?php if ($est_connecte): ?>
    <div class="row">
        <div class="col text-center mt-4">
            <a href="articles.php" class="btn btn-secondary">Voir plus d'articles</a>
        </div>
    </div>
    <?php endif; ?>
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
<script>
$(document).ready(function(){
    $('.carousel').carousel({
        interval: 2000
    });
});
</script>
</body>
</html>