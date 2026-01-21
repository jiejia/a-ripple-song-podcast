<?php

/**
 * Carbon Fields UI translations hotfix.
 *
 * Carbon Fields relies on the `carbon-fields-ui` textdomain for JS strings like:
 * - "There are no entries yet."
 * - "Add %s"
 *
 * This plugin bundles Carbon Fields, but the shipped Carbon Fields UI language
 * files may not cover all locales (e.g. zh_CN/zh_TW/zh_HK). Also, some Carbon
 * Fields versions load UI textdomains using `get_locale()` instead of the admin
 * user's locale.
 *
 * We inject missing locale strings via `carbon_fields_config` so the UI always
 * reflects the current admin language without modifying Carbon Fields itself.
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/admin
 */
class A_Ripple_Song_Podcast_Carbon_Fields_UI_I18n {

	/**
	 * Inject UI translations used by Carbon Fields JS.
	 *
	 * @param array $config
	 * @return array
	 */
	public function filter_carbon_fields_config( $config ) {
		if ( ! is_array( $config ) || ! isset( $config['config'] ) || ! is_array( $config['config'] ) ) {
			return $config;
		}

		if ( ! isset( $config['config']['locale'] ) || ! is_array( $config['config']['locale'] ) ) {
			$config['config']['locale'] = array();
		}

		$locale = is_admin() ? get_user_locale() : get_locale();

		$translations = $this->get_overrides_for_locale( $locale );
		if ( empty( $translations ) ) {
			return $config;
		}

		// Ensure Jed metadata exists.
		if ( ! isset( $config['config']['locale'][''] ) || ! is_array( $config['config']['locale'][''] ) ) {
			$config['config']['locale'][''] = array(
				'domain' => 'carbon-fields-ui',
				'lang'   => $locale,
			);
		}

		foreach ( $translations as $msgid => $translation ) {
			$config['config']['locale'][ $msgid ] = array( $translation );
		}

		return $config;
	}

	/**
	 * Get string overrides for a given locale.
	 *
	 * @param string $locale
	 * @return array<string,string>
	 */
	private function get_overrides_for_locale( $locale ) {
		$locale = (string) $locale;

		// Normalize locales like zh_HK -> zh_HK, but also accept zh_CN etc.
		switch ( $locale ) {
			case 'zh_CN':
				return array(
					'There are no entries yet.' => '暂无条目。',
					'Add %s'                    => '添加 %s',
				);
			case 'zh_TW':
			case 'zh_HK':
				return array(
					'There are no entries yet.' => '尚無項目。',
					'Add %s'                    => '新增 %s',
				);
			default:
				return array();
		}
	}
}

