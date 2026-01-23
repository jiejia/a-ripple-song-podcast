<?php

/**
 * Episode save hooks (auto-fill audio meta, defaults, admin notices).
 *
 * @package    A_Ripple_Song_Podcast
 * @subpackage A_Ripple_Song_Podcast/includes
 */
class A_Ripple_Song_Podcast_Episode_Save {

	/**
	 * Meta key used for storing last audio meta extraction error.
	 */
	private const AUDIO_META_LAST_ERROR_KEY = '_podcast_audio_meta_last_error';

	/**
	 * Persist the last audio meta error in a structured way so we can translate it on display.
	 *
	 * @param int    $post_id
	 * @param string $code
	 * @param string $detail
	 */
	private function set_audio_meta_last_error( $post_id, $code, $detail = '' ) {
		update_post_meta(
			$post_id,
			self::AUDIO_META_LAST_ERROR_KEY,
			array(
				'code'   => (string) $code,
				'detail' => (string) $detail,
			)
		);
	}

	/**
	 * Clear the last audio meta error.
	 *
	 * @param int $post_id
	 */
	private function clear_audio_meta_last_error( $post_id ) {
		delete_post_meta( $post_id, self::AUDIO_META_LAST_ERROR_KEY );
	}

	/**
	 * Post meta container saved callback.
	 *
	 * @param int   $post_id
	 * @param mixed $container
	 */
	public function on_post_meta_saved( $post_id, $container ) {
		if ( get_post_type( $post_id ) !== A_Ripple_Song_Podcast_Episodes::POST_TYPE ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$this->auto_fill_audio_meta( $post_id );
	}

	/**
	 * Auto calculate audio meta after save.
	 */
	private function auto_fill_audio_meta( $post_id ) {
		$auto_meta = $this->calculate_audio_meta( $post_id );

		if ( ! empty( $auto_meta['duration'] ) ) {
			$this->set_episode_field_value( $post_id, 'duration', (int) $auto_meta['duration'] );
		}

		if ( ! empty( $auto_meta['length'] ) ) {
			$this->set_episode_field_value( $post_id, 'audio_length', (int) $auto_meta['length'] );
		}

		if ( ! empty( $auto_meta['mime'] ) ) {
			$this->set_episode_field_value( $post_id, 'audio_mime', (string) $auto_meta['mime'] );
		}
	}

	/**
	 * Persist an Episode Details field using Carbon Fields when available.
	 *
	 * @param int          $post_id
	 * @param string       $key
	 * @param string|int   $value
	 * @return void
	 */
	private function set_episode_field_value( $post_id, $key, $value ) {
		if ( function_exists( 'carbon_set_post_meta' ) ) {
			carbon_set_post_meta( $post_id, $key, $value );
			return;
		}

		update_post_meta( $post_id, '_' . ltrim( (string) $key, '_' ), $value );
	}

	/**
	 * Calculate podcast audio metadata (duration, length, mime) via getID3.
	 *
	 * @param int    $post_id
	 * @param string $audio_url
	 * @return array{duration:int|null,length:int|null,mime:string|null}
	 */
	private function calculate_audio_meta( $post_id, $audio_url = '' ) {
		$result = array(
			'duration' => null,
			'length'   => null,
			'mime'     => null,
		);

		if ( $audio_url === '' ) {
			$audio_url = $this->get_episode_field_value( $post_id, 'audio_file' );
		}

		if ( $audio_url === '' ) {
			return $result;
		}

		$last_error_code   = null;
		$last_error_detail = '';

		if ( ! class_exists( 'getID3' ) ) {
			$maybe = ABSPATH . WPINC . '/ID3/getid3.php';
			if ( file_exists( $maybe ) ) {
				require_once $maybe;
			}
		}

		if ( ! class_exists( 'getID3' ) ) {
			$last_error_code = 'getid3_missing';
			error_log( "Episode #{$post_id}: getID3 not available" );
			$this->set_audio_meta_last_error( $post_id, $last_error_code );
			return $result;
		}

		$upload_dir = wp_get_upload_dir();
		$file_path  = $audio_url;

		if ( filter_var( $audio_url, FILTER_VALIDATE_URL ) ) {
			$file_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $audio_url );

			if ( ! file_exists( $file_path ) ) {
				$audio_path       = (string) wp_parse_url( $audio_url, PHP_URL_PATH );
				$audio_path       = $audio_path !== '' ? rawurldecode( $audio_path ) : '';
				$uploads_url_path = (string) wp_parse_url( $upload_dir['baseurl'], PHP_URL_PATH );

				if ( $audio_path !== '' && $uploads_url_path !== '' && strpos( $audio_path, $uploads_url_path ) === 0 ) {
					$relative  = ltrim( substr( $audio_path, strlen( $uploads_url_path ) ), '/' );
					$file_path = trailingslashit( $upload_dir['basedir'] ) . $relative;
				}
			}
		}

		if ( ! file_exists( $file_path ) ) {
			$uploads_basedir      = isset( $upload_dir['basedir'] ) ? (string) $upload_dir['basedir'] : '';
			$uploads_basedir_real = $uploads_basedir !== '' ? realpath( $uploads_basedir ) : false;
			$uploads_basedir_real = $uploads_basedir_real !== false ? wp_normalize_path( $uploads_basedir_real ) : false;

			$url_path = '';

			if ( filter_var( $audio_url, FILTER_VALIDATE_URL ) ) {
				$parsed_url = wp_parse_url( $audio_url );
				$url_path   = isset( $parsed_url['path'] ) ? (string) $parsed_url['path'] : '';
			} elseif ( is_string( $audio_url ) && strpos( $audio_url, '/' ) === 0 ) {
				$url_path = $audio_url;
			}

			if ( $uploads_basedir_real && $url_path !== '' ) {
				$candidate      = ABSPATH . ltrim( rawurldecode( $url_path ), '/' );
				$candidate_real = realpath( $candidate );
				if ( $candidate_real !== false ) {
					$candidate_real = wp_normalize_path( $candidate_real );
					if ( strpos( $candidate_real, $uploads_basedir_real . '/' ) === 0 || $candidate_real === $uploads_basedir_real ) {
						$file_path = $candidate_real;
					}
				}
			}
		}

		if ( ! file_exists( $file_path ) ) {
			if ( $this->is_valid_http_url( $audio_url ) ) {
				$request_url = $this->encode_url_for_request( $audio_url );

				if ( function_exists( 'wp_http_validate_url' ) && ! wp_http_validate_url( $request_url ) ) {
					$last_error_code = 'audio_url_rejected';
					error_log( "Episode #{$post_id}: audio URL rejected by wp_http_validate_url" );
					$this->set_audio_meta_last_error( $post_id, $last_error_code );
					return $result;
				}

				if ( ! function_exists( 'download_url' ) ) {
					require_once ABSPATH . 'wp-admin/includes/file.php';
				}

				$timeout = (int) apply_filters( 'ars_episode_audio_meta_download_timeout', 300, $audio_url, $post_id );
				if ( $timeout < 30 ) {
					$timeout = 30;
				}

				$tmp = download_url( $request_url, $timeout );
				if ( is_wp_error( $tmp ) ) {
					$last_error_code   = 'audio_download_failed';
					$last_error_detail = (string) $tmp->get_error_message();
					error_log( "Episode #{$post_id}: audio download failed - {$last_error_detail}" );
					$this->set_audio_meta_last_error( $post_id, $last_error_code, $last_error_detail );
					return $result;
				}

				try {
					$getID3    = new \getID3();
					$file_info = $getID3->analyze( $tmp );

					if ( isset( $file_info['playtime_seconds'] ) ) {
						$result['duration'] = (int) round( $file_info['playtime_seconds'] );
					} else {
						$last_error_code = 'getid3_no_playtime_download';
					}

					$tmp_size = @filesize( $tmp );
					if ( $tmp_size !== false ) {
						$result['length'] = (int) $tmp_size;
					}

					if ( ! empty( $file_info['mime_type'] ) ) {
						$result['mime'] = (string) $file_info['mime_type'];
					}
				} catch ( \Exception $e ) {
					$last_error_code   = 'getid3_error';
					$last_error_detail = (string) $e->getMessage();
					error_log( "Episode #{$post_id}: getID3 error - {$last_error_detail}" );
				} finally {
					@unlink( $tmp );
				}

				if ( $last_error_code ) {
					$this->set_audio_meta_last_error( $post_id, $last_error_code, $last_error_detail );
				} elseif ( ! empty( $result['duration'] ) ) {
					$this->clear_audio_meta_last_error( $post_id );
				}

				return $result;
			}

			$last_error_code = 'audio_file_missing';
			error_log( "Episode #{$post_id}: audio file missing for duration/size/mime detection" );
			$this->set_audio_meta_last_error( $post_id, $last_error_code );
			return $result;
		}

		try {
			$getID3    = new \getID3();
			$file_info = $getID3->analyze( $file_path );

			if ( isset( $file_info['playtime_seconds'] ) ) {
				$result['duration'] = (int) round( $file_info['playtime_seconds'] );
			} else {
				$last_error_code = 'getid3_no_playtime_local';
			}

			if ( ! empty( $file_info['filesize'] ) ) {
				$result['length'] = (int) $file_info['filesize'];
			}

			if ( ! empty( $file_info['mime_type'] ) ) {
				$result['mime'] = (string) $file_info['mime_type'];
			}
		} catch ( \Exception $e ) {
			$last_error_code   = 'getid3_error';
			$last_error_detail = (string) $e->getMessage();
			error_log( "Episode #{$post_id}: getID3 error - {$last_error_detail}" );
		}

		if ( $last_error_code ) {
			$this->set_audio_meta_last_error( $post_id, $last_error_code, $last_error_detail );
		} elseif ( ! empty( $result['duration'] ) ) {
			$this->clear_audio_meta_last_error( $post_id );
		}

		return $result;
	}

