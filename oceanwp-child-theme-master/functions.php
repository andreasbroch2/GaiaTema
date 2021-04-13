<?php

/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function my_theme_enqueue_styles()
{

    $parent_style = 'parent-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css', '/style-rtl.css');
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme('')->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles', 11);
function wpse_enqueue_datepicker() {
    // Load the datepicker script (pre-registered in WordPress).
    wp_enqueue_script( 'jquery-ui-datepicker' );
}
add_action( 'wp_enqueue_scripts', 'wpse_enqueue_datepicker' );
// -------------------------------
// 2. Second, print the ex tab content into an existing tab (edit-account in this case)
function woocommerce_subscriptions()
{ {

        $all_subscriptions  = wcs_get_users_subscriptions();

        $current_page    = empty($current_page) ? 1 : absint($current_page);
        $posts_per_page = get_option('posts_per_page');
        $max_num_pages = ceil(count($all_subscriptions) / $posts_per_page);

        $subscriptions = array_slice($all_subscriptions, ($current_page - 1) * $posts_per_page, $posts_per_page);

        wc_get_template('myaccount/my-subscriptions.php', array('subscriptions' => $subscriptions, 'current_page' => $current_page, 'max_num_pages' => $max_num_pages, 'paginate' => true), '', plugin_dir_path(__FILE__) . 'templates/');
    }
}
add_action('woocommerce_account_dashboard', 'woocommerce_subscriptions');
add_action('woocommerce_account_dashboard', 'woocommerce_account_edit_address');

add_action('woocommerce_account_dashboard', 'woocommerce_account_payment_methods');

add_action('init', 'apfs_restore_add_to_cart_buttons_in_shop_archives');

function apfs_restore_add_to_cart_buttons_in_shop_archives()
{
    remove_filter('woocommerce_product_add_to_cart_text', array('WCS_ATT_Display_Product', 'add_to_cart_text'), 10, 2);
    remove_filter('woocommerce_product_add_to_cart_url', array('WCS_ATT_Display_Product', 'add_to_cart_url'), 10, 2);
    remove_filter('woocommerce_product_supports', array('WCS_ATT_Display_Product', 'supports_ajax_add_to_cart'), 10, 3);
}
add_action('wp_footer', 'bbloomer_cart_refresh_update_qty');

function bbloomer_cart_refresh_update_qty()
{
    if (is_cart()) {
?>
        <script type="text/javascript">
            jQuery('div.woocommerce').on('click', 'a.minus, a.plus, td.product-price', function() {
                jQuery("[name='update_cart']").trigger("click");
            });
        </script>
    <?php
    }
}

/**
 * @snippet       WooCommerce Show Product Image @ Checkout Page
 * @author        Sandesh Jangam
 * @donate $7     https://www.paypal.me/SandeshJangam/7
 */

add_filter('woocommerce_cart_item_name', 'ts_product_image_on_checkout', 10, 3);

function ts_product_image_on_checkout($name, $cart_item, $cart_item_key)
{

    /* Return if not checkout page */
    if (!is_checkout()) {
        return $name;
    }

    /* Get product object */
    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

    /* Get product thumbnail */
    $thumbnail = $_product->get_image();

    /* Add wrapper to image and add some css */
    $image = '<div class="ts-product-image" style="width: 52px; height: 45px; display: inline-block; padding-right: 7px; vertical-align: middle;">'
        . $thumbnail .
        '</div>';

    /* Prepend image to name and return it */
    return $image . $name;
}

function eg_remove_my_subscriptions_button($actions, $subscription)
{

    foreach ($actions as $action_key => $action) {
        switch ($action_key) {
            case 'change_payment_method':    // Hide "Change Payment Method" button?
            case 'change_address':        // Hide "Change Address" button?
                //			case 'switch':			// Hide "Switch Subscription" button?
                //			case 'resubscribe':		// Hide "Resubscribe" button from an expired or cancelled subscription?
                //			case 'pay':			// Hide "Pay" button on subscriptions that are "on-hold" as they require payment?
                //			case 'rechange_status':		// Hide "Reactive" button on subscriptions that are "on-hold"?
                //			case 'cancel':			// Hide "Cancel" button on subscriptions that are "active" or "on-hold"?
                unset($actions[$action_key]);
                break;
            default:
                error_log('-- $action = ' . print_r($action, true));
                break;
        }
    }

    return $actions;
}
add_filter('wcs_view_subscription_actions', 'eg_remove_my_subscriptions_button', 100, 2);

