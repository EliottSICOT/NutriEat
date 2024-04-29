<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Vérification et récupération sécurisée des paramètres GET
$aliment_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;

if (empty($aliment_id) || empty($date)) {
    die("ID d'aliment ou date manquante. Veuillez fournir les paramètres corrects.");
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "root", "NutriEat");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupération des détails de l'aliment à modifier
$sql = "SELECT aliments.nom, journalalimentaire.quantite, journalalimentaire.id
        FROM journalalimentaire
        INNER JOIN aliments ON journalalimentaire.aliment_id = aliments.id
        WHERE journalalimentaire.id = ? AND journalalimentaire.utilisateur_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $aliment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$aliment = $result->fetch_assoc();

if (!$aliment) {
    die("Aucun aliment trouvé avec cet ID.");
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantite_modifiee = $_POST['quantite'];

    $sql_update = "UPDATE journalalimentaire SET quantite = ? WHERE id = ? AND utilisateur_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $quantite_modifiee, $aliment_id, $user_id);

    if ($stmt_update->execute()) {
        header("Location: detail_journee.php?date=" . urlencode($date));
        exit;
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Quantité - NutriEat</title>
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

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <h2 class="h3 mb-3 font-weight-normal">Modifier la quantité</h2>
                <p>Aliment : <strong><?php echo htmlspecialchars($aliment['nom']); ?></strong> pour le <strong><?php echo htmlspecialchars($date); ?></strong></p>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="quantite">Quantité (en grammes):</label>
                            <input type="number" class="form-control" id="quantite" name="quantite" value="<?php echo htmlspecialchars($aliment['quantite']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
