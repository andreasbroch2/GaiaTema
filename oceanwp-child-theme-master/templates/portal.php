<?php

/**
 * Template Name: Portal
 *
 */
get_header('portal'); ?>
<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = jQuery(e.target).data('field');
        var parent = jQuery(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = jQuery(e.target).data('field');
        var parent = jQuery(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }


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


    jQuery(function() {
        jQuery('.clickdiv').click(function(e) {
            jQuery(this).parent().find('#abomodal').show('slow');
        });
        jQuery('.abonnement').click(function(e) {
            jQuery(this).closest('#abomodal').hide('slow');
        });
        jQuery('#rewardkasse').click(function(e) {
            jQuery(this).parent().find('#rewardmodal').show('slow');
        });
        jQuery('.fullmodalhead').click(function(e) {
            jQuery(this).closest('#rewardmodal, #products').hide('slow');
        });
        jQuery('#addbutton').click(function() {
            jQuery(this).parent().find(' #products').show('slow');
        });
        jQuery('.grid104545').click(function() {
            jQuery(this).parent().find('#collapsiblecontent, .productgrid').toggle('slow');
        });
        jQuery('.button-plus').click(function(e) {
            incrementValue(e);
        });

        jQuery('.input-group').on('click', '.button-minus', function(e) {
            decrementValue(e);
        });
    });
</script>

<?php
$user = get_current_user_id();
$kunde = new WC_Customer($user);
$navn = $kunde->get_billing_first_name();
?>

<div class="contain">
    <div class="hilsen">
        Go'aften <?php echo $navn ?>
    </div>
    <div class="deadlinenotice">
        <div>
            <span style="font-size:2rem">
                <i class="fas fa-exclamation-circle"></i>
            </span>
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
            <span style="font-size:2rem">
                <i class="fas fa-mobile"></i>
            </span>
        </div>
        <div>
            Styr nemt din måltidskasse med vores app
        </div>
        <div>
            <a href="http://onelink.to/m5sjja" class="button">Hent app</a>
        </div>
    </div>

    <div class="kasse">
        <h3>Måltidskasser</h3>

        <?php
        // Get all customers subscriptions
        $customer_subscriptions = get_posts(array(
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $user,
            'post_type'   => 'shop_subscription', // WC orders post type
            'post_status' => array('wc-active', 'wc-on-hold', 'wc-cancelled') // Only orders with status "completed"
        ));

        // Iterating through each post subscription object
        foreach ($customer_subscriptions as $customer_subscription) {
            // The subscription ID
            $subscription_id = $customer_subscription->ID;

            // IMPORTANT HERE: Get an instance of the WC_Subscription Object
            $subscription = new WC_Subscription($subscription_id);
            // Or also you can use
            // wc_get_order( $subscription_id ); 

            // Getting the related Order ID (added WC 3+ comaptibility)
            $order_id = method_exists($subscription, 'get_parent_id') ? $subscription->get_parent_id() : $subscription->order->id;

            // Getting an instance of the related WC_Order Object (added WC 3+ comaptibility)
            $order = method_exists($subscription, 'get_parent') ? $subscription->get_parent() : $subscription->order;
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
                        <i class="fas fa-truck"></i>
                        <span class="levering">Næste levering:</span>
                        <p class="leveringsdag">
                            <?php if ($status == 'cancelled') : ?>
                                Ingen leveringer
                            <?php else : echo $levering;
                            endif ?>
                        </p>
                    </div>
                    <div>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div id="abomodal">
                    <?php
                    get_template_part('templates/abonnement', null, array(
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
    <div class="customerinfo">
        <h3>Dine oplysninger</h3>
        <div class="infogrid">
            <div>Email</div>
            <div style="text-align:right"><?php echo $kunde->get_email(); ?></div>
            <i class="fas fa-pen" id="openemailmodal"></i>
            <div>Telefon</div>
            <div style="text-align:right"><?php echo $kunde->get_billing_phone(); ?></div>
            <i class="fas fa-pen" id="openphonemodal"></i>
            <div>Kodeord</div>
            <div style="text-align:right">********</div>
            <i class="fas fa-pen" id="openpasswordmodal"></i>
        </div>
    </div>
    <div class="rewardprogram" style="display:none">
        <h3>Fordelsprogram</h3>
        <div class="kassekasse" id="rewardkasse">
            <div class="grid104545">
                <div>
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <p>Dine point</p>
                </div>
                <div>
                    <p><?php echo do_shortcode('[wr_simple_points system="default"]'); ?></p>
                </div>
                <div>
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
        <div>
            <?php
            get_template_part('templates/rewards');
            ?></div>
    </div>
    <div class="historik">
        <h3>Købshistorik</h3>
        <?php
        $customer = wp_get_current_user();
        // Get all customer orders
        $customer_orders = get_posts(array(
            'numberposts' => -1,
            'meta_key' => '_customer_user',
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_value' => get_current_user_id(),
            'post_type' => wc_get_order_types(),
            'post_status' => array_keys(wc_get_order_statuses())
        ));
        foreach ($customer_orders as $customer_order) {
            $orderq = wc_get_order($customer_order);
        ?>
            <div class="kassekasse">
                <i class="fas fa-calendar"></i>
                <?php echo $orderq->get_date_created()->date_i18n('Y-m-d'); ?>
                <i class="fas fa-creditcard"></i>
                <?php echo $orderq->get_total(); ?>,-
                <?php if ($orderq->get_status() == 'completed'){ ?>
                    Leveret
                <?php 
                }
                ?>
            </div>
        <?php
        };
        ?>
    </div>
</div>
<div class="modalfull" id="modalfull"></div>
<?php get_footer(); ?>