	/**
	 * Read an Episode Details field using Carbon Fields when available.
	 *
	 * @param int    $post_id
	 * @param string $key
	 * @return string
	 */
	private function get_episode_field_value( $post_id, $key ) {
		if ( function_exists( 'carbon_get_post_meta' ) ) {
			$value = carbon_get_post_meta( $post_id, $key );
			if ( is_string( $value ) ) {
				return (string) $value;
			}
			if ( is_numeric( $value ) ) {
				return (string) $value;
			}
		}

		return (string) get_post_meta( $post_id, '_' . ltrim( (string) $key, '_' ), true );
	}

	/**
	 * Show last audio meta extraction error on the editor screen.
	 */
	public function show_audio_meta_error_notice() {
		if ( ! is_admin() || ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || $screen->post_type !== A_Ripple_Song_Podcast_Episodes::POST_TYPE ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0;
		if ( $post_id <= 0 ) {
			return;
		}

		$last_error = get_post_meta( $post_id, self::AUDIO_META_LAST_ERROR_KEY, true );
		if ( empty( $last_error ) ) {
			return;
		}

		$message = '';

		if ( is_array( $last_error ) && ! empty( $last_error['code'] ) ) {
			$code   = (string) $last_error['code'];
			$detail = isset( $last_error['detail'] ) ? (string) $last_error['detail'] : '';

			switch ( $code ) {
				case 'getid3_missing':
					$message = sprintf( __( 'Episode #%d: getID3 not available', 'a-ripple-song-podcast' ), $post_id );
					break;
				case 'audio_url_rejected':
					$message = sprintf( __( 'Episode #%d: audio URL rejected by wp_http_validate_url', 'a-ripple-song-podcast' ), $post_id );
					break;
				case 'audio_download_failed':
					$message = sprintf( __( 'Episode #%d: audio download failed - %s', 'a-ripple-song-podcast' ), $post_id, $detail );
					break;
				case 'getid3_no_playtime_download':
					$message = sprintf( __( 'Episode #%d: getID3 did not return playtime_seconds for downloaded audio', 'a-ripple-song-podcast' ), $post_id );
					break;
				case 'getid3_no_playtime_local':
					$message = sprintf( __( 'Episode #%d: getID3 did not return playtime_seconds for local file', 'a-ripple-song-podcast' ), $post_id );
					break;
				case 'audio_file_missing':
					$message = sprintf( __( 'Episode #%d: audio file missing for duration/size/mime detection', 'a-ripple-song-podcast' ), $post_id );
					break;
				case 'getid3_error':
					$message = sprintf( __( 'Episode #%d: getID3 error - %s', 'a-ripple-song-podcast' ), $post_id, $detail );
					break;
				default:
					$message = $detail;
					break;
			}
		} else {
			// Backward compatibility: previously stored as a plain string.
			$message = (string) $last_error;
		}

		if ( $message === '' ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>' . esc_html( $message ) . '</p></div>';
	}

	private function is_valid_http_url( $url ) {
		$url = trim( (string) $url );
		if ( $url === '' ) {
			return false;
		}

		$encoded = $this->encode_url_for_request( $url );

		if ( function_exists( 'wp_http_validate_url' ) ) {
			return (bool) wp_http_validate_url( $encoded );
		}

		$parts = wp_parse_url( $encoded );
		if ( ! is_array( $parts ) ) {
			return false;
		}

		$scheme = isset( $parts['scheme'] ) ? strtolower( (string) $parts['scheme'] ) : '';
		return in_array( $scheme, array( 'http', 'https' ), true ) && ! empty( $parts['host'] );
	}

	private function encode_url_for_request( $url ) {
		$parts = function_exists( 'wp_parse_url' ) ? wp_parse_url( $url ) : parse_url( $url );
		if ( $parts === false || ! is_array( $parts ) ) {
			return $url;
		}

		$scheme = isset( $parts['scheme'] ) ? strtolower( (string) $parts['scheme'] ) : '';
		$host   = isset( $parts['host'] ) ? (string) $parts['host'] : '';
		if ( $scheme === '' || $host === '' ) {
			return $url;
		}

		$user = isset( $parts['user'] ) ? (string) $parts['user'] : '';
		$pass = isset( $parts['pass'] ) ? (string) $parts['pass'] : '';
		$auth = '';
		if ( $user !== '' ) {
			$auth = $user;
			if ( $pass !== '' ) {
				$auth .= ':' . $pass;
			}
			$auth .= '@';
		}

		$port = isset( $parts['port'] ) ? ':' . (int) $parts['port'] : '';

		$path = isset( $parts['path'] ) ? (string) $parts['path'] : '';
		if ( $path !== '' ) {
			$segments = explode( '/', $path );
			$segments = array_map(
				static function ( $segment ) {
					return rawurlencode( rawurldecode( (string) $segment ) );
				},
				$segments
			);
			$path = implode( '/', $segments );
		}

		$query    = isset( $parts['query'] ) && $parts['query'] !== '' ? '?' . (string) $parts['query'] : '';
		$fragment = isset( $parts['fragment'] ) && $parts['fragment'] !== '' ? '#' . (string) $parts['fragment'] : '';

		return $scheme . '://' . $auth . $host . $port . $path . $query . $fragment;
	}
}
