<?php
/*
Plugin Name: Login press Maxnumber
Description: A simple Login press Maxnumber
Version: 1.0
Author:
*/

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'wpbcv_plugin_activation');
register_deactivation_hook(__FILE__, 'wpbcv_plugin_deactivation');

// Enqueue necessary scripts and styles
function wpbcv_csv_management_enqueue_scripts() {
    // wp_enqueue_style('csv-management-style', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('csv-management-script', plugins_url('/js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'wpbcv_csv_management_enqueue_scripts');

function max_number_login_menu() {
    add_menu_page('Max Number of Logins', 'Max Logins', 'manage_options', 'max-number-login', 'wpbcv_max_number_login_page');
}
add_action('admin_menu', 'max_number_login_menu');

// Placeholder function for the menu page
function wpbcv_max_number_login_page() {
    echo '<div class="wrap"><h1>Max Number of Logins Page</h1><p>This is a placeholder page for managing the maximum number of logins.</p></div>';
}

// Function to create database table on plugin activation
function wpbcv_plugin_activation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wp_table';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        username varchar(255) NOT NULL,
        ip_address varchar(100) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Function to drop database table on plugin deactivation
function wpbcv_plugin_deactivation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wp_table';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

class LoginAttemptTracker {
    const MAX_LOGIN_ATTEMPTS = 5;
    const TIME_WINDOW = 3600; // 1 hour in seconds

    public function trackLoginAttempt($username, $ip_address) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp_table';

        // Check if login attempts for the IP address are within the limit
        $attempts_count = $this->getLoginAttemptsCount($ip_address, self::TIME_WINDOW);
        if ($attempts_count < self::MAX_LOGIN_ATTEMPTS) {
            $wpdb->insert($table_name, array('username' => $username, 'ip_address' => $ip_address));
        } else {
            // Return a message indicating login limit exceeded
            echo "Login attempt blocked. Maximum login attempts exceeded.";
        }
    }

    public function getLoginAttemptsCount($ip_address, $time_window) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp_table';
        $current_time = time();
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE ip_address = %s AND timestamp >= %s", $ip_address, date('Y-m-d H:i:s', $current_time - $time_window));
        $attempts_count = $wpdb->get_var($sql);
        return $attempts_count;
    }

    public function resetLoginAttempts($ip_address) {
        // Implement your logic to reset attempts count in database here
    }
}

class LoginProcessor {
    private $tracker;

    public function __construct() {
        $this->tracker = new LoginAttemptTracker();
    }

    public function processLogin($username, $password, $ip_address) {
        $this->tracker->trackLoginAttempt($username, $ip_address);
        // Implement your login processing logic here
    }
}

// Hook into the wp_login action to fetch the IP address when a user logs in
add_action('wp_login', 'my_custom_login_function', 10, 2);

function my_custom_login_function($user_login, $user) {
    // Get the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Create an instance of the LoginProcessor class
    $loginProcessor = new LoginProcessor();

    // Process login using the fetched IP address
    $result = $loginProcessor->processLogin($user_login, '', $user_ip);

    // Output the result
    echo $result . "\n";
}
?>
