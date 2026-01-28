[English](README.en_US.md) | [简体中文](README.zh_CN.md) | [繁體中文](README.zh_TW.md) | [繁體中文（香港）](README.zh_HK.md) | [日本語](README.ja.md) | [한국어](README.ko_KR.md) | [Français](README.fr_FR.md) | [Español](README.es_ES.md) | [Português (Brasil)](README.pt_BR.md) | [Русский](README.ru_RU.md) | [हिन्दी](README.hi_IN.md) | [বাংলা](README.bn_BD.md) | [العربية](README.ar.md) | [اردو](README.ur.md)

# A Ripple Song Podcast

- Contribuidores: jiejia
- Link para doação: https://github.com/jiejia/
- Tags: podcast, rss, feed, itunes, apple podcasts, spotify, podcasting 2.0, custom post type, carbon fields
- Requer no mínimo: WordPress 5.0
- Testado até: WordPress 6.9
- Requer PHP: 7.4
- Versão estável: 0.5.0-beta
- Licença: GPLv2 ou superior

Feed RSS de podcast (`/feed/podcast`) + CPT de episódios para o tema A Ripple Song, com suporte a iTunes e Podcasting 2.0.

## Descrição

Este plugin adiciona funcionalidades de podcast ao tema/site “A Ripple Song”: gerencie episódios via um tipo de post personalizado e gere um feed RSS de podcast adequado para Apple Podcasts / Spotify e outros diretórios.

### Principais recursos

- Tipo de post personalizado: Episode (`ars_episode`), slug de arquivo padrão `/podcasts/`
- Taxonomia: Episode Categories (`ars_episode_category`), além de suporte a tags nativas (`post_tag`)
- Feed RSS do podcast: `/feed/podcast/` (ou `?feed=podcast` se os links permanentes estiverem desativados)
- Página de configurações do canal: menu admin `A Ripple Song` → `Podcast Settings`
  - Campos comuns: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, iTunes Title opcional
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt` (código de verificação da Apple), `podcast:funding`
- Campos por episódio (metas do Carbon Fields):
  - URL do áudio (seletor da Biblioteca de Mídia ou URL manual); ao salvar, preenche `duration/length/mime` (via getID3)
  - clean/explicit, episodeType (full/trailer/bonus), episode/season number
  - Capa do episódio, autor por episódio, iTunes Title, Subtitle, Summary, GUID personalizado, iTunes Block
  - Podcasting 2.0: Transcript (`podcast:transcript`), Chapters (`podcast:chapters`), Soundbites (`podcast:soundbite`)
  - Membros/Convidados: saída como entradas `podcast:person`
- REST API: registra/expõe metas selecionadas para consumo no tema/front-end
- Upload: permite `mp3` / `m4a`; melhora campos de URL com UI de upload/download/remover

### Observações

- Carbon Fields está incluído via Composer `vendor/` (não é necessário instalar o plugin Carbon Fields separadamente).
- O feed depende de regras de rewrite; a ativação normalmente faz flush, mas se aparecer 404, vá em “Configurações → Links permanentes” e clique em “Salvar alterações”.

## Instalação

1. Envie a pasta `a-ripple-song-podcast` para `/wp-content/plugins/` (ou instale o ZIP pelo admin)
2. Ative o plugin no WP Admin
3. Vá em `A Ripple Song` → `Podcast Settings` e preencha os dados do canal (título, descrição, autor, capa etc.)
4. Crie um episódio: `ARS Episodes` → `Add New Episode`, e preencha a caixa “Episode Details” (áudio + metadados)
5. Abra `/feed/podcast/` (ou `?feed=podcast`) e envie para os diretórios de podcast

## Perguntas frequentes

### Qual é a URL do RSS?

Por padrão: `https://your-site.example/feed/podcast/`. Se os links permanentes estiverem desativados: `https://your-site.example/?feed=podcast`.

### Por que /feed/podcast/ dá 404 ou redireciona?

Geralmente porque as regras de rewrite não foram atualizadas. Vá em “Configurações → Links permanentes” e clique em “Salvar alterações”. O plugin também tenta um flush único no admin.

### Por que duração/tamanho não são preenchidos automaticamente?

Ao salvar o episódio, o plugin usa getID3 para analisar o áudio. Para URLs remotas, pode baixar um arquivo temporário; verifique se o servidor consegue acessar a URL e deixe tempo suficiente. Use o filtro `ars_episode_audio_meta_download_timeout` para ajustar o tempo de download (padrão: 300 segundos).

### Preciso instalar o plugin Carbon Fields?

Não. O Carbon Fields está incluído via Composer e é inicializado em `after_setup_theme`.

## Capturas de tela

1. `A Ripple Song` → `Podcast Settings` (configurações do canal)
2. Caixa “Episode Details” na tela de edição de `ARS Episodes`
3. Saída RSS em `/feed/podcast/` (inclui tags iTunes / Podcasting 2.0)

## Registro de alterações

### 0.5.0-beta

- Versão beta: CPT de episódios + RSS de podcast + configurações no admin + campos meta do episódio.

## Aviso de atualização

### 0.5.0-beta

Versão beta.
