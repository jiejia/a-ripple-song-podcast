<?php

/**
 * Admin upload MIME support for podcast-related media.
 *
 * Ported from the previous theme implementation.
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/admin
 */
class A_Ripple_Song_Podcast_Media {

	/**
	 * Allow additional audio file types to be uploaded.
	 *
	 * @param array $mimes Existing allowed mime types.
	 * @return array
	 */
	public function allow_upload_mimes( $mimes ) {
		// Audio files.
		$mimes['mp3'] = 'audio/mpeg';
		$mimes['m4a'] = 'audio/x-m4a';

		return $mimes;
	}

	/**
	 * Fix file type detection for custom mime types.
	 *
	 * WordPress performs additional security checks on file uploads that can
	 * incorrectly reject valid files. This filter ensures our allowed types pass validation.
	 *
	 * @param array  $data File data array containing 'ext', 'type', 'proper_filename'.
	 * @param string $file Full path to the file.
	 * @param string $filename The name of the file.
	 * @param array  $mimes Array of mime types keyed by their file extension.
	 * @return array
	 */
	public function fix_filetype_and_ext( $data, $file, $filename, $mimes ) {
		$ext = strtolower( (string) pathinfo( (string) $filename, PATHINFO_EXTENSION ) );

		$custom_mimes = array(
			'mp3' => 'audio/mpeg',
			'm4a' => 'audio/x-m4a',
		);

		if ( isset( $custom_mimes[ $ext ] ) && ( empty( $data['type'] ) || empty( $data['ext'] ) ) ) {
			$data['ext']  = $ext;
			$data['type'] = $custom_mimes[ $ext ];
		}

		return $data;
	}
}