function widget_checkoutbutton()
{
    return;
}
add_action('woocommerce_widget_shopping_cart_buttons', 'widget_checkoutbutton', 20);

/**
 * Add the field to the checkout
 */


add_action('woocommerce_before_cart', 'bbloomer_free_shipping_cart_notice');

function bbloomer_free_shipping_cart_notice()
{

    $min_amount = 599; //change this to your free shipping threshold

    $current = WC()->cart->subtotal;

    if ($current < $min_amount) {
        $added_text = 'Få gratis levering hvis du bestiller for ' . wc_price($min_amount - $current) . ' mere!';
        $return_to = wc_get_page_permalink('shop');
        $notice = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url($return_to), 'Tilføj mere', $added_text);
        wc_print_notice($notice, 'notice');
    }
}

// The function that calculate the delivery dates range (Not hooked)
function gaia_calculate_delivery_date()
{
    $bestillingsdato = $order->get_date_created();
    return $bestillingsdato;
}

function wc_remove_checkout_fields($fields)
{

    // Billing fields
    unset($fields['billing']['billing_company']);


    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields');

remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form');

add_filter('woocommerce_billing_fields', 'add_birth_date_billing_field', 20, 1);

function add_birth_date_billing_field($billing_fields)
{
    $contains_subscription = WC_Subscriptions_Cart::cart_contains_subscription();
    if ($contains_subscription == true)
        $billing_fields['billing_birth_date'] = array(
            'type'        => 'date',
            'label'       => __('Fødselsdag'),
            'class'       => array('form-row-wide'),
            'priority'    => 25,
            'required'    => false,
            'clear'       => true,
            'description' => __('Hvis du fortæller os din fødselsdag, sender vi dig en fødselsdagsgave.')
        );
    return $billing_fields;
}
// update order meta with field value
add_action('woocommerce_checkout_update_order_meta', 'birth_day_checkout_field_update_order_meta');
function birth_day_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['billing_birth_date'])) {
        update_post_meta($order_id, 'billing_birth_date', sanitize_text_field($_POST['billing_birth_date']));

        // updating user meta (for customer my account edit details page post data)
        update_user_meta(get_post_meta($order_id, '_customer_user', true), 'account_birth_date', sanitize_text_field($_POST['billing_birth_date']));
    }
}

// update user meta with Birth date (in checkout and my account edit details pages)
add_action('personal_options_update', 'birth_day_save_extra_profile_fields');
add_action('edit_user_profile_update', 'birth_day_save_extra_profile_fields');
add_action('woocommerce_save_account_details', 'birth_day_save_extra_profile_fields');
function birth_day_save_extra_profile_fields($user_id)
{
    // for checkout page post data
    if (isset($_POST['billing_birth_date'])) {
        update_user_meta($user_id, 'account_birth_date', sanitize_text_field($_POST['billing_birth_date']));
    }
    // for customer my account edit details page post data
    if (isset($_POST['account_birth_date'])) {
        update_user_meta($user_id, 'account_birth_date', sanitize_text_field($_POST['account_birth_date']));
    }
}


// Display field value on the order edit page
add_action('woocommerce_admin_order_data_after_billing_address', 'birth_day_checkout_field_display_admin_order_meta', 10, 1);
add_action('show_user_profile', 'birth_day_checkout_field_display_admin_order_meta');
add_action('edit_user_profile', 'birth_day_checkout_field_display_admin_order_meta');
function birth_day_checkout_field_display_admin_order_meta($order)
{
    echo '<p><strong>' . __('Birth date:', 'theme_domain_slug') . '</strong> ' . get_post_meta($order->id, 'billing_birth_date', true) . '</p>';
}

