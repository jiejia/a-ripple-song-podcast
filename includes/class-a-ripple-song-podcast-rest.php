<?php

/**
 * REST API integration (expose episode meta).
 *
 * WordPress REST endpoints only include custom fields under `meta` when those
 * meta keys are registered with `show_in_rest`.
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/includes
 */
class A_Ripple_Song_Podcast_REST {

	/**
	 * Register Episode Details meta keys for REST output.
	 */
	public function register_episode_meta() {
		$post_type = A_Ripple_Song_Podcast_Episodes::POST_TYPE;

		// Carbon Fields stores post meta as protected keys (leading underscore).
		// Register only scalar fields here. Complex/association fields are exposed via register_rest_field.
		$this->register_string_meta( $post_type, '_audio_file', true, true );
		$this->register_int_meta( $post_type, '_duration' );
		$this->register_int_meta( $post_type, '_audio_length' );
		$this->register_string_meta( $post_type, '_audio_mime' );

		$this->register_string_meta( $post_type, '_episode_explicit' );
		$this->register_string_meta( $post_type, '_episode_type' );
		$this->register_int_meta( $post_type, '_episode_number' );
		$this->register_int_meta( $post_type, '_season_number' );

		$this->register_string_meta( $post_type, '_episode_author' );
		$this->register_string_meta( $post_type, '_episode_image', true, true );
		$this->register_string_meta( $post_type, '_episode_transcript', true, true );
		$this->register_string_meta( $post_type, '_itunes_title' );
		$this->register_string_meta( $post_type, '_episode_chapters', true, true );
		$this->register_string_meta( $post_type, '_episode_chapters_type' );

		$this->register_string_meta( $post_type, '_episode_subtitle' );
		$this->register_string_meta( $post_type, '_episode_summary' );
		$this->register_string_meta( $post_type, '_episode_guid' );
		$this->register_string_meta( $post_type, '_episode_block' );
	}

	/**
	 * Expose selected Episode Details fields as top-level REST fields (theme parity).
	 *
	 * @return void
	 */
	public function register_episode_rest_fields() {
		$post_type = A_Ripple_Song_Podcast_Episodes::POST_TYPE;

		register_rest_field(
			$post_type,
			'audio_file',
			array(
				'get_callback' => static function ( $post, $field_name, $request ) {
					return (string) A_Ripple_Song_Podcast_REST::get_episode_value( (int) $post['id'], 'audio_file', '' );
				},
				'schema'       => array(
					'description' => __( 'Audio file URL', 'a-ripple-song-podcast' ),
					'type'        => 'string',
				),
			)
		);

		register_rest_field(
			$post_type,
			'duration',
			array(
				'get_callback' => static function ( $post, $field_name, $request ) {
					return (int) A_Ripple_Song_Podcast_REST::get_episode_value( (int) $post['id'], 'duration', 0 );
				},
				'schema'       => array(
					'description' => __( 'Audio duration (seconds)', 'a-ripple-song-podcast' ),
					'type'        => 'integer',
				),
			)
		);

		register_rest_field(
			$post_type,
			'episode_transcript',
			array(
				'get_callback' => static function ( $post, $field_name, $request ) {
					return (string) A_Ripple_Song_Podcast_REST::get_episode_value( (int) $post['id'], 'episode_transcript', '' );
				},
				'schema'       => array(
					'description' => __( 'Episode transcript URL', 'a-ripple-song-podcast' ),
					'type'        => 'string',
				),
			)
		);
	}

	/**
	 * Read an episode field from Carbon Fields (preferred) or the underscored meta key fallback.
	 *
	 * @param int          $post_id
	 * @param string       $key
	 * @param string|int   $default
	 * @return string|int
	 */
	private static function get_episode_value( $post_id, $key, $default ) {
		if ( function_exists( 'carbon_get_post_meta' ) ) {
			$value = carbon_get_post_meta( $post_id, $key );
			if ( null !== $value && '' !== $value && array() !== $value ) {
				return $value;
			}
		}

		$raw = get_post_meta( $post_id, '_' . ltrim( (string) $key, '_' ), true );
		if ( '' === $raw || null === $raw ) {
			return $default;
		}

		return $raw;
	}

	private function register_string_meta( $post_type, $key, $is_url = false, $public_read = false ) {
		$args = array(
			'type'              => 'string',
			'single'            => true,
			'sanitize_callback' => $is_url ? 'esc_url_raw' : 'sanitize_text_field',
			'auth_callback'     => '__return_true',
			'show_in_rest'      => array(
				'schema' => array(
					'type'    => 'string',
					'default' => '',
					'context' => array( 'view', 'edit' ),
					'format'  => $is_url ? 'uri' : null,
				),
			),
		);

		// Remove null format key.
		if ( empty( $args['show_in_rest']['schema']['format'] ) ) {
			unset( $args['show_in_rest']['schema']['format'] );
		}

		register_post_meta( $post_type, $key, $args );
	}

	private function register_int_meta( $post_type, $key ) {
		register_post_meta(
			$post_type,
			$key,
			array(
				'type'              => 'integer',
				'single'            => true,
				'sanitize_callback' => 'absint',
				'auth_callback'     => '__return_true',
				'show_in_rest'      => array(
					'schema' => array(
						'type'    => 'integer',
						'default' => 0,
						'context' => array( 'view', 'edit' ),
					),
				),
			)
		);
	}

	private function register_array_meta( $post_type, $key, $items_schema ) {
		register_post_meta(
			$post_type,
			$key,
			array(
				'type'          => 'array',
				'single'        => true,
				'auth_callback' => '__return_true',
				'show_in_rest'  => array(
					'schema' => array(
						'type'    => 'array',
						'default' => array(),
						'context' => array( 'view', 'edit' ),
						'items'   => $items_schema,
					),
				),
			)
		);
	}
}
