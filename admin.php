<?php
// Aloita sessio heti tiedoston alussa
session_start();

// Sisällytetään tietokantafunktiot
require_once 'database.php';

// Funktio mallipohjan tarkistamiseen
function checkArticleTemplate($title) {
    $titleLower = strtolower(trim($title));
    
    // Sunny-mallipohja
    if (strpos($titleLower, "sunny") !== false || 
        strpos($titleLower, "golden ray") !== false || 
        strpos($titleLower, "meet sunny") !== false) {
        
        // Tarkista onko vastaavaa artikkelia jo olemassa
        $existingSections = getAllSections();
        $exists = false;
        foreach ($existingSections as $section) {
            if (strpos(strtolower($section['title']), "sunny") !== false || 
                strpos(strtolower($section['title']), "golden ray") !== false) {
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            return [
                'title' => 'Meet Sunny – A Golden Ray of Joy!',
                'content' => '<p>
                  <strong>Name:</strong> Sunny<br>
                  <strong>Breed:</strong> Golden Retriever<br>
                  <strong>Color:</strong> Golden<br>
                  <strong>Age:</strong> 4 months<br>
                  <strong>Gender:</strong> Female
                </p>
                <p>
                  Sunny is a playful and affectionate Golden Retriever puppy with a heart full of love and endless puppy energy. 
                  She loves chasing balls, making new friends, and cuddling up for naps after playtime.
                </p>
                <p>
                  With her soft golden fur and sweet eyes, she\'ll steal your heart in seconds! Sunny is very social, eager to learn, 
                  and responds well to positive training.
                </p>
                <p>
                  She\'s great with kids, other dogs, and would thrive in an active home where she can explore, play, and grow into 
                  the loyal companion she\'s meant to be.
                </p>
                <p>
                  Sunny is up to date on her vaccinations and is learning fast with house training.
                </p>
                <p>
                  👉 Think Sunny might be your perfect match? Apply now to adopt and give her the loving home she deserves!
                </p>',
                'image_url' => 'images/dog1.jpg',
                'imageAlt' => 'Cute dog',
                'imageWidth' => 200,
                'imageHeight' => 'auto',
                'imageAlignment' => 'center',
                'message' => 'Sunny-mallipohja tunnistettu! Artikkeli täytetty alkuperäisellä Sunny-sisällöllä.'
            ];
        }
    }
    
    // Pumpkin-mallipohja
    else if (strpos($titleLower, "pumpkin") !== false || 
             strpos($titleLower, "furry friend") !== false || 
             strpos($titleLower, "meet pumpkin") !== false) {
        
        // Tarkista onko vastaavaa artikkelia jo olemassa
        $existingSections = getAllSections();
        $exists = false;
        foreach ($existingSections as $section) {
            if (strpos(strtolower($section['title']), "pumpkin") !== false || 
                strpos(strtolower($section['title']), "furry friend") !== false) {
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            return [
                'title' => 'Meet Pumpkin – Your Future Furry Friend!',
                'content' => '<p>
                  <strong>Name:</strong> Pumpkin<br>
                  <strong>Breed:</strong> Domestic Longhair<br>
                  <strong>Color:</strong> Orange<br>
                  <strong>Age:</strong> 3 years<br>
                  <strong>Gender:</strong> Male
                </p>
                <p>
                  Pumpkin is a sweet and curious orange cat with striking green eyes and a fluffy coat. 
                  He loves to lounge on soft rugs and quietly observe the world around him.
                </p>
                <p>
                  Pumpkin has a gentle personality and enjoys both quiet cuddle time and playful pouncing with his toys.
                </p>
                <p>
                  He gets along well with people and would be a perfect match for a calm home where he can feel safe and loved.
                </p>
                <p>
                  Pumpkin is neutered, vaccinated, and litter trained—ready to join his forever family!
                </p>
                <p>
                  👉 Ready to adopt Pumpkin? Fill out an application on our website and give this lovable cat the home he deserves.
                </p>',
                'image_url' => 'images/cat1.jpg',
                'imageAlt' => 'Cute cat',
                'imageWidth' => 200,
                'imageHeight' => 'auto',
                'imageAlignment' => 'center',
                'message' => 'Pumpkin-mallipohja tunnistettu! Artikkeli täytetty alkuperäisellä Pumpkin-sisällöllä.'
            ];
        }
    }
    
    // Ei tunnistettu mallipohjaa
    return null;
}

// Määrittele simplifioidut header ja footer -funktiot
function displayHeader() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>CMS Admin</title>
      <link rel="stylesheet" href="styles.css"/>
      <style>
        /* Added styles for image container */
        .article-image {
          display: flex;
          flex-direction: column;
          align-items: center; /* Center images horizontally */
          margin-left: 20px;
          max-width: 40%; /* Prevent image container from taking too much space */
          overflow: hidden; /* Prevents overflow */
        }
        
        .article-image img {
          max-width: 100%; /* Ensure image doesn't overflow its container */
          height: auto; /* Maintain aspect ratio by default */
          object-fit: contain; /* Ensures the entire image is visible */
          object-position: center; /* Centers the image */
        }
    
        /* Ensure article layout is flexible */
        .article {
          display: flex;
          flex-wrap: wrap;
          margin-bottom: 30px;
          padding: 20px;
          border: 1px solid #ddd;
          border-radius: 5px;
        }
    
        .article-text {
          flex: 1;
          min-width: 300px; /* Minimum width for text content */
        }
    
        /* Alignment classes for images */
        .align-left {
          align-items: flex-start;
        }
        
        .align-right {
          align-items: flex-end;
        }
        
        .align-center {
          align-items: center;
        }
    
        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
          .article {
            flex-direction: column;
          }
          
          .article-image {
            margin-left: 0;
            margin-top: 20px;
            max-width: 100%;
          }
        }

        /* Form styling */
        .edit-form-container {
          max-width: 800px;
          margin: 20px auto;
          padding: 20px;
          border: 1px solid #ddd;
          border-radius: 5px;
        }
        
        .form-group {
          margin-bottom: 15px;
        }
        
        .form-group label {
          display: block;
          margin-bottom: 5px;
          font-weight: bold;
        }
        
        .form-group input[type="text"],
        .form-group textarea {
          width: 100%;
          padding: 8px;
          border: 1px solid #ddd;
          border-radius: 4px;
        }
        
        .form-buttons {
          margin-top: 20px;
        }
        
        .save-button, .cancel-button, .delete-button {
          padding: 8px 16px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          margin-right: 10px;
        }
        
        .save-button {
          background-color: #4CAF50;
          color: white;
        }
        
        .cancel-button {
          background-color: #f1f1f1;
          color: #333;
          text-decoration: none;
          display: inline-block;
        }
        
        .delete-button {
          background-color: #f44336;
          color: white;
        }
        
        /* Confirmation dialog */
        .confirmation-dialog {
          max-width: 500px;
          margin: 100px auto;
          padding: 20px;
          border: 1px solid #ddd;
          border-radius: 5px;
          text-align: center;
        }
      </style>
    </head>
    <body>
      <div class="app-bar">
        <div class="logo">
          <h1>CMS Admin</h1>
        </div>
        <nav class="nav-links">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </nav>
      </div>
      <main class="content">
    <?php
}
function displayFooter() {
    ?>
      </main>
      <footer class="footer" style="margin-top: 20px; text-align: center; padding: 10px; border-top: 1px solid #ddd;">
        <p>&copy; 2025 CMS Admin System. All rights reserved.</p>
      </footer>
    </body>
    </html>
    <?php
}

