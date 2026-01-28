[English](../README.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh-Hant.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলা](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- Colaboradores: jiejia
- Enlace de donación: https://github.com/jiejia/
- Tags: podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- Requiere al menos: WordPress 5.0
- Probado hasta: WordPress 6.9
- Requiere PHP: 7.4
- Versión estable: 0.5.0-beta
- Licencia: GPLv2 o posterior

Feed RSS de podcast (`/feed/podcast`) + CPT de episodios para el tema A Ripple Song, con soporte iTunes y Podcasting 2.0.

## Descripción

Este plugin añade funcionalidad de podcast al tema/sitio “A Ripple Song”: gestiona episodios mediante un tipo de contenido personalizado y genera un feed RSS de podcast apto para Apple Podcasts / Spotify y otros directorios.

### Funciones principales

- Tipo de contenido personalizado: Episode (`ars_episode`), slug de archivo por defecto `/podcasts/`
- Taxonomía: Episode Categories (`ars_episode_category`), además de soporte para etiquetas nativas (`post_tag`)
- Feed RSS de podcast: `/feed/podcast/` (o `?feed=podcast` si los enlaces permanentes están desactivados)
- Página de ajustes del canal: menú admin `A Ripple Song` → `Podcast Settings`
  - Campos comunes: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, iTunes Title opcional
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (código de verificación de Apple), `podcast:funding`
- Campos por episodio (metadatos Carbon Fields):
  - URL de audio (selector de Medios o URL manual); al guardar rellena `duration/length/mime` (vía getID3)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Portada del episodio, autor por episodio, iTunes Title, Subtitle, Summary, GUID personalizado, iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Miembros/Invitados: se generan como entradas `podcast:person`
- REST API: registra/expone metadatos seleccionados para consumo en tema/front-end
- Subidas: permite subir `mp3` / `m4a`; mejora campos URL con UI de subir/descargar/eliminar

### Notas

- Carbon Fields viene incluido mediante Composer `vendor/` (no necesitas instalar el plugin Carbon Fields aparte).
- El feed depende de reglas de reescritura; al activar suele hacer flush, pero si obtienes 404, ve a “Ajustes → Enlaces permanentes” y pulsa “Guardar cambios”.

## Instalación

1. Sube la carpeta `a-ripple-song-podcast` a `/wp-content/plugins/` (o instala el ZIP desde el admin)
2. Activa el plugin en WordPress
3. Ve a `A Ripple Song` → `Podcast Settings` y completa los datos del canal (título, descripción, autor, portada, etc.)
4. Crea un episodio: `ARS Episodes` → `Add New Episode`, y rellena la caja “Episode Details” (audio + metadatos)
5. Abre `/feed/podcast/` (o `?feed=podcast`) y envíalo a directorios de podcasts

## Preguntas frecuentes

### ¿Cuál es la URL del RSS?

Por defecto: `https://your-site.example/feed/podcast/`. Si los enlaces permanentes están desactivados: `https://your-site.example/?feed=podcast`.

### ¿Por qué /feed/podcast/ devuelve 404 o redirige?

Normalmente porque no se han refrescado las reglas de reescritura. Ve a “Ajustes → Enlaces permanentes” y pulsa “Guardar cambios”. El plugin también intenta un flush único desde el admin.

### ¿Por qué no se rellenan automáticamente duración/tamaño?

Al guardar el episodio, el plugin usa getID3 para analizar el audio. Para URLs remotas puede descargar un archivo temporal; asegúrate de que el servidor puede acceder a la URL y deja tiempo suficiente. Usa el filtro `ars_episode_audio_meta_download_timeout` para ajustar el tiempo de descarga (por defecto: 300 segundos).

### ¿Necesito instalar Carbon Fields?

No. Carbon Fields viene incluido vía Composer y se arranca en `after_setup_theme`.

## Capturas de pantalla

1. `A Ripple Song` → `Podcast Settings` (ajustes del canal)
2. Caja “Episode Details” en la pantalla de edición de `ARS Episodes`
3. Salida RSS en `/feed/podcast/` (incluye tags iTunes / Podcasting 2.0)

## Registro de cambios

### 0.5.0-beta

- Versión beta: CPT de episodios + RSS de podcast + ajustes admin + metacampos del episodio.

## Aviso de actualización

### 0.5.0-beta

Versión beta.
