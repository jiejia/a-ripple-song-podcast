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

<h3 align="center">পডকাস্ট RSS এর জন্য সহায়ক WordPress প্লাগইন</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 টিউটোরিয়াল</a> •
  <a href="https://doc-podcast.aripplesong.me/blog">📝 ব্লগ</a> •
  <a href="https://github.com/jiejia/a-ripple-song-podcast">⭐ GitHub</a>
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.6+-21759B?style=flat-square&logo=wordpress&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-GPL--3.0-blue?style=flat-square">
</p>

---

# A Ripple Song Podcast

> A Ripple Song থিমের জন্য Podcast RSS (`/feed/podcast`) + Episode CPT, iTunes এবং Podcasting 2.0 ট্যাগ সাপোর্টসহ।

## ✨ বিবরণ

এই প্লাগইন “A Ripple Song” থিম/সাইটে পডকাস্ট ফিচার যোগ করে: কাস্টম পোস্ট টাইপ দিয়ে এপিসোড ম্যানেজ করুন এবং Apple Podcasts / Spotify সহ অন্যান্য ডিরেক্টরির জন্য উপযুক্ত পডকাস্ট RSS ফিড তৈরি করুন।

### মূল ফিচারসমূহ

- কাস্টম পোস্ট টাইপ: Episode (`ars_episode`), আর্কাইভ স্লাগ ডিফল্ট `/podcasts/`
- ট্যাক্সোনমি: Episode Categories (`ars_episode_category`), সাথে কোর ট্যাগ (`post_tag`) সাপোর্ট
- পডকাস্ট RSS ফিড: `/feed/podcast/` (permalinks বন্ধ থাকলে `?feed=podcast`)
- চ্যানেল সেটিংস পেজ: Admin মেনু `A Ripple Song` → `Podcast Settings`
  - সাধারণ ফিল্ড: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, ঐচ্ছিক iTunes Title
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (Apple verify code), `podcast:funding`
- এপিসোড-লেভেল ফিল্ড (Carbon Fields meta):
  - Audio URL (Media Library picker বা manual URL); save করলে `duration/length/mime` auto-fill (getID3 দিয়ে)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Episode cover, প্রতি-এপিসোড author override, iTunes Title, Subtitle, Summary, Custom GUID, iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Members/Guests: `podcast:person` entries হিসেবে আউটপুট
- REST API: থিম/ফ্রন্টএন্ড ব্যবহারের জন্য নির্বাচিত episode meta register/expose করে
- Upload support: `mp3` / `m4a` আপলোড অনুমোদন; URL ফিল্ডে upload/download/remove UI যোগ করে

### নোট

- Carbon Fields Composer `vendor/` এর মাধ্যমে bundled (আলাদা Carbon Fields প্লাগইন লাগবে না)।
- ফিড rewrite rules এর ওপর নির্ভর করে; activation সাধারণত flush করে, কিন্তু 404 হলে “Settings → Permalinks” এ গিয়ে “Save” চাপুন।

## 🚀 ইনস্টলেশন

1. `a-ripple-song-podcast` ফোল্ডার `/wp-content/plugins/` এ আপলোড করুন (অথবা WP Admin থেকে ZIP ইনস্টল করুন)
2. WP Admin এ প্লাগইন activate করুন
3. `A Ripple Song` → `Podcast Settings` এ গিয়ে চ্যানেল metadata (title, description, author, cover ইত্যাদি) পূরণ করুন
4. Episode তৈরি করুন: `ARS Episodes` → `Add New Episode`, তারপর “Episode Details” meta box (audio + metadata) পূরণ করুন
5. `/feed/podcast/` (অথবা `?feed=podcast`) খুলে podcast directories এ submit করুন

## ❓ সাধারণ প্রশ্ন

### RSS URL কী?

ডিফল্ট: `https://your-site.example/feed/podcast/`। permalinks বন্ধ থাকলে `https://your-site.example/?feed=podcast` ব্যবহার করুন।

### /feed/podcast/ 404 দেয় বা redirect করে কেন?

সাধারণত rewrite rules flush হয়নি। “Settings → Permalinks” এ গিয়ে “Save” চাপুন। প্লাগইনও admin-side এ একবার flush করার চেষ্টা করে।

### duration/size auto-fill হয় না কেন?

Episode save করার সময় প্লাগইন getID3 দিয়ে audio analyze করে। remote URL হলে সাময়িক ফাইল ডাউনলোড করতে পারে; নিশ্চিত করুন server URL অ্যাক্সেস করতে পারে এবং যথেষ্ট সময় দিন। `ars_episode_audio_meta_download_timeout` filter দিয়ে download timeout (ডিফল্ট 300 সেকেন্ড) বদলাতে পারবেন।

### Carbon Fields প্লাগইন ইনস্টল করতে হবে?

না। Carbon Fields bundled এবং `after_setup_theme` এ boot হয়।

## 🖼️ স্ক্রিনশট

1. `A Ripple Song` → `Podcast Settings` (চ্যানেল সেটিংস)
2. `ARS Episodes` edit screen এর “Episode Details” meta box
3. `/feed/podcast/` RSS আউটপুট (iTunes / Podcasting 2.0 ট্যাগসহ)

## 📝 পরিবর্তনের তালিকা

### 0.5.0-beta

- বেটা রিলিজ: Episode CPT + Podcast RSS feed + admin settings এবং episode meta fields।

## 🔔 আপগ্রেড নোটিশ

### 0.5.0-beta

বেটা রিলিজ।