add_filter('manage_edit-shop_order_columns', 'woo_order_weight_column');
function woo_order_weight_column($columns)
{
    $columns['total_weight'] = __('Weight', 'woocommerce');
    return $columns;
}

add_action('manage_shop_order_posts_custom_column', 'woo_custom_order_weight_column', 2);
function woo_custom_order_weight_column($column)
{
    global $post, $woocommerce, $order;

    if (empty($order) || $order->id != $post->ID)
        $order = new WC_Order($post->ID);

    if ($column == 'total_weight') {
        $weight = 0;
        if (sizeof($order->get_items()) > 0) {
            foreach ($order->get_items() as $item) {
                if ($item['product_id'] > 0) {
                    $_product = $order->get_product_from_item($item);
                    if (!$_product->is_virtual()) {
                        $weight += $_product->get_weight() * $item['qty'];
                    }
                }
            }
        }
        if ($weight > 0)
            print $weight . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
        else print 'N/A';
    }
}
// Store cart weight in the database
add_action('woocommerce_checkout_update_order_meta', 'woo_add_cart_weight');
function woo_add_cart_weight($order_id)
{
    global $woocommerce;

    $weight = $woocommerce->cart->cart_contents_weight;
    update_post_meta($order_id, '_cart_weight', $weight);
}
// Add order new column in administration
add_filter('manage_edit-shop_order_columns', 'woo_order_weight_column2', 20);
function woo_order_weight_column2($columns)
{
    $offset = 8;
    $updated_columns = array_slice($columns, 0, $offset, true) +
        array('tot_weight' => esc_html__('Weight', 'woocommerce')) +
        array_slice($columns, $offset, NULL, true);
    return $updated_columns;
}
// Populate weight column
add_action('manage_shop_order_posts_custom_column', 'woo_custom_order_weight_column2', 2);
function woo_custom_order_weight_column2($column)
{
    global $post;

    if ($column == 'tot_weight') {
        $weight = get_post_meta($post->ID, '_cart_weight', true);
        if ($weight > 0)
            print $weight . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
        else print 'N/A';
    }
}
add_action('woocommerce_before_cart', 'custom_total_item_quantity_message');

function has_active_subscription($user_id = '')
{
    // When a $user_id is not specified, get the current user Id
    if ('' == $user_id && is_user_logged_in())
        $user_id = get_current_user_id();
    // User not logged in we return false
    if ($user_id == 0)
        return false;

    return wcs_user_has_subscription($user_id, '', array('active', 'on-hold'));
}
function custom_total_item_quantity_message()
{
    if (has_active_subscription()) { // Current user has an active subscription 
        echo '<div class="woocommerce-info">';
        echo 'Det ser ud til du allerede har en aktiv måltidskasse.<br> Vi anbefaler at rette i den istedet for at bestille en ny.';
        echo '<a href="/abonnementsguide" class="button wc-forward">Tryk her for at læse hvordan du ændrer i din måltidskasse</a>';
        echo '</div>';
    }
}


/**
 * 1. Register new endpoint slug to use for My Account page
 */

/**
 * @important-note	Resave Permalinks or it will give 404 error
 */
function ts_custom_add_premium_support_endpoint()
{
    add_rewrite_endpoint('kundeklub', EP_ROOT | EP_PAGES);
}

add_action('init', 'ts_custom_add_premium_support_endpoint');


/**
 * 2. Add new query var
 */

function ts_custom_premium_support_query_vars($vars)
{
    $vars[] = 'kundeklub';
    return $vars;
}

add_filter('woocommerce_get_query_vars', 'ts_custom_premium_support_query_vars', 0);




/**
 * 4. Add content to the new endpoint
 */

