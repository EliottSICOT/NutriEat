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

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $calories = $_POST['calories'];
    $proteines = $_POST['proteines'];
    $glucides = $_POST['glucides'];
    $lipides = $_POST['lipides'];
    $categorie = $_POST['categorie']; // Récupération de la catégorie depuis le formulaire

    // Préparation de la requête d'insertion
    $sql = "INSERT INTO aliments (nom, calories, proteines, glucides, lipides, categorie) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $calories, $proteines, $glucides, $lipides, $categorie]);

    echo '<p>L\'aliment a été ajouté avec succès.</p>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'un Aliment - NutriEat</title>
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
    <h2>Ajout d'un nouvel aliment</h2>
    <form action="ajout_aliment.php" method="post">
        <div class="form-group">
            <label for="nom">Nom de l'aliment</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="calories">Calories (par 100g)</label>
            <input type="number" class="form-control" id="calories" name="calories" required>
        </div>
        <div class="form-group">
            <label for="proteines">Protéines (par 100g)</label>
            <input type="number" class="form-control" id="proteines" name="proteines" required>
        </div>
        <div class="form-group">
            <label for="glucides">Glucides (par 100g)</label>
            <input type="number" class="form-control" id="glucides" name="glucides" required>
        </div>
        <div class="form-group">
            <label for="lipides">Lipides (par 100g)</label>
            <input type="number" class="form-control" id="lipides" name="lipides" required>
        </div>
        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select class="form-control" id="categorie" name="categorie">
                <option value="fruits_legumes">Fruits et légumes</option>
                <option value="viandes_poissons">Viandes et poissons</option>
                <option value="produits_laitiers">Produits laitiers</option>
                <option value="boissons">Boissons</option>
                <option value="cereales">Céréales et dérivés</option>
                <option value="snacks_sucres">Snacks sucrés</option>
                <option value="aliments_gras">Aliments gras et huiles</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'aliment</button>
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
