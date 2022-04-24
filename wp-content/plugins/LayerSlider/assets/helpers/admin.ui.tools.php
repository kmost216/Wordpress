<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;


function lsGetSwitchControl( $inputAttributes = [], $labelAttributes = [] ) {

	$inputAttrList 	= '';
	$labelAttrList 	= '';
	$classList 		= '';


	if( empty( $inputAttributes['checked'] ) ) {
		unset( $inputAttributes['checked'] );
	}

	if( ! empty( $inputAttributes ) ) {
		foreach( $inputAttributes as $key => $val ) {
			$inputAttrList .= ' '.$key.'="'.$val.'"';
		}
	}

	if( ! empty( $labelAttributes['class'] ) ) {
		$classList = $labelAttributes['class'];
		unset( $labelAttributes['class'] );
	}

	if( ! empty( $labelAttributes ) ) {
		foreach( $labelAttributes as $key => $val ) {
			$labelAttrList .= ' '.$key.'="'.$val.'"';
		}
	}

	return '<label class="ls-switch '.$classList.'"'.$labelAttrList.'><input type="checkbox" '.$inputAttrList.'><ls-switch></ls-switch></label>';

}


function lsGetSVGIcon( $iconName, $type = 'solid', $attributes = [], $elementName = 'ls-icon' ) {

	if( empty( $type ) ) {
		$type = 'solid';
	}

	$iconsPath 	= LS_ROOT_PATH.'/static/admin/svgs';
	$iconPath 	= $iconsPath.'/'.$type.'/'.$iconName.'.svg';
	$classList 	= '';
	$attrList 	= '';

	if( ! empty( $attributes['class'] ) ) {
		$classList = $attributes['class'];
		unset( $attributes['class'] );
	}

	if( ! empty( $attributes ) ) {
		foreach( $attributes as $key => $val ) {
			$attrList .= ' '.$key.'="'.$val.'"';
		}
	}

	if( file_exists( $iconPath ) ) {
		return '<'.$elementName.' class="ls-icon-'.$iconName.' '.$classList.'"'.$attrList.'>'.file_get_contents( $iconPath ).'</'.$elementName.'>';
	}
}

function lsGetOptionField( $type, $key, $default, $attrs = [] ) {

	$value = get_option( 'ls_'.$key, $default );
	$input = '<input type="'.$type.'" name="'.$key.'"';

	if( $type === 'checkbox' && $value ) {
		$input .= ' checked="checked"';

	} else {
		$input .= ' value="'.$value.'"';
	}

	// Theme forced settings
	if( isset( LS_Config::$forced[ $key ] ) ) {
		$help = sprintf(__('This setting is enforced by <b><i>%s</i></b> in order to maximize compatibility on your site.', 'LayerSlider'), LS_Config::$forcedBy[ $key ] );

		$input .= ' class="ls-switch-disabled ls-switch-yellow" data-help-delay="100" data-help="'.$help.'"';
	}

	foreach ($attrs as $key => $value) {
		$input .= $key.'="'.$value.'"';
	}

	return $input.'>';
}

function lsGetSwitchOptionField( $key, $default, $attrs = [] ) {

	$value = get_option( 'ls_'.$key, $default );
	$label = '<label class="ls-switch';
	$input = '<input type="checkbox" name="'.$key.'"';

	if( is_numeric( $value ) ) {
		$value = (int) $value;
	}

	if( $value ) {
		$attrs['checked'] = 'checked';
	}

	// Theme forced settings
	if( isset( LS_Config::$forced[ $key ] ) ) {
		$help = sprintf(__('This setting is enforced by <b><i>%s</i></b> in order to maximize compatibility on your site.', 'LayerSlider'), LS_Config::$forcedBy[ $key ] );

		$label .= ' ls-switch-disabled ls-switch-yellow data-help-delay="100" data-help="'.$help.'""';

		$attrs['disabled'] = 'disabled';
	}

	foreach ($attrs as $key => $value) {
		$input .= $key.'="'.$value.'"';
	}

	return $label.'">'.$input.'><ls-switch></ls-switch></label>';

}

