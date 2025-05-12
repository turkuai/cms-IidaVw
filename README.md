# CMS-projekti

Tämä projekti on yksinkertaisen sisällönhallintajärjestelmän (CMS) toteutus, joka mahdollistaa verkkosivuston luomisen ja muokkaamisen visuaalisella editorilla ilman koodaustaitoja.

## Julkiset linkit

- Netlify: [https://cms-iidavw.netlify.app/](https://cms-iidavw.netlify.app/)

## Projektin kuvaus

CMS-järjestelmämme tarjoaa käyttäjäystävällisen käyttöliittymän verkkosivustojen hallintaan. Käyttäjät voivat muokata sivuston sisältöä ilman teknistä osaamista.

## Toteutetut tehtävät

### Tehtävä 1 - Sivun rakentaminen HTML/CSS

Projektin pohja rakennettiin HTML:n ja CSS:n avulla ja tallennettiin index.html-tiedostoon. Tämä toimii järjestelmän perustana ja mahdollistaa sisällön visuaalisen esittämisen.

Tiedosto on nimetty "index.html", jolloin palvelin tarjoaa sen automaattisesti asiakkaalle osoitteen juuresta.

### Tehtävä 2 - GitHub Pages -käyttöönotto

Sivusto julkaistiin GitHub Pages -palvelussa automaattisen käyttöönottotoiminnon avulla:
1. Asetukset määritettiin valitsemalla "main" haara julkaistavaksi
2. GitHub Actions luo automaattisesti käyttöönoton aina kun muutoksia työnnetään main-haaraan
3. Julkinen linkki pysyy samana päivityksistä riippumatta

### Tehtävä 3 - Admin-reitti ja sisällön muokkaus

Järjestelmään on toteutettu "/admin" -reitti, joka mahdollistaa sivuston sisällön muokkaamisen:
- Logon muokkaus valikossa
- Alatunnisteen huomautuksen muokkaus
- Sosiaalisen median linkkien hallinta (lisäys, muokkaus, poisto)

Toteutus käyttää JavaScript-teknologiaa ja muutokset tallennetaan selaimen localStorage-ominaisuuden avulla. Käyttäjälle näytetään vahvistusikkunat poistojen yhteydessä ja muokkauslomakkeet sisältävät kentät sekä näyttötekstille että URL-osoitteelle.

### Tehtävä 4 - Netlify-käyttöönotto

Sivusto julkaistiin myös Netlify-palvelussa:
1. Luotiin Netlify-tunnus ja linkitettiin se GitHub-tiliin
2. Asetettiin automaattinen käyttöönottotoiminto GitHubista Netlifyyn
3. Määritettiin sivuston asetukset ja valittiin päähaaraksi "main"
4. Käyttöönotto tapahtuu nyt automaattisesti aina kun muutoksia työnnetään GitHubiin

### Tehtävä 5 - Julkiset linkit

README.md-tiedosto päivitettiin sisältämään verkkosivuston julkiset linkit GitHub Pages -palvelusta ja Netlify-palvelusta. Nämä linkit näkyvät tämän tiedoston alussa.