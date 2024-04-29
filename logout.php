<?php
// Démarrer une session
session_start();

// Détruire toutes les données de session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion
header("location: connexion.php");
exit;
?>
