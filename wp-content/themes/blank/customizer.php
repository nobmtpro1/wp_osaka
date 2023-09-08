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
                    'label'    =>  $title,
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
                    'label'    =>  $title,
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
    $wp_customize->add_panel('footer', array(
        'priority'       => 10,
        'theme_supports' => '',
        'title'          => __('Footer', 'theme_name'),
    ));
    // Add section.
    $wp_customize->add_section('col1', array(
        'title'    => __('Cột 1', 'theme-name'),
        'panel'    => 'footer',
        'priority' => 10
    ));
    add_input($wp_customize, 'text', 'col1', 'footer_col1_title', 'Tiêu đề');
    add_input($wp_customize, 'text', 'col1', 'footer_col1_description', 'Mô tả');
    // Add section.
    $wp_customize->add_section('col2', array(
        'title'    => __('Cột 2', 'theme-name'),
        'panel'    => 'footer',
        'priority' => 10
    ));
    add_input($wp_customize, 'text', 'col2', 'footer_col2_title', 'Tiêu đề');
    for ($i = 1; $i < 10; $i++) {
        add_input($wp_customize, 'text', 'col2', 'footer_col2_link_name_' . $i, 'Tên link ' . $i);
        add_input($wp_customize, 'text', 'col2', 'footer_col2_link_' . $i, 'Link ' . $i);
    }
    // Add section.
    $wp_customize->add_section('col3', array(
        'title'    => __('Cột 3', 'theme-name'),
        'panel'    => 'footer',
        'priority' => 10
    ));
    add_input($wp_customize, 'text', 'col3', 'footer_col3_title', 'Tiêu đề');
    for ($i = 1; $i < 10; $i++) {
        add_input($wp_customize, 'text', 'col3', 'footer_col3_link_name_' . $i, 'Tên link ' . $i);
        add_input($wp_customize, 'text', 'col3', 'footer_col3_link_' . $i, 'Link ' . $i);
    }

    // Add section.
    $wp_customize->add_section('col4', array(
        'title'    => __('Cột 4', 'theme-name'),
        'panel'    => 'footer',
        'priority' => 10
    ));
    add_input($wp_customize, 'text', 'col4', 'footer_col4_title', 'Tiêu đề');
    for ($i = 1; $i < 10; $i++) {
        add_input($wp_customize, 'text', 'col4', 'footer_col4_link_name_' . $i, 'Tên link ' . $i);
        add_input($wp_customize, 'text', 'col4', 'footer_col4_link_' . $i, 'Link ' . $i);
    }

    // Add section.
    $wp_customize->add_section('copyright', array(
        'title'    => __('Copy right', 'theme-name'),
        'panel'    => 'footer',
        'priority' => 10
    ));
    add_input($wp_customize, 'text', 'copyright', 'footer_copyright', 'copyright');
}
add_action('customize_register', 'theme_name_register_theme_customizer');
