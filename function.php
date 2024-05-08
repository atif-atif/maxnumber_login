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
    echo '<div class="wrap" ><h1>Max Number of Logins Page</h1></div>';
    
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
        <select name="search" id="search" multiple size="3">
            <!-- Add more country options here -->
            <option value="Afghanistan">Afghanistan</option>
            <option value="Pakistan">Pakistan</option>

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

<?php
// Define a variable to hold the submitted number
$number = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value of the input field
    $number = $_POST["numberInput"];
    
    // Display the number
    echo "The number you entered is: " . $number;
     // Store the number in the database
     global $wpdb;
     $table_name = $wpdb->prefix . 'login_limit';
     $wpdb->insert(
         $table_name,
         array(
             'max_login_limit' => $number,
         )
     );
}

// Function to check login attempts
function check_login_attempts($username, $password) {
    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Initialize login attempts count for the IP address
    $login_attempts = get_transient('login_attempts_' . $ip_address);
    
    // Fetch the maximum login limit from the database
    global $wpdb;
    $table_name = $wpdb->prefix . 'login_limit';
    $number_row = $wpdb->get_row("SELECT max_login_limit FROM $table_name WHERE id = 1"); // Assuming the max login limit is stored in the row with id 1

    // If the count is not set, initialize it to 1
    if (!$login_attempts) {
        $login_attempts = 1;
    } else {
        // If count is set, increment it
        $login_attempts++;
    }
    
    // Save the updated count with a 24-hour expiration
    set_transient('login_attempts_' . $ip_address, $login_attempts, 24 * HOUR_IN_SECONDS);
    
    // If the maximum login limit is fetched successfully from the database
    if ($number_row) {
        $number = $number_row->max_login_limit;
        
        // If login attempts exceed the fetched number, redirect user to the login page
        if ($login_attempts > $number) {
            wp_redirect(wp_login_url());
            exit;
        }
    }
}
add_action('wp_authenticate', 'check_login_attempts', 10, 2);
?>

<div class='ip-wrap'>
    <form method="post">
    <h1 style= color:white >Max Login Limit</h1>
    <label for="numberInput">Enter the number for Max number of logins:</label>
        <input type="number" id="numberInput" name="numberInput" value="<?php echo $number; ?>">
        <button type="submit">Submit</button>
    </form>
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
                    showdetails.textContent = `The Latitude ${latitude} and The Longitude ${longitude}`;
                  
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
                // Call function to store country in database
                storeCountryInDatabase(data.countryName, latitude, longitude);
            } else {
                userCountry.textContent = 'User Country: Unknown';
            }
        })
        .catch(error => {
            console.error('Error fetching user country:', error);
            userCountry.textContent = 'User Country: Unknown';
        });
    }

    function storeCountryInDatabase(country, latitude, longitude) {
        // AJAX request to store country in database
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log('Country stored in database successfully.');
            }
        };
        xhr.open("POST", "<?php echo admin_url('admin-ajax.php'); ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`action=save_user_location&country=${encodeURIComponent(country)}&latitude=${latitude}&longitude=${longitude}`);
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
$sql_blocked_country = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}blocked_country (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blocked_country VARCHAR(45)
)";
dbDelta($sql_blocked_country);

// SQL query to create the custom table for login limit
$sql_login_limit = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}login_limit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    max_login_limit INT
)";

// Execute the SQL query for login limit table
dbDelta($sql_login_limit);


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








function check_blocked_country_on_login() {
    global $wpdb;

    // SQL query to check if the user's country is blocked
    $query = "
        SELECT 
            wp_blocked_country.blocked_country,
            wp_location_country.user_country
        FROM 
            {$wpdb->prefix}blocked_country AS wp_blocked_country
        JOIN 
            {$wpdb->prefix}location_country AS wp_location_country 
        ON 
            wp_blocked_country.blocked_country = wp_location_country.user_country
    ";

    // Execute the query
    $results = $wpdb->get_results($query);

    // Check if any rows are returned
    if ($results) {
        // Display message indicating that the user's country is blocked
        echo "Your country has been blocked by admin.";
        exit; // Stop further execution
    }
}

// Hook the function to run when the login button is clicked
add_action('wp_login', 'check_blocked_country_on_login');




// ajax call
// Hook for handling AJAX request to save user location
add_action('wp_ajax_save_user_location', 'save_user_location_callback');
function save_user_location_callback() {
    global $wpdb;
    
    // Get country, latitude, and longitude from AJAX request
    $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
    $latitude = isset($_POST['latitude']) ? sanitize_text_field($_POST['latitude']) : '';
    $longitude = isset($_POST['longitude']) ? sanitize_text_field($_POST['longitude']) : '';

    // Insert data into location_country table
    $result = $wpdb->insert(
        $wpdb->prefix . 'location_country',
        array(
            'user_country' => $country,
            'user_latitude' => $latitude,
            'user_longitude' => $longitude
        )
    );

    // Check for errors during database insertion
    if ($result === false) {
        // If insertion fails, send error response
        $response = array('error' => 'Database insertion failed.');
        wp_send_json_error($response);
    } else {
        // If insertion succeeds, send success response
        $response = array('success' => 'Data inserted successfully.');
        wp_send_json_success($response);
    }
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
   
        border: 2px solid #000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 600px;
        background-color: #808080;
        border-radius: 15px;
        margin: 0 auto;
        margin-bottom: 50px;
        margin-top: 30px;
        
    }

    h1 {
        margin-bottom: 20px;
        font-size: 36px;
        font-weight: bold;
    }

    label {
        margin-bottom: 8px;
        color: white;
        display: block; 
    }

    input[type="text"],
    select {
        border: 1px solid #ccc;
        width: 100%;
        margin-bottom: 20px;
        padding: 10px;
        box-sizing: border-box;
        border-radius: 4px;
        
    }

    input[type="text"][readonly] {
        background-color: #f3f3f3;
    }

    button {
        border-radius: 4px;
        padding: 10px 20px;
       border-radius: 30px;
        color: #fff;
        background-color: #2c3e50;
        border: none;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #1a252f;
    }

    .ip-wrap {
        border: 2px solid #000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 600px;
        background-color: #808080;
        border-radius: 15px;
        margin: 0 auto;
    }
</style>