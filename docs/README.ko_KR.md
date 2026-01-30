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

<h3 align="center">팟캐스트 RSS용 WordPress 플러그인</h3>

<p align="center">
  <a href="https://doc-podcast.aripplesong.me/docs/intro">📖 튜토리얼</a> •
  <a href="https://doc-podcast.aripplesong.me/blog">📝 블로그</a> •
  <a href="https://github.com/jiejia/a-ripple-song-podcast">⭐ GitHub</a>
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.6+-21759B?style=flat-square&logo=wordpress&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-GPL--3.0-blue?style=flat-square">
</p>

---

# A Ripple Song Podcast

> A Ripple Song 테마용 Podcast RSS(`/feed/podcast`) + Episode 커스텀 포스트 타입. iTunes 및 Podcasting 2.0 태그 지원.

## ✨ 설명

이 플러그인은 “A Ripple Song” 테마/사이트에 팟캐스트 기능을 추가합니다. 커스텀 포스트 타입으로 에피소드를 관리하고 Apple Podcasts / Spotify 등 디렉터리에 제출 가능한 팟캐스트 RSS 피드를 생성합니다.

### 주요 기능

- 커스텀 포스트 타입: Episode(`ars_episode`), 아카이브 슬러그 기본값 `/podcasts/`
- 택소노미: Episode Categories(`ars_episode_category`), 기본 태그(`post_tag`) 지원
- 팟캐스트 RSS 피드: `/feed/podcast/` (고정 링크 비활성화 시 `?feed=podcast`)
- 채널 설정 페이지: 관리자 메뉴 `A Ripple Song` → `Podcast Settings`
  - 기본 필드: Title / Subtitle / Description / Author / Owner / Language / Cover / Categories
  - iTunes: `itunes:type`, `itunes:block`, `itunes:complete`, `itunes:new-feed-url`, 선택적 iTunes Title
  - Podcasting 2.0: `podcast:locked`, `podcast:guid`, `podcast:txt`(Apple 검증 코드), `podcast:funding`
- 에피소드(episode) 필드(Carbon Fields 메타):
  - 오디오 URL(미디어 라이브러리 선택 또는 수동 URL); 저장 시 `duration/length/mime` 자동 채움(getID3)
  - clean/explicit, episodeType(full/trailer/bonus), episode/season number
  - 에피소드 커버, 에피소드별 author 오버라이드, iTunes Title, Subtitle, Summary, Custom GUID, iTunes Block
  - Podcasting 2.0: Transcript(`podcast:transcript`), Chapters(`podcast:chapters`), Soundbites(`podcast:soundbite`)
  - Members/Guests: `podcast:person` 항목으로 출력
- REST API: 테마/프론트엔드 사용을 위해 일부 에피소드 메타 등록/노출
- 업로드 지원: `mp3` / `m4a` 업로드 허용, URL 필드에 업로드/다운로드/제거 UI 강화

### 참고

- Carbon Fields는 Composer `vendor/`에 번들로 포함되어 있습니다(별도의 Carbon Fields 플러그인 설치 불필요).
- 피드는 rewrite 규칙에 의존합니다. 활성화 시 보통 자동 flush 되지만 404가 나면 “설정 → 고정 링크”에서 “변경 사항 저장”을 클릭하세요.

## 🚀 설치

1. `a-ripple-song-podcast` 폴더를 `/wp-content/plugins/`에 업로드(또는 관리자에서 ZIP 설치)
2. 플러그인 활성화
3. `A Ripple Song` → `Podcast Settings`에서 채널 메타데이터(제목/설명/작성자/커버 등) 입력
4. `ARS Episodes` → `Add New Episode`에서 에피소드 생성 후 “Episode Details” 메타박스에 오디오 및 메타 입력
5. `/feed/podcast/`(또는 `?feed=podcast`)를 열어 팟캐스트 디렉터리에 제출

## ❓ 자주 묻는 질문

### RSS URL은 무엇인가요?

기본값은 `https://your-site.example/feed/podcast/`입니다. 고정 링크가 비활성화되어 있으면 `https://your-site.example/?feed=podcast`를 사용하세요.

### /feed/podcast/가 404 또는 리다이렉트됩니다

대개 rewrite 규칙이 flush되지 않았기 때문입니다. “설정 → 고정 링크”에서 “변경 사항 저장”을 클릭하세요. 플러그인도 관리자에서 1회 flush를 시도합니다.

### duration/size가 자동으로 채워지지 않습니다

에피소드 저장 시 getID3로 오디오를 분석합니다. 원격 URL은 임시 파일을 다운로드한 뒤 분석할 수 있으니, 서버에서 접근 가능한 URL인지 확인하고 충분한 시간을 허용하세요. `ars_episode_audio_meta_download_timeout` 필터로 다운로드 타임아웃(기본 300초)을 조정할 수 있습니다.

### Carbon Fields 플러그인을 설치해야 하나요?

아니요. Carbon Fields는 번들로 포함되어 있으며 `after_setup_theme`에서 부팅됩니다.

## 🖼️ 스크린샷

1. `A Ripple Song` → `Podcast Settings`(채널 설정)
2. `ARS Episodes` 편집 화면의 “Episode Details” 메타박스
3. `/feed/podcast/` RSS 출력(iTunes / Podcasting 2.0 태그 포함)

## 📝 변경 로그

### 0.5.0

- 베타 릴리스: Episode CPT + Podcast RSS 피드 + 관리자 설정 + 에피소드 메타 필드.

## 🔔 업그레이드 안내

### 0.5.0

베타 릴리스.
