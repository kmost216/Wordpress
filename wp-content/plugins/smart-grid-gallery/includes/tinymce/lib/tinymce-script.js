(function($) {
  tinymce.create( 
      'tinymce.plugins.sgg_shortcode', 
      {

          init : function( editor, url ) {
              editor.addButton(
                  'sgg_shortcode_btn', 
                  {
                    cmd   : 'sgg_shortcode_btn_cmd',
                    title : 'Smart Grid Gallery',
                    image : url + '/sgg-icon.png'
                  }
                );
               editor.addCommand(
                'sgg_shortcode_btn_cmd',
                function() {
                  editor.windowManager.open(
                    {
                      // this is the ID of the popups parent element
                      id     : 'sgg_shortcode-form',
                      width    : 480,
                      height   : 600,
                      title    : 'Smart Grid Gallery Shortcode',
                      wpDialog : true,
                    },
                    {
                      plugin_url : url
                    }
                  );
                }
              );
          }
      }
  );
  // register plugin
  tinymce.PluginManager.add( 'sgg_shortcode', tinymce.plugins.sgg_shortcode );
})(jQuery);