function lsOptionRow( $type, $default, $current, $attrs = [], $trClasses = '', $forceOptionVal = false) {

	$wrapperStart = '';
	$wrapperEnd = '';
	$control = '';

	$default['desc'] = ! empty( $default['desc'] ) ? $default['desc'] : '';


	if( ! empty($default['advanced']) ) {
		$trClasses .= ' lse-advanced';
		$wrapperStart = '<div>'.lsGetSVGIcon('flag-alt', false, [ 'data-tt' => '.tt-advanced']);
		$wrapperEnd = '</div>';

	} else if( ! empty($default['premium']) ) {
		if( ! LS_Config::isActivatedSite() ) {
			$trClasses .= ' ls-premium';
			$wrapperStart = '<div><a class="lse-premium-lock" target="_blank" href="'.admin_url('admin.php?page=layerslider#open-addons' ).'" data-tt=".tt-premium">'.lsGetSVGIcon('lock').'</a>';
			$wrapperEnd = '</div>';
		}
	}


	switch($type) {
		case 'input':
			$control = lsGetInput($default, $current, $attrs, true);
			break;

		case 'checkbox':
			$control = lsGetCheckbox($default, $current, $attrs, true);
			break;

		case 'select':
			$control = '<lse-fe-wrapper class="lse-select">'.lsGetSelect($default, $current, $attrs, $forceOptionVal, true).'</lse-fe-wrapper>';
			break;
	}

	$trClasses = ! empty($trClasses) ? ' class="'.$trClasses.'"' : '';

	echo '<tr'.$trClasses.'>
	<td>'.$wrapperStart.''.$default['name'].''.$wrapperEnd.'</td>
	<td>'.$control.'</td>
	<td class="desc">'.$default['desc'].'</td>
</tr>';
}


function lsGetOptionValue( $default, $current ) {

	$value = $default['value'];

	// Override the default
	if( isset( $current[ $name ] ) && $current[ $name ] !== '' ) {
		$value = htmlspecialchars( stripslashes( $current[ $name ] ) );
	}

	return $value;
}


function lsGetInput($default, $current = null, $attrs = [], $return = false) {

	// Markup
	$el 		= LayerSlider\DOM::newDocumentHTML('<input>')->children();
	$attributes = [];

	$name = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];

	$attributes['value'] 		= $default['value'];
	$attributes['type']  		= is_string($default['value']) ? 'text' : 'number';
	$attributes['name']  		= $name;
	$attributes['data-prop'] 	= $name;


	if( ! empty( $default['name'] ) ) {
		$attributes['data-search-name'] = $default['name'];
	}

	$attrs = isset($default['attrs']) ? array_merge($default['attrs'], $attrs) : $attrs;
	if( ! empty($attrs) && is_array( $attrs ) ) {
		$attributes = array_merge($attributes, $attrs);
	}

	// Override the default
	if(isset($current[$name]) && $current[$name] !== '') {
		if( $current[$name] != $default['value'] ) {
			$attributes['value'] = htmlspecialchars(stripslashes($current[$name]));
		}
	}

	$attributes['data-default'] = $default['value'];

	if( empty( $attributes['placeholder'] ) ) {
		//if( ! is_string( $default['value'] ) || ! empty( $default['value'] ) ) {
			$attributes['placeholder'] = $default['value'];
		//}
	}

	$el->attr($attributes);

	// License registration check
	if( ! empty( $default['premium'] ) ) {
		if( ! LS_Config::isActivatedSite() ) {
			$el->addClass('locked');
			$el->attr('disabled', 'disabled');
		}
	}

	$ret = (string) $el;
	LayerSlider\DOM::unloadDocuments();

	if( $return ) { return $ret; } else { echo $ret; }
}



