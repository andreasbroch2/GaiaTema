<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:0;margin-bottom:20px">
<?php /* translators: %s: Customer first name */ ?>
<strong><p><?php printf( esc_html__( 'Hej %s', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?> &#128522</p></strong>
<p>Efter et par gode og hårde dage i køkkenet er din måltidskasse nu pakket, klar og sendt afsted mod dig!</p>
<p>Måltidskassen bliver leveret søndag mellem 9-19, og du modtager en sms om morgenen med nærmere tidspunkt.</p>
<p>Du kan lige nå at planlægge hvad du skal bruge alt den ekstra tid du får i næste uge på &#128522</p>
<br>
<p style="text-align:center">Vi håber du får en fantastisk uge!</p>
<strong><p style="text-align:center">Alt det bedste!</p></strong>
<h3 style="text-align:center;color:#006633">Andreas & Asger</h3>
<?php

