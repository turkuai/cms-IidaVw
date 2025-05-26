<?php
// config.php - Sisältää tietokantayhteyden parametrit
// HUOM: Tätä tiedostoa ei lisätä GitHubiin

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');  // Paikallinen kehitys XAMPP:lla
define('DB_PASSWORD', '');      // Paikallinen kehitys XAMPP:lla
define('DB_NAME', 'cms');

// Luodaan tietokantayhteys
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Tarkistetaan yhteys
if ($conn->connect_error) {
    die("Yhteysvirhe: " . $conn->connect_error);
}

// Asetetaan merkistö UTF-8
$conn->set_charset("utf8");
?>