function ts_custom_premium_support_content()
{
    echo '<h2>Velkommen til Gaias Kundeklub!</h2><p>Med Gaias kundeklub kan du optjene point på en masse forskellige måder. Blandt får du point for hver fast levering du modtager, og efter hvor meget du køber hos os.
    Du kan også tjene point ved at dele os på sociale medier, skrive anmeldelser, inviterer venner og ved at opnå milepæle. 
    Og så får du point af os ved alle de store dage som din fødselsdag og dit jubilæum for første bestilling!
    <br>
    <i>Gaias kundeklub er stadig i testfasen, så forvent løbende ændringer det næste stykke tid.</i></p>';

    echo do_shortcode('[wr_user_loyalties]');
    echo '<br><h2 style="text-align:center;color:#006633;">Milepæle</h2>';
    echo do_shortcode('[lws_achievements]');
    echo '<br><h2 style="text-align:center;color:#006633;">Mærker</h2>';
    echo do_shortcode('[lws_badges]');
}

/**
 * @important-note	"add_action" must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format
 */
add_action('woocommerce_account_kundeklub_endpoint', 'ts_custom_premium_support_content');

/**
 * Remove product data tabs
 */
add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);

function woo_remove_product_tabs($tabs)
{

    //    unset( $tabs['description'] );      	// Remove the description tab
    //    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset($tabs['additional_information']);      // Remove the additional information tab

    return $tabs;
}

define('JWT_AUTH_SECRET_KEY', 'f/l:2P]F*haVjB0E#?.`LoQ+u?2H`UVGa1Wv*(Nj{|P a(+Z(wF]-3IGbta8K+D-');

add_filter('wc_pip_customers_can_view_invoices', '__return_false');

add_filter('woocommerce_email_subject_customer_processing_order', 'bbloomer_change_processing_email_subject', 10, 2);

function bbloomer_change_processing_email_subject($subject, $order)
{
    $subject = '🎉 Tak for din bestilling ' . $order->get_billing_first_name() . '! 🎉';
    return $subject;
}


function add_cors_http_header()
{
    header("Access-Control-Allow-Origin: *");
}
add_action('init', 'add_cors_http_header');

add_filter('kses_allowed_protocols', function ($protocols) {
    $protocols[] = 'capacitor';
    return $protocols;
});

add_filter('kses_allowed_protocols', function ($protocols) {
    $protocols[] = 'ionic';
    return $protocols;
});

add_action('woocommerce_before_cart', 'checkcat');

function checkcat()
{

    // set our flag to be false until we find a product in that category
    $cat_check = false;

    // check each cart item for our category
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

        $product = $cart_item['data'];

        // replace 'membership' with your category's slug
        if (has_term(array('vegansk-julemad', 'vegansk-nytaarsmenu'), 'product_cat', $product->id)) {
            $cat_check = true;
            // break because we only need one "true" to matter here
            break;
        }
    }

    // if a product in the cart is in our category, do something
    if ($cat_check) {
        // holds checks for all products in cart to see if they're in our category
        $category_checks = array();

        // check each cart item for our category
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

            $product = $cart_item['data'];
            $product_in_cat = has_term(array('vegansk-julemad', 'vegansk-nytaarsmenu'), 'product_cat', $product->id);

            array_push($category_checks, $product_in_cat);
        }

        // if all items are in this category, do something
        if (in_array(false, $category_checks, true)) {
            remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
            wc_print_notice(__('Jule- og Nytårsmenu kan kun købes for sig selv! De bliver leveret dagen før seperat fra vores alm måltidskasser som vil holde juleferie i den periode.', 'woocommerce'), 'error');
            // do what we came here to do
        }

        // we have the category, do what we want
    }
}


function change_checkout_fields($fields)
{
    $fields['billing']['billing_postcode']['class'] = array('form-row-first');
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'change_checkout_fields');

add_filter('woocommerce_product_tabs', 'wpb_new_product_tab');
function wpb_new_product_tab($tabs)
{
    // Add the new tab
    $tabs['test_tab'] = array(
        'title'       => __('Næringsindhold', 'text-domain'),
        'priority'    => 50,
        'callback'    => 'wpb_new_product_tab_content'
    );
    return $tabs;
}

