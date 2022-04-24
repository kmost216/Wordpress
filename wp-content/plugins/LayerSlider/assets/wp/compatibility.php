<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

function ls_doing_it_wrong( $function, $message, $version ) {

	do_action( 'doing_it_wrong_run', $function, $message, $version );

    if( WP_DEBUG && apply_filters( 'doing_it_wrong_trigger_error', true ) ) {
		trigger_error(
			sprintf(
				'%1$s was called <strong>incorrectly</strong>. %2$s',
				$function,
				$message
			)
		);
    }
}

function ls_wp_timezone() {

	try {
		return new DateTimeZone( ls_wp_timezone_string() );

	} catch (Exception $e) {
		return new DateTimeZone( 'UTC' );
	}
}


function ls_wp_timezone_string() {
	$timezone_string = get_option( 'timezone_string' );

    if ( $timezone_string ) {
        return $timezone_string;
    }

    $offset  = (float) get_option( 'gmt_offset' );
    $hours   = (int) $offset;
    $minutes = ( $offset - $hours );

    $sign      = ( $offset < 0 ) ? '-' : '+';
    $abs_hour  = abs( $hours );
    $abs_mins  = abs( $minutes * 60 );
    $tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );

    return $tz_offset;
}

function ls_date($format, $timestamp = null, $timezone = null ) {

	if( ! $timezone ) {
		$timezone = ls_wp_timezone();
	}

	if( ! $timestamp ) {
		$timestamp = time();
	}

	$datetime = date_create( '@' . $timestamp );
	$datetime->setTimezone( $timezone );

	return $datetime->format( $format );
}


function ls_date_create_for_timezone( $dateStr ) {

	$date = date_create( $dateStr, ls_wp_timezone() );
	return $date->format('U');
}

function layerslider_convert() {

	// Get old sliders if any
	$sliders = get_option('layerslider-slides', []);
	$sliders = is_array($sliders) ? $sliders : unserialize($sliders);

	// Create new storage in DB
	layerslider_create_db_table();

	// Iterate over them
	if(!empty($sliders) && is_array($sliders)) {
		foreach($sliders as $key => $slider) {
			LS_Sliders::add($slider['properties']['title'], $slider);
		}
	}

	// Remove old data and exit
	delete_option('layerslider-slides');
	wp_redirect( admin_url('admin.php?page=layerslider') );
	exit;
}

function ls_parse_border_prop( $data ) {

	$props = ['border-top', 'border-right', 'border-bottom', 'border-left'];
	$borderWidth = [];
	$borderStyle = '';
	$borderColor = '';


	foreach( $props as $prop ) {

		if( ! empty( $data->{ $prop } ) ) {

			$parts = ls_parse_border_val( $data->{ $prop } );

			if( ! empty( $parts['width'] ) ) {
				$borderWidth[] = $parts['width'];
			}

			if( ! empty( $parts['style'] ) ) {
				$borderStyle = $parts['style'];
			}


			if( ! empty( $parts['color'] ) ) {
				$borderColor = $parts['color'];
			}
		} else {

			$borderWidth[] = '0px';

		}
	}

	$borderWidth = implode(' ', $borderWidth );
	$borderWidth = ( $borderWidth === '0px 0px 0px 0px' ) ? '' : $borderWidth;


	return [
		'width' => $borderWidth,
		'style' => $borderStyle,
		'color' => $borderColor
	];
}

function ls_parse_border_val( $val ) {

	$parts = explode( ' ', $val );
	$width = ! empty( $parts[0] ) ? (int) $parts[0].'px' : '0px';
	$style = ! empty( $parts[1] ) ? $parts[1] : '';
	$color = ! empty( $parts[2] ) ? $parts[2] : '';

	return [
		'width' => $width,
		'style' => $style,
		'color' => $color
	];
}

