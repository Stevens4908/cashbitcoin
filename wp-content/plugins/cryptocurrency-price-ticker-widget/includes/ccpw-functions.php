<?php

/*
|--------------------------------------------------------------------------
| getting all coins details from database
|--------------------------------------------------------------------------
 */
function ccpw_get_coins_data($coin_id_arr)
{
    $DB = new ccpw_database;
    $coin_data = $DB->get_coins(array('coin_id' => $coin_id_arr, 'number' => '1000', 'orderby' => 'market_cap', 'order' => 'DESC'));

    if (is_array($coin_data) && isset($coin_data)) {
        $coin_rs_data = ccpw_objectToArray($coin_data);
        return $coin_rs_data;
    } else {
        return false;
    }

}

/*
|--------------------------------------------------------------------------
| getting all coins details from database
|--------------------------------------------------------------------------
 */

function ccpw_get_top_coins_data($limit)
{
    $order_col_name = 'market_cap';
    $order_type = 'DESC';
    $DB = new ccpw_database;
    $coin_data = $DB->get_coins(array("number" => $limit, 'offset' => 0, 'orderby' => $order_col_name,
        'order' => $order_type,
    ));
    if (is_array($coin_data) && isset($coin_data)) {
        $coins_rs_arr = ccpw_objectToArray($coin_data);
        return $coins_rs_arr;
    } else {
        return false;
    }
}

/*
|--------------------------------------------------------------------------
| getting all coin ids from database
|--------------------------------------------------------------------------
 */
function ccpw_get_all_coin_ids()
{
    $DB = new ccpw_database;
    $coin_data = $DB->get_coins(array('number' => '1000'));
    if (is_array($coin_data) && isset($coin_data)) {
        $coin_data = ccpw_objectToArray($coin_data);
        $coins = array();
        foreach ($coin_data as $coin) {
            $coins[$coin['coin_id']] = $coin['name'];
        }
        return $coins;
    } else {
        return false;
    }

}

/**
 * Check if provided $value is empty or not.
 * Return $default if $value is empty
 */
function ccpw_set_default_if_empty($value, $default = 'N/A')
{
    return $value ? $value : $default;
}

/*
Adding coins SVG logos
 */
function ccpw_get_coin_logo($coin_id, $size = 32, $HTML = true)
{
    $logo_html = '';
    $coin_svg = CCPWF_DIR . '/assets/coin-logos/' . strtolower($coin_id) . '.svg';
    $coin_png = CCPWF_DIR . '/assets/coin-logos/' . strtolower($coin_id) . '.png';

    if (file_exists($coin_svg)) {
        $coin_svg = CCPWF_URL . 'assets/coin-logos/' . strtolower($coin_id) . '.svg';
        if ($HTML == true) {
            $logo_html = '<img id="' . $coin_id . '" alt="' . $coin_id . '" src="' . $coin_svg . '">';
        } else {
            $logo_html = $coin_svg;
        }
        return $logo_html;

    } else if (file_exists($coin_png)) {
        $coin_png = CCPWF_URL . 'assets/coin-logos/' . strtolower($coin_id) . '.png';
        if ($HTML == true) {
            $logo_html = '<img id="' . $coin_id . '" alt="' . $coin_id . '" src="' . $coin_png . '">';
        } else {
            $logo_html = $coin_png;
        }
        return $logo_html;

    } else {
        return false;
    }
}

function ccpw_format_number($n)
{
    $formatted = $n;
    if ($n <= -1) {
        $formatted = number_format($n, 2, '.', ',');
    } else if ($n < 0.50) {
        $formatted = number_format($n, 6, '.', ',');
    } else {
        $formatted = number_format($n, 2, '.', ',');
    }
    return $formatted;
}

// object to array conversion
function ccpw_objectToArray($d)
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
         * Return array converted to object
         * Using __FUNCTION__ (Magic constant)
         * for recursive call
         */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}

// currencies symbol
function ccpw_currency_symbol($name)
{
    $cc = strtoupper($name);
    $currency = array(
        "USD" => "&#36;", //U.S. Dollar
        "CLP" => "&#36;", //CLP Dollar
        "SGD" => "S&#36;", //Singapur dollar
        "AUD" => "&#36;", //Australian Dollar
        "BRL" => "R&#36;", //Brazilian Real
        "CAD" => "C&#36;", //Canadian Dollar
        "CZK" => "K&#269;", //Czech Koruna
        "DKK" => "kr", //Danish Krone
        "EUR" => "&euro;", //Euro
        "HKD" => "&#36", //Hong Kong Dollar
        "HUF" => "Ft", //Hungarian Forint
        "ILS" => "&#x20aa;", //Israeli New Sheqel
        "INR" => "&#8377;", //Indian Rupee
        "IDR" => "Rp", //Indian Rupee
        "KRW" => "&#8361;", //WON
        "CNY" => "&#165;", //CNY
        "JPY" => "&yen;", //Japanese Yen
        "MYR" => "RM", //Malaysian Ringgit
        "MXN" => "&#36;", //Mexican Peso
        "NOK" => "kr", //Norwegian Krone
        "NZD" => "&#36;", //New Zealand Dollar
        "PHP" => "&#x20b1;", //Philippine Peso
        "PLN" => "&#122;&#322;", //Polish Zloty
        "GBP" => "&pound;", //Pound Sterling
        "SEK" => "kr", //Swedish Krona
        "CHF" => "Fr", //Swiss Franc
        "TWD" => "NT&#36;", //Taiwan New Dollar
        "PKR" => "Rs", //Rs
        "THB" => "&#3647;", //Thai Baht
        "TRY" => "&#8378;", //Turkish Lira
        "ZAR" => "R", //zar
        "RUB" => "&#8381;", //rub
    );

    if (array_key_exists($cc, $currency)) {
        return $currency[$cc];
    }
}

