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

<h3 align="center">ポッドキャスト RSS 用 WordPress プラグイン</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 チュートリアル</a> •
  <a href="https://doc-podcast.aripplesong.me/blog">📝 ブログ</a> •
  <a href="https://github.com/jiejia/a-ripple-song-podcast">⭐ GitHub</a>
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.6+-21759B?style=flat-square&logo=wordpress&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-GPL--3.0-blue?style=flat-square">
</p>

---

# A Ripple Song Podcast

> A Ripple Song テーマ向けの Podcast RSS（`/feed/podcast`）と Episode カスタム投稿タイプ。iTunes / Podcasting 2.0 タグに対応。

## ✨ 説明

このプラグインは「A Ripple Song」テーマ/サイトにポッドキャスト機能を追加します。カスタム投稿タイプでエピソードを管理し、Apple Podcasts / Spotify などに提出できる Podcast RSS フィードを生成します。

### 主な機能

- カスタム投稿タイプ：Episode（`ars_episode`）。アーカイブスラッグはデフォルトで `/podcasts/`
- タクソノミー：Episode Categories（`ars_episode_category`）。さらに標準タグ（`post_tag`）にも対応
- Podcast RSS フィード：`/feed/podcast/`（パーマリンク無効時は `?feed=podcast`）
- チャンネル設定ページ：管理画面メニュー `A Ripple Song` → `Podcast Settings`
  - 基本項目：Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes：`itunes:type`、`itunes:block`、`itunes:complete`、`itunes:new-feed-url`、任意の iTunes Title
  - Podcasting 2.0：`podcast:locked`、`podcast:guid`、`podcast:txt`（Apple 検証コード）、`podcast:funding`
- エピソード（Episode）項目（Carbon Fields メタ）：
  - 音声 URL（メディアライブラリ選択または手動 URL）。保存時に `duration/length/mime` を自動計算（getID3）
  - clean/explicit、episodeType（full/trailer/bonus）、episode/season number
  - エピソードカバー、エピソード単位の author 上書き、iTunes Title、Subtitle、Summary、Custom GUID、iTunes Block
  - Podcasting 2.0：Transcript（`podcast:transcript`）、Chapters（`podcast:chapters`）、Soundbites（`podcast:soundbite`）
  - Members/Guests：`podcast:person` として出力
- REST API：テーマ/フロントエンド向けに一部のエピソードメタを登録・公開
- アップロード対応：`mp3` / `m4a` のアップロードを許可し、URL フィールドにアップロード/ダウンロード/削除 UI を追加

### 注意

- Carbon Fields は Composer の `vendor/` に同梱（Carbon Fields プラグインの別途インストール不要）。
- フィードはリライトルールに依存します。通常は有効化時にフラッシュされますが、404 の場合は「設定 → パーマリンク設定」で「変更を保存」をクリックしてください。

## 🚀 インストール

1. `a-ripple-song-podcast` フォルダを `/wp-content/plugins/` にアップロード（または管理画面で ZIP をインストール）
2. 管理画面でプラグインを有効化
3. `A Ripple Song` → `Podcast Settings` でチャンネル情報（title/description/author/cover など）を設定
4. `ARS Episodes` → `Add New Episode` でエピソードを作成し、“Episode Details” に音声とメタ情報を入力
5. `/feed/podcast/`（または `?feed=podcast`）を開き、各ポッドキャストディレクトリへ提出

## ❓ よくある質問

### RSS URL は？

デフォルトは `https://your-site.example/feed/podcast/` です。パーマリンクが無効の場合は `https://your-site.example/?feed=podcast` を使用してください。

### /feed/podcast/ が 404 またはリダイレクトされる

多くの場合、リライトルールがフラッシュされていません。「設定 → パーマリンク設定」で「変更を保存」をクリックしてください。プラグイン側でも管理画面で一度だけフラッシュを試みます。

### duration/size が自動入力されない

エピソード保存時に getID3 で音声を解析します。リモート URL の場合は一時ファイルをダウンロードして解析することがあります。サーバーからアクセス可能な URL であること、十分な時間があることを確認してください。`ars_episode_audio_meta_download_timeout` フィルターでタイムアウト（デフォルト 300 秒）を調整できます。

### Carbon Fields プラグインは必要？

不要です。Carbon Fields は同梱され、`after_setup_theme` で起動します。

## 🖼️ スクリーンショット

1. `A Ripple Song` → `Podcast Settings`（チャンネル設定）
2. `ARS Episodes` 編集画面の “Episode Details” メタボックス
3. `/feed/podcast/` の RSS 出力（iTunes / Podcasting 2.0 タグ含む）

## 📝 変更履歴

### 0.5.0

- ベータ版リリース：Episode CPT + Podcast RSS フィード + 管理画面設定 + エピソードメタ項目。

## 🔔 アップグレード通知

### 0.5.0

ベータ版リリース。
