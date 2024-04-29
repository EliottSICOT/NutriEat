<?php
session_start();

// Vérification de l'accès admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=NutriEat;charset=utf8', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// Récupération des demandes de contact
$stmt = $pdo->prepare("SELECT id, nom, email, sujet, message, date_envoi, traite FROM messages_contact ORDER BY date_envoi DESC");
$stmt->execute();
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes de Contact</title>
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
<div class="container mt-5">
<main class="container mt-5 pt-5">
    <h2>Demandes de contact</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date d'envoi</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['nom']) ?></td>
                <td><a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></td>
                <td><?= htmlspecialchars($row['sujet']) ?></td>
                <td><?= htmlspecialchars($row['message']) ?></td>
                <td><?= date("d/m/Y H:i", strtotime($row['date_envoi'])) ?></td>
                <td><?= $row['traite'] ? 'Traité' : 'Non traité' ?></td>
                <td>
                    <?php if (!$row['traite']): ?>
                    <a href="traiter_contact.php?id=<?= $row['id']; ?>" class="btn btn-info">Traiter</a>
                    <?php endif; ?>
                    <a href="supprimer_contact.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($messages)): ?>
            <tr>
                <td colspan="7">Aucune demande de contact trouvée.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</div>


<footer class="footer mt-5 bg-light">
    <div class="container text-center">
        <p class="mb-0">&copy; NutriEat 2024 | 
            <a href="../contact.php">Contactez-nous</a> | 
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
