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
  ?>
   <div class='table-wrap'>
    <h1 style="font-size: 50px; font-weight: bold;">Location Country</h1>

    <!-- Country Selection -->
    <div>
        <label for="selected-countries">Selected Countries:</label>
        <input type="text" id="selected-countries">
    </div>

    <!-- Search Form -->
    <form id="search-form" method="GET">
        <label for="search">Select Blocked Country Location:</label>
        <select name="search" id="search" multiple size="5">
        <option value="Afghanistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Antigua and Barbuda">Antigua and Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cabo Verde">Cabo Verde</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
<option value="Congo, Republic of the">Congo, Republic of the</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic (Czechia)">Czech Republic (Czechia)</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor (Timor-Leste)">East Timor (Timor-Leste)</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Eswatini">Eswatini</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Greece">Greece</option>
<option value="Grenada">Grenada</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guinea-Bissau">Guinea-Bissau</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Honduras">Honduras</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Ivory Coast">Ivory Coast</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Kosovo">Kosovo</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Madagascar">Madagascar</option>
<option value="Malawi">Malawi</option>
<option value="Malaysia">Malaysia</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mexico">Mexico</option>
<option value="Micronesia">Micronesia</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montenegro">Montenegro</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar (Burma)">Myanmar (Burma)</option>
<option value="Namibia">Namibia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherlands">Netherlands</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="North Korea">North Korea</option>
<option value="North Macedonia (formerly Macedonia)">North Macedonia (formerly Macedonia)</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau">Palau</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Philippines">Philippines</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Qatar">Qatar</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
<option value="Saint Lucia">Saint Lucia</option>
<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
<option value="Samoa">Samoa</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome and Principe">Sao Tome and Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="South Korea">South Korea</option>
<option value="South Sudan">South Sudan</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad and Tobago">Trinidad and Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Tuvalu">Tuvalu</option>
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
        <button type="button" id="add-country-btn" style="display: none;">Add Country</button>
        <button type="submit" id="finalize-btn" style="display: none;">Blocked Selected Countries</button>
    </form>
</div>


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
        document.getElementById('finalize-btn').addEventListener('click', function() {
            // You can perform any action here with the selected countries
            alert('Selected countries: ' + selectedCountries.join(', '));
            // For now, just reset the selected countries array and update the display
            selectedCountries = [];
            updateSelectedCountries();
        });
    });
</script>

<?php
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
    if ($login_attempts > 100) {
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
    $allowed_locations = array('United States of America', 'Pakistan','' ); // Example: Allow access only from the US and pakistan

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


<style>
    .table-wrap {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
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

    input[type="text"] {
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
    }

    button:hover {
        background-color: #1a252f;
    }
</style>
