<?php
// index.php - CMS Admin Panel
session_start();

// Sisällytetään tietokantafunktiot
require_once 'database.php';

// Mallipohjan tarkistus
function checkArticleTemplate($title) {
    $titleLower = strtolower(trim($title));
    
    if (strpos($titleLower, "sunny") !== false || strpos($titleLower, "golden ray") !== false) {
        $existingSections = getAllSections();
        foreach ($existingSections as $section) {
            if (strpos(strtolower($section['title']), "sunny") !== false) {
                return null; // Sunny jo olemassa
            }
        }
        
        return [
            'title' => 'Meet Sunny – A Golden Ray of Joy!',
            'content' => '<p><strong>Name:</strong> Sunny<br><strong>Breed:</strong> Golden Retriever<br><strong>Color:</strong> Golden<br><strong>Age:</strong> 4 months<br><strong>Gender:</strong> Female</p><p>Sunny is a playful and affectionate Golden Retriever puppy with a heart full of love and endless puppy energy.</p>',
            'image_url' => 'images/dog1.jpg',
            'message' => 'Sunny-mallipohja tunnistettu!'
        ];
    }
    
    if (strpos($titleLower, "pumpkin") !== false || strpos($titleLower, "furry friend") !== false) {
        $existingSections = getAllSections();
        foreach ($existingSections as $section) {
            if (strpos(strtolower($section['title']), "pumpkin") !== false) {
                return null; // Pumpkin jo olemassa
            }
        }
        
        return [
            'title' => 'Meet Pumpkin – Your Future Furry Friend!',
            'content' => '<p><strong>Name:</strong> Pumpkin<br><strong>Breed:</strong> Domestic Longhair<br><strong>Color:</strong> Orange<br><strong>Age:</strong> 3 years<br><strong>Gender:</strong> Male</p><p>Pumpkin is a sweet and curious orange cat with striking green eyes and a fluffy coat.</p>',
            'image_url' => 'images/cat1.jpg',
            'message' => 'Pumpkin-mallipohja tunnistettu!'
        ];
    }
    
    return null;
}

// Session oletusarvot
if (!isset($_SESSION['logoText'])) $_SESSION['logoText'] = 'LOGO';
if (!isset($_SESSION['footerTitle'])) $_SESSION['footerTitle'] = "Your Company's Footer Title";
if (!isset($_SESSION['footerNote'])) $_SESSION['footerNote'] = "Lorem ipsum dolor sit amet consectetur.";
if (!isset($_SESSION['companyName'])) $_SESSION['companyName'] = "Company's name";

$page = $_GET['page'] ?? '';

// ============ EDIT LINKS KÄSITTELY ============
if ($page === 'edit_links' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_link') {
        // Yksinkertainen lomake ilman template-tiedostoa
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lisää uusi linkki</title>
            <link rel="stylesheet" href="styles.css">
            <style>
                .form-container {
                    max-width: 600px;
                    margin: 100px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    background-color: #f9f9f9;
                }
                .form-group {
                    margin-bottom: 15px;
                }
                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }
                .form-group input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }
                .form-buttons {
                    margin-top: 20px;
                }
                .save-button, .cancel-button {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    margin-right: 10px;
                    text-decoration: none;
                    display: inline-block;
                }
                .save-button {
                    background-color: #4CAF50;
                    color: white;
                }
                .cancel-button {
                    background-color: #f1f1f1;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="form-container">
                <h2>Lisää uusi linkki</h2>
                <form method="post" action="index.php?page=edit_links">
                    <input type="hidden" name="action" value="save_new_link">
                    
                    <div class="form-group">
                        <label for="link_name">Linkin teksti:</label>
                        <input type="text" id="link_name" name="link_name" placeholder="Esim. Facebook" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="link_url">Linkin URL:</label>
                        <input type="url" id="link_url" name="link_url" placeholder="Esim. https://facebook.com" required>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="save-button">Tallenna linkki</button>
                        <a href="index.php" class="cancel-button">Peruuta</a>
                    </div>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
    
    if ($action === 'save_new_link') {
        $displayText = $_POST['link_name'] ?? '';
        $url = $_POST['link_url'] ?? '';
        
        if ($displayText && $url) {
            addLink($displayText, $url);
            header('Location: index.php');
            exit;
        }
    }
    
    if ($action === 'delete_link') {
        $linkId = (int)($_POST['link_id'] ?? 0);
        if ($linkId) {
            deleteLink($linkId);
        }
        header('Location: index.php');
        exit;
    }
    
    header('Location: index.php');
    exit;
}

