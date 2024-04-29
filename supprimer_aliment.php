<?php
session_start();

// S'assurer que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// S'assurer que l'ID de l'aliment et la date sont présents
if (isset($_GET['id']) && isset($_GET['date'])) {
    $aliment_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $date = $_GET['date'];

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "root", "NutriEat");
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Supprimer l'aliment spécifié pour l'utilisateur connecté
    $sql = "DELETE FROM journalalimentaire WHERE id = ? AND utilisateur_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $aliment_id, $user_id);
    if ($stmt->execute()) {
        // Redirection vers la page de détail avec un message de succès
        header("Location: detail_journee.php?date=$date&success=1");
    } else {
        // Gestion d'erreur
        echo "Erreur lors de la suppression de l'aliment.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirection ou message d'erreur si l'ID ou la date manque
    die('ID d\'aliment ou date manquante.');
}
?>
