<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Episode meta fields (Carbon Fields post meta).
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/includes
 */
class A_Ripple_Song_Podcast_Episode_Fields {

	/**
	 * Register the Carbon Fields container for episode meta.
	 */
	public function register_fields() {
		if ( ! class_exists( 'A_Ripple_Song_Podcast_Carbon_Compat' ) ) {
			return;
		}

		$container_class = A_Ripple_Song_Podcast_Carbon_Compat::container_class();
		$field_class     = A_Ripple_Song_Podcast_Carbon_Compat::field_class();

		if ( ! $container_class || ! $field_class ) {
			return;
		}

		$default_members = $this->get_default_members_value();

		$container_class::make( 'post_meta', 'ars_episode_details', __( 'Episode Details', 'a-ripple-song-podcast' ) )
			->where( 'post_type', '=', A_Ripple_Song_Podcast_Episodes::POST_TYPE )
			->set_context( 'normal' )
			->set_priority( 'high' )
			->add_fields(
				array(
					$field_class::make( 'text', 'audio_file', __( 'Audio File', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Required. Upload an audio file or enter audio file URL (https).', 'a-ripple-song-podcast' ) )
						->set_required( true )
						->set_attribute( 'type', 'url' )
						->set_attribute( 'placeholder', 'https://' )
						->set_attribute( 'data-ars-media-uploader', 'audio' ),
					$field_class::make( 'text', 'duration', __( 'Duration (seconds)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Auto detected from "Audio File" on save.', 'a-ripple-song-podcast' ) )
						->set_attribute( 'type', 'number' )
						->set_attribute( 'min', '0' )
						->set_attribute( 'step', '1' )
						->set_attribute( 'readOnly', 'readOnly' ),
					$field_class::make( 'text', 'audio_length', __( 'Audio Length (bytes)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Auto detected from "Audio File" on save.', 'a-ripple-song-podcast' ) )
						->set_attribute( 'type', 'number' )
						->set_attribute( 'min', '1' )
						->set_attribute( 'readOnly', 'readOnly' ),
					$field_class::make( 'text', 'audio_mime', __( 'Audio MIME Type', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Auto detected from "Audio File" on save.', 'a-ripple-song-podcast' ) )
						->set_default_value( 'audio/mpeg' )
						->set_attribute( 'readOnly', 'readOnly' ),
					$field_class::make( 'radio', 'episode_explicit', __( 'Explicit', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Required. clean / explicit.', 'a-ripple-song-podcast' ) )
						->set_options(
							array(
								'clean'    => __( 'clean', 'a-ripple-song-podcast' ),
								'explicit' => __( 'explicit', 'a-ripple-song-podcast' ),
							)
						)
						->set_default_value( 'clean' )
						->set_required( true ),
					$field_class::make( 'select', 'episode_type', __( 'Episode Type', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Required. full / trailer / bonus', 'a-ripple-song-podcast' ) )
						->set_options(
							array(
								'full'    => __( 'full', 'a-ripple-song-podcast' ),
								'trailer' => __( 'trailer', 'a-ripple-song-podcast' ),
								'bonus'   => __( 'bonus', 'a-ripple-song-podcast' ),
							)
						)
						->set_default_value( 'full' )
						->set_required( true ),
					$field_class::make( 'text', 'episode_number', __( 'Episode Number', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional but recommended. Integer.', 'a-ripple-song-podcast' ) )
						->set_attribute( 'type', 'number' )
						->set_attribute( 'min', '0' )
						->set_attribute( 'step', '1' ),
					$field_class::make( 'text', 'season_number', __( 'Season Number', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Integer.', 'a-ripple-song-podcast' ) )
						->set_attribute( 'type', 'number' )
						->set_attribute( 'min', '0' )
						->set_attribute( 'step', '1' ),
					$field_class::make( 'text', 'episode_author', __( 'Episode Author (override)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Overrides channel author for this episode.', 'a-ripple-song-podcast' ) ),
					$field_class::make( 'image', 'episode_image', __( 'Episode Cover (square)', 'a-ripple-song-podcast' ) )
						->set_value_type( 'url' )
						->set_help_text( __( 'Optional. Square 1400–3000px. Overrides channel cover.', 'a-ripple-song-podcast' ) ),
					$field_class::make( 'text', 'episode_transcript', __( 'Transcript (optional)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Upload a transcript file (vtt/srt/txt/pdf) or enter a transcript URL (https).', 'a-ripple-song-podcast' ) )
						->set_attribute( 'type', 'url' )
						->set_attribute( 'placeholder', 'https://' )
						->set_attribute( 'data-ars-media-uploader', 'transcript' ),
					$field_class::make( 'text', 'itunes_title', __( 'iTunes Title (optional)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Apple Podcasts: overrides the episode title for <itunes:title>.', 'a-ripple-song-podcast' ) ),
					$field_class::make( 'text', 'episode_chapters', __( 'Chapters (Podcasting 2.0)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Provide a chapters JSON URL/file for <podcast:chapters>.', 'a-ripple-song-podcast' ) )
						->set_attribute( 'type', 'url' )
						->set_attribute( 'placeholder', 'https://' )
						->set_attribute( 'data-ars-media-uploader', 'chapters' ),
					$field_class::make( 'text', 'episode_chapters_type', __( 'Chapters MIME Type', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Defaults to application/json+chapters.', 'a-ripple-song-podcast' ) )
						->set_default_value( 'application/json+chapters' ),
					$field_class::make( 'complex', 'episode_soundbites', __( 'Soundbites (Podcasting 2.0)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Adds one or more <podcast:soundbite> tags.', 'a-ripple-song-podcast' ) )
						->setup_labels(
							array(
								'singular_name' => __( 'Soundbite', 'a-ripple-song-podcast' ),
								'plural_name'   => __( 'Soundbites', 'a-ripple-song-podcast' ),
							)
						)
						->add_fields(
							array(
								$field_class::make( 'text', 'start_time', __( 'Start Time (seconds)', 'a-ripple-song-podcast' ) )
									->set_attribute( 'type', 'number' )
									->set_attribute( 'min', '0' )
									->set_attribute( 'step', '0.01' ),
								$field_class::make( 'text', 'duration', __( 'Duration (seconds)', 'a-ripple-song-podcast' ) )
									->set_attribute( 'type', 'number' )
									->set_attribute( 'min', '0.01' )
									->set_attribute( 'step', '0.01' ),
								$field_class::make( 'text', 'title', __( 'Title (optional)', 'a-ripple-song-podcast' ) ),
							)
						),
					$field_class::make( 'text', 'episode_subtitle', __( 'Subtitle', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Short subtitle for iTunes.', 'a-ripple-song-podcast' ) ),
					$field_class::make( 'textarea', 'episode_summary', __( 'Summary', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. Plain text summary for iTunes.', 'a-ripple-song-podcast' ) ),
					$field_class::make( 'text', 'episode_guid', __( 'Custom GUID (optional)', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. If empty, feed uses WP permalink as GUID.', 'a-ripple-song-podcast' ) ),
					$field_class::make( 'radio', 'episode_block', __( 'iTunes Block', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Optional. yes = hide this episode in Apple Podcasts.', 'a-ripple-song-podcast' ) )
						->set_options(
							array(
								'no'  => __( 'no', 'a-ripple-song-podcast' ),
								'yes' => __( 'yes', 'a-ripple-song-podcast' ),
							)
						)
						->set_default_value( 'no' ),
					$field_class::make( 'association', 'members', __( 'Members', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Select episode members (administrators, authors, editors).', 'a-ripple-song-podcast' ) )
						->set_types(
							array(
								array(
									'type' => 'user',
								),
							)
						)
						->set_default_value( $default_members ),
					$field_class::make( 'association', 'guests', __( 'Guests', 'a-ripple-song-podcast' ) )
						->set_help_text( __( 'Select episode guests (contributors).', 'a-ripple-song-podcast' ) )
						->set_types(
							array(
								array(
									'type' => 'user',
								),
							)
						),
				)
			);
	}

	/**
	 * Default selected member when creating a new episode.
	 *
	 * @return array<int,string>
	 */
	private function get_default_members_value() {
		$current_user_id = get_current_user_id();
		if ( ! $current_user_id ) {
			return array();
		}

		$current_user = get_userdata( $current_user_id );
		if ( ! $current_user ) {
			return array();
		}

		$allowed_roles = array( 'administrator', 'author', 'editor' );
		if ( empty( array_intersect( $allowed_roles, (array) $current_user->roles ) ) ) {
			return array();
		}

		// Association field values are stored as type:subtype:id strings (or as structured arrays).
		return array( 'user:user:' . (int) $current_user_id );
	}
}
