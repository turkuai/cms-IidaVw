<?php
// config.php - Sisältää tietokantayhteyden parametrit

// Lataa .env tiedosto jos löytyy
if (file_exists('.env')) {
    foreach (parse_ini_file('.env') as $key => $value) {
        $_ENV[$key] = $value;
    }
    // Käytä .env arvoja
    $conn = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
} else {
    // Käytä XAMPP oletusarvoja jos .env puuttuu
    $conn = new mysqli("localhost", "root", "", "cms");
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Asetetaan merkistö UTF-8
$conn->set_charset("utf8");
?>