function ls_extract_layer_fonts( $slider ) {

	$usedFonts = [];

	if( ! empty( $slider['layers'] ) && is_array( $slider['layers'] ) ) {
		foreach( $slider['layers'] as $slide ) {

			if( ! empty( $slide['sublayers'] ) && is_array( $slide['sublayers'] ) ) {
				foreach( $slide['sublayers'] as $layer ) {

					if( ! empty( $layer['styles'] ) ) {

							$styles = ! empty( $layer['styles'] ) ? json_decode( stripslashes( $layer['styles'] ), true ) : new stdClass;

							if( ! empty( $styles['font-family'] ) ) {
								$families = explode( ',', $styles['font-family'] );
								foreach( $families as $family ) {
									$family = trim( $family, " \"'\t\n\r\0\x0B");
									$family = str_replace(['+', '"', "'"], [' ', '', ''], $family);

									if( ! empty( $family ) ) {
										$usedFonts[] = $family;
									}
								}
							}
						}
				}
			}
		}
	}

	return array_unique( $usedFonts );
}

function ls_normalize_project_fonts( $slider ) {

	if( ! empty( $slider['googlefonts'] ) && is_array( $slider['googlefonts'] ) ) {
		foreach( $slider['googlefonts'] as $fontIndex => $font ) {
			$fontParam = explode(':', $font['param'] );
			$font = urldecode( $fontParam[0] );
			$font = str_replace(['+', '"', "'"], [' ', '', ''], $font);

			$slider['googlefonts'][ $fontIndex ] = [ 'param' => $font ];
		}

	} else {
		$slider['googlefonts'] = [];
	}

	return $slider;
}

function ls_merge_google_fonts( $slider ) {

	// If the slider have saved Google Fonts, we can safely assume
	// it's built with a newer version that already manages the font list.
	// In that case we don't have to attempt extracting and merging fonts.
	if( ! empty( $slider['googlefonts'] ) ) {
		return $slider;
	}

	// Bail out if the slider doesn't seem to have custom fonts
	$layerFonts = ls_extract_layer_fonts( $slider );
	if( empty( $layerFonts ) ) {
		return $slider;
	}

	if( ! class_exists('LS_RemoteData') ) {
		include LS_ROOT_PATH.'/classes/class.ls.remotedata.php';
		LS_RemoteData::init();
	}

	$usedFonts 	 = [];
	$googleFonts = LS_RemoteData::get('fonts', [], 'fonts');


	foreach( $googleFonts as $font ) {

		if( in_array( $font['family'], $layerFonts ) ) {
			$usedFonts[] = [ 'param' => $font['family'] ];
		}
	}

	$slider['googlefonts'] = $usedFonts;

	return $slider;
}

