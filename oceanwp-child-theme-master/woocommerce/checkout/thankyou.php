<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<style>
.thankyouhead {
	width: 100%;
	display: flex;
}
@media (max-width: 767px){
.thankyouhead {
    display: block;
}}
.thankyouheadrows {
	width: 50%;
	display: flex;
	position: relative;
	
	align-items: center;
	align-content: center;
}
@media (max-width: 767px){
.thankyouheadrows {
    width: 100%;
}}
.thankyouimg {
	padding: 90px;
}
@media (max-width: 767px){
.thankyouimg {
    padding: 30px;
}}
.thankyoutexttitle {
	font-size: 40px;
	font-weight: 500;
	line-height: 52px;
	text-align: center;
	color: #000000;
}
.thankyoutextsub {
	font-size: 14px;
	font-weight: 400;
	line-height: 26px;
	text-align: center;
}
.thankyouwrap {
	width: 100%;
	position: relative;
}
</style>
<div class="woocommerce-order">
<script async src="https://script.digitaladvisor.dk/cp/HQh7SdJ?adv_sub=<?php echo $order->get_order_number()?>"></script>
	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="thankyouhead">
				<div class="thankyouheadrows">
					<div class="thankyouwrap">
						<p class="thankyoutexttitle">Tusind tak for din bestilling <?php echo $order->get_billing_first_name(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>!</p>
						<p class="thankyoutextsub">Uanset om du er vegetar, flexitar, veganer, pescetar eller bare har lyst til et par grønne måltider, er vi glade for at du hjælper os med at skabe #EnGrønnereFremtid</p>
					</div>
				</div>
				<div class="thankyouheadrows">
					<div class="thankyouwrap">
						<img width="1024" height="1024" src="https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?fit=1024%2C1024&amp;ssl=1" class="thankyouimg" alt="Tak for din bestilling" loading="lazy" srcset="https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?w=2160&amp;ssl=1 2160w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=300%2C300&amp;ssl=1 300w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=1024%2C1024&amp;ssl=1 1024w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=150%2C150&amp;ssl=1 150w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=768%2C768&amp;ssl=1 768w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=96%2C96&amp;ssl=1 96w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=42%2C42&amp;ssl=1 42w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=1536%2C1536&amp;ssl=1 1536w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=2048%2C2048&amp;ssl=1 2048w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=600%2C600&amp;ssl=1 600w, https://i0.wp.com/gaiamadservice.dk/wp-content/uploads/2020/07/thanyou.png?resize=100%2C100&amp;ssl=1 100w" sizes="(max-width: 1024px) 100vw, 1024px">
					</div>
				</div>
			</div>
			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