// Tarkista onko kyseessä edit_article.php vai edit_links.php
$page = $_GET['page'] ?? '';

// Hae alatunnisteen huomautus tiedostosta (jos sellainen on)
$footerNotePath = 'data/footer_note.json';
if (file_exists($footerNotePath)) {
    $footerNote = json_decode(file_get_contents($footerNotePath), true);
    $_SESSION['footerNote'] = $footerNote['text'] ?? "Lorem ipsum dolor sit amet";
}

// Default settings if not already set
if (!isset($_SESSION['logoText'])) {
    $_SESSION['logoText'] = 'LOGO';
}

if (!isset($_SESSION['footerTitle'])) {
    $_SESSION['footerTitle'] = "Your Company's Footer Title";
}

if (!isset($_SESSION['footerNote'])) {
    $_SESSION['footerNote'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
}

if (!isset($_SESSION['companyName'])) {
    $_SESSION['companyName'] = "Company's name";
}

// Käsittele edit_links.php toiminnot
if ($page === 'edit_links' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_link') {
        // Näytä lomake uuden linkin lisäämiseen
        displayHeader();
        ?>
        <div class="edit-form-container">
            <h2>Lisää uusi linkki</h2>
            <form method="post" action="index.php?page=edit_links">
                <input type="hidden" name="action" value="save_new_link">
                <div class="form-group">
                    <label for="link_name">Linkin teksti:</label>
                    <input type="text" id="link_name" name="link_name" placeholder="Esim. Facebook" required>
                </div>
                <div class="form-group">
                    <label for="link_url">Linkin URL:</label>
                    <input type="text" id="link_url" name="link_url" placeholder="Esim. https://facebook.com" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="save-button">Tallenna linkki</button>
                    <a href="index.php" class="cancel-button">Peruuta</a>
                </div>
            </form>
        </div>
        <?php
        displayFooter();
        exit;
    }
    
    else if ($action === 'save_new_link') {
        // Tallenna uusi linkki tietokantaan
        $displayText = $_POST['link_name'] ?? '';
        $url = $_POST['link_url'] ?? '';
        
        if ($displayText && $url) {
            // Käytä tietokantafunktiota linkin lisäämiseen
            $result = addLink($displayText, $url);
            
            if ($result) {
                // Ohjaa takaisin pääsivulle
                header('Location: index.php');
                exit;
            } else {
                echo "<script>alert('Linkin tallentaminen epäonnistui!'); history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Molemmat kentät vaaditaan!'); history.back();</script>";
            exit;
        }
    }
    
    else if ($action === 'delete_link') {
        // Poista linkki
        $linkId = isset($_POST['link_id']) ? (int)$_POST['link_id'] : -1;
        
        if ($linkId > 0) {
            // Hae linkin tiedot vahvistussivua varten
            $links = getAllLinks();
            $linkToDelete = null;
            
            foreach ($links as $link) {
                if ($link['id'] == $linkId) {
                    $linkToDelete = $link;
                    break;
                }
            }
            
            if ($linkToDelete) {
                // Näytä vahvistussivu
                displayHeader();
                ?>
                <div class="confirmation-dialog">
                    <h2>Vahvista poisto</h2>
                    <p>Oletko varma, että haluat poistaa linkin "<?php echo htmlspecialchars($linkToDelete['display_text']); ?>"?</p>
                    <form method="post" action="index.php?page=edit_links">
                        <input type="hidden" name="link_id" value="<?php echo $linkId; ?>">
                        <input type="hidden" name="action" value="confirm_delete_link">
                        <div class="form-buttons">
                            <button type="submit" class="delete-button">Kyllä, poista linkki</button>
                            <a href="index.php" class="cancel-button">Peruuta</a>
                        </div>
                    </form>
                </div>
                <?php
                displayFooter();
                exit;
            }
        }
    }
    
    else if ($action === 'confirm_delete_link') {
        // Poista linkki vahvistuksen jälkeen
        $linkId = isset($_POST['link_id']) ? (int)$_POST['link_id'] : -1;
        
        if ($linkId > 0) {
            // Käytä tietokantafunktiota linkin poistamiseen
            $result = deleteLink($linkId);
            
            // Ohjaa takaisin pääsivulle
            header('Location: index.php');
            exit;
        }
    }
    
    else if ($action === 'edit_link') {
        // Muokkaa linkkiä
        $linkId = isset($_POST['link_id']) ? (int)$_POST['link_id'] : -1;
        
        if ($linkId > 0) {
            // Hae linkin tiedot
            $links = getAllLinks();
            $linkToEdit = null;
            
            foreach ($links as $link) {
                if ($link['id'] == $linkId) {
                    $linkToEdit = $link;
                    break;
                }
            }
            
            if ($linkToEdit) {
                // Näytä lomake linkin muokkaamiseen
                displayHeader();
                ?>
                <div class="edit-form-container">
                    <h2>Muokkaa linkkiä</h2>
                    <form method="post" action="index.php?page=edit_links">
                        <input type="hidden" name="link_id" value="<?php echo $linkId; ?>">
                        <input type="hidden" name="action" value="save_edit_link">
                        <div class="form-group">
                            <label for="link_name">Linkin teksti:</label>
                            <input type="text" id="link_name" name="link_name" value="<?php echo htmlspecialchars($linkToEdit['display_text']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="link_url">Linkin URL:</label>
                            <input type="text" id="link_url" name="link_url" value="<?php echo htmlspecialchars($linkToEdit['url']); ?>" required>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class="save-button">Tallenna muutokset</button>
                            <a href="index.php" class="cancel-button">Peruuta</a>
                        </div>
                    </form>
                </div>
                <?php
                displayFooter();
                exit;
            }
        }
    }
    
    else if ($action === 'save_edit_link') {
        // Tallenna muokattu linkki
        $linkId = isset($_POST['link_id']) ? (int)$_POST['link_id'] : -1;
        $displayText = $_POST['link_name'] ?? '';
        $url = $_POST['link_url'] ?? '';
        
        if ($linkId > 0 && $displayText && $url) {
            // Käytä tietokantafunktiota linkin päivittämiseen
            $result = updateLink($linkId, $displayText, $url);
            
            // Ohjaa takaisin pääsivulle
            header('Location: index.php');
            exit;
        } else {
          if ($page === 'edit_article' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $sectionId = isset($_POST['section_id']) ? (int)$_POST['section_id'] : -1;
            echo "<script>alert('Molemmat kentät vaaditaan!'); history.back();</script>";
            exit;
        }
    }
    
    // Ohjaa takaisin pääsivulle, jos toimintoa ei käsitelty
    header('Location: index.php');
    exit;
}
else if ($action === 'confirm_delete') {
        // Poista artikkeli vahvistuksen jälkeen
        if ($sectionId > 0) {
            // Käytä tietokantafunktiota artikkelin poistamiseen
            $result = deleteSection($sectionId);
            
            // Ohjaa takaisin pääsivulle
            header('Location: index.php');
            exit;
        }
    }
    
    else if ($action === 'add_article') {
        // Näytä lomake uuden artikkelin lisäämiseen
        displayHeader();
        ?>
        <div class="edit-form-container">
            <h2>Lisää uusi artikkeli</h2>
            <form method="post" action="index.php?page=edit_article" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_new_article">
                
                <div class="form-group">
                    <label for="title">Otsikko:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Sisältö:</label>
                    <textarea id="content" name="content" style="width: 100%; height: 300px; padding: 10px;"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="upload-method">Kuvan lisääminen:</label>
                    <select id="upload-method" name="upload_method" onchange="toggleUploadMethod()">
                        <option value="path">Määritä polku</option>
                        <option value="upload">Lataa uusi kuva</option>
                    </select>
                    
                    <div id="path-input">
                        <label for="image-src">Kuvan polku (esim. images/cat1.jpg):</label>
                        <input type="text" id="image-src" name="image_src" value="images/default.jpg">
                    </div>
                    
                    <div id="file-input" style="display: none;">
                        <label for="image-file">Valitse kuvatiedosto:</label>
                        <input type="file" id="image-file" name="image_file" accept="image/*">
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="save-button">Tallenna artikkeli</button>
                    <a href="index.php" class="cancel-button">Peruuta</a>
                </div>
            </form>
        </div>
        
        <script>
            function toggleUploadMethod() {
                const method = document.getElementById('upload-method').value;
                if (method === 'path') {
                    document.getElementById('path-input').style.display = 'block';
                    document.getElementById('file-input').style.display = 'none';
                } else {
                    document.getElementById('path-input').style.display = 'none';
                    document.getElementById('file-input').style.display = 'block';
                }
            }
        </script>
        <?php
        displayFooter();
        exit;
    }
    
    else if ($action === 'save_new_article') {
        // Tallenna uusi artikkeli
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        
        if ($title && trim($title) !== '') {
            // Tarkista, onko kyseessä mallipohja
            $template = checkArticleTemplate($title);
            
            if ($template) {
                // Jos mallipohja tunnistettiin, käytä sen tietoja
                $title = $template['title'];
                $htmlContent = $template['content'];
                $imageUrl = $template['image_url'];
                
                // Näytä viesti käyttäjälle
                echo "<script>alert('" . addslashes($template['message']) . "');</script>";
            } else {
                // Muunna teksti HTML-muotoon
                $paragraphs = explode("\n\n", $content);
                $htmlContent = '';
                
                foreach ($paragraphs as $p) {
                    $lines = explode("\n", $p);
                    $htmlContent .= '<p>' . implode('<br>', $lines) . '</p>';
                }
                
                // Käsittele kuva
                $uploadMethod = $_POST['upload_method'] ?? 'path';
                $imageUrl = '';
                
                if ($uploadMethod === 'path') {
                    $imageUrl = $_POST['image_src'] ?? 'images/default.jpg';
                } else {
                    // Lataa tiedosto palvelimelle
                    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = 'uploads/';
                        
                        // Varmista että hakemisto on olemassa
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        
                        $fileName = basename($_FILES['image_file']['name']);
                        $targetFilePath = $uploadDir . $fileName;
                        
                        // Siirrä ladattu tiedosto hakemistoon
                        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFilePath)) {
                            $imageUrl = $targetFilePath;
                        } else {
                            $imageUrl = 'images/default.jpg';
                        }
                    } else {
                        $imageUrl = 'images/default.jpg';
                    }
                }
            }
            
            // Käytä tietokantafunktiota artikkelin lisäämiseen
            $result = addSection($title, $htmlContent, $imageUrl);
            
            if ($result) {
                // Ohjaa takaisin pääsivulle
                header('Location: index.php');
                exit;
            } else {
                echo "<script>alert('Artikkelin tallentaminen epäonnistui!'); history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Otsikko vaaditaan!'); history.back();</script>";
            exit;
        }
    }
    
    // Ohjaa takaisin pääsivulle, jos toimintoa ei käsitelty
    header('Location: index.php');
    exit;
}
// Käsittele pääsivun lomakkeiden lähettäminen
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logo edit
    if (isset($_POST['edit_logo'])) {
        $_SESSION['logoText'] = $_POST['logoText'];
    }
    
    // Footer title edit
    if (isset($_POST['edit_footer_title'])) {
        $_SESSION['footerTitle'] = $_POST['footerTitle'];
    }
    
    // Footer note edit
    if (isset($_POST['edit_footer_note'])) {
        $_SESSION['footerNote'] = $_POST['footerNote'];
        
        // Tallenna alatunnisteen huomautus JSON-tiedostoon
        $footerNotePath = 'data/footer_note.json';
        $footerNoteDir = dirname($footerNotePath);
        
        if (!file_exists($footerNoteDir)) {
            mkdir($footerNoteDir, 0777, true);
        }
        
        $data = ['text' => $_SESSION['footerNote']];
        file_put_contents($footerNotePath, json_encode($data));
    }
    
    // Company name edit
    if (isset($_POST['edit_company_name'])) {
        $_SESSION['companyName'] = $_POST['companyName'];
    }
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
// Näytä pääsivu, jos kyseessä ei ole edit_article tai edit_links
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CMS Admin</title>
  <link rel="stylesheet" href="styles.css"/>
  <style>
    /* Added styles for image container */
    .article-image {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center images horizontally */
      margin-left: 20px;
      max-width: 40%; /* Prevent image container from taking too much space */
      overflow: hidden; /* Prevents overflow */
    }
    
    .article-image img {
      max-width: 100%; /* Ensure image doesn't overflow its container */
      height: auto; /* Maintain aspect ratio by default */
      object-fit: contain; /* Ensures the entire image is visible */
      object-position: center; /* Centers the image */
    }

    /* Ensure article layout is flexible */
    .article {
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 30px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .article-text {
      flex: 1;
      min-width: 300px; /* Minimum width for text content */
    }

    /* Alignment classes for images */
    .align-left {
      align-items: flex-start;
    }
    
    .align-right {
      align-items: flex-end;
    }
    
    .align-center {
      align-items: center;
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
      .article {
        flex-direction: column;
      }
      
      .article-image {
        margin-left: 0;
        margin-top: 20px;
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="app-bar">
    <div class="logo">
      <h1 class="editable" id="logoText"><?php echo htmlspecialchars($_SESSION['logoText']); ?></h1>
      <form method="post" style="display: inline;">
        <input type="hidden" name="edit_logo" value="1">
        <input type="text" name="logoText" value="<?php echo htmlspecialchars($_SESSION['logoText']); ?>" style="display: none;" id="logoTextInput">
        <button type="button" class="edit-button" onclick="toggleLogoEdit()">Edit</button>
        <button type="submit" style="display: none;" id="logoSubmit">Save</button>
      </form>
    </div>
    <nav class="nav-links">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Blog</a></li>
      </ul>
    </nav>
  </div>

  <main class="articles" id="articlesContainer">
    <!-- Articles will be loaded dynamically from database -->
    <?php 
    // Hae kaikki artikkelit tietokannasta
    $sections = getAllSections();
    foreach ($sections as $section): 
    ?>
      <section class="article" id="section-<?php echo $section['id']; ?>">
        <div class="article-text">
          <h2><?php echo htmlspecialchars($section['title']); ?></h2>
          <form method="post" action="index.php?page=edit_article">
            <input type="hidden" name="section_id" value="<?php echo $section['id']; ?>">
            <input type="hidden" name="action" value="edit_title">
            <button type="submit" class="edit-button">Edit Title</button>
          </form>
          <div class="article-content">
            <?php echo $section['content']; // Note: content should be sanitized before storing ?>
          </div>
          <form method="post" action="index.php?page=edit_article">
            <input type="hidden" name="section_id" value="<?php echo $section['id']; ?>">
            <input type="hidden" name="action" value="edit_content">
            <button type="submit" class="edit-button edit-content-button">Edit Content</button>
          </form>
        </div>
        <div class="article-image align-center">
          <img 
            src="<?php echo htmlspecialchars($section['image_url']); ?>" 
            alt="Article image" 
            style="width: 200px; height: auto;"
          >
          <div class="image-buttons">
            <form method="post" action="index.php?page=edit_article" style="display: inline;">
              <input type="hidden" name="section_id" value="<?php echo $section['id']; ?>">
              <input type="hidden" name="action" value="change_image">
              <button type="submit" class="edit-button">Change Image</button>
            </form>
          </div>
        </div>
        <div class="article-actions">
          <form method="post" action="index.php?page=edit_article">
            <input type="hidden" name="section_id" value="<?php echo $section['id']; ?>">
            <input type="hidden" name="action" value="delete_article">
            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this article?');">Delete Article</button>
          </form>
        </div>
      </section>
    <?php endforeach; ?>
  </main>
  
  <!-- Add New Article button moved to bottom -->
  <div class="footer-admin-tools">
    <form method="post" action="index.php?page=edit_article">
      <input type="hidden" name="action" value="add_article">
      <button type="submit" class="add-button">+ Add New Article</button>
    </form>
  </div>

  <footer class="footer">
    <div class="footer-left">
        <h3 class="editable" id="footer-title"><?php echo htmlspecialchars($_SESSION['footerTitle']); ?></h3>
        <form method="post" style="display: inline;">
          <input type="hidden" name="edit_footer_title" value="1">
          <input type="text" name="footerTitle" value="<?php echo htmlspecialchars($_SESSION['footerTitle']); ?>" style="display: none;" id="footerTitleInput">
          <button type="button" class="edit-button" onclick="toggleFooterTitleEdit()">Edit</button>
          <button type="submit" style="display: none;" id="footerTitleSubmit">Save</button>
        </form>
        
        <p class="editable" id="footer-note"><?php echo htmlspecialchars($_SESSION['footerNote']); ?></p>
        <form method="post" style="display: inline;">
          <input type="hidden" name="edit_footer_note" value="1">
          <textarea name="footerNote" style="display: none;" id="footerNoteInput"><?php echo htmlspecialchars($_SESSION['footerNote']); ?></textarea>
          <button type="button" class="edit-button" onclick="toggleFooterNoteEdit()">Edit</button>
          <button type="submit" style="display: none;" id="footerNoteSubmit">Save</button>
        </form>

        <p>© 2025, <span id="companyName"><?php echo htmlspecialchars($_SESSION['companyName']); ?></span>.</p> 
        <form method="post" style="display: inline;">
          <input type="hidden" name="edit_company_name" value="1">
          <input type="text" name="companyName" value="<?php echo htmlspecialchars($_SESSION['companyName']); ?>" style="display: none;" id="companyNameInput">
          <button type="button" class="edit-button" onclick="toggleCompanyNameEdit()">Edit</button>
          <button type="submit" style="display: none;" id="companyNameSubmit">Save</button>
        </form>
        <br>
        <p>All rights reserved.</p>
    </div>

    <div class="footer-center">
        <ul class="footer-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </div>

    <div class="footer-right">
        <div id="linksContainer">
            <!-- Social links from database -->
            <?php
            // Hae linkit tietokannasta
            $links = getAllLinks();
            foreach ($links as $link) {
                echo '<div class="social-link">';
                echo '<a href="' . htmlspecialchars($link['url']) . '" target="_blank">' . htmlspecialchars($link['display_text']) . '</a>';
                echo '<form method="post" action="index.php?page=edit_links" style="display: inline;">';
                echo '<input type="hidden" name="link_id" value="' . $link['id'] . '">';
                echo '<input type="hidden" name="action" value="edit_link">';
                echo '<button type="submit" class="edit-button small">Edit</button>';
                echo '</form>';
                echo '<form method="post" action="index.php?page=edit_links" style="display: inline;">';
                echo '<input type="hidden" name="link_id" value="' . $link['id'] . '">';
                echo '<input type="hidden" name="action" value="delete_link">';
                echo '<button type="submit" class="delete-button small">X</button>';
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
        <form method="post" action="index.php?page=edit_links">
          <input type="hidden" name="action" value="add_link">
          <button type="submit" class="add-button">Add New Link</button>
        </form>
    </div>
  </footer>

  <script>
    // Toggle editing functions for inline editing
    function toggleLogoEdit() {
      const logoText = document.getElementById('logoText');
      const logoInput = document.getElementById('logoTextInput');
      const logoSubmit = document.getElementById('logoSubmit');
      const editButton = event.target;
      
      logoText.style.display = 'none';
      logoInput.style.display = 'inline';
      logoSubmit.style.display = 'inline';
      editButton.style.display = 'none';
    }
    
    function toggleFooterTitleEdit() {
      const footerTitle = document.getElementById('footer-title');
      const footerTitleInput = document.getElementById('footerTitleInput');
      const footerTitleSubmit = document.getElementById('footerTitleSubmit');
      const editButton = event.target;
      
      footerTitle.style.display = 'none';
      footerTitleInput.style.display = 'inline';
      footerTitleSubmit.style.display = 'inline';
      editButton.style.display = 'none';
    }
    
    function toggleFooterNoteEdit() {
      const footerNote = document.getElementById('footer-note');
      const footerNoteInput = document.getElementById('footerNoteInput');
      const footerNoteSubmit = document.getElementById('footerNoteSubmit');
      const editButton = event.target;
      
      footerNote.style.display = 'none';
      footerNoteInput.style.display = 'block';
      footerNoteSubmit.style.display = 'inline';
      editButton.style.display = 'none';
    }
    
    function toggleCompanyNameEdit() {
      const companyName = document.getElementById('companyName');
      const companyNameInput = document.getElementById('companyNameInput');
      const companyNameSubmit = document.getElementById('companyNameSubmit');
      const editButton = event.target;
      
      companyName.style.display = 'none';
      companyNameInput.style.display = 'inline';
      companyNameSubmit.style.display = 'inline';
      editButton.style.display = 'none';
    }
  </script>
</body>
</html>