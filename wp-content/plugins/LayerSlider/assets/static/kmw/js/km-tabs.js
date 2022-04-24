
/*
	* KM-Tabs
	*
	* (c) 2019-2021 Kreatura Media, AgeraWeb, George K., John G.
	*
*/



jQuery( document ).ready( function( $ ){

	$( document ).on( 'click.km-tabs', '.km-tabs-list > *:not(.kmw-disabled, .kmw-unselectable, kmw-menutitle)', function(){

		var selector = '[data-kmw-uid="' + $(this).closest('.kmw-modal-container').data('kmwUid') + '"] kmw-menuitem';

		var $clicked = $(this),
			index = $clicked.index( selector ),
			$parent = $clicked.parent(),
			$modal = $parent.closest( '.kmw-modal' ),
			menuText = $clicked.find( 'kmw-menutext' ).text(),
			$target = $( $parent.data( 'target' ) ),
			disableAutoRename = $parent.data( 'disableAutoRename' );

		if( !$clicked.hasClass( 'kmw-active' ) ){

			$clicked.siblings().removeClass( 'kmw-active' );
			$clicked.addClass( 'kmw-active' );

			$target.children().removeClass( 'kmw-active' );
			$target.children().eq(index).addClass( 'kmw-active' );
		}

		if( typeof disableAutoRename === 'undefined' ){
			$modal.find( 'kmw-h1.kmw-modal-title' ).text( menuText );
		}
	});
});
