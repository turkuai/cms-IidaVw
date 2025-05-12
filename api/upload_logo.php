<?php
// Salli cross-origin-pyynnöt (kehitysympäristössä)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Tarkista että käytetään POST-metodia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tarkista että logo-teksti on saatu
    if (isset($_POST['logoText'])) {
        // Tallenna logo-teksti JSON-tiedostoon
        $logo_data = ["text" => $_POST['logoText']];
        $file_path = "../data/logo.json";
        file_put_contents($file_path, json_encode($logo_data));
        
        // Vastaa onnistuneesta tallennuksesta
        echo json_encode(["success" => true, "message" => "Logo text saved successfully"]);
    } else {
        // Vastaa puuttuvalla datalla
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Logo text is required"]);
    }
} else {
    // Vastaa virheellisellä HTTP-metodilla
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
}
?>