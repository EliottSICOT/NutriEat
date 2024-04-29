<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "root", "NutriEat");

    // Vérifie la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Vérification des données du formulaire
    if (isset($_POST['nom'], $_POST['email'], $_POST['password'], $_POST['objectif'], $_POST['age'], $_POST['sexe'], $_POST['taille'], $_POST['poids'])) {
        // Récupération et nettoyage des données du formulaire
        $nom = $conn->real_escape_string($_POST['nom']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        
        // Vérification de l'existence de la valeur de l'objectif nutritionnel
        $objectif = isset($_POST['objectif']) ? $conn->real_escape_string($_POST['objectif']) : null;

        $age = (int) $_POST['age']; // Cast en entier pour s'assurer de la validité du type
        $sexe = $conn->real_escape_string($_POST['sexe']);
        $taille = (int) $_POST['taille']; // Cast en entier
        $poids = (int) $_POST['poids']; // Cast en entier

        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparation de la requête d'insertion avec des placeholders pour les valeurs à insérer
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, objectif_nutritionnel, age, sexe, taille, poids) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Liaison des paramètres (s = string, i = integer)
        $stmt->bind_param("ssssisii", $nom, $email, $hashed_password, $objectif, $age, $sexe, $taille, $poids);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Redirection vers la page de connexion après une inscription réussie
            header("Location: connexion.php");
            exit;
        } else {
            echo "Erreur lors de l'inscription: " . $stmt->error;
        }

        // Fermeture du statement
        $stmt->close();
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }

    // Fermeture de la connexion
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - NutriEat</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">Inscription</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-5">
    <h2>Inscription</h2>
        <form action="inscription.php" method="post">
            <div class="form-group">
                <label for="nom">Prénom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="objectif">Objectif nutritionnel :</label>
                <select class="form-control" id="objectif" name="objectif">
                    <option value="perte_de_poids">Perte de poids</option>
                    <option value="maintien">Maintien</option>
                    <option value="prise_de_masse">Prise de masse</option>
                </select>
            </div>
            <div class="form-group">
                <label for="age">Âge :</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="sexe">Sexe :</label>
                <select class="form-control" id="sexe" name="sexe">
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="taille">Taille (cm) :</label>
                <input type="number" class="form-control" id="taille" name="taille" step="1" required>
            </div>
            <div class="form-group">
                <label for="poids">Poids (kg) :</label>
                <input type="number" class="form-control" id="poids" name="poids" step="1" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
        <p class="mt-3">Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
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
