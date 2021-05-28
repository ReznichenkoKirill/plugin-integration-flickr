<?php


namespace Plugin_Integration_flickr\Classes;


class Admin_menu {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'add_admin_menu' ] );
	}

	public function register_admin_menu() {
		add_menu_page(
			'Flickr Settings',
			'Flickr Page Title',
			'manage_options',
			'flickr_page',
			[ $this, 'register_admin_menu_callback' ],
			'',
			99
		);
	}

	public function register_admin_menu_callback() {
		?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

            <form action="options.php" method="POST">
				<?php
				settings_fields( 'flickr_options' );
				do_settings_sections( 'flickr_page' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	public function add_admin_menu() {
		add_settings_section(
			'flickr_API_section',
			'The title of the flickr API settings section',
			'',
			'flickr_page' );

		add_settings_field(
			'flickr_setting_key',
			'The key of API flickr app',
			[ $this, 'flickr_setting_key_callback' ],
			'flickr_page',
			'flickr_API_section'
		);

		add_settings_field(
			'flickr_setting_gallery_id',
			'Enter the gallery id of API flickr app',
			[ $this, 'flickr_setting_gallery_id_callback' ],
			'flickr_page',
			'flickr_API_section'
		);


		add_settings_section(
			'flickr_container_section',
			'The title of the flickr Wrap img settings section',
			'',
			'flickr_page' );

		add_settings_field(
			'flickr_container_setting_width',
			'The Wrap width',
			[ $this, 'wrap_setting_width_callback' ],
			'flickr_page',
			'flickr_container_section'
		);

		add_settings_field(
			'flickr_container_setting_height',
			'The Wrap height',
			[ $this, 'wrap_setting_height_callback' ],
			'flickr_page',
			'flickr_container_section'
		);

		register_setting( 'flickr_options', 'flickr_setting_key' );
		register_setting( 'flickr_options', 'flickr_setting_gallery_id' );

		register_setting( 'flickr_options', 'flickr_wrap_setting_width' );
		register_setting( 'flickr_options', 'flickr_wrap_setting_height' );
	}

	/*** API SETTING ***/
	public function flickr_setting_key_callback() {
		$value = get_option( 'flickr_setting_key' );
		?>
        <input type='text' name='flickr_setting_key' value='<?php echo( ! empty( $value ) ? $value : '' ) ?>'>
		<?php
	}

	public function flickr_setting_gallery_id_callback() {
		$value = get_option( 'flickr_setting_gallery_id' );
		?>

        <label for="flickr_setting_gallery_id">Choose the gallery</label>
        <select name="flickr_setting_gallery_id" id="flickr_setting_gallery_id">
            <option value="72157719045394021" <?php echo( ! empty( $value ) && $value === '72157719045394021' ? 'selected' : '' ) ?> >
                Happy Earth Day 2021
            </option>
            <option value="72157718874259726" <?php echo( ! empty( $value ) && $value === '72157718874259726' ? 'selected' : '' ) ?> >
                Weather
            </option>
            <option value="72157718505043164" <?php echo( ! empty( $value ) && $value === '72157718505043164' ? 'selected' : '' ) ?> >
                Your Night Photography
            </option>
            <option value="72157718144985682" <?php echo( ! empty( $value ) && $value === '72157718144985682' ? 'selected' : '' ) ?> >
                Sports
            </option>
        </select>

		<?php
	}

	/*** CONTAINER SETTING ***/
	public function wrap_setting_width_callback() {
		$value = get_option( 'flickr_wrap_setting_width' );
		?>
        <label for="flickr_wrap_setting_width">In percents</label>
        <select name="flickr_wrap_setting_width" id="flickr_wrap_setting_width">
            <option value="100" <?php echo( ! empty( $value ) && $value === '100' ? 'selected' : '' ) ?> >100</option>
            <option value="75" <?php echo( ! empty( $value ) && $value === '75' ? 'selected' : '' ) ?> >75</option>
            <option value="50" <?php echo( ! empty( $value ) && $value === '50' ? 'selected' : '' ) ?> >50</option>
            <option value="25" <?php echo( ! empty( $value ) && $value === '25' ? 'selected' : '' ) ?> >25</option>
        </select>
		<?php
	}

	public function wrap_setting_height_callback() {
		$value = get_option( 'flickr_wrap_setting_height' );
		?>
        <label for="flickr_wrap_setting_height">In px (default 400)</label>
        <input type="number" name="flickr_wrap_setting_height" value="<?php echo( ! empty( $value ) ? $value : 400 ) ?>"
               id="flickr_wrap_setting_height">
		<?php
	}


}