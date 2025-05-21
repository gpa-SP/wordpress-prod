<?php
// Cargar fonts.css en el frontend
function custom_enqueue_fonts() {
    wp_enqueue_style('custom-fonts', get_stylesheet_directory_uri() . '/fonts/fonts.css');
}
add_action('wp_enqueue_scripts', 'custom_enqueue_fonts');

/*
// Registrar fuentes personalizadas para Elementor en el hook adecuado
add_action('init', function () {
    add_filter('elementor/fonts/additional_fonts', function($fonts) {
        $fonts['Lato'] = [
            '400' => get_stylesheet_directory_uri() . '/fonts/Lato Regular.ttf',
            '700' => get_stylesheet_directory_uri() . '/fonts/Lato Bold.ttf',
            '400italic' => get_stylesheet_directory_uri() . '/fonts/Lato Italic.ttf',
        ];
        $fonts['HWT Artz'] = [
            '400' => get_stylesheet_directory_uri() . '/fonts/HWT Artz Regular.ttf',
        ];
        $fonts['Zooja'] = [
            '400' => get_stylesheet_directory_uri() . '/fonts/Zooja Pro Regular.ttf',
        ];
        return $fonts;
    });
});
*/
