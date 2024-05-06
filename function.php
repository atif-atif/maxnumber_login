<?php
/*
Plugin Name: Login press Maxnumber
Description: A simple Login press Maxnumber
Version: 1.0
Author:  Manal Kashif, Muhammad Atif, Muhammad Ahmed.
*/


function max_number_login_menu() {
    add_menu_page('Max Number of Logins', 'Max Logins', 'manage_options', 'max-number-login', 'wpml_max_number_login_page');
}
add_action('admin_menu', 'max_number_login_menu');

function wpml_max_number_login_page() {
    echo '<div class="wrap"><h1>Max Number of Logins Page</h1><p>This is a placeholder page for managing the maximum number of logins.</p></div>';
    
    ?>
    <div class='table-wrap'>
    <h1 style= color:white >Location Country</h1>

    <!-- Country Selection -->
    <div>
        <label for="selected-countries">Selected Countries:</label>
        <input type="text" id="selected-countries" name="selected_countries">
    </div>

    <!-- Search Form -->
    <form id="search-form" method="GET" action="">
        <label for="search">Select Blocked Country Location:</label>
        <select name="search" id="search" multiple size="5">
            <!-- Add more country options here -->
            <option value="Afghanistan">Afghanistan</option>
            <option value="Uganda">Uganda</option>
            <option value="Ukraine">Ukraine</option>
            <option value="United Arab Emirates">United Arab Emirates</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="United States">United States</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Uzbekistan">Uzbekistan</option>
            <option value="Vanuatu">Vanuatu</option>
            <option value="Vatican City">Vatican City</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Vietnam">Vietnam</option>
            <option value="Yemen">Yemen</option>
            <option value="Zambia">Zambia</option>
            <option value="Zimbabwe">Zimbabwe</option>
        </select>
        <div>
            <button type="button" id="add-country-btn" style="display: none;">Add Country</button>
            <button type="submit" id="finalize-btn" style="display: none;">Blocked Selected Countries</button>
        </div>
    </form>

    <button class="geo-btn">Show User Location</button>
    <p style= color:white  class="showdetails">User Location Details</p>
    <!-- User Country -->
    <p style= color:white class="usercountry">User Country</p>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $('#finalize-btn').click(function(){
        var selectedCountries = $('#selected-countries').val();

        // Send data to server using AJAX
        $.ajax({
            url: window.location.href, // Same page URL
            method: 'POST',
            data: {selected_countries: selectedCountries},
            success: function(response){
                // You can handle success here if needed
            },
            error: function(xhr, status, error){
                console.error('Error:', error);
            }
        });
    });
});
</script>

<?php
// Include WordPress functionality if needed
// require_once('wp-load.php');

// Handle form submission
if(isset($_POST['selected_countries'])) {
    $selectedCountries = explode(',', $_POST['selected_countries']); // Split multiple countries into an array
    
    // Assuming you're using WordPress and $wpdb is available
    global $wpdb;
    
    // Insert data into the database
    foreach ($selectedCountries as $country) {
        $country = trim($country); // Remove extra whitespace
        $sql = $wpdb->prepare ("INSERT INTO {$wpdb->prefix}blocked_country (blocked_country) VALUES (%s)", $country);
        $wpdb->query($sql);
    }
    
    // You can also perform additional error handling or validation here
    echo "<script>alert('Countries blocked successfully!');</script>";
}
?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectedCountries = [];

        // Add event listener for selecting countries
        document.getElementById('search').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption) {
                var countryName = selectedOption.text;
                selectedCountries.push(countryName);
                updateSelectedCountries();
                this.selectedIndex = -1; // Reset dropdown
            }
        });

        // Function to update selected countries display
        function updateSelectedCountries() {
            var selectedCountriesField = document.getElementById('selected-countries');
            selectedCountriesField.value = selectedCountries.join(', ');
            toggleButtons();
        }

        // Function to toggle buttons based on selected countries
        function toggleButtons() {
            var addCountryBtn = document.getElementById('add-country-btn');
            var finalizeBtn = document.getElementById('finalize-btn');
            if (selectedCountries.length > 0) {
                addCountryBtn.style.display = 'inline-block';
                finalizeBtn.style.display = 'inline-block';
            } else {
                addCountryBtn.style.display = 'none';
                finalizeBtn.style.display = 'none';
            }
        }

        // Add event listener for adding countries
        document.getElementById('add-country-btn').addEventListener('click', function() {
            var searchInput = document.getElementById('search');
            var selectedOption = searchInput.options[searchInput.selectedIndex];
            if (selectedOption) {
                var countryName = selectedOption.text;
                selectedCountries.push(countryName);
                updateSelectedCountries();
                searchInput.selectedIndex = -1; // Reset dropdown
            }
        });

        // Add event listener for finalizing selected countries
        // document.getElementById('finalize-btn').addEventListener('click', function() {
        //     // You can perform any action here with the selected countries
        //     alert('Selected countries: ' + selectedCountries.join(', '));
        //     // For now, just reset the selected countries array and update the display
        //     selectedCountries = [];
        //     updateSelectedCountries();
        // });
    });
