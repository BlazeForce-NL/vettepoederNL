# Beheerhandleiding Vette Poeder

Deze website gebruikt een licht premium WordPress-framework zonder zware pagebuilder.

## Pagina's aanpassen
Gebruik WordPress pagina's en Gutenberg blocks. De globale stijl komt uit het maatwerk theme.

## Blog plaatsen
Ga naar `Berichten > Nieuw bericht`. Gebruik categorieën en tags. Voeg waar mogelijk een uitgelichte afbeelding en korte samenvatting toe.

## Portfolio beheren
Ga naar `Portfolio > Nieuw portfolio-item`. Geschikt voor projecten, reizen, hobby's, werkvoorbeelden of cases.

## Fotoalbums
Gebruik het native WordPress `Galerij` blok. Alternatief: shortcode `[premium_gallery ids="1,2,3"]`.

## Security en privacy
XML-RPC staat uit, Wordfence is actief, HTTPS/security headers staan aan en de cookie/privacybasis is ingericht.

## Gebruikte plugins
- Polylang
- Wordfence
- WP Consent API
- Google Site Kit
- Insert Headers and Footers / WPCode

## Ontwerp
Website en design gerealiseerd door BlazeForce.

## Fotoalbums beheren

- Ga in WordPress naar **Fotoalbums** om een nieuw album aan te maken.
- Geef elk album een duidelijke titel, korte samenvatting en uitgelichte afbeelding.
- Voeg foto's toe in de content met het standaard WordPress galerijblok, of vul bij aangepaste velden `_album_image_ids` met media-ID's gescheiden door komma's.
- Het overzicht staat automatisch op `/fotoalbums/`.
- Je kunt albums ook tonen met shortcode: `[photo_album_grid limit="6"]`.
