[English](README.en_US.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh_TW.md) | [繁體中文（香港）](README.zh_HK.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলা](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- 貢獻者：jiejia
- 捐贈連結：https://github.com/jiejia/
- 標籤：podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- 最低要求：WordPress 5.0
- 測試版本：WordPress 6.9
- PHP 最低版本：7.4
- 穩定版本：0.5.0-beta
- 授權：GPLv2 或更高版本

為 A Ripple Song 主題提供播客 RSS（`/feed/podcast`）及 Episode 自訂文章類型，並支援 iTunes 與 Podcasting 2.0 標籤。

## 說明

本外掛為「A Ripple Song」主題/網站提供播客（Podcast）功能：以自訂文章類型管理每一集，並自動產生可提交到 Apple Podcasts / Spotify 等平台的 RSS Feed。

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
  - 成員/嘉賓：以 `podcast:person` 輸出
- REST API：註冊並暴露部分 Episode 元欄位，方便主題/前端使用
- 上傳支援：允許上傳 `mp3` / `m4a`，並加強 URL 欄位的上載/下載/移除操作

### 注意事項

- Carbon Fields 已透過 Composer `vendor/` 內置（毋須另外安裝 Carbon Fields 外掛）。
- Feed 依賴重寫規則；啟用外掛通常會自動刷新規則，但如出現 404，請到「設定 → 固定連結」按「儲存」。

## 安裝

1. 將 `a-ripple-song-podcast` 外掛資料夾上載到 `/wp-content/plugins/`（或於後台上載 ZIP 安裝）
2. 於後台啟用外掛
3. 進入 `A Ripple Song` → `Podcast Settings`，填寫頻道資料（標題、描述、作者、封面等）
4. 建立單集：`ARS Episodes` → `Add New Episode`，於 “Episode Details” 填寫音訊及元資料
5. 開啟 `/feed/podcast/`（或 `?feed=podcast`）並提交到播客平台

## 常見問題

### RSS 網址係乜？

預設係 `https://your-site.example/feed/podcast/`。如未啟用固定連結，請用 `https://your-site.example/?feed=podcast`。

### 點解 /feed/podcast/ 會 404 或跳轉？

通常係重寫規則未刷新。請到「設定 → 固定連結」按「儲存」。外掛亦會喺管理員進入後台時嘗試一次性刷新規則。

### 點解時長/大小冇自動填？

儲存 Episode 時外掛會用 getID3 分析音訊。若係遠端 URL，可能需要先下載暫存檔；請確保伺服器可存取該 URL 並預留足夠時間。可用 `ars_episode_audio_meta_download_timeout` 過濾器調整下載逾時（預設 300 秒）。

### 需要安裝 Carbon Fields 外掛嗎？

唔需要。Carbon Fields 已內置，並會喺 `after_setup_theme` 自動啟動。

## 截圖

1. `A Ripple Song` → `Podcast Settings`（頻道設定）
2. `ARS Episodes` 編輯頁的 “Episode Details” 元欄位面板
3. `/feed/podcast/` 的 RSS 輸出（包含 iTunes / Podcasting 2.0 標籤）

## 更新日誌

### 0.5.0-beta

- Beta 版本：Episode CPT + 播客 RSS + 後台設定與單集元欄位。

## 升級提示

### 0.5.0-beta

Beta 版本。

