<p align="center">
  <a href="./README.md">English</a> •
  <a href="./docs/README.zh_CN.md">简体中文</a> •
  <a href="./docs/README.zh-Hant.md">繁體中文</a> •
  <a href="./docs/README.ja.md">日本語</a> •
  <a href="./docs/README.ko_KR.md">한국어</a> •
  <a href="./docs/README.fr_FR.md">Français</a> •
  <a href="./docs/README.es_ES.md">Español</a> •
  <a href="./docs/README.pt_BR.md">Português (Brasil)</a> •
  <a href="./docs/README.ru_RU.md">Русский</a> •
  <a href="./docs/README.hi_IN.md">हिन्दी</a> •
  <a href="./docs/README.bn_BD.md">বাংলা</a> •
  <a href="./docs/README.ar.md">العربية</a> •
  <a href="./docs/README.ur.md">اردو</a>
</p>

<p align="center">
  <img alt="A Ripple Song Podcast" src="https://img.shields.io/badge/A%20Ripple%20Song%20Podcast-0.5.0-6366f1?style=for-the-badge&logo=wordpress&logoColor=white" height="40">
</p>

<h3 align="center">Companion WordPress plugin for podcast RSS feeds</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 Tutorial</a> •
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

> Podcast RSS feed (`/feed/podcast`) + Episode CPT for the A Ripple Song theme, with iTunes & Podcasting 2.0 support.

## ✨ Description

This plugin adds podcast functionality for the “A Ripple Song” theme/site: manage episodes via a custom post type and generate a podcast RSS feed suitable for Apple Podcasts / Spotify and other directories.

### Key features

- Custom post type: Episode (`ars_episode`), archive slug defaults to `/podcasts/`
- Taxonomy: Episode Categories (`ars_episode_category`), plus support for core tags (`post_tag`)
- Podcast RSS feed: `/feed/podcast/` (or `?feed=podcast` if permalinks are disabled)
- Channel-level settings page: Admin menu `A Ripple Song` → `Podcast Settings`
  - Common fields: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, optional iTunes Title
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (Apple verify code), `podcast:funding`
- Episode-level fields (Carbon Fields meta):
  - Audio URL (Media Library picker or manual URL); on save auto-fills `duration/length/mime` (via getID3)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Episode cover, per-episode author override, iTunes Title, Subtitle, Summary, Custom GUID, iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Members/Guests: outputs as `podcast:person` entries
- REST API: registers/exposes selected episode meta for theme/front-end consumption
- Upload support: allows `mp3` / `m4a` uploads; enhances URL fields with upload/download/remove UI

### Notes

- Carbon Fields is bundled via Composer `vendor/` (no separate Carbon Fields plugin required).
- The feed depends on rewrite rules; activation typically flushes rules, but if you get a 404, visit “Settings → Permalinks” and click “Save”.

## 🚀 Installation

1. Upload the `a-ripple-song-podcast` plugin folder to `/wp-content/plugins/` (or install the ZIP via WP Admin)
2. Activate the plugin in WP Admin
3. Go to `A Ripple Song` → `Podcast Settings` and fill in channel metadata (title, description, author, cover, etc.)
4. Create an Episode: `ARS Episodes` → `Add New Episode`, then fill in the “Episode Details” meta box (audio + metadata)
5. Open the feed at `/feed/podcast/` (or `?feed=podcast`) and submit it to podcast directories

## ❓ Frequently Asked Questions

### What is the RSS URL?

By default it’s `https://your-site.example/feed/podcast/`. If permalinks are disabled, use `https://your-site.example/?feed=podcast`.

### Why does /feed/podcast/ return 404 or redirect?

Usually rewrite rules haven’t been flushed. Go to “Settings → Permalinks” and click “Save”. The plugin also attempts a one-time admin-side flush.

### Why aren’t duration/size auto-filled?

On Episode save, the plugin uses getID3 to analyze the audio. For remote URLs, it may download a temporary file first; ensure the URL is reachable by the server and allow enough time. Use the `ars_episode_audio_meta_download_timeout` filter to adjust the download timeout (default: 300 seconds).

### Do I need to install the Carbon Fields plugin?

No. Carbon Fields is bundled via Composer and booted on `after_setup_theme`.

## 🖼️ Screenshots

1. `A Ripple Song` → `Podcast Settings` (channel settings)
2. “Episode Details” meta box on the `ARS Episodes` edit screen
3. `/feed/podcast/` RSS output (includes iTunes / Podcasting 2.0 tags)

## 📝 Changelog

### 0.5.0

- Beta release: Episode CPT + Podcast RSS feed + admin settings and episode meta fields.

## 🔔 Upgrade Notice

### 0.5.0

Beta release.
