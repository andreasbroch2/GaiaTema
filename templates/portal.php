
<?php
/**
* Template Name: Portal
*
*/
get_header('portal'); ?>
<script>
    // Set the date we're counting down to
    // 1. JavaScript
    // var countDownDate = new Date("Sep 5, 2018 15:37:25").getTime();
    // 2. PHP
    var countDownDate = <?php echo strtotime('Next Wednesday') ?> * 1000;
    var now = <?php echo time() ?> * 1000;

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        // 1. JavaScript
        // var now = new Date().getTime();
        // 2. PHP
        now = now + 1000;

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        // Output the result in an element with id="demo"
        document.getElementById("dage").innerHTML = days;
        document.getElementById("timer").innerHTML = hours;
        document.getElementById("min").innerHTML = minutes;

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "UDLØBET";
        }
    }, 1000);


jQuery(function(){
    console.log('ready');
    console.log(this);
    jQuery('.clickdiv').click(function(e){
        console.log('click');
        console.log(e);
        console.log(this);
        jQuery(this).parent().find('#abomodal').show( 'slow' );
    });
    jQuery('.abonnement').click(function(e){
        console.log('click');
        console.log(e);
        console.log(this);
        jQuery(this).closest('#abomodal').hide( 'slow' );
    });
    jQuery('#addbutton').click(function(){
        console.log('click');
        console.log(this);
        jQuery(this).parent().find(' #products').show( 'slow' );
    });
});
</script>

<style>
.hilsen{
    text-align: center;
}
.feats{
    display: grid;
    grid-template-columns: 1fr 1fr;
    margin: 5px 0; 
    padding: 10px; 
}
p{
    margin: 0; 
}
</style>

<?php
    $user = get_current_user_id();
    $kunde = new WC_Customer( $user );
    $navn = $kunde->get_billing_first_name();
?>

<div class="contain">
    <div class="hilsen">
        Go'aften <?php echo $navn ?>
    </div>
    <div class="deadlinenotice">
        <div> 
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div>
            Deadline for ændringer inden næste levering
        </div>
        <div class="tid">
            <div id="dage"></div>
            <div id="timer"></div>
            <div id="min"></div>
            <div>DAGE</div>
            <div>TIMER</div>
            <div>MIN</div>
        </div>
    </div>
    <div class="notice">
        <div>
            <i class="fas fa-mobile"></i>
        </div>
        <div>
            Styr nemt din måltidskasse med vores app
        </div>
        <div>
            <a href="#" class="button">Hent app</a>
        </div>
    </div>

    <div class="kasse">
        <h3>Måltidskasser</h3>

        <?php
// Get all customers subscriptions
$customer_subscriptions = get_posts( array(
    'numberposts' => -1,
    'meta_key'    => '_customer_user',
    'meta_value'  => $user,
    'post_type'   => 'shop_subscription', // WC orders post type
    'post_status' => array('wc-active', 'wc-on-hold', 'wc-cancelled') // Only orders with status "completed"
) );

// Iterating through each post subscription object
foreach( $customer_subscriptions as $customer_subscription ){
    // The subscription ID
    $subscription_id = $customer_subscription->ID;

    // IMPORTANT HERE: Get an instance of the WC_Subscription Object
    $subscription = new WC_Subscription( $subscription_id );
    // Or also you can use
    // wc_get_order( $subscription_id ); 

    // Getting the related Order ID (added WC 3+ comaptibility)
    $order_id = method_exists( $subscription, 'get_parent_id' ) ? $subscription->get_parent_id() : $subscription->order->id;

    // Getting an instance of the related WC_Order Object (added WC 3+ comaptibility)
    $order = method_exists( $subscription, 'get_parent' ) ? $subscription->get_parent() : $subscription->order;
    $status = $subscription->get_status();
    $antal = $subscription->get_item_count();
    $levering = $subscription->get_date('next_payment', 'site');
     ?>
        <div class="kassekasse" id="kassekasse">
            <div class="clickdiv">
                <div>
                    <?php if ($status == 'cancelled') : ?>
                        <span style="color:red">
                            <i class="fas fa-times-circle"></i>
                        </span>
                        Afmeldt
                    <?php elseif ($status == 'on-hold') : ?>
                        <span style="color:yellow">
                            <i class="fas fa-pause-circle"></i>
                        </span>
                            På pause
                    <?php elseif ($status == 'active') : ?>
                        <span style="color:green">
                            <i class="fas fa-check-circle"></i>
                        </span>
                            Aktiv
                    <?php endif ?>
                </div>
                <div>
                    <i class="fas fa-truck"></i>Næste levering:
                    <br>
                    <?php if ($status == 'cancelled') : ?>
                        Ingen leveringer
                    <?php else : echo $levering;
                    endif ?>
                </div>
                <div>
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div id="abomodal">
            <?php 
    get_template_part( 'templates/abonnement', null, array(
        'subscription' => $subscription,
        'levering' => $levering,
    ));
    ?></div>
        </div>
        <?php
    // Optional (uncomment below): Displaying the WC_Subscription object raw data
    //  echo '<pre>';print_r($customer_subscription);echo '</pre>';
};
        ?>
    </div>
    <div class="hardu">
        <h3>Har du prøvet...</h3>
        <?php echo do_shortcode('[products limit="2" orderbyid="id" order="DESC"]'); ?>
    </div>
    <div class="historik">
    <h3>Købshistorik</h3>
    </div>
</div>
<div class="modalfull" id="modalfull"></div>
<?php get_footer(); ?>