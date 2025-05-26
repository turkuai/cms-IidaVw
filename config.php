<?php
// config.php - Sisältää tietokantayhteyden parametrit
// HUOM: Tätä tiedostoa ei lisätä GitHubiin

// LISÄÄ TÄMÄ ALKUUN (ympäristömuuttujat)
if (file_exists('.env')) {
    foreach (parse_ini_file('.env') as $key => $value) {
        $_ENV[$key] = $value;
    }
    // Käytä .env:stä jos löytyy
    define('DB_SERVER', $_ENV['DB_HOST'] ?? 'localhost');
    define('DB_USERNAME', $_ENV['DB_USERNAME'] ?? 'root');
    define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
    define('DB_NAME', $_ENV['DB_NAME'] ?? 'cms');
} else {
    // Käytä oletusarvoja jos .env puuttuu
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'cms');
}

// Luodaan tietokantayhteys
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Tarkistetaan yhteys
if ($conn->connect_error) {
    die("Yhteysvirhe: " . $conn->connect_error);
}

// Asetetaan merkistö UTF-8
$conn->set_charset("utf8");
?>