function ls_normalize_slider_data( $slider ) {

	$sliderItem 	= $slider;
	$lsActivated 	= LS_Config::isActivatedSite();

	if( ! isset($slider['properties']['status']) ) {
		$slider['properties']['status'] = true;
	}

	$slider = ls_merge_google_fonts( $slider );

	// Allow accepting a "hero" type slider
	if( ! empty( $slider['properties']['type'] ) && ! empty( $slider['properties']['fullSizeMode'] ) ) {

		if( $slider['properties']['type'] === 'fullsize' && $slider['properties']['fullSizeMode'] === 'hero' ) {
			$slider['properties']['type'] = 'hero';
		}
	}

	// COMPAT: If old and non-fullwidth slider
	if( ! isset($slider['properties']['slideBGSize']) && ! isset($slider['properties']['new']) ) {
		if( empty( $slider['properties']['forceresponsive'] ) ) {
			$slider['properties']['slideBGSize'] = 'auto';
		}
	}


	if( ! empty( $slider['properties']['schedule_start'] ) && is_numeric( $slider['properties']['schedule_start'] ) ) {
		$dateTime = new DateTime('@'.$slider['properties']['schedule_start']);
		$dateTime->setTimezone( ls_wp_timezone() );

		$slider['properties']['schedule_start'] = $dateTime->format('Y-m-d\TH:i:s');
	} else {
		$slider['properties']['schedule_start'] = '';
	}


	if( ! empty( $slider['properties']['schedule_end'] ) && is_numeric( $slider['properties']['schedule_end'] ) ) {
		$dateTime = new DateTime('@'.$slider['properties']['schedule_end']);
		$dateTime->setTimezone( ls_wp_timezone() );

		$slider['properties']['schedule_end'] = $dateTime->format('Y-m-d\TH:i:s');;
	} else {
		$slider['properties']['schedule_end'] = '';
	}

	if( empty($slider['properties']['new']) && empty($slider['properties']['type']) ) {
		if( !empty($slider['properties']['forceresponsive']) ) {
			$slider['properties']['type'] = 'fullwidth';

			if( strpos($slider['properties']['width'], '%') !== false ) {

				if( ! empty($slider['properties']['responsiveunder']) ) {
					$slider['properties']['width'] = $slider['properties']['responsiveunder'];

				} elseif( ! empty($slider['properties']['sublayercontainer']) ) {
					$slider['properties']['width'] = $slider['properties']['sublayercontainer'];
				}
			}

		} elseif( empty($slider['properties']['responsive']) ) {
			$slider['properties']['type'] = 'fixedsize';
		} else {
			$slider['properties']['type'] = 'responsive';
		}
	}

	if( ! empty( $slider['properties']['width'] ) ) {
		if( strpos($slider['properties']['width'], '%') !== false ) {
			$slider['properties']['width'] = 1000;
		}
	}

	if( ! empty($slider['properties']['sublayercontainer']) ) {
		unset($slider['properties']['sublayercontainer']);
	}

	if( ! empty( $slider['properties']['width'] ) ) {
		$slider['properties']['width'] = (int) $slider['properties']['width'];
	}

	if( ! empty( $slider['properties']['width'] ) ) {
		$slider['properties']['height'] = (int) $slider['properties']['height'];
	}

	if( empty($slider['properties']['new']) && empty( $slider['properties']['pauseonhover'] ) ) {
		$slider['properties']['pauseonhover'] = 'enabled';
	}

	if( empty($slider['properties']['sliderVersion'] ) && empty($slider['properties']['circletimer'] ) ) {
		$slider['properties']['circletimer'] = false;
	}

	if( isset( $slider['properties']['useSrcset'] ) && is_bool( $slider['properties']['useSrcset'] ) ) {
		$slider['properties']['useSrcset'] = $slider['properties']['useSrcset'] ? 'enabled' : 'disabled';
	}

	if( isset( $slider['properties']['enhancedLazyLoad'] ) && is_bool( $slider['properties']['enhancedLazyLoad'] ) ) {
		$slider['properties']['enhancedLazyLoad'] = $slider['properties']['enhancedLazyLoad'] ? 'enabled' : 'disabled';
	}

	// Convert old checkbox values
	foreach($slider['properties'] as $optionKey => $optionValue) {
		switch($optionValue) {
			case 'on':
				$slider['properties'][$optionKey] = true;
				break;

			case 'off':
				$slider['properties'][$optionKey] = false;
				break;
		}
	}

	// Make sure to always have the necessary data
	// structure to avoid PHP errors.
	if( empty( $slider['layers'] ) ) {
		$slider['layers'][] = [
			'sublayers' => [],
			'meta' => []
		];
	}

	foreach( $slider['layers'] as $slideKey => $slideVal) {

		// Make sure to each slide has a 'properties' object
		if( ! isset( $slideVal['properties'] ) ) {
			$slideVal['properties'] = [];
		}

		// Scheduling
		if( ! empty( $slideVal['properties']['schedule_start'] ) && is_numeric( $slideVal['properties']['schedule_start'] ) ) {
			$dateTime = new DateTime('@'.$slideVal['properties']['schedule_start']);
			$dateTime->setTimezone( ls_wp_timezone() );

			$slideVal['properties']['schedule_start'] = $dateTime->format('Y-m-d\TH:i:s');
		} else {
			$slideVal['properties']['schedule_start'] = '';
		}


		if( ! empty( $slideVal['properties']['schedule_end'] ) && is_numeric( $slideVal['properties']['schedule_end'] ) ) {
			$dateTime = new DateTime('@'.$slideVal['properties']['schedule_end']);
			$dateTime->setTimezone( ls_wp_timezone() );

			$slideVal['properties']['schedule_end'] = $dateTime->format('Y-m-d\TH:i:s');;
		} else {
			$slideVal['properties']['schedule_end'] = '';
		}


		// Get slide background
		if( ! empty($slideVal['properties']['backgroundId']) ) {
			$slideVal['properties']['background'] = apply_filters('ls_get_image', $slideVal['properties']['backgroundId'], $slideVal['properties']['background']);
			$slideVal['properties']['backgroundThumb'] = apply_filters('ls_get_thumbnail', $slideVal['properties']['backgroundId'], $slideVal['properties']['background']);
		}

		// Get slide thumbnail
		if( ! empty($slideVal['properties']['thumbnailId']) ) {
			$slideVal['properties']['thumbnail'] = apply_filters('ls_get_image', $slideVal['properties']['thumbnailId'], $slideVal['properties']['thumbnail']);
			$slideVal['properties']['thumbnailThumb'] = apply_filters('ls_get_thumbnail', $slideVal['properties']['thumbnailId'], $slideVal['properties']['thumbnail']);
		}


		// v6.3.0: Improve compatibility with *really* old sliders
		if( ! empty( $slideVal['sublayers'] ) && is_array( $slideVal['sublayers'] ) ) {
			$slideVal['sublayers'] = array_values( $slideVal['sublayers'] );
		}


		$slider['layers'][$slideKey] = $slideVal;

		if(!empty($slideVal['sublayers']) && is_array($slideVal['sublayers'])) {

			// v6.0: Reverse layers list
			$slideVal['sublayers'] = array_reverse($slideVal['sublayers']);

			foreach($slideVal['sublayers'] as $layerKey => $layerVal) {

				// v7.0.0: Normalize HTML element tag for old versions
				if( empty( $layerVal['htmlTag'] ) ) {

					$layerVal['htmlTag'] = ! empty( $layerVal['type'] ) ? $layerVal['type'] : 'ls-layer';

					if( ! empty( $layerVal['media'] ) ) {
						switch( $layerVal['media'] ) {
							case 'img':
								$layerVal['htmlTag'] = 'img';
								break;

							case 'button':
							case 'icon':
								$layerVal['htmlTag'] = 'span';
								break;

							case 'html':
							case 'media':
								$layerVal['htmlTag'] = 'div';
								break;

							case 'post':
								$layerVal['htmlTag'] = 'div';
								break;
						}
					}
				}

				if( ! empty($layerVal['imageId']) ) {
					$layerVal['image'] = apply_filters('ls_get_image', $layerVal['imageId'], $layerVal['image']);
					$layerVal['imageThumb'] = apply_filters('ls_get_thumbnail', $layerVal['imageId'], $layerVal['image']);
				}

				if( ! empty($layerVal['posterId']) ) {
					$layerVal['poster'] = apply_filters('ls_get_image', $layerVal['posterId'], $layerVal['poster']);
					$layerVal['posterThumb'] = apply_filters('ls_get_thumbnail', $layerVal['posterId'], $layerVal['poster']);
				}

				if( ! empty($layerVal['layerBackgroundId']) ) {
					$layerVal['layerBackground'] = apply_filters('ls_get_image', $layerVal['layerBackgroundId'], $layerVal['layerBackground']);
					$layerVal['layerBackgroundThumb'] = apply_filters('ls_get_thumbnail', $layerVal['layerBackgroundId'], $layerVal['layerBackground']);
				}

				// Line break
				if( empty( $layerVal['htmlLineBreak'] ) ) {
					$layerVal['htmlLineBreak'] = 'manual';
				}

				// Parse embedded JSON data
				$layerVal['styles'] = !empty($layerVal['styles']) ? (object) json_decode(stripslashes($layerVal['styles']), true) : new stdClass;
				$layerVal['transition'] = !empty($layerVal['transition']) ? (object) json_decode(stripslashes($layerVal['transition']), true) : new stdClass;
				$layerVal['html'] = !empty($layerVal['html']) ? stripslashes($layerVal['html']) : '';

				// Add 'top', 'left' and 'wordwrap' to the styles object
				if(isset($layerVal['top'])) { $layerVal['styles']->top = $layerVal['top']; unset($layerVal['top']); }
				if(isset($layerVal['left'])) { $layerVal['styles']->left = $layerVal['left']; unset($layerVal['left']); }
				if(isset($layerVal['wordwrap'])) { $layerVal['styles']->wordwrap = $layerVal['wordwrap']; unset($layerVal['wordwrap']); }

				if( !empty( $layerVal['styles']->{'font-size'} ) ) {
					$layerVal['styles']->{'font-size'} = (int) $layerVal['styles']->{'font-size'};
				}

				// v6.8.5: Introduced individual background properties for layers such as size, position, etc.
				// Thus we need to specify each property with its own unique key instead of the combined 'background'
				// to avoid potentially overriding previous settings.
				if( ! empty( $layerVal['styles']->background ) ) {
					$layerVal['styles']->{'background-color'} = $layerVal['styles']->background;
					unset( $layerVal['styles']->background );
				}


				if( ! empty( $layerVal['layerBackground'] ) && empty( $layerVal['styles']->{'background-repeat'} ) ) {
					if( empty( $slider['properties']['sliderVersion'] ) ||
						version_compare( $slider['properties']['sliderVersion'], '7.0.0', '<' )
					) {
						$layerVal['styles']->{'background-repeat'} = 'repeat';
					}
				}

				// v7.0.0: Convert old border settings to new format
				if( empty( $layerVal['styles']->{'border-width'} ) ) {
					$borderParts = ls_parse_border_prop( $layerVal['styles'] );

					$layerVal['styles']->{'border-width'} = $borderParts['width'];
					$layerVal['styles']->{'border-style'} = $borderParts['style'];
					$layerVal['styles']->{'border-color'} = $borderParts['color'];

					unset( $layerVal['styles']->{'border-top'} );
					unset( $layerVal['styles']->{'border-right'} );
					unset( $layerVal['styles']->{'border-bottom'} );
					unset( $layerVal['styles']->{'border-left'} );
				}



				if( ! empty( $layerVal['transition']->showuntil ) ) {

					$layerVal['transition']->startatout = 'transitioninend + '.$layerVal['transition']->showuntil;
					$layerVal['transition']->startatouttiming = 'transitioninend';
					$layerVal['transition']->startatoutvalue = $layerVal['transition']->showuntil;
					unset($layerVal['transition']->showuntil);
				}

				if( ! empty( $layerVal['transition']->parallaxlevel ) ) {
					$layerVal['transition']->parallax = true;
				}

				// Custom attributes
				$layerVal['innerAttributes'] = !empty($layerVal['innerAttributes']) ?  (object) $layerVal['innerAttributes'] : new stdClass;
				$layerVal['outerAttributes'] = !empty($layerVal['outerAttributes']) ?  (object) $layerVal['outerAttributes'] : new stdClass;


				// v6.5.6: Convert old checkbox media settings to the new
				// select based options.
				if( isset( $layerVal['transition']->controls ) ) {
					if( true === $layerVal['transition']->controls ) {
						$layerVal['transition']->controls = 'auto';
					} elseif( false === $layerVal['transition']->controls ) {
						$layerVal['transition']->controls = 'disabled';
					}
				}

				$slider['layers'][$slideKey]['sublayers'][$layerKey] = $layerVal;
			}
		} else {
			$slider['layers'][$slideKey]['sublayers'] = [];
		}
	}

	if( ! empty( $slider['callbacks'] ) ) {
		foreach( $slider['callbacks'] as $key => $callback ) {
			$slider['callbacks'][$key] = stripslashes($callback);
		}
	}

	// v6.6.8: Set slider type to responsive in case of Popup
	// on a non-activated site.
	// if( ! $lsActivated && ! empty( $slider['properties']['type'] ) && $slider['properties']['type'] === 'popup' ) {
	// 	$slider['properties']['type'] = 'responsive';
	// }

	$slider['properties']['sliderVersion'] = LS_PLUGIN_VERSION;

	return $slider;
}


function lsSliderById($id) {

	ls_doing_it_wrong(
		__FUNCTION__,
		sprintf(
			'Deprecated function: use %sLS_Sliders::find( $id )%s instead.',
			'<a href="https://layerslider.com/developers/#sliders-intro" target="_blank">',
			'</a>'
		),
		'6.11.0'
	);

	$args = is_numeric($id) ? (int) $id : ['limit' => 1];
	$slider = LS_Sliders::find($args);

	if($slider == null) {
		return false;
	}

	return $slider;
}

function lsSliders($limit = 50, $desc = true, $withData = false) {

	ls_doing_it_wrong(
		__FUNCTION__,
		sprintf(
			'Deprecated function: use %sLS_Sliders::find( [ $options ] )%s instead.',
			'<a href="https://layerslider.com/developers/#sliders-intro" target="_blank">',
			'</a>'
		),
		'6.11.0'
	);

	$args = [];
	$args['limit'] = $limit;
	$args['order'] = ($desc === true) ? 'DESC' : 'ASC';
	$args['data'] = ($withData === true) ? true : false;

	$sliders = LS_Sliders::find($args);

	// No results
	if($sliders == null) {
		return [];
	}

	return $sliders;
}

?>
