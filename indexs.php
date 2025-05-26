<?php
// index.php - Julkinen sivu, joka näyttää sisällön
?>
<!DOCTYPE html>
<html lang="fi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pet Adoption</title>
  <link rel="stylesheet" href="styles.css"/>
  <style>
    /* Parannetut kuvakonttien tyylit */
    .article-image {
      display: flex;
      flex-direction: column;
      align-items: center; /* Keskitä kuvat vaakatasossa oletuksena */
      max-width: 40%; /* Estä kuvakontaineria viemästä liikaa tilaa */
      margin-left: 20px;
    }
    
    .article-image img {
      max-width: 100%; /* Varmista, että kuva ei ylivuoda kontaineria */
      height: auto; /* Ylläpidä kuvasuhdetta oletuksena */
      object-fit: contain; /* Varmistaa, että koko kuva on näkyvissä */
      object-position: center; /* Keskitä kuva */
      border: 2px solid #000;
      border-radius: 8px;
    }

    /* Varmista, että artikkelin asettelu on joustava */
    .article {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-start;
      border: 2px solid #999;
      padding: 20px;
      margin-bottom: 30px;
      gap: 20px;
    }

    .article-text {
      flex: 2;
      min-width: 300px; /* Minimileveys tekstisisällölle */
    }

    /* Kohdistusluokat kuville */
    .align-left {
      align-items: flex-start;
    }
    
    .align-right {
      align-items: flex-end;
    }
    
    .align-center {
      align-items: center;
    }

    /* Responsiivinen suunnittelu pienemmille näytöille */
    @media (max-width: 768px) {
      .article {
        flex-direction: column;
        align-items: center;
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
      <?php
      // Hae logo-data palvelimelta
      $logoText = 'LOGO'; // Oletusarvo
      $logoFile = 'data/logo.json';
      if (file_exists($logoFile)) {
          $logoData = json_decode(file_get_contents($logoFile), true);
          if ($logoData && isset($logoData['logoText'])) {
              $logoText = htmlspecialchars($logoData['logoText']);
          }
      }
      
      // Tarkista, onko logokuvaa
      $logoImage = null;
      $logoImageFile = 'data/logo_image.json';
      if (file_exists($logoImageFile)) {
          $logoImageData = json_decode(file_get_contents($logoImageFile), true);
          if ($logoImageData && isset($logoImageData['logoPath'])) {
              $logoImage = htmlspecialchars($logoImageData['logoPath']);
          }
      }
      
      // Näytä logo (joko teksti tai kuva)
      if ($logoImage) {
          echo '<img src="' . $logoImage . '" alt="Logo" style="max-height: 50px;">';
      } else {
          echo '<h1 id="logoText">' . $logoText . '</h1>';
      }
      ?>
    </div>
    <nav class="nav-links">
      <ul>
        <li><a href="index.php">Koti</a></li>
        <li><a href="#">Tietoa</a></li>
        <li><a href="#">Blogi</a></li>
        <li><a href="admin.php">Hallinta</a></li>
      </ul>
    </nav>
  </div>

  <main class="articles" id="articlesContainer">
    <!-- Artikkelit ladataan tänne dynaamisesti -->
    <?php
    // Lataa artikkelit datatiedostosta
    $articlesFile = 'data/articles.json';
    $articles = [];
    
    if (file_exists($articlesFile)) {
        $articlesJson = file_get_contents($articlesFile);
        $articlesData = json_decode($articlesJson, true);
        if (isset($articlesData['articles'])) {
            $articles = $articlesData['articles'];
        }
    }
    
    // Jos artikkeleita ei löydy, käytä oletusartikkeleita
    if (empty($articles)) {
        // Oletusartikkelit (samat kuin alkuperäisessä koodissa)
        $articles = [
          [
            'id' => 'article1',
            'title' => 'Tule tapaamaan Sunnya – Iloinen kultainen säde!',
            'content' => '<p>
              <strong>Nimi:</strong> Sunny<br>
              <strong>Rotu:</strong> Kultainen noutaja<br>
              <strong>Väri:</strong> Kultainen<br>
              <strong>Ikä:</strong> 4 kuukautta<br>
              <strong>Sukupuoli:</strong> Naaras
            </p>
            <p>
              Sunny on leikkisä ja hellä kultainennoutaja-pentu, jolla on sydän täynnä rakkautta ja loputonta pentutarmoa. 
              Hän rakastaa pallojen jahtaamista, uusien ystävien tapaamista ja leikkimisen jälkeen päiväunille käpertymistä.
            </p>
            <p>
              Pehmeällä kultaisella turkillaan ja suloisilla silmillään hän varastaa sydämesi sekunneissa! Sunny on hyvin 
              sosiaalinen, innokas oppimaan ja vastaa hyvin positiiviseen koulutukseen.
            </p>
            <p>
              Hän tulee hyvin toimeen lasten ja muiden koirien kanssa, ja kukoistaisi aktiivisessa kodissa, jossa hän voi 
              tutkia, leikkiä ja kasvaa lojaaliseksi kumppaniksi, joksi hänet on tarkoitettu.
            </p>
            <p>
              Sunnyn rokotukset ovat ajan tasalla ja hän oppii nopeasti sisäsiistiksi.
            </p>
            <p>
              👉 Luuletko, että Sunny voisi olla täydellinen kumppanisi? Hae nyt adoptiota ja anna hänelle rakastava koti jonka hän ansaitsee!
            </p>',
            'imageSrc' => 'images/dog1.jpg',
            'imageAlt' => 'Söpö koira',
            'imageWidth' => 200,
            'imageHeight' => 'auto',
            'imageAlignment' => 'center'
          ],
          [
            'id' => 'article2',
            'title' => 'Tapaa Pumpkin – Tuleva karvainen ystäväsi!',
            'content' => '<p>
              <strong>Nimi:</strong> Pumpkin<br>
              <strong>Rotu:</strong> Pitkäkarvainen kotikissa<br>
              <strong>Väri:</strong> Oranssi<br>
              <strong>Ikä:</strong> 3 vuotta<br>
              <strong>Sukupuoli:</strong> Uros
            </p>
            <p>
              Pumpkin on suloinen ja utelias oranssi kissa, jolla on silmiinpistävät vihreät silmät ja pörröinen turkki. 
              Hän rakastaa pehmeillä matoilla loikoilua ja ympäröivän maailman hiljaista tarkkailua.
            </p>
            <p>
              Pumpkinilla on lempeä persoonallisuus, ja hän nauttii sekä rauhallisesta haliajasta että lelujen metsästämisestä.
            </p>
            <p>
              Hän tulee hyvin toimeen ihmisten kanssa ja olisi täydellinen kumppani rauhalliseen kotiin, jossa hän voi tuntea olonsa turvalliseksi ja rakastetuksi.
            </p>
            <p>
              Pumpkin on kastroitu, rokotettu ja sisäsiisti - valmiina liittymään ikuiseen perheeseensä!
            </p>
            <p>
              👉 Oletko valmis adoptoimaan Pumpkinin? Täytä hakemus verkkosivuillamme ja anna tälle rakastettavalle kissalle koti, jonka hän ansaitsee.
            </p>',
            'imageSrc' => 'images/cat1.jpg',
            'imageAlt' => 'Söpö kissa',
            'imageWidth' => 200,
            'imageHeight' => 'auto',
            'imageAlignment' => 'center'
          ]
        ];
        
        // Tallenna oletusartikkelit tiedostoon
        $articlesData = [
            'articles' => $articles,
            'lastUpdated' => date('Y-m-d H:i:s')
        ];
        
        if (!file_exists('data/')) {
            mkdir('data/', 0755, true);
        }
        
        file_put_contents($articlesFile, json_encode($articlesData, JSON_PRETTY_PRINT));
    }
    
    // Näytä artikkelit
    foreach ($articles as $article) {
        // Aseta oletusarvot jos niitä ei ole
        if (!isset($article['imageWidth'])) $article['imageWidth'] = 200;
        if (!isset($article['imageHeight'])) $article['imageHeight'] = 'auto';
        if (!isset($article['imageAlignment'])) $article['imageAlignment'] = 'center';
        
        echo '<section class="article" id="' . htmlspecialchars($article['id']) . '">';
        echo '<div class="article-text">';
        echo '<h2>' . htmlspecialchars($article['title']) . '</h2>';
        echo $article['content']; // Sisältö sisältää jo HTML:ää
        echo '</div>';
        echo '<div class="article-image align-' . htmlspecialchars($article['imageAlignment']) . '">';
        echo '<img src="' . htmlspecialchars($article['imageSrc']) . '" 
                  alt="' . htmlspecialchars($article['imageAlt']) . '" 
                  style="width: ' . htmlspecialchars($article['imageWidth']) . 'px; 
                         height: ' . (($article['imageHeight'] === 'auto') ? 'auto' : htmlspecialchars($article['imageHeight']) . 'px') . ';">';
        echo '</div>';
        echo '</section>';
    }
    ?>
  </main>
  
  <!-- Alatunniste-osio -->
  <footer class="footer">
    <div class="footer-left">
      <?php
      // Hae alatunnisteen tiedot palvelimelta
      $footerTitle = 'Yrityksesi Nimi';
      $footerNote = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
      $companyName = 'Yrityksen nimi';
      
      $footerFile = 'data/footer.json';
      if (file_exists($footerFile)) {
          $footerData = json_decode(file_get_contents($footerFile), true);
          if ($footerData) {
              if (isset($footerData['footerTitle'])) {
                  $footerTitle = htmlspecialchars($footerData['footerTitle']);
              }
              if (isset($footerData['footerNote'])) {
                  $footerNote = htmlspecialchars($footerData['footerNote']);
              }
              if (isset($footerData['companyName'])) {
                  $companyName = htmlspecialchars($footerData['companyName']);
              }
          }
      }
      ?>
      <h3 id="footer-title"><?php echo $footerTitle; ?></h3>
      <p id="footer-note"><?php echo $footerNote; ?></p>
      <p>&copy; 2025, <span id="companyName"><?php echo $companyName; ?></span>.</p>
      <br>
      <p>Kaikki oikeudet pidätetään.</p>
    </div>
    
    <div class="footer-center">
      <ul class="footer-links">
        <li><a href="index.php">Koti</a></li>
        <li><a href="#">Tietoa</a></li>
        <li><a href="#">Blogi</a></li>
      </ul>
    </div>

    <div class="footer-right">
      <div id="linksContainer">
        <?php
        // Lataa sosiaalisen median linkit tiedostosta
        $linksFile = 'data/social_links.json';
        $links = [];
        
        if (file_exists($linksFile)) {
            $linksJson = file_get_contents($linksFile);
            $linksData = json_decode($linksJson, true);
            if (isset($linksData['links'])) {
                $links = $linksData['links'];
            }
        }
        
        if (!empty($links)) {
            foreach ($links as $link) {
                echo '<div class="link-row">';
                echo '<a href="' . htmlspecialchars($link['url']) . '" target="_blank" style="color: blue;">' . htmlspecialchars($link['text']) . '</a>';
                echo '</div>';
            }
        }
        ?>
      </div>
    </div>
  </footer>

</body>
</html>