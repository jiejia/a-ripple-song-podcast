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
 * Version:           0.5.0-beta
 * Author:            jiejia
 * Author URI:        https://github.com/jiejia/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Text Domain:       a-ripple-song-podcast
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.5.0-beta and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'A_RIPPLE_SONG_PODCAST_VERSION', '0.5.0-beta' );

$autoload = __DIR__ . '/vendor/autoload.php';
$scoper_autoload = __DIR__ . '/vendor/scoper-autoload.php';
if ( file_exists( $scoper_autoload ) ) {
	require_once $scoper_autoload;
} elseif ( file_exists( $autoload ) ) {
	require_once $autoload;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-a-ripple-song-podcast-activator.php
 */
function activate_a_ripple_song_podcast() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a-ripple-song-podcast-activator.php';
	A_Ripple_Song_Podcast_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-a-ripple-song-podcast-deactivator.php
 */
function deactivate_a_ripple_song_podcast() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-a-ripple-song-podcast-deactivator.php';
	A_Ripple_Song_Podcast_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_a_ripple_song_podcast' );
register_deactivation_hook( __FILE__, 'deactivate_a_ripple_song_podcast' );

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
function run_a_ripple_song_podcast() {

	$plugin = new A_Ripple_Song_Podcast();
	$plugin->run();

}
run_a_ripple_song_podcast();
