<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate plugin information in the admin area.
 *
 * It loads dependencies, registers activation/deactivation hooks, and boots the
 * plugin (custom post type + podcast RSS feed + admin settings).
 *
 * @link              https://github.com/jiejia/a-ripple-song-podcast
 * @since             0.5.0
 * @package           A_Ripple_Song_Podcast
 *
 * @wordpress-plugin
 * Plugin Name:       A Ripple Song Podcast
 * Plugin URI:        https://github.com/jiejia/a-ripple-song-podcast
 * Description:       Podcast features for the A Ripple Song theme: Episode CPT + /feed/podcast RSS (iTunes & Podcasting 2.0 tags).
 * Version:           0.5.0
 * Author:            jiejia
 * Author URI:        https://github.com/jiejia/
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 6.6
 * Requires PHP:      8.2
 * Text Domain:       a-ripple-song-podcast
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( PHP_VERSION_ID < 80200 ) {
	add_action(
		'admin_notices',
		static function () {
			$message = sprintf(
				'A Ripple Song Podcast requires PHP %s or higher. Your server is running PHP %s.',
				'8.2',
				PHP_VERSION
			);

			printf(
				'<div class="notice notice-error"><p>%s</p></div>',
				esc_html( $message )
			);
		}
	);

	return;
}

if ( isset( $GLOBALS['wp_version'] ) && version_compare( $GLOBALS['wp_version'], '6.6', '<' ) ) {
	add_action(
		'admin_notices',
		static function () {
			$message = sprintf(
				'A Ripple Song Podcast requires WordPress %s or higher. Your site is running WordPress %s.',
				'6.6',
				$GLOBALS['wp_version']
			);

			printf(
				'<div class="notice notice-error"><p>%s</p></div>',
				esc_html( $message )
			);
		}
	);

	return;
}

/**
 * Currently plugin version.
 * Start at version 0.5.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'A_RIPPLE_SONG_PODCAST_VERSION', '0.5.0' );

$a_ripple_song_podcast_autoload        = __DIR__ . '/vendor/autoload.php';
$a_ripple_song_podcast_scoper_autoload = __DIR__ . '/vendor/scoper-autoload.php';
if ( file_exists( $a_ripple_song_podcast_scoper_autoload ) ) {
	require_once $a_ripple_song_podcast_scoper_autoload;
} elseif ( file_exists( $a_ripple_song_podcast_autoload ) ) {
	require_once $a_ripple_song_podcast_autoload;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-a-ripple-song-podcast-activator.php
 */
function a_ripple_song_podcast_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a-ripple-song-podcast-activator.php';
	A_Ripple_Song_Podcast_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-a-ripple-song-podcast-deactivator.php
 */
function a_ripple_song_podcast_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a-ripple-song-podcast-deactivator.php';
	A_Ripple_Song_Podcast_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'a_ripple_song_podcast_activate' );
register_deactivation_hook( __FILE__, 'a_ripple_song_podcast_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-a-ripple-song-podcast.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function a_ripple_song_podcast_run() {

	$plugin = new A_Ripple_Song_Podcast();
	$plugin->run();

}
a_ripple_song_podcast_run();
