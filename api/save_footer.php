<?php
// Salli cross-origin-pyynnöt (kehitysympäristössä)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Tarkista että käytetään POST-metodia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hae JSON-data pyynnöstä
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    
    // Tarkista että data on validia
    if (json_last_error() === JSON_ERROR_NONE) {
        // Tallenna footer-data JSON-tiedostoon
        $file_path = "../data/footer.json";
        file_put_contents($file_path, $json_data);
        
        // Vastaa onnistuneesta tallennuksesta
        echo json_encode(["success" => true, "message" => "Footer data saved successfully"]);
    } else {
        // Vastaa JSON-virheellä
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid JSON data"]);
    }
} else {
    // Vastaa virheellisellä HTTP-metodilla
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
}
?>