<?php

/**
 * Plugin Name: Shortcode Plugin
 * Description: This plugin adds a simple shortcode.
 * Author: Donald Folayan
 * Version: 1.0
 * Author URI: https://www.github.com/donfolayan
 * Plugin URI: https://www.github.com/donfolayan/wp_plugin_practice/shortcode-plugin
 */

 // Basic Shortcode

 add_shortcode("message", "sp_show_static_message");

 function sp_show_static_message(){
    return "Hello, I am a static message from the Shortcode Plugin!";
 }

 // Shortcode with attributes

add_shortcode("student", "sp_handle_student_data");

function sp_handle_student_data($attributes){
    $attr = shortcode_atts(array(
        "name" => "Default Name",
        "email" => "default@mail.com"
    ), $attributes, "student");

    return "<h2>Student Data:</h2>
             <p>Name- {$attr['name']},<br> 
             Email- {$attr['email']}</p>";
}

// Shortcode with dynamic content
add
