<?php


/* Adding CSS & JS */
function woocommerce_custom_theme() {
    wp_register_style( 'custom_css', get_template_directory_uri() . '/css/style.css', false, '1.0.0' );
    wp_register_style( 'stolzl_cdn', 'https://use.typekit.net/bjt7zcc.css', false, '1.0.0' );;
    wp_enqueue_style( 'custom_css' );
    wp_enqueue_style( 'stolzl_cdn' );

    wp_enqueue_script( 'main-scripts',  get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'woocommerce_custom_theme' );


/* Creating Custom Menu */
function woocommerce_custom_menu(){
    register_nav_menu('top-menu',__('WooCommerce Custom Menu', 'woocommercecustommenu'));
}
add_action( 'init', 'woocommerce_custom_menu');


/* WooCommerce */
if (class_exists('WooCommerce')) {

    /* WooCommerce Support */
    function woocommerceshop_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    add_action ( 'after_setup_theme', 'woocommerceshop_add_woocommerce_support' );

    // Remove WooCommerce Styles
    // add_filter( 'woocommerce_enqueue_styles', '__return_false' );

    // Remove Shop Title
    add_filter( 'woocommerce_show_page_title', '__return_false' );

    // Add Support
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

}
/**
 * Override loop template and show quantities next to add to cart buttons
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
		$html .= woocommerce_quantity_input( array(), $product, false );
		$html .= '<button type="submit" class="button alt">' . esc_html( $product->add_to_cart_text() ) . '</button>';
		$html .= '</form>';
	}
	return $html;
}

function trigger_new_order( $from_product_id, $subscription ) {
    $product    = wc_get_product( $from_product_id );
    $subscription->add_product($product);

    $subscription->calculate_totals();

    // Display a message with the order number
    echo '<p>' . sprintf( __("Vare tilføjet"), $subscription->get_id() ) . '</p>';
}

function gaia_add_to_cart() {

    $product_id = $_POST['product'];

    $product = wc_get_product( $product_id );
    $subscription->add_product($product);
    $subscription->calculate_totals();

    echo wp_send_json(['Status' => 'Product has been added to the cart!']);
    die;

}
add_action('wp_ajax_gaia_add_to_cart', 'gaia_add_to_cart');
add_action('wp_ajax_nopriv_gaia_add_to_cart', 'gaia_add_to_cart');
