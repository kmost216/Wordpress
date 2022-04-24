var nodes = document.querySelectorAll('#justified_gallery_<?php echo $this->ID; ?> > *'),
_nodes = [].slice.call(nodes, 0);
var getDirection = function (ev, obj) {
    // the width and height of the current div
	var w = $(obj).width(),
		h = $(obj).height(),
		// calculate the x and y to get an angle to the center of the div from that x and y.
		// gets the x value relative to the center of the DIV and "normalize" it
		x = ( ev.pageX - $(obj).offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
		y = ( ev.pageY - $(obj).offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
		// the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
		// first calculate the angle of the point,
		// add 180 deg to get rid of the negative values
		// divide by 90 to get the quadrant
		// add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
		direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
	return direction;
};
var addClass = function ( ev, obj, state ) {
    var direction = getDirection( ev, obj ),
        class_suffix = "",
        iframe = obj.classList.contains("mfp-iframe");
    obj.className = "";
    if (iframe) {
        obj.classList.add("mfp-iframe");
    }
    obj.classList.add("sgg-lightbox-item");
    switch ( direction ) {
        case 0 : class_suffix = '-top';    break;
        case 1 : class_suffix = '-right';  break;
        case 2 : class_suffix = '-bottom'; break;
        case 3 : class_suffix = '-left';   break;
    }
    obj.classList.add( state + class_suffix );
};
// bind events
_nodes.forEach(function (el) {
    el.addEventListener('mouseenter', function (ev) {
        addClass( ev, this, 'in' );
    }, false);
    el.addEventListener('mouseleave', function (ev) {
        addClass( ev, this, 'out' );
    }, false);
});