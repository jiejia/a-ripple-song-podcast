<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/jiejia
 * @since      1.0.0
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/includes
 * @author     jiejia <jiejia2009@gmail.com>
 */
class A_Ripple_Song_Podcast_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Ensure rewrites are registered before flushing.
		if ( ! class_exists( 'A_Ripple_Song_Podcast_Episodes' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a-ripple-song-podcast-episodes.php';
		}

		if ( ! class_exists( 'A_Ripple_Song_Podcast_Podcast_Feed' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-a-ripple-song-podcast-podcast-feed.php';
		}

		$episodes = new A_Ripple_Song_Podcast_Episodes();
		$episodes->register_post_type();
		$episodes->register_category_taxonomy();
		$episodes->register_tags();

		$feed = new A_Ripple_Song_Podcast_Podcast_Feed();
		$feed->register_feed();

		self::maybe_migrate_from_theme();
		flush_rewrite_rules( false );
	}

	/**
	 * One-time migration from the previous theme's CPT/taxonomy names.
	 *
	 * - `podcast` -> `ars_episode`
	 * - `podcast_category` -> `ars_episode_category`
	 */
	private static function maybe_migrate_from_theme() {
		$flag = 'ars_podcast_migrated_v1';
		if ( get_option( $flag ) ) {
			return;
		}

		global $wpdb;

		// Migrate post type.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- One-time activation migration.
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$wpdb->posts} SET post_type = %s WHERE post_type = %s",
				A_Ripple_Song_Podcast_Episodes::POST_TYPE,
				'podcast'
			)
		);

		// Migrate taxonomy.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- One-time activation migration.
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$wpdb->term_taxonomy} SET taxonomy = %s WHERE taxonomy = %s",
				A_Ripple_Song_Podcast_Episodes::TAXONOMY,
				'podcast_category'
			)
		);

		self::maybe_migrate_member_meta();

		update_option( $flag, '1', 'no' );
	}

	/**
	 * Migrate old CMB2-style member/guest meta to Carbon Fields association values.
	 *
	 * Old format (multicheck): [ user_id => 'on', ... ]
	 * New format (association): [ 'user:user:123', ... ] (or structured arrays saved by Carbon Fields).
	 */
	private static function maybe_migrate_member_meta() {
		$post_ids = get_posts(
			array(
				'post_type'      => A_Ripple_Song_Podcast_Episodes::POST_TYPE,
				'post_status'    => 'any',
					'fields'         => 'ids',
					'posts_per_page' => -1,
					// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- One-time activation migration.
					'meta_query'     => array(
						'relation' => 'OR',
						array(
							'key'     => 'members',
						'compare' => 'EXISTS',
					),
					array(
						'key'     => 'guests',
						'compare' => 'EXISTS',
					),
				),
			)
		);

		foreach ( $post_ids as $post_id ) {
			self::maybe_migrate_member_meta_key( (int) $post_id, 'members' );
			self::maybe_migrate_member_meta_key( (int) $post_id, 'guests' );
		}
	}

	private static function maybe_migrate_member_meta_key( $post_id, $meta_key ) {
		$value = get_post_meta( $post_id, $meta_key, true );

		if ( empty( $value ) || ! is_array( $value ) ) {
			return;
		}

		$first = reset( $value );
		if ( is_array( $first ) && isset( $first['type'] ) && isset( $first['id'] ) ) {
			// Already Carbon Fields association format.
			return;
		}

		if ( is_string( $first ) && strpos( $first, ':' ) !== false ) {
			// Already type:subtype:id strings.
			return;
		}

		$ids = array();
		foreach ( $value as $k => $v ) {
			if ( is_numeric( $k ) ) {
				$ids[] = (int) $k;
			}
			if ( is_numeric( $v ) ) {
				$ids[] = (int) $v;
			}
		}

		$ids = array_values(
			array_filter(
				array_unique( $ids ),
				static function ( $id ) {
					return $id > 0;
				}
			)
		);

		if ( empty( $ids ) ) {
			return;
		}

		$new = array();
		foreach ( $ids as $id ) {
			$new[] = 'user:user:' . (int) $id;
		}

		update_post_meta( $post_id, $meta_key, $new );
	}

}
