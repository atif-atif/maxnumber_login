<?php
/*
Plugin Name: Login press Maxnumber
Description: A simple Login press Maxnumber
Version: 1.0
Author: Manal Kashif, Muhammad Atif, Muhammad Ahmed.
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
    //$loc = get_location_details('101.36.115.255');
    // print_r($loc['data']['country_name']);
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
    if ($login_attempts > 5) {
        wp_redirect(wp_login_url());
        exit;
    }
}
add_action('wp_authenticate', 'check_login_attempts', 100, 2);

// Function to get location details based on IP address
function get_location_details($ip) {
    $location_details = array();
    try {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.iplocation.net/?ip={$ip}");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $execute = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($execute);

        if ($result && $result->response_code === '200') {
            if ($result->country_name !== '-' && $result->country_code2 !== '-') {
                $location_details['response_code']        = $result->response_code;
                $location_details['message']              = 'Success';
                $location_details['data']['country_name'] = $result->country_name;
                $location_details['data']['country_code'] = $result->country_code2;
            } else {
                $missing_info = array();
                if ($result->country_name === '-') {
                    $missing_info[] = 'country_name';
                }
                if ($result->country_code2 === '-') {
                    $missing_info[] = 'country_code';
                }
                $location_details['response_code'] = '400';
                $location_details['message']       = 'Error: Missing information for ' . implode(', ', $missing_info) . ' for the IP Address: ' . $ip;
            }
        } else {
            $location_details['response_code'] = '400';
            $location_details['message']       = 'Error: Invalid response code or data for the IP Address: ' . $ip;
        }

        return $location_details;
    } catch (\Exception $e) {
        $location_details['response_code'] = '400';
        $location_details['message']       = 'Error: ' . $e->getMessage();
        return $location_details;
    }
}




function restrict_admin_by_location() {
    // Get the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];
    // $user_ip = '142.154.127.255';
    // Replace this with your preferred method to get user location
    $user_location = (get_location_details($user_ip));
    
    // Define allowed locations (e.g., country codes)
    $allowed_locations = array('United States of America', 'Pakistan', ''); // Example: Allow access only from the US and pakistan

    // Check if the user's location is not in the allowed locations
    if (!in_array(isset($user_location['data']['country_name']), $allowed_locations)) {
        // Redirect user to a custom page or display an error message
        // wp_redirect(home_url('/location-error'));
        wp_die( 'You are not allowed' );
        exit;
    }
}

// Hook into WordPress admin_init action to run the function
add_action('admin_init', 'restrict_admin_by_location');
?>