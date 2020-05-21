<?php

add_action( 'admin_menu', array( 'GBLOCKS', 'admin_menu' ));
add_action( 'wp_loaded', array( 'GBLOCKS', 'init' ));
add_action( 'admin_init', array( 'GBLOCKS', 'adminInit' ));
add_action( 'admin_enqueue_scripts', array('GBLOCKS', 'enqueue_admin_files' ));
add_action( 'wp_enqueue_scripts', array('GBLOCKS', 'enqueue_files' ));
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array('GBLOCKS', 'plugin_settings_link' ));

add_filter('render_block', function($content, $block) {

    if (trim($content) && strpos($content, 'block-container') === false && strpos($block['blockName'], 'core/') !== false) {
        $content = '<div class="wp-block block-bg-none" data-type="'.$block['blockName'].'">'.$content.'</div>';
	}
	
    return trim($content);
}, 1, 2);


/**
 *
 * @author GG
 *
 */
class GBLOCKS {

	private static $version = '3.0.0';
	private static $page = 'admin.php?page=gblocks';
	private static $settings = array();
	private static $option_key = 'gblocks_settings';
	private static $posts_to_exclude = array('attachment', 'revision', 'nav_menu_item', 'acf-field-group', 'acf-field');
	public  static $current_block_name = '';
	public  static $block_index = 0;
	public  static $block_wrapped_repeater_index = 0;
	//private static $registered_sections = array(array());
	private static $cache = array();
	private static $registered_sections = array();