/*
|--------------------------------------------------------------------------
|  check admin side post type page
|--------------------------------------------------------------------------
 */
function ccpw_get_post_type_page()
{
    global $post, $typenow, $current_screen;

    if ($post && $post->post_type) {
        return $post->post_type;
    } elseif ($typenow) {
        return $typenow;
    } elseif ($current_screen && $current_screen->post_type) {
        return $current_screen->post_type;
    } elseif (isset($_REQUEST['page'])) {
        return sanitize_key($_REQUEST['page']);
    } elseif (isset($_REQUEST['post_type'])) {
        return sanitize_key($_REQUEST['post_type']);
    } elseif (isset($_REQUEST['post'])) {
        return get_post_type(sanitize_text_field($_REQUEST['post']));
    }
    return null;
}

function display_live_preview()
{
    $output = '';
    if (isset($_REQUEST['post']) && !is_array($_REQUEST['post'])) {

        $id = sanitize_text_field($_REQUEST['post']);

        $type = get_post_meta($id, 'type', true);
        $output = '<p><strong class="micon-info-circled"></strong>' . __('Backend preview may be a little bit different from frontend / actual view. Add this shortcode on any page for frontend view - ', 'ccpwx') . '<code>[ccpw id=' . $id . ']</code></p>' . do_shortcode("[ccpw id='" . $id . "']");
        $output .= '<script type="text/javascript">
         jQuery(document).ready(function($){
           $(".ccpw-ticker-cont").fadeIn();
         });
         </script>
         <style type="text/css">
         .ccpw-footer-ticker-fixedbar, .ccpw-header-ticker-fixedbar{
           position:relative!important;
         }
         .tickercontainer li{
             float:left!important;
             width:auto!important;
         }
         .ccpw-container-rss-view ul li.ccpw-news {
          margin-bottom: 30px;
          float: none;
          width: auto;
      }
      .ccpw-news-ticker .tickercontainer li{
        width: auto!important;
      }
         </style>';
        return $output;

    } else {
        return $output = '<h4><strong class="micon-info-circled"></strong> ' . __('Publish to preview the widget.', 'ccpwx') . '</h4>';

    }
}

function update_tbl_settings($post_id)
{
    $old_settings = get_post_meta($post_id, 'display_currencies_for_table', true);

    if ($old_settings) {
        switch ($old_settings) {
            case 'top-10':
                $newVal = 10;
                break;
            case 'top-50':
                $newVal = 50;
                break;
            case 'top-100':
                $newVal = 100;
                break;
            case 'top-200':
                $newVal = 200;
                break;
            case 'all':
                $newVal = 250;
                break;
            default:
                $newVal = 10;
        }
        update_post_meta($post_id, 'show-coins', $newVal);
        delete_post_meta($post_id, 'display_currencies_for_table');
    }
}

function ccpw_set_checkbox_default_for_new_post($default)
{
    return isset($_GET['post']) ? '' : ($default ? (string) $default : '');
}

function ccpw_value_format_number($n)
{

    if ($n <= 0.00001 && $n > 0) {
        return $formatted = number_format($n, 8, '.', ',');
    } else if ($n <= 0.0001 && $n > 0.00001) {
        return $formatted = number_format($n, 6, '.', ',');
    } else if ($n <= 0.001 && $n > 0.0001) {
        return $formatted = number_format($n, 5, '.', ',');
    } else if ($n <= 0.01 && $n > 0.001) {
        return $formatted = number_format($n, 4, '.', ',');
    } else if ($n <= 1 && $n > 0.01) {
        return $formatted = number_format($n, 3, '.', ',');
    } else {
        return $formatted = number_format($n, 2, '.', ',');
    }
}

function ccpw_format_coin_value($value, $precision = 2)
{
    if ($value < 1000000) {
        // Anything less than a million
        $formated_str = number_format($value, $precision);
    } else if ($value < 1000000000) {
        // Anything less than a billion
        $formated_str = number_format($value / 1000000, $precision) . 'M';
    } else {
        // At least a billion
        $formated_str = number_format($value / 1000000000, $precision) . 'B';
    }

    return $formated_str;
}

function ccpw_widget_format_coin_value($value, $precision = 2)
{
    if ($value < 1000000) {
        // Anything less than a million
        $formated_str = number_format($value, $precision);
    } else if ($value < 1000000000) {
        // Anything less than a billion
        $formated_str = number_format($value / 1000000, $precision) . ' Million';
    } else {
        // At least a billion
        $formated_str = number_format($value / 1000000000, $precision) . ' Billion';
    }

    return $formated_str;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function ccpw_get_option($key = '', $default = false)
{
    if (function_exists('cmb2_get_option')) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option('ccpw_widget_settings', $key, $default);
    }

    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option('ccpw_widget_settings', $default);

    $val = $default;

    if ('all' == $key) {
        $val = $opts;
    } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
        $val = $opts[$key];
    }

    return $val;
}