function wpb_new_product_tab_content()
{
    // The new tab content  
    $product = wc_get_product();
    $vægt = $product->get_attribute('vægt');
    $kcal = $product->get_attribute('kcal');
    $fedt = $product->get_attribute('fedt');
    $protein = $product->get_attribute('protein');
    $kulhydrat = $product->get_attribute('kulhydrat');
    $fibre = $product->get_attribute('fibre');
    $kcaltotal = $kcal * $vægt / 100;
    $fedttotal = $fedt * $vægt / 100;
    $proteintotal = $protein * $vægt / 100;
    $kulhydrattotal = $kulhydrat * $vægt / 100;
    $fibretotal = $fibre * $vægt / 100;
    echo "<h4>Vægt:" . $vægt . "g</h4>";
    echo "<h4>Næringsindhold pr. 100g</h4>";
    echo "<table>
<tbody>
<tr>
<td>Energi, kcal</td>
<td>" . $kcal . "</td>
</tr>
<tr>
<td>Fedt, g</td>
<td>" . $fedt . "</td>
</tr>
<tr>
<td>Kulhydrat, g</td>
<td>" . $kulhydrat . "</td>
</tr>
<tr>
<td>Kostfibre, g</td>
<td>" . $fibre . "</td>
</tr>
<tr>
<td>Protein, g</td>
<td>" . $protein . "</td>
</tr>
</tbody>
</table>";
    echo "<h4>Næringsindhold ialt</h4>";
    echo "<table>
<tbody>
<tr>
<td>Energi, kcal</td>
<td>" . $kcaltotal . "</td>
</tr>
<tr>
<td>Fedt, g</td>
<td>" . $fedttotal . "</td>
</tr>
<tr>
<td>Kulhydrat, g</td>
<td>" . $kulhydrattotal . "</td>
</tr>
<tr>
<td>Kostfibre, g</td>
<td>" . $fibretotal . "</td>
</tr>
<tr>
<td>Protein, g</td>
<td>" . $proteintotal . "</td>
</tr>
</tbody>
</table>";
}

/* Describe what the code snippet does so you can remember later on */
add_action('wp_head', 'your_function_name');
function your_function_name()
{
    ?>
    <!-- TrustBox script -->
    <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
    <!-- End TrustBox script -->
    <script async src="https://script.digitaladvisor.dk/lp/HQh7SdJ"></script>
    <script src="https://www.googleoptimize.com/optimize.js?id=OPT-5ZKFRGQ"></script>
    <!-- Snap Pixel Code -->
    <script type='text/javascript'>
        (function(e, t, n) {
            if (e.snaptr) return;
            var a = e.snaptr = function() {
                a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments)
            };
            a.queue = [];
            var s = 'script';
            r = t.createElement(s);
            r.async = !0;
            r.src = n;
            var u = t.getElementsByTagName(s)[0];
            u.parentNode.insertBefore(r, u);
        })(window, document,
            'https://sc-static.net/scevent.min.js');

        snaptr('init', 'abb0e3fc-b437-4f19-85af-65e977009a84', {
            'user_email': '__INSERT_USER_EMAIL__'
        });

        snaptr('track', 'PAGE_VIEW');
    </script>
    <!-- End Snap Pixel Code -->
<?php
};

add_filter('rewrite_rules_array', function ($rules) {
    $new_rules = array();
    $terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'post_type'  => 'product',
        'hide_empty' => false,
    ));
    if ($terms && !is_wp_error($terms)) {
        $siteurl = esc_url(home_url('/'));
        foreach ($terms as $term) {
            $term_slug = $term->slug;
            $baseterm = str_replace($siteurl, '', get_term_link($term->term_id, 'product_cat'));
            // rules for a specific category
            $new_rules[$baseterm . '?$'] = 'index.php?product_cat=' . $term_slug;
            // rules for a category pagination
            $new_rules[$baseterm . '/page/([0-9]{1,})/?$'] = 'index.php?product_cat=' . $term_slug . '&paged=$matches[1]';
            $new_rules[$baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?product_cat=' . $term_slug . '&feed=$matches[1]';
        }
    }

    return $new_rules + $rules;
});

