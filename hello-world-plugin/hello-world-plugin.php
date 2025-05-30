<?php

/**
 * Plugin Name: Hello World Plugin
 * Description: This plugin displays a "Hello World" message on the WordPress site.
 * Author: Donald Folayan
 * Version: 1.0
 * Author URI: https://www.github.com/donfolayan
 * Plugin URI: https://www.github.com/donfolayan/wp_plugin_practice
 */

// Admin notices

 add_action("admin_notices", "hw_show_information_message");

 function hw_show_success_message(){
    echo "<div class='notice notice-success is-dismissible'><p> Hello, I am a success message </p></div>";
 }

  function hw_show_error_message(){
    echo "<div class='notice notice-error is-dismissible'><p> Hello, I am an error message </p></div>";
 }

 function hw_show_information_message(){
    echo "<div class='notice notice-info is-dismissible'><p> Hello, I am an informational message </p></div>";
 }

 function hw_show_warning_message(){
    echo "<div class='notice notice-warning is-dismissible'><p> Hello, I am a warning message </p></div>";
 }

 // Admin Dashboard Widget
  add_action("wp_dashboard_setup", "hw_hello_world_dashboard_widget");
  
 function hw_hello_world_dashboard_widget() {
   wp_add_dashboard_widget(
      "hw_hello_world",
      "Hello World Widget",
      "hw_custom_admin_widget"
   );
 }

 function hw_custom_admin_widget(){
   echo "<p>Hello, World! This is your dashboard widget.</p>";
 }