function lsGetCheckbox($default, $current = null, $attrs = [], $return = false, $labelAttrs = [] ) {

	$labelClassList = '';
	if( ! empty( $labelAttrs['class'] ) ) {
		$labelClassList = $labelAttrs['class'];
		unset( $labelAttrs['class'] );
	}



	// Markup
	$markup = LayerSlider\DOM::newDocumentHTML('<label class="ls-switch"><input type="checkbox"><ls-switch></ls-switch></label>');

	$input 	= $markup->find('input');
	$label 	= $markup->find('label');

	$attributes = [];

	$name = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];

	$attributes['value'] 		= $default['value'];
	$attributes['name']  		= $name;
	$attributes['data-prop'] 	= $name;

	if( ! empty( $default['name'] ) ) {
		$attributes['data-search-name'] = $default['name'];
	}

	$attrs = isset($default['attrs']) ? array_merge($default['attrs'], $attrs) : $attrs;
	if( ! empty($attrs) && is_array( $attrs ) ) {
		$attributes = array_merge($attributes, $attrs);
	}

	// Checked?
	$attributes['data-default'] = $default['value'] ? 'true' : 'false';
	$attributes['data-value'] = false;
	if($default['value'] === true && ( ! isset($current[$name]) || count($current) < 3 ) ) {
		$attributes['checked'] = 'checked';
	} elseif(isset($current[$name]) && $current[$name] != false && $current[$name] !== 'false') {
		$attributes['checked'] = 'checked';
	}

	$attributes['value'] = $attributes['data-value'];
	$input->attr($attributes);

	// Label attributes
	$label->attr( $labelAttrs );
	$label->addClass( $labelClassList );

	// License registration check
	if( ! empty( $default['premium'] ) ) {
		if( ! LS_Config::isActivatedSite() ) {
			$input->addClass('locked');
			$input->attr('disabled', 'disabled');
		}
	}

	$ret = (string) $input;
	LayerSlider\DOM::unloadDocuments();

	if( $return ) { return $ret; } else { echo $ret; }
}



function lsGetSelect($default, $current = null, $attrs = [], $forceOptionVal = false, $return = false ) {

	// Var to hold data to print
	$el 		= LayerSlider\DOM::newDocumentHTML('<select>')->children();
	$attributes = [];
	$options 	= [];
	$listItems  = [];

	$name  = is_string($default['keys']) ? $default['keys'] : $default['keys'][0];

	$attributes['value'] 		= $value = $default['value'];
	$attributes['name']  		= $name;
	$attributes['data-prop'] 	= $name;

	if( ! empty( $default['name'] ) ) {
		$attributes['data-search-name'] = $default['name'];
	}

	// Attributes
	$attrs = isset($default['attrs']) ? array_merge($default['attrs'], $attrs) : $attrs;
	if( ! empty($attrs) && is_array( $attrs ) ) {
		$attributes = array_merge($attributes, $attrs);
	}

	// Get options
	if(isset($default['options']) && is_array($default['options'])) {
		$options = $default['options'];
	} elseif(isset($attrs['options']) && is_array($attrs['options'])) {
		$options = $attrs['options'];
	}

	// Override the default
	if(isset($current[$name]) && $current[$name] !== '') {
		$attributes['value'] = $value = $current[$name];
	}

	// Add options
	foreach($options as $name => $val) {

		$name = (is_string($name) || $forceOptionVal) ? $name : $val;
		$name = ($name === 'zero') ? 0 : $name;


		$checked = ($name == $value) ? ' selected="selected"' : '';
		$listItems[] = "<option value=\"$name\" $checked>$val</option>";
	}

	$attributes['data-default'] = $default['value'];
	$el->append( implode('', $listItems) )->attr($attributes);

	// License registration check
	if( ! empty( $default['premium'] ) ) {
		if( ! LS_Config::isActivatedSite() ) {
			$el->addClass('locked');
			$el->attr('disabled', 'disabled');
		}
	}

	$ret = (string) $el;
	LayerSlider\DOM::unloadDocuments();

	if( $return ) { return $ret; } else { echo $ret; }
}

?>