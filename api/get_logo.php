<?php
// Salli cross-origin-pyynnöt (kehitysympäristössä)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Tarkista että käytetään GET-metodia
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $file_path = "../data/logo.json";
    
    // Tarkista että tiedosto on olemassa
    if (file_exists($file_path)) {
        // Lue ja palauta JSON-data
        $json_data = file_get_contents($file_path);
        echo $json_data;
    } else {
        // Palauta tyhjä oletus-logo jos tiedostoa ei ole
        echo json_encode(["text" => "LOGO"]);
    }
} else {
    // Vastaa virheellisellä HTTP-metodilla
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
}
?>