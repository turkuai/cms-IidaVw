**CMS-projekti**
Tämä projekti on yksinkertaisen sisällönhallintajärjestelmän (CMS) toteutus, joka mahdollistaa verkkosivuston luomisen ja muokkaamisen visuaalisella editorilla ilman koodaustaitoja.

**Julkiset linkit**
* Netlify: https://cms-iidavw.netlify.app/
* Koulun palvelin: http://taikukkula.fi/tiev23p/iida/indexs.php

**Projektin kuvaus**
CMS-järjestelmämme tarjoaa käyttäjäystävällisen käyttöliittymän verkkosivustojen hallintaan. Käyttäjät voivat muokata sivuston sisältöä ilman teknistä osaamista.

**Toteutetut tehtävät**

**Tehtävä 1 - Sivun rakentaminen HTML/CSS**
Projektin pohja rakennettiin HTML:n ja CSS:n avulla ja tallennettiin index.html-tiedostoon. Tämä toimii järjestelmän perustana ja mahdollistaa sisällön visuaalisen esittämisen. Tiedosto on nimetty "index.html", jolloin palvelin tarjoaa sen automaattisesti asiakkaalle osoitteen juuresta.

**Tehtävä 2 - GitHub Pages -käyttöönotto**
Sivusto julkaistiin GitHub Pages -palvelussa automaattisen käyttöönottotoiminnon avulla:
1. Asetukset määritettiin valitsemalla "main" haara julkaistavaksi
2. GitHub Actions luo automaattisesti käyttöönoton aina kun muutoksia työnnetään main-haaraan
3. Julkinen linkki pysyy samana päivityksistä riippumatta

**Tehtävä 3 - Admin-reitti ja sisällön muokkaus**
Järjestelmään on toteutettu "/admin" -reitti, joka mahdollistaa sivuston sisällön muokkaamisen:
* Logon muokkaus valikossa
* Alatunnisteen huomautuksen muokkaus
* Sosiaalisen median linkkien hallinta (lisäys, muokkaus, poisto) Toteutus käyttää JavaScript-teknologiaa ja muutokset tallennetaan selaimen localStorage-ominaisuuden avulla. Käyttäjälle näytetään vahvistusikkunat poistojen yhteydessä ja muokkauslomakkeet sisältävät kentät sekä näyttötekstille että URL-osoitteelle.

**Tehtävä 4 - Netlify-käyttöönotto**
Sivusto julkaistiin myös Netlify-palvelussa:
1. Luotiin Netlify-tunnus ja linkitettiin se GitHub-tiliin
2. Asetettiin automaattinen käyttöönottotoiminto GitHubista Netlifyyn
3. Määritettiin sivuston asetukset ja valittiin päähaaraksi "main"
4. Käyttöönotto tapahtuu nyt automaattisesti aina kun muutoksia työnnetään GitHubiin

**Tehtävä 5 - Julkiset linkit**
README.md-tiedosto päivitettiin sisältämään verkkosivuston julkiset linkit GitHub Pages -palvelusta ja Netlify-palvelusta. Nämä linkit näkyvät tämän tiedoston alussa.

**Tehtävä 6 - Sisällön täysi hallinta ja kuvan koon muokkaus**
Järjestelmää laajennettiin mahdollistamaan sivuston sisällön kattavampi hallinta:
1. **Artikkelien dynaaminen hallinta**:
   * Uusien artikkelien lisääminen "Add New Article" -painikkeella
   * Artikkelien otsikon ja sisällön muokkaus
   * Artikkelien poistaminen vahvistusikkunan kautta
   * Artikkelien järjestyksen hallinta
2. **Kuvien hallinta ja muokkaus**:
   * Kuvien vaihtaminen URL-osoitteen kautta
   * Kuvien koon muokkaaminen pikselitarkkuudella (leveys ja korkeus)
   * Automaattinen suhteutettu korkeus -vaihtoehto
3. **Käyttöliittymän parannukset**:
   * Käyttäjäystävällinen muokkauskäyttöliittymä modaali-ikkunoilla
   * Pyöristetyt reunat painikkeissa
   * Visuaaliset indikaattorit muokattaville elementeille
   * Yhdenmukainen värimaailma koko järjestelmässä
   * Muokatut tyylit siirretty ulkoiseen CSS-tiedostoon selkeämmän ylläpidon vuoksi
4. **Parempi tietojen tallennusjärjestelmä**:
   * Kaikki sisältömuutokset tallennetaan automaattisesti localStorage-ominaisuuden avulla
   * Kuvien koot ja asettelut säilyvät sekä admin- että käyttäjänäkymässä

**Tehtävä 8 - FTP-käyttöönotto koulun palvelimelle**
Sivusto julkaistiin koulun PHP-palvelimelle GitHub Actions automaation avulla:
1. Luotiin GitHub Actions workflow -tiedosto (.github/workflows/ftp-deploy.yml)
2. Määritettiin FTP-tunnukset turvallisesti GitHub Secrets -ominaisuudella
3. Asetettiin automaattinen käyttöönotto server-haarasta koulun palvelimelle
4. Määritettiin julkaisukohteeksi /cms/ -kansio FTP-palvelimella
5. Käyttöönotto tapahtuu nyt automaattisesti aina kun muutoksia työnnetään server-haaraan
6. PHP-toiminnallisuudet ovat nyt käytettävissä ja sivusto on saatavilla julkisesti koulun palvelimella

Nämä parannukset mahdollistavat sivuston täydellisen muokkaamisen ilman koodiosaamista suoraan selaimessa, mikä tekee CMS-järjestelmästä huomattavasti monipuolisemman ja käyttäjäystävällisemmän.