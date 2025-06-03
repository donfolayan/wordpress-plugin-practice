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

// Shortcode with DB Operation

function sp_list_posts(){

    global $wpdb;

    $table_name = $wpdb->prefix . "posts";
    $posts = $wpdb->get_results("SELECT * FROM $table_name WHERE post_status = 'publish' && post_type = 'post'");
    if (empty($posts)) {
        return "<p>No posts found.</p>";
    } else {
        $outputHtml = "<ul>";

        foreach ($posts as $post){
            $outputHtml .= "<li>" . $post->post_title . "</li>";
        }
    }
    $outputHtml .= "</ul>";
    return $outputHtml;
    
}

function sp_list_post_with_wp_posts($attributes){
    $attr = shortcode_atts(array(
        "number" => 5
    ), $attributes, "list_posts");

    $query = new WP_Query(array(
        "post_type" => "post",
        "posts_per_page" => $attr['number'],
        "post_status" => "publish"
    ));
    
    if ($query->have_posts()){

        $outputHtml = "<ul>";
        while ($query->have_posts()) {
            $query->the_post();
            $outputHtml .= "<li><a href='". get_the_permalink() . "'>" . get_the_title() ."</a></li>";
        }
        $outputHtml .= "</ul>";
        return $outputHtml;
    } else {
        return "<p>No posts found.</p>";
    }
}

add_shortcode("list_posts", "sp_list_post_with_wp_posts");