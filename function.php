<?php
/*
Plugin Name: Login press Maxnumber
Description: A simple Login press Maxnumber
Version: 1.0
Author:
*/
function max_number_login_menu() {
    add_menu_page('Max Number of Logins', 'Max Logins', 'manage_options', 'max-number-login', 'wpml_max_number_login_page');
}
add_action('admin_menu', 'max_number_login_menu');

function wpml_max_number_login_page() {
    echo '<div class="wrap"><h1>Max Number of Logins Page</h1><p>This is a placeholder page for managing the maximum number of logins.</p></div>';
}

// Connect to the WordPress database
global $wpdb;

// SQL query to create the custom table
$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}login_ips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ip_address VARCHAR(45),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the SQL query
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

function capture_user_login_ip($user_login, $user) {
    global $wpdb;
    
    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Insert IP address into custom table
    $wpdb->insert(
        'wp_login_ips',
        array(
            'user_id' => $user->ID,
            'ip_address' => $ip_address
        ),
        array('%d', '%s')
    );
}
add_action('wp_login', 'capture_user_login_ip', 10, 2);

function check_login_attempts($username, $password) {
    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Initialize login attempts count for the IP address
    $login_attempts = get_transient('login_attempts_' . $ip_address);
    
    // If the count is not set, initialize it to 1
    if (!$login_attempts) {
        $login_attempts = 1;
    } else {
        // If count is set, increment it
        $login_attempts++;
    }
    
    // Save the updated count with a 24-hour expiration
    set_transient('login_attempts_' . $ip_address, $login_attempts, 24 * HOUR_IN_SECONDS);
    
    // If login attempts exceed 10, redirect user to the login page
    if ($login_attempts > 10) {
        wp_redirect(wp_login_url());
        exit;
    }
}
add_action('wp_authenticate', 'check_login_attempts', 10, 2);
?>
