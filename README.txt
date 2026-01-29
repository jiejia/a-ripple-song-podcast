=== A Ripple Song Podcast ===
Contributors: jiejia
Donate link: https://github.com/jiejia/
Tags: podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 8.2
Stable tag: 0.5.0-beta
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Podcast RSS feed (/feed/podcast) + Episode CPT for the A Ripple Song theme, with iTunes & Podcasting 2.0 support.

== Description ==

This plugin adds podcast functionality for the “A Ripple Song” theme/site: manage episodes via a custom post type and generate a podcast RSS feed suitable for Apple Podcasts / Spotify and other directories.

Key features:

* Custom post type: Episode (`ars_episode`), archive slug defaults to `/podcasts/`
* Taxonomy: Episode Categories (`ars_episode_category`), plus support for core tags (`post_tag`)
* Podcast RSS feed: `/feed/podcast/` (or `?feed=podcast` if permalinks are disabled)
* Channel-level settings page: Admin menu `A Ripple Song` → `Podcast Settings`
  * Common fields: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  * iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, optional iTunes Title
  * Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (Apple verify code), `podcast:funding`
* Episode-level fields (Carbon Fields meta):
  * Audio URL (Media Library picker or manual URL); on save auto-fills `duration/length/mime` (via getID3)
  * clean/explicit, episodeType (full/trailer/bonus), episode/season number
  * Episode cover, per-episode author override, iTunes Title, Subtitle, Summary, Custom GUID, iTunes Block
  * Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  * Members/Guests: outputs as `podcast:person` entries
* REST API: registers/exposes selected episode meta for theme/front-end consumption
* Upload support: allows `mp3` / `m4a` uploads; enhances URL fields with upload/download/remove UI

Notes:

* Carbon Fields is bundled via Composer `vendor/` (no separate Carbon Fields plugin required).
* The feed depends on rewrite rules; activation typically flushes rules, but if you get a 404, visit “Settings → Permalinks” and click “Save”.

== Installation ==

1. Upload the `a-ripple-song-podcast` plugin folder to `/wp-content/plugins/` (or install the ZIP via WP Admin)
2. Activate the plugin in WP Admin
3. Go to `A Ripple Song` → `Podcast Settings` and fill in channel metadata (title, description, author, cover, etc.)
4. Create an Episode: `ARS Episodes` → `Add New Episode`, then fill in the “Episode Details” meta box (audio + metadata)
5. Open the feed at `/feed/podcast/` (or `?feed=podcast`) and submit it to podcast directories

== Frequently Asked Questions ==

= What is the RSS URL? =

By default it’s `https://your-site.example/feed/podcast/`. If permalinks are disabled, use `https://your-site.example/?feed=podcast`.

= Why does /feed/podcast/ return 404 or redirect? =

Usually rewrite rules haven’t been flushed. Go to “Settings → Permalinks” and click “Save”. The plugin also attempts a one-time admin-side flush.

= Why aren’t duration/size auto-filled? =

On Episode save, the plugin uses getID3 to analyze the audio. For remote URLs, it may download a temporary file first; ensure the URL is reachable by the server and allow enough time. Use the `ars_episode_audio_meta_download_timeout` filter to adjust the download timeout (default: 300 seconds).

= Do I need to install the Carbon Fields plugin? =

No. Carbon Fields is bundled via Composer and booted on `after_setup_theme`.

== Screenshots ==

1. `A Ripple Song` → `Podcast Settings` (channel settings)
2. “Episode Details” meta box on the `ARS Episodes` edit screen
3. `/feed/podcast/` RSS output (includes iTunes / Podcasting 2.0 tags)

== Changelog ==

= 0.5.0-beta =
* Beta release: Episode CPT + Podcast RSS feed + admin settings and episode meta fields.

== Upgrade Notice ==

= 0.5.0-beta =
Beta release.
