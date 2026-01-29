<p align="center">
  <a href="../README.md">English</a> •
  <a href="README.zh_CN.md">简体中文</a> •
  <a href="README.zh-Hant.md">繁體中文</a> •
  <a href="README.ja.md">日本語</a> •
  <a href="README.ko_KR.md">한국어</a> •
  <a href="README.fr_FR.md">Français</a> •
  <a href="README.es_ES.md">Español</a> •
  <a href="README.pt_BR.md">Português (Brasil)</a> •
  <a href="README.ru_RU.md">Русский</a> •
  <a href="README.hi_IN.md">हिन्दी</a> •
  <a href="README.bn_BD.md">বাংলা</a> •
  <a href="README.ar.md">العربية</a> •
  <a href="README.ur.md">اردو</a>
</p>

<p align="center">
  <img alt="A Ripple Song Podcast" src="https://img.shields.io/badge/A%20Ripple%20Song%20Podcast-0.5.0--beta-6366f1?style=for-the-badge&logo=wordpress&logoColor=white" height="40">
</p>

<h3 align="center">Plugin WordPress compagnon pour flux RSS de podcast</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 Tutoriel</a> •
  <a href="https://doc-podcast.aripplesong.me/blog">📝 Blog</a> •
  <a href="https://github.com/jiejia/a-ripple-song-podcast">⭐ GitHub</a>
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.6+-21759B?style=flat-square&logo=wordpress&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-GPL--3.0-blue?style=flat-square">
</p>

---

# A Ripple Song Podcast

> Flux RSS podcast (`/feed/podcast`) + CPT Episode pour le thème A Ripple Song, avec prise en charge iTunes & Podcasting 2.0.

## ✨ Description

Ce plugin ajoute des fonctionnalités de podcast au thème/site « A Ripple Song » : gérer les épisodes via un type de contenu personnalisé et générer un flux RSS de podcast adapté à Apple Podcasts / Spotify et autres annuaires.

### Fonctionnalités clés

- Type de contenu personnalisé : Episode (`ars_episode`), slug d’archive par défaut `/podcasts/`
- Taxonomie : Episode Categories (`ars_episode_category`), avec prise en charge des tags natifs (`post_tag`)
- Flux RSS podcast : `/feed/podcast/` (ou `?feed=podcast` si les permaliens sont désactivés)
- Page de réglages du podcast : menu admin `A Ripple Song` → `Podcast Settings`
  - Champs principaux : Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes : `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, titre iTunes optionnel
  - Podcasting 2.0 : `podcast:locked`, `podcast:guid`, `podcast:txt` (code de vérification Apple), `podcast:funding`
- Champs au niveau de l’épisode (métas Carbon Fields) :
  - URL audio (sélecteur Média ou URL manuelle) ; à l’enregistrement, remplit `duration/length/mime` (via getID3)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Couverture d’épisode, surcharge d’auteur par épisode, iTunes Title, Subtitle, Summary, GUID personnalisé, iTunes Block
  - Podcasting 2.0 : Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Membres/Invités : sortie en entrées `podcast:person`
- REST API : enregistre/expose certaines métadonnées d’épisode pour le thème/le front
- Upload : autorise `mp3` / `m4a` ; ajoute une UI upload/télécharger/supprimer pour certains champs URL

### Notes

- Carbon Fields est inclus via Composer `vendor/` (pas besoin d’installer le plugin Carbon Fields séparément).
- Le flux dépend des règles de réécriture ; l’activation les flush généralement, mais en cas de 404, allez dans « Réglages → Permaliens » et cliquez sur « Enregistrer les modifications ».

## 🚀 Installation

1. Téléversez le dossier du plugin `a-ripple-song-podcast` dans `/wp-content/plugins/` (ou installez le ZIP via l’admin)
2. Activez le plugin dans l’admin WordPress
3. Allez dans `A Ripple Song` → `Podcast Settings` et remplissez les informations du podcast (titre, description, auteur, couverture, etc.)
4. Créez un épisode : `ARS Episodes` → `Add New Episode`, puis renseignez la boîte “Episode Details” (audio + métadonnées)
5. Ouvrez le flux `/feed/podcast/` (ou `?feed=podcast`) et soumettez-le aux annuaires de podcasts

## ❓ FAQ

### Quelle est l’URL du flux RSS ?

Par défaut : `https://your-site.example/feed/podcast/`. Si les permaliens sont désactivés : `https://your-site.example/?feed=podcast`.

### Pourquoi /feed/podcast/ renvoie 404 ou redirige ?

Souvent, les règles de réécriture n’ont pas été flush. Allez dans « Réglages → Permaliens » et cliquez sur « Enregistrer les modifications ». Le plugin tente aussi un flush unique côté admin.

### Pourquoi la durée/la taille ne se remplissent pas automatiquement ?

À l’enregistrement d’un épisode, le plugin utilise getID3 pour analyser l’audio. Pour une URL distante, il peut télécharger un fichier temporaire ; assurez-vous que l’URL est accessible depuis le serveur et laissez suffisamment de temps. Utilisez le filtre `ars_episode_audio_meta_download_timeout` pour ajuster le délai (par défaut : 300 secondes).

### Dois-je installer le plugin Carbon Fields ?

Non. Carbon Fields est inclus via Composer et est démarré sur `after_setup_theme`.

## 🖼️ Captures d’écran

1. `A Ripple Song` → `Podcast Settings` (réglages du podcast)
2. Boîte “Episode Details” sur l’écran d’édition `ARS Episodes`
3. Sortie RSS `/feed/podcast/` (inclut les tags iTunes / Podcasting 2.0)

## 📝 Journal des changements

### 0.5.0-beta

- Version bêta : CPT Episode + flux RSS podcast + réglages admin + champs méta d’épisode.

## 🔔 Note de mise à jour

### 0.5.0-beta

Version bêta.