	public static function dump($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	/**
	 * Outputs the G-Block CSS to the Front End Head
	 *
	 * @return type
	 */
	public static function add_head_css()
	{
		echo "
		<style>

		/* Block Option Classes */
		.block-options-padding-remove-top .block-inner {
			padding-top: 0;
		}
		.block-options-padding-remove-bottom .block-inner {
			padding-bottom: 0;
		}
		.block-bg-image {
			background-size: cover;
			background-position: center;
		}
		.block-bg-video {
			overflow: hidden;
		}
		.block-bg-video .block-video-container {
			position: absolute;
			top: 50%;
			left: 50%;
			-webkit-transform: translateX(-50%) translateY(-50%);
			transform: translateX(-50%) translateY(-50%);
			min-width: 100%;
			min-height: 100%;
			width: auto;
			height: auto;
			overflow: hidden;
			z-index: -1;
		}
		.block-bg-video,
		.block-bg-overlay,
		.block-bg-video .block-inner,
		.block-bg-overlay .block-inner {
			position: relative;
		}
		.block-bg-blur {
			overflow: hidden;
		}
		.block-bg-blur .block-bg-image-container {
			position: absolute;
			background-size: cover;
			top: -40px;
			right: -40px;
			bottom: -40px;
			left: -40px;
			filter: blur(20px);
		}
		.block-bg-overlay .block-bg-overlay-container {
			content: '';
			display: block;
			position: absolute;
			background-color: rgba(0, 0, 0, 0.5);
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
		}
		/*.block-bg-overlay::before {
			content: '';
			display: block;
			position: absolute;
			background-color: rgba(0, 0, 0, 0.5);
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
		}*/
		";

		if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'enqueue_css'))
		{
			self::get_settings(true);

			$custom_class = GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class');

			if(!empty(self::$settings['background_colors']))
			{				
				foreach (self::$settings['background_colors'] as $color_key => $color_params)
				{
					echo '<pre>';print_r($color_params['dark'][0]);echo '</pre>';
					
					$use_css_variable = (!empty($color_params['class']) && $custom_class);

					if(!empty($color_params['value'])){
				?>	<?php echo ($use_css_variable ? '.'.str_replace('.', '', $color_params['class']).', ' : ''); echo '.block-bg-'.$color_params['_repeater_id'];?> { background-color: <?php echo $color_params['value'];?>}
			<?php
					}
				}
			}
		}
		?></style>
	<?php
	}

	public static function setTmceSettings () {
		if ( !class_exists('Tinymce_Advanced') ) {
			add_filter('mce_buttons', function ($buttons) {
				return [
					'styleselect',
					'bullist',
					'numlist',
					'forecolor',
					'fontsizeselect',
					'wp_help',
				];
			}, 9);
		
			add_filter('mce_buttons_2', function ($buttons) {
				return [];
			}, 9);
		
			add_filter('tiny_mce_before_init', function ($tinymce) {    
				$style_formats = array(
					[
						'title' => 'Bold',
						'icon' => 'bold',
						'format' => 'bold'
					],
					[
						'title' => 'Italic',
						'icon' => 'italic',
						'format' => 'italic'
					],
					[
						'title' => 'Underline',
						'icon' => 'underline',
						'format' => 'underline'
					],
					[
						'title' => 'Strikethrough',
						'icon' => 'strikethrough',
						'format' => 'strikethrough'
					],
					[
						'title' => 'Superscript',
						'icon' => 'superscript',
						'format' => 'superscript'
					],
					[
						'title' => 'Subscript',
						'icon' => 'subscript',
						'format' => 'subscript'
					],
					[
						'title' => 'Code',
						'icon' => 'code',
						'format' => 'code'
					],
					[
						'title' => 'Headings',
						'icon' => 'forecolor',
						'items' => [
							[
								'title' => 'Heading 1',
								'format' => 'h1'
							],
							[
								'title' => 'Heading 2',
								'format' => 'h2'
							],
							[
								'title' => 'Heading 3',
								'format' => 'h3'
							],
							[
								'title' => 'Heading 4',
								'format' => 'h4'
							],
							[
								'title' => 'Heading 5',
								'format' => 'h5'
							],
							[
								'title' => 'Heading 6',
								'format' => 'h6'
							]
						]
					],
					[
						'title' => 'Blocks',
						'icon' => 'visualblocks',
						'items' => [
							[
								'title' => 'Paragraph',
								'icon' => 'visualblocks',
								'format' => 'p'
							],
							[
								'title' => 'Paragraph Large',
								'icon' => 'visualblocks',
								'selector' => 'p',
								'classes' => 'large',
							],
							[
								'title' => 'Blockquote',
								'icon' => 'blockquote',
								'format' => 'blockquote'
							],
							[
								'title' => 'Pre',
								'icon' => 'code',
								'format' => 'pre'
							]
						]
					],
					[
						'title' => 'Alignment',
						'icon' => 'drag',
						'items' => [
							[
								'title' => 'Left',
								'icon' => 'alignleft',
								'format' => 'alignleft'
							],
							[
								'title' => 'Center',
								'icon' => 'aligncenter',
								'format' => 'aligncenter'
							],
							[
								'title' => 'Right',
								'icon' => 'alignright',
								'format' => 'alignright'
							],
							[
								'title' => 'Justify',
								'icon' => 'alignjustify',
								'format' => 'alignjustify'
							],
							[
								'title' => 'Indent',
								'icon' => 'indent',
								'selector' => 'p',
								'styles' => ['padding-left' => '40px']
							]
						]
					],
					[
						'title' => 'Columns',
						'icon' => 'alignjustify',
						'items' => [
							[
								'title' => 'Response - Small',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => '200px auto']
							],
							[
								'title' => 'Response - Medium',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => '300px auto']
							],
							[
								'title' => 'Response - Large',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => '400px auto']
							],
							[
								'title' => 'Response - X-Large',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => '550px auto']
							],
							[
								'title' => 'Fixed - 2',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => 'auto 2']
							],
							[
								'title' => 'Fixed - 3',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => 'auto 3']
							],
							[
								'title' => 'Fixed - 4',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => 'auto 4']
							],
							[
								'title' => 'Fixed - 5',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => 'auto 5']
							],
							[
								'title' => 'Fixed - 6',
								'block' => 'div',
								'classes' => 'has-columns',
								'styles' => ['columns' => 'auto 6']
							],
						]
					],
					[
						'title' => 'Buttons',
						'icon' => 'removeformat',
						'items' => [
							[
								'title' => 'Primary',
								'icon' => 'removeformat',
								'selector' => 'a',
								'classes' => 'btn btn-primary',
							],
							[
								'title' => 'Secondary',
								'icon' => 'removeformat',
								'selector' => 'a',
								'classes' => 'btn btn-secondary',
							],
						],
					],
				);
		
				$tinymce['style_formats_merge'] = false;
				$tinymce['style_formats'] = json_encode($style_formats);
				$tinymce['fontsize_formats'] = "10px 11px 12px 14px 16px 18px 24px 36px 42px 48px";
				$tinymce['toolbar1'] = '';
				$tinymce['toolbar2'] = '';
				$tinymce['menubar'] = true;
				$tinymce['menu'] = json_encode([
					'edit' => [
						'title' => 'Edit',
						'items' => 'undo redo | cut copy paste pastetext removeformat | selectall | tableprops deletetable cell row column wp_help'
					],
					'insert' => [
						'title' => 'Insert',
						'items' => 'link media inserttable charmap hr'
					]
				]);
		
				return $tinymce;
			}, 9);
		
			add_filter( 'mce_external_plugins', function($plugin_array) {
				$plugin_array['table'] = get_template_directory_uri() .'/lib/gblocks/library/js/tmce-table.js';
				return $plugin_array;
			});
		}
	}

	public static function renderBlock($block) {

	    self::display_block($block['name']);
	}

	/**
	 * Check if Block Editor is active.
	 * Must only be used after plugins_loaded action is fired.
	 *
	 * @return bool
	 */
	public static function isGutenbergEditor() {
		// Gutenberg plugin is installed and activated.
		$gutenberg = ! ( false === has_filter( 'replace_editor', 'gutenberg_init' ) );

		// Block editor since 5.0.
		$block_editor = version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' );

		if ( ! $gutenberg && ! $block_editor ) {
			return false;
		}

		if ( self::is_classic_editor_plugin_active() ) {
			$editor_option       = get_option( 'classic-editor-replace' );
			$block_editor_active = array( 'no-replace', 'block' );

			return in_array( $editor_option, $block_editor_active, true );
		}

		return true;
	}

	/**
	 * Check if Classic Editor plugin is active.
	 *
	 * @return bool
	 */
	public static function is_classic_editor_plugin_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * This is the initial setup that connects the Settings and loads the Fields from ACF
	 *
	 * @return void
	 */
	private static function setup()
	{
		global $block;

		include plugin_dir_path( __FILE__ ).'plugin-settings.php';

		new GBLOCKS_PLUGIN_SETTINGS(self::$option_key);

		self::get_settings(true);

		/**
		 *  Include Blocks in Flexible Content
		 */
		$layouts = array();
		foreach(self::get_blocks() as $block => $block_params)
		{
			self::$current_block_name = $block;
			if(!empty($block_params['path']))
			{
				$block_backgrounds = array ();
				$block_background_image = array ();

				if(file_exists($block_params['path'].'/block_fields.php'))
				{
					$layouts[$block] = include($block_params['path'].'/block_fields.php');
				}
			}
		}

		// Reset Current Block
		$block = '';


		/*
		* Block Function to build Admin and Set Fields for ACF
		*/
		if(function_exists("acf_add_local_field_group") && !empty($layouts))
		{
			// Filter the Link Options
			self::filter_layout_links($layouts, '', 'gblock_link_fields');

			// Add Default Fields
			foreach ($layouts as $block_key => $block_layout)
			{
				if(!empty($block_layout['sub_fields']))
				{
					$layouts[$block_key]['sub_fields'] = array_merge(self::get_default_fields($block_layout['name']), $block_layout['sub_fields']);
				}
			}

			// Filter the Fields from developers
			$layouts = apply_filters( 'gblock_fields', $layouts );

			// Create Tabs
			if(!empty($layouts))
			{
				foreach ($layouts as $block_key => $block_layout)
				{
					$tab_fields = array();
					$new_sub_fields = array();
					$tab_options_fields = array();

					$add_first_tab = true;

					if(!empty($block_layout['sub_fields']))
					{
						foreach ($block_layout['sub_fields'] as $sub_field_key => $sub_field)
						{
							if($sub_field_key === 0)
							{
								if(!empty($sub_field['type']) && $sub_field['type'] === 'tab')
								{
									$add_first_tab = false;
								}
							}

							if((!empty($sub_field['block_options']) || !empty($sub_field['block_option'])) && $sub_field['type'] !== 'tab')
							{
								$tab_options_fields[] = $sub_field;
							}
							else
							{
								$tab_fields[] = $sub_field;
							}
						}
					}

					$tab_content = array (
						'key' => 'field_block_tab_'.$block_layout['name'].'_tab1',
						'label' => 'Content',
						'name' => 'block_tab_'.$block_layout['name'].'_tab1',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'open' => 1,
						'placement' => 'left',
						'multi_expand' => 0,
						'endpoint' => 0,          // end tabs to start a new group
					);

					$tab_options = array (
						'key' => 'field_block_tab_'.$block_layout['name'].'_tab2',
						'label' => 'Options',
						'name' => 'block_tab_'.$block_layout['name'].'_tab2',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'open' => 0,
						'placement' => 'left',
						'multi_expand' => 0,
						'endpoint' => 0,          // end tabs to start a new group
					);

					if($add_first_tab)
					{
						$new_sub_fields = array($tab_content);
					}

					if(!empty($block_layout['gblocks_settings']['repeater']))
					{

						$block_repeater_defaults = array(
							'label' => 'Item',
							'max' => '',
							'min' => '1',
						);

						if(!is_array($block_layout['gblocks_settings']['repeater']))
						{
							$block_repeater = $block_repeater_defaults;
						}
						else
						{
							$block_repeater = array_merge($block_repeater_defaults, $block_layout['gblocks_settings']['repeater']);
						}


						$layouts[$block_key]['display'] = 'block';
						$background_fields = self::get_background_fields($block_layout['name'], 'Container Background', 'wrapped_repeater_background');

						$tab_fields = array(array (
						    'key' => 'field_'.$block_layout['name'].'_wrapped_repeater',
						    'label' => $block_repeater['label'],
						    'name' => 'wrapped_repeater',
						    'type' => 'repeater',
						    'instructions' => '',
						    'required' => 0,
						    'conditional_logic' => 0,
						    'wrapper' => array (
						        'width' => '',
						        'class' => '',
						        'id' => '',
						    ),
						    'collapsed' => '',
						    'min' => $block_repeater['min'],
						    'max' => $block_repeater['max'],
						    'layout' => 'row',         // table | block | row
						    'button_label' => 'Add '.$block_repeater['label'],
						    'sub_fields' => $tab_fields,
						));

						$tab_fields = array_merge($background_fields, $tab_fields);

					}

					$new_sub_fields = array_merge($new_sub_fields, $tab_fields, array($tab_options), $tab_options_fields);

					$layouts[$block_key]['sub_fields'] = $new_sub_fields;

				}
			}

			$placement = (GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'after_title')) ? 'acf_after_title' : 'normal';

			if (self::isGutenbergEditor()) {
				foreach ($layouts as $layoutKey => $layout) {

					acf_register_block(array(
						'name'				=> $layoutKey,
						'title'				=> __('* '.$layout['label']),
						'description'		=> __('A custom block by G Blocks'),
						'render_callback'	=> array(__CLASS__, 'renderBlock'),
						'category'			=> 'g-blocks',
						'mode' 				=> 'edit',
						'icon'				=> !empty($layout['gblocks_settings']['icon']) ? str_replace('dashicons-', '', $layout['gblocks_settings']['icon']) : 'admin-comments',
						'keywords'			=> array( $layoutKey ),
						'supports' 			=> array('align' => false, 'mode' => false)
					));
					
					acf_add_local_field_group(array(
						'key' => 'gblock_'.$layoutKey.'_block',
						'title' => $layout['label'],
						'fields' => $layout['sub_fields'],
						'location' => array (
							array (
								array (
									'param' => 'block',
									'operator' => '==',
									'value' => 'acf/'.$layoutKey,
								),
							),
						),
						'menu_order' => 0,
						'position' => 1,
						'style' => 'no_box',
						'label_placement' => 'top',
						'instruction_placement' => 'label',
						'hide_on_screen' => self::hide_on_screen(),
						'active' => 1,
						'description' => '',
					));
				}
			} else {
				$sections = array (
					'key' => 'group_gblocks',
					'title' => 'G-Blocks',
					'fields' => array (
						array (
							'key' => 'field_x1',
							'label' => 'G-Blocks',
							'name' => 'gblocks',
							'type' => 'flexible_content',
							'layouts' => $layouts,
							'button_label' => 'Add Content',
							'min' => '',
							'max' => '',
						),
					),
					'location' => self::get_locations(),
					'menu_order' => 100,
					'position' => $placement,
					'style' => 'no_box',
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' => self::hide_on_screen(),
					'active' => 1,
					'description' => '',
				);
				$sections = apply_filters('gblock_default_section', $sections);
				acf_add_local_field_group($sections);
			}

			$option_pages = (!empty(self::$settings['option_pages']) ? self::$settings['option_pages'] : false);

			if($option_pages)
			{
				foreach($option_pages as $option_page)
				{
					$sections = array (
						'key' => 'group_options_'.$option_page,
						'title' => 'Blocks',
						'fields' => array (
							array (
								'key' => 'field_options_'.$option_page,
								'label' => 'G-Blocks',
								'name' => $option_page,
								'type' => 'clone',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'clone' => array (
									0 => 'group_gblocks',
								),
								'display' => 'seamless',
								'layout' => 'block',
								'prefix_label' => 0,
								'prefix_name' => 1,
							),
						),
						'location' => array (
							array (
								array (
									'param' => 'options_page',
									'operator' => '==',
									'value' => $option_page,
								),
							),
						),
						'menu_order' => 100,
						'position' => 'normal',
						'style' => 'no_box',
						'label_placement' => 'top',
						'instruction_placement' => 'label',
						'hide_on_screen' => '',
						'active' => 1,
						'description' => '',
					);

					$sections = apply_filters('gblocks_section', $sections, $option_page);
					acf_add_local_field_group($sections);
				}
			}

			self::$registered_sections = $sections;
		}
	}


	private static function get_block_background_allowed_video(){
		$block_background_video_blocks =  array('banner');
		return apply_filters( 'gblocks_background_video', $block_background_video_blocks);
	}

	private static function get_background_fields($block='', $label='Background', $key='background')
	{
		/**
		 *  Set Background Colors
		 */
		$block_background_colors = array();
		$block_background_colors['block-bg-none'] = 'None';
		if(!empty(self::$settings['background_colors']))
		{
			foreach (self::$settings['background_colors'] as $color_key => $color_params)
			{
				if(!empty($color_params['_repeater_id']))
				{
					$block_background_colors['block-bg-'.$color_params['_repeater_id']] = $color_params['name'];
				}
			}
		}
		$block_background_colors['block-bg-image'] = 'Image';

		if(in_array($block, self::get_block_background_allowed_video($block))){
			$block_background_colors['block-bg-video'] = 'Video';
		}
		$block_background_colors = apply_filters( 'gblock_background_colors', $block_background_colors, $block );

		/**
		 *  Set Default Fields
		 */
		$background_fields = array(
			array (
				'key' => 'field_block_default_'.$block.'_'.$key,
				'label' => $label,
				'name' => 'block_background',
				'type' => 'select',
				'column_width' => '',
				'choices' => $block_background_colors,
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
			    'key' => 'field_block_default_'.$block.'_'.$key.'_video_type',
			    'label' => 'Video Type',
			    'name' => 'block_background_video_type',
			    'type' => 'radio',
			    'instructions' => 'Using Url with Vimeo or other Provider is the better option as it will not incur additional bandwidth charges from your Hosting Provider.',
			    'required' => 0,
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_block_default_'.$block.'_'.$key,
							'operator' => '==',
							'value' => 'block-bg-video',
						),
					),
				),
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'choices' => array (
			        'url' => 'Url',
					'file' => 'File'
			    ),
			    'other_choice' => 0,
			    'save_other_choice' => 0,
			    'default_value' => 'url',
			    'layout' => 'horizontal',
			),
			array (
				'key' => 'field_block_default_'.$block.'_'.$key.'_video_url',
				'label' => 'Background Video URL',
				'name' => 'block_background_video_url',
				'type' => 'text',
				'instructions' => 'Video must be a MP4 Format. <br><br>Use the Background Image below for a Placeholder',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_block_default_'.$block.'_'.$key.'_video_type',
							'operator' => '==',
							'value' => 'url',
						),
						array (
							'field' => 'field_block_default_'.$block.'_'.$key,
							'operator' => '==',
							'value' => 'block-bg-video',
						),
					),
				),
				'column_width' => '',
				'save_format' => 'object',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array (
			    'key' => 'field_block_default_'.$block.'_'.$key.'_video_file',
			    'label' => 'Video File',
			    'name' => 'block_background_video_file',
			    'type' => 'file',
			    'instructions' => 'Uploads may not work if the file is too large.  <br><br>Use the Background Image below for a Placeholder',
			    'required' => 0,
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_block_default_'.$block.'_'.$key.'_video_type',
							'operator' => '==',
							'value' => 'file',
						),
						array (
							'field' => 'field_block_default_'.$block.'_'.$key,
							'operator' => '==',
							'value' => 'block-bg-video',
						),
					),
				),
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'return_format' => 'url',      // array | url | id
			    'library' => 'all',              // all | uploadedTo
			    'min_size' => '',
			    'max_size' => '',
			    'mime_types' => '',
			),
			array (
				'key' => 'field_block_default_'.$block.'_'.$key.'_image',
				'label' => 'Background Image',
				'name' => 'block_background_image',
				'type' => 'image',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_block_default_'.$block.'_'.$key,
							'operator' => '==',
							'value' => 'block-bg-image',
						),
					),
					array (
						array (
							'field' => 'field_block_default_'.$block.'_'.$key,
							'operator' => '==',
							'value' => 'block-bg-video',
						),
					),
				),
				'column_width' => '',
				'save_format' => 'object',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array (
			   'key' => 'field_block_default_'.$block.'_'.$key.'_overlay',
			   'label' => 'Add Background Overlay',
			   'name' => 'block_background_overlay',
			   'type' => 'true_false',
			   'instructions' => '',
			   'required' => 0,
			   'conditional_logic' => array (
				   array (
					   array (
						   'field' => 'field_block_default_'.$block.'_'.$key,
						   'operator' => '==',
						   'value' => 'block-bg-image',
					   ),
				   ),
				   array (
					   array (
						   'field' => 'field_block_default_'.$block.'_'.$key,
						   'operator' => '==',
						   'value' => 'block-bg-video',
					   ),
				   ),
			   ),
			   'wrapper' => array (
			       'width' => '50',
			       'class' => '',
			       'id' => '',
			   ),
			   'message' => '',
			   'ui' => 1,
			   'ui_on_text' => 'Yes',
			   'ui_off_text' => 'No',
			   'default_value' => 0,
		    ),
			array (
			   'key' => 'field_block_default_'.$block.'_'.$key.'_blur',
			   'label' => 'Add Background Blur',
			   'name' => 'block_background_blur',
			   'type' => 'true_false',
			   'instructions' => '',
			   'required' => 0,
			   'conditional_logic' => array (
				   array (
					   array (
						   'field' => 'field_block_default_'.$block.'_'.$key,
						   'operator' => '==',
						   'value' => 'block-bg-image',
					   ),
				   ),
			   ),
			   'wrapper' => array (
			       'width' => '50',
			       'class' => '',
			       'id' => '',
			   ),
			   'message' => '',
			   'ui' => 1,
			   'ui_on_text' => 'Yes',
			   'ui_off_text' => 'No',
			   'default_value' => 0,
		    ),
		);

		return $background_fields;
	}

	public static function getField($field) {
		// global $block_attributes;

		if (!function_exists('get_field')) {
			return '';
		}

		return self::isGutenbergEditor() ? get_field($field) : get_sub_field($field);
	}

	private static function get_default_fields($block='')
	{
		$background_fields = self::get_background_fields($block);

		$default_fields = array(
			array (
				'key' => 'field_block_default_'.$block.'_unique_id',
				'label' => 'Container ID',
				'name' => 'unique_id',
				'type' => 'text',
				'column_width' => '',
				'default_value' => '',
				'instructions' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none', 		// none | html
				'maxlength' => '',
				'block_options' => 1
			),
			array (
				'key' => 'field_block_default_'.$block.'_custom_class',
				'label' => 'Custom CSS Classes',
				'name' => 'block_option_custom_class',
				'type' => 'text',
				'column_width' => '',
				'default_value' => '',
				'instructions' => 'Separate with spaces',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none', 		// none | html
				'maxlength' => '',
				'block_options' => 1
			),
			array (
			    'key' => 'field_block_option_'.$block.'_padding',
			    'label' => 'Padding',
			    'name' => 'block_option_padding',
			    'type' => 'checkbox',
			    'instructions' => '',
			    'required' => 0,
			    'conditional_logic' => 0,
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'choices' => array (
			        'block-options-padding-remove-top' => 'Remove Top Padding',
			        'block-options-padding-remove-bottom' => 'Remove Bottom Padding'
			    ),
			    'default_value' => array (
			    ),
			    'layout' => 'horizontal',
			    'toggle' => 0,
				'block_options' => 1
			),
			array (
			    'key' => 'field_block_option_'.$block.'_hiding',
			    'label' => 'Hide For',
			    'name' => 'block_option_hide',
			    'type' => 'checkbox',
			    'instructions' => '',
			    'required' => 0,
			    'conditional_logic' => 0,
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'choices' => array (
			        'sm' => 'Small Screens',
			        'md' => 'Medium Screens',
			        'lg' => 'Large Screens',
			        'xl' => 'Extra Large Screens',
			    ),
			    'default_value' => array (
			    ),
			    'layout' => 'horizontal',
			    'toggle' => 0,
				'block_options' => 1
			),
		);

		return array_merge($background_fields, $default_fields);
	}

	// Style (Keep for Older Versions) #TODO Depricate as this is no longer needed with get_default_fields()
	public static function get_additional_fields(){

		return array();
	}

	public static function get_registered_sections()
	{
		return self::$registered_sections;
	}

	public static function hide_on_screen(){
		$hidden = array();
		if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'hide_content')){
			$hidden[0] = 'the_content';
		}
		$hidden = apply_filters( 'gblock_hide_on_screen', $hidden );
		return $hidden;
	}

	public static function updateGutenbergSettings() {

		if(!self::isGutenbergEditor()) {
			return;
		}

		add_filter( 'block_editor_settings' , function ($settings) {
			unset($settings['styles'][0]);
			return $settings;
		});
	
		add_theme_support( 'editor-color-palette', array() );

		add_action('admin_footer', function(){ ?>
			<script>
			(function($, undefined){
				var gutenbergValidation = new acf.Model({
					wait: 'ready',
					initialize: function(){
						if (acf.isGutenberg()) {
							this.customizeEditor();
						}
					},
					customizeEditor: function(){
						var editor = wp.data.dispatch( 'core/editor' );
						var notices = wp.data.dispatch( 'core/notices' );
						var savePost = editor.savePost;
						editor.savePost = function(){
							var valid = acf.validateForm({
								form: $('#editor'),
								reset: true,
								complete: function( $form, validator ){
									editor.unlockPostSaving( 'acf' );
								},
								failure: function( $form, validator ){
									var notice = validator.get('notice');
									notices.createErrorNotice( notice.get('text'), { 
										id: 'acf-validation', 
										isDismissible: true
									});
									notice.remove();
								},
								success: function(){
									savePost();
								}
							});
							if( !valid ) {
								editor.lockPostSaving( 'acf' );
								return false;
							}
							savePost();
						}
					}
				});
			})(jQuery);
			</script>
			
		<?php 
		});
			
		add_action('acf/validate_save_post', function () {
			if( empty($_POST) ) return;
			foreach ( $_POST as $postkey => $postvalue ) {
				if ('acf' == $postkey || 'acf-block' == substr( $postkey, 0, 9 ) ) {
					foreach( $postvalue as $key => $value ) {
						$field = acf_get_field( $key );
						$input = $postkey . '[' . $key . ']';
						if( !$field ) continue;
						acf_validate_value( $value, $field, $input );		
					}
				}
			}
		});
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function init()
	{
		self::setTmceSettings();

		if(function_exists('acf_add_local_field_group')) {

			add_filter( 'block_categories', function ( $categories) {
				return array_merge(
					array(
						array(
							'slug' => 'g-blocks',
							'title' => __( 'Custom Blocks', 'g-blocks' ),
						),
					),
					$categories
				);
			});

			self::setup();
			self::add_hooks();
			self::prepare_blocks();
		}
	}

	/**
	 * Runs on action "wp"
	 * Use this section to run code before any output has been sent to browser.
	 *
	 * @return void
	 */
	public static function prepare_blocks()
	{
		if($blocks = self::get_blocks())
		{
			foreach ($blocks as $block_name => $block)
			{
				$block_functions_file = $block['path'].'/block_functions.php';
				if(file_exists($block_functions_file))
				{
					include_once($block_functions_file);
				}
			}
		}
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function add_hooks()
	{
		if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'filter_content') && !is_admin())
		{
			self::add_hook('filter', 'the_content', 'filter_content', 23);
		}

		self::add_hook('action', 'wp_head', 'add_head_css');
		self::add_hook('action', 'admin_head', 'add_head_css');

		//self::add_hook('action', 'wp', 'prepare_blocks');

		if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'include_in_search') && !is_admin() && is_main_query())
		{
			self::add_hook('filter', 'posts_search', 'add_search_filtering');
		}

		if(!is_admin())
		{
			if((!empty($_GET['s']) && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'include_in_search')) || GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'filter_excerpt'))
			{
				self::add_hook('filter', 'get_the_excerpt', 'add_excerpt_filtering');
			}
		}

		if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'enqueue_scripts') ||
		   GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			self::add_hook('action', 'wp_footer', 'add_footer_js', 100);
		}

		if(!function_exists('acf_add_local_field_group') && (!isset($_GET['page']) || $_GET['page'] != 'gblocks'))
		{
			self::add_hook('action', 'admin_notices', 'acf_notice');
		}

		// Add Hook doesn't work here as the parameters messes up the reference
		// self::add_hook('action', 'gblocks_display_before' , 'get_block_background_video_markup', 10, 2);
		add_action( 'gblocks_display_before' , array(__CLASS__, 'get_block_background_video_markup'), 10, 2);

		add_action( 'gblocks_display_before' , array(__CLASS__, 'get_block_background_image_markup'), 10, 3);
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function add_hook($type='', $hook='', $hook_function='', $param='')
	{
		if($type === 'action')
		{
			add_action( $hook , array(__CLASS__, $hook_function));
		}
		else
		{
			add_filter( $hook , array(__CLASS__, $hook_function), $param);
		}
	}

	/**
	 * Grabs the settings from the Settings class
	 *
	 * @param boolean $force
	 *
	 * @return void
	 */
	public static function get_settings($force=false)
	{
		self::$settings = GBLOCKS_PLUGIN_SETTINGS::get_settings($force);
	}

	/**
	 * Runs on WP Plugin Activation
	 *
	 * @return void
	 */
	public static function adminInit()
	{
		self::updateGutenbergSettings();
		
		$active_settings = get_option(self::$option_key);
		if(!$active_settings)
		{
			$current_settings = array(
				'post_types' => array_keys(self::get_usable_post_types()),
				'templates' => '',
				'advanced_options' => array('filter_content', 'enqueue_scripts'),
				'css_options' => array('enqueue_css', 'use_foundation', 'use_default'),
				'background_colors' => array(
					array('name' => 'White', 'value' => '#ffffff'),
					array('name' => 'Light Gray', 'value' => '#eeeeee'),
					array('name' => 'Dark Gray', 'value' => '#555555')
				),
				'foundation' => array('f5'),
			);
			$blocks_groups = self::get_available_block_groups();
			foreach($blocks_groups as $group_name => $group_info){
				$current_settings['blocks_enabled_'.$group_name] = array_keys($group_info);
			}
			update_option(self::$option_key, $current_settings);
		}
	}

	public static function acf_notice($dismissible=true)
	{
	    ?>
	    <div class="notice error gblocks-acf-notice<?php echo ($dismissible ? ' is-dismissible' : '');?>">
	        <p><?php _e( 'G-Blocks - ACF Pro is required to run G-Blocks<br>To download the plugin go here. <a target="_blank" href="http://www.advancedcustomfields.com/pro/">http://www.advancedcustomfields.com/pro/</a><br>To remove this message permanently either Install ACF Pro or Deactivate the G-Blocks Plugin', 'GBLOCKS' ); ?></p>
	    </div>
	    <?php
	}

	/**
	 * Create the Admin Menu in that Admin Panel
	 *
	 * @return void
	 */
	public static function admin_menu()
	{
		add_submenu_page( 'options-general.php', 'G-Blocks', 'G-Blocks', 'manage_options', 'gblocks', array( __CLASS__, 'admin' ));
	}

	public static function plugin_settings_link($links)
	{
		$settings_link = '<a href="options-general.php?page=gblocks">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	public static function add_excerpt_filtering( $output )
	{
		if(empty($output) && !has_excerpt() && !trim(strip_tags(get_the_content())))
		{
			global $wpdb;

			// If is Search, then first check to see if we can find results that matches the search
			if(is_main_query() && get_search_query() && is_search() && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'include_in_search'))
			{
				$results = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->postmeta." WHERE meta_value LIKE '%".get_search_query()."%' AND meta_key NOT LIKE '\_%' AND post_id = ".get_the_ID()." ORDER BY CHAR_LENGTH(meta_value) DESC LIMIT 1");
			}

			// If no matches are found or if not Search then check for any fields to show data
			if(empty($results))
			{
				if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'include_in_search') || !is_search() || !is_main_query())
				{
					$results = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->postmeta." WHERE meta_key NOT LIKE '\_%' AND post_id = ".get_the_ID()." ORDER BY CHAR_LENGTH(meta_value) DESC LIMIT 1");
				}
			}

			// If Results then lets format it
		    if(!empty($results))
	    	{
	    		$output = wp_trim_excerpt(strip_shortcodes(strip_tags($results)));
	    	}

		}
		return $output;
	}

	public static function add_search_filtering($search)
	{
		if(!is_admin() && is_search() && is_main_query())
		{
			global $wpdb;
			$post_ids = array();

			if($results = $wpdb->get_results("SELECT * FROM ".$wpdb->postmeta.", ".$wpdb->posts." WHERE meta_value LIKE '%".get_search_query()."%' AND post_id = ID AND post_status = 'publish' GROUP BY post_id"))
			{
			    foreach ($results as $result)
			    {
			        $post_ids[] = $result->post_id;
			    }
			}

			if(!empty($post_ids))
			{
				$replace = ' OR ('.$wpdb->posts.'.ID IN ('.esc_sql(implode(',',$post_ids)).')) OR ';
				$search = str_replace(' OR ', $replace, $search);
			}
		}

		return $search;
	}


	/**
	 * Outputs the G-Blocks
	 *
	 * @param string $args - Currently the two options for the array are 'section' and 'object'
	 *
	 * @return type
	 */
	public static function display($args = array())
	{
		// Check $args array if it exists and what is set.
		$section = (!empty($args['section'])) ? $args['section'] : 'gblocks';
		$object = (in_array('object', array_keys($args)) ? $args['object'] : false);

		$block_only = !empty($args['block']) ? $args['block'] : '';
		$block_only_id = !empty($args['block_id']) ? $args['block_id'] : '';

		$block_only_variables = isset($args['block_variables']) ? $args['block_variables'] : array();

		$block_excludes = !empty($args['exclude_blocks']) ? $args['exclude_blocks'] : array();
		$block_includes = !empty($args['include_blocks']) ? $args['include_blocks'] : array();

		$handler_file = self::get_path('handler.php');

		// Use Single Block
		if(is_null($object) && $block_only)
		{
			self::$current_block_name = strtolower(str_replace('_', '-', $block_only));
			self::get_block_format($block_only_variables, $handler_file);
			return;
		}

		// Use All Blocks
		$query_target = ($object) ? $object : ( ( ( $query = get_queried_object() ) && !empty($query->term_id ) ) ? $query : '');

		if(isset($query_target->ID))
		{
			$query_target = $query_target->ID;
		}

		$viewable_query_target = $query_target;

		if(in_array($viewable_query_target, array('option_page', 'options_page')))
		{
			$viewable_query_target = $section;
			$section.= '_gblocks';
			$query_target = 'option';
		}

		if(self::is_viewable($viewable_query_target))
		{
			if($handler_file && get_field($section, $query_target))
			{
				while(the_flexible_field($section, $query_target))
				{
					self::$current_block_name = strtolower(str_replace('_', '-', get_row_layout()));

					$use_single_block = ((!$block_only_id && $block_only === self::$current_block_name) || ($block_only_id && $block_only_id === get_sub_field('unique_id')));

					if(empty($block_only) || $use_single_block)
					{
						if(!in_array(self::$current_block_name, $block_excludes) && (empty($block_includes) || in_array(self::$current_block_name, $block_includes)))
						{
							self::get_block_format($block_only_variables, $handler_file);

							if($use_single_block)
							{
								reset_rows( true );
								return;
							}
						}
					}
				}
			}
		}
	}


	private static function get_block_attributes($block_name='', $block_variables=array())
	{
		$block_attributes = array();

		if(!empty($block_variables))
		{
			extract($block_variables);
		}

		if(!isset($block_unique_id))
		{
			$block_unique_id = !empty($block_variables['is_wp_block']) ? get_field('unique_id') : get_sub_field('unique_id');
		}

		if(!isset($block_custom_class))
		{
			$block_custom_class = !empty($block_variables['is_wp_block']) ? get_field('block_option_custom_class') : get_sub_field('block_option_custom_class');
		}

		if(!isset($block_padding))
		{
			$block_padding = !empty($block_variables['is_wp_block']) ? get_field('block_option_padding') : get_sub_field('block_option_padding');
		}

		if(!isset($block_hide))
		{
			$block_hide = !empty($block_variables['is_wp_block']) ? get_field('block_option_hide') : get_sub_field('block_option_hide');
		}

		if(!isset($block_background))
		{
			$block_background = ($block_bg = !empty($block_variables['is_wp_block']) ? get_field('block_background') : get_sub_field('block_background')) ? $block_bg : 'block-bg-none';
		}

		if(!isset($block_background_image))
		{
			$block_background_image = !empty($block_variables['is_wp_block']) ? get_field('block_background_image') : get_sub_field('block_background_image');
		}

		if(!isset($block_background_overlay))
		{
			$block_background_overlay = !empty($block_variables['is_wp_block']) ? get_field('block_background_overlay') : get_sub_field('block_background_overlay');
		}

		if(!isset($block_background_blur))
		{
			$block_background_blur = !empty($block_variables['is_wp_block']) ? get_field('block_background_blur') : get_sub_field('block_background_blur');
		}

		$block_index = self::$block_index;
		$block_attributes['data-block-index'] = $block_index;

		// ID
		//$block_unique_id = get_sub_field('unique_id');

		if($block_unique_id)
		{
			$block_attributes['id'] = sanitize_title($block_unique_id);
		}

		// Class
		$block_attributes['class'] = array();

		if(!empty($block_custom_class))
		{
			$block_attributes['class'] = array_merge($block_attributes['class'], explode(' ', $block_custom_class));
		}

		// Padding Options
		if($block_padding)
		{
			$block_attributes['class'] = array_merge($block_attributes['class'], $block_padding);
		}

		$sections = self::get_registered_sections();

		if(!empty($sections['fields'][0]['layouts']))
		{
			foreach ($sections['fields'][0]['layouts'] as $layout_name => $layout)
			{
				if(!empty($layout['sub_fields']))
				{
					foreach ($layout['sub_fields'] as $sub_field)
					{
						if(!empty($sub_field['block_data_attribute']))
						{
							$block_attributes['data-'.str_replace('_', '-', strtolower($sub_field['name']))] = trim(get_sub_field($sub_field['name']));
						}

						if(!empty($sub_field['block_class_attribute']))
						{
							$block_attributes['class'][] = trim(get_sub_field($sub_field['name']));
						}
					}
				}
			}
		}

		foreach (self::$settings['background_colors'] as $color_key => $color_params) {
			if ($block_background === 'block-bg-'.$color_params['_repeater_id'] && !empty($color_params['dark'][0])) {
				$block_attributes['class'][] = $color_params['dark'][0];
			}
		}

		// Screen Options
		if(!empty($block_hide))
		{
			$sm = in_array('sm', $block_hide);
			$md = in_array('md', $block_hide);
			$lg = in_array('lg', $block_hide);
			$xl = in_array('xl', $block_hide);

			if ($sm && $md && $lg && $xl) {
				$block_attributes['class'][] = 'd-none';
			} 
			elseif ($sm && !$md && !$lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-none d-md-block';
			} 
			elseif (!$sm && $md && !$lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-md-none d-lg-block';
			} 
			elseif (!$sm && !$md && $lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-lg-none d-xl-block';
			} 
			elseif (!$sm && !$md && !$lg && $xl) 
			{
				$block_attributes['class'][] = 'd-xl-none';
			} 
			elseif ($sm && $md && !$lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-none d-lg-block';
			} 
			elseif (!$sm && $md && $lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-md-none d-xl-block';
			} 
			elseif (!$sm && !$md && $lg && $xl) 
			{
				$block_attributes['class'][] = 'd-lg-none';
			} 
			elseif ($sm && $md && $lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-none d-lg-block';
			}
			elseif (!$sm && $md && $lg && $xl) 
			{
				$block_attributes['class'][] = 'd-md-none';
			}
			elseif (!$sm && $md && !$lg && $xl) 
			{
				$block_attributes['class'][] = 'd-md-none d-lg-block d-xl-none';
			}
			elseif ($sm && !$md && $lg && !$xl) 
			{
				$block_attributes['class'][] = 'd-none d-md-block d-lg-none d-xl-block';
			}
			elseif ($sm && !$md && !$lg && $xl) 
			{
				$block_attributes['class'][] = 'd-none d-md-block d-xl-none';
			}
			$block_attributes['class'] = array_merge($block_attributes['class'], $block_hide);
		}

		// Background
		$block_attributes['class'][] = $block_background;

		if(!empty(self::$settings['background_colors']))
		{
			foreach (self::$settings['background_colors'] as $color_key => $color_params)
			{
				$use_css_variable = (!empty($color_params['class']) && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class'));

				if(!empty($color_params['_repeater_id']) && $block_background === 'block-bg-'.$color_params['_repeater_id'] && $use_css_variable)
				{
					if(!GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'enqueue_css'))
					{
						$block_background = '';
					}
					$block_attributes['class'][] = $color_params['class'];
				}
			}
		}

		// Background Blur
		if(in_array($block_background, array('block-bg-image')) && $block_background_blur)
		{
			$block_attributes['class'][] = 'block-bg-blur';
			$block_attributes['data-image'] = self::get_prefered_image_size_src($block_background_image, 'small', false);
		}

		// Background Image
		if($block_background === 'block-bg-image' && $block_background_image)
		{
			$block_attributes['style'] = '';

			if(is_string($block_background_image) && !is_numeric($block_background_image))
			{
				$image_src = self::get_prefered_image_size_src($block_background_image, '', true);
				$block_attributes['style'] = " background-image: url('".esc_url($image_src)."'); ";

				if(is_admin() || !GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
				{
					$block_attributes['background_image_src_preload'] = esc_url($image_src);
				}
			}
			else if(!in_array('block-bg-blur', $block_attributes['class']))
			{
				$image_src = self::get_prefered_image_size_src($block_background_image);
				
				$block_attributes['style'] = ($image_src ? " background-image: url('".$image_src."'); " : '');
				$block_attributes['background_image_src_preload'] = ($image_src ? $image_src : '');

				if($block_name !== 'banner' && !is_admin() && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
				{
					unset($block_attributes['background_image_src_preload']);
					
					if($block_background === 'block-bg-image')
					{
						if($responsive_image_sizes = GBLOCKS::image_sources($block_background_image, true))
						{
							$block_attributes = array_merge($block_attributes, $responsive_image_sizes);
							if($block_name !== 'banner') $block_attributes['style'] = '';
						}
					}
				}
			}
		}

		// Background Overlay
		if(in_array($block_background, array('block-bg-image', 'block-bg-video')) && $block_background_overlay)
		{
			$block_attributes['class'][] = 'block-bg-overlay';
		}

		// Check for JS and CSS Files
		if($block_path = self::get_path($block_name))
		{
			// JS
			if(file_exists($block_path.'/block.js'))
			{
				add_action( 'wp_footer', function() use ($block_name, $block_path)
				{
					global $gblock_js_loaded;

					if(empty($gblock_js_loaded[$block_name]))
					{
						if(empty($gblock_js_loaded))
						{
							$gblock_js_loaded = array();
						}

						$gblock_js_loaded[$block_name] = true;

						echo "<script>\n".file_get_contents($block_path.'/block.js')."</script>\n";
					}

				}, 100);
			}

			// CSS
			if(file_exists($block_path.'/block.css'))
			{
				add_action( 'wp_footer', function() use ($block_name, $block_path)
				{
					global $gblock_css_loaded;

					if(empty($gblock_css_loaded[$block_name]))
					{
						if(empty($gblock_css_loaded))
						{
							$gblock_css_loaded = array();
						}

						$gblock_css_loaded[$block_name] = true;

						echo "<style>\n".file_get_contents($block_path.'/block.css')."</style>\n";
					}

				});
			}
		}

		// Add Aria Label
		$block_attributes['aria-label'] = ucwords(str_replace(array('-','_'), ' ', $block_name));

		// Style (Keep for Older Versions) #TODO Depricate as this can be handled by "gblocks_attributes" hook
		$block_attributes['style'] = apply_filters( 'gblock_background_style', (isset($block_attributes['style']) ? $block_attributes['style'] : ''));

		// Class (Keep for Older Versions) #TODO Depricate as this can be handled by "gblocks_attributes" hook
		$block_attributes['class'] = array_unique($block_attributes['class']);

		// $block_attributes['class'] = GBLOCKS::css()->add($block_attributes['class'])->get();
		// $block_attributes['class'] = explode(' ', $block_attributes['class']);

		// Allow filtering all attributes - remove empty values, but leave 0
		$block_attributes = array_filter(apply_filters('gblocks_container_attributes', $block_attributes, $block_name), function($value) {
    		return ($value !== null && $value !== false && $value !== '');
		});

		return $block_attributes;
	}

	private static function format_block_attributes($attributes)
	{
		$block_attributes = array();

		foreach ($attributes as $key => $attribute)
		{
			$block_attributes[esc_attr($key)] = '"'.esc_attr(is_array($attribute) ? implode(' ', $attribute) : $attribute).'"';
		}

		$block_attributes = trim(urldecode(http_build_query($block_attributes, '', ' ')));

		return $block_attributes;
	}


	private static function get_block_format($block_only_variables, $handler_file)
	{
		$block_name = self::$current_block_name;

		$sections = self::get_registered_sections();

		if(!empty($sections['fields'][0]['layouts'][$block_name]['gblocks_settings']['repeater']))
		{
			self::$block_wrapped_repeater_index++;
			while ( have_rows('wrapped_repeater') )
			{
				self::$block_index++;
				the_row();

				self::display_block($block_name, $block_only_variables, $handler_file);
			}
		}
		else
		{
			self::$block_index++;
			self::display_block($block_name, $block_only_variables, $handler_file);
		}
	}


	private static function display_block($block_name='', $block_variables=array(), $handler_file='')
	{
		if (strpos($block_name, 'acf/') !== false) {
			$block_is_wp_block = true;
			$block_name = str_replace('acf/', '', $block_name);
		}

		if(!$handler_file)
		{
			$handler_file = self::get_path('handler.php');
		}
		
		$block_variables['is_wp_block'] = !empty($block_is_wp_block) ? true : false;

		$block_attributes = self::get_block_attributes($block_name, $block_variables);

		$block_attributes['is_wp_block'] = !empty($block_is_wp_block) ? true : false;

		$block_attributes['class'][] = 'block-container';
		$block_attributes['class'][] = 'block-'.$block_name;
		$block_attributes['class'][] = 'block-index-'.self::$block_index;

		if(isset($block_attributes['background_image_src_preload']))
		{
			if(!empty($block_attributes['background_image_src_preload']))
			{
				$block_background_image_src_preload = $block_attributes['background_image_src_preload'];
			}
			unset($block_attributes['background_image_src_preload']);
		}

		$block_container_attributes = self::format_block_attributes($block_attributes);

		include $handler_file;
	}


	public static function has_block($block='', $object_id=0, $section='gblocks')
	{
		if(!$object_id)
		{
			$object_id = get_queried_object_id();
		}

		if(self::is_viewable())
		{
			if (function_exists('has_block') && has_block('acf/'.$block)) {
				return true;
			}

			if(get_field($section, $object_id))
			{
				while(the_flexible_field($section, $object_id))
				{
					if(strtolower(str_replace('_', '-', $block)) === strtolower(str_replace('_', '-', get_row_layout())))
					{
						reset_rows( true );
						return true;
					}
				}
			}
		}


		return false;
	}

	/**
	 * Returns the Array of locations that the blocks are attached to.
	 *
	 * Has Filter:
	 * Allows to be filtered with apply_filters( 'gblock_locations', $locations_formatted )
	 *
	 * @return array
	 */
	public static function get_locations($format = 'acf')
	{
		self::get_settings(true);
		$locations = array();
		$locations_formatted = array();


		if($format == 'viewable')
		{
			$locations['post_types'] = self::$settings['post_types'];
			$locations['templates'] = self::$settings['templates'];
			$locations['taxonomies'] = self::$settings['taxonomies'];
			$locations['option_pages'] = (!empty(self::$settings['option_pages']) ? self::$settings['option_pages'] : false);
			return $locations;
		}


		if(!empty(self::$settings['post_types']))
		{
			foreach (self::$settings['post_types'] as $location)
			{
				$locations[] = array('key' => 'post_type', 'value' => $location);
			}
		}

		if(!empty(self::$settings['templates']))
		{
			foreach (self::$settings['templates'] as $location)
			{
				$locations[] = array('key' => 'page_template', 'value' => $location);
			}
		}

		if(!empty(self::$settings['taxonomies']))
		{
			foreach (self::$settings['taxonomies'] as $location)
			{
				$locations[] = array('key' => 'taxonomy', 'value' => $location);
			}
		}

		$group = 0;


		foreach ($locations as $location)
		{
			$locations_formatted[] = array (
					array (
						'param' => $location['key'],
						'operator' => '==',
						'value' => $location['value'],
						'order_no' => 0,
						'group_no' => $group++,
					),
				);
		}

		$locations_formatted = apply_filters( 'gblock_locations', $locations_formatted );

		return $locations_formatted;
	}

	/**
	 * Outputs the Markup for the Block
	 *
	 * @param string $block - This is the name of the block folder to retrieve and output
	 *
	 * @return void
	 */
	public static function get_block($block='', $block_variables=array(), $block_attributes=array())
	{
		if(!empty($block_variables))
		{
			extract($block_variables);
		}

		if($path = self::get_path($block))
		{
			if(file_exists($path.'/block.php'))
			{
				do_action('gblocks_display_before', $block, $block_variables, $block_attributes);
				include($path.'/block.php');
				do_action('gblocks_display_after', $block, $block_variables, $block_attributes);
			}
			else
			{
				// Error
			}
		}
		else
		{
			// Error
		}
	}

	/**
	 * Outputs the Markup for a background Video
	 *
	 * @param string $block - This is the name of the block folder
	 *
	 * @return void
	 */
	public static function get_block_background_video_markup($block, $block_variables = array()){
		if(in_array($block, self::get_block_background_allowed_video())){
			if(!empty($block_variables)){ extract($block_variables); }
			$background = isset($block_background) ? $block_background : get_sub_field('block_background');
			if($background === 'block-bg-video')
			{
				$block_video_type = isset($block_video_type) ? $block_video_type : get_sub_field('block_background_video_type');
				$block_video_url = isset($block_video_url) ? $block_video_url : get_sub_field('block_background_video_'.$block_video_type);
				$block_video_poster = isset($block_video_poster) ? $block_video_poster : get_sub_field('block_background_image');
			}

			if(!empty($block_video_url)){?>
				<video class="block-video-container" src="<?php echo $block_video_url;?>" autoplay loop muted <?php if(!empty($block_video_poster['sizes']['large'])){?>poster="<?php echo $block_video_poster['sizes']['large'];?>" <?php } ?>preload="auto"></video>
			<?php }
		}
	}


	public static function get_block_background_image_markup($block, $block_variables = array(), $block_attributes = array())
	{

		if(in_array('block-bg-blur', $block_attributes['class']) && in_array('block-bg-image', $block_attributes['class']))
		{
			$image = '';

			if(!empty($block_attributes['data-image']))
			{
				$image = $block_attributes['data-image'];
			}

			if(empty($image))
			{
				foreach (array('data-rimg-small', 'data-rimg-medium', 'data-rimg-large') as $size)
				{
					if(!empty($block_attributes[$size]))
					{
						$image = $block_attributes[$size];
						break;
					}
				}
			}

			if(!empty($image))
			{
				?>
					<div class="block-bg-image-container" style="background-image: url('<?php echo $image;?>');"></div>
				<?php
			}
		}

		if(in_array('block-bg-overlay', $block_attributes['class']))
		{

			?>
				<div class="block-bg-overlay-container"></div>
			<?php
		}

	}

	/**
	 * Returns the specified setting for the block or array of all settings
	 *
	 * @param string $block - This is the name of the block folder to retrieve
	 * @param string $setting - This is the setting to retrieve
	 *
	 * @return array if no setting specified, string if setting is specified
	 */
	public static function get_block_settings($block='', $setting='')
	{
		$block = ($block != '') ? $block : self::$current_block_name;

		if($path = self::get_path($block))
		{
			if(file_exists($path.'/block_fields.php'))
			{
				$fields = include($path.'/block_fields.php');
				$settings = ($setting === '') ? $fields['gblocks_settings'] : $fields['gblocks_settings'][$setting];

				return $settings;
			}
		}

		// Reset Current Block
		$block = '';

		return false;
	}

	/**
	 * Returns the Enabled Blocks
	 *
	 * @return array
	 */
	public static function get_blocks()
	{
		self::get_settings(true);
		$blocks = array();

		if($available_blocks = self::get_available_blocks())
		{

			$enabled_blocks = array();

			foreach (self::$settings as $setting_key => $setting_value)
			{
				if(strpos($setting_key, 'blocks_enabled_') !== false && is_array($setting_value))
				{
					$enabled_blocks = array_merge($enabled_blocks, $setting_value);
				}
			}

			$blocks = array_intersect_key($available_blocks, array_flip($enabled_blocks));

		}

		return $blocks;
	}

	/**
	 * Returns all the available blocks
	 *
	 * Has Filter:
	 * Allows to be filtered with apply_filters( 'gblocks', $blocks );
	 *
	 * @return array
	 */
	public static function get_available_blocks()
	{
		// Return Cache if exists
		if(isset(self::$cache['filterd_blocks']))
		{
			return self::$cache['filterd_blocks'];
		}
		else
		{
			global $block;

			$blocks = array();
			$plugin_blocks = array();
			$theme_blocks = array();

			// Get blocks from the Plugin
			if($directory = self::get_path())
			{
				$plugin_blocks = array_filter(glob($directory.'*'), 'is_dir');
			}

			// Get blocks from the Theme
			if($directory = get_template_directory().'/gblocks/')
			{
				if(is_dir($directory))
				{
					$theme_blocks = array_filter(glob($directory.'*'), 'is_dir');
				}
			}

			/* These are just placed to ignore any php warnings when including the fields */
			$block_backgrounds = '';
			$block_background_image = '';

			if($plugin_blocks)
			{
				foreach($plugin_blocks as $dir)
				{
					$block = basename($dir);
				    if(file_exists($dir.'/block_fields.php'))
				    {
				    	$fields = include($dir.'/block_fields.php');
				    	$label = (!empty($fields['label'])) ? $fields['label'] : $block;
						$blocks[$block] = array('label' => $label, 'path' => $dir, 'group' => (!empty($fields['gblocks_settings']['group']) ? $fields['gblocks_settings']['group'] : 'default'));
					}
				}
			}

			if($theme_blocks)
			{
				foreach($theme_blocks as $dir)
				{
					$block = basename($dir);

				    if(file_exists($dir.'/block_fields.php'))
				    {
				    	$fields = include($dir.'/block_fields.php');
				    	$label = (!empty($fields['label'])) ? $fields['label'] : $block;
						$blocks[$block] = array('label' => $label, 'path' => $dir, 'group' => (!empty($fields['gblocks_settings']['group']) ? $fields['gblocks_settings']['group'] : 'theme'));
					}
				}
			}

			// Reset Current Block
			$block = '';

			// Apply Filters to allow others to filter the blocks used.
			$filterd_blocks = apply_filters( 'gblocks', $blocks );

			self::$cache['filterd_blocks'] = $filterd_blocks;

			return $filterd_blocks;
		}
	}

	/**
	 * Returns all the available block groups
	 *
	 *
	 * @return array
	 */
	public static function get_available_block_groups()
	{
		$block_groups = array();
		foreach (self::get_available_blocks() as $block => $block_params)
		{
			$block_groups[str_replace(' ', '_', strtolower($block_params['group']))][$block] = $block_params['label'];
		}
		return $block_groups;
	}

	/**
	 * Gets the correct path of a file or directory for a Block asset.
	 * Allows to be overwritten by the theme if the theme has a block asset in /gblocks/
	 *
	 * @param string $path
	 *
	 * @return string|false
	 */
	public static function get_path($path='')
	{
		if(!$path)
		{
			if(is_dir(plugin_dir_path( __FILE__ ).'gblocks/'))
			{
				return plugin_dir_path( __FILE__ ).'gblocks/';
			}
			else
			{
				// Error
			}
		}
		else
		{
			if(is_dir(get_template_directory().'/gblocks/'.$path.'/'))
			{
				return get_template_directory().'/gblocks/'.$path;
			}
			else if(file_exists(get_template_directory().'/gblocks/'.$path))
			{
				return get_template_directory().'/gblocks/'.$path;
			}
			else if(is_dir(plugin_dir_path( __FILE__ ).'gblocks/'.$path.'/'))
			{
				return plugin_dir_path( __FILE__ ).'gblocks/'.$path;
			}
			else if(file_exists(plugin_dir_path( __FILE__ ).'gblocks/'.$path))
			{
				return plugin_dir_path( __FILE__ ).'gblocks/'.$path;
			}
			else if(file_exists(get_template_directory().'/gblocks/'.str_replace('-', '_', $path)))
			{
				return get_template_directory().'/gblocks/'.str_replace('-', '_', $path);
			}

			return false;
		}
	}

	/**
	 * Returns the Real IP from the user
	 *
	 * @return string
	 */
	public static function get_real_ip()
    {
        foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR') as $server_ip)
        {
            if(!empty($_SERVER[$server_ip]) && is_string($_SERVER[$server_ip]))
            {
                if($ip = trim(reset(explode(',', $_SERVER[$server_ip]))))
	            {
	            	return $ip;
	            }
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns the Settings Fields for specifc location.
     *
     * @param string $location
     *
     * @return array
     */
	private static function get_settings_fields($location = 'general')
	{
		switch ($location)
		{

			case 'advanced':
				$advanced_options = array(
					'filter_content' => 'G-Blocks will be added to the end of your content. <span class="extra-info">( Using "the_content" filter )</span>',
					'filter_excerpt' => 'Filter the_excerpt() with Block Fields (all postmeta fields) when the_excerpt() or the_content() is empty.',
					'include_in_search' => 'Include Block Fields (all postmeta fields) in the search criteria.',
					'after_title' => 'Place G-Blocks directly after the title in the WordPress admin. <span class="extra-info">( changes position using acf_after_title )</span>',
					'hide_content' => 'Remove the WordPress content box from G-Blocks enabled pages. <span class="extra-info">( if content has already been entered it may still show on the front end of the website. )</span>',
					'add_responsive_img' => 'Add "Responsive-Images" JS. This will also include data attributes for all image sizes.',
				);
				$css_options = array(
					'add_custom_color_class' => 'Allow customization of CSS class names for the background color options.',
					'disable_colorpicker' => 'Disable color picker ( Use this to force your own css class names ).',
					'enqueue_css' => 'Background color CSS will be added to the website\'s header. <span class="extra-info">( Needed for custom background colors, images, etc. )</span>',
				);

				$fields = array();
				$fields['advanced_options'] = array('type' => 'checkbox', 'label' => 'Advanced Options', 'options' => $advanced_options, 'description' => '');
				$fields['css_options'] = array('type' => 'checkbox', 'label' => 'CSS Settings', 'options' => $css_options, 'description' => '');

			break;

			default:
			case 'general':
				$post_types = self::get_usable_post_types();
				$template_options = self::get_template_options();
				$block_groups = self::get_available_block_groups();

				$option_pages = self::get_acf_option_pages(true);

				$taxonomies = self::get_usable_taxonomies(true);

				$background_colors_repeater = array();
				$background_colors_repeater['name'] = array('type' => 'text', 'label' => 'Name', 'description' => 'Name of color');

				if(GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class'))
				{
					$background_colors_repeater['class'] = array('type' => 'text', 'label' => 'CSS Class Name', 'description' => '( Optional )');
				}

				if(!GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'disable_colorpicker'))
				{
					$background_colors_repeater['value'] = array('type' => 'colorpicker', 'label' => 'Value', 'description' => 'Use Hex values (ex. #ff0000)');
				}

				$background_colors_repeater['dark'] = array('type' => 'checkbox', 'options' => ['text-light bg-dark' => 'Yes'], 'label' => 'Is Dark Background', 'description' => 'Should Text be converted to light text with this background color');

				$fields = array();

				foreach ($block_groups as $group => $blocks)
				{
					foreach($blocks as $block_slug => $block_label)
					{
						if($block_settings = self::get_block_settings($block_slug))
						{
							$block_settings['label'] = $block_label;
							$blocks[$block_slug] = $block_settings;
						}
					}
					$description = ($group == 'default') ? 'Determine what default blocks will be available.' : '';
					$fields['blocks_enabled_'.$group] = array('type' => 'checkbox', 'label' => ucwords(str_replace('_', ' ', $group)).' Blocks', 'options' => $blocks, 'description' => $description);
				}

				$fields['background_colors'] = array('type' => 'repeater', 'label' => 'Background Color Options', 'fields' => $background_colors_repeater, 'description' => 'Choose what Background Colors you want to have the G-Blocks.');
				$fields['post_types'] = array('type' => 'checkbox', 'label' => 'Post Types', 'options' => $post_types, 'description' => 'Determine the post types that G-Blocks will appear on.');
				$fields['templates'] = array('type' => 'checkbox', 'label' => 'Page Templates', 'options' => $template_options, 'description' => 'Determine the page templates that G-Blocks will appear on.');

				if(!empty($taxonomies))
				{
					$fields['taxonomies'] = array('type' => 'checkbox', 'label' => 'Taxonomies', 'options' => $taxonomies, 'description' => 'Determine the Taxonomy Archive Pages that G-Blocks will appear on.');
				}

				if(!empty($option_pages))
				{
					$fields['option_pages'] = array('type' => 'checkbox', 'label' => 'Option Pages', 'options' => $option_pages, 'description' => 'Determine the ACF Option Pages that G-Blocks will appear on.');
				}



			break;

		}

		return $fields;
	}


	/**
	 * Gets current version of G-Blocks
	 *
	 *
	 * @return
	 */
	public static function get_version()
	{
		return self::$version;
	}


	/**
	 * Gets current version of foundation
	 *
	 *
	 * @return
	 */
	public static function get_foundation_version()
	{
		$foundation_version = GBLOCKS_PLUGIN_SETTINGS::get_setting_value('foundation', 0);
		return $foundation_version;
	}

	/**
	 * Gets current version of foundation
	 *
	 *
	 * @return
	 */
	public static function get_foundation_file_name()
	{
		$foundation_version = self::get_foundation_version();
		switch ($foundation_version){
			case 'f5':
				$foundation_file_name = 'foundation5';
				break;

			case 'f6':
				$foundation_file_name = 'foundation6';
				break;

			default:
			case 'f6flex':
				$foundation_file_name = 'foundation6flex';
				break;

		}
		return $foundation_file_name;
	}


	/**
	 * Runs the Admin Page and outputs the HTML
	 *
	 * @return void
	 */
	public static function admin()
	{
		if (class_exists('GBLOCKS_PLUGIN_SETTINGS')) {

			// Get Settings
			self::get_settings(true);

			// Save Settings if POST
			$response = GBLOCKS_PLUGIN_SETTINGS::save_settings();
			if($response['error'])
			{
				$error = 'Error saving Settings. Please try again.';
			}
			else if($response['success'])
			{
				$success = 'Settings saved successfully.';
			}
		}

		?>
		<?php add_thickbox(); ?>
		<div class="wrap gblocks">
			<header>
				<h1>G Blocks <small class="gblocks-version-label">Version <?php echo self::$version;?></small></h1>
			</header>
			<main>

				<?php if(!function_exists('acf_add_local_field_group'))
				{
					self::acf_notice(false);
				}
				else
				{
					if(!empty($error)){?><div class="error"><p><?php echo $error; ?></p></div><?php }
					if(!empty($success)){?><div class="updated"><p><?php echo $success; ?></p></div><?php } 
					
					?>
					
					<br>
					<div class="gblocks-redirects-page-links">
						<a href="<?php echo self::$page;?>&section=general" class="<?php echo self::get_current_tab($_GET['section'], 'general'); ?>">General</a>
						<a href="<?php echo self::$page;?>&section=advanced" class="<?php echo self::get_current_tab($_GET['section'], 'advanced'); ?>">Advanced</a>
						<a href="<?php echo self::$page;?>&section=developers" class="<?php echo self::get_current_tab($_GET['section'], 'developers'); ?>">Developers</a>
						<a href="<?php echo self::$page;?>&section=usage" class="<?php echo self::get_current_tab($_GET['section'], 'usage'); ?>">Block Usage</a>
					</div>

					<br>
					<br>

					<?php

					$section = (!empty($_GET['section']) ? $_GET['section'] : 'settings');

					switch($section)
					{
						case 'advanced':
							self::form('advanced');
						break;

						case 'developers':
							self::developers();
						break;

						case 'usage':
							self::blocks_usage();
						break;

						default:
						case 'settings':
							self::form();
						break;
					}
				}
				?>
			</main>
		</div>
		<?php
	}

	/**
	 * Outputs the Form with the correct fields
	 *
	 * @param string $location
	 *
	 * @return type
	 */
	private static function form($location = 'general')
	{
		// Get Form Fields
		switch ($location)
		{
			default;
			case 'general':
				$fields = self::get_settings_fields();
				break;

			case 'advanced':
				$fields = self::get_settings_fields('advanced');
				break;
		}

		GBLOCKS_PLUGIN_SETTINGS::get_form($fields);
	}

	private static function developers()
	{
		include_once('library/includes/developer.php');
	}

	private static function blocks_usage() {
		include_once('library/includes/blocks-usage.php');
	}

	/**
	 * Filters a string to be in a title format
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	public static function unsanitize_title($title)
	{
		return ucwords(str_replace(array('_', '-'), ' ', $title));
	}

	/**
	 * Enqueue Admin Scripts
	 *
	 * @param $hook
	 *
	 * @return runs enqueue for admin
	 */
	public static function enqueue_admin_files($hook){

		wp_enqueue_style( 'gblocks_admin_css', get_template_directory_uri().'/lib/gblocks/library/admin.css', true, '1.0.0' );

		if ( 'toplevel_page_gblocks' != $hook ) {
	        return;
	    }

    	wp_enqueue_script( 'gblocks_scripts_js', get_template_directory_uri().'/lib/gblocks/library/js/blocks.min.js', array('jquery'), self::$version, true );
	    wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
	 * Enqueue Front End Scripts
	 *
	 * @param $hook
	 *
	 * @return runs enqueue for front end where required
	 */
	public static function enqueue_files($hook)
	{
		if (GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			wp_enqueue_script( 'gblocks_responsive-images_js', get_template_directory_uri().'/lib/gblocks/library/js/responsive-images.min.js', array('jquery'), self::$version, true );
		}
	}

	/**
	 * Add any necessary JS to footer
	 *
	 * @param
	 *
	 * @return
	 */
	public static function add_footer_js(){
		?>
			<script>
				if (window.jQuery) {
					jQuery(function($){
						$(document).ready(function(){

						<?php if(!is_admin() && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img')){

							$image_sizes = array();
							foreach (self::get_image_sizes() as $name => $image)
							{
								// Only include sizes that are not cropped.
								if(empty($image['crop']) && $image['width'])
								{
									$image_sizes[$name] = $image['width'];
								}
							}

							// Sort Sizes from smallest to largest by width
							asort($image_sizes);

							// Create json format for jquery
							$image_sizes_array = array();
							foreach ($image_sizes as $name => $width)
							{
								$image_sizes_array[] = array('name' => $name, 'size' => $width);
							}

							$image_sizes_array[] = array('name' => 'full', 'size' => 99999);

							$responsive_image_settings = array(
								'watch' => 'tag',
								'throttle' => 100,
								'downscale' => false,
								'downsize' => false,
								'onload' => true,
								'lazyload' => true,
								'lazyload_threshold' => 1000,
								'forcetagwidth' => true,
								'retna' => false,
								'sizes' => $image_sizes_array
							);

							$filtered_responsive_image_settings = apply_filters( 'gblocks_responsive_image_settings', $responsive_image_settings );

							?>

							$(this).responsiveImages(<?php echo json_encode($filtered_responsive_image_settings);?>);

						<?php } ?>

						});
					});
				}
			</script>
		<?php
	}



	/**
	 * Check for the Post or Queried Object ID
	 *
	 * @param none
	 *
	 * @return int | false
	 */
	public static function get_queried_object_id()
	{
		$post_id = ( ($query = get_queried_object()) && !empty($query->ID) ) ? $query->ID : false;
		return $post_id;
	}



	/**
	 * Check if blocks are viewable on the front end
	 *
	 * @param none
	 *
	 * @return boolean
	 */
	public static function is_viewable($object=0)
	{
		$is_viewable = false;
		if(!$object)
		{
			$object = self::get_queried_object_id();
		}

		if( $object )
		{
			$locations = self::get_locations('viewable');

			if(!empty($locations['post_types']) && is_numeric($object))
			{
				$post_type = get_post_type($object);

				if(!empty($post_type) && in_array($post_type, $locations['post_types']))
				{
					$is_viewable = true;
				}
			}

			if(!empty($locations['templates']) && is_numeric($object))
			{
				$is_default = (get_page_template_slug($object) == '' && in_array('default', $locations['templates']));

				if($is_default || in_array(get_page_template_slug($object), $locations['templates']))
				{
					$is_viewable = true;
				}
			}

			if(!empty($locations['taxonomies']))
			{
				$queried_object = get_queried_object();
				if(!empty($queried_object->taxonomy))
				{
					$queried_object = get_taxonomy($queried_object->taxonomy);
					if(!empty($queried_object->name) && in_array($queried_object->name, $locations['taxonomies']))
					{
						$is_viewable = true;
					}
				}
			}

			if(!empty($locations['option_pages']) && in_array($object, $locations['option_pages']))
			{
				$is_viewable = true;
			}

		}
		$is_viewable = apply_filters( 'gblock_is_viewable', $is_viewable );
		return $is_viewable;
	}

	/**
	 * Filters the content and adds content blocks to the end of the content
	 *
	 * @param string $content
	 *
	 * @return
	 */
	public static function filter_content($content)
	{

		ob_start();

		self::display();

		$blocks = ob_get_contents();
		ob_end_clean();

		return $content . $blocks;

	}

	/**
	 * Gets acf registered Option Pages
	 *
	 * @param $titles_only (bool)
	 *
	 * @return
	 */
	public static function get_acf_option_pages($titles_only=false)
	{
		$pages = array();

		if(!empty($GLOBALS['acf_options_pages']))
		{
			if($titles_only)
			{
				foreach ($GLOBALS['acf_options_pages'] as $key => $page)
				{
					$pages[$key] = $page['page_title'];
				}
			}
			else
			{
				$pages = $GLOBALS['acf_options_pages'];
			}
		}

		return $pages;

	}

	/**
	 * Gets usable taxonomies
	 *
	 * @param
	 *
	 * @return
	 */
	public static function get_usable_taxonomies($titles_only=false)
	{
		$taxonomies = array();

		foreach(get_taxonomies(array('public' => true), 'objects') as $taxonomy)
		{
			if($taxonomy->name !== 'post_format')
			{
				if($titles_only)
				{
					$taxonomies[$taxonomy->name] = $taxonomy->label;
				}
				else
				{
					$taxonomies[] = $taxonomy;
				}
			}
		}

		return $taxonomies;
	}

	/**
	 * Gets usable post types
	 *
	 * @param
	 *
	 * @return
	 */
	public static function get_usable_post_types()
	{


		$posts = get_post_types();
		$post_types = array();

		foreach($posts as $post_type)
		{
			if(!in_array($post_type, self::$posts_to_exclude))
			{
				$post_types[$post_type] = self::unsanitize_title($post_type);
			}
		}

		// TODO add filter here for $post_types

		return $post_types;

	}

	/**
	 * Gets template options
	 *
	 * @param
	 *
	 * @return
	 */
	public static function get_template_options()
	{

		// TODO add filter here for $templates_to_exclude

		$templates = get_page_templates();
		$template_options = array();

		if(!in_array('default', array_map('strtolower', $templates)) && !in_array('page.php', array_map('strtolower', $templates)) && file_exists(get_template_directory().'/page.php'))
		{
			$templates = array_merge(array('Default' => 'default'), $templates);
		}

		foreach($templates as $key => $template)
		{
			$template_options[$template] = self::unsanitize_title($key);
		}

		return $template_options;

	}

	/**
	 * Gets current tab and sets active state
	 *
	 * @param string $current
	 * @param string $section
	 *
	 * @return
	 */
	public static function get_current_tab($current = '' , $section = ''){

		if($current == $section || ($current == '' && $section == 'general'))
		{
			return 'active';
		}

	}


	/**
	 * Converts a URL to a verified Vimeo ID
	 *
	 * @param  $url  (string) Url of a defined Vimeo Video.
	 *
	 * @return (int)
	 * @author GG
	 *
	 **/
	public static function get_vimeo_id($url)
	{
		preg_match('/([0-9]+)/', $url, $matches);
		if(!empty($matches[1]) && is_numeric($matches[1]))
		{
			return $matches[1];
		}
		else if(strpos($url, 'http') === false)
		{
			return $url;
		}
		return 0;
	}
	/**
	 * onverts a URL to a verified YouTube ID
	 *
	 * @param  $url  (string) Url of a defined Youtube Video.
	 *
	 * @return (int)
	 * @author GG
	 *
	 **/
	public static function get_youtube_id($url)
	{
		if(!$pos = strpos($url, 'youtu.be/'))
		{
			$pos = strpos($url, '/watch?v=');
		}
		if($pos)
		{
			$split = explode("?", substr($url, ($pos+9)));
			$split = explode("&", $split[0]);
			return $split[0];
		}
		else if($pos = strpos($url, '/embed/'))
		{
			$split = explode("?", substr($url, ($pos+7)));
			return $split[0];
		}
		else if($pos = strpos($url, '/v/'))
		{
			$split = explode("?", substr($url, ($pos+3)));
			return $split[0];
		}
		else if(!$pos && strpos($url, 'http') === false)
		{
			return $url;
		}
		return 0;
	}
	/**
	 * Converts a URL to a verified YouTube video ID function
	 *
	 * @param  $url  (string) Url of a defined Youtube Video.
	 *
	 * REQUIRES: function gblock_get_youtube_id()
	 *
	 * @return (str)
	 * @author GG
	 *
	 **/
	public static function get_video_url($url)
	{
		$autoplay = 1;
		if(strpos($url, 'autoplay=0') || strpos($url, 'autoplay=false'))
		{
			$autoplay = 0;
		}
		if(strpos($url, 'vimeo'))
		{
			$id = self::get_vimeo_id($url);
			if(is_numeric($id))
			{
				return 'https://player.vimeo.com/video/'.$id.'?autoplay='.$autoplay;
			}
			return $url;
		}
		$id = self::get_youtube_id($url);
		if($id)
		{
			$link = 'https://www.youtube.com/embed/'.$id.'?rel=0&amp;iframe=true&amp;wmode=transparent&amp;autoplay='.$autoplay;
			return $link;
		}
		return '';
	}

	public static function column_width_options()
	{
		$column_width_options = array(
			2 => 'X-Small',
			3 => 'Small',
			4 => 'Medium-Small',
			6 => 'Half',
			8 => 'Medium-Large',
			9 => 'Large',
			10 => 'X-Large',
		);

		// allow filtering of column sizes for the media with content block
		$filtered_column_width_options = apply_filters( 'gblock_column_widths', $column_width_options );

		return $filtered_column_width_options;
	}


	/**
	 * Converts a single array of link options into multiple fields
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $includes
	 * @param bool   $show_text
	 * @param array  $post_types
	 * @param array  $conditional_logic
	 * @param array  $styles
	 *
	 * @return array
	 * @author GG & BF
	 *
	 **/
	public static function get_link_fields($name = 'link', $label = '', $includes = array(), $show_text = true, $post_types = array(0 => 'all'), $conditional_logic = array(), $styles = array())
	{
		$post_types = array();

		$block_name = self::$current_block_name;

		foreach(get_post_types(array('public' => true)) as $post_type)
		{
			if($count = wp_count_posts($post_type)->publish)
			{
				$post_types[$count] = $post_type;
			}
		}

		if(!empty($post_types))
		{
			ksort($post_types);
		}

		if(is_array($name))
		{
			$arr = $name;
			$name = isset($arr['name']) ? sanitize_title($arr['name']) : sanitize_title($name);
			$label = isset($arr['label']) ? $arr['label'] : (isset($arr['name']) ? ucwords(str_replace(array('_', '-'), ' ', $arr['name'])) : 'link');
			$includes = isset($arr['includes']) ? $arr['includes'] : array();
			$styles = isset($arr['styles']) ? $arr['styles'] : $styles;
			$show_text = isset($arr['show_text']) ? $arr['show_text'] : true;
			$post_types = isset($arr['post_types']) ? $arr['post_types'] : $post_types;
			$conditional_logic = isset($arr['conditional_logic']) ? $arr['conditional_logic'] : array();
		}

		if(empty($name))
		{
			$name = sanitize_title($label);
		}

		global $block;

		$allowed_options = array(
			'none' => 'None',
			'page' => 'Page Link',
			'url' => 'URL',
			'file' => 'File Download',
			'video' => 'Play Video',
		);
		$allowed_fields = !empty($includes) ? array() : $allowed_options;

		if(!empty($includes)){
			foreach($includes as $include_key => $include){
				// Allow the Dev to change the Label
				if(!is_numeric($include_key) && isset($allowed_options[$include_key]))
				{
					$allowed_fields[$include_key] = $include;
				}
				else  // Use Default Label
				{
					$allowed_fields[$include] = $allowed_options[$include];
				}
			}
		}

		// Format the Array if it is not formatted correctly
		if(!empty($conditional_logic) && is_array($conditional_logic))
		{
			// Check if it has Wrapping Array
			if(empty($conditional_logic[0][0]))
			{
				$conditional_logic = array($conditional_logic);
			}

			// If it is still not Wrapping then add another
			if(empty($conditional_logic[0][0]))
			{
				$conditional_logic = array($conditional_logic);
			}
		}
		else
		{
			$conditional_logic = array();
		}

		$label_title = ucwords(str_replace(array('-','_'),' ',$label));
		$fields = array();

		$fields[] = array (
			'key' => 'field_'.$block.'_'.$name.'_type',
			'label' => $label_title.' Type',
			'name' => $name.'_type',
			'type' => 'radio',
			'layout' => 'horizontal',
			'column_width' => '',
			'choices' => $allowed_fields,
			'default_value' => 'none',
			'allow_null' => 0,
			'multiple' => 0,
			'conditional_logic' => (!empty($conditional_logic) ? $conditional_logic : 0)
		);

		$field_conditional_logic = array (
			array (
				array (
					'field' => 'field_'.$block.'_'.$name.'_type',
					'operator' => '!=',
					'value' => 'none',
				),
			),
		);

		if(!empty($conditional_logic))
		{
			$field_conditional_logic[0][] = $conditional_logic[0][0];
		}

		if($show_text){
			$fields[] = array (
				'key' => 'field_'.$block.'_'.$name.'_text',
				'label' => $label_title.' Text',
				'name' => $name.'_text',
				'type' => 'text',
				'required' => 1,
				'conditional_logic' => $field_conditional_logic,
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			);
		}

		if(isset($allowed_fields['url']))
		{
			$field_conditional_logic[0][0]['operator'] = '==';
			$field_conditional_logic[0][0]['value'] = 'url';

			$fields[] = array (
				'key' => 'field_'.$block.'_'.$name.'_url',
				'label' => $allowed_fields['url'],
				'name' => $name.'_url',
				'type' => 'text',
				'required' => 1,
				'conditional_logic' => $field_conditional_logic,
				'column_width' => '',
				'default_value' => '',
				'placeholder' => 'http://',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			);
		}

		if(isset($allowed_fields['page']))
		{
			$field_conditional_logic[0][0]['operator'] = '==';
			$field_conditional_logic[0][0]['value'] = 'page';

			$fields[] = array (
				'key' => 'field_'.$block.'_'.$name.'_page',
				'label' => $allowed_fields['page'],
				'name' => $name.'_page',
				'type' => 'page_link',
				'required' => 1,
				'conditional_logic' => $field_conditional_logic,
				'column_width' => '',
				'post_type' => $post_types,
				'allow_null' => 0,
				'multiple' => 0,
			);
		}

		if(isset($allowed_fields['file']))
		{
			$field_conditional_logic[0][0]['operator'] = '==';
			$field_conditional_logic[0][0]['value'] = 'file';

			$fields[] = array (
				'key' => 'field_'.$block.'_'.$name.'_file',
				'label' => $allowed_fields['file'],
				'name' => $name.'_file',
				'type' => 'file',
				'required' => 1,
				'conditional_logic' => $field_conditional_logic,
				'column_width' => '',
				'save_format' => 'url',
				'library' => 'all',
			);
		}

		if(isset($allowed_fields['video']))
		{
			$field_conditional_logic[0][0]['operator'] = '==';
			$field_conditional_logic[0][0]['value'] = 'video';

			$fields[] = array (
				'key' => 'field_'.$block.'_'.$name.'_video',
				'label' => $allowed_fields['video'],
				'name' => $name.'_video',
				'type' => 'text',
				'required' => 1,
				'instructions' => 'This works for Vimeo or Youtube. Just paste in the url to the video you want to show.',
				'conditional_logic' => $field_conditional_logic,
				'column_width' => '',
				'default_value' => '',
				'placeholder' => 'http://',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			);
		}

		$styles = apply_filters('gblocks_link_fields_styles', $styles, $block_name, $name);

		if(!empty($styles) && is_array($styles))
		{
			$field_conditional_logic[0][0]['operator'] = '!=';
			$field_conditional_logic[0][0]['value'] = 'none';

			$fields[] = array (
				'key' => 'field_'.$block.'_'.$name.'_style',
				'label' => 'Style',
				'name' => $name.'_style',
				'type' => 'radio',
			    'instructions' => '',
			    'required' => 0,
			    'conditional_logic' => $field_conditional_logic,
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'choices' => $styles,
			    'other_choice' => 0,
			    'save_other_choice' => 0,
			    'default_value' => '',
			    'layout' => 'horizontal',
			);
		}

		$filtered_fields = apply_filters('gblock_link_fields', $fields);
		return array('gblock_link_fields' => $filtered_fields);
	}

	public static function get_link_url($field)
	{
		// TODO make this a public filterable array
		$allowed_options = array(
			'none' => 'None',
			'page' => 'Page Link',
			'url' => 'URL',
			'file' => 'File Download',
			'video' => 'Play Video',
		);
		if($type = self::getField($field.'_type'))
		{
			if($type != 'none')
			{
				$url = self::getField($field.'_'.$type);
				if(!array_key_exists($type, $allowed_options))
				{
					$url = self::getField($field.'_url');
				}
				if($type == 'video')
				{
					$url = self::get_video_url($url);
				}
				return esc_url($url);
			}
		}
		return '';
	}

	public static function get_link_html($field, $class='')
	{
		$url = ($type_url = self::get_link_url($field)) ? $type_url : '#';
		if($text = get_sub_field($field.'_text'))
		{
			?>
				<a class="block-link-<?php echo esc_attr(get_sub_field($field.'_type'));?><?php echo ($class ? ' '.$class : '');?>" href="<?php echo esc_url($url);?>"><?php echo esc_html($text);?></a>
			<?php
		}
	}

	public static function filter_layout_links(&$item, $key='', $lookup='')
	{
	    if(!empty($item) && is_array($item))
	    {
	        foreach ($item as $k => $v)
	        {
	            if(is_array($v) && isset($v[$lookup]))
	            {
	                array_splice($item, array_search($k, array_keys($item)), 1, $v[$lookup]);
	            }
	        }
	        array_walk($item, array(__CLASS__, __METHOD__), $lookup);
	    }
	}




	/**
	* Get size information for all currently-registered image sizes.
	*
	* @global $_wp_additional_image_sizes
	* @uses   get_intermediate_image_sizes()
	* @return array $sizes Data for all currently-registered image sizes.
	*/
	public static function get_image_sizes()
	{
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size )
		{
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			}
			elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) )
			{
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}


	private static function get_prefered_image_size_src($image, $size='', $largest=true)
	{
		if($largest)
		{
			$sizes = array($size, 'xlarge', 'large');
		}
		else
		{
			$sizes = array($size, 'xsmall', 'small', 'medium', 'medium_large', 'large', 'xlarge');
		}

		foreach ($sizes as $size)
		{
			if(!empty($image['sizes'][$size]))
			{
				return $image['sizes'][$size];
			}
		}

		if(!empty($image['url']))
		{
			return $image['url'];
		}

		return '';
	}



	public static function image_sources($image='featured', $return_as_array=false)
	{
		$sources = array();

		if(is_numeric($image) && get_post_type($image) !== 'attachment')
		{
			$image = get_post_thumbnail_id($image);
		}

		if($image === 'featured')
		{
			$image = get_post_thumbnail_id();
		}

		if(is_numeric($image) || !empty($image['sizes']))
		{
			$image_sizes = self::get_image_sizes();

			if(is_numeric($image))
			{
				foreach ($image_sizes as $size => $image_size)
				{
					// Only include sizes that are not cropped.
					if(empty($image_size['crop']) && $image_size['width'])
					{
						if($url = wp_get_attachment_image_src( $image, $size ))
						{
							$sources['data-rimg-'.$size] = $url[0];
						}
					}
				}
			}
			else
			{
				foreach ($image['sizes'] as $size => $url)
				{
					if(!preg_match('/\-width|\-height/i', $size) && isset($image_sizes[$size]['crop']) && empty($image_sizes[$size]['crop']))
					{
						$sources['data-rimg-'.$size] = $url;
					}
				}
			}
		}

		if($return_as_array)
		{
			return $sources;
		}

		foreach ($sources as $key => $source)
		{
			$sources[$key] = '"'.$source.'"';
		}

		return trim(urldecode(http_build_query($sources, '', ' ')));
	}


	public static function image_background($image='featured', $fallback_size='large')
	{
		if(!is_admin() && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			return self::image_sources($image);
		}

		if($image === 'featured' || is_numeric($image) )
		{
			if(is_numeric($image) && get_post_type($image) !== 'attachment')
			{
				$attachment = get_post(get_post_thumbnail_id($image));
			}
			else
			{
				$attachment = get_post(get_post_thumbnail_id());
			}

			if($attachment)
			{
				$image = array(
					'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'caption' => $attachment->post_excerpt,
					'description' => $attachment->post_content,
					'href' => get_permalink( $attachment->ID ),
					'src' => $attachment->guid,
					'url' => $attachment->guid,
					'title' => $attachment->post_title
				);

				$image['sizes'] = array();

				foreach (self::get_image_sizes() as $size => $image_size)
				{
					// Only include sizes that are not cropped.
					if(empty($image_size['crop']) && $image_size['width'])
					{
						if($url = wp_get_attachment_image_src( $attachment->ID, $size ))
						{
							$image['sizes'][$size] = $url[0];
						}
					}
				}
			}
		}

		if(!empty($image))
		{
			$prefered_image_src = self::get_prefered_image_size_src($image, $fallback_size);

			if($prefered_image_src)
			{
				return " style=\"background-image: url('".$prefered_image_src."');\" ";
			}
		}

		return '';

	}



	public static function image($image='featured', $additional_attributes=array(), $tag_type='img', $fallback_size='')
	{
		if(empty($image)){
			return '';
		}
		if($image === 'featured' || is_numeric($image))
		{
			if(is_numeric($image) && get_post_type($image) !== 'attachment')
			{
				$attachment = get_post(get_post_thumbnail_id($image));
			}
			else
			{
				$attachment = get_post(get_post_thumbnail_id());
			}

			if($attachment)
			{
				$image = array(
					'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'caption' => $attachment->post_excerpt,
					'description' => $attachment->post_content,
					'href' => get_permalink( $attachment->ID ),
					'src' => $attachment->guid,
					'url' => $attachment->guid,
					'title' => $attachment->post_title
				);

				$image['sizes'] = array();

				foreach (self::get_image_sizes() as $size => $image_size)
				{
					// Only include sizes that are not cropped.
					if(empty($image_size['crop']) && $image_size['width'])
					{
						if($url = wp_get_attachment_image_src( $attachment->ID, $size ))
						{
							$image['sizes'][$size] = $url[0];
						}
					}
				}
			}
			else
			{
				return '';
			}
		}

		if($tag_type === 'img' && !isset($additional_attributes['alt']) && !empty($image['alt']))
		{
			$additional_attributes['alt'] = esc_attr($image['alt']);
		}

		if(!isset($additional_attributes['title']) && !empty($image['title']))
		{
			$additional_attributes['title'] = esc_attr($image['title']);
		}

		// Accessibility
		if($tag_type === 'img' && empty($additional_attributes['alt']) && !empty($additional_attributes['title']))
		{
			$additional_attributes['alt'] = $additional_attributes['title'];
		}

		$image_sources = array();

		if(!is_admin() && GBLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			$additional_attributes['src'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

			$image_sources = self::image_sources($image, true);
		}
		else
		{
			$prefered_image_src = self::get_prefered_image_size_src($image, $fallback_size);

			if($tag_type === 'img' && !isset($additional_attributes['src']))
			{
				if($prefered_image_src)
				{
					$additional_attributes['src'] = $prefered_image_src;
				}
			}

			if($tag_type !== 'img' && $prefered_image_src)
			{
				$additional_attributes['style'] = " background-image: url('".$prefered_image_src."'); ";
			}
		}

		$additional_attributes = array_filter($additional_attributes);

		foreach ($additional_attributes as $attribute_key => $attribute_value)
		{
			$additional_attributes[$attribute_key] = '"'.esc_attr($attribute_value).'"';
		}

		$attributes_array = array_filter(array_merge($image_sources, $additional_attributes));

		// If not ALt then add an empty one for validation
		if($tag_type === 'img' && empty($additional_attributes['alt']))
		{
			$attributes_array['alt'] = '""';
		}

		$attributes_str = trim(urldecode(http_build_query($attributes_array, '', ' ')));


		if($attributes_str)
		{
			if($tag_type === 'div')
			{
				return '<div '.$attributes_str.'></div>';
			}
			else
			{
				return '<img '.$attributes_str.' />';
			}
		}

		return '';
	}


	public static function allow_br($value)
	{
		return str_replace(array('&lt;br&gt;','&lt;br/&gt;','&lt;br /&gt;'), '<br>', $value);
	}

	public static function get_gravity_forms()
	{
		$gravity_forms = array();

		// Return Cache if exists
		if(isset(self::$cache['gravity_forms']))
		{
			return self::$cache['gravity_forms'];
		}
		else
		{
			if(class_exists('GFAPI'))
			{
				self::$cache['gravity_forms'] = array();

				foreach(GFAPI::get_forms() as $gform)
				{
					$gravity_forms[] = $gform;
				}
			}
		}

		self::$cache['gravity_forms'] = $gravity_forms;

		return $gravity_forms;
	}




	public static function get_radio_num_conditionals($field = '', $num = 0, $max = 4)
	{
		$conditional_array = array();
		if($num){
			for( $i = $max; $i >= $num; $i-- ) {
				$conditional_array[] = array (
					array (
						'field' => $field,
						'operator' => '==',
						'value' => $i,
					),
				);
			}
		}

		return $conditional_array;
	}


	public static function get_grid_format_choices() {
		return array (
			'' => 'Grid',
			'gallery' => 'Image Gallery',
			'logos' => 'Logos',
			'slider' => 'Slider'
		);
	}

	public static function get_blocks_usage( $data=[] ) {
		// Do something with the $request
		$response = '';
		if ( $gblocks = self::get_available_blocks() )
		{

			if($data['name']){
				$chosen_blocks[$data['name']] = $gblocks[$data['name']];
			} else {
				$chosen_blocks = $gblocks;
			}
			foreach ( $chosen_blocks as $block_name => $block )
			{
				$response .= '<div class="gblocks-row">';
				$posts = get_posts(
					array(
						'numberposts' => -1,
						'post_type' => get_post_types(),
						'meta_query' => array(
							array(
								'key' => 'gblocks',
								'value' => $block_name,
								'compare' => 'LIKE'
							),
						),
					)
				);
				$response .= '<div class="gblocks-column"><h4>' . $block['label'] . ' (' . count($posts) . ')</h4></div>';
				if ( count($posts) > 0 )
				{
					$response .= '<div class="gblocks-column"><ul class="permalink block ' . $block_name . '">';
					foreach ( $posts as $post )
					{
						// debug($post, true);
						$response .= '<li><a class="permalink" target="_blank" href="' . get_the_permalink( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a> (<a class="edit" href="' . admin_url() . 'post.php?post=' . $post->ID . '&action=edit" target="_blank">edit</a>)</li>';
					}
					$response .= '</ul></div>';
				}
				$response .= '</div>';
			}

		}

		return $response;
	}

}