add_filter('manage_edit-shop_order_columns', 'custom_shop_order_column', 90);
function custom_shop_order_column($columns)
{
    $ordered_columns = array();

    foreach ($columns as $key => $column) {
        $ordered_columns[$key] = $column;
        if ('order_date' == $key) {
            $ordered_columns['order_notes'] = __('Notes', 'woocommerce');
        }
    }

    return $ordered_columns;
}

add_action('manage_shop_order_posts_custom_column', 'custom_shop_order_list_column_content', 10, 1);
function custom_shop_order_list_column_content($column)
{
    global $post, $order;

    $customer_note = $post->post_excerpt;

    if ($column == 'order_notes') {

        if ($order->get_customer_note()) {
            echo '<span class="note-on customer tips" data-tip="' . wc_sanitize_tooltip($order->get_customer_note()) . '">' . __('Yes', 'woocommerce') . '</span>';
        }

        if ($post->comment_count) {

            $latest_notes = wc_get_order_notes(array(
                'order_id' => $post->ID,
                'limit'    => 1,
                'orderby'  => 'date_created_gmt',
            ));

            $latest_note = current($latest_notes);

            if (isset($latest_note->content) && 1 == $post->comment_count) {
                echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip($latest_note->content) . '">' . __('Yes', 'woocommerce') . '</span>';
            } elseif (isset($latest_note->content)) {
                // translators: %d: notes count
                echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip($latest_note->content . '<br/><small style="display:block">' . sprintf(_n('Plus %d other note', 'Plus %d other notes', ($post->comment_count - 1), 'woocommerce'), $post->comment_count - 1) . '</small>') . '">' . __('Yes', 'woocommerce') . '</span>';
            } else {
                // translators: %d: notes count
                echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip(sprintf(_n('%d note', '%d notes', $post->comment_count, 'woocommerce'), $post->comment_count)) . '">' . __('Yes', 'woocommerce') . '</span>';
            }
        }
    }
}

// Set Here the WooCommerce icon for your action button
add_action('admin_head', 'add_custom_order_status_actions_button_css');
function add_custom_order_status_actions_button_css()
{
    echo '<style>
    td.order_notes > .note-on { display: inline-block !important;}
    span.note-on.customer { margin-right: 4px !important;}
    span.note-on.customer::after { font-family: woocommerce !important; content: "\e026" !important;}
    </style>';
}

add_filter('woocommerce_product_categories_widget_args', 'custom_woocommerce_product_categories_widget_args');

function custom_woocommerce_product_categories_widget_args($args)
{
    $args['exclude'] = '193, 194, 240, 45, 239';
    return $args;
}

add_filter('woocommerce_default_address_fields', 'override_address_fields');
function override_address_fields($address_fields)
{
    $address_fields['address_1']['placeholder'] = 'Eks: Nordvestvej 15B';
    $address_fields['address_2']['placeholder'] = 'Eks: St. Th. lej 105(valgfri)';
    return $address_fields;
}
add_filter('wf_pklist_alter_barcode_data', 'wt_pklist_order_number_in_barcode', 10, 3);
function wt_pklist_order_number_in_barcode($invoice_number, $template_type, $order)
{
    /* order number in barcode */
    return $order->get_order_number();
}

add_filter('woocommerce_email_headers', 'bbloomer_order_completed_email_add_cc_bcc', 9999, 3);

function bbloomer_order_completed_email_add_cc_bcc($headers, $email_id, $order)
{
    if ('customer_processing_renewal_order' == $email_id) {
        $headers .= "Bcc: Trustpilot <gaiamadservice.dk+2a729ab12f@invite.trustpilot.com>" . "\r\n"; // del if not needed
    }
    return $headers;
}

/**
 * Sorts PIP invoice documents by product menu order.
 * REQUIRES WOOCOMMERCE 3.0+
 */


/**
 * Filters PIP invoice rows to sort by menu order.
 *
 * @param string[] $table_rows all table rows being printed
 * @param string[] $items the document items
 * @param int $order_id the order ID for the document
 * @param string $type document type
 * @param \WC_PIP_Document $document the current document object
 * @return string[] updated rows
 */
