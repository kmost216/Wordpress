<?php do_action( "before_smart_grid_gallery_html" ); ?>
<div id="justified_gallery_<?php echo $this->ID; ?>" class="sgg-style-<?php echo $this->shortcode_atts['style']; ?> <?php echo $this->gallery_atts['class']; ?>"><?php 
	$first_gallery = array_shift( $galleries );
	$this->gallery_images( $first_gallery['args'] );
	?>
</div>
<div id="load_more_holder_<?php echo $this->ID; ?>" style="display:none"></div>
<?php 
$this->load_more_button( $galleries ); 
$this->custom_js( $galleries );
$this->custom_css();
do_action( "after_smart_grid_gallery_html" ); ?>