<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'vc_iconpicker-type-theme-icons', 'care_plugin_theme_icons' );
add_action( 'admin_menu', 'care_plugin_register_show_theme_icons_page' );
add_action( 'admin_enqueue_scripts', 'care_plugin_icons_page_style' );

function care_plugin_theme_icons( $icons ) {
    return array_merge( $icons, care_plugin_get_theme_icon_list() );
}

function care_plugin_get_theme_icons_for_elementor( $icons ) {
    foreach ( care_plugin_get_theme_icon_list() as $icon ) {
        $key = key( $icon );
        $icons[$key] = $key;
    }

    return $icons;
}

function care_plugin_show_theme_icons() {
    $icons = care_plugin_get_theme_icon_list();
    ?>
    <h1><?php esc_html_e( 'Theme Icons', 'care-plugin' ); ?></h1>
    <ul class="icons">
    <?php foreach ( $icons as $icon_data ): ?>
        <?php foreach ( $icon_data as $icon ): ?>
            <li><i class="<?php echo esc_attr( $icon ); ?>"></i> <?php echo esc_html( $icon ); ?></li>
        <?php endforeach ?>
    <?php endforeach ?>
    </ul>
    <?php
}

function care_plugin_icons_page_style( $hook ) {

    if ( $hook != 'tools_page_theme-icons' ) {
        return;
    }
    wp_enqueue_style( 'care-theme-icons', get_template_directory_uri() . '/assets/css/theme-icons.css', false );

    $custom_css = '.icons li{width: 30%;list-style:none;float: left;
    padding: 10px;}.icons li i{font-size:30px;margin-right: 15px;}';
    wp_add_inline_style( 'care-theme-icons', $custom_css );
}

function care_plugin_register_show_theme_icons_page() {
    add_submenu_page( 
        'tools.php',
        'Theme Icons',
        'Theme Icons',
        'manage_options',
        'theme-icons',
        'care_plugin_show_theme_icons'
    );
}

