[English](../README.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh_TW.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলা](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- المساهمون: jiejia
- رابط التبرع: https://github.com/jiejia/
- الوسوم: podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- يتطلب على الأقل: WordPress 5.0
- مُختبر حتى: WordPress 6.9
- يتطلب PHP: 7.4
- الإصدار المستقر: 0.5.0-beta
- الرخصة: GPLv2 or later

خلاصة RSS للبودكاست (`/feed/podcast`) + نوع منشورات مخصص للحلقات (Episode) لثيم A Ripple Song، مع دعم iTunes و Podcasting 2.0.

## الوصف

تضيف هذه الإضافة وظائف البودكاست لثيم/موقع “A Ripple Song”: إدارة الحلقات عبر نوع منشورات مخصص وتوليد خلاصة RSS مناسبة لـ Apple Podcasts / Spotify وغيرها من الدلائل.

### الميزات الرئيسية

- نوع منشورات مخصص: Episode (`ars_episode`)، ومسار الأرشيف الافتراضي `/podcasts/`
- تصنيف: Episode Categories (`ars_episode_category`)، مع دعم وسوم ووردبريس الأساسية (`post_tag`)
- خلاصة RSS للبودكاست: `/feed/podcast/` (أو `?feed=podcast` إذا كانت الروابط الدائمة معطلة)
- صفحة إعدادات القناة: من قائمة الإدارة `A Ripple Song` → `Podcast Settings`
  - الحقول الشائعة: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`، `itunes:block`، `itunes:complete`، `itunes:new-feed-url`، و iTunes Title اختياري
  - Podcasting 2.0: `podcast:locked`، `podcast:guid`، `podcast:txt` (رمز تحقق Apple)، `podcast:funding`
- حقول على مستوى الحلقة (بيانات Carbon Fields):
  - رابط الصوت (اختيار من المكتبة أو إدخال رابط يدوي)؛ عند الحفظ يتم تعبئة `duration/length/mime` تلقائياً (عبر getID3)
  - clean/explicit، episodeType (full/trailer/bonus)، episode/season number
  - غلاف الحلقة، استبدال المؤلف لكل حلقة، iTunes Title، Subtitle، Summary، GUID مخصص، iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`)، Chapters (`podcast:chapters`)، Soundbites (`podcast:soundbite`)
  - الأعضاء/الضيوف: يتم إخراجهم كعناصر `podcast:person`
- REST API: تسجيل/إظهار بعض بيانات الحلقة لاستهلاك الثيم/الواجهة الأمامية
- دعم الرفع: السماح برفع `mp3` / `m4a` وتحسين حقول الروابط بواجهة رفع/تنزيل/حذف

### ملاحظات

- Carbon Fields مضمّن عبر Composer داخل `vendor/` (لا حاجة لتثبيت إضافة Carbon Fields بشكل منفصل).
- تعتمد الخلاصة على قواعد إعادة الكتابة؛ التفعيل غالباً يقوم بعمل flush، ولكن إذا ظهر 404 فاذهب إلى “Settings → Permalinks” واضغط “Save”.

## التثبيت

1. ارفع مجلد الإضافة `a-ripple-song-podcast` إلى `/wp-content/plugins/` (أو ثبّت ملف ZIP من لوحة التحكم)
2. فعّل الإضافة من لوحة التحكم
3. اذهب إلى `A Ripple Song` → `Podcast Settings` واملأ بيانات القناة (العنوان، الوصف، المؤلف، الغلاف، إلخ)
4. أنشئ حلقة: `ARS Episodes` → `Add New Episode` ثم املأ مربع “Episode Details” (الصوت + البيانات)
5. افتح `/feed/podcast/` (أو `?feed=podcast`) وقدّمها إلى أدلة البودكاست

## الأسئلة الشائعة

### ما هو رابط RSS؟

افتراضياً: `https://your-site.example/feed/podcast/`. إذا كانت الروابط الدائمة معطلة استخدم: `https://your-site.example/?feed=podcast`.

### لماذا /feed/podcast/ يعرض 404 أو يعيد التوجيه؟

غالباً لم يتم عمل flush لقواعد إعادة الكتابة. اذهب إلى “Settings → Permalinks” واضغط “Save”. كما تحاول الإضافة إجراء flush مرة واحدة من لوحة التحكم.

### لماذا لا يتم تعبئة المدة/الحجم تلقائياً؟

عند حفظ الحلقة تستخدم الإضافة getID3 لتحليل الصوت. بالنسبة لروابط الصوت البعيدة قد تقوم بتنزيل ملف مؤقت؛ تأكد أن الخادم يستطيع الوصول للرابط واترك وقتاً كافياً. استخدم الفلتر `ars_episode_audio_meta_download_timeout` لتعديل مهلة التحميل (الافتراضي: 300 ثانية).

### هل أحتاج لتثبيت إضافة Carbon Fields؟

لا. Carbon Fields مضمّن ويبدأ على `after_setup_theme`.

## لقطات الشاشة

1. `A Ripple Song` → `Podcast Settings` (إعدادات القناة)
2. مربع “Episode Details” في شاشة تحرير `ARS Episodes`
3. مخرجات RSS عبر `/feed/podcast/` (تتضمن وسوم iTunes / Podcasting 2.0)

## سجل التغييرات

### 0.5.0-beta

- إصدار تجريبي: نوع حلقات + خلاصة RSS + إعدادات الإدارة + حقول البيانات للحلقات.

## ملاحظة الترقية

### 0.5.0-beta

إصدار تجريبي.
