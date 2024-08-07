<?php

namespace Kmoconnect\Classess;

defined( 'ABSPATH' ) || exit;

class Theme {

	protected $name;
	protected $version;
	protected $text_domain;
	protected array $google_recaptcha_keys = [];
	protected static $_instance;
	protected $logo;
	protected array $widgets;
	protected array $scripts;

	private function __construct() {

		$theme_params = \wp_get_theme();

		$this->name        = $theme_params->get( 'Name' );
		$this->version     = $theme_params->get( 'Version' );
		$this->text_domain = $theme_params->get( 'TextDomain' );

		$this->loadTextDomain( 'kmoconnect', \get_template_directory() . '/languages' )
		     ->addCommentScript();

		\do_action( 'studiowebvision_theme_init', $this );
	}

	public static function instance(): Theme {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function setGoogleRecaptchaKeys( $site_key, $secret_key ): Theme {
		$this->google_recaptcha_keys = [
			'site_key'   => $site_key,
			'secret_key' => $secret_key,
		];

		return $this;
	}

	public function addGoogleRecaptcha(): void {
		$this->addScript(
			"{$this->name}-recaptcha-v3",
			'https://www.google.com/recaptcha/api.js?render=' . $this->getGoogleRecaptchaKey( 'site_key' ),
			[],
			false
		);
	}

	public function getGoogleRecaptchaKey( $type ) {
		if ( count( $this->google_recaptcha_keys ) === 0 ) {
			return false;
		}
		if ( array_key_exists( $type, $this->google_recaptcha_keys ) ) {
			return $this->google_recaptcha_keys[ $type ];
		}
	}

	/*
	 * Register theme widgets
	 */
	public function addWidget( string $name, int $int ) {
		$this->widgets[ $name ] = $int;
		$this->actionWidgetsInit(
			function () use ( $name, $int ) {
				$name_lw = strtolower( $name );
				$name_lw = str_replace( " ", "_", $name_lw );
				$name    = ucfirst( $name );

				for ( $i = 1; $i <= $int; $i ++ ) {
					\register_sidebar( [
						"name"          => "{$name} #{$i}",
						"id"            => "{$name_lw}_{$i}",
						"description"   => "{$name} area {$i}",
						"before_widget" => "<div class=\"{$name_lw}__widget {$name_lw}__widget-{$i}\">",
						"after_widget"  => "</div>",
						"before_title"  => "<h4 class=\"{$name_lw}__title\">",
						"after_title"   => "</h4>",
					] );
				}
			}
		);

		return $this;
	}

	/**
	 * Theme supports
	 *
	 * @param $feature
	 * @param $options
	 *
	 * @return $this
	 */
	public function addSupport( $feature, $options = null ): Theme {
		$this->actionAfterSetup(
			function () use ( $feature, $options ) {
				if ( $options ) {
					\add_theme_support( $feature, $options );
				} else {
					\add_theme_support( $feature );
				}
			}
		);

		return $this;
	}

	public function removeSupport( $feature ): Theme {
		$this->actionAfterSetup(
			function () use ( $feature ) {
				\remove_theme_support( $feature );
			}
		);

		return $this;
	}

	private function loadTextDomain( $domain, $path = false ): Theme {
		$this->actionAfterSetup(
			function () use ( $domain, $path ) {
				\load_theme_textdomain( $domain, $path );
			}
		);

		return $this;
	}

	public function addImageSize( $name, $width = 0, $height = 0, $crop = false ): Theme {
		$this->actionAfterSetup(
			function () use ( $name, $width, $height, $crop ) {
				\add_image_size( $name, $width, $height, $crop );
			}
		);

		return $this;
	}

	public function removeImageSize( $name ): Theme {
		$this->actionAfterSetup(
			function () use ( $name ) {
				\remove_image_size( $name );
			}
		);

		return $this;
	}

	public function addStyle( $handle, $src = '', $deps = [], $media = 'all' ): Theme {
		$this->actionEnqueueScripts(
			function () use ( $handle, $src, $deps, $media ) {
				\wp_enqueue_style( $handle, $src, $deps, $this->version, $media );
			}
		);

		return $this;
	}

	public function addScript( string $handle, $src = '', $deps = [], $in_footer = false, $module = false ): Theme {
		$this->scripts[] = $handle;

		$this->actionEnqueueScripts(
			function () use ( $handle, $src, $deps, $in_footer ) {
				\wp_enqueue_script( $handle, $src, $deps, $this->version, $in_footer );
			}
		);

		if ( $module ) {
			$this->jsModule( $handle );
		}

		return $this;
	}

	protected function jsModule( $script ) {
		// Load scripts as modules.
		\add_filter(
			'script_loader_tag',
			function ( string $tag, string $handle, string $src ) use ( $script ) {
				if ( $handle === $script ) {
					return '<script type="module" src="' . esc_url( $src ) . '" defer></script>';
				}

				return $tag;
			},
			10,
			3
		);
	}

	public function addAjaxScript( $handle, $ajax_obj_name = '', $ajax_values = [] ): Theme {
		$this->actionEnqueueScripts(
			function () use ( $handle, $ajax_obj_name, $ajax_values ) {
				\wp_localize_script( $handle, $ajax_obj_name, $ajax_values, $this->version );
			}
		);

		return $this;
	}

	public function addCommentScript(): Theme {
		$this->actionEnqueueScripts(
			function () {
				if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
					\wp_enqueue_script( 'comment-reply' );
				}
			}
		);

		return $this;
	}

