<?php
// database.php - Sisältää tietokantafunktiot

// Sisällytetään config.php tiedosto (tietokantayhteys)
require_once 'config.php';

// Linkkien CRUD-funktiot
function getAllLinks() {
    global $conn;
    $sql = "SELECT * FROM links ORDER BY id";
    $result = $conn->query($sql);
    
    $links = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $links[] = $row;
        }
    }
    
    return $links;
}

function getLinkById($id) {
    global $conn;
    
    $id = (int)$id;
    $sql = "SELECT * FROM links WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

function addLink($displayText, $url) {
    global $conn;
    
    $displayText = $conn->real_escape_string($displayText);
    $url = $conn->real_escape_string($url);
    
    $sql = "INSERT INTO links (display_text, url) VALUES ('$displayText', '$url')";
    
    if ($conn->query($sql) === TRUE) {
        return $conn->insert_id;
    } else {
        return false;
    }
}

function updateLink($id, $displayText, $url) {
    global $conn;
    
    $id = (int)$id;
    $displayText = $conn->real_escape_string($displayText);
    $url = $conn->real_escape_string($url);
    
    $sql = "UPDATE links SET display_text='$displayText', url='$url' WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}

function deleteLink($id) {
    global $conn;
    
    $id = (int)$id;
    $sql = "DELETE FROM links WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}

// Sivuosien CRUD-funktiot
function getAllSections() {
    global $conn;
    $sql = "SELECT * FROM sections ORDER BY id";
    $result = $conn->query($sql);
    
    $sections = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sections[] = $row;
        }
    }
    
    return $sections;
}

function getSectionById($id) {
    global $conn;
    
    $id = (int)$id;
    $sql = "SELECT * FROM sections WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

function addSection($title, $content, $imageUrl = null) {
    global $conn;
    
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $imageUrl = $imageUrl ? $conn->real_escape_string($imageUrl) : null;
    
    $sql = "INSERT INTO sections (title, content, image_url) VALUES ('$title', '$content', " . ($imageUrl ? "'$imageUrl'" : "NULL") . ")";
    
    if ($conn->query($sql) === TRUE) {
        return $conn->insert_id;
    } else {
        return false;
    }
}

function updateSection($id, $title, $content, $imageUrl = null) {
    global $conn;
    
    $id = (int)$id;
    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $imageUrl = $imageUrl ? $conn->real_escape_string($imageUrl) : null;
    
    $sql = "UPDATE sections SET title='$title', content='$content', image_url=" . ($imageUrl ? "'$imageUrl'" : "NULL") . " WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}

function updateSectionTitle($id, $title) {
    global $conn;
    
    $id = (int)$id;
    $title = $conn->real_escape_string($title);
    
    $sql = "UPDATE sections SET title='$title' WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}

function updateSectionContent($id, $content) {
    global $conn;
    
    $id = (int)$id;
    $content = $conn->real_escape_string($content);
    
    $sql = "UPDATE sections SET content='$content' WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}

function updateSectionImage($id, $imageUrl) {
    global $conn;
    
    $id = (int)$id;
    $imageUrl = $conn->real_escape_string($imageUrl);
    
    $sql = "UPDATE sections SET image_url='$imageUrl' WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}

function deleteSection($id) {
    global $conn;
    
    $id = (int)$id;
    $sql = "DELETE FROM sections WHERE id=$id";
    
    return $conn->query($sql) === TRUE;
}
?>