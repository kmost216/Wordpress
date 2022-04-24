(function() {
    tinymce.PluginManager.add('scp_mce_shortcodes', function( editor, url ) {
        editor.addButton( 'scp_mce_shortcodes', {
            text: 'Theme Shortcodes',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Icons',
                    menu: [

                        /**
                         *  Icon
                         */
                        {
                            text: 'Icon',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Insert Icon Shortcode',
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'icon_class',
                                            label: 'Icon Class',
                                            value: 'fa fa-twitter',
                                            tooltip: 'You can use font awesome or iconsmind icon class'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'link',
                                            label: 'link',
                                            value: '',
                                            tooltip: 'Use absolute url'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'size',
                                            label: 'Size',
                                            value: '20px'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'color',
                                            label: 'Icon Color',
                                            value: '#000',
                                            tooltip: 'Use hex value'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'hover_color',
                                            label: 'Icon Hover Color',
                                            value: '#333',
                                            tooltip: 'Use hex value'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'margin',
                                            label: 'Margin',
                                            value: '0 5px'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'line_height',
                                            label: 'Line Height',
                                            value: '30px'
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'float',
                                            label: 'Float',
                                            'values': [
                                                {text: 'Left', value: 'left'},
                                                {text: 'Right', value: 'right'}
                                            ]
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'bg_color',
                                            label: 'Background Color',
                                            value: ''
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'bg_width',
                                            label: 'Background Width',
                                            value: ''
                                        }
                                    ],
                                    onsubmit: function( e ) {

                                        var shortcode = '[scp_icon';

                                        shortcode += ' icon="' + e.data.icon_class + '"';
                                        shortcode += ' link="' + e.data.link + '"';
                                        shortcode += ' size="' + e.data.size + '"';
                                        shortcode += ' color="' + e.data.color + '"';
                                        shortcode += ' hover_color="' + e.data.hover_color + '"';
                                        shortcode += ' float="' + e.data.float + '"';
                                        shortcode += ' margin="' + e.data.margin + '"';
                                        shortcode += ' line_height="' + e.data.line_height + '"';
                                        shortcode += ' bg_color="' + e.data.bg_color + '"';
                                        shortcode += ' bg_width="' + e.data.bg_width + '"';
                                        shortcode += ']';

                                        editor.insertContent( shortcode );
                                    }
                                });
                            }
                        },

                        /**
                         *  Icon Bullet Text
                         */
                        {
                            text: 'Icon Bullet Text',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Insert Icon Bullet Text Shortcode',
                                    body: [
                                        {
                                            type: 'textbox',
                                            name: 'icon_class',
                                            label: 'Icon Class',
                                            value: 'fa fa-twitter',



                                            tooltip: 'You can use font awesome or iconsmind icon class.'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'icon_font_size',
                                            label: 'Icon Font Size',
                                            value: '14',
                                            tooltip: 'Value in px. Use number only.'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'icon_color',
                                            label: 'Icon Color',
                                            value: '#000',
                                            tooltip: 'Value hex value.'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'title',
                                            label: 'Title',
                                            value: 'The Title'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'title_tag',
                                            label: 'Title HTML Tag',
                                            value: 'h3'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'title_color',
                                            label: 'Title Color',
                                            value: '#000',
                                            tooltip: 'Value hex value.'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'subtitle',
                                            label: 'Subtitle',
                                            value: 'The Subtitle'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'subtitle_tag',
                                            label: 'Subtitle HTML Tag',
                                            value: 'h4'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'subtitle_color',
                                            label: 'Subtitle Color',
                                            value: '#000',
                                            tooltip: 'Value hex value.'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'description_tag',
                                            label: 'Description HTML Tag',
                                            value: 'p'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'description_color',
                                            label: 'Description Color',
                                            value: '#000',
                                            tooltip: 'Value hex value.'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'description',
                                            label: 'Description',
                                            value: 'Description goes here',
                                            multiline: true,
                                            minWidth: 300,
                                            minHeight: 100
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'float',
                                            label: 'Float',
                                            'values': [
                                                {text: 'Left', value: 'left'},
                                                {text: 'Right', value: 'right'}
                                            ]
                                        },
                                        {
                                            type: 'listbox',
                                            name: 'subtitle_is_above',
                                            label: 'Subtitle is above?',
                                            'values': [
                                                {text: 'Yes', value: '0'},
                                                {text: 'No', value: '1'}
                                            ]
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'padding',
                                            label: 'Padding',
                                            value: '0px'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'margin',
                                            label: 'Margin',
                                            value: '0px'
                                        },
                                        {
                                            type: 'textbox',
                                            name: 'text_block_margin',
                                            label: 'Text Block Margin',
                                            value: ''
                                        }
                                    ],
                                    onsubmit: function( e ) {

                                        var shortcode = '[scp_icon_bullet_text';

                                        shortcode += ' icon="' + e.data.icon_class + '"';
                                        shortcode += ' icon_font_size="' + e.data.icon_font_size + '"';
                                        shortcode += ' icon_color="' + e.data.icon_color + '"';
                                        shortcode += ' title="' + e.data.title + '"';
                                        shortcode += ' title_tag="' + e.data.title_tag + '"';
                                        shortcode += ' title_color="' + e.data.title_color + '"';
                                        shortcode += ' subtitle="' + e.data.subtitle + '"';
                                        shortcode += ' subtitle_tag="' + e.data.subtitle_tag + '"';
                                        shortcode += ' subtitle_color="' + e.data.subtitle_color + '"';
                                        shortcode += ' description_tag="' + e.data.description_tag + '"';
                                        shortcode += ' description_color="' + e.data.description_color + '"';
                                        shortcode += ' float="' + e.data.float + '"';
                                        shortcode += ' padding="' + e.data.padding + '"';
                                        shortcode += ' margin="' + e.data.margin + '"';
                                        shortcode += ' text_block_margin="' + e.data.text_block_margin + '"';
                                        shortcode += ' subtitle_is_above="' + e.data.subtitle_is_above + '"';

                                        shortcode += ']';
                                        shortcode += e.data.description;
                                        shortcode += '[/scp_icon_bullet_text]';

                                        editor.insertContent( shortcode );
                                    }
                                });
                            }
                        }

                    ]
                }, // end Icons menu

                /**
                 * Separator
                 */
                {
                    text: 'Separator',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Separator Shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'color',
                                    label: 'Color',
                                    value: '#000',
                                    tooltip: 'Use hex color.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'margin',
                                    label: 'Margin',
                                    value: '20px',
                                    tooltip: 'Example: 10px 20px 10px 20px'
                                },
                                {
                                    type: 'textbox',
                                    name: 'width',
                                    label: 'Width',
                                    value: '1px',
                                    tooltip: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'height',
                                    label: 'Height',
                                    value: '50px',
                                    tooltip: ''
                                },
                                {
                                    type: 'listbox',
                                    name: 'float',
                                    label: 'Float',
                                    'values': [
                                        {text: 'None', value: 'none'},
                                        {text: 'Left', value: 'left'},
                                        {text: 'Right', value: 'right'}
                                    ]
                                },
                                {
                                    type: 'listbox',
                                    name: 'show_on_mobile',
                                    label: 'Show on Mobile',
                                    'values': [
                                        {text: 'no', value: 'No'},
                                        {text: 'yes', value: 'Yes'}
                                    ]
                                }
                            ],
                            onsubmit: function( e ) {

                                var shortcode = '[scp_separator';

                                shortcode += ' width="' + e.data.width + '"';
                                shortcode += ' height="' + e.data.height + '"';
                                shortcode += ' color="' + e.data.color + '"';
                                shortcode += ' margin="' + e.data.margin + '"';
                                shortcode += ' float="' + e.data.float + '"';
                                shortcode += ' show_on_mobile="' + e.data.show_on_mobile + '"';

                                shortcode += ']';

                                editor.insertContent( shortcode );
                            }
                        });
                    }
                },
            /**
             * Alt Blockquote
             */
                {
                    text: 'Alt Blockquote',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Alt Blockquote',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'width',
                                    label: 'Width',
                                    value: '50%',
                                    tooltip: ''
                                },
                                {
                                    type: 'listbox',
                                    name: 'float',
                                    label: 'Float',
                                    'values': [
                                        {text: 'Left', value: 'left'},
                                        {text: 'Right', value: 'right'}
                                    ]
                                },
                                {
                                    type: 'textbox',
                                    name: 'description',
                                    label: 'Description',
                                    value: 'Description goes here',
                                    multiline: true,
                                    minWidth: 300,
                                    minHeight: 100
                                }
                            ],
                            onsubmit: function( e ) {

                                var shortcode = '[scp_block_quote_alt';

                                shortcode += ' width="' + e.data.width + '"';
                                shortcode += ' float="' + e.data.float + '"';

                                shortcode += ']';
                                shortcode += e.data.description;
                                shortcode += '[/scp_block_quote_alt]';

                                editor.insertContent( shortcode );
                            }
                        });
                    }
                },
                /**
                 * Resposnive Table
                 */
                {
                    text: 'Responsive Table',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Responsive Table',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'columns',
                                    label: 'Table Columns',
                                    value: 'Column 1|Column 2|Column 3',
                                    tooltip: 'pipe separated list of table columns'
                                },
                                {
                                    type: 'textbox',
                                    name: 'number_of_rows',
                                    label: 'Number of rows',
                                    value: '3',
                                    tooltip: 'number of example rows'
                                },
                                {
                                    type: 'textbox',
                                    name: 'table_row',
                                    label: 'Table Row',
                                    value: 'Label 1|Label 2|Label 3',
                                    tooltip: 'pipe separated list of row labels'
                                },
                                {
                                    type: 'textbox',
                                    name: 'column_highlight',
                                    label: 'Higlight Column',
                                    value: '',
                                    tooltip: 'Number of the column to make column labels bold.'
                                }
                            ],
                            onsubmit: function( e ) {

                                var shortcode = '[scp_table';

                                shortcode += ' columns="' + e.data.columns + '"';

                                var column_highlight = parseInt(e.data.column_highlight);
                                if (column_highlight) {
                                    shortcode += ' highlight="' + column_highlight + '"';
                                }

                                shortcode += ']';
                                var number_of_rows = parseInt(e.data.number_of_rows);
                                while (number_of_rows) {
                                    shortcode += '[scp_table_row labels="' + e.data.table_row + '"]';
                                    number_of_rows--;
                                }


                                shortcode += '[/scp_table]';

                                editor.insertContent( shortcode );
                            }
                        });
                    }
                }
            ] // end Theme Shortcodes menu
        });
    });
})();
