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
  <img alt="A Ripple Song Podcast" src="https://img.shields.io/badge/A%20Ripple%20Song%20Podcast-0.5.0-6366f1?style=for-the-badge&logo=wordpress&logoColor=white" height="40">
</p>

<h3 align="center">पॉडकास्ट RSS के लिए WordPress प्लगइन</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 ट्यूटोरियल</a> •
  <a href="https://doc-podcast.aripplesong.me/blog">📝 ब्लॉग</a> •
  <a href="https://github.com/jiejia/a-ripple-song-podcast">⭐ GitHub</a>
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.6+-21759B?style=flat-square&logo=wordpress&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-GPL--3.0-blue?style=flat-square">
</p>

---

# A Ripple Song Podcast

> A Ripple Song थीम के लिए Podcast RSS (`/feed/podcast`) + Episode CPT, iTunes और Podcasting 2.0 टैग सपोर्ट के साथ।

## ✨ विवरण

यह प्लगइन “A Ripple Song” थीम/साइट के लिए पॉडकास्ट फीचर जोड़ता है: कस्टम पोस्ट टाइप के ज़रिए एपिसोड मैनेज करें और Apple Podcasts / Spotify व अन्य डायरेक्टरी के लिए उपयुक्त पॉडकास्ट RSS फ़ीड जनरेट करें।

### मुख्य विशेषताएँ

- कस्टम पोस्ट टाइप: Episode (`ars_episode`), आर्काइव स्लग डिफ़ॉल्ट `/podcasts/`
- टैक्सोनॉमी: Episode Categories (`ars_episode_category`), साथ ही कोर टैग (`post_tag`) सपोर्ट
- पॉडकास्ट RSS फ़ीड: `/feed/podcast/` (या permalinks बंद हों तो `?feed=podcast`)
- चैनल सेटिंग पेज: Admin मेनू `A Ripple Song` → `Podcast Settings`
  - सामान्य फ़ील्ड: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, वैकल्पिक iTunes Title
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (Apple verify code), `podcast:funding`
- एपिसोड-लेवल फ़ील्ड (Carbon Fields meta):
  - Audio URL (Media Library picker या manual URL); save पर `duration/length/mime` auto-fill (getID3 के जरिए)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Episode cover, प्रति-एपिसोड author override, iTunes Title, Subtitle, Summary, Custom GUID, iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Members/Guests: `podcast:person` entries के रूप में आउटपुट
- REST API: थीम/फ्रंटएंड उपयोग के लिए चुने हुए एपिसोड meta को register/expose करता है
- Upload support: `mp3` / `m4a` uploads की अनुमति; URL fields में upload/download/remove UI जोड़ता है

### नोट्स

- Carbon Fields Composer `vendor/` के जरिए bundled है (अलग Carbon Fields प्लगइन की जरूरत नहीं)।
- फ़ीड rewrite rules पर निर्भर है; activation आमतौर पर rules flush करता है, लेकिन 404 आए तो “Settings → Permalinks” में जाकर “Save” क्लिक करें।

## 🚀 इंस्टॉलेशन

1. `a-ripple-song-podcast` प्लगइन फ़ोल्डर को `/wp-content/plugins/` में अपलोड करें (या WP Admin से ZIP इंस्टॉल करें)
2. WP Admin में प्लगइन activate करें
3. `A Ripple Song` → `Podcast Settings` में जाकर चैनल metadata (title, description, author, cover आदि) भरें
4. एक Episode बनाएं: `ARS Episodes` → `Add New Episode`, फिर “Episode Details” meta box (audio + metadata) भरें
5. `/feed/podcast/` (या `?feed=podcast`) खोलें और इसे podcast directories में submit करें

## ❓ अक्सर पूछे जाने वाले सवाल

### RSS URL क्या है?

डिफ़ॉल्ट रूप से: `https://your-site.example/feed/podcast/`। यदि permalinks बंद हैं तो `https://your-site.example/?feed=podcast` उपयोग करें।

### /feed/podcast/ 404 देता है या redirect करता है

आमतौर पर rewrite rules flush नहीं हुए होते। “Settings → Permalinks” में जाकर “Save” क्लिक करें। प्लगइन admin-side पर एक बार flush करने की कोशिश भी करता है।

### duration/size auto-fill क्यों नहीं होता?

Episode save पर प्लगइन getID3 से audio analyze करता है। remote URLs के लिए यह अस्थायी फ़ाइल डाउनलोड कर सकता है; सुनिश्चित करें कि server URL तक पहुँच सकता है और पर्याप्त समय दें। `ars_episode_audio_meta_download_timeout` filter से download timeout (डिफ़ॉल्ट 300 सेकंड) बदल सकते हैं।

### क्या Carbon Fields प्लगइन इंस्टॉल करना होगा?

नहीं। Carbon Fields bundled है और `after_setup_theme` पर boot होता है।

## 🖼️ स्क्रीनशॉट

1. `A Ripple Song` → `Podcast Settings` (चैनल सेटिंग्स)
2. `ARS Episodes` एडिट स्क्रीन पर “Episode Details” मेटा बॉक्स
3. `/feed/podcast/` RSS आउटपुट (iTunes / Podcasting 2.0 टैग सहित)

## 📝 चेंजलॉग

### 0.5.0

- बीटा रिलीज़: Episode CPT + Podcast RSS feed + admin settings और episode meta fields.

## 🔔 अपग्रेड सूचना

### 0.5.0

बीटा रिलीज़।
