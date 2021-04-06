

<?php
/**
* Template Name: Bestilling
*
*/
get_header(); ?>

 <div class="barcontainer">
      <ul class="progressbar">
          <li id="liststep1" onclick="step1()" class="active"></li>
          <li id="liststep2" onclick="step2()" ></li>
          <li id="liststep3" onclick="step3()"></li>
          <li id="liststep4" onclick="step4()"></li>
  </ul>
</div>
<div class="orderpagewrapper">
<div class="step step1">
<h2>Vælg Hovedretter</h2>
<?php get_template_part( 'templates/step1' ); ?>
</div>
<div class="step step2">
<h2>Vælg tilbehør</h2>
<?php get_template_part( 'templates/step2' ); ?>
</div>
<div class="step step3">
<h2>Vælg Drikkevarer</h2>
<?php get_template_part( 'templates/step3' ); ?>
</div>
</div>
<?php get_footer(); ?>
<div class="orderbottombar">
    <div>
    <i onclick="minicart()" class="fas fa-shopping-cart"></i>
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </div>
    <div>
        <?php echo WC()->cart->get_displayed_subtotal(); ?>,-
    </div>
</div>
<div class="minicart">
<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php if ( empty( $product_permalink ) ) : ?>
						<?php echo $thumbnail . $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>">
							<?php echo $thumbnail . $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php endif; ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>
                </li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>
</div>
<script>
function minicart(){
    jQuery( '.minicart' ).toggle( 'slow' )
}
function step1(){
    jQuery( '.step2' ).css("display", "none");
    jQuery( '.step1' ).css("display", "block");
    jQuery( '.step3' ).css("display", "none");
    jQuery( '.step4' ).css("display", "none");
    jQuery( '#liststep2' ).removeClass("active");
    jQuery( '#liststep3' ).removeClass("active");
    jQuery( '#liststep4' ).removeClass("active");
}
function step2(){
    jQuery( '.step2' ).css("display", "block");
    jQuery( '.step1' ).css("display", "none");
    jQuery( '.step3' ).css("display", "none");
    jQuery( '.step4' ).css("display", "none");
    jQuery( '#liststep2' ).addClass("active");
    jQuery( '#liststep3' ).removeClass("active");
    jQuery( '#liststep4' ).removeClass("active");
}
function step3(){
    jQuery( '.step2' ).css("display", "none");
    jQuery( '.step1' ).css("display", "none");
    jQuery( '.step3' ).css("display", "block");
    jQuery( '.step4' ).css("display", "none");
    jQuery( '#liststep2' ).addClass("active");
    jQuery( '#liststep3' ).addClass("active");
    jQuery( '#liststep4' ).removeClass("active");
}
function step4(){
    jQuery( '.step2' ).css("display", "none");
    jQuery( '.step1' ).css("display", "none");
    jQuery( '.step3' ).css("display", "none");
    jQuery( '.step4' ).css("display", "block");
    jQuery( '#liststep2' ).addClass("active");
    jQuery( '#liststep3' ).addClass("active");
    jQuery( '#liststep4' ).addClass("active");
}
</script>