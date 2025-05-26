<?php
// Aloita sessio heti tiedoston alussa
session_start();

// Sisällytetään tietokantafunktiot
require_once 'database.php';

// Funktio JSON-tiedostojen synkronointiin
function syncToJsonFiles() {
    // Varmista data-hakemiston olemassaolo
    if (!file_exists('data/')) {
        mkdir('data/', 0755, true);
    }
    
    // Synkronoi logo
    $logoData = ['logoText' => $_SESSION['logoText'] ?? 'LOGO'];
    file_put_contents('data/logo.json', json_encode($logoData, JSON_PRETTY_PRINT));
    
    // Synkronoi footer-tiedot
    $footerData = [
        'footerTitle' => $_SESSION['footerTitle'] ?? "Your Company's Footer Title",
        'footerNote' => $_SESSION['footerNote'] ?? 'Lorem ipsum dolor sit amet',
        'companyName' => $_SESSION['companyName'] ?? "Company's name"
    ];
    file_put_contents('data/footer.json', json_encode($footerData, JSON_PRETTY_PRINT));
    
    // Synkronoi artikkelit tietokannasta JSON:iin
    $sections = getAllSections();
    $articles = [];
    
    foreach ($sections as $section) {
        $articles[] = [
            'id' => 'section-' . $section['id'],
            'title' => $section['title'],
            'content' => $section['content'],
            'imageSrc' => $section['image_url'],
            'imageAlt' => 'Article image',
            'imageWidth' => 200,
            'imageHeight' => 'auto',
            'imageAlignment' => 'center'
        ];
    }
    
    $articlesData = [
        'articles' => $articles,
        'lastUpdated' => date('Y-m-d H:i:s')
    ];
    file_put_contents('data/articles.json', json_encode($articlesData, JSON_PRETTY_PRINT));
    
    // Synkronoi linkit tietokannasta JSON:iin
    $links = getAllLinks();
    $socialLinks = [];
    
    foreach ($links as $link) {
        $socialLinks[] = [
            'text' => $link['display_text'],
            'url' => $link['url']
        ];
    }
    
    $linksData = [
        'links' => $socialLinks,
        'lastUpdated' => date('Y-m-d H:i:s')
    ];
    file_put_contents('data/social_links.json', json_encode($linksData, JSON_PRETTY_PRINT));
}

