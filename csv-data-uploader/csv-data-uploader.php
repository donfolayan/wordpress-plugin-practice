<?php

/**
 * Plugin Name: CSV Data Uploader
 * Description: A plugin to upload and process CSV data.
 * Author: Donald Folayan
 * Version: 1.0
 * Author URI: https://www.github.com/donfolayan
 * Plugin URI: https://www.github.com/donfolayan/wp_plugin_practice/csv-data-uploader
 */


 define('CDU_PLUGIN_DIR', plugin_dir_path(__FILE__));

 function cdu_display_csv_uploader_form(){

    
    ob_start(); // Start php buffer

    include_once CDU_PLUGIN_DIR . 'template/cdu_form.php';

    // Get the content from the buffer and clean the buffer
    $template = ob_get_contents();
    ob_end_clean();

    return $template;

}

 add_shortcode("csv_uploader", "cdu_display_csv_uploader_form");

 //DB Table on plugin activation
function cdu_create_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . "csv_data";
    $table_collate = $wpdb->get_charset_collate();
    $sql = "
        CREATE TABLE " . $table_name ." (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) DEFAULT NULL,
        `email` varchar(50) DEFAULT NULL,
        `age` int(5) DEFAULT NULL,
        `phone` varchar(30) DEFAULT NULL,
        `photo` varchar(120) DEFAULT NULL,
        PRIMARY KEY (`id`)
        )" . $table_collate ."
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

 register_activation_hook(__FILE__, 'cdu_create_table');

 // Add script file

 function cdu_enqueue_scripts(){
    // C:\xampp\htdocs\wp\wp_plugin_practice\wp-content\plugins\csv-data-uploader\assets\js\scripts.js
    wp_enqueue_script('cdu-script', plugin_dir_url(__FILE__) . '/assets/js/scripts.js', array('jquery'));
    wp_localize_script('cdu-script', 'cdu_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
 
 add_action('wp_enqueue_scripts', 'cdu_enqueue_scripts');


 // Handle the AJAX request


function cdu_handle_csv_upload(){


    if($_FILES['csv_data_file']){

        $csvFile = $_FILES['csv_data_file']['tmp_name'];
        $handle = fopen($csvFile, 'r');

        global $wpdb;
        $table_name = $wpdb->prefix . "csv_data";

        if ($handle){

            $row = 0;
            while ($data = fgetcsv($handle, 1000, ',')) {

                if ($row == 0) {
                    $row++;
                    continue;
                }
                
                // Sanitize and validate the data
                if (count($data) < 5) {
                    continue; // Skip rows with insufficient data
                }
                $name = sanitize_text_field($data[1]);
                $email = sanitize_email($data[2]);
                $age = intval($data[3]);
                $phone = sanitize_text_field($data[4]);
                $photo = sanitize_text_field($data[5]);

                global $wpdb;
                $table_name = $wpdb->prefix . "csv_data";

                // Insert data into the database
                $wpdb->insert(
                    $table_name,
                    array(
                        'name' => $name,
                        'email' => $email,
                        'age' => $age,
                        'phone' => $phone,
                        'photo' => $photo
                    )
                );
            }
            
            fclose($handle);
            echo json_encode(array(
                'status' => 1,
                'message' => 'CSV data uploaded successfully.'
            ));
        }

    } else{

        echo json_encode(array(
            'status' => 0,
            'message' => 'No file uploaded.'
        ));

    }

}

 add_action('wp_ajax_cdu_submit_csv_data', 'cdu_handle_csv_upload'); // logged-in users
 add_action('wp_ajax_nopriv_cdu_submit_csv_data', 'cdu_handle_csv_upload'); // logged-out users