<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Profiles
    |--------------------------------------------------------------------------
    |
    | You can add as many as you want of profiles to use it in your application.
    |
    */



    'profiles' => [

        'default' => [
            'plugins' => 'advlist autoresize codesample code directionality emoticons hr tabfocus image imagetools pagebreak link lists media table toc wordcount template',
            'toolbar' => ' code undo redo removeformat | formatselect fontsizeselect | bold italic | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist | forecolor backcolor | blockquote pagebreak table toc hr | image link media emoticons | fullscreen template',
            'upload_directory' => null,
            'images_reuse_filename' => true,
            'automatic_uploads' => false,
            'image_upload_url' => '/convert',
            'custom_configs' => [
                'image_advtab' => true,
            ]

        ],

        'simple' => [
            'plugins' => 'autoresize directionality emoticons link wordcount',
            'toolbar' => 'removeformat | bold italic | rtl ltr | link emoticons',
            'upload_directory' => null,
        ],

        'template' => [
            'plugins' => 'autoresize template',
            'toolbar' => 'template',
            'upload_directory' => null,
        ],
        /*
        |--------------------------------------------------------------------------
        | Custom Configs
        |--------------------------------------------------------------------------
        |
        | If you want to add custom configurations to directly tinymce
        | You can use custom_configs key as an array
        |
        */

        'grid' =>
            [
                'type' => 'grid', // component type
                'columns' => 2, // number of columns
                'items' => [ '<p>Hi</p>' ] // array of panel components
            ],

        'image_class_list' => [
            [
                'title' => 'None',
                'value' => '',
            ],
            [
                'title' => 'Fluid',
                'value' => 'img-fluid',
            ]
        ],

        /*
          'default' => [
            'plugins' => 'advlist autoresize codesample directionality emoticons fullscreen hr image imagetools link lists media table toc wordcount',
            'toolbar' => 'undo redo removeformat | formatselect fontsizeselect | bold italic | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen',
            'custom_configs' => [
                'allow_html_in_named_anchor' => true,
                'link_default_target' => '_blank',
                'codesample_global_prismjs' => true,
                'image_advtab' => true,
                'image_class_list' => [
                  [
                    'title' => 'None',
                    'value' => '',
                  ],
                  [
                    'title' => 'Fluid',
                    'value' => 'img-fluid',
                  ],
              ],
            ]
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    | You can add as many as you want of templates to use it in your application.
    |
    | https://www.tiny.cloud/docs/plugins/opensource/template/#templates
    |
    | ex: TinyEditor::make('content')->profiles('template')->template('example')
    */

        'templates' => [

            'example' => [
                [
                    'title' => 'Button', 'description' => 'Standard button used on the website', 'content' =>
                    '<button
                        value="Save Task"
                        type="submit"
                        :href="slider.sliderButtonLink"
                        size="x-large"
                        class="v-btn v-btn--elevated v-theme--customDarkTheme v-btn--density-default v-btn--size-x-large v-btn--variant-elevated bg-secondary text-center mt-5 text-white font-bold text-15pt no-underline max-w-full overflow-hidden whitespace-nowrap text-left text-ellipsis" >
                        Button
                    </button>'
                ],
                ['title' => 'Blue subtitle', 'description' => 'Blue subtitle used as standard in paragraphs', 'content' => '<p style="color: #005ba9;font-size: 18pt;" class="text-primary">Blue subtitle</p>'],
                ['title' => 'Orange subtitle', 'description' => 'Orange subtitle used as variant in paragraphs', 'content' => '<p style="color: #e04218;font-size: 18pt;" class="text-secondary">Orange subtitle</p>'],
            ],

    ],
];
