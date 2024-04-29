<?php
session_start();

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=NutriEat;charset=utf8', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérification si l'utilisateur est connecté et a le rôle administrateur
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Récupération du rôle de l'utilisateur
$stmt = $pdo->prepare("SELECT role FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user === false || $user['role'] !== 'admin') {
    die('Accès refusé. Cette page est réservée aux administrateurs.');
}

// Gestion de l'upload et de l'ajout d'article si la méthode POST est utilisée
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['url_image']) && $_FILES['url_image']['error'] == 0) {
        if ($_FILES['url_image']['size'] <= 10000000) {
            $fileInfo = pathinfo($_FILES['url_image']['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

            if (in_array($extension, $allowedExtensions)) {
                $fileName = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['url_image']['tmp_name'], '../img/' . $fileName);
                $url_image = 'img/' . $fileName;
            } else {
                die('Erreur : Extension de fichier non autorisée.');
            }
        } else {
            die('Erreur : Fichier trop volumineux.');
        }
    }

    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $source = $_POST['source'];
    $date_publication = $_POST['date_publication'];

    $sql = "INSERT INTO articles (titre, description, url_image, source, date_publication) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $description, $url_image, $source, $date_publication]);

    echo '<p>L\'article a été ajouté avec succès.</p>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'un Article - NutriEat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">
            <img src="../img/logo-nutrieat.png" alt="NutriEat Logo" style="height: 30px;">
            NutriEat
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="panneau_admin.php">Panneau d'Administration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container mt-5 pt-5">
    <h2>Ajout d'un nouvel article</h2>
    <form action="ajout_article.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="url_image">Image de l'article</label>
            <input type="file" class="form-control-file" id="url_image" name="url_image" required>
        </div>
        <div class="form-group">
            <label for="source">Source</label>
            <input type="text" class="form-control" id="source" name="source">
        </div>
        <div class="form-group">
            <label for="date_publication">Date de publication</label>
            <input type="date" class="form-control" id="date_publication" name="date_publication" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'article</button>
    </form>
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

</body>
</html>
