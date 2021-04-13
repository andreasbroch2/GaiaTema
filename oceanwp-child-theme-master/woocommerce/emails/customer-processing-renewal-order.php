<?php
/**
 * Customer processing renewal order email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<hr style="height:2px;border-width:0;color:#006633;background-color:#006633;margin-top:0;margin-bottom:20px">
<p><strong><?php printf( esc_html__( 'Hej %s', 'woocommerce-subscriptions' ), esc_html( $order->get_billing_first_name() ) ); ?>! &#128522</strong></p>
<?php /* translators: %s: Order number */ ?>
<p>Vi har nu modtaget bestillingen på din næste måltidskasse, og tusind tak for at du har valgt en fast levering fra Gaia!</p>
<p>Inden længe vil vores hold af passionerede plantemadkreatører gå igang med at lave din mad, 
så du kan se frem til dage hvor dine personlige privatkokke fra Gaia, sørger for at du har mere tid til dig selv. </p>
<p><strong>Vi er er glade for at du støtter os på rejsen for at skabe #EnGrønnereFremtid &#127757</strong></p>
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

if(date('D', $order_timestamp) === 'Mon') {
	echo "<h2>Hvornår</h2>" ;
	echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (6 * $day) ).'</h3>';
}
if(date('D', $order_timestamp) === 'Tue') {
	echo "<h2>Hvornår</h2>" ;
	echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (5 * $day) ).'</h3>';
}
if(date('D', $order_timestamp) === 'Wed') {
	if(date('H', $order_timestamp) < '6') {
		echo "<h2>Hvornår</h2>" ;
		echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (4 * $day) ).'</h3>';
		} else {
			echo "<h2>Hvornår</h2>" ;
			echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (11 * $day) ).'</h3>';
		}
}
if(date('D', $order_timestamp) === 'Fri') {
	echo "<h2>Hvornår</h2>" ;
	echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (9 * $day) ).'</h3>';
}
if(date('D', $order_timestamp) === 'Sat') {
	echo "<h2>Hvornår</h2>" ;
	echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (8 * $day) ).'</h3>';
}
if(date('D', $order_timestamp) === 'Sun') {
	echo "<h2>Hvornår</h2>" ;
	echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (7 * $day) ).'</h3>';
}
if(date('D', $order_timestamp) === 'Thu') {
	echo "<h2>Hvornår</h2>" ;
	echo '<h3>Søndag<br>d. '.strftime("%e. %B", $order_timestamp + (10 * $day) ).'</h3>';
}
?>
</th>
<th>
<?php
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
?>
</th>
</tr>
</table>
<?php
do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

?>
<p style="text-align:center">Vi glæder os til at levere maden til dig &#128522</p>
<strong><p style="text-align:center">Velbekomme!</p></strong>
<h3 style="text-align:center;color:#006633">Grønne Hilsner</h3>
<h3 style="text-align:center">Andreas og Asger</h3>