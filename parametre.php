<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "root", "NutriEat");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupération des informations de l'utilisateur et de son rôle
$sql = "SELECT nom, email, role FROM utilisateurs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres du Compte - NutriEat</title>
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
                    <a class="nav-link" href="parametre.php">Paramètre du compte</a>
                </li>
                <li class="nav-item">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <h2 class="text-center mb-4">Paramètres du Compte</h2>
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Données du compte</h4>
                        <p class="card-text"><strong>Nom :</strong> <?php echo htmlspecialchars($user_info['nom']); ?></p>
                        <p class="card-text"><strong>Email :</strong> <?php echo htmlspecialchars($user_info['email']); ?></p>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="modifier_mot_de_passe.php" class="btn btn-primary">Modifier le mot de passe</a>
                            <a href="supprimer_compte.php" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">Supprimer le compte</a>
                            <?php if ($user_info['role'] === 'admin'): ?>
                                <a href="admin/panneau_admin.php" class="btn btn-info">Panneau administrateur</a>
                            <?php endif; ?>
                        </div>
                    </div>
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