// ============ EDIT ARTICLE KÄSITTELY ============
if ($page === 'edit_article' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $sectionId = (int)($_POST['section_id'] ?? 0);
    
    if ($action === 'add_article') {
        // Yksinkertainen lomake ilman template-tiedostoa
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lisää uusi artikkeli</title>
            <link rel="stylesheet" href="styles.css">
            <style>
                .form-container {
                    max-width: 800px;
                    margin: 50px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    background-color: #f9f9f9;
                }
                .form-group {
                    margin-bottom: 15px;
                }
                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }
                .form-group input, .form-group textarea {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }
                .form-group textarea {
                    height: 200px;
                    resize: vertical;
                }
                .form-buttons {
                    margin-top: 20px;
                }
                .save-button, .cancel-button {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    margin-right: 10px;
                    text-decoration: none;
                    display: inline-block;
                }
                .save-button {
                    background-color: #4CAF50;
                    color: white;
                }
                .cancel-button {
                    background-color: #f1f1f1;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="form-container">
                <h2>Lisää uusi artikkeli</h2>
                <form method="post" action="index.php?page=edit_article">
                    <input type="hidden" name="action" value="save_new_article">
                    
                    <div class="form-group">
                        <label for="title">Otsikko:</label>
                        <input type="text" id="title" name="title" required placeholder="Esim. Meet Sunny tai Meet Pumpkin">
                        <small>Vihje: Kirjoita 'Sunny' tai 'Pumpkin' otsikkoon käyttääksesi valmista mallipohjaa!</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Sisältö:</label>
                        <textarea id="content" name="content" placeholder="Kirjoita artikkelin sisältö tähän..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image_src">Kuvan polku:</label>
                        <input type="text" id="image_src" name="image_src" value="images/default.jpg" placeholder="Esim. images/cat1.jpg">
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="save-button">Tallenna artikkeli</button>
                        <a href="index.php" class="cancel-button">Peruuta</a>
                    </div>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
    
    if ($action === 'save_new_article') {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        
        if ($title) {
            $template = checkArticleTemplate($title);
            
            if ($template) {
                $title = $template['title'];
                $htmlContent = $template['content'];
                $imageUrl = $template['image_url'];
                echo "<script>alert('" . addslashes($template['message']) . "'); window.location='index.php';</script>";
                exit;
            } else {
                $paragraphs = explode("\n\n", $content);
                $htmlContent = '';
                foreach ($paragraphs as $p) {
                    $lines = explode("\n", $p);
                    $htmlContent .= '<p>' . implode('<br>', $lines) . '</p>';
                }
                $imageUrl = $_POST['image_src'] ?? 'images/default.jpg';
            }
            
            addSection($title, $htmlContent, $imageUrl);
        }
        header('Location: index.php');
        exit;
    }
    
    if ($action === 'delete_article') {
        if ($sectionId) {
            deleteSection($sectionId);
        }
        header('Location: index.php');
        exit;
    }
    
    header('Location: index.php');
    exit;
}

// ============ PÄÄSIVUN LOMAKKEET ============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_logo'])) {
        $_SESSION['logoText'] = $_POST['logoText'];
    }
    if (isset($_POST['edit_footer_title'])) {
        $_SESSION['footerTitle'] = $_POST['footerTitle'];
    }
    if (isset($_POST['edit_footer_note'])) {
        $_SESSION['footerNote'] = $_POST['footerNote'];
    }
    if (isset($_POST['edit_company_name'])) {
        $_SESSION['companyName'] = $_POST['companyName'];
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// ============ PÄÄSIVU HTML ============
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
            min-width: 300px;
        }
        .article-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-left: 20px;
            max-width: 40%;
        }
        .article-image img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }
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
    <?php 
    $sections = getAllSections();
    foreach ($sections as $section): 
    ?>
    <section class="article" id="section-<?php echo $section['id']; ?>">
        <div class="article-text">
            <h2><?php echo htmlspecialchars($section['title']); ?></h2>
            
            <div class="article-content">
                <?php echo $section['content']; ?>
            </div>
        </div>
        
        <div class="article-image">
            <img src="<?php echo htmlspecialchars($section['image_url']); ?>" alt="Article image" style="width: 200px; height: auto;">
        </div>
        
        <div class="article-actions">
            <form method="post" action="index.php?page=edit_article" style="display: inline;">
                <input type="hidden" name="section_id" value="<?php echo $section['id']; ?>">
                <input type="hidden" name="action" value="delete_article">
                <button type="submit" class="delete-button" onclick="return confirm('Haluatko varmasti poistaa tämän artikkelin?');">Delete Article</button>
            </form>
        </div>
    </section>
    <?php endforeach; ?>
</main>

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
            <?php
            $links = getAllLinks();
            foreach ($links as $link) {
                echo '<div class="social-link">';
                echo '<a href="' . htmlspecialchars($link['url']) . '" target="_blank">' . htmlspecialchars($link['display_text']) . '</a>';
                echo '<form method="post" action="index.php?page=edit_links" style="display: inline;">';
                echo '<input type="hidden" name="link_id" value="' . $link['id'] . '">';
                echo '<input type="hidden" name="action" value="delete_link">';
                echo '<button type="submit" class="delete-button small" onclick="return confirm(\'Haluatko poistaa tämän linkin?\');">X</button>';
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