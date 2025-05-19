<?php
// api.php - Käsittelee AJAX-pyynnöt tietokantaan

// Sisällytetään tietokantafunktiot
require_once 'database.php';

// Asetetaan vastausformaatti JSON:ksi
header('Content-Type: application/json');

// Tarkistetaan pyynnön tyyppi
$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    // Linkkien toiminnot
    case 'getLinks':
        echo json_encode(getAllLinks());
        break;
        
    case 'addLink':
        $displayText = isset($_POST['displayText']) ? $_POST['displayText'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        
        $result = addLink($displayText, $url);
        echo json_encode(['success' => $result !== false, 'id' => $result]);
        break;
        
    case 'updateLink':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $displayText = isset($_POST['displayText']) ? $_POST['displayText'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        
        $result = updateLink($id, $displayText, $url);
        echo json_encode(['success' => $result]);
        break;
        
    case 'deleteLink':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        
        $result = deleteLink($id);
        echo json_encode(['success' => $result]);
        break;
        
    // Sivuosien toiminnot
    case 'getSections':
        echo json_encode(getAllSections());
        break;
        
    case 'addSection':
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : null;
        
        $result = addSection($title, $content, $imageUrl);
        echo json_encode(['success' => $result !== false, 'id' => $result]);
        break;
        
    case 'updateSection':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : null;
        
        $result = updateSection($id, $title, $content, $imageUrl);
        echo json_encode(['success' => $result]);
        break;
        
    case 'deleteSection':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        
        $result = deleteSection($id);
        echo json_encode(['success' => $result]);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
}
?>