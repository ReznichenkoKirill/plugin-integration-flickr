<?php


namespace Inc\Classes;


class Admin_menu {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'my_plugin_register_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'my_plugin_add_admin_menu' ] );
	}

	public function my_plugin_register_admin_menu() {
		add_menu_page(
			'Flickr Settings',
			'Flickr Page Title',
			'manage_options',
			'my_plugin_flickr_page',
			[ $this, 'my_plugin_register_admin_menu_callback' ],
			'',
			99
		);
	}

	public function my_plugin_register_admin_menu_callback() {
		?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

            <form action="options.php" method="POST">
				<?php
				settings_fields( 'my_plugin_flickr_options' );
				do_settings_sections( 'my_plugin_flickr_page' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	public function my_plugin_add_admin_menu() {
		add_settings_section(
			'my_plugin_flickr_API_section',
			'The title of the flickr API settings section',
			'',
			'my_plugin_flickr_page' );

		add_settings_field(
			'my_plugin_flickr_setting_key',
			'The key of API flickr app',
			[ $this, 'my_plugin_flickr_setting_key_callback' ],
			'my_plugin_flickr_page',
			'my_plugin_flickr_API_section'
		);

		add_settings_field(
			'my_plugin_flickr_setting_gallery_id',
			'Enter the gallery id of API flickr app',
			[ $this, 'my_plugin_flickr_setting_gallery_id_callback' ],
			'my_plugin_flickr_page',
			'my_plugin_flickr_API_section'
		);


		add_settings_section(
			'my_plugin_flickr_container_section',
			'The title of the flickr Wrap img settings section',
			'',
			'my_plugin_flickr_page' );

		add_settings_field(
			'my_plugin_flickr_container_setting_width',
			'The Wrap width',
			[ $this, 'my_plugin_flickr_wrap_setting_width_callback' ],
			'my_plugin_flickr_page',
			'my_plugin_flickr_container_section'
		);

		add_settings_field(
			'my_plugin_flickr_container_setting_height',
			'The Wrap height',
			[ $this, 'my_plugin_flickr_wrap_setting_height_callback' ],
			'my_plugin_flickr_page',
			'my_plugin_flickr_container_section'
		);

		register_setting( 'my_plugin_flickr_options', 'my_plugin_flickr_setting_key' );
		register_setting( 'my_plugin_flickr_options', 'my_plugin_flickr_setting_gallery_id' );

		register_setting( 'my_plugin_flickr_options', 'my_plugin_flickr_wrap_setting_width' );
		register_setting( 'my_plugin_flickr_options', 'my_plugin_flickr_wrap_setting_height' );
	}

	/*** API SETTING ***/
	public function my_plugin_flickr_setting_key_callback() {
		$value = get_option( 'my_plugin_flickr_setting_key' );
		?>
        <input type='text' name='my_plugin_flickr_setting_key' value='<?php echo( ! empty( $value ) ? $value : '' ) ?>'>
		<?php
	}

	public function my_plugin_flickr_setting_gallery_id_callback() {
		$value = get_option( 'my_plugin_flickr_setting_gallery_id' );
		?>
        <input type='text' name='my_plugin_flickr_setting_gallery_id'
               value='<?php echo( ! empty( $value ) ? $value : '' ) ?>'>
		<?php
	}

	/*** CONTAINER SETTING ***/
	public function my_plugin_flickr_wrap_setting_width_callback() {
		$value = get_option( 'my_plugin_flickr_wrap_setting_width' );
		?>
        <label for="my_plugin_flickr_wrap_setting_width">In percents</label>
        <select name="my_plugin_flickr_wrap_setting_width" id="my_plugin_flickr_wrap_setting_width">
            <option value="100" <?php echo(!empty($value) && $value === '100' ? 'selected' : '') ?> >100</option>
            <option value="75" <?php echo(!empty($value) && $value === '75' ? 'selected' : '') ?> >75</option>
            <option value="50" <?php echo(!empty($value) && $value === '50' ? 'selected' : '') ?> >50</option>
            <option value="25" <?php echo(!empty($value) && $value === '25' ? 'selected' : '') ?> >25</option>
        </select>
		<?php
	}

	public function my_plugin_flickr_wrap_setting_height_callback() {
		$value = get_option( 'my_plugin_flickr_wrap_setting_height' );
		?>
        <label for="my_plugin_flickr_wrap_setting_height">In px (default 400)</label>
        <input type="number" name="my_plugin_flickr_wrap_setting_height" value="<?php echo( !empty($value) ? $value : 400 ) ?>" id="my_plugin_flickr_wrap_setting_height">
		<?php
	}



}