// Käsittele AJAX-pyynnöt
if (isset($_POST['ajax_action'])) {
    header('Content-Type: application/json');
    
    $action = $_POST['ajax_action'];
    $response = ['success' => false, 'message' => ''];
    
    switch ($action) {
        case 'edit_logo':
            $_SESSION['logoText'] = $_POST['logoText'] ?? 'LOGO';
            syncToJsonFiles(); // Synkronoi JSON-tiedostoon
            $response = ['success' => true, 'message' => 'Logo updated'];
            break;
            
        case 'edit_footer_title':
            $_SESSION['footerTitle'] = $_POST['footerTitle'] ?? "Your Company's Footer Title";
            syncToJsonFiles(); // Synkronoi JSON-tiedostoon
            $response = ['success' => true, 'message' => 'Footer title updated'];
            break;
            
        case 'edit_footer_note':
            $_SESSION['footerNote'] = $_POST['footerNote'] ?? '';
            syncToJsonFiles(); // Synkronoi JSON-tiedostoon
            $response = ['success' => true, 'message' => 'Footer note updated'];
            break;
            
        case 'edit_company_name':
            $_SESSION['companyName'] = $_POST['companyName'] ?? "Company's name";
            syncToJsonFiles(); // Synkronoi JSON-tiedostoon
            $response = ['success' => true, 'message' => 'Company name updated'];
            break;
            
        case 'add_article':
            $title = $_POST['title'] ?? 'New Article';
            $content = $_POST['content'] ?? '<p>Enter your article content here.</p>';
            $imageUrl = $_POST['image_url'] ?? 'images/placeholder.jpg';
            
            // Tarkista mallipohjat
            $titleLower = strtolower(trim($title));
            
            // Sunny-mallipohja
            if (strpos($titleLower, "sunny") !== false || 
                strpos($titleLower, "golden ray") !== false || 
                strpos($titleLower, "meet sunny") !== false) {
                
                $title = 'Meet Sunny – A Golden Ray of Joy!';
                $content = '<p>
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
                </p>';
                $imageUrl = 'images/dog1.jpg';
            }
            
            // Pumpkin-mallipohja
            else if (strpos($titleLower, "pumpkin") !== false || 
                     strpos($titleLower, "furry friend") !== false || 
                     strpos($titleLower, "meet pumpkin") !== false) {
                
                $title = 'Meet Pumpkin – Your Future Furry Friend!';
                $content = '<p>
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
                </p>';
                $imageUrl = 'images/cat1.jpg';
            }
            
            $result = addSection($title, $content, $imageUrl);
            if ($result) {
                syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                $response = ['success' => true, 'message' => 'Article added', 'redirect' => true];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add article'];
            }
            break;
            
        case 'edit_article_title':
            $sectionId = (int)($_POST['section_id'] ?? 0);
            $title = $_POST['title'] ?? '';
            
            if ($sectionId > 0 && $title) {
                $result = updateSectionTitle($sectionId, $title);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Title updated' : 'Failed to update title'];
            }
            break;
            
        case 'edit_article_content':
            $sectionId = (int)($_POST['section_id'] ?? 0);
            $content = $_POST['content'] ?? '';
            
            if ($sectionId > 0 && $content) {
                $result = updateSectionContent($sectionId, $content);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Content updated' : 'Failed to update content'];
            }
            break;
            
        case 'edit_article_image':
            $sectionId = (int)($_POST['section_id'] ?? 0);
            $imageUrl = $_POST['image_url'] ?? '';
            
            if ($sectionId > 0 && $imageUrl) {
                $result = updateSectionImage($sectionId, $imageUrl);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Image updated' : 'Failed to update image'];
            }
            break;
            
        case 'delete_article':
            $sectionId = (int)($_POST['section_id'] ?? 0);
            
            if ($sectionId > 0) {
                $result = deleteSection($sectionId);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Article deleted' : 'Failed to delete article', 'redirect' => true];
            }
            break;
            
        case 'add_link':
            $linkText = $_POST['link_text'] ?? '';
            $linkUrl = $_POST['link_url'] ?? '';
            
            if ($linkText && $linkUrl) {
                $result = addLink($linkText, $linkUrl);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Link added' : 'Failed to add link', 'redirect' => true];
            }
            break;
            
        case 'edit_link':
            $linkId = (int)($_POST['link_id'] ?? 0);
            $linkText = $_POST['link_text'] ?? '';
            $linkUrl = $_POST['link_url'] ?? '';
            
            if ($linkId > 0 && $linkText && $linkUrl) {
                $result = updateLink($linkId, $linkText, $linkUrl);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Link updated' : 'Failed to update link', 'redirect' => true];
            }
            break;
            
        case 'delete_link':
            $linkId = (int)($_POST['link_id'] ?? 0);
            
            if ($linkId > 0) {
                $result = deleteLink($linkId);
                if ($result) {
                    syncToJsonFiles(); // Synkronoi JSON-tiedostoon
                }
                $response = ['success' => $result, 'message' => $result ? 'Link deleted' : 'Failed to delete link', 'redirect' => true];
            }
            break;
    }
    
    echo json_encode($response);
    exit;
}

// Lataa tallennetut tiedot JSON-tiedostoista sessioon (jos ne ovat olemassa)
$logoFile = 'data/logo.json';
if (file_exists($logoFile)) {
    $logoData = json_decode(file_get_contents($logoFile), true);
    if ($logoData && isset($logoData['logoText'])) {
        $_SESSION['logoText'] = $logoData['logoText'];
    }
}

