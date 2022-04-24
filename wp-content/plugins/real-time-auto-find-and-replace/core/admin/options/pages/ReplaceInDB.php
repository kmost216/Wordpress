<?php namespace RealTimeAutoFindReplace\admin\options\pages;

/**
 * Class: Replace in db
 *
 * @package Admin
 * @since 1.0.0
 * @author M.Tuhin <info@codesolz.net>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	die();
}

use RealTimeAutoFindReplace\lib\Util;
use RealTimeAutoFindReplace\admin\builders\FormBuilder;
use RealTimeAutoFindReplace\admin\builders\AdminPageBuilder;


use RealTimeAutoFindReplace\admin\functions\DbReplacer;

class ReplaceInDB {

	/**
	 * Hold page generator class
	 *
	 * @var type
	 */
	private $Admin_Page_Generator;

	/**
	 * Form Generator
	 *
	 * @var type
	 */
	private $Form_Generator;


	public function __construct( AdminPageBuilder $AdminPageGenerator ) {
		$this->Admin_Page_Generator = $AdminPageGenerator;

		/*create obj form generator*/
		$this->Form_Generator = new FormBuilder();

		add_action( 'admin_footer', array( $this, 'default_page_scripts' ) );
	}

	/**
	 * Generate add new coin page
	 *
	 * @param type $args
	 * @return type
	 */
	public function generate_default_settings( $args ) {

		$settings = isset( $args['gateway_settings'] ) ? (object) $args['gateway_settings'] : '';
		$option   = isset( $settings->defaultOptn ) ? $settings->defaultOptn : '';

		$fields = array(
			'cs_db_string_replace[find]'             => array(
				'title'       => __( 'Find', 'real-time-auto-find-and-replace' ),
				'type'        => 'textarea',
				'class'       => 'form-control',
				'required'    => true,
				'value'       => '',
				'placeholder' => __( 'Enter word to find ', 'real-time-auto-find-and-replace' ),
				'desc_tip'    => __( 'Enter a word / phrase you want to find in Database. e.g: _test ', 'real-time-auto-find-and-replace' ),
			),

			'cs_db_string_replace[replace]'          => array(
				'title'       => __( 'Replace With', 'real-time-auto-find-and-replace' ),
				'type'        => 'text',
				'class'       => 'form-control',
				'value'       => '',
				'placeholder' => __( 'Enter word to replace with', 'real-time-auto-find-and-replace' ),
				'desc_tip'    => __( 'Enter word / phrase you want to replace with. e.g : test', 'real-time-auto-find-and-replace' ),
			),
			'cs_db_string_replace[where_to_replace]' => array(
				'title'       => __( 'Where to Replace', 'real-time-auto-find-and-replace' ),
				'type'        => 'select',
				'class'       => 'form-control where-to-replace',
				'required'    => true,
				'options'     => array(
					'tables' => __( 'Database Tables', 'real-time-auto-find-and-replace' ),
					'urls'   => __( 'URLs', 'real-time-auto-find-and-replace' ),
				),
				'placeholder' => __( 'Select where to find and replace', 'real-time-auto-find-and-replace' ),
				'desc_tip'    => __( 'Select where to find and replace. e.g : Database Tables', 'real-time-auto-find-and-replace' ),
			),
			'db_tables[]'                            => array(
				'wrapper_class' => 'no-border db-tables-wrap',
				'title'         => __( 'Select tables', 'real-time-auto-find-and-replace' ),
				'type'          => 'select',
				'class'         => 'form-control db-tables',
				'multiple'      => true,
				'required'      => true,
				'placeholder'   => __( 'Please select tables', 'real-time-auto-find-and-replace' ),
				'options'       => '', // loads dynamically
				'desc_tip'      => __( 'Select / Enter table name where you want to replace. e.g : post.', 'real-time-auto-find-and-replace' ),
			),
			'url_options[]'                          => array(
				'wrapper_class' => 'url-options force-hidden',
				'title'         => __( 'Select which url', 'real-time-auto-find-and-replace' ),
				'type'          => 'select',
				'class'         => 'form-control in-which-url',
				'multiple'      => true,
				'placeholder'   => __( 'Please select options', 'real-time-auto-find-and-replace' ),
				'options'       => '', // loads value dynamically
				'desc_tip'      => __( 'Select / Enter table name where you want to replace. e.g : post', 'real-time-auto-find-and-replace' ),
			),
			'st2'                                    => array(
				'wrapper_class' => 'advance-filter ',
				'type'          => 'section_title',
				'title'         => __( 'Advance Filters', 'real-time-auto-find-and-replace' ),
				'desc_tip'      => __( 'Set the following settings if you want to apply special filter options.', 'real-time-auto-find-and-replace' ),
			),
			'cs_db_string_replace[case_insensitive]' => array(
				'title'    => __( 'Case-Insensitive', 'real-time-auto-find-and-replace' ),
				'type'     => 'checkbox',
				'desc_tip' => __( 'Check this checkbox if you want to find case insensitive or keep it un-check to find case-sensitive. e.g : Shop / shop / SHOP, all will be treated as same if you check this checkbox.', 'real-time-auto-find-and-replace' ),
			),
			'cs_db_string_replace[whole_word]'       => array(
				'title'    => __( 'Whole Words Only', 'real-time-auto-find-and-replace' ),
				'type'     => 'checkbox',
				'desc_tip' => \sprintf(
					__( 'Check this checkbox, if you want to find & replace match whole words only. e.g : if you want to replace - %1$stest%2$s from - %1$sThis is a test sentence for testing%2$s, then only replacement will be on -  %1$sThis is a %3$stest%4$s sentence for testing%2$s ', 'real-time-auto-find-and-replace' ),
					'<code>',
					'</code>',
					'<em>',
					'</em>'
				),
			),
			'cs_db_string_replace[unicode_modifier]' => array(
				'title'             => sprintf( __( 'Unicode Characters %1$s Pro version only %2$s', 'real-time-auto-find-and-replace' ), '<br/><span class="pro-version-only">', '</span>' ),
				'type'              => 'checkbox',
				'is_pro'            => true,
				'custom_attributes' => array(
					'disabled' => 'disabled',
				),
				'desc_tip'          => __( 'Check this checkbox, if you want find and replace unicode characters (UTF-8). e.g: U+0026, REČA', 'real-time-auto-find-and-replace' ),
			),
			'cs_db_string_replace[dry_run]'          => array(
				'title'    => __( 'Dry run', 'real-time-auto-find-and-replace' ),
				'type'     => 'checkbox',
				'value'    => true,
				'desc_tip' => __( 'Check this checkbox, if you want to see where find and replace will take place. A list of the find and replacement will be displayed in the popup window. No changes will be made to the database.', 'real-time-auto-find-and-replace' ),
			),
		);

		$fields          = apply_filters( 'bfrp_replacedb_settings_fields', $fields, $option );
		$args['content'] = $this->Form_Generator->generate_html_fields( $fields );

		$hidden_fields = array(
			'method'           => array(
				'id'    => 'method',
				'type'  => 'hidden',
				'value' => "admin\\functions\\DbReplacer@db_string_replace",
			),
			'swal_title'       => array(
				'id'    => 'swal_title',
				'type'  => 'hidden',
				'value' => 'Finding & Replacing..',
			),
			'swal_des'         => array(
				'id'    => 'swal_des',
				'type'  => 'hidden',
				'value' => __( 'Please wait a while...', 'real-time-auto-find-and-replace' ),
			),
			'swal_loading_gif' => array(
				'id'    => 'swal_loading_gif',
				'type'  => 'hidden',
				'value' => CS_RTAFAR_PLUGIN_ASSET_URI . 'img/loading-timer.gif',
			),
			'swal_error'       => array(
				'id'    => 'swal_error',
				'type'  => 'hidden',
				'value' => __( 'Something went wrong! Please try again by refreshing the page.', 'real-time-auto-find-and-replace' ),
			),

		);
		$args['hidden_fields'] = $this->Form_Generator->generate_hidden_fields( $hidden_fields );

		$args['btn_text']       = __( 'Create Reports', 'real-time-auto-find-and-replace' );
		$args['show_btn']       = true;
		$args['body_class']     = 'no-bottom-margin';
		$args['well']           = '<ul>
                        <li> <b>' . __( 'Warning!', 'real-time-auto-find-and-replace' ) . '</b>
                            <ol>
                                <li>'
									. __( 'Replacement in database is permanent. You can\'t un-done it, once it get replaced.', 'real-time-auto-find-and-replace' )
								. '</li>
                            </ol>
                        </li>
					</ul>';
		$args['hidden_content'] = $this->popupHtml();

		return $this->Admin_Page_Generator->generate_page( $args );
	}

	/**
	 * Add custom scripts
	 */
	public function default_page_scripts() {
		?>
			<script>
				jQuery(document).ready(function($) {

					jQuery("body").on('click', 'a.close', function(){
						$("#popup1").removeClass('show-popup').addClass('hide-popup');
					});

					jQuery("#bfrModalContent").scroll(function () {
						var pos = $(this).scrollTop();
						if( pos >= 1 ){
							jQuery( ".bfr-res-head").addClass('change-tbl-head-bg');
						}else{
							jQuery( ".bfr-res-head").removeClass('change-tbl-head-bg');
						}

					});
				});
						
			</script>
		<?php
	}

	/**
	 * Custom Modal
	 *
	 * @return void
	 */
	private function popupHtml() {
		$html = \ob_start();
		?>
			<div id="popup1" class="overlay">
				<div class="popup">
					<h2 class="title">---</h2>
					<p class="sub-title">--</p>
					<a class="close" >&times;</a>
					<div id="bfrModalContent" class="content"><!-- Content --></div>
					<div class="after-content"><!-- after content elements --> </div>
					<div class="apiResponse"></div>
				</div>
			</div>
		<?php
		$html = ob_get_clean();

		return $html;
	}

}
