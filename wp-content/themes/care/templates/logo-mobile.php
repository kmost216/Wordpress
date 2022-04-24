<?php

$respmenu_use                     = (int) care_get_option( 'respmenu-use', 1 );
$respmenu_show_start              = (int) care_get_option( 'respmenu-show-start', 767 );
$respmenu_logo                    = care_get_option( 'respmenu-logo', array() );
$respmenu_logo_url                = isset( $respmenu_logo['url'] ) && $respmenu_logo['url'] ? $respmenu_logo['url'] : '';
$respmenu_display_switch_logo     = care_get_option( 'respmenu-display-switch-img', array() );
$respmenu_display_switch_logo_url = isset( $respmenu_display_switch_logo['url'] ) && $respmenu_display_switch_logo['url'] ? $respmenu_display_switch_logo['url'] : '';
