<?php

class Care_Widgets_Importer implements Care_Importer_Interface {

  	const FILTER_AVAILABLE_WIDGETS = 'wheels_filter_available_widgets';
  	const FILTER_WIDGET_DATA       = 'wheels_filter_widget_data';
  	const FILTER_WIDGET_SETTINGS   = 'wheels_filter_widget_settings';
  	const FILTER_WIDGET_RESULTS    = 'wheels_filter_widget_results';

  	const ACTION_AFTER_IMPORT = 'wheels_action_widgets_after_import';

  	protected $filename;
	  protected $delete_current_widgets;


    protected function delete_current_widgets() {
        update_option( 'sidebars_widgets', array() );
    }

    /**
     * Process import file
     *
     * This parses a file and triggers importation of its widgets.
     *
     * @since 1.0.0
     *
     * @param string $file Path to .wie file uploaded
     * @global string $widget_import_results
     */
    public function import() {

        $file = $this->get_filename();

        // File exists?
        if ( ! file_exists( $file ) ) {
            wp_die(
	            esc_html__( 'Widget Import file could not be found. Please try again.', 'care' ),
                '',
                array( 'back_link' => true )
            );
        }

	    $data = null;
	    if ( function_exists( 'scp_fgc') ) {
		    $data = scp_fgc( $file );
	    }

	    if ( $data ) {

		    $data = json_decode( $data );

		    // Delete import file
		    // unlink( $file );

		    // Import the widget data
		    // Make results available for display on import/export page
		    // $this->widget_import_results = $this->import_widgets( $data );

		    if ( $this->get_delete_current_widgets() ) {
			    $this->delete_current_widgets();
		    }
		    $this->import_widgets( $data );

	    }

    }


