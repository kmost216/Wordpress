jQuery(function ($) {

    setTimeout(function () {
        var $themeIconNames = $('.scp-theme-icon-name');

        $themeIconNames.each(function () {

            var $this = $(this);

            var className = $this.text();
            var markup = '<i class="' + className + '"></i>';

            $this.html(markup);

        });
    }, 1000);

});