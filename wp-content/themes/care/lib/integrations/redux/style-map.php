<?php

function care_style_map() {

	return apply_filters( 'care-filter-style-map', array(
		'background-color' => array(
			array(
				'option' => 'global-accent-color',
				'suboption' => false,
				'important' => true,
				'selectors' => array(
					'#today',
				)
			),
		),
		'font-family' => array(
			array(
				'option' => 'headings-typography-h1',
				'suboption' => 'font-family',
				'important' => false,
				'selectors' => array(
					'.children-links a',
					'.wh-big-icon .vc_tta-title-text',
					'.scp-tribe-events .event .info .title',
					'.scp-tribe-events .event .date',
					'.scp-tribe-events-link a',
					'.widget-banner',
					'.single-teacher .teacher .teacher-meta-data',
					'.single-teacher .teacher .text',
					'.vc_tta-title-text',
					'.prev-next-item',
					'.schedule',
					'blockquote p',
					'.linp-post-list .item .meta-data .date',
				)
			),
			array(
				'option' => 'page-title-typography',
				'suboption' => 'font-family',
				'important' => false,
				'selectors' => array(
					'.wh-page-title-bar .entry-meta span',
					'.page-subtitle',
				)
			),
		),
		'text-align' => array(
			array(
				'option' => 'page-title-typography',
				'suboption' => 'text-align',
				'important' => false,
				'selectors' => array(
					'.wh-page-title-bar .entry-meta span',
					'.page-subtitle',
				)
			),
		),
		'border-top-color' => array(
			array(
				'option' => 'content-hr',
				'suboption' => 'border-color',
				'important' => false,
				'selectors' => array(
					'.comment-list .comment hr',
				)
			),
		),
	) );

}

function care_get_style_from_options( $redux_options ) {
	$style = '';
	foreach (care_style_map() as $prop => $options ) {

		foreach ( $options as $option ) {

			if ( ! isset( $redux_options[ $option['option'] ] ) ) {
				continue;
			}
			$val = $redux_options[ $option['option'] ];
			if ( is_array( $val ) && isset( $option['suboption'] ) ) {
				if ( ! isset( $val[ $option['suboption'] ] ) || ! $val[ $option['suboption'] ] ) {
					continue;
				}
				$val = $val[ $option['suboption'] ];
			}

			$important = '';
			if ( isset( $option['important'] ) && $option['important'] ) {
				$important = '!important';
			}

			$style .= implode( ',', $option['selectors'] );
			$style .= "{{$prop}:{$val}{$important};}";
		}
	}

	return $style;
}
