jQuery(function($) {

    "use strict";

    (function() {
        /**
         * Embellishments
         */

        $('.wh-has-embellishment').each(function() {

            var $this = $(this);

            var classes = $this.attr('class').split(' ');
            var matchedClasses = [];

            $.each(classes, function(i, className) {

                var matches = /^wh-embellishment-type\-(.+)/.exec(className);
                if (matches !== null) {
                    matchedClasses.push(matches[1]);
                }
            });

            $.each(matchedClasses, function(i, className) {

                if (className.search('top') !== -1) {
                    $this.prepend('<div class="wh-embellishment-' + className + '"/>');
                } else if (className.search('bottom') !== -1) {
                    $this.append('<div class="wh-embellishment-' + className + '"/>');
                }
            });

        });

    })();

    /**
     * Mobile Menu
     */
    (function () {

        var $mobileMenu = $('#wh-mobile-menu');

        // Header Toggle
        $mobileMenu.find('.respmenu-header .respmenu-open').on('click', function() {
            $mobileMenu.find('.respmenu').slideToggle(200);
        });

        // Submenu Toggle
        $mobileMenu.find('.respmenu-submenu-toggle').on('click', function() {
            $(this).siblings('.sub-menu').slideToggle(200);
        });

    })();


    (function() {

        var classOpen = 'iconsmind-minus';
        var classClose = 'iconsmind-plus';

        $('.wpb_accordion_header').on('click', function () {

            var $this = $(this);

            $this.find('.ui-icon').addClass(classOpen);
            $this.find('.ui-icon').removeClass(classClose);

            $this.parent().siblings().find('.wpb_accordion_header .ui-icon'). removeClass(classOpen).addClass(classClose);

        });
        /**
         * Replace Accordion icon class
         */

        setTimeout(function () {


            $('.wpb_accordion_header').each(function() {

                var $this = $(this);

                if ($this.hasClass('ui-state-active')) {
                    $this.find('.ui-icon').addClass(classOpen);
                } else {
                    $this.find('.ui-icon').addClass(classClose);
                }


            });
        }, 500);

    })();


    /**
     * Init Plugins
     */
    (function () {


        /**
         * Superfish Menu
         */
        $('.sf-menu ul').superfish();

        $('.cbp-row:not(.wpb_layerslider_element)').fitVids();


        /**
         * Respmenu
         */
        if (wheels.data.respmenu) {
            $('#' + wheels.data.respmenu.id + ' ul').first().respmenu(wheels.data.respmenu.options);
        }

        /**
         * ScrollUp
         */
        if (wheels.data.useScrollToTop) {
            $.scrollUp({
                scrollText: wheels.data.scrollToTopText
            });
        }


        /**
         * Sticky Menu
         */
        var stickyMenuTopOffset = 0;
        if (wheels.data.isAdminBarShowing) {
            stickyMenuTopOffset = $('#wpadminbar').height();
        }

        $('.wh-sticky-header-enabled').sticky({
            topSpacing: stickyMenuTopOffset,
            className: 'wh-sticky-header',
            getWidthFrom: 'body',
            responsiveWidth: true
        });



        /**
         * Scroll to Element
         */
        $('header a[href^="#"], .wh-top-bar a[href^="#"], .wh-top-bar a[href^="/#"]').on('click', function(e) {

            var positionTop;
            var $this = $(this);
            var $mainMenuWrapper = $('.wh-main-menu-bar-wrapper');
            var stickyHeaderHeight = $mainMenuWrapper.height();


            var target = $this.attr('href');
            target = target.replace('/', '');
            var $target = $(target);

            if( $target.length ) {
                e.preventDefault();

                // if sticky menu is visible
                if ($('.wh-sticky-header').length) {
                    positionTop = $target.offset().top - stickyHeaderHeight;
                } else {
                    positionTop = $target.offset().top - wheels.data.initialWaypointScrollCompensation || 120;
                }

                $('body, html').animate({ // html needs to be there for Firefox
                    scrollTop: positionTop
                }, 1000);
            }
        });


    })();

});
