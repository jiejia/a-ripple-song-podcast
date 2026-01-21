<?php

/**
 * Carbon Fields bootstrap.
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/includes
 */
class A_Ripple_Song_Podcast_Carbon {

	/**
	 * Boot Carbon Fields.
	 */
	public function boot() {
		if ( class_exists( '\Carbon_Fields\Carbon_Fields' ) ) {
			\Carbon_Fields\Carbon_Fields::boot();
		}
	}
}