	public function removeStyle( $handle ): Theme {
		$this->actionEnqueueScripts(
			function () use ( $handle ) {
				\wp_dequeue_style( $handle );
				\wp_deregister_style( $handle );
			}
		);

		return $this;
	}

	public function removeScript( $handle ): Theme {
		$this->actionEnqueueScripts(
			function () use ( $handle ) {
				\wp_dequeue_script( $handle );
				\wp_deregister_script( $handle );
			}
		);

		return $this;
	}

	public function addNavMenus( $locations = [] ): Theme {
		$this->actionAfterSetup(
			function () use ( $locations ) {
				$new_locations = [];

				foreach ( $locations as $key => $value ) {
					$new_locations[ $key ] = esc_html__( $value, $this->text_domain );
				}
				\register_nav_menus( $locations );
			}
		);

		return $this;
	}

	public function addNavMenu( $location, $description ): Theme {
		$this->actionAfterSetup(
			function () use ( $location, $description ) {
				\register_nav_menu( $location, $description );
			}
		);

		return $this;
	}

	public function removeNavMenu( $location ): Theme {
		$this->actionAfterSetup(
			function () use ( $location ) {
				\unregister_nav_menu( $location );
			}
		);

		return $this;
	}

	private function actionAfterSetup( $function ): void {
		\add_action(
			'after_setup_theme',
			function () use ( $function ) {
				$function();
			}
		);
	}

	private function actionEnqueueScripts( $function ): void {
		\add_action(
			'wp_enqueue_scripts',
			function () use ( $function ) {
				$function();
			}
		);
	}

	private function actionWidgetsInit( $function ): void {
		\add_action(
			'widgets_init',
			function () use ( $function ) {
				$function();
			}
		);
	}

	private function actionInit( $function ): void {
		\add_action(
			'init',
			function () use ( $function ) {
				$function();
			}
		);
	}

	public function registerCPT( \Closure $param ) {
		$this->actionInit( $param );
	}

	public function getWidgets( $name = null ): mixed {
		if ( ! is_null( $name ) && array_key_exists( $name, $this->widgets ) ) {
			return $this->widgets[ $name ];
		}

		return $this->widgets;
	}

	private function actionRegisteredWidgets( $function ): void {
		\add_action(
			'register_sidebar',
			function ( $sidebar ) use ( $function ) {
				$function( $sidebar );
			}
		);
	}

	public function getContactDetails(): Theme_Contact_Details {
		return $this->contact_details;
	}

	/**
	 * @return Theme_Social_Media
	 */
	public function getSocialMedia(): Theme_Social_Media {
		return $this->social_media;
	}

	/**
	 * @return mixed
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * @param mixed $logo
	 */
	public function setLogo( $logo ): void {
		$this->logo = $logo;
	}

	/**
	 * @return array|false|string
	 */
	public function getTextDomain() {
		return $this->text_domain;
	}

	/**
	 * @return array|false|string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return array|false|string
	 */
	public function getVersion() {
		return $this->version;
	}
}
