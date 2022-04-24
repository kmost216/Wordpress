jQuery(document).ready(function($){

	var getRecoupValues = function( $el ){

		let el = $el[0],
			position = $el.position(),
			data = $el.data(),
			_left, _top, recoup;

		if( !data.uiDraggable || data.uiDraggable.options.noRecoup ){

			recoup = {
				left: 0,
				top: 0
			};

		}else{

			_left = parseInt( el.style.left );
			_left = ( isNaN(_left) ? 0 : _left ) * ( LS_previewZoom || 1 );
			_top = parseInt( el.style.top );
			_top = ( isNaN(_top) ? 0 : _top ) * ( LS_previewZoom || 1 );

			recoup = {
				left: _left - position.left,
				top: _top - position.top
			};
		}

		data.recoup = recoup;
		return recoup;
	};

	jQuery.ui.draggable.prototype._refreshOffsets = function( event ) {

		let recoup = getRecoupValues( this.element );

		this.offset = {
			top: this.positionAbs.top - this.margins.top + recoup.top,
			left: this.positionAbs.left - this.margins.left + recoup.left,
			scroll: false,
			parent: this._getParentOffset(),
			relative: this._getRelativeOffset()
		};

		this.offset.click = {
			left: event.pageX - this.offset.left,
			top: event.pageY - this.offset.top
		};
	};

	$.ui.plugin.add( "draggable", "snap", {
		start: function( event, ui, i ) {

			var o = i.options;

			i.snapElements = [];

			$( o.snap.constructor !== String ? ( o.snap.items || ":data(ui-draggable)" ) : o.snap )
				.each( function() {
					var $t = $( this ),
						$o = $t.offset();
					if ( this !== i.element[ 0 ] ) {
						i.snapElements.push( {
							item: this,
							width: $t.outerWidth(), height: $t.outerHeight(),
							top: $o.top, left: $o.left
						});
					}
				} );
		},
		drag: function( event, ui, inst ) {

			var ts, bs, ls, rs, cc, mm, l, r, t, b, c, m, i, first, $el, data, recoup,
				o = inst.options,
				d = o.snapTolerance,
				uiW = inst.helperProportions.width,
				uiH = inst.helperProportions.height,
				uiL = ui.offset.left,
				uiR = uiL + uiW,
				uiC = uiL + uiW / 2,
				uiT = ui.offset.top,
				uiM = uiT + uiH / 2,
				uiB = uiT + uiH;
			//console.log( ui );
			for ( i = inst.snapElements.length - 1; i >= 0; i-- ) {

				$el = $( inst.snapElements[ i ].item );
				data =  $el.data();

				recoup = getRecoupValues( $el );

				l = inst.snapElements[ i ].left - inst.margins.left + recoup.left;
				r = l + inst.snapElements[ i ].width;
				t = inst.snapElements[ i ].top - inst.margins.top + recoup.top;
				b = t + inst.snapElements[ i ].height;
				c = l + inst.snapElements[ i ].width / 2;
				m = t + inst.snapElements[ i ].height / 2;

				//console.log('left', l, 'right', r, 'width', inst.snapElements[ i ].width, 'center', c );
				//console.log('uiLeft', uiL, 'uiRight', uiR );

				if ( uiR < l - d || uiL > r + d || uiB < t - d || uiT > b + d ||
						!$.contains( inst.snapElements[ i ].item.ownerDocument,
						inst.snapElements[ i ].item ) ) {
					if ( inst.snapElements[ i ].snapping ) {
						if ( inst.options.snap.release ) {
							inst.options.snap.release.call(
								inst.element,
								event,
								$.extend( inst._uiHash(), { snapItem: inst.snapElements[ i ].item } )
							);
						}
					}
					inst.snapElements[ i ].snapping = false;
					continue;
				}

				// center - center | horizontal
				cc = Math.abs( c - uiC ) <= d;

				if ( cc ) {
					ui.position.left = inst._convertPositionTo( "relative", {
						top: 0,
						left: c - uiW / 2
					} ).left;
				}

				// center to center | vertical
				mm = Math.abs( m - uiM ) <= d;

				if ( mm ) {
					ui.position.top = inst._convertPositionTo( "relative", {
						top: m - uiH / 2,
						left: 0
					} ).top;
				}

				if ( o.snapMode !== "inner" ) {
					ts = Math.abs( t - uiB ) <= d;
					bs = Math.abs( b - uiT ) <= d;
					ls = Math.abs( l - uiR ) <= d;
					rs = Math.abs( r - uiL ) <= d;
					if ( ts ) {
						ui.position.top = inst._convertPositionTo( "relative", {
							top: t - uiH,
							left: 0
						} ).top;
					}
					if ( bs ) {
						ui.position.top = inst._convertPositionTo( "relative", {
							top: b,
							left: 0
						} ).top;
					}
					if ( ls ) {
						ui.position.left = inst._convertPositionTo( "relative", {
							top: 0,
							left: l - uiW
						} ).left;
					}
					if ( rs ) {
						ui.position.left = inst._convertPositionTo( "relative", {
							top: 0,
							left: r
						} ).left;
					}
				}

				first = ( ts || bs || ls || rs || cc || mm );

				if ( o.snapMode !== "outer" ) {
					ts = Math.abs( t - uiT ) <= d;
					bs = Math.abs( b - uiB ) <= d;
					ls = Math.abs( l - uiL ) <= d;
					rs = Math.abs( r - uiR ) <= d;

					if ( ts ) {
						ui.position.top = inst._convertPositionTo( "relative", {
							top: t,
							left: 0
						} ).top;
					}
					if ( bs ) {
						ui.position.top = inst._convertPositionTo( "relative", {
							top: b - uiH,
							left: 0
						} ).top;
					}
					if ( ls ) {
						ui.position.left = inst._convertPositionTo( "relative", {
							top: 0,
							left: l
						} ).left;
					}
					if ( rs ) {
						ui.position.left = inst._convertPositionTo( "relative", {
							top: 0,
							left: r - uiW
						} ).left;
					}
				}

				if ( !inst.snapElements[ i ].snapping && ( ts || bs || ls || rs || cc || mm || first ) ) {
					if ( inst.options.snap.snap ) {
						inst.options.snap.snap.call(
							inst.element,
							event,
							$.extend( inst._uiHash(), {
								snapItem: inst.snapElements[ i ].item
							} ) );
					}
				}
				inst.snapElements[ i ].snapping = ( ts || bs || ls || rs || cc || mm || first );
			}

		}
	} );
});