[English](../README.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh-Hant.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলा](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- 贡献者：jiejia
- 捐赠链接：https://github.com/jiejia/
- 标签：podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- 最低要求：WordPress 5.0
- 测试版本：WordPress 6.9
- PHP 最低版本：7.4
- 稳定版本：0.5.0-beta
- 许可证：GPLv2 或更高版本

为 A Ripple Song 主题提供播客 RSS（`/feed/podcast`）与 Episode 自定义文章类型，并支持 iTunes 与 Podcasting 2.0 标签。

## 说明

本插件为「A Ripple Song」主题/站点提供播客（Podcast）功能：用自定义文章类型管理每一期节目，并自动生成可提交到 Apple Podcasts / Spotify 等平台的 RSS Feed。

### 主要功能

- 自定义文章类型：Episode（`ars_episode`），归档路径默认为 `/podcasts/`
- 分类法：Episode Categories（`ars_episode_category`），并支持默认标签（`post_tag`）
- 播客 RSS：`/feed/podcast/`（未启用固定链接时也支持 `?feed=podcast`）
- 频道级设置页：后台菜单 `A Ripple Song` → `Podcast Settings`
  - 常用字段：Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes：`itunes:type`、`itunes:block`、`itunes:complete`、`itunes:new-feed-url`、可选 iTunes Title
  - Podcasting 2.0：`podcast:locked`、`podcast:guid`、`podcast:txt`（Apple 验证码）、`podcast:funding`
- 单集字段（Carbon Fields 元字段）：
  - 音频地址（媒体库选择或手动 URL）；保存时自动填充 `duration/length/mime`（通过 getID3）
  - clean/explicit、episodeType（full/trailer/bonus）、episode/season number
  - 单集封面、单集作者覆盖、iTunes Title、Subtitle、Summary、Custom GUID、iTunes Block
  - Podcasting 2.0：Transcript（`podcast:transcript`）、Chapters（`podcast:chapters`）、Soundbites（`podcast:soundbite`）
  - 成员/嘉宾：以 `podcast:person` 输出
- REST API：注册并暴露部分 Episode 元字段，便于主题/前端使用
- 上传支持：允许上传 `mp3` / `m4a`，并增强 URL 字段的上传/下载/移除交互

### 注意事项

- 插件通过 Composer `vendor/` 内置 Carbon Fields（无需单独安装 Carbon Fields 插件）。
- Feed 依赖重写规则；启用插件通常会自动刷新规则，但如果出现 404，请到“设置 → 固定链接”点击“保存”。

## 安装

1. 将 `a-ripple-song-podcast` 插件目录上传到 `/wp-content/plugins/`（或在后台上传 ZIP 安装）
2. 在后台启用插件
3. 打开 `A Ripple Song` → `Podcast Settings`，填写频道信息（标题、描述、作者、封面等）
4. 创建单集：`ARS Episodes` → `Add New Episode`，在 “Episode Details” 中填写音频与元信息
5. 访问 `/feed/podcast/`（或 `?feed=podcast`）并提交到播客平台

## 常见问题

### RSS 地址是什么？

默认是 `https://your-site.example/feed/podcast/`。如果未启用固定链接，请使用 `https://your-site.example/?feed=podcast`。

### 为什么 /feed/podcast/ 会 404 或跳转？

通常是重写规则未刷新。请到“设置 → 固定链接”点击“保存”。插件也会在管理员访问后台时尝试一次性刷新规则。

### 为什么时长/大小没有自动填充？

保存 Episode 时插件使用 getID3 分析音频。若音频是远程 URL，可能需要先下载临时文件；请确保服务器可访问该 URL，并预留足够时间。可通过 `ars_episode_audio_meta_download_timeout` 过滤器调整下载超时时间（默认 300 秒）。

### 需要安装 Carbon Fields 插件吗？

不需要。Carbon Fields 已内置，并在 `after_setup_theme` 上自动启动。

## 截图

1. `A Ripple Song` → `Podcast Settings`（频道设置）
2. `ARS Episodes` 编辑页的 “Episode Details” 元字段面板
3. `/feed/podcast/` 的 RSS 输出（包含 iTunes / Podcasting 2.0 标签）

## 更新日志

### 0.5.0-beta

- Beta 版本：Episode CPT + 播客 RSS + 后台设置与单集元字段。

## 升级提示

### 0.5.0-beta

Beta 版本。