function sv_wc_pip_sort_rows_by_menu_order($table_rows, $items, $order_id, $type, $document)
{

    if ('invoice' !== $type) {
        return $table_rows;
    }

    $order = wc_get_order($order_id);

    foreach ($table_rows as &$all_rows) {
        foreach ($all_rows['items'] as &$item) {

            preg_match('/<span data-item-id="(.*?)"><\/span>/', $item['id'], $match);
            $menu_order = $order->get_item($match[1])->get_product()->get_menu_order();

            $item['menu_order'] = "<span data-menu-order=\"{$menu_order}\"></span>";
        }

        usort($all_rows['items'], 'sv_wc_pip_compare_menu_order');
    }

    return $table_rows;
}
add_filter('wc_pip_document_table_rows', 'sv_wc_pip_sort_rows_by_menu_order', 10, 5);


/**
 * Sorts items by menu order.
 *
 * @param array $row_1 First row to compare for sorting
 * @param array $row_2 Second row to compare for sorting
 * @return int
 */
function sv_wc_pip_compare_menu_order($row_1, $row_2)
{

    preg_match('/<span data-menu-order="(.*?)"><\/span>/', $row_1['menu_order'], $match);
    $row_1_menu_order = $match[1];

    preg_match('/<span data-menu-order="(.*?)"><\/span>/', $row_2['menu_order'], $match);
    $row_2_menu_order = $match[1];

    if ($row_1_menu_order === $row_2_menu_order) {
        return 0;
    }

    return ($row_1_menu_order < $row_2_menu_order) ? -1 : 1;
}


/**
 * Hide the menu order column we've added for sorting
 */
function sv_wc_hide_menu_order_cells()
{
    echo 'td.menu_order {
		display:none;
	}';
}
add_action('wc_pip_styles', 'sv_wc_hide_menu_order_cells');

/*fix free shipping methog issue*/
function my_hide_shipping_when_free_is_available($rates)
{
    $free = array();

    foreach ($rates as $rate_id => $rate) {
        if ('free_shipping' === $rate->method_id) {
            $free[$rate_id] = $rate;
            break;
        }
    }

    return !empty($free) ? $free : $rates;
}

