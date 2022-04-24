<?php

// WRAPPER
echo "<div class=\"slide slide{$slide_count} testimonial_rotator_slide hreview itemreviewed item {$has_image} cf-tr\">\n";

// POST THUMBNAIL
if ( $has_image && $show_image ) {
	echo "<div class=\"testimonial_rotator_img img\">" . wp_kses_post( get_the_post_thumbnail( get_the_ID(), $img_size ) ) . "</div>\n";
}
// DESCRIPTION
echo "<div class=\"text testimonial_rotator_description\">\n";

echo "<i class=\"quote-icon fa fa-quote-right\"></i>\n";

// IF SHOW TITLE
if ( $show_title ) {
	echo "<{$title_heading} class=\"testimonial_rotator_slide_title\">" . esc_html( get_the_title() ) . "</{$title_heading}>\n";
}

// CONTENT
if ( $show_body ) {
	echo "<div class=\"testimonial_rotator_quote\">\n";
	if ( $show_size == "full" ) {
		echo do_shortcode( nl2br( get_the_content( ' ' ) ) );
	} else {
		echo testimonial_rotator_excerpt( $excerpt_length );
	}
	echo "</div>\n";
}

// RATING
if ( $rating AND $show_stars ) {
	echo "<div class=\"testimonial_rotator_stars cf-tr\">\n";
	for( $r=1; $r <= $rating; $r++ ) {
		echo "<span class=\"testimonial_rotator_star testimonial_rotator_star_$r\"><i class=\"fa {$testimonial_rotator_star}\"></i></span>";
	}
	echo "</div>\n";
}

// AUTHOR INFO
if ( $cite AND $show_author ) {
	echo "<div class=\"testimonial_rotator_author_info cf-tr\">\n";
	echo wp_kses_post( wpautop( $cite ) );
	echo "</div>\n";				
}

echo "</div>\n";

// MICRODATA 
if ( $show_microdata ) {
	$global_rating = $global_rating + $rating;

	echo "<div class=\"testimonial_rotator_microdata\">\n";

		if ( $itemreviewed ) {
			echo "\t<div class=\"item\"><div class=\"fn\">{$itemreviewed}</div></div>\n";
		}
		if ( $rating ) {
			echo "\t<div class=\"rating\">{$rating}.0</div>\n";
		}

		echo "	<div class=\"dtreviewed\"> " . esc_html( get_the_date('c') ) . "</div>";
		echo "	<div class=\"reviewer\"> ";
			echo "	<div class=\"fn\"> " . wp_kses_post( wpautop( $cite ) ). "</div>";
			if ( has_post_thumbnail() ) { echo wp_kses_post( get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => 'photo' ) ) ); }
		echo "	</div>";
		echo "	<div class=\"summary\"> " . wp_kses_post( wp_trim_excerpt( get_the_excerpt() ) ) . "</div>";
		echo "	<div class=\"permalink\"> " . esc_url( get_permalink() ) . "</div>";
	
	echo "</div> <!-- .testimonial_rotator_microdata -->\n";
}

echo "</div>\n";