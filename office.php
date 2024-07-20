
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$UtilisateurNom = filter_input(INPUT_POST, 'UtilisateurNom', FILTER_SANITIZE_STRING);
$UtilisateurGmail = filter_input(INPUT_POST, 'UtilisateurGmail', FILTER_SANITIZE_EMAIL);

if (!empty($UtilisateurNom)) {
    if (!empty($UtilisateurGmail)) {
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "office";

        // Create connection
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die('Connection Error ('.$conn->connect_errno.') '.$conn->connect_error);
        } else {
            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO newsletter (UtilisateurNom, UtilisateurGmail) VALUES ('$UtilisateurNom', '$UtilisateurGmail')");
            $stmt->bind_param("ss", $UtilisateurNom, $UtilisateurGmail);

            if ($stmt->execute()) {
                echo "New record inserted successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Email should not be empty";
        die();
    }
} else {
    echo "Username should not be empty";
    die();
}
?>