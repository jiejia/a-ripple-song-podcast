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

<h3 align="center">播客 RSS 配套 WordPress 外掛</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 使用教學</a> •
  <a href="https://doc-podcast.aripplesong.me/blog">📝 部落格</a> •
  <a href="https://github.com/jiejia/a-ripple-song-podcast">⭐ GitHub</a>
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-5.0+-21759B?style=flat-square&logo=wordpress&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-GPLv2%2B-blue?style=flat-square">
</p>

---

# A Ripple Song Podcast

> 為 A Ripple Song 主題提供播客 RSS（`/feed/podcast`）與 Episode 自訂文章類型，並支援 iTunes 與 Podcasting 2.0 標籤。

## ✨ 說明

本外掛為「A Ripple Song」主題/網站提供播客（Podcast）功能：以自訂文章類型管理每一集，並自動產生可提交至 Apple Podcasts / Spotify 等平台的 RSS Feed。

### 主要功能

- 自訂文章類型：Episode（`ars_episode`），封存頁路徑預設為 `/podcasts/`
- 分類法：Episode Categories（`ars_episode_category`），並支援預設標籤（`post_tag`）
- 播客 RSS：`/feed/podcast/`（未啟用固定連結時亦支援 `?feed=podcast`）
- 頻道級設定頁：後台選單 `A Ripple Song` → `Podcast Settings`
  - 常用欄位：Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes：`itunes:type`、`itunes:block`、`itunes:complete`、`itunes:new-feed-url`、可選 iTunes Title
  - Podcasting 2.0：`podcast:locked`、`podcast:guid`、`podcast:txt`（Apple 驗證碼）、`podcast:funding`
- 單集欄位（Carbon Fields 元欄位）：
  - 音訊 URL（媒體庫選取或手動 URL）；儲存時自動填入 `duration/length/mime`（透過 getID3）
  - clean/explicit、episodeType（full/trailer/bonus）、episode/season number
  - 單集封面、單集作者覆寫、iTunes Title、Subtitle、Summary、Custom GUID、iTunes Block
  - Podcasting 2.0：Transcript（`podcast:transcript`）、Chapters（`podcast:chapters`）、Soundbites（`podcast:soundbite`）
  - 成員/來賓：以 `podcast:person` 輸出
- REST API：註冊並暴露部分 Episode 元欄位，便於主題/前端使用
- 上傳支援：允許上傳 `mp3` / `m4a`，並增強 URL 欄位的上傳/下載/移除操作

### 注意事項

- Carbon Fields 已透過 Composer `vendor/` 內建（不需另外安裝 Carbon Fields 外掛）。
- Feed 依賴重寫規則；啟用外掛通常會自動刷新規則，但若出現 404，請至「設定 → 固定連結」點擊「儲存」。

## 🚀 安裝

1. 將 `a-ripple-song-podcast` 外掛資料夾上傳至 `/wp-content/plugins/`（或在後台上傳 ZIP 安裝）
2. 在後台啟用外掛
3. 進入 `A Ripple Song` → `Podcast Settings`，填寫頻道資訊（標題、描述、作者、封面等）
4. 建立單集：`ARS Episodes` → `Add New Episode`，於 “Episode Details” 填寫音訊與元資訊
5. 開啟 `/feed/podcast/`（或 `?feed=podcast`）並提交至播客平台

## ❓ 常見問題

### RSS 位址是什麼？

預設是 `https://your-site.example/feed/podcast/`。若未啟用固定連結，請使用 `https://your-site.example/?feed=podcast`。

### 為什麼 /feed/podcast/ 會 404 或跳轉？

通常是重寫規則未刷新。請至「設定 → 固定連結」點擊「儲存」。外掛也會在管理員進入後台時嘗試一次性刷新規則。

### 為什麼時長/大小沒有自動填入？

儲存 Episode 時外掛會使用 getID3 分析音訊。若為遠端 URL，可能需要先下載暫存檔；請確保伺服器可存取該 URL 並預留足夠時間。可透過 `ars_episode_audio_meta_download_timeout` 過濾器調整下載逾時（預設 300 秒）。

### 需要安裝 Carbon Fields 外掛嗎？

不需要。Carbon Fields 已內建，並在 `after_setup_theme` 自動啟動。

## 🖼️ 截圖

1. `A Ripple Song` → `Podcast Settings`（頻道設定）
2. `ARS Episodes` 編輯頁的 “Episode Details” 元欄位面板
3. `/feed/podcast/` 的 RSS 輸出（包含 iTunes / Podcasting 2.0 標籤）

## 📝 變更記錄

### 0.5.0-beta

- Beta 版本：Episode CPT + 播客 RSS + 後台設定與單集元欄位。

## 🔔 升級提示

### 0.5.0-beta

Beta 版本。
