<?php

/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action('woocommerce_email_header', $email_heading, $email);
?>

<?php /* translators: %s: Customer first name */
// $cat_check = false;
// $cat_checks = false;

// // check each cart item for our category
// foreach ( $order->get_items() as $item ){
// 	$categories = get_the_terms( $item['product_id'] , 'product_cat' );

// 	foreach( $categories as $categorie ) {
//         if ($categorie->slug == 'vegansk-julemad') {
//         	$cat_check = true;
//         	// break because we only need one "true" to matter here
// 			break;
// 		} elseif ($categorie->slug == 'vegansk-nytaarsmenu') {
//         	$cat_checks = true;
//         	// break because we only need one "true" to matter here
// 			break;
// 		} else {
// 		break;
// 		}
// }
// }
// if ( $cat_check ) {
// 
// <hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:0;margin-bottom:20px">
// <p><strong><?php printf( esc_html__( 'Hej %s', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ! &#128522</strong></p>
// <p>Vi har modtaget din bestilling og tusind tak for den!</p>
// <p>Din julemenu vil blive leveret d. 23 december, klar til at blive varmet, så du har en lækker og grøn julemenu på 30 min. 
// Hvis du har valgt afhentning kan du hente din julemad d. 23 mellem 10-14. </p>
// <p>Vi er er glade for at du støtter os på rejsen for at skabe #EnGrønnereFremtid &#127757</p>
// <?php 
// } elseif ( $cat_checks ) {
// 	
// <hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:0;margin-bottom:20px">
// <p><strong><?php printf( esc_html__( 'Hej %s', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ! &#128522</strong></p>
// <p>Vi har modtaget din bestilling og tusind tak for den!</p>
// <p>Din nytårsmiddag vil blive leveret d. 30 december, klar til at blive varmet, så du har en lækker og grøn nytårsmiddag på kort tid. 
// Hvis du har valgt afhentning kan du hente din nytårsmad d. 30 mellem 10-14. </p>
// <p>Vi er er glade for at du støtter os på rejsen for at skabe #EnGrønnereFremtid &#127757</p>
// <?php 
// }	else 
?>
<hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:0;margin-bottom:20px">
<p><strong><?php printf(esc_html__('Hej %s', 'woocommerce'), esc_html($order->get_billing_first_name())); ?>! &#128522</strong></p>
<p>Vi har modtaget din bestilling og tusind tak for den!</p>
<p>Inden længe vil vores hold af passionerede plantemadkreatører gå igang med at lave din mad,
	så du kan se frem til dage hvor dine personlige privatkokke fra Gaia, sørger for at du har mere tid til dig selv. </p>
<p>Vi er er glade for at du støtter os på rejsen for at skabe #EnGrønnereFremtid &#127757</p>
<?php
$order_datetime  = $order->get_date_created(); // Get order created date ( WC_DateTime Object ) 
$order_timestamp = $order_datetime->getTimestamp(); // get the timestamp in seconds
$day             = 86400; // 1 day in seconds

$delivery_url    = 'deliveryinfopageURL'; // <== Set the correct URL to the delivery page
$delivery_txt    = __("Read more about delivery", "woocommerce");
?>
<hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:20px;margin-bottom:0px">
<h2 style="color:#333333">Din Måltidskasse</h2>

<hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:0px;margin-bottom:0px">
<table style="width:100%">
	<tr style="vertical-align:top">
		<th>
			<?php
			setlocale(LC_ALL, '');
			setlocale(LC_ALL, 'da_DK.utf8');
			if ($order->get_shipping_method() == 'Afhentning - Vejle') {
				if (date('D', $order_timestamp) === 'Mon') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (5 * $day)) . ' mellem 15-16</h3>';
				}
				if (date('D', $order_timestamp) === 'Tue') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (4 * $day)) . ' mellem 15-16</h3>';
				}
				if (date('D', $order_timestamp) === 'Wed') {
					if (date('H', $order_timestamp) < '5') {
						echo "<h2>Hvornår</h2>";
						echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (3 * $day)) . ' mellem 15-16</h3>';
					} else {
						echo "<h2>Hvornår</h2>";
						echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (10 * $day)) . ' mellem 15-16</h3>';
					}
				}
				if (date('D', $order_timestamp) === 'Fri') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (8 * $day)) . ' mellem 15-16</h3>';
				}
				if (date('D', $order_timestamp) === 'Sat') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (7 * $day)) . ' mellem 15-16</h3>';
				}
				if (date('D', $order_timestamp) === 'Sun') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (6 * $day)) . ' mellem 15-16</h3>';
				}
				if (date('D', $order_timestamp) === 'Thu') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Lørdag<br>d. ' . strftime("%e. %B", $order_timestamp + (9 * $day)) . ' mellem 15-16</h3>';
				}
			} if($order->get_shipping_method() != 'Afhentning - Vejle') {
				if (date('D', $order_timestamp) === 'Mon') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (6 * $day)) . '</h3>';
				}
				if (date('D', $order_timestamp) === 'Tue') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (5 * $day)) . '</h3>';
				}
				if (date('D', $order_timestamp) === 'Wed') {
					if (date('H', $order_timestamp) < '5') {
						echo "<h2>Hvornår</h2>";
						echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (4 * $day)) . '</h3>';
					} else {
						echo "<h2>Hvornår</h2>";
						echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (11 * $day)) . '</h3>';
					}
				}
				if (date('D', $order_timestamp) === 'Fri') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (9 * $day)) . '</h3>';
				}
				if (date('D', $order_timestamp) === 'Sat') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (8 * $day)) . '</h3>';
				}
				if (date('D', $order_timestamp) === 'Sun') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (7 * $day)) . '</h3>';
				}
				if (date('D', $order_timestamp) === 'Thu') {
					echo "<h2>Hvornår</h2>";
					echo '<h3>Søndag<br>d. ' . strftime("%e. %B", $order_timestamp + (10 * $day)) . '</h3>';
				}
			}
			?>
		</th>
		<th>
			<?php
			do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);
			?>
		</th>
	</tr>
</table>
<?php
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);
if ($additional_content) {
	echo wp_kses_post(wpautop(wptexturize($additional_content)));
}

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */


/**
 * Show user-defined additional content - this is set in each email's settings.
 */
?>
<p style="text-align:center">Vi glæder os til at levere maden til dig &#128522</p>
<strong>
	<p style="text-align:center">Velbekomme!</p>
</strong>
<h3 style="text-align:center;color:#006633">Grønne Hilsner</h3>
<h3 style="text-align:center">Andreas og Asger</h3>
<?php
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