	  /**
     * add_widget_to_sidebar Import sidebars
     * @param  string $sidebar_slug    Sidebar slug to add widget
     * @param  string $widget_slug     Widget slug
     * @param  string $count_mod       position in sidebar
     * @param  array  $widget_settings widget settings
     *
     * @since 1.0.0
     *
     * @return null
     */
    public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()){

        $sidebars_widgets = get_option('sidebars_widgets');

        if(!isset($sidebars_widgets[$sidebar_slug]))
            $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

        $newWidget = get_option('widget_'.$widget_slug);

        if(!is_array($newWidget))
            $newWidget = array();

        $count                             = count($newWidget)+1+$count_mod;
        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

        $newWidget[$count] = $widget_settings;

        update_option('sidebars_widgets', $sidebars_widgets);
        update_option('widget_'.$widget_slug, $newWidget);

    }

    /**
     * Available widgets
     *
     * Gather site's widgets into array with ID base, name, etc.
     * Used by export and import functions.
     *
     * @since 1.0.0
     *
     * @global array $wp_registered_widget_updates
     * @return array Widget information
     */
    public function available_widgets() {

      	global $wp_registered_widget_controls;

      	$widget_controls = $wp_registered_widget_controls;

      	$available_widgets = array();

      	foreach ( $widget_controls as $widget ) {

        		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

          			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
          			$available_widgets[$widget['id_base']]['name'] = $widget['name'];
        		}
      	}
      	return apply_filters( self::FILTER_AVAILABLE_WIDGETS, $available_widgets );
    }


    /**
     * Import widget JSON data
     *
     * @since 2.2.0
     * @global array $wp_registered_sidebars
     * @param object $data JSON widget data from .wie file
     * @return array Results array
     */
    public function import_widgets( $data ) {

      	global $wp_registered_sidebars;

      	// Have valid data?
      	// If no data or could not decode
      	if ( empty( $data ) || ! is_object( $data ) ) {
        		wp_die(
          			esc_html__( 'Widget import data could not be read. Please try a different file.', 'care'),
          			'',
          			array( 'back_link' => true )
        		);
      	}

      	// Hook before import
      	$data = apply_filters( self::FILTER_WIDGET_DATA, $data );

      	// Get all available widgets site supports
      	$available_widgets = $this->available_widgets();

      	// Get all existing widget instances
      	$widget_instances = array();
      	foreach ( $available_widgets as $widget_data ) {
      		  $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
      	}

      	// Begin results
      	$results = array();

      	// Loop import data's sidebars
      	foreach ( $data as $sidebar_id => $widgets ) {

      		// Skip inactive widgets
      		// (should not be in export file)
      		if ( 'wp_inactive_widgets' == $sidebar_id ) {
              continue;
      		}

      		// Check if sidebar is available on this site
      		// Otherwise add widgets to inactive, and say so
      		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
        			$sidebar_available    = true;
        			$use_sidebar_id       = $sidebar_id;
        			$sidebar_message_type = 'success';
        			$sidebar_message      = '';
      		} else {
        			$sidebar_available    = false;
        			$use_sidebar_id       = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
        			$sidebar_message_type = 'error';
        			$sidebar_message      = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'care' );
      		}

      		// Result for sidebar
      		$results[$sidebar_id]['name']         = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
      		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
      		$results[$sidebar_id]['message']      = $sidebar_message;
      		$results[$sidebar_id]['widgets']      = array();

      		// Loop widgets
      		foreach ( $widgets as $widget_instance_id => $widget ) {

      			$fail = false;

      			// Get id_base (remove -# from end) and instance ID number
      			$id_base            = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
      			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

      			// Does site support this widget?
      			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
        				$fail                = true;
        				$widget_message_type = 'error';
        				$widget_message      = esc_html__( 'Site does not support widget', 'care' ); // explain why widget not imported
      			}

      			// Filter to modify settings before import
      			// Do before identical check because changes may make it identical to end result (such as URL replacements)
      			$widget = apply_filters( self::FILTER_WIDGET_SETTINGS, $widget );

      			// Does widget with identical settings already exist in same sidebar?
      			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

        				// Get existing widgets in this sidebar
        				$sidebars_widgets = get_option( 'sidebars_widgets' );
        				$sidebar_widgets  = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

        				// Loop widgets with ID base
        				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
        				foreach ( $single_widget_instances as $check_id => $check_widget ) {

          					// Is widget in same sidebar and has identical settings?
          					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

            						$fail                = true;
            						$widget_message_type = 'warning';
            						$widget_message      = esc_html__( 'Widget already exists', 'care' ); // explain why widget not imported

            						break;
          					}
        				}
      			}

      			// No failure
      			if ( ! $fail ) {

        				// Add widget instance
        				$single_widget_instances   = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
        				$single_widget_instances   = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
        				$single_widget_instances[] = (array) $widget; // add it

      					// Get the key it was given
      					end( $single_widget_instances );
      					$new_instance_id_number = key( $single_widget_instances );

      					// If key is 0, make it 1
      					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
      					if ( '0' === strval( $new_instance_id_number ) ) {
        						$new_instance_id_number = 1;
        						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
        						unset( $single_widget_instances[0] );
      					}

      					// Move _multiwidget to end of array for uniformity
      					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
        						$multiwidget = $single_widget_instances['_multiwidget'];
        						unset( $single_widget_instances['_multiwidget'] );
        						$single_widget_instances['_multiwidget'] = $multiwidget;
      					}

      					// Update option with new widget
      					update_option( 'widget_' . $id_base, $single_widget_instances );

        				// Assign widget instance to sidebar
        				$sidebars_widgets                    = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
        				$new_instance_id                     = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
        				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
        				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

        				// Success message
        				if ( $sidebar_available ) {
          					$widget_message_type = 'success';
          					$widget_message      = esc_html__( 'Imported', 'care' );
        				} else {
          					$widget_message_type = 'warning';
          					$widget_message      = esc_html__( 'Imported to Inactive', 'care' );
        				}

      			}

      			// Result for widget instance
      			$results[$sidebar_id]['widgets'][$widget_instance_id]['name']         = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
      			$results[$sidebar_id]['widgets'][$widget_instance_id]['title']        = $widget->title ? $widget->title : esc_html__( 'No Title', 'care' ); // show "No Title" if widget instance is untitled
      			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
      			$results[$sidebar_id]['widgets'][$widget_instance_id]['message']      = $widget_message;

      		}

      	}

      	// Hook after import
      	do_action( self::ACTION_AFTER_IMPORT );

      	// Return results
      	return apply_filters( self::FILTER_WIDGET_RESULTS, $results );

    }

	public function get_filename() {
		return $this->content_filename;
	}

	public function set_filename( $filename ) {
		$this->content_filename = $filename;
	}

	public function get_delete_current_widgets() {
		return $this->delete_current_widgets;
	}

	public function set_delete_current_widgets( $delete_current_widgets ) {
		$this->delete_current_widgets = $delete_current_widgets;
	}

}
