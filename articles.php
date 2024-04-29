<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "root", "NutriEat");

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Déterminer l'ordre de tri
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC';
$toggleOrder = $order === 'ASC' ? 'desc' : 'asc';

// Requête pour sélectionner tous les articles avec tri
$sql = "SELECT * FROM articles ORDER BY date_publication $order";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
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
                    <a class="nav-link" href="dashboard.php">Tableau de Bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="header">
    <div class="container">
        <h1 class="text-center">Articles</h1>
        <p class="text-center">Découvrez nos articles dédiés à la nutrition et au sport. Vous trouverez ici des conseils pratiques, des informations sur les dernières tendances en matière de santé et des mises à jour sur notre application NutriEat.</p>
        <div class="text-center">
            <a href="?order=<?php echo $toggleOrder; ?>" class="btn btn-info">Trier par date <?php echo $toggleOrder === 'asc' ? 'croissante' : 'décroissante'; ?></a>
        </div>
    </div>
</header>


<main class="container mt-4">
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="<?php echo $row['url_image']; ?>" alt="<?php echo htmlspecialchars($row['titre']); ?>">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlspecialchars($row['titre']); ?></h4>
                            <p class="card-text"><small class="text-muted">Publié le <?php echo date("d/m/Y", strtotime($row['date_publication'])); ?></small></p>
                            <p class="card-text"><small class="text-muted">Source : <?php echo htmlspecialchars($row['source']); ?></small></p>
                        </div>
                        <div class="card-footer">
                            <a href="article.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">Lire l'article</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Aucun article trouvé.</p>";
        }
        ?>
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