function care_plugin_get_theme_icon_list() {
	$theme_icons = array(
		array('icon-arrow-right' => 'icon-arrow-right'),
        array('icon-comment' => 'icon-comment'),
        array('icon-left-arrow' => 'icon-left-arrow'),
        array('icon-price-tag' => 'icon-price-tag'),
        array('icon-right-arrow' => 'icon-right-arrow'),
        array('icon-user' => 'icon-user'),
        array('icon-gardening' => 'icon-gardening'),
        array('icon-leaves' => 'icon-leaves'),
        array('icon-plant1' => 'icon-plant1'),
        array('icon-plant' => 'icon-plant'),
        array('icon-trees' => 'icon-trees'),
        array('icon-watering-can-with-water-drops' => 'icon-watering-can-with-water-drops'),
        array('icon-apple2' => 'icon-apple2'),
        array('icon-exercise1' => 'icon-exercise1'),
        array('icon-exercise' => 'icon-exercise'),
        array('icon-icon1' => 'icon-icon1'),
        array('icon-icon2' => 'icon-icon2'),
        array('icon-india' => 'icon-india'),
        array('icon-man' => 'icon-man'),
        array('icon-medical5' => 'icon-medical5'),
        array('icon-mountain' => 'icon-mountain'),
        array('icon-nature12' => 'icon-nature12'),
        array('icon-nature2' => 'icon-nature2'),
        array('icon-people4' => 'icon-people4'),
        array('icon-shape2' => 'icon-shape2'),
        array('icon-silhouette3' => 'icon-silhouette3'),
        array('icon-sports12' => 'icon-sports12'),
        array('icon-sports3' => 'icon-sports3'),
        array('icon-two3' => 'icon-two3'),
        array('icon-bath' => 'icon-bath'),
        array('icon-business3' => 'icon-business3'),
        array('icon-calculate' => 'icon-calculate'),
        array('icon-fashion' => 'icon-fashion'),
        array('icon-food13' => 'icon-food13'),
        array('icon-food11' => 'icon-food11'),
        array('icon-fruit9' => 'icon-fruit9'),
        array('icon-healthy2' => 'icon-healthy2'),
        array('icon-medical3' => 'icon-medical3'),
        array('icon-money2' => 'icon-money2'),
        array('icon-plus' => 'icon-plus'),
        array('icon-ribbon2' => 'icon-ribbon2'),
        array('icon-silhouette2' => 'icon-silhouette2'),
        array('icon-square' => 'icon-square'),
        array('icon-tool8' => 'icon-tool8'),
        array('icon-transport12' => 'icon-transport12'),
        array('icon-transport3' => 'icon-transport3'),
        array('icon-bag' => 'icon-bag'),
        array('icon-book12' => 'icon-book12'),
        array('icon-diploma' => 'icon-diploma'),
        array('icon-food10' => 'icon-food10'),
        array('icon-interface1' => 'icon-interface1'),
        array('icon-interface2' => 'icon-interface2'),
        array('icon-park1' => 'icon-park1'),
        array('icon-park' => 'icon-park'),
        array('icon-people1' => 'icon-people1'),
        array('icon-people22' => 'icon-people22'),
        array('icon-people3' => 'icon-people3'),
        array('icon-school' => 'icon-school'),
        array('icon-time4' => 'icon-time4'),
        array('icon-transport' => 'icon-transport'),
        array('icon-letter' => 'icon-letter'),
        array('icon-animal1' => 'icon-animal1'),
        array('icon-animal2' => 'icon-animal2'),
        array('icon-animal3' => 'icon-animal3'),
        array('icon-animal4' => 'icon-animal4'),
        array('icon-animal5' => 'icon-animal5'),
        array('icon-animal6' => 'icon-animal6'),
        array('icon-animal' => 'icon-animal'),
        array('icon-animals1' => 'icon-animals1'),
        array('icon-animals2' => 'icon-animals2'),
        array('icon-animals' => 'icon-animals'),
        array('icon-apple' => 'icon-apple'),
        array('icon-arrow' => 'icon-arrow'),
        array('icon-arrows' => 'icon-arrows'),
        array('icon-ball' => 'icon-ball'),
        array('icon-book1' => 'icon-book1'),
        array('icon-book' => 'icon-book'),
        array('icon-bookmark' => 'icon-bookmark'),
        array('icon-box' => 'icon-box'),
        array('icon-business' => 'icon-business'),
        array('icon-calendar' => 'icon-calendar'),
        array('icon-camera' => 'icon-camera'),
        array('icon-clock2' => 'icon-clock2'),
        array('icon-clock4' => 'icon-clock4'),
        array('icon-cup' => 'icon-cup'),
        array('icon-cut' => 'icon-cut'),
        array('icon-dog1' => 'icon-dog1'),
        array('icon-dog2' => 'icon-dog2'),
        array('icon-dog' => 'icon-dog'),
        array('icon-drink' => 'icon-drink'),
        array('icon-food1' => 'icon-food1'),
        array('icon-food2' => 'icon-food2'),
        array('icon-food3' => 'icon-food3'),
        array('icon-food4' => 'icon-food4'),
        array('icon-food' => 'icon-food'),
        array('icon-fruit1' => 'icon-fruit1'),
        array('icon-fruit2' => 'icon-fruit2'),
        array('icon-fruit3' => 'icon-fruit3'),
        array('icon-fruit4' => 'icon-fruit4'),
        array('icon-fruit5' => 'icon-fruit5'),
        array('icon-fruit6' => 'icon-fruit6'),
        array('icon-fruit7' => 'icon-fruit7'),
        array('icon-fruit' => 'icon-fruit'),
        array('icon-fruits' => 'icon-fruits'),
        array('icon-hand' => 'icon-hand'),
        array('icon-healthy1' => 'icon-healthy1'),
        array('icon-interface' => 'icon-interface'),
        array('icon-keys' => 'icon-keys'),
        array('icon-medical2' => 'icon-medical2'),
        array('icon-medical' => 'icon-medical'),
        array('icon-money' => 'icon-money'),
        array('icon-music1' => 'icon-music1'),
        array('icon-paint' => 'icon-paint'),
        array('icon-people' => 'icon-people'),
        array('icon-phone' => 'icon-phone'),
        array('icon-ribbon' => 'icon-ribbon'),
        array('icon-sewing' => 'icon-sewing'),
        array('icon-shape1' => 'icon-shape1'),
        array('icon-shape' => 'icon-shape'),
        array('icon-shield' => 'icon-shield'),
        array('icon-sign' => 'icon-sign'),
        array('icon-signs' => 'icon-signs'),
        array('icon-silhouette' => 'icon-silhouette'),
        array('icon-snack' => 'icon-snack'),
        array('icon-sport' => 'icon-sport'),
        array('icon-sports' => 'icon-sports'),
        array('icon-three' => 'icon-three'),
        array('icon-time1' => 'icon-time1'),
        array('icon-time2' => 'icon-time2'),
        array('icon-time3' => 'icon-time3'),
        array('icon-tool1' => 'icon-tool1'),
        array('icon-tool3' => 'icon-tool3'),
        array('icon-tool4' => 'icon-tool4'),
        array('icon-tool5' => 'icon-tool5'),
        array('icon-tool6' => 'icon-tool6'),
        array('icon-tool' => 'icon-tool'),
        array('icon-transport1' => 'icon-transport1'),
        array('icon-transport2' => 'icon-transport2'),
        array('icon-two' => 'icon-two'),
        array('icon-animal7' => 'icon-animal7'),
        array('icon-arrows2' => 'icon-arrows2'),
        array('icon-beach' => 'icon-beach'),
        array('icon-black' => 'icon-black'),
        array('icon-business2' => 'icon-business2'),
        array('icon-check' => 'icon-check'),
        array('icon-circle1' => 'icon-circle1'),
        array('icon-circle2' => 'icon-circle2'),
        array('icon-circle3' => 'icon-circle3'),
        array('icon-circle' => 'icon-circle'),
        array('icon-computer' => 'icon-computer'),
        array('icon-dog12' => 'icon-dog12'),
        array('icon-dog3' => 'icon-dog3'),
        array('icon-draw' => 'icon-draw'),
        array('icon-drink2' => 'icon-drink2'),
        array('icon-food12' => 'icon-food12'),
        array('icon-food22' => 'icon-food22'),
        array('icon-food32' => 'icon-food32'),
        array('icon-food42' => 'icon-food42'),
        array('icon-food5' => 'icon-food5'),
        array('icon-food6' => 'icon-food6'),
        array('icon-food7' => 'icon-food7'),
        array('icon-food8' => 'icon-food8'),
        array('icon-food9' => 'icon-food9'),
        array('icon-fruit12' => 'icon-fruit12'),
        array('icon-fruit8' => 'icon-fruit8'),
        array('icon-gps1' => 'icon-gps1'),
        array('icon-gps' => 'icon-gps'),
        array('icon-healthy' => 'icon-healthy'),
        array('icon-icon' => 'icon-icon'),
        array('icon-medical4' => 'icon-medical4'),
        array('icon-nature1' => 'icon-nature1'),
        array('icon-nature' => 'icon-nature'),
        array('icon-check-icon' => 'icon-check-icon'),
        array('icon-people2' => 'icon-people2'),
        array('icon-sewing2' => 'icon-sewing2'),
        array('icon-shapes1' => 'icon-shapes1'),
        array('icon-signs1' => 'icon-signs1'),
        array('icon-signs2' => 'icon-signs2'),
        array('icon-signs3' => 'icon-signs3'),
        array('icon-signs4' => 'icon-signs4'),
        array('icon-signs5' => 'icon-signs5'),
        array('icon-social' => 'icon-social'),
        array('icon-social-media1' => 'icon-social-media1'),
        array('icon-social-media2' => 'icon-social-media2'),
        array('icon-social-media3' => 'icon-social-media3'),
        array('icon-social-media' => 'icon-social-media'),
        array('icon-sports1' => 'icon-sports1'),
        array('icon-sports2' => 'icon-sports2'),
        array('icon-stack' => 'icon-stack'),
        array('icon-strength' => 'icon-strength'),
        array('icon-symbol' => 'icon-symbol'),
        array('icon-telephone' => 'icon-telephone'),
        array('icon-three2' => 'icon-three2'),
        array('icon-time' => 'icon-time'),
        array('icon-tool12' => 'icon-tool12'),
        array('icon-tool2' => 'icon-tool2'),
        array('icon-tool7' => 'icon-tool7'),
        array('icon-two2' => 'icon-two2'),
	);

	return $theme_icons;
}