$footerFile = 'data/footer.json';
if (file_exists($footerFile)) {
    $footerData = json_decode(file_get_contents($footerFile), true);
    if ($footerData) {
        if (isset($footerData['footerTitle'])) {
            $_SESSION['footerTitle'] = $footerData['footerTitle'];
        }
        if (isset($footerData['footerNote'])) {
            $_SESSION['footerNote'] = $footerData['footerNote'];
        }
        if (isset($footerData['companyName'])) {
            $_SESSION['companyName'] = $footerData['companyName'];
        }
    }
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

// Varmista että JSON-tiedostot ovat synkronoituja
syncToJsonFiles();
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

    /* Modal styles */
    .edit-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .edit-modal-content {
      background: white;
      padding: 20px;
      border-radius: 5px;
      max-width: 600px;
      width: 90%;
      max-height: 80vh;
      overflow-y: auto;
    }

    .editor-actions {
      margin-top: 15px;
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
    }

    .delete-button {
      background-color: #f44336;
      color: white;
    }

    .link-row {
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .link-form {
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>

  <div class="app-bar">
    <div class="logo">
      <h1 class="editable" id="logoText"><?php echo htmlspecialchars($_SESSION['logoText']); ?></h1>
      <button class="edit-button" onclick="editLogo()">Edit</button>
    </div>
    <nav class="nav-links">
      <ul>
        <li><a href="indexs.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Blog</a></li>
      </ul>
    </nav>
  </div>

  <main class="articles" id="articlesContainer">
    <!-- Articles loaded from database -->
    <?php 
    $sections = getAllSections();
    foreach ($sections as $section): 
    ?>
      <section class="article" id="section-<?php echo $section['id']; ?>">
        <div class="article-text">
          <h2><?php echo htmlspecialchars($section['title']); ?></h2>
          <button class="edit-button" onclick="editArticleTitle(<?php echo $section['id']; ?>)">Edit Title</button>
          <div class="article-content">
            <?php echo $section['content']; ?>
          </div>
          <button class="edit-button edit-content-button" onclick="editArticleContent(<?php echo $section['id']; ?>)">Edit Content</button>
        </div>
        <div class="article-image align-center">
          <img 
            src="<?php echo htmlspecialchars($section['image_url']); ?>" 
            alt="Article image" 
            style="width: 200px; height: auto;"
          >
          <div class="image-buttons">
            <button class="edit-button" onclick="editArticleImage(<?php echo $section['id']; ?>)">Change Image</button>
            <button class="edit-button" onclick="resizeArticleImage(<?php echo $section['id']; ?>)">Resize Image</button>
          </div>
        </div>
        <div class="article-actions">
          <button class="delete-button" onclick="deleteArticle(<?php echo $section['id']; ?>)">Delete Article</button>
        </div>
      </section>
    <?php endforeach; ?>
  </main>
  
  <!-- Add New Article button moved to bottom -->
  <div class="footer-admin-tools">
    <button class="add-button" onclick="addNewArticle()">+ Add New Article</button>
  </div>

  <footer class="footer">
    <div class="footer-left">
        <h3 class="editable" id="footer-title"><?php echo htmlspecialchars($_SESSION['footerTitle']); ?></h3>
        <button class="edit-button" onclick="editFooterTitle()">Edit</button>
        <p class="editable" id="footer-note"><?php echo htmlspecialchars($_SESSION['footerNote']); ?></p>
        <button class="edit-button" onclick="editFooterNote()">Edit</button>

        <p>© 2025, <span id="companyName"><?php echo htmlspecialchars($_SESSION['companyName']); ?></span>.</p> 
        <button class="edit-button" onclick="editCompanyName()">Edit</button>
        <br>
        <p>All rights reserved.</p>
    </div>

    <div class="footer-center">
        <ul class="footer-links">
            <li><a href="indexs.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </div>

    <div class="footer-right">
        <div id="linksContainer">
            <?php
            $links = getAllLinks();
            if (empty($links)) {
                echo '<p>No social media links. Add a link using the button below.</p>';
            } else {
                foreach ($links as $link) {
                    echo '<div class="link-row">';
                    echo '<a href="' . htmlspecialchars($link['url']) . '" target="_blank" style="color: blue;">' . htmlspecialchars($link['display_text']) . '</a> ';
                    echo '<button class="edit-button" onclick="editLink(' . $link['id'] . ', \'' . htmlspecialchars($link['display_text'], ENT_QUOTES) . '\', \'' . htmlspecialchars($link['url'], ENT_QUOTES) . '\')">Edit</button>';
                    echo '<button class="delete-button" onclick="confirmRemoveLink(' . $link['id'] . ', \'' . htmlspecialchars($link['display_text'], ENT_QUOTES) . '\')">Delete</button>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <button class="add-button" onclick="addLink()">Add New Link</button>
    </div>
  </footer>

  <script>
    // AJAX helper function
    function sendAjaxRequest(action, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (callback) callback(response);
                    if (response.redirect) {
                        location.reload();
                    }
                } catch (e) {
                    console.error('Failed to parse response:', e);
                }
            }
        };
        
        let params = 'ajax_action=' + encodeURIComponent(action);
        for (const key in data) {
            params += '&' + encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
        }
        
        xhr.send(params);
    }

    // Logo editing function
    function editLogo() {
      const logo = document.getElementById('logoText');
      const newLogoText = prompt("Edit logo text", logo.textContent);
      if (newLogoText) {
        sendAjaxRequest('edit_logo', { logoText: newLogoText }, function(response) {
            if (response.success) {
                logo.textContent = newLogoText;
                alert('Logo updated! Changes will appear on the public page.');
            }
        });
      }
    }

    // Footer editing functions
    function editFooterTitle() {
      const footerTitle = document.getElementById('footer-title');
      const newFooterTitle = prompt("Edit footer title", footerTitle.textContent);
      if (newFooterTitle) {
        sendAjaxRequest('edit_footer_title', { footerTitle: newFooterTitle }, function(response) {
            if (response.success) {
                footerTitle.textContent = newFooterTitle;
                alert('Footer title updated! Changes will appear on the public page.');
            }
        });
      }
    }

    function editFooterNote() {
      const footerNote = document.getElementById('footer-note');
      const newFooterNote = prompt("Edit footer text", footerNote.textContent);
      if (newFooterNote) {
        sendAjaxRequest('edit_footer_note', { footerNote: newFooterNote }, function(response) {
            if (response.success) {
                footerNote.textContent = newFooterNote;
                alert('Footer note updated! Changes will appear on the public page.');
            }
        });
      }
    }

    function editCompanyName() {
      const companyName = document.getElementById('companyName');
      const newCompanyName = prompt("Edit company name", companyName.textContent);
      if (newCompanyName) {
        sendAjaxRequest('edit_company_name', { companyName: newCompanyName }, function(response) {
            if (response.success) {
                companyName.textContent = newCompanyName;
                alert('Company name updated! Changes will appear on the public page.');
            }
        });
      }
    }

    // Article management functions
    function editArticleTitle(sectionId) {
        const titleElement = document.querySelector('#section-' + sectionId + ' h2');
        const newTitle = prompt("Edit article title", titleElement.textContent);
        
        if (newTitle && newTitle.trim() !== '') {
            sendAjaxRequest('edit_article_title', { 
                section_id: sectionId, 
                title: newTitle 
            }, function(response) {
                if (response.success) {
                    titleElement.textContent = newTitle;
                    alert('Title updated! Changes will appear on the public page.');
                } else {
                    alert('Failed to update title: ' + response.message);
                }
            });
        }
    }

    function editArticleContent(sectionId) {
        // Create modal for content editing
        const modal = document.createElement('div');
        modal.className = 'edit-modal';
        
        const contentElement = document.querySelector('#section-' + sectionId + ' .article-content');
        const currentContent = contentElement.innerHTML
            .replace(/<br>/g, '\n')
            .replace(/<\/p><p>/g, '\n\n')
            .replace(/<[^>]*>/g, '')
            .trim();
            
        modal.innerHTML = `
            <div class="edit-modal-content">
                <h3>Edit Article Content</h3>
                <textarea id="content-editor" style="width: 100%; height: 300px; padding: 10px;">${currentContent}</textarea>
                <div class="editor-actions">
                    <button class="save-button" onclick="saveArticleContent(${sectionId})">Save Changes</button>
                    <button class="cancel-button" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        window.currentModal = modal;
    }

    function saveArticleContent(sectionId) {
        const textarea = document.getElementById('content-editor');
        const newContent = textarea.value;
        
        if (newContent && newContent.trim() !== '') {
            // Convert plain text to HTML paragraphs
            const paragraphs = newContent.split('\n\n');
            const htmlContent = paragraphs.map(p => {
                const lines = p.split('\n');
                return '<p>' + lines.join('<br>') + '</p>';
            }).join('');
            
            sendAjaxRequest('edit_article_content', { 
                section_id: sectionId, 
                content: htmlContent 
            }, function(response) {
                if (response.success) {
                    const contentElement = document.querySelector('#section-' + sectionId + ' .article-content');
                    contentElement.innerHTML = htmlContent;
                    closeModal();
                    alert('Content updated! Changes will appear on the public page.');
                } else {
                    alert('Failed to update content: ' + response.message);
                }
            });
        }
    }

    function closeModal() {
        if (window.currentModal) {
            window.currentModal.remove();
            window.currentModal = null;
        }
    }

    function editArticleImage(sectionId) {
        const imgElement = document.querySelector('#section-' + sectionId + ' img');
        const currentSrc = imgElement.src.split('/').pop(); // Get filename only
        const newSrc = prompt("Enter image path (e.g., images/cat1.jpg)", "images/" + currentSrc);
        
        if (newSrc && newSrc.trim() !== '') {
            sendAjaxRequest('edit_article_image', { 
                section_id: sectionId, 
                image_url: newSrc 
            }, function(response) {
                if (response.success) {
                    imgElement.src = newSrc;
                    alert('Image updated! Changes will appear on the public page.');
                } else {
                    alert('Failed to update image: ' + response.message);
                }
            });
        }
    }

    function resizeArticleImage(sectionId) {
        const imgElement = document.querySelector('#section-' + sectionId + ' img');
        const currentWidth = imgElement.style.width.replace('px', '') || '200';
        const newWidth = prompt("Enter image width in pixels", currentWidth);
        
        if (newWidth && parseInt(newWidth) > 0) {
            imgElement.style.width = newWidth + 'px';
            // Note: This only changes display, not saved data for now
        }
    }

    function deleteArticle(sectionId) {
        if (confirm("Are you sure you want to delete this article?")) {
            sendAjaxRequest('delete_article', { section_id: sectionId }, function(response) {
                if (response.success) {
                    document.getElementById('section-' + sectionId).remove();
                    alert('Article deleted! Changes will appear on the public page.');
                } else {
                    alert('Failed to delete article: ' + response.message);
                }
            });
        }
    }

    function addNewArticle() {
        const newTitle = prompt("Enter new article title", "New Article Title");
        
        if (!newTitle || newTitle.trim() === '') {
            return;
        }
        
        sendAjaxRequest('add_article', { 
            title: newTitle.trim(),
            content: '<p>Enter your article content here.</p>',
            image_url: 'images/placeholder.jpg'
        }, function(response) {
            if (response.success) {
                alert('Article added! Refreshing page to show changes...');
                location.reload(); // Reload to show new article
            } else {
                alert('Failed to add article: ' + response.message);
            }
        });
    }

    // Social media link management functions
    function addLink() {
        const modal = document.createElement('div');
        modal.className = 'edit-modal';
        modal.innerHTML = `
            <div class="edit-modal-content">
                <h4>Add New Link</h4>
                <div style="margin-bottom: 10px;">
                    <label for="newLinkText" style="display: block; margin-bottom: 5px;">Link Text:</label>
                    <input type="text" id="newLinkText" placeholder="e.g. Facebook" style="width: 100%; padding: 5px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="newLinkUrl" style="display: block; margin-bottom: 5px;">Link URL:</label>
                    <input type="text" id="newLinkUrl" placeholder="e.g. https://facebook.com" style="width: 100%; padding: 5px;">
                </div>
                <div class="editor-actions">
                    <button class="save-button" onclick="saveNewLink()">Save</button>
                    <button class="cancel-button" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        window.currentModal = modal;
    }

    function saveNewLink() {
        const linkText = document.getElementById('newLinkText').value;
        const linkUrl = document.getElementById('newLinkUrl').value;
        
        if (linkText && linkUrl) {
            sendAjaxRequest('add_link', { 
                link_text: linkText, 
                link_url: linkUrl 
            }, function(response) {
                if (response.success) {
                    closeModal();
                    alert('Link added! Changes will appear on the public page.');
                    location.reload();
                } else {
                    alert('Failed to add link: ' + response.message);
                }
            });
        } else {
            alert("Both fields are required!");
        }
    }

    function editLink(linkId, currentText, currentUrl) {
        const modal = document.createElement('div');
        modal.className = 'edit-modal';
        modal.innerHTML = `
            <div class="edit-modal-content">
                <h4>Edit Link</h4>
                <div style="margin-bottom: 10px;">
                    <label for="editLinkText" style="display: block; margin-bottom: 5px;">Link Text:</label>
                    <input type="text" id="editLinkText" value="${currentText}" style="width: 100%; padding: 5px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="editLinkUrl" style="display: block; margin-bottom: 5px;">Link URL:</label>
                    <input type="text" id="editLinkUrl" value="${currentUrl}" style="width: 100%; padding: 5px;">
                </div>
                <div class="editor-actions">
                    <button class="save-button" onclick="saveEditLink(${linkId})">Save Changes</button>
                    <button class="cancel-button" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        window.currentModal = modal;
    }

    function saveEditLink(linkId) {
        const linkText = document.getElementById('editLinkText').value;
        const linkUrl = document.getElementById('editLinkUrl').value;
        
        if (linkText && linkUrl) {
            sendAjaxRequest('edit_link', { 
                link_id: linkId,
                link_text: linkText, 
                link_url: linkUrl 
            }, function(response) {
                if (response.success) {
                    closeModal();
                    alert('Link updated! Changes will appear on the public page.');
                    location.reload();
                } else {
                    alert('Failed to update link: ' + response.message);
                }
            });
        } else {
            alert("Both fields are required!");
        }
    }

    function confirmRemoveLink(linkId, linkText) {
        if (confirm(`Are you sure you want to delete the link "${linkText}"?`)) {
            sendAjaxRequest('delete_link', { link_id: linkId }, function(response) {
                if (response.success) {
                    alert('Link deleted! Changes will appear on the public page.');
                    location.reload();
                } else {
                    alert('Failed to delete link: ' + response.message);
                }
            });
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('edit-modal')) {
            closeModal();
        }
    });
  </script>

</body>
</html>