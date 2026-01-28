[English](../README.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh_TW.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলা](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- تعاون کنندگان: jiejia
- عطیہ لنک: https://github.com/jiejia/
- ٹیگز: podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- کم از کم درکار: WordPress 5.0
- ٹیسٹ شدہ: WordPress 6.9
- PHP درکار: 7.4
- مستحکم ٹیگ: 0.5.0-beta
- لائسنس: GPLv2 or later

A Ripple Song تھیم کے لیے Podcast RSS (`/feed/podcast`) + Episode CPT، iTunes اور Podcasting 2.0 ٹیگز کے ساتھ۔

## تعارف

یہ پلگ اِن “A Ripple Song” تھیم/سائٹ کے لیے پوڈکاسٹ فیچر مہیا کرتا ہے: کسٹم پوسٹ ٹائپ کے ذریعے ایپی سوڈز مینیج کریں اور Apple Podcasts / Spotify سمیت دیگر ڈائریکٹریز کے لیے موزوں پوڈکاسٹ RSS فیڈ بنائیں۔

### اہم خصوصیات

- کسٹم پوسٹ ٹائپ: Episode (`ars_episode`)، آرکائیو سلگ ڈیفالٹ `/podcasts/`
- ٹیکسانومی: Episode Categories (`ars_episode_category`)، نیز کور ٹیگز (`post_tag`) کی سپورٹ
- پوڈکاسٹ RSS فیڈ: `/feed/podcast/` (یا permalinks بند ہوں تو `?feed=podcast`)
- چینل سیٹنگز پیج: ایڈمن مینو `A Ripple Song` → `Podcast Settings`
  - عام فیلڈز: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`، `itunes:block`، `itunes:complete`، `itunes:new-feed-url`، اختیاری iTunes Title
  - Podcasting 2.0: `podcast:locked`، `podcast:guid`، `podcast:txt` (Apple verify code)، `podcast:funding`
- ایپی سوڈ لیول فیلڈز (Carbon Fields meta):
  - Audio URL (Media Library picker یا manual URL)؛ save پر `duration/length/mime` خودکار بھرے جاتے ہیں (getID3 کے ذریعے)
  - clean/explicit، episodeType (full/trailer/bonus)، episode/season number
  - Episode cover، فی ایپی سوڈ author override، iTunes Title، Subtitle، Summary، Custom GUID، iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`)، Chapters (`podcast:chapters`)، Soundbites (`podcast:soundbite`)
  - Members/Guests: `podcast:person` entries کے طور پر آؤٹ پٹ
- REST API: تھیم/فرنٹ اینڈ کے لیے منتخب episode meta کو register/expose کرتا ہے
- Upload support: `mp3` / `m4a` اپلوڈ کی اجازت؛ URL فیلڈز میں upload/download/remove UI بہتر کرتا ہے

### نوٹس

- Carbon Fields Composer `vendor/` میں bundled ہے (Carbon Fields پلگ اِن علیحدہ انسٹال کرنے کی ضرورت نہیں)۔
- فیڈ rewrite rules پر منحصر ہے؛ activation عام طور پر rules flush کرتا ہے، لیکن اگر 404 آئے تو “Settings → Permalinks” میں جا کر “Save” پر کلک کریں۔

## انسٹالیشن

1. `a-ripple-song-podcast` پلگ اِن فولڈر کو `/wp-content/plugins/` میں اپلوڈ کریں (یا WP Admin سے ZIP انسٹال کریں)
2. پلگ اِن کو WP Admin میں activate کریں
3. `A Ripple Song` → `Podcast Settings` میں جا کر چینل metadata (title, description, author, cover وغیرہ) پُر کریں
4. Episode بنائیں: `ARS Episodes` → `Add New Episode`، پھر “Episode Details” meta box (audio + metadata) پُر کریں
5. `/feed/podcast/` (یا `?feed=podcast`) کھولیں اور podcast directories میں submit کریں

## عمومی سوالات

### RSS URL کیا ہے؟

ڈیفالٹ: `https://your-site.example/feed/podcast/`۔ اگر permalinks بند ہوں تو `https://your-site.example/?feed=podcast` استعمال کریں۔

### /feed/podcast/ 404 دیتا ہے یا redirect کرتا ہے

عموماً rewrite rules flush نہیں ہوئے ہوتے۔ “Settings → Permalinks” میں جا کر “Save” کریں۔ پلگ اِن بھی admin-side پر ایک بار flush کی کوشش کرتا ہے۔

### duration/size خودکار کیوں نہیں بھرتا؟

Episode save ہونے پر پلگ اِن getID3 سے audio analyze کرتا ہے۔ remote URLs کے لیے یہ عارضی فائل ڈاؤن لوڈ کر سکتا ہے؛ یقینی بنائیں کہ سرور URL تک رسائی رکھتا ہو اور کافی وقت دیں۔ `ars_episode_audio_meta_download_timeout` فلٹر سے download timeout (ڈیفالٹ 300 سیکنڈ) تبدیل کیا جا سکتا ہے۔

### کیا Carbon Fields پلگ اِن انسٹال کرنا ہوگا؟

نہیں۔ Carbon Fields bundled ہے اور `after_setup_theme` پر boot ہوتا ہے۔

## اسکرین شاٹس

1. `A Ripple Song` → `Podcast Settings` (چینل سیٹنگز)
2. `ARS Episodes` ایڈٹ اسکرین پر “Episode Details” میٹا باکس
3. `/feed/podcast/` RSS آؤٹ پٹ (iTunes / Podcasting 2.0 ٹیگز کے ساتھ)

## تبدیلیوں کا ریکارڈ

### 0.5.0-beta

- بیٹا ریلیز: Episode CPT + Podcast RSS feed + admin settings اور episode meta fields۔

## اپگریڈ نوٹس

### 0.5.0-beta

بیٹا ریلیز۔
