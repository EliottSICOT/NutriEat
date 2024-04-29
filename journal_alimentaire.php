<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$aliments_consommes = array();

$conn = new mysqli("localhost", "root", "root", "NutriEat");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Traitement du formulaire d'ajout d'aliment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['aliment_id'], $_POST['quantite'], $_POST['date'])) {
    $aliment_id = $_POST['aliment_id'];
    $quantite = $_POST['quantite'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO journalalimentaire (utilisateur_id, aliment_id, quantite, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $aliment_id, $quantite, $date);
    if ($stmt->execute()) {
        echo "<p>Aliment ajouté avec succès.</p>";
    } else {
        echo "<p>Erreur lors de l'ajout de l'aliment : " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Requête pour récupérer les aliments consommés
$sql_select = "SELECT journalalimentaire.date,
                      SUM(aliments.calories * journalalimentaire.quantite / 100) AS calories_totales,
                      SUM(aliments.proteines * journalalimentaire.quantite / 100) AS proteines_totales,
                      SUM(aliments.glucides * journalalimentaire.quantite / 100) AS glucides_totales,
                      SUM(aliments.lipides * journalalimentaire.quantite / 100) AS lipides_totales
               FROM journalalimentaire
               INNER JOIN aliments ON journalalimentaire.aliment_id = aliments.id
               WHERE journalalimentaire.utilisateur_id = ?
               GROUP BY journalalimentaire.date
               ORDER BY journalalimentaire.date DESC";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $user_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();

while ($row = $result_select->fetch_assoc()) {
    $aliments_consommes[] = $row;
}
$stmt_select->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Alimentaire</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet">
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
        <h1 class="text-center">Journal Alimentaire</h1>
    </div>
</header>

<div class="container mt-3">
    <a href="dashboard.php" class="btn btn-secondary">Retour au tableau de bord</a>
</div>

<main class="container mt-4">
    <section class="mb-5">
        <h2 class="mb-3">Aliments Consommés</h2>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Calories Totales</th>
                        <th>Protéines Totales (g)</th>
                        <th>Glucides Totales (g)</th>
                        <th>Lipides Totales (g)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aliments_consommes as $jour): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($jour['date']); ?></td>
                        <td><?php echo round($jour['calories_totales']); ?> Cal</td>
                        <td><?php echo round($jour['proteines_totales']); ?> g</td>
                        <td><?php echo round($jour['glucides_totales']); ?> g</td>
                        <td><?php echo round($jour['lipides_totales']); ?> g</td>
                        <td>
                            <a href="detail_journee.php?date=<?php echo urlencode($jour['date']); ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <section class="mb-5">
        <h2 class="mb-3">Ajouter un Aliment</h2>
        <div class="card">
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="aliment_id">Aliment:</label>
                        <select name="aliment_id" id="aliment_id" class="form-control select2" required>
                            <option value="" selected disabled>Sélectionner un aliment</option>
                            <?php
                            // Réouverture de la connexion à la base de données nécessaire pour cette section
                            $conn = new mysqli("localhost", "root", "root", "NutriEat");
                            if ($conn->connect_error) {
                                die("Connexion échouée : " . $conn->connect_error);
                            }
                            // Requête pour récupérer les aliments
                            $sql_aliments = "SELECT id, nom FROM aliments ORDER BY nom ASC";
                            $result_aliments = $conn->query($sql_aliments);
                            if ($result_aliments->num_rows > 0) {
                                while ($row_aliment = $result_aliments->fetch_assoc()) {
                                    echo "<option value='" . $row_aliment['id'] . "'>" . htmlspecialchars($row_aliment['nom']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Aucun aliment disponible</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantite">Quantité (en grammes) :</label>
                        <input type="number" name="quantite" id="quantite" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </form>
            </div>
        </div>
    </section>
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
<script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#aliment_id').select2({
            placeholder: "Sélectionner un aliment",
            allowClear: true
        });
    });
</script>
</body>
</html>