</script>
<!-- Location script -->
<script>
        const showdetails = document.querySelector(".showdetails");
        const userCountry = document.querySelector(".usercountry");

        document.querySelector('.geo-btn').addEventListener('click', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const { latitude, longitude } = position.coords;
                        showdetails.textContent = `The latitude ${latitude} and longitude ${longitude}`;
                        
                        // Fetch user country
                        fetchUserCountry(latitude, longitude);
                    },
                    (error) => {
                        showdetails.textContent = error.message;
                        console.log(error.message);
                    }
                );
            }
        });

        function fetchUserCountry(latitude, longitude) {
            fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`)
            .then(response => response.json())
            .then(data => {
                if (data.countryName) {
                    userCountry.textContent = `User Country: ${data.countryName}`;
                } else {
                    userCountry.textContent = 'User Country: Unknown';
                }
            })
            .catch(error => {
                console.error('Error fetching user country:', error);
                userCountry.textContent = 'User Country: Unknown';
            });
        }
    </script>

    <!-- ajax script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.geo-btn').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    
                    // Send latitude and longitude to backend using AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            var response = JSON.parse(this.responseText);
                            document.querySelector('.showdetails').innerHTML = 'User Location Details:';
                            document.querySelector('.usercountry').innerHTML = 'User Country: ' + response.country;
                        }
                    };
                    xhr.open("POST", "<?php echo admin_url('admin-ajax.php'); ?>", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("action=save_user_location&latitude=" + latitude + "&longitude=" + longitude);
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });
    });
</script>

<?php
}

// Connect to the WordPress database
global $wpdb;

// SQL query to create the custom table for login IPs
$sql_login_ips = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}login_ips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ip_address VARCHAR(45),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the SQL query for login IPs table
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql_login_ips);

// SQL query to create the custom table for location country
$sql_location_country = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}location_country (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_country VARCHAR(45),
    user_latitude VARCHAR(45),
    user_longitude VARCHAR(45)
)";

// Execute the SQL query for location country table
dbDelta($sql_location_country);


// SQL query to create the custom table for blocked country
$sql_location_country = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}blocked_country (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blocked_country VARCHAR(45)
)";




// Function to capture user login IP and insert into login_ips table
function capture_user_login_ip($user_login, $user) {
    global $wpdb;
    
    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Insert IP address into login_ips table
    $wpdb->insert(
        $wpdb->prefix . 'login_ips',
        array(
            'user_id' => $user->ID,
            'ip_address' => $ip_address
        ),
        array('%d', '%s')
    );
}
add_action('wp_login', 'capture_user_login_ip', 10, 2);

// ajax call
// Hook for handling AJAX request to save user location
add_action('wp_ajax_save_user_location', 'save_user_location_callback');
function save_user_location_callback() {
    global $wpdb;
    
    // Get latitude, longitude, and user country from AJAX request
    $latitude = sanitize_text_field($_POST['latitude']);
    $longitude = sanitize_text_field($_POST['longitude']);
    
    // Get user country based on latitude and longitude
    $user_country = get_country_from_coords($latitude, $longitude);
    
    // Insert data into location_country table
    $wpdb->insert(
        $wpdb->prefix . 'location_country',
        array(
            'user_country' => $user_country,
            'user_latitude' => $latitude,
            'user_longitude' => $longitude
        ),
        array('%s', '%s', '%s')
    );
    
    // Send response back to the JavaScript
    $response = array('country' => $user_country);
    wp_send_json($response);
}

// Function to get user's country based on latitude and longitude
function get_country_from_coords($latitude, $longitude) {
    // Use your method to determine the country from latitude and longitude
    // Example: You can use a third-party API like https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=40.7128&longitude=-74.0060
    // Replace the API call with your actual method to get the country
    // Parse the API response to extract the country
    // Return the country name
    return 'Country'; // Example country, replace with actual country name
}
// Function to capture user location country and insert into location_country table
function capture_user_location_country($user_login, $user) {
    global $wpdb;
    
    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Define user country, latitude, and longitude (Replace with your logic to get these values)
    $user_country = "country";
    $user_latitude = "latitude";
    $user_longitude = "longitude";
    
    // Insert data into location_country table
    $wpdb->insert(
        $wpdb->prefix . 'location_country',
        array(
            'user_country' => $user_country,
            'user_latitude' => $user_latitude,
            'user_longitude' => $user_longitude
        ),
        array('%s', '%s', '%s')
    );
}
add_action('wp_login', 'capture_user_location_country', 10, 2);



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
    var_dump($user_ip);

    // Get selected countries from the form
    $selected_countries = isset($_GET['selected-countries']) ? $_GET['selected-countries'] : 'No Country Selected';

    // Get user location details
    $user_location = get_location_details($user_ip);

    // Check if the user's country is in the selected countries list
    if (!empty($selected_countries) && isset($user_location['data']['country_name']) && in_array($user_location['data']['country_name'], $selected_countries)) {
        // If user's country is in the blocked countries list, display a message and exit
        wp_die('Your location is blocked.');
        exit;
    }
}


// Hook into WordPress admin_init action to run the function
add_action('admin_init', 'restrict_admin_by_location');
?>

<style>
    .table-wrap {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #808080;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: white;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="text"][readonly] {
        background-color: #f3f3f3;
    }

    button {
        padding: 10px 20px;
        background-color: #2c3e50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }

    button:hover {
        background-color: #1a252f;
    }
</style>
