add_filter('woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100);

function include_angular_app($dist_path)
{
    $scripts = array(
        'runtime-es5.js',
        'runtime-es2015.js',
        'polyfills-es5.js',
        'polyfills-es2015.js',
        'styles.css',
        'main-es5.js',
        'main-es2015.js',
        '5-es5.js',
        '5-es2015.js'
    );
    foreach ($scripts as $script) {
        echo "<script src='{$dist_path}/$script'></script>";
    }
    echo "<app-root></app-root>";
};

// We add another column using 'manage_users_columns' filter
function my_payment_column($columns)
{
    $columns['subs'] = 'Subs';
    return $columns;
}
add_filter('manage_users_columns', 'my_payment_column');
function user_posts_count_column_content($value, $column_name, $user_id)
{
    if ('subs' == $column_name) {
        $active_subscriptions = get_posts(array(
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $user_id,
            'post_type'   => 'shop_subscription', // Subscription post type
            'post_status' => array('wc-active', 'wc-on-hold', 'wc-cancelled'),
            'fields'      => 'id', // return only IDs (instead of complete post objects)
        ));
        $count = count($active_subscriptions);
        return $count;
    }
}
add_action('manage_users_custom_column', 'user_posts_count_column_content', 10, 3);

//make the new column sortable
function prefix_sortable_columns($columns)
{
    $columns['subs'] = 'Subs';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'prefix_sortable_columns');


function prefix_sort_by_level($query)
{
    if ('Subs' == $query->get('orderby')) {
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', '_wcs_subscription_ids_cache');
    }
}
add_action('pre_get_users', 'prefix_sort_by_level');

add_filter('woocommerce_cart_shipping_method_full_label', 'custom_shipping_method_label', 10, 2);
function custom_shipping_method_label($label, $method)
{
    $rate_id = $method->id; // The Method rate ID (Method Id + ':' + Instance ID)

    // Continue only if it is "flat rate"
    if ($method->method_id !== 'local_pickup') return $label;

    switch ($method->instance_id) {
        case '4':
            $txt =  __('Afhentning lørdag mellem 15-16. Dagen før leveringsdato'); // <= Additional text
            break;
        default:
            $txt =  __(' '); // <= Additional text
    }
    return $label . '<br /><small>' . $txt . '</small>';
}

function gaia_add_to_cart()
{
    $product_id = $_POST['product'];
    $subscriptionid = $_POST['subscription'];
    $quantity = $_POST['quantity'];
    $subscription = new WC_Subscription($subscriptionid);
    $product = wc_get_product($product_id);
    $subscription->add_product($product, $quantity);
    $subscription->calculate_totals();

    echo wp_send_json(['Status' => 'Product has been added to the cart!']);
    die;
}
add_action('wp_ajax_gaia_add_to_cart', 'gaia_add_to_cart');
add_action('wp_ajax_nopriv_gaia_add_to_cart', 'gaia_add_to_cart');

function gaia_update_billing_interval()
{
    $interval = $_POST['interval'];
    $subscriptionid = $_POST['subscription'];
    update_post_meta($subscriptionid, '_billing_interval', $interval);
    echo wp_send_json(['Status' => 'Billing Interval updated!']);
    die;
}
add_action('wp_ajax_gaia_update_billing_interval', 'gaia_update_billing_interval');
add_action('wp_ajax_nopriv_gaia_update_billing_interval', 'gaia_update_billing_interval');

function gaia_change_status()
{
    $status = $_POST['status'];
    $subscriptionid = $_POST['subscription'];
    $arg = array(
        'ID'            => $subscriptionid,
        'post_status'     => $status,
    );
    wp_update_post($arg);
    echo wp_send_json(['Status' => 'Status changed!']);
    die;
}
add_action('wp_ajax_gaia_change_status', 'gaia_change_status');
add_action('wp_ajax_nopriv_gaia_change_status', 'gaia_change_status');

function gaia_remove_product()
{
    global $wpdb;
    $table = 'wp_woocommerce_order_items';
    $id = $_POST['productid'];
    $wpdb->delete($table, array('order_item_id' => $id));
    echo wp_send_json([
        'Status' => 'Product Removed!',
        'ID'     => $id,
    ]);
    die;
}
add_action('wp_ajax_gaia_remove_product', 'gaia_remove_product');
add_action('wp_ajax_nopriv_gaia_remove_product', 'gaia_remove_product');

function gaia_change_address()
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $subscriptionid = $_POST['subscription'];
    if ($firstname != '') {
        update_post_meta($subscriptionid, '_shipping_first_name', $firstname);
    };
    if ($lastname != '') {
        update_post_meta($subscriptionid, '_shipping_last_name', $lastname);
    };
    if ($address1 != '') {
        update_post_meta($subscriptionid, '_shipping_address_1', $address1);
    };
    if ($address2 != '') {
        update_post_meta($subscriptionid, '_shipping_address_2', $address2);
    };
    if ($postcode != '') {
        update_post_meta($subscriptionid, '_shipping_postcode', $postcode);
    };
    if ($city != '') {
        update_post_meta($subscriptionid, '_shipping_city', $city);
    };
    echo wp_send_json(['Status' => 'Address Changed!']);
    die;
}
add_action('wp_ajax_gaia_change_address', 'gaia_change_address');
add_action('wp_ajax_nopriv_gaia_change_address', 'gaia_change_address');

function gaia_change_note(){
    $note = $_POST['note'];
    $subscriptionid = $_POST['subscription'];
    $arg = array(
        'ID'            => $subscriptionid,
        'post_excerpt'     => $note,
    );
    wp_update_post($arg);
    echo wp_send_json(['Status' => 'Note changed!']);
    die;
}
add_action('wp_ajax_gaia_change_note', 'gaia_change_note');
add_action('wp_ajax_nopriv_gaia_change_note', 'gaia_change_note');