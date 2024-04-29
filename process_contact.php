<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "nutrieat";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        function clean_input($data) {
          return htmlspecialchars(stripslashes(trim($data)));
        }

        $nom = clean_input($_POST['name'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $sujet = clean_input($_POST['subject'] ?? '');
        $message = clean_input($_POST['message'] ?? '');

        $stmt = $conn->prepare("INSERT INTO messages_contact (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sujet', $sujet);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            header("Location: contact.php?status=success");
            exit;
        } else {
            echo "Une erreur s'est produite lors de l'envoi du message.";
        }
    }
}
catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null;
?>
