[English](../README.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh_TW.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলা](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- Авторы: jiejia
- Ссылка для доната: https://github.com/jiejia/
- Теги: podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- Требуется: WordPress 5.0+
- Проверено до: WordPress 6.9
- Требуется PHP: 7.4
- Стабильная версия: 0.5.0-beta
- Лицензия: GPLv2 или новее

Подкаст RSS (`/feed/podcast`) + тип записи Episode для темы A Ripple Song, с поддержкой iTunes и Podcasting 2.0.

## Описание

Этот плагин добавляет подкаст-функциональность для темы/сайта “A Ripple Song”: управление эпизодами через пользовательский тип записи и генерация RSS-ленты подкаста, подходящей для Apple Podcasts / Spotify и других каталогов.

### Возможности

- Пользовательский тип записи: Episode (`ars_episode`), архив по умолчанию `/podcasts/`
- Таксономия: Episode Categories (`ars_episode_category`), плюс поддержка стандартных тегов (`post_tag`)
- RSS-лента подкаста: `/feed/podcast/` (или `?feed=podcast`, если ЧПУ отключены)
- Страница настроек канала: меню админки `A Ripple Song` → `Podcast Settings`
  - Основные поля: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, опциональный iTunes Title
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (код проверки Apple), `podcast:funding`
- Поля эпизода (мета Carbon Fields):
  - URL аудио (выбор из медиатеки или ручной URL); при сохранении автоматически заполняет `duration/length/mime` (через getID3)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Обложка эпизода, автор для конкретного эпизода, iTunes Title, Subtitle, Summary, Custom GUID, iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Участники/гости: выводятся как элементы `podcast:person`
- REST API: регистрирует/публикует выбранные метаданные эпизодов для темы/фронтенда
- Загрузка файлов: разрешает `mp3` / `m4a`; улучшает URL-поля UI для загрузки/скачивания/удаления

### Примечания

- Carbon Fields включён в Composer `vendor/` (не нужно устанавливать отдельный плагин Carbon Fields).
- Лента зависит от правил rewrite; при активации обычно выполняется flush, но если получаете 404, откройте “Настройки → Постоянные ссылки” и нажмите “Сохранить изменения”.

## Установка

1. Загрузите папку плагина `a-ripple-song-podcast` в `/wp-content/plugins/` (или установите ZIP через админку)
2. Активируйте плагин в админке WordPress
3. Перейдите в `A Ripple Song` → `Podcast Settings` и заполните данные канала (заголовок, описание, автор, обложка и т. д.)
4. Создайте эпизод: `ARS Episodes` → `Add New Episode`, затем заполните метабокс “Episode Details” (аудио + метаданные)
5. Откройте `/feed/podcast/` (или `?feed=podcast`) и отправьте ленту в каталоги подкастов

## Вопросы и ответы

### Какой URL у RSS?

По умолчанию: `https://your-site.example/feed/podcast/`. Если ЧПУ отключены: `https://your-site.example/?feed=podcast`.

### Почему /feed/podcast/ возвращает 404 или редирект?

Чаще всего правила rewrite не были обновлены. Откройте “Настройки → Постоянные ссылки” и нажмите “Сохранить изменения”. Плагин также пытается выполнить одноразовый flush в админке.

### Почему длительность/размер не заполняются автоматически?

При сохранении эпизода плагин использует getID3 для анализа аудио. Для удалённых URL он может скачивать временный файл; убедитесь, что сервер может обратиться к URL, и дайте достаточно времени. Используйте фильтр `ars_episode_audio_meta_download_timeout` для настройки таймаута скачивания (по умолчанию: 300 секунд).

### Нужно ли устанавливать плагин Carbon Fields?

Нет. Carbon Fields включён и запускается на `after_setup_theme`.

## Скриншоты

1. `A Ripple Song` → `Podcast Settings` (настройки канала)
2. Метабокс “Episode Details” на экране редактирования `ARS Episodes`
3. RSS-вывод `/feed/podcast/` (включает теги iTunes / Podcasting 2.0)

## История изменений

### 0.5.0-beta

- Бета-релиз: Episode CPT + RSS-лента подкаста + настройки админки + мета-поля эпизодов.

## Уведомление об обновлении

### 0.5.0-beta

Бета-релиз.
