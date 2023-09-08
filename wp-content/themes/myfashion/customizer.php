<?php
// Sanitize text
function sanitize_text($text)
{
    return sanitize_text_field($text);
}

function add_input($wp_customize, $type, $section, $name, $title)
{
    $wp_customize->add_setting($name, array(
        // 'default'           => __('Title', 'theme-name'),
        'sanitize_callback' => 'sanitize_text'
    ));
    if ($type == 'text') {
        // Add control
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                $name,
                array(
                    'label'    => $title,
                    'section'  => $section,
                    'settings' => $name,
                    'type'     => 'text'
                )
            )
        );
    } elseif ($type == 'media') {
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                $name,
                array(
                    'label'    => $title,
                    'section'  => $section,
                    'settings' => $name,
                )
            )
        );
    }
}

function theme_name_register_theme_customizer($wp_customize)
{
    // Create custom panel.
    $wp_customize->add_panel('home', array(
        'priority'       => 10,
        'theme_supports' => '',
        'title'          => __('Home', 'theme_name'),
    ));
    // Add section.
    $wp_customize->add_section('banner', array(
        'title'    => __('Banner', 'theme-name'),
        'panel'    => 'home',
        'priority' => 10
    ));

    for ($i = 1; $i < 10; $i++) {
        add_input($wp_customize, 'text', 'banner', 'banner_title_' . $i, 'Title ' . $i);
        add_input($wp_customize, 'media', 'banner', 'banner_image_' . $i, 'Image ' . $i);
    }

    $wp_customize->add_section('category', array(
        'title'    => __('Category', 'theme-name'),
        'panel'    => 'home',
        'priority' => 10
    ));

    for ($i = 1; $i < 3; $i++) {
        add_input($wp_customize, 'text', 'category', 'category_name_' . $i, 'Name ' . $i);
        add_input($wp_customize, 'media', 'category', 'category_image_' . $i, 'Image ' . $i);
    }
}
add_action('customize_register', 'theme_name_register_theme_customizer');
